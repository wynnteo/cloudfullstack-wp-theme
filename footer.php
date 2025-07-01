</div><!-- #content -->
</div><!-- #page -->

<footer id="colophon" class="site-footer">
    <div class="container">
        <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) : ?>
            <div class="footer-widgets">
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
            <!-- Fallback content if no widgets are active -->
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
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor