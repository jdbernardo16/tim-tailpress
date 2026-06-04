<?php

/**
 * Be Remembered Page - "Your Work Has Impact" Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_message_heading') ?: 'Your Work Has Impact.<br>Your <em class="text-gold italic">Legacy</em> Doesn&rsquo;t Have a Framework.';
$text = get_field('section_message_text');
?>
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16">
            <!-- Text Content -->
            <div class="w-full lg:w-1/2">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                    <?= $heading ?>
                </h2>

                <?php if ($text): ?>
                    <?= $text ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
