<?php

$heading = get_field('section_videos_heading');
?>
<section class="relative pt-24 lg:pt-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-12">
            <h2 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[56px] text-dark leading-[1.1] max-w-[600px]">
                <?= $heading ?>
            </h2>
            <p class="font-garet text-lg text-dark leading-[150%] max-w-[500px]">
                Moments of clarity, confidence, transformation, and emotional breakthrough from people who experienced the work firsthand.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
            <?php if (have_rows('section_videos_items')): ?>
                <?php while (have_rows('section_videos_items')): the_row(); ?>
                    <?php
                    $item_image_id = get_sub_field('item_image');
                    $video_embed = get_sub_field('item_video_url');
                    ?>
                    <div class="flex flex-col">
                        <div class="relative h-[400px] rounded-[10px] overflow-hidden bg-[#363636]">
                            <?php if ($item_image_id): ?>
                                <?= wp_get_attachment_image($item_image_id, 'full', false, ['class' => 'w-full h-full object-cover']) ?>
                            <?php endif; ?>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-[65px] h-[65px] flex items-center justify-center rounded-[5px]">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/play.svg" alt="" class="w-16 h-16" aria-hidden="true">
                                </div>
                            </div>
                        </div>

                        <p class="mt-4 font-garet text-lg text-[#1e1e1e] leading-[150%]">
                            "<?php echo esc_html(get_sub_field('item_quote')); ?>"
                        </p>

                        <p class="mt-2 font-flatline font-bold text-lg text-navy tracking-[20%]">
                            <?php echo esc_html(get_sub_field('item_name')); ?>
                        </p>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
