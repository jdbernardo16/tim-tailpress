<?php

/**
 * Tell Your Story Page - Speaking Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_tys_speaking_heading') ?: 'This Is <em>Not</em> Just Speaking Training; It\'s Leading from the Stage';
$text_1 = get_field('section_tys_speaking_text_1') ?: 'This is the work of uncovering the moments that shaped your voice, your leadership, and the way people experience you.';
$text_2 = get_field('section_tys_speaking_text_2') ?: 'Inside the retreat, leaders reconnect with the truth behind their message so their words stop sounding practiced and start feeling real.';
?>

<section class="py-24 lg:py-28 px-5 bg-canvas">
    <div class="max-w-[1230px] mx-auto flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
        <!-- Left: Text -->
        <div class="w-full lg:w-[40%] flex-shrink-0">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-dark-text leading-[1.1] mb-8">
                <?= $heading ?>
            </h2>
            <p class="font-garet text-lg font-light text-dark-text leading-[1.6]">
                <?= esc_html($text_1) ?>
            </p>
            <p class="font-garet text-lg font-light text-dark-text leading-[1.6] mt-4">
                <?= esc_html($text_2) ?>
            </p>
        </div>

        <!-- Right: Photo -->
        <div class="flex-1 relative w-full">
            <div class="relative w-full bg-canvas rounded-[4px]" style="aspect-ratio: 673 / 454;">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-your-story-speaking-bg.webp"
                     alt="" class="absolute inset-0 w-full h-full object-cover object-center rounded-[4px]">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-your-story-speaking-fg.webp"
                     alt="Joanna Horton McPherson"
                     class="absolute bottom-0 left-[40%] -translate-x-1/2 h-[113%] w-auto max-w-none"
                     style="height: 113%;">
            </div>
        </div>
    </div>
</section>
