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
        'before_widget' => '<div id="%1$s" class="widget %2$s">