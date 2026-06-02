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
                <?php else: ?>
                <ul class="mt-10 space-y-4">
                    <?php
                    $includes = array(
                        'A 7-minute training with Joanna',
                        'A Clear Message – what you say',
                        'A Clear Position – why people choose you',
                        'A Clear Voice – how you confidently show up and get remembered',
                        'The framework behind your defining message',
                        'A guided homework exercise to uncover it yourself',
                        'One message you can immediately use in: speaking, pitches, leadership, interviews, and conversations',
                    );
                    ?>
                    <?php foreach ($includes as $item) : ?>
                        <li class="flex items-start gap-3 font-garet text-lg text-dark-text leading-[1.5]">
                            <svg class="w-5 h-5 flex-shrink-0 mt-1.5 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                                <path d="M18 14L18.75 16.25L21 17L18.75 17.75L18 20L17.25 17.75L15 17L17.25 16.25L18 14Z" opacity="0.6"/>
                                <path d="M6 14L6.75 16.25L9 17L6.75 17.75L6 20L5.25 17.75L3 17L5.25 16.25L6 14Z" opacity="0.6"/>
                            </svg>
                            <span><?php echo esc_html($item); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>

                <div class="mt-10">
                    <a href="<?php echo esc_url(home_url('/million-dollar-message/')); ?>" class="btn-primary">
                        START THE TRAINING — $29
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Image -->
            <div class="w-full lg:w-1/2">
                <?php if ($inside_image_id): ?>
                    <?= wp_get_attachment_image($inside_image_id, 'full', false, ['class' => 'w-full h-auto object-cover rounded-xl', 'alt' => 'Joanna Horton McPherson']) ?>
                <?php else: ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/million-inside.webp" alt="Joanna Horton McPherson" class="w-full h-auto object-cover rounded-xl">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
