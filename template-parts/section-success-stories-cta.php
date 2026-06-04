<?php

/**
 * Success Stories Page - CTA Section template part.
 *
 * @package TailPress
 */

$bg_image_id = get_field('section_cta_bg_image');
$heading = get_field('section_cta_heading') ?: 'Your Story May Be Waiting for Its <em class="text-gold italic">Moment</em> too';
$text = get_field('section_cta_text') ?: 'Explore the retreat, speaking experiences, and transformational work behind the True Influence Method™.';
$btn_text = get_field('section_cta_btn_text') ?: 'Start Your Story Journey';
$btn_url = get_field('section_cta_btn_url') ?: home_url('/get-started/');
?>
<section class="relative mx-8 rounded-3xl bg-gold-section overflow-hidden ">
    <?php if ($bg_image_id): ?>
    <div class="absolute inset-0">
        <?= wp_get_attachment_image($bg_image_id, 'full', false, ['class' => 'w-full h-full object-cover', 'alt' => '', 'aria-hidden' => 'true']) ?>
    </div>
    <?php endif; ?>

    <!-- Decorative deep blue ellipses with blur -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-1/4 w-80 h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
    </div>

    <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 text-center">
        <!-- Heading -->
        <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[64px] text-white leading-[1.1]">
            <?= $heading ?>
        </h2>

        <!-- Description -->
        <p class="mt-6 font-garet text-lg text-white max-w-xl mx-auto leading-[150%]">
            <?= esc_html($text) ?>
        </p>

        <!-- Button -->
        <div class="mt-10">
            <a href="<?php echo esc_url($btn_url); ?>" class="btn-primary">
                <?= esc_html($btn_text) ?>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                    <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>

        <!-- Sub-link -->
        <div class="mt-8">
            <p class="font-garet text-base text-white">
                Not sure where to begin?
            </p>
            <a href="<?php echo esc_url(home_url('/get-started/')); ?>" class="font-garet text-base text-white underline hover:opacity-80 transition-opacity">
                Take the 5-minute Influence Path Assessment and we'll know what you need
            </a>
        </div>
    </div>
</section>
