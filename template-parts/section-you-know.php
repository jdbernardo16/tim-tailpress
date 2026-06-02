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

<section class="bg-[#F8F4EC] py-24 lg:pt-64">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex space-x-16">
            <div class="relative flex-1 h-fit">
                <?php if ($bg_image_id): ?>
                    <?= wp_get_attachment_image($bg_image_id, 'full', false, ['class' => 'grayscale', 'alt' => 'Joanna']) ?>
                <?php else: ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/know-bg.webp" alt="Joanna" class="grayscale">
                <?php endif; ?>
                <?php if ($profile_image_id): ?>
                    <?= wp_get_attachment_image($profile_image_id, 'full', false, ['class' => 'w-full h-auto absolute bottom-0 left-0', 'alt' => 'Joanna']) ?>
                <?php else: ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/joanna-whole.webp" alt="Joanna" class="w-full h-auto absolute bottom-0 left-0">
                <?php endif; ?>
            </div>
            <div class="max-w-[442px]">
                <h2 class="font-flatline font-medium text-5xl md:text-6xl text-navy leading-tight">
                    <?= $heading ?>
                </h2>
                <div class="mt-6 font-garet text-lg text-dark-text leading-normal space-y-4">
                    <?php if ($text): ?>
                        <?= wpautop($text) ?>
                    <?php else: ?>
                        <p>But when it's time to speak… <br><br>You over-explain. You soften your truth. You lose the part people were supposed to feel.</p>
                        <p>Because the words were never the problem.<br><br>The disconnect came long before the conversation did.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</section>
