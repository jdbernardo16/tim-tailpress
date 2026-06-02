<?php
/**
 * About Page - Life Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_life_heading') ?: "A <em class=\"text-gold italic\">Life</em> Built Across Leadership<br>and Transformation.";
$text = get_field('section_life_text');

$credentials = array(
    "Master's in Education – Harvard University",
    'Advanced studies in Sustainable Investing – Harvard Business School',
    'Six-time founder',
    'Founded nonprofit and international school in Costa Rica',
    'President of the National Association of Women Business Owners in Phoenix',
);
?>

<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-tight">
            <?= $heading ?>
        </h2>

        <?php if ($text): ?>
            <?= $text ?>
        <?php else: ?>
            <ul class="mt-12 space-y-4">
                <?php foreach ($credentials as $credential) : ?>
                    <li class="flex items-center justify-center gap-3 font-garet text-lg text-dark-text">
                        <svg class="w-5 h-5 flex-shrink-0 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                            <path d="M18 14L18.75 16.25L21 17L18.75 17.75L18 20L17.25 17.75L15 17L17.25 16.25L18 14Z" opacity="0.6"/>
                            <path d="M6 14L6.75 16.25L9 17L6.75 17.75L6 20L5.25 17.75L3 17L5.25 16.25L6 14Z" opacity="0.6"/>
                        </svg>
                        <span><?php echo esc_html($credential); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
