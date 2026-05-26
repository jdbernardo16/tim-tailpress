<?php

/**
 * Discover Section template part.
 *
 * @package TailPress
 */
?>

<section class="relative mx-10 rounded-b-3xl bg-warm-beige overflow-hidden">
    <!-- Decorative blurred gold ellipses -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-96 h-96 bg-gold/30 rounded-full blur-3xl transform -translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-gold/20 rounded-full blur-3xl transform translate-y-1/2"></div>
    </div>

    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <div class="flex-1 max-w-[457px]">
                <h2 class="text-[56px] leading-tight font-flatline">
                    Discover the Message <em class="text-gold italic">Hidden</em> Inside Your Story.
                </h2>
                <p class="mt-6 text-body">
                    A guided experience to help you uncover the truth, perspective, and story behind your influence.
                </p>
                <div class="mt-8">
                    <a href="#" class="btn-primary">
                        Explore the $29 MILLION DOLLAR Experience
                    </a>
                </div>
            </div>
            <div class="relative flex-1">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/discover.png" alt="Joanna - Discover" class="w-full">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/discover-whole.png" alt="Joanna - Discover" class="w-full absolute bottom-0 left-0">

            </div>

        </div>
    </div>
</section>