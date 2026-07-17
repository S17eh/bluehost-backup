<?php

// Include all PHP files from specific subfolders inside 'inc'
function include_rewild_files()
{
    $folders = array(
        'Home metabox',
        'Service metabox',
        'About Metabox',
        'Team metabox',
        'Contact metabox',
    );

    foreach ($folders as $folder) {
        $folder_path = get_template_directory() . '/inc/' . $folder . '/';

        if (is_dir($folder_path)) {
            foreach (glob($folder_path . '*.php') as $file) {
                include_once $file;
            }
        }
    }
    add_theme_support('custom-logo');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'smart-calsee'),
        'footer' => __('Footer Menu', 'smart-calsee'),
        'legal' => __('Footer Legal', 'smart-calsee'),
        'social' => __('Footer Social', 'smart-calsee'),
    ));

}
add_action('after_setup_theme', 'include_rewild_files');



//svg support
function allow_svg_uploads($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

// body class add
function add_custom_body_class($classes)
{
    $classes[] = 'smart-body-dots'; // 👈 your new class
    return $classes;
}
add_filter('body_class', 'add_custom_body_class');

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_media();
});

// Enqueue styles and scripts (Bootstrap, Google Fonts, theme CSS/JS)
function smart_calsee_enqueue_scripts()
{

    // Bootstrap CSS (CDN)
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '5.3.2');
    wp_enqueue_style('smart-custom-css', get_template_directory_uri() . '/assets/css/custom.css', true);
    wp_enqueue_style('smart-home-css', get_template_directory_uri() . '/assets/css/home.css', true);
    wp_enqueue_style('smart-service-css', get_template_directory_uri() . '/assets/css/service.css', true);
    wp_enqueue_style('smart-team-css', get_template_directory_uri() . '/assets/css/team.css', true);
    wp_enqueue_style('smart-about-css', get_template_directory_uri() . '/assets/css/about.css', true);
    wp_enqueue_style('smart-contact-css', get_template_directory_uri() . '/assets/css/contact.css', true);
        wp_enqueue_style('smart-details-service-css', get_template_directory_uri() . '/assets/css/service-details.css', true);
                wp_enqueue_style('smart-blog-css', get_template_directory_uri() . '/assets/css/single-blog-latest.css', true);


    // wp_enqueue_style( 'smart-calsee-style', get_template_directory_uri() . '/assets/css/custom.css', array(), wp_get_theme()->get( 'Version' ) );
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array(), '5.3.2', true);

    wp_enqueue_script('three-js', 'https://cdn.jsdelivr.net/npm/three@0.148.0/build/three.min.js', array(),'0.148.0', true );

    // GSAP Core (single source of truth for all animations)
    wp_enqueue_script('gsap-js',  get_template_directory_uri() . '/assets/js/gsap.min.js', array(), null, true);

    wp_enqueue_style( 'bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css' );

    // ScrollTrigger + ScrollSmoother (use same GSAP instance)
    wp_enqueue_script('scrolltrigger-js', get_template_directory_uri() . '/assets/js/ScrollTrigger.min.js', array('gsap-js'), null, true);
    wp_enqueue_script('scrollsmoother-js', get_template_directory_uri() . '/assets/js/ScrollSmoother.min.js', array('gsap-js', 'scrolltrigger-js'), null, true);

    // Simplex Noise
    wp_enqueue_script( 'simplex-noise-js', 'https://cdnjs.cloudflare.com/ajax/libs/simplex-noise/2.4.0/simplex-noise.min.js',  array(),  '2.4.0', true );
    // Theme JS
    wp_enqueue_script('smart-calsee-about-js', get_template_directory_uri() . '/assets/js/about.js', array('jquery', 'three-js'), wp_get_theme()->get('Version'), true);
    wp_enqueue_script(
        'smart-calsee-js',
        get_template_directory_uri() . '/assets/js/custom-script.js',
        array('jquery', 'gsap-js', 'scrolltrigger-js', 'scrollsmoother-js', 'simplex-noise-js'),
        wp_get_theme()->get('Version'),
        true
    );
    wp_localize_script( 'smart-calsee-js', 'ThemeData', [
  'assetsUrl' => get_template_directory_uri() . '/assets/image/'  // trailing slash
] );
	
}   
add_action('wp_enqueue_scripts', 'smart_calsee_enqueue_scripts');

function smart_get_country_slug($term) {
  if (is_numeric($term)) {
    $term = get_term($term, 'service_category');
  }
  if (!$term || is_wp_error($term)) {
    return '';
  }
  
  $slug = $term->slug;
  $slug_lower = strtolower($slug);
  $name_lower = strtolower($term->name);
  
  // Map common country names and slugs to standardized codes
  $slug_map = array(
    'australia' => 'australia',
    'au' => 'australia', 
    'usa' => 'usa',
    'united-states' => 'usa',
    'united_states' => 'usa',
    'us' => 'usa',
  );
  
  $name_map = array(
    'australia' => 'australia',
    'usa' => 'usa',
    'united states' => 'usa',
    'united states of america' => 'usa',
    'us' => 'usa',
  );
  
  // Check slug first (most reliable)
  if (isset($slug_map[$slug_lower])) {
    return $slug_map[$slug_lower];
  }
  
  // Then check name
  if (isset($name_map[$name_lower])) {
    return $name_map[$name_lower];
  }
  
  // Return original slug if no mapping found
  return $slug;
}
/**
 * Enqueue About Timeline assets + pass data to JS
 */
function smart_about_timeline_assets() {

    // Only on About Us page (by slug OR template)
    if ( ! is_page( 'about-us' ) && ! is_page_template( 'template/about-template.php' ) ) {
        return;
    }

    $post_id = get_queried_object_id();
    if ( ! $post_id ) return;

    $items = get_post_meta( $post_id, '_about_timeline_items', true );
    if ( ! is_array( $items ) || empty( $items ) ) {
        // If no timeline items, still enqueue script but with empty data
        $items = array();
    }

    $timeline_data = array();
    foreach ( $items as $item ) {
        $year = isset( $item['year'] ) ? trim( $item['year'] ) : '';
        $headline = isset( $item['headline'] ) ? trim( $item['headline'] ) : '';
        $description = isset( $item['description'] ) ? trim( $item['description'] ) : '';
        
        // Skip empty items
        if ( empty( $year ) && empty( $headline ) && empty( $description ) ) {
            continue;
        }
        
        $timeline_data[] = array(
            'year'        => ! empty( $year ) ? (int) $year : 0,
            'title'       => $headline,
            'description' => $description,
            'logo'        => '', // optional, you can add another meta later
        );
    }

    // Use the already-enqueued GSAP + ScrollTrigger from the theme to avoid duplicates
    wp_enqueue_script(
        'about-timeline',
        get_template_directory_uri() . '/assets/js/timeline.js',
        array( 'gsap-js', 'scrolltrigger-js' ),
        '1.0.2', // Version updated
        true
    );

    // Pass PHP data → JS
    wp_localize_script(
        'about-timeline',
        'AboutTimelineData',
        array(
            'items' => $timeline_data,
        )
    );
}
add_action( 'wp_enqueue_scripts', 'smart_about_timeline_assets' );

// Make sure classic editor APIs (wp.editor / wp.oldEditor) are loaded
add_action( 'admin_enqueue_scripts', 'sc_enqueue_editor_assets' );
function sc_enqueue_editor_assets( $hook ) {
    if ( $hook !== 'post.php' && $hook !== 'post-new.php' ) {
        return;
    }

    $screen = get_current_screen();
    if ( ! $screen || $screen->post_type !== 'services' ) {
        return;
    }

    wp_enqueue_editor(); // IMPORTANT for wp.editor / wp.oldEditor JS
        wp_enqueue_media();

}

add_action('admin_footer', function(){
?>
<script>
jQuery(document).ready(function($){
    $('#post').on('submit', function(){
        if ( typeof tinyMCE !== 'undefined' ) {
            tinyMCE.triggerSave();
        }
    });
});
</script>
<?php
});

/**
 * Country Management System
 * Handles country selection (USA/Australia) for content switching
 */

// Get countries from service_category taxonomy (dynamic)
function smart_get_valid_countries() {
    $countries = array();
    
    // Get all service_category terms
    $terms = get_terms(array(
        'taxonomy' => 'service_category',
        'hide_empty' => false,
    ));
    
    if (!is_wp_error($terms) && !empty($terms)) {
        foreach ($terms as $term) {
            $slug = $term->slug;
            $countries[$slug] = array(
                'code' => $slug,
                'name' => $term->name,
                'slug' => $slug,
                'term_id' => $term->term_id,
            );
        }
    } else {
        // Fallback to default countries if no terms exist
        $countries = array(
            'usa' => array(
                'code' => 'usa',
                'name' => 'USA',
                'slug' => 'usa',
            ),
            'australia' => array(
                'code' => 'australia',
                'name' => 'Australia',
                'slug' => 'australia',
            ),
        );
    }
    
    return $countries;
}

// Get default country (Australia)
function smart_get_default_country() {
    $countries = smart_get_valid_countries();
    if (isset($countries['usa'])) {
        return 'usa';
    } elseif (!empty($countries)) {
        return array_key_first($countries);
    }
    return 'usa'; // Ultimate fallback
}

// Get current selected country (from URL parameter, cookie, or default)
function smart_get_current_country() {
    $valid_countries = smart_get_valid_countries();
    
    // Check URL parameter first (highest priority)
    if ( isset( $_GET['country'] ) && !empty( $_GET['country'] ) ) {
        $country = sanitize_text_field( $_GET['country'] );
        $country = strtolower(trim($country));
        
        if ( isset( $valid_countries[ $country ] ) ) {
            // Set cookie server-side to sync with URL parameter
            if (!headers_sent()) {
                setcookie('smart_selected_country', $country, time() + (30 * DAY_IN_SECONDS), '/', '', false, false);
            }
            return $country;
        }
    }
    
    // Check cookie
    if ( isset( $_COOKIE['smart_selected_country'] ) && !empty( $_COOKIE['smart_selected_country'] ) ) {
        $country = sanitize_text_field( $_COOKIE['smart_selected_country'] );
        $country = strtolower(trim($country));
        if ( isset( $valid_countries[ $country ] ) ) {
            return $country;
        }
    }
    
    // Default
    return smart_get_default_country();
}

// Get country-specific meta value
// Usage: smart_get_country_meta( $post_id, '_hero_title', 'au' )
function smart_get_country_meta( $post_id, $meta_key, $country = null ) {
    if ( ! $country ) {
        $country = smart_get_current_country();
    }
    
    // Try country-specific meta first (e.g., _hero_title_usa, _hero_title_au)
    $country_meta_key = $meta_key . '_' . $country;
    $value = get_post_meta( $post_id, $country_meta_key, true );
    
    // Debug output (remove after testing)
    if (WP_DEBUG) {
        error_log("smart_get_country_meta: post_id={$post_id}, meta_key={$meta_key}, country={$country}, country_meta_key={$country_meta_key}, value=" . (empty($value) ? 'EMPTY' : 'HAS_VALUE'));
    }
    
    // If no country-specific value, fallback to default meta
    if ( empty( $value ) ) {
        $value = get_post_meta( $post_id, $meta_key, true );
    }
    
    return $value;
}

/**
 * Get available countries for any post/page (from service_category taxonomy)
 * This function works for all pages, not just services
 */
function smart_get_page_countries($post_id = null) {
    if (!$post_id) {
        global $post;
        $post_id = $post ? $post->ID : 0;
    }
    
    $countries_data = function_exists('smart_get_valid_countries') ? smart_get_valid_countries() : array();
    $default_country = function_exists('smart_get_default_country') ? smart_get_default_country() : 'usa';
    
    // Get all service_category terms (countries)
    $terms = get_terms(array(
        'taxonomy' => 'service_category',
        'hide_empty' => false,
    ));
    
    $available_countries = array();
    
    if (!is_wp_error($terms) && !empty($terms)) {
        foreach ($terms as $term) {
            $slug = $term->slug;
            if (isset($countries_data[$slug])) {
                $available_countries[$slug] = $countries_data[$slug];
            } else {
                $available_countries[$slug] = array(
                    'name' => $term->name,
                    'slug' => $slug,
                );
            }
        }
    } else {
        // Fallback to default countries if no terms exist
        $available_countries = !empty($countries_data) ? $countries_data : array(
            'usa' => array('name' => 'USA', 'slug' => 'usa'),
            'australia' => array('name' => 'Australia', 'slug' => 'australia'),
        );

    }
    
    // Ensure default country is in the list
    if (!isset($available_countries[$default_country]) && !empty($countries_data)) {
        $available_countries = $countries_data;
    }
    
    $selected_country = isset($_GET['country']) ? sanitize_text_field($_GET['country']) : (isset($available_countries['usa']) ? 'usa' : $default_country);
    if (!isset($available_countries[$selected_country])) {
        $selected_country = isset($available_countries['usa']) ? 'usa' : array_key_first($available_countries);
    }
    
    return array(
        'countries' => $available_countries,
        'default' => $default_country,
        'selected' => $selected_country,
    );
}

// AJAX handler for country switching
add_action( 'wp_ajax_smart_switch_country', 'smart_ajax_switch_country' );
add_action( 'wp_ajax_nopriv_smart_switch_country', 'smart_ajax_switch_country' );
function smart_ajax_switch_country() {
    check_ajax_referer( 'smart_country_nonce', 'nonce' );
    
    $country = isset( $_POST['country'] ) ? sanitize_text_field( $_POST['country'] ) : '';
    $valid_countries = smart_get_valid_countries();
    
    if ( ! isset( $valid_countries[ $country ] ) ) {
        wp_send_json_error( array( 'message' => 'Invalid country' ) );
    }
    
    // Set cookie (30 days expiry)
    setcookie( 'smart_selected_country', $country, time() + ( 30 * DAY_IN_SECONDS ), '/' );
    $_COOKIE['smart_selected_country'] = $country;
    
    wp_send_json_success( array(
        'country' => $country,
        'name' => $valid_countries[ $country ]['name'],
        'redirect' => isset( $_POST['redirect'] ) ? esc_url_raw( $_POST['redirect'] ) : home_url( '/' ),
    ) );
}

// Enqueue AJAX script for country switching
add_action( 'wp_enqueue_scripts', 'smart_enqueue_country_switcher' );
function smart_enqueue_country_switcher() {
    $current = smart_get_current_country();
    wp_localize_script( 'smart-calsee-js', 'SmartCountry', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'smart_country_nonce' ),
        'currentCountry' => $current,
        'debug' => array(
            'urlParam' => isset($_GET['country']) ? sanitize_text_field($_GET['country']) : '',
            'cookie' => isset($_COOKIE['smart_selected_country']) ? sanitize_text_field($_COOKIE['smart_selected_country']) : '',
            'detected' => $current,
        ),
    ) );
}

/**
 * Shared JavaScript for country dropdown switching in all metaboxes
 */
add_action('admin_footer', 'smart_country_dropdown_script');
function smart_country_dropdown_script() {
    $screen = get_current_screen();
    if (!$screen || !in_array($screen->post_type, array('services', 'page'))) {
        return;
    }
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Country dropdown switching
        $(document).on('change', '.sc-country-selector, .country-selector', function() {
            var country = $(this).val();
            var $metabox = $(this).closest('.postbox, .inside');
            
            // Update all dropdowns in this metabox
            $metabox.find('.sc-country-selector, .country-selector').val(country);
            
            // Update content
            $metabox.find('.country-content').removeClass('active').hide();
            $metabox.find('.country-content[data-country="' + country + '"]').addClass('active').show();
        });
        
        // Initialize on load
        $('.sc-country-selector, .country-selector').each(function() {
            var country = $(this).val();
            var $metabox = $(this).closest('.postbox, .inside');
            $metabox.find('.country-content').removeClass('active').hide();
            $metabox.find('.country-content[data-country="' + country + '"]').addClass('active').show();
        });
    });
    </script>
    <?php
}