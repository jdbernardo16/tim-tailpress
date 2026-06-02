<?php
/**
 * Template Name: Be Remembered
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-be-remembered', 'hero'); ?>
    <?php get_template_part('template-parts/section-be-remembered', 'message'); ?>
    <?php get_template_part('template-parts/section-be-remembered', 'build'); ?>
    <?php get_template_part('template-parts/section-be-remembered', 'distinct'); ?>
    <?php get_template_part('template-parts/section-be-remembered', 'cta'); ?>
    <?php get_template_part('template-parts/section-be-remembered', 'form'); ?>
</main>

<?php
get_footer();
