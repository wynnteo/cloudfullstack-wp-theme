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

require get_template_directory() . '/inc/portfolio.php';

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
        'before_widget' => '<div id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget 2', 'nordic-tech'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add widgets here to appear in the second footer column.', 'nordic-tech'),
        'before_widget' => '<div id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Footer Widget 3', 'nordic-tech'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Add widgets here to appear in the third footer column.', 'nordic-tech'),
        'before_widget' => '<div id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'nordic_tech_widgets_init');

/**
 * Custom About Widget
 */
class Nordic_About_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'nordic_about_widget',
            __('Nordic About', 'nordic-tech'),
            array('description' => __('Display about information with contact details', 'nordic-tech'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        echo '<div class="about-widget-content">';
        
        if (!empty($instance['description'])) {
            echo '<p>' . wp_kses_post($instance['description']) . '</p>';
        }
        
        if (!empty($instance['location'])) {
            echo '<p>' . esc_html($instance['location']) . '</p>';
        }
        
        echo '</div>';
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('About', 'nordic-tech');
        $description = !empty($instance['description']) ? $instance['description'] : '';
        $location = !empty($instance['location']) ? $instance['location'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'nordic-tech'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php _e('Description:', 'nordic-tech'); ?></label>
            <textarea class="widefat" rows="5" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php echo esc_textarea($description); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('location')); ?>"><?php _e('Location:', 'nordic-tech'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('location')); ?>" name="<?php echo esc_attr($this->get_field_name('location')); ?>" type="text" value="<?php echo esc_attr($location); ?>">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['description'] = (!empty($new_instance['description'])) ? wp_kses_post($new_instance['description']) : '';
        $instance['location'] = (!empty($new_instance['location'])) ? sanitize_text_field($new_instance['location']) : '';
        return $instance;
    }
}

/**
 * Custom Contact Widget
 */
class Nordic_Contact_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'nordic_contact_widget',
            __('Nordic Contact', 'nordic-tech'),
            array('description' => __('Display contact information and social links', 'nordic-tech'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        echo '<div class="contact-widget-content">';
        echo '<ul>';
        
        if (!empty($instance['email'])) {
            echo '<li><a href="mailto:' . esc_attr($instance['email']) . '">' . esc_html($instance['email']) . '</a></li>';
        }
        
        if (!empty($instance['phone'])) {
            echo '<li><a href="tel:' . esc_attr($instance['phone']) . '">' . esc_html($instance['phone']) . '</a></li>';
        }
        
        if (!empty($instance['address'])) {
            echo '<li>' . esc_html($instance['address']) . '</li>';
        }
        
        echo '</ul>';
        
        // Social Links
        if (!empty($instance['github']) || !empty($instance['medium']) || !empty($instance['linkedin']) || !empty($instance['twitter'])) {
            echo '<div class="footer-social">';
            
            if (!empty($instance['github'])) {
                echo '<a href="' . esc_url($instance['github']) . '" title="GitHub">';
                echo '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>';
                echo '</a>';
            }
            
            if (!empty($instance['medium'])) {
                echo '<a href="' . esc_url($instance['medium']) . '" title="Medium">';
                echo '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M13.54 12a6.8 6.8 0 01-6.77 6.82A6.8 6.8 0 010 12a6.8 6.8 0 016.77-6.82A6.8 6.8 0 0113.54 12zM20.96 12c0 3.54-1.51 6.42-3.38 6.42-1.87 0-3.39-2.88-3.39-6.42s1.52-6.42 3.39-6.42 3.38 2.88 3.38 6.42M24 12c0 3.17-.53 5.75-1.19 5.75-.66 0-1.19-2.58-1.19-5.75s.53-5.75 1.19-5.75C23.47 6.25 24 8.83 24 12z"/></svg>';
                echo '</a>';
            }
            
            if (!empty($instance['linkedin'])) {
                echo '<a href="' . esc_url($instance['linkedin']) . '" title="LinkedIn">';
                echo '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>';
                echo '</a>';
            }
            
            if (!empty($instance['twitter'])) {
                echo '<a href="' . esc_url($instance['twitter']) . '" title="Twitter">';
                echo '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>';
                echo '</a>';
            }
            
            echo '</div>';
        }
        
        echo '</div>';
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Connect', 'nordic-tech');
        $email = !empty($instance['email']) ? $instance['email'] : '';
        $phone = !empty($instance['phone']) ? $instance['phone'] : '';
        $address = !empty($instance['address']) ? $instance['address'] : '';
        $github = !empty($instance['github']) ? $instance['github'] : '';
        $medium = !empty($instance['medium']) ? $instance['medium'] : '';
        $linkedin = !empty($instance['linkedin']) ? $instance['linkedin'] : '';
        $twitter = !empty($instance['twitter']) ? $instance['twitter'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'nordic-tech'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('email')); ?>"><?php _e('Email:', 'nordic-tech'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('email')); ?>" name="<?php echo esc_attr($this->get_field_name('email')); ?>" type="email" value="<?php echo esc_attr($email); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('phone')); ?>"><?php _e('Phone:', 'nordic-tech'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('phone')); ?>" name="<?php echo esc_attr($this->get_field_name('phone')); ?>" type="text" value="<?php echo esc_attr($phone); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('address')); ?>"><?php _e('Address:', 'nordic-tech'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('address')); ?>" name="<?php echo esc_attr($this->get_field_name('address')); ?>" type="text" value="<?php echo esc_attr($address); ?>">
        </p>
        <hr>
        <h4><?php _e('Social Links:', 'nordic-tech'); ?></h4>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('github')); ?>"><?php _e('GitHub URL:', 'nordic-tech'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('github')); ?>" name="<?php echo esc_attr($this->get_field_name('github')); ?>" type="url" value="<?php echo esc_attr($github); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('medium')); ?>"><?php _e('Medium URL:', 'nordic-tech'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('medium')); ?>" name="<?php echo esc_attr($this->get_field_name('medium')); ?>" type="url" value="<?php echo esc_attr($medium); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('linkedin')); ?>"><?php _e('LinkedIn URL:', 'nordic-tech'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('linkedin')); ?>" name="<?php echo esc_attr($this->get_field_name('linkedin')); ?>" type="url" value="<?php echo esc_attr($linkedin); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('twitter')); ?>"><?php _e('Twitter URL:', 'nordic-tech'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('twitter')); ?>" name="<?php echo esc_attr($this->get_field_name('twitter')); ?>" type="url" value="<?php echo esc_attr($twitter); ?>">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['email'] = (!empty($new_instance['email'])) ? sanitize_email($new_instance['email']) : '';
        $instance['phone'] = (!empty($new_instance['phone'])) ? sanitize_text_field($new_instance['phone']) : '';
        $instance['address'] = (!empty($new_instance['address'])) ? sanitize_text_field($new_instance['address']) : '';
        $instance['github'] = (!empty($new_instance['github'])) ? esc_url_raw($new_instance['github']) : '';
        $instance['medium'] = (!empty($new_instance['medium'])) ? esc_url_raw($new_instance['medium']) : '';
        $instance['linkedin'] = (!empty($new_instance['linkedin'])) ? esc_url_raw($new_instance['linkedin']) : '';
        $instance['twitter'] = (!empty($new_instance['twitter'])) ? esc_url_raw($new_instance['twitter']) : '';
        return $instance;
    }
}

/**
 * Custom Recent Posts Widget (Enhanced)
 */
class Nordic_Recent_Posts_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'nordic_recent_posts_widget',
            __('Nordic Recent Posts', 'nordic-tech'),
            array('description' => __('Display recent posts with customizable options', 'nordic-tech'))
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        
        $number = (!empty($instance['number'])) ? absint($instance['number']) : 5;
        $show_date = isset($instance['show_date']) ? $instance['show_date'] : false;
        
        $recent_posts = wp_get_recent_posts(array(
            'numberposts' => $number,
            'post_status' => 'publish'
        ));
        
        if (!empty($recent_posts)) {
            echo '<ul>';
            foreach ($recent_posts as $post) {
                echo '<li>';
                echo '<a href="' . get_permalink($post['ID']) . '">';
                echo esc_html($post['post_title']);
                echo '</a>';
                if ($show_date) {
                    echo '<span class="post-date"> - ' . date_i18n(get_option('date_format'), strtotime($post['post_date'])) . '</span>';
                }
                echo '</li>';
            }
            echo '</ul>';
            wp_reset_query();
        } else {
            echo '<ul>';
            echo '<li><a href="#">' . __('Modern JavaScript Patterns for Clean Code', 'nordic-tech') . '</a></li>';
            echo '<li><a href="#">' . __('Scandinavian Design Principles in Web Development', 'nordic-tech') . '</a></li>';
            echo '<li><a href="#">' . __('Building a Productive Development Environment', 'nordic-tech') . '</a></li>';
            echo '<li><a href="#">' . __('Complete Guide to CSS Grid Layout', 'nordic-tech') . '</a></li>';
            echo '<li><a href="#">' . __('TypeScript Best Practices', 'nordic-tech') . '</a></li>';
            echo '</ul>';
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Recent Posts', 'nordic-tech');
        $number = !empty($instance['number']) ? absint($instance['number']) : 5;
        $show_date = isset($instance['show_date']) ? (bool) $instance['show_date'] : false;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'nordic-tech'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php _e('Number of posts to show:', 'nordic-tech'); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($number); ?>" size="3">
        </p>
        <p>
            <input class="checkbox" type="checkbox"<?php checked($show_date); ?> id="<?php echo esc_attr($this->get_field_id('show_date')); ?>" name="<?php echo esc_attr($this->get_field_name('show_date')); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('show_date')); ?>"><?php _e('Display post date?', 'nordic-tech'); ?></label>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['number'] = (!empty($new_instance['number'])) ? absint($new_instance['number']) : 5;
        $instance['show_date'] = isset($new_instance['show_date']) ? (bool) $new_instance['show_date'] : false;
        return $instance;
    }
}

// Register the custom widgets
function nordic_tech_register_widgets() {
    register_widget('Nordic_About_Widget');
    register_widget('Nordic_Contact_Widget');
    register_widget('Nordic_Recent_Posts_Widget');
}
add_action('widgets_init', 'nordic_tech_register_widgets', 5);

/**
 * Auto-populate footer widgets on theme activation
 */
function nordic_tech_setup_default_widgets() {
    // Check if widgets are already set up
    error_log('Setting up default widgets...');
    
    // Check if widgets are already set up
    if (get_option('nordic_tech_widgets_setup')) {
        error_log('Widgets already set up, skipping...');
        return;
    }
    
    // Set up default widgets
    $footer_1_widgets = array(
        'nordic_about_widget-1' => array(
            'title' => 'About ' . get_bloginfo('name'),
            'description' => 'A personal blog exploring the intersection of technology, design, and Scandinavian minimalism. I share insights on clean code, thoughtful design, and building meaningful digital experiences.',
            'location' => 'Based in Stockholm, Sweden 🇸🇪'
        )
    );
    
    $footer_2_widgets = array(
        'nordic_contact_widget-1' => array(
            'title' => 'Connect',
            'email' => 'hello@nordictech.dev',
            'phone' => '+46 123 456 789',
            'address' => 'Stockholm, Sweden',
            'github' => 'https://github.com',
            'medium' => 'https://medium.com',
            'linkedin' => 'https://linkedin.com',
            'twitter' => 'https://twitter.com'
        )
    );
    
    $footer_3_widgets = array(
        'nordic_recent_posts_widget-1' => array(
            'title' => 'Recent Posts',
            'number' => 5,
            'show_date' => false
        )
    );
    
    // Save widget instances
    update_option('widget_nordic_about_widget', array(1 => $footer_1_widgets['nordic_about_widget-1'], '_multiwidget' => 1));
    update_option('widget_nordic_contact_widget', array(1 => $footer_2_widgets['nordic_contact_widget-1'], '_multiwidget' => 1));
    update_option('widget_nordic_recent_posts_widget', array(1 => $footer_3_widgets['nordic_recent_posts_widget-1'], '_multiwidget' => 1));
    
    // Assign widgets to sidebars
    update_option('sidebars_widgets', array(
        'footer-1' => array('nordic_about_widget-1'),
        'footer-2' => array('nordic_contact_widget-1'),
        'footer-3' => array('nordic_recent_posts_widget-1'),
        'wp_inactive_widgets' => array(),
        'array_version' => 3
    ));
    
    // Mark widgets as set up
    update_option('nordic_tech_widgets_setup', true);
}
add_action('after_switch_theme', 'nordic_tech_setup_default_widgets', 15);

/**
 * Reset widgets setup flag when switching away from theme
 */
function nordic_tech_cleanup_widgets() {
    delete_option('nordic_tech_widgets_setup');
}
add_action('switch_theme', 'nordic_tech_cleanup_widgets');

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
 * Flush rewrite rules on theme activation
 */
function nordic_tech_flush_rewrite_rules() {
    nordic_tech_register_portfolio_post_type();
    nordic_tech_register_portfolio_taxonomy();
}
register_activation_hook(__FILE__, 'nordic_tech_flush_rewrite_rules');


// Add Customizer settings for hero section
function nordic_tech_customize_register($wp_customize) {
    // Hero Section Panel
    $wp_customize->add_section('hero_section', array(
        'title'    => __('Hero Section', 'nordic-tech'),
        'priority' => 30,
    ));

    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default'           => 'Welcome to Nordic Tech',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label'    => __('Hero Title', 'nordic-tech'),
        'section'  => 'hero_section',
        'type'     => 'text',
    ));

    // Hero Description
    $wp_customize->add_setting('hero_description', array(
        'default'           => 'Exploring the intersection of technology, design, and Scandinavian minimalism. Join me on a journey through clean code, elegant solutions, and thoughtful innovation.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('hero_description', array(
        'label'    => __('Hero Description', 'nordic-tech'),
        'section'  => 'hero_section',
        'type'     => 'textarea',
    ));

    // Show Button Toggle
    $wp_customize->add_setting('hero_show_button', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('hero_show_button', array(
        'label'    => __('Show Hero Button', 'nordic-tech'),
        'section'  => 'hero_section',
        'type'     => 'checkbox',
    ));

    // Button Text
    $wp_customize->add_setting('hero_button_text', array(
        'default'           => 'Get Started',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('hero_button_text', array(
        'label'    => __('Button Text', 'nordic-tech'),
        'section'  => 'hero_section',
        'type'     => 'text',
    ));

    // Button URL
    $wp_customize->add_setting('hero_button_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('hero_button_url', array(
        'label'    => __('Button URL', 'nordic-tech'),
        'section'  => 'hero_section',
        'type'     => 'url',
    ));
}
add_action('customize_register', 'nordic_tech_customize_register');

function nordic_tech_customize_register_portfolio_archive($wp_customize) {
    // Portfolio Archive Section
    $wp_customize->add_section('portfolio_archive_section', array(
        'title'    => __('Portfolio Archive', 'nordic-tech'),
        'priority' => 35,
    ));

    // Archive Title
    $wp_customize->add_setting('portfolio_archive_title', array(
        'default'           => 'My Portfolio',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('portfolio_archive_title', array(
        'label'    => __('Portfolio Archive Title', 'nordic-tech'),
        'section'  => 'portfolio_archive_section',
        'type'     => 'text',
    ));

    // Archive Description
    $wp_customize->add_setting('portfolio_archive_description', array(
        'default'           => 'A showcase of my creative work and technical projects.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('portfolio_archive_description', array(
        'label'    => __('Portfolio Archive Description', 'nordic-tech'),
        'section'  => 'portfolio_archive_section',
        'type'     => 'textarea',
    ));

    // Show Button Toggle
    $wp_customize->add_setting('portfolio_show_button', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('portfolio_show_button', array(
        'label'    => __('Show Portfolio Button', 'nordic-tech'),
        'section'  => 'portfolio_archive_section',
        'type'     => 'checkbox',
    ));

    // Button Text
    $wp_customize->add_setting('portfolio_button_text', array(
        'default'           => 'View Featured Work',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('portfolio_button_text', array(
        'label'    => __('Portfolio Button Text', 'nordic-tech'),
        'section'  => 'portfolio_archive_section',
        'type'     => 'text',
    ));

    // Button URL
    $wp_customize->add_setting('portfolio_button_url', array(
        'default'           => '#featured',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('portfolio_button_url', array(
        'label'    => __('Portfolio Button URL', 'nordic-tech'),
        'section'  => 'portfolio_archive_section',
        'type'     => 'url',
    ));
}
add_action('customize_register', 'nordic_tech_customize_register_portfolio_archive');
?>