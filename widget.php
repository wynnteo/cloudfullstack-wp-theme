<?php
/**
 * Custom Widgets for Nordic Tech Theme
 * Add this to your theme's functions.php or create a separate widgets.php file
 */

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

// Register the widgets
function nordic_tech_register_widgets() {
    register_widget('Nordic_About_Widget');
    register_widget('Nordic_Contact_Widget');
    register_widget('Nordic_Recent_Posts_Widget');
}
add_action('widgets_init', 'nordic_tech_register_widgets');

/**
 * Auto-populate footer widgets on theme activation
 */
function nordic_tech_setup_default_widgets() {
    // Check if widgets are already set up
    if (get_option('nordic_tech_widgets_setup')) {
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
add_action('after_switch_theme', 'nordic_tech_setup_default_widgets');

/**
 * Reset widgets setup flag when switching away from theme
 */
function nordic_tech_cleanup_widgets() {
    delete_option('nordic_tech_widgets_setup');
}
add_action('switch_theme', 'nordic_tech_cleanup_widgets');
?>