

    <?php get_header(); ?>

    <nav>
        <ul>
            <li><a href="?post_type=news">News List</a></li>
            <li><a href="?post_type=columns">columns List</a></li>

            <li><a href="?page=column-list">Column List</a></li>
            <li><a href="?page=column-detail">Column Detail</a></li>
        </ul>
    </nav>

        <?php
        if (isset($_GET['page'])) {
          $page = $_GET['page'];

          switch ($page) {
            case 'news-list':
              get_template_part('pages/news-list');
              break;

            case 'column-list':
              get_template_part('pages/column-list');
              break;
            case 'column-detail':
              get_template_part('pages/column-detail');
              break;
            default:
              echo '<p>' . __('Page not found.') . '</p>';
              break;
          }
        }
        ?>

    <?php get_footer(); ?>


