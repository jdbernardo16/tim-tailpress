<?php

/**
 * Million Dollar Message Page - What's Inside Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_inside_heading') ?: 'What&#8217;s <em class="text-gold italic">Inside</em>';
$inside_text = get_field('section_inside_text');
$inside_image_id = get_field('section_inside_image');
?>
<section class="bg-canvas py-24 lg:py-32" id="inside">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <!-- Text Content -->
            <div class="w-full lg:w-1/2">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                    <?= $heading ?>
                </h2>

                <?php if ($inside_text): ?>
                    <?= wpautop($inside_text) ?>
                <?php endif; ?>
            </div>

            <!-- Image -->
            <div class="w-full lg:w-1/2">
                <?php if ($inside_image_id): ?>
                    <?= wp_get_attachment_image($inside_image_id, 'full', false, ['class' => 'w-full h-auto object-cover rounded-xl', 'alt' => 'Joanna Horton McPherson']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
