<?php

$heading = get_field('section_what_is_heading');
$what_is_text = get_field('section_what_is_text');
$what_is_image_id = get_field('section_what_is_image');
?>
<section class="bg-canvas py-24 lg:py-28">
    <div class="max-w-[1230px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-start gap-12 lg:gap-16">
            <div class="w-full lg:w-1/2">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-dark-text leading-[1.1]">
                    <?= $heading ?>
                </h2>

                <?php if ($what_is_text): ?>
                    <div class="mt-8 font-garet text-lg text-dark-text leading-[1.5]">
                        <?= wpautop($what_is_text) ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="w-full lg:w-1/2">
                <?php if ($what_is_image_id): ?>
                    <?= wp_get_attachment_image($what_is_image_id, 'full', false, ['class' => 'w-full h-[356px] object-cover rounded-[10px]', 'alt' => 'Joanna Horton McPherson']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
