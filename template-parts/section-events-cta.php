<?php

/**
 * Events Page - CTA Section template part.
 *
 * @package TailPress
 */
?>
<section class="relative mx-8 rounded-b-3xl bg-gold-section overflow-hidden -translate-y-5">
    <!-- Background texture -->
    <div class="absolute inset-0">
        <img
            src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/voice-bg.png"
            alt=""
            class="w-full h-full object-cover"
            aria-hidden="true">
    </div>


    <!-- Decorative deep blue ellipses -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-1/4 w-80 h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
    </div>

    <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 text-center">
        <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-white leading-[1.1]">
            Not Sure Where to<br><em class="text-gold italic">Begin?</em>
        </h2>
        <p class="mt-6 font-garet text-lg text-white max-w-xl mx-auto leading-[150%]">
            We'll help guide you toward the experience, retreat, or next step that feels most aligned with where you are right now.
        </p>
        <div class="mt-10">
            <a href="#" class="btn-primary">
                Find Your Path
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                    <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>
</section>