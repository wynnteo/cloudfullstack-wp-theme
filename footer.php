</div><!-- #content -->
</div><!-- #page -->

<footer id="colophon" class="site-footer">
    <div class="container">
        <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) : ?>
            <div class="footer-content">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-widget">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (is_active_sidebar('footer-2')) : ?>
                    <div class="footer-widget">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (is_active_sidebar('footer-3')) : ?>
                    <div class="footer-widget">
                        <?php dynamic_sidebar('footer-3'); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <!-- Default footer content when no widgets are active -->
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?php esc_html_e('About', 'nordic-tech'); ?> <?php bloginfo('name'); ?></h3>
                    <p><?php echo get_bloginfo('description') ?: esc_html__('A clean, minimalist WordPress theme inspired by Scandinavian design principles.', 'nordic-tech'); ?></p>
                </div>
                
                <div class="footer-section">
                    <h3><?php esc_html_e('Quick Links', 'nordic-tech'); ?></h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_id'        => 'footer-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>
                
                <div class="footer-section">
                    <h3><?php esc_html_e('Recent Posts', 'nordic-tech'); ?></h3>
                    <ul>
                        <?php
                        $recent_posts = wp_get_recent_posts(array(
                            'numberposts' => 5,
                            'post_status' => 'publish'
                        ));
                        foreach ($recent_posts as $post) :
                        ?>
                            <li>
                                <a href="<?php echo get_permalink($post['ID']); ?>">
                                    <?php echo esc_html($post['post_title']); ?>
                                </a>
                            </li>
                        <?php endforeach; wp_reset_query(); ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="footer-bottom">
            <p>
                <?php
                printf(
                    esc_html__('&copy; %1$s %2$s. Built with %3$s and %4$s.', 'nordic-tech'),
                    date('Y'),
                    get_bloginfo('name'),
                    '<a href="https://wordpress.org/" target="_blank" rel="noopener">WordPress</a>',
                    '<a href="#" target="_blank" rel="noopener">Nordic Tech Theme</a>'
                );
                ?>
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

<script>
// Basic search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-box input[type="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            // You can add live search functionality here if needed
        });
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Add animation classes on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe post cards and widgets
    const animatedElements = document.querySelectorAll('.post, .widget');
    animatedElements.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(element);
    });
});
</script>

</body>
</html>