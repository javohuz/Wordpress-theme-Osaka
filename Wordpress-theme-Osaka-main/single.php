<?php
get_header();
?>


    <!-- news detail section stars -->

<section class="news-detail-section container-nl">
    <div class="news-detail-main-content contener-clp">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="news-detail-items">
                <a class="news-detail-items-right" href="<?php the_permalink(); ?>">
                    <h1>【<?php the_title(); ?>】</h1>
                </a>
                <div class="news-detail-items-red">
                    <a href="#" class="bg-red">
                        <?php echo get_the_category()[0]->name; ?>
                    </a>
                    <span><?php echo get_the_date('Y.m.d'); ?></span>
                </div>
            </div>

            <div class="news-detail-content">
                <p><?php the_content(); ?></p>
            </div>

            <div class="news-detail-title-2">
                <a href="<?php echo get_post_type_archive_link('post'); ?>" class="news-detail-btn-2">
                    <p><span>😃</span> 一覧を見る</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M14.4297 5.92969L20.4997 11.9997L14.4297 18.0697" stroke="#FFFFFF" stroke-width="1.5"
                            stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M3.5 12H20.33" stroke="#FFFFFF" stroke-width="1.5" stroke-miterlimit="10"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        <?php endwhile; endif; ?>
    </div>

    <div class="list-pages-right">
        <div class="lpr-item">
            <p>Contener</p>
            <div class="lpr-item-links">
                <a href="#" class="lpr-link-btn bg-black">すべて</a>
                <?php 
                $categories = get_categories();
                foreach ($categories as $category) : ?>
                    <a href="<?php echo get_category_link($category->term_id); ?>" 
                       class="lpr-link-btn <?php echo ($category->name == '重要なお知らせ') ? 'bg-red' : ''; ?>">
                        <?php echo $category->name; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="lpr-item">
            <p>ARCHIVE</p>
            <div class="lpr-item-links">
                <a href="#" class="lpr-drop-down">
                    <p>選択してください</p>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M7 10L12.0008 14.58L17 10" stroke="#0A090B" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>
