<?php

/**
 * About Page - Hero Section template part.
 *
 * @package TailPress
 */

$stats = array(
    array(
        'icon'  => 'UsersThree',
        'value' => '10,000',
        'label' => 'Leaders Transformed',
    ),
    array(
        'icon'  => 'SealCheck',
        'value' => '30',
        'label' => 'Years of Work',
    ),
    array(
        'icon'  => 'Lectern',
        'value' => '1,000',
        'label' => 'Keynotes Delivered',
    ),
    array(
        'icon'  => 'UserCircleCheck',
        'value' => '6',
        'label' => 'Founder & Investor',
    ),
);
?>

<section class="relative bg-navy overflow-hidden h-screen">
    <!-- Background image -->
    <div class="absolute inset-0">
        <img class="w-full h-full object-cover" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/about-joanna-bg.png" alt="">
    </div>


    <!-- Logo watermark -->
    <!-- <div class="absolute top-[300px] left-1/2 -translate-x-1/2 w-[1080px] h-[1080px] opacity-5 mix-blend-luminosity pointer-events-none">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icononly_transparent_nobuffer.png" alt="" class="w-full h-full object-contain">
    </div> -->

    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 lg:pt-32 h-full">
        <!-- Content Block - Centered -->
        <div class="flex flex-col items-center text-center h-full justify-between">
            <!-- Text Content -->
            <div class="max-w-[665px]">
                <h1 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[64px] text-white leading-[1.1]">
                    Influence Begins<br>With What's <em class="text-gold italic">True.</em>
                </h1>
                <p class="mt-6 font-garet text-lg text-white leading-[27px] max-w-[665px] mx-auto">
                    Joanna Horton McPherson is a private advisor, speaker, and creator of the True Influence Method™ — helping leaders turn lived experience into messages people trust, feel, and follow.
                </p>
            </div>

            <!-- Joanna Image - Centered -->
            <div class="mt-8 flex justify-center">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/about-joanna-img.png" alt="Joanna Horton McPherson" class="w-[338px] object-contain">
            </div>
        </div>
    </div>

    <!-- Stats Bar - Full width gradient -->
    <div class="absolute bottom-0 left-0 right-0 flex items-end" style="height: 163px; background: linear-gradient(to top, #0f203d 21%, #0f203d00 100%);">
        <div class="w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-wrap justify-center gap-6 lg:gap-0">
                <?php foreach ($stats as $index => $stat) : ?>
                    <?php if ($index > 0) : ?>
                        <div class="hidden lg:block w-px h-6 bg-white/40 self-center mx-8"></div>
                    <?php endif; ?>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 flex items-center justify-center">
                            <?php if ($stat['icon'] === 'UsersThree') : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/UsersThree.svg" alt="" class="w-6 h-6">
                            <?php elseif ($stat['icon'] === 'SealCheck') : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/SealCheck.svg" alt="" class="w-6 h-6">
                            <?php elseif ($stat['icon'] === 'Lectern') : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/Lectern.svg" alt="" class="w-6 h-6">
                            <?php elseif ($stat['icon'] === 'UserCircleCheck') : ?>
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/UserCircleCheck.svg" alt="" class="w-6 h-6">
                            <?php endif; ?>
                        </div>
                        <div class="flex items-baseline gap-1">
                            <span class="font-flatline font-semibold text-lg text-gold"><?php echo esc_html($stat['value']); ?></span>
                        </div>
                        <span class="font-garet text-sm text-white"><?php echo esc_html($stat['label']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>