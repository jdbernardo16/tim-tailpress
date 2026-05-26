<?php
/**
 * Theme footer template.
 *
 * @package TailPress
 */
?>
        <?php do_action('tailpress_content_end'); ?>
    </main>
    </div>

    <?php do_action('tailpress_content_after'); ?>

    <?php get_template_part('template-parts/footer'); ?>

</div>

<?php wp_footer(); ?>
</body>
</html>
