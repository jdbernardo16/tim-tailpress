<?php

/**
 * Million Dollar Message Page - What's Inside Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_inside_heading') ?: 'What&#8217;s <em class="text-gold italic">Inside</em>';
$inside_text = get_field('section_inside_text');
$inside_image_id = get_field('section_inside_image');

$default_text = <<<HTML
<ul>
  <li>A 7-minute training with Joanna</li>
  <li>A Clear Message &ndash; what you say</li>
  <li>A Clear Position &ndash; why people choose you</li>
  <li>A Clear Voice &ndash; how you confidently show up and get remembered</li>
  <li>The framework behind your defining message</li>
  <li>A guided homework exercise to uncover it yourself</li>
  <li>One message you can immediately use in: speaking, pitches, leadership, interviews, and conversations</li>
</ul>
HTML;

$text = $inside_text ?: $default_text;
?>
<section class="bg-canvas py-24 lg:py-32" id="inside">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-8">
            <!-- Text Content -->
            <div class="w-full lg:w-[590px] flex-shrink-0">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                    <?= $heading ?>
                </h2>

                <div class="mt-6 font-garet text-lg font-light text-dark-text leading-[150%]
                            [&>ul]:list-none [&>ul]:p-0 [&>ul]:m-0 [&>ul]:space-y-1
                            [&_ul_li]:flex [&_ul_li]:items-center [&_ul_li]:gap-2
                            [&_ul_li]:before:content-[''] [&_ul_li]:before:w-4 [&_ul_li]:before:h-4
                            [&_ul_li]:before:bg-no-repeat [&_ul_li]:before:bg-contain [&_ul_li]:before:flex-shrink-0
                            [&_ul_li]:before:bg-[url('data:image/svg+xml;utf8,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20viewBox%3D%270%200%2024%2024%27%20fill%3D%27%23d4b478%27%3E%3Cpath%20d%3D%27M12%202L13.5%208.5L20%2010L13.5%2011.5L12%2018L10.5%2011.5L4%2010L10.5%208.5L12%202Z%27%2F%3E%3C%2Fsvg%3E')]">
                    <?= wp_kses_post($text) ?>
                </div>
            </div>

            <!-- Image -->
            <div class="w-full lg:flex-1">
                <?php if ($inside_image_id): ?>
                    <?= wp_get_attachment_image($inside_image_id, 'full', false, ['class' => 'w-full h-[450px] object-cover rounded-[10px]', 'alt' => 'Joanna Horton McPherson']) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
