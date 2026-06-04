<?php

/**
 * The Legacy Page - Message Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_message_heading') ?: "Make an <em>Impact</em> With Your Voice";
$text = get_field('section_message_text') ?: "That's where authority begins.";

$needs = array(
    'a message that lands clearly',
    'emotional connection, not overexplaining',
    'language people can remember and repeat',
);
?>
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
            <!-- Text Content -->
            <div class="w-full max-w-xl mx-auto">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                    <?= $heading ?>
                </h2>

                <p class="mt-10 font-flatline font-medium text-2xl text-navy leading-[1.1]">
                    You need:
                </p>

                <ul class="mt-4 space-y-2">
                    <?php foreach ($needs as $need) : ?>
                        <li class="flex items-center gap-3 font-garet text-lg text-dark-text">
                            <svg class="w-5 h-5 flex-shrink-0 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                                <path d="M18 14L18.75 16.25L21 17L18.75 17.75L18 20L17.25 17.75L15 17L17.25 16.25L18 14Z" opacity="0.6"/>
                                <path d="M6 14L6.75 16.25L9 17L6.75 17.75L6 20L5.25 17.75L3 17L5.25 16.25L6 14Z" opacity="0.6"/>
                            </svg>
                            <span><?php echo esc_html($need); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <p class="mt-8 font-garet text-lg text-dark-text leading-[150%]">
                    <?= esc_html($text) ?>
                </p>
            </div>
        </div>
    </div>
</section>
