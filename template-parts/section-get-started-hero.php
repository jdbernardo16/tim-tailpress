<?php

/**
 * Get Started Page - Hero Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_hero_heading') ?: 'Choose Where You Are.';
$text = get_field('section_hero_text') ?: "You don't need more strategy. You need to close the gap between what you know and what you can actually say in the moments that matter.";
$bg_image_id = get_field('section_hero_bg_image');
$btn_text = get_field('section_hero_btn_text');
$btn_url = get_field('section_hero_btn_url');
?>

<section class="relative bg-navy overflow-hidden">
    <!-- Background texture -->
    <div class="absolute inset-0">
        <?php if ($bg_image_id): ?>
            <?= wp_get_attachment_image($bg_image_id, 'full', false, ['class' => 'w-full h-full object-cover object-right', 'alt' => '']) ?>
        <?php else: ?>
            <img class="w-full h-full object-cover object-right" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/generic-bg.webp" alt="">
        <?php endif; ?>
    </div>



    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 lg:pt-44 pb-16">
        <!-- Heading Section -->
        <div class="text-center mb-10">
            <h1 class="font-flatline font-semibold text-4xl md:text-5xl lg:text-[64px] text-white leading-[1.1]">
                <?= esc_html($heading) ?>
            </h1>
            <p class="mt-6 font-garet font-light text-lg text-white leading-[1.5] max-w-[694px] mx-auto">
                <?= esc_html($text) ?>
            </p>
            <p class="mt-4 font-garet font-light text-lg text-white leading-[1.5] max-w-[694px] mx-auto">
                Are you building your message, your authority, or your legacy?
            </p>
            <?php if ($btn_text && $btn_url) : ?>
            <div class="mt-8">
                <a href="<?= esc_url($btn_url) ?>" class="btn-primary">
                    <?= esc_html($btn_text) ?>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
            <?php endif; ?>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 max-w-[1100px] mx-auto mt-16">
            <?php
            $cards = array(
                array(
                    'tag'         => 'THE SPEAKER',
                    'title'       => 'Find my Message.',
                    'description' => 'You know you have something to say — but you can\'t clearly articulate what defines you yet.',
                    'quote'       => '"I know there\'s something important here."',
                    'button_text' => 'Start Here',
                    'button_url'  => home_url('/the-speaker/'),
                ),
                array(
                    'tag'         => 'THE AUTHORITY',
                    'title'       => 'Build my Talk.',
                    'description' => 'You know your work — but your message loses energy when you explain it.',
                    'quote'       => '"I want my message to land."',
                    'button_text' => 'Get the Framework',
                    'button_url'  => home_url('/the-authority/'),
                ),
                array(
                    'tag'         => 'THE LEGACY',
                    'title'       => 'Define my Legacy.',
                    'description' => 'You\'ve built something significant — but now you want to create work that outlives you.',
                    'quote'       => '"I want what I build to matter long-term."',
                    'button_text' => 'Begin My Legacy Work',
                    'button_url'  => home_url('/the-legacy/'),
                ),
            );
            ?>
            <?php foreach ($cards as $card) : ?>
                <div class="relative rounded-xl overflow-hidden border border-gold" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(9px);">
                    <div class="p-8 lg:p-10 flex flex-col gap-6 h-full">
                        <!-- Tag + Title -->
                        <div class="flex flex-col gap-2">
                            <!-- Tag Pill -->
                            <span class="inline-flex self-start items-center px-4 py-2 rounded-full text-xs font-flatline font-bold tracking-[0.3em] uppercase text-warm-beige" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(3px);">
                                <?php echo esc_html($card['tag']); ?>
                            </span>
                            <!-- Title -->
                            <h3 class="font-flatline font-semibold text-[32px] text-gold leading-[1.1]">
                                <?php echo esc_html($card['title']); ?>
                            </h3>
                        </div>

                        <!-- Description -->
                        <p class="font-garet font-light text-base text-white leading-[1.5]">
                            <?php echo esc_html($card['description']); ?>
                        </p>

                        <!-- Quote -->
                        <p class="font-flatline font-semibold italic text-xl text-white leading-[1.5]">
                            <?php echo esc_html($card['quote']); ?>
                        </p>

                        <!-- CTA Button -->
                        <div class="mt-auto">
                            <a href="<?php echo esc_url($card['button_url']); ?>" class="w-full h-[50px] rounded-full font-flatline font-bold text-base text-navy flex items-center justify-center gap-2.5 transition-opacity hover:opacity-90"
                                style="background: radial-gradient(circle at 65% 0%, #e7d4c5 0%, #d4b478 100%); border: 1px solid #e7d4c5;">
                                <?php echo esc_html($card['button_text']); ?>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Bottom Section -->
        <div class="mt-16 lg:mt-20 text-center">
            <p class="font-flatline font-semibold text-lg text-white leading-[1.1]">
                Still exploring?
            </p>
            <p class="mt-2 font-garet font-light text-base text-white leading-[1.5]">
                You don't need to have it fully figured out yet.
            </p>
            <a href="<?php echo esc_url(home_url('/offers/')); ?>" class="inline-flex items-center gap-2.5 mt-3 font-flatline font-bold text-base text-gold hover:opacity-80 transition-opacity">
                VIEW ALL EXPERIENCES
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>
    </div>
</section>
