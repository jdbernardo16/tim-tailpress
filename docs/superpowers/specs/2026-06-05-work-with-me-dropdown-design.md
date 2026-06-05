# Work With Me — Hover Dropdown (Header Nav)

**Date:** 2026-06-05
**Status:** Approved (design phase)
**Scope:** Header navigation, desktop and mobile

## Problem

The "Work With Me" item in the header navigation currently behaves like a normal
link. Visitors have to navigate to the page and then drill down to specific
offers. Figma spec (node 156-1069, file "True Influence Method - June 2")
defines a hover dropdown that surfaces the 10 relevant destinations in one
interaction, reducing friction.

## Goal

When a visitor hovers the "Work With Me" nav item, a two-column dropdown panel
appears directly below the item, styled to match the Figma spec. The chevron
indicator rotates 180° to confirm the active state.

## Non-Goals

- No redesign of mobile navigation. The existing mobile menu (inline, depth=1)
  stays as-is. We only hide the chevron on mobile to avoid dangling affordance.
- No changes to other menu items.
- No new dependency (no Headless UI, no Alpine, no hover-intent library).
- No CMS-side changes (no ACF, no custom post types). Items are managed via
  the existing `Appearance → Menus` UI as submenu entries under
  "Work With Me".

## Source of Truth

- Figma node: `156:1069` (file `pDchxJNShjdRFT1YuY0vY2`, "True Influence Method - June 2")
- Theme files involved:
  - `template-parts/header.php` (no structural change required; walker handles everything)
  - `src/Walkers/HeaderNavWalker.php`
  - `resources/css/custom.css` (imported as `@layer(utilities)` in `app.css`)

`resources/js/app.js` is **not** modified in v1 — see the JavaScript section.

## Design

### Dropdown panel (CSS, in `custom.css`)

```css
.menu-item-has-children {
  position: relative;
}

.sub-menu {
  position: absolute;
  top: 100%;
  left: 0;
  min-width: 475px;
  z-index: 50;
  padding: 24px;
  border-radius: 10px;
  background: rgba(15, 32, 61, 0.9);
  -webkit-backdrop-filter: blur(30px);
  backdrop-filter: blur(30px);
  border: 1px solid rgba(212, 180, 120, 0.4);
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 8px 40px;
  opacity: 0;
  visibility: hidden;
  transform: translateY(8px);
  transition: opacity 200ms ease, transform 200ms ease, visibility 200ms;
}

.menu-item-has-children:hover > .sub-menu,
.menu-item-has-children:focus-within > .sub-menu {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}
```

### Submenu link styling (CSS)

```css
.sub-menu-link {
  font-family: var(--font-garet);
  font-weight: 300;
  font-size: 16px;
  line-height: 1.5;
  color: #fff;
  text-decoration: none;
  transition: color 150ms ease;
}

.sub-menu-link:hover {
  color: var(--color-gold);
}
```

### Chevron rotation (CSS)

```css
.menu-chevron {
  transition: transform 200ms ease;
}

.menu-item-has-children:hover > a > .menu-chevron,
.menu-item-has-children:focus-within > a > .menu-chevron {
  transform: rotate(180deg);
}
```

### Mobile: hide chevron (CSS)

```css
@media (max-width: 1023px) {
  .menu-chevron { display: none; }
}
```

The mobile menu uses `depth => 1` so the submenu is never rendered, but the
parent `<li>` still carries `menu-item-has-children` and the walker still emits
the chevron. Hiding the chevron at the mobile breakpoint removes the dangling
affordance.

### Walker changes (`src/Walkers/HeaderNavWalker.php`)

1. Remove `hidden` from the `start_lvl` opening div. We now control visibility
   with opacity/visibility for animation; `display: none` would block that.
2. Add `sub-menu-link` class to every `<a>` rendered inside the submenu
   (recognised by `$depth > 0`).
3. Add `menu-chevron` class to the chevron `<svg>`.

Pseudocode diff:

```php
public function start_lvl(&$output, $depth = 0, $args = [])
{
    $output .= '<div class="sub-menu">'; // was: 'sub-menu hidden'
}

public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
{
    $classes = empty($item->classes) ? [] : (array) $item->classes;
    $has_children = in_array('menu-item-has-children', $classes);
    $is_active = untrailingslashit($item->url) === untrailingslashit(home_url(add_query_arg([])));
    $class_names = ($is_active ? 'text-gold' : 'text-white') . ' font-garet font-light text-base no-underline';
    $class_names .= $depth > 0 ? ' sub-menu-link' : ''; // new

    $output .= '<a href="' . esc_url($item->url) . '" class="' . $class_names . '">';
    $output .= esc_html($item->title);

    if ($has_children) {
        $output .= '<svg ... class="menu-chevron inline-block ml-1">'; // new class
    }

    $output .= '</a>';
}
```

### JavaScript (`resources/js/app.js`)

The desktop hover pattern is fully handled by CSS. JS is only required for two
edge cases:

1. **Click-outside to close on desktop** — when a visitor hovers the trigger,
   moves into the panel, and then clicks somewhere else, the panel should close
   immediately rather than waiting for mouseleave propagation.
2. **Mobile tap-to-toggle** — out of scope for v1 (mobile menu uses `depth=1`
   and the chevron is hidden). Not implementing now; can be added later by
   changing mobile `depth => 2` and adding a click handler on the chevron.

**Final JS surface for v1:** small click-outside listener on desktop only.
This is simple enough to defer entirely (mouseleave on the parent closes it
naturally), so v1 ships with **zero JS additions** and we add click-outside
later only if QA reports a real issue.

## Behavior Matrix

| Trigger | Desktop | Mobile |
|---|---|---|
| Hover parent `<li>` | Panel fades in, chevron rotates | (no-op; mobile uses different menu) |
| Mouse leaves parent `<li>` | Panel fades out, chevron resets | n/a |
| Keyboard focus into parent | Panel shows, chevron rotates (`:focus-within`) | n/a |
| Click parent `<a>` | Normal navigation | Normal navigation (no dropdown) |
| Click submenu link | Normal navigation, panel closes via blur | n/a |

## Acceptance Criteria

1. Hovering "Work With Me" on desktop shows the panel styled per Figma:
   navy 90% bg, blur, gold-tinted border, 10px radius, 24px padding, two
   columns with 40px gap.
2. The chevron rotates 180° on hover and resets on mouseleave.
3. The panel is keyboard accessible: tabbing into the trigger or any submenu
   link keeps the panel open (`:focus-within`).
4. The panel animates in/out via opacity + translateY, not a hard display
   toggle.
5. On screens `<1024px` the chevron is hidden, and the mobile menu behaves
   exactly as it does today (no submenu rendered).
6. The dropdown works once a content editor adds the 10 submenu items in
   `Appearance → Menus`. Until then, the trigger still hovers but the panel
   is empty (expected).
7. No console errors, no layout shift on page load, no regressions on other
   nav items.

## Out of Scope (deferred)

- Mobile tap-to-expand (would require changing mobile `depth` to 2 and
  adding a click handler).
- Hover-intent delay / mouseleave delay (current CSS-only timing feels
  snappy and matches Figma spec).
- Keyboard arrow-key navigation between submenu items (out of scope; tab
  navigation is sufficient for WCAG AA).
- Animated border gradient (Figma spec has a 2-stop linear gradient
  border). v1 uses a single `rgba` approximation; we can layer a
  `border-image` later if visual fidelity needs to be exact.

## Open Questions

None. Design approved.
