<?php

/**
 * Be Remembered Page - "A Legacy That Outlasts You" Section template part.
 *
 * @package TailPress
 */

$receives = array(
    'private legacy advisory',
    'impact thesis development',
    'succession and continuity planning',
    'voice and visibility for long-term influence',
    'wealth and contribution alignment',
    'long-term framework design',
);
?>
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <!-- Image -->
            <div class="w-full lg:w-1/2 order-2 lg:order-1">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/be-remembered-2.webp" alt="Joanna shaping long-term legacy and impact" class="w-full h-[560px] object-cover rounded-xl">
            </div>

            <!-- Text Content -->
            <div class="w-full lg:w-1/2 order-1 lg:order-2">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                    A Legacy That Outlives <em class="text-gold italic">You.</em>
                </h2>

                <p class="mt-6 font-garet text-lg text-dark-text leading-[1.5] max-w-[460px]">
                    Joanna works privately with founders and executives to architect legacy, succession, voice, and wealth, so what you build continues to lead long after you step back.
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
