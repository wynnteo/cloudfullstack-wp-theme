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
 * Fixed to only load on appropriate pages
 */
function nordic_tech_enqueue_filter_scripts() {
    // Only load on blog/archive pages, NOT on single posts
    if (is_home() || is_category() || is_tag() || is_archive()) {
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
                    }
                });
                
                // Search functionality enhancement - only for blog pages
                var searchTimeout;
                $(".search-field").on("input", function() {
                    clearTimeout(searchTimeout);
                    var query = $(this).val().toLowerCase();
                    
                    searchTimeout = setTimeout(function() {
                        // Only target post cards on archive pages
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
 * Add reading progress bar (fixed version)
 */
function nordic_tech_add_reading_progress() {
    if (is_single()) {
        ?>
        <div id="reading-progress" style="position: fixed; top: 0; left: 0; width: 0%; height: 3px; background: var(--accent-color); z-index: 9999; transition: width 0.3s ease;"></div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateProgress() {
                const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = (winScroll / height) * 100;
                const progressBar = document.getElementById('reading-progress');
                if (progressBar) {
                    progressBar.style.width = scrolled + '%';
                }
            }
            
            window.addEventListener('scroll', updateProgress);
            window.addEventListener('resize', updateProgress);
            
            // Initial call
            updateProgress();
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'nordic_tech_add_reading_progress');

/**
 * Portfolio Custom Post Type and Functionality
 * Add this to your functions.php file
 */

/**
 * Register Portfolio Custom Post Type
 */
function nordic_tech_register_portfolio_post_type() {
    $labels = array(
        'name'                  => _x('Portfolio', 'Post type general name', 'nordic-tech'),
        'singular_name'         => _x('Portfolio Item', 'Post type singular name', 'nordic-tech'),
        'menu_name'             => _x('Portfolio', 'Admin Menu text', 'nordic-tech'),
        'name_admin_bar'        => _x('Portfolio Item', 'Add New on Toolbar', 'nordic-tech'),
        'add_new'               => __('Add New', 'nordic-tech'),
        'add_new_item'          => __('Add New Portfolio Item', 'nordic-tech'),
        'new_item'              => __('New Portfolio Item', 'nordic-tech'),
        'edit_item'             => __('Edit Portfolio Item', 'nordic-tech'),
        'view_item'             => __('View Portfolio Item', 'nordic-tech'),
        'all_items'             => __('All Portfolio Items', 'nordic-tech'),
        'search_items'          => __('Search Portfolio Items', 'nordic-tech'),
        'parent_item_colon'     => __('Parent Portfolio Items:', 'nordic-tech'),
        'not_found'             => __('No portfolio items found.', 'nordic-tech'),
        'not_found_in_trash'    => __('No portfolio items found in Trash.', 'nordic-tech'),
        'featured_image'        => _x('Portfolio Image', 'Overrides the "Featured Image" phrase', 'nordic-tech'),
        'set_featured_image'    => _x('Set portfolio image', 'Overrides the "Set featured image" phrase', 'nordic-tech'),
        'remove_featured_image' => _x('Remove portfolio image', 'Overrides the "Remove featured image" phrase', 'nordic-tech'),
        'use_featured_image'    => _x('Use as portfolio image', 'Overrides the "Use as featured image" phrase', 'nordic-tech'),
        'archives'              => _x('Portfolio archives', 'The post type archive label', 'nordic-tech'),
        'insert_into_item'      => _x('Insert into portfolio item', 'Overrides the "Insert into post" phrase', 'nordic-tech'),
        'uploaded_to_this_item' => _x('Uploaded to this portfolio item', 'Overrides the "Uploaded to this post" phrase', 'nordic-tech'),
        'filter_items_list'     => _x('Filter portfolio items list', 'Screen reader text for the filter links', 'nordic-tech'),
        'items_list_navigation' => _x('Portfolio items list navigation', 'Screen reader text for the pagination', 'nordic-tech'),
        'items_list'            => _x('Portfolio items list', 'Screen reader text for the items list', 'nordic-tech'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'portfolio'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true, // Enable Gutenberg editor
    );

    register_post_type('portfolio', $args);
}
add_action('init', 'nordic_tech_register_portfolio_post_type');

/**
 * Register Portfolio Categories Taxonomy
 */
function nordic_tech_register_portfolio_taxonomy() {
    $labels = array(
        'name'              => _x('Portfolio Categories', 'taxonomy general name', 'nordic-tech'),
        'singular_name'     => _x('Portfolio Category', 'taxonomy singular name', 'nordic-tech'),
        'search_items'      => __('Search Portfolio Categories', 'nordic-tech'),
        'all_items'         => __('All Portfolio Categories', 'nordic-tech'),
        'parent_item'       => __('Parent Portfolio Category', 'nordic-tech'),
        'parent_item_colon' => __('Parent Portfolio Category:', 'nordic-tech'),
        'edit_item'         => __('Edit Portfolio Category', 'nordic-tech'),
        'update_item'       => __('Update Portfolio Category', 'nordic-tech'),
        'add_new_item'      => __('Add New Portfolio Category', 'nordic-tech'),
        'new_item_name'     => __('New Portfolio Category Name', 'nordic-tech'),
        'menu_name'         => __('Portfolio Categories', 'nordic-tech'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'portfolio-category'),
        'show_in_rest'      => true,
    );

    register_taxonomy('portfolio_category', array('portfolio'), $args);

    // Register Portfolio Tags
    $tag_labels = array(
        'name'                       => _x('Portfolio Tags', 'taxonomy general name', 'nordic-tech'),
        'singular_name'              => _x('Portfolio Tag', 'taxonomy singular name', 'nordic-tech'),
        'search_items'               => __('Search Portfolio Tags', 'nordic-tech'),
        'popular_items'              => __('Popular Portfolio Tags', 'nordic-tech'),
        'all_items'                  => __('All Portfolio Tags', 'nordic-tech'),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __('Edit Portfolio Tag', 'nordic-tech'),
        'update_item'                => __('Update Portfolio Tag', 'nordic-tech'),
        'add_new_item'               => __('Add New Portfolio Tag', 'nordic-tech'),
        'new_item_name'              => __('New Portfolio Tag Name', 'nordic-tech'),
        'separate_items_with_commas' => __('Separate portfolio tags with commas', 'nordic-tech'),
        'add_or_remove_items'        => __('Add or remove portfolio tags', 'nordic-tech'),
        'choose_from_most_used'      => __('Choose from the most used portfolio tags', 'nordic-tech'),
        'not_found'                  => __('No portfolio tags found.', 'nordic-tech'),
        'menu_name'                  => __('Portfolio Tags', 'nordic-tech'),
    );

    $tag_args = array(
        'hierarchical'          => false,
        'labels'                => $tag_labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array('slug' => 'portfolio-tag'),
        'show_in_rest'          => true,
    );

    register_taxonomy('portfolio_tag', 'portfolio', $tag_args);
}
add_action('init', 'nordic_tech_register_portfolio_taxonomy');

/**
 * Add Portfolio Meta Boxes
 */
function nordic_tech_add_portfolio_meta_boxes() {
    add_meta_box(
        'portfolio_details',
        __('Portfolio Details', 'nordic-tech'),
        'nordic_tech_portfolio_details_callback',
        'portfolio',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'nordic_tech_add_portfolio_meta_boxes');

/**
 * Portfolio Details Meta Box Callback
 */
function nordic_tech_portfolio_details_callback($post) {
    wp_nonce_field('nordic_tech_portfolio_details_nonce', 'nordic_tech_portfolio_details_nonce');
    
    $project_url = get_post_meta($post->ID, '_project_url', true);
    $github_url = get_post_meta($post->ID, '_github_url', true);
    $demo_url = get_post_meta($post->ID, '_demo_url', true);
    $client = get_post_meta($post->ID, '_project_client', true);
    $year = get_post_meta($post->ID, '_project_year', true);
    $technologies = get_post_meta($post->ID, '_project_technologies', true);
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="project_url"><?php _e('Project URL', 'nordic-tech'); ?></label>
            </th>
            <td>
                <input type="url" id="project_url" name="project_url" value="<?php echo esc_attr($project_url); ?>" class="regular-text" />
                <p class="description"><?php _e('Main project URL', 'nordic-tech'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="github_url"><?php _e('GitHub URL', 'nordic-tech'); ?></label>
            </th>
            <td>
                <input type="url" id="github_url" name="github_url" value="<?php echo esc_attr($github_url); ?>" class="regular-text" />
                <p class="description"><?php _e('GitHub repository URL', 'nordic-tech'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="demo_url"><?php _e('Demo URL', 'nordic-tech'); ?></label>
            </th>
            <td>
                <input type="url" id="demo_url" name="demo_url" value="<?php echo esc_attr($demo_url); ?>" class="regular-text" />
                <p class="description"><?php _e('Live demo URL', 'nordic-tech'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="project_client"><?php _e('Client', 'nordic-tech'); ?></label>
            </th>
            <td>
                <input type="text" id="project_client" name="project_client" value="<?php echo esc_attr($client); ?>" class="regular-text" />
                <p class="description"><?php _e('Client name (optional)', 'nordic-tech'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="project_year"><?php _e('Year', 'nordic-tech'); ?></label>
            </th>
            <td>
                <input type="number" id="project_year" name="project_year" value="<?php echo esc_attr($year); ?>" min="2000" max="<?php echo date('Y'); ?>" />
                <p class="description"><?php _e('Project completion year', 'nordic-tech'); ?></p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="project_technologies"><?php _e('Technologies', 'nordic-tech'); ?></label>
            </th>
            <td>
                <textarea id="project_technologies" name="project_technologies" rows="3" class="large-text"><?php echo esc_textarea($technologies); ?></textarea>
                <p class="description"><?php _e('Technologies used (comma separated)', 'nordic-tech'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save Portfolio Meta Data
 */
function nordic_tech_save_portfolio_meta($post_id) {
    if (!isset($_POST['nordic_tech_portfolio_details_nonce']) || 
        !wp_verify_nonce($_POST['nordic_tech_portfolio_details_nonce'], 'nordic_tech_portfolio_details_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array('project_url', 'github_url', 'demo_url', 'project_client', 'project_year', 'project_technologies');
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'nordic_tech_save_portfolio_meta');

/**
 * Helper function to get portfolio items
 */
function nordic_tech_get_portfolio_items($args = array()) {
    $default_args = array(
        'post_type' => 'portfolio',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_key' => '_project_year',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    );
    
    $args = wp_parse_args($args, $default_args);
    return new WP_Query($args);
}

/**
 * Portfolio shortcode
 */
function nordic_tech_portfolio_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => -1,
        'category' => '',
        'columns' => 3
    ), $atts);
    
    $args = array(
        'posts_per_page' => $atts['limit']
    );
    
    if (!empty($atts['category'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'portfolio_category',
                'field'    => 'slug',
                'terms'    => $atts['category'],
            ),
        );
    }
    
    $portfolio_query = nordic_tech_get_portfolio_items($args);
    
    if (!$portfolio_query->have_posts()) {
        return '<p>' . __('No portfolio items found.', 'nordic-tech') . '</p>';
    }
    
    ob_start();
    ?>
    <div class="portfolio-grid columns-<?php echo esc_attr($atts['columns']); ?>">
        <?php while ($portfolio_query->have_posts()) : $portfolio_query->the_post(); ?>
            <div class="portfolio-item">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="portfolio-image">
                        <?php the_post_thumbnail('medium'); ?>
                    </div>
                <?php endif; ?>
                
                <div class="portfolio-content">
                    <h3 class="portfolio-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    
                    <?php if (get_the_excerpt()) : ?>
                        <div class="portfolio-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php 
                    $technologies = get_post_meta(get_the_ID(), '_project_technologies', true);
                    if ($technologies) :
                        $tech_array = array_map('trim', explode(',', $technologies));
                    ?>
                        <div class="portfolio-technologies">
                            <?php foreach ($tech_array as $tech) : ?>
                                <span class="tech-tag"><?php echo esc_html($tech); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <?php
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode('portfolio', 'nordic_tech_portfolio_shortcode');

/**
 * Flush rewrite rules on theme activation
 */
function nordic_tech_flush_rewrite_rules() {
    nordic_tech_register_portfolio_post_type();
    nordic_tech_register_portfolio_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'nordic_tech_flush_rewrite_rules');