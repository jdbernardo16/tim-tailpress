<?php

/**
 * Events Page - Hero Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_hero_heading') ?: 'Experiences That <em class="text-gold">Move</em> You.';
$subtitle = get_field('section_hero_subtitle') ?: 'Retreats, speaking experiences, leadership conversations, and transformational gatherings designed to reconnect people with the truth behind their voice and influence.';
$bg_image_id = get_field('section_hero_bg_image');
$profile_image_id = get_field('section_hero_profile_image');
?>
<section class="relative overflow-hidden min-h-[555px] flex items-center">
    <!-- Background Image -->
    <div class="absolute inset-0 w-full h-full">
        <?php if ($bg_image_id): ?>
            <?= wp_get_attachment_image($bg_image_id, 'full', false, array('class' => 'w-full h-full object-cover object-top', 'alt' => '')) ?>
        <?php else: ?>
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/general-bg.webp" alt="" class="w-full h-full object-cover object-top" aria-hidden="true">
        <?php endif; ?>
    </div>


    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="flex flex-col items-center text-center">
            <!-- Subtitle pill -->
            <span class="inline-flex items-center rounded-full bg-white/20 backdrop-blur-sm px-4 py-1.5 text-xs font-medium uppercase tracking-widest text-white/80">
                Events & Workshops
            </span>

            <!-- Heading -->
            <h1 class="mt-6 font-flatline font-semibold text-4xl md:text-5xl lg:text-[64px] text-white leading-[1.1]">
                <?= $heading ?>
            </h1>

            <!-- Description -->
            <p class="mt-6 font-garet text-lg text-white leading-[27px] max-w-[600px]">
                <?= esc_html($subtitle) ?>
            </p>
        </div>
    </div>
</section>
