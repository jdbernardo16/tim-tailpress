# CMS Migration Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Move all hardcoded page content in tim-tailpress to ACF field groups (one per page template), migrating ~80 template-part files, adding WP-CLI seeder, and converting navigation to WordPress Menus.

**Architecture:** Each page template gets its own ACF field group (exported as JSON to `acf-json/`). Template parts use `get_field()` with fallbacks to current hardcoded values. A WP-CLI command seeds the initial content. Navigation moves from hardcoded HTML to `wp_nav_menu()`.

**Tech Stack:** ACF Pro, WordPress, PHP, WP-CLI, TailPress framework

---

### Task 1: Infrastructure Setup

**Files:**
- Modify: `functions.php`
- Create: `acf-json/index.php`

- [ ] **Step 1: Add ACF Local JSON paths to functions.php**

```php
// After line 37 (tailpress();) add:

/**
 * ACF Local JSON — sync field groups to filesystem.
 */
add_filter('acf/settings/save_json', function () {
    return get_template_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
});
```

- [ ] **Step 2: Register additional nav menu locations**

Replace the existing menu registration at line 19:
```php
->menus(fn($manager) => $manager->add('primary', __('Primary Menu', 'tailpress')))
```

With:
```php
->menus(function ($manager) {
    $manager->add('primary', __('Primary Menu', 'tailpress'));
    $manager->add('header', __('Header Navigation', 'tailpress'));
    $manager->add('footer-offers', __('Footer - Offers', 'tailpress'));
    $manager->add('footer-about', __('Footer - About', 'tailpress'));
    $manager->add('footer-connect', __('Footer - Connect', 'tailpress'));
    return $manager;
})
```

- [ ] **Step 3: Register WP-CLI seeder**

At the bottom of functions.php, add:

```php
/**
 * Load WP-CLI seeder.
 */
if (defined('WP_CLI') && WP_CLI) {
    require_once get_template_directory() . '/wp-cli/seeder.php';
}
```

- [ ] **Step 4: Create acf-json/index.php**

```php
<?php
// Silence is golden.
```

- [ ] **Step 5: Commit**

```bash
git add functions.php acf-json/index.php
git commit -m "feat: add ACF Local JSON, nav menus, and WP-CLI seeder scaffolding"
```

---

### Task 2: Navigation Migration — Header

**Files:**
- Modify: `template-parts/header.php`

- [ ] **Step 1: Replace desktop nav in header.php with wp_nav_menu**

Replace lines 16-28:

```php
<nav class="hidden lg:flex items-center gap-6" aria-label="<?php esc_attr_e('Primary Navigation', 'tailpress'); ?>">
    <a href="<?php echo esc_url(home_url('/about/')); ?>" class="text-white font-garet font-light text-base no-underline">About</a>
    <a href="<?php echo esc_url(home_url('/offers/')); ?>" class="inline-flex items-center gap-1.5 text-white font-garet font-light text-base no-underline">
        Work with me
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m6 9 6 6 6-6" />
        </svg>
    </a>
    <a href="<?php echo esc_url(home_url('/on-stage/')); ?>" class="text-white font-garet font-light text-base no-underline">On Stage</a>
    <a href="<?php echo esc_url(home_url('/events/')); ?>" class="text-white font-garet font-light text-base no-underline">Events & Workshops</a>
    <a href="<?php echo esc_url(home_url('/success-stories/')); ?>" class="text-white font-garet font-light text-base no-underline">Success Stories</a>
    <a href="<?php echo esc_url(home_url('/inquiry/')); ?>" class="text-white font-garet font-light text-base no-underline">Inquiry</a>
</nav>
```

With:

```php
<nav class="hidden lg:flex items-center gap-6" aria-label="<?php esc_attr_e('Primary Navigation', 'tailpress'); ?>">
    <?php
    wp_nav_menu([
        'theme_location' => 'header',
        'container' => false,
        'menu_class' => 'flex items-center gap-6',
        'items_wrap' => '%3$s',
        'depth' => 2,
        'walker' => new \TailPress\Walkers\HeaderNavWalker(),
    ]);
    ?>
</nav>
```

- [ ] **Step 2: Replace mobile nav links**

Replace lines 46-52:

```php
<a href="<?php echo esc_url(home_url('/about/')); ?>" class="text-white font-garet font-light text-base no-underline">About</a>
<a href="<?php echo esc_url(home_url('/offers/')); ?>" class="text-white font-garet font-light text-base no-underline">Work with me</a>
<a href="<?php echo esc_url(home_url('/on-stage/')); ?>" class="text-white font-garet font-light text-base no-underline">On Stage</a>
<a href="<?php echo esc_url(home_url('/events/')); ?>" class="text-white font-garet font-light text-base no-underline">Events & Workshops</a>
<a href="<?php echo esc_url(home_url('/success-stories/')); ?>" class="text-white font-garet font-light text-base no-underline">Success Stories</a>
<a href="<?php echo esc_url(home_url('/inquiry/')); ?>" class="text-white font-garet font-light text-base no-underline">Inquiry</a>
```

With:

```php
<?php
wp_nav_menu([
    'theme_location' => 'header',
    'container' => false,
    'menu_class' => 'flex flex-col gap-4',
    'items_wrap' => '%3$s',
    'depth' => 1,
    'walker' => new \TailPress\Walkers\HeaderNavWalker(),
]);
?>
```

- [ ] **Step 3: Create HeaderNavWalker**

Create `src/Walkers/HeaderNavWalker.php`:

```php
<?php

namespace TailPress\Walkers;

use Walker_Nav_Menu;

class HeaderNavWalker extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0) {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        $class_names = 'text-white font-garet font-light text-base no-underline';

        $output .= '<a href="' . esc_url($item->url) . '" class="' . $class_names . '">';
        $output .= esc_html($item->title);

        if ($has_children) {
            $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block ml-1"><path d="m6 9 6 6 6-6"/></svg>';
        }

        $output .= '</a>';
    }

    public function start_lvl(&$output, $depth = 0, $args = []) {
        $output .= '<div class="sub-menu hidden">';
    }

    public function end_lvl(&$output, $depth = 0, $args = []) {
        $output .= '</div>';
    }
}
```

- [ ] **Step 4: Commit**

```bash
git add template-parts/header.php src/Walkers/HeaderNavWalker.php
git commit -m "feat: convert header navigation to wp_nav_menu"
```

---

### Task 3: Navigation Migration — Footer

**Files:**
- Modify: `template-parts/footer.php`

- [ ] **Step 1: Replace footer Offer links column**

Replace lines 14-21:

```php
<!-- Column 1: All Offers -->
<div class="flex flex-col gap-2 lg:w-52">
    <a href="<?php echo esc_url(home_url('/offers/')); ?>" class="font-garet font-light text-sm text-black hover:opacity-70 transition-opacity">All Offers</a>
    <a href="<?php echo esc_url(home_url('/the-vault/')); ?>" class="font-garet font-light text-sm text-black hover:opacity-70 transition-opacity">The Vault</a>
    <a href="<?php echo esc_url(home_url('/million-dollar-message/')); ?>" class="font-garet font-light text-sm text-black hover:opacity-70 transition-opacity">$29 Million Dollar Message</a>
    <a href="<?php echo esc_url(home_url('/breakthrough-session/')); ?>" class="font-garet font-light text-sm text-black hover:opacity-70 transition-opacity">Breakthrough Session</a>
    <a href="<?php echo esc_url(home_url('/4-session/')); ?>" class="font-garet font-light text-sm text-black hover:opacity-70 transition-opacity">4-Session Training Package</a>
</div>
```

With:

```php
<div class="flex flex-col gap-2 lg:w-52">
    <?php
    wp_nav_menu([
        'theme_location' => 'footer-offers',
        'container' => false,
        'menu_class' => 'flex flex-col gap-2',
        'items_wrap' => '%3$s',
        'depth' => 1,
        'fallback_cb' => false,
    ]);
    ?>
</div>
```

- [ ] **Step 2: Replace footer Programs column**

Replace lines 23-30 with:

```php
<div class="flex flex-col gap-2 lg:w-52">
    <?php
    wp_nav_menu([
        'theme_location' => 'footer-programs',
        'container' => false,
        'menu_class' => 'flex flex-col gap-2',
        'items_wrap' => '%3$s',
        'depth' => 1,
        'fallback_cb' => false,
    ]);
    ?>
</div>
```

- [ ] **Step 3: Replace footer About column**

Replace lines 32-38 with:

```php
<div class="flex flex-col gap-2 lg:w-44">
    <?php
    wp_nav_menu([
        'theme_location' => 'footer-about',
        'container' => false,
        'menu_class' => 'flex flex-col gap-2',
        'items_wrap' => '%3$s',
        'depth' => 1,
        'fallback_cb' => false,
    ]);
    ?>
</div>
```

- [ ] **Step 4: Register footer-programs menu in functions.php**

Update the menus registration to add `footer-programs`:

```php
->menus(function ($manager) {
    $manager->add('primary', __('Primary Menu', 'tailpress'));
    $manager->add('header', __('Header Navigation', 'tailpress'));
    $manager->add('footer-offers', __('Footer - Offers', 'tailpress'));
    $manager->add('footer-programs', __('Footer - Programs', 'tailpress'));
    $manager->add('footer-about', __('Footer - About', 'tailpress'));
    $manager->add('footer-connect', __('Footer - Connect', 'tailpress'));
    return $manager;
})
```

- [ ] **Step 5: Commit**

```bash
git add template-parts/footer.php functions.php
git commit -m "feat: convert footer navigation columns to wp_nav_menu"
```

---

### Task 4: Template Migration Pattern — Front Page

**Files:**
- Create: `acf-json/group_front-page.json`
- Modify: `template-parts/section-hero.php`, `section-trusted.php`, `section-you-know.php`, `section-tell-story.php`, `section-discover.php`, `section-journey.php`, `section-speaker.php`, `section-vault.php`, `section-testimonials.php`, `section-voice.php`

**ACF Field Group: Front Page**
Location rule: `Page Template == Front Page`

Fields (each with unique name):
- `section_hero_heading` (text)
- `section_hero_subtitle` (textarea)
- `section_hero_bg_image` (image)
- `section_hero_profile_image` (image)
- `section_hero_btn_primary_text` (text)
- `section_hero_btn_primary_url` (link)
- `section_hero_btn_secondary_text` (text)
- `section_hero_btn_secondary_url` (link)

- `section_trusted_heading` (text)
- `section_trusted_stats` (repeater) → `item_icon` (image), `item_value` (text), `item_label` (text)

- `section_you_know_heading` (text)
- `section_you_know_bg_image` (image)
- `section_you_know_profile_image` (image)
- `section_you_know_text` (wysiwyg)

- `section_tell_story_heading` (text)
- `section_tell_story_text` (wysiwyg)
- `section_tell_story_image` (image)
- `section_tell_story_btn_text` (text)
- `section_tell_story_btn_url` (link)

- `section_discover_heading` (text)
- `section_discover_text` (textarea)
- `section_discover_image` (image)
- `section_discover_btn_text` (text)
- `section_discover_btn_url` (link)

- `section_journey_heading` (text)
- `section_journey_items` (repeater) → `item_icon` (image), `item_heading` (text), `item_text` (textarea)

- `section_speaker_heading` (text)
- `section_speaker_text` (textarea)
- `section_speaker_image` (image)
- `section_speaker_bg_image` (image)
- `section_speaker_watermark_image` (image)
- `section_speaker_btn_text` (text)
- `section_speaker_btn_url` (link)

- `section_vault_heading` (text)
- `section_vault_text` (textarea)
- `section_vault_image` (image)
- `section_vault_btn_text` (text)
- `section_vault_btn_url` (link)

- `section_testimonials_heading` (text)
- `section_testimonials_subtitle` (textarea)
- `section_testimonials_items` (repeater) → `item_quote` (textarea), `item_author` (text), `item_title` (text)

- `section_voice_heading` (text)
- `section_voice_text` (wysiwyg)
- `section_voice_image` (image)

- [ ] **Step 1: Create ACF field group JSON file**

Create `acf-json/group_front-page.json` with all front page fields as defined above, exported from ACF UI. (See reference pattern for JSON structure.)

- [ ] **Step 2: Migrate template-parts/section-hero.php**

Replace hardcoded content with `get_field()` + fallbacks. Transform pattern:

```php
// BEFORE (current):
<h1 class="font-flatline font-normal text-5xl md:text-6xl text-white leading-tight">
    You're Not Missing a Message. <em class="text-gold">You're Missing Trust.</em>
</h1>
<p class="mt-6 font-garet text-lg text-white leading-normal max-w-xl mx-auto lg:mx-0">
    Somewhere along the way, you learned how to explain yourself… but not how to truly be felt.
</p>

// AFTER:
<?php $hero_heading = get_field('section_hero_heading') ?: "You're Not Missing a Message. <em class=\"text-gold\">You're Missing Trust.</em>"; ?>
<?php $hero_subtitle = get_field('section_hero_subtitle') ?: 'Somewhere along the way, you learned how to explain yourself… but not how to truly be felt.'; ?>

<h1 class="font-flatline font-normal text-5xl md:text-6xl text-white leading-tight">
    <?= $hero_heading ?>
</h1>
<p class="mt-6 font-garet text-lg text-white leading-normal max-w-xl mx-auto lg:mx-0">
    <?= esc_html($hero_subtitle) ?>
</p>
```

Continue for each field (images, buttons).

- [ ] **Step 3: Migrate template-parts/section-trusted.php**

Replace stat array with `have_rows('section_trusted_stats')` loop with fallback to hardcoded array.

- [ ] **Step 4: Migrate template-parts/section-you-know.php**

Replace hardcoded heading, text, and image paths with `get_field()`.

- [ ] **Step 5: Migrate template-parts/section-tell-story.php**

Replace content with ACF fields.

- [ ] **Step 6: Migrate template-parts/section-discover.php**

Replace content with ACF fields.

- [ ] **Step 7: Migrate template-parts/section-journey.php**

Replace journey items array with repeater loop.

- [ ] **Step 8: Migrate template-parts/section-speaker.php**

Replace content with ACF fields.

- [ ] **Step 9: Migrate template-parts/section-vault.php**

Replace content with ACF fields.

- [ ] **Step 10: Migrate template-parts/section-testimonials.php**

Replace testimonial array with repeater loop + fallback.

- [ ] **Step 11: Migrate template-parts/section-voice.php**

Replace content with ACF fields.

- [ ] **Step 12: Commit**

```bash
git add acf-json/group_front-page.json template-parts/section-*.php
git commit -m "feat: migrate front page sections to ACF fields"
```

---

### Task 5: About Page Migration

**Files:**
- Create: `acf-json/group_page-about.json`
- Modify: `template-parts/section-about-hero.php`, `section-about-leader.php`, `section-about-meaning.php`, `section-about-life.php`, `section-about-reconnect.php`, `section-about-voice.php`

**ACF Field Group: About Page**
Location: `Page Template == About`

Fields:
- `section_hero_heading` (text), `section_hero_subtitle` (textarea), `section_hero_bg_image` (image), `section_hero_profile_image` (image)
- `section_hero_stats` (repeater) → `item_icon` (text/select for icon name), `item_value` (text), `item_label` (text)
- `section_leader_heading` (text), `section_leader_text` (wysiwyg), `section_leader_image` (image), `section_leader_gallery` (gallery or repeater)
- `section_meaning_heading` (text), `section_meaning_text` (wysiwyg), `section_meaning_image` (image)
- `section_life_heading` (text), `section_life_text` (wysiwyg), `section_life_image` (image)
- `section_reconnect_heading` (text), `section_reconnect_text` (wysiwyg), `section_reconnect_btn_text` (text), `section_reconnect_btn_url` (link)
- `section_voice_heading` (text), `section_voice_text` (wysiwyg)

- [ ] **Step 1: Create ACF JSON**

`acf-json/group_page-about.json`

- [ ] **Step 2-7: Migrate each section template part**

Same pattern as Task 4: `get_field()` + fallback.

- [ ] **Step 8: Commit**

---

### Task 6: Offers Page + Million Dollar Message

**Files:**
- Create: `acf-json/group_page-offers.json`, `acf-json/group_page-million-dollar-message.json`
- Modify: `template-parts/section-offers-*.php`, `template-parts/section-million-dollar-message-*.php`

- [ ] **Step 1: Offers field group** — includes signature offers repeater with sub-fields (title, description, price_label, price, cta_text, cta_url)

- [ ] **Step 2: Migrate section-offers-hero.php, section-offers-signature.php, section-offers-other.php, section-offers-cta.php**

- [ ] **Step 3: Million Dollar Message field group** — hero + inside (video/embed + bullet points)

- [ ] **Step 4: Migrate both million-dollar-message template parts**

- [ ] **Step 5: Commit**

---

### Task 7: Speaker Cohort + Be Remembered + Breakthrough Session

**Files:**
- Create: `acf-json/group_page-speaker-cohort.json`, `acf-json/group_page-be-remembered.json`, `acf-json/group_page-breakthrough-session.json`
- Modify: 15 template part files

- [ ] **Step 1: Speaker Cohort** — hero, message, build, speaking, cta

- [ ] **Step 2: Be Remembered** — hero, message, build, distinct, cta, form

- [ ] **Step 3: Breakthrough Session** — hero, message, build, cta

- [ ] **Step 4: Commit**

---

### Task 8: Build My Team + Master My Message + 4-Session

**Files:**
- Create: 3 ACF JSON files
- Modify: 16 template part files

- [ ] **Step 1: Build My Team** — hero, message, build, distinct, cta, form

- [ ] **Step 2: Master My Message** — hero, message, build, distinct, cta

- [ ] **Step 3: 4-Session Training** — hero, build, distinct, cta

- [ ] **Step 4: Commit**

---

### Task 9: On Stage + Events + Success Stories

**Files:**
- Create: 3 ACF JSON files
- Modify: 14 template part files

- [ ] **Step 1: On Stage** — hero, video (oembed), credibility (stats repeater), experiences (repeater), book, download

- [ ] **Step 2: Events** — hero, retreat, upcoming (events repeater → date, title, location, description), features, cta

- [ ] **Step 3: Success Stories** — hero, videos (video testimonial repeater), written (testimonial repeater), cta

- [ ] **Step 4: Commit**

---

### Task 10: The Authority + The Legacy + The Speaker + The Vault

**Files:**
- Create: 4 ACF JSON files
- Modify: 15 template part files

- [ ] **Step 1: The Authority** — hero, message, two-ways (repeater), work

- [ ] **Step 2: The Legacy** — hero, message, two-ways (repeater)

- [ ] **Step 3: The Speaker** — hero, message, story, breakthrough

- [ ] **Step 4: The Vault** — hero, what-is, what-happens, registration

- [ ] **Step 5: Commit**

---

### Task 11: Thank You + Get Started + Inquiry

**Files:**
- Create: 3 ACF JSON files
- Modify: 4 template part files

- [ ] **Step 1: Thank You** — hero, testimonials (repeater)

- [ ] **Step 2: Get Started** — hero

- [ ] **Step 3: Inquiry** — hero

- [ ] **Step 4: Commit**

---

### Task 12: WP-CLI Seeder — Core Class & Navigation

**Files:**
- Create: `wp-cli/seeder.php`

- [ ] **Step 1: Create seeder class skeleton with WP-CLI command registration**

```php
<?php
/**
 * WP-CLI Seeder — populates ACF fields with current hardcoded content.
 *
 * @package TailPress
 */

if (! defined('WP_CLI') || ! WP_CLI) {
    return;
}

/**
 * Seeds all pages with their original hardcoded content via ACF fields.
 */
class TimTailPress_Seeder {

    /**
     * Get page ID by slug.
     */
    private function get_page_id($slug) {
        $pages = get_posts([
            'post_type' => 'page',
            'name' => $slug,
            'fields' => 'ids',
            'posts_per_page' => 1,
            'post_status' => 'publish',
        ]);
        return ! empty($pages) ? $pages[0] : null;
    }

    /**
     * Seed all pages with ACF content.
     *
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
    public function seed($args, $assoc_args) {
        $force = isset($assoc_args['force']);
        $page_slugs = ['front-page', 'about', '4-session', 'be-remembered', 'breakthrough-session', 'build-my-team', 'events', 'get-started', 'inquiry', 'master-my-message', 'million-dollar-message', 'offers', 'on-stage', 'speaker-cohort', 'success-stories', 'thank-you', 'the-authority', 'the-legacy', 'the-speaker', 'the-vault'];

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

    /**
     * Helper: update ACF field with skip-if-exists logic.
     */
    private function update_acf_field($field_name, $value, $page_id, $force = false) {
        if (empty($page_id)) return;
        if (! $force) {
            $existing = get_field($field_name, $page_id);
            if (! empty($existing)) return;
        }
        update_field($field_name, $value, $page_id);
    }

    // ... seed methods
}

WP_CLI::add_command('tim-tailpress', 'TimTailPress_Seeder');
```

- [ ] **Step 2: Add menu creation helpers**

```php
/**
 * Create a WordPress menu and populate with items.
 * Items with a 'children' key create submenus.
 */
private function create_menu($menu_name, $location, $items) {
    if (wp_get_nav_menu_object($menu_name)) return;

    $menu_id = wp_create_nav_menu($menu_name);
    if (is_wp_error($menu_id)) return;

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

    // Second pass: assign parent-child relationships
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
```

- [ ] **Step 3: Add create_menus() method**

Seeds header, footer-offers, footer-programs, footer-about, footer-connect menus with exact URLs from current header.php and footer.php.

- [ ] **Step 4: Commit**

```bash
git add wp-cli/seeder.php
git commit -m "feat: add WP-CLI seeder with navigation menu creation"
```

---

### Task 13: WP-CLI Seeder — Front Page & About

- [ ] **Step 1: Add seed_front_page() method**

Populates all 10 sections with exact text from current template parts:

```php
private function seed_front_page($force = false) {
    $page_id = $this->get_page_id('front-page');
    if (! $page_id) return;

    $this->update_acf_field('section_hero_heading', "You're Not Missing a Message. <em class=\"text-gold\">You're Missing Trust.</em>", $page_id, $force);
    $this->update_acf_field('section_hero_subtitle', 'Somewhere along the way, you learned how to explain yourself… but not how to truly be felt.', $page_id, $force);
    $this->update_acf_field('section_hero_bg_image', $this->upload_image('hero-bg.webp'), $page_id, $force);
    $this->update_acf_field('section_hero_profile_image', $this->upload_image('hero-img.webp'), $page_id, $force);
    $this->update_acf_field('section_hero_btn_primary_text', 'Start Your Story', $page_id, $force);
    $this->update_acf_field('section_hero_btn_primary_url', home_url('/get-started/'), $page_id, $force);
    $this->update_acf_field('section_hero_btn_secondary_text', 'Watch Joanna Speak', $page_id, $force);
    $this->update_acf_field('section_hero_btn_secondary_url', home_url('/on-stage/'), $page_id, $force);

    $this->update_acf_field('section_trusted_heading', "Trusted by leaders worldwide", $page_id, $force);
    $this->update_acf_field('section_trusted_stats', [
        ['item_icon' => $this->upload_svg('UsersThree'), 'item_value' => '10,000+', 'item_label' => 'Leaders Transformed'],
        ['item_icon' => $this->upload_svg('SealCheck'), 'item_value' => '30+', 'item_label' => 'Years of Work'],
    ], $page_id, $force);

    $this->update_acf_field('section_you_know_heading', "You Know What You <em class=\"text-gold\">Mean</em>", $page_id, $force);
    $this->update_acf_field('section_you_know_text', '<p>But when it\'s time to speak…</p><p>You over-explain. You soften your truth. You lose the part people were supposed to feel.</p><p>Because the words were never the problem. The disconnect came long before the conversation did.</p>', $page_id, $force);
    $this->update_acf_field('section_you_know_bg_image', $this->upload_image('know-bg.webp'), $page_id, $force);
    $this->update_acf_field('section_you_know_profile_image', $this->upload_image('joanna-whole.webp'), $page_id, $force);

    // Continue for all remaining sections...
}
```

- [ ] **Step 2: Add image upload helper**

```php
/**
 * Upload an image from assets directory to media library.
 */
private function upload_image($filename) {
    $file_path = get_template_directory() . '/assets/images/' . $filename;
    if (! file_exists($file_path)) return null;

    $attachment_id = attachment_url_to_postid(get_template_directory_uri() . '/assets/images/' . $filename);
    if ($attachment_id) return $attachment_id;

    $upload = wp_upload_bits($filename, null, file_get_contents($file_path));
    if ($upload['error']) return null;

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

/**
 * Upload an SVG to media library.
 */
private function upload_svg($filename) {
    $file_path = get_template_directory() . '/assets/images/' . $filename . '.svg';
    if (! file_exists($file_path)) return null;

    $attachment_id = attachment_url_to_postid(get_template_directory_uri() . '/assets/images/' . $filename . '.svg');
    if ($attachment_id) return $attachment_id;

    $upload = wp_upload_bits($filename . '.svg', null, file_get_contents($file_path));
    if ($upload['error']) return null;

    $attachment_id = wp_insert_attachment([
        'post_mime_type' => 'image/svg+xml',
        'post_title' => $filename,
        'post_content' => '',
        'post_status' => 'inherit',
        'guid' => $upload['url'],
    ], $upload['file']);

    return $attachment_id;
}
```

- [ ] **Step 3: Add seed_about() method**

Populates all about page sections with exact current content.

- [ ] **Step 4: Commit**

```bash
git add wp-cli/seeder.php
git commit -m "feat: add seeder for front page and about page"
```

---

### Task 14: WP-CLI Seeder — Remaining Pages

- [ ] **Step 1: Add seeder methods for all remaining pages**

Each method follows the same pattern:
```php
private function seed_offers($force = false) {
    $page_id = $this->get_page_id('offers');
    if (! $page_id) return;

    $this->update_acf_field('section_hero_heading', 'Ways to <em>Work</em> with Joanna', $page_id, $force);
    $this->update_acf_field('section_signature_offers', [
        [
            'item_title' => 'Tell Your Story',
            'item_description' => 'Reconnect with the defining moments behind your leadership, voice, and influence.',
            'item_price' => '$3,200',
            'item_cta' => 'FIND MY MESSAGE',
            'item_url' => home_url('/the-speaker/'),
        ],
        // ... remaining 4 offers
    ], $page_id, $force);
}
```

Pages to add methods for (from Task 4-11):
- seed_4_session
- seed_be_remembered
- seed_breakthrough_session
- seed_build_my_team
- seed_events
- seed_get_started
- seed_inquiry
- seed_master_my_message
- seed_million_dollar_message
- seed_offers
- seed_on_stage
- seed_speaker_cohort
- seed_success_stories
- seed_thank_you
- seed_the_authority
- seed_the_legacy
- seed_the_speaker
- seed_the_vault

- [ ] **Step 2: Commit**

```bash
git add wp-cli/seeder.php
git commit -m "feat: complete seeder for all pages"
```

---

### Task 15: Full Integration Test

- [ ] **Step 1: Run the seeder**

```bash
wp tim-tailpress seed --force
```

Expected: All pages populated with their original content.

- [ ] **Step 2: Verify front-end rendering**

Browse to each page and verify content displays correctly.

- [ ] **Step 3: Verify navigation menus**

Check that header and footer menus display correct links matching the original hardcoded navigation.

- [ ] **Step 4: Verify ACF JSON sync**

Check that all field groups appear in ACF → Field Groups admin screen and are synced.

- [ ] **Step 5: Final commit**

```bash
git add -A
git commit -m "feat: complete CMS migration with ACF field groups and seeder"
```

---

## ACF JSON Reference Pattern

Each ACF field group JSON follows this structure:

```json
{
    "key": "group_front_page",
    "title": "Page: Front Page",
    "fields": [
        {
            "key": "field_section_hero_heading",
            "label": "Hero Heading",
            "name": "section_hero_heading",
            "type": "text",
            "default_value": "You're Not Missing a Message. <em class=\"text-gold\">You're Missing Trust.</em>"
        },
        {
            "key": "field_section_hero_subtitle",
            "label": "Hero Subtitle",
            "name": "section_hero_subtitle",
            "type": "textarea",
            "default_value": "Somewhere along the way..."
        },
        {
            "key": "field_section_hero_bg_image",
            "label": "Hero Background Image",
            "name": "section_hero_bg_image",
            "type": "image",
            "return_format": "id",
            "preview_size": "medium"
        },
        {
            "key": "field_section_testimonials_items",
            "label": "Testimonials",
            "name": "section_testimonials_items",
            "type": "repeater",
            "layout": "block",
            "sub_fields": [
                {
                    "key": "field_section_testimonials_item_quote",
                    "label": "Quote",
                    "name": "item_quote",
                    "type": "textarea"
                },
                {
                    "key": "field_section_testimonials_item_author",
                    "label": "Author",
                    "name": "item_author",
                    "type": "text"
                },
                {
                    "key": "field_section_testimonials_item_title",
                    "label": "Title",
                    "name": "item_title",
                    "type": "text"
                }
            ]
        }
    ],
    "location": [
        [
            {
                "param": "page_template",
                "operator": "==",
                "value": "front-page.php"
            }
        ]
    ],
    "active": true
}
```

## Template Part Migration Recipe

Every section template part follows this pattern:

1. **Identify all dynamic content** (headings, paragraphs, image paths, arrays of data, button text/URLs)
2. **At the top of the file**, declare variables with `get_field()` + fallback:
   ```php
   $heading = get_field('section_{section}_{field}') ?: 'Hardcoded default value';
   ```
3. **Replace inline hardcoded strings** with `<?= esc_html($heading) ?>` or `<?= $heading ?>` (for HTML-safe content like wysiwyg)
4. **Replace hardcoded arrays** (testimonials, stats, pricing) with:
   ```php
   if (have_rows('section_{section}_items')) :
       while (have_rows('section_{section}_items')) : the_row();
           $item_title = get_sub_field('item_title');
           // ...
       endwhile;
   else :
       // original hardcoded array
   endif;
   ```
5. **Replace image paths** with:
   ```php
   $image_id = get_field('section_{section}_image');
   if ($image_id) :
       echo wp_get_attachment_image($image_id, 'full');
   else : ?>
       <img src="<?= get_template_directory_uri() ?>/assets/images/original.webp" alt="">
   <?php endif; ?>
   ```
6. **Replace button links** with:
   ```php
   $btn = get_field('section_{section}_btn');
   $btn_url = $btn['url'] ?? home_url('/default/');
   $btn_text = $btn['title'] ?? 'Default Text';
   ?>
   <a href="<?= esc_url($btn_url) ?>" class="btn-primary"><?= esc_html($btn_text) ?></a>
   ```
