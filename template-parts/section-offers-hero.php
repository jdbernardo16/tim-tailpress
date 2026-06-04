<?php

/**
 * Offers Page - Hero Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_hero_heading') ?: "Ways to Work<br>with Joanna.";
$subtitle = get_field('section_hero_subtitle') ?: 'From transformational retreats and speaker development to private leadership work and live conversations, each experience inside the True Influence Method&trade; is designed to help leaders communicate with greater clarity, authority, and emotional truth.';
$bg_image_id = get_field('section_hero_bg_image');
?>
<section class="relative overflow-hidden min-h-[400px] sm:min-h-[500px] lg:min-h-[555px] flex items-center">
    <!-- Background Image -->
    <div class="absolute inset-0 w-full h-full">
        <?php if ($bg_image_id): ?>
            <?= wp_get_attachment_image($bg_image_id, 'full', false, ['class' => 'w-full h-full object-cover object-top', 'aria-hidden' => 'true']) ?>
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
        </div>
    </div>
</section>
