<?php

/**
 * On Stage Page - Download Speaker Kit Section template part.
 *
 * @package TailPress
 */
?>

<section class="relative mx-10 rounded-b-3xl bg-gold-section overflow-hidden -translate-y-5">
    <div class="absolute inset-0">
        <img
            src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/voice-bg.png"
            alt=""
            class="w-full h-full object-cover"
            aria-hidden="true">
    </div>

    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-1/4 w-80 h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
    </div>

    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <div class="flex-1 max-w-[714px]">
                <h2 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[64px] text-white leading-[1.1]">
                    Planning an Event or Leadership <em class="text-warm-beige italic">Gathering?</em>
                </h2>
                <p class="mt-6 font-garet text-lg text-white leading-relaxed">
                    Download Joanna's speaker kit for speaking topics, event formats, experience details, and inquiry information.
                </p>
                <div class="mt-10">
                    <a href="#" class="inline-flex items-center gap-2.5 px-6 py-4 rounded-full bg-gradient-to-r from-warm-beige to-gold border border-warm-beige font-flatline font-bold text-sm text-navy">
                        Download Speaker Kit
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="flex-shrink-0 hidden lg:block">
                <div class="relative">
                    <div class="w-64 rounded-lg overflow-hidden shadow-xl">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/joanna-speaker.png" alt="Speaker Kit" class="w-full object-cover">
                    </div>
                    <div class="absolute -top-4 -right-4 w-64 rounded-lg overflow-hidden shadow-xl opacity-90">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/speaker-bg.png" alt="" class="w-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
