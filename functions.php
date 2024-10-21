<?php
function javo_test_theme_enqueue_styles() {
    // Enqueue main theme stylesheet
    wp_enqueue_style('main-style', get_stylesheet_uri());

    // Additional stylesheets
    wp_enqueue_style('layout-style', get_template_directory_uri() . '/assets/styles/main_layout.css');
    wp_enqueue_style('footer-style', get_template_directory_uri() . '/assets/styles/footer.css');
    wp_enqueue_style('header-style', get_template_directory_uri() . '/assets/styles/header.css');
    wp_enqueue_style('root-style', get_template_directory_uri() . '/assets/styles/root_javo.css');

    // Get the current page from the URL parameter
    $page = isset($_GET['page']) ? $_GET['page'] : null;

    // Conditionally enqueue styles based on the current page
    if ($page === 'news-list') {
        wp_enqueue_style('news-list-style', get_template_directory_uri() . '/assets/style_pages/36-news-list.css');
    } elseif ($page === 'news-detail') {
        wp_enqueue_style('news-detail-style', get_template_directory_uri() . '/assets/style_pages/37-news-detail.css');
    } elseif ($page === 'column-list') {
        wp_enqueue_style('column-list-style', get_template_directory_uri() . '/assets/style_pages/38-column-list.css');
    } elseif ($page === 'column-detail') {
        wp_enqueue_style('column-detail-style', get_template_directory_uri() . '/assets/style_pages/39-column-detail.css');
    }

    // Enqueue common JavaScript files
    wp_enqueue_script('header-js', get_template_directory_uri() . '/js/header.js', array(), null, true);

    // Conditionally enqueue scripts based on the current page
    if ($page === 'news-list') {
        wp_enqueue_script('news-list-js', get_template_directory_uri() . '/assets/pages-js/36-news-list.js', array(), null, true);
    } elseif ($page === 'news-detail') {
        wp_enqueue_script('news-detail-js', get_template_directory_uri() . '/assets/pages-js/37-news-detail.js', array(), null, true);
    } elseif ($page === 'column-list') {
        wp_enqueue_script('column-list-js', get_template_directory_uri() . '/assets/pages-js/38-column-list.js', array(), null, true);
    } elseif ($page === 'column-detail') {
        wp_enqueue_script('column-detail-js', get_template_directory_uri() . '/assets/pages-js/39-column-detail.js', array(), null, true);
    }
}
add_action('wp_enqueue_scripts', 'javo_test_theme_enqueue_styles');
?>
