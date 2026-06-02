<?php

/**
 * Speaker Cohort Page - Pricing CTA Section template part.
 *
 * @package TailPress
 */
?>
<section class="bg-canvas pb-24 lg:pb-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-warm-beige rounded-3xl overflow-hidden">
            <!-- Background texture -->
            <div class="absolute inset-0">
                <img class="w-full h-full object-cover" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/cta-bg.webp" alt="" aria-hidden="true">
            </div>



            <div class="relative px-6 py-20 md:px-12 md:py-24 lg:px-20 flex flex-col items-center text-center">
                <!-- Heading -->
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1] max-w-[620px]">
                    Some People Know Their Work. Others Can Others <em class="text-gold italic">Move a Room</em> With it.
                </h2>

                <!-- Pricing -->
                <div class="mt-10 flex flex-col items-center">
                    <p class="font-flatline font-semibold text-3xl text-navy">Starting at</p>
                    <div class="mt-4 flex items-center gap-4">
                        <span class="font-flatline font-semibold text-3xl text-dark-text/40 line-through italic">$20,000</span>
                        <span class="font-flatline font-semibold text-5xl md:text-6xl text-gold-section italic">$12,000</span>
                    </div>
                    <p class="mt-4 font-garet text-base text-navy">Featured retreat speaking opportunity included</p>
                </div>

                <!-- CTA -->
                <div class="mt-10">
                    <a href="<?php echo esc_url(home_url('/speaker-cohort/')); ?>" class="btn-primary">
                        TAKE THE STAGE
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
