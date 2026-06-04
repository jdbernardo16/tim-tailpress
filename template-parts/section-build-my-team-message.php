<?php

/**
 * Build My Team Page - "Your Business Has Grown" Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_message_heading') ?: 'Your Business<br>Has Grown. Your <em class="text-gold italic">Leadership</em> Hasn&rsquo;t.';
$text = get_field('section_message_text');
$message_image_id = get_field('section_message_image');
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
                <?php endif; ?>
            </div>

            <!-- Image -->
            <div class="w-full lg:w-1/2">
                <?php if ($message_image_id): ?>
                    <?= wp_get_attachment_image($message_image_id, 'full', false, ['class' => 'w-full h-[450px] object-cover rounded-xl', 'alt' => 'Joanna Horton McPherson']) ?>
                <?php else: ?>
                    <img src="<?= esc_url(get_template_directory_uri()) ?>/assets/images/build-my-team1.webp" alt="Joanna Horton McPherson" class="w-full h-[450px] object-cover rounded-xl">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
