<?php

/**
 * Trusted By Leaders Section template part.
 *
 * @package TailPress
 */
?>

<section class="bg-white py-24">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex space-x-20 justify-between">
            <p class="text-lg font-flatline font-semibold uppercase tracking-[50%] text-navy mb-12">
                Trusted by<br>leaders worldwide
            </p>

            <div class="flex flex-wrap justify-center gap-12 md:gap-16 mb-16">
                <div class="flex items-center gap-4">
                    <!-- UsersThree icon -->
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/UsersThree.svg" alt="">
                    <div>
                        <p class="font-flatline text-lg font-semibold leading-[1.2rem] text-navy">10,000+</p>
                        <p class="font-garet text-base text-dark-text">Leaders Transformed</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <!-- SealCheck icon -->
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/SealCheck.svg" alt="">
                    <div>
                        <p class="font-flatline text-lg font-semibold leading-[1.2rem] text-navy">30+</p>
                        <p class="font-garet text-base text-dark-text">Years of Work</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="marquee overflow-hidden">
        <div class="marquee__track flex gap-8 md:gap-12 opacity-60 grayscale">
            <?php for ($j = 0; $j < 2; $j++) : ?>
                <?php for ($i = 1; $i <= 30; $i++) : ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logos/logo-company-<?php echo $i; ?>.png" alt="" class="marquee__img h-10 w-auto object-contain">
                <?php endfor; ?>
            <?php endfor; ?>
        </div>
    </div>
</section>