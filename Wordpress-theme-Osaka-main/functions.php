<?php
function javo_enqueue_styles_and_scripts() {
    // Enqueue core theme styles
    wp_enqueue_style('main-style', get_stylesheet_uri());
    wp_enqueue_style('layout-style', get_template_directory_uri() . '/assets/styles/main_layout.css');
    wp_enqueue_style('news-detail-style', get_template_directory_uri() . '/assets/style_pages/37-news-detail.css');
     wp_enqueue_script('news-detail-js', get_template_directory_uri() . '/assets/pages-js/37-news-detail.js', array(), null, true);
    // Enqueue scripts and styles conditionally based on the page parameter
    $page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : 'news-list';

    if ($page === 'news-list') {
        wp_enqueue_style('news-list-style', get_template_directory_uri() . '/assets/style_pages/36-news-list.css');
        wp_enqueue_script('news-list-js', get_template_directory_uri() . '/assets/pages-js/36-news-list.js', array(), null, true);
    } elseif ($page === 'news-detail') {
        wp_enqueue_style('news-detail-style', get_template_directory_uri() . '/assets/style_pages/37-news-detail.css');
        wp_enqueue_script('news-detail-js', get_template_directory_uri() . '/assets/pages-js/37-news-detail.js', array(), null, true);
    }
    // Repeat the same pattern for other pages...

    // Enqueue common JS
    wp_enqueue_script('header-js', get_template_directory_uri() . '/js/header.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'javo_enqueue_styles_and_scripts');


function my_theme_enqueue_scripts() {
    wp_enqueue_style('my-style', get_stylesheet_uri());
    wp_enqueue_script('my-script', get_template_directory_uri() . '/js/my-script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');




function create_news_post_type() {
    register_post_type('news', array(
        'labels' => array(
            'name' => __('News'),
            'singular_name' => __('News Item')
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'rewrite' => array('slug' => 'news-p', 'with_front' => false), // Updated slug for permalinks
    ));
}
add_action('init', 'create_news_post_type');

// Custom rewrite rule for news post type
add_action('init', function() {
    add_rewrite_rule('^news-p-([0-9]+)/?$', 'index.php?news=$matches[1]', 'top');
});

// Custom permalink structure for news posts
add_filter('post_type_link', function($post_link, $id) {
    $post = get_post($id);
    if ($post->post_type === 'news') {
        return home_url('news-p-' . $post->ID); // Custom permalink structure
    }
    return $post_link;
}, 10, 2);












