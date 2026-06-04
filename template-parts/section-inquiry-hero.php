<?php

/**
 * Inquiry Page - Hero Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_hero_heading') ?: 'Start the<br><em class="text-gold italic">Conversation.</em>';
$text = get_field('section_hero_text') ?: 'Tell us where you are, what you\'re exploring, or what feels most aligned right now.';
$bg_image_id = get_field('section_hero_bg_image');

$ghl_webhook = 'https://services.leadconnectorhq.com/hooks/txFvEqJbQlKriCxJl8w3/webhook-trigger/4a7aefc4-5270-46b9-b64a-9d7382f3dc98';
?>

<section class="relative bg-navy overflow-hidden min-h-[870px]">
    <!-- Background texture -->
    <div class="absolute inset-0">
        <?php if ($bg_image_id): ?>
            <?= wp_get_attachment_image($bg_image_id, 'full', false, ['class' => 'w-full h-full object-cover', 'alt' => '']) ?>
        <?php endif; ?>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 lg:pt-44 pb-20">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-[145px] items-start">
            <!-- Left Content -->
            <div class="w-full lg:max-w-[405px] shrink-0 pt-8 lg:pt-12">
                <h1 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[64px] text-white leading-[1.1]">
                    <?= $heading ?>
                </h1>
                <p class="mt-6 font-garet font-light text-lg text-white leading-[1.5]">
                    <?= esc_html($text) ?>
                </p>
                <p class="mt-4 font-garet font-light text-lg text-white leading-[1.5]">
                    Fill out the form, and Joanna's team will be in touch within 2 business days.
                </p>
            </div>

            <!-- Right Content - Glassmorphism Form Card -->
            <div class="w-full lg:w-[635px] shrink-0">
                <div class="relative rounded-xl p-px overflow-hidden">
                    <!-- Gradient border -->
                    <div class="absolute inset-0 bg-gradient-to-br from-white via-white/50 to-transparent opacity-60"></div>

                    <!-- Inner card with blur -->
                    <div class="relative bg-warm-beige/10 backdrop-blur-[20px] rounded-xl p-8 lg:p-14">
                        <form id="inquiry-form" class="space-y-2" novalidate
                              data-ghl-webhook="<?= esc_url($ghl_webhook) ?>">
                            <!-- Full Name -->
                            <div>
                                <input type="text" id="inquiry-full-name" name="full_name" placeholder="Full Name" required
                                    class="w-full h-[47px] px-4 rounded-[10px] bg-white border border-warm-beige font-garet font-light text-lg text-dark-text placeholder:text-dark-text/50 focus:outline-none focus:ring-2 focus:ring-gold/50">
                                <span class="inquiry-error hidden text-red-400 text-sm font-garet mt-1" data-field="full_name"></span>
                            </div>

                            <!-- Email Address -->
                            <div>
                                <input type="email" id="inquiry-email" name="email" placeholder="Email Address" required
                                    class="w-full h-[47px] px-4 rounded-[10px] bg-white border border-warm-beige font-garet font-light text-lg text-dark-text placeholder:text-dark-text/50 focus:outline-none focus:ring-2 focus:ring-gold/50">
                                <span class="inquiry-error hidden text-red-400 text-sm font-garet mt-1" data-field="email"></span>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <input type="tel" id="inquiry-phone" name="phone" placeholder="Phone Number"
                                    class="w-full h-[47px] px-4 rounded-[10px] bg-white border border-warm-beige font-garet font-light text-lg text-dark-text placeholder:text-dark-text/50 focus:outline-none focus:ring-2 focus:ring-gold/50">
                                <span class="inquiry-error hidden text-red-400 text-sm font-garet mt-1" data-field="phone"></span>
                            </div>

                            <!-- Message -->
                            <div>
                                <textarea id="inquiry-message" name="message" placeholder="What would you like support, clarity, or guidance around?" rows="4" required
                                    class="w-full px-4 py-2.5 rounded-[10px] bg-white border border-warm-beige font-garet font-light text-lg text-dark-text placeholder:text-dark-text/50 focus:outline-none focus:ring-2 focus:ring-gold/50 resize-none"></textarea>
                                <span class="inquiry-error hidden text-red-400 text-sm font-garet mt-1" data-field="message"></span>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <button type="submit" id="inquiry-submit" class="w-full h-[41px] rounded-full font-flatline font-bold text-base uppercase tracking-normal text-navy flex items-center justify-center gap-2.5 transition-opacity hover:opacity-90"
                                    style="background: radial-gradient(circle at 65% 0%, #e7d4c5 0%, #d4b478 100%); border: 1px solid #e7d4c5;">
                                    <span class="inquiry-btn-text">BEGIN THE CONVERSATION</span>
                                    <span class="inquiry-btn-spinner hidden">
                                        <svg class="animate-spin h-5 w-5 text-navy" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Success Modal -->
<div id="inquiry-success-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="inquiry-modal-heading">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <!-- Modal Card -->
    <div class="relative w-full max-w-lg bg-navy rounded-2xl p-8 sm:p-12 text-center shadow-2xl border border-white/10">
        <!-- Close Button -->
        <button type="button" id="inquiry-modal-close" class="absolute top-4 right-4 text-white/60 hover:text-white transition-colors" aria-label="Close modal">
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
        <h3 id="inquiry-modal-heading" class="font-flatline font-semibold text-2xl sm:text-3xl text-white">
            Thank You!
        </h3>

        <!-- Message -->
        <p class="mt-4 font-garet text-base text-white/80 leading-relaxed">
            Your inquiry has been received. Joanna's team will be in touch within 2 business days.
        </p>

        <!-- Okay Button -->
        <button type="button" id="inquiry-modal-okay" class="mt-8 px-8 h-[41px] rounded-full font-flatline font-bold text-base uppercase tracking-normal text-navy transition-opacity hover:opacity-90"
                style="background: radial-gradient(circle at 65% 0%, #e7d4c5 0%, #d4b478 100%); border: 1px solid #e7d4c5;">
            OKAY
        </button>
    </div>
</div>

<style>
    .inquiry-field-error {
        border-color: #f87171 !important;
    }
    .inquiry-field-error:focus {
        ring-color: #f87171 !important;
    }
</style>
