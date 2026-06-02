<?php

/**
 * The Speaker Page - Story Section template part.
 *
 * @package TailPress
 */

$includes = array(
    'Your defining moment (written + spoken)',
    'Your deeper why',
    'Your first leadership message',
    'Your unique differentiator',
);
?>
<section class="bg-canvas px-4 sm:px-10 py-8 lg:py-12">
    <div class="relative overflow-hidden rounded-[20px] bg-warm-beige">
        <!-- Background texture -->
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-10" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/bg-texture.webp" alt="" aria-hidden="true">
        </div>

        <!-- Decorative gold blur ellipse -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 right-0 w-[1535px] h-[1535px] bg-gold/40 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/2"></div>
        </div>

        <div class="relative grid grid-cols-1 lg:grid-cols-2 items-center gap-8 lg:gap-12">
            <!-- Text Content -->
            <div class="px-6 sm:px-10 lg:pl-16 lg:pr-8 py-16 lg:py-24 max-w-xl">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                    Tell Your Story —<br>My <em class="text-gold italic">Why</em>
                </h2>

                <p class="mt-8 font-garet text-lg text-dark-text leading-[150%]">
                    The first course + retreat experience.
                </p>

                <ul class="mt-6 space-y-2">
                    <?php foreach ($includes as $item) : ?>
                        <li class="flex items-center gap-3 font-garet text-lg text-dark-text">
                            <svg class="w-5 h-5 flex-shrink-0 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                                <path d="M18 14L18.75 16.25L21 17L18.75 17.75L18 20L17.25 17.75L15 17L17.25 16.25L18 14Z" opacity="0.6"/>
                                <path d="M6 14L6.75 16.25L9 17L6.75 17.75L6 20L5.25 17.75L3 17L5.25 16.25L6 14Z" opacity="0.6"/>
                            </svg>
                            <span><?php echo esc_html($item); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <p class="mt-10 font-flatline font-medium text-4xl text-gold leading-[1.1]">
                    $3,200
                </p>

                <div class="mt-8">
                    <a href="<?php echo esc_url(home_url('/the-speaker/')); ?>" class="btn-primary">
                        FIND MY MESSAGE
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Image -->
            <div class="relative h-full w-full">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/the-speaker2.webp" alt="Joanna Horton McPherson" class="w-full h-full object-cover lg:rounded-tl-[20px] lg:rounded-bl-[20px] rounded-b-[20px] lg:rounded-br-none">
            </div>
        </div>
    </div>
</section>
