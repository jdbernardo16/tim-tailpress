<?php

/**
 * Hero Section template part.
 *
 * @package TailPress
 */
?>

<section class="relative bg-navy overflow-hidden">
    <div class="absolute inset-0">
        <img class="w-full h-full object-cover" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/hero-bg.webp" alt="True Influence Method">
    </div>
    <div class="absolute top-0 right-0 blur-sm opacity-50">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/ray.webp" alt="ray">
    </div>
    <div class="absolute -bottom-1/2 right-0">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/icon-transparent.webp" alt="icon-transparent">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 lg:pt-32">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <div class="flex-1 text-center lg:text-left">
                <h1 class="font-flatline font-normal text-5xl md:text-6xl text-white leading-tight">
                    You're Not Missing a Message. <em class="text-gold">You're Missing Trust.</em>
                </h1>
                <p class="mt-6 font-garet text-lg text-white leading-normal max-w-xl mx-auto lg:mx-0">
                    Somewhere along the way, you learned how to explain yourself… but not how to truly be felt.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="<?php echo esc_url(home_url('/get-started/')); ?>" class="btn-primary">
                        Start Your Story
                    </a>
                    <a href="<?php echo esc_url(home_url('/on-stage/')); ?>" class="btn-secondary text-gold">
                        Watch Joanna Speak
                    </a>
                </div>
            </div>
            <div class="flex-1 flex justify-center lg:justify-end">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/hero-img.webp" alt="Joanna" class="w-full max-w-md lg:max-w-lg object-cover">
            </div>
        </div>
    </div>
</section>
