<?php
/**
 * Template for displaying search forms
 *
 * @package Nordic_Tech
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label for="search-field-<?php echo esc_attr(uniqid()); ?>" class="screen-reader-text">
        <?php echo esc_html_x('Search for:', 'label', 'nordic-tech'); ?>
    </label>
    <input 
        type="search" 
        id="search-field-<?php echo esc_attr(uniqid()); ?>" 
        class="search-field" 
        placeholder="<?php echo esc_attr_x('Search...', 'placeholder', 'nordic-tech'); ?>" 
        value="<?php echo get_search_query(); ?>" 
        name="s" 
        required
    />
    <button type="submit" class="search-submit">
        <span class="screen-reader-text"><?php echo esc_html_x('Search', 'submit button', 'nordic-tech'); ?></span>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.35-4.35"></path>
        </svg>
    </button>
</form>