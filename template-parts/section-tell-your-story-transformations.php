<?php

/**
 * Tell Your Story Page - Transformations Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_tys_transformations_heading') ?: 'Some Transformations Can\'t be Explained.<br>They Have to be <em class="text-gold italic">Experienced.</em>';
$subtitle = get_field('section_tys_transformations_subtitle') ?: 'When your story becomes clear, so does your leadership.';
$banner_text = get_field('section_tys_transformations_banner') ?: 'Because your message finally comes from something real.';
?>

<section class="relative bg-canvas overflow-hidden">
    <!-- Background Image with Fades -->
    <div class="absolute inset-0 w-full h-full">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-your-story-transformations-bg.webp"
             alt="" class="w-full h-full object-cover">
        <div class="absolute top-0 left-0 right-0 h-[200px] bg-gradient-to-b from-canvas to-transparent z-10 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 right-0 h-[200px] bg-gradient-to-t from-canvas to-transparent z-10 pointer-events-none"></div>
    </div>

    <div class="relative z-20 max-w-[1100px] mx-auto px-5 pt-20 lg:pt-28">
        <!-- Heading -->
        <div class="text-center max-w-[700px] mx-auto mb-6">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-dark-text leading-[1.1]">
                <?= $heading ?>
            </h2>
        </div>
        <p class="font-garet text-lg font-light text-dark-text leading-[1.5] text-center mb-10 max-w-[600px] mx-auto">
            <?= esc_html($subtitle) ?>
        </p>

        <!-- Portrait + Cards Container -->
        <div class="relative mx-auto w-fit max-w-full">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-your-story-portrait.webp"
                 alt="Joanna Horton McPherson" class="w-full h-auto max-w-[500px] lg:max-w-none block">

            <!-- Floating Cards (desktop absolute, mobile static) -->
            <div class="relative lg:absolute lg:inset-0 z-30 mt-6 lg:mt-0 space-y-4 lg:space-y-0">
                <div class="lg:absolute lg:top-[25%] lg:-right-[60%] bg-white/70 backdrop-blur-sm border border-white/60 rounded-lg px-5 py-4 shadow-lg font-garet text-base font-light text-navy leading-[1.4] w-full lg:w-auto max-w-[280px] mx-auto lg:mx-0">
                    You stop trying to sound convincing.
                </div>
                <div class="lg:absolute lg:top-[40%] lg:-left-[50%] bg-white/70 backdrop-blur-sm border border-white/60 rounded-lg px-5 py-4 shadow-lg font-garet text-base font-light text-navy leading-[1.4] w-full lg:w-auto max-w-[280px] mx-auto lg:mx-0">
                    You stop over-explaining.
                </div>
                <div class="lg:absolute lg:-right-[50%] lg:bottom-[30%] lg:ml-20 bg-white/70 backdrop-blur-sm border border-white/60 rounded-lg px-5 py-4 shadow-lg font-garet text-base font-light text-navy leading-[1.4] w-full lg:w-auto max-w-[280px] mx-auto lg:mx-0">
                    You stop searching for the right words.
                </div>
            </div>
        </div>

        <!-- Banner -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 mt-8 lg:mt-12 mx-auto w-full lg:w-fit bg-navy/85 px-6 sm:px-10 py-4 rounded text-center">
            <p class="font-garet text-xl sm:text-[22px] font-light text-white leading-[1.3]">
                <?= esc_html($banner_text) ?>
            </p>
        </div>
    </div>
</section>
