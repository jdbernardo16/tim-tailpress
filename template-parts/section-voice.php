<?php

/**
 * Your Voice Section template part.
 *
 * @package TailPress
 */
?>

<section class="relative mx-10 rounded-3xl bg-gold-section overflow-hidden">
    <!-- Background texture -->
    <div class="absolute inset-0">
        <img
            src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/voice-bg.webp"
            alt=""
            class="w-full h-full object-cover"
            aria-hidden="true">
    </div>

    <!-- Decorative deep blue ellipses -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-1/4 w-80 h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
    </div>

    <!-- Decorative images -->
    <div class="absolute inset-0 pointer-events-none hidden xl:block">
        <div class="absolute top-12 left-12 w-48 h-48 rounded-xl overflow-hidden">
            <img
                src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/voice-gallery-1.webp"
                alt=""
                class="w-full h-full object-cover"
                aria-hidden="true">
        </div>
        <div class="absolute bottom-12 right-12 w-48 h-48 rounded-xl overflow-hidden">
            <img
                src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/voice-gallery-2.webp"
                alt=""
                class="w-full h-full object-cover"
                aria-hidden="true">
        </div>
        <div class="absolute top-40 left-20 w-44 h-44 rounded-xl overflow-hidden">
            <img
                src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/voice-gallery-3.webp"
                alt=""
                class="w-full h-full object-cover"
                aria-hidden="true">
        </div>
        <div class="absolute top-16 right-20 w-56 h-56 rounded-xl overflow-hidden">
            <img
                src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/voice-gallery-4.webp"
                alt=""
                class="w-full h-full object-cover"
                aria-hidden="true">
        </div>
        <div class="absolute bottom-20 left-24 w-56 h-56 rounded-xl overflow-hidden">
            <img
                src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/voice-gallery-5.webp"
                alt=""
                class="w-full h-full object-cover"
                aria-hidden="true">
        </div>
    </div>

    <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 text-center">
        <h2 class="font-flatline font-semibold text-5xl md:text-6xl text-white leading-tight">
            Your Voice Carries More Than <em class="text-warm-beige italic">Information.</em>
        </h2>
        <p class="mt-6 font-garet text-lg text-white leading-normal">
            It carries your story. Your leadership.<br>The life that shaped you.
        </p>
        <div class="mt-10">
            <a href="<?php echo esc_url(home_url('/get-started/')); ?>" class="btn-primary">
                Start Your Story Journey
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>
        <div class="mt-10 pt-8">
            <p class="font-flatline font-semibold text-lg text-white">
                Not Sure Where You Are?
            </p>
            <p class="mt-2 font-garet text-base text-white leading-normal">
                Take the 5-minute <span class="underline">Influence Path Assessment</span> and we'll know what you need
            </p>
        </div>
    </div>
</section>