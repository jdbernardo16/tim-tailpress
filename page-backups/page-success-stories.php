<?php
/**
 * Template Name: Success Stories
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-success-stories', 'hero'); ?>
    <?php get_template_part('template-parts/section-success-stories', 'videos'); ?>
    <?php get_template_part('template-parts/section-success-stories', 'written'); ?>
    <?php get_template_part('template-parts/section-success-stories', 'cta'); ?>
</main>

<?php
get_footer();
