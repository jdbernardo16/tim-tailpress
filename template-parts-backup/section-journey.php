<?php

/**
 * The Journey Section template part.
 *
 * @package TailPress
 */

$phases = array(
    array(
        'number'  => '1',
        'title'   => 'Speak Your Story',
        'desc'    => 'Uncover the truth behind your experiences and learn to share it with courage.',
        'image'   => 'phase-1.webp',
    ),
    array(
        'number'  => '2',
        'title'   => 'Move the Room',
        'desc'    => 'Develop the presence and energy that captivates and inspires any audience.',
        'image'   => 'phase-2.webp',
    ),
    array(
        'number'  => '3',
        'title'   => 'Master My Message',
        'desc'    => 'Refine your core message so it resonates deeply and drives action.',
        'image'   => 'phase-3.webp',
    ),
    array(
        'number'  => '4',
        'title'   => 'Build My Team',
        'desc'    => 'Create a culture of trust, communication, and shared purpose.',
        'image'   => 'phase-4.webp',
    ),
    array(
        'number'  => '5',
        'title'   => 'Be Remembered',
        'desc'    => 'Leave a lasting impact that extends far beyond the moment you speak.',
        'image'   => 'phase-5.webp',
    ),
);
?>

<section class="relative bg-canvas">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <!-- Header -->
        <div class="text-center mb-16">
            <h2 class="font-flatline font-medium text-5xl md:text-6xl text-navy leading-tight">
                The <em class="text-gold italic">Journey</em>
            </h2>
            <p class="mt-4 font-garet text-lg text-dark-text">
                The True influence method.
            </p>
        </div>

        <!-- Cards Row -->
        <div class="space-y-6">
            <?php foreach ($phases as $phase) : ?>
                <div class="relative rounded-lg overflow-hidden bg-zinc-200 aspect-[1100/362] group">
                    <!-- Image -->
                    <img
                        src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/<?php echo esc_attr($phase['image']); ?>"
                        alt="<?php echo esc_attr($phase['title']); ?>"
                        class="w-full h-full object-cover object-top">

                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

                    <!-- Content -->
                    <div class="absolute bottom-0 left-0 right-0 p-5">
                        <h3 class="font-flatline font-medium text-3xl text-white leading-tight">
                            <?php echo esc_html($phase['title']); ?>
                        </h3>
                        <p class="mt-2 font-garet text-base text-white leading-relaxed">
                            <?php echo esc_html($phase['desc']); ?>
                        </p>
                    </div>

                    <!-- Phase Watermark -->
                    <div class="absolute top-3 right-3 font-flatline font-medium text-5xl text-white/20 leading-none select-none">
                        PHASE <?php echo esc_html($phase['number']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
