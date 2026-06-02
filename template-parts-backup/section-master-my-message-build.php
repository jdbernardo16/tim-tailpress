<?php

/**
 * Master My Message Page - "What You Build" Section template part.
 *
 * @package TailPress
 */

$bullets = array(
    'A refined, repeatable signature message',
    'A message people remember and repeat',
    'Your thought leader perspective',
    'Clear audience positioning',
    'A keynote-level talk',
    'A defined point of view',
);
?>
<section class="bg-canvas py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-navy rounded-3xl overflow-hidden">
            <!-- Background texture -->
            <div class="absolute inset-0 opacity-10">
                <img class="w-full h-full object-cover" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/general-bg.webp" alt="" aria-hidden="true">
            </div>

            <!-- Decorative blurred ellipses -->
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-deep-blue/60 rounded-full blur-3xl"></div>
                <div class="absolute -top-32 -left-40 w-[500px] h-[500px] bg-gold/30 rounded-full blur-3xl"></div>
            </div>

            <!-- Master My Message wordmark behind heading -->
            <div class="absolute top-6 left-0 right-0 flex justify-center pointer-events-none">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/master-text.webp" alt="" aria-hidden="true" class="h-20 md:h-24 opacity-20 object-contain">
            </div>

            <div class="relative px-6 py-20 md:px-12 md:py-24 lg:px-20 lg:py-28 flex flex-col items-center text-center">
                <!-- Heading -->
                <h2 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[56px] text-white leading-[1.1]">
                    What You <em class="text-gold italic">Build</em>
                </h2>

                <!-- Bullets Box -->
                <div class="mt-12 w-full max-w-[750px] bg-warm-beige/10 rounded-[10px] px-6 py-6 md:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-2">
                        <?php foreach ($bullets as $item) : ?>
                            <div class="flex items-center gap-3 py-1">
                                <svg class="w-4 h-4 flex-shrink-0 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                                </svg>
                                <span class="font-garet text-base text-white text-left"><?php echo esc_html($item); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Bottom Text -->
                <p class="mt-10 font-garet text-lg text-white leading-[1.5] max-w-[600px]">
                    This is where your experience becomes: recognizable, repeatable, emotionally resonant, distinct
                </p>
            </div>
        </div>
    </div>
</section>
