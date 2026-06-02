<?php
/**
 * Template Name: Master My Message
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-master-my-message', 'hero'); ?>
    <?php get_template_part('template-parts/section-master-my-message', 'message'); ?>
    <?php get_template_part('template-parts/section-master-my-message', 'build'); ?>
    <?php get_template_part('template-parts/section-master-my-message', 'distinct'); ?>
    <?php get_template_part('template-parts/section-master-my-message', 'cta'); ?>
</main>

<?php
get_footer();
