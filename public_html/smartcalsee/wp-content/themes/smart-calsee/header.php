<?php

/**
 * The header for our theme
 *
 * Displays the <head> section and everything up until <div id="content">
 *
 * @package Smart-Calsee
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <div id="page" class="site">

        <header id="masthead" class="site-header">
          <!-- Bootstrap Navbar -->
          <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm" id="siteHeader" style="border-radius: 50px; margin: 26px 60px 0px 60px; border: 1px solid #DFDFDF;">
            <div class="container-fluid">

              <!-- Logo / Brand -->
              <div class="navbar-brand ms-sm-3 d-flex align-items-center">
                <?php
                if (function_exists('the_custom_logo') && has_custom_logo()) {
                  the_custom_logo();
                } else {
                  $home_url  = esc_url(home_url('/'));
                  $site_name = get_bloginfo('name');
                  $logo_src  = get_template_directory_uri() . '/image/Logo.png';
                ?>
                  <a class="d-flex align-items-center" href="<?php echo $home_url; ?>">
                    <img src="<?php echo esc_url($logo_src); ?>" alt="<?php echo esc_attr($site_name); ?>" style="height:28px;">
                  </a>
                <?php } ?>
              </div>

              <button class="navbar-toggler me-sm-3 border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#primaryNavbar"
                aria-controls="primaryNavbar" aria-expanded="false"
                aria-label="<?php esc_attr_e('Toggle navigation', 'smart-calsee'); ?>">

                <span class="open-icon">
                  <i class="bi bi-list"></i> <!-- Bootstrap hamburger icon -->
                </span>
                <span class="close-icon d-none">
                  <i class="bi bi-x-lg"></i> <!-- Bootstrap close icon -->
                </span>
              </button>

              <div class="collapse navbar-collapse navbar-menu-custom" id="primaryNavbar">
                <?php
                wp_nav_menu(array(
                  'theme_location' => 'primary',
                  'container'      => false,
                  'menu_class'     => 'navbar-nav mx-auto',
                  'fallback_cb'    => 'wp_page_menu',
                  'depth'          => 2,
                ));
                ?>

                <!-- Country selector (Dynamic from service_category) -->
                <?php
                // Get current selected country (default to Australia)
                $current_country = function_exists('smart_get_current_country') ? smart_get_current_country() : 'usa';
                $valid_countries = function_exists('smart_get_valid_countries') ? smart_get_valid_countries() : array();
                
                // Ensure Australia is default
                if (empty($current_country)) {
                    $current_country = 'usa';
                }
                
                // Country flag mapping (can be extended)
                $country_flags = array(
                    'usa' => get_template_directory_uri() . '/assets/image/usa-logo.svg',
                    'australia' => get_template_directory_uri() . '/assets/image/australia-logo.svg',
                );
                
                // Build countries array with flags and normalized codes
                $countries = array();
                foreach ($valid_countries as $code => $country_data) {
                    // Normalize country code using smart_get_country_slug if available
                    $normalized_code = $code;
                    if (function_exists('smart_get_country_slug')) {
                        // Get term object to normalize
                        $term_obj = get_term_by('slug', $code, 'service_category');
                        if ($term_obj && !is_wp_error($term_obj)) {
                            $normalized_code = smart_get_country_slug($term_obj);
                        }
                    }
                    
                    $countries[$normalized_code] = array(
                        'name' => $country_data['name'],
                        'flag' => isset($country_flags[$normalized_code]) ? $country_flags[$normalized_code] : (isset($country_flags[$code]) ? $country_flags[$code] : get_template_directory_uri() . '/assets/image/australia-logo.svg'),
                    );
                }
                
                // If no countries from taxonomy, use defaults
                if (empty($countries)) {
                    $countries = array(
                        'usa' => array(
                            'name' => 'USA',
                            'flag' => get_template_directory_uri() . '/assets/image/usa-logo.svg',
                        ),
                        'australia' => array(
                            'name' => 'Australia',
                            'flag' => get_template_directory_uri() . '/assets/image/australia-logo.svg',
                        ),
                    );
                }
                
                $current_country_data = isset($countries[$current_country]) ? $countries[$current_country] : (isset($countries['usa']) ? $countries['usa'] : reset($countries));
                ?>

                <div class="country-select position-relative">
                  <button id="country-toggle" class="country-btn d-flex align-items-center justify-content-between w-100" type="button">
                    <span class="d-flex align-items-center">
                      <img id="selected-flag" src="<?php echo esc_url($current_country_data['flag']); ?>" alt="flag" class="flag-icon me-2" style="width: 24px; height: 24px; object-fit: contain;">
                      <span id="selected-label" class="fw-medium"><?php echo esc_html($current_country_data['name']); ?></span>
                    </span>
                    <span class="dropdown-arrow ms-2">
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/image/arrow-down.svg" alt="arrow" class="arrow-icon">
                    </span>
                  </button>

                  <ul id="country-dropdown" class="dropdown-list list-unstyled m-0 p-2 shadow-sm">
                    <?php foreach ($countries as $code => $country_data) : ?>
                      <li class="dropdown-item d-flex align-items-center p-2" 
                          data-country="<?php echo esc_attr($code); ?>"
                          data-name="<?php echo esc_attr($country_data['name']); ?>"
                          data-flag="<?php echo esc_url($country_data['flag']); ?>">
                        <img src="<?php echo esc_url($country_data['flag']); ?>" class="flag-icon me-2" alt="" style="width: 24px; height: 24px; object-fit: contain;">
                        <?php echo esc_html($country_data['name']); ?>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>

              </div>
            </div>
          </nav>
        </header>