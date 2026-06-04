<?php

/**
 * On Stage Page - Experiences Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_experiences_heading');
$subtitle = get_field('section_experiences_subtitle');
?>

<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center text-center">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-tight max-w-[556px]">
                <?= $heading ?>
            </h2>
            <p class="mt-6 font-garet text-lg text-dark-text leading-relaxed max-w-[556px]">
                <?= esc_html($subtitle) ?>
            </p>
        </div>

        <?php if (have_rows('section_experiences_items')): ?>
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-2">
            <?php while (have_rows('section_experiences_items')): the_row(); ?>
                <?php
                $item_title = get_sub_field('item_title');
                $item_length = get_sub_field('item_length');
                $item_ideal = get_sub_field('item_ideal');
                $item_description = get_sub_field('item_description');
                $item_btn_url = get_sub_field('item_btn_url');
                ?>
                <div class="bg-warm-beige rounded-lg pt-10 px-6 pb-10 flex flex-col gap-6">
                    <h3 class="font-flatline font-medium text-3xl text-navy leading-tight">
                        <?= esc_html($item_title) ?>
                    </h3>

                    <div class="flex flex-col gap-2">
                        <?php if ($item_length): ?>
                        <div class="flex items-start gap-4">
                            <div class="flex items-center gap-2 shrink-0">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="9" cy="9" r="7.5" stroke="#ad8b3a" stroke-width="1.5"/>
                                    <path d="M9 5V9L11.5 10.5" stroke="#ad8b3a" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                <span class="font-flatline font-bold text-lg text-navy">Length:</span>
                            </div>
                            <span class="font-garet text-base text-dark-text"><?= esc_html($item_length) ?></span>
                        </div>
                        <?php endif; ?>

                        <?php if ($item_ideal): ?>
                        <div class="flex items-start gap-4">
                            <div class="flex items-center gap-2 shrink-0">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 1.5L2.25 4.5V8.25C2.25 12.8025 5.2875 17.0325 9 18C12.7125 17.0325 15.75 12.8025 15.75 8.25V4.5L9 1.5Z" stroke="#ad8b3a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6.75 9L8.25 10.5L11.25 7.5" stroke="#ad8b3a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="font-flatline font-bold text-lg text-navy">Ideal for:</span>
                            </div>
                            <span class="font-garet text-base text-dark-text"><?= wp_kses_post($item_ideal) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="border-t border-gold-section"></div>

                    <p class="font-garet text-base text-dark-text leading-relaxed">
                        <?= esc_html($item_description) ?>
                    </p>

                    <div class="mt-auto w-full">
                        <a href="<?= esc_url($item_btn_url ?: home_url('/inquiry/')) ?>" class="inline-flex items-center gap-2.5 px-6 py-4 rounded-full w-full justify-center bg-gradient-to-r from-warm-beige to-gold border border-warm-beige font-flatline font-bold text-base text-navy">
                            BOOKING INQUIRY
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
