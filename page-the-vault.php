<?php
/**
 * Template Name: The Vault
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-the-vault', 'hero'); ?>
    <?php get_template_part('template-parts/section-the-vault', 'what-is'); ?>
    <?php get_template_part('template-parts/section-the-vault', 'what-happens'); ?>
    <?php get_template_part('template-parts/section-the-vault', 'registration'); ?>
</main>

<?php
get_footer();
