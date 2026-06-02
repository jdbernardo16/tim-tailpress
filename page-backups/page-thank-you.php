<?php
/**
 * Template Name: Thank You
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-thank-you', 'hero'); ?>
    <?php get_template_part('template-parts/section-thank-you', 'testimonials'); ?>
</main>

<?php
get_footer();
