<?php

namespace TailPress;

class SEO
{
    public function __construct()
    {
        add_action('wp_head', [$this, 'output_meta_tags'], 5);
        add_action('wp_footer', [$this, 'output_json_ld'], 100);
        add_action('tailpress_content_start', [$this, 'maybe_output_breadcrumbs']);
        add_action('init', [$this, 'register_acf_fields']);
    }

    public function register_acf_fields(): void
    {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        acf_add_local_field_group([
            'key' => 'group_seo',
            'title' => 'SEO Settings',
            'fields' => [
                [
                    'key' => 'field_seo_meta_description',
                    'label' => 'Meta Description',
                    'name' => 'seo_meta_description',
                    'type' => 'textarea',
                    'instructions' => 'Enter a meta description between 120–160 characters for optimal search engine display.',
                    'rows' => 2,
                    'maxlength' => 160,
                    'new_lines' => '',
                ],
                [
                    'key' => 'field_seo_robots',
                    'label' => 'Robots Meta',
                    'name' => 'seo_robots',
                    'type' => 'select',
                    'instructions' => 'Control search engine indexing for this page.',
                    'choices' => [
                        '' => 'Index, Follow',
                        'noindex' => 'No Index, No Follow',
                    ],
                    'default_value' => '',
                    'allow_null' => false,
                    'multiple' => false,
                ],
                [
                    'key' => 'field_seo_og_image',
                    'label' => 'OG Image',
                    'name' => 'seo_og_image',
                    'type' => 'image',
                    'instructions' => 'Recommended size: 1200×630px for optimal social sharing previews.',
                    'return_format' => 'url',
                    'preview_size' => 'medium',
                    'library' => 'all',
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'post',
                    ],
                ],
                [
                    [
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'page',
                    ],
                ],
            ],
            'menu_order' => 0,
            'position' => 'side',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
        ]);
    }

    private function get_description(): string
    {
        $description = '';

        if (is_singular()) {
            $description = function_exists('get_field') ? get_field('seo_meta_description', get_the_ID()) : '';

            if (empty($description)) {
                $post = get_post();
                if (!empty($post->post_excerpt)) {
                    $description = $post->post_excerpt;
                } elseif (!empty($post->post_content)) {
                    $description = wp_trim_words(wp_strip_all_tags($post->post_content), 30);
                }
            }
        }

        if (empty($description) && (is_category() || is_tag() || is_tax())) {
            $description = category_description();
        }

        if (empty($description)) {
            $description = get_bloginfo('description');
        }

        return wp_strip_all_tags($description);
    }

    private function get_og_image(): string
    {
        $image = '';

        if (is_singular()) {
            // Use get_field() for proper ACF return format handling (URL)
            if (function_exists('get_field')) {
                $image = get_field('seo_og_image', get_the_ID());
            }

            if (empty($image) && has_post_thumbnail()) {
                $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
                if (!empty($thumbnail)) {
                    $image = $thumbnail[0];
                }
            }
        }

        if (empty($image)) {
            $custom_logo_id = get_theme_mod('custom_logo');
            if ($custom_logo_id) {
                $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                if (!empty($logo)) {
                    $image = $logo[0];
                }
            }
        }

        if (empty($image)) {
            $image = get_template_directory_uri() . '/assets/images/logos/logo.webp';
        }

        return $image;
    }

    private function get_organization_logo(): string
    {
        // Organization logo should be the brand logo, not a social preview image
        $custom_logo_id = get_theme_mod('custom_logo');
        if ($custom_logo_id) {
            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            if (!empty($logo)) {
                return $logo[0];
            }
        }

        return get_template_directory_uri() . '/assets/images/logos/logo.webp';
    }

    private function get_canonical(): string
    {
        if (is_singular()) {
            $canonical = wp_get_canonical_url();
            if (!empty($canonical)) {
                return $canonical;
            }
            return get_permalink();
        }

        if (is_front_page() || is_home()) {
            return home_url('/');
        }

        if (is_archive()) {
            $paged = max(1, absint(get_query_var('paged')));
            return get_pagenum_link($paged);
        }

        // Fallback: reconstruct current URL via WordPress-safe method
        global $wp;
        if (!empty($wp->request)) {
            return home_url($wp->request);
        }
        return home_url('/');
    }

    public function output_meta_tags(): void
    {
        $description = $this->get_description();

        if (!empty($description)) {
            printf(
                '<meta name="description" content="%s">' . "\n",
                esc_attr($description)
            );
        }

        $robots = 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1';

        if (is_singular()) {
            $seo_robots = function_exists('get_field') ? get_field('seo_robots', get_the_ID()) : '';
            if ($seo_robots === 'noindex') {
                $robots = 'noindex, nofollow';
            }
        }

        if (is_search() || is_404()) {
            $robots = 'noindex, follow';
        }

        printf(
            '<meta name="robots" content="%s">' . "\n",
            esc_attr($robots)
        );

        $canonical = $this->get_canonical();
        if (!empty($canonical)) {
            printf(
                '<link rel="canonical" href="%s">' . "\n",
                esc_url($canonical)
            );
        }

        $title = wp_get_document_title();
        $og_type = is_singular('post') ? 'article' : 'website';
        $og_image = $this->get_og_image();

        printf('<meta property="og:title" content="%s">' . "\n", esc_attr($title));
        if (!empty($description)) {
            printf('<meta property="og:description" content="%s">' . "\n", esc_attr($description));
        }
        printf('<meta property="og:url" content="%s">' . "\n", esc_url($canonical));
        if (!empty($og_image)) {
            printf('<meta property="og:image" content="%s">' . "\n", esc_url($og_image));
        }
        printf('<meta property="og:type" content="%s">' . "\n", esc_attr($og_type));
        printf('<meta property="og:locale" content="%s">' . "\n", esc_attr(get_locale()));
        printf('<meta property="og:site_name" content="%s">' . "\n", esc_attr(get_bloginfo('name')));

        printf('<meta name="twitter:card" content="%s">' . "\n", 'summary_large_image');
        printf('<meta name="twitter:title" content="%s">' . "\n", esc_attr($title));
        if (!empty($description)) {
            printf('<meta name="twitter:description" content="%s">' . "\n", esc_attr($description));
        }
        if (!empty($og_image)) {
            printf('<meta name="twitter:image" content="%s">' . "\n", esc_url($og_image));
        }
    }

    public function output_json_ld(): void
    {
        $site_name = get_bloginfo('name');
        $site_url = home_url('/');
        $description = $this->get_description();
        $logo = $this->get_organization_logo();

        $organization = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $site_name,
            'url' => $site_url,
            'logo' => $logo,
            'description' => $description,
            'sameAs' => [
                'https://www.linkedin.com/in/joannahortonmcpherson/',
                'https://www.instagram.com/joannahortonmcpherson/',
                'https://www.facebook.com/joannahortonmcpherson/',
            ],
        ];

        printf(
            '<script type="application/ld+json">' . "\n%s\n" . '</script>' . "\n",
            wp_json_encode($organization, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
        );

        $person = [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => 'Joanna Horton McPherson',
            'jobTitle' => 'Private Advisor | Master Coach',
            'url' => $site_url,
            'sameAs' => [
                'https://www.linkedin.com/in/joannahortonmcpherson/',
                'https://www.instagram.com/joannahortonmcpherson/',
                'https://www.facebook.com/joannahortonmcpherson/',
            ],
        ];

        printf(
            '<script type="application/ld+json">' . "\n%s\n" . '</script>' . "\n",
            wp_json_encode($person, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
        );

        if (is_singular('post')) {
            $post = get_post();
            $article = [
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => get_the_title(),
                'description' => $description,
                'datePublished' => get_the_date('c'),
                'dateModified' => get_the_modified_date('c'),
                'author' => [
                    '@type' => 'Person',
                    'name' => get_the_author(),
                ],
            ];

            if (has_post_thumbnail()) {
                $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                if (!empty($thumbnail)) {
                    $article['image'] = $thumbnail[0];
                }
            }

            printf(
                '<script type="application/ld+json">' . "\n%s\n" . '</script>' . "\n",
                wp_json_encode($article, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
            );
        }
    }

    public function maybe_output_breadcrumbs(): void
    {
        if (is_front_page()) {
            return;
        }

        get_template_part('template-parts/breadcrumbs');
    }
}
