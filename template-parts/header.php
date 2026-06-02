<?php

/**
 * Site header template part.
 *
 * @package TailPress
 */
?>

<header class="fixed top-0 left-0 right-0 z-50 py-6 transition-all duration-300" id="site-header">
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
                'items_wrap' => '%3$s',
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

        <button type="button" id="header-mobile-toggle" class="lg:hidden text-white p-2" aria-label="<?php esc_attr_e('Toggle navigation', 'tailpress'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
    </div>

    <div id="header-mobile-menu" class="hidden lg:hidden bg-navy/95 absolute top-full left-0 right-0">
        <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col gap-4">
            <?php
            wp_nav_menu([
                'theme_location' => 'header',
                'container' => false,
                'menu_class' => 'flex flex-col gap-4',
                'items_wrap' => '%3$s',
                'depth' => 1,
                'fallback_cb' => false,
                'walker' => new \TailPress\Walkers\HeaderNavWalker(),
            ]);
            ?>
        </div>
    </div>
</header>

<?php if (has_nav_menu('primary')) : ?>
    <script>
        (function() {
            var toggle = document.getElementById('header-mobile-toggle');
            var menu = document.getElementById('header-mobile-menu');
            if (toggle && menu) {
                toggle.addEventListener('click', function() {
                    menu.classList.toggle('hidden');
                });
            }
        })();
    </script>
<?php endif; ?>

<script>
(function() {
    var header = document.getElementById('site-header');
    if (!header) return;

    function updateHeader() {
        if (window.scrollY > 10) {
            header.classList.add('bg-navy/95', 'backdrop-blur-sm');
        } else {
            header.classList.remove('bg-navy/95', 'backdrop-blur-sm');
        }
    }

    window.addEventListener('scroll', updateHeader);
    updateHeader();
})();
</script>
