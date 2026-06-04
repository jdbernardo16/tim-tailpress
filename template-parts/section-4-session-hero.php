<?php

/**
 * 4-Session Training Package Page - Hero Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_hero_heading') ?: 'Build the Message<br><em class="text-gold italic">From the Inside Out.</em>';
$subtitle = get_field('section_hero_subtitle') ?: 'The 4-Session Training Package is a private experience for leaders ready to uncover, refine, and clearly articulate the message behind their work. Together, you move beyond explaining and begin building a message that feels true, clear, and aligned.';
$bg_image_id = get_field('section_hero_bg_image');
$profile_image_id = get_field('section_hero_profile_image');
?>
<section class="relative bg-navy overflow-hidden">
    <!-- Background texture -->
    <div class="absolute inset-0">
        <?php if ($bg_image_id): ?>
            <?= wp_get_attachment_image($bg_image_id, 'full', false, ['class' => 'w-full h-full object-cover', 'aria-hidden' => 'true']) ?>
        <?php endif; ?>
    </div>

    <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 flex flex-col items-center text-center">
        <!-- Pill Label -->
        <span class="inline-flex items-center font-flatline rounded-full bg-white/15 backdrop-blur-sm px-6 py-2 text-xs font-bold uppercase tracking-[0.3em] text-warm-beige">
            4-Session Training Package
        </span>

        <!-- Heading -->
        <h1 class="mt-8 font-flatline font-semibold text-5xl md:text-6xl lg:text-[64px] text-white leading-[1.1]">
            <?= $heading ?>
        </h1>

        <!-- Description -->
        <div class="mt-6 font-garet text-lg text-white leading-[1.6] max-w-[600px] space-y-3">
            <?= $subtitle ?>
        </div>
    </div>
</section>
