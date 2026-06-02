<?php
/**
 * Template Name: The Legacy
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-the-legacy', 'hero'); ?>
    <?php get_template_part('template-parts/section-the-legacy', 'message'); ?>
    <?php get_template_part('template-parts/section-the-legacy', 'two-ways'); ?>
</main>

<?php
get_footer();
