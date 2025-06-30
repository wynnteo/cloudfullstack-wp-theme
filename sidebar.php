<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Nordic_Tech
 */

if (!is_active_sidebar('sidebar-1')) {
    // Still show default widgets even if no custom widgets are active
}
?>

<aside id="secondary" class="widget-area sidebar">
    <!-- About Section Widget -->
    <div class="widget about-section">
        <div class="profile-image">
            <?php 
            $author_id = 1; // Get the main author or use get_the_author_meta('ID') if on a post
            if (is_single() || is_author()) {
                $author_id = get_the_author_meta('ID');
            }
            echo get_avatar($author_id, 120, '', '', array('class' => 'profile-avatar'));
            ?>
        </div>
        <h3><?php echo get_the_author_meta('display_name', $author_id); ?></h3>
        <p>
            <?php 
            $author_description = get_the_author_meta('description', $author_id);
            if ($author_description) {
                echo esc_html($author_description);
            } else {
                echo esc_html__('Full-stack developer passionate about clean code, minimalist design, and creating meaningful digital experiences.', 'nordic-tech');
            }
            ?>
        </p>
        <div class="social-links">
            <a href="mailto:<?php echo get_the_author_meta('user_email', $author_id); ?>" class="social-link" title="Email">📧</a>
            <?php if (get_the_author_meta('github', $author_id)) : ?>
                <a href="<?php echo esc_url(get_the_author_meta('github', $author_id)); ?>" class="social-link" title="GitHub">🐙</a>
            <?php endif; ?>
            <?php if (get_the_author_meta('linkedin', $author_id)) : ?>
                <a href="<?php echo esc_url(get_the_author_meta('linkedin', $author_id)); ?>" class="social-link" title="LinkedIn">💼</a>
            <?php endif; ?>
            <?php if (get_the_author_meta('twitter', $author_id)) : ?>
                <a href="<?php echo esc_url(get_the_author_meta('twitter', $author_id)); ?>" class="social-link" title="Twitter">🐦</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Categories Widget -->
    <div class="widget">
        <h3><?php esc_html_e('Categories', 'nordic-tech'); ?></h3>
        <ul class="widget-list">
            <?php
            $categories = get_categories(array(
                'orderby' => 'count',
                'order' => 'DESC',
                'hide_empty' => true
            ));
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
                'number' => 10,
                'hide_empty' => true
            ));
            if ($popular_tags) {
                foreach ($popular_tags as $tag) {
                    echo '<li><a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a></li>';
                }
            } else {
                // Fallback content to match HTML structure
                echo '<li><a href="#">React</a></li>';
                echo '<li><a href="#">TypeScript</a></li>';
                echo '<li><a href="#">CSS Grid</a></li>';
                echo '<li><a href="#">Node.js</a></li>';
                echo '<li><a href="#">Minimalism</a></li>';
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
                echo '<li><a href="' . get_permalink($post['ID']) . '">' . esc_html($post['post_title']) . '</a></li>';
            }
            wp_reset_query();
            ?>
        </ul>
    </div>

    <!-- Default WordPress Widgets -->
    <?php if (is_active_sidebar('sidebar-1')) : ?>
        <?php dynamic_sidebar('sidebar-1'); ?>
    <?php endif; ?>
</aside><!-- #secondary -->