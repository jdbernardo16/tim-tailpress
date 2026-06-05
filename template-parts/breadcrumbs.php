<?php

/**
 * Breadcrumb navigation with BreadcrumbList structured data.
 *
 * @package TailPress
 */

if (is_front_page()) {
    return;
}

$items = [
    ['name' => __('Home', 'tailpress'), 'url' => home_url('/')],
];

if (is_singular()) {
    // Hierarchical page ancestors
    if (is_page() && $post = get_post()) {
        $ancestors = array_reverse(get_post_ancestors($post));
        foreach ($ancestors as $ancestor) {
            $items[] = [
                'name' => get_the_title($ancestor),
                'url'  => get_permalink($ancestor),
            ];
        }
    }

    // Non-post CPT archive link
    $post_type = get_post_type_object(get_post_type());
    if ($post_type && $post_type->has_archive && $post_type->name !== 'post') {
        $items[] = [
            'name' => $post_type->labels->name,
            'url'  => get_post_type_archive_link($post_type->name),
        ];
    } elseif (is_singular('post')) {
        $categories = get_the_category();
        if (! empty($categories)) {
            $items[] = [
                'name' => $categories[0]->name,
                'url'  => get_category_link($categories[0]->term_id),
            ];
        }
    }
    $items[] = ['name' => get_the_title()];
} elseif (is_category()) {
    $items[] = ['name' => single_cat_title('', false)];
} elseif (is_tag()) {
    $items[] = ['name' => single_tag_title('', false)];
} elseif (is_author()) {
    $items[] = ['name' => sprintf(__('Posts by %s', 'tailpress'), get_the_author())];
} elseif (is_day()) {
    $items[] = ['name' => get_the_date()];
} elseif (is_month()) {
    $items[] = ['name' => get_the_date('F Y')];
} elseif (is_year()) {
    $items[] = ['name' => get_the_date('Y')];
} elseif (is_search()) {
    $items[] = ['name' => sprintf(__('Search: %s', 'tailpress'), get_search_query())];
} elseif (is_404()) {
    $items[] = ['name' => __('Page Not Found', 'tailpress')];
}
?>

<nav aria-label="<?php esc_attr_e('Breadcrumb', 'tailpress'); ?>" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 text-sm text-zinc-600 hidden">
    <ol class="flex flex-wrap items-center gap-1">
        <?php foreach ($items as $i => $item): ?>
            <li>
                <?php if ($i > 0): ?>
                    <span class="mx-1" aria-hidden="true">/</span>
                <?php endif; ?>
                <?php if (isset($item['url']) && $i < count($items) - 1): ?>
                    <a href="<?php echo esc_url($item['url']); ?>" class="hover:text-navy transition-colors">
                        <?php echo esc_html($item['name']); ?>
                    </a>
                <?php else: ?>
                    <span aria-current="page"><?php echo esc_html($item['name']); ?></span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>

<script type="application/ld+json">
<?php
$json_items = [];
foreach ($items as $i => $item) {
    $json_item = [
        '@type'    => 'ListItem',
        'position' => $i + 1,
        'name'     => $item['name'],
    ];
    if (isset($item['url'])) {
        $json_item['item'] = $item['url'];
    }
    $json_items[] = $json_item;
}

echo wp_json_encode([
    '@context'        => 'https://schema.org',
    '@type'           => 'BreadcrumbList',
    'itemListElement' => $json_items,
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
?>
</script>
