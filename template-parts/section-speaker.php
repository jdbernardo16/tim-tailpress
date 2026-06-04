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

<section class="relative mx-10 rounded-3xl overflow-hidden bg-navy">
    <!-- Background image -->
    <?php if ($bg_image_id): ?>
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('<?php echo esc_url(wp_get_attachment_image_url($bg_image_id, 'full')); ?>');"></div>
    <?php endif; ?>

    <div class="relative flex items-center justify-between max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[564px]">
        <!-- Left image -->
        <div class="flex-1 flex justify-start items-end h-full">
            <?php if ($image_id): ?>
                <?= wp_get_attachment_image($image_id, 'full', false, ['class' => 'h-full w-auto object-contain object-bottom', 'alt' => 'Joanna - Speaker Cohort']) ?>
            <?php endif; ?>
        </div>

        <!-- Right content -->
        <div class="flex-1 max-w-[480px]">
            <h2 class="font-flatline font-semibold text-white text-center" style="font-size: 56px; line-height: 1.1;">
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
