<?php

/**
 * Speaker Cohort Page - "This is Not Just Speaking Training" Section template part.
 *
 * @package TailPress
 */

$receives = array(
    'live coaching with Joanna',
    'peer refinement and feedback',
    'retreat speaking opportunity',
    'professional video and photos',
    'content for brand positioning',
);
?>
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <!-- Image -->
            <div class="w-full lg:w-1/2 order-2 lg:order-1">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/move-the-room2.webp" alt="Joanna connecting with cohort members" class="w-full h-[500px] object-cover rounded-xl">
            </div>

            <!-- Text Content -->
            <div class="w-full lg:w-1/2 order-1 lg:order-2">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                    This is <em class="font-normal text-gold italic">Not</em> Just<br>Speaking Training.
                </h2>

                <div class="mt-6 font-garet text-lg text-dark-text leading-[1.5] space-y-3 max-w-[460px]">
                    <p>This is live refinement in front of real people.</p>
                    <p>Inside the cohort, leaders step onto the stage, receive real-time feedback, and refine how their message actually lands emotionally.</p>
                </div>

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
