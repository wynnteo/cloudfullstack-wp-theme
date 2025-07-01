<?php get_header(); ?>

<main class="container">
    <?php if (is_home() && is_front_page()) : ?>
    <section class="hero">
        <h1><?php echo esc_html(get_theme_mod('hero_title', 'Welcome to Nordic Tech')); ?></h1>
        <p><?php echo esc_html(get_theme_mod('hero_description', 'Exploring the intersection of technology, design, and Scandinavian minimalism. Join me on a journey through clean code, elegant solutions, and thoughtful innovation.')); ?></p>
        
        <?php if (get_theme_mod('hero_show_button', true)) : ?>
            <div class="hero-actions">
                <a href="<?php echo esc_url(get_theme_mod('hero_button_url', '#')); ?>" class="hero-button">
                    <?php echo esc_html(get_theme_mod('hero_button_text', 'Get Started')); ?>
                </a>
            </div>
        <?php endif; ?>
    </section>
    <?php endif; ?>

    <div class="main-content">
        <div class="content-area">
            <?php if (have_posts()) : ?>
                <!-- Category Filter -->
                <div class="categories">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="category-tag <?php echo is_home() && !is_category() ? 'active' : ''; ?>">
                        <?php esc_html_e('All Posts', 'nordic-tech'); ?>
                    </a>
                    <?php
                    $categories = get_categories(array(
                        'orderby' => 'count',
                        'order'   => 'DESC',
                        'number'  => 5
                    ));
                    foreach ($categories as $category) {
                        $is_active = is_category($category->term_id) ? 'active' : '';
                        echo '<a href="' . get_category_link($category->term_id) . '" class="category-tag ' . $is_active . '">' . $category->name . '</a>';
                    }
                    ?>
                </div>

                <!-- Posts Grid -->
                <div class="posts-grid" id="postsGrid">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-image">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>
                            <?php else : ?>
                                <div class="post-image"></div>
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
                </div>
                
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
                <div class="post-card">
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