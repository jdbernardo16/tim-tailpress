# Mobile Responsive Other Page Templates Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Fix mobile responsive issues in 9 page templates (about, on-stage, events, success-stories, offers, the-vault, the-speaker, the-legacy, the-authority, million-dollar-message), preserving desktop layouts.

**Architecture:** Two parallel subagents (3A, 3B) own disjoint file sets. Each makes minimal Tailwind class changes only — no new colors, no JS, no new components.

**Tech Stack:** PHP 8.x, WordPress 6.x, Tailwind CSS v4, Chrome DevTools.

**Working Directory:** `/Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress`

**Current Branch:** `mobile-responsive`

---

## File Allocation (No Overlaps)

| Subagent | Files | Pattern |
| --- | --- | --- |
| 3A | 8 hero files (Groups A + B) | min-h-[555px] and h-screen → responsive chain |
| 3B | 6 files (Groups C + D) | mx-X + decorative ellipse/watermark overflow |

---

## Subagent 3A: Hero Sections

**Files modified:**
- `template-parts/section-events-hero.php`
- `template-parts/section-offers-hero.php`
- `template-parts/section-success-stories-hero.php`
- `template-parts/section-the-speaker-hero.php`
- `template-parts/section-the-legacy-hero.php`
- `template-parts/section-the-authority-hero.php`
- `template-parts/section-about-hero.php`
- `template-parts/section-onstage-hero.php`

### Task 3A.1 — Events hero (Group A)

**File:** `template-parts/section-events-hero.php:14`

- [ ] **Step 1: Replace min-h-[555px] with responsive chain**

Find:
```php
<section class="relative overflow-hidden min-h-[555px] flex items-center">
```

Replace with:
```php
<section class="relative overflow-hidden min-h-[400px] sm:min-h-[500px] lg:min-h-[555px] flex items-center">
```

- [ ] **Step 2: Verify and commit**

```bash
php -l template-parts/section-events-hero.php
git add template-parts/section-events-hero.php
git commit -m "feat(home): scale events hero min-height for mobile"
```

---

### Task 3A.2 — Offers hero (Group A)

**File:** `template-parts/section-offers-hero.php`

- [ ] **Step 1: Same responsive chain change**

Find: `<section class="relative overflow-hidden min-h-[555px] flex items-center">`
Replace with: `<section class="relative overflow-hidden min-h-[400px] sm:min-h-[500px] lg:min-h-[555px] flex items-center">`

- [ ] **Step 2: Verify and commit**

```bash
php -l template-parts/section-offers-hero.php
git add template-parts/section-offers-hero.php
git commit -m "feat(home): scale offers hero min-height for mobile"
```

---

### Task 3A.3 — Success Stories hero (Group A)

**File:** `template-parts/section-success-stories-hero.php:13`

- [ ] **Step 1: Same change**

Find: `<section class="relative overflow-hidden min-h-[555px] flex items-center">`
Replace with: `<section class="relative overflow-hidden min-h-[400px] sm:min-h-[500px] lg:min-h-[555px] flex items-center">`

- [ ] **Step 2: Verify and commit**

```bash
php -l template-parts/section-success-stories-hero.php
git add template-parts/section-success-stories-hero.php
git commit -m "feat(home): scale success-stories hero min-height for mobile"
```

---

### Task 3A.4 — The Speaker hero (Group A)

**File:** `template-parts/section-the-speaker-hero.php`

- [ ] **Step 1: Same change**

Find: `<section class="relative overflow-hidden min-h-[555px] flex items-center">`
Replace with: `<section class="relative overflow-hidden min-h-[400px] sm:min-h-[500px] lg:min-h-[555px] flex items-center">`

- [ ] **Step 2: Verify and commit**

```bash
php -l template-parts/section-the-speaker-hero.php
git add template-parts/section-the-speaker-hero.php
git commit -m "feat(home): scale the-speaker hero min-height for mobile"
```

---

### Task 3A.5 — The Legacy hero (Group A)

**File:** `template-parts/section-the-legacy-hero.php`

- [ ] **Step 1: Same change**

Find: `<section class="relative overflow-hidden min-h-[555px] flex items-center">`
Replace with: `<section class="relative overflow-hidden min-h-[400px] sm:min-h-[500px] lg:min-h-[555px] flex items-center">`

- [ ] **Step 2: Verify and commit**

```bash
php -l template-parts/section-the-legacy-hero.php
git add template-parts/section-the-legacy-hero.php
git commit -m "feat(home): scale the-legacy hero min-height for mobile"
```

---

### Task 3A.6 — The Authority hero (Group A)

**File:** `template-parts/section-the-authority-hero.php`

- [ ] **Step 1: Same change**

Find: `<section class="relative overflow-hidden min-h-[555px] flex items-center">`
Replace with: `<section class="relative overflow-hidden min-h-[400px] sm:min-h-[500px] lg:min-h-[555px] flex items-center">`

- [ ] **Step 2: Verify and commit**

```bash
php -l template-parts/section-the-authority-hero.php
git add template-parts/section-the-authority-hero.php
git commit -m "feat(home): scale the-authority hero min-height for mobile"
```

---

### Task 3A.7 — About hero (Group B)

**File:** `template-parts/section-about-hero.php:15`

- [ ] **Step 1: Replace h-screen with responsive chain**

Find:
```php
<section class="relative bg-navy overflow-hidden h-screen">
```

Replace with:
```php
<section class="relative bg-navy overflow-hidden min-h-[560px] sm:min-h-[640px] lg:min-h-screen">
```

- [ ] **Step 2: Add max-w safety to profile image**

Find (in the profile image container):
```php
<?= wp_get_attachment_image($profile_image_id, 'full', false, ['class' => 'w-[338px] object-contain', 'alt' => 'Joanna Horton McPherson']) ?>
```

Replace with:
```php
<?= wp_get_attachment_image($profile_image_id, 'full', false, ['class' => 'w-[280px] sm:w-[338px] max-w-full object-contain', 'alt' => 'Joanna Horton McPherson']) ?>
```

- [ ] **Step 3: Verify and commit**

```bash
php -l template-parts/section-about-hero.php
git add template-parts/section-about-hero.php
git commit -m "feat(home): rework about hero for mobile (min-height + image scale)"
```

---

### Task 3A.8 — On Stage hero (Group B)

**File:** `template-parts/section-onstage-hero.php:27`

- [ ] **Step 1: Replace h-screen with responsive chain**

Find:
```php
<section class="relative bg-navy overflow-hidden h-screen">
```

Replace with:
```php
<section class="relative bg-navy overflow-hidden min-h-[560px] sm:min-h-[640px] lg:min-h-screen">
```

- [ ] **Step 2: Add max-w safety to profile image**

Find (in the profile image container):
```php
<?= wp_get_attachment_image($profile_image_id, 'full', false, array('class' => 'w-[338px] object-contain', 'alt' => 'Joanna Horton McPherson')) ?>
```

Replace with:
```php
<?= wp_get_attachment_image($profile_image_id, 'full', false, array('class' => 'w-[280px] sm:w-[338px] max-w-full object-contain', 'alt' => 'Joanna Horton McPherson')) ?>
```

- [ ] **Step 3: Verify and commit**

```bash
php -l template-parts/section-onstage-hero.php
git add template-parts/section-onstage-hero.php
git commit -m "feat(home): rework on-stage hero for mobile (min-height + image scale)"
```

---

## Subagent 3B: CTA + Decorative Overflow

**Files modified:**
- `template-parts/section-events-cta.php`
- `template-parts/section-offers-cta.php`
- `template-parts/section-onstage-download.php`
- `template-parts/section-the-vault-hero.php`
- `template-parts/section-million-dollar-message-hero.php`
- `template-parts/section-the-speaker-story.php`

### Task 3B.1 — Events CTA (Group C)

**File:** `template-parts/section-events-cta.php`

The file uses `<section class="relative mx-8 rounded-b-3xl bg-gold-section overflow-hidden -translate-y-5">`.

- [ ] **Step 1: Reduce margin**

Find: `<section class="relative mx-8 rounded-b-3xl bg-gold-section overflow-hidden -translate-y-5">`
Replace with: `<section class="relative mx-4 sm:mx-8 rounded-b-3xl bg-gold-section overflow-hidden -translate-y-5">`

- [ ] **Step 2: Scale decorative ellipses**

Find the two decorative ellipses (top-right w-96 and bottom-left w-80 with translate transforms). Scale them:
```php
<!-- before -->
<div class="absolute top-0 right-0 w-96 h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
<div class="absolute bottom-0 left-1/4 w-80 h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>

<!-- after -->
<div class="absolute top-0 right-0 w-48 h-48 sm:w-72 sm:h-72 lg:w-96 lg:h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
<div class="absolute bottom-0 left-1/4 w-40 h-40 sm:w-60 sm:h-60 lg:w-80 lg:h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
```

- [ ] **Step 3: Verify and commit**

```bash
php -l template-parts/section-events-cta.php
git add template-parts/section-events-cta.php
git commit -m "feat(home): scale events CTA ellipses + reduce mobile margin"
```

---

### Task 3B.2 — Offers CTA (Group C)

**File:** `template-parts/section-offers-cta.php`

Same pattern as 3B.1.

- [ ] **Step 1: Reduce margin**

Find: `<section class="relative mx-8 rounded-b-3xl bg-gold-section overflow-hidden -translate-y-5">`
Replace with: `<section class="relative mx-4 sm:mx-8 rounded-b-3xl bg-gold-section overflow-hidden -translate-y-5">`

- [ ] **Step 2: Scale decorative ellipses (same as 3B.1)**

```php
<div class="absolute top-0 right-0 w-48 h-48 sm:w-72 sm:h-72 lg:w-96 lg:h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
<div class="absolute bottom-0 left-1/4 w-40 h-40 sm:w-60 sm:h-60 lg:w-80 lg:h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
```

- [ ] **Step 3: Verify and commit**

```bash
php -l template-parts/section-offers-cta.php
git add template-parts/section-offers-cta.php
git commit -m "feat(home): scale offers CTA ellipses + reduce mobile margin"
```

---

### Task 3B.3 — On Stage download (Group C)

**File:** `template-parts/section-onstage-download.php:17`

- [ ] **Step 1: Reduce margin**

Find: `<section class="relative mx-10 rounded-b-3xl bg-gold-section overflow-hidden -translate-y-5">`
Replace with: `<section class="relative mx-4 sm:mx-10 rounded-b-3xl bg-gold-section overflow-hidden -translate-y-5">`

- [ ] **Step 2: Scale decorative ellipses**

```php
<div class="absolute top-0 right-0 w-48 h-48 sm:w-72 sm:h-72 lg:w-96 lg:h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
<div class="absolute bottom-0 left-1/4 w-40 h-40 sm:w-60 sm:h-60 lg:w-80 lg:h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
```

- [ ] **Step 3: Verify and commit**

```bash
php -l template-parts/section-onstage-download.php
git add template-parts/section-onstage-download.php
git commit -m "feat(home): scale on-stage download ellipses + reduce mobile margin"
```

---

### Task 3B.4 — The Vault hero watermark + ellipses (Group D)

**File:** `template-parts/section-the-vault-hero.php:24, 28-31`

- [ ] **Step 1: Scale the watermark image**

Find (in the watermark div):
```php
<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vault-watermark.webp" alt="" class="w-[770px] h-auto max-w-none opacity-90" aria-hidden="true">
```

Replace with:
```php
<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vault-watermark.webp" alt="" class="w-[280px] sm:w-[500px] lg:w-[770px] h-auto max-w-none opacity-90" aria-hidden="true">
```

- [ ] **Step 2: Scale decorative ellipses**

```php
<!-- before -->
<div class="absolute top-0 right-0 w-96 h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
<div class="absolute bottom-0 left-1/4 w-80 h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>

<!-- after -->
<div class="absolute top-0 right-0 w-48 h-48 sm:w-72 sm:h-72 lg:w-96 lg:h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
<div class="absolute bottom-0 left-1/4 w-40 h-40 sm:w-60 sm:h-60 lg:w-80 lg:h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
```

- [ ] **Step 3: Verify and commit**

```bash
php -l template-parts/section-the-vault-hero.php
git add template-parts/section-the-vault-hero.php
git commit -m "feat(home): scale vault hero watermark + ellipses for mobile"
```

---

### Task 3B.5 — Million Dollar Message hero ellipses (Group D)

**File:** `template-parts/section-million-dollar-message-hero.php`

- [ ] **Step 1: Scale all three decorative ellipses**

The file has the same top-right w-96 + bottom-left w-80 pattern as well as a bottom-center w-[600px] gold ellipse. Scale all three:

```php
<!-- top-right -->
<div class="absolute top-0 right-0 w-48 h-48 sm:w-72 sm:h-72 lg:w-96 lg:h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
<!-- bottom-left -->
<div class="absolute bottom-0 left-1/4 w-40 h-40 sm:w-60 sm:h-60 lg:w-80 lg:h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
<!-- bottom-center gold -->
<div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[300px] h-[200px] sm:w-[450px] sm:h-[300px] lg:w-[600px] lg:h-[400px] bg-gold/30 rounded-full blur-3xl"></div>
```

(Only change the width/height classes; preserve all other classes and `style` attributes.)

- [ ] **Step 2: Verify and commit**

```bash
php -l template-parts/section-million-dollar-message-hero.php
git add template-parts/section-million-dollar-message-hero.php
git commit -m "feat(home): scale million-dollar-message hero ellipses for mobile"
```

---

### Task 3B.6 — The Speaker story 1535px ellipse (Group D)

**File:** `template-parts/section-the-speaker-story.php`

- [ ] **Step 1: Find and scale the 1535px ellipse**

Find:
```html
<div class="absolute top-1/2 right-0 w-[1535px] h-[1535px] bg-gold/40 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/2"></div>
```

Replace with:
```html
<div class="absolute top-1/2 right-0 w-[400px] h-[400px] sm:w-[800px] sm:h-[800px] lg:w-[1535px] lg:h-[1535px] bg-gold/40 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/2"></div>
```

- [ ] **Step 2: Verify parent has overflow-hidden**

Check the parent section element. If it doesn't have `overflow-hidden`, add it to ensure clipping.

- [ ] **Step 3: Verify and commit**

```bash
php -l template-parts/section-the-speaker-story.php
git add template-parts/section-the-speaker-story.php
git commit -m "feat(home): scale the-speaker story 1535px ellipse for mobile"
```

---

## Final Verification (Controller does this)

After both subagents complete:

- [ ] **Step 1: Build assets**

```bash
npm run build
```

- [ ] **Step 2: Visual verify each affected page at 500×800**

Navigate in Chrome devtools to each of the 9 pages and confirm no horizontal overflow:
- `/about/`, `/on-stage/`, `/events/`, `/success-stories/`, `/offers/`
- `/the-vault/`, `/the-speaker/`, `/the-legacy/`, `/the-authority/`
- `/million-dollar-message/`

- [ ] **Step 3: Verify no horizontal overflow programmatically**

In DevTools console: `document.body.scrollWidth <= window.innerWidth` — should be `true`.

- [ ] **Step 4: Visual verify desktop at 1440×900**

Confirm no regressions on any of the 9 pages.

- [ ] **Step 5: No console errors**

Confirm no new errors in dev console.

---

## Self-Review Notes

**Spec coverage check:**

| Spec requirement | Task |
| --- | --- |
| Group A: min-h-[555px] in 6 heroes | 3A.1-3A.6 |
| Group B: h-screen in about + on-stage | 3A.7, 3A.8 |
| Group B: profile image scale in about + on-stage | 3A.7, 3A.8 |
| Group C: mx-8/mx-10 in 3 CTAs | 3B.1-3B.3 |
| Group C: decorative ellipse scaling in 3 CTAs | 3B.1-3B.3 |
| Group D: vault hero watermark + ellipses | 3B.4 |
| Group D: million-dollar-message hero ellipses | 3B.5 |
| Group D: the-speaker story 1535px ellipse | 3B.6 |

**Placeholder scan:** All code blocks complete. No TBDs.

**Type/identifier consistency:** Tailwind class names consistent across files. The `w-48 h-48 sm:w-72 sm:h-72 lg:w-96 lg:h-96` pattern is the same as used in Phase 2 voice section.

**Parallel safety:** Subagent 3A touches 8 hero files. Subagent 3B touches 6 different files (CTAs and other sections). Zero file overlap. No merge conflicts possible.

**Risk acknowledgment:**
- The `min-h-[400px]` mobile value may still be too tall on very small phones (320px). Will verify at the smallest testable width (500px) and adjust if needed.
- The h-screen → min-h-screen conversion on Group B preserves desktop but may shift content positioning. Visual verification will catch this.
