<?php get_header(); ?>

<main class="container">
    <!-- Search Results Hero Section -->
    <section class="hero">
        <h1>Search Results</h1>
        <p>
            <?php
            printf(
                esc_html__('Found results for: %s', 'nordic-tech'),
                '<strong>' . get_search_query() . '</strong>'
            );
            ?>
        </p>
    </section>

    <div class="main-content">
        <div class="content-area">
            <?php if (have_posts()) : ?>
                <!-- Search Statistics -->
                <div class="search-stats">
                    <p>
                        <?php
                        global $wp_query;
                        printf(
                            esc_html__('Showing %d results', 'nordic-tech'),
                            $wp_query->found_posts
                        );
                        ?>
                    </p>
                </div>

                <!-- Search Results Grid -->
                <div class="posts-grid" id="searchResults">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('post-card-thumbnail'); ?>
                                    </a>
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
                                    <?php 
                                    // Enhanced excerpt with search term highlighting
                                    $excerpt = get_the_excerpt();
                                    $search_query = get_search_query();
                                    if ($search_query) {
                                        $excerpt = preg_replace(
                                            '/(' . preg_quote($search_query, '/') . ')/i',
                                            '<mark>$1</mark>',
                                            $excerpt
                                        );
                                    }
                                    echo $excerpt;
                                    ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="read-more">
                                    <?php esc_html_e('Read more', 'nordic-tech'); ?> →
                                </a>
                                
                                <!-- Post Tags -->
                                <?php
                                $tags = get_the_tags();
                                if ($tags) : ?>
                                    <div class="post-tags">
                                        <?php foreach ($tags as $tag) : ?>
                                            <a href="<?php echo get_tag_link($tag->term_id); ?>" class="tag">
                                                <?php echo esc_html($tag->name); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                
                <!-- Pagination -->
                <?php if (get_next_posts_link() || get_previous_posts_link()) : ?>
                    <nav class="pagination">
                        <?php
                        echo paginate_links(array(
                            'prev_text' => '← Previous',
                            'next_text' => 'Next →',
                            'mid_size' => 2,
                            'end_size' => 1,
                        ));
                        ?>
                    </nav>
                <?php endif; ?>
                
            <?php else : ?>
                <!-- No Results Found -->
                <div class="no-results">
                    <div class="no-results-content">
                        <h2><?php esc_html_e('No results found', 'nordic-tech'); ?></h2>
                        <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'nordic-tech'); ?></p>
                        
                        <!-- Search Form -->
                        <div class="search-form-container">
                            <?php get_search_form(); ?>
                        </div>
                        
                        <!-- Search Suggestions -->
                        <div class="search-suggestions">
                            <h3><?php esc_html_e('Try searching for:', 'nordic-tech'); ?></h3>
                            <div class="suggestion-tags">
                                <?php
                                // Get popular tags for suggestions
                                $popular_tags = get_tags(array(
                                    'orderby' => 'count',
                                    'order' => 'DESC',
                                    'number' => 8,
                                ));
                                
                                if ($popular_tags) :
                                    foreach ($popular_tags as $tag) : ?>
                                        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="tag">
                                            <?php echo esc_html($tag->name); ?>
                                        </a>
                                    <?php endforeach;
                                endif;
                                ?>
                            </div>
                        </div>
                        
                        <!-- Recent Posts -->
                        <div class="recent-posts-section">
                            <h3><?php esc_html_e('Recent Posts', 'nordic-tech'); ?></h3>
                            <div class="recent-posts-grid">
                                <?php
                                $recent_posts = new WP_Query(array(
                                    'posts_per_page' => 3,
                                    'post_status' => 'publish',
                                    'ignore_sticky_posts' => true,
                                ));
                                
                                if ($recent_posts->have_posts()) :
                                    while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                                        <div class="recent-post-card">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="recent-post-image">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail('related-post-thumbnail'); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            <div class="recent-post-content">
                                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                                <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                            </div>
                                        </div>
                                    <?php endwhile;
                                    wp_reset_postdata();
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <?php get_sidebar(); ?>
    </div>
</main>

<!-- Enhanced Search JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Highlight search terms in results
    const searchQuery = '<?php echo esc_js(get_search_query()); ?>';
    if (searchQuery) {
        const posts = document.querySelectorAll('.post-card');
        posts.forEach(post => {
            const title = post.querySelector('.post-title a');
            const excerpt = post.querySelector('.post-excerpt');
            
            if (title && excerpt) {
                // Highlight in title (if not already highlighted)
                if (!title.innerHTML.includes('<mark>')) {
                    title.innerHTML = title.innerHTML.replace(
                        new RegExp('(' + searchQuery + ')', 'gi'),
                        '<mark>$1</mark>'
                    );
                }
            }
        });
    }
    
    // Live search functionality for the search form
    const searchField = document.querySelector('.search-field');
    if (searchField) {
        let searchTimeout;
        searchField.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.toLowerCase();
            
            if (query.length > 2) {
                searchTimeout = setTimeout(function() {
                    // This would typically trigger an AJAX search
                    // For now, we'll just filter visible results
                    const posts = document.querySelectorAll('.post-card');
                    posts.forEach(post => {
                        const title = post.querySelector('.post-title').textContent.toLowerCase();
                        const excerpt = post.querySelector('.post-excerpt').textContent.toLowerCase();
                        const tags = Array.from(post.querySelectorAll('.tag')).map(tag => 
                            tag.textContent.toLowerCase()
                        );
                        
                        const matches = title.includes(query) || 
                                      excerpt.includes(query) || 
                                      tags.some(tag => tag.includes(query));
                        
                        post.style.display = matches ? 'block' : 'none';
                    });
                }, 300);
            } else {
                // Show all posts if query is too short
                document.querySelectorAll('.post-card').forEach(post => {
                    post.style.display = 'block';
                });
            }
        });
    }
    
    // Animate search results on load
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
    
    // Observe search result cards
    const cards = document.querySelectorAll('.post-card, .recent-post-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
});
</script>

<?php get_footer(); ?>