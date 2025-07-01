<?php get_header(); ?>

<main class="container">
    <div class="main-content">
        <div class="content-area">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('portfolio-single'); ?>>
                    
                    <!-- Portfolio Header -->
                    <header class="portfolio-header">
                        <div class="portfolio-breadcrumb">
                            <a href="<?php echo esc_url(get_post_type_archive_link('portfolio')); ?>" class="breadcrumb-link">
                                ← <?php _e('Portfolio', 'nordic-tech'); ?>
                            </a>
                        </div>
                        
                        <h1 class="portfolio-title"><?php the_title(); ?></h1>
                        
                        <!-- Portfolio Meta Grid -->
                        <div class="portfolio-meta-grid">
                            <?php 
                            $client = get_post_meta(get_the_ID(), '_project_client', true);
                            $year = get_post_meta(get_the_ID(), '_project_year', true);
                            $categories = get_the_terms(get_the_ID(), 'portfolio_category');
                            ?>
                            
                            <?php if ($client) : ?>
                                <div class="meta-item">
                                    <span class="meta-label"><?php _e('Client', 'nordic-tech'); ?></span>
                                    <span class="meta-value"><?php echo esc_html($client); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($year) : ?>
                                <div class="meta-item">
                                    <span class="meta-label"><?php _e('Year', 'nordic-tech'); ?></span>
                                    <span class="meta-value"><?php echo esc_html($year); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($categories && !is_wp_error($categories)) : ?>
                                <div class="meta-item">
                                    <span class="meta-label"><?php _e('Category', 'nordic-tech'); ?></span>
                                    <span class="meta-value">
                                        <?php 
                                        $category_names = array();
                                        foreach ($categories as $category) {
                                            $category_names[] = $category->name;
                                        }
                                        echo esc_html(implode(', ', $category_names));
                                        ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </header>

                    <!-- Project Overview Section -->
                    <div class="portfolio-overview">
                        <!-- Featured Image -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="portfolio-featured-image">
                                <?php the_post_thumbnail('large', array('class' => 'img-responsive')); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Project Description -->
                        <div class="portfolio-description">
                            <h2 class="section-title"><?php _e('Project Overview', 'nordic-tech'); ?></h2>
                            <div class="portfolio-content">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Technologies & Links Section -->
                    <div class="portfolio-details-section">
                        <div class="portfolio-details-grid">
                            
                            <!-- Technologies Used -->
                            <?php 
                            $technologies = get_post_meta(get_the_ID(), '_project_technologies', true);
                            if ($technologies) :
                                $tech_array = array_map('trim', explode(',', $technologies));
                            ?>
                                <div class="portfolio-technologies">
                                    <h3 class="detail-title"><?php _e('Technologies', 'nordic-tech'); ?></h3>
                                    <div class="tech-tags">
                                        <?php foreach ($tech_array as $tech) : ?>
                                            <span class="tech-tag"><?php echo esc_html($tech); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Project Links -->
                            <?php 
                            $project_url = get_post_meta(get_the_ID(), '_project_url', true);
                            $github_url = get_post_meta(get_the_ID(), '_github_url', true);
                            $demo_url = get_post_meta(get_the_ID(), '_demo_url', true);
                            
                            if ($project_url || $github_url || $demo_url) : ?>
                                <div class="portfolio-links">
                                    <h3 class="detail-title"><?php _e('Project Links', 'nordic-tech'); ?></h3>
                                    <div class="project-buttons">
                                        <?php if ($project_url) : ?>
                                            <a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                                                <span class="btn-icon">🔗</span>
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
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Portfolio Navigation -->
                    <nav class="portfolio-navigation">
                        <?php
                        $prev_post = get_previous_post(false, '', 'portfolio_category');
                        $next_post = get_next_post(false, '', 'portfolio_category');
                        ?>
                        
                        <div class="nav-grid">
                            <?php if ($prev_post) : ?>
                                <div class="nav-item nav-previous">
                                    <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" rel="prev" class="nav-link">
                                        <span class="nav-direction">← <?php _e('Previous', 'nordic-tech'); ?></span>
                                        <span class="nav-title"><?php echo esc_html(get_the_title($prev_post->ID)); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($next_post) : ?>
                                <div class="nav-item nav-next">
                                    <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" rel="next" class="nav-link">
                                        <span class="nav-direction"><?php _e('Next', 'nordic-tech'); ?> →</span>
                                        <span class="nav-title"><?php echo esc_html(get_the_title($next_post->ID)); ?></span>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </nav>

                </article>
            <?php endwhile; ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</main>

<?php get_footer(); ?>