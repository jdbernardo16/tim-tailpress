<?php

/**
 * Success Stories Page - Written Testimonials Marquee Section template part.
 *
 * @package TailPress
 */

$written_testimonials_fallback = array(
    array(
        'quote' => 'Joanna is skilled, patient and passionate, driving people to dig deep inside to achieve their best.',
        'name'  => 'Jennifer P.',
    ),
    array(
        'quote' => 'She\'s clear and focused about doing \'the work,\' bringing sheer determination and vision to make something new manifest in front of her eyes.',
        'name'  => 'Dr. Nadia R.',
    ),
    array(
        'quote' => 'I think you captured a top-notch clarity, like a next-level clarity. But you captured how to take them to the next level. You captured in-depth details on how to propel their success.',
        'name'  => 'WILDx',
    ),
    array(
        'quote' => 'Joanna has been instrumental to my project and I\'m lucky to have her. She guided me throughout the start and progress, by asking why, what, ..questions, and suggesting solutions. I definitely recommend her.',
        'name'  => 'Laurien Sibomana',
    ),
    array(
        'quote' => 'What sets Joanna apart is that she doesn\'t just help you "sound better" or memorize lines, she goes straight to the core of what\'s been holding you back. Her technique is honest, practical, and incredibly effective.',
        'name'  => 'Monica May-Dunn',
    ),
    array(
        'quote' => 'Joanna brought a level of safety and clarity to our team that was beyond valuable. We knew the training would be good, but got far more from it than we expected. I tell everyone I know to work with her.',
        'name'  => 'K. Johnson',
    ),
    array(
        'quote' => 'Working with Joanna McPherson has been nothing short of life changing. Her skill, patience, and intuition make her truly exceptional, and I can\'t recommend her enough.',
        'name'  => 'A. Robinson',
    ),
);
$heading = get_field('section_written_heading') ?: 'What Changed Wasn\'t<br>Just the <em class="text-gold italic">Message</em>.';
?>

<section class="relative py-24 lg:py-32 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Heading -->
        <h2 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[56px] text-dark leading-[1.1] text-center mb-12">
            <?= $heading ?>
        </h2>
    </div>

    <!-- Marquee Container -->
    <div class="marquee overflow-hidden">
        <div class="testimonials-marquee__track flex gap-2">
            <?php if (have_rows('section_written_items')): ?>
                <?php $acf_testimonials = array(); ?>
                <?php while (have_rows('section_written_items')): the_row(); ?>
                    <?php
                    $acf_testimonials[] = array(
                        'quote' => get_sub_field('item_quote'),
                        'name'  => get_sub_field('item_author'),
                    );
                    ?>
                <?php endwhile; ?>
                <?php $marquee_items = array_merge($acf_testimonials, $acf_testimonials); ?>
                <?php foreach ($marquee_items as $testimonial) : ?>
                    <div class="w-[361px] flex-shrink-0 rounded-[10px] bg-navy p-10 flex flex-col">
                        <img
                            src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/quote.svg"
                            alt=""
                            class="w-[92px] h-[69px] opacity-30 mb-4"
                            aria-hidden="true"
                        >
                        <p class="font-garet text-base text-white leading-[150%] flex-grow">
                            "<?php echo esc_html($testimonial['quote']); ?>"
                        </p>
                        <div class="w-full h-px bg-white/40 my-6"></div>
                        <p class="font-flatline font-bold text-base text-gold tracking-[20%]">
                            <?php echo esc_html($testimonial['name']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <?php $marquee_testimonials = array_merge($written_testimonials_fallback, $written_testimonials_fallback); ?>
                <?php foreach ($marquee_testimonials as $testimonial) : ?>
                    <div class="w-[361px] flex-shrink-0 rounded-[10px] bg-navy p-10 flex flex-col">
                        <img
                            src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/quote.svg"
                            alt=""
                            class="w-[92px] h-[69px] opacity-30 mb-4"
                            aria-hidden="true"
                        >
                        <p class="font-garet text-base text-white leading-[150%] flex-grow">
                            "<?php echo esc_html($testimonial['quote']); ?>"
                        </p>
                        <div class="w-full h-px bg-white/40 my-6"></div>
                        <p class="font-flatline font-bold text-base text-gold tracking-[20%]">
                            <?php echo esc_html($testimonial['name']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
