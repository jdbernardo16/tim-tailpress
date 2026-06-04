# Mobile Responsive — Header & Footer (Phase 1)

**Date:** 2026-06-04
**Phase:** 1 of 4
**Status:** Awaiting user review
**Author:** opencode

## Goal

Make the global header and footer work flawlessly across all viewport widths (320px–2560px), preserving the desktop visual identity while ensuring mobile UX is solid. No page-level changes in this phase.

## Scope

### In scope

- `template-parts/header.php` — fixed navigation, mobile menu, scroll behavior
- `template-parts/footer.php` — link columns, newsletter, profile, brand lockup
- `resources/css/custom.css` — minor global additions (focus states, safe-area)
- `resources/js/app.js` — mobile menu JS extracted out of header inline script (still inline acceptable; see implementation choice below)

### Out of scope (later phases)

- Page-level section mobile fixes (hero variants, swipers, etc.)
- Backend / WP-admin audit
- Touch gestures / iOS pull-to-refresh
- New visual design — desktop identity stays intact

## Constraints

- **No redesign.** Mobile is a faithful, scaled version of desktop.
- **Tailwind v4 only.** No new CSS framework or arbitrary values where standard utilities exist.
- **No new dependencies.** Use existing libraries (Swiper is loaded but not needed for header/footer).
- **Theme colors via existing OKLCH tokens** (`--color-navy`, `--color-canvas`, `--color-gold`, etc.).
- **Project's FE rules apply** — no hex codes in classes, no arbitrary values unless unavoidable.

## Design Decisions

### Header

| Concern | Decision |
| --- | --- |
| Mobile menu trigger | Existing hamburger button; swap to X icon when open via JS |
| Mobile menu visibility | Existing `#header-mobile-menu` div; toggled via `class` swap + `aria-expanded` |
| Body scroll lock | `document.body.style.overflow = 'hidden'` when menu open |
| Backdrop | `bg-navy/95 backdrop-blur-sm` already on the panel; ensure always applied when open |
| Close on link click | Yes — add click listener on each menu anchor |
| Close on Escape | Yes — add `keydown` listener |
| Hamburger color | Keep `text-white` (header always sits over dark hero on every page — confirmed by site audit) |
| Mobile padding | `py-3` instead of `py-6` (was too tall) |
| Focus state | `:focus-visible:ring-2 ring-gold/60` on toggle button and menu links |
| JS location | Move inline `<script>` blocks out of `header.php` into `resources/js/app.js` for cacheability and CSP friendliness |

### Footer

| Concern | Decision |
| --- | --- |
| Brand lockup size | `text-3xl sm:text-4xl md:text-5xl lg:text-7xl xl:text-8xl` (was `text-5xl sm:text-6xl lg:text-8xl`) |
| Brand lockup layout | Stack logo above text on mobile (`flex-col sm:flex-row sm:items-center`); current flex row breaks below ~400px |
| Brand image size | Already `w-32 sm:w-40 lg:w-52` — keep |
| Profile block | Stack name under image on mobile (`flex-col sm:flex-row`); current `flex flex-col sm:flex-row` is fine but tighten gap to `gap-3 sm:gap-2.5` |
| Section padding | `py-12 sm:py-16` instead of `py-16` |
| Safe area | Add `pb-[env(safe-area-inset-bottom)]` on the outer container for iOS |
| Newsletter form | Stays as-is (already full-width on mobile) |
| Link columns | Already stack on mobile via `flex-col lg:flex-row` — keep |
| Social icons row | Already `flex items-center gap-1` — keep |
| Copyright | Already stacks — keep |

## Implementation Plan (to be detailed in writing-plans)

1. Update `template-parts/header.php`:
   - Change `py-6` → `py-3 sm:py-6` on `<header>`
   - Add `aria-expanded="false"` to toggle button, `aria-controls="header-mobile-menu"`
   - Add `id="header-mobile-toggle-icon"` to the hamburger SVG and a hidden X icon swap
   - Add `id` and `role="dialog" aria-modal="true"` to the mobile menu container
   - Remove the two inline `<script>` blocks (mobile toggle + scroll listener)
2. Update `resources/js/app.js`:
   - Add mobile menu controller (open/close, body scroll lock, focus management, close on link/Escape)
   - Keep existing scroll-header logic (move from header.php)
   - Keep existing Swiper inits
3. Update `template-parts/footer.php`:
   - Change brand lockup classes (text sizes + flex direction)
   - Add safe-area padding
   - Reduce section padding on mobile
4. Update `resources/css/custom.css`:
   - Add `:focus-visible` ring styles for the hamburger button and footer links
   - Add safe-area helper if needed (most handled by inline class)

## File-by-file Changes

### `template-parts/header.php`

- `<header>`: `py-6` → `py-3 sm:py-6`
- Hamburger `<button>`: add `aria-expanded="false"`, `aria-controls="header-mobile-menu"`, `id="header-mobile-toggle"`, `:focus-visible` classes
- Hamburger SVG: wrap with `id="header-mobile-toggle-open"` (hamburger)
- Add a sibling SVG (X icon) with `id="header-mobile-toggle-close" hidden`
- Mobile menu `<div id="header-mobile-menu" ...>`: add `role="dialog"`, `aria-modal="true"`, `aria-label="Mobile menu"`
- Remove the two inline `<script>` blocks at the bottom

### `resources/js/app.js`

Add a new section above the existing Swiper inits:

```js
// Mobile menu controller
const mobileToggle = document.getElementById('header-mobile-toggle');
const mobileMenu = document.getElementById('header-mobile-menu');
const iconOpen = document.getElementById('header-mobile-toggle-open');
const iconClose = document.getElementById('header-mobile-toggle-close');

if (mobileToggle && mobileMenu) {
    function setMenuOpen(open) {
        mobileMenu.classList.toggle('hidden', !open);
        mobileToggle.setAttribute('aria-expanded', String(open));
        document.body.classList.toggle('overflow-hidden', open);
        if (iconOpen) iconOpen.classList.toggle('hidden', open);
        if (iconClose) iconClose.classList.toggle('hidden', !open);
    }

    mobileToggle.addEventListener('click', () => {
        const open = mobileToggle.getAttribute('aria-expanded') !== 'true';
        setMenuOpen(open);
    });

    mobileMenu.querySelectorAll('a').forEach((a) => {
        a.addEventListener('click', () => setMenuOpen(false));
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && mobileToggle.getAttribute('aria-expanded') === 'true') {
            setMenuOpen(false);
            mobileToggle.focus();
        }
    });
}
```

Keep the scroll listener that adds `bg-navy/95 backdrop-blur-sm` to the header on scroll. Move that into the same controller.

### `template-parts/footer.php`

- Outer `<div>` with `py-16`: change to `py-12 sm:py-16`
- Wrap the outer container with `pb-[env(safe-area-inset-bottom)]` (or add to the existing div)
- Brand lockup container: `<div class="mt-16 flex items-center gap-4 sm:gap-6">` → `<div class="mt-12 sm:mt-16 flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">`
- Brand text: `text-5xl sm:text-6xl lg:text-8xl` → `text-3xl sm:text-4xl md:text-5xl lg:text-7xl xl:text-8xl`

### `resources/css/custom.css`

Add a small section for focus rings:

```css
#header-mobile-toggle:focus-visible,
#header-mobile-menu a:focus-visible {
    outline: 2px solid var(--color-gold);
    outline-offset: 2px;
    border-radius: 4px;
}
```

## Acceptance Criteria

- [ ] Header and footer render correctly at 320, 375, 414, 480, 600, 768, 1024, 1280, 1440, 1920, 2560 px
- [ ] Mobile menu opens, shows X icon, body scroll locks, focus moves into menu
- [ ] Mobile menu closes via: link click, Escape key, hamburger click
- [ ] Hamburger remains visible against the dark hero on every page (no contrast issues)
- [ ] No horizontal scroll on any page at any width (for header/footer specifically)
- [ ] Footer brand lockup is readable on a 320px viewport
- [ ] Footer profile block doesn't overflow on a 320px viewport
- [ ] iOS safe-area bottom padding applied (visible on devices with home indicator)
- [ ] All Tailwind classes follow FE rules (no arbitrary values for color, no hex codes)
- [ ] No console errors after changes
- [ ] No new console warnings
- [ ] No new JS dependencies added
- [ ] No new CSS files added

## Testing Procedure

1. Open `http://tim-tailpress.test/` in Chrome devtools
2. Set device toolbar to: iPhone SE (375×667), iPhone 14 Pro (390×844), iPad (768×1024), Responsive (custom widths)
3. For each width:
   - Take a full-page screenshot
   - Open mobile menu, take screenshot
   - Tap a link in mobile menu, verify it navigates and closes
   - Press Escape, verify menu closes
4. Test in landscape orientation on mobile widths
5. Verify header over all hero backgrounds (front page, about, on-stage, success-stories, events, etc.)
6. Test in a private window to bypass cache
7. Verify Swiper carousels still work (no regression)

## Risks

| Risk | Mitigation |
| --- | --- |
| Header z-index conflicts with page content (some pages have `overflow-hidden` sections) | Verify on each page type in Phase 2+ |
| Removing inline scripts breaks menu behavior temporarily | JS ported to `app.js` is functionally identical, just cleaner |
| Focus management on mobile menu can be subtle | Use simple "trap focus inside menu" pattern, not a full library |
| `env(safe-area-inset-bottom)` not respected on all Android devices | Fall back to `pb-4` minimum |

## Open Questions

None. The user has approved the phased approach and "preserve desktop design, just scale" visual strategy.

## Next Phase

Phase 2 will cover the front page sections (hero, trusted, you-know, tell-story, discover, journey, speaker, vault, testimonials, voice) using the same preserve-and-scale strategy. A new spec will be created when Phase 1 is complete.
