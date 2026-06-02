<?php
/**
 * Template Name: The Speaker
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-the-speaker', 'hero'); ?>
    <?php get_template_part('template-parts/section-the-speaker', 'message'); ?>
    <?php get_template_part('template-parts/section-the-speaker', 'story'); ?>
    <?php get_template_part('template-parts/section-the-speaker', 'breakthrough'); ?>
</main>

<?php
get_footer();
