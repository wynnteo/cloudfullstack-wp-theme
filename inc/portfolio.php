<?php
/**
 * Portfolio functionality for Nordic Tech theme
 * 
 * @package Nordic_Tech
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

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
 * Register Portfolio Taxonomies
 */
function nordic_tech_register_portfolio_taxonomies() {
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
add_action('init', 'nordic_tech_register_portfolio_taxonomies');

/**
 * Portfolio Meta Boxes
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