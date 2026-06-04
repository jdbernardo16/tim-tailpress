<?php
/**
 * About Page - Meaning Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_meaning_heading') ?: "Long Before the Stages, There Was the Search for <em class=\"text-gold italic\">Meaning.</em>";
$text = get_field('section_meaning_text');

$gallery_images = get_field('section_meaning_gallery');
?>

<section class="bg-canvas pb-8 lg:pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
            <!-- Heading -->
            <div class="flex-1">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-tight">
                    <?= $heading ?>
                </h2>
                <!-- Navigation Arrows -->
                <div class="about-meaning-nav mt-8">
                    <button class="about-meaning-swiper-button-prev about-meaning-nav__btn" aria-label="Previous slide">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                    </button>
                    <button class="about-meaning-swiper-button-next about-meaning-nav__btn" aria-label="Next slide">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Text -->
            <div class="flex-1 max-w-xl">
                <div class="font-garet text-lg text-dark-text leading-normal space-y-6">
                    <?php if ($text): ?>
                        <?= $text ?>
                    <?php else: ?>
                        <p>Joanna's journey began with public speaking at 13 and entrepreneurship at 20, eventually expanding into acting, education, nonprofit leadership, international schools, and transformational coaching.</p>
                        <p>Today, she works with thought leaders, founders, public figures, and high-performing women navigating leadership, visibility, emotional clarity, and conscious success.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Gallery Carousel -->
        <?php if ($gallery_images): ?>
        <div class="swiper about-meaning-swiper mt-12 lg:mt-16">
            <div class="swiper-wrapper">
                <?php foreach ($gallery_images as $image_id) : ?>
                    <div class="swiper-slide">
                        <div class="relative aspect-square rounded-xl overflow-hidden">
                            <?= wp_get_attachment_image($image_id, 'medium', false, ['class' => 'w-full h-full object-cover', 'alt' => 'Joanna']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
