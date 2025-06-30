<?php get_header(); ?>

<main class="container">
    <div class="main-content">
        <div class="content-area">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('post single-post'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="post-content">
                        <div class="post-meta">
                            <span><?php echo get_the_date(); ?></span>
                            <span>•</span>
                            <span><?php echo esc_html(nordic_tech_reading_time()); ?> min read</span>
                            <span>•</span>
                            <span><?php the_author(); ?></span>
                            <?php if (has_category()) : ?>
                                <span>•</span>
                                <span><?php the_category(', '); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <h1 class="post-title"><?php the_title(); ?></h1>
                        
                        <div class="post-body">
                            <?php the_content(); ?>
                        </div>
                        
                        <?php if (has_tag()) : ?>
                            <div class="post-tags">
                                <?php
                                $tags = get_the_tags();
                                if ($tags) {
                                    foreach ($tags as $tag) {
                                        echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag">' . $tag->name . '</a>';
                                    }
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Post navigation -->
                        <nav class="post-navigation">
                            <div class="nav-previous">
                                <?php previous_post_link('%link', '← %title'); ?>
                            </div>
                            <div class="nav-next">
                                <?php next_post_link('%link', '%title →'); ?>
                            </div>
                        </nav>
                    </div>
                </article>
                
                <!-- Related Posts Section -->
                <?php
                $categories = get_the_category($post->ID);
                if ($categories) {
                    $category_ids = array();
                    foreach ($categories as $individual_category) $category_ids[] = $individual_category->term_id;
                    
                    $args = array(
                        'category__in' => $category_ids,
                        'post__not_in' => array($post->ID),
                        'posts_per_page' => 3,
                    );
                    $related_posts = new WP_Query($args);
                    
                    if ($related_posts->have_posts()) :
                ?>
                <div class="related-posts">
                    <h3>Related Posts</h3>
                    <div class="related-grid">
                        <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                        <div class="related-card">
                            <div class="related-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                <?php endif; ?>
                            </div>
                            <div class="related-content">
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php 
                    endif;
                    wp_reset_postdata();
                }
                ?>
                
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