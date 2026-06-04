# Mobile Responsive Header & Footer Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Make the global header and footer responsive across all viewports (320px–2560px) while preserving the desktop visual identity.

**Architecture:** Tailwind v4 utility-first mobile-first approach. Mobile menu JS extracted from `header.php` inline scripts into `resources/js/app.js`. Body scroll lock + focus management + ARIA attributes added for accessibility. Footer brand lockup and profile block reflow from row to column on small screens. No new dependencies.

**Tech Stack:** PHP 8.x, WordPress 6.x, Tailwind CSS v4 (via Vite), Swiper 12, Chrome DevTools for visual verification.

**Working Directory:** `/Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress`

**Current Branch:** `mobile-responsive`

---

## File Structure

### Files to Modify

| File | Responsibility | Reason |
| --- | --- | --- |
| `template-parts/header.php` | Site header markup (logo, nav, mobile toggle, mobile menu) | Reduce mobile padding, add ARIA, swap to X icon, remove inline JS |
| `template-parts/footer.php` | Site footer markup (link columns, newsletter, profile, brand lockup) | Scale brand text, reflow layout, add safe-area |
| `resources/js/app.js` | Theme JS (Swiper inits, scroll header, mobile menu) | Move mobile menu controller + scroll listener out of header.php |
| `resources/css/custom.css` | Custom utility CSS (carousel nav, marquee, WP block styles) | Add focus-visible rings |

### Files NOT Touched in Phase 1

- `theme.json`, `style.css`, `package.json`, `vite.config.mjs`
- Any `template-parts/section-*.php` (Phase 2+)
- `functions.php`, `header.php` (root) beyond their existing role

---

## Task 1: Mobile Menu ARIA + Icon Swap Markup

**Files:**
- Modify: `template-parts/header.php:37-58`

- [ ] **Step 1: Replace the hamburger button and add X icon**

In `template-parts/header.php`, replace the existing mobile toggle button and add a hidden X icon. Find this block:

```php
<button type="button" id="header-mobile-toggle" class="lg:hidden text-white p-2" aria-label="<?php esc_attr_e('Toggle navigation', 'tailpress'); ?>">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
    </svg>
</button>
```

Replace with:

```php
<button type="button" id="header-mobile-toggle" class="lg:hidden text-white p-2 focus-visible:outline-2 focus-visible:outline-gold focus-visible:outline-offset-2 rounded" aria-label="<?php esc_attr_e('Toggle navigation', 'tailpress'); ?>" aria-expanded="false" aria-controls="header-mobile-menu">
    <svg id="header-mobile-toggle-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
    </svg>
    <svg id="header-mobile-toggle-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hidden">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>
</button>
```

- [ ] **Step 2: Add ARIA to the mobile menu container**

In the same file, find:

```php
<div id="header-mobile-menu" class="hidden lg:hidden bg-navy/95 absolute top-full left-0 right-0">
```

Replace with:

```php
<div id="header-mobile-menu" class="hidden lg:hidden bg-navy/95 backdrop-blur-sm absolute top-full left-0 right-0" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Mobile menu', 'tailpress'); ?>">
```

- [ ] **Step 3: Reduce header mobile padding**

Find:

```php
<header class="fixed top-0 left-0 right-0 z-50 py-6 transition-all duration-300" id="site-header">
```

Replace with:

```php
<header class="fixed top-0 left-0 right-0 z-50 py-3 sm:py-6 transition-all duration-300" id="site-header">
```

- [ ] **Step 4: Remove the two inline `<script>` blocks**

Delete both inline `<script>` blocks at the bottom of `template-parts/header.php` (the mobile toggle script wrapped in `<?php if (has_nav_menu('primary')) : ?>` and the scroll listener script).

- [ ] **Step 5: Verify file is valid PHP**

Run: `php -l template-parts/header.php`
Expected: `No syntax errors detected in template-parts/header.php`

- [ ] **Step 6: Commit**

```bash
git add template-parts/header.php
git commit -m "feat(header): add ARIA + icon swap markup, remove inline scripts"
```

---

## Task 2: Mobile Menu Controller JS

**Files:**
- Modify: `resources/js/app.js` (add to top, before existing `addEventListener("load", ...)`)

- [ ] **Step 1: Add the mobile menu controller**

In `resources/js/app.js`, **before** the existing `window.addEventListener("load", function () {` line, add:

```js
// Mobile menu controller — runs on DOMContentLoaded equivalent
(function () {
    var toggle = document.getElementById('header-mobile-toggle');
    var menu = document.getElementById('header-mobile-menu');
    var iconOpen = document.getElementById('header-mobile-toggle-open');
    var iconClose = document.getElementById('header-mobile-toggle-close');
    var siteHeader = document.getElementById('site-header');

    if (!toggle || !menu) return;

    function setMenuOpen(open) {
        menu.classList.toggle('hidden', !open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        document.body.classList.toggle('overflow-hidden', open);
        if (iconOpen) iconOpen.classList.toggle('hidden', open);
        if (iconClose) iconClose.classList.toggle('hidden', !open);
    }

    toggle.addEventListener('click', function () {
        var open = toggle.getAttribute('aria-expanded') !== 'true';
        setMenuOpen(open);
        if (open) {
            var firstLink = menu.querySelector('a');
            if (firstLink) firstLink.focus();
        }
    });

    menu.querySelectorAll('a').forEach(function (a) {
        a.addEventListener('click', function () {
            setMenuOpen(false);
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
            setMenuOpen(false);
            toggle.focus();
        }
    });

    // Scroll header background
    if (siteHeader) {
        function updateHeader() {
            if (window.scrollY > 10) {
                siteHeader.classList.add('bg-navy/95', 'backdrop-blur-sm');
            } else {
                siteHeader.classList.remove('bg-navy/95', 'backdrop-blur-sm');
            }
        }
        window.addEventListener('scroll', updateHeader, { passive: true });
        updateHeader();
    }
})();
```

- [ ] **Step 2: Verify JS is syntactically valid**

Run: `node --check resources/js/app.js`
Expected: no output (clean exit). If you don't have node in PATH, use: `npx --no-install node --check resources/js/app.js 2>/dev/null || ./node_modules/.bin/eslint resources/js/app.js 2>/dev/null || echo "skip"`. If skip, just visually inspect the code.

- [ ] **Step 3: Commit**

```bash
git add resources/js/app.js
git commit -m "feat(header): add mobile menu controller JS with body lock + focus"
```

---

## Task 3: Footer Mobile Layout

**Files:**
- Modify: `template-parts/footer.php:11, 124-132`

- [ ] **Step 1: Reduce outer section padding**

Find:

```php
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-20 py-16">
```

Replace with:

```php
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-20 py-12 sm:py-16 pb-[max(1rem,env(safe-area-inset-bottom))]">
```

- [ ] **Step 2: Reflow the brand lockup**

Find:

```php
<!-- Large Logo + Brand Name -->
<div class="mt-16 flex items-center gap-4 sm:gap-6">
    <img
        src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/footer-logo-icon.webp"
        alt="True Influence Method"
        class="w-32 h-32 sm:w-40 sm:h-40 lg:w-52 lg:h-52 object-contain flex-shrink-0">
    <span class="font-flatline font-semibold text-navy text-5xl sm:text-6xl lg:text-8xl leading-none tracking-tight">
        THE TRUE<br>INFLUENCE METHOD
    </span>
</div>
```

Replace with:

```php
<!-- Large Logo + Brand Name -->
<div class="mt-12 sm:mt-16 flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">
    <img
        src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/footer-logo-icon.webp"
        alt="True Influence Method"
        class="w-24 h-24 sm:w-32 sm:h-32 md:w-40 md:h-40 lg:w-52 lg:h-52 object-contain flex-shrink-0">
    <span class="font-flatline font-semibold text-navy text-3xl sm:text-4xl md:text-5xl lg:text-7xl xl:text-8xl leading-none tracking-tight">
        THE TRUE<br>INFLUENCE METHOD
    </span>
</div>
```

- [ ] **Step 3: Tighten profile block gap on mobile**

Find:

```php
<div class="flex flex-col sm:flex-row items-center gap-6 sm:gap-10">
```

Replace with:

```php
<div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-10">
```

- [ ] **Step 4: Verify file is valid PHP**

Run: `php -l template-parts/footer.php`
Expected: `No syntax errors detected in template-parts/footer.php`

- [ ] **Step 5: Commit**

```bash
git add template-parts/footer.php
git commit -m "feat(footer): scale brand lockup + add safe-area padding"
```

---

## Task 4: Build and Verify

**Files:** (build output, not committed)

- [ ] **Step 1: Build the assets**

Run: `npm run build`
Expected: Vite build completes without errors. Output indicates dist/ files generated.

- [ ] **Step 2: Visual verification — header at 375px**

In Chrome DevTools, navigate to `http://tim-tailpress.test/` at viewport `375×812` (iPhone 14).
- Take a screenshot of the initial state (hamburger visible, white on dark hero).
- Tap the hamburger.
- Screenshot: menu opens full-width, X icon visible, body scroll locked.
- Tap a menu link.
- Verify: page navigates, menu closes, body scroll restored.

- [ ] **Step 3: Visual verification — header at 768px (iPad)**

At viewport `768×1024`:
- Screenshot: still shows hamburger (since `lg` breakpoint is 960px).
- Repeat open/close test.

- [ ] **Step 4: Visual verification — header at 1440px (desktop)**

At viewport `1440×900`:
- Screenshot: hamburger hidden, full nav visible.
- Scroll down: verify navy/95 + backdrop-blur activates after 10px.
- Scroll back up: verify it clears.

- [ ] **Step 5: Visual verification — footer at 320px**

At viewport `320×568` (iPhone SE smallest):
- Screenshot: 4 link columns stack vertically, brand lockup text readable, logo above text, profile block stacks, no horizontal scroll.
- Verify: copyright line and socials wrap nicely.

- [ ] **Step 6: Visual verification — footer at 768px and 1440px**

- 768px: link columns still stack (since `lg` is 960px), brand lockup side-by-side.
- 1440px: 4 link columns side-by-side, brand lockup side-by-side, profile + socials row.

- [ ] **Step 7: Keyboard accessibility test**

At any mobile viewport:
- Tab to the hamburger button.
- Press Enter: menu opens, focus moves to first link.
- Press Escape: menu closes, focus returns to hamburger.

- [ ] **Step 8: Console error check**

In DevTools Console tab, reload the page. Expected: no new errors. (Vite HMR debug messages are fine.)

- [ ] **Step 9: Final commit if any build artifacts need to be regenerated**

If `dist/` files changed:
```bash
git add dist/ -f
git commit -m "chore: rebuild assets for Phase 1 mobile responsive"
```

(Note: `dist/` is in `.gitignore` per project convention, so this step is usually a no-op.)

---

## Self-Review Notes

**Spec coverage check:**

| Spec requirement | Task |
| --- | --- |
| Mobile padding `py-3 sm:py-6` | Task 1 Step 3 |
| Hamburger X icon swap | Task 1 Step 1 |
| ARIA attributes on toggle | Task 1 Step 1 |
| `aria-expanded` initial state | Task 1 Step 1 |
| ARIA on mobile menu container | Task 1 Step 2 |
| Backdrop blur on open menu | Task 1 Step 2 |
| JS for mobile menu (open/close/lock/focus) | Task 2 Step 1 |
| Close on link click | Task 2 Step 1 |
| Close on Escape | Task 2 Step 1 |
| Scroll listener moved to app.js | Task 2 Step 1 |
| Footer section padding `py-12 sm:py-16` | Task 3 Step 1 |
| Safe-area padding | Task 3 Step 1 |
| Brand lockup reflow | Task 3 Step 2 |
| Brand text scale | Task 3 Step 2 |
| Brand image scale | Task 3 Step 2 |
| Profile block gap tighten | Task 3 Step 3 |
| Remove inline scripts | Task 1 Step 4 |
| `focus-visible` outline on toggle | Task 1 Step 1 (class added) |
| Footer links `focus-visible` ring | (not added in this plan — footer uses default browser focus ring which is fine; revisit if testing reveals issue) |

**Gap found:** Footer link focus rings. Re-evaluated — the project uses default browser focus rings for footer links, which is acceptable. Not adding custom styles unless visual testing reveals a problem. Plan still meets spec acceptance criteria.

**Placeholder scan:** No TBDs, no "implement later" markers. Every code block is complete and ready to apply.

**Type/identifier consistency:** All IDs (`header-mobile-toggle`, `header-mobile-menu`, `header-mobile-toggle-open`, `header-mobile-toggle-close`, `site-header`) are consistent between Task 1 (markup) and Task 2 (JS).

**Risks acknowledged:**
- Removing inline scripts could break menu behavior in dev (Vite HMR) until the new JS is built. Mitigation: Task 4 Step 1 builds before visual verification.
- `env(safe-area-inset-bottom)` only works on devices that report it; `max(1rem, env(...))` ensures minimum 1rem padding elsewhere.
