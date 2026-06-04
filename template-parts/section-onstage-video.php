<?php

/**
 * On Stage Page - Video Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_video_heading');
$text = get_field('section_video_text');
$video_embed = get_field('section_video_video_url');
?>

<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-tight">
            <?= $heading ?>
        </h2>
        <p class="mt-6 font-garet text-lg text-dark-text leading-relaxed max-w-2xl mx-auto">
            <?= esc_html($text) ?>
        </p>

        <div class="mt-12 max-w-3xl mx-auto">
            <?php if ($video_embed): ?>
                <div class="relative aspect-video rounded-lg overflow-hidden">
                    <?= $video_embed ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
