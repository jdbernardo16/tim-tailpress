<?php

/**
 * Speaker Cohort Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_speaker_heading') ?: '<em class="text-gold italic">Move</em> the Room.';
$text = get_field('section_speaker_text') ?: 'Speaker Cohort is Joanna\'s advanced speaking experience for leaders ready to communicate with clarity, emotional authority, and presence that moves people to action.';
$image_id = get_field('section_speaker_image');
$bg_image_id = get_field('section_speaker_bg_image');
$watermark_image_id = get_field('section_speaker_watermark_image');
$btn_text = get_field('section_speaker_btn_text') ?: 'Explore Speaker Cohort';
$btn_url = get_field('section_speaker_btn_url') ?: '/speaker-cohort/';
?>

<section class="relative mx-4 sm:mx-10 rounded-3xl overflow-hidden bg-navy">
    <!-- Background image -->
    <?php if ($bg_image_id): ?>
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('<?php echo esc_url(wp_get_attachment_image_url($bg_image_id, 'full')); ?>');"></div>
    <?php endif; ?>

    <!-- Watermark image -->
    <?php if ($watermark_image_id): ?>
        <?= wp_get_attachment_image($watermark_image_id, 'full', false, ['class' => 'absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-[1360px] pointer-events-none select-none z-1', 'aria-hidden' => 'true']) ?>
    <?php endif; ?>

    <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-0 min-h-[480px] lg:h-[564px]">
        <!-- Image -->
        <div class="flex-1 flex justify-center lg:justify-start items-end h-64 lg:h-full order-1 lg:order-none">
            <?php if ($image_id): ?>
                <?= wp_get_attachment_image($image_id, 'full', false, ['class' => 'h-full w-auto object-contain object-bottom max-h-64 lg:max-h-none', 'alt' => 'Joanna - Speaker Cohort']) ?>
            <?php endif; ?>
        </div>

        <!-- Content -->
        <div class="flex-1 max-w-[480px] text-center lg:text-left order-2 lg:order-none mt-8 lg:mt-0">
            <h2 class="font-flatline font-semibold text-white text-4xl sm:text-5xl lg:text-[56px] leading-[1.1]">
                <?= $heading ?>
            </h2>
            <p class="mt-6 text-body text-white">
                <?= esc_html($text) ?>
            </p>
            <div class="mt-8">
                <a href="<?php echo esc_url(home_url($btn_url)); ?>" class="btn-primary">
                    <?= esc_html($btn_text) ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/btn-arrow.svg" alt="" class="w-5 h-2" aria-hidden="true">
                </a>
            </div>
        </div>
    </div>
</section>
