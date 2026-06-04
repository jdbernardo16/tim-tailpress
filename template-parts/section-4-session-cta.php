<?php

/**
 * 4-Session Training Package Page - Pricing CTA Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_cta_heading') ?: 'Clarity Changes <em class="text-gold italic">How You Lead.</em>';
$btn_text = get_field('section_cta_btn_text') ?: 'BOOK PRIVATE TRAINING';
$btn_url = get_field('section_cta_btn_url') ?: 'https://go.trueinfluencemethod.com/4-session-training-package';
$bg_image_id = get_field('section_cta_bg_image');

$price_label = get_field('section_cta_price_label');
$price_original = get_field('section_cta_price_original');
$price = get_field('section_cta_price');
$price_description = get_field('section_cta_price_description');
?>
<section class="bg-canvas pb-24 lg:pb-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-warm-beige rounded-3xl overflow-hidden">
            <!-- Background texture -->
            <div class="absolute inset-0">
                <?php if ($bg_image_id): ?>
                    <?= wp_get_attachment_image($bg_image_id, 'full', false, ['class' => 'w-full h-full object-cover', 'aria-hidden' => 'true']) ?>
                <?php else: ?>
                    <img class="w-full h-full object-cover" src="<?= esc_url(get_template_directory_uri()) ?>/assets/images/cta-bg.webp" alt="" aria-hidden="true">
                <?php endif; ?>
            </div>

            <div class="relative px-6 py-20 md:px-12 md:py-24 lg:px-20 flex flex-col items-center text-center">
                <!-- Heading -->
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1] max-w-[620px]">
                    <?= $heading ?>
                </h2>

                <?php if ($price): ?>
                <!-- Pricing -->
                <div class="mt-10 flex flex-col items-center">
                    <?php if ($price_label): ?>
                    <p class="font-flatline font-semibold text-3xl text-navy"><?= esc_html($price_label) ?></p>
                    <?php endif; ?>

                    <?php if ($price_original): ?>
                    <div class="mt-4 flex items-center gap-4">
                        <span class="font-flatline font-semibold text-3xl text-dark-text/40 line-through italic"><?= esc_html($price_original) ?></span>
                        <span class="font-flatline font-semibold text-5xl md:text-6xl text-gold-section italic"><?= esc_html($price) ?></span>
                    </div>
                    <?php else: ?>
                    <span class="mt-4 font-flatline font-semibold text-5xl md:text-6xl text-gold-section italic"><?= esc_html($price) ?></span>
                    <?php endif; ?>

                    <?php if ($price_description): ?>
                    <p class="mt-4 font-garet text-base text-navy"><?= esc_html($price_description) ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- CTA -->
                <div class="mt-10">
                    <a href="<?= esc_url($btn_url) ?>" class="btn-primary">
                        <?= esc_html($btn_text) ?>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
