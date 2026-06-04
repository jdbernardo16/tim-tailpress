<?php

/**
 * The Journey Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_journey_heading') ?: 'The <em class="text-gold italic">Journey</em>';
?>

<section class="relative bg-canvas">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <!-- Header -->
        <div class="text-center mb-16">
            <h2 class="font-flatline font-medium text-5xl md:text-6xl text-navy leading-tight">
                <?= $heading ?>
            </h2>
            <p class="mt-4 font-garet text-lg text-dark-text">
                The True influence method.
            </p>
        </div>

        <!-- Cards Row -->
        <div class="space-y-6">
            <?php if (have_rows('section_journey_items')): ?>
                <?php $phase_num = 1; while (have_rows('section_journey_items')): the_row(); ?>
                    <?php $item_icon_id = get_sub_field('item_icon'); ?>
                    <div class="relative rounded-lg overflow-hidden bg-zinc-200 aspect-[1100/362] group">
                        <?php if ($item_icon_id): ?>
                            <?= wp_get_attachment_image($item_icon_id, 'full', false, ['class' => 'w-full h-full object-cover object-top', 'alt' => esc_attr(get_sub_field('item_heading'))]) ?>
                        <?php endif; ?>

                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

                        <!-- Content -->
                        <div class="absolute bottom-0 left-0 right-0 p-5">
                            <h3 class="font-flatline font-medium text-3xl text-white leading-tight">
                                <?= esc_html(get_sub_field('item_heading')) ?>
                            </h3>
                            <p class="mt-2 font-garet text-base text-white leading-relaxed">
                                <?= esc_html(get_sub_field('item_text')) ?>
                            </p>
                        </div>

                        <!-- Phase Watermark -->
                        <div class="absolute top-3 right-3 font-flatline font-medium text-5xl text-white/20 leading-none select-none">
                            PHASE <?= $phase_num ?>
                        </div>
                    </div>
                <?php $phase_num++; endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
