<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();

$page = isset($_GET['page']) ? $_GET['page'] : null;

$content = '';

if ($page) {
    switch ($page) {
        case 'news-detail':
            require 'pages/news-detail.php';
            break;
        case 'column-list':
            require 'pages/column-list.php';
            break;
        case 'column-detail':
            require 'pages/column-detail.php';
            break;
        case 'news-list':
        default:
            require 'pages/news-list.php';
            break;
    }
} else {
    $content = '<p>Please select a page from the navigation above.</p>';
}

// Capture the output content
$content .= ob_get_clean();

// Replace the image paths
$image_base_url = get_template_directory_uri() . '/assets/images/';
$content = str_replace('src="../assets/images/', 'src="' . $image_base_url, $content);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $page ? ucfirst(str_replace('-', ' ', $page)) : 'My Site'; ?></title>
    <?php wp_head(); ?>
</head>
<body>
    <!-- Navigation Menu -->
    <nav>
        <ul>
            <li><a href="?page=news-list">News List</a></li>
            <li><a href="?page=news-detail">News Detail</a></li>
            <li><a href="?page=column-list">Column List</a></li>
            <li><a href="?page=column-detail">Column Detail</a></li>
        </ul>
    </nav>

    <!-- Output the modified content -->
    <?php echo $content; ?>
    
    <?php wp_footer(); ?>
</body>
</html>
