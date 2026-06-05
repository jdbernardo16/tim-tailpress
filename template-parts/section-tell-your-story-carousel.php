<?php

/**
 * Tell Your Story Page - Carousel Section template part.
 *
 * @package TailPress
 */

$carousel_images = array(
    'tell-your-story-carousel-1.webp',
    'tell-your-story-carousel-2.webp',
    'tell-your-story-carousel-3.webp',
    'tell-your-story-carousel-4.webp',
    'tell-your-story-carousel-5.webp',
    'tell-your-story-carousel-6.webp',
);

if (have_rows('section_tys_carousel_images')) {
    $carousel_images = array();
    while (have_rows('section_tys_carousel_images')) {
        the_row();
        $image_id = get_sub_field('image');
        if ($image_id) {
            $carousel_images[] = $image_id;
        }
    }
}
?>

<section class="py-16 lg:py-20 bg-canvas overflow-hidden">
    <div class="tell-your-story-swiper swiper">
        <div class="swiper-wrapper">
            <?php foreach ($carousel_images as $image) : ?>
                <div class="swiper-slide !w-auto">
                    <div class="w-[280px] sm:w-[360px] aspect-[3/2] rounded-[10px] overflow-hidden bg-navy flex-shrink-0">
                        <?php if (is_numeric($image)): ?>
                            <?= wp_get_attachment_image($image, 'large', false, ['class' => 'w-full h-full object-cover', 'alt' => '']) ?>
                        <?php else: ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/' . $image); ?>"
                                 alt="" class="w-full h-full object-cover">
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="flex items-center justify-center gap-4 mt-8">
        <button class="tell-your-story-swiper-button-prev w-[52px] h-[52px] rounded-full bg-gold border-none cursor-pointer flex items-center justify-center transition-transform hover:-translate-y-0.5 hover:shadow-lg"
                aria-label="Previous">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M19 12H5M5 12L12 5M5 12L12 19" stroke="#0f203d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <button class="tell-your-story-swiper-button-next w-[52px] h-[52px] rounded-full bg-gold border-none cursor-pointer flex items-center justify-center transition-transform hover:-translate-y-0.5 hover:shadow-lg"
                aria-label="Next">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="#0f203d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>
</section>
