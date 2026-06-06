<?php
/**
 * About Page - Life Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_life_heading') ?: "A <em class=\"text-gold italic\">Life</em> Built Across Leadership<br>and Transformation.";

$default_text = <<<HTML
<ul>
  <li>Master&rsquo;s in Education &ndash; Harvard University</li>
  <li>Advanced studies in Sustainable Investing &ndash; Harvard Business School</li>
  <li>Six-time founder</li>
  <li>Founded nonprofit and international school in Costa Rica</li>
  <li>President of the National Association of Women Business Owners in Phoenix</li>
</ul>
HTML;

$text = get_field('section_life_text') ?: $default_text;
?>
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-tight">
            <?= $heading ?>
        </h2>

        <div class="mt-12 font-garet text-lg text-dark-text leading-[150%]
                    [&>ul]:list-none [&>ul]:p-0 [&>ul]:m-0 [&>ul]:space-y-4
                    [&_ul_li]:flex [&_ul_li]:items-center [&_ul_li]:justify-center [&_ul_li]:gap-3
                    [&_ul_li]:before:content-[''] [&_ul_li]:before:w-4 [&_ul_li]:before:h-4
                    [&_ul_li]:before:bg-no-repeat [&_ul_li]:before:bg-contain [&_ul_li]:flex-shrink-0
                    [&_ul_li]:before:bg-[url('data:image/svg+xml;utf8,%3Csvg%20xmlns%3D%27http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%27%20viewBox%3D%270%200%2024%2024%27%20fill%3D%27%23d4b478%27%3E%3Cpath%20d%3D%27M12%202L13.5%208.5L20%2010L13.5%2011.5L12%2018L10.5%2011.5L4%2010L10.5%208.5L12%202Z%27%2F%3E%3C%2Fsvg%3E')]">
            <?= wp_kses_post($text) ?>
        </div>
    </div>
</section>
