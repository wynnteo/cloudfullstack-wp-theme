<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e('Skip to content', 'nordic-tech'); ?></a>

<header id="masthead" class="site-header">
    <nav class="container">
        <div class="logo-area">
            <div class="logo-icon">
                <?php 
                $site_title = get_bloginfo('name');
                $initials = '';
                $words = explode(' ', $site_title);
                foreach ($words as $word) {
                    if (!empty($word)) {
                        $initials .= strtoupper(substr($word, 0, 1));
                    }
                }
                echo esc_html(substr($initials, 0, 2));
                ?>
            </div>
            <div class="logo-text">
                <?php if (is_front_page() && is_home()) : ?>
                    <h1 class="logo">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                <?php else : ?>
                    <p class="logo">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </p>
                <?php endif; ?>
                
                <?php
                $description = get_bloginfo('description', 'display');
                if ($description || is_customize_preview()) :
                ?>
                    <span class="logo-tagline"><?php echo $description; ?></span>
                <?php endif; ?>
            </div>
        </div>
        
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_id'        => 'primary-menu',
            'container'      => false,
            'menu_class'     => 'nav-links',
            'fallback_cb'    => 'nordic_tech_fallback_menu',
        ));
        ?>
        
        <div class="search-box">
            <?php get_search_form(); ?>
        </div>
    </nav>
</header>

<div id="page" class="site">
    <div id="content" class="site-content">