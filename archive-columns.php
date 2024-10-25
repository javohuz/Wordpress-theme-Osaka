<?php get_header(); ?>


<!-- column list section stars -->
<div class="title-list-pages container-nl">
  <div class="tl-texts title-1-column ">
    <h1><span><img src="../assets/images/yulduzcha.svg" alt="" /></span></h1>
    <p>COLUMN</p>
  </div>
  <div class="tl-texts title-2-column">
    <h1>COLUMN <span><img src="../assets/images/yulduzcha.svg" alt="" /></span></h1>
    <p>大阪電子専門学校コラム</p>
  </div>

  <div class="tl-link-tags">
    <p>Top</p>
    <p>情報エンジニア科</p>
  </div>
</div>

<section class="column-list-section container-nl">

  <div class="column-list-main-content">

    <?php
    $tags = get_terms(array(
      'taxonomy' => 'post_tag',
      'hide_empty' => true,
    ));

    // Get the current tag from the query parameter
    $current_tag = isset($_GET['tag']) ? sanitize_text_field($_GET['tag']) : '';
    $tags = get_terms(array(
      'taxonomy' => 'post_tag',
      'hide_empty' => true,
      'object_ids' => get_posts(array(
        'post_type' => 'columns',
        'fields' => 'ids',
        'numberposts' => -1 // Get all column post IDs
      )),
    ));

    if ($tags) {
      echo '<div class="column-list-links-top">';
      echo '<a href="' . esc_url(get_post_type_archive_link('columns')) . '" class=" lpr-link-btn ' . (!$current_tag ? 'bg-black' : '') . '">すべて</a>'; // 'All' button
    
      foreach ($tags as $tag) {
        // Check if this tag is the current tag
        $active_class = ($current_tag === $tag->slug) ? 'bg-black' : '';
        $is_important = get_term_meta($tag->term_id, 'is_important', true);
        if ($is_important) {
          $active_class .= ' bg-red';
        }
        echo '<a href="' . esc_url(add_query_arg('tag', $tag->slug, get_post_type_archive_link('columns'))) . '" class=" lpr-link-btn ' . esc_attr($active_class) . '">' . esc_html($tag->name) . '</a>';
      }
      echo '</div>';
    }
    ?>


    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    // Check if a tag is set in the query parameter
    $tag = isset($_GET['tag']) ? sanitize_text_field($_GET['tag']) : '';

    // Check if a filter date is set
    $filter_date = isset($_GET['filter_date']) ? sanitize_text_field($_GET['filter_date']) : '';

    // Build query arguments
    $args = array(
      'post_type' => 'columns',
      'posts_per_page' => 10,
      'paged' => $paged,
    );

    // If a tag is specified, modify the query to include it
    if ($tag) {
      $args['tax_query'] = array(
        array(
          'taxonomy' => 'post_tag',
          'field' => 'slug',
          'terms' => $tag,
        ),
      );
    }

    // If a filter date is specified, add a date query
    if ($filter_date) {
      $args['date_query'] = array(
        array(
          'after' => $filter_date,
          'inclusive' => true,
        ),
      );
    }

    $columns_query = new WP_Query($args);

    if ($columns_query->have_posts()): ?>
      <div class="column-list-items contener-clp">
        <?php while ($columns_query->have_posts()):
          $columns_query->the_post();
          $top_image = get_post_meta(get_the_ID(), '_top_image', true); 

          ?>
          <div class="column-list-item">
            <a href="<?php the_permalink(); ?>" class="cl-img-box">
            <img src="<?php echo esc_url($top_image); ?>" alt="<?php the_title(); ?>">
            </a>
            <div class="cl-content-section">
              <div class="column-list-texts-top">
                <span><?php echo get_the_date('Y.m.d'); ?></span>
                <div class="cl-contente-tag-links">
                  <?php
                  // Get the tags for the current post
                  $post_tags = get_the_tags();
                  if ($post_tags) {
                    foreach ($post_tags as $tag) {
                      // Check if the tag is important
                      $is_important = get_term_meta($tag->term_id, 'is_important', true);
                      $important_class = $is_important ? 'item-bg-red' : '';
                      echo '<a href="' . esc_url(add_query_arg('tag', $tag->slug)) . '" class="tag-link ' . esc_attr($important_class) . '">' . esc_html($tag->name) . '</a> ';
                    }
                  }
                  ?>
                </div>
              </div>
              <a class="cl-text-content" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </div>
          </div>
        <?php endwhile; ?>
      </div>


      <div class="pagination">
        <?php
        $total_pages = $columns_query->max_num_pages;
        $links = [];
        if ($total_pages > 1) {
          // Check if there's a previous page
          if ($paged > 1) {
            echo '<a href="' . get_previous_posts_page_link() . '" class="prev active">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <path
                                  d="M14.8233 6.31712C14.723 6.21659 14.6039 6.13684 14.4727 6.08242C14.3415 6.02801 14.2009 6 14.0589 6C13.9168 6 13.7762 6.02801 13.645 6.08242C13.5139 6.13684 13.3947 6.21659 13.2944 6.31712L8.31712 11.2944C8.21659 11.3947 8.13684 11.5139 8.08242 11.645C8.02801 11.7762 8 11.9168 8 12.0589C8 12.2009 8.02801 12.3415 8.08242 12.4727C8.13684 12.6039 8.21659 12.723 8.31712 12.8233L13.2944 17.8006C13.3948 17.901 13.514 17.9806 13.6451 18.035C13.7763 18.0893 13.9169 18.1173 14.0589 18.1173C14.2008 18.1173 14.3414 18.0893 14.4726 18.035C14.6038 17.9806 14.7229 17.901 14.8233 17.8006C14.9237 17.7002 15.0034 17.581 15.0577 17.4499C15.112 17.3187 15.14 17.1781 15.14 17.0361C15.14 16.8941 15.112 16.7536 15.0577 16.6224C15.0034 16.4912 14.9237 16.372 14.8233 16.2716L10.616 12.0534L14.8233 7.84608C15.2462 7.42318 15.2354 6.72918 14.8233 6.31712Z"
                                  fill="#001E62" />
                          </svg>
                          </a>';
          } else {
            echo '<a class="prev">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path
                                d="M14.8233 6.31712C14.723 6.21659 14.6039 6.13684 14.4727 6.08242C14.3415 6.02801 14.2009 6 14.0589 6C13.9168 6 13.7762 6.02801 13.645 6.08242C13.5139 6.13684 13.3947 6.21659 13.2944 6.31712L8.31712 11.2944C8.21659 11.3947 8.13684 11.5139 8.08242 11.645C8.02801 11.7762 8 11.9168 8 12.0589C8 12.2009 8.02801 12.3415 8.08242 12.4727C8.13684 12.6039 8.21659 12.723 8.31712 12.8233L13.2944 17.8006C13.3948 17.901 13.514 17.9806 13.6451 18.035C13.7763 18.0893 13.9169 18.1173 14.0589 18.1173C14.2008 18.1173 14.3414 18.0893 14.4726 18.035C14.6038 17.9806 14.7229 17.901 14.8233 17.8006C14.9237 17.7002 15.0034 17.581 15.0577 17.4499C15.112 17.3187 15.14 17.1781 15.14 17.0361C15.14 16.8941 15.112 16.7536 15.0577 16.6224C15.0034 16.4912 14.9237 16.372 14.8233 16.2716L10.616 12.0534L14.8233 7.84608C15.2462 7.42318 15.2354 6.72918 14.8233 6.31712Z"
                                fill="#001E62" />
                        </svg>
                        </a>';
          }

          // Pagination links
      

          // Create the pagination logic
          if ($total_pages > 1) {
            $start = max(1, $paged - 2);
            $end = min($total_pages, $paged + 3);

            if ($start > 1) {
              $links[] = '<a href="' . get_pagenum_link(1) . '" class="case-page">1</a>';
              if ($start > 2) {
                $links[] = '<p class="case-page">...</p>';
              }
            }

            for ($i = $start; $i <= $end; $i++) {
              if ($i == $paged) {
                $links[] = '<a href="#" class="case-page active">' . $i . '</a>';
              } else {
                $links[] = '<a href="' . get_pagenum_link($i) . '" class="case-page">' . $i . '</a>';
              }
            }

            if ($end < $total_pages) {
              if ($end < $total_pages - 1) {
                $links[] = '<p class="case-page">...</p>';
              }
              $links[] = '<a href="' . get_pagenum_link($total_pages) . '" class="case-page">' . $total_pages . '</a>';
            }
          }

          // Output the links
          echo implode('', $links);

          // Check if there's a next page
          if ($paged < $total_pages) {
            echo '<a href="' . get_next_posts_page_link() . '" class="next active">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <path
                                  d="M9.17666 17.6829C9.27698 17.7834 9.39614 17.8632 9.52732 17.9176C9.6585 17.972 9.79912 18 9.94114 18C10.0832 18 10.2238 17.972 10.355 17.9176C10.4861 17.8632 10.6053 17.7834 10.7056 17.6829L15.6829 12.7056C15.7834 12.6053 15.8632 12.4861 15.9176 12.355C15.972 12.2238 16 12.0832 16 11.9411C16 11.7991 15.972 11.6585 15.9176 11.5273C15.8632 11.3961 15.7834 11.277 15.6829 11.1767L10.7056 6.1994C10.6052 6.099 10.486 6.01937 10.3549 5.96503C10.2237 5.9107 10.0831 5.88274 9.94114 5.88274C9.79916 5.88274 9.65858 5.9107 9.52741 5.96503C9.39624 6.01937 9.27705 6.099 9.17666 6.1994C9.07627 6.29979 8.99663 6.41897 8.9423 6.55014C8.88797 6.68131 8.86 6.8219 8.86 6.96388C8.86 7.10585 8.88797 7.24644 8.9423 7.37761C8.99663 7.50878 9.07627 7.62796 9.17666 7.72836L13.384 11.9466L9.17666 16.1539C8.75375 16.5768 8.7646 17.2708 9.17666 17.6829Z"
                                  fill="#001E62" />
                          </svg>
                          </a>';
          } else {
            echo '<a class="next ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <path
                                  d="M9.17666 17.6829C9.27698 17.7834 9.39614 17.8632 9.52732 17.9176C9.6585 17.972 9.79912 18 9.94114 18C10.0832 18 10.2238 17.972 10.355 17.9176C10.4861 17.8632 10.6053 17.7834 10.7056 17.6829L15.6829 12.7056C15.7834 12.6053 15.8632 12.4861 15.9176 12.355C15.972 12.2238 16 12.0832 16 11.9411C16 11.7991 15.972 11.6585 15.9176 11.5273C15.8632 11.3961 15.7834 11.277 15.6829 11.1767L10.7056 6.1994C10.6052 6.099 10.486 6.01937 10.3549 5.96503C10.2237 5.9107 10.0831 5.88274 9.94114 5.88274C9.79916 5.88274 9.65858 5.9107 9.52741 5.96503C9.39624 6.01937 9.27705 6.099 9.17666 6.1994C9.07627 6.29979 8.99663 6.41897 8.9423 6.55014C8.88797 6.68131 8.86 6.8219 8.86 6.96388C8.86 7.10585 8.88797 7.24644 8.9423 7.37761C8.99663 7.50878 9.07627 7.62796 9.17666 7.72836L13.384 11.9466L9.17666 16.1539C8.75375 16.5768 8.7646 17.2708 9.17666 17.6829Z"
                                    fill="#001E62" />
                        </svg>
                      </a>';
          }
        }
        ?>
      </div>



    <?php else: ?>
      <p><?php _e('No coulmn  found.'); ?></p>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>





  </div>

  <div class="list-pages-right">
    <div class="lpr-item">
      <p>Tags</p>
      <div class="lpr-item-links" id="tagContainer">
        <?php
        // Get the current tag from the query parameter
        $current_tag = isset($_GET['tag']) ? sanitize_text_field($_GET['tag']) : '';

        // Fetch tags used in columns posts
        $tags = get_terms(array(
          'taxonomy' => 'post_tag',
          'hide_empty' => true,
          'object_ids' => get_posts(array(
            'post_type' => 'columns',
            'fields' => 'ids',
            'numberposts' => -1 // Get all column post IDs
          )),
        ));

        if ($tags) {
          echo '<div class="lpr-item-links">';
          echo '<a href="' . esc_url(get_post_type_archive_link('columns')) . '" class="lpr-link-btn ' . (!$current_tag ? 'bg-black' : '') . '">すべて</a>'; // 'All' button
        
          foreach ($tags as $tag) {
            // Check if this tag is the current tag
            $active_class = ($current_tag === $tag->slug) ? 'bg-black' : '';
            $is_important = get_term_meta($tag->term_id, 'is_important', true);
            if ($is_important) {
              $active_class = 'bg-red';
            }
            echo '<a href="' . esc_url(add_query_arg('tag', $tag->slug, get_post_type_archive_link('columns'))) . '" class="lpr-link-btn ' . esc_attr($active_class) . '">' . esc_html($tag->name) . '</a>';
          }
          echo '</div>';
        }
        ?>


      </div>
      <button id="showMoreBtn">もっと見る
        <span>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M7 10L12.0008 14.58L17 10" stroke="#0A090B" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </span>
      </button>
    </div>

    <div class="lpr-item">
      <p>ARCHIVE</p>
      <div class="archive-items" id="archiveItems" style="display:none;">

        <a href="<?php echo add_query_arg('filter_date', '2024-01-01', get_post_type_archive_link('columns')); ?>"
          class="lpr-link-btn">2024</a>
        <a href="<?php echo add_query_arg('filter_date', '2023-01-01', get_post_type_archive_link('columns')); ?>"
          class="lpr-link-btn">2023</a>
        <a href="<?php echo add_query_arg('filter_date', '2022-01-01', get_post_type_archive_link('columns')); ?>"
          class="lpr-link-btn">2022</a>

      </div>

      <div class="lpr-item-links">
        <a class="lpr-drop-down" role="button" tabindex="0">
          <p>選択してください</p>
          <span>
            <svg class="dropdown-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
              fill="none">
              <path d="M7 10L12.0008 14.58L17 10" stroke="#0A090B" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
          </span>
        </a>
      </div>
    </div>

  </div>

</section>


<!-- Column  list section finished -->

<!-- two cards starts -->
<!-- <section class="two_cards for_phone">
  <div class="tc_wrapper">

    <a class="kard" id="bir">

      <div class="in_kard">
        <div class="taytl">
          <div class="op_tit">
            <h2>Entry & Scholarship</h2>
          </div>
          <div class="nop_tit">
            <h2>入学・学費案内</h2>
          </div>
        </div>
        <div class="xtxs">
          <p>
            入学制度は一人ひとりのバックグラウンドに応じて<br />多様なニーズに沿ったシステムを用意しています。
          </p>
        </div>
      </div>

      <div class="plus-button-tc-box">
        <div class="plus-sign-tc horizontal-tc"></div>
        <div class="plus-sign-tc vertical-tc"></div>
      </div>
    </a>

    <a class="kard" id="ikki">
      <div class="in_kard">
        <div class="taytl">
          <div class="op_tit">
            <h2>School Guide Book</h2>
          </div>
          <div class="nop_tit">
            <h2>資料請求</h2>
          </div>
        </div>
        <div class="xtxs">
          <p>
            無料でパンフレットをお届け！ご希望の学科に関する詳細情報を確認できます。 資料請求はこちらから。
          </p>
          <div class="image">
            <img src="../assets/images/manga.svg" alt="Manga Illustration" />
          </div>
        </div>
      </div>
      <div class="plus-button-tc-box">
        <div class="plus-sign-tc horizontal-tc"></div>
        <div class="plus-sign-tc vertical-tc"></div>
      </div>
    </a>
  </div>
</section> -->

<!-- two cards ends -->


<?php get_footer(); ?>