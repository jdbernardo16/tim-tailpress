<?php

/**
 * Master My Message Page - "This is Where Your Message Becomes Distinct" Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_distinct_heading') ?: 'This is Where Your <em class="font-normal">Message</em> Becomes <em class="text-gold italic">Distinct.</em>';
$text = get_field('section_distinct_text');
?>
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <!-- Image -->
            <div class="w-full lg:w-1/2 order-2 lg:order-1">
                <?php $image_id = get_field('section_distinct_image'); ?>
                <?php if ($image_id): ?>
                    <?= wp_get_attachment_image($image_id, 'full', false, ['class' => 'w-full h-[560px] object-cover rounded-xl', 'alt' => 'Joanna connecting with the audience']) ?>
                <?php else: ?>
                    <img src="<?= esc_url(get_template_directory_uri()) ?>/assets/images/master2.webp" alt="Joanna connecting with the audience" class="w-full h-[560px] object-cover rounded-xl">
                <?php endif; ?>
            </div>

            <!-- Text Content -->
            <div class="w-full lg:w-1/2 order-1 lg:order-2">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                    <?= $heading ?>
                </h2>

                <?php if ($text): ?>
                    <?= $text ?>
                <?php else: ?>
                <p class="mt-6 font-garet text-lg text-dark-text leading-[1.5] max-w-[460px]">
                    Inside the experience, Joanna works directly with leaders to refine how their ideas are communicated, positioned, and emotionally received.
                </p>
                <?php endif; ?>

                <?php if (have_rows('section_distinct_items')): ?>
                <p class="mt-8 font-flatline font-medium text-2xl text-navy">You receive:</p>
                <ul class="mt-4 space-y-1 max-w-[460px]">
                    <?php while (have_rows('section_distinct_items')): the_row(); ?>
                        <li class="flex items-start gap-3 font-garet text-lg text-dark-text leading-[1.5]">
                            <svg class="w-4 h-4 flex-shrink-0 mt-2 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                            </svg>
                            <?= esc_html(get_sub_field('item_heading')) ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
