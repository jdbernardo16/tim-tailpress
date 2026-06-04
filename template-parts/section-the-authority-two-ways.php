<?php

/**
 * The Authority Page - Two Ways Forward Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_two_ways_heading');
?>
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center text-center">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                <?= $heading ?>
            </h2>
            <p class="mt-6 font-garet text-lg text-dark-text leading-[150%] max-w-[556px]">
                Build the structured talk that lands, or go all the way to keynote / TEDx.
            </p>
            <p class="mt-6 font-garet text-lg text-dark-text leading-[150%] font-semibold">
                Become a Speaker with Joanna
            </p>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-2">
            <?php if (have_rows('section_two_ways_items')): ?>
                <?php while (have_rows('section_two_ways_items')): the_row(); ?>
                    <?php
                    $item_heading = get_sub_field('item_heading');
                    $item_text = get_sub_field('item_text');
                    $item_price = get_sub_field('item_price');
                    $item_price_label = get_sub_field('item_price_label');
                    $item_includes = get_sub_field('item_includes');
                    $item_btn_text = get_sub_field('item_btn_text');
                    $item_btn_url = get_sub_field('item_btn_url');
                    ?>
                    <div class="bg-warm-beige rounded-[10px] border border-gold-section p-6 sm:p-8 flex flex-col">
                        <h3 class="font-flatline font-medium text-3xl text-navy leading-[1.1]">
                            <?= wp_kses_post($item_heading) ?>
                        </h3>

                        <?php if ($item_text): ?>
                            <p class="mt-6 font-garet text-lg text-dark-text leading-[150%]">
                                <?= esc_html($item_text) ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($item_includes): ?>
                        <ul class="mt-4 space-y-2">
                            <?php foreach (explode("\n", $item_includes) as $line): ?>
                                <?php $line = trim($line); if (!$line) continue; ?>
                                <li class="flex items-center gap-3 font-garet text-lg text-dark-text">
                                    <svg class="w-5 h-5 flex-shrink-0 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                                        <path d="M18 14L18.75 16.25L21 17L18.75 17.75L18 20L17.25 17.75L15 17L17.25 16.25L18 14Z" opacity="0.6"/>
                                        <path d="M6 14L6.75 16.25L9 17L6.75 17.75L6 20L5.25 17.75L3 17L5.25 16.25L6 14Z" opacity="0.6"/>
                                    </svg>
                                    <span><?php echo esc_html($line); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>

                        <div class="mt-10 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-baseline gap-2">
                                <?php if ($item_price_label): ?>
                                    <span class="font-flatline text-base text-dark-text"><?= esc_html($item_price_label) ?></span>
                                <?php endif; ?>
                                <?php if ($item_price): ?>
                                    <span class="font-flatline font-medium text-4xl text-gold leading-[1.1]"><?= esc_html($item_price) ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if ($item_btn_text && $item_btn_url): ?>
                                <a href="<?php echo esc_url($item_btn_url); ?>" class="btn-primary">
                                    <?= esc_html($item_btn_text) ?>
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
