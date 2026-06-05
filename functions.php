<?php

if (is_file(__DIR__.'/vendor/autoload_packages.php')) {
    require_once __DIR__.'/vendor/autoload_packages.php';
}

function tailpress(): TailPress\Framework\Theme
{
    return TailPress\Framework\Theme::instance()
        ->assets(fn($manager) => $manager
            ->withCompiler(new TailPress\Framework\Assets\ViteCompiler, fn($compiler) => $compiler
                ->registerAsset('resources/css/app.css')
                ->registerAsset('resources/js/app.js')
                ->editorStyleFile('resources/css/editor-style.css')
            )
            ->enqueueAssets()
        )
        ->features(fn($manager) => $manager->add(TailPress\Framework\Features\MenuOptions::class))
        ->menus(function ($manager) {
            $manager->add('primary', __('Primary Menu', 'tailpress'));
            $manager->add('header', __('Header Navigation', 'tailpress'));
            $manager->add('footer-offers', __('Footer - Offers', 'tailpress'));
            $manager->add('footer-programs', __('Footer - Programs', 'tailpress'));
            $manager->add('footer-about', __('Footer - About', 'tailpress'));
            $manager->add('footer-connect', __('Footer - Connect', 'tailpress'));
            return $manager;
        })
        ->themeSupport(fn($manager) => $manager->add([
            'title-tag',
            'custom-logo',
            'post-thumbnails',
            'align-wide',
            'wp-block-styles',
            'responsive-embeds',
            'html5' => [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ]
        ]));
}

tailpress();

// Ensure app.js is loaded as a module when using Vite dev server
add_filter('script_loader_tag', function ($tag, $handle) {
    if (str_starts_with($handle, 'tailpress-') && str_ends_with($handle, '-app')) {
        $tag = str_replace('<script ', '<script type="module" ', $tag);
    }
    return $tag;
}, 10, 2);

/**
 * ACF Local JSON — sync field groups to filesystem.
 */
add_filter('acf/settings/save_json', function () {
    return get_template_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
});

/**
 * Allow SVG uploads for theme assets.
 */
add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});

/**
 * Initialize theme SEO (no plugin required).
 */
add_action('after_setup_theme', function () {
    new TailPress\SEO();
});

/**
 * Load seeder (WP-CLI or admin AJAX trigger).
 */
if (defined('WP_CLI') && WP_CLI || is_admin()) {
    require_once get_template_directory() . '/wp-cli/seeder.php';
}
