<?php

/**
 * Site footer template part.
 *
 * @package TailPress
 */
?>

<footer class="bg-canvas">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-20 py-12 sm:py-16 pb-[max(1rem,env(safe-area-inset-bottom))]">
        <!-- Top section: Links + Newsletter -->
        <div class="flex flex-col lg:flex-row justify-between gap-12 lg:gap-8">
            <!-- Column 1: All Offers -->
            <div class="flex flex-col gap-2 lg:w-52">
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer-offers',
                    'container' => false,
                    'menu_class' => 'flex flex-col gap-2',
                    'items_wrap' => '%3$s',
                    'depth' => 1,
                    'fallback_cb' => false,
                    'walker' => new \TailPress\Walkers\FooterNavWalker(),
                ]);
                ?>
            </div>

            <!-- Column 2: Programs -->
            <div class="flex flex-col gap-2 lg:w-52">
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer-programs',
                    'container' => false,
                    'menu_class' => 'flex flex-col gap-2',
                    'items_wrap' => '%3$s',
                    'depth' => 1,
                    'fallback_cb' => false,
                    'walker' => new \TailPress\Walkers\FooterNavWalker(),
                ]);
                ?>
            </div>

            <!-- Column 3: About -->
            <div class="flex flex-col gap-2 lg:w-44">
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer-about',
                    'container' => false,
                    'menu_class' => 'flex flex-col gap-2',
                    'items_wrap' => '%3$s',
                    'depth' => 1,
                    'fallback_cb' => false,
                    'walker' => new \TailPress\Walkers\FooterNavWalker(),
                ]);
                ?>
            </div>

            <!-- Column 4: Newsletter -->
            <div class="flex flex-col gap-4 lg:w-80">
                <h3 class="font-flatline font-semibold text-lg text-navy">Stay Connected</h3>
                <p class="font-garet font-light text-sm text-black/70">Weekly insights on authentic influence.</p>
                <form id="footer-newsletter-form" class="flex flex-col gap-1" novalidate
                      data-ghl-webhook="https://services.leadconnectorhq.com/hooks/txFvEqJbQlKriCxJl8w3/webhook-trigger/df1dc8ef-b3ec-4ae5-815f-4ad8e42d493b">
                    <div>
                        <input
                            type="email"
                            name="email"
                            placeholder="your@email.com"
                            class="newsletter-email-input w-full px-4 py-2.5 border border-warm-beige rounded-lg font-garet font-light text-sm text-black placeholder:text-black/50 bg-white focus:outline-none focus:ring-2 focus:ring-gold/50"
                            required>
                        <span class="newsletter-error hidden text-red-400 text-xs font-garet mt-1" data-field="email"></span>
                    </div>
                    <button type="submit" id="newsletter-submit" class="btn-primary w-full justify-center h-[38px]">
                        <span class="newsletter-btn-text">SUBSCRIBE</span>
                        <span class="newsletter-btn-spinner hidden">
                            <svg class="animate-spin h-4 w-4 text-navy" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Divider -->
        <hr class="border-gold/40 my-10">

        <!-- Bottom section -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <!-- Left: Profile + Socials -->
            <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-10">
                <!-- Profile -->
                <div class="flex items-center gap-2.5">
                    <img
                        src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/joanna-profile.webp"
                        alt="Joanna Horton McPherson"
                        class="w-14 h-14 rounded-full object-cover">
                    <div class="flex flex-col gap-1">
                        <span class="font-flatline font-semibold text-lg text-navy">Joanna Horton McPherson</span>
                        <span class="font-garet font-light text-sm text-black">Private Advisor | Master Coach</span>
                    </div>
                </div>

                <!-- Social Icons -->
                <div class="flex items-center gap-1">
                    <a href="https://www.linkedin.com/in/joannahortonmcpherson/" target="_blank" rel="noopener noreferrer" class="w-9 h-9 flex items-center justify-center text-navy hover:opacity-70 transition-opacity" aria-label="LinkedIn">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/joannahortonmcpherson/" target="_blank" rel="noopener noreferrer" class="w-9 h-9 flex items-center justify-center text-navy hover:opacity-70 transition-opacity" aria-label="Instagram">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/joannahortonmcpherson/" target="_blank" rel="noopener noreferrer" class="w-9 h-9 flex items-center justify-center text-navy hover:opacity-70 transition-opacity" aria-label="Facebook">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Right: Copyright -->
            <div class="flex flex-col sm:flex-row items-center gap-1 sm:gap-4">
                <span class="font-garet font-light text-sm text-black">©<?php echo esc_html(date_i18n('Y')); ?> True Influence Method.</span>
                <span class="font-garet font-light text-sm text-black">All Rights Reserved.</span>
            </div>
        </div>

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
    </div>
</footer>

<!-- Newsletter Success Modal -->
<div id="newsletter-success-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="newsletter-modal-heading">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <!-- Modal Card -->
    <div class="relative w-full max-w-lg bg-navy rounded-2xl p-8 sm:p-12 text-center shadow-2xl border border-white/10">
        <!-- Close Button -->
        <button type="button" id="newsletter-modal-close" class="absolute top-4 right-4 text-white/60 hover:text-white transition-colors" aria-label="Close modal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <!-- Success Icon -->
        <div class="mx-auto mb-6 w-16 h-16 rounded-full bg-green-500/20 flex items-center justify-center">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        <!-- Heading -->
        <h3 id="newsletter-modal-heading" class="font-flatline font-semibold text-2xl sm:text-3xl text-white">
            You're In!
        </h3>

        <!-- Message -->
        <p class="mt-4 font-garet text-base text-white/80 leading-relaxed">
            Thanks for subscribing. We'll send weekly insights on authentic influence straight to your inbox.
        </p>

        <!-- Okay Button -->
        <button type="button" id="newsletter-modal-okay" class="mt-8 px-8 h-[41px] rounded-full font-flatline font-bold text-base uppercase tracking-normal text-navy transition-opacity hover:opacity-90"
                style="background: radial-gradient(circle at 65% 0%, #e7d4c5 0%, #d4b478 100%); border: 1px solid #e7d4c5;">
            OKAY
        </button>
    </div>
</div>

<style>
    .newsletter-field-error {
        border-color: #f87171 !important;
    }
    .newsletter-field-error:focus {
        ring-color: #f87171 !important;
    }
</style>
