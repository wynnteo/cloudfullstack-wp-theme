<?php
/**
 * Nordic Tech Theme Functions
 *
 * @package Nordic_Tech
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function nordic_tech_setup() {
    // Add theme support for various features
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    
    // Add theme support for HTML5 markup
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    
    // Add theme support for custom background
    add_theme_support('custom-background', array(
        'default-color' => 'fefefe',
    ));
    
    // Add theme support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));
    
    // Set content width
    if (!isset($content_width)) {
        $content_width = 800;
    }
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'nordic-tech'),
        'footer'  => esc_html__('Footer Menu', 'nordic-tech'),
    ));
    
    // Add excerpt support to pages
    add_post_type_support('page', 'excerpt');
}
add_action('after_setup_theme', 'nordic_tech_setup');

/**
 * Register widget areas
 */
function nordic_tech_widgets_init() {
    // Main sidebar
    register_sidebar(array(
        'name'          => esc_html__('Main Sidebar', 'nordic-tech'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here to appear in your sidebar.', 'nordic-tech'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    // Footer widgets
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget 1', 'nordic-tech'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here to appear in the first footer column.', 'nordic-tech'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget 2', 'nordic-tech'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add widgets here to appear in the second footer column.', 'nordic-tech'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget 3', 'nordic-tech'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Add widgets here to appear in the third footer column.', 'nordic-tech'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'nordic_tech_widgets_init');

/**
 * Enqueue scripts and styles
 */
function nordic_tech_scripts() {
    // Main stylesheet
    wp_enqueue_style('nordic-tech-style', get_stylesheet_uri(), array(), '1.0');
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'nordic_tech_scripts');

/**
 * Custom excerpt length
 */
function nordic_tech_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'nordic_tech_excerpt_length');

/**
 * Custom excerpt more text
 */
function nordic_tech_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'nordic_tech_excerpt_more');

/**
 * Calculate reading time
 */
function nordic_tech_reading_time() {
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed
    return $reading_time;
}


// custom user meta fields for social links
function nordic_tech_user_profile_fields($user) {
    ?>
    <h3>Social Media Links</h3>
    <table class="form-table">
        <tr>
            <th><label for="github">GitHub URL</label></th>
            <td><input type="url" name="github" id="github" value="<?php echo esc_attr(get_the_author_meta('github', $user->ID)); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="linkedin">LinkedIn URL</label></th>
            <td><input type="url" name="linkedin" id="linkedin" value="<?php echo esc_attr(get_the_author_meta('linkedin', $user->ID)); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="twitter">Twitter URL</label></th>
            <td><input type="url" name="twitter" id="twitter" value="<?php echo esc_attr(get_the_author_meta('twitter', $user->ID)); ?>" class="regular-text" /></td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'nordic_tech_user_profile_fields');
add_action('edit_user_profile', 'nordic_tech_user_profile_fields');

function nordic_tech_save_user_profile_fields($user_id) {
    if (!current_user_can('edit_user', $user_id)) { return false; }
    update_user_meta($user_id, 'github', $_POST['github']);
    update_user_meta($user_id, 'linkedin', $_POST['linkedin']);
    update_user_meta($user_id, 'twitter', $_POST['twitter']);
}
add_action('personal_options_update', 'nordic_tech_save_user_profile_fields');
add_action('edit_user_profile_update', 'nordic_tech_save_user_profile_fields');
/**
 * Fallback menu for primary navigation
 */
function nordic_tech_fallback_menu() {
    echo '<ul class="nav-links">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'nordic-tech') . '</a></li>';
    
    // Show pages in navigation
    $pages = get_pages(array('sort_column' => 'menu_order'));
    foreach ($pages as $page) {
        echo '<li><a href="' . get_permalink($page->ID) . '">' . esc_html($page->post_title) . '</a></li>';
    }
    echo '</ul>';
}

/**
 * Add custom post class for styling
 */
function nordic_tech_post_classes($classes) {
    if (is_single()) {
        $classes[] = 'single-post';
    }
    return $classes;
}
add_filter('post_class', 'nordic_tech_post_classes');

/**
 * Customize search form
 */
function nordic_tech_search_form($form) {
    $form = '<form role="search" method="get" class="search-form" action="' . home_url('/') . '">
        <input type="search" class="search-field" placeholder="' . esc_attr__('Search...', 'nordic-tech') . '" value="' . get_search_query() . '" name="s" />
        <button type="submit" class="search-submit">' . esc_html__('Search', 'nordic-tech') . '</button>
    </form>';
    return $form;
}
add_filter('get_search_form', 'nordic_tech_search_form');

/**
 * Add theme support for block editor
 */
function nordic_tech_block_editor_setup() {
    // Add support for editor styles
    add_theme_support('editor-styles');
    
    // Enqueue editor styles
    add_editor_style('editor-style.css');
    
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add support for editor font sizes
    add_theme_support('editor-font-sizes', array(
        array(
            'name' => esc_html__('Small', 'nordic-tech'),
            'size' => 14,
            'slug' => 'small'
        ),
        array(
            'name' => esc_html__('Regular', 'nordic-tech'),
            'size' => 16,
            'slug' => 'regular'
        ),
        array(
            'name' => esc_html__('Large', 'nordic-tech'),
            'size' => 20,
            'slug' => 'large'
        ),
        array(
            'name' => esc_html__('Extra Large', 'nordic-tech'),
            'size' => 24,
            'slug' => 'extra-large'
        ),
    ));
    
    // Add support for editor color palette
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => esc_html__('Primary Color', 'nordic-tech'),
            'slug'  => 'primary',
            'color' => '#2c2c2c',
        ),
        array(
            'name'  => esc_html__('Accent Color', 'nordic-tech'),
            'slug'  => 'accent',
            'color' => '#9f8e7f',
        ),
        array(
            'name'  => esc_html__('Wood Warm', 'nordic-tech'),
            'slug'  => 'wood-warm',
            'color' => '#a8a591',
        ),
        array(
            'name'  => esc_html__('Light Beige', 'nordic-tech'),
            'slug'  => 'light-beige',
            'color' => '#d9d7d0',
        ),
    ));
}
add_action('after_setup_theme', 'nordic_tech_block_editor_setup');

/**
 * Disable block editor for certain post types (optional)
 */
function nordic_tech_disable_block_editor($use_block_editor, $post_type) {
    // You can disable block editor for specific post types if needed
    // Example: if ($post_type === 'page') return false;
    return $use_block_editor;
}
add_filter('use_block_editor_for_post_type', 'nordic_tech_disable_block_editor', 10, 2);

/**
 * Custom body classes
 */
function nordic_tech_body_classes($classes) {
    // Add class for single posts
    if (is_single()) {
        $classes[] = 'single-post-page';
    }
    
    // Add class for pages
    if (is_page()) {
        $classes[] = 'single-page';
    }
    
    // Add class if sidebar is active
    if (is_active_sidebar('sidebar-1')) {
        $classes[] = 'has-sidebar';
    } else {
        $classes[] = 'no-sidebar';
    }
    
    return $classes;
}
add_filter('body_class', 'nordic_tech_body_classes');

/**
 * Remove default WordPress styles that might conflict
 */
function nordic_tech_dequeue_styles() {
    // Remove block library CSS if you want full control
    // wp_dequeue_style('wp-block-library');
}
add_action('wp_enqueue_scripts', 'nordic_tech_dequeue_styles', 100);

/**
 * Customize comment form
 */
function nordic_tech_comment_form_defaults($defaults) {
    $defaults['comment_notes_before'] = '';
    $defaults['comment_notes_after'] = '';
    $defaults['title_reply'] = esc_html__('Leave a Comment', 'nordic-tech');
    $defaults['label_submit'] = esc_html__('Post Comment', 'nordic-tech');
    
    return $defaults;
}
add_filter('comment_form_defaults', 'nordic_tech_comment_form_defaults');

/**
 * Add featured post meta box
 */
function nordic_tech_add_featured_post_meta_box() {
    add_meta_box(
        'nordic_tech_featured_post',
        __('Featured Post', 'nordic-tech'),
        'nordic_tech_featured_post_meta_box_callback',
        'post',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'nordic_tech_add_featured_post_meta_box');

function nordic_tech_featured_post_meta_box_callback($post) {
    wp_nonce_field('nordic_tech_featured_post_nonce', 'nordic_tech_featured_post_nonce');
    $featured = get_post_meta($post->ID, '_featured_post', true);
    ?>
    <label for="nordic_tech_featured_post">
        <input type="checkbox" id="nordic_tech_featured_post" name="nordic_tech_featured_post" value="yes" <?php checked($featured, 'yes'); ?> />
        <?php _e('Mark as featured post', 'nordic-tech'); ?>
    </label>
    <?php
}

function nordic_tech_save_featured_post_meta($post_id) {
    if (!isset($_POST['nordic_tech_featured_post_nonce']) || !wp_verify_nonce($_POST['nordic_tech_featured_post_nonce'], 'nordic_tech_featured_post_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['nordic_tech_featured_post'])) {
        update_post_meta($post_id, '_featured_post', 'yes');
    } else {
        delete_post_meta($post_id, '_featured_post');
    }
}
add_action('save_post', 'nordic_tech_save_featured_post_meta');

/**
 * Enqueue additional scripts for filtering functionality
 */
function nordic_tech_enqueue_filter_scripts() {
    if (is_home() || is_category()) {
        wp_enqueue_script('jquery');
        wp_add_inline_script('jquery', '
            jQuery(document).ready(function($) {
                // Category filtering functionality
                $(".category-tag").on("click", function(e) {
                    if ($(this).attr("href") === "#") {
                        e.preventDefault();
                        
                        // Remove active class from all tags
                        $(".category-tag").removeClass("active");
                        $(this).addClass("active");
                        
                        var category = $(this).data("category");
                        
                        // Filter posts (this would need AJAX for full functionality)
                        // For now, we\'ll just use the href navigation
                    }
                });
                
                // Search functionality enhancement
                var searchTimeout;
                $(".search-field").on("input", function() {
                    clearTimeout(searchTimeout);
                    var query = $(this).val().toLowerCase();
                    
                    searchTimeout = setTimeout(function() {
                        $(".post-card").each(function() {
                            var title = $(this).find(".post-title").text().toLowerCase();
                            var excerpt = $(this).find(".post-excerpt").text().toLowerCase();
                            var tags = $(this).find(".tag").map(function() {
                                return $(this).text().toLowerCase();
                            }).get().join(" ");
                            
                            var matches = title.includes(query) || 
                                        excerpt.includes(query) || 
                                        tags.includes(query);
                            
                            $(this).toggle(matches || query === "");
                        });
                    }, 300);
                });
            });
        ');
    }
}
add_action('wp_enqueue_scripts', 'nordic_tech_enqueue_filter_scripts');

/**
 * Add custom image sizes to match the design
 */
function nordic_tech_custom_image_sizes() {
    add_image_size('post-card-thumbnail', 400, 250, true);
    add_image_size('related-post-thumbnail', 150, 100, true);
}
add_action('after_setup_theme', 'nordic_tech_custom_image_sizes');

/**
 * Custom post classes for better styling control
 */
function nordic_tech_enhanced_post_classes($classes) {
    global $post;
    
    if (is_home() || is_archive()) {
        $classes[] = 'post-card';
    }
    
    if (get_post_meta($post->ID, '_featured_post', true) === 'yes') {
        $classes[] = 'featured-post';
    }
    
    // Add category classes
    $categories = get_the_category();
    if ($categories) {
        foreach ($categories as $category) {
            $classes[] = 'category-' . $category->slug;
        }
    }
    
    return $classes;
}
add_filter('post_class', 'nordic_tech_enhanced_post_classes');

/**
 * Add body classes for better page identification
 */
function nordic_tech_enhanced_body_classes($classes) {
    if (is_home()) {
        $classes[] = 'home-page';
    }
    
    if (is_category()) {
        $classes[] = 'category-archive';
        $classes[] = 'category-' . get_queried_object()->slug;
    }
    
    if (is_tag()) {
        $classes[] = 'tag-archive';
        $classes[] = 'tag-' . get_queried_object()->slug;
    }
    
    return $classes;
}
add_filter('body_class', 'nordic_tech_enhanced_body_classes');

/**
 * Customize excerpt for card layout
 */
function nordic_tech_custom_excerpt_for_cards($excerpt) {
    if (is_home() || is_archive()) {
        // Ensure consistent excerpt length for card layouts
        return wp_trim_words($excerpt, 25, '...');
    }
    return $excerpt;
}
add_filter('the_excerpt', 'nordic_tech_custom_excerpt_for_cards');

/**
 * Add structured data for blog posts (SEO enhancement)
 */
function nordic_tech_add_structured_data() {
    if (is_single()) {
        global $post;
        
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => get_the_title(),
            'description' => get_the_excerpt(),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author()
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name')
            )
        );
        
        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url(null, 'large');
        }
        
        echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
    }
}
add_action('wp_head', 'nordic_tech_add_structured_data');

/**
 * Add reading progress bar (optional enhancement)
 */
function nordic_tech_add_reading_progress() {
    if (is_single()) {
        ?>
        <div id="reading-progress" style="position: fixed; top: 0; left: 0; width: 0%; height: 3px; background: var(--accent-color); z-index: 9999; transition: width 0.3s ease;"></div>
        <script>
        window.addEventListener('scroll', function() {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            document.getElementById('reading-progress').style.width = scrolled + '%';
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'nordic_tech_add_reading_progress');