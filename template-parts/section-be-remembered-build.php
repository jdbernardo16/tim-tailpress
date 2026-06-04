<?php

/**
 * Be Remembered Page - "What You Build" Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_build_heading') ?: 'What You <em class="text-gold italic">Build</em>';
$text = get_field('section_build_text');
$btn_text = get_field('section_build_btn_text');
?>
<section class="bg-canvas py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-navy rounded-3xl overflow-hidden">
            <!-- Background texture -->
            <div class="absolute inset-0 opacity-10">
                <img class="w-full h-full object-cover" src="<?= esc_url(get_template_directory_uri()) ?>/assets/images/general-bg.webp" alt="" aria-hidden="true">
            </div>

            <!-- Decorative blurred ellipses -->
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-deep-blue/60 rounded-full blur-3xl"></div>
                <div class="absolute -top-32 -left-40 w-[500px] h-[500px] bg-gold/30 rounded-full blur-3xl"></div>
            </div>

            <!-- Be Remembered wordmark behind heading -->
            <div class="absolute top-6 left-0 right-0 flex justify-center pointer-events-none">
                <img src="<?= esc_url(get_template_directory_uri()) ?>/assets/images/be-remembered-text.webp" alt="" aria-hidden="true" class="h-20 md:h-24 opacity-20 object-contain">
            </div>

            <div class="relative px-6 py-20 md:px-12 md:py-24 lg:px-20 lg:py-28 flex flex-col items-center text-center">
                <!-- Heading -->
                <h2 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[56px] text-white leading-[1.1]">
                    <?= $heading ?>
                </h2>

                <!-- Bullets Box -->
                <?php if (have_rows('section_build_items')): ?>
                <div class="mt-12 w-full max-w-[750px] bg-warm-beige/10 rounded-[10px] px-6 py-6 md:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-2">
                        <?php while (have_rows('section_build_items')): the_row(); ?>
                            <div class="flex items-center gap-3 py-1">
                                <svg class="w-4 h-4 flex-shrink-0 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                                </svg>
                                <span class="font-garet text-base text-white text-left"><?= esc_html(get_sub_field('item_heading')) ?></span>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($text): ?>
                <?= $text ?>
                <?php else: ?>
                <!-- Bottom Text -->
                <p class="mt-10 font-garet text-lg text-white leading-[1.5] max-w-[600px]">
                    You create a long-term framework for your voice, wealth, and contribution, designed to carry forward without depending on you alone.
                </p>
                <?php endif; ?>

                <?php if ($btn_text): ?>
                <div class="mt-10">
                    <a href="#register" class="btn-primary scroll-smooth">
                        <?= esc_html($btn_text) ?>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
