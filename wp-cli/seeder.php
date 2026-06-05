<?php

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
        $menu = wp_get_nav_menu_object($menu_name);

        if (! $menu) {
            $menu_id = wp_create_nav_menu($menu_name);
            if (is_wp_error($menu_id)) {
                return;
            }
        } else {
            $menu_id = $menu->term_id;
        }

        $existing_items = wp_get_nav_menu_items($menu_id);
        if ($existing_items === false) {
            $existing_items = [];
        }
        $existing_keys = [];
        foreach ($existing_items as $existing) {
            $parent_id = get_post_meta($existing->ID, '_menu_item_menu_item_parent', true);
            $parent_title = $parent_id ? get_the_title($parent_id) : '';
            $key = $parent_title . '||' . $existing->title;
            $existing_keys[$key] = true;
        }

        $item_ids = [];
        foreach ($items as $i => $item) {
            $parent_title = $item['parent'] ?? '';
            $key = $parent_title . '||' . $item['title'];

            if (isset($existing_keys[$key])) {
                foreach ($existing_items as $existing) {
                    $existing_parent_id = get_post_meta($existing->ID, '_menu_item_menu_item_parent', true);
                    $existing_parent_title = $existing_parent_id ? get_the_title($existing_parent_id) : '';
                    if ($existing_parent_title === $parent_title && $existing->title === $item['title']) {
                        $item_ids[$i] = $existing->ID;
                        break;
                    }
                }
                continue;
            }

            $item_id = wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title' => $item['title'],
                'menu-item-url' => $item['url'] ?? '',
                'menu-item-status' => 'publish',
                'menu-item-type' => ! empty($item['url']) ? 'custom' : 'none',
            ]);
            $item_ids[$i] = $item_id;
        }

        foreach ($items as $i => $item) {
            if (! empty($item['parent']) && isset($item_ids[$i])) {
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

    private function seed_seo($force = false)
    {
        $pages = [
            'front-page'          => ['meta_desc' => "Transform your leadership voice with Joanna Horton McPherson's True Influence Method™. Discover how to communicate with clarity, emotional authority, and trust.", 'og_image' => 'hero-img.webp'],
            'about'               => ['meta_desc' => 'Learn about Joanna Horton McPherson, creator of the True Influence Method™ helping leaders turn lived experience into messages people trust, feel, and follow.', 'og_image' => 'about-joanna-img.webp'],
            '4-session'           => ['meta_desc' => "Build your message from the inside out with Joanna's private 4-Session Training Package. Uncover, refine, and articulate the message behind your work.", 'og_image' => 'joanna-profile.webp'],
            'be-remembered'       => ['meta_desc' => 'Build a legacy that outlasts you with Be Remembered — Joanna\'s private legacy experience for founders and executives ready to create lasting impact.', 'og_image' => 'be-remembered-1.webp'],
            'breakthrough-session' => ['meta_desc' => "One session to see clearly. A private breakthrough session with Joanna to uncover what's true underneath the message you've been trying to say.", 'og_image' => 'breakthrough-1.webp'],
            'build-my-team'       => ['meta_desc' => "Scale trust, communication, and leadership across your organization with Build My Team — Joanna's private leadership experience for founders and executives.", 'og_image' => 'build-my-team1.webp'],
            'events'              => ['meta_desc' => 'Explore transformational retreats, speaking experiences, and leadership conversations with Joanna Horton McPherson at events and workshops worldwide.', 'og_image' => 'joanna-profile.webp'],
            'get-started'         => ['meta_desc' => "Choose where you are in your leadership journey. Discover the right path to uncover your message, build your authority, or define your legacy.", 'og_image' => 'generic-bg.webp'],
            'inquiry'             => ['meta_desc' => "Start the conversation with Joanna Horton McPherson. Tell us where you are and what you're exploring in your leadership and message journey.", 'og_image' => 'generic-bg.webp'],
            'master-my-message'   => ['meta_desc' => "Become known for something specific. Master My Message is Joanna's advanced authority-positioning experience for leaders ready to refine their message.", 'og_image' => 'master1.webp'],
            'million-dollar-message' => ['meta_desc' => "Your message already exists. Uncover the defining message behind your work with Joanna's 7-minute Million Dollar Message training for just \$29.", 'og_image' => 'million-hero.webp'],
            'offers'              => ['meta_desc' => 'Explore ways to work with Joanna Horton McPherson — from retreats and speaker development to private leadership advisory and transformational conversations.', 'og_image' => 'joanna-profile.webp'],
            'on-stage'            => ['meta_desc' => 'Book Joanna Horton McPherson for your next event. Keynotes, leadership conversations, and transformational speaking experiences that move rooms.', 'og_image' => 'onstage-joanna.webp'],
            'speaker-cohort'      => ['meta_desc' => "Stop explaining. Start landing. Join Joanna's Speaker Cohort to turn your lived experience into a clear, structured message people trust and follow.", 'og_image' => 'joanna-profile.webp'],
            'success-stories'     => ['meta_desc' => "Read stories from leaders who transformed their voice, clarity, and confidence through Joanna Horton McPherson's True Influence Method™.", 'og_image' => 'general-bg.webp'],
            'thank-you'           => ['meta_desc' => 'Thank you for beginning your message work with Joanna Horton McPherson. Your journey toward clearer communication starts now.', 'og_image' => 'generic-bg.webp'],
            'the-authority'       => ['meta_desc' => "Refine how you communicate and turn your experience into a message people immediately understand, remember, and follow with The Authority path.", 'og_image' => 'the-authority.webp'],
            'the-legacy'          => ['meta_desc' => "Strengthen your authority and build a message that people immediately understand, remember, and trust with The Legacy path.", 'og_image' => 'joanna-profile.webp'],
            'the-speaker'         => ['meta_desc' => "Uncover the message behind your lived experience and communicate with greater clarity, confidence, and emotional truth with The Speaker path.", 'og_image' => 'the-speaker1.webp'],
            'the-vault'           => ['meta_desc' => "Join Joanna live in The Vault — a free conversation space for women exploring voice, visibility, leadership, and emotional truth.", 'og_image' => 'vault-hero-joanna.webp'],
            'tell-your-story'    => ['meta_desc' => "Tell Your Story is the transformational course + retreat experience inside the True Influence Method. Created for leaders ready to reconnect with the story behind their influence.", 'og_image' => 'tell-your-story-hero-bg.webp'],
        ];

        foreach ($pages as $slug => $data) {
            $page_id = $this->get_page_id($slug);
            if (! $page_id) {
                continue;
            }

            $this->update_acf_field('seo_meta_description', $data['meta_desc'], $page_id, $force);
            $this->update_acf_field('seo_robots', '', $page_id, $force);

            $img_id = $this->upload_image($data['og_image']);
            if ($img_id) {
                // Pass attachment ID directly, consistent with all other image field seeding in this class.
                // ACF resolves ID → URL internally based on the field's return_format setting.
                $this->update_acf_field('seo_og_image', $img_id, $page_id, $force);
            }

            WP_CLI::line("Seeded SEO fields for: {$slug}");
        }
    }

    private function seed_blog_posts($force = false)
    {
        $category_name = 'Leadership & Influence';
        $category = get_term_by('name', $category_name, 'category');
        if (! $category) {
            $result = wp_insert_term($category_name, 'category', ['slug' => sanitize_title($category_name)]);
            if (is_wp_error($result)) {
                WP_CLI::warning('Failed to create category "Leadership & Influence": ' . $result->get_error_message());
                return;
            }
            $category = get_term($result['term_id'], 'category');
        }
        $category_id = $category->term_id;

        $posts = [
            [
                'title'   => 'Why Emotional Truth Matters More Than Strategic Communication',
                'slug'    => 'emotional-truth-strategic-communication',
                'excerpt' => 'Most leaders over-explain. The ones people remember have learned that trust is built not through information, but through emotional truth.',
                'content' => "In leadership, we're taught to communicate clearly, concisely, and strategically. We learn frameworks for messaging, structures for presentations, and formulas for persuasion.\n\nBut the leaders who actually move rooms — the ones people remember years later — have discovered something counterintuitive: emotional truth matters more than strategic communication.\n\n**What is emotional truth?**\n\nIt's the willingness to say what's actually true underneath the polished message. It's the moment a leader stops explaining and starts being real about what they've learned, what they've lost, and what they're still figuring out.\n\n**Why it works**\n\nTrust isn't built through information. Trust is built through congruence — when what someone says matches what we sense is true about them. When a leader shares something vulnerable, the brain registers safety. And in safety, people open up, engage, and commit.\n\n**Three ways to lead with emotional truth:**\n\n1. Name the tension. Before presenting a solution, acknowledge the real struggle.\n2. Share your own learning edge. Admit what you're still figuring out.\n3. Speak from experience, not theory. Replace abstract concepts with lived moments.\n\nThe next time you prepare to speak, ask yourself: Am I trying to sound impressive — or am I trying to be real? The answer will determine whether your audience merely listens or is truly moved.",
            ],
            [
                'title'   => 'The Hidden Connection Between Storytelling and Leadership Presence',
                'slug'    => 'storytelling-leadership-presence',
                'excerpt' => 'True leadership presence isn\'t about commanding attention — it\'s about creating connection. And the most powerful tool for connection is your story.',
                'content' => "Leadership presence is one of those qualities we recognize instantly but struggle to define. We know it when we see it — that quality some leaders have that makes people lean in, listen deeply, and feel inspired.\n\nBut what if presence isn't about confidence, charisma, or commanding attention? What if true presence comes from something far more accessible: the ability to tell your story in a way that creates connection?\n\n**Presence is connection, not performance**\n\nWhen we try to perform presence — deepening our voice, slowing our pace, adopting power poses — we often come across as rehearsed rather than real. But when we share a genuine story, something shifts. Our body relaxes. Our voice finds its natural rhythm. And the audience stops evaluating and starts experiencing.\n\n**Why storytelling creates presence:**\n\nStories activate the entire brain. When you share a personal experience, listeners don't just hear your words — they feel your emotions, imagine the scenes, and unconsciously mirror your physiological state. This creates a shared experience, and shared experience creates presence.\n\n**The story that builds presence:**\n\nThe most presence-building story you can tell is the one about your defining moment — the experience that shaped your leadership, your values, or your understanding of your work. It doesn't have to be dramatic. It just has to be true.\n\nThe next time you need to lead a room, don't prepare more slides. Prepare to share one real moment from your journey. That's where your presence lives.",
            ],
            [
                'title'   => 'From Over-Explaining to Landing: Finding Your Core Message',
                'slug'    => 'over-explaining-core-message',
                'excerpt' => 'If you find yourself explaining too much, it\'s not because your idea is complex — it\'s because you haven\'t found the core yet. Here\'s how to find it.',
                'content' => "Do you ever finish a conversation thinking: \"That's not what I meant to say\"?\n\nYou're not alone. One of the most common challenges leaders face is the tendency to over-explain. We add context, background, caveats, and qualifiers — trying to be so clear that we end up muddying our message entirely.\n\n**The paradox of over-explaining**\n\nThe harder we try to be clear, the less clear we become. Why? Because over-explaining is usually a sign that we haven't yet found the core of our message. We're still searching for it — out loud, in front of our audience.\n\n**The core message test**\n\nA core message passes three tests:\n\n1. **The grandma test** — Can you say it in one sentence your grandmother would understand?\n2. **The repeat test** — Can someone else repeat your message without adding their own interpretation?\n3. **The feeling test** — Does saying it actually feel true in your body?\n\n**How to find your core:**\n\nStart by asking yourself: If my audience remembers only one thing from our conversation, what must it be? Write that down. Then cross out every word that isn't essential. Keep going until you can't remove anything else without losing the meaning.\n\nThat's your core message.\n\n**Practice landing, not explaining**\n\nInstead of leading with context, lead with your core. Say your one sentence first. Then, if needed, add context. This forces you to land before you explain — and your audience will thank you for it.",
            ],
        ];

        foreach ($posts as $p) {
            $existing = get_posts([
                'name'           => $p['slug'],
                'post_type'      => 'post',
                'posts_per_page' => 1,
                'fields'         => 'ids',
            ]);

            if (! empty($existing) && ! $force) {
                continue;
            }

            $post_data = [
                'post_title'    => $p['title'],
                'post_name'     => $p['slug'],
                'post_excerpt'  => $p['excerpt'],
                'post_content'  => $p['content'],
                'post_status'   => 'publish',
                'post_type'     => 'post',
                'post_category' => [$category_id],
            ];

            if (! empty($existing)) {
                $post_data['ID'] = $existing[0];
            }

            $post_id = wp_insert_post($post_data);

            if (is_wp_error($post_id)) {
                WP_CLI::warning("Failed to seed blog post '{$p['title']}': " . $post_id->get_error_message());
                continue;
            }

            WP_CLI::line("Seeded blog post: {$p['title']}");
        }
    }

    public function seed_all($force = true)
    {
        $this->cleanup_media();

        // Clear ACF caches to ensure fresh reads
        if (function_exists('acf_get_store')) {
            $store = acf_get_store('fields');
            if ($store) $store->reset();
            $store = acf_get_store('field-groups');
            if ($store) $store->reset();
        }

        $this->create_menus();
        $this->ensure_pages_exist();

        $page_slugs = [
            'front-page', 'about', '4-session', 'be-remembered',
            'breakthrough-session', 'build-my-team', 'events',
            'get-started', 'inquiry', 'master-my-message',
            'million-dollar-message', 'offers', 'on-stage',
            'speaker-cohort', 'success-stories', 'thank-you',
            'the-authority', 'the-legacy', 'the-speaker', 'the-vault',
            'tell-your-story',
        ];

        foreach ($page_slugs as $slug) {
            $slug = trim($slug);
            $method = 'seed_' . str_replace('-', '_', $slug);
            if (method_exists($this, $method)) {
                $this->$method($force);
            }
        }

        $this->seed_seo($force);
        $this->seed_blog_posts($force);
    }

    private function ensure_pages_exist()
    {
        $pages = [
            ['slug' => 'front-page',              'title' => 'Home',                'template' => 'Front Page'],
            ['slug' => 'about',                   'title' => 'About',               'template' => 'About'],
            ['slug' => '4-session',               'title' => '4-Session Training',  'template' => '4-Session Training Package'],
            ['slug' => 'be-remembered',            'title' => 'Be Remembered',        'template' => 'Be Remembered'],
            ['slug' => 'breakthrough-session',     'title' => 'Breakthrough Session', 'template' => 'Breakthrough Session'],
            ['slug' => 'build-my-team',            'title' => 'Build My Team',        'template' => 'Build My Team'],
            ['slug' => 'events',                  'title' => 'Events & Workshops',  'template' => 'Events and Workshops'],
            ['slug' => 'get-started',              'title' => 'Get Started',          'template' => 'Get Started'],
            ['slug' => 'inquiry',                 'title' => 'Inquiry',             'template' => 'Inquiry'],
            ['slug' => 'master-my-message',        'title' => 'Master My Message',    'template' => 'Master My Message'],
            ['slug' => 'million-dollar-message',   'title' => 'Million Dollar Message', 'template' => 'Million Dollar Message'],
            ['slug' => 'offers',                  'title' => 'Offers',              'template' => 'Offers'],
            ['slug' => 'on-stage',                'title' => 'On Stage',            'template' => 'On Stage'],
            ['slug' => 'speaker-cohort',           'title' => 'Speaker Cohort',       'template' => 'Speaker Cohort'],
            ['slug' => 'success-stories',          'title' => 'Success Stories',      'template' => 'Success Stories'],
            ['slug' => 'thank-you',               'title' => 'Thank You',           'template' => 'Thank You'],
            ['slug' => 'the-authority',            'title' => 'The Authority',        'template' => 'The Authority'],
            ['slug' => 'the-legacy',              'title' => 'The Legacy',          'template' => 'The Legacy'],
            ['slug' => 'the-speaker',             'title' => 'The Speaker',         'template' => 'The Speaker'],
            ['slug' => 'the-vault',               'title' => 'The Vault',           'template' => 'The Vault'],
            ['slug' => 'tell-your-story',         'title' => 'Tell Your Story',     'template' => 'Tell Your Story'],
        ];

        foreach ($pages as $p) {
            $existing = get_posts([
                'name'             => $p['slug'],
                'post_type'        => 'page',
                'posts_per_page'   => 1,
                'fields'           => 'ids',
                'post_status'      => 'any',
            ]);

            if (! empty($existing)) {
                continue;
            }

            $page_id = wp_insert_post([
                'post_title'    => $p['title'],
                'post_name'     => $p['slug'],
                'post_type'     => 'page',
                'post_status'   => 'publish',
                'page_template' => $p['slug'] === 'front-page' ? '' : 'page-' . $p['slug'] . '.php',
            ]);

            if ($p['slug'] === 'front-page') {
                update_option('page_on_front', $page_id);
                update_option('show_on_front', 'page');
            }

            WP_CLI::line("Created page: {$p['title']} ({$p['slug']})");
        }
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

        if (! empty($assoc_args['page'])) {
            $page_slugs = explode(',', $assoc_args['page']);
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
        } else {
            $this->seed_all($force);
            // Clear ACF caches so get_field() returns fresh data
            if (function_exists('acf_get_store')) {
                $store = acf_get_store('fields');
                if ($store) $store->reset();
                $store = acf_get_store('field-groups');
                if ($store) $store->reset();
            }
            WP_CLI::success('All pages seeded.');
        }
    }

    private function create_menus()
    {
        $this->create_menu('Header Navigation', 'header', [
            ['title' => 'About', 'url' => home_url('/about/')],
            ['title' => 'Work with me', 'url' => home_url('/offers/')],
            ['title' => 'All Offers', 'url' => home_url('/offers/'), 'parent' => 'Work with me'],
            ['title' => 'The Vault', 'url' => home_url('/the-vault/'), 'parent' => 'Work with me'],
            ['title' => 'Your Million Dollar Message', 'url' => home_url('/million-dollar-message/'), 'parent' => 'Work with me'],
            ['title' => 'Breakthrough Session', 'url' => home_url('/breakthrough-session/'), 'parent' => 'Work with me'],
            ['title' => '4-Session Training Package', 'url' => home_url('/4-session/'), 'parent' => 'Work with me'],
            ['title' => 'Master My Message', 'url' => home_url('/master-my-message/'), 'parent' => 'Work with me'],
            ['title' => 'Build My Team', 'url' => home_url('/build-my-team/'), 'parent' => 'Work with me'],
            ['title' => 'Be Remembered', 'url' => home_url('/be-remembered/'), 'parent' => 'Work with me'],
            ['title' => 'Tell Your Story', 'url' => home_url('/tell-your-story'), 'parent' => 'Work with me'],
            ['title' => 'Move the Room', 'url' => home_url('/speaker-cohort/'), 'parent' => 'Work with me'],
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
        $this->update_acf_field('section_hero_btn_primary_url', '/tell-your-story/', $page_id, $force);
        $this->update_acf_field('section_hero_btn_secondary_text', 'Watch Joanna Speak', $page_id, $force);
        $this->update_acf_field('section_hero_btn_secondary_url', '/on-stage/', $page_id, $force);

        $this->update_acf_field('section_trusted_heading', 'Trusted by<br>leaders worldwide', $page_id, $force);
        $this->update_acf_field('section_trusted_stats', [
            ['item_icon' => $this->upload_svg('UsersThree'), 'item_value' => '10,000+', 'item_label' => 'Leaders Transformed'],
            ['item_icon' => $this->upload_svg('SealCheck'), 'item_value' => '30+', 'item_label' => 'Years of Work'],
        ], $page_id, $force);

        $this->update_acf_field('section_you_know_heading', 'You Know What You <em class="text-gold">Mean</em>', $page_id, $force);
        $this->update_acf_field('section_you_know_bg_image', $this->upload_image('joanna-bg-mean.webp'), $page_id, $force);
        $this->update_acf_field('section_you_know_profile_image', $this->upload_image('joanna-bg-mean-her.webp'), $page_id, $force);
        $this->update_acf_field('section_you_know_text', 'But when it\'s time to speak… <br><br>You over-explain. You soften your truth. You lose the part people were supposed to feel.<br><br>Because the words were never the problem.<br><br>The disconnect came long before the conversation did.', $page_id, $force);

        $this->update_acf_field('section_tell_story_heading', 'Your Story <em class="text-gold italic">Changes</em> Rooms.', $page_id, $force);
        $this->update_acf_field('section_tell_story_text', 'Tell Your Story is a transformational course and retreat experience where becoming a better speaker starts becoming a better leader.

It\'s about reconnecting with the moments that shaped your voice, your leadership, and the way people experience you.', $page_id, $force);
        $this->update_acf_field('section_tell_story_image', $this->upload_image('tell-story-1.webp'), $page_id, $force);
        $this->update_acf_field('section_tell_story_btn_text', 'START YOUR STORY', $page_id, $force);
        $this->update_acf_field('section_tell_story_btn_url', '/tell-your-story/', $page_id, $force);

        $this->update_acf_field('section_discover_heading', 'Discover the Message <em class="text-gold italic">Hidden</em> Inside Your Story.', $page_id, $force);
        $this->update_acf_field('section_discover_text', 'A guided experience to help you uncover the truth, perspective, and story behind your influence.', $page_id, $force);
        $this->update_acf_field('section_discover_image', $this->upload_image('discover.webp'), $page_id, $force);
        $this->update_acf_field('section_discover_btn_text', 'Explore the $29 MILLION DOLLAR Experience', $page_id, $force);
        $this->update_acf_field('section_discover_btn_url', '/million-dollar-message/', $page_id, $force);

        $this->update_acf_field('section_journey_heading', 'The <em class="text-gold italic">Journey</em>', $page_id, $force);
        $this->update_acf_field('section_journey_items', [
            ['item_icon' => $this->upload_image('phase1.webp'), 'item_heading' => 'Tell Your Story', 'item_text' => 'Your story becomes the foundation of your influence.', 'item_url' => home_url('/events/')],
            ['item_icon' => $this->upload_image('phase2.webp'), 'item_heading' => 'Move the Room', 'item_text' => 'Your message becomes clear, structured, and emotionally powerful.', 'item_url' => home_url('/speaker-cohort/')],
            ['item_icon' => $this->upload_image('phase3.webp'), 'item_heading' => 'Become Known', 'item_text' => 'Become known for a message people remember and repeat.', 'item_url' => home_url('/million-dollar-message/')],
            ['item_icon' => $this->upload_image('phase4.webp'), 'item_heading' => 'Build Leaders', 'item_text' => 'Turn your message into leadership culture and scalable influence.', 'item_url' => home_url('/build-my-team/')],
            ['item_icon' => $this->upload_image('phase5.webp'), 'item_heading' => 'Be Remembered', 'item_text' => 'Build a legacy designed to outlive you.', 'item_url' => home_url('/be-remembered/')],
        ], $page_id, $force);

        $this->update_acf_field('section_speaker_heading', '<em class="text-gold italic">Move</em> the Room.', $page_id, $force);
        $this->update_acf_field('section_speaker_text', 'Speaker Cohort is Joanna\'s advanced speaking experience for leaders ready to communicate with clarity, emotional authority, and presence that moves people to action.', $page_id, $force);
        $this->update_acf_field('section_speaker_image', $this->upload_image('joana-speaker.webp'), $page_id, $force);
        $this->update_acf_field('section_speaker_bg_image', $this->upload_image('speaker-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_speaker_watermark_image', $this->upload_image('speaker-cohort.webp'), $page_id, $force);
        $this->update_acf_field('section_speaker_btn_text', 'Explore Speaker Cohort', $page_id, $force);
        $this->update_acf_field('section_speaker_btn_url', '/speaker-cohort/', $page_id, $force);

        $this->update_acf_field('section_vault_heading', 'Stay Inside the <span class="text-gold-section italic font-semibold">Conversation.</span>', $page_id, $force);
        $this->update_acf_field('section_vault_text', 'Inside The Vault, Joanna shares live reflections, speaking insights, leadership conversations, and the moments still unfolding behind the work.', $page_id, $force);
        $this->update_acf_field('section_vault_image', $this->upload_image('the-vault-bg.webp'), $page_id, $force);
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
        $this->update_acf_field('section_voice_text', 'It carries your story. Your leadership. The life that shaped you.', $page_id, $force);
        $this->update_acf_field('section_voice_image', $this->upload_image('voice-bg.webp'), $page_id, $force);
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
        $this->update_acf_field('section_leader_text', '<p>People do not follow information alone. They follow truth they can feel.</p><p>The True Influence Method&trade; was created to help leaders reconnect with the experiences that shaped the way they lead, speak, and move people.</p>', $page_id, $force);
        $this->update_acf_field('section_leader_image', $this->upload_image('about-frame2.webp'), $page_id, $force);
        $this->update_acf_field('section_leader_gallery', [
            $this->upload_image('tell-story-1.webp'),
            $this->upload_image('tell-story-2.webp'),
            $this->upload_image('tell-story-3.webp'),
            $this->upload_image('tell-story-4.webp'),
        ], $page_id, $force);

        $this->update_acf_field('section_meaning_heading', "Long Before the Stages, There Was the Search for <em class=\"text-gold italic\">Meaning.</em>", $page_id, $force);
        $this->update_acf_field('section_meaning_text', '<p>Joanna&#8217;s journey began with public speaking at 13 and entrepreneurship at 20, eventually expanding into acting, education, nonprofit leadership, international schools, and transformational coaching.</p><p>Today, she works with thought leaders, founders, public figures, and high-performing women navigating leadership, visibility, emotional clarity, and conscious success.</p>', $page_id, $force);
        $this->update_acf_field('section_meaning_gallery', [
            $this->upload_image('tell-story-1.webp'),
            $this->upload_image('tell-story-2.webp'),
            $this->upload_image('tell-story-3.webp'),
            $this->upload_image('tell-story-4.webp'),
            $this->upload_image('tell-story-1.webp'),
            $this->upload_image('tell-story-2.webp'),
            $this->upload_image('tell-story-3.webp'),
            $this->upload_image('tell-story-4.webp'),
        ], $page_id, $force);

        $this->update_acf_field('section_life_heading', "A <em class=\"text-gold italic\">Life</em> Built Across Leadership<br>and Transformation.", $page_id, $force);
        $this->update_acf_field('section_life_text', '<ul><li>Master&#8217;s in Education &#8211; Harvard University</li><li>Advanced studies in Sustainable Investing &#8211; Harvard Business School</li><li>Six-time founder</li><li>Founded nonprofit and international school in Costa Rica</li><li>President of the National Association of Women Business Owners in Phoenix</li></ul>', $page_id, $force);

        $this->update_acf_field('section_reconnect_heading', "Joanna <span class=\"italic text-gold\">Help</span> Leaders Reconnect With What People Can Actually Feel.", $page_id, $force);
        $this->update_acf_field('section_reconnect_text', 'Through retreats, transformational speaking experiences, leadership conversations, and private advisory work, she helps people uncover the story behind their influence and communicate it with clarity, courage, and emotional truth.', $page_id, $force);
        $this->update_acf_field('section_reconnect_btn_text', 'Work With Joanna', $page_id, $force);
        $this->update_acf_field('section_reconnect_btn_url', '/inquiry/', $page_id, $force);

        $this->update_acf_field('section_voice_heading', "Your Voice Carries More Than <em class=\"text-warm-beige italic\">Information.</em>", $page_id, $force);
        $this->update_acf_field('section_voice_text', 'It carries your story. Your leadership.<br>The life that shaped you.', $page_id, $force);
        $this->update_acf_field('section_voice_bg_image', $this->upload_image('voice-bg.webp'), $page_id, $force);
    }

    private function seed_4_session($force = false)
    {
        $page_id = $this->get_page_id('4-session');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Build the Message<br><em class="text-gold italic">From the Inside Out.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'The 4-Session Training Package is a private experience for leaders ready to uncover, refine, and clearly articulate the message behind their work. Together, you move beyond explaining and begin building a message that feels true, clear, and aligned.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('service-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('joanna-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You <em class="text-gold italic">Leave</em> With', $page_id, $force);
        $this->update_acf_field('section_build_items', [
            ['item_heading' => 'Your defining moment'],
            ['item_heading' => 'A clearer understanding of what shaped your work'],
            ['item_heading' => 'Your deeper why'],
            ['item_heading' => 'A message you can actually say out loud'],
            ['item_heading' => 'Greater clarity around your leadership and differentiator'],
        ], $page_id, $force);
        $this->update_acf_field('section_distinct_heading', 'Private Work.<br><em class="text-gold italic">Real Refinement.</em>', $page_id, $force);
        $this->update_acf_field('section_distinct_items', [
            ['item_heading' => 'Personalized Curriculum', 'item_text' => 'Every session is tailored to your specific voice, message, and leadership context.'],
            ['item_heading' => 'Real-Time Feedback', 'item_text' => 'Receive immediate, actionable feedback on your delivery, presence, and messaging.'],
            ['item_heading' => 'Proven Framework', 'item_text' => "The True Influence Method\u2122 framework has transformed thousands of leaders worldwide."],
            ['item_heading' => 'Lasting Impact', 'item_text' => 'Walk away with skills and self-awareness that compound over time.'],
        ], $page_id, $force);
        $this->update_acf_field('section_distinct_image', $this->upload_image('4-session.webp'), $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Clarity Changes <em class="text-gold italic">How You Lead.</em>', $page_id, $force);
        $this->update_acf_field('section_cta_text', '<p><span class="font-flatline font-semibold text-5xl md:text-6xl text-gold-section italic">$8,000</span></p><p class="font-garet text-base text-navy">4 Private Sessions</p>', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'BOOK PRIVATE TRAINING', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', 'https://go.trueinfluencemethod.com/4-session-training-package', $page_id, $force);
        $this->update_acf_field('section_cta_bg_image', $this->upload_image('cta-bg.webp'), $page_id, $force);
    }

    private function seed_be_remembered($force = false)
    {
        $page_id = $this->get_page_id('be-remembered');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Build a Legacy.<br><em class="text-gold italic">Not Just a Career.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Be Remembered is Joanna&rsquo;s private legacy experience for founders and executives ready to build work, wealth, and influence designed to outlast them. This is where your impact becomes a framework others can continue through.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('service-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('be-remembered-1.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'Your Work Has Impact.<br>Your <em class="text-gold italic">Legacy</em> Doesn&rsquo;t Have a Framework.', $page_id, $force);
        $this->update_acf_field('section_message_text', '<p>You&#8217;ve built a meaningful career but:</p><ul><li>your influence feels tied only to your presence</li><li>succession planning has never been formalized</li><li>your work, voice, and wealth are not yet aligned</li><li>there is no clear structure for what you&#8217;ll leave behind</li></ul><p>You don&#8217;t need more success.</p><p>You need a legacy blueprint others can carry forward.</p>', $page_id, $force);
        $this->update_acf_field('section_message_image', $this->upload_image('be-remembered-1.webp'), $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You <em class="text-gold italic">Build</em>', $page_id, $force);
        $this->update_acf_field('section_build_items', [
            ['item_heading' => 'A clear legacy blueprint'],
            ['item_heading' => 'A defined impact thesis'],
            ['item_heading' => 'A succession and continuity plan'],
            ['item_heading' => 'A long-term voice and visibility strategy'],
            ['item_heading' => 'Wealth and contribution aligned to your mission'],
            ['item_heading' => 'A framework that outlives your direct involvement'],
        ], $page_id, $force);
        $this->update_acf_field('section_build_btn_text', 'BUILD MY LEGACY', $page_id, $force);
        $this->update_acf_field('section_build_btn_url', '/inquiry/', $page_id, $force);
        $this->update_acf_field('section_distinct_heading', 'A Legacy That Outlives <em class="text-gold italic">You.</em>', $page_id, $force);
        $this->update_acf_field('section_distinct_items', [
            ['item_heading' => 'Vision Architecture', 'item_text' => 'Design a long-term vision that goes beyond your lifetime.'],
            ['item_heading' => 'Legacy Blueprint', 'item_text' => 'Build the systems and message that will carry your work forward.'],
            ['item_heading' => 'Influence Strategy', 'item_text' => 'Create influence that compounds across generations.'],
        ], $page_id, $force);
        $this->update_acf_field('section_distinct_image', $this->upload_image('be-remembered-2.webp'), $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Some Build a Career. <em class="text-gold italic">Others Build a Legacy.</em>', $page_id, $force);
        $this->update_acf_field('section_cta_text', '<p>Starts at</p><p>$1M</p><p>Private Legacy Advisory</p>', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'BOOK DISCOVERY CALL - FREE', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '#register', $page_id, $force);
        $this->update_acf_field('section_cta_bg_image', $this->upload_image('cta-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_form_heading', '<em class="text-gold italic">Begin</em> the Conversation.', $page_id, $force);
        $this->update_acf_field('section_form_text', '<p>A private conversation to explore your legacy, succession, voice, and the long-term impact you want your work to carry forward.</p>', $page_id, $force);
        $this->update_acf_field('section_form_bg_image', $this->upload_image('vault-registration-bg.webp'), $page_id, $force);
    }

    private function seed_breakthrough_session($force = false)
    {
        $page_id = $this->get_page_id('breakthrough-session');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'One Session<br><em class="text-gold italic">to See Clearly.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', '<p>You bring what you&rsquo;ve been trying to say.</p><p>Joanna helps uncover what&rsquo;s actually true underneath it.</p><p>A private breakthrough session for leaders ready to stop circling the message and finally say what matters most.</p>', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('service-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('breakthrough-1.webp'), $page_id, $force);
        $this->update_acf_field('section_message_image', $this->upload_image('breakthrough-1.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'You Already Know<br>Something <em class="text-gold italic">Feels Off.</em>', $page_id, $force);
        $this->update_acf_field('section_message_text', '<ul class="mt-8 space-y-1"><li class="flex items-start gap-3 font-garet text-lg text-dark-text leading-[1.5]"><svg class="w-4 h-4 flex-shrink-0 mt-2 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/></svg>You&rsquo;ve tried to explain it more clearly.</li><li class="flex items-start gap-3 font-garet text-lg text-dark-text leading-[1.5]"><svg class="w-4 h-4 flex-shrink-0 mt-2 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/></svg>You&rsquo;ve tried refining the strategy.</li><li class="flex items-start gap-3 font-garet text-lg text-dark-text leading-[1.5]"><svg class="w-4 h-4 flex-shrink-0 mt-2 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/></svg>You&rsquo;ve tried finding better words.</li></ul><p class="mt-8 font-garet text-lg text-dark-text leading-[1.5] max-w-[480px]">But underneath it, you still feel disconnected from what you actually want to say.<br><br>This session is designed to help you stop performing clarity and reconnect with what is actually true.</p>', $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You <em class="text-gold italic">Leave</em> With', $page_id, $force);
        $this->update_acf_field('section_build_text', '<p>Sometimes the breakthrough is not learning something new. It&#8217;s finally seeing clearly what was already there.</p>', $page_id, $force);
        $this->update_acf_field('section_build_btn_text', 'BOOK A SESSION', $page_id, $force);
        $this->update_acf_field('section_build_btn_url', 'https://go.trueinfluencemethod.com/breakthrough-session', $page_id, $force);
        $this->update_acf_field('section_build_items', [
            ['item_heading' => 'Clear direction on your message'],
            ['item_heading' => 'Greater emotional clarity and confidence'],
            ['item_heading' => 'A sharper articulation of what you do'],
            ['item_heading' => 'The next step that actually moves you forward'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_bg_image', $this->upload_image('cta-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'One Honest Conversation <em class="text-gold italic">Can Change Everything.</em>', $page_id, $force);
        $this->update_acf_field('section_cta_text', '<p>$2,000</p><p>Private Session</p>', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'BOOK A BREAKTHROUGH SESSION', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', 'https://go.trueinfluencemethod.com/breakthrough-session', $page_id, $force);
    }

    private function seed_build_my_team($force = false)
    {
        $page_id = $this->get_page_id('build-my-team');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Build Leaders.<br><em class="text-gold italic">Not Just Results.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Build My Team is Joanna&rsquo;s private leadership experience for founders and executives ready to scale trust, communication, and leadership across an entire organization. This is where your message becomes a system others can lead through.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('service-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('build-my-team1.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'Your Business<br>Has Grown. Your <em class="text-gold italic">Leadership</em> Hasn&rsquo;t.', $page_id, $force);
        $this->update_acf_field('section_message_text', '<p>You&#8217;ve built real success but internally:</p><ul><li>communication becomes inconsistent</li><li>leadership depends too heavily on you</li><li>trust weakens as teams scale</li><li>culture becomes harder to sustain</li></ul><p>You don&#8217;t need more management.</p><p>You need a leadership framework people can actually operate through.</p>', $page_id, $force);
        $this->update_acf_field('section_message_image', $this->upload_image('build-my-team1.webp'), $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You <em class="text-gold italic">Build</em>', $page_id, $force);
        $this->update_acf_field('section_build_text', '<p>You create psychological safety and trust inside your team and a repeatable system others can lead through.</p>', $page_id, $force);
        $this->update_acf_field('section_build_btn_text', 'SCALE MY BUSINESS', $page_id, $force);
        $this->update_acf_field('section_build_btn_url', '/inquiry/', $page_id, $force);
        $this->update_acf_field('section_build_items', [
            ['item_heading' => 'A leadership framework rooted in trust and clarity'],
            ['item_heading' => 'A scalable mentorship structure'],
            ['item_heading' => 'A repeatable leadership philosophy'],
            ['item_heading' => 'A culture people can lead through consistently'],
            ['item_heading' => 'Aligned communication across the organization'],
            ['item_heading' => 'A leadership system that doesn\'t depend on you alone'],
        ], $page_id, $force);
        $this->update_acf_field('section_distinct_heading', 'Leadership That Scales <em class="text-gold italic">Beyond You.</em>', $page_id, $force);
        $this->update_acf_field('section_distinct_items', [
            ['item_heading' => 'Enterprise Framework', 'item_text' => 'Proven methodology adapted for organizational scale.'],
            ['item_heading' => 'Leadership Alignment', 'item_text' => 'Get your entire leadership team communicating with one voice.'],
            ['item_heading' => 'Cultural Transformation', 'item_text' => 'Build a culture of authentic communication from the inside out.'],
        ], $page_id, $force);
        $this->update_acf_field('section_distinct_image', $this->upload_image('build-my-team2.webp'), $page_id, $force);
        $this->update_acf_field('section_form_heading', '<em class="text-gold italic">Begin</em> the Conversation.', $page_id, $force);
        $this->update_acf_field('section_form_text', '<p>A private conversation to explore your leadership, organization, and the next stage of growth for your team and business.</p>', $page_id, $force);
        $this->update_acf_field('section_form_bg_image', $this->upload_image('vault-registration-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Strong Organizations <em class="text-gold italic">Are Built Through Trust.</em>', $page_id, $force);
        $this->update_acf_field('section_cta_text', '<p>Starting at</p><p>$250,000</p><p>Private Leadership Advisory</p>', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'BOOK DISCOVERY CALL - FREE', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/inquiry/', $page_id, $force);
        $this->update_acf_field('section_cta_bg_image', $this->upload_image('cta-bg.webp'), $page_id, $force);
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
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('joanna-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_retreat_heading', '<span class="text-navy">Tell Your Story</span><br><em class="text-gold italic">Course &amp; Retreat</em>', $page_id, $force);
        $this->update_acf_field('section_retreat_text', '<p>A transformational storytelling and leadership experience designed to help people reconnect with the moments that shaped their voice, influence, and emotional authority.</p><p>Through retreat immersion, live story work, emotional refinement, and transformational conversations, participants are guided deeper into the work behind authentic leadership.</p>', $page_id, $force);
        $this->update_acf_field('section_retreat_image', $this->upload_image('event-frame2-img1.webp'), $page_id, $force);
        $this->update_acf_field('section_retreat_image_2', $this->upload_image('events-frame2-img2.webp'), $page_id, $force);
        $this->update_acf_field('section_upcoming_heading', '<em class="text-gold italic">Upcoming</em> <span class="text-navy">Experiences</span>', $page_id, $force);
        $this->update_acf_field('section_upcoming_items', [
            [
                'item_date' => 'September 16-20, 2026',
                'item_title' => 'Speak & Rise + Retreat',
                'item_location' => 'Phoenix',
                'item_description' => 'A live speaking and storytelling experience centered around transformational voices, truth-telling, and leadership presence.',
                'item_image' => $this->upload_image('events-frame3-img1.webp'),
                'item_note' => 'This is a part of Tell Your Story and Move the Room',
            ],
            [
                'item_date' => 'December 1, 2026',
                'item_title' => 'Speaking On Stage Top Talent Hollywood',
                'item_location' => 'Phoenix',
                'item_description' => 'An immersive speaking experience designed to strengthen presence, authority, and audience connection.',
                'item_image' => $this->upload_image('events-frame3-img2.webp'),
                'item_note' => 'Want to book Joanna On Stage? Click <a href="' . home_url('/on-stage/') . '">here</a> to learn more.',
            ],
        ], $page_id, $force);
        $this->update_acf_field('section_features_bg_image', $this->upload_image('events-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_features_heading', '<em class="text-gold italic">More</em> <span class="text-navy">Than Events.</span>', $page_id, $force);
        $this->update_acf_field('section_features_items', [
            ['item_icon' => $this->upload_svg('Heart'), 'item_heading' => 'Connection', 'item_text' => 'Conversations that stay with you.'],
            ['item_icon' => $this->upload_svg('BookOpen'), 'item_heading' => 'Reflection', 'item_text' => "Moments that reconnect you with what's true."],
            ['item_icon' => $this->upload_svg('Bolt'), 'item_heading' => 'Momentum', 'item_text' => 'Clarity that moves beyond the retreat.'],
            ['item_icon' => $this->upload_svg('Users'), 'item_heading' => 'Community', 'item_text' => 'A room full of leaders growing together.'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_bg_image', $this->upload_image('voice-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Not Sure Where to<br><em class="text-gold italic">Begin?</em>', $page_id, $force);
        $this->update_acf_field('section_cta_text', 'We\'ll help guide you toward the experience, retreat, or next step that feels most aligned with where you are right now.', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'Find Your Path', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/get-started/', $page_id, $force);
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
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('generic-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_cards', [
            [
                'tag' => 'THE SPEAKER',
                'title' => 'Find my Message.',
                'description' => "You know you have something to say — but you can't clearly articulate what defines you yet.",
                'quote' => '"I know there\'s something important here."',
                'button_text' => 'Start Here',
                'button_url' => home_url('/the-speaker/'),
            ],
            [
                'tag' => 'THE AUTHORITY',
                'title' => 'Build my Talk.',
                'description' => "You know your work — but your message loses energy when you explain it.",
                'quote' => '"I want my message to land."',
                'button_text' => 'Get the Framework',
                'button_url' => home_url('/the-authority/'),
            ],
            [
                'tag' => 'THE LEGACY',
                'title' => 'Define my Legacy.',
                'description' => "You've built something significant — but now you want to create work that outlives you.",
                'quote' => '"I want what I build to matter long-term."',
                'button_text' => 'Begin My Legacy Work',
                'button_url' => home_url('/the-legacy/'),
            ],
        ], $page_id, $force);
    }

    private function seed_inquiry($force = false)
    {
        $page_id = $this->get_page_id('inquiry');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Start the<br><em class="text-gold italic">Conversation.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_text', 'Tell us where you are, what you\'re exploring, or what feels most aligned right now.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('generic-bg.webp'), $page_id, $force);
    }

    private function seed_master_my_message($force = false)
    {
        $page_id = $this->get_page_id('master-my-message');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Become Known<br><em class="text-gold italic">for Something Specific.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Master My Message is Joanna&rsquo;s advanced authority-positioning experience designed for leaders ready to refine, elevate, and scale the message people remember them for. This is where your message becomes distinct, repeatable, and impossible to confuse with anyone else&rsquo;s.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('service-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('master1.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'Your Work is Strong.<br>Your <em class="text-gold italic">Positioning</em> Isn&rsquo;t.', $page_id, $force);
        $this->update_acf_field('section_message_text', '<p>You&#8217;ve built real experience but:</p><ul><li>people still don&#8217;t clearly understand what makes you different</li><li>your message sounds too similar to others in your space</li><li>your expertise isn&#8217;t translating into authority</li><li>your ideas are respected, but not remembered</li></ul><p>You don&#8217;t lack success.</p><p>You haven&#8217;t fully claimed your differentiator yet.</p>', $page_id, $force);
        $this->update_acf_field('section_message_image', $this->upload_image('master1.webp'), $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You <em class="text-gold italic">Build</em>', $page_id, $force);
        $this->update_acf_field('section_build_items', [
            ['item_heading' => 'A refined, repeatable signature message'],
            ['item_heading' => 'A message people remember and repeat'],
            ['item_heading' => 'Your thought leader perspective'],
            ['item_heading' => 'Clear audience positioning'],
            ['item_heading' => 'A keynote-level talk'],
            ['item_heading' => 'A defined point of view'],
        ], $page_id, $force);
        $this->update_acf_field('section_build_btn_text', 'CREATE MY KEYNOTE', $page_id, $force);
        $this->update_acf_field('section_build_btn_url', 'https://go.trueinfluencemethod.com/master-my-message', $page_id, $force);
        $this->update_acf_field('section_distinct_heading', 'This is Where Your <em class="font-normal">Message</em> Becomes <em class="text-gold italic">Distinct.</em>', $page_id, $force);
        $this->update_acf_field('section_distinct_image', $this->upload_image('master2.webp'), $page_id, $force);
        $this->update_acf_field('section_distinct_items', [
            ['item_heading' => 'Message Architecture', 'item_text' => 'Build a message framework that supports every communication you\u2019ll ever make.'],
            ['item_heading' => 'Authority Positioning', 'item_text' => 'Position yourself as the go-to authority in your space.'],
            ['item_heading' => 'Keynote Development', 'item_text' => 'Develop a keynote that opens doors and creates opportunities.'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Some People Have <em class="font-normal">Expertise</em>. <em class="text-gold italic">Others Become Known For it.</em>', $page_id, $force);
        $this->update_acf_field('section_cta_text', '<p>Starting at</p><p><span style="text-decoration: line-through;">$40,000</span> $25,000</p><p>Keynote, positioning, and leadership refinement</p>', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'CREATE MY KEYNOTE', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', 'https://go.trueinfluencemethod.com/master-my-message', $page_id, $force);
        $this->update_acf_field('section_cta_bg_image', $this->upload_image('cta-bg.webp'), $page_id, $force);
    }

    private function seed_million_dollar_message($force = false)
    {
        $page_id = $this->get_page_id('million-dollar-message');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Your Message<br>Already <em class="text-gold italic">Exists.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'You are closer to your message than you think.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('general-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('million-hero.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_btn_text', 'GET THE TRAINING — $29', $page_id, $force);
        $this->update_acf_field('section_hero_btn_url', 'https://go.trueinfluencemethod.com/million-dollar-purchase-checkout-page-7216', $page_id, $force);
        $this->update_acf_field('section_inside_heading', 'What&#8217;s <em class="text-gold italic">Inside</em>', $page_id, $force);
        $this->update_acf_field('section_inside_text', '<ul><li>A 7-minute training with Joanna</li><li>A Clear Message \u2013 what you say</li><li>A Clear Position \u2013 why people choose you</li><li>A Clear Voice \u2013 how you confidently show up and get remembered</li><li>The framework behind your defining message</li><li>A guided homework exercise to uncover it yourself</li><li>One message you can immediately use in: speaking, pitches, leadership, interviews, and conversations</li></ul>', $page_id, $force);
        $this->update_acf_field('section_inside_image', $this->upload_image('million-inside.webp'), $page_id, $force);
    }

    private function seed_offers($force = false)
    {
        $page_id = $this->get_page_id('offers');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', "Ways to Work<br>with Joanna.", $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'From transformational retreats and speaker development to private leadership work and live conversations, each experience inside the True Influence Method&trade; is designed to help leaders communicate with greater clarity, authority, and emotional truth.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('general-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('joanna-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_signature_heading', 'Signature <em class="text-gold italic">Offers</em>', $page_id, $force);
        $this->update_acf_field('section_signature_subtitle', 'The primary transformational experiences inside the True Influence Method&trade; — designed for different stages of leadership, visibility, authority, and long-term impact.', $page_id, $force);
        $this->update_acf_field('section_signature_items', [
            ['item_title' => 'Tell Your Story', 'item_description' => 'Reconnect with the defining moments behind your leadership, voice, and influence.', 'item_price_label' => '', 'item_price' => '$3,200', 'item_cta' => 'FIND MY MESSAGE', 'item_url' => home_url('/events/')],
            ['item_title' => 'Move the Room', 'item_description' => 'Build a signature talk and message people trust, remember, and follow.', 'item_price_label' => '', 'item_price' => '$12,000', 'item_cta' => 'TAKE THE STAGE', 'item_url' => home_url('/speaker-cohort/')],
            ['item_title' => 'Master My Message', 'item_description' => 'Refine your positioning, authority, and keynote-level message.', 'item_price_label' => 'Starts at', 'item_price' => '$25,000', 'item_cta' => 'CREATE MY KEYNOTE', 'item_url' => home_url('/master-my-message/')],
            ['item_title' => 'Build My Team', 'item_description' => 'Scale communication, trust, and leadership across your organization.', 'item_price_label' => 'Starts at', 'item_price' => '$250,000', 'item_cta' => 'SCALE MY BUSINESS', 'item_url' => home_url('/build-my-team/')],
            ['item_title' => 'Be Remembered', 'item_description' => 'Create work, leadership, and influence designed to outlast you.', 'item_price_label' => 'Starts at', 'item_price' => '$1M', 'item_cta' => 'SCALE MY BUSINESS', 'item_url' => home_url('/be-remembered/')],
        ], $page_id, $force);
        $this->update_acf_field('section_other_heading', 'Other Ways to<br>Work <em class="text-gold italic">Together</em>', $page_id, $force);
        $this->update_acf_field('section_other_items', [
            ['item_title' => 'The Vault', 'item_description' => 'Live conversations with Joanna around story, visibility, leadership, and emotional truth.', 'item_price' => 'FREE', 'item_cta' => 'RESERVE MY SEAT', 'item_url' => home_url('/the-vault/')],
            ['item_title' => 'Million Dollar Message', 'item_description' => 'A 7-minute training to uncover the defining message behind your work.', 'item_price' => '$29', 'item_cta' => 'GET THE TRAINING', 'item_url' => home_url('/million-dollar-message/')],
            ['item_title' => '4-Session Training Package', 'item_description' => 'Private message refinement and leadership clarity across four sessions.', 'item_price' => '$8,000', 'item_cta' => 'BOOK PRIVATE TRAINING', 'item_url' => home_url('/4-session/')],
            ['item_title' => 'Breakthrough Session', 'item_description' => 'One focused session designed to create immediate clarity and direction.', 'item_price' => '$2,000', 'item_cta' => 'BOOK A BREAKTHROUGH SESSION', 'item_url' => home_url('t/breakthrough-session/')],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Not Sure Where<br>to <em class="text-gold italic">Begin?</em>', $page_id, $force);
        $this->update_acf_field('section_cta_text', 'We\'ll help guide you toward the experience, retreat, or next step that feels most aligned with where you are right now.', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'Find Your Path', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', '/get-started/', $page_id, $force);
        $this->update_acf_field('section_cta_bg_image', $this->upload_image('voice-bg.webp'), $page_id, $force);
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
            ['item_icon' => $this->upload_svg('UsersThree'), 'item_value' => '150+', 'item_label' => 'Stages Worldwide'],
            ['item_icon' => $this->upload_svg('SealCheck'), 'item_value' => '12', 'item_label' => 'Countries'],
        ], $page_id, $force);
        $this->update_acf_field('section_video_heading', 'Two Minutes of Her in a <em class="text-gold italic">Room.</em>', $page_id, $force);
        $this->update_acf_field('section_video_video_url', 'https://www.youtube.com/watch?v=06QKEonomv0', $page_id, $force);
        $this->update_acf_field('section_video_text', "A glimpse into Joanna's presence, storytelling, and emotional leadership in live speaking environments.", $page_id, $force);
        $this->update_acf_field('section_credibility_heading', '<em class="text-gold italic">Where</em> She\'s Been.', $page_id, $force);
        $this->update_acf_field('section_credibility_featured', [
            ['item_image' => $this->upload_image('forbes.webp'), 'item_badge' => 'KEYNOTE', 'item_title' => "Forbes -\nWhy Fostering Belonging Is Key For Supporting Women Investors", 'item_date' => 'March 2026'],
            ['item_image' => $this->upload_image('forbes2.webp'), 'item_badge' => 'KEYNOTE', 'item_title' => "Harvard Alumni -\nAnnual Harvard Alumni for Global Women&#8217;s Empowerment", 'item_date' => 'Apr 2026'],
            ['item_image' => $this->upload_image('forbes3.webp'), 'item_badge' => 'PANEL', 'item_title' => "WILDx -\nThe WILDx Experience: A stage for truth and transformation", 'item_date' => 'Dec 2025'],
        ], $page_id, $force);
        $this->update_acf_field('section_credibility_items', [
            ['item_badge' => 'PODCAST', 'item_heading' => 'Makers Bar Interview — Social Entrepreneur Thought Leader', 'item_date' => '2025'],
            ['item_badge' => 'KEYNOTE', 'item_heading' => 'Speak & Rise: Women Speakers Leading From The Stage', 'item_date' => 'Jan 2026'],
            ['item_badge' => 'PANEL', 'item_heading' => 'Speak & Rise: Executive Leading from the Stage', 'item_date' => 'Feb 2026'],
            ['item_badge' => 'KEYNOTE', 'item_heading' => 'Annual Harvard Alumni for Global Women\'s Empowerment', 'item_date' => 'Apr 2026'],
            ['item_badge' => 'PODCAST', 'item_heading' => 'Women in Global Leadership Podcast', 'item_date' => 'Nov 2025'],
            ['item_badge' => 'KEYNOTE', 'item_heading' => 'GCU Investment Club Keynote', 'item_date' => 'Jan 2026'],
            ['item_badge' => 'KEYNOTE', 'item_heading' => 'Top Talent Hollywood Keynote', 'item_date' => 'May 2026'],
            ['item_badge' => 'KEYNOTE', 'item_heading' => 'The WILDx Experience — Stage for Truth & Transformation', 'item_date' => 'Dec 2025'],
            ['item_badge' => 'KEYNOTE', 'item_heading' => 'President of NAWBO Phoenix', 'item_date' => '2025'],
            ['item_badge' => 'KEYNOTE', 'item_heading' => 'She Means Business Magazine Feature', 'item_date' => 'Jan 2026'],
            ['item_badge' => 'KEYNOTE', 'item_heading' => 'Phoenix Business Journal\'s Mentoring Monday', 'item_date' => 'Feb 2026'],
            ['item_badge' => 'KEYNOTE', 'item_heading' => '2nd Annual Scale Up Symposium', 'item_date' => 'Apr 2026'],
        ], $page_id, $force);
        $this->update_acf_field('section_experiences_heading', '<em class="text-gold italic">Conversations</em> That Stay With People.', $page_id, $force);
        $this->update_acf_field('section_experiences_subtitle', 'Three experiences, three formats — each designed to move a room differently.', $page_id, $force);
        $this->update_acf_field('section_experiences_items', [
            ['item_title' => 'Speak Your Story. Create Influence.', 'item_length' => '45&ndash;60 min', 'item_ideal' => 'Founders, executives, and leadership events', 'item_description' => 'Helping leaders reconnect with the lived experiences that shape trust, influence, and emotional authority.', 'item_btn_url' => home_url('/inquiry/')],
            ['item_title' => 'The Moment That Made You.', 'item_length' => '30&ndash;45 min', 'item_ideal' => "Women&#8217;s leadership and transformational conversations", 'item_description' => 'A reflective conversation around identity, truth, visibility, and the defining moments behind leadership.', 'item_btn_url' => home_url('/inquiry/')],
            ['item_title' => 'Influence Is a Human Experience.', 'item_length' => '20&ndash;30 min', 'item_ideal' => 'TED-style events and keynote openings', 'item_description' => 'Why people trust emotional truth before strategy, information, or performance.', 'item_btn_url' => home_url('/inquiry/')],
        ], $page_id, $force);
        $this->update_acf_field('section_book_heading', 'Tell us About Your <em class="text-gold italic">Event.</em>', $page_id, $force);
        $this->update_acf_field('section_book_text', "Share a few details about your audience, event format, and what you want the room to experience. Joanna's team will review and follow up with the next best step.", $page_id, $force);
        $this->update_acf_field('section_book_image', $this->upload_image('book-joanna-img.webp'), $page_id, $force);
        $this->update_acf_field('section_book_btn_text', 'SEND INQUIRY', $page_id, $force);
        $this->update_acf_field('section_book_btn_url', '#', $page_id, $force);
        $this->update_acf_field('section_download_heading', 'Planning an Event or Leadership Gathering?', $page_id, $force);
        $this->update_acf_field('section_download_text', "Download Joanna's speaker kit for speaking topics, event formats, experience details, and inquiry information.", $page_id, $force);
        $this->update_acf_field('section_download_bg_image', $this->upload_image('voice-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_download_image_left', $this->upload_image('speaker-kit.webp'), $page_id, $force);
        $this->update_acf_field('section_download_image_right', $this->upload_image('speaker-kit2.webp'), $page_id, $force);
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
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('service-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('joanna-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'You Know Your Work. But Your Message Still <em class="text-gold italic">Isn\'t Landing.</em>', $page_id, $force);
        $this->update_acf_field('section_message_text', '<p>You:</p><ul><li>ramble instead of landing your point</li><li>over-explain before saying anything clear</li><li>walk away thinking: &ldquo;That&rsquo;s not what I meant to say.&rdquo;</li></ul><p>You don&#8217;t lack experience.</p><p>You haven&#8217;t structured your message to move people yet.</p>', $page_id, $force);
        $this->update_acf_field('section_message_image', $this->upload_image('move-the-room1.webp'), $page_id, $force);
        $this->update_acf_field('section_build_heading', 'What You <em class="text-gold italic">Build</em><br>Inside the Cohort', $page_id, $force);
        $this->update_acf_field('section_build_items', [
            ['item_icon' => '', 'item_heading' => 'Your Signature Talk', 'item_text' => 'Craft a talk that lands with power and precision.'],
            ['item_icon' => '', 'item_heading' => 'Stage Presence & Delivery', 'item_text' => 'Develop the presence that commands attention.'],
            ['item_icon' => '', 'item_heading' => 'Story Architecture', 'item_text' => 'Structure your story for maximum emotional impact.'],
            ['item_icon' => '', 'item_heading' => 'Audience Connection', 'item_text' => 'Learn to read a room and adjust in real-time.'],
        ], $page_id, $force);
        $this->update_acf_field('section_build_btn_text', 'JOIN THE COHORT', $page_id, $force);
        $this->update_acf_field('section_build_btn_url', 'https://go.trueinfluencemethod.com/move-the-room', $page_id, $force);
        $this->update_acf_field('section_speaking_heading', 'This is <em class="font-normal text-gold italic">Not</em> Just<br>Speaking Training.', $page_id, $force);
        $this->update_acf_field('section_speaking_image', $this->upload_image('move-the-room2.webp'), $page_id, $force);
        $this->update_acf_field('section_speaking_items', [
            ['item_heading' => 'Message Development', 'item_text' => 'Craft a message that lands with power and precision.'],
            ['item_heading' => 'Stage Presence', 'item_text' => 'Develop the presence that commands attention and builds trust.'],
            ['item_heading' => 'Story Architecture', 'item_text' => 'Structure your story for maximum emotional impact.'],
            ['item_heading' => 'Audience Connection', 'item_text' => 'Learn to read a room and adjust in real-time.'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Some People Know Their Work. Others Can Others <em class="text-gold italic">Move a Room</em> With it.', $page_id, $force);
        $this->update_acf_field('section_cta_text', '<p>Starting at</p><p><span style="text-decoration: line-through;">$20,000</span> $12,000</p><p>Featured retreat speaking opportunity included</p>', $page_id, $force);
        $this->update_acf_field('section_cta_btn_text', 'TAKE THE STAGE', $page_id, $force);
        $this->update_acf_field('section_cta_btn_url', 'https://go.trueinfluencemethod.com/move-the-room', $page_id, $force);
        $this->update_acf_field('section_cta_bg_image', $this->upload_image('cta-bg.webp'), $page_id, $force);
    }

    private function seed_success_stories($force = false)
    {
        $page_id = $this->get_page_id('success-stories');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'Stories People<br>Now Carry <em class="text-gold italic">Differently</em>.', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Conversations, retreats, and transformational experiences that helped leaders reconnect with their voice, clarity, confidence, and influence.', $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('general-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_videos_heading', 'Hear it in Their <br>Own <em class="text-gold italic">Words</em>.', $page_id, $force);
        $this->update_acf_field('section_videos_items', [
            ['item_image' => $this->upload_image('story1.webp'), 'item_video_url' => '', 'item_name' => 'Victoria Richardson', 'item_title' => 'CEO', 'item_quote' => 'I now feel inspired and more clear in my why and my purpose.'],
            ['item_image' => $this->upload_image('story2.webp'), 'item_video_url' => '', 'item_name' => 'LeQuisha Underwood', 'item_title' => 'Executive Director', 'item_quote' => 'The biggest change in me is confidence.'],
            ['item_image' => $this->upload_image('story3.webp'), 'item_video_url' => '', 'item_name' => 'Kendi Brown', 'item_title' => 'Founder', 'item_quote' => 'I finally found the talk I was meant to give.'],
            ['item_image' => $this->upload_image('story4.webp'), 'item_video_url' => '', 'item_name' => 'BEN ARMSTRONG', 'item_title' => 'Leader', 'item_quote' => "She flips the script on how you do a speech."],
            ['item_image' => $this->upload_image('story5.webp'), 'item_video_url' => '', 'item_name' => 'DAWN ARMSTRONG', 'item_title' => 'Executive', 'item_quote' => "Giving people the confidence they didn\u2019t know they had."],
            ['item_image' => $this->upload_image('story6.webp'), 'item_video_url' => '', 'item_name' => 'Jessica Avignone', 'item_title' => 'Leader', 'item_quote' => 'Working with Joanna. What happens is you get real laser focused.'],
        ], $page_id, $force);
        $this->update_acf_field('section_written_heading', 'What Changed Wasn\'t<br>Just the <em class="text-gold italic">Message</em>.', $page_id, $force);
        $this->update_acf_field('section_written_items', [
            ['item_quote' => 'Joanna is skilled, patient and passionate, driving people to dig deep inside to achieve their best.', 'item_author' => 'Jennifer P.', 'item_title' => 'Executive'],
            ['item_quote' => 'She\u2019s clear and focused about doing \u2018the work,\u2019 bringing sheer determination and vision to make something new manifest in front of her eyes.', 'item_author' => 'Dr. Nadia R.', 'item_title' => 'Doctor'],
            ['item_quote' => 'I think you captured a top-notch clarity, like a next-level clarity. But you captured how to take them to the next level. You captured in-depth details on how to propel their success.', 'item_author' => 'WILDx', 'item_title' => 'Organization'],
            ['item_quote' => 'Joanna has been instrumental to my project and I\u2019m lucky to have her. She guided me throughout the start and progress, by asking why, what, ..questions, and suggesting solutions. I definitely recommend her.', 'item_author' => 'Laurien Sibomana', 'item_title' => 'Leader'],
            ['item_quote' => 'What sets Joanna apart is that she doesn\u2019t just help you \u201csound better\u201d or memorize lines, she goes straight to the core of what\u2019s been holding you back. Her technique is honest, practical, and incredibly effective.', 'item_author' => 'Monica May-Dunn', 'item_title' => 'Executive'],
            ['item_quote' => 'Joanna brought a level of safety and clarity to our team that was beyond valuable. We knew the training would be good, but got far more from it than we expected. I tell everyone I know to work with her.', 'item_author' => 'K. Johnson', 'item_title' => 'CEO'],
            ['item_quote' => 'Working with Joanna McPherson has been nothing short of life changing. Her skill, patience, and intuition make her truly exceptional, and I can\u2019t recommend her enough.', 'item_author' => 'A. Robinson', 'item_title' => 'Executive Leader'],
        ], $page_id, $force);
        $this->update_acf_field('section_cta_bg_image', $this->upload_image('voice-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_cta_heading', 'Your Story May Be Waiting for Its <em class="text-gold italic">Moment</em> too', $page_id, $force);
        $this->update_acf_field('section_cta_text', 'Explore the retreat, speaking experiences, and transformational work behind the True Influence Method\u2122.', $page_id, $force);
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
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('generic-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_testimonials_heading', 'People Remember What <em class="text-gold italic">Felt True.</em>', $page_id, $force);
        $this->update_acf_field('section_testimonials_items', [
            ['item_quote' => 'Working with Joanna has been nothing short of life-changing.', 'item_author' => 'A. Robinson', 'item_title' => 'Executive Leader'],
            ['item_quote' => 'I now feel inspired and more clear in my why and my purpose.', 'item_author' => 'Victoria Richardson', 'item_title' => 'CEO'],
            ['item_quote' => 'Joanna has been instrumental to my project and I\'m lucky to have her.', 'item_author' => 'Laurien Sibomana', 'item_title' => 'Leader'],
        ], $page_id, $force);
    }

    private function seed_the_authority($force = false)
    {
        $page_id = $this->get_page_id('the-authority');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'The <em class="text-gold italic">Authority</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', "This path is designed for leaders ready to refine how they communicate, strengthen their authority, and turn their experience into a message people immediately understand, remember, and follow.", $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('general-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('the-authority.webp'), $page_id, $force);
        $this->update_acf_field('section_message_image', $this->upload_image('the-authority.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'Be the <em class="text-gold italic">Authority</em> Through Your Story', $page_id, $force);
        $this->update_acf_field('section_message_text', "That's where authority begins.", $page_id, $force);
        $this->update_acf_field('section_two_ways_heading', 'Two Ways <em class="text-gold italic">Forward</em>', $page_id, $force);
        $this->update_acf_field('section_two_ways_items', [
            ['item_heading' => 'Move the Room &mdash; My Signature Talk', 'item_text' => 'Your story becomes a structured talk that moves people.', 'item_price' => '$12,000', 'item_price_label' => '', 'item_includes' => "A 7-minute signature talk\nA clear problem \u2192 solution message\nEmotional connection points + defined CTA\nLive coaching with Joanna", 'item_btn_text' => 'TAKE THE STAGE', 'item_btn_url' => home_url('/the-speaker/')],
            ['item_heading' => 'Master My Message &mdash; Keynote or TEDx', 'item_text' => 'This is where you become known.', 'item_price' => '$25,000', 'item_price_label' => 'Starts at', 'item_includes' => "A refined, repeatable signature message\nYour thought-leader perspective\nYour \"special sauce\" (what you do differently)\nA one-liner people can repeat", 'item_btn_text' => 'CREATE MY KEYNOTE', 'item_btn_url' => home_url('/master-my-message/')],
        ], $page_id, $force);
        $this->update_acf_field('section_work_heading', 'Work 1:1 with Joanna.', $page_id, $force);
        $this->update_acf_field('section_work_items', [
            ['item_heading' => 'Breakthrough Session', 'item_text' => 'One focused session designed to create immediate clarity and direction.', 'item_price' => '$2,000', 'item_btn_text' => 'BOOK A BREAKTHROUGH SESSION', 'item_btn_url' => home_url('t/breakthrough-session/')],
            ['item_heading' => '4-Session Training Package', 'item_text' => 'Private message refinement and leadership clarity across four sessions.', 'item_price' => '$8,000', 'item_btn_text' => 'BOOK PRIVATE TRAINING', 'item_btn_url' => home_url('/4-session/')],
        ], $page_id, $force);
    }

    private function seed_the_legacy($force = false)
    {
        $page_id = $this->get_page_id('the-legacy');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'The <em class="text-gold italic">Legacy</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', "This path is designed for leaders ready to strengthen their authority, refine how they communicate, and build a message that people immediately understand, remember, and trust.", $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('general-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('joanna-profile.webp'), $page_id, $force);
        $this->update_acf_field('section_message_image', $this->upload_image('the-legacy.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'Make an <em class="text-gold italic">Impact</em> With Your Voice', $page_id, $force);
        $this->update_acf_field('section_message_text', "You need: a message that lands clearly, emotional connection, not overexplaining, language people can remember and repeat. That's where authority begins.", $page_id, $force);
        $this->update_acf_field('section_two_ways_heading', 'Two Ways <em class="text-gold italic">Forward</em>', $page_id, $force);
        $this->update_acf_field('section_two_ways_items', [
            ['item_heading' => 'Build My Team &mdash; My Scaling Strategy', 'item_text' => 'Your message becomes a system.', 'item_btn_text' => 'DISCOVERY CALL', 'item_btn_url' => home_url('/build-my-team/')],
            ['item_heading' => 'Be Remembered &mdash; My Legacy Framework', 'item_text' => 'Your work outlives you.', 'item_btn_text' => 'DISCOVERY CALL', 'item_btn_url' => home_url('/be-remembered/')],
        ], $page_id, $force);
    }

    private function seed_the_speaker($force = false)
    {
        $page_id = $this->get_page_id('the-speaker');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', 'The <em class="text-gold italic">Speaker</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', "This path is designed for leaders ready to uncover the message behind their lived experience and begin communicating it with greater clarity, confidence, and emotional truth.", $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('general-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_profile_image', $this->upload_image('the-speaker1.webp'), $page_id, $force);
        $this->update_acf_field('section_message_image', $this->upload_image('the-speaker1.webp'), $page_id, $force);
        $this->update_acf_field('section_message_heading', 'You <em class="text-gold italic">Don&#8217;t Need</em> to Sound More Impressive.', $page_id, $force);
        $this->update_acf_field('section_message_text', "That's where this work begins.", $page_id, $force);
        $this->update_acf_field('section_story_heading', 'Tell Your Story &mdash;<br>My <em class="text-gold italic">Why</em>', $page_id, $force);
        $this->update_acf_field('section_story_text', '<p>The first course + retreat experience.</p><ul><li>Your defining moment (written + spoken)</li><li>Your deeper why</li><li>Your first leadership message</li><li>Your unique differentiator</li></ul>', $page_id, $force);
        $this->update_acf_field('section_story_image', $this->upload_image('the-speaker2.webp'), $page_id, $force);
        $this->update_acf_field('section_story_price', '$3,200', $page_id, $force);
        $this->update_acf_field('section_story_btn_text', 'FIND MY MESSAGE', $page_id, $force);
        $this->update_acf_field('section_story_btn_url', '/tell-your-story/', $page_id, $force);
        $this->update_acf_field('section_breakthrough_heading', "Want to go further?", $page_id, $force);
        $this->update_acf_field('section_breakthrough_text', 'One focused session designed to create immediate clarity and direction.', $page_id, $force);
        $this->update_acf_field('section_breakthrough_btn_text', "BOOK A BREAKTHROUGH SESSION", $page_id, $force);
        $this->update_acf_field('section_breakthrough_btn_url', 'https://go.trueinfluencemethod.com/breakthrough-session', $page_id, $force);
    }

    private function seed_the_vault($force = false)
    {
        $page_id = $this->get_page_id('the-vault');
        if (! $page_id) {
            return;
        }
        $this->update_acf_field('section_hero_heading', "The <em class=\"text-gold italic\">Vault</em>", $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', "A free live session with Joanna &mdash; <strong>June 5, 9:00&ndash;10:00 AM PST</strong>\n\nThis is your invitation to sit with Joanna in real time. No slides. No sales pitch. Just a direct conversation about the message you've been carrying and haven't fully said yet. Bring a question. Leave with clarity.", $page_id, $force);
        $this->update_acf_field('section_hero_bg_image', $this->upload_image('vault-hero-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_image', $this->upload_image('vault-hero-joanna.webp'), $page_id, $force);
        $this->update_acf_field('section_what_is_heading', "What is the <em class=\"text-gold italic\">Vault?</em>", $page_id, $force);
        $this->update_acf_field('section_what_is_text', '<p>The Vault is Joanna\'s free live conversation space for women exploring voice, visibility, leadership, and emotional truth.</p><p>A place for honest reflection, real questions, and the conversations that usually happen after the stage lights go down.</p><p>No performance. No pressure. Just space to reconnect with what\'s real.</p>', $page_id, $force);
        $this->update_acf_field('section_what_is_image', $this->upload_image('vault-what-is.webp'), $page_id, $force);
        $this->update_acf_field('section_what_happens_heading', "What <em>Happens</em> Inside", $page_id, $force);
        $this->update_acf_field('section_what_happens_image', $this->upload_image('vault-what-happens.webp'), $page_id, $force);
        $this->update_acf_field('section_what_happens_items', [
            ['item_heading' => 'Live conversation with Joanna', 'item_text' => ''],
            ['item_heading' => 'Real-time reflection and guidance', 'item_text' => ''],
            ['item_heading' => 'Message clarity and refinement', 'item_text' => ''],
            ['item_heading' => 'Honest conversations around visibility, leadership, and truth', 'item_text' => ''],
            ['item_heading' => 'A space to ask the question you haven\u2019t fully said out loud yet', 'item_text' => ''],
        ], $page_id, $force);
        $this->update_acf_field('section_registration_heading', '<em class="text-gold italic">Reserve</em> Your Seat', $page_id, $force);
        $this->update_acf_field('section_registration_text', '<p>Join Joanna live for an honest conversation around story, leadership, visibility, and the message you haven\'t fully said yet.</p><p>No performance. No pressure. <strong>Just real conversation.</strong></p>', $page_id, $force);
        $this->update_acf_field('section_registration_btn_text', "REGISTER FOR THE VAULT", $page_id, $force);
        $this->update_acf_field('section_registration_btn_url', '', $page_id, $force);
        $this->update_acf_field('section_registration_bg_image', $this->upload_image('vault-registration-bg.webp'), $page_id, $force);
    }

    private function seed_tell_your_story($force = false)
    {
        $page_id = $this->get_page_id('tell-your-story');
        if (! $page_id) {
            return;
        }

        $this->update_acf_field('section_tys_hero_eyebrow', 'Tell Your Story', $page_id, $force);
        $this->update_acf_field('section_tys_hero_heading', 'Where Leaders<br>Tell The <em class="text-gold italic">Truth.</em>', $page_id, $force);
        $this->update_acf_field('section_tys_hero_body', 'Tell Your Story is the transformational course + retreat experience inside the True Influence Method. Created for leaders ready to reconnect with the story behind their influence.', $page_id, $force);
        $this->update_acf_field('section_tys_hero_cta_text', 'VIEW THE RETREAT EXPERIENCE', $page_id, $force);
        $this->update_acf_field('section_tys_hero_cta_url', '#pricing', $page_id, $force);
        $this->update_acf_field('section_tys_hero_bg_image', $this->upload_image('tell-your-story-hero-bg.webp'), $page_id, $force);

        $this->update_acf_field('section_tys_speaking_heading', 'This Is <em>Not</em> Just Speaking Training; It\'s Leading from the Stage', $page_id, $force);
        $this->update_acf_field('section_tys_speaking_text_1', 'This is the work of uncovering the moments that shaped your voice, your leadership, and the way people experience you.', $page_id, $force);
        $this->update_acf_field('section_tys_speaking_text_2', 'Inside the retreat, leaders reconnect with the truth behind their message so their words stop sounding practiced and start feeling real.', $page_id, $force);

        $this->update_acf_field('section_tys_founding_heading', 'Be Part of the<br><em class="text-gold">Founding Experience.</em>', $page_id, $force);
        $this->update_acf_field('section_tys_founding_subhead', 'This retreat marks the beginning of a new chapter inside the True Influence Method \u2014 bringing together a small group of leaders ready to uncover the story behind their influence.', $page_id, $force);
        $this->update_acf_field('section_tys_founding_card_title', 'Inside the Experience', $page_id, $force);
        $this->update_acf_field('section_tys_founding_card_sub', 'A guided experience designed to help you uncover the story behind your leadership.', $page_id, $force);
        $this->update_acf_field('section_tys_founding_card_text', 'Inside Tell Your Story, you\'ll move through a structured self-guided course experience with Joanna designed to help you identify the defining moments, emotional truths, and deeper why behind your message.', $page_id, $force);
        $this->update_acf_field('section_tys_founding_date', 'September 17-20, 2027', $page_id, $force);
        $this->update_acf_field('section_tys_founding_features', [
            ['feature_text' => 'Four guided self-paced modules'],
            ['feature_text' => 'Community connection with like-minded leaders'],
            ['feature_text' => 'Reflective prompts and story exercises'],
            ['feature_text' => 'Story sharing, refinement, and feedback'],
            ['feature_text' => 'Defining moment and "why" discovery'],
            ['feature_text' => 'Immersive retreat experience with Joanna'],
        ], $page_id, $force);

        $this->update_acf_field('section_tys_carousel_images', [
            ['image' => $this->upload_image('tell-your-story-carousel-1.webp')],
            ['image' => $this->upload_image('tell-your-story-carousel-2.webp')],
            ['image' => $this->upload_image('tell-your-story-carousel-3.webp')],
            ['image' => $this->upload_image('tell-your-story-carousel-4.webp')],
            ['image' => $this->upload_image('tell-your-story-carousel-5.webp')],
            ['image' => $this->upload_image('tell-your-story-carousel-6.webp')],
        ], $page_id, $force);

        $this->update_acf_field('section_tys_transformations_heading', 'Some Transformations Can\'t be Explained.<br>They Have to be <em class="text-gold italic">Experienced.</em>', $page_id, $force);
        $this->update_acf_field('section_tys_transformations_subtitle', 'When your story becomes clear, so does your leadership.', $page_id, $force);
        $this->update_acf_field('section_tys_transformations_banner', 'Because your message finally comes from something real.', $page_id, $force);

        $this->update_acf_field('section_tys_pricing_heading', 'Join the Course &amp; Retreat<br><em class="text-gold-section italic">Experience</em>', $page_id, $force);
        $this->update_acf_field('section_tys_pricing_subhead', 'This inaugural course & retreat experience is intentionally intimate to preserve depth, connection, and transformation.', $page_id, $force);
        $this->update_acf_field('section_tys_pricing_strike', '$12,000', $page_id, $force);
        $this->update_acf_field('section_tys_pricing_price', '$3,200', $page_id, $force);
        $this->update_acf_field('section_tys_pricing_footnote', 'Includes the transformational course and retreat experience. Travel & accommodations not included.', $page_id, $force);
        $this->update_acf_field('section_tys_pricing_cta_text', 'JOIN THE COURSE & RETREAT', $page_id, $force);
        $this->update_acf_field('section_tys_pricing_cta_url', 'https://true-influence-method.mykajabi.com/offers/zvLu7zev/checkout', $page_id, $force);

        $this->update_acf_field('section_tys_faq_heading', 'Frequently Asked<br><em class="text-gold italic">Questions</em>', $page_id, $force);
        $this->update_acf_field('section_tys_faq_items', [
            ['question' => 'What happens during the retreat?', 'answer' => 'Tell Your Story is an immersive transformational experience designed to help leaders reconnect with the story behind their voice, leadership, and influence. Through guided reflection, live story sharing, emotional feedback, and intimate group experiences, participants begin clarifying the message that feels most true to who they are.'],
            ['question' => 'Do I need speaking experience?', 'answer' => 'No. This experience is not about becoming a polished performer. It\u2019s about reconnecting with the truth behind your voice so your message feels more grounded, clear, and emotionally honest.'],
            ['question' => 'Is this for leaders or speakers?', 'answer' => 'Both. Tell Your Story is designed for leaders, founders, visionaries, and speakers who want to communicate with deeper trust, clarity, and emotional connection.'],
            ['question' => 'What\u2019s included?', 'answer' => 'Your investment includes the transformational course experience, retreat sessions, guided exercises, live story work, and immersive group experiences throughout the retreat. Travel and accommodations are not included.'],
            ['question' => 'Is travel included?', 'answer' => 'No. Travel and accommodations are separate so participants can choose the arrangements that best support their experience.'],
            ['question' => 'What if I\u2019m not fully clear on my message yet?', 'answer' => 'That\u2019s exactly why this experience exists. Tell Your Story is designed for people who know there\u2019s something deeper they want to communicate \u2014 even if they don\u2019t fully have the words for it yet.'],
        ], $page_id, $force);

        WP_CLI::line('Seeded ACF fields for: tell-your-story');
    }

    /**
     * Fix page template assignments for existing pages that still use 'default'.
     *
     * Maps each page slug to its corresponding template file so ACF field groups
     * (which are conditioned on specific page templates) will appear in the backend.
     *
     * ## OPTIONS
     *
     * [--dry-run]
     * : Show what would change without making changes.
     *
     * @when after_wp_load
     */
    public function fix_templates($args, $assoc_args)
    {
        $dry_run = isset($assoc_args['dry-run']);

        $template_map = [
            'about'                => 'page-about.php',
            '4-session'            => 'page-4-session.php',
            'be-remembered'        => 'page-be-remembered.php',
            'breakthrough-session' => 'page-breakthrough-session.php',
            'build-my-team'        => 'page-build-my-team.php',
            'events'               => 'page-events.php',
            'get-started'          => 'page-get-started.php',
            'inquiry'              => 'page-inquiry.php',
            'master-my-message'    => 'page-master-my-message.php',
            'million-dollar-message' => 'page-million-dollar-message.php',
            'offers'               => 'page-offers.php',
            'on-stage'             => 'page-on-stage.php',
            'speaker-cohort'       => 'page-speaker-cohort.php',
            'success-stories'      => 'page-success-stories.php',
            'thank-you'            => 'page-thank-you.php',
            'the-authority'        => 'page-the-authority.php',
            'the-legacy'           => 'page-the-legacy.php',
            'the-speaker'          => 'page-the-speaker.php',
            'the-vault'            => 'page-the-vault.php',
            'tell-your-story'      => 'page-tell-your-story.php',
        ];

        $pages = get_posts([
            'post_type'      => 'page',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ]);

        $fixed = 0;
        $skipped = 0;

        foreach ($pages as $page) {
            $current = get_page_template_slug($page->ID);
            $slug = $page->post_name;

            if (! isset($template_map[$slug])) {
                $skipped++;
                continue;
            }

            $expected = $template_map[$slug];

            if ($current === $expected) {
                $skipped++;
                continue;
            }

            if ($dry_run) {
                WP_CLI::line("[DRY RUN] {$page->post_title} ({$slug}) — '{$current}' → '{$expected}'");
                $fixed++;
                continue;
            }

            update_post_meta($page->ID, '_wp_page_template', $expected);
            WP_CLI::line("Fixed: {$page->post_title} ({$slug}) — '{$current}' → '{$expected}'");
            $fixed++;
        }

        if ($dry_run) {
            WP_CLI::success("Dry run complete. {$fixed} page(s) would be updated, {$skipped} skipped.");
        } else {
            WP_CLI::success("Fixed {$fixed} page(s). {$skipped} skipped (already correct or unknown slug).");
        }
    }

    /**
     * Delete all pages and create fresh ones with correct slugs and templates.
     *
     * ## OPTIONS
     *
     * [--force]
     * : Skip confirmation prompt.
     *
     * @when after_wp_load
     */
    public function create_pages($args, $assoc_args)
    {
        $force = isset($assoc_args['force']);

        if (! $force) {
            WP_CLI::confirm('This will DELETE all existing pages and create new ones. Continue?');
        }

        $pages = get_posts([
            'post_type' => 'page',
            'posts_per_page' => -1,
            'post_status' => 'any',
        ]);

        $deleted = 0;
        foreach ($pages as $page) {
            wp_delete_post($page->ID, true);
            $deleted++;
        }
        WP_CLI::success("Deleted {$deleted} existing page(s).");

        $pages_to_create = [
            ['slug' => 'front-page',              'title' => 'Home',                'template' => 'Front Page'],
            ['slug' => 'about',                   'title' => 'About',               'template' => 'About'],
            ['slug' => '4-session',               'title' => '4-Session Training',  'template' => '4-Session Training Package'],
            ['slug' => 'be-remembered',            'title' => 'Be Remembered',        'template' => 'Be Remembered'],
            ['slug' => 'breakthrough-session',     'title' => 'Breakthrough Session', 'template' => 'Breakthrough Session'],
            ['slug' => 'build-my-team',            'title' => 'Build My Team',        'template' => 'Build My Team'],
            ['slug' => 'events',                  'title' => 'Events & Workshops',  'template' => 'Events and Workshops'],
            ['slug' => 'get-started',              'title' => 'Get Started',          'template' => 'Get Started'],
            ['slug' => 'inquiry',                 'title' => 'Inquiry',             'template' => 'Inquiry'],
            ['slug' => 'master-my-message',        'title' => 'Master My Message',    'template' => 'Master My Message'],
            ['slug' => 'million-dollar-message',   'title' => 'Million Dollar Message', 'template' => 'Million Dollar Message'],
            ['slug' => 'offers',                  'title' => 'Offers',              'template' => 'Offers'],
            ['slug' => 'on-stage',                'title' => 'On Stage',            'template' => 'On Stage'],
            ['slug' => 'speaker-cohort',           'title' => 'Speaker Cohort',       'template' => 'Speaker Cohort'],
            ['slug' => 'success-stories',          'title' => 'Success Stories',      'template' => 'Success Stories'],
            ['slug' => 'thank-you',               'title' => 'Thank You',           'template' => 'Thank You'],
            ['slug' => 'the-authority',            'title' => 'The Authority',        'template' => 'The Authority'],
            ['slug' => 'the-legacy',              'title' => 'The Legacy',          'template' => 'The Legacy'],
            ['slug' => 'the-speaker',             'title' => 'The Speaker',         'template' => 'The Speaker'],
            ['slug' => 'the-vault',               'title' => 'The Vault',           'template' => 'The Vault'],
        ];

        $created = 0;
        foreach ($pages_to_create as $p) {
            $page_id = wp_insert_post([
                'post_title'   => $p['title'],
                'post_name'    => $p['slug'],
                'post_type'    => 'page',
                'post_status'  => 'publish',
                'page_template' => $p['template'] === 'Front Page' ? '' : 'page-' . $p['slug'] . '.php',
            ]);

            if ($p['slug'] === 'front-page') {
                update_option('page_on_front', $page_id);
                update_option('show_on_front', 'page');
            }

            if (is_wp_error($page_id)) {
                WP_CLI::warning("Failed to create page: {$p['slug']}");
                continue;
            }

            $created++;
            WP_CLI::line("Created: {$p['title']} (/{$p['slug']}/) → template: {$p['template']}");
        }

        WP_CLI::success("Created {$created} page(s). Run `wp tim-tailpress seed --force` to populate ACF fields.");
    }

    /**
     * Reset everything: delete all pages and media, recreate pages, reseed all content.
     *
     * ## OPTIONS
     *
     * [--force]
     * : Skip confirmation prompt.
     *
     * @when after_wp_load
     */
    public function reset($args, $assoc_args)
    {
        $force = isset($assoc_args['force']);

        if (! $force) {
            WP_CLI::confirm('This will DELETE all pages AND all media, then recreate everything from scratch. Continue?');
        }

        WP_CLI::line('Deleting all pages...');
        $pages = get_posts([
            'post_type' => 'page',
            'posts_per_page' => -1,
            'post_status' => 'any',
            'fields' => 'ids',
        ]);
        foreach ($pages as $id) {
            wp_delete_post($id, true);
        }
        WP_CLI::success('All pages deleted.');

        WP_CLI::line('Deleting all media...');
        $attachments = get_posts([
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_status' => 'any',
            'fields' => 'ids',
        ]);
        foreach ($attachments as $id) {
            wp_delete_attachment($id, true);
        }
        WP_CLI::success('All media deleted.');

        WP_CLI::line('Deleting all menus...');
        $menu_items = get_posts([
            'post_type' => 'nav_menu_item',
            'posts_per_page' => -1,
            'post_status' => 'any',
            'fields' => 'ids',
        ]);
        foreach ($menu_items as $id) {
            wp_delete_post($id, true);
        }
        $menus = get_terms(['taxonomy' => 'nav_menu', 'hide_empty' => false]);
        if (! is_wp_error($menus)) {
            foreach ($menus as $menu) {
                wp_delete_term($menu->term_id, 'nav_menu');
            }
        }
        WP_CLI::success('All menus deleted.');

        WP_CLI::line('Creating fresh pages...');
        // Inline create_pages logic so we don't need to parse CLI args
        $pages_to_create = [
            ['slug' => 'front-page',              'title' => 'Home',                'template' => 'Front Page'],
            ['slug' => 'about',                   'title' => 'About',               'template' => 'About'],
            ['slug' => '4-session',               'title' => '4-Session Training',  'template' => '4-Session Training Package'],
            ['slug' => 'be-remembered',            'title' => 'Be Remembered',        'template' => 'Be Remembered'],
            ['slug' => 'breakthrough-session',     'title' => 'Breakthrough Session', 'template' => 'Breakthrough Session'],
            ['slug' => 'build-my-team',            'title' => 'Build My Team',        'template' => 'Build My Team'],
            ['slug' => 'events',                  'title' => 'Events & Workshops',  'template' => 'Events and Workshops'],
            ['slug' => 'get-started',              'title' => 'Get Started',          'template' => 'Get Started'],
            ['slug' => 'inquiry',                 'title' => 'Inquiry',             'template' => 'Inquiry'],
            ['slug' => 'master-my-message',        'title' => 'Master My Message',    'template' => 'Master My Message'],
            ['slug' => 'million-dollar-message',   'title' => 'Million Dollar Message', 'template' => 'Million Dollar Message'],
            ['slug' => 'offers',                  'title' => 'Offers',              'template' => 'Offers'],
            ['slug' => 'on-stage',                'title' => 'On Stage',            'template' => 'On Stage'],
            ['slug' => 'speaker-cohort',           'title' => 'Speaker Cohort',       'template' => 'Speaker Cohort'],
            ['slug' => 'success-stories',          'title' => 'Success Stories',      'template' => 'Success Stories'],
            ['slug' => 'thank-you',               'title' => 'Thank You',           'template' => 'Thank You'],
            ['slug' => 'the-authority',            'title' => 'The Authority',        'template' => 'The Authority'],
            ['slug' => 'the-legacy',              'title' => 'The Legacy',          'template' => 'The Legacy'],
            ['slug' => 'the-speaker',             'title' => 'The Speaker',         'template' => 'The Speaker'],
            ['slug' => 'the-vault',               'title' => 'The Vault',           'template' => 'The Vault'],
            ['slug' => 'tell-your-story',         'title' => 'Tell Your Story',     'template' => 'Tell Your Story'],
        ];

        $created = 0;
        foreach ($pages_to_create as $p) {
            $page_id = wp_insert_post([
                'post_title'    => $p['title'],
                'post_name'     => $p['slug'],
                'post_type'     => 'page',
                'post_status'   => 'publish',
                'page_template' => $p['template'] === 'Front Page' ? '' : 'page-' . $p['slug'] . '.php',
            ]);

            if ($p['slug'] === 'front-page') {
                update_option('page_on_front', $page_id);
                update_option('show_on_front', 'page');
            }

            if (is_wp_error($page_id)) {
                WP_CLI::warning("Failed to create page: {$p['slug']}");
                continue;
            }

            $created++;
            WP_CLI::line("Created: {$p['title']} (/{$p['slug']}/)");
        }
        WP_CLI::success("Created {$created} page(s).");

        WP_CLI::line('Seeding all ACF content...');
        // Call seed_all(true) with $force = true
        $this->seed_all(true);

        WP_CLI::success('Full reset & seed complete. All pages, media, SEO fields, and blog posts have been regenerated.');
    }

    private function cleanup_media()
    {
        $attachments = get_posts([
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_status' => 'any',
            'fields' => 'ids',
        ]);
        foreach ($attachments as $id) {
            wp_delete_attachment($id, true);
        }
    }
}

if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('tim-tailpress', 'TimTailPress_Seeder');
}

add_action('wp_ajax_tim_tailpress_seed', function () {
    if (! current_user_can('manage_options')) {
        wp_die('Unauthorized.');
    }
    if (! wp_verify_nonce($_REQUEST['_wpnonce'] ?? '', 'tim_tailpress_seed')) {
        wp_die('Invalid nonce.');
    }

    $seeder = new TimTailPress_Seeder();
    $seeder->seed_all(true);

    wp_redirect(add_query_arg('seeded', '1', wp_get_referer()));
    exit;
});

add_action('wp_ajax_tim_tailpress_reset', function () {
    if (! current_user_can('manage_options')) {
        wp_die('Unauthorized.');
    }
    if (! wp_verify_nonce($_REQUEST['_wpnonce'] ?? '', 'tim_tailpress_reset')) {
        wp_die('Invalid nonce.');
    }

    $seeder = new TimTailPress_Seeder();

    // Delete all pages
    $pages = get_posts([
        'post_type' => 'page',
        'posts_per_page' => -1,
        'post_status' => 'any',
        'fields' => 'ids',
    ]);
    foreach ($pages as $id) {
        wp_delete_post($id, true);
    }

    // Delete all media
    $attachments = get_posts([
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'post_status' => 'any',
        'fields' => 'ids',
    ]);
    foreach ($attachments as $id) {
        wp_delete_attachment($id, true);
    }

    // Reset ACF caches
    if (function_exists('acf_get_store')) {
        $store = acf_get_store('fields');
        if ($store) $store->reset();
        $store = acf_get_store('field-groups');
        if ($store) $store->reset();
    }

    // Recreate all pages from scratch
    $pages_to_create = [
        ['slug' => 'front-page',              'title' => 'Home',                'template' => 'Front Page'],
        ['slug' => 'about',                   'title' => 'About',               'template' => 'About'],
        ['slug' => '4-session',               'title' => '4-Session Training',  'template' => '4-Session Training Package'],
        ['slug' => 'be-remembered',            'title' => 'Be Remembered',        'template' => 'Be Remembered'],
        ['slug' => 'breakthrough-session',     'title' => 'Breakthrough Session', 'template' => 'Breakthrough Session'],
        ['slug' => 'build-my-team',            'title' => 'Build My Team',        'template' => 'Build My Team'],
        ['slug' => 'events',                  'title' => 'Events & Workshops',  'template' => 'Events and Workshops'],
        ['slug' => 'get-started',              'title' => 'Get Started',          'template' => 'Get Started'],
        ['slug' => 'inquiry',                 'title' => 'Inquiry',             'template' => 'Inquiry'],
        ['slug' => 'master-my-message',        'title' => 'Master My Message',    'template' => 'Master My Message'],
        ['slug' => 'million-dollar-message',   'title' => 'Million Dollar Message', 'template' => 'Million Dollar Message'],
        ['slug' => 'offers',                  'title' => 'Offers',              'template' => 'Offers'],
        ['slug' => 'on-stage',                'title' => 'On Stage',            'template' => 'On Stage'],
        ['slug' => 'speaker-cohort',           'title' => 'Speaker Cohort',       'template' => 'Speaker Cohort'],
        ['slug' => 'success-stories',          'title' => 'Success Stories',      'template' => 'Success Stories'],
        ['slug' => 'thank-you',               'title' => 'Thank You',           'template' => 'Thank You'],
        ['slug' => 'the-authority',            'title' => 'The Authority',        'template' => 'The Authority'],
        ['slug' => 'the-legacy',              'title' => 'The Legacy',          'template' => 'The Legacy'],
        ['slug' => 'the-speaker',             'title' => 'The Speaker',         'template' => 'The Speaker'],
        ['slug' => 'the-vault',               'title' => 'The Vault',           'template' => 'The Vault'],
        ['slug' => 'tell-your-story',         'title' => 'Tell Your Story',     'template' => 'Tell Your Story'],
    ];

    foreach ($pages_to_create as $p) {
        $page_id = wp_insert_post([
            'post_title'    => $p['title'],
            'post_name'     => $p['slug'],
            'post_type'     => 'page',
            'post_status'   => 'publish',
            'page_template' => $p['template'] === 'Front Page' ? '' : 'page-' . $p['slug'] . '.php',
        ]);

        if ($p['slug'] === 'front-page') {
            update_option('page_on_front', $page_id);
            update_option('show_on_front', 'page');
        }
    }

    // Seed everything with force
    $seeder->seed_all(true);

    wp_redirect(add_query_arg('reset', '1', wp_get_referer()));
    exit;
});

add_action('admin_menu', function () {
    add_submenu_page(
        'tools.php',
        'Seed Content',
        'Seed Content',
        'manage_options',
        'tim-tailpress-seed',
        function () {
            if (! current_user_can('manage_options')) {
                return;
            }

            $seeded = isset($_GET['seeded']);
            $reset = isset($_GET['reset']);

            if ($seeded) : ?>
                <div class="notice notice-success"><p>Content seeded successfully.</p></div>
            <?php endif; ?>
            <?php if ($reset) : ?>
                <div class="notice notice-success"><p>Full reset complete. All pages, media, SEO fields, and blog posts have been regenerated.</p></div>
            <?php endif; ?>

            <div class="wrap">
                <h1>Seed Site Content</h1>

                <h2>Quick Seed</h2>
                <p>Populate all ACF field groups with the original hardcoded content. This will overwrite any existing field values.</p>
                <form method="post" action="<?= admin_url('admin-ajax.php') ?>" style="margin-bottom:2em">
                    <?php wp_nonce_field('tim_tailpress_seed') ?>
                    <input type="hidden" name="action" value="tim_tailpress_seed">
                    <input type="hidden" name="page" value="tim-tailpress-seed">
                    <p class="submit">
                        <button type="submit" class="button button-primary" onclick="return confirm('This will overwrite all ACF field values. Continue?')">
                            Run Seeder
                        </button>
                    </p>
                </form>

                <hr>

                <h2>Full Reset &amp; Seed</h2>
                <p><strong>Destructive.</strong> Deletes all pages, all media library items, then recreates all pages from scratch and seeds all content (ACF fields, SEO fields, nav menus, blog posts). Use this to start fresh.</p>
                <form method="post" action="<?= admin_url('admin-ajax.php') ?>">
                    <?php wp_nonce_field('tim_tailpress_reset') ?>
                    <input type="hidden" name="action" value="tim_tailpress_reset">
                    <input type="hidden" name="page" value="tim-tailpress-seed">
                    <p class="submit">
                        <button type="submit" class="button button-danger" onclick="return confirm('⚠️ This will DELETE all pages and ALL media library items, then recreate everything from scratch. This cannot be undone. Continue?')" style="background:#c00;border-color:#c00;color:#fff;text-shadow:none">
                            Full Reset &amp; Seed
                        </button>
                    </p>
                </form>
            </div>
            <?php
        }
    );
});
