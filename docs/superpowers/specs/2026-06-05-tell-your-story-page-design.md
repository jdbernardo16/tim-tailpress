# Tell Your Story — Page Build

**Date:** 2026-06-05
**Status:** Approved (design phase)
**Scope:** New WordPress page + ACF field group + seeder + 15 image assets
**Styling approach:** Tailwind (Approach A) with theme tokens already in `theme.json`

## Problem

The current site links `Tell Your Story` from the footer `Programs` menu to
`/offers/#tell-your-story` — a fragment on the Offers page. A full standalone
landing page for the course + retreat experience has been designed in static
HTML (`/Users/jdbernardo/Sites/million-dollar/tellyourstory.html`) but is not
yet wired into WordPress. The static HTML has no CMS hookup, no ACF fields, no
seeder, and doesn't use the global header/footer.

## Goal

Build a standalone WordPress page at `/tell-your-story/` that:
- Renders the same visual design as the source HTML
- Uses the global theme `header.php` and `footer.php`
- Exposes all content via ACF so a non-developer can edit text, swap images,
  update prices, change FAQ items, toggle the exit-intent modal, etc.
- Seeding populates the page from the same content the source HTML hardcodes
- Is responsive across desktop, tablet, and mobile
- Has a working FAQ accordion, image carousel, and exit-intent lead-capture
  modal with LeadConnector webhook submission

## Non-Goals

- No redesign of the global header or footer
- No new CSS file (Tailwind utilities + theme tokens; section-specific CSS
  inlined in template parts where Tailwind doesn't fit, e.g. floating cards
  and gradient ellipses)
- No new JS dependency. Carousel, FAQ, and modal logic are plain vanilla JS
  inlined in the relevant template parts
- No ACF options-page changes
- No new post types or taxonomies
- Modal is **page-scoped** (only renders on this template), not global

## Source of Truth

- Source HTML: `/Users/jdbernardo/Sites/million-dollar/tellyourstory.html`
- Webhook: `https://services.leadconnectorhq.com/hooks/txFvEqJbQlKriCxJl8w3/webhook-trigger/ed78846f-c6f9-4e59-8c42-13a8aebe2798`
- Fonts: Flatline Sans (via existing `font-flatline` Tailwind token) and Garet
  (via `font-garet` token). Both already loaded globally
- Reference pattern: `page-master-my-message.php` + its template parts and
  ACF group `group_page-master-my-message.json`

## Page Identity

| Field | Value |
|---|---|
| Slug | `tell-your-story` |
| Title | `Tell Your Story` |
| Template | `Tell Your Story` → file: `page-tell-your-story.php` |
| URL | `/tell-your-story/` |
| Footer menu update | `Footer Programs → Tell Your Story` URL changes from `home_url('/offers/#tell-your-story')` to `home_url('/tell-your-story/')` |

## File Structure

### New files

| Path | Purpose |
|---|---|
| `page-tell-your-story.php` | Page template — `get_header()` + 8 template parts + `get_footer()` |
| `template-parts/section-tell-your-story-hero.php` | Navy hero with logo, pill eyebrow, headline, subtitle, CTA |
| `template-parts/section-tell-your-story-speaking.php` | "This Is Not Just Speaking Training…" — 2-col text + photo frame |
| `template-parts/section-tell-your-story-founding.php` | Navy rounded "Be Part of the Founding Experience" card |
| `template-parts/section-tell-your-story-carousel.php` | Image carousel (6 images, prev/next nav) |
| `template-parts/section-tell-your-story-transformations.php` | Portrait with 3 floating glass cards + banner |
| `template-parts/section-tell-your-story-pricing.php` | Investment card with strikethrough price + CTA |
| `template-parts/section-tell-your-story-faq.php` | FAQ accordion (6 items, first open) |
| `template-parts/section-tell-your-story-modal.php` | Exit-intent popup + page-scoped JS |
| `acf-json/group_page-tell-your-story.json` | ACF field group, location: `page_template == page-tell-your-story.php` |
| 15 files in `assets/images/tell-story-*.webp` | Downloaded images |

### Modified files

- `wp-cli/seeder.php` — add `seed_tell_your_story()`, register in `seed_all()`,
  add to `seed_seo()`, add to both `create_pages()` arrays, update
  `create_menus()` footer entry

### Untouched

- Global `template-parts/header.php` and `template-parts/footer.php`
- `theme.json`, `tailwind.config.mjs`, Vite config
- Any other page template, ACF group, or seeder
- Other menu items

## ACF Field Schema

**Group key:** `group_page-tell-your-story`
**Title:** `Page: Tell Your Story`
**Location:** `page_template == page-tell-your-story.php`

All image fields use `return_format: id` and `preview_size: medium` (matching
the rest of the theme). All repeater sub-fields use the `item_*` prefix.

| Field name | Type | Default / Notes |
|---|---|---|
| `section_hero_logo` | image | 100×100 logo, also used in header overlay area |
| `section_hero_background` | image | Full-bleed navy hero bg |
| `section_hero_eyebrow` | text | Default: `Tell Your Story` |
| `section_hero_heading` | text | Default: `Where Leaders<br>Tell The <em>Truth.</em>` |
| `section_hero_subtitle` | textarea | Body w/ bold span |
| `section_hero_cta_text` | text | Default: `VIEW THE RETREAT EXPERIENCE` |
| `section_hero_cta_url` | text | Default: `#pricing` |
| `section_speaking_heading` | text | Default: `This Is <em>Not</em> Just Speaking Training; It's Leading from the Stage` |
| `section_speaking_paragraphs` | repeater (textarea) | 2 paragraphs |
| `section_speaking_image_bg` | image | Background frame |
| `section_speaking_image_fg` | image | Foreground portrait (overlaps frame) |
| `section_founding_logo` | image | Small logo watermark at top |
| `section_founding_background` | image | Navy section bg texture |
| `section_founding_heading` | text | Default: `Be Part of the<br><em>Founding Experience.</em>` |
| `section_founding_subhead` | textarea | Body copy |
| `section_founding_card_title` | text | Default: `Inside the Experience` |
| `section_founding_card_subtitle` | text | Card subtitle |
| `section_founding_card_text` | textarea | Card body |
| `section_founding_date` | text | Default: `September 17-20, 2027` |
| `section_founding_features` | repeater (text) | 6 bullet items |
| `section_carousel_images` | repeater (image) | 6 images, displayed 360×240 each |
| `section_transformations_background` | image | Bg texture behind portrait |
| `section_transformations_portrait` | image | Central portrait |
| `section_transformations_headline` | text | Default: `Some Transformations Can't be Explained.<br>They Have to be <em>Experienced.</em>` |
| `section_transformations_subtitle` | text | Default: `When your story becomes clear, so does your leadership.` |
| `section_transformations_card_1` | text | Default: `You stop trying to sound convincing.` |
| `section_transformations_card_2` | text | Default: `You stop over-explaining.` |
| `section_transformations_card_3` | text | Default: `You stop searching for the right words.` |
| `section_transformations_banner` | text | Default: `Because your message finally comes from something real.` |
| `section_pricing_background` | image | Warm beige bg |
| `section_pricing_heading` | text | Default: `Join the Course & Retreat<br><em>Experience</em>` |
| `section_pricing_subhead` | textarea | Body copy |
| `section_pricing_original_price` | text | Default: `$12,000` |
| `section_pricing_price` | text | Default: `$3,200` |
| `section_pricing_label` | text | Default: `Investment` (label above the price) |
| `section_pricing_footnote` | textarea | Travel not included copy |
| `section_pricing_cta_text` | text | Default: `JOIN THE COURSE & RETREAT` |
| `section_pricing_cta_url` | text | Default: `https://true-influence-method.mykajabi.com/offers/zvLu7zev/checkout` |
| `section_faq_heading` | text | Default: `Frequently Asked<br><em>Questions</em>` |
| `section_faq_items` | repeater | sub: `item_question` (text), `item_answer` (textarea), `item_open` (true/false) |
| `section_modal_enabled` | true/false | Master toggle (default `1`) |
| `section_modal_delay_seconds` | number | Default: `3` |
| `section_modal_badge` | text | Default: `STAY IN THE LOOP` |
| `section_modal_title` | text | Default: `Before You Go…` |
| `section_modal_subtitle` | textarea | Body |
| `section_modal_message_label` | text | Default: `What's the message you struggle most to put into words?` |
| `section_modal_consent_text` | textarea | Consent disclosure (preserved from source) |
| `section_modal_submit_text` | text | Default: `SUBSCRIBE` |
| `section_modal_success_title` | text | Default: `You're Subscribed! 🎉` |
| `section_modal_success_text` | textarea | Body |
| `section_modal_webhook_url` | text | Default: LeadConnector webhook URL |

**SEO:** the theme's existing global `seo` group handles
`seo_meta_description`, `seo_robots`, `seo_og_image`. Populated via
`seed_seo()` with: meta description focused on the retreat and
`tell-story-hero-bg.webp` as OG image.

## Image Assets (15 files)

All downloaded to `/Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/assets/images/`.

| # | Local filename | Source URL | Used by |
|---|---|---|---|
| 1 | `tell-story-logo.webp` | `…/6a1641985a7f217776784c3e.webp` | hero logo |
| 2 | `tell-story-hero-bg.webp` | `…/6a167548ebdb915d9a714ccb.webp` | hero bg + OG image |
| 3 | `tell-story-speaking-bg.webp` | `…/6a2022af85f563c78d79ba30.webp` | speaking section bg |
| 4 | `tell-story-speaking-fg.webp` | `…/6a2022af2f1efbc07201735f.webp` | speaking foreground portrait |
| 5 | `tell-story-founding-logo.webp` | `…/6a2022af04148c4c34d32d31.webp` | founding watermark |
| 6 | `tell-story-founding-bg.webp` | `…/6a2022acb75a113972d3f9ab.webp` | founding navy bg |
| 7 | `tell-story-carousel-1.webp` | `…/6a2022aca499696d31d58bfa.webp` | carousel image 1 |
| 8 | `tell-story-carousel-2.webp` | `…/6a2022acb75a113972d3f9aa.webp` | carousel image 2 |
| 9 | `tell-story-carousel-3.webp` | `…/6a2024aa08c28ee98564d2c8.webp` | carousel image 3 |
| 10 | `tell-story-carousel-4.webp` | `…/6a2022acb75a113972d3f9a9.webp` | carousel image 4 |
| 11 | `tell-story-carousel-5.webp` | `…/6a2022aea499696d31d58c2e.webp` | carousel image 5 |
| 12 | `tell-story-carousel-6.webp` | `…/6a2022af2f1efbc07201735d.webp` | carousel image 6 |
| 13 | `tell-story-transformations-bg.webp` | `…/6a2022afc1e22b16af5f53f2.webp` | transformations bg |
| 14 | `tell-story-transformations-portrait.webp` | `…/6a2022b1a499696d31d58c3f.webp` | transformations central portrait |
| 15 | `tell-story-pricing-bg.webp` | `…/6a2022acb75a113972d3f9a8.webp` | pricing bg |

## Seeder Wiring

**1. `seed_all()` page slug list** (line ~259 in `seeder.php`) — add:
```php
'tell-your-story',
```

**2. `seed_seo()` pages array** (line ~130) — add:
```php
'tell-your-story' => [
    'meta_desc' => 'Tell Your Story is the transformational course + retreat experience inside the True Influence Method. Reconnect with the story behind your voice, leadership, and influence.',
    'og_image'  => 'tell-story-hero-bg.webp',
],
```

**3. `create_pages()` arrays** (both copies at lines ~1177 and ~1271) — add:
```php
['slug' => 'tell-your-story', 'title' => 'Tell Your Story', 'template' => 'Tell Your Story'],
```

**4. New `seed_tell_your_story($force = false)` method** — follows the exact
pattern of `seed_master_my_message()`. Uses `get_page_id('tell-your-story')`,
guards on null, then calls `update_acf_field()` for every field listed in the
schema section, using `$this->upload_image('tell-story-xxx.webp')` for images
and `update_field('section_carousel_images', [...], $page_id, $force)` for
repeaters.

**5. `create_menus()` footer Programs** (line ~339) — change:
```php
['title' => 'Tell Your Story', 'url' => home_url('/offers/#tell-your-story')],
```
to:
```php
['title' => 'Tell Your Story', 'url' => home_url('/tell-your-story/')],
```

## Styling Strategy

Use Tailwind utilities + theme tokens (`bg-navy`, `text-gold`, `text-warm-beige`,
`bg-canvas`, `font-flatline`, `font-garet`, `font-medium/semibold/black`).

**Inline `<style>` blocks in two template parts** (only where Tailwind
doesn't fit cleanly):

1. **`section-tell-your-story-founding.php`** — gradient ellipse blurs
   (`radial-gradient + filter: blur`) for the navy bg accents. ≤ 20 lines.
2. **`section-tell-your-story-transformations.php`** — absolutely positioned
   floating glass cards. ≤ 30 lines.

This matches the established pattern in `section-onstage-credibility.php`
which uses a small inline `<style>` for its radial-gradient accent.

## JavaScript

Three small inline scripts in `section-tell-your-story-modal.php` and
`section-tell-your-story-faq.php` (page-scoped, not in main app.js):

1. **FAQ accordion** — single-open pattern, click handler on `.faq-question`,
   toggles `.open` class on parent `.faq-item`. ~10 lines.
2. **Carousel prev/next** — native `scrollTo({ behavior: 'smooth' })` with
   wraparound. ~15 lines.
3. **Modal lifecycle** — show after `section_modal_delay_seconds`, close on
   X / overlay click / Escape key, POST to `section_modal_webhook_url`,
   swap to success view, auto-close + reset after 4s. ~50 lines. Reads
   delay/toggle from ACF so admin can disable.

## Verification

1. **Static** — `php -l` on every new/modified PHP file
2. **ACF schema** — open `/wp-admin/post.php?post=<id>&action=edit` for the
   Tell Your Story page, confirm all field groups render, no ACF errors
3. **Seeder dry run** — `wp eval 'echo get_field("section_hero_heading", get_page_by_path("tell-your-story")->ID);'`
   returns the seeded headline
4. **Visual** — open `/tell-your-story/` in a real browser, take screenshot,
   compare to source HTML at 3 viewports: desktop 1280, tablet 768, mobile 375
5. **Interactive** — click FAQ items, click carousel prev/next, wait for modal
   to appear, submit the form, verify success view
6. **Responsive** — at ≤767px: transformations cards stack vertically, carousel
   cards become 280px wide, single-column layouts kick in
7. **No regressions** — visit `/offers/`, `/on-stage/`, `/` to confirm no
   leakage from the modal or new global styles

## Open Questions

None at design time. The user confirmed the Tailwind approach, page slug, and
page-scoped modal during brainstorming.
