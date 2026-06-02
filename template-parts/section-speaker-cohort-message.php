<?php

/**
 * Speaker Cohort Page - "You Know Your Work" Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_message_heading') ?: 'You Know Your Work. But Your Message Still <em class="text-gold italic">Isn\'t Landing.</em>';
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
                <p class="mt-8 font-flatline font-medium text-2xl text-navy">You:</p>

                <ul class="mt-4 space-y-1">
                    <li class="flex items-start gap-3 font-garet text-lg text-dark-text leading-[1.5]">
                        <svg class="w-4 h-4 flex-shrink-0 mt-2 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                        </svg>
                        ramble instead of landing your point
                    </li>
                    <li class="flex items-start gap-3 font-garet text-lg text-dark-text leading-[1.5]">
                        <svg class="w-4 h-4 flex-shrink-0 mt-2 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                        </svg>
                        over-explain before saying anything clear
                    </li>
                    <li class="flex items-start gap-3 font-garet text-lg text-dark-text leading-[1.5]">
                        <svg class="w-4 h-4 flex-shrink-0 mt-2 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                        </svg>
                        walk away thinking: &ldquo;That&rsquo;s not what I meant to say.&rdquo;
                    </li>
                </ul>

                <p class="mt-8 font-garet text-lg text-dark-text leading-[1.5] max-w-[480px]">
                    You don&rsquo;t lack experience.<br><br>You haven&rsquo;t structured your message to move people yet.
                </p>
                <?php endif; ?>
            </div>

            <!-- Image -->
            <div class="w-full lg:w-1/2">
                <?php $image_id = get_field('section_message_image'); ?>
                <?php if ($image_id): ?>
                    <?= wp_get_attachment_image($image_id, 'full', false, ['class' => 'w-full h-[450px] object-cover rounded-xl', 'alt' => 'Joanna Horton McPherson']) ?>
                <?php else: ?>
                    <img src="<?= esc_url(get_template_directory_uri()) ?>/assets/images/move-the-room1.webp" alt="Joanna Horton McPherson" class="w-full h-[450px] object-cover rounded-xl">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
