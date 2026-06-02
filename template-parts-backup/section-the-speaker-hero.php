<?php

/**
 * The Speaker Page - Hero Section template part.
 *
 * @package TailPress
 */
?>
<section class="relative overflow-hidden min-h-[555px] flex items-center">
    <!-- Background Image -->
    <div class="absolute inset-0 w-full h-full">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/general-bg.webp" alt="" class="w-full h-full object-cover object-top" aria-hidden="true">
    </div>

    <!-- Dark Navy Background -->
    <div class="absolute inset-0 bg-navy -z-10"></div>

    <!-- Decorative ellipses with blur effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-1/4 w-80 h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
    </div>

    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="flex flex-col items-center text-center">
            <!-- Heading -->
            <h1 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[64px] text-white leading-[1.1]">
                The <em class="text-gold italic">Speaker</em>
            </h1>

            <!-- Description -->
            <p class="mt-6 font-garet text-lg text-white leading-[27px] max-w-[600px]">
                This path is designed for leaders ready to uncover the message behind their lived experience and begin communicating it with greater clarity, confidence, and emotional truth.
            </p>

            <!-- Back link -->
            <p class="mt-6 font-garet text-base text-white">
                Not You? Go back and <a href="<?php echo esc_url(home_url('/get-started/')); ?>" class="font-flatline font-bold text-gold underline hover:opacity-80 transition-opacity">choose</a> again
            </p>
        </div>
    </div>
</section>
