<?php
/**
 * About Page - Gallery Section template part.
 *
 * @package TailPress
 */

$gallery_images = get_field('section_leader_gallery');
if (! $gallery_images) {
    $gallery_images = array(
        'tell-story-1.webp',
        'tell-story-2.webp',
        'tell-story-3.webp',
        'tell-story-4.webp',
    );
}
?>

<section class="bg-canvas pb-24 lg:pb-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php foreach ($gallery_images as $image) : ?>
                <div class="relative aspect-square rounded-xl overflow-hidden">
                    <?php if (is_numeric($image)) : ?>
                        <?= wp_get_attachment_image($image, 'medium', false, ['class' => 'w-full h-full object-cover']) ?>
                    <?php else : ?>
                        <img
                            src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/<?php echo esc_attr($image); ?>"
                            alt="Joanna"
                            class="w-full h-full object-cover"
                        >
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
