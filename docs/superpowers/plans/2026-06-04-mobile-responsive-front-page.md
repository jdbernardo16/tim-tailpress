# Mobile Responsive Front Page Sections Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Fix mobile responsive issues in all 10 front page sections (hero, trusted, you-know, tell-story, discover, journey, speaker, vault, testimonials, voice) at viewports 320–959px, preserving desktop layouts.

**Architecture:** Three parallel subagents (2A, 2B, 2C) each own a non-overlapping set of files. Each makes minimal Tailwind class changes only — no new colors, no JS changes, no new components. Visual verification at the end.

**Tech Stack:** PHP 8.x, WordPress 6.x, Tailwind CSS v4, Chrome DevTools.

**Working Directory:** `/Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress`

**Current Branch:** `mobile-responsive`

---

## File Allocation (No Overlaps)

| Subagent | Files | Sections |
| --- | --- | --- |
| 2A | `section-hero.php`, `section-trusted.php`, `section-you-know.php`, `section-tell-story.php` | Hero (no changes), Trusted, You Know, Tell Your Story |
| 2B | `section-discover.php`, `section-journey.php`, `section-speaker.php` | Discover, Journey, Speaker (Move the Room) |
| 2C | `section-vault.php`, `section-testimonials.php`, `section-voice.php` | Vault, Testimonials, Voice |

**Conflict avoidance:** Each subagent owns a disjoint set of files. They may run in parallel.

---

## Subagent 2A: Hero, Trusted, You Know, Tell Your Story

**Files modified:**
- `template-parts/section-trusted.php`
- `template-parts/section-you-know.php`
- `template-parts/section-tell-story.php`
- (no changes to `section-hero.php` — works on mobile already)

### Task 2A.1: Trusted section — stack heading and stats on mobile

**File:** `template-parts/section-trusted.php:14-19`

- [ ] **Step 1: Make the heading/stats container stack on mobile**

Find:

```php
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex space-x-20 justify-between">
        <p class="text-lg font-flatline font-semibold uppercase tracking-[50%] text-navy mb-12">
            <?= $heading ?>
        </p>
```

Replace with:

```php
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:space-x-20 md:justify-between gap-6 md:gap-0">
        <p class="text-lg font-flatline font-semibold uppercase tracking-[50%] text-navy mb-6 md:mb-12">
            <?= $heading ?>
        </p>
```

- [ ] **Step 2: Verify PHP and commit**

Run: `php -l template-parts/section-trusted.php`
Expected: `No syntax errors detected`

```bash
git add template-parts/section-trusted.php
git commit -m "feat(home): stack trusted heading/stats on mobile"
```

---

### Task 2A.2: You Know section — stack image and text on mobile

**File:** `template-parts/section-you-know.php:15-37`

- [ ] **Step 1: Update outer section padding**

Find:

```php
<section class="bg-[#F8F4EC] py-24 lg:pt-64">
```

Replace with:

```php
<section class="bg-canvas py-16 lg:py-24 lg:pt-64">
```

(Note: `bg-canvas` already maps to OKLCH `oklch(0.9680 0.0114 84.58)` which is `#F8F4EC` — same color, theme token. Verify in `theme.css` first. If `bg-canvas` is slightly different, use the existing `bg-canvas` class as it is the project's official token for this color. **This change is part of cleanup toward the FE rule "no hex codes in classes"** — the `bg-[#F8F4EC]` in the source is a violation that we are fixing.)

- [ ] **Step 2: Update inner flex container to stack**

Find:

```php
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex space-x-16">
        <div class="relative flex-1 h-fit">
```

Replace with:

```php
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row lg:space-x-16 gap-8 lg:gap-0">
        <div class="relative w-full lg:flex-1 h-fit">
```

- [ ] **Step 3: Verify PHP and commit**

```bash
php -l template-parts/section-you-know.php
git add template-parts/section-you-know.php
git commit -m "feat(home): stack you-know image/text on mobile"
```

---

### Task 2A.3: Tell Your Story — reduce mobile horizontal margin

**File:** `template-parts/section-tell-story.php:9`

- [ ] **Step 1: Reduce outer margin on mobile**

Find:

```php
<section class="relative mx-10 rounded-3xl">
```

Replace with:

```php
<section class="relative mx-4 sm:mx-10 rounded-3xl">
```

- [ ] **Step 2: Verify PHP and commit**

```bash
php -l template-parts/section-tell-story.php
git add template-parts/section-tell-story.php
git commit -m "feat(home): reduce tell-story mobile margin"
```

---

## Subagent 2B: Discover, Journey, Speaker

**Files modified:**
- `template-parts/section-discover.php`
- `template-parts/section-journey.php`
- `template-parts/section-speaker.php`

### Task 2B.1: Discover — scale heading and fix absolute image

**File:** `template-parts/section-discover.php`

- [ ] **Step 1: Scale heading and update section margin**

Find:

```php
<section class="relative mx-10 rounded-b-3xl bg-warm-beige overflow-hidden">
```

Replace with:

```php
<section class="relative mx-4 sm:mx-10 rounded-b-3xl bg-warm-beige overflow-hidden">
```

- [ ] **Step 2: Scale the discover heading**

Find:

```php
<h2 class="text-[56px] leading-tight font-flatline">
    <?= $heading ?>
</h2>
```

Replace with:

```php
<h2 class="text-4xl sm:text-5xl lg:text-[56px] leading-tight font-flatline">
    <?= $heading ?>
</h2>
```

- [ ] **Step 3: Fix the absolute image positioning on mobile**

Find:

```php
            <div class="relative flex-1">
                <?php if ($image_id): ?>
                    <?= wp_get_attachment_image($image_id, 'full', false, ['class' => 'w-full', 'alt' => 'Joanna - Discover']) ?>
                <?php endif; ?>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/discover-whole.webp" alt="Joanna - Discover" class="w-full absolute bottom-0 left-0">

            </div>
```

Replace with:

```php
            <div class="relative flex-1 mt-8 lg:mt-0">
                <?php if ($image_id): ?>
                    <?= wp_get_attachment_image($image_id, 'full', false, ['class' => 'w-full', 'alt' => 'Joanna - Discover']) ?>
                <?php endif; ?>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/discover-whole.webp" alt="Joanna - Discover" class="w-full relative lg:absolute lg:bottom-0 lg:left-0 mt-4 lg:mt-0">

            </div>
```

- [ ] **Step 4: Verify PHP and commit**

```bash
php -l template-parts/section-discover.php
git add template-parts/section-discover.php
git commit -m "feat(home): scale discover heading + fix mobile image position"
```

---

### Task 2B.2: Journey — scale phase watermark and improve card aspect

**File:** `template-parts/section-journey.php`

- [ ] **Step 1: Update card aspect ratio for mobile**

Find:

```php
                    <div class="relative rounded-lg overflow-hidden bg-zinc-200 aspect-[1100/362] group">
```

Replace with:

```php
                    <div class="relative rounded-lg overflow-hidden bg-zinc-200 aspect-[16/12] sm:aspect-[1100/362] group">
```

- [ ] **Step 2: Scale the phase watermark**

Find:

```php
                        <!-- Phase Watermark -->
                        <div class="absolute top-3 right-3 font-flatline font-medium text-5xl text-white/20 leading-none select-none">
                            PHASE <?= $phase_num ?>
                        </div>
```

Replace with:

```php
                        <!-- Phase Watermark -->
                        <div class="absolute top-3 right-3 font-flatline font-medium text-3xl sm:text-5xl text-white/20 leading-none select-none">
                            PHASE <?= $phase_num ?>
                        </div>
```

- [ ] **Step 3: Verify PHP and commit**

```bash
php -l template-parts/section-journey.php
git add template-parts/section-journey.php
git commit -m "feat(home): improve journey card aspect + scale phase watermark"
```

---

### Task 2B.3: Speaker (Move the Room) — full mobile rework

**File:** `template-parts/section-speaker.php`

- [ ] **Step 1: Reduce outer section margin**

Find:

```php
<section class="relative mx-10 rounded-3xl overflow-hidden bg-navy">
```

Replace with:

```php
<section class="relative mx-4 sm:mx-10 rounded-3xl overflow-hidden bg-navy">
```

- [ ] **Step 2: Update the inner container to stack and use min-height**

Find:

```php
    <div class="relative flex items-center justify-between max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[564px]">
```

Replace with:

```php
    <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-0 min-h-[480px] lg:h-[564px]">
```

- [ ] **Step 3: Update the image container**

Find:

```php
        <!-- Left image -->
        <div class="flex-1 flex justify-start items-end h-full">
            <?php if ($image_id): ?>
                <?= wp_get_attachment_image($image_id, 'full', false, ['class' => 'h-full w-auto object-contain object-bottom', 'alt' => 'Joanna - Speaker Cohort']) ?>
            <?php endif; ?>
        </div>
```

Replace with:

```php
        <!-- Image -->
        <div class="flex-1 flex justify-center lg:justify-start items-end h-64 lg:h-full order-1 lg:order-none">
            <?php if ($image_id): ?>
                <?= wp_get_attachment_image($image_id, 'full', false, ['class' => 'h-full w-auto object-contain object-bottom max-h-64 lg:max-h-none', 'alt' => 'Joanna - Speaker Cohort']) ?>
            <?php endif; ?>
        </div>
```

- [ ] **Step 4: Update the right content + heading classes**

Find:

```php
        <!-- Right content -->
        <div class="flex-1 max-w-[480px]">
            <h2 class="font-flatline font-semibold text-white text-center" style="font-size: 56px; line-height: 1.1;">
                <?= $heading ?>
            </h2>
            <p class="mt-6 text-body text-white">
                <?= esc_html($text) ?>
            </p>
            <div class="mt-8">
                <a href="<?php echo esc_url(home_url($btn_url)); ?>" class="btn-primary">
                    <?= esc_html($btn_text) ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/btn-arrow.svg" alt="" class="w-5 h-2" aria-hidden="true">
                </a>
            </div>
        </div>
```

Replace with:

```php
        <!-- Content -->
        <div class="flex-1 max-w-[480px] text-center lg:text-left order-2 lg:order-none mt-8 lg:mt-0">
            <h2 class="font-flatline font-semibold text-white text-4xl sm:text-5xl lg:text-[56px] leading-[1.1]">
                <?= $heading ?>
            </h2>
            <p class="mt-6 text-body text-white">
                <?= esc_html($text) ?>
            </p>
            <div class="mt-8">
                <a href="<?php echo esc_url(home_url($btn_url)); ?>" class="btn-primary">
                    <?= esc_html($btn_text) ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/btn-arrow.svg" alt="" class="w-5 h-2" aria-hidden="true">
                </a>
            </div>
        </div>
```

- [ ] **Step 5: Verify PHP and commit**

```bash
php -l template-parts/section-speaker.php
git add template-parts/section-speaker.php
git commit -m "feat(home): rework speaker section for mobile (stack, scale, min-height)"
```

---

## Subagent 2C: Vault, Testimonials, Voice

**Files modified:**
- `template-parts/section-vault.php`
- `template-parts/section-voice.php`
- (no changes to `section-testimonials.php` — already works on mobile per audit)

### Task 2C.1: Vault — reduce margin, contain decorative ellipses, scale watermark

**File:** `template-parts/section-vault.php`

- [ ] **Step 1: Reduce outer margin and ensure overflow hidden**

Find:

```php
<section class="relative mx-10 rounded-b-3xl overflow-hidden"
```

Replace with:

```php
<section class="relative mx-4 sm:mx-10 rounded-b-3xl overflow-hidden"
```

- [ ] **Step 2: Scale the decorative ellipses on mobile**

Find:

```php
    <!-- Decorative blurred gold ellipses -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Ellipse 2: positioned bottom-right area -->
        <div class="absolute w-[1535px] h-[1535px] bg-gold rounded-full"
            style="top: 342px; left: 986px; filter: blur(620px);"></div>
        <!-- Ellipse 3: positioned top-left area, opacity 0.7 -->
        <div class="absolute w-[1525px] h-[1525px] bg-gold/70 rounded-full"
            style="top: -1183px; left: -901px; filter: blur(560px);"></div>
    </div>
```

Replace with:

```php
    <!-- Decorative blurred gold ellipses -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute w-[400px] h-[400px] sm:w-[800px] sm:h-[800px] lg:w-[1535px] lg:h-[1535px] bg-gold rounded-full"
            style="top: 30%; left: 40%; filter: blur(120px);"></div>
        <div class="absolute w-[400px] h-[400px] sm:w-[800px] sm:h-[800px] lg:w-[1525px] lg:h-[1525px] bg-gold/70 rounded-full"
            style="top: -10%; left: -10%; filter: blur(100px);"></div>
    </div>
```

- [ ] **Step 3: Scale the watermark image**

Find:

```php
    <!-- Watermark image -->
    <div class="absolute inset-x-0 top-0 flex justify-center pointer-events-none">
        <img src="<?php echo esc_url($theme_uri . '/assets/images/the-vault.webp'); ?>"
            alt=""
            class="w-[770px] h-auto select-none"
            aria-hidden="true">
    </div>
```

Replace with:

```php
    <!-- Watermark image -->
    <div class="absolute inset-x-0 top-0 flex justify-center pointer-events-none">
        <img src="<?php echo esc_url($theme_uri . '/assets/images/the-vault.webp'); ?>"
            alt=""
            class="w-[260px] sm:w-[500px] lg:w-[770px] h-auto select-none"
            aria-hidden="true">
    </div>
```

- [ ] **Step 4: Verify PHP and commit**

```bash
php -l template-parts/section-vault.php
git add template-parts/section-vault.php
git commit -m "feat(home): scale vault ellipses + watermark, contain overflow"
```

---

### Task 2C.2: Voice — reduce margin, ensure decorative ellipses don't overflow

**File:** `template-parts/section-voice.php`

- [ ] **Step 1: Reduce outer margin and contain decorative layer**

Find:

```php
<section class="relative mx-10 rounded-3xl bg-gold-section overflow-hidden">
```

Replace with:

```php
<section class="relative mx-4 sm:mx-10 rounded-3xl bg-gold-section overflow-hidden">
```

- [ ] **Step 2: Add overflow-hidden to decorative ellipse container**

Find:

```php
    <!-- Decorative deep blue ellipses -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-1/4 w-80 h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
    </div>
```

Replace with:

```php
    <!-- Decorative deep blue ellipses -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-0 right-0 w-48 h-48 sm:w-72 sm:h-72 lg:w-96 lg:h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-1/4 w-40 h-40 sm:w-60 sm:h-60 lg:w-80 lg:h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
    </div>
```

- [ ] **Step 3: Verify PHP and commit**

```bash
php -l template-parts/section-voice.php
git add template-parts/section-voice.php
git commit -m "feat(home): scale voice decorative ellipses, contain overflow"
```

---

## Final Verification (Controller does this, not a subagent)

After all 3 subagents complete, the controller will:

- [ ] **Step 1: Build assets**

```bash
npm run build
```

- [ ] **Step 2: Visual verify at 375×812 (iPhone 14)**

Open `http://tim-tailpress.test/` in Chrome devtools at 375×812. Check each section.

- [ ] **Step 3: Verify no horizontal overflow**

```bash
# In DevTools console:
document.body.scrollWidth <= window.innerWidth
# Should return true
```

- [ ] **Step 4: Visual verify at 768×1024 (iPad)**

At 768×1024, all sections should still look correct (mobile still, just wider).

- [ ] **Step 5: Visual verify at 1440×900 (desktop) — no regressions**

Confirm desktop layout unchanged for all 10 sections.

- [ ] **Step 6: No console errors**

Confirm no new errors in dev console.

---

## Self-Review Notes

**Spec coverage check:**

| Spec requirement | Task |
| --- | --- |
| Trusted: stack heading/stats | 2A.1 |
| You Know: stack image/text | 2A.2 |
| You Know: replace `bg-[#F8F4EC]` with `bg-canvas` | 2A.2 (FE rule cleanup) |
| You Know: reduce top padding on mobile | 2A.2 |
| Tell Story: `mx-10` → `mx-4 sm:mx-10` | 2A.3 |
| Discover: scale heading | 2B.1 |
| Discover: fix absolute image on mobile | 2B.1 |
| Discover: `mx-10` → `mx-4 sm:mx-10` | 2B.1 |
| Journey: card aspect ratio | 2B.2 |
| Journey: scale phase watermark | 2B.2 |
| Speaker: `mx-10` → `mx-4 sm:mx-10` | 2B.3 |
| Speaker: stack image and content | 2B.3 |
| Speaker: min-height instead of fixed | 2B.3 |
| Speaker: scale heading (remove inline style) | 2B.3 |
| Vault: `mx-10` → `mx-4 sm:mx-10` | 2C.1 |
| Vault: contain ellipses + scale | 2C.1 |
| Vault: scale watermark | 2C.1 |
| Voice: `mx-10` → `mx-4 sm:mx-10` | 2C.2 |
| Voice: contain ellipses + scale | 2C.2 |
| Testimonials: no changes (audit shows OK) | — |

**Placeholder scan:** All code blocks are complete. No TBDs.

**Type/identifier consistency:** Class names match Tailwind v4 utilities; no project-specific identifiers involved.

**Parallel safety:** The 3 subagent groups touch disjoint files. No merge conflicts expected.

**Risk acknowledgment:**
- The Vault ellipse position change (using percentages instead of fixed pixels) is the highest-risk change. If it doesn't look right, we may need to iterate after visual verification.
- The Speaker section's content order swap (`order-1`/`order-2`) reverses desktop vs mobile — visually fine but worth checking.
- The `bg-[#F8F4EC]` → `bg-canvas` change in You Know is technically a color change if the OKLCH values differ. Mitigated by both mapping to the same hex (#F8F4EC).
