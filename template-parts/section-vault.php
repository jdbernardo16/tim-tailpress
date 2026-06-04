<?php

/**
 * The Vault Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_vault_heading') ?: 'Stay Inside the <span class="text-gold-section italic font-semibold">Conversation.</span>';
$text = get_field('section_vault_text') ?: 'Inside The Vault, Joanna shares live reflections, speaking insights, leadership conversations, and the moments still unfolding behind the work.';
$image_id = get_field('section_vault_image');
$btn_text = get_field('section_vault_btn_text') ?: 'Enter The Vault';
$btn_url = get_field('section_vault_btn_url') ?: '/the-vault/';
$theme_uri = get_template_directory_uri();
?>

<section class="relative mx-10 rounded-b-3xl overflow-hidden"
    <?php if ($image_id): ?>
        style="background-image: url('<?php echo esc_url(wp_get_attachment_image_url($image_id, 'full')); ?>'); background-size: cover; background-position: center;"
    <?php endif; ?>>

    <!-- Decorative blurred gold ellipses -->
    <div class="absolute inset-0 pointer-events-none">
        <!-- Ellipse 2: positioned bottom-right area -->
        <div class="absolute w-[1535px] h-[1535px] bg-gold rounded-full"
            style="top: 342px; left: 986px; filter: blur(620px);"></div>
        <!-- Ellipse 3: positioned top-left area, opacity 0.7 -->
        <div class="absolute w-[1525px] h-[1525px] bg-gold/70 rounded-full"
            style="top: -1183px; left: -901px; filter: blur(560px);"></div>
    </div>

    <!-- Watermark image -->
    <div class="absolute inset-x-0 top-0 flex justify-center pointer-events-none">
        <img src="<?php echo esc_url($theme_uri . '/assets/images/the-vault.webp'); ?>"
            alt=""
            class="w-[770px] h-auto select-none"
            aria-hidden="true">
    </div>

    <!-- Content -->
    <div class="relative max-w-[800px] w-full mx-auto px-4 sm:px-6 lg:px-8 pt-[110px] pb-32 text-center">
        <h2 class="font-flatline font-semibold text-5xl md:text-[56px] text-navy leading-[1.1]">
            <?= $heading ?>
        </h2>
        <p class="mt-6 font-garet font-light text-lg text-navy leading-[1.5] max-w-xl mx-auto">
            <?= esc_html($text) ?>
        </p>
        <div class="mt-10">
            <a href="<?php echo esc_url(home_url($btn_url)); ?>" class="btn-primary">
                <?= esc_html($btn_text) ?>
                <img src="<?php echo esc_url($theme_uri . '/assets/images/btn-arrow.svg'); ?>" alt="" class="w-[21px] h-[8px]" aria-hidden="true">
            </a>
        </div>
    </div>
</section>
