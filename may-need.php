<div class="pagination">
                <a href="<?php echo get_previous_posts_page_link(); ?>" class="prev">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path
                      d="ignore inside "
                      fill="#001E62" />
                  </svg>
                </a>

                <?php
                // Pagination links
                $big = 999999999; // an unlikely integer
                echo paginate_links(array(
                  'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))), 
                  'format' => '?paged=%#%',
                  'current' => $paged,
                  'total' => $news_query->max_num_pages,
                  'prev_text' => '',
                  'next_text' => '',
                  'mid_size' => 1,
                  'type' => 'array',
                ));
                ?>

                <a href="<?php echo get_next_posts_page_link(); ?>" class="next">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path
                      d="ignore insede "
                      fill="#001E62" />
                  </svg>
                </a>
              </div>












              <?php get_header(); ?>





<!-- news list section stars -->

<div class="title-list-pages container-nl">
  <div class="tl-texts title-1-news">
    <h1><span><svg xmlns="http://www.w3.org/2000/svg" fill="#7cabf7" class="bi bi-chat-fill" viewBox="0 0 16 16"
          id="Chat-Fill--Streamline-Bootstrap" height="60" width="60">
          <desc>Chat Fill Streamline Icon: https://streamlinehq.com</desc>
          <path
            d="M8 14.4037C12.3296 14.4037 15.84 11.3324 15.84 7.5437S12.3296 0.6837 8 0.6837S0.16 3.755 0.16 7.5437C0.16 9.2685 0.8881 10.8463 2.0906 12.0517C1.9955 13.0474 1.6819 14.1391 1.335 14.9584C1.2576 15.1406 1.4075 15.3445 1.6026 15.3131C3.8134 14.9505 5.1276 14.3939 5.699 14.1038C6.4494 14.3047 7.2231 14.4055 8 14.4037"
            stroke-width="1"></path>
        </svg></span></h1>
    <p>大阪電子専門学校からのお知らせ</p>
  </div>
  <div class="tl-texts title-2-news">
    <h1>NEWS <span><svg xmlns="http://www.w3.org/2000/svg" fill="#7cabf7" class="bi bi-chat-fill" viewBox="0 0 16 16"
          id="Chat-Fill--Streamline-Bootstrap" height="24" width="24">
          <desc>Chat Fill Streamline Icon: https://streamlinehq.com</desc>
          <path
            d="M8 14.4037C12.3296 14.4037 15.84 11.3324 15.84 7.5437S12.3296 0.6837 8 0.6837S0.16 3.755 0.16 7.5437C0.16 9.2685 0.8881 10.8463 2.0906 12.0517C1.9955 13.0474 1.6819 14.1391 1.335 14.9584C1.2576 15.1406 1.4075 15.3445 1.6026 15.3131C3.8134 14.9505 5.1276 14.3939 5.699 14.1038C6.4494 14.3047 7.2231 14.4055 8 14.4037"
            stroke-width="1"></path>
        </svg></span></h1>
    <p>大阪電子専門学校からのお知らせ</p>
  </div>

  <div class="tl-link-tags">
    <p>Top</p>
    <p>情報エンジニア科</p>
  </div>
</div>


<section class="news-list-section  container-nl">

  <div class="news-list-main-content">
    <?php
    $tags = get_terms(array(
      'taxonomy' => 'post_tag',
      'hide_empty' => true,
    ));

    // Get the current tag from the query parameter
    $current_tag = isset($_GET['tag']) ? sanitize_text_field($_GET['tag']) : '';

    if ($tags) {
      echo '<div class="news-list-links-top">';
      echo '<a href="' . esc_url(get_post_type_archive_link('news')) . '" class=" ' . (!$current_tag ? 'bg-black' : '') . '">すべて</a>'; // 'All' button
    
      foreach ($tags as $tag) {
        // Check if this tag is the current tag
        $active_class = ($current_tag === $tag->slug) ? 'bg-black' : '';
        $is_important = get_term_meta($tag->term_id, 'is_important', true);
        if ($is_important) {
          $active_class .= ' bg-red';
        }
        echo '<a href="' . esc_url(add_query_arg('tag', $tag->slug)) . '" class=" ' . esc_attr($active_class) . '">' . esc_html($tag->name) . '</a>';
      }
      echo '</div>';
    }
    ?>


    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    // Check if a tag is set in the query parameter
    $tag = isset($_GET['tag']) ? sanitize_text_field($_GET['tag']) : '';

    // Build query arguments
    $args = array(
      'post_type' => 'news',
      'posts_per_page' => 2,
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

    $news_query = new WP_Query($args);

    if ($news_query->have_posts()): ?>
              <div class="news-list-items contener-clp">
                <?php while ($news_query->have_posts()):
                  $news_query->the_post(); ?>
                  <div class="news-list-item">
                    <div class="news-list-items-red">
                      <span><?php echo get_the_date('Y.m.d'); ?></span>
     
                      <?php
                      // Get the tags for the current post
                      $post_tags = get_the_tags();
                      if ($post_tags) {
                        echo '<span class="post-tags">';
                        foreach ($post_tags as $tag) {
                          // Check if the tag is important
                          $is_important = get_term_meta($tag->term_id, 'is_important', true);
                          $important_class = $is_important ? 'item-bg-red' : '';

                          echo '<a href="' . esc_url(add_query_arg('tag', $tag->slug)) . '" class="tag-link ' . esc_attr($important_class) . '">' . esc_html($tag->name) . '</a> ';
                        }
                        echo '</span>';
                      }

                      ?>
                    </div>
                    <a class="news-list-items-right" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </div>
                <?php endwhile; ?>
              </div>

    

              <div class="pagination">
              <?php
              // Check if there's a previous page
              if ($paged > 1) {
                  echo '<a href="' . get_previous_posts_page_link() . '" class="prev">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                              d="M14.8233 6.31712C14.723 6.21659 14.6039 6.13684 14.4727 6.08242C14.3415 6.02801 14.2009 6 14.0589 6C13.9168 6 13.7762 6.02801 13.645 6.08242C13.5139 6.13684 13.3947 6.21659 13.2944 6.31712L8.31712 11.2944C8.21659 11.3947 8.13684 11.5139 8.08242 11.645C8.02801 11.7762 8 11.9168 8 12.0589C8 12.2009 8.02801 12.3415 8.08242 12.4727C8.13684 12.6039 8.21659 12.723 8.31712 12.8233L13.2944 17.8006C13.3948 17.901 13.514 17.9806 13.6451 18.035C13.7763 18.0893 13.9169 18.1173 14.0589 18.1173C14.2008 18.1173 14.3414 18.0893 14.4726 18.035C14.6038 17.9806 14.7229 17.901 14.8233 17.8006C14.9237 17.7002 15.0034 17.581 15.0577 17.4499C15.112 17.3187 15.14 17.1781 15.14 17.0361C15.14 16.8941 15.112 16.7536 15.0577 16.6224C15.0034 16.4912 14.9237 16.372 14.8233 16.2716L10.616 12.0534L14.8233 7.84608C15.2462 7.42318 15.2354 6.72918 14.8233 6.31712Z"
                              <path d="YOUR_PATH_HERE" fill="#001E62" />
                          </svg>
                        </a>';
              }

              // Pagination links
              $total_pages = $news_query->max_num_pages;
              $links = [];

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
                  echo '<a href="' . get_next_posts_page_link() . '" class="next">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                           d="M9.17666 17.6829C9.27698 17.7834 9.39614 17.8632 9.52732 17.9176C9.6585 17.972 9.79912 18 9.94114 18C10.0832 18 10.2238 17.972 10.355 17.9176C10.4861 17.8632 10.6053 17.7834 10.7056 17.6829L15.6829 12.7056C15.7834 12.6053 15.8632 12.4861 15.9176 12.355C15.972 12.2238 16 12.0832 16 11.9411C16 11.7991 15.972 11.6585 15.9176 11.5273C15.8632 11.3961 15.7834 11.277 15.6829 11.1767L10.7056 6.1994C10.6052 6.099 10.486 6.01937 10.3549 5.96503C10.2237 5.9107 10.0831 5.88274 9.94114 5.88274C9.79916 5.88274 9.65858 5.9107 9.52741 5.96503C9.39624 6.01937 9.27705 6.099 9.17666 6.1994C9.07627 6.29979 8.99663 6.41897 8.9423 6.55014C8.88797 6.68131 8.86 6.8219 8.86 6.96388C8.86 7.10585 8.88797 7.24644 8.9423 7.37761C8.99663 7.50878 9.07627 7.62796 9.17666 7.72836L13.384 11.9466L9.17666 16.1539C8.75375 16.5768 8.7646 17.2708 9.17666 17.6829Z"

                          <path d="YOUR_PATH_HERE" fill="#001E62" />
                          </svg>
                        </a>';
              }
              ?>
          </div>

<!-- 
              d="M14.8233 6.31712C14.723 6.21659 14.6039 6.13684 14.4727 6.08242C14.3415 6.02801 14.2009 6 14.0589 6C13.9168 6 13.7762 6.02801 13.645 6.08242C13.5139 6.13684 13.3947 6.21659 13.2944 6.31712L8.31712 11.2944C8.21659 11.3947 8.13684 11.5139 8.08242 11.645C8.02801 11.7762 8 11.9168 8 12.0589C8 12.2009 8.02801 12.3415 8.08242 12.4727C8.13684 12.6039 8.21659 12.723 8.31712 12.8233L13.2944 17.8006C13.3948 17.901 13.514 17.9806 13.6451 18.035C13.7763 18.0893 13.9169 18.1173 14.0589 18.1173C14.2008 18.1173 14.3414 18.0893 14.4726 18.035C14.6038 17.9806 14.7229 17.901 14.8233 17.8006C14.9237 17.7002 15.0034 17.581 15.0577 17.4499C15.112 17.3187 15.14 17.1781 15.14 17.0361C15.14 16.8941 15.112 16.7536 15.0577 16.6224C15.0034 16.4912 14.9237 16.372 14.8233 16.2716L10.616 12.0534L14.8233 7.84608C15.2462 7.42318 15.2354 6.72918 14.8233 6.31712Z"

              d="M9.17666 17.6829C9.27698 17.7834 9.39614 17.8632 9.52732 17.9176C9.6585 17.972 9.79912 18 9.94114 18C10.0832 18 10.2238 17.972 10.355 17.9176C10.4861 17.8632 10.6053 17.7834 10.7056 17.6829L15.6829 12.7056C15.7834 12.6053 15.8632 12.4861 15.9176 12.355C15.972 12.2238 16 12.0832 16 11.9411C16 11.7991 15.972 11.6585 15.9176 11.5273C15.8632 11.3961 15.7834 11.277 15.6829 11.1767L10.7056 6.1994C10.6052 6.099 10.486 6.01937 10.3549 5.96503C10.2237 5.9107 10.0831 5.88274 9.94114 5.88274C9.79916 5.88274 9.65858 5.9107 9.52741 5.96503C9.39624 6.01937 9.27705 6.099 9.17666 6.1994C9.07627 6.29979 8.99663 6.41897 8.9423 6.55014C8.88797 6.68131 8.86 6.8219 8.86 6.96388C8.86 7.10585 8.88797 7.24644 8.9423 7.37761C8.99663 7.50878 9.07627 7.62796 9.17666 7.72836L13.384 11.9466L9.17666 16.1539C8.75375 16.5768 8.7646 17.2708 9.17666 17.6829Z" -->


    <?php else: ?>
      <p><?php _e('No news found.'); ?></p>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>

  </div>

  <div class="list-pages-right">
    <div class="lpr-item">
      <p>Contener</p>
      <?php
      $tags = get_terms(array(
        'taxonomy' => 'post_tag',
        'hide_empty' => true,
      ));

      // Get the current tag from the query parameter
      $current_tag = isset($_GET['tag']) ? sanitize_text_field($_GET['tag']) : '';

      if ($tags) {
        echo '<div class="lpr-item-links">';
        echo '<a href="' . esc_url(get_post_type_archive_link('news')) . '" class="lpr-link-btn ' . (!$current_tag ? 'bg-black' : '') . '">すべて</a>'; // 'All' button
      
        foreach ($tags as $tag) {
          // Check if this tag is the current tag
      
          $active_class = ($current_tag === $tag->slug) ? 'bg-black' : '';
          $is_important = get_term_meta($tag->term_id, 'is_important', true);
          if ($is_important) {
            $active_class = ' bg-red';
          }
          echo '<a href="' . esc_url(add_query_arg('tag', $tag->slug)) . '" class="lpr-link-btn ' . esc_attr($active_class) . '">' . esc_html($tag->name) . '</a>';
        }
        echo '</div>';
      }
      ?>




      <!-- <div class="lpr-item-links">
        <a href="#" class="lpr-link-btn bg-black">すべて</a>
        <a href="#" class="lpr-link-btn bg-red">重要なお知らせ</a>
        <a href="#" class="lpr-link-btn">お知らせ</a>
        <a href="#" class="lpr-link-btn">入試情報</a>
        <a href="#" class="lpr-link-btn">オープンキャンパス情報</a>
      </div> -->

    </div>

    <div class="lpr-item">
      <p>ARCHIVE</p>
      <div class="lpr-item-links">
        <a href="#" class="lpr-drop-down">
          <p>選択してください</p>
          <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M7 10L12.0008 14.58L17 10" stroke="#0A090B" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
          </span>
        </a>
      </div>
    </div>
  </div>


</section>

<!-- news list section finished -->

<?php get_footer(); ?>