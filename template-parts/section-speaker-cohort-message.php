<?php

/**
 * Speaker Cohort Page - "You Know Your Work" Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_message_heading') ?: 'You Know Your Work. But Your Message Still <em class="text-gold italic">Isn&rsquo;t Landing.</em>';

$default_text = <<<HTML
<p>You:</p>
<ul>
  <li>ramble instead of landing your point</li>
  <li>over-explain before saying anything clear</li>
  <li>walk away thinking: &ldquo;That&rsquo;s not what I meant to say.&rdquo;</li>
</ul>
<p>You don&rsquo;t lack experience.</p>
<p>You haven&rsquo;t structured your message to move people yet.</p>
HTML;

$text = get_field('section_message_text') ?: $default_text;
$image_id = get_field('section_message_image');
?>
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-8">
            <!-- Text Content -->
            <div class="w-full lg:w-[590px] flex-shrink-0">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                    <?= $heading ?>
                </h2>

                <div class="mt-6 font-garet text-lg font-light text-dark-text leading-[150%]
                            [&>p]:m-0
                            [&>p:first-child]:font-flatline [&>p:first-child]:text-2xl [&>p:first-child]:font-medium [&>p:first-child]:text-navy [&>p:first-child]:leading-[1.1] [&>p:first-child]:mb-4
                            [&>p+p]:mt-4
                            [&>ul]:list-none [&>ul]:p-0 [&>ul]:m-0 [&>ul]:space-y-1 [&>ul]:mb-6
                            [&_ul_li]:flex [&_ul_li]:items-center [&_ul_li]:gap-2
                            [&_ul_li]:before:content-[''] [&_ul_li]:before:w-4 [&_ul_li]:before:h-4
                            [&_ul_li]:before:bg-no-repeat [&_ul_li]:before:bg-contain [&_ul_li]:before:flex-shrink-0
                            [&_ul_li]:before:bg-[url('data:image/svg+xml;utf8,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20viewBox%3D%270%200%2024%2024%27%20fill%3D%27%23d4b478%27%3E%3Cpath%20d%3D%27M12%202L13.5%208.5L20%2010L13.5%2011.5L12%2018L10.5%2011.5L4%2010L10.5%208.5L12%202Z%27%2F%3E%3C%2Fsvg%3E')]">
                    <?= wp_kses_post($text) ?>
                </div>
            </div>

            <!-- Image -->
            <div class="w-full lg:flex-1">
                <?php if ($image_id): ?>
                    <?= wp_get_attachment_image($image_id, 'full', false, ['class' => 'w-full h-[450px] object-cover rounded-[10px]', 'alt' => 'Joanna Horton McPherson']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
