<?php

/**
 * You Know What You Mean Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_you_know_heading') ?: 'You Know What You <em class="text-gold">Mean</em>';
$bg_image_id = get_field('section_you_know_bg_image');
$profile_image_id = get_field('section_you_know_profile_image');
$text = get_field('section_you_know_text');
?>

<section class="bg-canvas py-16 lg:py-24 lg:pt-64">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:space-x-16 gap-8 lg:gap-0">
            <div class="relative w-full lg:flex-1 h-fit">
                <?php if ($bg_image_id): ?>
                    <?= wp_get_attachment_image($bg_image_id, 'full', false, ['class' => 'grayscale', 'alt' => 'Joanna']) ?>
                <?php endif; ?>
                <?php if ($profile_image_id): ?>
                    <?= wp_get_attachment_image($profile_image_id, 'full', false, ['class' => 'w-[72%] h-auto absolute bottom-0 right-9 md:right-[84px]', 'alt' => 'Joanna']) ?>
                <?php endif; ?>
            </div>
            <div class="max-w-[442px]">
                <h2 class="font-flatline font-medium text-5xl md:text-6xl text-navy leading-tight">
                    <?= $heading ?>
                </h2>
                <div class="mt-6 font-garet text-lg text-dark-text leading-normal space-y-4">
                    <?php if ($text): ?>
                        <?= wpautop($text) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</section>
