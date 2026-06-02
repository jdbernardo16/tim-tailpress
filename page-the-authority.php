<?php
/**
 * Template Name: The Authority
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-the-authority', 'hero'); ?>
    <?php get_template_part('template-parts/section-the-authority', 'message'); ?>
    <?php get_template_part('template-parts/section-the-authority', 'two-ways'); ?>
    <?php get_template_part('template-parts/section-the-authority', 'work'); ?>
</main>

<?php
get_footer();
