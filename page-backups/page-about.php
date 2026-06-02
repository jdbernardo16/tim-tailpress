<?php
/**
 * Template Name: About
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-about', 'hero'); ?>
    <?php get_template_part('template-parts/section-about', 'leader'); ?>
    <?php get_template_part('template-parts/section-about', 'meaning'); ?>
    <?php get_template_part('template-parts/section-about', 'life'); ?>
    <?php get_template_part('template-parts/section-about', 'reconnect'); ?>
    <?php get_template_part('template-parts/section-about', 'voice'); ?>
</main>

<?php
get_footer();
