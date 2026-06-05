<?php

/**
 * Events Page - Retreat Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_retreat_heading');
$text = get_field('section_retreat_text');
$image_id = get_field('section_retreat_image');
$image_2_id = get_field('section_retreat_image_2');
?>
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-start lg:items-center gap-8 lg:gap-4">
            <!-- Text Content -->
            <div class="w-full lg:w-7/12 max-w-xl">
                <h2 class="font-flatline font-medium text-3xl sm:text-4xl md:text-5xl lg:text-[56px] leading-[1.1]">
                    <?= $heading ?>
                </h2>
                <div class="mt-8 font-garet text-lg text-dark-text leading-normal space-y-6">
                    <?php if ($text): ?>
                        <?= wpautop($text) ?>
                    <?php endif; ?>
                </div>
                <?php if ($image_2_id): ?>
                <div class="aspect-[636/281] w-full rounded-xl overflow-hidden shadow-lg mt-6">
                    <?= wp_get_attachment_image($image_2_id, 'full', false, ['class' => 'w-full h-full object-cover', 'alt' => 'Laptop and books on a table']) ?>
                </div>
                <?php endif; ?>
            </div>
            <!-- Images -->
            <div class="w-full lg:w-5/12 relative max-w-lg lg:max-w-xl">
                <?php if ($image_id): ?>
                <div class="rounded-xl overflow-hidden shadow-lg aspect-[448/566] w-full">
                    <?= wp_get_attachment_image($image_id, 'full', false, ['class' => 'w-full h-full object-cover', 'alt' => 'Joanna on a couch in red pants']) ?>
                </div>
                <?php endif; ?>
                <div class="mt-4">
                    <a href="<?php echo esc_url(home_url('/events/#upcoming')); ?>" class="btn-primary w-full">
                        EXPLORE THE EXPERIENCE
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                            <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
