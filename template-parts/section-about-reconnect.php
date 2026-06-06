<?php
/**
 * About Page - Reconnect Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_reconnect_heading') ?: "Joanna <span class=\"italic text-gold\">Help</span> Leaders Reconnect With What People Can Actually Feel.";
$text = get_field('section_reconnect_text');
$btn_text = get_field('section_reconnect_btn_text');
$btn_url = get_field('section_reconnect_btn_url');
?>

<section class="px-10 relative z-10">
    <div class="relative overflow-hidden rounded-[20px] bg-[#0f203d]">
        <!-- Background image with baked-in lights -->
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/herwork-bg.webp" alt="">
        </div>




        <!-- "HER WORK" decorative text watermark -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2  z-20 pointer-events-none">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/herwork-text.webp" alt="" class="w-[500px] md:w-[700px] lg:w-[900px] max-w-none">
        </div>

        <div class="absolute top-0 right-0">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/joanna-work.webp" alt="Joanna" class="h-full object-contain">
        </div>
        <!-- Crowd silhouettes at bottom -->
        <div class="absolute bottom-0 left-0 right-0 z-10 pointer-events-none">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/work-people.webp" alt="" class="w-full h-auto object-cover">
        </div>

        <!-- Main content -->
        <div class="relative z-30 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:pt-24 lg:pt-32 pb-64">
            <div class="w-fit mx-auto">
                <!-- Text Content - Left side -->
                <div class="flex-1 max-w-2xl text-center">
                    <h2 class="font-flatline font-semibold text-3xl sm:text-4xl md:text-5xl lg:text-[56px] text-white leading-tight">
                        <?= $heading ?>
                    </h2>
                    <?php if ($text): ?>
                        <div class="mt-6 md:mt-8 font-garet text-base md:text-lg text-white leading-relaxed opacity-90
                                    [&>p]:m-0">
                            <?= wp_kses_post($text) ?>
                        </div>
                    <?php else: ?>
                        <p class="mt-6 md:mt-8 font-garet text-base md:text-lg text-white leading-relaxed opacity-90">
                            Through retreats, transformational speaking experiences, leadership conversations, and private advisory work, she helps people uncover the story behind their influence and communicate it with clarity, courage, and emotional truth.
                        </p>
                    <?php endif; ?>
                    <?php if ($btn_text && $btn_url): ?>
                        <div class="mt-8">
                            <a href="<?= esc_url($btn_url) ?>" class="btn-primary">
                                <?= esc_html($btn_text) ?>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Joanna Image - Right side -->

            </div>
        </div>
    </div>
</section>
