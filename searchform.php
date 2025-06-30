<?php
/**
 * Template for displaying search forms - Nordic Tech Design
 *
 * @package Nordic_Tech
 */

$unique_id = uniqid('search-form-');
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="search-form-wrapper">
        <label for="<?php echo esc_attr($unique_id); ?>" class="screen-reader-text">
            <?php echo esc_html_x('Search for:', 'label', 'nordic-tech'); ?>
        </label>
        
        <div class="search-input-container">
            <input 
                type="search" 
                id="<?php echo esc_attr($unique_id); ?>" 
                class="search-field" 
                placeholder="<?php echo esc_attr_x('Search articles, tags, categories...', 'placeholder', 'nordic-tech'); ?>" 
                value="<?php echo get_search_query(); ?>" 
                name="s" 
                autocomplete="off"
                required
                aria-describedby="<?php echo esc_attr($unique_id); ?>-desc"
            />
            
            <button type="submit" class="search-submit" aria-label="<?php echo esc_attr_x('Submit search', 'submit button', 'nordic-tech'); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                <span class="search-submit-text"><?php echo esc_html_x('Search', 'submit button', 'nordic-tech'); ?></span>
            </button>
        </div>
        
        <div id="<?php echo esc_attr($unique_id); ?>-desc" class="search-description screen-reader-text">
            <?php esc_html_e('Press Enter to search or Escape to close', 'nordic-tech'); ?>
        </div>
    </div>
    
    <!-- Search Suggestions (populated via JavaScript) -->
    <div class="search-suggestions" id="<?php echo esc_attr($unique_id); ?>-suggestions" style="display: none;">
        <div class="search-suggestions-header">
            <span><?php esc_html_e('Quick suggestions:', 'nordic-tech'); ?></span>
        </div>
        <div class="search-suggestions-list">
            <!-- Populated by JavaScript -->
        </div>
    </div>
</form>

<style>
/* Enhanced search form styles to match Nordic Tech design */
.search-form {
    position: relative;
    width: 100%;
    max-width: 400px;
}

.search-form-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    background: var(--background, #ffffff);
    border: 2px solid var(--background-light, #f8f9fa);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.search-form-wrapper:focus-within {
    border-color: var(--accent-color, #9f8e7f);
    box-shadow: 0 4px 12px rgba(159, 142, 127, 0.15);
    transform: translateY(-1px);
}

.search-input-container {
    display: flex;
    align-items: center;
    width: 100%;
}

.search-field {
    flex: 1;
    padding: 14px 16px;
    border: none;
    background: transparent;
    font-size: 16px;
    color: var(--primary-color, #2c2c2c);
    outline: none;
    font-family: inherit;
}

.search-field::placeholder {
    color: var(--text-light, #666666);
    opacity: 1;
}

.search-submit {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 14px 16px;
    background: var(--accent-color, #9f8e7f);
    color: white;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
    font-weight: 500;
    white-space: nowrap;
}

.search-submit:hover {
    background: var(--primary-color, #2c2c2c);
    transform: translateX(-2px);
}

.search-submit svg {
    flex-shrink: 0;
}

.search-submit-text {
    display: none;
}

/* Show text on larger screens */
@media (min-width: 768px) {
    .search-submit-text {
        display: inline;
    }
}

/* Search suggestions */
.search-suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: var(--background, #ffffff);
    border: 2px solid var(--background-light, #f8f9fa);
    border-top: none;
    border-radius: 0 0 12px 12px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    margin-top: -2px;
}

.search-suggestions-header {
    padding: 12px 16px 8px;
    font-size: 14px;
    color: var(--text-light, #666666);
    font-weight: 500;
    border-bottom: 1px solid var(--background-light, #f8f9fa);
}

.search-suggestions-list {
    padding: 8px 0;
}

.search-suggestion-item {
    display: block;
    padding: 10px 16px;
    color: var(--primary-color, #2c2c2c);
    text-decoration: none;
    transition: background-color 0.2s ease;
    cursor: pointer;
}

.search-suggestion-item:hover,
.search-suggestion-item:focus {
    background: var(--background-light, #f8f9fa);
    outline: none;
}

.search-suggestion-item strong {
    color: var(--accent-color, #9f8e7f);
}

/* Screen reader text */
.screen-reader-text {
    position: absolute !important;
    clip: rect(1px, 1px, 1px, 1px);
    width: 1px;
    height: 1px;
    overflow: hidden;
}

/* Widget context adjustments */
.widget .search-form {
    max-width: none;
}

.widget .search-form .search-field {
    padding: 12px 14px;
    font-size: 14px;
}

.widget .search-form .search-submit {
    padding: 12px 14px;
    font-size: 13px;
}

/* Header search box styling */
.search-box .search-form {
    max-width: 300px;
}

.search-box .search-form-wrapper {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
}

.search-box .search-field {
    color: white;
}

.search-box .search-field::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.search-box .search-form-wrapper:focus-within {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.4);
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .search-form {
        max-width: none;
    }
    
    .search-field {
        font-size: 16px; /* Prevent zoom on iOS */
    }
    
    .search-submit {
        padding: 14px 12px;
    }
    
    .search-suggestions {
        left: -16px;
        right: -16px;
        border-radius: 0 0 12px 12px;
    }
}

/* Animation for search form */
@keyframes searchFormAppear {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.search-form {
    animation: searchFormAppear 0.3s ease-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForms = document.querySelectorAll('.search-form');
    
    searchForms.forEach(function(form) {
        const searchField = form.querySelector('.search-field');
        const suggestionsContainer = form.querySelector('.search-suggestions');
        const suggestionsList = form.querySelector('.search-suggestions-list');
        
        if (!searchField || !suggestionsContainer || !suggestionsList) return;
        
        let searchTimeout;
        let isComposing = false;
        
        // Sample suggestions (in a real implementation, these would come from the backend)
        const quickSuggestions = [
            'JavaScript', 'React', 'CSS Grid', 'TypeScript', 'Node.js', 
            'Design', 'Productivity', 'Tutorials', 'Clean Code', 'Performance'
        ];
        
        // Handle input events
        searchField.addEventListener('input', function() {
            if (isComposing) return;
            
            clearTimeout(searchTimeout);
            const query = this.value.trim().toLowerCase();
            
            if (query.length > 0) {
                searchTimeout = setTimeout(function() {
                    showSuggestions(query);
                }, 150);
            } else {
                hideSuggestions();
            }
        });
        
        // Handle composition events (for IME input)
        searchField.addEventListener('compositionstart', function() {
            isComposing = true;
        });
        
        searchField.addEventListener('compositionend', function() {
            isComposing = false;
            searchField.dispatchEvent(new Event('input'));
        });
        
        // Handle keyboard navigation
        searchField.addEventListener('keydown', function(e) {
            const suggestions = suggestionsList.querySelectorAll('.search-suggestion-item');
            const currentFocus = suggestionsList.querySelector('.search-suggestion-item:focus');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (!currentFocus) {
                    suggestions[0]?.focus();
                } else {
                    const nextIndex = Array.from(suggestions).indexOf(currentFocus) + 1;
                    suggestions[nextIndex]?.focus() || searchField.focus();
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (!currentFocus) {
                    suggestions[suggestions.length - 1]?.focus();
                } else {
                    const prevIndex = Array.from(suggestions).indexOf(currentFocus) - 1;
                    if (prevIndex >= 0) {
                        suggestions[prevIndex].focus();
                    } else {
                        searchField.focus();
                    }
                }
            } else if (e.key === 'Escape') {
                hideSuggestions();
                searchField.blur();
            }
        });
        
        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!form.contains(e.target)) {
                hideSuggestions();
            }
        });
        
        function showSuggestions(query) {
            const filteredSuggestions = quickSuggestions.filter(suggestion =>
                suggestion.toLowerCase().includes(query)
            );
            
            if (filteredSuggestions.length > 0) {
                suggestionsList.innerHTML = filteredSuggestions.map(suggestion => {
                    const highlighted = suggestion.replace(
                        new RegExp(`(${query})`, 'gi'),
                        '<strong>$1</strong>'
                    );
                    return `<a href="?s=${encodeURIComponent(suggestion)}" class="search-suggestion-item">${highlighted}</a>`;
                }).join('');
                
                suggestionsContainer.style.display = 'block';
            } else {
                hideSuggestions();
            }
        }
        
        function hideSuggestions() {
            suggestionsContainer.style.display = 'none';
        }
        
        // Focus enhancement
        searchField.addEventListener('focus', function() {
            if (this.value.trim().length > 0) {
                showSuggestions(this.value.trim().toLowerCase());
            }
        });
    });
});
</script>