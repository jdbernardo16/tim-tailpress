<?php

/**
 * Master My Message Page - "This is Where Your Message Becomes Distinct" Section template part.
 *
 * @package TailPress
 */

$receives = array(
    'private advisory and refinement',
    'keynote development',
    'speaker cohort integration',
    'professional speaking assets',
    'social positioning content',
    'message and visibility strategy',
);
?>
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <!-- Image -->
            <div class="w-full lg:w-1/2 order-2 lg:order-1">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/master2.webp" alt="Joanna connecting with the audience" class="w-full h-[560px] object-cover rounded-xl">
            </div>

            <!-- Text Content -->
            <div class="w-full lg:w-1/2 order-1 lg:order-2">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                    This is Where Your <em class="font-normal">Message</em> Becomes <em class="text-gold italic">Distinct.</em>
                </h2>

                <p class="mt-6 font-garet text-lg text-dark-text leading-[1.5] max-w-[460px]">
                    Inside the experience, Joanna works directly with leaders to refine how their ideas are communicated, positioned, and emotionally received.
                </p>

                <p class="mt-8 font-flatline font-medium text-2xl text-navy">You receive:</p>

                <ul class="mt-4 space-y-1 max-w-[460px]">
                    <?php foreach ($receives as $item) : ?>
                        <li class="flex items-start gap-3 font-garet text-lg text-dark-text leading-[1.5]">
                            <svg class="w-4 h-4 flex-shrink-0 mt-2 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                            </svg>
                            <?php echo esc_html($item); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>
