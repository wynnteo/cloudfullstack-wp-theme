<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Nordic_Tech
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar">
    <!-- About Section Widget -->
    <div class="widget about-section">
        <div class="profile-image">
            <?php 
            $author_id = get_the_author_meta('ID');
            echo get_avatar($author_id, 120, '', '', array('class' => 'profile-avatar'));
            ?>
        </div>
        <h3><?php the_author_meta('display_name', $author_id); ?></h3>
        <p><?php the_author_meta('description', $author_id); ?></p>
        <div class="social-links">
            <a href="mailto:<?php the_author_meta('user_email', $author_id); ?>" class="social-link" title="Email">📧</a>
            <a href="<?php the_author_meta('github', $author_id); ?>" class="social-link" title="GitHub">🐙</a>
            <a href="<?php the_author_meta('linkedin', $author_id); ?>" class="social-link" title="LinkedIn">💼</a>
            <a href="<?php the_author_meta('twitter', $author_id); ?>" class="social-link" title="Twitter">🐦</a>
        </div>
    </div>

    <!-- Categories Widget -->
    <div class="widget">
        <h3><?php esc_html_e('Categories', 'nordic-tech'); ?></h3>
        <ul class="widget-list">
            <?php
            $categories = get_categories();
            foreach ($categories as $category) {
                echo '<li><a href="' . get_category_link($category->term_id) . '">' . $category->name . ' (' . $category->count . ')</a></li>';
            }
            ?>
        </ul>
    </div>

    <!-- Popular Tags Widget -->
    <div class="widget">
        <h3><?php esc_html_e('Popular Tags', 'nordic-tech'); ?></h3>
        <ul class="widget-list">
            <?php
            $popular_tags = get_tags(array(
                'orderby' => 'count',
                'order' => 'DESC',
                'number' => 10
            ));
            foreach ($popular_tags as $tag) {
                echo '<li><a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a></li>';
            }
            ?>
        </ul>
    </div>

    <!-- Recent Posts Widget -->
    <div class="widget">
        <h3><?php esc_html_e('Recent Posts', 'nordic-tech'); ?></h3>
        <ul class="widget-list">
            <?php
            $recent_posts = wp_get_recent_posts(array(
                'numberposts' => 5,
                'post_status' => 'publish'
            ));
            foreach ($recent_posts as $post) {
                echo '<li><a href="' . get_permalink($post['ID']) . '">' . $post['post_title'] . '</a></li>';
            }
            wp_reset_query();
            ?>
        </ul>
    </div>

    <!-- Default WordPress Widgets -->
    <?php dynamic_sidebar('sidebar-1'); ?>
</aside><!-- #secondary -->