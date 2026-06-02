<?php

/**
 * The Journey Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_journey_heading') ?: 'The <em class="text-gold italic">Journey</em>';

$fallback_phases = array(
    array(
        'title'   => 'Speak Your Story',
        'text'    => 'Uncover the truth behind your experiences and learn to share it with courage.',
        'image'   => 'phase-1.webp',
    ),
    array(
        'title'   => 'Move the Room',
        'text'    => 'Develop the presence and energy that captivates and inspires any audience.',
        'image'   => 'phase-2.webp',
    ),
    array(
        'title'   => 'Master My Message',
        'text'    => 'Refine your core message so it resonates deeply and drives action.',
        'image'   => 'phase-3.webp',
    ),
    array(
        'title'   => 'Build My Team',
        'text'    => 'Create a culture of trust, communication, and shared purpose.',
        'image'   => 'phase-4.webp',
    ),
    array(
        'title'   => 'Be Remembered',
        'text'    => 'Leave a lasting impact that extends far beyond the moment you speak.',
        'image'   => 'phase-5.webp',
    ),
);
?>

<section class="relative bg-canvas">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <!-- Header -->
        <div class="text-center mb-16">
            <h2 class="font-flatline font-medium text-5xl md:text-6xl text-navy leading-tight">
                <?= $heading ?>
            </h2>
            <p class="mt-4 font-garet text-lg text-dark-text">
                The True influence method.
            </p>
        </div>

        <!-- Cards Row -->
        <div class="space-y-6">
            <?php if (have_rows('section_journey_items')): ?>
                <?php $phase_num = 1; while (have_rows('section_journey_items')): the_row(); ?>
                    <?php $item_icon_id = get_sub_field('item_icon'); ?>
                    <div class="relative rounded-lg overflow-hidden bg-zinc-200 aspect-[1100/362] group">
                        <?php if ($item_icon_id): ?>
                            <?= wp_get_attachment_image($item_icon_id, 'full', false, ['class' => 'w-full h-full object-cover object-top', 'alt' => esc_attr(get_sub_field('item_heading'))]) ?>
                        <?php endif; ?>

                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

                        <!-- Content -->
                        <div class="absolute bottom-0 left-0 right-0 p-5">
                            <h3 class="font-flatline font-medium text-3xl text-white leading-tight">
                                <?= esc_html(get_sub_field('item_heading')) ?>
                            </h3>
                            <p class="mt-2 font-garet text-base text-white leading-relaxed">
                                <?= esc_html(get_sub_field('item_text')) ?>
                            </p>
                        </div>

                        <!-- Phase Watermark -->
                        <div class="absolute top-3 right-3 font-flatline font-medium text-5xl text-white/20 leading-none select-none">
                            PHASE <?= $phase_num ?>
                        </div>
                    </div>
                <?php $phase_num++; endwhile; ?>
            <?php else: ?>
                <?php foreach ($fallback_phases as $index => $phase) : ?>
                    <div class="relative rounded-lg overflow-hidden bg-zinc-200 aspect-[1100/362] group">
                        <img
                            src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/<?php echo esc_attr($phase['image']); ?>"
                            alt="<?php echo esc_attr($phase['title']); ?>"
                            class="w-full h-full object-cover object-top">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

                        <div class="absolute bottom-0 left-0 right-0 p-5">
                            <h3 class="font-flatline font-medium text-3xl text-white leading-tight">
                                <?= esc_html($phase['title']); ?>
                            </h3>
                            <p class="mt-2 font-garet text-base text-white leading-relaxed">
                                <?= esc_html($phase['text']); ?>
                            </p>
                        </div>

                        <div class="absolute top-3 right-3 font-flatline font-medium text-5xl text-white/20 leading-none select-none">
                            PHASE <?= $index + 1 ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
