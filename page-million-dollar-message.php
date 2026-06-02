<?php
/**
 * Template Name: Million Dollar Message
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-million-dollar-message', 'hero'); ?>
    <?php get_template_part('template-parts/section-million-dollar-message', 'inside'); ?>
</main>

<?php
get_footer();
