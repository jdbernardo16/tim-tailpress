<?php

$heading = get_field('section_story_heading');
$story_text = get_field('section_story_text');
$story_image_id = get_field('section_story_image');
$price = get_field('section_story_price');
$btn_text = get_field('section_story_btn_text') ?: 'FIND MY MESSAGE';
$btn_url = get_field('section_story_btn_url') ?: home_url('/the-speaker/');
?>
<section class="bg-canvas px-4 sm:px-10 py-8 lg:py-12">
    <div class="relative overflow-hidden rounded-[20px] bg-warm-beige">
        <!-- Background texture -->
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-10" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/bg-texture.webp" alt="" aria-hidden="true">
        </div>

        <!-- Decorative gold blur ellipse -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 right-0 w-[1535px] h-[1535px] bg-gold/40 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/2"></div>
        </div>

        <div class="relative grid grid-cols-1 lg:grid-cols-2 items-center gap-8 lg:gap-12">
            <!-- Text Content -->
            <div class="px-6 sm:px-10 lg:pl-16 lg:pr-8 py-16 lg:py-24 max-w-xl">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                    <?= $heading ?>
                </h2>

                <?php if ($story_text): ?>
                    <div class="mt-8 font-garet text-lg text-dark-text leading-[150%]">
                        <?= wpautop($story_text) ?>
                    </div>
                <?php endif; ?>

                <?php if ($price): ?>
                <p class="mt-10 font-flatline font-medium text-4xl text-gold leading-[1.1]">
                    <?= esc_html($price) ?>
                </p>
                <?php endif; ?>

                <div class="mt-8">
                    <a href="<?php echo esc_url($btn_url); ?>" class="btn-primary">
                        <?= esc_html($btn_text) ?>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Image -->
            <div class="relative h-full w-full">
                <?php if ($story_image_id): ?>
                    <?= wp_get_attachment_image($story_image_id, 'full', false, ['class' => 'w-full h-full object-cover lg:rounded-tl-[20px] lg:rounded-bl-[20px] rounded-b-[20px] lg:rounded-br-none', 'alt' => 'Joanna Horton McPherson']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
