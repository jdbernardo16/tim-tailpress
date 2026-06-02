<?php

if (! defined('WP_CLI') || ! WP_CLI) {
    return;
}

class TimTailPress_Seeder
{
    private function get_page_id($slug)
    {
        $pages = get_posts([
            'post_type' => 'page',
            'name' => $slug,
            'fields' => 'ids',
            'posts_per_page' => 1,
            'post_status' => 'publish',
        ]);
        return ! empty($pages) ? $pages[0] : null;
    }

    private function update_acf_field($field_name, $value, $page_id, $force = false)
    {
        if (empty($page_id)) {
            return;
        }
        if (! $force) {
            $existing = get_field($field_name, $page_id);
            if (! empty($existing)) {
                return;
            }
        }
        update_field($field_name, $value, $page_id);
    }

    private function upload_image($filename)
    {
        $file_path = get_template_directory() . '/assets/images/' . $filename;
        if (! file_exists($file_path)) {
            return null;
        }

        $attachment_id = attachment_url_to_postid(get_template_directory_uri() . '/assets/images/' . $filename);
        if ($attachment_id) {
            return $attachment_id;
        }

        $upload = wp_upload_bits($filename, null, file_get_contents($file_path));
        if ($upload['error']) {
            return null;
        }

        $wp_filetype = wp_check_filetype($filename, null);
        $attachment_id = wp_insert_attachment([
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name(pathinfo($filename, PATHINFO_FILENAME)),
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $upload['url'],
        ], $upload['file']);

        require_once ABSPATH . 'wp-admin/includes/image.php';
        wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $upload['file']));

        return $attachment_id;
    }

    private function upload_svg($filename)
    {
        $file_path = get_template_directory() . '/assets/images/' . $filename . '.svg';
        if (! file_exists($file_path)) {
            return null;
        }

        $attachment_id = attachment_url_to_postid(get_template_directory_uri() . '/assets/images/' . $filename . '.svg');
        if ($attachment_id) {
            return $attachment_id;
        }

        $upload = wp_upload_bits($filename . '.svg', null, file_get_contents($file_path));
        if ($upload['error']) {
            return null;
        }

        $attachment_id = wp_insert_attachment([
            'post_mime_type' => 'image/svg+xml',
            'post_title' => $filename,
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $upload['url'],
        ], $upload['file']);

        return $attachment_id;
    }

    private function create_menu($menu_name, $location, $items)
    {
        if (wp_get_nav_menu_object($menu_name)) {
            return;
        }

        $menu_id = wp_create_nav_menu($menu_name);
        if (is_wp_error($menu_id)) {
            return;
        }

        $item_ids = [];
        foreach ($items as $i => $item) {
            $item_id = wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title' => $item['title'],
                'menu-item-url' => $item['url'] ?? '',
                'menu-item-status' => 'publish',
                'menu-item-type' => ! empty($item['url']) ? 'custom' : 'none',
            ]);
            $item_ids[$i] = $item_id;
        }

        foreach ($items as $i => $item) {
            if (! empty($item['parent'])) {
                $parent_idx = array_search($item['parent'], array_column($items, 'title'));
                if ($parent_idx !== false && isset($item_ids[$parent_idx])) {
                    update_post_meta($item_ids[$i], '_menu_item_menu_item_parent', $item_ids[$parent_idx]);
                }
            }
        }

        set_theme_mod('nav_menu_locations', array_merge(
            (array) get_theme_mod('nav_menu_locations', []),
            [$location => $menu_id]
        ));
    }

    /**
     * ## OPTIONS
     *
     * [--page=<page>]
     * : Comma-separated list of page slugs to seed (default: all).
     *
     * [--force]
     * : Overwrite existing field values.
     *
     * @when after_wp_load
     */
    public function seed($args, $assoc_args)
    {
        $force = isset($assoc_args['force']);

        $this->create_menus();

        $page_slugs = [
            'front-page', 'about', '4-session', 'be-remembered',
            'breakthrough-session', 'build-my-team', 'events',
            'get-started', 'inquiry', 'master-my-message',
            'million-dollar-message', 'offers', 'on-stage',
            'speaker-cohort', 'success-stories', 'thank-you',
            'the-authority', 'the-legacy', 'the-speaker', 'the-vault',
        ];

        if (! empty($assoc_args['page'])) {
            $page_slugs = explode(',', $assoc_args['page']);
        }

        foreach ($page_slugs as $slug) {
            $slug = trim($slug);
            $method = 'seed_' . str_replace('-', '_', $slug);
            if (method_exists($this, $method)) {
                $this->$method($force);
                WP_CLI::success("Seeded: {$slug}");
            } else {
                WP_CLI::warning("No seeder method for: {$slug}");
            }
        }
    }

    private function create_menus()
    {
        $this->create_menu('Header Navigation', 'header', [
            ['title' => 'About', 'url' => home_url('/about/')],
            ['title' => 'Work with me', 'url' => home_url('/offers/')],
            ['title' => 'On Stage', 'url' => home_url('/on-stage/')],
            ['title' => 'Events & Workshops', 'url' => home_url('/events/')],
            ['title' => 'Success Stories', 'url' => home_url('/success-stories/')],
            ['title' => 'Inquiry', 'url' => home_url('/inquiry/')],
        ]);

        $this->create_menu('Footer Offers', 'footer-offers', [
            ['title' => 'All Offers', 'url' => home_url('/offers/')],
            ['title' => 'The Vault', 'url' => home_url('/the-vault/')],
            ['title' => '$29 Million Dollar Message', 'url' => home_url('/million-dollar-message/')],
            ['title' => 'Breakthrough Session', 'url' => home_url('/breakthrough-session/')],
            ['title' => '4-Session Training Package', 'url' => home_url('/4-session/')],
        ]);

        $this->create_menu('Footer Programs', 'footer-programs', [
            ['title' => 'Tell Your Story', 'url' => home_url('/offers/#tell-your-story')],
            ['title' => 'Move the Room', 'url' => home_url('/offers/#move-the-room')],
            ['title' => 'Master My Message', 'url' => home_url('/master-my-message/')],
            ['title' => 'Build My Team', 'url' => home_url('/build-my-team/')],
            ['title' => 'Be Remembered', 'url' => home_url('/be-remembered/')],
        ]);

        $this->create_menu('Footer About', 'footer-about', [
            ['title' => 'About Joanna', 'url' => home_url('/about/')],
            ['title' => 'Joanna On Stage', 'url' => home_url('/on-stage/')],
            ['title' => 'Events & Workshops', 'url' => home_url('/events/')],
            ['title' => 'Inquiry', 'url' => home_url('/inquiry/')],
        ]);
    }

    private function seed_front_page($force = false)
    {
        $page_id = $this->get_page_id('front-page');
        if (! $page_id) {
            return;
        }

        $this->update_acf_field('section_hero_heading', 'You\'re Not Missing a Message. <em class="text-gold">You\'re Missing Trust.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Somewhere along the way, you learned how to explain yourself… but not how to truly be felt.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('hero-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('hero-img.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_btn_primary_text', 'Start Your Story', $page_id, $force);
        $this->update_acf_field('section_hero_btn_primary_url', '/get-started/', $page_id, $force);
        $this->update_acf_field('section_hero_btn_secondary_text', 'Watch Joanna Speak', $page_id, $force);
        $this->update_acf_field('section_hero_btn_secondary_url', '/on-stage/', $page_id, $force);

        $this->update_acf_field('section_trusted_heading', 'Trusted by<br>leaders worldwide', $page_id, $force);
        $this->update_acf_field('section_trusted_stats', [
            ['item_icon' => $this->upload_svg('UsersThree'), 'item_value' => '10,000+', 'item_label' => 'Leaders Transformed'],
            ['item_icon' => $this->upload_svg('SealCheck'), 'item_value' => '30+', 'item_label' => 'Years of Work'],
        ], $page_id, $force);

        $this->update_acf_field('section_you_know_heading', 'You Know What You <em class="text-gold">Mean</em>', $page_id, $force);

        $this->update_acf_field('section_tell_story_heading', 'Your Story <em class="text-gold italic">Changes</em> Rooms.', $page_id, $force);
        $this->update_acf_field('section_tell_story_image', $this->upload_image('tell-story-1.webp'), $page_id, $force);
        $this->update_acf_field('section_tell_story_btn_text', 'START YOUR STORY', $page_id, $force);
        $this->update_acf_field('section_tell_story_btn_url', '/events/', $page_id, $force);

        $this->update_acf_field('section_discover_heading', 'Discover the Message <em class="text-gold italic">Hidden</em> Inside Your Story.', $page_id, $force);
        $this->update_acf_field('section_discover_image', $this->upload_image('discover-img.webp'), $page_id, $force);
        $this->update_acf_field('section_discover_btn_text', 'Explore the $29 MILLION DOLLAR Experience', $page_id, $force);
        $this->update_acf_field('section_discover_btn_url', '/million-dollar-message/', $page_id, $force);

        $this->update_acf_field('section_journey_heading', 'The <em class="text-gold italic">Journey</em>', $page_id, $force);
        $this->update_acf_field('section_journey_items', [
            ['item_icon' => $this->upload_svg('UsersThree'), 'item_heading' => 'Tell Your Story', 'item_text' => 'Reconnect with the defining moments behind your leadership, voice, and influence.'],
            ['item_icon' => $this->upload_svg('Lectern'), 'item_heading' => 'Move the Room', 'item_text' => 'Build a signature talk and message people trust, remember, and follow.'],
            ['item_icon' => $this->upload_svg('SealCheck'), 'item_heading' => 'Master My Message', 'item_text' => 'Refine your positioning, authority, and keynote-level message.'],
            ['item_icon' => $this->upload_svg('UserCircleCheck'), 'item_heading' => 'Build My Team', 'item_text' => 'Scale communication, trust, and leadership across your organization.'],
            ['item_icon' => $this->upload_svg('StarIcon'), 'item_heading' => 'Be Remembered', 'item_text' => 'Create work, leadership, and influence designed to outlast you.'],
        ], $page_id, $force);

        $this->update_acf_field('section_speaker_heading', '<em class="text-gold italic">Move</em> the Room.', $page_id, $force);
        $this->update_acf_field('section_speaker_image', $this->upload_image('joana-speaker.webp'), $page_id, $force);
        $this->update_acf_field('section_speaker_bg_image', $this->upload_image('speaker-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_speaker_watermark_image', $this->upload_image('speaker-cohort.webp'), $page_id, $force);
        $this->update_acf_field('section_speaker_btn_text', 'Explore Speaker Cohort', $page_id, $force);
        $this->update_acf_field('section_speaker_btn_url', '/speaker-cohort/', $page_id, $force);

        $this->update_acf_field('section_vault_heading', 'Stay Inside the <span class="text-gold-section italic font-semibold">Conversation.</span>', $page_id, $force);
        $this->update_acf_field('section_vault_image', $this->upload_image('vault-img.webp'), $page_id, $force);
        $this->update_acf_field('section_vault_btn_text', 'Enter The Vault', $page_id, $force);
        $this->update_acf_field('section_vault_btn_url', '/the-vault/', $page_id, $force);

        $this->update_acf_field('section_testimonials_heading', 'People Remember What Felt <em class="text-gold italic">True.</em>', $page_id, $force);
        $this->update_acf_field('section_testimonials_subtitle', 'Leaders from around the world come to Joanna to reconnect with their voice, refine their message, and lead with deeper influence.', $page_id, $force);
        $this->update_acf_field('section_testimonials_items', [
            ['item_quote' => 'Working with Joanna has been nothing short of life-changing.', 'item_author' => 'A. ROBINSON', 'item_title' => 'Executive Leader'],
            ['item_quote' => 'This was never about performing. It was about becoming.', 'item_author' => 'Speak & Rise Participant', 'item_title' => 'Leader'],
            ['item_quote' => 'When clarity meets momentum, everything changes. Joanna gave me both.', 'item_author' => 'EXECUTIVE CLIENT', 'item_title' => 'Leader'],
        ], $page_id, $force);

        $this->update_acf_field('section_voice_heading', 'Your Voice Carries More Than <em class="text-warm-beige italic">Information.</em>', $page_id, $force);
        $this->update_acf_field('section_voice_image', $this->upload_image('voice-img.webp'), $page_id, $force);
    }

    private function seed_about($force = false)
    {
        $page_id = $this->get_page_id('about');
        if (! $page_id) {
            return;
        }

        $this->update_acf_field('section_hero_heading', "Influence Begins<br>With What's <em class=\"text-gold italic\">True.</em>", $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Joanna Horton McPherson is a private advisor, speaker, and creator of the True Influence Method™ — helping leaders turn lived experience into messages people trust, feel, and follow.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('about-joanna-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('about-joanna-img.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_stats', [
            ['item_icon' => $this->upload_svg('UsersThree'), 'item_value' => '10,000', 'item_label' => 'Leaders Transformed'],
            ['item_icon' => $this->upload_svg('SealCheck'), 'item_value' => '30', 'item_label' => 'Years of Work'],
            ['item_icon' => $this->upload_svg('Lectern'), 'item_value' => '1,000', 'item_label' => 'Keynotes Delivered'],
            ['item_icon' => $this->upload_svg('UserCircleCheck'), 'item_value' => '6', 'item_label' => 'Founder & Investor'],
        ], $page_id, $force);

        $this->update_acf_field('section_leader_heading', "Being a Leader is Choosing What You <em class=\"text-gold italic\">Become.</em>", $page_id, $force);

        $this->update_acf_field('section_meaning_heading', "Long Before the Stages, There Was the Search for <em class=\"text-gold italic\">Meaning.</em>", $page_id, $force);

        $this->update_acf_field('section_life_heading', "A <em class=\"text-gold italic\">Life</em> Built Across Leadership<br>and Transformation.", $page_id, $force);

        $this->update_acf_field('section_reconnect_heading', "Joanna <span class=\"italic text-gold\">Help</span> Leaders Reconnect With What People Can Actually Feel.", $page_id, $force);
        $this->update_acf_field('section_reconnect_btn_text', 'Work With Joanna', $page_id, $force);
        $this->update_acf_field('section_reconnect_btn_url', '/inquiry/', $page_id, $force);

        $this->update_acf_field('section_voice_heading', "Your Voice Carries More Than <em class=\"text-warm-beige italic\">Information.</em>", $page_id, $force);
    }

    private function seed_4_session($force = false)
    {
        $page_id = $this->get_page_id('4-session');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Build the Message<br><em class="text-gold italic">From the Inside Out.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'The 4-Session Training Package is a private experience for leaders ready to uncover, refine, and clearly articulate the message behind their work. Together, you move beyond explaining and begin building a message that feels true, clear, and aligned.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('training-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('training-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You <em class="text-gold italic">Leave</em> With', $page_id, $force);
        $this->update_acf_field('section_distinct_heading', 'Private Work.<br><em class="text-gold italic">Real Refinement.</em>', $page_id, $force);
        $this->update_acf_field('section_distinct_items', [
            ['item_heading' => 'Personalized Curriculum', 'item_text' => 'Every session is tailored to your specific voice, message, and leadership context.'],
            ['item_heading' => 'Real-Time Feedback', 'item_text' => 'Receive immediate, actionable feedback on your delivery, presence, and messaging.'],
            ['item_heading' => 'Proven Framework', 'item_text' => "The True Influence Method\u2122 framework has transformed thousands of leaders worldwide."],
            ['item_heading' => 'Lasting Impact', 'item_text' => 'Walk away with skills and self-awareness that compound over time.'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Clarity Changes <em class="text-gold italic">How You Lead.</em>', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'BOOK PRIVATE TRAINING', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/inquiry/', $page_id, $force);
    }

    private function seed_be_remembered($force = false)
    {
        $page_id = $this->get_page_id('be-remembered');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Build a Legacy.<br><em class="text-gold italic">Not Just a Career.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Be Remembered is Joanna&rsquo;s private legacy experience for founders and executives ready to build work, wealth, and influence designed to outlast them. This is where your impact becomes a framework others can continue through.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('remembered-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('remembered-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'Your Work Has Impact.<br>Your <em class="text-gold italic">Legacy</em> Doesn&rsquo;t Have a Framework.', $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You <em class="text-gold italic">Build</em>', $page_id, $force);
        $this->update_acf_field('section_build_btn_text', 'BUILD MY LEGACY', $page_id, $force);
        $this->update_acf_field('section_build_btn_url', '/inquiry/', $page_id, $force);
        $this->update_acf_field('section_distinct_heading', 'A Legacy That Outlives <em class="text-gold italic">You.</em>', $page_id, $force);
        $this->update_acf_field('section_distinct_items', [
            ['item_heading' => 'Vision Architecture', 'item_text' => 'Design a long-term vision that goes beyond your lifetime.'],
            ['item_heading' => 'Legacy Blueprint', 'item_text' => 'Build the systems and message that will carry your work forward.'],
            ['item_heading' => 'Influence Strategy', 'item_text' => 'Create influence that compounds across generations.'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Some Build a Career. <em class="text-gold italic">Others Build a Legacy.</em>', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'BOOK DISCOVERY CALL - FREE', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '#register', $page_id, $force);
    }

    private function seed_breakthrough_session($force = false)
    {
        $page_id = $this->get_page_id('breakthrough-session');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'One Session<br><em class="text-gold italic">to See Clearly.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'You bring what you&rsquo;ve been trying to say. Joanna helps uncover what&rsquo;s actually true underneath it. A private breakthrough session for leaders ready to stop circling the message and finally say what matters most.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('breakthrough-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('breakthrough-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'You Already Know<br>Something <em class="text-gold italic">Feels Off.</em>', $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You <em class="text-gold italic">Leave</em> With', $page_id, $force);
        $this->update_acf_field('section_build_btn_text', 'BOOK A SESSION', $page_id, $force);
        $this->update_acf_field('section_build_btn_url', '/inquiry/', $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'One Honest Conversation <em class="text-gold italic">Can Change Everything.</em>', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'BOOK A BREAKTHROUGH SESSION', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/inquiry/', $page_id, $force);
    }

    private function seed_build_my_team($force = false)
    {
        $page_id = $this->get_page_id('build-my-team');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Build Leaders.<br><em class="text-gold italic">Not Just Results.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Build My Team is Joanna&rsquo;s private leadership experience for founders and executives ready to scale trust, communication, and leadership across an entire organization. This is where your message becomes a system others can lead through.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('team-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('team-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'Your Business<br>Has Grown. Your <em class="text-gold italic">Leadership</em> Hasn&rsquo;t.', $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You <em class="text-gold italic">Build</em>', $page_id, $force);
        $this->update_acf_field('section_build_btn_text', 'SCALE MY BUSINESS', $page_id, $force);
        $this->update_acf_field('section_build_btn_url', '/inquiry/', $page_id, $force);
        $this->update_acf_field('section_distinct_heading', 'Leadership That Scales <em class="text-gold italic">Beyond You.</em>', $page_id, $force);
        $this->update_acf_field('section_distinct_items', [
            ['item_heading' => 'Enterprise Framework', 'item_text' => 'Proven methodology adapted for organizational scale.'],
            ['item_heading' => 'Leadership Alignment', 'item_text' => 'Get your entire leadership team communicating with one voice.'],
            ['item_heading' => 'Cultural Transformation', 'item_text' => 'Build a culture of authentic communication from the inside out.'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Strong Organizations <em class="text-gold italic">Are Built Through Trust.</em>', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'BOOK DISCOVERY CALL - FREE', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/inquiry/', $page_id, $force);
    }

    private function seed_events($force = false)
    {
        $page_id = $this->get_page_id('events');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Experiences That <em class="text-gold">Move</em> You.', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Retreats, speaking experiences, leadership conversations, and transformational gatherings designed to reconnect people with the truth behind their voice and influence.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('general-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('events-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_retreat_heading', '<span class="text-navy">Tell Your Story</span><br><em class="text-gold italic">Course &amp; Retreat</em>', $page_id, $force);
        $this->update_acf_field('section_retreat_image', $this->upload_image('retreat-img.webp'), $page_id, $force);
        $this->update_acf_field('section_upcoming_heading', '<em class="text-gold italic">Upcoming</em> <span class="text-navy">Experiences</span>', $page_id, $force);
        $this->update_acf_field('section_upcoming_items', [
            ['item_date' => 'September 16-20, 2026', 'item_title' => 'Speak & Rise + Retreat', 'item_location' => 'Phoenix', 'item_description' => 'Our flagship leadership intensive.'],
            ['item_date' => 'December 1, 2026', 'item_title' => 'Speaking On Stage Top Talent Hollywood', 'item_location' => 'Phoenix', 'item_description' => 'Advanced speaking experience for top talent.'],
        ], $page_id, $force);
        $this->update_acf_field('section_features_heading', '<em class="text-gold italic">More</em> <span class="text-navy">Than Events.</span>', $page_id, $force);
        $this->update_acf_field('section_features_items', [
            ['item_heading' => 'Private Coaching', 'item_text' => 'One-on-one sessions with Joanna to refine your message.'],
            ['item_heading' => 'Peer Feedback', 'item_text' => 'Learn and grow alongside other high-level leaders.'],
            ['item_heading' => 'Practical Application', 'item_text' => 'Leave with a message you can deliver immediately.'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Not Sure Where to<br><em class="text-gold italic">Begin?</em>', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'Find Your Path', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/inquiry/', $page_id, $force);
    }

    private function seed_get_started($force = false)
    {
        $page_id = $this->get_page_id('get-started');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Choose Where You Are.', $page_id, $force);
        $this->update_acf_field('section_hero_text', "You don't need more strategy. You need to close the gap between what you know and what you can actually say in the moments that matter.", $page_id, $force);
        $this->update_acf_field('section_hero_btn_text', 'Let\'s Begin', $page_id, $force);
        $this->update_acf_field('section_hero_btn_url', '/inquiry/', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('getstarted-bg.webp'), $page_id, $force);
    }

    private function seed_inquiry($force = false)
    {
        $page_id = $this->get_page_id('inquiry');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Start the<br><em class="text-gold italic">Conversation.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_text', 'Tell us where you are, what you\'re exploring, or what feels most aligned right now.', $page_id, $force);
    }

    private function seed_master_my_message($force = false)
    {
        $page_id = $this->get_page_id('master-my-message');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Become Known<br><em class="text-gold italic">for Something Specific.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Master My Message is Joanna&rsquo;s advanced authority-positioning experience designed for leaders ready to refine, elevate, and scale the message people remember them for. This is where your message becomes distinct, repeatable, and impossible to confuse with anyone else&rsquo;s.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('message-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('message-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'Your Work is Strong.<br>Your <em class="text-gold italic">Positioning</em> Isn&rsquo;t.', $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You <em class="text-gold italic">Build</em>', $page_id, $force);
        $this->update_acf_field('section_build_btn_text', 'CREATE MY KEYNOTE', $page_id, $force);
        $this->update_acf_field('section_build_btn_url', '/inquiry/', $page_id, $force);
        $this->update_acf_field('section_distinct_heading', 'This is Where Your <em class="font-normal">Message</em> Becomes <em class="text-gold italic">Distinct.</em>', $page_id, $force);
        $this->update_acf_field('section_distinct_items', [
            ['item_heading' => 'Message Architecture', 'item_text' => 'Build a message framework that supports every communication you\u2019ll ever make.'],
            ['item_heading' => 'Authority Positioning', 'item_text' => 'Position yourself as the go-to authority in your space.'],
            ['item_heading' => 'Keynote Development', 'item_text' => 'Develop a keynote that opens doors and creates opportunities.'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Some People Have <em class="font-normal">Expertise</em>. <em class="text-gold italic">Others Become Known For it.</em>', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'CREATE MY KEYNOTE', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/inquiry/', $page_id, $force);
    }

    private function seed_million_dollar_message($force = false)
    {
        $page_id = $this->get_page_id('million-dollar-message');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Your Message<br>Already <em class="text-gold italic">Exists.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'You are closer to your message than you think.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('mdm-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('mdm-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_btn_text', 'GET THE TRAINING — $29', $page_id, $force);
        $this->update_acf_field('section_hero_btn_url', '#inside', $page_id, $force);
        $this->update_acf_field('section_inside_heading', 'What&#8217;s <em class="text-gold italic">Inside</em>', $page_id, $force);
        $this->update_acf_field('section_inside_image', $this->upload_image('mdm-inside.webp'), $page_id, $force);
    }

    private function seed_offers($force = false)
    {
        $page_id = $this->get_page_id('offers');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', "Ways to Work<br>with Joanna.", $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'From transformational retreats and speaker development to private leadership work and live conversations, each experience inside the True Influence Method&trade; is designed to help leaders communicate with greater clarity, authority, and emotional truth.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('offers-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('offers-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_signature_heading', 'Signature <em class="text-gold italic">Offers</em>', $page_id, $force);
        $this->update_acf_field('section_signature_subtitle', 'The primary transformational experiences inside the True Influence Method&trade; — designed for different stages of leadership, visibility, authority, and long-term impact.', $page_id, $force);
        $this->update_acf_field('section_signature_items', [
            ['item_title' => 'Tell Your Story', 'item_description' => 'Reconnect with the defining moments behind your leadership, voice, and influence.', 'item_price_label' => '', 'item_price' => '$3,200', 'item_cta' => 'FIND MY MESSAGE', 'item_url' => home_url('/the-speaker/')],
            ['item_title' => 'Move the Room', 'item_description' => 'Build a signature talk and message people trust, remember, and follow.', 'item_price_label' => '', 'item_price' => '$12,000', 'item_cta' => 'TAKE THE STAGE', 'item_url' => home_url('/the-speaker/')],
            ['item_title' => 'Master My Message', 'item_description' => 'Refine your positioning, authority, and keynote-level message.', 'item_price_label' => 'Starts at', 'item_price' => '$25,000', 'item_cta' => 'CREATE MY KEYNOTE', 'item_url' => home_url('/master-my-message/')],
            ['item_title' => 'Build My Team', 'item_description' => 'Scale communication, trust, and leadership across your organization.', 'item_price_label' => 'Starts at', 'item_price' => '$250,000', 'item_cta' => 'SCALE MY BUSINESS', 'item_url' => home_url('/build-my-team/')],
            ['item_title' => 'Be Remembered', 'item_description' => 'Create work, leadership, and influence designed to outlast you.', 'item_price_label' => 'Starts at', 'item_price' => '$1M', 'item_cta' => 'SCALE MY BUSINESS', 'item_url' => home_url('/be-remembered/')],
        ], $page_id, $force);
        $this->update_acf_field('section_other_heading', 'Other Ways to<br>Work <em class="text-gold italic">Together</em>', $page_id, $force);
        $this->update_acf_field('section_other_items', [
            ['item_title' => 'Breakthrough Session', 'item_description' => 'A single, powerful session to identify your core message and the story only you can tell.', 'item_price' => '$2,000', 'item_cta' => 'BOOK A SESSION', 'item_url' => home_url('/breakthrough-session/')],
            ['item_title' => '4-Session Training Package', 'item_description' => 'Four private sessions to clarify your message, own your authority, and communicate with influence.', 'item_price' => '$8,000', 'item_cta' => 'BOOK NOW', 'item_url' => home_url('/4-session/')],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Not Sure Where<br>to <em class="text-gold italic">Begin?</em>', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'Find Your Path', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/get-started/', $page_id, $force);
    }

    private function seed_on_stage($force = false)
    {
        $page_id = $this->get_page_id('on-stage');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Invite Joanna<br>Into the <em class="text-gold italic">Room.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Keynotes, leadership conversations, retreats, and transformational speaking experiences designed to help people reconnect with the truth behind their voice, leadership, and influence.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('about-joanna-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('onstage-joanna.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_stats', [
            ['item_value' => '150+', 'item_label' => 'Stages Worldwide'],
            ['item_value' => '12', 'item_label' => 'Countries'],
        ], $page_id, $force);
        $this->update_acf_field('section_video_heading', 'Two Minutes of Her in a <em class="text-gold italic">Room.</em>', $page_id, $force);
        $this->update_acf_field('section_credibility_heading', '<em class="text-gold italic">Where</em> She\'s Been.', $page_id, $force);
        $this->update_acf_field('section_experiences_heading', '<em class="text-gold italic">Conversations</em> That Stay With People.', $page_id, $force);
        $this->update_acf_field('section_book_heading', 'Tell us About Your <em class="text-gold italic">Event.</em>', $page_id, $force);
        $this->update_acf_field('section_download_heading', 'Planning an Event or Leadership Gathering?', $page_id, $force);
        $this->update_acf_field('section_download_text', "Download Joanna's speaker kit for speaking topics, event formats, experience details, and inquiry information.", $page_id, $force);
        $this->update_acf_field('section_download_btn_text', 'Download Speaker Kit', $page_id, $force);
        $this->update_acf_field('section_download_btn_url', '#', $page_id, $force);
    }

    private function seed_speaker_cohort($force = false)
    {
        $page_id = $this->get_page_id('speaker-cohort');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Stop Explaining.<br><em class="text-gold italic">Start Landing.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Move the Room is Joanna&rsquo;s advanced Speaker Cohort experience for leaders ready to turn lived experience into a clear, structured message people trust and follow.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('cohort-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('cohort-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'You Know Your Work. But Your Message Still <em class="text-gold italic">Isn\'t Landing.</em>', $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You <em class="text-gold italic">Build</em><br>Inside the Cohort', $page_id, $force);
        $this->update_acf_field('section_build_btn_text', 'JOIN THE COHORT', $page_id, $force);
        $this->update_acf_field('section_build_btn_url', '/inquiry/', $page_id, $force);
        $this->update_acf_field('section_speaking_heading', 'This is <em class="font-normal text-gold italic">Not</em> Just<br>Speaking Training.', $page_id, $force);
        $this->update_acf_field('section_speaking_items', [
            ['item_heading' => 'Message Development', 'item_text' => 'Craft a message that lands with power and precision.'],
            ['item_heading' => 'Stage Presence', 'item_text' => 'Develop the presence that commands attention and builds trust.'],
            ['item_heading' => 'Story Architecture', 'item_text' => 'Structure your story for maximum emotional impact.'],
            ['item_heading' => 'Audience Connection', 'item_text' => 'Learn to read a room and adjust in real-time.'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Some People Know Their Work. Others Can Others <em class="text-gold italic">Move a Room</em> With it.', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'TAKE THE STAGE', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/inquiry/', $page_id, $force);
    }

    private function seed_success_stories($force = false)
    {
        $page_id = $this->get_page_id('success-stories');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Stories People<br>Now Carry <em class="text-gold italic">Differently</em>.', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Conversations, retreats, and transformational experiences that helped leaders reconnect with their voice, clarity, confidence, and influence.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('stories-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_videos_heading', 'Hear it in Their <br>Own <em class="text-gold italic">Words</em>.', $page_id, $force);
        $this->update_acf_field('section_videos_items', [
            ['item_video_url' => 'https://www.youtube.com/watch?v=example1', 'item_name' => 'Victoria Richardson', 'item_title' => 'CEO', 'item_quote' => 'Working with Joanna transformed how I show up.'],
            ['item_video_url' => 'https://www.youtube.com/watch?v=example2', 'item_name' => 'LeQuisha Underwood', 'item_title' => 'Executive Director', 'item_quote' => 'I found my voice and my message in ways I never thought possible.'],
            ['item_video_url' => 'https://www.youtube.com/watch?v=example3', 'item_name' => 'Kendi Brown', 'item_title' => 'Founder', 'item_quote' => "Joanna's work is nothing short of transformational."],
            ['item_video_url' => 'https://www.youtube.com/watch?v=example4', 'item_name' => 'Ben Armstrong', 'item_title' => 'Leader', 'item_quote' => 'The clarity I gained has changed my leadership completely.'],
            ['item_video_url' => 'https://www.youtube.com/watch?v=example5', 'item_name' => 'Dawn Armstrong', 'item_title' => 'Executive', 'item_quote' => "I didn\u2019t realize how much I was holding back until Joanna showed me."],
            ['item_video_url' => 'https://www.youtube.com/watch?v=example6', 'item_name' => 'Jessica Avignone', 'item_title' => 'Leader', 'item_quote' => 'This work is essential for any leader who wants to be truly heard.'],
        ], $page_id, $force);
        $this->update_acf_field('section_written_heading', 'What Changed Wasn\'t<br>Just the <em class="text-gold italic">Message</em>.', $page_id, $force);
        $this->update_acf_field('section_written_items', [
            ['item_quote' => "Joanna\u2019s ability to help you find the story only you can tell is remarkable.", 'item_author' => 'Jennifer P.', 'item_title' => 'Executive'],
            ['item_quote' => 'I came in looking for a message. I left with a mission.', 'item_author' => 'Dr. Nadia R.', 'item_title' => 'Doctor'],
            ['item_quote' => 'This work changed the trajectory of my leadership.', 'item_author' => 'WILDx', 'item_title' => 'Organization'],
            ['item_quote' => 'Joanna helped me find words for what I had been feeling my whole career.', 'item_author' => 'Laurien Sibomana', 'item_title' => 'Leader'],
            ['item_quote' => 'I finally have a message that feels true to who I am.', 'item_author' => 'Monica May-Dunn', 'item_title' => 'Executive'],
            ['item_quote' => 'The True Influence Method is the real deal.', 'item_author' => 'K. Johnson', 'item_title' => 'CEO'],
            ['item_quote' => 'Working with Joanna has been nothing short of life-changing.', 'item_author' => 'A. Robinson', 'item_title' => 'Executive Leader'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Your Story May Be Waiting for Its <em class="text-gold italic">Moment</em> too', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'Start Your Story Journey', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/get-started/', $page_id, $force);
    }

    private function seed_thank_you($force = false)
    {
        $page_id = $this->get_page_id('thank-you');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Thank You', $page_id, $force);
        $this->update_acf_field('section_hero_text', 'Your message work begins now.', $page_id, $force);
        $this->update_acf_field('section_testimonials_heading', 'People Remember What <em class="text-gold italic">Felt True.</em>', $page_id, $force);
        $this->update_acf_field('section_testimonials_items', [
            ['item_quote' => 'Working with Joanna has been nothing short of life-changing.', 'item_author' => 'A. Robinson', 'item_title' => 'Executive Leader'],
            ['item_quote' => 'This was never about performing. It was about becoming.', 'item_author' => 'Victoria Richardson', 'item_title' => 'CEO'],
            ['item_quote' => 'Joanna helped me find words for what I had been feeling my whole career.', 'item_author' => 'Laurien Sibomana', 'item_title' => 'Leader'],
        ], $page_id, $force);
    }

    private function seed_the_authority($force = false)
    {
        $page_id = $this->get_page_id('the-authority');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', "The <em>Authority</em>", $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', "This path is designed for leaders ready to refine how they communicate, strengthen their authority, and turn their experience into a message people immediately understand, remember, and follow.", $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('authority-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('authority-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', "Be the <em>Authority</em> Through Your Story", $page_id, $force);
        $this->update_acf_field('section_two_ways_heading', "Two Ways <em>Forward</em>", $page_id, $force);
        $this->update_acf_field('section_two_ways_items', [
            ['item_heading' => 'Tell Your Story', 'item_text' => '<p>Reconnect with the defining moments behind your leadership, voice, and influence.</p>', 'item_btn_text' => 'FIND MY MESSAGE', 'item_btn_url' => home_url('/the-speaker/')],
            ['item_heading' => 'Move the Room', 'item_text' => '<p>Build a signature talk and message people trust, remember, and follow.</p>', 'item_btn_text' => 'TAKE THE STAGE', 'item_btn_url' => home_url('/the-speaker/')],
        ], $page_id, $force);
        $this->update_acf_field('section_work_heading', "Work 1:1 with Joanna.", $page_id, $force);
        $this->update_acf_field('section_work_items', [
            ['item_heading' => 'Discovery', 'item_text' => 'We begin by understanding where you are and where you want to go.', 'item_image' => $this->upload_image('work-discovery.webp')],
            ['item_heading' => 'Development', 'item_text' => 'Together, we build your message and authority position.', 'item_image' => $this->upload_image('work-development.webp')],
            ['item_heading' => 'Delivery', 'item_text' => 'You step into your message with confidence and power.', 'item_image' => $this->upload_image('work-delivery.webp')],
        ], $page_id, $force);
    }

    private function seed_the_legacy($force = false)
    {
        $page_id = $this->get_page_id('the-legacy');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', "The <em>Legacy</em>", $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', "This path is designed for leaders ready to strengthen their authority, refine how they communicate, and build a message that people immediately understand, remember, and trust.", $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('legacy-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('legacy-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', "Make an <em>Impact</em> With Your Voice", $page_id, $force);
        $this->update_acf_field('section_two_ways_heading', "Two Ways <em>Forward</em>", $page_id, $force);
        $this->update_acf_field('section_two_ways_items', [
            ['item_heading' => 'Build My Team', 'item_text' => '<p>Scale communication, trust, and leadership across your organization.</p>', 'item_btn_text' => 'SCALE MY BUSINESS', 'item_btn_url' => home_url('/build-my-team/')],
            ['item_heading' => 'Be Remembered', 'item_text' => '<p>Create work, leadership, and influence designed to outlast you.</p>', 'item_btn_text' => 'SCALE MY BUSINESS', 'item_btn_url' => home_url('/be-remembered/')],
        ], $page_id, $force);
    }

    private function seed_the_speaker($force = false)
    {
        $page_id = $this->get_page_id('the-speaker');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', "The <em>Speaker</em>", $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', "This path is designed for leaders ready to uncover the message behind their lived experience and begin communicating it with greater clarity, confidence, and emotional truth.", $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('speaker-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('speaker-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', "You <em>Don&#8217;t Need</em> to Sound More Impressive.", $page_id, $force);
        $this->update_acf_field('section_story_heading', "Tell Your Story &mdash;<br>My <em>Why</em>", $page_id, $force);
        $this->update_acf_field('section_story_image', $this->upload_image('story-superpower.webp'), $page_id, $force);
        $this->update_acf_field('section_breakthrough_heading', "Want to go further?", $page_id, $force);
        $this->update_acf_field('section_breakthrough_btn_text', "BOOK A BREAKTHROUGH SESSION", $page_id, $force);
        $this->update_acf_field('section_breakthrough_btn_url', '/inquiry/', $page_id, $force);
    }

    private function seed_the_vault($force = false)
    {
        $page_id = $this->get_page_id('the-vault');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', "The <em>Vault</em>", $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', "A free live session with Joanna &mdash; <strong>June 5, 9:00&ndash;10:00 AM PST</strong>\n\nThis is your invitation to sit with Joanna in real time. No slides. No sales pitch. Just a direct conversation about the message you've been carrying and haven't fully said yet. Bring a question. Leave with clarity.", $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('vault-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_what_is_heading', "What is the <em>Vault?</em>", $page_id, $force);
        $this->update_acf_field('section_what_is_image', $this->upload_image('vault-content.webp'), $page_id, $force);
        $this->update_acf_field('section_what_happens_heading', "What <em>Happens</em> Inside", $page_id, $force);
        $this->update_acf_field('section_what_happens_items', [
            ['item_heading' => 'Weekly Audio Sessions', 'item_text' => 'New content every week to keep you sharp and self-aware.'],
            ['item_heading' => 'Private Podcast', 'item_text' => 'Exclusive episodes you won\u2019t find anywhere else.'],
            ['item_heading' => 'Curated Insights', 'item_text' => 'Strategic insights tailored for leaders at the highest level.'],
            ['item_heading' => 'Community Access', 'item_text' => 'Connect with other leaders committed to authentic influence.'],
        ], $page_id, $force);
        $this->update_acf_field('section_registration_heading', "<em>Reserve</em> Your Seat", $page_id, $force);
        $this->update_acf_field('section_registration_btn_text', "REGISTER FOR THE VAULT", $page_id, $force);
        $this->update_acf_field('section_registration_btn_url', '/inquiry/', $page_id, $force);
    }
}

WP_CLI::add_command('tim-tailpress', 'TimTailPress_Seeder');
