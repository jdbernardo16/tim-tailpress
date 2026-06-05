# Tell Your Story Page — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a standalone WordPress page at `/tell-your-story/` that renders the source HTML design with all content managed via ACF fields, populated by a seeder, with a working FAQ accordion, image carousel, and exit-intent lead-capture modal.

**Architecture:** Page template (`page-tell-your-story.php`) loads 8 section template parts (hero, speaking, founding, carousel, transformations, pricing, faq, modal) via `get_template_part()`. Each section is a self-contained template part that reads ACF fields with sensible HTML defaults. All styling uses Tailwind utilities + theme tokens; only 2 template parts need small inline `<style>` blocks for effects Tailwind can't express. All JS is inline vanilla JS in the relevant template part.

**Tech Stack:** WordPress 6.x, PHP 8.x, ACF Pro 6.x, Tailwind CSS (already configured in theme), vanilla JS (no new dependencies), TailPress framework.

**Working directory:** `/Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/`

**Branch recommendation:** Consider creating a worktree on a feature branch (e.g., `feat/tell-your-story-page`) before starting. See `using-git-worktrees` skill. The repo currently has uncommitted changes on `live` that should NOT be in the implementation commits.

---

## Task 1: Download 15 images to assets/images/

**Files:**
- Create: 15 files in `assets/images/tell-story-*.webp`

- [ ] **Step 1: Download all 15 images**

Run this script from the theme root:

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress

BASE="https://assets.cdn.filesafe.space/txFvEqJbQlKriCxJl8w3/media"
DEST="assets/images"

curl -sSL -o "$DEST/tell-story-logo.webp"                    "$BASE/6a1641985a7f217776784c3e.webp"
curl -sSL -o "$DEST/tell-story-hero-bg.webp"                 "$BASE/6a167548ebdb915d9a714ccb.webp"
curl -sSL -o "$DEST/tell-story-speaking-bg.webp"             "$BASE/6a2022af85f563c78d79ba30.webp"
curl -sSL -o "$DEST/tell-story-speaking-fg.webp"             "$BASE/6a2022af2f1efbc07201735f.webp"
curl -sSL -o "$DEST/tell-story-founding-logo.webp"           "$BASE/6a2022af04148c4c34d32d31.webp"
curl -sSL -o "$DEST/tell-story-founding-bg.webp"             "$BASE/6a2022acb75a113972d3f9ab.webp"
curl -sSL -o "$DEST/tell-story-carousel-1.webp"              "$BASE/6a2022aca499696d31d58bfa.webp"
curl -sSL -o "$DEST/tell-story-carousel-2.webp"              "$BASE/6a2022acb75a113972d3f9aa.webp"
curl -sSL -o "$DEST/tell-story-carousel-3.webp"              "$BASE/6a2024aa08c28ee98564d2c8.webp"
curl -sSL -o "$DEST/tell-story-carousel-4.webp"              "$BASE/6a2022acb75a113972d3f9a9.webp"
curl -sSL -o "$DEST/tell-story-carousel-5.webp"              "$BASE/6a2022aea499696d31d58c2e.webp"
curl -sSL -o "$DEST/tell-story-carousel-6.webp"              "$BASE/6a2022af2f1efbc07201735d.webp"
curl -sSL -o "$DEST/tell-story-transformations-bg.webp"      "$BASE/6a2022afc1e22b16af5f53f2.webp"
curl -sSL -o "$DEST/tell-story-transformations-portrait.webp" "$BASE/6a2022b1a499696d31d58c3f.webp"
curl -sSL -o "$DEST/tell-story-pricing-bg.webp"              "$BASE/6a2022acb75a113972d3f9a8.webp"

echo "Downloaded 15 images."
```

- [ ] **Step 2: Verify all 15 files exist and are non-zero size**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
ls -la assets/images/tell-story-*.webp | awk '{print $5, $9}' | sort
```

Expected: 15 lines, each showing a size > 1000 bytes.

- [ ] **Step 3: Commit**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
git add assets/images/tell-story-*.webp
git commit -m "feat(assets): add 15 images for Tell Your Story page"
```

---

## Task 2: Create ACF field group JSON

**Files:**
- Create: `acf-json/group_page-tell-your-story.json`

- [ ] **Step 1: Create the field group file**

Write the following JSON to `acf-json/group_page-tell-your-story.json`:

```json
{
    "key": "group_page-tell-your-story",
    "title": "Page: Tell Your Story",
    "fields": [
        { "key": "field_section_hero_logo", "label": "Section Hero Logo", "name": "section_hero_logo", "type": "image", "return_format": "id", "preview_size": "medium" },
        { "key": "field_section_hero_background", "label": "Section Hero Background", "name": "section_hero_background", "type": "image", "return_format": "id", "preview_size": "medium" },
        { "key": "field_section_hero_eyebrow", "label": "Section Hero Eyebrow", "name": "section_hero_eyebrow", "type": "text", "default_value": "Tell Your Story" },
        { "key": "field_section_hero_heading", "label": "Section Hero Heading", "name": "section_hero_heading", "type": "text", "default_value": "Where Leaders<br>Tell The <em>Truth.</em>" },
        { "key": "field_section_hero_subtitle", "label": "Section Hero Subtitle", "name": "section_hero_subtitle", "type": "textarea" },
        { "key": "field_section_hero_cta_text", "label": "Section Hero CTA Text", "name": "section_hero_cta_text", "type": "text", "default_value": "VIEW THE RETREAT EXPERIENCE" },
        { "key": "field_section_hero_cta_url", "label": "Section Hero CTA URL", "name": "section_hero_cta_url", "type": "text", "default_value": "#pricing" },
        { "key": "field_section_speaking_heading", "label": "Section Speaking Heading", "name": "section_speaking_heading", "type": "text", "default_value": "This Is <em>Not</em> Just Speaking Training; It's Leading from the Stage" },
        {
            "key": "field_section_speaking_paragraphs",
            "label": "Section Speaking Paragraphs",
            "name": "section_speaking_paragraphs",
            "type": "repeater",
            "layout": "block",
            "sub_fields": [
                { "key": "field_section_speaking_paragraphs_item_text", "label": "Paragraph", "name": "item_text", "type": "textarea" }
            ]
        },
        { "key": "field_section_speaking_image_bg", "label": "Section Speaking Image BG", "name": "section_speaking_image_bg", "type": "image", "return_format": "id", "preview_size": "medium" },
        { "key": "field_section_speaking_image_fg", "label": "Section Speaking Image FG", "name": "section_speaking_image_fg", "type": "image", "return_format": "id", "preview_size": "medium" },
        { "key": "field_section_founding_logo", "label": "Section Founding Logo", "name": "section_founding_logo", "type": "image", "return_format": "id", "preview_size": "medium" },
        { "key": "field_section_founding_background", "label": "Section Founding Background", "name": "section_founding_background", "type": "image", "return_format": "id", "preview_size": "medium" },
        { "key": "field_section_founding_heading", "label": "Section Founding Heading", "name": "section_founding_heading", "type": "text", "default_value": "Be Part of the<br><em>Founding Experience.</em>" },
        { "key": "field_section_founding_subhead", "label": "Section Founding Subhead", "name": "section_founding_subhead", "type": "textarea" },
        { "key": "field_section_founding_card_title", "label": "Section Founding Card Title", "name": "section_founding_card_title", "type": "text", "default_value": "Inside the Experience" },
        { "key": "field_section_founding_card_subtitle", "label": "Section Founding Card Subtitle", "name": "section_founding_card_subtitle", "type": "text" },
        { "key": "field_section_founding_card_text", "label": "Section Founding Card Text", "name": "section_founding_card_text", "type": "textarea" },
        { "key": "field_section_founding_date", "label": "Section Founding Date", "name": "section_founding_date", "type": "text", "default_value": "September 17-20, 2027" },
        {
            "key": "field_section_founding_features",
            "label": "Section Founding Features",
            "name": "section_founding_features",
            "type": "repeater",
            "layout": "block",
            "sub_fields": [
                { "key": "field_section_founding_features_item_text", "label": "Feature", "name": "item_text", "type": "text" }
            ]
        },
        {
            "key": "field_section_carousel_images",
            "label": "Section Carousel Images",
            "name": "section_carousel_images",
            "type": "repeater",
            "layout": "block",
            "sub_fields": [
                { "key": "field_section_carousel_images_item_image", "label": "Image", "name": "item_image", "type": "image", "return_format": "id", "preview_size": "medium" }
            ]
        },
        { "key": "field_section_transformations_background", "label": "Section Transformations Background", "name": "section_transformations_background", "type": "image", "return_format": "id", "preview_size": "medium" },
        { "key": "field_section_transformations_portrait", "label": "Section Transformations Portrait", "name": "section_transformations_portrait", "type": "image", "return_format": "id", "preview_size": "medium" },
        { "key": "field_section_transformations_headline", "label": "Section Transformations Headline", "name": "section_transformations_headline", "type": "text", "default_value": "Some Transformations Can't be Explained.<br>They Have to be <em>Experienced.</em>" },
        { "key": "field_section_transformations_subtitle", "label": "Section Transformations Subtitle", "name": "section_transformations_subtitle", "type": "text", "default_value": "When your story becomes clear, so does your leadership." },
        { "key": "field_section_transformations_card_1", "label": "Section Transformations Card 1", "name": "section_transformations_card_1", "type": "text", "default_value": "You stop trying to sound convincing." },
        { "key": "field_section_transformations_card_2", "label": "Section Transformations Card 2", "name": "section_transformations_card_2", "type": "text", "default_value": "You stop over-explaining." },
        { "key": "field_section_transformations_card_3", "label": "Section Transformations Card 3", "name": "section_transformations_card_3", "type": "text", "default_value": "You stop searching for the right words." },
        { "key": "field_section_transformations_banner", "label": "Section Transformations Banner", "name": "section_transformations_banner", "type": "text", "default_value": "Because your message finally comes from something real." },
        { "key": "field_section_pricing_background", "label": "Section Pricing Background", "name": "section_pricing_background", "type": "image", "return_format": "id", "preview_size": "medium" },
        { "key": "field_section_pricing_heading", "label": "Section Pricing Heading", "name": "section_pricing_heading", "type": "text", "default_value": "Join the Course & Retreat<br><em>Experience</em>" },
        { "key": "field_section_pricing_subhead", "label": "Section Pricing Subhead", "name": "section_pricing_subhead", "type": "textarea" },
        { "key": "field_section_pricing_original_price", "label": "Section Pricing Original Price", "name": "section_pricing_original_price", "type": "text", "default_value": "$12,000" },
        { "key": "field_section_pricing_price", "label": "Section Pricing Price", "name": "section_pricing_price", "type": "text", "default_value": "$3,200" },
        { "key": "field_section_pricing_label", "label": "Section Pricing Label", "name": "section_pricing_label", "type": "text", "default_value": "Investment" },
        { "key": "field_section_pricing_footnote", "label": "Section Pricing Footnote", "name": "section_pricing_footnote", "type": "textarea" },
        { "key": "field_section_pricing_cta_text", "label": "Section Pricing CTA Text", "name": "section_pricing_cta_text", "type": "text", "default_value": "JOIN THE COURSE & RETREAT" },
        { "key": "field_section_pricing_cta_url", "label": "Section Pricing CTA URL", "name": "section_pricing_cta_url", "type": "text", "default_value": "https://true-influence-method.mykajabi.com/offers/zvLu7zev/checkout" },
        { "key": "field_section_faq_heading", "label": "Section FAQ Heading", "name": "section_faq_heading", "type": "text", "default_value": "Frequently Asked<br><em>Questions</em>" },
        {
            "key": "field_section_faq_items",
            "label": "Section FAQ Items",
            "name": "section_faq_items",
            "type": "repeater",
            "layout": "block",
            "sub_fields": [
                { "key": "field_section_faq_items_item_question", "label": "Question", "name": "item_question", "type": "text" },
                { "key": "field_section_faq_items_item_answer", "label": "Answer", "name": "item_answer", "type": "textarea" },
                { "key": "field_section_faq_items_item_open", "label": "Open by Default", "name": "item_open", "type": "true_false", "default_value": 0, "ui": 1 }
            ]
        },
        { "key": "field_section_modal_enabled", "label": "Section Modal Enabled", "name": "section_modal_enabled", "type": "true_false", "default_value": 1, "ui": 1 },
        { "key": "field_section_modal_delay_seconds", "label": "Section Modal Delay (seconds)", "name": "section_modal_delay_seconds", "type": "number", "default_value": 3 },
        { "key": "field_section_modal_badge", "label": "Section Modal Badge", "name": "section_modal_badge", "type": "text", "default_value": "STAY IN THE LOOP" },
        { "key": "field_section_modal_title", "label": "Section Modal Title", "name": "section_modal_title", "type": "text", "default_value": "Before You Go…" },
        { "key": "field_section_modal_subtitle", "label": "Section Modal Subtitle", "name": "section_modal_subtitle", "type": "textarea" },
        { "key": "field_section_modal_message_label", "label": "Section Modal Message Label", "name": "section_modal_message_label", "type": "text", "default_value": "What's the message you struggle most to put into words?" },
        { "key": "field_section_modal_consent_text", "label": "Section Modal Consent Text", "name": "section_modal_consent_text", "type": "textarea" },
        { "key": "field_section_modal_submit_text", "label": "Section Modal Submit Text", "name": "section_modal_submit_text", "type": "text", "default_value": "SUBSCRIBE" },
        { "key": "field_section_modal_success_title", "label": "Section Modal Success Title", "name": "section_modal_success_title", "type": "text", "default_value": "You're Subscribed! 🎉" },
        { "key": "field_section_modal_success_text", "label": "Section Modal Success Text", "name": "section_modal_success_text", "type": "textarea" },
        { "key": "field_section_modal_webhook_url", "label": "Section Modal Webhook URL", "name": "section_modal_webhook_url", "type": "text", "default_value": "https://services.leadconnectorhq.com/hooks/txFvEqJbQlKriCxJl8w3/webhook-trigger/ed78846f-c6f9-4e59-8c42-13a8aebe2798" }
    ],
    "location": [
        [
            {
                "param": "page_template",
                "operator": "==",
                "value": "page-tell-your-story.php"
            }
        ]
    ],
    "active": true
}
```

- [ ] **Step 2: Validate JSON syntax**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
python3 -m json.tool acf-json/group_page-tell-your-story.json > /dev/null && echo "Valid JSON"
```

Expected: `Valid JSON`

- [ ] **Step 3: Verify ACF picks it up**

Load the WP admin (any page using the template once it exists, or import via ACF → Field Groups → Sync). Field group `Page: Tell Your Story` should appear. If sync is needed:
```bash
wp acf sync
```

- [ ] **Step 4: Commit**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
git add acf-json/group_page-tell-your-story.json
git commit -m "feat(acf): add Tell Your Story page field group"
```

---

## Task 3: Create page template (skeleton, no sections yet)

**Files:**
- Create: `page-tell-your-story.php`

- [ ] **Step 1: Create the page template file**

Write to `page-tell-your-story.php`:

```php
<?php
/**
 * Template Name: Tell Your Story
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-tell-your-story', 'hero'); ?>
    <?php get_template_part('template-parts/section-tell-your-story', 'speaking'); ?>
    <?php get_template_part('template-parts/section-tell-your-story', 'founding'); ?>
    <?php get_template_part('template-parts/section-tell-your-story', 'carousel'); ?>
    <?php get_template_part('template-parts/section-tell-your-story', 'transformations'); ?>
    <?php get_template_part('template-parts/section-tell-your-story', 'pricing'); ?>
    <?php get_template_part('template-parts/section-tell-your-story', 'faq'); ?>
    <?php get_template_part('template-parts/section-tell-your-story', 'modal'); ?>
</main>

<?php
get_footer();
```

- [ ] **Step 2: Run PHP syntax check**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
php -l page-tell-your-story.php
```

Expected: `No syntax errors detected in page-tell-your-story.php`

- [ ] **Step 3: Commit**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
git add page-tell-your-story.php
git commit -m "feat(page): add Tell Your Story page template skeleton"
```

---

## Task 4: Create hero section template part

**Files:**
- Create: `template-parts/section-tell-your-story-hero.php`

- [ ] **Step 1: Create the hero template part**

Write to `template-parts/section-tell-your-story-hero.php`:

```php
<?php

/**
 * Tell Your Story Page - Hero Section template part.
 *
 * @package TailPress
 */

$logo_id       = get_field('section_hero_logo');
$bg_id         = get_field('section_hero_background');
$eyebrow       = get_field('section_hero_eyebrow') ?: 'Tell Your Story';
$heading       = get_field('section_hero_heading') ?: 'Where Leaders<br>Tell The <em class="text-gold italic">Truth.</em>';
$subtitle      = get_field('section_hero_subtitle') ?: 'Tell Your Story is the <strong>transformational course + retreat experience</strong> inside the True Influence Method. Created for leaders ready to reconnect with the story behind their influence.';
$cta_text      = get_field('section_hero_cta_text') ?: 'VIEW THE RETREAT EXPERIENCE';
$cta_url       = get_field('section_hero_cta_url') ?: '#pricing';
?>

<section class="relative bg-navy overflow-hidden min-h-screen pt-20 pb-20 px-5">
    <!-- Background image -->
    <div class="absolute inset-0">
        <?php if ($bg_id): ?>
            <?= wp_get_attachment_image($bg_id, 'full', false, ['class' => 'w-full h-full object-cover', 'aria-hidden' => 'true']) ?>
        <?php endif; ?>
    </div>

    <!-- Logo top center -->
    <div class="relative z-10 flex justify-center pt-5">
        <?php if ($logo_id): ?>
            <?= wp_get_attachment_image($logo_id, 'full', false, ['class' => 'w-[100px] h-[100px] object-contain', 'alt' => 'True Influence Method Logo']) ?>
        <?php endif; ?>
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-[600px] mx-auto mt-20 text-center">
        <span class="inline-block font-flatline font-bold text-xs text-warm-beige uppercase tracking-[0.3em] rounded-full bg-white/20 px-[18px] py-2 mb-8">
            <?= esc_html($eyebrow) ?>
        </span>

        <h1 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[64px] text-white leading-[1.1] mb-6">
            <?= $heading ?>
        </h1>

        <p class="font-garet font-light text-lg text-white leading-[1.6] mb-10 max-w-[592px] mx-auto">
            <?= $subtitle ?>
        </p>

        <a href="<?= esc_url($cta_url) ?>" class="inline-flex items-center justify-center gap-3 bg-gradient-to-r from-warm-beige to-gold border border-warm-beige rounded-full px-8 py-4 font-flatline font-bold text-sm text-navy tracking-[0.08em] transition-transform duration-200 hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(212,180,120,0.3)]">
            <?= esc_html($cta_text) ?>
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none">
                <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="#0f203d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
    </div>
</section>
```

- [ ] **Step 2: Run PHP syntax check**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
php -l template-parts/section-tell-your-story-hero.php
```

Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
git add template-parts/section-tell-your-story-hero.php
git commit -m "feat(template): add Tell Your Story hero section"
```

---

## Task 5: Create speaking section template part

**Files:**
- Create: `template-parts/section-tell-your-story-speaking.php`

- [ ] **Step 1: Create the speaking template part**

Write to `template-parts/section-tell-your-story-speaking.php`:

```php
<?php

/**
 * Tell Your Story Page - Speaking Section template part.
 *
 * @package TailPress
 */

$heading     = get_field('section_speaking_heading') ?: 'This Is <em class="text-gold italic">Not</em> Just Speaking Training; It\'s Leading from the Stage';
$bg_id       = get_field('section_speaking_image_bg');
$fg_id       = get_field('section_speaking_image_fg');
$paragraphs  = get_field('section_speaking_paragraphs');
$default_paras = [
    ['item_text' => 'This is the work of uncovering the moments that shaped your voice, your leadership, and the way people experience you.'],
    ['item_text' => 'Inside the retreat, leaders reconnect with the truth behind their message so their words stop sounding practiced and start feeling real.'],
];
$paragraphs  = ! empty($paragraphs) ? $paragraphs : $default_paras;
?>

<section class="bg-canvas py-24 lg:py-32 px-5">
    <div class="max-w-[1230px] mx-auto flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
        <div class="w-full lg:w-[40%] flex-shrink-0">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1] mb-8">
                <?= $heading ?>
            </h2>

            <?php foreach ($paragraphs as $p): ?>
                <p class="font-garet font-light text-lg text-navy leading-[1.6] mb-4 last:mb-0">
                    <?= esc_html($p['item_text']) ?>
                </p>
            <?php endforeach; ?>
        </div>

        <div class="w-full lg:flex-1 relative">
            <div class="relative w-full aspect-[673/454] bg-canvas rounded">
                <?php if ($bg_id): ?>
                    <?= wp_get_attachment_image($bg_id, 'full', false, ['class' => 'absolute inset-0 w-full h-full object-cover', 'aria-hidden' => 'true']) ?>
                <?php endif; ?>

                <?php if ($fg_id): ?>
                    <?= wp_get_attachment_image($fg_id, 'full', false, ['class' => 'absolute bottom-0 left-[40%] -translate-x-1/2 h-[113%] w-auto max-w-none', 'alt' => 'Joanna Horton McPherson']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
```

- [ ] **Step 2: Run PHP syntax check**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
php -l template-parts/section-tell-your-story-speaking.php
```

Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
git add template-parts/section-tell-your-story-speaking.php
git commit -m "feat(template): add Tell Your Story speaking section"
```

---

## Task 6: Create founding section template part (with inline styles)

**Files:**
- Create: `template-parts/section-tell-your-story-founding.php`

- [ ] **Step 1: Create the founding template part**

Write to `template-parts/section-tell-your-story-founding.php`:

```php
<?php

/**
 * Tell Your Story Page - Founding Experience Section template part.
 *
 * @package TailPress
 */

$logo_id      = get_field('section_founding_logo');
$bg_id        = get_field('section_founding_background');
$heading      = get_field('section_founding_heading') ?: 'Be Part of the<br><em class="text-gold italic">Founding Experience.</em>';
$subhead      = get_field('section_founding_subhead') ?: 'This retreat marks the <strong>beginning of a new chapter</strong> inside the True Influence Method — bringing together a small group of leaders ready to uncover the story behind their influence.';
$card_title   = get_field('section_founding_card_title') ?: 'Inside the Experience';
$card_sub     = get_field('section_founding_card_subtitle') ?: 'A guided experience designed to help you uncover the story behind your leadership.';
$card_text    = get_field('section_founding_card_text') ?: 'Inside Tell Your Story, you\'ll move through a structured self-guided course experience with Joanna designed to help you identify the defining moments, emotional truths, and deeper why behind your message.';
$date         = get_field('section_founding_date') ?: 'September 17-20, 2027';
$features     = get_field('section_founding_features');
$default_features = [
    ['item_text' => 'Four guided self-paced modules'],
    ['item_text' => 'Community connection with like-minded leaders'],
    ['item_text' => 'Reflective prompts and story exercises'],
    ['item_text' => 'Story sharing, refinement, and feedback'],
    ['item_text' => 'Defining moment and "why" discovery'],
    ['item_text' => 'Immersive retreat experience with Joanna'],
];
$features     = ! empty($features) ? $features : $default_features;
?>

<style>
.tys-founding-ellipse--right {
    position: absolute;
    width: 1535px;
    height: 1535px;
    right: -400px;
    top: -200px;
    background: #0e326e;
    filter: blur(120px);
    opacity: 0.6;
    border-radius: 50%;
    z-index: 0;
    pointer-events: none;
}
.tys-founding-ellipse--left {
    position: absolute;
    width: 1525px;
    height: 1525px;
    left: -500px;
    top: -300px;
    background: radial-gradient(circle, #d4b478 0%, transparent 70%);
    filter: blur(80px);
    opacity: 0.35;
    border-radius: 50%;
    z-index: 0;
    pointer-events: none;
}
</style>

<section class="px-5 sm:px-10 py-5 sm:py-10">
    <div class="relative bg-navy bg-center bg-no-repeat bg-cover rounded-[20px] py-24 lg:py-32 px-5 overflow-hidden" style="<?= $bg_id ? 'background-image:url(\'' . esc_url(wp_get_attachment_url($bg_id)) . '\');' : '' ?>">
        <!-- Ellipse blurs -->
        <div class="tys-founding-ellipse--right"></div>
        <div class="tys-founding-ellipse--left"></div>

        <!-- Logo watermark at top -->
        <?php if ($logo_id): ?>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 z-10 pointer-events-none">
            <?= wp_get_attachment_image($logo_id, 'full', false, ['class' => 'w-auto h-auto', 'alt' => 'Logo']) ?>
        </div>
        <?php endif; ?>

        <div class="relative z-[1] max-w-[903px] mx-auto text-center pt-12 lg:pt-16">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-white leading-[1.1] mb-6">
                <?= $heading ?>
            </h2>

            <p class="font-garet font-light text-lg text-white leading-[1.6] mb-12 max-w-[700px] mx-auto">
                <?= $subhead ?>
            </p>

            <div class="bg-white/10 backdrop-blur-[10px] border border-white/15 rounded-2xl p-8 lg:p-14 text-left">
                <div class="text-center">
                    <div class="font-flatline font-semibold text-2xl md:text-3xl lg:text-[32px] text-gold leading-[1.1] mb-3">
                        <?= esc_html($card_title) ?>
                    </div>
                    <div class="font-garet font-bold text-lg text-white leading-[1.4] mb-4">
                        <?= esc_html($card_sub) ?>
                    </div>
                    <p class="font-garet font-light text-base text-white leading-[1.6] mb-8 text-center">
                        <?= esc_html($card_text) ?>
                    </p>
                </div>

                <div class="text-center mb-8">
                    <div class="inline-flex items-center gap-2.5 font-garet font-bold text-base text-white border border-white/30 rounded-full px-5 py-2.5">
                        <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.5" />
                            <path d="M3 9h18M8 3v4M16 3v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        <?= esc_html($date) ?>
                    </div>
                </div>

                <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 list-none">
                    <?php foreach ($features as $f): ?>
                        <li class="flex items-start gap-3 font-garet font-light text-base text-white leading-[1.5] before:content-['✦'] before:text-gold before:flex-shrink-0 before:mt-0.5 before:text-sm">
                            <?= esc_html($f['item_text']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>
```

- [ ] **Step 2: Run PHP syntax check**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
php -l template-parts/section-tell-your-story-founding.php
```

Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
git add template-parts/section-tell-your-story-founding.php
git commit -m "feat(template): add Tell Your Story founding section"
```

---

## Task 7: Create carousel section template part (with JS)

**Files:**
- Create: `template-parts/section-tell-your-story-carousel.php`

- [ ] **Step 1: Create the carousel template part**

Write to `template-parts/section-tell-your-story-carousel.php`:

```php
<?php

/**
 * Tell Your Story Page - Carousel Section template part.
 *
 * @package TailPress
 */

$images = get_field('section_carousel_images');
$default_image_files = [
    'tell-story-carousel-1.webp',
    'tell-story-carousel-2.webp',
    'tell-story-carousel-3.webp',
    'tell-story-carousel-4.webp',
    'tell-story-carousel-5.webp',
    'tell-story-carousel-6.webp',
];

if (empty($images)) {
    $images = [];
    foreach ($default_image_files as $file) {
        $id = attachment_url_to_postid(get_template_directory_uri() . '/assets/images/' . $file);
        $images[] = ['item_image' => $id];
    }
}
?>

<section id="pricing" class="bg-canvas py-16 lg:py-20 overflow-hidden">
    <div class="relative w-full overflow-hidden">
        <div class="tys-carousel-track flex gap-2 w-max">
            <?php foreach ($images as $img): ?>
                <?php $img_id = is_array($img) ? ($img['item_image'] ?? null) : $img; ?>
                <?php if ($img_id): ?>
                    <div class="tys-carousel-card w-[280px] md:w-[360px] h-[187px] md:h-[240px] rounded-[10px] overflow-hidden flex-shrink-0 bg-navy">
                        <?= wp_get_attachment_image($img_id, 'full', false, ['class' => 'w-full h-full object-cover block']) ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="flex items-center justify-center gap-4 mt-8">
        <button type="button" class="tys-carousel-prev w-[52px] h-[52px] rounded-full bg-gold border-0 cursor-pointer flex items-center justify-center transition-all hover:bg-[#ad8b3a] hover:-translate-y-0.5" aria-label="Previous">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                <path d="M19 12H5M5 12L12 5M5 12L12 19" stroke="#0f203d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
        <button type="button" class="tys-carousel-next w-[52px] h-[52px] rounded-full bg-gold border-0 cursor-pointer flex items-center justify-center transition-all hover:bg-[#ad8b3a] hover:-translate-y-0.5" aria-label="Next">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="#0f203d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
    </div>
</section>

<script>
(function () {
    var wrap = document.querySelector('#pricing .tys-carousel-track')?.parentElement;
    var track = document.querySelector('#pricing .tys-carousel-track');
    var prev = document.querySelector('#pricing .tys-carousel-prev');
    var next = document.querySelector('#pricing .tys-carousel-next');
    if (!track || !prev || !next || !wrap) return;

    function cardWidth() {
        var card = track.querySelector('.tys-carousel-card');
        if (!card) return 368;
        return card.getBoundingClientRect().width + 8; // 8 = gap-2
    }

    prev.addEventListener('click', function () {
        var max = wrap.scrollWidth - wrap.clientWidth;
        var next = wrap.scrollLeft - cardWidth();
        wrap.scrollTo({ left: next < 0 ? max : next, behavior: 'smooth' });
    });
    next.addEventListener('click', function () {
        var max = wrap.scrollWidth - wrap.clientWidth;
        var next = wrap.scrollLeft + cardWidth();
        wrap.scrollTo({ left: next > max ? 0 : next, behavior: 'smooth' });
    });
})();
</script>
```

- [ ] **Step 2: Run PHP syntax check**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
php -l template-parts/section-tell-your-story-carousel.php
```

Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
git add template-parts/section-tell-your-story-carousel.php
git commit -m "feat(template): add Tell Your Story carousel section with prev/next JS"
```

---

## Task 8: Create transformations section template part (with inline styles)

**Files:**
- Create: `template-parts/section-tell-your-story-transformations.php`

- [ ] **Step 1: Create the transformations template part**

Write to `template-parts/section-tell-your-story-transformations.php`:

```php
<?php

/**
 * Tell Your Story Page - Transformations Section template part.
 *
 * @package TailPress
 */

$bg_id           = get_field('section_transformations_background');
$portrait_id     = get_field('section_transformations_portrait');
$headline        = get_field('section_transformations_headline') ?: 'Some Transformations Can\'t be Explained.<br>They Have to be <em class="text-gold italic">Experienced.</em>';
$subtitle        = get_field('section_transformations_subtitle') ?: 'When your story becomes clear, so does your leadership.';
$card_1          = get_field('section_transformations_card_1') ?: 'You stop trying to sound convincing.';
$card_2          = get_field('section_transformations_card_2') ?: 'You stop over-explaining.';
$card_3          = get_field('section_transformations_card_3') ?: 'You stop searching for the right words.';
$banner          = get_field('section_transformations_banner') ?: 'Because your message finally comes from something real.';
?>

<style>
.tys-transformations-bg-wrap {
    position: absolute;
    width: 100%;
    height: 100%;
    bottom: 0;
    pointer-events: none;
}
.tys-transformations-fade-top,
.tys-transformations-fade-bottom {
    position: absolute;
    left: 0;
    right: 0;
    height: 200px;
    z-index: 1;
    pointer-events: none;
}
.tys-transformations-fade-top { top: 0; background: linear-gradient(to bottom, #f8f4ec 0%, rgba(248, 244, 236, 0) 100%); }
.tys-transformations-fade-bottom { bottom: 0; background: linear-gradient(to top, #f8f4ec 0%, rgba(248, 244, 236, 0) 100%); }
.tys-trans-card { position: absolute; background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); border: 1px solid rgba(255, 255, 255, 0.6); border-radius: 8px; padding: 16px 22px; font-family: "Garet", sans-serif; font-size: 16px; font-weight: 300; color: #0f203d; line-height: 1.4; box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08); width: max-content; }
.tys-trans-card-1 { top: 25%; right: -60%; }
.tys-trans-card-2 { top: 40%; left: -50%; }
.tys-trans-card-3 { right: -50%; bottom: 30%; margin-left: 80px; }
.tys-transformations-banner { position: absolute; bottom: 50px; left: 50%; transform: translateX(-50%); background: rgba(15, 32, 61, 0.85); padding: 18px 40px; border-radius: 4px; z-index: 5; text-align: center; width: max-content; }
.tys-transformations-banner p { font-family: "Garet", sans-serif; font-size: 22px; font-weight: 300; color: #ffffff; line-height: 1.3; }
@media (max-width: 767px) {
    .tys-trans-card { position: relative; top: auto !important; left: auto !important; right: auto !important; bottom: auto !important; margin: 12px 0 !important; width: 100% !important; }
    .tys-transformations-cards { position: relative; inset: auto; z-index: 4; pointer-events: auto; margin-top: 20px; }
    .tys-transformations-banner { position: relative; bottom: auto; left: auto; transform: none; margin-top: 24px; width: 100%; }
}
</style>

<section class="relative bg-canvas overflow-hidden">
    <!-- Background image with fades -->
    <div class="tys-transformations-bg-wrap">
        <?php if ($bg_id): ?>
            <?= wp_get_attachment_image($bg_id, 'full', false, ['class' => 'absolute inset-0 w-full h-full object-cover z-0', 'aria-hidden' => 'true']) ?>
        <?php endif; ?>
        <div class="tys-transformations-fade-top"></div>
        <div class="tys-transformations-fade-bottom"></div>
    </div>

    <div class="relative z-[2] max-w-[1100px] mx-auto py-16 lg:py-24 px-5">
        <div class="text-center max-w-[700px] mx-auto mb-6">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                <?= $headline ?>
            </h2>
        </div>

        <p class="relative z-[3] text-center font-garet font-light text-lg text-navy leading-[1.5] mt-4 mb-10">
            <?= esc_html($subtitle) ?>
        </p>

        <div class="relative w-fit mx-auto mb-[-20px]">
            <?php if ($portrait_id): ?>
                <?= wp_get_attachment_image($portrait_id, 'full', false, ['class' => 'w-full h-auto block', 'alt' => 'Joanna Horton McPherson']) ?>
            <?php endif; ?>

            <div class="tys-transformations-cards absolute inset-0 z-[4] pointer-events-none">
                <div class="tys-trans-card tys-trans-card-1"><?= esc_html($card_1) ?></div>
                <div class="tys-trans-card tys-trans-card-2"><?= esc_html($card_2) ?></div>
                <div class="tys-trans-card tys-trans-card-3"><?= esc_html($card_3) ?></div>
            </div>
        </div>

        <div class="tys-transformations-banner">
            <p><?= esc_html($banner) ?></p>
        </div>
    </div>
</section>
```

- [ ] **Step 2: Run PHP syntax check**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
php -l template-parts/section-tell-your-story-transformations.php
```

Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
git add template-parts/section-tell-your-story-transformations.php
git commit -m "feat(template): add Tell Your Story transformations section with floating cards"
```

---

## Task 9: Create pricing section template part (with inline styles)

**Files:**
- Create: `template-parts/section-tell-your-story-pricing.php`

- [ ] **Step 1: Create the pricing template part**

Write to `template-parts/section-tell-your-story-pricing.php`:

```php
<?php

/**
 * Tell Your Story Page - Pricing Section template part.
 *
 * @package TailPress
 */

$bg_id            = get_field('section_pricing_background');
$heading          = get_field('section_pricing_heading') ?: 'Join the Course &amp; Retreat<br><em class="italic">Experience</em>';
$subhead          = get_field('section_pricing_subhead') ?: 'This inaugural course &amp; retreat experience is intentionally intimate to preserve depth, connection, and transformation.';
$label            = get_field('section_pricing_label') ?: 'Investment';
$original_price   = get_field('section_pricing_original_price') ?: '$12,000';
$price            = get_field('section_pricing_price') ?: '$3,200';
$footnote         = get_field('section_pricing_footnote') ?: 'Includes the transformational course and retreat experience.<br>Travel &amp; accommodations <strong>not</strong> included.';
$cta_text         = get_field('section_pricing_cta_text') ?: 'JOIN THE COURSE & RETREAT';
$cta_url          = get_field('section_pricing_cta_url') ?: 'https://true-influence-method.mykajabi.com/offers/zvLu7zev/checkout';
?>

<style>
.tys-pricing-ellipse--right { position: absolute; width: 1454px; height: 1454px; right: -400px; top: -400px; background: radial-gradient(circle, #d4b478 0%, transparent 70%); filter: blur(100px); opacity: 0.5; border-radius: 50%; z-index: 0; pointer-events: none; }
.tys-pricing-ellipse--left  { position: absolute; width: 837px;  height: 837px;  left: -300px; bottom: -300px; background: radial-gradient(circle, #d4b478 0%, transparent 70%); filter: blur(100px); opacity: 0.4; border-radius: 50%; z-index: 0; pointer-events: none; }
</style>

<section class="px-5 sm:px-10 py-5 sm:py-10">
    <div class="relative bg-warm-beige py-24 lg:py-32 px-5 overflow-hidden rounded-[20px]" id="pricing-card">
        <?php if ($bg_id): ?>
            <div class="absolute inset-0 bg-center bg-cover bg-no-repeat z-0" style="background-image:url('<?= esc_url(wp_get_attachment_url($bg_id)) ?>');"></div>
        <?php endif; ?>
        <div class="tys-pricing-ellipse--right"></div>
        <div class="tys-pricing-ellipse--left"></div>

        <div class="relative z-[1] max-w-[830px] mx-auto text-center">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[64px] text-navy leading-[1.1] mb-6">
                <?= $heading ?>
            </h2>

            <p class="font-garet font-light text-lg text-navy leading-[1.6] mb-12 max-w-[600px] mx-auto">
                <?= $subhead ?>
            </p>

            <div class="w-full max-w-[677px] h-px bg-navy/20 mx-auto mb-8"></div>

            <div class="font-flatline font-semibold text-2xl md:text-3xl lg:text-[32px] text-navy mb-6">
                <?= esc_html($label) ?>
            </div>

            <div class="flex items-baseline justify-center gap-6 mb-4">
                <span class="font-flatline font-semibold text-2xl md:text-3xl lg:text-[32px] text-navy/40 line-through">
                    <?= esc_html($original_price) ?>
                </span>
                <span class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[56px] text-[#ad8b3a] leading-none">
                    <?= esc_html($price) ?>
                </span>
            </div>

            <p class="font-garet font-light text-base text-navy leading-[1.6] mb-8">
                <?= $footnote ?>
            </p>

            <a href="<?= esc_url($cta_url) ?>" class="inline-flex items-center justify-center gap-3 bg-gradient-to-r from-warm-beige to-gold border border-gold rounded-full px-9 py-[18px] font-flatline font-bold text-base text-navy transition-transform duration-200 hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(212,180,120,0.4)]">
                <?= esc_html($cta_text) ?>
                <svg class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none">
                    <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="#0f203d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>
</section>
```

- [ ] **Step 2: Run PHP syntax check**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
php -l template-parts/section-tell-your-story-pricing.php
```

Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
git add template-parts/section-tell-your-story-pricing.php
git commit -m "feat(template): add Tell Your Story pricing section"
```

---

## Task 10: Create FAQ section template part (with JS)

**Files:**
- Create: `template-parts/section-tell-your-story-faq.php`

- [ ] **Step 1: Create the FAQ template part**

Write to `template-parts/section-tell-your-story-faq.php`:

```php
<?php

/**
 * Tell Your Story Page - FAQ Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_faq_heading') ?: 'Frequently Asked<br><em class="text-gold italic">Questions</em>';
$items   = get_field('section_faq_items');
$default_items = [
    ['item_question' => 'What happens during the retreat?',                'item_answer' => "Tell Your Story is an immersive transformational experience designed to help leaders reconnect with the story behind their voice, leadership, and influence. Through guided reflection, live story sharing, emotional feedback, and intimate group experiences, participants begin clarifying the message that feels most true to who they are.", 'item_open' => 1],
    ['item_question' => 'Do I need speaking experience?',                   'item_answer' => "No. This experience is not about becoming a polished performer. It's about reconnecting with the truth behind your voice so your message feels more grounded, clear, and emotionally honest.", 'item_open' => 0],
    ['item_question' => 'Is this for leaders or speakers?',                 'item_answer' => "Both. Tell Your Story is designed for leaders, founders, visionaries, and speakers who want to communicate with deeper trust, clarity, and emotional connection.", 'item_open' => 0],
    ['item_question' => "What's included?",                                  'item_answer' => "Your investment includes the transformational course experience, retreat sessions, guided exercises, live story work, and immersive group experiences throughout the retreat. Travel and accommodations are not included.", 'item_open' => 0],
    ['item_question' => 'Is travel included?',                               'item_answer' => "No. Travel and accommodations are separate so participants can choose the arrangements that best support their experience.", 'item_open' => 0],
    ['item_question' => "What if I'm not fully clear on my message yet?",    'item_answer' => "That's exactly why this experience exists. Tell Your Story is designed for people who know there's something deeper they want to communicate — even if they don't fully have the words for it yet.", 'item_open' => 0],
];
$items   = ! empty($items) ? $items : $default_items;
?>

<section class="bg-canvas py-24 lg:py-32 px-5">
    <div class="max-w-[1100px] mx-auto flex flex-col lg:flex-row items-start gap-12 lg:gap-20">
        <div class="w-full lg:w-[40%] flex-shrink-0">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                <?= $heading ?>
            </h2>
        </div>

        <div class="w-full lg:flex-1 flex flex-col">
            <?php foreach ($items as $i => $item):
                $is_open = ! empty($item['item_open']); ?>
                <div class="tys-faq-item border-t border-navy/15 <?= $is_open ? 'open' : '' ?><?= $i === count($items) - 1 ? ' border-b border-navy/15' : '' ?>">
                    <button type="button" class="tys-faq-question w-full bg-transparent border-0 py-6 flex items-center justify-between gap-4 cursor-pointer font-garet font-medium text-lg text-navy text-left">
                        <span><?= esc_html($item['item_question']) ?></span>
                        <span class="tys-faq-icon relative w-6 h-6 flex-shrink-0">
                            <span class="absolute top-1/2 left-0 right-0 h-0.5 bg-navy -translate-y-1/2 block"></span>
                            <span class="tys-faq-icon-bar absolute top-0 bottom-0 left-1/2 w-0.5 bg-navy -translate-x-1/2 block transition-transform duration-300"></span>
                        </span>
                    </button>
                    <div class="tys-faq-answer max-h-0 overflow-hidden transition-all duration-300">
                        <div class="bg-navy text-white py-7 px-8 rounded-xl font-garet font-light text-base leading-[1.6] mt-2 mb-6">
                            <?= esc_html($item['item_answer']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
.tys-faq-item.open .tys-faq-answer { max-height: 500px; }
.tys-faq-item.open .tys-faq-icon-bar { transform: translateX(-50%) scaleY(0); }
</style>

<script>
(function () {
    var faqItems = document.querySelectorAll('.tys-faq-item');
    faqItems.forEach(function (item) {
        var btn = item.querySelector('.tys-faq-question');
        if (!btn) return;
        btn.addEventListener('click', function () {
            var isOpen = item.classList.contains('open');
            faqItems.forEach(function (i) { i.classList.remove('open'); });
            if (!isOpen) item.classList.add('open');
        });
    });
})();
</script>
```

- [ ] **Step 2: Run PHP syntax check**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
php -l template-parts/section-tell-your-story-faq.php
```

Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
git add template-parts/section-tell-your-story-faq.php
git commit -m "feat(template): add Tell Your Story FAQ section with accordion JS"
```

---

## Task 11: Create modal section template part (with full JS)

**Files:**
- Create: `template-parts/section-tell-your-story-modal.php`

- [ ] **Step 1: Create the modal template part**

Write to `template-parts/section-tell-your-story-modal.php`:

```php
<?php

/**
 * Tell Your Story Page - Exit-Intent Modal template part.
 *
 * @package TailPress
 */

$enabled        = (bool) get_field('section_modal_enabled');
if (! $enabled) {
    return;
}

$delay           = (int) (get_field('section_modal_delay_seconds') ?: 3);
$badge           = get_field('section_modal_badge') ?: 'STAY IN THE LOOP';
$title           = get_field('section_modal_title') ?: 'Before You Go…';
$subtitle        = get_field('section_modal_subtitle') ?: 'Join the <strong>True Influence Method</strong> email list to receive insights, stories, and message-building strategies straight to your inbox.';
$message_label   = get_field('section_modal_message_label') ?: "What's the message you struggle most to put into words?";
$consent_text    = get_field('section_modal_consent_text') ?: 'By checking this box, I agree to receive marketing and informational emails, SMS text messages, and phone calls from True Influence Method™️ at the contact info provided, including via automated technology. Consent is not a condition of purchase. Message and data rates may apply. Message frequency varies. Reply STOP to opt out.';
$submit_text     = get_field('section_modal_submit_text') ?: 'SUBSCRIBE';
$success_title   = get_field('section_modal_success_title') ?: "You're Subscribed! 🎉";
$success_text    = get_field('section_modal_success_text') ?: 'Welcome to the <strong>True Influence Method</strong> community. Check your inbox for a welcome email — we\'re glad to have you.';
$webhook_url     = get_field('section_modal_webhook_url') ?: 'https://services.leadconnectorhq.com/hooks/txFvEqJbQlKriCxJl8w3/webhook-trigger/ed78846f-c6f9-4e59-8c42-13a8aebe2798';
?>

<style>
.tys-modal-overlay { position: fixed; inset: 0; z-index: 9999; background: rgba(15, 32, 61, 0.7); display: flex; align-items: center; justify-content: center; padding: 20px; opacity: 0; visibility: hidden; transition: opacity 0.4s ease, visibility 0.4s ease; backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); }
.tys-modal-overlay.active { opacity: 1; visibility: visible; }
.tys-modal-card { background: #ffffff; border-radius: 24px; max-width: 580px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 48px 40px 40px; position: relative; box-shadow: 0 24px 80px rgba(15, 32, 61, 0.3); transform: translateY(30px) scale(0.97); transition: transform 0.4s ease; }
.tys-modal-overlay.active .tys-modal-card { transform: translateY(0) scale(1); }
.tys-modal-close { position: absolute; top: 16px; right: 16px; width: 36px; height: 36px; border-radius: 50%; border: none; background: #f0ede6; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s ease; color: #1e1e1e; }
.tys-modal-close:hover { background: #e0dbd0; }
.tys-modal-close svg { width: 18px; height: 18px; display: block; }
.tys-modal-badge { display: inline-flex; align-items: center; justify-content: center; background: rgba(212, 180, 120, 0.15); border-radius: 20px; padding: 6px 16px; margin-bottom: 16px; font-family: "Flatline Sans", sans-serif; font-size: 11px; font-weight: 700; color: #d4b478; letter-spacing: 0.2em; text-transform: uppercase; }
.tys-modal-title { font-family: "Flatline Sans", sans-serif; font-size: 28px; font-weight: 600; color: #0f203d; line-height: 1.2; margin-bottom: 8px; }
.tys-modal-subtitle { font-family: "Garet", sans-serif; font-size: 15px; font-weight: 300; color: #555; line-height: 1.5; margin-bottom: 28px; }
.tys-modal-form { display: flex; flex-direction: column; gap: 16px; }
.tys-modal-field { display: flex; flex-direction: column; gap: 6px; }
.tys-modal-label { font-family: "Flatline Sans", sans-serif; font-size: 13px; font-weight: 600; color: #0f203d; letter-spacing: 0.03em; }
.tys-modal-input, .tys-modal-textarea { width: 100%; padding: 14px 16px; border: 1.5px solid #e0dbd0; border-radius: 12px; font-family: "Garet", sans-serif; font-size: 15px; color: #1e1e1e; background: #faf8f4; transition: border-color 0.2s ease, box-shadow 0.2s ease; outline: none; box-sizing: border-box; }
.tys-modal-input::placeholder, .tys-modal-textarea::placeholder { color: #aaa; }
.tys-modal-input:focus, .tys-modal-textarea:focus { border-color: #d4b478; box-shadow: 0 0 0 3px rgba(212, 180, 120, 0.15); background: #ffffff; }
.tys-modal-textarea { min-height: 100px; resize: vertical; }
.tys-modal-checkbox-wrap { display: flex; align-items: flex-start; gap: 10px; margin-top: 4px; }
.tys-modal-checkbox-wrap input[type="checkbox"] { width: 18px; height: 18px; min-width: 18px; margin-top: 2px; accent-color: #d4b478; cursor: pointer; }
.tys-modal-checkbox-label { font-family: "Garet", sans-serif; font-size: 12px; font-weight: 300; color: #777; line-height: 1.5; cursor: pointer; }
.tys-modal-submit { width: 100%; padding: 16px 24px; background: radial-gradient(circle at center, #e7d4c5, #d4b478); border: 1px solid #e7d4c5; border-radius: 40px; font-family: "Flatline Sans", sans-serif; font-size: 16px; font-weight: 700; color: #0f203d; cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease; margin-top: 8px; }
.tys-modal-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(212, 180, 120, 0.35); }
.tys-modal-submit:active { transform: translateY(0); }
.tys-modal-success { text-align: center; padding: 32px 16px; display: none; }
.tys-modal-success.show { display: block; }
.tys-modal-success-icon { width: 56px; height: 56px; margin: 0 auto 20px; background: #d4b478; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.tys-modal-success-icon svg { width: 28px; height: 28px; stroke: #ffffff; fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }
.tys-modal-success-title { font-family: "Flatline Sans", sans-serif; font-size: 22px; font-weight: 600; color: #0f203d; margin-bottom: 8px; }
.tys-modal-success-text { font-family: "Garet", sans-serif; font-size: 15px; font-weight: 300; color: #555; }
@media (max-width: 500px) {
    .tys-modal-card { padding: 36px 24px 28px; }
    .tys-modal-title { font-size: 22px; }
}
</style>

<div class="tys-modal-overlay" id="tysModal" data-delay="<?= esc_attr($delay) ?>" data-webhook="<?= esc_attr($webhook_url) ?>">
    <div class="tys-modal-card">
        <button type="button" class="tys-modal-close" id="tysModalClose" aria-label="Close popup">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>

        <div id="tysModalFormView">
            <div class="tys-modal-badge"><?= esc_html($badge) ?></div>
            <h2 class="tys-modal-title"><?= esc_html($title) ?></h2>
            <p class="tys-modal-subtitle"><?= $subtitle ?></p>

            <form class="tys-modal-form" id="tysModalForm">
                <div class="tys-modal-field">
                    <label class="tys-modal-label" for="tysModalName">Name</label>
                    <input class="tys-modal-input" type="text" id="tysModalName" name="name" placeholder="Your full name" required>
                </div>
                <div class="tys-modal-field">
                    <label class="tys-modal-label" for="tysModalPhone">Phone</label>
                    <input class="tys-modal-input" type="tel" id="tysModalPhone" name="phone" placeholder="(555) 123-4567" required>
                </div>
                <div class="tys-modal-field">
                    <label class="tys-modal-label" for="tysModalEmail">Email</label>
                    <input class="tys-modal-input" type="email" id="tysModalEmail" name="email" placeholder="you@example.com" required>
                </div>
                <div class="tys-modal-field">
                    <label class="tys-modal-label" for="tysModalMessage"><?= esc_html($message_label) ?></label>
                    <textarea class="tys-modal-textarea" id="tysModalMessage" name="message" placeholder="Share what's on your heart…" rows="4"></textarea>
                </div>
                <div class="tys-modal-checkbox-wrap">
                    <input type="checkbox" id="tysModalConsent" name="consent" required>
                    <label class="tys-modal-checkbox-label" for="tysModalConsent"><?= esc_html($consent_text) ?></label>
                </div>
                <button type="submit" class="tys-modal-submit"><?= esc_html($submit_text) ?></button>
            </form>
        </div>

        <div class="tys-modal-success" id="tysModalSuccessView">
            <div class="tys-modal-success-icon">
                <svg viewBox="0 0 24 24"><path d="M20 6L9 17L4 12" /></svg>
            </div>
            <h3 class="tys-modal-success-title"><?= esc_html($success_title) ?></h3>
            <p class="tys-modal-success-text"><?= $success_text ?></p>
        </div>
    </div>
</div>

<script>
(function () {
    "use strict";
    var overlay     = document.getElementById("tysModal");
    if (!overlay) return;
    var closeBtn    = document.getElementById("tysModalClose");
    var form        = document.getElementById("tysModalForm");
    var formView    = document.getElementById("tysModalFormView");
    var successView = document.getElementById("tysModalSuccessView");
    var consent     = document.getElementById("tysModalConsent");
    var webhookUrl  = overlay.getAttribute("data-webhook") || "";
    var delay       = parseInt(overlay.getAttribute("data-delay") || "3", 10) * 1000;
    var shown       = false;
    var submitted   = false;

    function openModal() {
        if (shown) return;
        shown = true;
        overlay.classList.add("active");
        document.body.style.overflow = "hidden";
    }
    function closeModal() {
        overlay.classList.remove("active");
        document.body.style.overflow = "";
    }

    setTimeout(openModal, delay);

    if (closeBtn) closeBtn.addEventListener("click", closeModal);
    overlay.addEventListener("click", function (e) { if (e.target === overlay) closeModal(); });
    document.addEventListener("keydown", function (e) { if (e.key === "Escape" && overlay.classList.contains("active")) closeModal(); });

    if (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            if (submitted) return;
            var name    = (document.getElementById("tysModalName")    || {}).value || "";
            var phone   = (document.getElementById("tysModalPhone")   || {}).value || "";
            var email   = (document.getElementById("tysModalEmail")   || {}).value || "";
            var message = (document.getElementById("tysModalMessage") || {}).value || "";
            name = name.trim(); phone = phone.trim(); email = email.trim(); message = message.trim();
            if (!name || !phone || !email) { alert("Please fill in your name, phone, and email."); return; }
            if (!consent || !consent.checked) { alert("Please agree to the consent terms."); return; }
            submitted = true;
            var submitBtn = form.querySelector(".tys-modal-submit");
            var originalText = submitBtn.textContent;
            submitBtn.textContent = "SUBMITTING…";
            submitBtn.disabled = true;
            fetch(webhookUrl, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ name: name, phone: phone, email: email, message: message })
            }).then(function (r) {
                if (!r.ok) throw new Error("Server responded with " + r.status);
                return r.text();
            }).then(function () {
                formView.style.display = "none";
                successView.classList.add("show");
                setTimeout(function () {
                    closeModal();
                    setTimeout(function () {
                        formView.style.display = "";
                        successView.classList.remove("show");
                        form.reset();
                        submitted = false;
                        shown = false;
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }, 400);
                }, 4000);
            }).catch(function (err) {
                console.error("Submission failed:", err);
                alert("Something went wrong. Please try again.");
                submitted = false;
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });
    }
})();
</script>
```

- [ ] **Step 2: Run PHP syntax check**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
php -l template-parts/section-tell-your-story-modal.php
```

Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
git add template-parts/section-tell-your-story-modal.php
git commit -m "feat(template): add Tell Your Story exit-intent modal with full JS"
```

---

## Task 12: Add `seed_tell_your_story()` method to seeder

**Files:**
- Modify: `wp-cli/seeder.php` (add new method)

- [ ] **Step 1: Locate the end of `seed_master_my_message()` and insert the new method after it**

Open `wp-cli/seeder.php`. Find the line that reads `private function seed_million_dollar_message($force = false)` (around line 768). Immediately **before** that line, add the new method. The full new method (paste verbatim) is:

```php
    private function seed_tell_your_story($force = false)
    {
        $page_id = $this->get_page_id('tell-your-story');
        if (! $page_id) {
            return;
        }

        $this->update_acf_field('section_hero_logo', $this->upload_image('tell-story-logo.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_background', $this->upload_image('tell-story-hero-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_hero_eyebrow', 'Tell Your Story', $page_id, $force);
        $this->update_acf_field('section_hero_heading', 'Where Leaders<br>Tell The <em class="text-gold italic">Truth.</em>', $page_id, $force);
        $this->update_acf_field('section_hero_subtitle', 'Tell Your Story is the <strong>transformational course + retreat experience</strong> inside the True Influence Method. Created for leaders ready to reconnect with the story behind their influence.', $page_id, $force);
        $this->update_acf_field('section_hero_cta_text', 'VIEW THE RETREAT EXPERIENCE', $page_id, $force);
        $this->update_acf_field('section_hero_cta_url', '#pricing', $page_id, $force);

        $this->update_acf_field('section_speaking_heading', 'This Is <em class="text-gold italic">Not</em> Just Speaking Training; It&rsquo;s Leading from the Stage', $page_id, $force);
        $this->update_acf_field('section_speaking_paragraphs', [
            ['item_text' => 'This is the work of uncovering the moments that shaped your voice, your leadership, and the way people experience you.'],
            ['item_text' => 'Inside the retreat, leaders reconnect with the truth behind their message so their words stop sounding practiced and start feeling real.'],
        ], $page_id, $force);
        $this->update_acf_field('section_speaking_image_bg', $this->upload_image('tell-story-speaking-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_speaking_image_fg', $this->upload_image('tell-story-speaking-fg.webp'), $page_id, $force);

        $this->update_acf_field('section_founding_logo', $this->upload_image('tell-story-founding-logo.webp'), $page_id, $force);
        $this->update_acf_field('section_founding_background', $this->upload_image('tell-story-founding-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_founding_heading', 'Be Part of the<br><em class="text-gold italic">Founding Experience.</em>', $page_id, $force);
        $this->update_acf_field('section_founding_subhead', 'This retreat marks the <strong>beginning of a new chapter</strong> inside the True Influence Method &mdash; bringing together a small group of leaders ready to uncover the story behind their influence.', $page_id, $force);
        $this->update_acf_field('section_founding_card_title', 'Inside the Experience', $page_id, $force);
        $this->update_acf_field('section_founding_card_subtitle', 'A guided experience designed to help you uncover the story behind your leadership.', $page_id, $force);
        $this->update_acf_field('section_founding_card_text', 'Inside Tell Your Story, you&rsquo;ll move through a structured self-guided course experience with Joanna designed to help you identify the defining moments, emotional truths, and deeper why behind your message.', $page_id, $force);
        $this->update_acf_field('section_founding_date', 'September 17-20, 2027', $page_id, $force);
        $this->update_acf_field('section_founding_features', [
            ['item_text' => 'Four guided self-paced modules'],
            ['item_text' => 'Community connection with like-minded leaders'],
            ['item_text' => 'Reflective prompts and story exercises'],
            ['item_text' => 'Story sharing, refinement, and feedback'],
            ['item_text' => 'Defining moment and "why" discovery'],
            ['item_text' => 'Immersive retreat experience with Joanna'],
        ], $page_id, $force);

        $this->update_acf_field('section_carousel_images', [
            ['item_image' => $this->upload_image('tell-story-carousel-1.webp')],
            ['item_image' => $this->upload_image('tell-story-carousel-2.webp')],
            ['item_image' => $this->upload_image('tell-story-carousel-3.webp')],
            ['item_image' => $this->upload_image('tell-story-carousel-4.webp')],
            ['item_image' => $this->upload_image('tell-story-carousel-5.webp')],
            ['item_image' => $this->upload_image('tell-story-carousel-6.webp')],
        ], $page_id, $force);

        $this->update_acf_field('section_transformations_background', $this->upload_image('tell-story-transformations-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_transformations_portrait', $this->upload_image('tell-story-transformations-portrait.webp'), $page_id, $force);
        $this->update_acf_field('section_transformations_headline', 'Some Transformations Can&rsquo;t be Explained.<br>They Have to be <em class="text-gold italic">Experienced.</em>', $page_id, $force);
        $this->update_acf_field('section_transformations_subtitle', 'When your story becomes clear, so does your leadership.', $page_id, $force);
        $this->update_acf_field('section_transformations_card_1', 'You stop trying to sound convincing.', $page_id, $force);
        $this->update_acf_field('section_transformations_card_2', 'You stop over-explaining.', $page_id, $force);
        $this->update_acf_field('section_transformations_card_3', 'You stop searching for the right words.', $page_id, $force);
        $this->update_acf_field('section_transformations_banner', 'Because your message finally comes from something real.', $page_id, $force);

        $this->update_acf_field('section_pricing_background', $this->upload_image('tell-story-pricing-bg.webp'), $page_id, $force);
        $this->update_acf_field('section_pricing_heading', 'Join the Course &amp; Retreat<br><em class="italic">Experience</em>', $page_id, $force);
        $this->update_acf_field('section_pricing_subhead', 'This inaugural course &amp; retreat experience is intentionally intimate to preserve depth, connection, and transformation.', $page_id, $force);
        $this->update_acf_field('section_pricing_label', 'Investment', $page_id, $force);
        $this->update_acf_field('section_pricing_original_price', '$12,000', $page_id, $force);
        $this->update_acf_field('section_pricing_price', '$3,200', $page_id, $force);
        $this->update_acf_field('section_pricing_footnote', 'Includes the transformational course and retreat experience.<br>Travel &amp; accommodations <strong>not</strong> included.', $page_id, $force);
        $this->update_acf_field('section_pricing_cta_text', 'JOIN THE COURSE & RETREAT', $page_id, $force);
        $this->update_acf_field('section_pricing_cta_url', 'https://true-influence-method.mykajabi.com/offers/zvLu7zev/checkout', $page_id, $force);

        $this->update_acf_field('section_faq_heading', 'Frequently Asked<br><em class="text-gold italic">Questions</em>', $page_id, $force);
        $this->update_acf_field('section_faq_items', [
            ['item_question' => 'What happens during the retreat?',                'item_answer' => "Tell Your Story is an immersive transformational experience designed to help leaders reconnect with the story behind their voice, leadership, and influence. Through guided reflection, live story sharing, emotional feedback, and intimate group experiences, participants begin clarifying the message that feels most true to who they are.", 'item_open' => 1],
            ['item_question' => 'Do I need speaking experience?',                   'item_answer' => "No. This experience is not about becoming a polished performer. It's about reconnecting with the truth behind your voice so your message feels more grounded, clear, and emotionally honest.", 'item_open' => 0],
            ['item_question' => 'Is this for leaders or speakers?',                 'item_answer' => "Both. Tell Your Story is designed for leaders, founders, visionaries, and speakers who want to communicate with deeper trust, clarity, and emotional connection.", 'item_open' => 0],
            ['item_question' => "What's included?",                                  'item_answer' => "Your investment includes the transformational course experience, retreat sessions, guided exercises, live story work, and immersive group experiences throughout the retreat. Travel and accommodations are not included.", 'item_open' => 0],
            ['item_question' => 'Is travel included?',                               'item_answer' => "No. Travel and accommodations are separate so participants can choose the arrangements that best support their experience.", 'item_open' => 0],
            ['item_question' => "What if I'm not fully clear on my message yet?",    'item_answer' => "That's exactly why this experience exists. Tell Your Story is designed for people who know there's something deeper they want to communicate \u2014 even if they don't fully have the words for it yet.", 'item_open' => 0],
        ], $page_id, $force);

        $this->update_acf_field('section_modal_enabled', 1, $page_id, $force);
        $this->update_acf_field('section_modal_delay_seconds', 3, $page_id, $force);
        $this->update_acf_field('section_modal_badge', 'STAY IN THE LOOP', $page_id, $force);
        $this->update_acf_field('section_modal_title', 'Before You Go\u2026', $page_id, $force);
        $this->update_acf_field('section_modal_subtitle', 'Join the <strong>True Influence Method</strong> email list to receive insights, stories, and message-building strategies straight to your inbox.', $page_id, $force);
        $this->update_acf_field('section_modal_message_label', "What's the message you struggle most to put into words?", $page_id, $force);
        $this->update_acf_field('section_modal_consent_text', 'By checking this box, I agree to receive marketing and informational emails, SMS text messages, and phone calls from True Influence Method\u2122\ufe0f at the contact info provided, including via automated technology. Consent is not a condition of purchase. Message and data rates may apply. Message frequency varies. Reply STOP to opt out.', $page_id, $force);
        $this->update_acf_field('section_modal_submit_text', 'SUBSCRIBE', $page_id, $force);
        $this->update_acf_field('section_modal_success_title', "You're Subscribed! \ud83c\udf89", $page_id, $force);
        $this->update_acf_field('section_modal_success_text', "Welcome to the <strong>True Influence Method</strong> community. Check your inbox for a welcome email \u2014 we're glad to have you.", $page_id, $force);
        $this->update_acf_field('section_modal_webhook_url', 'https://services.leadconnectorhq.com/hooks/txFvEqJbQlKriCxJl8w3/webhook-trigger/ed78846f-c6f9-4e59-8c42-13a8aebe2798', $page_id, $force);
    }

```

- [ ] **Step 2: Run PHP syntax check**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
php -l wp-cli/seeder.php
```

Expected: `No syntax errors detected`

- [ ] **Step 3: Commit**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
git add wp-cli/seeder.php
git commit -m "feat(seeder): add seed_tell_your_story() method"
```

---

## Task 13: Wire seeder into `seed_all`, `seed_seo`, `create_pages`, and footer menu

**Files:**
- Modify: `wp-cli/seeder.php` (4 edits)

- [ ] **Step 1: Add to `seed_all()` page slug list**

Find the `$page_slugs` array inside `seed_all()` (around line 259–266). Add `'tell-your-story',` so the list becomes:

```php
        $page_slugs = [
            'front-page', 'about', '4-session', 'be-remembered',
            'breakthrough-session', 'build-my-team', 'events',
            'get-started', 'inquiry', 'master-my-message',
            'million-dollar-message', 'offers', 'on-stage',
            'speaker-cohort', 'success-stories', 'tell-your-story',
            'thank-you', 'the-authority', 'the-legacy',
            'the-speaker', 'the-vault',
        ];
```

- [ ] **Step 2: Add to `seed_seo()` pages array**

Find the `$pages` array inside `seed_seo()` (around line 130–151). Add a new entry (alphabetical order, after `'success-stories'` and before `'thank-you'`):

```php
            'tell-your-story'    => ['meta_desc' => "Tell Your Story is the transformational course + retreat experience inside the True Influence Method. Reconnect with the story behind your voice, leadership, and influence.", 'og_image' => 'tell-story-hero-bg.webp'],
```

- [ ] **Step 3: Add to BOTH `create_pages()` arrays (lines ~1177 and ~1271)**

Add this entry (alphabetical order, after `'success-stories'` and before `'thank-you'`):

```php
            ['slug' => 'tell-your-story', 'title' => 'Tell Your Story', 'template' => 'Tell Your Story'],
```

- [ ] **Step 4: Update footer Programs menu URL in `create_menus()` (line ~340)**

Find:
```php
            ['title' => 'Tell Your Story', 'url' => home_url('/offers/#tell-your-story')],
```

Replace with:
```php
            ['title' => 'Tell Your Story', 'url' => home_url('/tell-your-story/')],
```

- [ ] **Step 5: Run PHP syntax check**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
php -l wp-cli/seeder.php
```

Expected: `No syntax errors detected`

- [ ] **Step 6: Commit**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
git add wp-cli/seeder.php
git commit -m "feat(seeder): register tell-your-story in seed_all, seed_seo, create_pages, and footer menu"
```

---

## Task 14: Create the page, run the seeder, verify in admin

**Files:** none modified (operational task)

- [ ] **Step 1: Create the page in WordPress**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
wp eval '
$id = wp_insert_post([
    "post_title"   => "Tell Your Story",
    "post_name"    => "tell-your-story",
    "post_type"    => "page",
    "post_status"  => "publish",
    "page_template" => "page-tell-your-story.php",
]);
echo $id ? "Created page ID: $id" : "FAILED";
'
```

Expected: `Created page ID: <number>`

If the page already exists (from a previous run), use:
```bash
wp post list --post_type=page --name=tell-your-story --field=ID
```
to find the existing page ID.

- [ ] **Step 2: Run the seeder for this page**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
wp tim-tailpress seed --page=tell-your-story --force
```

Expected: `Success: Seeded: tell-your-story`

- [ ] **Step 3: Verify ACF fields populated**

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
wp eval '
$pid = get_page_by_path("tell-your-story")->ID;
echo "Heading: "   . get_field("section_hero_heading", $pid) . PHP_EOL;
echo "CTA URL: "   . get_field("section_hero_cta_url", $pid) . PHP_EOL;
echo "Price: "     . get_field("section_pricing_price", $pid) . PHP_EOL;
echo "Modal enabled: " . var_export(get_field("section_modal_enabled", $pid), true) . PHP_EOL;
echo "Carousel count: " . count(get_field("section_carousel_images", $pid) ?: []) . PHP_EOL;
echo "FAQ count: " . count(get_field("section_faq_items", $pid) ?: []) . PHP_EOL;
'
```

Expected: 6 lines of output. `Heading` shows the HTML string with `<em>`. `Carousel count` is 6. `FAQ count` is 6. `Modal enabled` is `true`.

- [ ] **Step 4: Verify page renders in browser**

Open the page in a real browser:
- URL: `https://trueinfluencemethod.test/tell-your-story/` (or your local dev URL)
- Check: navy hero with "Where Leaders Tell The Truth." in gold italic
- Check: 6 carousel images visible
- Check: FAQ items click and accordion opens/closes
- Check: Pricing shows $12,000 (strikethrough) → $3,200
- Check: Modal appears after 3 seconds, X button closes it

If any section is blank or broken, inspect browser dev tools console and network tab.

---

## Task 15: Visual + responsive + interactive + regression verification

**Files:** none modified (verification only)

- [ ] **Step 1: Desktop screenshot at 1280px width**

Use Chrome DevTools MCP (or `chrome-devtools` tools) to navigate to the page, resize to 1280×800, and take a full-page screenshot. Save to `/tmp/tell-story-desktop.png`. Compare visually with source HTML:
- Hero matches
- All 6 carousel cards visible
- Pricing card centered
- Footer matches the global footer

- [ ] **Step 2: Tablet screenshot at 768px width**

Resize to 768×1024. Take screenshot to `/tmp/tell-story-tablet.png`. Check:
- 2-col layouts become single-column at this width
- Speaking section stacks
- FAQ section stacks

- [ ] **Step 3: Mobile screenshot at 375px width**

Resize to 375×812. Take screenshot to `/tmp/tell-story-mobile.png`. Check:
- Transformations cards stack vertically (no absolute positioning at this width)
- Carousel cards become 280px wide
- Founding card padding reduces (no horizontal padding)
- Pricing amount font shrinks to 40px
- Modal card padding reduces to 36px/24px

- [ ] **Step 4: Interactive — FAQ accordion**

Click each FAQ question in the browser:
- Only one item open at a time
- Clicking an open item closes it
- Re-clicking reopens
- Plus icon (vertical bar) rotates to X when open

- [ ] **Step 5: Interactive — Carousel prev/next**

Click prev/next buttons. Cards should:
- Scroll smoothly to the next/prev card
- Wrap around (prev from first → last; next from last → first)

- [ ] **Step 6: Interactive — Modal**

Wait 3 seconds for the modal to appear:
- Modal has correct badge, title, subtitle
- Form fields: name (required), phone (required), email (required), message (optional)
- Consent checkbox required
- Submit button text matches ACF
- Click X to close → closes, body scroll restored
- Press Escape to close → closes
- Fill form, submit → success view shows, auto-closes after 4s

- [ ] **Step 7: No regressions**

Visit these pages and confirm no leakage from the new template (no modal, no new styles affecting them):
- `/` (front page)
- `/offers/`
- `/on-stage/`
- `/master-my-message/`

- [ ] **Step 8: Commit any final tweaks**

If any visual fixes were required (e.g., padding tweak, color adjustment), commit them with a descriptive message. If nothing changed, this step is a no-op.

---

## Completion Checklist

- [ ] All 15 image files in `assets/images/tell-story-*.webp`
- [ ] `acf-json/group_page-tell-your-story.json` validates as JSON
- [ ] `page-tell-your-story.php` passes `php -l`
- [ ] All 8 template parts pass `php -l`
- [ ] `wp-cli/seeder.php` passes `php -l`
- [ ] Page exists at `/tell-your-story/` with the `Tell Your Story` template
- [ ] `wp tim-tailpress seed --page=tell-your-story --force` succeeds
- [ ] Visual: desktop, tablet, mobile screenshots match the source HTML design
- [ ] Interactive: FAQ accordion, carousel, modal all work
- [ ] No regressions on other pages
- [ ] Footer Programs menu now links to `/tell-your-story/` (not the anchor on /offers/)
