<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load WordPress header
get_header();

// Capture the requested page from the URL parameter
$page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : 'news-list';

// Include the corresponding template file
switch ($page) {
    case 'news-detail':
        get_template_part('pages/news-detail');
        break;
    case 'column-list':
        get_template_part('pages/column-list');
        break;
    case 'column-detail':
        get_template_part('pages/column-detail');
        break;
    case 'news-list':
    default:
        get_template_part('pages/news-list');
        break;
}
?>

<!-- Navigation Menu -->
<nav>
    <ul>
        <li><a href="?page=news-list">News List</a></li>
        <li><a href="?page=column-list">Column List</a></li>
        <li><a href="?page=column-detail">Column Detail</a></li>
    </ul>
</nav>

<?php
// Load WordPress footer
get_footer();
?>
