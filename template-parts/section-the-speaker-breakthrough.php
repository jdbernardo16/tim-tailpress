<?php

/**
 * The Speaker Page - Breakthrough Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_breakthrough_heading') ?: "Want to go further?";
$text = get_field('section_breakthrough_text') ?: "One focused session designed to create immediate clarity and direction.";
$btn_text = get_field('section_breakthrough_btn_text') ?: "BOOK A BREAKTHROUGH SESSION";
$btn_url = get_field('section_breakthrough_btn_url') ?: 'https://go.trueinfluencemethod.com/breakthrough-session';
?>
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center text-center">
        <!-- Heading -->
        <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[40px] text-navy leading-[1.1]">
            <?= esc_html($heading) ?>
        </h2>

        <!-- Card -->
        <div class="mt-10 w-full max-w-[361px] rounded-[10px] bg-warm-beige border border-gold-section backdrop-blur-md p-6 sm:p-8 text-left flex flex-col gap-6">
            <h3 class="font-flatline font-medium text-3xl text-navy leading-[1.1]">
                Breakthrough Session
            </h3>

            <p class="font-garet text-base text-dark-text leading-[150%]">
                <?= esc_html($text) ?>
            </p>

            <p class="font-flatline font-medium text-4xl text-gold leading-[1.1]">
                $2,000
            </p>

            <a href="<?php echo esc_url($btn_url); ?>" class="btn-primary w-full">
                <?= esc_html($btn_text) ?>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </div>
</section>
