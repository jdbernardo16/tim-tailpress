# Work With Me Header Dropdown — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a hover dropdown panel to the "Work With Me" item in the header navigation, matching Figma spec node 156-1069, with a chevron that rotates 180° on hover.

**Architecture:** Pure CSS hover behavior driven by classes emitted from the existing `HeaderNavWalker`. No JS in v1. Two-column grid layout comes from CSS Grid on the `.sub-menu` container. Items are sourced from the WordPress menu system (no hardcoding).

**Tech Stack:** PHP (WordPress walker), Tailwind CSS v4 (custom CSS imported via `@layer(utilities)`), Vite for asset building.

**Spec:** `docs/superpowers/specs/2026-06-05-work-with-me-dropdown-design.md`

---

## File Map

| File | Status | Responsibility |
|---|---|---|
| `src/Walkers/HeaderNavWalker.php` | Modify | Emit `sub-menu-link` and `menu-chevron` classes; remove `hidden` from submenu div |
| `resources/css/custom.css` | Modify | Add dropdown panel, link, and chevron styles |
| `template-parts/header.php` | **No change** | The walker + CSS handle all behavior; this file is untouched |

`resources/js/app.js` is **not** modified in v1.

---

## Task 1: Update HeaderNavWalker — Submenu Class

**Files:**
- Modify: `src/Walkers/HeaderNavWalker.php` (lines 26-29, `start_lvl` method)

- [ ] **Step 1: Remove the `hidden` class from the submenu opening div**

In `src/Walkers/HeaderNavWalker.php`, change the `start_lvl` method from:

```php
public function start_lvl(&$output, $depth = 0, $args = [])
{
    $output .= '<div class="sub-menu hidden">';
}
```

to:

```php
public function start_lvl(&$output, $depth = 0, $args = [])
{
    $output .= '<div class="sub-menu">';
}
```

Reason: Tailwind's `.hidden` sets `display: none`, which can't be animated. We control visibility with `opacity` + `visibility` in CSS instead.

- [ ] **Step 2: Verify the file edit**

Run:

```bash
grep -n "sub-menu" /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/src/Walkers/HeaderNavWalker.php
```

Expected output (line numbers may differ):

```
28:    public function start_lvl(&$output, $depth = 0, $args = [])
29:    {
30:        $output .= '<div class="sub-menu">';
```

The string `sub-menu hidden` must NOT appear.

- [ ] **Step 3: Commit**

```bash
git add src/Walkers/HeaderNavWalker.php
git commit -m "refactor(walker): drop hidden class from submenu div"
```

---

## Task 2: Update HeaderNavWalker — Add `sub-menu-link` Class

**Files:**
- Modify: `src/Walkers/HeaderNavWalker.php` (lines 9-24, `start_el` method)

- [ ] **Step 1: Add `sub-menu-link` class to submenu anchor elements**

In `src/Walkers/HeaderNavWalker.php`, change the `start_el` method from:

```php
public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
{
    $classes = empty($item->classes) ? [] : (array) $item->classes;
    $has_children = in_array('menu-item-has-children', $classes);
    $is_active = untrailingslashit($item->url) === untrailingslashit(home_url(add_query_arg([])));
    $class_names = ($is_active ? 'text-gold' : 'text-white') . ' font-garet font-light text-base no-underline';

    $output .= '<a href="' . esc_url($item->url) . '" class="' . $class_names . '">';
    $output .= esc_html($item->title);

    if ($has_children) {
        $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block ml-1"><path d="m6 9 6 6 6-6"/></svg>';
    }

    $output .= '</a>';
}
```

to:

```php
public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
{
    $classes = empty($item->classes) ? [] : (array) $item->classes;
    $has_children = in_array('menu-item-has-children', $classes);
    $is_active = untrailingslashit($item->url) === untrailingslashit(home_url(add_query_arg([])));
    $class_names = ($is_active ? 'text-gold' : 'text-white') . ' font-garet font-light text-base no-underline';
    $class_names .= $depth > 0 ? ' sub-menu-link' : '';

    $output .= '<a href="' . esc_url($item->url) . '" class="' . $class_names . '">';
    $output .= esc_html($item->title);

    if ($has_children) {
        $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="menu-chevron inline-block ml-1"><path d="m6 9 6 6 6-6"/></svg>';
    }

    $output .= '</a>';
}
```

Two changes:
- Line `$class_names .= $depth > 0 ? ' sub-menu-link' : '';` — adds class to submenu anchors only (depth > 0)
- Chevron SVG `class` becomes `"menu-chevron inline-block ml-1"` — added `menu-chevron` as the first class

- [ ] **Step 2: Verify the file edit**

Run:

```bash
grep -n "sub-menu-link\|menu-chevron" /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/src/Walkers/HeaderNavWalker.php
```

Expected output:

```
20:        $class_names .= $depth > 0 ? ' sub-menu-link' : '';
26:            $output .= '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="menu-chevron inline-block ml-1"><path d="m6 9 6 6 6-6"/></svg>';
```

- [ ] **Step 3: Verify PHP syntax**

Run:

```bash
php -l /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/src/Walkers/HeaderNavWalker.php
```

Expected output: `No syntax errors detected in ...`

- [ ] **Step 4: Commit**

```bash
git add src/Walkers/HeaderNavWalker.php
git commit -m "feat(walker): emit sub-menu-link and menu-chevron classes"
```

---

## Task 3: Add Dropdown Panel CSS

**Files:**
- Modify: `resources/css/custom.css` (append to end of file)

- [ ] **Step 1: Append the dropdown panel styles**

Open `resources/css/custom.css` and append the following block at the end of the file (after the existing `.entry-content` block):

```css
/* =================================================================
   Header nav: Work With Me hover dropdown
   ================================================================= */

/* Parent item with children — needs a positioning context */
.menu-item-has-children {
    position: relative;
}

/* Dropdown panel */
.sub-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 50;
    min-width: 475px;
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

- [ ] **Step 2: Verify the append**

Run:

```bash
tail -45 /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/resources/css/custom.css
```

Expected: the appended block appears at the end of the file, beginning with the comment `/* Header nav: Work With Me hover dropdown`.

- [ ] **Step 3: Commit**

```bash
git add resources/css/custom.css
git commit -m "feat(css): add hover dropdown panel styles for header nav"
```

---

## Task 4: Add Submenu Link and Chevron CSS

**Files:**
- Modify: `resources/css/custom.css` (append after the previous block)

- [ ] **Step 1: Append the submenu link and chevron styles**

Append to the end of `resources/css/custom.css`:

```css
/* Submenu link styling */
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

/* Chevron rotation on parent hover/focus */
.menu-chevron {
    transition: transform 200ms ease;
}

.menu-item-has-children:hover > a > .menu-chevron,
.menu-item-has-children:focus-within > a > .menu-chevron {
    transform: rotate(180deg);
}

/* Mobile: hide chevron (no submenu rendered at depth=1) */
@media (max-width: 1023px) {
    .menu-chevron {
        display: none;
    }
}
```

- [ ] **Step 2: Verify the file ends with the new block**

Run:

```bash
tail -35 /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/resources/css/custom.css
```

Expected: the new block ends the file, with the `@media (max-width: 1023px)` rule last.

- [ ] **Step 3: Commit**

```bash
git add resources/css/custom.css
git commit -m "feat(css): style submenu links, chevron rotation, mobile hide"
```

---

## Task 5: Build Assets

**Files:**
- Generated: `dist/assets/app-*.css` and `dist/assets/app-*.js` (Vite output)

- [ ] **Step 1: Run the production build**

Run from the theme root:

```bash
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
npm run build
```

Expected output ends with:

```
✓ built in <N>ms
```

(Where `<N>` is a small number of milliseconds.)

- [ ] **Step 2: Confirm the new CSS made it into the bundle**

Run:

```bash
grep -c "menu-item-has-children" /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/dist/assets/app-*.css
grep -c "sub-menu-link" /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/dist/assets/app-*.css
grep -c "menu-chevron" /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/dist/assets/app-*.css
```

Expected: each command prints a number `>= 1` (the bundled CSS contains each class).

- [ ] **Step 3: Commit built assets (if they are tracked in git)**

Check whether `dist/` is tracked:

```bash
git status --short dist/
```

If any files show as modified, commit them:

```bash
git add dist/
git commit -m "build: regenerate assets with dropdown styles"
```

If no files show as modified, skip this step.

---

## Task 6: Visual Verification in Browser

**Files:** None (read-only verification)

- [ ] **Step 1: Start a local server (if not already running)**

The Vite dev server can be used for live CSS reload, or use any local WordPress environment that serves the theme. Examples:

```bash
# Option A: Vite dev server (CSS hot-reload)
cd /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress
npm run dev
```

```bash
# Option B: WordPress local (e.g., Local by Flywheel, Lando, MAMP)
# Navigate to the site's home page in a browser
```

- [ ] **Step 2: Verify the panel HTML is rendered**

Open the site in a browser, view the page source (or use dev tools), and confirm that the header nav includes:

```html
<li class="menu-item-has-children ...">
  <a href="/work-with-me" class="...">
    Work With Me
    <svg class="menu-chevron inline-block ml-1" ...>...</svg>
  </a>
  <div class="sub-menu">
    <a href="/offers" class="... sub-menu-link">All Offers</a>
    ...
  </div>
</li>
```

If the submenu `<div>` is empty or missing the 10 items, the content editor needs to add them in `Appearance → Menus`. The dropdown styles will be in place; they just won't be visible until items are added.

- [ ] **Step 3: Verify hover behavior**

In a browser at `>= 1024px` width:

1. Hover the "Work With Me" item.
2. Confirm the dropdown panel fades in below the item.
3. Confirm the panel shows two columns of items.
4. Confirm the chevron rotates 180°.
5. Move the cursor away — confirm the panel fades out and the chevron resets.
6. Tab into "Work With Me" with the keyboard — confirm the panel shows (`:focus-within`).
7. Hover a submenu link — confirm its color changes to gold.

- [ ] **Step 4: Verify mobile behavior**

In a browser at `< 1024px` width (or with dev tools device emulation):

1. Open the mobile menu (hamburger).
2. Confirm the "Work With Me" item appears WITHOUT a chevron.
3. Confirm the submenu items do NOT appear (mobile menu still uses depth=1).

- [ ] **Step 5: Verify no console errors or layout shift**

1. Open the browser dev tools console — confirm no errors or warnings related to the navigation.
2. Reload the page — confirm no layout shift (the dropdown should be invisible at rest, not affecting document height).

---

## Task 7: Document the Content Editor Step

**Files:**
- Modify: None (notes only)

- [ ] **Step 1: Add a note for the content editor**

The 10 dropdown items must exist in the WordPress menu for the dropdown to populate. Document this expectation in the commit message of the final task so the user (or a content editor) sees it.

In the chat reply to the user (not in code), include:

> To populate the dropdown, go to **Appearance → Menus**, edit the Header Navigation menu, and add these items as children of "Work With Me":
>
> **Column 1:** All Offers (/offers), The Vault (/the-vault), Your Million Dollar Message (/million-dollar-message), Breakthrough Session (/breakthrough-session), 4-Session Training Package (/4-session)
>
> **Column 2:** Tell Your Story (/tell-your-story), Move the Room (/move-the-room), Master My Message (/master-my-message), Build My Team (/build-my-team), Be Remembered (/be-remembered)
>
> The dropdown will be empty (just an invisible box) until these are added.

- [ ] **Step 2: Final commit (none expected, this task is communication only)**

If no further code changes were made during verification, no commit is needed. If small fixes were required, commit them with a descriptive message.

---

## Self-Review

**Spec coverage:**

| Spec Section | Task(s) |
|---|---|
| Dropdown panel (CSS) | Task 3 |
| Submenu link styling | Task 4 |
| Chevron rotation | Task 4 |
| Mobile chevron hide | Task 4 |
| Walker: drop `hidden` class | Task 1 |
| Walker: add `sub-menu-link` class | Task 2 |
| Walker: add `menu-chevron` class | Task 2 |
| No JS additions in v1 | (All tasks confirm no `app.js` change) |
| Acceptance criteria (visual) | Task 6 |
| Content editor note | Task 7 |

**Placeholder scan:** No TBDs, no "implement later", no "similar to Task N". All CSS is shown in full. All commit commands are explicit.

**Type / class name consistency:**
- `.menu-item-has-children` used consistently (parent `<li>`, emitted by WordPress)
- `.sub-menu` used consistently (container div, walker + CSS)
- `.sub-menu-link` used consistently (submenu anchor, walker + CSS)
- `.menu-chevron` used consistently (chevron SVG, walker + CSS)
- All CSS selectors match the classes emitted by the walker

No issues found.
