<?php

/**
 * On Stage Page - Video Section template part.
 *
 * @package TailPress
 */
?>

<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-tight">
            Two Minutes of Her in a <em class="text-gold italic">Room.</em>
        </h2>
        <p class="mt-6 font-garet text-lg text-dark-text leading-relaxed max-w-2xl mx-auto">
            A glimpse into Joanna's presence, storytelling, and emotional leadership in live speaking environments.
        </p>

        <div class="mt-12 max-w-3xl mx-auto">
            <div class="relative aspect-video rounded-lg overflow-hidden bg-gray-600">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/speaker-bg.png" alt="Joanna speaking" class="w-full h-full object-cover">
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-16 h-16 rounded bg-gold flex items-center justify-center cursor-pointer hover:opacity-90 transition-opacity">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 5.14v14l11-7-11-7z" fill="#0f203d"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
