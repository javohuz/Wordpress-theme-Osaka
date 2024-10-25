<?php
get_header();
?>





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
    <p>情報エンジニア科</p>
  </div>
</div>


<section class="news-detail-section container-nl">

  <div class="news-detail-main-content contener-clp">

    <?php if (have_posts()):
      while (have_posts()):
        the_post(); ?>
        <div class="news-detail-items">
          <a class="news-detail-items-right" href="#">
            <h1><?php the_title(); ?></h1>
          </a>
          <div class="news-detail-items-red">
            <?php
            // Get the tags for the current post
            $post_tags = get_the_tags();
            if ($post_tags) {
              foreach ($post_tags as $tag) {
                // Check if the tag is important
                $is_important = get_term_meta($tag->term_id, 'is_important', true);
                $important_class = $is_important ? 'item-bg-red' : '';

                echo '<a href="' . esc_url(add_query_arg('tag', $tag->slug, get_post_type_archive_link('news'))) . '" class="tag-link ' . esc_attr($important_class) . '">' . esc_html($tag->name) . '</a> ';
              }
            }
            ?>
            <span><?php echo get_the_date('Y.m.d'); ?></span>
          </div>
        </div>
        <div class="news-detail-content">
          <p><?php the_content(); ?></p>
        </div>
      <?php endwhile; else: ?>
      <p><?php _e('Sorry, no news found.'); ?></p>
    <?php endif; ?>


    <div class="news-detail-title-2 ">
      <a href="#" class="news-detail-btn-2">
        <p>
          <span>😃</span> 一覧を見る
        </p>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M14.4297 5.92969L20.4997 11.9997L14.4297 18.0697" stroke="#FFFFFF" stroke-width="1.5"
            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M3.5 12H20.33" stroke="#FFFFFF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
            stroke-linejoin="round" />
        </svg>
      </a>
    </div>

  </div>

  <div class="list-pages-right">
    <div class="lpr-item">
      <p>Contener</p>
      <div class="lpr-item-links" id="tagContainer">
        <?php
        // Get all tags
        $tags = get_terms(array(
          'taxonomy' => 'post_tag',
          'hide_empty' => true,
        ));

        // Get the current tag from the query parameter
        $current_tag = isset($_GET['tag']) ? sanitize_text_field($_GET['tag']) : '';

        // Check if we're on a tag archive page and get the current tag slug
        if (is_tag()) {
          $current_tag = get_queried_object()->slug;
        }

        // Get the current post's tags
        $post_tags = get_the_tags();
        $tags = get_terms(array(
          'taxonomy' => 'post_tag',
          'hide_empty' => true,
          'object_ids' => get_posts(array(
            'post_type' => 'news',
            'fields' => 'ids',
            'numberposts' => -1 // Get all column post IDs
          )),
        ));
        if ($tags) {
          echo '<div class="lpr-item-links">';
          echo '<a href="' . esc_url(get_post_type_archive_link('news')) . '" class="lpr-link-btn ' . '">すべて</a>'; // 'All' button
        
          foreach ($tags as $tag) {
            // Check if this tag is in the current post's tags
            $active_class = '';

            if ($post_tags) {
              foreach ($post_tags as $post_tag) {
                if ($post_tag->slug === $tag->slug) {
                  $active_class = 'bg-black';
                  break;
                }
              }
            }

            echo '<a href="' . esc_url(add_query_arg('tag', $tag->slug, get_post_type_archive_link('news'))) . '" class="lpr-link-btn ' . esc_attr($active_class) . '">' . esc_html($tag->name) . '</a>';
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

        <a href="<?php echo add_query_arg('filter_date', '2024-01-01', get_post_type_archive_link('news')); ?>"
          class="lpr-link-btn">2024</a>
        <a href="<?php echo add_query_arg('filter_date', '2023-01-01', get_post_type_archive_link('news')); ?>"
          class="lpr-link-btn">2023</a>
        <a href="<?php echo add_query_arg('filter_date', '2023-01-01', get_post_type_archive_link('news')); ?>"
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
<?php get_footer(); ?>