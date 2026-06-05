<?php

/**
 * The Journey Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_journey_heading') ?: 'The <em class="text-gold italic">Journey</em>';
$subtitle = '5 phases of growth of the True Influence Method';
?>

<section class="relative bg-canvas">
    <div class="max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <!-- Header -->
        <div class="text-center mb-10">
            <h2 class="font-flatline font-medium text-5xl lg:text-[56px] text-navy leading-tight">
                <?= $heading ?>
            </h2>
            <p class="mt-4 text-body text-dark-text">
                <?= esc_html($subtitle) ?>
            </p>
        </div>

        <!-- Cards -->
        <div class="space-y-2">
            <?php if (have_rows('section_journey_items')): ?>
                <?php $phase_num = 1; while (have_rows('section_journey_items')): the_row(); ?>
                    <?php
                    $item_icon_id = get_sub_field('item_icon');
                    $default_urls = [
                        1 => home_url('/tell-your-story/'),
                        2 => home_url('/speaker-cohort/'),
                        3 => home_url('/million-dollar-message/'),
                        4 => home_url('/build-my-team/'),
                        5 => home_url('/be-remembered/'),
                    ];
                    $item_url = get_sub_field('item_url') ?: ($default_urls[$phase_num] ?? '#');
                    ?>
                    <a
                        href="<?= esc_url($item_url) ?>"
                        class="group block relative rounded-[10px] overflow-hidden bg-zinc-200 aspect-[16/12] sm:aspect-[1100/362] focus:outline-none focus-visible:ring-2 focus-visible:ring-gold focus-visible:ring-offset-2 transition-shadow hover:shadow-lg"
                        aria-label="Learn more about <?= esc_attr(get_sub_field('item_heading')) ?>"
                    >
                        <?php if ($item_icon_id): ?>
                            <?= wp_get_attachment_image($item_icon_id, 'full', false, ['class' => 'absolute inset-0 w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105', 'alt' => esc_attr(get_sub_field('item_heading'))]) ?>
                        <?php endif; ?>

                        <!-- Gradient Overlay (bottom 55%, transparent → navy) -->
                        <div class="absolute bottom-0 left-0 right-0 h-[55%] bg-gradient-to-t from-navy to-transparent"></div>

                        <!-- Content Row (heading left, description right) -->
                        <div class="absolute bottom-5 sm:bottom-16 left-0 right-0 px-5 sm:px-10 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2 sm:gap-6">
                            <h3 class="text-2xl sm:heading-card text-white sm:max-w-[65%]">
                                <?= esc_html(get_sub_field('item_heading')) ?>
                            </h3>
                            <p class="text-sm sm:text-body-sm text-white text-left sm:text-right sm:max-w-[40%]">
                                <?= esc_html(get_sub_field('item_text')) ?>
                            </p>
                        </div>

                        <!-- Phase Label (bottom-left, gradient fade) -->
                        <div class="absolute !bottom-0 sm:bottom-6 left-5 sm:left-10 font-flatline font-semibold text-2xl sm:text-[56px] leading-none select-none bg-gradient-to-b from-white to-white/30 bg-clip-text text-transparent">
                            PHASE <?= str_pad($phase_num, 2, '0', STR_PAD_LEFT) ?>
                        </div>
                    </a>
                <?php $phase_num++; endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
