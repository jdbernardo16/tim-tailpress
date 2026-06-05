<?php
/**
 * Template Name: Tell Your Story
 *
 * @package TailPress
 */

get_header();
?>

<main id="main" class="site-main">
    <?php get_template_part('template-parts/section-tell-your-story', 'hero'); ?>
    <?php get_template_part('template-parts/section-tell-your-story', 'speaking'); ?>
    <?php get_template_part('template-parts/section-tell-your-story', 'founding'); ?>
    <?php get_template_part('template-parts/section-tell-your-story', 'carousel'); ?>
    <?php get_template_part('template-parts/section-tell-your-story', 'transformations'); ?>
    <?php get_template_part('template-parts/section-tell-your-story', 'pricing'); ?>
    <?php get_template_part('template-parts/section-tell-your-story', 'faq'); ?>
</main>

<?php
get_template_part('template-parts/section-tell-your-story', 'modal');
get_footer();
