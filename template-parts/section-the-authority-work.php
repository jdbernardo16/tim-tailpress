<?php

/**
 * The Authority Page - Work 1:1 Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_work_heading') ?: "Work 1:1 with Joanna.";

$work_options = array(
    array(
        'title'       => 'Breakthrough Session',
        'description' => 'One focused session designed to create immediate clarity and direction.',
        'price'       => '$2,000',
        'cta'         => 'BOOK A BREAKTHROUGH SESSION',
        'url'         => home_url('/inquiry/'),
    ),
    array(
        'title'       => '4-Session Training Package',
        'description' => 'Private message refinement and leadership clarity across four sessions.',
        'price'       => '$8,000',
        'cta'         => 'BOOK PRIVATE TRAINING',
        'url'         => home_url('/inquiry/'),
    ),
);
?>
<section class="bg-canvas pb-24 lg:pb-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center text-center">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[40px] text-navy leading-[1.1]">
                <?= esc_html($heading) ?>
            </h2>
        </div>

        <?php if (have_rows('section_work_items')): ?>
            <div class="mt-12 max-w-3xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-2">
                <?php while (have_rows('section_work_items')): the_row(); ?>
                    <?php
                    $item_heading = get_sub_field('item_heading');
                    $item_text = get_sub_field('item_text');
                    ?>
                    <div class="bg-warm-beige rounded-[10px] border border-gold-section p-6 sm:p-8 flex flex-col">
                        <h3 class="font-flatline font-medium text-3xl text-navy leading-[1.1]">
                            <?= esc_html($item_heading) ?>
                        </h3>

                        <p class="mt-6 font-garet text-base text-dark-text leading-[150%] flex-1">
                            <?= esc_html($item_text) ?>
                        </p>

                        <p class="mt-8 font-flatline font-medium text-4xl text-gold leading-[1.1]">
                            $2,000
                        </p>

                        <a href="<?php echo esc_url(home_url('/inquiry/')); ?>" class="mt-8 btn-primary">
                            BOOK PRIVATE TRAINING
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="mt-12 max-w-3xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-2">
                <?php foreach ($work_options as $option) : ?>
                    <div class="bg-warm-beige rounded-[10px] border border-gold-section p-6 sm:p-8 flex flex-col">
                        <h3 class="font-flatline font-medium text-3xl text-navy leading-[1.1]">
                            <?php echo esc_html($option['title']); ?>
                        </h3>

                        <p class="mt-6 font-garet text-base text-dark-text leading-[150%] flex-1">
                            <?php echo esc_html($option['description']); ?>
                        </p>

                        <p class="mt-8 font-flatline font-medium text-4xl text-gold leading-[1.1]">
                            <?php echo esc_html($option['price']); ?>
                        </p>

                        <a href="<?php echo esc_url($option['url']); ?>" class="mt-8 btn-primary">
                            <?php echo esc_html($option['cta']); ?>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
