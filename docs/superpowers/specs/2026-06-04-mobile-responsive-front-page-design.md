# Mobile Responsive — Front Page Sections (Phase 2)

**Date:** 2026-06-04
**Phase:** 2 of 4
**Status:** Awaiting user review
**Author:** opencode

## Goal

Make all 10 sections of the front page (`front-page.php`) work flawlessly at mobile widths (320px–959px), preserving the desktop visual identity. No redesign — just fix broken layouts, scaling, and overflow.

## Scope

### In scope

10 section template parts on the front page:

1. `template-parts/section-hero.php`
2. `template-parts/section-trusted.php`
3. `template-parts/section-you-know.php`
4. `template-parts/section-tell-story.php`
5. `template-parts/section-discover.php`
6. `template-parts/section-journey.php`
7. `template-parts/section-speaker.php`
8. `template-parts/section-vault.php`
9. `template-parts/section-testimonials.php`
10. `template-parts/section-voice.php`

### Out of scope (later phases)

- Other pages (about, on-stage, events, success-stories, etc.) — Phase 3
- Backend / WP-admin — Phase 4
- Header & footer (already done in Phase 1)

## Current State (Audit Results)

Audited at 375×812 (iPhone 14). Programmatic check via `evaluate_script`:

| # | Section | Overflows X | Heading Size (mobile) | Major Issue |
| --- | --- | --- | --- | --- |
| 0 | Hero | No | 48px | None — works ✅ |
| 1 | Trusted | No | n/a (uses `<p>`) | Flex row layout doesn't collapse |
| 2 | You Know | No | 48px | `flex space-x-16` — image and text forced side-by-side |
| 3 | Tell Your Story | No | 48px | `mx-10` margin on mobile, otherwise OK |
| 4 | Discover | No | **56px fixed** | Heading `text-[56px]` not responsive; absolute image positioning broken |
| 5 | Journey | No | 48px | Cards use wide aspect ratio (1100/362) — too short on mobile |
| 6 | Speaker (Move) | No | **56px fixed inline** | `mx-10` on mobile, `h-[564px]` too tall, `flex items-center` doesn't stack |
| 7 | Vault | **YES** | 48px | `mx-10` + 1535px decorative ellipses overflow viewport |
| 8 | Testimonials | No | 48px | OK — already stacks to single column |
| 9 | Voice | **YES** | 48px | `mx-10` + decorative ellipses overflow |

## Design Decisions

### Global rules (apply to all 10 sections)

- **Replace `mx-10` on outer section containers with `mx-4 sm:mx-10`** (or `mx-4 lg:mx-10` for rounder). Preserves desktop rounded card look; removes 80px of wasted space on mobile.
- **Replace fixed `text-[56px]`, `text-[64px]`, `text-[117px]` font sizes with responsive chains** (`text-4xl sm:text-5xl md:text-6xl lg:text-[56px]`) using the project's existing font size scale.
- **Decorative blurred ellipses** positioned with `absolute` + large widths (`w-[1535px]`) overflow the viewport on mobile. Contain them with `overflow-hidden` on the section (already there in most cases — Vault and Voice need verification) AND scale them down with `scale-50` or position offscreen with `left-[-50%]` on mobile only. Prefer to keep them visible on mobile, just smaller and properly clipped.
- **No new colors, no hex codes** — use existing OKLCH tokens.

### Section-specific changes

#### 1. section-hero.php

**Current state:** Works on mobile. `flex flex-col lg:flex-row` already stacks.

**Changes:** None.

---

#### 2. section-trusted.php

**Current state:** Container `<div class="flex space-x-20 justify-between">` keeps heading and stats side-by-side on mobile.

**Change:** Add `flex-col md:flex-row` so it stacks on mobile, row on `md+`:
```php
<!-- before -->
<div class="flex space-x-20 justify-between">

<!-- after -->
<div class="flex flex-col md:flex-row md:space-x-20 md:justify-between gap-8 md:gap-0">
```

**Heading `<p>`:** The `mb-12` becomes `mb-6 md:mb-12` for tighter mobile spacing. Heading already has `tracking-[50%]` which renders as `tracking-[0.5em]` — keep.

---

#### 3. section-you-know.php

**Current state:** `<div class="flex space-x-16">` keeps image and text side-by-side on mobile. Image area `relative flex-1 h-fit` collapses oddly.

**Changes:**
- Outer flex: `flex flex-col lg:flex-row lg:space-x-16 gap-8 lg:gap-0`
- Image container: `relative w-full lg:flex-1 h-fit` — on mobile, the bg image is full width, the absolute profile image overlays at the bottom
- Text container: `max-w-[442px]` is fine
- Add `order-2 lg:order-1` to image area (image first on desktop, second on mobile is fine — keep as-is since visual flow is fine)
- Change `lg:pt-64` to `pt-16 lg:pt-64` (removes excessive top padding on mobile)

---

#### 4. section-tell-story.php

**Current state:** `relative mx-10 rounded-3xl` — `mx-10` (40px) on mobile is too much wasted space.

**Change:** `mx-4 sm:mx-10 rounded-3xl` — preserves the rounded card look on all viewports.

Otherwise OK. The swiper handles itself via existing breakpoints (slidesPerView: 1 on mobile).

---

#### 5. section-discover.php

**Current state:** `<h2 class="text-[56px] leading-tight font-flatline">` — fixed 56px on mobile. Image container has `w-full absolute bottom-0 left-0` for the layered image, which positions correctly only when the parent has a defined height.

**Changes:**
- Heading: `text-4xl md:text-5xl lg:text-[56px] leading-tight font-flatline`
- Outer padding-top: `pt-10 lg:pt-10` is fine
- Image container: `flex-1 relative` — add `mt-8 lg:mt-0` to give the image area space on mobile. The layered image should be `relative` on mobile, `absolute` on desktop:
  ```php
  <img src="...discover-whole.webp" alt="..." class="w-full relative lg:absolute lg:bottom-0 lg:left-0 mt-4 lg:mt-0">
  ```
- This is the only section where we change the absolute image behavior — it's a clear improvement that doesn't change desktop

---

#### 6. section-journey.php

**Current state:** Cards use `aspect-[1100/362]` — very wide aspect ratio (3:1). On mobile this makes each card short and squat.

**Changes:**
- Change aspect to `aspect-[16/9] sm:aspect-[1100/362]` — taller on mobile, wide on `sm+`
- Phase watermark `text-5xl` → `text-3xl sm:text-5xl` — too large on mobile
- Heading: already `text-5xl md:text-6xl` (48px on mobile) — OK

---

#### 7. section-speaker.php (Move the Room)

**Current state:** 
- `relative mx-10 rounded-3xl overflow-hidden bg-navy` — `mx-10` wastes mobile space
- Inner container: `flex items-center justify-between max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[564px]` — fixed 564px height, `flex items-center` doesn't stack on mobile
- Image: `h-full w-auto object-contain object-bottom` — fills the 564px height
- Heading: `style="font-size: 56px; line-height: 1.1;"` — fixed inline

**Changes:**
- Outer: `relative mx-4 sm:mx-10 rounded-3xl overflow-hidden bg-navy`
- Inner: `flex flex-col lg:flex-row lg:items-center lg:justify-between max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-0 min-h-[480px] lg:h-[564px]`
- Image container: `flex-1 flex justify-center lg:justify-start items-end h-64 lg:h-full`
- Image itself: `h-full lg:h-full w-auto object-contain object-bottom max-h-64 lg:max-h-none`
- Heading: remove inline `style="font-size: 56px; line-height: 1.1;"`, add Tailwind classes `text-4xl sm:text-5xl lg:text-[56px] leading-[1.1]`

---

#### 8. section-vault.php (Stay Inside the Conversation)

**Current state:**
- `relative mx-10 rounded-b-3xl overflow-hidden` — `mx-10` on mobile
- Two huge decorative ellipses: `w-[1535px] h-[1535px] bg-gold` positioned with `top: 342px; left: 986px; filter: blur(620px)` — these exceed viewport
- Background image covers the whole section
- The decorative ellipses cause horizontal overflow

**Changes:**
- Outer: `relative mx-4 sm:mx-10 rounded-b-3xl overflow-hidden`
- Decorative ellipses: wrap in a div with `absolute inset-0 pointer-events-none overflow-hidden` and scale each ellipse. Use Tailwind's `scale-[0.3] sm:scale-50` on the wrapper OR just reduce the absolute width on mobile.
- Simpler approach: change the ellipses from fixed pixel sizes to responsive: `w-[300px] h-[300px] sm:w-[800px] sm:h-[800px] lg:w-[1535px] lg:h-[1535px]` and adjust positions to be percentages
- Heading `text-5xl md:text-[56px]` is OK (48px on mobile)
- Watermark `<img w-[770px]>` → `w-[300px] sm:w-[500px] lg:w-[770px]`

**Recommended approach (cleanest):** Use `overflow-hidden` on the existing wrapper divs around the ellipses (already present per audit), and on mobile apply `scale-50 origin-center` via a Tailwind class chain on the ellipses. Verify visually.

---

#### 9. section-testimonials.php

**Current state:** Works on mobile. Grid `grid-cols-1 md:grid-cols-3` already stacks.

**Changes:** None major. Optional polish: the decorative quote mark `top:0 left:10 w-[92px] h-[69px]` is fine on mobile. The `min-h-[281px]` cards have enough room.

**Verdict:** No changes required. (Will verify visually and skip if all good.)

---

#### 10. section-voice.php

**Current state:**
- `relative mx-10 rounded-3xl bg-gold-section overflow-hidden` — `mx-10` on mobile
- Decorative deep blue ellipses: `w-96 h-96` and `w-80 h-80` — these are small, may be OK
- Gallery images: `hidden xl:block` — already hidden below xl, so OK on mobile
- Heading: `text-5xl md:text-6xl` (48px on mobile) — OK

**Changes:**
- Outer: `relative mx-4 sm:mx-10 rounded-3xl bg-gold-section overflow-hidden`
- The decorative ellipses at `top-0 right-0 w-96 h-96 ... translate-x-1/3 -translate-y-1/3` may still cause overflow because `translate-x-1/3` pushes them outside. Add `overflow-hidden` on their parent div (already there: `pointer-events-none`).

**Verdict:** Likely just the `mx-10` change. Will verify overflow is gone after change.

## Acceptance Criteria

- [ ] No horizontal overflow on the front page at 320, 375, 414, 480, 600, 768, 959 px
- [ ] No content cut off on the right edge at any width
- [ ] All section headings are readable on mobile (no fixed large sizes)
- [ ] All flex layouts that should stack on mobile DO stack
- [ ] All absolute-positioned decorative elements stay within viewport
- [ ] The "Move the Room" speaker section is usable on mobile (image visible, text readable, button tappable)
- [ ] The Vault section's decorative ellipses don't cause horizontal scroll
- [ ] The Voice section's decorative ellipses don't cause horizontal scroll
- [ ] All Tailwind classes follow FE rules (no arbitrary color values, no hex codes)
- [ ] No console errors
- [ ] Desktop layouts unchanged

## Testing Procedure

1. Open `http://tim-tailpress.test/` at 375×812
2. Take a full-page screenshot before and after
3. Verify no `body.scrollWidth > window.innerWidth` at any width
4. Visually inspect each of the 10 sections
5. Resize to 768×1024 and re-verify
6. Resize to 1440×900 and confirm no desktop regressions

## Risks

| Risk | Mitigation |
| --- | --- |
| Decorative ellipses may still overflow after Tailwind changes | Use `overflow-hidden` on parent + `scale-` utilities; visual verification |
| Phase 2 is touching 10 files — large diff | Each section change is small; commit per section for clear history |
| Inline styles (`style="font-size: 56px"`) on speaker section may conflict with Tailwind classes | Remove the inline style entirely and use Tailwind classes |
| Testimonials section "no changes" assumption may be wrong | Visual verification will catch it |

## Subagent Strategy

This is too many files for one implementer. Plan: dispatch 3 parallel subagents grouped by similarity:

- **Subagent 2A:** Hero, Trusted, You Know, Tell Your Story (sections 1-4) — 4 files, mostly flex-direction and margin fixes
- **Subagent 2B:** Discover, Journey, Speaker (sections 5-7) — 3 files, heading scale + layout fixes  
- **Subagent 2C:** Vault, Testimonials, Voice (sections 8-10) — 3 files, overflow containment

Each subagent will commit its own work. Then a final visual verification pass at multiple widths.

## Next Phase

Phase 3 will cover the remaining 14 page templates (about, on-stage, events, success-stories, offers, the-vault, the-speaker, the-legacy, the-authority, speaker-cohort, master-my-message, build-my-team, be-remembered, breakthrough-session, 4-session, million-dollar-message, inquiry, get-started, thank-you). Some of these share patterns (e.g., all "session" pages) so they can be grouped.
