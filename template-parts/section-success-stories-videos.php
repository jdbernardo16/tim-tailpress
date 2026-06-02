<?php

/**
 * Success Stories Page - Video Testimonials Section template part.
 *
 * @package TailPress
 */

$video_testimonials = array(
    array(
        'image' => 'story1.webp',
        'quote' => 'I now feel inspired and more clear in my why and my purpose.',
        'name'  => 'Victoria Richardson',
    ),
    array(
        'image' => 'story2.webp',
        'quote' => 'The biggest change in me is confidence.',
        'name'  => 'LeQuisha Underwood',
    ),
    array(
        'image' => 'story3.webp',
        'quote' => 'I finally found the talk I was meant to give.',
        'name'  => 'Kendi Brown',
    ),
    array(
        'image' => 'story4.webp',
        'quote' => 'She flips the script on how you do a speech.',
        'name'  => 'BEN ARMSTRONG',
    ),
    array(
        'image' => 'story5.webp',
        'quote' => 'Giving people the confidence they didn\'t know they had.',
        'name'  => 'DAWN ARMSTRONG',
    ),
    array(
        'image' => 'story6.webp',
        'quote' => 'Working with Joanna. What happens is you get real laser focused.',
        'name'  => 'Jessica Avignone',
    ),
);
?>
<section class="relative pt-24 lg:pt-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header area -->
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-12">
            <!-- Left: Heading -->
            <h2 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[56px] text-dark leading-[1.1] max-w-[600px]">
                Hear it in Their <br>Own <em class="text-gold italic">Words</em>.
            </h2>

            <!-- Right: Description -->
            <p class="font-garet text-lg text-dark leading-[150%] max-w-[500px]">
                Moments of clarity, confidence, transformation, and emotional breakthrough from people who experienced the work firsthand.
            </p>
        </div>

        <!-- Video testimonials grid: 2 rows of 3 cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
            <?php foreach ($video_testimonials as $testimonial) : ?>
                <div class="flex flex-col">
                    <!-- Image container -->
                    <div class="relative h-[400px] rounded-[10px] overflow-hidden bg-[#363636]">
                        <img
                            src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/' . $testimonial['image']); ?>"
                            alt="<?php echo esc_attr($testimonial['name']); ?>"
                            class="w-full h-full object-cover"
                        >
                        <!-- Play button -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <button
                                class="w-[65px] h-[65px] flex items-center justify-center  rounded-[5px]"
                                aria-label="Play video for <?php echo esc_attr($testimonial['name']); ?>"
                            >
                                <img
                                    src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/play.svg"
                                    alt=""
                                    class="w-16 h-16"
                                    aria-hidden="true"
                                >
                            </button>
                        </div>
                    </div>

                    <!-- Quote below image -->
                    <p class="mt-4 font-garet text-lg text-[#1e1e1e] leading-[150%]">
                        "<?php echo esc_html($testimonial['quote']); ?>"
                    </p>

                    <!-- Name -->
                    <p class="mt-2 font-flatline font-bold text-lg text-navy tracking-[20%]">
                        <?php echo esc_html($testimonial['name']); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
