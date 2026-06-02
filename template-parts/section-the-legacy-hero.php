<?php

/**
 * The Legacy Page - Hero Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_hero_heading') ?: "The <em>Legacy</em>";
$subtitle = get_field('section_hero_subtitle') ?: "This path is designed for leaders ready to strengthen their authority, refine how they communicate, and build a message that people immediately understand, remember, and trust.";
$bg_image_id = get_field('section_hero_bg_image');
?>
<section class="relative overflow-hidden min-h-[555px] flex items-center">
    <!-- Background Image -->
    <div class="absolute inset-0 w-full h-full">
        <?php if ($bg_image_id): ?>
            <?= wp_get_attachment_image($bg_image_id, 'full', false, ['class' => 'w-full h-full object-cover object-top', 'aria-hidden' => 'true']) ?>
        <?php else: ?>
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/general-bg.webp" alt="" class="w-full h-full object-cover object-top" aria-hidden="true">
        <?php endif; ?>
    </div>

    <!-- Dark Navy Background -->
    <div class="absolute inset-0 bg-navy -z-10"></div>

    <!-- Decorative ellipses with blur effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-1/4 w-80 h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
    </div>

    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="flex flex-col items-center text-center">
            <!-- Heading -->
            <h1 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[64px] text-white leading-[1.1]">
                <?= $heading ?>
            </h1>

            <!-- Description -->
            <p class="mt-6 font-garet text-lg text-white leading-[27px] max-w-[600px]">
                <?= esc_html($subtitle) ?>
            </p>

            <!-- Back link -->
            <p class="mt-6 font-garet text-base text-white">
                Not You? Go back and <a href="<?php echo esc_url(home_url('/get-started/')); ?>" class="font-flatline font-bold text-gold underline hover:opacity-80 transition-opacity">choose</a> again
            </p>
        </div>
    </div>
</section>
