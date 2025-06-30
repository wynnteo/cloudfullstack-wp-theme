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
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    return $reading_time;
}

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