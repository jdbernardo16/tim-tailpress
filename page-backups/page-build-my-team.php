<?php
/**
 * Template Name: Build My Team
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-build-my-team', 'hero'); ?>
    <?php get_template_part('template-parts/section-build-my-team', 'message'); ?>
    <?php get_template_part('template-parts/section-build-my-team', 'build'); ?>
    <?php get_template_part('template-parts/section-build-my-team', 'distinct'); ?>
    <?php get_template_part('template-parts/section-build-my-team', 'cta'); ?>
    <?php get_template_part('template-parts/section-build-my-team', 'form'); ?>
</main>

<?php
get_footer();
