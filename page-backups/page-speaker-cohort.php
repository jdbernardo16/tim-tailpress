<?php
/**
 * Template Name: Speaker Cohort
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-speaker-cohort', 'hero'); ?>
    <?php get_template_part('template-parts/section-speaker-cohort', 'message'); ?>
    <?php get_template_part('template-parts/section-speaker-cohort', 'build'); ?>
    <?php get_template_part('template-parts/section-speaker-cohort', 'speaking'); ?>
    <?php get_template_part('template-parts/section-speaker-cohort', 'cta'); ?>
</main>

<?php
get_footer();
