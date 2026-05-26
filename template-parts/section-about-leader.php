<?php

/**
 * About Page - Leader Section template part.
 *
 * @package TailPress
 */
?>

<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <!-- Image -->
            <div class="flex-1 flex justify-center lg:justify-start">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/about-frame2.png" alt="Joanna" class="w-full max-w-md lg:max-w-lg object-cover rounded-xl">
            </div>
            <!-- Text Content -->
            <div class="flex-1 max-w-xl">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-tight">
                    Being a Leader is Choosing What You <em class="text-gold italic">Become.</em>
                </h2>
                <div class="mt-8 font-garet text-lg text-dark-text leading-normal space-y-6">
                    <p>People do not follow information alone. They follow truth they can feel.</p>
                    <p>The True Influence Method™ was created to help leaders reconnect with the experiences that shaped the way they lead, speak, and move people.</p>
                </div>
            </div>
        </div>
    </div>
</section>