<?php get_header(); ?>

<main class="container">
    <div class="main-content">
        <div class="content-area">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
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
                            </div>
                            
                            <h2 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="read-more">
                                <?php esc_html_e('Read more', 'nordic-tech'); ?> →
                            </a>
                            
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
                        </div>
                    </article>
                <?php endwhile; ?>
                
                <!-- Pagination -->
                <nav class="pagination">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '← Previous',
                        'next_text' => 'Next →',
                    ));
                    ?>
                </nav>
                
            <?php else : ?>
                <div class="post">
                    <div class="post-content">
                        <h2 class="post-title"><?php esc_html_e('No posts found', 'nordic-tech'); ?></h2>
                        <p class="post-excerpt">
                            <?php esc_html_e('Sorry, no posts were found. Please try searching for something else.', 'nordic-tech'); ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>