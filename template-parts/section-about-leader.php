<?php
/**
 * About Page - Leader Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_leader_heading') ?: "Being a Leader is Choosing What You <em class=\"text-gold italic\">Become.</em>";
$text = get_field('section_leader_text');
$image_id = get_field('section_leader_image');
$gallery = get_field('section_leader_gallery');
?>

<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <!-- Image -->
            <div class="flex-1 flex justify-center lg:justify-start">
                <?php if ($image_id): ?>
                    <?= wp_get_attachment_image($image_id, 'full', false, ['class' => 'w-full max-w-md lg:max-w-lg object-cover rounded-xl', 'alt' => 'Joanna']) ?>
                <?php else: ?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/about-frame2.webp" alt="Joanna" class="w-full max-w-md lg:max-w-lg object-cover rounded-xl">
                <?php endif; ?>
            </div>
            <!-- Text Content -->
            <div class="flex-1 max-w-xl">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-tight">
                    <?= $heading ?>
                </h2>
                <div class="mt-8 font-garet text-lg text-dark-text leading-normal space-y-6">
                    <?php if ($text): ?>
                        <?= $text ?>
                    <?php else: ?>
                        <p>People do not follow information alone. They follow truth they can feel.</p>
                        <p>The True Influence Method™ was created to help leaders reconnect with the experiences that shaped the way they lead, speak, and move people.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if ($gallery): ?>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-12">
                <?php foreach ($gallery as $gallery_image_id): ?>
                    <div class="relative aspect-square rounded-xl overflow-hidden">
                        <?= wp_get_attachment_image($gallery_image_id, 'medium', false, ['class' => 'w-full h-full object-cover']) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
