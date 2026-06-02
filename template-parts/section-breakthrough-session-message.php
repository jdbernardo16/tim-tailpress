<?php

/**
 * Breakthrough Session Page - "You Already Know" Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_message_heading') ?: 'You Already Know<br>Something <em class="text-gold italic">Feels Off.</em>';
$text = get_field('section_message_text');
?>
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <!-- Text Content -->
            <div class="w-full lg:w-1/2">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                    <?= $heading ?>
                </h2>

                <?php if ($text): ?>
                    <?= $text ?>
                <?php else: ?>
                <ul class="mt-8 space-y-1">
                    <li class="flex items-start gap-3 font-garet text-lg text-dark-text leading-[1.5]">
                        <svg class="w-4 h-4 flex-shrink-0 mt-2 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                        </svg>
                        You&rsquo;ve tried to explain it more clearly.
                    </li>
                    <li class="flex items-start gap-3 font-garet text-lg text-dark-text leading-[1.5]">
                        <svg class="w-4 h-4 flex-shrink-0 mt-2 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                        </svg>
                        You&rsquo;ve tried refining the strategy.
                    </li>
                    <li class="flex items-start gap-3 font-garet text-lg text-dark-text leading-[1.5]">
                        <svg class="w-4 h-4 flex-shrink-0 mt-2 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                        </svg>
                        You&rsquo;ve tried finding better words.
                    </li>
                </ul>

                <p class="mt-8 font-garet text-lg text-dark-text leading-[1.5] max-w-[480px]">
                    But underneath it, you still feel disconnected from what you actually want to say.<br><br>This session is designed to help you stop performing clarity and reconnect with what is actually true.
                </p>
                <?php endif; ?>
            </div>

            <!-- Image -->
            <div class="w-full lg:w-1/2">
                <?php $image_id = get_field('section_message_image'); ?>
                <?php if ($image_id): ?>
                    <?= wp_get_attachment_image($image_id, 'full', false, ['class' => 'w-full h-[550px] object-cover rounded-xl', 'alt' => 'Joanna Horton McPherson']) ?>
                <?php else: ?>
                    <img src="<?= esc_url(get_template_directory_uri()) ?>/assets/images/breakthrough-1.webp" alt="Joanna Horton McPherson" class="w-full h-[550px] object-cover rounded-xl">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
