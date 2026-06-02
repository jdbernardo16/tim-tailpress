<?php
/**
 * Template Name: Breakthrough Session
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-breakthrough-session', 'hero'); ?>
    <?php get_template_part('template-parts/section-breakthrough-session', 'message'); ?>
    <?php get_template_part('template-parts/section-breakthrough-session', 'build'); ?>
    <?php get_template_part('template-parts/section-breakthrough-session', 'cta'); ?>
</main>

<?php
get_footer();
