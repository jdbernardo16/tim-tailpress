<?php

/**
 * Site header template part.
 *
 * @package TailPress
 */
?>

<header class="fixed top-0 left-0 right-0 z-50 py-3 sm:py-6 transition-all duration-300" id="site-header">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center shrink-0">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/logos/logo.webp" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="w-14 h-14">
        </a>

        <nav class="hidden lg:flex items-center gap-6" aria-label="<?php esc_attr_e('Primary Navigation', 'tailpress'); ?>">
            <?php
            wp_nav_menu([
                'theme_location' => 'header',
                'container' => false,
                'menu_class' => 'flex items-center gap-6',
                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'depth' => 2,
                'fallback_cb' => false,
                'walker' => new \TailPress\Walkers\HeaderNavWalker(),
            ]);
            ?>
        </nav>

        <a href="<?php echo esc_url(home_url('/get-started/')); ?>" class="btn-primary py-3 hidden lg:inline-flex">
            <?php esc_html_e('GET STARTED', 'tailpress'); ?>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        </a>

        <button type="button" id="header-mobile-toggle" class="lg:hidden text-white p-2 focus-visible:outline-2 focus-visible:outline-gold focus-visible:outline-offset-2 rounded" aria-label="<?php esc_attr_e('Toggle navigation', 'tailpress'); ?>" aria-expanded="false" aria-controls="header-mobile-menu">
            <svg id="header-mobile-toggle-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <svg id="header-mobile-toggle-close" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hidden">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</header>

<div id="header-mobile-menu" class="hidden lg:hidden bg-navy fixed inset-0 z-50 pt-24 overflow-y-auto" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e('Mobile menu', 'tailpress'); ?>">
    <button type="button" id="header-mobile-close" class="absolute top-6 right-4 w-9 h-9 flex items-center justify-center text-white/80 hover:text-white transition-colors" aria-label="<?php esc_attr_e('Close navigation', 'tailpress'); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <div class="min-h-full flex flex-col px-6 pb-8">
        <?php
        wp_nav_menu([
            'theme_location' => 'header',
            'container' => false,
            'menu_class' => 'flex flex-col gap-2',
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth' => 2,
            'fallback_cb' => false,
            'walker' => new \TailPress\Walkers\HeaderNavWalker(),
        ]);
        ?>

        <div class="mt-auto pt-8">
            <a href="<?php echo esc_url(home_url('/get-started/')); ?>" class="btn-primary w-full py-4">
                <?php esc_html_e('GET STARTED', 'tailpress'); ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>
    </div>
</div>
