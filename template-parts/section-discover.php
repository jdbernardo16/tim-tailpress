<?php

/**
 * Discover Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_discover_heading') ?: 'Discover the Message <em class="text-gold italic">Hidden</em> Inside Your Story.';
$text = get_field('section_discover_text') ?: 'A guided experience to help you uncover the truth, perspective, and story behind your influence.';
$image_id = get_field('section_discover_image');
$btn_text = get_field('section_discover_btn_text') ?: 'Explore the $29 MILLION DOLLAR Experience';
$btn_url = get_field('section_discover_btn_url') ?: '/million-dollar-message/';
?>

<section class="relative mx-10 rounded-b-3xl bg-warm-beige overflow-hidden">
    <!-- Decorative blurred gold ellipses -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-96 h-96 bg-gold/30 rounded-full blur-3xl transform -translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-gold/20 rounded-full blur-3xl transform translate-y-1/2"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <div class="flex-1 max-w-[457px]">
                <h2 class="text-[56px] leading-tight font-flatline">
                    <?= $heading ?>
                </h2>
                <p class="mt-6 text-body">
                    <?= esc_html($text) ?>
                </p>
                <div class="mt-8">
                    <a href="<?php echo esc_url(home_url($btn_url)); ?>" class="btn-primary">
                        <?= esc_html($btn_text) ?>
                    </a>
                </div>
            </div>
            <div class="relative flex-1">
                <?php if ($image_id): ?>
                    <?= wp_get_attachment_image($image_id, 'full', false, ['class' => 'w-full', 'alt' => 'Joanna - Discover']) ?>
                <?php endif; ?>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/discover-whole.webp" alt="Joanna - Discover" class="w-full absolute bottom-0 left-0">

            </div>

        </div>
    </div>
</section>
