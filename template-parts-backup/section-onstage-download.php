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
            src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/voice-bg.webp"
            alt=""
            class="w-full h-full object-cover"
            aria-hidden="true">
    </div>

    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-1/4 w-80 h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <div class="flex-1 max-w-[714px]">
                <h2 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[64px] text-white leading-[1.1]">
                    Planning an Event or Leadership Gathering?
                </h2>
                <p class="mt-6 font-garet text-lg text-white leading-relaxed">
                    Download Joanna's speaker kit for speaking topics, event formats, experience details, and inquiry information.
                </p>
                <div class="mt-10 flex flex-wrap items-center gap-4">
                    <a href="<?php echo esc_url(home_url('/inquiry/')); ?>" class="inline-flex items-center gap-2.5 px-6 py-4 rounded-full bg-gradient-to-r from-warm-beige to-gold border border-warm-beige font-flatline font-bold text-sm text-navy">
                        Download Speaker Kit
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <a href="<?php echo esc_url(home_url('/inquiry/')); ?>" class="inline-flex items-center gap-2.5 px-6 py-4 rounded-full border border-white font-flatline font-bold text-sm text-white hover:bg-white/10 transition-colors">
                        Download Speaker Kit
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="flex-shrink-0 hidden lg:block relative">
                <div class="relative w-64 h-80">
                    <div class="absolute -top-10 -right-4 w-64 h-80 rounded-lg overflow-hidden shadow-xl">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/speaker-kit2.webp" alt="" class="w-full h-full object-cover">
                    </div>
                    <div class="absolute top-4 left-0 w-64 h-80 rounded-lg overflow-hidden shadow-xl z-10">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/speaker-kit.webp" alt="Speaker Kit" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
