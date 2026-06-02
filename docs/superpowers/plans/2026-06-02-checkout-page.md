# Checkout Page Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add a `/checkout` page (Template Name: `Checkout`) that lets visitors purchase the $29 "Your Dollar Message" mini-training, matching the Figma design at `120:2200` and using a placeholder for a future GoHighLevel (GHL) order form embed.

**Architecture:** A new WordPress page template (`page-checkout.php`) loads a single section (`template-parts/section-checkout-checkout.php`) that renders a static 2-column layout (form on the left, order-summary card on the right) using the existing theme's global header and footer, existing color tokens, and existing `btn-primary` / `heading-section` / `text-label` / `text-body` / `text-body-sm` utilities. The payment-method tabs and submit-button behavior are handled by a small block of vanilla JS added to `resources/js/app.js` (guarded by an element existence check so it only runs on the checkout page). A `<div id="ghl-order-form" hidden>` placeholder sits at the end of the form for the future GHL embed. Three existing links (one hero CTA, one inside-page CTA, one footer link) are re-pointed to `/checkout`.

**Tech Stack:** WordPress (PHP), Tailwind CSS 4 (via Vite, no new tokens needed), vanilla JavaScript (added to existing `app.js` entry), existing `btn-primary` / `heading-section` / `text-label` / `text-body` / `text-body-sm` utilities from `resources/css/utilities.css`, existing color tokens (`navy`, `gold`, `warm-beige`, `gold-section`, `canvas`, `dark-text`) from `resources/css/theme.css`.

**Spec:** `docs/superpowers/specs/2026-06-02-checkout-page-design.md` (2 commits: `81573fc` initial, `18129e1` self-review fixes).

---

## File Structure

### New files

| Path | Responsibility |
|---|---|
| `page-checkout.php` | Page template registration (`Template Name: Checkout`) and main wrapper. Loads the section. ~10 lines. |
| `template-parts/section-checkout-checkout.php` | The 2-column checkout section (heading, form, order summary, GHL placeholder). ~200 lines of HTML/PHP. |

### Modified files

| Path | Change |
|---|---|
| `resources/js/app.js` | Add a guarded block at the end of the `window.load` listener: payment-tab switching + submit-button behavior for the GHL placeholder. ~60 lines added. |
| `template-parts/section-million-dollar-message-hero.php` | Change CTA `href="#"` → `href="<?php echo esc_url(home_url('/checkout')); ?>"` (line 49). |
| `template-parts/section-million-dollar-message-inside.php` | Change CTA `href="#"` → `href="<?php echo esc_url(home_url('/checkout')); ?>"` (line 42). |
| `template-parts/footer.php` | Change footer link `$29 Million Dollar Message` `href="#"` → `href="<?php echo esc_url(home_url('/checkout')); ?>"` (line 18). |

### Not modified

- `functions.php` — the JS is added to the existing `app.js` bundle, so no `wp_enqueue_script` change is required.
- `resources/css/theme.css`, `resources/css/utilities.css`, `theme.json` — all required color tokens and utilities already exist.
- The global `header.php` and `footer.php` (other than the one link edit) — the page reuses them as-is.

---

## Task 1: Create the page template

**Files:**
- Create: `page-checkout.php`

- [ ] **Step 1: Create the file**

Create `page-checkout.php` at the theme root (`/Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/page-checkout.php`) with the following content:

```php
<?php
/**
 * Template Name: Checkout
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-checkout', 'checkout'); ?>
</main>

<?php
get_footer();
```

- [ ] **Step 2: Verify the file syntax**

Run: `php -l /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/page-checkout.php`
Expected: `No syntax errors detected in ...page-checkout.php`

- [ ] **Step 3: Commit**

```bash
git add page-checkout.php
git commit -m "Add Checkout page template"
```

---

## Task 2: Create the checkout section

**Files:**
- Create: `template-parts/section-checkout-checkout.php`

- [ ] **Step 1: Create the file**

Create `template-parts/section-checkout-checkout.php` with the following content (this is the entire file — copy verbatim):

```php
<?php

/**
 * Checkout Page - Main Section template part.
 *
 * @package TailPress
 */
?>
<section class="bg-canvas pt-40 pb-24 lg:pb-32" id="checkout">
    <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-16 items-start">

            <div class="w-full lg:w-[558px] flex-shrink-0">
                <h1 class="heading-section text-navy">
                    You&rsquo;re One Step Closer to Clarity.
                </h1>
                <p class="text-body text-dark-text mt-6 max-w-[510px]">
                    Your message already exists. This is where you begin uncovering it.
                </p>

                <form id="checkout-form" class="mt-10 text-left" novalidate>
                    <h2 class="text-label text-navy mb-6">YOUR DETAILS</h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-body-sm text-navy mb-2" for="checkout-full-name">Full Name<span class="text-gold">*</span></label>
                            <input class="w-full px-4 py-3 rounded-[10px] bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none focus:border-gold" type="text" id="checkout-full-name" name="full_name" placeholder="First Name Last Name" required>
                        </div>
                        <div>
                            <label class="block text-body-sm text-navy mb-2" for="checkout-email">Email<span class="text-gold">*</span></label>
                            <input class="w-full px-4 py-3 rounded-[10px] bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none focus:border-gold" type="email" id="checkout-email" name="email" placeholder="your@email.com" required>
                        </div>
                        <div>
                            <label class="block text-body-sm text-navy mb-2" for="checkout-phone">Phone Number (Optional)</label>
                            <input class="w-full px-4 py-3 rounded-[10px] bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none focus:border-gold" type="tel" id="checkout-phone" name="phone" placeholder="+1555 0100">
                        </div>
                    </div>

                    <h2 class="text-label text-navy mt-12 mb-6">PAYMENT METHOD</h2>

                    <div class="flex gap-3" role="tablist" aria-label="Payment method">
                        <button type="button" class="checkout-tab flex-1 h-11 rounded-full border text-body-sm font-medium flex items-center justify-center gap-2 bg-gold border-gold text-white" data-tab="card" role="tab" aria-selected="true" aria-controls="panel-card">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="2" y="5" width="20" height="14" rx="2" />
                                <line x1="2" y1="10" x2="22" y2="10" />
                            </svg>
                            Card
                        </button>
                        <button type="button" class="checkout-tab flex-1 h-11 rounded-full border text-body-sm font-medium flex items-center justify-center gap-2 bg-transparent border-warm-beige text-dark-text" data-tab="apple_pay" role="tab" aria-selected="false" aria-controls="panel-apple-pay">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M17.05 12.04c-.03-2.92 2.39-4.32 2.5-4.39-1.36-1.99-3.48-2.27-4.24-2.3-1.8-.18-3.52 1.06-4.43 1.06-.91 0-2.32-1.04-3.82-1.01-1.96.03-3.77 1.14-4.78 2.9-2.04 3.53-.52 8.75 1.46 11.61.97 1.4 2.13 2.97 3.65 2.91 1.47-.06 2.02-.95 3.79-.95 1.77 0 2.27.95 3.82.92 1.58-.03 2.58-1.43 3.55-2.84 1.12-1.63 1.58-3.21 1.6-3.29-.03-.01-3.07-1.18-3.1-4.62zM14.31 4.18c.8-.97 1.34-2.32 1.19-3.68-1.15.05-2.55.77-3.38 1.73-.74.85-1.39 2.23-1.22 3.55 1.29.1 2.6-.65 3.41-1.6z" />
                            </svg>
                            Apple Pay
                        </button>
                        <button type="button" class="checkout-tab flex-1 h-11 rounded-full border text-body-sm font-medium flex items-center justify-center gap-2 bg-transparent border-warm-beige text-dark-text" data-tab="wire" role="tab" aria-selected="false" aria-controls="panel-wire">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="9" y1="13" x2="15" y2="13" />
                                <line x1="9" y1="17" x2="15" y2="17" />
                            </svg>
                            Wire/Invoice
                        </button>
                    </div>

                    <div class="mt-6">
                        <div class="checkout-tab-panel space-y-4" id="panel-card" data-panel="card" role="tabpanel">
                            <div>
                                <label class="block text-body-sm text-navy mb-2" for="checkout-card-number">Card number<span class="text-gold">*</span></label>
                                <input class="w-full px-4 py-3 rounded-[10px] bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none focus:border-gold" type="text" id="checkout-card-number" name="card_number" placeholder="1234 1234 1234 1234" inputmode="numeric" autocomplete="cc-number" required>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-body-sm text-navy mb-2" for="checkout-card-expiry">Expiry<span class="text-gold">*</span></label>
                                    <input class="w-full px-4 py-3 rounded-[10px] bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none focus:border-gold" type="text" id="checkout-card-expiry" name="card_expiry" placeholder="MM/YY" inputmode="numeric" autocomplete="cc-exp" required>
                                </div>
                                <div>
                                    <label class="block text-body-sm text-navy mb-2" for="checkout-card-cvc">CVC<span class="text-gold">*</span></label>
                                    <input class="w-full px-4 py-3 rounded-[10px] bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none focus:border-gold" type="text" id="checkout-card-cvc" name="card_cvc" placeholder="123" inputmode="numeric" autocomplete="cc-csc" required>
                                </div>
                            </div>
                        </div>

                        <div class="checkout-tab-panel hidden text-center py-8" id="panel-apple-pay" data-panel="apple_pay" role="tabpanel" hidden>
                            <p class="text-body text-dark-text">Complete your purchase using Apple Pay.</p>
                            <button type="button" class="checkout-info-btn mt-6 bg-black text-white rounded-full py-3 w-full max-w-xs font-medium">
                                Pay
                            </button>
                        </div>

                        <div class="checkout-tab-panel hidden text-center py-8" id="panel-wire" data-panel="wire" role="tabpanel" hidden>
                            <p class="text-body text-dark-text">We&rsquo;ll email you an invoice with wire instructions within 1 business day.</p>
                            <button type="button" class="checkout-info-btn mt-6 bg-navy text-white rounded-full py-3 w-full max-w-xs font-medium uppercase">
                                Email me an invoice
                            </button>
                        </div>
                    </div>

                    <div id="checkout-inline-note" class="hidden mt-6 p-4 bg-gold/20 border border-gold rounded-[10px] text-body-sm text-dark-text" role="status" aria-live="polite">
                        Payment integration is being configured. Please check back soon.
                    </div>

                    <button type="submit" id="checkout-submit" class="btn-primary w-full mt-10">
                        CONFIRM AND PAY $29
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </form>

                <div id="ghl-order-form" class="mt-10" hidden></div>
            </div>

            <aside class="w-full lg:w-[478px] flex-shrink-0 bg-warm-beige rounded-[10px] overflow-hidden">
                <div class="p-10 max-w-[398px]">
                    <h2 class="text-label text-navy">ORDER SUMMARY</h2>

                    <div class="mt-8">
                        <h3 class="font-flatline font-semibold text-3xl text-navy leading-[1.1]">
                            Your $29 Dollar Message
                        </h3>
                        <p class="text-body-sm text-dark-text mt-3">
                            A 7-minute training to find the one sentence that sells you.
                        </p>
                    </div>

                    <ul class="mt-6 bg-canvas rounded-[10px] p-6 space-y-3">
                        <li class="flex items-start gap-3 text-body-sm text-dark-text">
                            <span class="flex-shrink-0 w-4 h-4 mt-0.5 rounded-full bg-gold flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </span>
                            <span>60-minute self-paced training</span>
                        </li>
                        <li class="flex items-start gap-3 text-body-sm text-dark-text">
                            <span class="flex-shrink-0 w-4 h-4 mt-0.5 rounded-full bg-gold flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </span>
                            <span>The &ldquo;Dollar Message&rdquo; worksheet</span>
                        </li>
                        <li class="flex items-start gap-3 text-body-sm text-dark-text">
                            <span class="flex-shrink-0 w-4 h-4 mt-0.5 rounded-full bg-gold flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </span>
                            <span>Joanna&rsquo;s 2-question clarity prompt</span>
                        </li>
                        <li class="flex items-start gap-3 text-body-sm text-dark-text">
                            <span class="flex-shrink-0 w-4 h-4 mt-0.5 rounded-full bg-gold flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </span>
                            <span>Lifetime access</span>
                        </li>
                    </ul>

                    <div class="mt-8 space-y-3">
                        <div class="flex justify-between text-body-sm text-dark-text">
                            <span>Subtotal</span>
                            <span>$29</span>
                        </div>
                        <div class="flex justify-between items-baseline">
                            <span class="font-flatline text-2xl text-navy">Total</span>
                            <span class="font-flatline text-5xl text-gold-section">$29</span>
                        </div>
                    </div>

                    <p class="mt-6 text-body-sm text-dark-text text-center">
                        Instant access upon confirmation.
                    </p>
                </div>
            </aside>

        </div>
    </div>
</section>
```

- [ ] **Step 2: Verify the file syntax**

Run: `php -l /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/template-parts/section-checkout-checkout.php`
Expected: `No syntax errors detected in ...section-checkout-checkout.php`

- [ ] **Step 3: Commit**

```bash
git add template-parts/section-checkout-checkout.php
git commit -m "Add checkout section with form and order summary"
```

---

## Task 3: Add checkout tab switching and submit behavior to app.js

**Files:**
- Modify: `resources/js/app.js` (append a guarded block to the existing `window.load` listener)

- [ ] **Step 1: Read the current end of app.js**

Read the last 5 lines of `resources/js/app.js` to confirm the closing structure.

The file currently ends with the `tellStorySwiper` block and a closing `});` for the `window.load` listener (line 99). We will add our block **inside** that listener, right before the closing `});`.

- [ ] **Step 2: Add the checkout block**

In `resources/js/app.js`, **after the closing `});` of the `tellStorySwiper` block** (currently around line 98) and **before the final closing `});` of the `window.load` listener** (currently line 99), insert the following block:

```javascript

    // Checkout: payment-method tab switching
    const checkoutForm = document.getElementById("checkout-form");
    if (checkoutForm) {
        const tabs = document.querySelectorAll(".checkout-tab");
        const panels = document.querySelectorAll(".checkout-tab-panel");

        tabs.forEach(function (tab) {
            tab.addEventListener("click", function () {
                const target = tab.getAttribute("data-tab");

                tabs.forEach(function (t) {
                    const isActive = t === tab;
                    t.classList.toggle("bg-gold", isActive);
                    t.classList.toggle("border-gold", isActive);
                    t.classList.toggle("text-white", isActive);
                    t.classList.toggle("bg-transparent", !isActive);
                    t.classList.toggle("border-warm-beige", !isActive);
                    t.classList.toggle("text-dark-text", !isActive);
                    t.setAttribute("aria-selected", isActive ? "true" : "false");
                });

                panels.forEach(function (panel) {
                    const isMatch = panel.getAttribute("data-panel") === target;
                    panel.classList.toggle("hidden", !isMatch);
                    if (isMatch) {
                        panel.removeAttribute("hidden");
                    } else {
                        panel.setAttribute("hidden", "");
                    }
                });
            });
        });

        const inlineNote = document.getElementById("checkout-inline-note");
        const submitBtn = document.getElementById("checkout-submit");
        const ghlContainer = document.getElementById("ghl-order-form");
        const infoButtons = document.querySelectorAll(".checkout-info-btn");

        function flashInlineNote() {
            if (!inlineNote) return;
            inlineNote.classList.remove("hidden");
            window.setTimeout(function () {
                inlineNote.classList.add("hidden");
            }, 4000);
        }

        if (submitBtn) {
            submitBtn.addEventListener("click", function (e) {
                if (ghlContainer && ghlContainer.children.length > 0) {
                    e.preventDefault();
                    checkoutForm.classList.add("hidden");
                    ghlContainer.classList.remove("hidden");
                    ghlContainer.scrollIntoView({ behavior: "smooth", block: "start" });
                    return;
                }
                e.preventDefault();
                flashInlineNote();
            });
        }

        infoButtons.forEach(function (btn) {
            btn.addEventListener("click", function (e) {
                e.preventDefault();
                flashInlineNote();
            });
        });
    }
```

The final structure of `app.js` should be: the existing Swiper blocks (unchanged), then this new checkout block, then the final `});` closing the `window.load` listener.

- [ ] **Step 3: Verify the JS file parses**

Run: `node --check /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/resources/js/app.js`
Expected: no output (success) or a Vite/ESM warning is acceptable; **a parse error is not**.

If `node` complains about the `import Swiper from "swiper"` line (ESM resolution), that's fine — it's expected outside a Vite build. The point is that the syntax is valid.

- [ ] **Step 4: Commit**

```bash
git add resources/js/app.js
git commit -m "Add checkout tab switching and submit handler"
```

---

## Task 4: Point the 3 existing CTAs at /checkout

**Files:**
- Modify: `template-parts/section-million-dollar-message-hero.php:49`
- Modify: `template-parts/section-million-dollar-message-inside.php:42`
- Modify: `template-parts/footer.php:18`

- [ ] **Step 1: Update the hero CTA**

In `template-parts/section-million-dollar-message-hero.php`, find line 49 (the anchor inside the hero CTA `<div class="mt-10">`):

```php
            <a href="#" class="btn-primary">
```

Change it to:

```php
            <a href="<?php echo esc_url(home_url('/checkout')); ?>" class="btn-primary">
```

- [ ] **Step 2: Update the inside-page CTA**

In `template-parts/section-million-dollar-message-inside.php`, find line 42 (the anchor inside the `<div class="mt-10">` inside the "What's Inside" section):

```php
                    <a href="#" class="btn-primary">
```

Change it to:

```php
                    <a href="<?php echo esc_url(home_url('/checkout')); ?>" class="btn-primary">
```

- [ ] **Step 3: Update the footer link**

In `template-parts/footer.php`, find line 18 (the `<a>` with text `$29 Million Dollar Message` in the "All Offers" column):

```php
                <a href="#" class="font-garet font-light text-sm text-black hover:opacity-70 transition-opacity">$29 Million Dollar Message</a>
```

Change it to:

```php
                <a href="<?php echo esc_url(home_url('/checkout')); ?>" class="font-garet font-light text-sm text-black hover:opacity-70 transition-opacity">$29 Million Dollar Message</a>
```

- [ ] **Step 4: Verify all 3 edits**

Run: `grep -rn "esc_url(home_url('/checkout'))" /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/template-parts/ /Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/page-checkout.php`
Expected output (3 matches, plus the new page template may or may not match — that's fine, what matters is the 3 edits are in place):
- `template-parts/section-million-dollar-message-hero.php:... esc_url(home_url('/checkout')); ...`
- `template-parts/section-million-dollar-message-inside.php:... esc_url(home_url('/checkout')); ...`
- `template-parts/footer.php:... esc_url(home_url('/checkout')); ...`

- [ ] **Step 5: Commit**

```bash
git add template-parts/section-million-dollar-message-hero.php template-parts/section-million-dollar-message-inside.php template-parts/footer.php
git commit -m "Point sales page CTAs and footer link at /checkout"
```

---

## Task 5: Build, browse, and verify

**Files:** none — verification only.

- [ ] **Step 1: Build the assets**

Run: `npm run build` from the theme root `/Users/jdbernardo/Sites/tim-tailpress/wp-content/themes/tim-tailpress/`
Expected: a successful Vite build. Watch the terminal for any Tailwind class-not-found errors. If any class used in `section-checkout-checkout.php` is reported as unknown, check the spelling against `resources/css/theme.css` (color tokens) and `resources/css/utilities.css` (utility classes).

- [ ] **Step 2: Create a WordPress page that uses the new template**

In the WordPress admin (or via WP-CLI), create a new page with:
- Title: `Checkout`
- Slug: `checkout` (must match — that's the URL the CTAs point at)
- Page template: `Checkout` (the new template from `page-checkout.php`)
- Status: Published

If you don't have WordPress running locally, you can verify the template by serving the theme under any local WordPress install. The verification can be done by the user once they have a local WP environment.

- [ ] **Step 3: Visual verification at 4 viewports**

Open `/checkout` in a browser. At each viewport, verify the layout matches the Figma (frame `120:2200`):

- **1440×900 (desktop):** Two columns side by side. Form on the left, order summary card on the right. The card top aligns with the H1 area. The H1 reads "You're One Step Closer to Clarity." in `font-flatline` navy. The card background is `bg-warm-beige` (tan). The 4 feature items each have a small gold checkmark. The total `$29` is in large gold (`text-gold-section`). The "CONFIRM AND PAY $29" button is a pill with the radial-gradient background (tan center → gold edge).
- **1024×768 (laptop):** Same as desktop, possibly tighter spacing. Still 2 columns.
- **768×1024 (tablet portrait):** Stacks. Form on top, order summary card below.
- **375×667 (mobile):** Stacked, form first. Inputs fill the width. The order summary card is full-width below the form.

- [ ] **Step 4: Tab interaction check**

On the checkout page, click each of the 3 payment-method tabs:
- Click **Card** → the card number, expiry, and CVC fields are visible. The Card tab has the gold pill background.
- Click **Apple Pay** → the card fields hide, the "Complete your purchase using Apple Pay." message and the black "Pay" button are visible. The Apple Pay tab gets the gold pill.
- Click **Wire/Invoice** → the card fields hide, the "We'll email you an invoice with wire instructions within 1 business day." message and the navy "EMAIL ME AN INVOICE" button are visible. The Wire/Invoice tab gets the gold pill.

Only one tab has the gold pill at any time.

- [ ] **Step 5: Submit-without-GHL check**

Click the "CONFIRM AND PAY $29" button (with the form empty or filled — either way):
- Expected: a yellow/gold-bordered inline note appears below the form: "Payment integration is being configured. Please check back soon."
- The page does not navigate away.
- The browser console has no errors.
- After 4 seconds, the note disappears.

Also test the Apple Pay "Pay" button and the Wire/Invoice "EMAIL ME AN INVOICE" button — they should show the same inline note (they are non-functional placeholders until GHL is wired).

- [ ] **Step 6: Link-from-sales-page check**

Navigate to `/million-dollar-message` (the existing sales page):
- Click the "GET THE TRAINING — $29" button at the bottom of the hero section. Expected: lands on `/checkout`.
- Scroll to the "What's Inside" section. Click the "START THE TRAINING — $29" button. Expected: lands on `/checkout`.
- Scroll to the footer. Click the "$29 Million Dollar Message" link in the "All Offers" column. Expected: lands on `/checkout`.

- [ ] **Step 7: Theme consistency check**

On `/checkout`, verify the H1 uses the Flatline Sans font (same as the H1s on `/about`, `/the-vault`, etc.), the body text uses the Garet font, the button has the same radial-gradient as the "GET STARTED" button in the header, and the page uses the same navy / gold / warm-beige / canvas palette as the rest of the site.

- [ ] **Step 8: Final commit (if any cleanup needed)**

If any of the verification steps required a code fix, amend or add a new commit:

```bash
git add -A
git commit -m "Fix issues found during /checkout verification"
```

Otherwise, no commit is needed — the build is the final state.

---

## Self-Review Checklist (run after writing the plan)

- [x] **Spec coverage:**
  - Spec section "Files" → Tasks 1, 2, 3, 4 cover all 2 new + 4 modified files.
  - Spec section "Layout" → Task 2 (the 2-column section file).
  - Spec section "Left column — form" → Task 2 (heading, YOUR DETAILS inputs, PAYMENT METHOD tabs, card form, Apple Pay and Wire panels, submit button, GHL placeholder).
  - Spec section "Right column — order summary card" → Task 2 (the `<aside>`).
  - Spec section "Client-side script" → Task 3.
  - Spec section "Verification" → Task 5 (steps 1–7).

- [x] **Placeholder scan:** No "TBD", "TODO", "implement later", or "add appropriate error handling" anywhere in the plan. All code blocks are complete and copy-pasteable.

- [x] **Type / ID consistency:** The IDs used in the JS (`checkout-form`, `checkout-tab`, `checkout-tab-panel`, `data-tab`, `data-panel`, `checkout-submit`, `checkout-inline-note`, `ghl-order-form`, `checkout-info-btn`) all match the IDs / class names used in the section file in Task 2. The submit button has `id="checkout-submit"` in both Task 2 and Task 3. The `data-tab` values (`card`, `apple_pay`, `wire`) match the `data-panel` values in both Task 2 and Task 3.

- [x] **Build command verified:** `npm run build` exists in `package.json` and outputs to `dist/`. The JS input is `resources/js/app.js` (per `vite.config.mjs`), so adding to `app.js` is the correct way to include the new code in the bundle.

- [x] **No `functions.php` change required:** The new JS is added to the existing `app.js` entry, which is already enqueued by the TailPress framework. No PHP enqueue is needed, keeping the change surface to 4 files (1 new page template, 1 new section, 1 modified JS, 3 modified template parts).

- [x] **Spec self-review fixes already committed** in `18129e1` (button id, tab panel placeholders clarified).
