<?php

/**
 * On Stage Page - Credibility Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_credibility_heading');
?>

<section class="bg-canvas px-4 sm:px-10">
    <div class="relative overflow-hidden rounded-[20px] bg-navy">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-10" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/bg-texture.webp" alt="">
        </div>

        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 right-0 w-[1535px] h-[1535px] bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3"></div>
            <div class="absolute top-0 left-0 w-[1525px] h-[1525px] bg-gold/10 rounded-full blur-3xl transform -translate-x-2/3 -translate-y-2/3"></div>
        </div>

        <div class="absolute -top-3 left-1/2 -translate-x-1/2 pointer-events-none select-none">
            <h2 class="font-flatline font-bold text-[117px] leading-none text-transparent bg-clip-text bg-gradient-to-b from-white to-white/0 opacity-20">
                CREDIBILITY
            </h2>
        </div>

        <div class="relative max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center mb-20">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-white leading-tight">
                    <?= $heading ?>
                </h2>
            </div>

            <?php if (have_rows('section_credibility_featured')): ?>
            <div class="relative mb-20">
                <div class="swiper onstage-credibility-featured-swiper">
                    <div class="swiper-wrapper">
                        <?php while (have_rows('section_credibility_featured')): the_row(); ?>
                            <?php
                            $featured_image_id = get_sub_field('item_image');
                            $featured_badge = get_sub_field('item_badge');
                            $featured_title = get_sub_field('item_title');
                            $featured_date = get_sub_field('item_date');
                            ?>
                            <div class="swiper-slide">
                                <div class="flex flex-col lg:flex-row items-center gap-[64px]">
                                    <div class="w-full lg:w-[708px] rounded-[10px] bg-white overflow-hidden flex-shrink-0">
                                        <?php if ($featured_image_id): ?>
                                        <div class="w-full h-[400px]">
                                            <?= wp_get_attachment_image($featured_image_id, 'full', false, ['class' => 'w-full h-full object-cover']) ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="w-full lg:w-[328px] flex flex-col gap-6">
                                        <?php if ($featured_badge): ?>
                                        <div class="inline-flex self-start items-center px-4 py-2 rounded-full bg-white/20 backdrop-blur-[3px]">
                                            <span class="font-flatline font-black text-xs text-warm-beige tracking-[0.15em]"><?= esc_html($featured_badge) ?></span>
                                        </div>
                                        <?php endif; ?>

                                        <?php if ($featured_title): ?>
                                        <h3 class="font-flatline font-semibold text-gold text-[22px] leading-[110%]">
                                            <?= nl2br(esc_html($featured_title)) ?>
                                        </h3>
                                        <?php endif; ?>

                                        <?php if ($featured_date): ?>
                                        <p class="font-garet text-white text-lg">
                                            <?= esc_html($featured_date) ?>
                                        </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>

                <div class="onstage-credibility-featured-nav ml-auto w-fit">
                    <button class="onstage-credibility-featured-swiper-button-prev onstage-credibility-featured-nav__btn" aria-label="Previous slide">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                    </button>
                    <button class="onstage-credibility-featured-swiper-button-next onstage-credibility-featured-nav__btn" aria-label="Next slide">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>
            <?php endif; ?>

            <?php if (have_rows('section_credibility_items')): ?>
                <div class="flex flex-col gap-6">
                    <?php $item_count = 0; ?>
                    <?php while (have_rows('section_credibility_items')): the_row(); ?>
                        <?php if ($item_count % 4 === 0): ?>
                            <?php if ($item_count > 0): ?>
                    </div>
                            <?php endif; ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
                        <?php endif; ?>
                        <div class="rounded-[10px] bg-white/15 backdrop-blur-[9px] border border-gold p-5 min-h-[201px] flex flex-col">
                            <?php $item_badge = get_sub_field('item_badge'); ?>
                            <?php if ($item_badge): ?>
                            <div class="inline-flex self-start items-center px-4 py-2 rounded-full bg-white/20 backdrop-blur-[3px] mb-2">
                                <span class="font-flatline font-black text-xs text-warm-beige tracking-[0.15em]"><?= esc_html($item_badge) ?></span>
                            </div>
                            <?php endif; ?>
                            <h4 class="font-flatline font-semibold text-gold text-lg leading-[110%] flex-1">
                                <?php echo esc_html(get_sub_field('item_heading')); ?>
                            </h4>
                            <p class="font-garet text-white text-sm mt-6">
                                <?php echo esc_html(get_sub_field('item_date')); ?>
                            </p>
                        </div>
                        <?php $item_count++; ?>
                    <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
