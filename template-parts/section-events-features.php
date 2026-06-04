<?php

/**
 * Events Page - Features Section template part.
 *
 * @package TailPress
 */

$bg_image_id = get_field('section_features_bg_image');
$heading = get_field('section_features_heading') ?: '<em class="text-gold italic">More</em> <span class="text-navy">Than Events.</span>';
?>
<section class="relative z-10 px-8">
    <div class="py-24 lg:py-32 relative">
        <?php if ($bg_image_id): ?>
            <?= wp_get_attachment_image($bg_image_id, 'full', false, ['class' => 'absolute top-0 left-0 w-full h-full object-cover rounded-2xl', 'alt' => '']) ?>
        <?php endif; ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] leading-[1.1]">
                <?= $heading ?>
            </h2>

            <?php if (have_rows('section_features_items')): ?>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 mt-16 relative">
                    <?php while (have_rows('section_features_items')): the_row(); ?>
                        <?php $item_icon_id = get_sub_field('item_icon'); ?>
                        <div class="text-center">
                            <?php if ($item_icon_id): ?>
                                <div class="mx-auto h-10 w-10 flex items-center justify-center">
                                    <?= wp_get_attachment_image($item_icon_id, 'full', false, ['class' => 'h-full w-auto', 'alt' => '']) ?>
                                </div>
                            <?php endif; ?>
                            <h3 class="mt-4 uppercase text-sm tracking-wide text-navy font-medium"><?php echo esc_html(get_sub_field('item_heading')); ?></h3>
                            <p class="mt-2 font-garet text-sm text-dark-text leading-[150%]"><?php echo esc_html(get_sub_field('item_text')); ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</section>
