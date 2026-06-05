<?php

/**
 * Events Page - Upcoming Experiences Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_upcoming_heading') ?: '<em class="text-gold italic">Upcoming</em> <span class="text-navy">Experiences</span>';
?>

<section id="upcoming" class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] leading-[110%] text-center">
            <?= $heading ?>
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 mt-12">
            <?php if (have_rows('section_upcoming_items')): ?>
                <?php while (have_rows('section_upcoming_items')): the_row(); ?>
                    <?php $item_image_id = get_sub_field('item_image'); ?>
                    <div class="overflow-hidden">
                        <?php if ($item_image_id): ?>
                        <div class="aspect-[16/9] overflow-hidden rounded-xl mb-8">
                            <?= wp_get_attachment_image($item_image_id, 'full', false, ['class' => 'w-full h-full object-cover']) ?>
                        </div>
                        <?php endif; ?>

                        <h3 class="font-flatline text-[32px] text-navy font-semibold leading-[110%]"><?php echo esc_html(get_sub_field('item_title')); ?></h3>
                        <p class="font-garet text-lg text-dark-text mt-4 leading-[150%]">
                            <?php echo esc_html(get_sub_field('item_description')); ?>
                        </p>

                        <div class="mt-4 flex items-center gap-6">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-gold flex-shrink-0">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" fill="currentColor" />
                                    <circle cx="12" cy="10" r="3" fill="#0f203d" />
                                </svg>
                                <span class="font-garet text-lg text-navy font-bold"><?php echo esc_html(get_sub_field('item_location')); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-gold flex-shrink-0">
                                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2" fill="currentColor" />
                                    <line x1="16" x2="16" y1="2" y2="6" stroke="#0f203d" stroke-width="1.5" />
                                    <line x1="8" x2="8" y1="2" y2="6" stroke="#0f203d" stroke-width="1.5" />
                                    <line x1="3" x2="21" y1="10" y2="10" stroke="#0f203d" stroke-width="1.5" />
                                </svg>
                                <span class="font-garet text-lg text-navy font-bold"><?php echo esc_html(get_sub_field('item_date')); ?></span>
                            </div>
                        </div>

                        <?php $note = get_sub_field('item_note'); ?>
                        <?php if ($note): ?>
                        <p class="font-garet text-base text-dark-text mt-4 leading-[150%]"><?php echo wp_kses_post($note); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
