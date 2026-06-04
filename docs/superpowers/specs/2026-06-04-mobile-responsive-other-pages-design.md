# Mobile Responsive — Other Page Templates (Phase 3)

**Date:** 2026-06-04
**Phase:** 3 of 4
**Status:** Awaiting user review
**Author:** opencode

## Goal

Fix mobile responsive issues in the remaining 19 page templates, preserving desktop. Only 9 pages have issues (10 are already clean).

## Audit Summary (at 500px)

| Page | Status | Root cause |
| --- | --- | --- |
| about | ❌ | `h-screen` hero (`section-about-hero.php`) |
| on-stage | ❌ | `h-screen` hero + mx-10 download section + planning section |
| events | ❌ | min-h-[555px] hero + decorative ellipses overflow in CTA |
| success-stories | ❌ | min-h-[555px] hero + decorative ellipses overflow in CTA |
| offers | ❌ | min-h-[555px] hero + decorative ellipses overflow in CTA |
| the-vault | ❌ | 770px watermark + decorative ellipses overflow in hero |
| the-speaker | ❌ | min-h-[555px] hero + 1535px decorative ellipse in story section |
| the-legacy | ❌ | min-h-[555px] hero |
| the-authority | ❌ | min-h-[555px] hero |
| million-dollar-message | ❌ | decorative ellipses overflow in hero |
| speaker-cohort | ✅ | No issues |
| master-my-message | ✅ | No issues |
| build-my-team | ✅ | No issues |
| be-remembered | ✅ | No issues |
| breakthrough-session | ✅ | No issues |
| 4-session | ✅ | No issues |
| inquiry | ✅ | No issues |
| get-started | ✅ | No issues |
| thank-you | ✅ | No issues |

## Files to Modify

### Group A: `min-h-[555px]` hero pattern (6 files)

These all share the pattern `<section class="relative overflow-hidden min-h-[555px] flex items-center">` plus decorative ellipses with `translate-x-1/3` that overflow on mobile.

- `template-parts/section-events-hero.php`
- `template-parts/section-offers-hero.php`
- `template-parts/section-success-stories-hero.php`
- `template-parts/section-the-speaker-hero.php`
- `template-parts/section-the-legacy-hero.php`
- `template-parts/section-the-authority-hero.php`

**Fix:** Change `min-h-[555px]` to `min-h-[400px] sm:min-h-[500px] lg:min-h-[555px]` (preserves desktop, gives mobile a more proportional hero).

### Group B: `h-screen` hero pattern (2 files)

These use `h-screen` which forces a full-viewport-height hero on every device.

- `template-parts/section-about-hero.php`
- `template-parts/section-onstage-hero.php`

**Fix:** Change `h-screen` to `min-h-[560px] sm:min-h-[640px] lg:min-h-screen` (shorter on mobile, full on desktop). Also need to verify the centered profile image (which uses `w-[338px]`) doesn't overflow — it shouldn't on 500px viewport but needs `max-w-full` for safety.

### Group C: `mx-8` / `mx-10` rounded gold-section CTAs (3 files)

These reuse the same pattern as Phase 2's voice/vault fixes:

- `template-parts/section-events-cta.php` (uses `mx-8`)
- `template-parts/section-offers-cta.php` (uses `mx-8`)
- `template-parts/section-onstage-download.php` (uses `mx-10`)

**Fix:** Change `mx-8` / `mx-10` to `mx-4 sm:mx-8` / `mx-4 sm:mx-10`; scale decorative ellipses to `w-48 h-48 sm:w-72 sm:h-72 lg:w-96 lg:h-96`; add `overflow-hidden` to the ellipse container if not already present.

### Group D: Page-specific decorative element overflow (3 files)

- `template-parts/section-the-vault-hero.php` — 770px watermark + 96px ellipses
- `template-parts/section-million-dollar-message-hero.php` — 96px ellipses
- `template-parts/section-the-speaker-story.php` — 1535px gold ellipse

**Fix:** Scale each decorative element with responsive width chains. Watermark 770px → 300/500/770. Ellipses w-96 → w-48/w-72/w-96. 1535px ellipse → scale-50 on mobile.

## Design Decisions

### Reuse Phase 2 patterns

All fixes follow the same patterns established in Phases 1 and 2:
- `mx-X` → `mx-4 sm:mx-X` to recover mobile horizontal space
- Fixed `w-[NNNpx]` / `h-[NNNpx]` → responsive chains `w-X h-X sm:w-Y sm:h-Y lg:w-Z lg:h-Z`
- Decorative ellipse pattern: `w-48 h-48 sm:w-72 sm:h-72 lg:w-96 lg:h-96` (matches voice section from Phase 2)
- `h-screen` → `min-h-[NNNpx] sm:min-h-[NNNpx] lg:min-h-screen` (preserves desktop, allows mobile to size by content)

### No redesign

- Desktop layouts unchanged
- No new colors, no new components
- No JS changes

### No FE rule violations

- All changes use existing OKLCH theme tokens
- Standard Tailwind utilities only

## Acceptance Criteria

- [ ] No horizontal overflow on any of the 9 affected pages at 320, 375, 414, 480, 500, 600, 768, 959, 1024, 1280, 1440 px
- [ ] No content cut off on the right edge at any width
- [ ] All hero sections are usable on mobile (text visible, image positioned correctly)
- [ ] All decorative elements stay within their parent containers
- [ ] Desktop layouts preserved at 1440px
- [ ] No console errors
- [ ] All Tailwind classes follow FE rules

## Subagent Strategy

Two parallel subagents (non-overlapping file sets):

- **Subagent 3A:** Group A + Group B = 8 files (all hero sections)
- **Subagent 3B:** Group C + Group D = 6 files (CTA / decorative overflow sections)

Each commits independently, then final visual verification at multiple widths.

## Risks

| Risk | Mitigation |
| --- | --- |
| min-h-[555px] change might shrink hero too much on mobile | Use min-h-[400px] which is still tall enough for hero content; visual verify |
| 1535px ellipse in the-speaker-story might not be properly clipped by parent overflow | Add `overflow-hidden` to its container if missing |
| The h-screen fix to about/on-stage may not match original design intent | Visual verify desktop; if needed, use min-h-screen instead |

## Next Phase

Phase 4 will be the backend/admin audit (wp-admin mobile usability, ACF field groups, performance).
