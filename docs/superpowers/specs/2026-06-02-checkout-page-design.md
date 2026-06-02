# Checkout Page Design

**Date:** 2026-06-02
**Status:** Approved
**Figma reference:** [True Influence Method — June 2 / Million Dollar Message frame `120:2200`](https://www.figma.com/design/pDchxJNShjdRFT1YuY0vY2/True-Influence-Method---June-2?node-id=120-2200)

## Purpose

A new `/checkout` page that lets visitors purchase the $29 "Your Dollar Message" mini-training. It is the conversion endpoint for the existing `Million Dollar Message` sales page (`page-million-dollar-message.php`).

## Approach (chosen)

**Static shell + embedded GHL order form (recommended).**
- WordPress renders the full custom UI (header, headings, order summary card, payment tabs, card fields, submit button, footer) in Tailwind, matching the Figma pixel-for-pixel where possible.
- A `<div id="ghl-order-form" hidden>` placeholder sits in the section file. When the GHL embed snippet is provided later, pasting it into that div wires up real payment processing without touching the rest of the page.
- A small client-side script (`resources/js/checkout.js`, ~30 lines) handles payment-tab switching and submit-button behavior.

## Conventions Followed

- All design tokens (colors, fonts, utilities) **already exist** in `resources/css/theme.css` and `resources/css/utilities.css`. No new theme variables needed.
- The page uses the **global** `header.php` (already includes the nav with "Work with me" highlighted in gold, fixed position, mobile menu) and `footer.php` (already includes 4 link columns, newsletter, social icons, large wordmark). The Figma header/footer is treated as context, not built into the page.
- Follows the existing page-section split: `page-X.php` + `template-parts/section-X-Y.php` per page.
- Reuses the existing `btn-primary` utility (radial-gradient pill — exact Figma match) and `heading-section` / `text-label` / `text-body` / `text-body-sm` utilities.
- No new images required.
- No code comments in shipped files (project rule).

## Files

### New

| Path | Purpose |
|---|---|
| `page-checkout.php` | Page template, `Template Name: Checkout` |
| `template-parts/section-checkout-checkout.php` | 2-column checkout section (form + order summary) |
| `resources/js/checkout.js` | Tab switching + submit handler for the GHL placeholder |

### Edited

| Path | Change |
|---|---|
| `template-parts/section-million-dollar-message-hero.php` | CTA `href="#"` → `href="<?php echo esc_url(home_url('/checkout')); ?>"` |
| `template-parts/section-million-dollar-message-inside.php` | CTA `href="#"` → `href="<?php echo esc_url(home_url('/checkout')); ?>"` |
| `template-parts/footer.php` | Footer link `$29 Million Dollar Message` `href="#"` → `href="<?php echo esc_url(home_url('/checkout')); ?>"` |

## Layout

```
[ global header (fixed, navy) ]
[ pt-40 spacer to clear fixed header ]

┌──────────────────────────────────────────────────────────────┐
│                                                              │
│   FORM (558)                          ORDER SUMMARY (478)    │
│   ───────────                         ───────────────────    │
│   H1: You're One Step Closer          Card (bg-warm-beige)   │
│       to Clarity.                       • ORDER SUMMARY      │
│   subtext                              • Product title       │
│                                        • Description         │
│   YOUR DETAILS                         • Features list       │
│   [Full Name]                            (inset, 4 items,    │
│   [Email]                                gold checks)        │
│   [Phone (Optional)]                   • Subtotal  $29       │
│                                        • Total     $29 (gold)│
│   PAYMENT METHOD                       • "Instant access"   │
│   [Card*] [Apple Pay] [Wire/Inv]                             │
│   [Card number          ]                                   │
│   [Expiry    ] [CVC    ]                                     │
│                                                              │
│   [ CONFIRM AND PAY $29   ]                                  │
│                                                              │
│   <div id="ghl-order-form" hidden>  ← GHL embed goes here    │
│                                                              │
└──────────────────────────────────────────────────────────────┘

[ global footer ]
```

- Outer container: `max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8`
- Page wrapper: `bg-canvas`
- Two-column layout: `flex flex-col lg:flex-row gap-16 items-start`
- Left (form) column: `w-full lg:w-[558px] flex-shrink-0`
- Right (order summary) column: `w-full lg:w-[478px] flex-shrink-0`
- On `<lg`: stacks with the form first; right column appears below.
- Vertical alignment on desktop: `items-start` so the order summary card sticks near the top of the form (matches the Figma where the card top is at y=214 and the H1 also at y≈214).

## Left column — form

### Heading block

```html
<h1 class="heading-section text-navy">
  You&rsquo;re One Step Closer to Clarity.
</h1>
<p class="text-body text-dark-text mt-6 max-w-[510px]">
  Your message already exists. This is where you begin uncovering it.
</p>
```

### YOUR DETAILS section

- Section label: `<h2 class="text-label text-navy mt-12 mb-6">YOUR DETAILS</h2>`
- Input stack with `space-y-4`:
  - Full Name (text, required)
  - Email (email, required)
  - Phone Number (Optional) — tel
- Input markup matches `template-parts/section-be-remembered-form.php:48-66` (white bg, `border-warm-beige`, `rounded-[10px]`, focus `border-gold`).
- Labels above each input: `<label class="block text-body-sm text-navy mb-2">`

### PAYMENT METHOD section

- Section label: `<h2 class="text-label text-navy mt-12 mb-6">PAYMENT METHOD</h2>`
- Tab strip: `<div class="flex gap-3" role="tablist">`
  - 3 buttons, each `flex-1 h-11 rounded-full border text-body-sm font-medium`
  - Active state: `bg-gold border-gold text-white`
  - Inactive state: `bg-transparent border-warm-beige text-dark-text`
  - Each tab has a small inline icon (card / Apple logo / invoice) + label
- Tab content panels (one visible at a time, controlled by `checkout.js`):
  - **Card** (default visible): 3 inputs in `space-y-4`
    - Card number (text, full width, placeholder `1234 1234 1234 1234`, `inputmode="numeric"`)
    - Two-column grid (`md:grid-cols-2 gap-4`): Expiry (placeholder `MM/YY`) + CVC (placeholder `123`)
  - **Apple Pay** panel: short instructional copy ("Complete your purchase using Apple Pay.") and a black pill-styled button (`<button type="button" class="bg-black text-white rounded-full py-3 w-full font-medium">Pay</button>`) that is non-functional until GHL is wired — clicking it shows the same inline note as the main submit button.
  - **Wire/Invoice** panel: short instructional copy ("We'll email you an invoice with wire instructions within 1 business day.") and a non-functional `EMAIL ME AN INVOICE` button that shows the same inline note.

### Form and submit button

The form wraps all the input groups, matching the pattern used in `section-be-remembered-form.php` and `section-build-my-team-form.php`:

```html
<form id="checkout-form" class="mt-10 text-left" novalidate>
  [YOUR DETAILS group, PAYMENT METHOD group, submit button — see sections above]
</form>
```

The submit button sits at the bottom of the form:

```html
<button type="submit" id="checkout-submit" class="btn-primary w-full mt-10">
  CONFIRM AND PAY $29
  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833"
          stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
  </svg>
</button>
```

(No `form="..."` attribute needed — the button is a direct child of `<form id="checkout-form">`.)

### GHL placeholder

```html
<div id="ghl-order-form" hidden></div>
```

Hidden by default. When the GHL embed is pasted in, `checkout.js` flips `hidden` off and (optionally) hides the static form.

## Right column — order summary card

- Wrapper: `<aside class="bg-warm-beige rounded-[10px] overflow-hidden">`
- Inner padding: `p-10`
- Max content width: 398 (matches Figma `Frame 214` and `Frame 222` widths)

### Card contents

1. `<h2 class="text-label text-navy">ORDER SUMMARY</h2>`
2. **Product block** (`mt-8`):
   - `<h3 class="font-flatline font-semibold text-3xl text-navy leading-[1.1]">Your $29 Dollar Message</h3>`
   - `<p class="text-body-sm text-dark-text mt-3">A 7-minute training to find the one sentence that sells you.</p>`
3. **Features list** (`mt-6 bg-canvas rounded-[10px] p-6`):
   - 4 `<li>` items, each `flex items-start gap-3 text-body-sm text-dark-text`
   - Gold checkmark icon (16×16): a `bg-gold rounded-full` circle with an inline white check (`stroke-width="3"` SVG path)
   - Items:
     - `60-minute self-paced training`
     - `The "Dollar Message" worksheet`
     - `Joanna's 2-question clarity prompt`
     - `Lifetime access`
4. **Totals block** (`mt-8 space-y-3`):
   - Subtotal row: `flex justify-between text-body-sm text-dark-text` → `Subtotal` / `$29`
   - Total row: `flex justify-between items-baseline` → `Total` (`font-flatline text-2xl text-navy`) / `$29` (`font-flatline text-5xl text-gold-section`)
5. **Footnote** (`mt-6`): `<p class="text-body-sm text-dark-text text-center">Instant access upon confirmation.</p>`

## Client-side script (`resources/js/checkout.js`)

Loaded via `wp_enqueue_script` in `functions.php` (or imported by `app.js`). Pure vanilla JS, no dependencies.

Responsibilities:
1. **Tab switching** — click on a `.checkout-tab` button:
   - Removes `bg-gold border-gold text-white` from all tabs and adds it to the clicked one.
   - Hides all `.checkout-tab-panel` and shows the matching one (via `data-tab` → `data-panel` attributes).
2. **Submit handler** — click on `#checkout-submit`:
   - If `#ghl-order-form` is empty (no GHL embed yet): `e.preventDefault()` + flash a small inline note "Payment integration is being configured. Please check back soon." (yellow `bg-gold/20 border-gold` toast, dismisses after 4s).
   - If `#ghl-order-form` has children: hide the static form, reveal the GHL embed, scroll to it.
3. **Form validation** — uses native HTML5 (`required`, `type="email"`, `pattern` on card number/expiry/CVC). No JS validation library.

Script is enqueued only on the checkout page via `is_page_template('page-checkout.php')` check in `functions.php` to avoid loading it site-wide.

## Header / Footer — global, not built here

The page renders the global `header.php` (fixed-position, navy) and `footer.php` (4 columns, newsletter, wordmark). The body section adds `pt-40` top padding so content doesn't hide behind the fixed header.

The 3 edits listed above are the only places the rest of the site changes.

## Verification

1. **Build:** `npm run build` — must complete with no Tailwind errors.
2. **Visual check:** load `/checkout` in a browser at 1440px, 1024px, 768px, 375px viewports. Compare to the Figma frame at 1440px.
3. **Tab interaction:** click each of Card / Apple Pay / Wire — only one panel shows at a time, the active tab gets the gold pill.
4. **Form fields:** tab through inputs — focus ring is gold (`focus:border-gold`).
5. **Submit without GHL:** clicking "CONFIRM AND PAY $29" shows the inline note (no console errors, no page navigation).
6. **Links from sales page:** clicking the hero CTA or inside-page CTA on `/million-dollar-message` lands on `/checkout`.
7. **Footer link:** clicking the "$29 Million Dollar Message" link in the footer lands on `/checkout`.
8. **Theme consistency:** the H1, button, and labels use the same fonts (`font-flatline`, `font-garet`), the same gold/navy palette, and the same button gradient as every other page.

## Out of scope

- Real payment processing (GHL embed to be added later).
- Email confirmation / receipt generation (handled by GHL).
- Tax handling (none in the Figma, none added).
- Coupon / discount codes (none in the Figma).
- Mobile-app or non-WordPress versions of the page.
- A/B testing, analytics, conversion tracking (no events added; can be layered on later without changing this build).
