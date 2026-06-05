<?php

/**
 * Hero Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_hero_heading') ?: 'You\'re Not Missing a Message. <em class="text-gold">You\'re Missing Trust.</em>';
$subtitle = get_field('section_hero_subtitle') ?: 'Somewhere along the way, you learned how to explain yourself… but not how to truly be felt.';
$bg_image_id = get_field('section_hero_bg_image');
$profile_image_id = get_field('section_hero_profile_image');
$btn_primary_text = get_field('section_hero_btn_primary_text') ?: 'Start Your Story';
$btn_primary_url = get_field('section_hero_btn_primary_url') ?: '/tell-your-story/';
$btn_secondary_text = get_field('section_hero_btn_secondary_text') ?: 'Watch Joanna Speak';
$btn_secondary_url = get_field('section_hero_btn_secondary_url') ?: '/on-stage/';
?>

<section class="relative bg-navy overflow-hidden">
    <div class="absolute inset-0">
        <?php if ($bg_image_id): ?>
            <?= wp_get_attachment_image($bg_image_id, 'full', false, ['class' => 'w-full h-full object-cover', 'alt' => 'True Influence Method']) ?>
        <?php endif; ?>
    </div>
    <div class="absolute top-0 right-0 blur-sm opacity-50">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/ray.webp" alt="ray">
    </div>
    <div class="absolute -bottom-1/2 right-0">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icon-transparent.webp" alt="icon-transparent">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 lg:pt-32">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <div class="flex-1 text-center lg:text-left">
                <h1 class="font-flatline font-normal text-5xl md:text-6xl text-white leading-tight">
                    <?= $heading ?>
                </h1>
                <p class="mt-6 font-garet text-lg text-white leading-normal max-w-xl mx-auto lg:mx-0">
                    <?= esc_html($subtitle) ?>
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="<?php echo esc_url(home_url($btn_primary_url)); ?>" class="btn-primary">
                        <?= esc_html($btn_primary_text) ?>
                    </a>
                    <a href="<?php echo esc_url(home_url($btn_secondary_url)); ?>" class="btn-secondary text-gold">
                        <?= esc_html($btn_secondary_text) ?>
                    </a>
                </div>
            </div>
            <div class="flex-1 flex justify-center lg:justify-end">
                <?php if ($profile_image_id): ?>
                    <?= wp_get_attachment_image($profile_image_id, 'full', false, ['class' => 'w-full max-w-md lg:max-w-lg object-cover', 'alt' => 'Joanna']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
