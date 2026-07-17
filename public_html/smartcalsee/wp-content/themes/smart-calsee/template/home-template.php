<?php

/**
 * Template Name: Home Page
 */

// Redirect to default country if no country parameter
if (!isset($_GET['country'])) {
    $default = function_exists('smart_get_default_country') ? smart_get_default_country() : 'au';
    wp_redirect(add_query_arg('country', $default, get_permalink()));
    exit;
}

// Normalize country parameter dynamically
if (isset($_GET['country']) && function_exists('smart_get_country_slug')) {
    $country_param = sanitize_text_field($_GET['country']);
    // Try to find matching term in service_category
    $term = get_term_by('slug', $country_param, 'service_category');
    if (!$term) {
        $term = get_term_by('name', $country_param, 'service_category');
    }
    if ($term) {
        $normalized = smart_get_country_slug($term);
        if ($normalized !== $country_param) {
            wp_redirect(add_query_arg('country', $normalized, remove_query_arg('country')));
            exit;
        }
    }
}

get_header();

$post_id = get_the_ID();
// hero section (country-specific)
$hero_title    = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_hero_title') : get_post_meta($post_id, '_hero_title', true);
$hero_subtitle = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_hero_description') : get_post_meta($post_id, '_hero_description', true);
$badge1_num    = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_badge1_number') : get_post_meta($post_id, '_badge1_number', true);
$badge1_txt    = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_badge1_text') : get_post_meta($post_id, '_badge1_text', true);
$badge2_num    = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_badge2_number') : get_post_meta($post_id, '_badge2_number', true);
$badge2_txt    = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_badge2_text') : get_post_meta($post_id, '_badge2_text', true);
// contact section (country-specific)
$contact_home_title    = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_contact_home_title') : get_post_meta($post_id, '_contact_home_title', true);
$contact_home_description = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_contact_home_description') : get_post_meta($post_id, '_contact_home_description', true);
$contact_button_text    = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_contact_button_text') : get_post_meta($post_id, '_contact_button_text', true);
$contact_button_link = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_contact_button_link') : get_post_meta($post_id, '_contact_button_link', true);

$service_title = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_service_title') : get_post_meta($post_id, '_service_title', true);
$service_description = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_service_description') : get_post_meta($post_id, '_service_description', true);
//why chooes section (country-specific)
$smart_why_title    = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_smart_why_title') : get_post_meta($post_id, '_smart_why_title', true);
$smart_why_description = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_smart_why_description') : get_post_meta($post_id, '_smart_why_description', true);
$smart_why_stats    = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_smart_why_stats') : get_post_meta($post_id, '_smart_why_stats', true);
$smart_why_buttons = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_smart_why_buttons') : get_post_meta($post_id, '_smart_why_buttons', true);

if (! is_array($smart_why_stats)) $smart_why_stats = [];
if (! is_array($smart_why_buttons)) $smart_why_buttons = [];
?>
<div id="smart-wrapper-rainbow">
  <div id="smart-content-rainbow">

    <div class="smart-scroll-rainbow">
     

    </div>
  </div>
</div>

<!-- hero section -->
<div class="hero-content container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8 text-center ">
            <h1 class="hero-title"><?php echo wp_kses_post($hero_title); ?></h1>
            <p class="hero-subtitle"><?php echo nl2br(esc_html($hero_subtitle)); ?></p>

            <div class="badges-container row justify-content-center g-4 mt-5">
                <div class="col-12 col-sm-5 col-md-5 col-lg-5 d-flex justify-content-center align-items-center">
                    <div class="badge badge-blue">
                        <div class="badge-number"><?php echo esc_html($badge1_num); ?></div>
                        <div class="badge-text"><?php echo esc_html($badge1_txt); ?></div>
                    </div>
                </div>

                <div class="col-12 col-sm-2 col-md-2 col-lg-2"></div>

                <div class="col-12 col-sm-5 col-md-5 col-lg-5 d-flex justify-content-center align-items-center">
                    <div class="badge badge-green">
                        <div class="badge-number"><?php echo esc_html($badge2_num); ?></div>
                        <div class="badge-text"><?php echo esc_html($badge2_txt); ?></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Optional globe/ribbon canvas target -->
<!-- <div class="globe-container" style="width:100%;height:420px;position:relative;"></div> -->

<!-- calculator section  -->
<section class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                <div class="calculator" id="calculator">
                    <input type="text" class="display" id="display" disabled />
                </div>
                <div class="buttons" id="buttons"></div>
            </div>
        </div>
    </div>
</section>

<div id="servicesStack">
    <div class="container px-lg-0 px-md-3 px-3 service-header">
        <div class="row">
            <div class="col-12 details-container-wrapper">
                <h1 class="service-title"><?php echo esc_html($service_title); ?></h1>
                <p class="service-description"><?php echo nl2br(esc_html($service_description)); ?></p>
            </div>
        </div>
    </div>
    
    <?php echo do_shortcode('[services_stack]'); ?>
</div>

<!-- Why Choose Us Section -->
<div class="container mb-4">
    <div class="why-choose-section px-lg-0 px-md-3 px-3">
        <div class="row">
            <div class="col-12 details-container-wrapper">
                <h2 class="main-title"><?php echo esc_html($smart_why_title); ?></h2>
                <p class="description"><?php echo nl2br(esc_html($smart_why_description)); ?></p>
            </div>
        </div>

        <!-- Statistics Blocks -->
        <div class="row">
            <div class="col-12">
                <div class="stats-container">
                    <?php
                    if (empty($smart_why_stats)) :
                        $defaults = array(
                            array('num' => '10+',  'label' => 'Years of Expertise'),
                            array('num' => '100+', 'label' => 'Trusted Clients'),
                            array('num' => '100%', 'label' => 'Scalable + Transparent'),
                        );
                        $use_stats = $defaults;
                    else :
                        $use_stats = $smart_why_stats;
                    endif;

                    foreach ($use_stats as $stat) :
                        $num   = isset($stat['num']) ? $stat['num'] : '';
                        $label = isset($stat['label']) ? $stat['label'] : '';

                        if ($num === '' && $label === '') continue;
                    ?>
                        <div class="stat-block">
                            <div class="stat-number"><?php echo esc_html($num); ?></div>
                            <div class="stat-label"><?php echo nl2br(esc_html($label)); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-12">
                <div class="buttons-container">
                    <?php
                    if (empty($smart_why_buttons)) :
                    else :
                        foreach ($smart_why_buttons as $btn) :
                            $text = isset($btn['text']) ? $btn['text'] : '';
                            $link = isset($btn['link']) ? $btn['link'] : '';
                            if ($text === '') continue;
                            $href = $link ? esc_url($link) : '#';
                    ?>
                            <a class="oval-button" href="<?php echo $href; ?>"><?php echo esc_html($text); ?></a>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Globe and Details Section -->
  
</div>
<div class="container mb-4">
  <div class="globe-section row px-lg-0 px-md-2 px-2">
        <div class="col-12 col-lg-6">
            <div class="globe-container">
                <!-- <div id="chartdiv"></div> -->
            </div>
        </div>
        <div class="col-12 col-lg-6 details-container-wrapper">
            <div class="details-container">
                <h2 class="details-title"><?php echo esc_html($contact_home_title); ?></h2>
                <p class="details-description"><?php echo nl2br(esc_html($contact_home_description)); ?></p>
                <button class="contact-button"><a href="<?php echo esc_html($contact_button_link); ?>" class="contact-btn-home"><?php echo esc_html($contact_button_text); ?></a></button>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
