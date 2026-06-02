<?php
/**
 * Template Name: Front Page
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section', 'hero'); ?>
    <?php get_template_part('template-parts/section', 'trusted'); ?>
    <?php get_template_part('template-parts/section', 'you-know'); ?>
    <?php get_template_part('template-parts/section', 'tell-story'); ?>
    <?php get_template_part('template-parts/section', 'discover'); ?>
    <?php get_template_part('template-parts/section', 'journey'); ?>
    <?php get_template_part('template-parts/section', 'speaker'); ?>
    <?php get_template_part('template-parts/section', 'vault'); ?>
    <?php get_template_part('template-parts/section', 'testimonials'); ?>
    <?php get_template_part('template-parts/section', 'voice'); ?>
</main>

<?php
get_footer();
