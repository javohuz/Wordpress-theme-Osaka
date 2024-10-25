<?php

// Enqueue styles and scripts
function my_theme_scripts()
{
  // Enqueue main stylesheet
  wp_enqueue_style('main-style', get_stylesheet_directory_uri() . '/style.css');

  // Enqueue additional stylesheets
  wp_enqueue_style('main-layout', get_template_directory_uri() . '/assets/styles/main_layout.css');
  wp_enqueue_style('footer', get_template_directory_uri() . '/assets/styles/footer.css');
  wp_enqueue_style('header', get_template_directory_uri() . '/assets/styles/header.css');
  wp_enqueue_style('root-javo', get_template_directory_uri() . '/assets/styles/root_javo.css');
  wp_enqueue_style('news-list', get_template_directory_uri() . '/assets/style_pages/36-news-list.css');
  wp_enqueue_style('news-detail', get_template_directory_uri() . '/assets/style_pages/37-news-detail.css');
  wp_enqueue_style('column-list-style', get_template_directory_uri() . '/assets/style_pages/38-column-list.css');
  wp_enqueue_style('column-detail-style', get_template_directory_uri() . '/assets/style_pages/39-column-detail.css');

  // Enqueue scripts
  wp_enqueue_script('news-list-js', get_template_directory_uri() . '/assets/pages-js/36-news-list.js', array(), null, true);
  wp_enqueue_script('news-detail-js', get_template_directory_uri() . '/assets/pages-js/37-news-detail.js', array(), null, true);
  wp_enqueue_script('header-js', get_template_directory_uri() . '/js/header.js', array(), null, true);
  wp_enqueue_script('column-detail-js', get_template_directory_uri() . '/assets/pages-js/39-column-detail.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');

// Create custom post type for news
function create_news_post_type()
{
  register_post_type(
    'news',
    array(
      'labels' => array(
        'name' => __('News'),
        'singular_name' => __('News Item')
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
      'taxonomies' => array('post_tag'),
      'rewrite' => array('slug' => 'news'),
    )
  );
}
add_action('init', 'create_news_post_type');

// Add a custom meta box for custom URL slug
function add_custom_slug_meta_box()
{
  add_meta_box(
    'custom_slug_meta_box',
    __('Custom URL Slug', 'textdomain'),
    'render_custom_slug_meta_box',
    'news',
    'side',
    'default'
  );
}
add_action('add_meta_boxes', 'add_custom_slug_meta_box');

function render_custom_slug_meta_box($post)
{
  $custom_slug = get_post_meta($post->ID, '_custom_slug', true);
  ?>
  <label for="custom_slug"><?php _e('Enter custom URL slug:', 'textdomain'); ?></label>
  <input type="text" id="custom_slug" name="custom_slug" value="<?php echo esc_attr($custom_slug); ?>"
    style="width:100%;">
  <?php
}

// Save the custom slug
function save_custom_slug_meta_box($post_id)
{
  if (array_key_exists('custom_slug', $_POST)) {
    update_post_meta($post_id, '_custom_slug', sanitize_text_field($_POST['custom_slug']));
  }
}
add_action('save_post', 'save_custom_slug_meta_box');

// Modify the slug for news posts
function custom_news_permalink($post_link, $id = 0)
{
  $post = get_post($id);

  if ($post->post_type == 'news') {
    $custom_slug = get_post_meta($id, '_custom_slug', true);
    if (!empty($custom_slug)) {
      return home_url('news/' . $custom_slug);
    }
  }
  return $post_link;
}
add_filter('post_type_link', 'custom_news_permalink', 10, 2);

// Ensure the custom slug is applied when the post is saved
function update_news_slug($post_id, $post, $update)
{
  if ($post->post_type === 'news') {
    $custom_slug = get_post_meta($post_id, '_custom_slug', true);

    // If a custom slug is set, use it
    if (!empty($custom_slug)) {
      $post->post_name = sanitize_title($custom_slug);
      remove_action('save_post', 'update_news_slug'); // Prevent recursion
      wp_update_post($post);
      add_action('save_post', 'update_news_slug', 10, 3);
    }
  }
}
add_action('save_post', 'update_news_slug', 10, 3);

// Add a custom field for tags
function add_tag_meta_boxes()
{
  add_action('post_tag_edit_form', 'tag_meta_box');
}
add_action('admin_init', 'add_tag_meta_boxes');

function tag_meta_box($tag)
{
  $important = get_term_meta($tag->term_id, 'is_important', true);
  ?>
  <div class="form-field">
    <label for="is_important"><?php _e('Important Tag', 'textdomain'); ?></label>
    <input type="checkbox" name="is_important" id="is_important" <?php checked($important, 'yes'); ?> value="yes" />
    <p><?php _e('Check this box if the tag is important.', 'textdomain'); ?></p>
  </div>
  <?php
}

// Save the custom field value when editing a tag
function save_tag_meta($term_id)
{
  if (isset($_POST['is_important'])) {
    update_term_meta($term_id, 'is_important', 'yes');
  } else {
    delete_term_meta($term_id, 'is_important');
  }
}
add_action('edited_post_tag', 'save_tag_meta');









// Create Custom Post Type for Columns
function create_columns_post_type() {
    register_post_type('columns', array(
        'labels' => array(
            'name' => __('Columns'),
            'singular_name' => __('Column Item')
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'taxonomies' => array('post_tag'),
        'rewrite' => array('slug' => 'columns'),
    ));
}
add_action('init', 'create_columns_post_type');

// Add Custom Meta Box for Custom URL Slug
function add_custom_slug_meta_box_columns() {
    add_meta_box('custom_slug_meta_box_columns', __('Custom URL Slug', 'textdomain'), 'render_custom_slug_meta_box_columns', 'columns', 'side', 'default');
}
add_action('add_meta_boxes', 'add_custom_slug_meta_box_columns');

function render_custom_slug_meta_box_columns($post) {
    $custom_slug = get_post_meta($post->ID, '_custom_slug_columns', true);
    echo '<label for="custom_slug_columns">' . __('Enter custom URL slug:', 'textdomain') . '</label>';
    echo '<input type="text" id="custom_slug_columns" name="custom_slug_columns" value="' . esc_attr($custom_slug) . '" style="width:100%;">';
}

// Save the Custom Slug for Columns
function save_custom_slug_meta_box_columns($post_id) {
    if (array_key_exists('custom_slug_columns', $_POST)) {
        update_post_meta($post_id, '_custom_slug_columns', sanitize_text_field($_POST['custom_slug_columns']));
    }
}
add_action('save_post', 'save_custom_slug_meta_box_columns');
// Add Custom Meta Box for Top Image
function add_top_image_meta_box() {
    add_meta_box('top_image_meta_box', __('Top Image', 'textdomain'), 'render_top_image_meta_box', 'columns', 'side', 'default');
}
add_action('add_meta_boxes', 'add_top_image_meta_box');

function render_top_image_meta_box($post) {
    // Retrieve existing top image URL
    $top_image = get_post_meta($post->ID, '_top_image', true);
    ?>
    <div style="text-align: left;">
        <label for="top_image" style="font-weight: bold;"><?php _e('Upload Top Image:', 'textdomain'); ?></label>
        <input type="text" id="top_image" name="top_image" value="<?php echo esc_attr($top_image); ?>" style="width: 100%; margin-bottom: 10px; padding: 5px;">
        <input type="button" id="upload_top_image_button" class="button" value="<?php _e('Upload Image', 'textdomain'); ?>" style="margin-bottom: 10px;" />
        
        <div id="top_image_preview" style="margin-top: 10px;">
            <?php if ($top_image): ?>
                <img src="<?php echo esc_url($top_image); ?>" alt="<?php esc_attr_e('Top Image Preview', 'textdomain'); ?>" style="max-width: 100%; border: 1px solid #ddd; border-radius: 4px; margin-top: 5px;">
            <?php else: ?>
                <p><?php _e('No image uploaded. Please upload an image.', 'textdomain'); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('#upload_top_image_button').click(function(e) {
                e.preventDefault();
                var image_frame = wp.media({
                    title: '<?php _e('Select Image', 'textdomain'); ?>',
                    button: {
                        text: '<?php _e('Use this image', 'textdomain'); ?>'
                    },
                    multiple: false // Set to true to allow multiple images to be selected
                });

                image_frame.on('select', function() {
                    var uploaded_image = image_frame.state().get('selection').first().toJSON();
                    $('#top_image').val(uploaded_image.url);
                    $('#top_image_preview img').attr('src', uploaded_image.url); // Update image preview
                    $('#top_image_preview p').hide(); // Hide the placeholder message
                });

                image_frame.open();
            });
        });
    </script>
    <?php
}

// Save the Top Image
function save_top_image_meta_box($post_id) {
    if (array_key_exists('top_image', $_POST)) {
        update_post_meta($post_id, '_top_image', sanitize_text_field($_POST['top_image']));
    }
}
add_action('save_post', 'save_top_image_meta_box');


// Modify the Slug for Columns Posts
function custom_columns_permalink($post_link, $id = 0) {
    $post = get_post($id);
    if ($post->post_type == 'columns') {
        $custom_slug = get_post_meta($id, '_custom_slug_columns', true);
        if (!empty($custom_slug)) {
            return home_url('columns/' . $custom_slug);
        }
    }
    return $post_link;
}
add_filter('post_type_link', 'custom_columns_permalink', 10, 2);

// Ensure the Custom Slug is Applied When the Post is Saved
function update_columns_slug($post_id, $post, $update) {
    if ($post->post_type === 'columns') {
        $custom_slug = get_post_meta($post_id, '_custom_slug_columns', true);
        if (!empty($custom_slug)) {
            $post->post_name = sanitize_title($custom_slug);
            remove_action('save_post', 'update_columns_slug'); // Prevent recursion
            wp_update_post($post);
            add_action('save_post', 'update_columns_slug', 10, 3);
        }
    }
}
add_action('save_post', 'update_columns_slug', 10, 3);

// Add Custom Field for Tags
function add_tag_meta_boxes_columns() {
    add_action('post_tag_edit_form', 'tag_meta_box_columns');
}
add_action('admin_init', 'add_tag_meta_boxes_columns');

function tag_meta_box_columns($tag) {
    $important = get_term_meta($tag->term_id, 'is_important', true);
    ?>
    <div class="form-field">
        <label for="is_important"><?php _e('Important Tag', 'textdomain'); ?></label>
        <input type="checkbox" name="is_important" id="is_important" <?php checked($important, 'yes'); ?> value="yes" />
        <p><?php _e('Check this box if the tag is important.', 'textdomain'); ?></p>
    </div>
    <?php
}

// Save the Custom Field Value When Editing a Tag
function save_tag_meta_columns($term_id) {
    if (isset($_POST['is_important'])) {
        update_term_meta($term_id, 'is_important', 'yes');
    } else {
        delete_term_meta($term_id, 'is_important');
    }
}
add_action('edited_post_tag', 'save_tag_meta_columns');
