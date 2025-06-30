<?php get_header(); ?>

<main class="container">
    <div class="main-content">
        <div class="content-area">
            <header class="page-header">
                <h1 class="page-title">
                    <?php
                    printf(
                        esc_html__('Search Results for: %s', 'nordic-tech'),
                        '<span>' . get_search_query() . '</span>'
                    );
                    ?>
                </h1>
            </header>

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
                        <h2 class="post-title"><?php esc_html_e('Nothing found', 'nordic-tech'); ?></h2>
                        <p class="post-excerpt">
                            <?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'nordic-tech'); ?>
                        </p>
                        <?php get_search_form(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>