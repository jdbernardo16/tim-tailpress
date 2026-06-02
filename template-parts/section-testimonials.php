<?php
/**
 * Testimonials Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_testimonials_heading') ?: 'People Remember What Felt <em class="text-gold italic">True.</em>';
$subtitle = get_field('section_testimonials_subtitle') ?: 'Leaders from around the world come to Joanna to reconnect with their voice, refine their message, and lead with deeper influence.';

$fallback_testimonials = array(
    array(
        'quote'  => 'Working with Joanna has been nothing short of life-changing.',
        'author' => 'A. ROBINSON',
        'title'  => 'Executive Leader',
    ),
    array(
        'quote'  => 'This was never about performing. It was about becoming.',
        'author' => 'Speak & Rise Participant',
        'title'  => 'Leader',
    ),
    array(
        'quote'  => 'When clarity meets momentum, everything changes. Joanna gave me both.',
        'author' => 'EXECUTIVE CLIENT',
        'title'  => 'Leader',
    ),
);
?>

<section class="relative bg-canvas py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header: flex row, title left, subtitle right -->
        <div class="flex flex-col md:flex-row justify-between items-start gap-10 mb-10">
            <h2 class="font-flatline font-medium text-5xl md:text-[56px] text-navy leading-[1.1] text-left">
                <?= $heading ?>
            </h2>
            <p class="font-garet font-light text-lg text-dark-text leading-[1.5] text-left md:max-w-[470px] md:pt-4">
                <?= esc_html($subtitle) ?>
            </p>
        </div>

        <!-- Testimonial Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
            <?php if (have_rows('section_testimonials_items')): ?>
                <?php while (have_rows('section_testimonials_items')): the_row(); ?>
                    <div class="relative bg-navy rounded-[10px] overflow-hidden min-h-[281px] flex flex-col">
                        <!-- Decorative large quote mark with gradient -->
                        <div class="absolute top-0 left-10 w-[92px] h-[69px] opacity-30 pointer-events-none"
                            style="background: linear-gradient(180deg, rgba(255,255,255,1) 2%, rgba(255,255,255,0) 83%);
                            -webkit-mask-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22white%22><path d=%22M10 11H6C6 8.79086 7.79086 7 10 7V5C6.68629 5 4 7.68629 4 11V19H10V11ZM18 11H14C14 8.79086 15.7909 7 18 7V5C14.6863 5 12 7.68629 12 11V19H18V11Z%22/></svg>');
                            mask-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22white%22><path d=%22M10 11H6C6 8.79086 7.79086 7 10 7V5C6.68629 5 4 7.68629 4 11V19H10V11ZM18 11H14C14 8.79086 15.7909 7 18 7V5C14.6863 5 12 7.68629 12 11V19H18V11Z%22/></svg>');
                            -webkit-mask-size: contain; mask-size: contain;
                            -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat;">
                        </div>

                        <!-- Quote Text -->
                        <div class="px-10 pt-[85px] flex-1">
                            <p class="font-garet font-light text-base text-white leading-[1.5]">
                                <?= esc_html(get_sub_field('item_quote')) ?>
                            </p>
                        </div>

                        <!-- Author Block -->
                        <div class="px-10 pb-10 pt-6 mt-auto">
                            <!-- Divider line -->
                            <div class="w-full h-px bg-white/40 mb-6"></div>
                            <p class="font-flatline font-bold text-base text-gold-section uppercase leading-[1.1]">
                                <?= esc_html(get_sub_field('item_author')) ?>
                            </p>
                            <p class="font-garet font-light text-xs text-white leading-[1.5] mt-1">
                                <?= esc_html(get_sub_field('item_title')) ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <?php foreach ($fallback_testimonials as $testimonial) : ?>
                    <div class="relative bg-navy rounded-[10px] overflow-hidden min-h-[281px] flex flex-col">
                        <div class="absolute top-0 left-10 w-[92px] h-[69px] opacity-30 pointer-events-none"
                            style="background: linear-gradient(180deg, rgba(255,255,255,1) 2%, rgba(255,255,255,0) 83%);
                            -webkit-mask-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22white%22><path d=%22M10 11H6C6 8.79086 7.79086 7 10 7V5C6.68629 5 4 7.68629 4 11V19H10V11ZM18 11H14C14 8.79086 15.7909 7 18 7V5C14.6863 5 12 7.68629 12 11V19H18V11Z%22/></svg>');
                            mask-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22white%22><path d=%22M10 11H6C6 8.79086 7.79086 7 10 7V5C6.68629 5 4 7.68629 4 11V19H10V11ZM18 11H14C14 8.79086 15.7909 7 18 7V5C14.6863 5 12 7.68629 12 11V19H18V11Z%22/></svg>');
                            -webkit-mask-size: contain; mask-size: contain;
                            -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat;">
                        </div>

                        <div class="px-10 pt-[85px] flex-1">
                            <p class="font-garet font-light text-base text-white leading-[1.5]">
                                <?php echo esc_html($testimonial['quote']); ?>
                            </p>
                        </div>

                        <div class="px-10 pb-10 pt-6 mt-auto">
                            <div class="w-full h-px bg-white/40 mb-6"></div>
                            <p class="font-flatline font-bold text-base text-gold-section uppercase leading-[1.1]">
                                <?php echo esc_html($testimonial['author']); ?>
                            </p>
                            <p class="font-garet font-light text-xs text-white leading-[1.5] mt-1">
                                <?php echo esc_html($testimonial['title']); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
