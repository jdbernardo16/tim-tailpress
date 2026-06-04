<?php

/**
 * Inquiry Page - Hero Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_hero_heading') ?: 'Start the<br><em class="text-gold italic">Conversation.</em>';
$text = get_field('section_hero_text') ?: 'Tell us where you are, what you\'re exploring, or what feels most aligned right now.';
$bg_image_id = get_field('section_hero_bg_image');
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
                        <form class="space-y-2" action="" method="post">
                            <!-- Full Name -->
                            <div>
                                <input type="text" name="full_name" placeholder="Full Name"
                                    class="w-full h-[47px] px-4 rounded-[10px] bg-white border border-warm-beige font-garet font-light text-lg text-dark-text placeholder:text-dark-text/50 focus:outline-none focus:ring-2 focus:ring-gold/50">
                            </div>

                            <!-- Email Address -->
                            <div>
                                <input type="email" name="email" placeholder="Email Address"
                                    class="w-full h-[47px] px-4 rounded-[10px] bg-white border border-warm-beige font-garet font-light text-lg text-dark-text placeholder:text-dark-text/50 focus:outline-none focus:ring-2 focus:ring-gold/50">
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <input type="tel" name="phone" placeholder="Phone Number"
                                    class="w-full h-[47px] px-4 rounded-[10px] bg-white border border-warm-beige font-garet font-light text-lg text-dark-text placeholder:text-dark-text/50 focus:outline-none focus:ring-2 focus:ring-gold/50">
                            </div>

                            <!-- Message -->
                            <div>
                                <textarea name="message" placeholder="What would you like support, clarity, or guidance around?" rows="4"
                                    class="w-full px-4 py-2.5 rounded-[10px] bg-white border border-warm-beige font-garet font-light text-lg text-dark-text placeholder:text-dark-text/50 focus:outline-none focus:ring-2 focus:ring-gold/50 resize-none"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <button type="submit" class="w-full h-[41px] rounded-full font-flatline font-bold text-base uppercase tracking-normal text-navy flex items-center justify-center gap-2.5 transition-opacity hover:opacity-90"
                                    style="background: radial-gradient(circle at 65% 0%, #e7d4c5 0%, #d4b478 100%); border: 1px solid #e7d4c5;">
                                    BEGIN THE CONVERSATION
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
