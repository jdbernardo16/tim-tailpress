<?php

/**
 * Template Name: On Stage
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-onstage', 'hero'); ?>
    <?php get_template_part('template-parts/section-onstage', 'video'); ?>
    <?php get_template_part('template-parts/section-onstage', 'credibility'); ?>
    <?php get_template_part('template-parts/section-onstage', 'experiences'); ?>
    <?php get_template_part('template-parts/section-onstage', 'book'); ?>
    <?php get_template_part('template-parts/section-onstage', 'download'); ?>
</main>

<?php
get_footer();
