<?php

/**
 * The Vault Page - Hero Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_hero_heading') ?: "The <em>Vault</em>";
$subtitle = get_field('section_hero_subtitle') ?: "A free live session with Joanna &mdash; <strong>June 5, 9:00&ndash;10:00 AM PST</strong>\n\nThis is your invitation to sit with Joanna in real time. No slides. No sales pitch. Just a direct conversation about the message you've been carrying and haven't fully said yet. Bring a question. Leave with clarity.";
$bg_image_id = get_field('section_hero_bg_image');
$subtitle_paragraphs = explode("\n\n", $subtitle);
?>
<section class="relative bg-navy overflow-hidden">
    <!-- Background texture -->
    <div class="absolute inset-0">
        <?php if ($bg_image_id): ?>
            <?= wp_get_attachment_image($bg_image_id, 'full', false, ['class' => 'w-full h-full object-cover', 'aria-hidden' => 'true']) ?>
        <?php else: ?>
            <img class="w-full h-full object-cover" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vault-hero-bg.webp" alt="" aria-hidden="true">
        <?php endif; ?>
    </div>

    <!-- Watermark mandala icon -->
    <div class="absolute inset-x-0 top-0 flex justify-center pointer-events-none select-none">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vault-watermark.webp" alt="" class="w-[770px] h-auto max-w-none opacity-90" aria-hidden="true">
    </div>

    <!-- Decorative blurred ellipses -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-1/4 w-80 h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 lg:pt-24 pb-0 flex flex-col items-center text-center">
        <!-- Heading -->
        <h1 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[64px] text-white leading-[1.1]">
            <?= $heading ?>
        </h1>

        <!-- Description -->
        <div class="mt-6 font-garet text-lg text-white leading-[1.6] max-w-[665px]">
            <?php foreach ($subtitle_paragraphs as $index => $paragraph): ?>
                <p class="<?= $index > 0 ? 'mt-4' : '' ?>"><?= $paragraph ?></p>
            <?php endforeach; ?>
        </div>

        <!-- CTA -->
        <div class="mt-8">
            <a href="#register" class="btn-primary">
                RESERVE MY SEAT - FREE
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>

        <!-- Hero Image -->
        <div class="mt-12 flex justify-center">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vault-hero-joanna.webp" alt="Joanna Horton McPherson" class="w-full max-w-md lg:max-w-lg h-auto object-contain">
        </div>
    </div>
</section>
