<?php

/**
 * Be Remembered Page - "Your Work Has Impact" Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_message_heading') ?: 'Your Work Has Impact.<br>Your <em class="text-gold italic">Legacy</em> Doesn&rsquo;t Have a Framework.';

$default_text = <<<HTML
<p>You&rsquo;ve built a meaningful career but:</p>
<ul>
  <li>your influence feels tied only to your presence</li>
  <li>succession planning has never been formalized</li>
  <li>your work, voice, and wealth are not yet aligned</li>
  <li>there is no clear structure for what you&rsquo;ll leave behind</li>
</ul>
<p>You don&rsquo;t need more success.</p>
<p>You need a legacy blueprint others can carry forward.</p>
HTML;

$text = get_field('section_message_text') ?: $default_text;
$message_image_id = get_field('section_message_image');
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
                <?php if ($message_image_id): ?>
                    <?= wp_get_attachment_image($message_image_id, 'full', false, ['class' => 'w-full h-[450px] object-cover rounded-[10px]', 'alt' => 'Joanna Horton McPherson']) ?>
                <?php else: ?>
                    <img src="<?= esc_url(get_template_directory_uri()) ?>/assets/images/be-remembered-1.webp" alt="Joanna Horton McPherson" class="w-full h-[450px] object-cover rounded-[10px]">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
