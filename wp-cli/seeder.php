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

        $this->update_acf_field('section_hero_heading', "You're Not Missing a Message. <em class=\"text-gold\">You're Missing Trust.</em>", $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Somewhere along the way, you learned how to explain yourself\u2026 but not how to truly be felt.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('hero-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('hero-img.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_btn_primary_text', 'Start Your Story', $page_id, $force);
        $this->update_acf_field('section_hero_btn_primary_url', '/get-started/', $page_id, $force);
        $this->update_acf_field('section_hero_btn_secondary_text', 'Watch Joanna Speak', $page_id, $force);
        $this->update_acf_field('section_hero_btn_secondary_url', '/on-stage/', $page_id, $force);

        $this->update_acf_field('section_trusted_heading', 'Trusted by leaders worldwide', $page_id, $force);
        $this->update_acf_field('section_trusted_stats', [
            ['item_icon' => $this->upload_svg('UsersThree'), 'item_value' => '10,000+', 'item_label' => 'Leaders Transformed'],
            ['item_icon' => $this->upload_svg('SealCheck'), 'item_value' => '30+', 'item_label' => 'Years of Work'],
        ], $page_id, $force);

        $this->update_acf_field('section_you_know_heading', 'You Know What You <em class="text-gold">Mean</em>', $page_id, $force);
        $this->update_acf_field('section_you_know_bg_image', $this->upload_image('know-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_you_know_profile_image', $this->upload_image('joanna-whole.webp'), $page_id, $force);
        $this->update_acf_field('section_you_know_text', '<p>But when it\u2019s time to speak\u2026</p><p>You over-explain. You soften your truth. You lose the part people were supposed to feel.</p><p>Because the words were never the problem.<br><br>The disconnect came long before the conversation did.</p>', $page_id, $force);

        $this->update_acf_field('section_tell_story_heading', 'Your Story Changes Rooms.', $page_id, $force);
        $this->update_acf_field('section_tell_story_text', '<p>What\u2019s been dismissed as \u201cjust your story\u201d is actually your most underused asset.</p><p>When you reclaim it, you don\u2019t just speak\u2014you land. You stop performing authority and start \u201cbeing\u201d it.</p>', $page_id, $force);
        $this->update_acf_field('section_tell_story_image', $this->upload_image('tell-story-1.webp'), $page_id, $force);
        $this->update_acf_field('section_tell_story_btn_text', 'Tell Your Story', $page_id, $force);
        $this->update_acf_field('section_tell_story_btn_url', '/the-speaker/', $page_id, $force);

        $this->update_acf_field('section_discover_heading', 'Discover the Message Hidden Inside Your Story.', $page_id, $force);
        $this->update_acf_field('section_discover_text', 'Somewhere between the roles you play and the dreams you carry is a truth trying to be born\u2014not as a performance, but as presence.', $page_id, $force);
        $this->update_acf_field('section_discover_image', $this->upload_image('discover-img.webp'), $page_id, $force);
        $this->update_acf_field('section_discover_btn_text', 'FIND MY MESSAGE', $page_id, $force);
        $this->update_acf_field('section_discover_btn_url', '/get-started/', $page_id, $force);

        $this->update_acf_field('section_journey_heading', 'The Journey', $page_id, $force);
        $this->update_acf_field('section_journey_items', [
            ['item_icon' => $this->upload_svg('UsersThree'), 'item_heading' => 'Tell Your Story', 'item_text' => 'Reconnect with the defining moments behind your leadership, voice, and influence.'],
            ['item_icon' => $this->upload_svg('Lectern'), 'item_heading' => 'Move the Room', 'item_text' => 'Build a signature talk and message people trust, remember, and follow.'],
            ['item_icon' => $this->upload_svg('SealCheck'), 'item_heading' => 'Master My Message', 'item_text' => 'Refine your positioning, authority, and keynote-level message.'],
            ['item_icon' => $this->upload_svg('UserCircleCheck'), 'item_heading' => 'Build My Team', 'item_text' => 'Scale communication, trust, and leadership across your organization.'],
            ['item_icon' => $this->upload_svg('StarIcon'), 'item_heading' => 'Be Remembered', 'item_text' => 'Create work, leadership, and influence designed to outlast you.'],
        ], $page_id, $force);

        $this->update_acf_field('section_speaker_heading', '<em class="text-gold italic">Move</em> the Room.', $page_id, $force);
        $this->update_acf_field('section_speaker_text', "Speaker Cohort is Joanna's advanced speaking experience for leaders ready to communicate with clarity, emotional authority, and presence that moves people to action.", $page_id, $force);
        $this->update_acf_field('section_speaker_image', $this->upload_image('joana-speaker.webp'), $page_id, $force);
        $this->update_acf_field('section_speaker_bg_image', $this->upload_image('speaker-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_speaker_watermark_image', $this->upload_image('speaker-cohort.webp'), $page_id, $force);
        $this->update_acf_field('section_speaker_btn_text', 'Explore Speaker Cohort', $page_id, $force);
        $this->update_acf_field('section_speaker_btn_url', '/speaker-cohort/', $page_id, $force);

        $this->update_acf_field('section_vault_heading', 'Stay Inside the Conversation.', $page_id, $force);
        $this->update_acf_field('section_vault_text', "Get first access to Joanna's premium audio sessions, private podcast, and curated insights designed for leaders who want to stay sharp, self-aware, and leading from what's real.", $page_id, $force);
        $this->update_acf_field('section_vault_image', $this->upload_image('vault-img.webp'), $page_id, $force);
        $this->update_acf_field('section_vault_btn_text', 'ENTER THE VAULT', $page_id, $force);
        $this->update_acf_field('section_vault_btn_url', '/the-vault/', $page_id, $force);

        $this->update_acf_field('section_testimonials_heading', 'People Remember What Felt <em class="text-gold italic">True.</em>', $page_id, $force);
        $this->update_acf_field('section_testimonials_subtitle', 'Leaders from around the world come to Joanna to reconnect with their voice, refine their message, and lead with deeper influence.', $page_id, $force);
        $this->update_acf_field('section_testimonials_items', [
            ['item_quote' => 'Working with Joanna has been nothing short of life-changing.', 'item_author' => 'A. ROBINSON', 'item_title' => 'Executive Leader'],
            ['item_quote' => 'This was never about performing. It was about becoming.', 'item_author' => 'Speak & Rise Participant', 'item_title' => 'Leader'],
            ['item_quote' => 'When clarity meets momentum, everything changes. Joanna gave me both.', 'item_author' => 'EXECUTIVE CLIENT', 'item_title' => 'Leader'],
        ], $page_id, $force);

        $this->update_acf_field('section_voice_heading', 'Your Voice Carries More Than Information.', $page_id, $force);
        $this->update_acf_field('section_voice_text', '<p>Whether you are standing on a stage, leading a team, building a company, or guiding your family\u2014what people remember is not what you said. It is how you made them feel.</p><p>The True Influence Method is not a set of techniques. It is a return to what is already true in you.</p>', $page_id, $force);
        $this->update_acf_field('section_voice_image', $this->upload_image('voice-img.webp'), $page_id, $force);
    }

    private function seed_about($force = false)
    {
        $page_id = $this->get_page_id('about');
        if (! $page_id) {
            return;
        }

        $this->update_acf_field('section_hero_heading', 'Influence Begins<br>With What\'s <em class="text-gold italic">True.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Joanna Horton McPherson is a private advisor, speaker, and creator of the True Influence Method\u2122 \u2014 helping leaders turn lived experience into messages people trust, feel, and follow.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('about-joanna-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('about-joanna-img.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_stats', [
            ['item_icon' => $this->upload_svg('UsersThree'), 'item_value' => '10,000', 'item_label' => 'Leaders Transformed'],
            ['item_icon' => $this->upload_svg('SealCheck'), 'item_value' => '30', 'item_label' => 'Years of Work'],
            ['item_icon' => $this->upload_svg('Lectern'), 'item_value' => '1,000', 'item_label' => 'Keynotes Delivered'],
            ['item_icon' => $this->upload_svg('UserCircleCheck'), 'item_value' => '6', 'item_label' => 'Founder & Investor'],
        ], $page_id, $force);

        $this->update_acf_field('section_leader_heading', 'Being a Leader is Choosing What You <em class="text-gold">Become.</em>', $page_id, $force);
        $this->update_acf_field('section_leader_text', '<p>Joanna Horton McPherson is not a speaker coach. She is a private advisor to leaders, founders, and high-visibility executives who have outgrown the strategies that got them noticed and are ready for the ones that make them unforgettable.</p><p>Her work sits at the intersection of story, identity, and influence \u2014 helping clients turn lived experience into a message people trust, feel, and follow.</p>', $page_id, $force);
        $this->update_acf_field('section_leader_image', $this->upload_image('about-leader.webp'), $page_id, $force);
        $this->update_acf_field('section_leader_gallery', [
            $this->upload_image('about-gallery-1.webp'),
            $this->upload_image('about-gallery-2.webp'),
            $this->upload_image('about-gallery-3.webp'),
            $this->upload_image('about-gallery-4.webp'),
        ], $page_id, $force);

        $this->update_acf_field('section_meaning_heading', 'Long Before the Stages, There Was the Search for <em class="text-gold">Meaning.</em>', $page_id, $force);
        $this->update_acf_field('section_meaning_text', '<p>Before she ever stepped on a stage, Joanna was shaped by a question most leaders avoid: What is true about me when no one is watching?</p><p>This question became the foundation of everything she would later teach \u2014 that real influence is not built through technique, but through the courage to meet yourself first.</p>', $page_id, $force);
        $this->update_acf_field('section_meaning_image', $this->upload_image('about-meaning.webp'), $page_id, $force);

        $this->update_acf_field('section_life_heading', 'Choose Where You <em class="text-gold">Are.</em>', $page_id, $force);
        $this->update_acf_field('section_life_text', '<p>Joanna\u2019s path has been anything but linear. From early career decisions that tested her identity to moments of reinvention that redefined her purpose, her story mirrors the journey of every leader she works with.</p>', $page_id, $force);
        $this->update_acf_field('section_life_image', $this->upload_image('about-life.webp'), $page_id, $force);

        $this->update_acf_field('section_reconnect_heading', 'Reconnect With What\'s <em class="text-gold italic">True.</em>', $page_id, $force);
        $this->update_acf_field('section_reconnect_text', '<p>Whether you are building a keynote, navigating a career transition, or preparing for a high-stakes conversation \u2014 Joanna meets you where you are and helps you get to where only you can go.</p>', $page_id, $force);
        $this->update_acf_field('section_reconnect_btn_text', 'Work With Joanna', $page_id, $force);
        $this->update_acf_field('section_reconnect_btn_url', '/inquiry/', $page_id, $force);

        $this->update_acf_field('section_voice_heading', 'Your Voice Carries More Than Information.', $page_id, $force);
        $this->update_acf_field('section_voice_text', '<p>Whether you are standing on a stage, leading a team, building a company, or guiding your family\u2014what people remember is not what you said. It is how you made them feel.</p>', $page_id, $force);
    }

    private function seed_4_session($force = false)
    {
        $page_id = $this->get_page_id('4-session');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', '4-Session <em class="text-gold">Training Package</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Four private, high-impact sessions designed to help you clarify your message, own your authority, and communicate with influence.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('training-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('training-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You\'ll <em class="text-gold">Build</em>', $page_id, $force);
        $this->update_acf_field('section_build_text', 'Over four sessions, you will move from feeling unheard to being unforgettable. Each session builds on the last, creating a complete transformation in how you communicate and lead.', $page_id, $force);
        $this->update_acf_field('section_distinct_heading', 'What Makes This <em class="text-gold">Distinct</em>', $page_id, $force);
        $this->update_acf_field('section_distinct_items', [
            ['item_heading' => 'Personalized Curriculum', 'item_text' => 'Every session is tailored to your specific voice, message, and leadership context.'],
            ['item_heading' => 'Real-Time Feedback', 'item_text' => 'Receive immediate, actionable feedback on your delivery, presence, and messaging.'],
            ['item_heading' => 'Proven Framework', 'item_text' => "The True Influence Method\u2122 framework has transformed thousands of leaders worldwide."],
            ['item_heading' => 'Lasting Impact', 'item_text' => 'Walk away with skills and self-awareness that compound over time.'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Ready to Begin Your <em class="text-gold">Transformation</em>', $page_id, $force);
        $this->update_acf_field('section_cta_text', 'Your message matters. Let\u2019s make sure it lands.', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'BOOK A SESSION', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/inquiry/', $page_id, $force);
    }

    private function seed_be_remembered($force = false)
    {
        $page_id = $this->get_page_id('be-remembered');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Be <em class="text-gold">Remembered.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Create work, leadership, and influence designed to outlast you.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('remembered-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('remembered-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'The Message', $page_id, $force);
        $this->update_acf_field('section_message_text', 'You didn\u2019t come this far to be forgotten.', $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You\'ll <em class="text-gold">Build</em>', $page_id, $force);
        $this->update_acf_field('section_build_text', 'A legacy isn\u2019t something you leave. It\u2019s something you build\u2014on purpose.', $page_id, $force);
        $this->update_acf_field('section_build_btn_text', 'BUILD MY LEGACY', $page_id, $force);
        $this->update_acf_field('section_build_btn_url', '/inquiry/', $page_id, $force);
        $this->update_acf_field('section_distinct_heading', 'What Makes This <em class="text-gold">Distinct</em>', $page_id, $force);
        $this->update_acf_field('section_distinct_items', [
            ['item_heading' => 'Vision Architecture', 'item_text' => 'Design a long-term vision that goes beyond your lifetime.'],
            ['item_heading' => 'Legacy Blueprint', 'item_text' => 'Build the systems and message that will carry your work forward.'],
            ['item_heading' => 'Influence Strategy', 'item_text' => 'Create influence that compounds across generations.'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Your Legacy <em class="text-gold">Starts Now</em>', $page_id, $force);
        $this->update_acf_field('section_cta_text', 'The work you do today determines what you leave behind tomorrow.', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'START BUILDING', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/inquiry/', $page_id, $force);
    }

    private function seed_breakthrough_session($force = false)
    {
        $page_id = $this->get_page_id('breakthrough-session');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Breakthrough <em class="text-gold">Session</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'A single, powerful session to identify your core message and the story only you can tell.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('breakthrough-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('breakthrough-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'Your <em class="text-gold">Message</em>', $page_id, $force);
        $this->update_acf_field('section_message_text', 'Somewhere inside you is a message the world needs to hear. In one session, we find it.', $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You\'ll <em class="text-gold">Build</em>', $page_id, $force);
        $this->update_acf_field('section_build_text', 'Clarity. Confidence. A message that moves people.', $page_id, $force);
        $this->update_acf_field('section_build_btn_text', 'BOOK A SESSION', $page_id, $force);
        $this->update_acf_field('section_build_btn_url', '/inquiry/', $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Ready for Your <em class="text-gold">Breakthrough</em>', $page_id, $force);
        $this->update_acf_field('section_cta_text', 'One session can change everything.', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'BOOK A SESSION', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/inquiry/', $page_id, $force);
    }

    private function seed_build_my_team($force = false)
    {
        $page_id = $this->get_page_id('build-my-team');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Build My <em class="text-gold">Team.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Scale communication, trust, and leadership across your organization.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('team-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('team-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'The <em class="text-gold">Message</em>', $page_id, $force);
        $this->update_acf_field('section_message_text', 'Your organization\u2019s message isn\u2019t just what you say\u2014it\u2019s how your people show up.', $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You\'ll <em class="text-gold">Build</em>', $page_id, $force);
        $this->update_acf_field('section_build_text', 'A communication culture that scales trust, clarity, and leadership at every level.', $page_id, $force);
        $this->update_acf_field('section_build_btn_text', 'SCALE MY BUSINESS', $page_id, $force);
        $this->update_acf_field('section_build_btn_url', '/inquiry/', $page_id, $force);
        $this->update_acf_field('section_distinct_heading', 'What Makes This <em class="text-gold">Distinct</em>', $page_id, $force);
        $this->update_acf_field('section_distinct_items', [
            ['item_heading' => 'Enterprise Framework', 'item_text' => 'Proven methodology adapted for organizational scale.'],
            ['item_heading' => 'Leadership Alignment', 'item_text' => 'Get your entire leadership team communicating with one voice.'],
            ['item_heading' => 'Cultural Transformation', 'item_text' => 'Build a culture of authentic communication from the inside out.'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Ready to <em class="text-gold">Scale</em> Your Impact', $page_id, $force);
        $this->update_acf_field('section_cta_text', 'Your team is ready for the next level.', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'SCALE MY BUSINESS', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/inquiry/', $page_id, $force);
    }

    private function seed_events($force = false)
    {
        $page_id = $this->get_page_id('events');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Events & <em class="text-gold">Workshops</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Transformational experiences designed for leaders who are ready to go further.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('events-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('events-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_retreat_heading', 'The <em class="text-gold">Retreat</em>', $page_id, $force);
        $this->update_acf_field('section_retreat_text', '<p>Speak & Rise + Retreat is Joanna\u2019s immersive leadership experience. Over multiple days, leaders move from feeling stuck in their message to standing fully in their authority.</p>', $page_id, $force);
        $this->update_acf_field('section_retreat_image', $this->upload_image('retreat-img.webp'), $page_id, $force);
        $this->update_acf_field('section_upcoming_heading', 'Upcoming <em class="text-gold">Events</em>', $page_id, $force);
        $this->update_acf_field('section_upcoming_items', [
            ['item_date' => 'September 16-20, 2026', 'item_title' => 'Speak & Rise + Retreat', 'item_location' => 'Phoenix', 'item_description' => 'Our flagship leadership intensive.'],
            ['item_date' => 'December 1, 2026', 'item_title' => 'Speaking On Stage Top Talent Hollywood', 'item_location' => 'Phoenix', 'item_description' => 'Advanced speaking experience for top talent.'],
        ], $page_id, $force);
        $this->update_acf_field('section_features_heading', 'What\'s <em class="text-gold">Included</em>', $page_id, $force);
        $this->update_acf_field('section_features_items', [
            ['item_heading' => 'Private Coaching', 'item_text' => 'One-on-one sessions with Joanna to refine your message.'],
            ['item_heading' => 'Peer Feedback', 'item_text' => 'Learn and grow alongside other high-level leaders.'],
            ['item_heading' => 'Practical Application', 'item_text' => 'Leave with a message you can deliver immediately.'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Join Us at the <em class="text-gold">Next Event</em>', $page_id, $force);
        $this->update_acf_field('section_cta_text', 'Space is limited to ensure every leader gets the attention they deserve.', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'REGISTER NOW', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/inquiry/', $page_id, $force);
    }

    private function seed_get_started($force = false)
    {
        $page_id = $this->get_page_id('get-started');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Get <em class="text-gold">Started</em>', $page_id, $force);
        $this->update_acf_field('section_hero_text', 'Your message is ready to be heard. Let\u2019s find the path that\u2019s right for you.', $page_id, $force);
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
        $this->update_acf_field('section_hero_heading', 'Let\'s <em class="text-gold">Connect</em>', $page_id, $force);
        $this->update_acf_field('section_hero_text', 'Ready to take the next step? Tell me a little about where you are and what you\u2019re looking for.', $page_id, $force);
    }

    private function seed_master_my_message($force = false)
    {
        $page_id = $this->get_page_id('master-my-message');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Master My <em class="text-gold">Message</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Refine your positioning, authority, and keynote-level message.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('message-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('message-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'Your <em class="text-gold">Message</em>', $page_id, $force);
        $this->update_acf_field('section_message_text', 'You have been building authority your whole life. Now let\u2019s build the message that communicates it.', $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You\'ll <em class="text-gold">Build</em>', $page_id, $force);
        $this->update_acf_field('section_build_text', 'A signature message that positions you as the authority you are.', $page_id, $force);
        $this->update_acf_field('section_build_btn_text', 'CREATE MY KEYNOTE', $page_id, $force);
        $this->update_acf_field('section_build_btn_url', '/inquiry/', $page_id, $force);
        $this->update_acf_field('section_distinct_heading', 'What Makes This <em class="text-gold">Distinct</em>', $page_id, $force);
        $this->update_acf_field('section_distinct_items', [
            ['item_heading' => 'Message Architecture', 'item_text' => 'Build a message framework that supports every communication you\u2019ll ever make.'],
            ['item_heading' => 'Authority Positioning', 'item_text' => 'Position yourself as the go-to authority in your space.'],
            ['item_heading' => 'Keynote Development', 'item_text' => 'Develop a keynote that opens doors and creates opportunities.'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Ready to <em class="text-gold">Master</em> Your Message', $page_id, $force);
        $this->update_acf_field('section_cta_text', 'Your authority is waiting.', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'CREATE MY KEYNOTE', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/inquiry/', $page_id, $force);
    }

    private function seed_million_dollar_message($force = false)
    {
        $page_id = $this->get_page_id('million-dollar-message');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'The Million Dollar <em class="text-gold">Message</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'The framework that has helped thousands of leaders turn their story into their greatest asset.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('mdm-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('mdm-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_btn_text', 'GET INSTANT ACCESS', $page_id, $force);
        $this->update_acf_field('section_hero_btn_url', '#', $page_id, $force);
        $this->update_acf_field('section_inside_heading', 'What\'s <em class="text-gold">Inside</em>', $page_id, $force);
        $this->update_acf_field('section_inside_text', '<p>Joanna\u2019s proven framework for turning your lived experience into a message that moves people to action. This is the same methodology she uses with CEOs, founders, and leaders at the highest levels.</p>', $page_id, $force);
        $this->update_acf_field('section_inside_image', $this->upload_image('mdm-inside.webp'), $page_id, $force);
    }

    private function seed_offers($force = false)
    {
        $page_id = $this->get_page_id('offers');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Ways to <em class="text-gold">Work</em> with Joanna', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', "Every leader's journey is different. Find the path that's right for where you are and where you're ready to go.", $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('offers-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('offers-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_signature_heading', 'Signature <em class="text-gold italic">Offers</em>', $page_id, $force);
        $this->update_acf_field('section_signature_subtitle', 'The primary transformational experiences inside the True Influence Method\u2122 \u2014 designed for different stages of leadership, visibility, authority, and long-term impact.', $page_id, $force);
        $this->update_acf_field('section_signature_items', [
            ['item_title' => 'Tell Your Story', 'item_description' => 'Reconnect with the defining moments behind your leadership, voice, and influence.', 'item_price_label' => '', 'item_price' => '$3,200', 'item_cta' => 'FIND MY MESSAGE', 'item_url' => home_url('/the-speaker/')],
            ['item_title' => 'Move the Room', 'item_description' => 'Build a signature talk and message people trust, remember, and follow.', 'item_price_label' => '', 'item_price' => '$12,000', 'item_cta' => 'TAKE THE STAGE', 'item_url' => home_url('/the-speaker/')],
            ['item_title' => 'Master My Message', 'item_description' => 'Refine your positioning, authority, and keynote-level message.', 'item_price_label' => 'Starts at', 'item_price' => '$25,000', 'item_cta' => 'CREATE MY KEYNOTE', 'item_url' => home_url('/master-my-message/')],
            ['item_title' => 'Build My Team', 'item_description' => 'Scale communication, trust, and leadership across your organization.', 'item_price_label' => 'Starts at', 'item_price' => '$250,000', 'item_cta' => 'SCALE MY BUSINESS', 'item_url' => home_url('/build-my-team/')],
            ['item_title' => 'Be Remembered', 'item_description' => 'Create work, leadership, and influence designed to outlast you.', 'item_price_label' => 'Starts at', 'item_price' => '$1M', 'item_cta' => 'SCALE MY BUSINESS', 'item_url' => home_url('/be-remembered/')],
        ], $page_id, $force);
        $this->update_acf_field('section_other_heading', 'Other <em class="text-gold italic">Offers</em>', $page_id, $force);
        $this->update_acf_field('section_other_items', [
            ['item_title' => 'Breakthrough Session', 'item_description' => 'A single, powerful session to identify your core message and the story only you can tell.', 'item_price' => '$2,000', 'item_cta' => 'BOOK A SESSION', 'item_url' => home_url('/breakthrough-session/')],
            ['item_title' => '4-Session Training Package', 'item_description' => 'Four private sessions to clarify your message, own your authority, and communicate with influence.', 'item_price' => '$8,000', 'item_cta' => 'BOOK NOW', 'item_url' => home_url('/4-session/')],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Not Sure Where to <em class="text-gold italic">Start</em>', $page_id, $force);
        $this->update_acf_field('section_cta_text', 'Every leader\u2019s journey is unique. Let\u2019s find where you are and where you\u2019re ready to go.', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'GET STARTED', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/get-started/', $page_id, $force);
    }

    private function seed_on_stage($force = false)
    {
        $page_id = $this->get_page_id('on-stage');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', '<em class="text-gold">On Stage</em> With Joanna', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'From boardrooms to ballrooms, Joanna brings a message of authentic influence to leaders around the world.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('onstage-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('onstage-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_stats', [
            ['item_value' => '150+', 'item_label' => 'Stages'],
            ['item_value' => '12', 'item_label' => 'Countries'],
        ], $page_id, $force);
        $this->update_acf_field('section_video_heading', 'Watch Joanna <em class="text-gold">Speak</em>', $page_id, $force);
        $this->update_acf_field('section_video_video_url', 'https://www.youtube.com/watch?v=example', $page_id, $force);
        $this->update_acf_field('section_video_text', "Experience Joanna's keynote presence and see why leaders around the world trust her to help them find their voice.", $page_id, $force);
        $this->update_acf_field('section_credibility_heading', 'Why Leading Organizations <em class="text-gold">Trust</em> Joanna', $page_id, $force);
        $this->update_acf_field('section_credibility_items', [
            ['item_heading' => '30+ Years of Leadership', 'item_text' => 'Decades of experience guiding leaders through transformation.'],
            ['item_heading' => '1,000+ Keynotes Delivered', 'item_text' => 'A proven track record of moving audiences to action.'],
            ['item_heading' => 'Proven Methodology', 'item_text' => "The True Influence Method\u2122 is backed by real results with real leaders."],
        ], $page_id, $force);
        $this->update_acf_field('section_experiences_heading', 'Signature <em class="text-gold">Experiences</em>', $page_id, $force);
        $this->update_acf_field('section_experiences_items', [
            ['item_image' => $this->upload_image('keynote-img.webp'), 'item_title' => 'Keynote Speeches', 'item_description' => 'Custom keynotes that inspire, challenge, and transform your audience.'],
            ['item_image' => $this->upload_image('workshop-img.webp'), 'item_title' => 'Leadership Workshops', 'item_description' => 'Immersive workshops that build authentic communication skills.'],
            ['item_image' => $this->upload_image('consulting-img.webp'), 'item_title' => 'Executive Consulting', 'item_description' => 'One-on-one work with your leadership team to align message and vision.'],
        ], $page_id, $force);
        $this->update_acf_field('section_book_heading', 'Book Joanna for Your <em class="text-gold">Next Event</em>', $page_id, $force);
        $this->update_acf_field('section_book_text', 'Ready to bring Joanna\u2019s message of authentic influence to your audience?', $page_id, $force);
        $this->update_acf_field('section_book_image', $this->upload_image('book-joanna.webp'), $page_id, $force);
        $this->update_acf_field('section_book_btn_text', 'BOOK JOANNA', $page_id, $force);
        $this->update_acf_field('section_book_btn_url', '/inquiry/', $page_id, $force);
        $this->update_acf_field('section_download_heading', 'Download Joanna\'s <em class="text-gold">Media Kit</em>', $page_id, $force);
        $this->update_acf_field('section_download_text', 'Get Joanna\u2019s full speaker profile, topic list, and testimonials for your next event.', $page_id, $force);
        $this->update_acf_field('section_download_btn_text', 'DOWNLOAD MEDIA KIT', $page_id, $force);
        $this->update_acf_field('section_download_btn_url', '#', $page_id, $force);
    }

    private function seed_speaker_cohort($force = false)
    {
        $page_id = $this->get_page_id('speaker-cohort');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Speaker <em class="text-gold">Cohort</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', "Joanna's advanced speaking experience for leaders ready to communicate with clarity, emotional authority, and presence that moves people to action.", $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('cohort-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('cohort-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'Your <em class="text-gold">Message</em>', $page_id, $force);
        $this->update_acf_field('section_message_text', 'You have a message that matters. The Speaker Cohort helps you deliver it with power and presence.', $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You\'ll <em class="text-gold">Build</em>', $page_id, $force);
        $this->update_acf_field('section_build_text', 'A signature talk that opens doors, creates impact, and positions you as the authority you are.', $page_id, $force);
        $this->update_acf_field('section_build_btn_text', 'JOIN THE COHORT', $page_id, $force);
        $this->update_acf_field('section_build_btn_url', '/inquiry/', $page_id, $force);
        $this->update_acf_field('section_speaking_heading', 'What You\'ll <em class="text-gold">Learn</em>', $page_id, $force);
        $this->update_acf_field('section_speaking_items', [
            ['item_heading' => 'Message Development', 'item_text' => 'Craft a message that lands with power and precision.'],
            ['item_heading' => 'Stage Presence', 'item_text' => 'Develop the presence that commands attention and builds trust.'],
            ['item_heading' => 'Story Architecture', 'item_text' => 'Structure your story for maximum emotional impact.'],
            ['item_heading' => 'Audience Connection', 'item_text' => 'Learn to read a room and adjust in real-time.'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Ready to <em class="text-gold">Join</em> the Cohort', $page_id, $force);
        $this->update_acf_field('section_cta_text', 'Space is limited to ensure every participant gets personalized attention.', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'JOIN THE COHORT', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/inquiry/', $page_id, $force);
    }

    private function seed_success_stories($force = false)
    {
        $page_id = $this->get_page_id('success-stories');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Success <em class="text-gold">Stories</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Leaders who have done the work. Messages that have moved rooms. Results that speak for themselves.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('stories-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_videos_heading', 'Hear from Leaders Who\'ve <em class="text-gold">Transformed</em>', $page_id, $force);
        $this->update_acf_field('section_videos_items', [
            ['item_video_url' => 'https://www.youtube.com/watch?v=example1', 'item_name' => 'Victoria Richardson', 'item_title' => 'CEO', 'item_quote' => 'Working with Joanna transformed how I show up.'],
            ['item_video_url' => 'https://www.youtube.com/watch?v=example2', 'item_name' => 'LeQuisha Underwood', 'item_title' => 'Executive Director', 'item_quote' => 'I found my voice and my message in ways I never thought possible.'],
            ['item_video_url' => 'https://www.youtube.com/watch?v=example3', 'item_name' => 'Kendi Brown', 'item_title' => 'Founder', 'item_quote' => "Joanna's work is nothing short of transformational."],
            ['item_video_url' => 'https://www.youtube.com/watch?v=example4', 'item_name' => 'Ben Armstrong', 'item_title' => 'Leader', 'item_quote' => 'The clarity I gained has changed my leadership completely.'],
            ['item_video_url' => 'https://www.youtube.com/watch?v=example5', 'item_name' => 'Dawn Armstrong', 'item_title' => 'Executive', 'item_quote' => "I didn\u2019t realize how much I was holding back until Joanna showed me."],
            ['item_video_url' => 'https://www.youtube.com/watch?v=example6', 'item_name' => 'Jessica Avignone', 'item_title' => 'Leader', 'item_quote' => 'This work is essential for any leader who wants to be truly heard.'],
        ], $page_id, $force);
        $this->update_acf_field('section_written_heading', 'What Leaders Are <em class="text-gold">Saying</em>', $page_id, $force);
        $this->update_acf_field('section_written_items', [
            ['item_quote' => "Joanna\u2019s ability to help you find the story only you can tell is remarkable.", 'item_author' => 'Jennifer P.', 'item_title' => 'Executive'],
            ['item_quote' => 'I came in looking for a message. I left with a mission.', 'item_author' => 'Dr. Nadia R.', 'item_title' => 'Doctor'],
            ['item_quote' => 'This work changed the trajectory of my leadership.', 'item_author' => 'WILDx', 'item_title' => 'Organization'],
            ['item_quote' => 'Joanna helped me find words for what I had been feeling my whole career.', 'item_author' => 'Laurien Sibomana', 'item_title' => 'Leader'],
            ['item_quote' => 'I finally have a message that feels true to who I am.', 'item_author' => 'Monica May-Dunn', 'item_title' => 'Executive'],
            ['item_quote' => 'The True Influence Method is the real deal.', 'item_author' => 'K. Johnson', 'item_title' => 'CEO'],
            ['item_quote' => 'Working with Joanna has been nothing short of life-changing.', 'item_author' => 'A. Robinson', 'item_title' => 'Executive Leader'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Your Story Could Be <em class="text-gold">Next</em>', $page_id, $force);
        $this->update_acf_field('section_cta_text', 'Every leader has a message waiting to be uncovered.', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'START YOUR JOURNEY', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/get-started/', $page_id, $force);
    }

    private function seed_thank_you($force = false)
    {
        $page_id = $this->get_page_id('thank-you');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Thank <em class="text-gold">You</em>', $page_id, $force);
        $this->update_acf_field('section_hero_text', 'Your inquiry has been received. I will review your message and get back to you within 24\u201348 hours.', $page_id, $force);
        $this->update_acf_field('section_testimonials_heading', 'While You <em class="text-gold">Wait</em>', $page_id, $force);
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
        $this->update_acf_field('section_hero_heading', 'The <em class="text-gold">Authority</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Position yourself as the go-to authority in your space through the power of your story.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('authority-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('authority-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'Your Work is Strong. <em class="text-gold">Your Positioning Isn\'t.</em>', $page_id, $force);
        $this->update_acf_field('section_message_text', 'Authority isn\u2019t declared. It\u2019s demonstrated through the story only you can tell.', $page_id, $force);
        $this->update_acf_field('section_two_ways_heading', 'Two Ways to <em class="text-gold">Work</em>', $page_id, $force);
        $this->update_acf_field('section_two_ways_items', [
            ['item_heading' => 'Tell Your Story', 'item_text' => '<p>Reconnect with the defining moments behind your leadership, voice, and influence.</p>', 'item_btn_text' => 'FIND MY MESSAGE', 'item_btn_url' => home_url('/the-speaker/')],
            ['item_heading' => 'Move the Room', 'item_text' => '<p>Build a signature talk and message people trust, remember, and follow.</p>', 'item_btn_text' => 'TAKE THE STAGE', 'item_btn_url' => home_url('/the-speaker/')],
        ], $page_id, $force);
        $this->update_acf_field('section_work_heading', 'How We\'ll <em class="text-gold">Work</em> Together', $page_id, $force);
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
        $this->update_acf_field('section_hero_heading', 'The <em class="text-gold">Legacy</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Build influence that outlasts you.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('legacy-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('legacy-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'Your <em class="text-gold">Legacy</em>', $page_id, $force);
        $this->update_acf_field('section_message_text', 'What you leave behind is not what you built. It\u2019s what you made possible for others.', $page_id, $force);
        $this->update_acf_field('section_two_ways_heading', 'Two Ways to <em class="text-gold">Work</em>', $page_id, $force);
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
        $this->update_acf_field('section_hero_heading', 'The <em class="text-gold">Speaker</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'From the boardroom to the ballroom \u2014 find the voice that makes people stop, listen, and follow.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('speaker-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('speaker-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'Make an Impact With Your <em class="text-gold italic">Voice</em>', $page_id, $force);
        $this->update_acf_field('section_message_text', 'You have been building authority your whole life. Now learn to communicate it with the impact it deserves.', $page_id, $force);
        $this->update_acf_field('section_story_heading', 'Your Story is Your <em class="text-gold">Superpower</em>', $page_id, $force);
        $this->update_acf_field('section_story_text', '<p>What\u2019s been dismissed as \u201cjust your story\u201d is actually your most underused asset. When you reclaim it, you don\u2019t just speak\u2014you land.</p>', $page_id, $force);
        $this->update_acf_field('section_story_image', $this->upload_image('story-superpower.webp'), $page_id, $force);
        $this->update_acf_field('section_breakthrough_heading', 'Ready for Your <em class="text-gold">Breakthrough</em>', $page_id, $force);
        $this->update_acf_field('section_breakthrough_text', 'Your voice has the power to move rooms. Let\u2019s make sure it\u2019s heard.', $page_id, $force);
        $this->update_acf_field('section_breakthrough_btn_text', 'BOOK A SESSION', $page_id, $force);
        $this->update_acf_field('section_breakthrough_btn_url', '/inquiry/', $page_id, $force);
    }

    private function seed_the_vault($force = false)
    {
        $page_id = $this->get_page_id('the-vault');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'The <em class="text-gold">Vault</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Exclusive audio sessions, private podcast, and curated insights for leaders who want to stay sharp.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('vault-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_what_is_heading', 'What Is the <em class="text-gold">Vault</em>', $page_id, $force);
        $this->update_acf_field('section_what_is_text', '<p>The Vault is Joanna\u2019s premium content library \u2014 a private collection of audio teachings, guided reflections, and strategic insights designed for leaders who are committed to continuous growth.</p>', $page_id, $force);
        $this->update_acf_field('section_what_is_image', $this->upload_image('vault-content.webp'), $page_id, $force);
        $this->update_acf_field('section_what_happens_heading', 'What Happens <em class="text-gold">Inside</em>', $page_id, $force);
        $this->update_acf_field('section_what_happens_items', [
            ['item_heading' => 'Weekly Audio Sessions', 'item_text' => 'New content every week to keep you sharp and self-aware.'],
            ['item_heading' => 'Private Podcast', 'item_text' => 'Exclusive episodes you won\u2019t find anywhere else.'],
            ['item_heading' => 'Curated Insights', 'item_text' => 'Strategic insights tailored for leaders at the highest level.'],
            ['item_heading' => 'Community Access', 'item_text' => 'Connect with other leaders committed to authentic influence.'],
        ], $page_id, $force);
        $this->update_acf_field('section_registration_heading', 'Enter the <em class="text-gold">Vault</em>', $page_id, $force);
        $this->update_acf_field('section_registration_text', 'The next session opens June 5, 9:00-10:00 AM PST.', $page_id, $force);
        $this->update_acf_field('section_registration_btn_text', 'REQUEST ACCESS', $page_id, $force);
        $this->update_acf_field('section_registration_btn_url', '/inquiry/', $page_id, $force);
    }
}

WP_CLI::add_command('tim-tailpress', 'TimTailPress_Seeder');
