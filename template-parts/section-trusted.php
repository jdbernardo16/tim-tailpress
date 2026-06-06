<?php

/**
 * Trusted By Leaders Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_trusted_heading') ?: 'Trusted by<br>leaders worldwide';
?>

<section class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:space-x-20 md:justify-between gap-6 md:gap-0">
            <p class="text-lg font-flatline font-semibold uppercase tracking-[50%] text-navy mb-6 md:mb-12">
                <?= $heading ?>
            </p>

            <div class="flex flex-wrap justify-center gap-12 md:gap-16 mb-16">
                <?php if (have_rows('section_trusted_stats')): ?>
                    <?php while (have_rows('section_trusted_stats')): the_row(); ?>
                        <?php $icon_id = get_sub_field('item_icon'); ?>
                        <div class="flex items-center gap-4">
                            <?php if ($icon_id): ?>
                                <?= wp_get_attachment_image($icon_id, 'full', false, ['alt' => '']) ?>
                            <?php endif; ?>
                            <div>
                                <p class="font-flatline text-lg font-semibold leading-[1.2rem] text-navy"><?= esc_html(get_sub_field('item_value')) ?></p>
                                <p class="font-garet text-base text-dark-text"><?= esc_html(get_sub_field('item_label')) ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="marquee overflow-hidden">
        <div class="marquee__track flex gap-8 md:gap-16">
            <?php for ($j = 0; $j < 2; $j++) : ?>
                <?php for ($i = 1; $i <= 30; $i++) : ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logos/logo-company-<?php echo $i; ?>.webp" alt="" class="marquee__img h-16 w-auto object-contain opacity-60 grayscale transition hover:opacity-100 hover:grayscale-0">
                <?php endfor; ?>
            <?php endfor; ?>
        </div>
    </div>
</section>
