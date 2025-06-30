<?php get_header(); ?>

<main class="container">
    <!-- Add hero section for pages if needed -->
    <?php if (is_front_page()) : ?>
    <section class="hero">
        <h1>Welcome to Nordic Tech</h1>
        <p>Exploring the intersection of technology, design, and Scandinavian minimalism. Join me on a journey through clean code, elegant solutions, and thoughtful innovation.</p>
    </section>
    <?php endif; ?>

    <div class="main-content">
        <div class="content-area">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('post single-page'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="post-content">
                        <h1 class="post-title"><?php the_title(); ?></h1>
                        
                        <?php if (has_excerpt()) : ?>
                            <div class="page-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-body">
                            <?php the_content(); ?>
                        </div>
                        
                        <?php
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'nordic-tech'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </article>
                
                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
                
            <?php endwhile; ?>
        </div>
        
        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>