<?php

/**
 * Speaker Cohort Section template part.
 *
 * @package TailPress
 */
?>

<section class="relative mx-10 rounded-3xl overflow-hidden bg-navy">
    <!-- Background image -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/speaker-bg.webp');"></div>

    <!-- Speaker Cohort gradient text watermark -->
    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/speaker-cohort.webp"
        alt="SPEAKER COHORT"
        class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-[1360px] pointer-events-none select-none z-1"
        aria-hidden="true">

    <div class="relative flex items-center justify-between max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[564px]">
        <!-- Left image -->
        <div class="flex-1 flex justify-start items-end h-full">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/joana-speaker.webp"
                alt="Joanna - Speaker Cohort"
                class="h-full w-auto object-contain object-bottom">
        </div>

        <!-- Right content -->
        <div class="flex-1 max-w-[480px]">
            <h2 class="font-flatline font-semibold text-white text-center" style="font-size: 56px; line-height: 1.1;">
                <em class="text-gold italic">Move</em> the Room.
            </h2>
            <p class="mt-6 text-body text-white">
                Speaker Cohort is Joanna's advanced speaking experience for leaders ready to communicate with clarity, emotional authority, and presence that moves people to action.
            </p>
            <div class="mt-8">
                <a href="<?php echo esc_url(home_url('/speaker-cohort/')); ?>" class="btn-primary">
                    Explore Speaker Cohort
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/btn-arrow.svg" alt="" class="w-5 h-2" aria-hidden="true">
                </a>
            </div>
        </div>
    </div>
</section>
