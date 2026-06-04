<?php

/**
 * On Stage Page - Hero Section template part.
 *
 * @package TailPress
 */

$stats_fallback = array(
    array(
        'icon'  => 'UsersThree',
        'value' => '150+',
        'label' => 'Stages Worldwide',
    ),
    array(
        'icon'  => 'SealCheck',
        'value' => '12',
        'label' => 'Countries',
    ),
);
$heading = get_field('section_hero_heading') ?: 'Invite Joanna<br>Into the <em class="text-gold italic">Room.</em>';
$subtitle = get_field('section_hero_subtitle') ?: 'Keynotes, leadership conversations, retreats, and transformational speaking experiences designed to help people reconnect with the truth behind their voice, leadership, and influence.';
$bg_image_id = get_field('section_hero_bg_image');
$profile_image_id = get_field('section_hero_profile_image');
?>

<section class="relative bg-navy overflow-hidden min-h-[560px] sm:min-h-[640px] lg:min-h-auto">
    <!-- Background image -->
    <div class="absolute inset-0">
        <?php if ($bg_image_id): ?>
            <?= wp_get_attachment_image($bg_image_id, 'full', false, array('class' => 'w-full h-full object-cover')) ?>
        <?php endif; ?>
    </div>


    <!-- Logo watermark -->
    <!-- <div class="absolute top-[300px] left-1/2 -translate-x-1/2 w-[1080px] h-[1080px] opacity-5 mix-blend-luminosity pointer-events-none">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icononly_transparent_nobuffer.webp" alt="" class="w-full h-full object-contain">
    </div> -->

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 lg:pt-32 h-full">
        <!-- Content Block - Centered -->
        <div class="flex flex-col items-center text-center h-full justify-between">
            <!-- Text Content -->
            <div class="max-w-[665px]">
                <h1 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[64px] text-white leading-[1.1]">
                    <?= $heading ?>
                </h1>
                <p class="mt-6 font-garet text-lg text-white leading-[27px] max-w-[665px] mx-auto">
                    <?= esc_html($subtitle) ?>
                </p>
            </div>

            <!-- Joanna Image - Centered -->
            <div class="mt-8 flex justify-center">
                <?php if ($profile_image_id): ?>
                    <?= wp_get_attachment_image($profile_image_id, 'full', false, array('class' => 'w-[280px] sm:w-[338px] max-w-full object-contain', 'alt' => 'Joanna Horton McPherson')) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Stats Bar - Full width gradient -->
    <div class="absolute bottom-0 left-0 right-0 flex items-end" style="height: 163px; background: linear-gradient(to top, #0f203d 21%, #0f203d00 100%);">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-wrap justify-center gap-6 lg:gap-0">
                <?php if (have_rows('section_hero_stats')): ?>
                    <?php $stat_index = 0; ?>
                    <?php while (have_rows('section_hero_stats')): the_row(); ?>
                        <?php if ($stat_index > 0) : ?>
                            <div class="hidden lg:block w-px h-6 bg-white/40 self-center mx-8"></div>
                        <?php endif; ?>
                        <?php $item_icon_id = get_sub_field('item_icon'); ?>
                        <div class="flex items-center gap-3">
                            <?php if ($item_icon_id): ?>
                                <div class="w-6 h-6 flex items-center justify-center">
                                    <?= wp_get_attachment_image($item_icon_id, 'medium', false, array('class' => 'w-6 h-6')) ?>
                                </div>
                            <?php endif; ?>
                            <div class="flex items-baseline gap-1">
                                <span class="font-flatline font-semibold text-lg text-gold"><?php echo esc_html(get_sub_field('item_value')); ?></span>
                            </div>
                            <span class="font-garet text-sm text-white"><?php echo esc_html(get_sub_field('item_label')); ?></span>
                        </div>
                        <?php $stat_index++; ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
