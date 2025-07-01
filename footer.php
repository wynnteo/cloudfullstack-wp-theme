</div><!-- #content -->
</div><!-- #page -->

<footer id="colophon" class="site-footer">
    <div class="container">
        <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) : ?>
            <div class="footer-widgets">
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
            <!-- Default footer content matching wp.html structure -->
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?php esc_html_e('About', 'nordic-tech'); ?> <?php bloginfo('name'); ?></h3>
                    <p><?php 
                        $description = get_bloginfo('description');
                        if ($description) {
                            echo esc_html($description);
                        } else {
                            esc_html_e('A personal blog exploring the intersection of technology, design, and Scandinavian minimalism. I share insights on clean code, thoughtful design, and building meaningful digital experiences.', 'nordic-tech');
                        }
                    ?></p>
                    <p><?php esc_html_e('Based in Stockholm, Sweden 🇸🇪', 'nordic-tech'); ?></p>
                </div>
                
                <div class="footer-section">
                    <h3><?php esc_html_e('Connect', 'nordic-tech'); ?></h3>
                    <ul>
                        <li><a href="mailto:hello@nordictech.dev">hello@nordictech.dev</a></li>
                        <li><a href="tel:+46123456789">+46 123 456 789</a></li>
                        <li><?php esc_html_e('Stockholm, Sweden', 'nordic-tech'); ?></li>
                    </ul>
                    <div class="footer-social">
                        <a href="#" title="<?php esc_attr_e('GitHub', 'nordic-tech'); ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                            </svg>
                        </a>
                        <a href="#" title="<?php esc_attr_e('Medium', 'nordic-tech'); ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M13.54 12a6.8 6.8 0 01-6.77 6.82A6.8 6.8 0 010 12a6.8 6.8 0 016.77-6.82A6.8 6.8 0 0113.54 12zM20.96 12c0 3.54-1.51 6.42-3.38 6.42-1.87 0-3.39-2.88-3.39-6.42s1.52-6.42 3.39-6.42 3.38 2.88 3.38 6.42M24 12c0 3.17-.53 5.75-1.19 5.75-.66 0-1.19-2.58-1.19-5.75s.53-5.75 1.19-5.75C23.47 6.25 24 8.83 24 12z"/>
                            </svg>
                        </a>
                        <a href="#" title="<?php esc_attr_e('LinkedIn', 'nordic-tech'); ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" title="<?php esc_attr_e('Twitter', 'nordic-tech'); ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3><?php esc_html_e('Recent Posts', 'nordic-tech'); ?></h3>
                    <ul>
                        <?php
                        $recent_posts = wp_get_recent_posts(array(
                            'numberposts' => 5,
                            'post_status' => 'publish'
                        ));
                        
                        if (!empty($recent_posts)) :
                            foreach ($recent_posts as $post) :
                        ?>
                            <li>
                                <a href="<?php echo get_permalink($post['ID']); ?>">
                                    <?php echo esc_html($post['post_title']); ?>
                                </a>
                            </li>
                        <?php 
                            endforeach; 
                            wp_reset_query(); 
                        else : 
                        ?>
                            <!-- Default posts if no posts exist -->
                            <li><a href="#"><?php esc_html_e('Modern JavaScript Patterns for Clean Code', 'nordic-tech'); ?></a></li>
                            <li><a href="#"><?php esc_html_e('Scandinavian Design Principles in Web Development', 'nordic-tech'); ?></a></li>
                            <li><a href="#"><?php esc_html_e('Building a Productive Development Environment', 'nordic-tech'); ?></a></li>
                            <li><a href="#"><?php esc_html_e('Complete Guide to CSS Grid Layout', 'nordic-tech'); ?></a></li>
                            <li><a href="#"><?php esc_html_e('TypeScript Best Practices', 'nordic-tech'); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="footer-bottom">
            <p>
                <?php
                printf(
                    esc_html__('&copy; %1$s %2$s. Built with passion for clean code and beautiful design. Made in Sweden 🌲', 'nordic-tech'),
                    date('Y'),
                    get_bloginfo('name')
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
    const animatedElements = document.querySelectorAll('.post, .widget, .footer-section');
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