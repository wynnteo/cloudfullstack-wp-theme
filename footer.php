</div><!-- #content -->
</div><!-- #page -->

<footer id="colophon" class="site-footer">
    <div class="container">
        <?php 
        // Check if any footer widgets are active
        $has_widgets = is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3');
        
        if ($has_widgets) : ?>
            <div class="footer-content">
                <?php if (is_active_sidebar('footer-1')) : ?>
                    <div class="footer-section">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (is_active_sidebar('footer-2')) : ?>
                    <div class="footer-section">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (is_active_sidebar('footer-3')) : ?>
                    <div class="footer-section">
                        <?php dynamic_sidebar('footer-3'); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <!-- Fallback: Use default widgets programmatically -->
            <div class="footer-content">
                <div class="footer-section">
                    <?php
                    // About Widget
                    $about_widget = new Nordic_About_Widget();
                    $about_args = array(
                        'before_widget' => '<div class="footer-widget nordic_about_widget">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3 class="widget-title">',
                        'after_title' => '</h3>',
                    );
                    $about_instance = array(
                        'title' => 'About ' . get_bloginfo('name'),
                        'description' => get_bloginfo('description') ? get_bloginfo('description') : 'A personal blog exploring the intersection of technology, design, and Scandinavian minimalism. I share insights on clean code, thoughtful design, and building meaningful digital experiences.',
                        'location' => 'Based in Stockholm, Sweden 🇸🇪'
                    );
                    $about_widget->widget($about_args, $about_instance);
                    ?>
                </div>
                
                <div class="footer-section">
                    <?php
                    // Contact Widget
                    $contact_widget = new Nordic_Contact_Widget();
                    $contact_args = array(
                        'before_widget' => '<div class="footer-widget nordic_contact_widget">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3 class="widget-title">',
                        'after_title' => '</h3>',
                    );
                    $contact_instance = array(
                        'title' => 'Connect',
                        'email' => 'hello@nordictech.dev',
                        'phone' => '+46 123 456 789',
                        'address' => 'Stockholm, Sweden',
                        'github' => 'https://github.com',
                        'medium' => 'https://medium.com',
                        'linkedin' => 'https://linkedin.com',
                        'twitter' => 'https://twitter.com'
                    );
                    $contact_widget->widget($contact_args, $contact_instance);
                    ?>
                </div>
                
                <div class="footer-section">
                    <?php
                    // Recent Posts Widget
                    $recent_widget = new Nordic_Recent_Posts_Widget();
                    $recent_args = array(
                        'before_widget' => '<div class="footer-widget nordic_recent_posts_widget">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3 class="widget-title">',
                        'after_title' => '</h3>',
                    );
                    $recent_instance = array(
                        'title' => 'Recent Posts',
                        'number' => 5,
                        'show_date' => false
                    );
                    $recent_widget->widget($recent_args, $recent_instance);
                    ?>
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