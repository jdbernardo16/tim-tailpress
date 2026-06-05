<?php

/**
 * Tell Your Story Page - Hero Section template part.
 *
 * @package TailPress
 */

$eyebrow = get_field('section_tys_hero_eyebrow') ?: 'Tell Your Story';
$heading = get_field('section_tys_hero_heading') ?: 'Where Leaders<br>Tell The <em class="text-gold italic">Truth.</em>';
$body = get_field('section_tys_hero_body') ?: 'Tell Your Story is the <strong>transformational course + retreat experience</strong> inside the True Influence Method. Created for leaders ready to reconnect with the story behind their influence.';
$cta_text = get_field('section_tys_hero_cta_text') ?: 'VIEW THE RETREAT EXPERIENCE';
$cta_url = get_field('section_tys_hero_cta_url') ?: '#pricing';
$bg_image_id = get_field('section_tys_hero_bg_image');
?>

<section class="relative bg-navy min-h-screen overflow-hidden py-5 pb-20">
    <!-- Background Image -->
    <div class="absolute inset-0 w-full h-full">
        <?php if ($bg_image_id): ?>
            <?= wp_get_attachment_image($bg_image_id, 'full', false, ['class' => 'w-full h-full object-cover', 'alt' => '']) ?>
        <?php else: ?>
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-your-story-hero-bg.webp"
                 alt="" class="w-full h-full object-cover">
        <?php endif; ?>
    </div>

    <!-- Content -->
    <div class="relative z-10 max-w-[600px] mx-auto mt-20 lg:mt-40 text-center px-5">
        <span class="inline-flex items-center font-flatline text-xs font-bold uppercase tracking-[0.3em] text-[#e7d4c5] bg-white/20 rounded-full px-[18px] py-2 mb-8">
            <?= esc_html($eyebrow) ?>
        </span>

        <h1 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[64px] text-white leading-[1.1] mb-6">
            <?= $heading ?>
        </h1>

        <p class="font-garet text-lg font-light text-white leading-[1.6] mb-10 max-w-[592px] mx-auto">
            <?= $body ?>
        </p>

        <a href="<?php echo esc_url($cta_url); ?>" class="btn-primary inline-flex">
            <?= esc_html($cta_text) ?>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="#0f203d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </div>
</section>
