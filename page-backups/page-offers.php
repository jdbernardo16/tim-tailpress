<?php
/**
 * Template Name: Offers
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-offers', 'hero'); ?>
    <?php get_template_part('template-parts/section-offers', 'signature'); ?>
    <?php get_template_part('template-parts/section-offers', 'other'); ?>
    <?php get_template_part('template-parts/section-offers', 'cta'); ?>
</main>

<?php
get_footer();
