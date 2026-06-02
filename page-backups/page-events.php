<?php
/**
 * Template Name: Events and Workshops
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-events', 'hero'); ?>
    <?php get_template_part('template-parts/section-events', 'retreat'); ?>
    <?php get_template_part('template-parts/section-events', 'upcoming'); ?>
    <?php get_template_part('template-parts/section-events', 'features'); ?>
    <?php get_template_part('template-parts/section-events', 'cta'); ?>
</main>

<?php
get_footer();
