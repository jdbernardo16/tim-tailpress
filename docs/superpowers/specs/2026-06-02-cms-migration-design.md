# CMS Migration: ACF-Powered Page Content for tim-tailpress

**Date:** 2026-06-02
**Status:** Approved by user

## Overview

Migrate all hardcoded page content in the tim-tailpress WordPress theme to Advanced Custom Fields (ACF Pro) field groups — one per page template — preserving every piece of existing content verbatim. Add a WP-CLI seeder so the initial content is identical to what is currently hardcoded. Convert header/footer navigation from hardcoded HTML to WordPress Menus.

## Scope

| Category | Count | Details |
|---|---|---|
| Page-specific templates | 19 | `front-page` + 18 `page-{slug}.php` |
| Template parts to migrate | ~80 | `template-parts/section-*.php` |
| ACF field groups | 19 | One per page template |
| WordPress menus | 4–5 | Header, Footer Offers, Footer About, Footer Connect |
| Seeder commands | 1 | `wp tim-tailpress seed` |

## 1. Architecture

### 1.1 ACF Local JSON

ACF field groups are synced to/from the filesystem via the Local JSON feature. This keeps field definitions in version control and avoids database drift between environments.

**Setup in `functions.php`:**

```php
add_filter('acf/settings/save_json', function () {
    return get_template_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
});
```

**File layout:**

```
acf-json/
├── group_front-page.json
├── group_page-about.json
├── group_page-4-session.json
├── group_page-be-remembered.json
├── group_page-breakthrough-session.json
├── group_page-build-my-team.json
├── group_page-events.json
├── group_page-get-started.json
├── group_page-inquiry.json
├── group_page-master-my-message.json
├── group_page-million-dollar-message.json
├── group_page-offers.json
├── group_page-on-stage.json
├── group_page-speaker-cohort.json
├── group_page-success-stories.json
├── group_page-thank-you.json
├── group_page-the-authority.json
├── group_page-the-legacy.json
├── group_page-the-speaker.json
├── group_page-the-vault.json
└── index.php
```

### 1.2 Field Naming Convention

```
section_{section_slug}_{field_name}
```

| Part | Description | Example |
|---|---|---|
| `section_` | Prefix — all ACF fields share this | `section_hero_` |
| `{section_slug}` | kebab-case slug matching the template-part file | `hero`, `testimonials`, `you_know` |
| `{field_name}` | Descriptive field name | `heading`, `text`, `image`, `items` |

**Sub-field naming inside repeaters:**
Repeater field: `section_{section}_items`
Sub-fields: `item_heading`, `item_text`, `item_image`, `item_link`, `item_name`, `item_title`

### 1.3 Field Type Mapping

| Content Type | ACF Field Type | Notes |
|---|---|---|
| Heading / Title | `text` | Plain text, single line |
| Tagline / Subtitle | `text` | Plain text, single line |
| Body paragraph | `textarea` or `wysiwyg` | `textarea` for short copy, `wysiwyg` for rich text |
| Image | `image` | Returns ID — use `wp_get_attachment_image()` for responsive markup |
| Button / CTA link | `link` | Returns URL + title + target |
| Feature / bullet list | `repeater` | Sub-fields: `item_heading`, `item_text` |
| Testimonial | `repeater` | Sub-fields: `item_name`, `item_title`, `item_text`, `item_image` |
| Pricing tier | `repeater` | Sub-fields: `item_name`, `item_price`, `item_description` |
| Logo / brand list | `repeater` | Sub-fields: `item_image`, `item_name` |
| Stat / number | `number` | |
| Video URL / embed | `url` or `oembed` | `oembed` for YouTube/Vimeo |
| Section visibility | `true_false` | Optional toggle to show/hide a section |

### 1.4 Location Rules

Every field group uses exactly one location rule:

```
Page Template == {Template Name}
```

Where `{Template Name}` matches the `Template Name:` header in each `page-{slug}.php` file (e.g., "Front Page", "About", "4-Session Training Package").

## 2. Template Migration Pattern

### 2.1 Single-Value Fields

Every `get_field()` call includes a fallback to the **current hardcoded value** so the site never breaks — even if ACF is deactivated or a field hasn't been saved yet.

**Before:**
```php
<h1 class="text-4xl font-bold">You're Not Missing a Message. You're Missing Trust.</h1>
```

**After:**
```php
$heading = get_field('section_hero_heading') ?: "You're Not Missing a Message. You're Missing Trust.";
?>
<h1 class="text-4xl font-bold"><?= esc_html($heading) ?></h1>
```

### 2.2 Repeater Fields

**Before:**
```php
<?php $testimonials = [
    ['name' => 'A. Robinson', 'text' => '...'],
    ['name' => 'Speak & Rise Participant', 'text' => '...'],
]; ?>
<?php foreach ($testimonials as $t): ?>
    <div><?= esc_html($t['name']) ?></div>
<?php endforeach; ?>
```

**After:**
```php
<?php if (have_rows('section_testimonials_items')): ?>
    <?php while (have_rows('section_testimonials_items')): the_row(); ?>
        <div><?= esc_html(get_sub_field('item_name')) ?></div>
    <?php endwhile; ?>
<?php else: ?>
    <?php $defaults = [
        ['name' => 'A. Robinson', 'text' => '...'],
        ['name' => 'Speak & Rise Participant', 'text' => '...'],
    ]; ?>
    <?php foreach ($defaults as $t): ?>
        <div><?= esc_html($t['name']) ?></div>
    <?php endforeach; ?>
<?php endif; ?>
```

### 2.3 Image Fields

**Before:**
```php
<img src="<?= get_template_directory_uri() ?>/assets/images/hero-bg.webp" alt="Hero">
```

**After:**
```php
$image_id = get_field('section_hero_image');
if ($image_id) {
    echo wp_get_attachment_image($image_id, 'full');
} else { ?>
    <img src="<?= get_template_directory_uri() ?>/assets/images/hero-bg.webp" alt="Hero">
<?php } ?>
```

## 3. Seeder Architecture

### 3.1 File Location

```
wp-cli/
└── seeder.php
```

Registered in `functions.php`:
```php
if (defined('WP_CLI') && WP_CLI) {
    require_once get_template_directory() . '/wp-cli/seeder.php';
}
```

### 3.2 Command

```
wp tim-tailpress seed
```

Optional: `wp tim-tailpress seed --page=about` to seed a single page.

### 3.3 Implementation

```php
class TimTailPress_Seeder {
    
    private function get_page_id($slug) {
        return get_posts([
            'post_type' => 'page',
            'name' => $slug,
            'fields' => 'ids',
            'posts_per_page' => 1,
        ])[0] ?? null;
    }
    
    public function seed($args, $assoc_args) {
        $pages = $assoc_args['page'] ?? false;
        
        if ($pages) {
            $pages = explode(',', $pages);
        } else {
            $pages = ['front-page', 'about', '4-session', 'be-remembered', /* ... all slugs */];
        }
        
        foreach ($pages as $slug) {
            $method = 'seed_' . str_replace('-', '_', $slug);
            if (method_exists($this, $method)) {
                $this->$method();
                WP_CLI::success("Seeded: {$slug}");
            }
        }
    }
    
    private function seed_front_page() {
        $page_id = $this->get_page_id('front-page');
        if (!$page_id) return;
        
        update_field('section_hero_heading', "You're Not Missing a Message. You're Missing Trust.", $page_id);
        update_field('section_hero_subtitle', '...', $page_id);
        // ... repeat for every field
    }
    
    // One method per page template, populated with exact hardcoded text
}
```

### 3.4 Content Sources

Every seeder method uses the **exact text strings** currently found in the corresponding `template-parts/section-{page}-{name}.php` files. No paraphrasing or editing — verbatim copy.

## 4. Navigation Migration

### 4.1 Menu Registration

```php
register_nav_menus([
    'header' => 'Header Navigation',
    'footer-offers' => 'Footer - Offers',
    'footer-about' => 'Footer - About',
    'footer-connect' => 'Footer - Connect',
]);
```

### 4.2 Menu Structure

| Menu | Items |
|---|---|
| Header Navigation | About, Work with me (dropdown: all offers), On Stage, Events & Workshops, Success Stories, Inquiry, GET STARTED |
| Footer - Offers | The Vault, Million Dollar Message, Breakthrough Session, 4-Session Training, Tell Your Story, Move the Room, Master My Message, Build My Team, Be Remembered |
| Footer - About | About Joanna, On Stage, Events & Workshops, Inquiry |
| Footer - Connect | LinkedIn, Instagram, Facebook (custom links) |

### 4.3 Seeder Creates Menus

The WP-CLI seeder also creates these menus and their items:
```php
wp_nav_menu_items_from_links($menu_id, [
    ['title' => 'About', 'url' => home_url('/about')],
    // ...
]);
```

## 5. Template Replacement

### 5.1 Header

`template-parts/header.php` — Replace hardcoded nav list with:
```php
wp_nav_menu(['theme_location' => 'header', 'container' => false]);
```

### 5.2 Footer

`template-parts/footer.php` — Replace three hardcoded link columns with:
```php
wp_nav_menu(['theme_location' => 'footer-offers']);
wp_nav_menu(['theme_location' => 'footer-about']);
wp_nav_menu(['theme_location' => 'footer-connect']);
```

## 6. Non-Goals

- Forms remain hardcoded HTML (Be Remembered, Inquiry, newsletter)
- No Gutenberg block editor changes
- No post type changes — existing custom post types (if any) untouched
- No CSS/design changes — only content source changes

## 7. Risk Mitigation

| Risk | Mitigation |
|---|---|
| Field name typos | ACF JSON enforces consistent naming |
| Missing field breaks page | Fallback to hardcoded value in every `get_field()` call |
| Seeder overwrites manual edits | Seeder only runs on explicit command |
| ACF not activated | Theme still works via fallback values |
| Image disappears from media library | Fallback to current `get_template_directory_uri()` path |

## 8. File Change Summary

| Type | Files | Action |
|---|---|---|
| `acf-json/group_*.json` | 19 | Create (field definitions) |
| `acf-json/index.php` | 1 | Create (silence) |
| `wp-cli/seeder.php` | 1 | Create |
| `functions.php` | 1 | Edit (ACF JSON paths, WP-CLI registration, menus) |
| `template-parts/header.php` | 1 | Edit (nav → wp_nav_menu) |
| `template-parts/footer.php` | 1 | Edit (nav columns → wp_nav_menu) |
| `template-parts/section-*.php` | ~80 | Edit (hardcoded → get_field with fallback) |
