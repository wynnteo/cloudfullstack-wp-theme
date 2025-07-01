<?php
/**
 * Single Portfolio Template
 *
 * @package Nordic_Tech
 */

get_header(); ?>

<main class="main-content">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('portfolio-single'); ?>>
                
                <!-- Portfolio Header -->
                <header class="portfolio-header">
                    <h1 class="portfolio-title"><?php the_title(); ?></h1>
                    
                    <!-- Portfolio Meta -->
                    <div class="portfolio-meta">
                        <?php 
                        $client = get_post_meta(get_the_ID(), '_project_client', true);
                        $year = get_post_meta(get_the_ID(), '_project_year', true);
                        
                        if ($client || $year) : ?>
                            <div class="portfolio-details">
                                <?php if ($client) : ?>
                                    <span class="portfolio-client">
                                        <strong><?php _e('Client:', 'nordic-tech'); ?></strong> <?php echo esc_html($client); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($year) : ?>
                                    <span class="portfolio-year">
                                        <strong><?php _e('Year:', 'nordic-tech'); ?></strong> <?php echo esc_html($year); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Portfolio Categories -->
                        <?php 
                        $categories = get_the_terms(get_the_ID(), 'portfolio_category');
                        if ($categories && !is_wp_error($categories)) : ?>
                            <div class="portfolio-categories">
                                <strong><?php _e('Category:', 'nordic-tech'); ?></strong>
                                <?php foreach ($categories as $category) : ?>
                                    <a href="<?php echo esc_url(get_term_link($category)); ?>" class="portfolio-category-link">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </header>

                <!-- Featured Image -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="portfolio-featured-image">
                        <?php the_post_thumbnail('large', array('class' => 'img-responsive')); ?>
                    </div>
                <?php endif; ?>

                <!-- Portfolio Content -->
                <div class="portfolio-content">
                    <?php the_content(); ?>
                </div>

                <!-- Technologies Used -->
                <?php 
                $technologies = get_post_meta(get_the_ID(), '_project_technologies', true);
                if ($technologies) :
                    $tech_array = array_map('trim', explode(',', $technologies));
                ?>
                    <div class="portfolio-technologies">
                        <h3><?php _e('Technologies Used', 'nordic-tech'); ?></h3>
                        <div class="tech-tags">
                            <?php foreach ($tech_array as $tech) : ?>
                                <span class="tech-tag"><?php echo esc_html($tech); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Project Links -->
                <div class="portfolio-links">
                    <?php 
                    $project_url = get_post_meta(get_the_ID(), '_project_url', true);
                    $github_url = get_post_meta(get_the_ID(), '_github_url', true);
                    $demo_url = get_post_meta(get_the_ID(), '_demo_url', true);
                    
                    if ($project_url || $github_url || $demo_url) : ?>
                        <h3><?php _e('Project Links', 'nordic-tech'); ?></h3>
                        <div class="project-buttons">
                            <?php if ($project_url) : ?>
                                <a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                                    <?php _e('View Project', 'nordic-tech'); ?>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($github_url) : ?>
                                <a href="<?php echo esc_url($github_url); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary">
                                    <?php _e('View Code', 'nordic-tech'); ?>
                                </a>
                            <?php endif; ?>
                            
                            <?php if ($demo_url) : ?>
                                <a href="<?php echo esc_url($demo_url); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-accent">
                                    <?php _e('Live Demo', 'nordic-tech'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Portfolio Tags -->
                <?php 
                $tags = get_the_terms(get_the_ID(), 'portfolio_tag');
                if ($tags && !is_wp_error($tags)) : ?>
                    <div class="portfolio-tags">
                        <h3><?php _e('Tags', 'nordic-tech'); ?></h3>
                        <div class="tag-list">
                            <?php foreach ($tags as $tag) : ?>
                                <a href="<?php echo esc_url(get_term_link($tag)); ?>" class="portfolio-tag">
                                    <?php echo esc_html($tag->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Navigation -->
                <nav class="portfolio-navigation">
                    <div class="nav-links">
                        <?php
                        $prev_post = get_previous_post(false, '', 'portfolio_category');
                        $next_post = get_next_post(false, '', 'portfolio_category');
                        
                        if ($prev_post) : ?>
                            <div class="nav-previous">
                                <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" rel="prev">
                                    <span class="nav-subtitle"><?php _e('Previous Project', 'nordic-tech'); ?></span>
                                    <span class="nav-title"><?php echo esc_html(get_the_title($prev_post->ID)); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($next_post) : ?>
                            <div class="nav-next">
                                <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" rel="next">
                                    <span class="nav-subtitle"><?php _e('Next Project', 'nordic-tech'); ?></span>
                                    <span class="nav-title"><?php echo esc_html(get_the_title($next_post->ID)); ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="back-to-portfolio">
                        <a href="<?php echo esc_url(get_post_type_archive_link('portfolio')); ?>" class="btn btn-outline">
                            <?php _e('← Back to Portfolio', 'nordic-tech'); ?>
                        </a>
                    </div>
                </nav>

            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>