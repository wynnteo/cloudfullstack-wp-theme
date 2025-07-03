<?php
/**
 * Template Name: Portfolio
 * Template for displaying portfolio items
 */

get_header(); ?>

<main class="container">
    <!-- Portfolio Content -->
    <div class="tab-content active">
        <section class="hero">
            <h1><?php 
                    echo esc_html(get_theme_mod('portfolio_archive_title', 'My Portfolio'));
                    ?></h1>
            <p><?php 
                    echo esc_html(get_theme_mod('portfolio_archive_description', 'A showcase of my creative work and technical projects.'));
                    ?></p>
            <?php if (get_theme_mod('portfolio_show_button', true)) : ?>
                    <div class="hero-actions">
                        <a href="<?php echo esc_url(get_theme_mod('portfolio_button_url', '#featured')); ?>" class="btn btn-primary">
                            <?php echo esc_html(get_theme_mod('portfolio_button_text', 'View Featured Work')); ?>
                        </a>
                    </div>
                <?php endif; ?>
        </section>

        <?php
        // Portfolio filter by categories
        $portfolio_categories = get_terms(array(
            'taxonomy' => 'portfolio_category',
            'hide_empty' => true,
        ));
        
        if (!empty($portfolio_categories) && !is_wp_error($portfolio_categories)) : ?>
            <div class="portfolio-filters">
                <button class="filter-btn active" data-filter="*">All Projects</button>
                <?php foreach ($portfolio_categories as $category) : ?>
                    <button class="filter-btn" data-filter=".<?php echo esc_attr($category->slug); ?>">
                        <?php echo esc_html($category->name); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="portolio portfolio-grid" id="portfolioGrid">
            <?php
            // Get portfolio items
            $portfolio_query = nordic_tech_get_portfolio_items(array(
                'posts_per_page' => -1,
            ));

            if ($portfolio_query->have_posts()) :
                while ($portfolio_query->have_posts()) : $portfolio_query->the_post();
                    // Get portfolio meta data
                    $project_url = get_post_meta(get_the_ID(), '_project_url', true);
                    $github_url = get_post_meta(get_the_ID(), '_github_url', true);
                    $demo_url = get_post_meta(get_the_ID(), '_demo_url', true);
                    $client = get_post_meta(get_the_ID(), '_project_client', true);
                    $year = get_post_meta(get_the_ID(), '_project_year', true);
                    $technologies = get_post_meta(get_the_ID(), '_project_technologies', true);
                    
                    // Get portfolio categories for filtering
                    $portfolio_cats = get_the_terms(get_the_ID(), 'portfolio_category');
                    $cat_classes = '';
                    if ($portfolio_cats && !is_wp_error($portfolio_cats)) {
                        $cat_slugs = array_map(function($cat) { return $cat->slug; }, $portfolio_cats);
                        $cat_classes = implode(' ', $cat_slugs);
                    }
            ?>
                <div class="project-card <?php echo esc_attr($cat_classes); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="project-image">
                            <?php the_post_thumbnail('medium_large', array('alt' => get_the_title())); ?>
                            <div class="project-overlay">
                                <div class="project-links">
                                    <?php if ($project_url) : ?>
                                        <a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener noreferrer" class="project-link" title="View Project">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M14,3V5H17.59L7.76,14.83L9.17,16.24L19,6.41V10H21V3M19,19H5V5H12V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19Z" />
                                            </svg>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($github_url) : ?>
                                        <a href="<?php echo esc_url($github_url); ?>" target="_blank" rel="noopener noreferrer" class="project-link" title="View Code">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12,2A10,10 0 0,0 2,12C2,16.42 4.87,20.17 8.84,21.5C9.34,21.58 9.5,21.27 9.5,21C9.5,20.77 9.5,20.14 9.5,19.31C6.73,19.91 6.14,17.97 6.14,17.97C5.68,16.81 5.03,16.5 5.03,16.5C4.12,15.88 5.1,15.9 5.1,15.9C6.1,15.97 6.63,16.93 6.63,16.93C7.5,18.45 8.97,18 9.54,17.76C9.63,17.11 9.89,16.67 10.17,16.42C7.95,16.17 5.62,15.31 5.62,11.5C5.62,10.39 6,9.5 6.65,8.79C6.55,8.54 6.2,7.5 6.75,6.15C6.75,6.15 7.59,5.88 9.5,7.17C10.29,6.95 11.15,6.84 12,6.84C12.85,6.84 13.71,6.95 14.5,7.17C16.41,5.88 17.25,6.15 17.25,6.15C17.8,7.5 17.45,8.54 17.35,8.79C18,9.5 18.38,10.39 18.38,11.5C18.38,15.32 16.04,16.16 13.81,16.41C14.17,16.72 14.5,17.33 14.5,18.26C14.5,19.6 14.5,20.68 14.5,21C14.5,21.27 14.66,21.59 15.17,21.5C19.14,20.16 22,16.42 22,12A10,10 0 0,0 12,2Z" />
                                            </svg>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($demo_url) : ?>
                                        <a href="<?php echo esc_url($demo_url); ?>" target="_blank" rel="noopener noreferrer" class="project-link" title="Live Demo">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M12,6A6,6 0 0,1 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12A6,6 0 0,1 12,6M12,8A4,4 0 0,0 8,12A4,4 0 0,0 12,16A4,4 0 0,0 16,12A4,4 0 0,0 12,8Z" />
                                            </svg>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <a href="<?php the_permalink(); ?>" class="project-link" title="View Details">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M11,9H13V7H11M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M11,17H13V11H11V17Z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="project-image no-image">
                            <div class="placeholder-icon">
                                <svg width="60" height="60" viewBox="0 0 24 24" fill="currentColor" opacity="0.3">
                                    <path d="M21,17H7V3H21M21,1H7A2,2 0 0,0 5,3V17A2,2 0 0,0 7,19H21A2,2 0 0,0 23,17V3A2,2 0 0,0 21,1M3,5H1V21A2,2 0 0,0 3,23H19V21H3M15.96,10.29L13.21,13.83L11.25,11.47L8.5,15H19.5L15.96,10.29Z" />
                                </svg>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="project-info">
                        <div class="project-meta">
                            <?php if ($year) : ?>
                                <span class="project-year"><?php echo esc_html($year); ?></span>
                            <?php endif; ?>
                            <?php if ($client) : ?>
                                <span class="project-client"><?php echo esc_html($client); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <h3 class="project-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        
                        <?php if (get_the_excerpt()) : ?>
                            <p class="project-description"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                        <?php endif; ?>
                        
                        <?php if ($technologies) : 
                            $tech_array = array_map('trim', explode(',', $technologies));
                        ?>
                            <div class="project-tech">
                                <?php foreach ($tech_array as $tech) : ?>
                                    <span class="tech-tag"><?php echo esc_html($tech); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php
                        // Display portfolio categories
                        if ($portfolio_cats && !is_wp_error($portfolio_cats)) : ?>
                            <div class="project-categories">
                                <?php foreach ($portfolio_cats as $cat) : ?>
                                    <a href="<?php echo get_term_link($cat); ?>" class="category-link">
                                        <?php echo esc_html($cat->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php 
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <div class="no-portfolio-items">
                    <h3><?php _e('No Portfolio Items Found', 'nordic-tech'); ?></h3>
                    <p><?php _e('There are currently no portfolio items to display. Please check back later.', 'nordic-tech'); ?></p>
                </div>
            <?php endif; ?>
        </div>
        
        <?php
        // Pagination for portfolio items
        if ($portfolio_query->max_num_pages > 1) : ?>
            <div class="portfolio-pagination">
                <?php
                echo paginate_links(array(
                    'total' => $portfolio_query->max_num_pages,
                    'current' => max(1, get_query_var('paged')),
                    'mid_size' => 2,
                    'prev_text' => '← Previous',
                    'next_text' => 'Next →',
                ));
                ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
/* Portfolio specific styles to complement your existing CSS */
.portfolio-filters {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.filter-btn {
    background: var(--background-light);
    border: 2px solid transparent;
    padding: 0.5rem 1.5rem;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    color: var(--text-color);
}

.filter-btn:hover,
.filter-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.project-card {
    position: relative;
    background: var(--background);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    opacity: 1;
    transform: scale(1);
}

.project-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.project-image {
    position: relative;
    height: 250px;
    overflow: hidden;
    background: var(--background-light);
    display: flex;
    align-items: center;
    justify-content: center;
}

.project-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.project-card:hover .project-image img {
    transform: scale(1.05);
}

.project-image.no-image {
    background: linear-gradient(135deg, var(--background-light) 0%, #f8f9fa 100%);
}

.project-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(var(--primary-color-rgb), 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.project-card:hover .project-overlay {
    opacity: 1;
}

.project-links {
    display: flex;
    gap: 1rem;
}

.project-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.project-link:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

.project-info {
    padding: 1.5rem;
}

.project-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-light);
}

.project-year,
.project-client {
    font-weight: 500;
}

.project-title a {
    color: var(--text-color);
    text-decoration: none;
    font-size: 1.25rem;
    font-weight: 600;
    line-height: 1.4;
}

.project-title a:hover {
    color: var(--primary-color);
}

.project-description {
    margin: 1rem 0;
    color: var(--text-light);
    line-height: 1.6;
}

.project-tech {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin: 1rem 0;
}

.project-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 1rem;
}

.category-link {
    background: var(--accent-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.category-link:hover {
    background: var(--primary-color);
    transform: translateY(-1px);
}

.no-portfolio-items {
    text-align: center;
    padding: 3rem;
    color: var(--text-light);
}

.portfolio-pagination {
    display: flex;
    justify-content: center;
    margin-top: 3rem;
    gap: 0.5rem;
}

.portfolio-pagination a,
.portfolio-pagination span {
    padding: 0.5rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 5px;
    text-decoration: none;
    color: var(--text-color);
    transition: all 0.3s ease;
}

.portfolio-pagination a:hover,
.portfolio-pagination .current {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

/* Filtering animation */
.project-card.filtering-out {
    opacity: 0;
    transform: scale(0.8);
    pointer-events: none;
}

@media (max-width: 768px) {
    .portfolio-filters {
        justify-content: flex-start;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }
    
    .filter-btn {
        white-space: nowrap;
        flex-shrink: 0;
    }
    
    .project-links {
        gap: 0.5rem;
    }
    
    .project-link {
        width: 35px;
        height: 35px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const filterBtns = document.querySelectorAll('.filter-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            portfolioItems.forEach(item => {
                if (filter === '*') {
                    item.style.display = 'block';
                } else {
                    if (item.classList.contains(filter.replace('.', ''))) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        });
    });
    
    // Portfolio filtering functionality
    const filterBtns = document.querySelectorAll('.filter-btn');
    const portfolioGrid = document.getElementById('portfolioGrid');
    const projectCards = document.querySelectorAll('.project-card');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            projectCards.forEach(card => {
                card.classList.add('filtering-out');
                
                setTimeout(() => {
                    if (filter === '*' || card.classList.contains(filter.substring(1))) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.classList.remove('filtering-out');
                        }, 10);
                    } else {
                        card.style.display = 'none';
                    }
                }, 300);
            });
        });
    });
    
    // Smooth scroll animation for portfolio items
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
    
    // Observe project cards
    projectCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
});
</script>

<?php get_footer(); ?>