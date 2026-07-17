<?php
/**
 * Template Name: How we work Page
 */
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

// Section 1
$sec1_title   = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_req_title' ) : get_post_meta( $post_id, '_hs_req_title', true );
$sec1_text    = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_req_content' ) : get_post_meta( $post_id, '_hs_req_content', true );
$sec1_points  = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_req_points' ) : get_post_meta( $post_id, '_hs_req_points', true );
$sec1_img_id  = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_req_image_id' ) : get_post_meta( $post_id, '_hs_req_image_id', true );
$sec1_img_url = $sec1_img_id ? wp_get_attachment_image_url( $sec1_img_id, 'large' ) : '';

// Section 2
$sec2_title   = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_onboarding_title' ) : get_post_meta( $post_id, '_hs_onboarding_title', true );
$sec2_text    = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_onboarding_content' ) : get_post_meta( $post_id, '_hs_onboarding_content', true );
$sec2_points  = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_onboarding_points' ) : get_post_meta( $post_id, '_hs_onboarding_points', true );
$sec2_img_id  = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_onboarding_image_id' ) : get_post_meta( $post_id, '_hs_onboarding_image_id', true );
$sec2_img_url = $sec2_img_id ? wp_get_attachment_image_url( $sec2_img_id, 'large' ) : '';

// Section 3
$sec3_title     = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_sec_title' ) : get_post_meta( $post_id, '_hs_sec_title', true );
$sec3_subtitle  = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_sec_sub_title' ) : get_post_meta( $post_id, '_hs_sec_sub_title', true );
$sec3_intro     = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_sec_intro' ) : get_post_meta( $post_id, '_hs_sec_intro', true );
$sec3_img_id    = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_sec_image_id' ) : get_post_meta( $post_id, '_hs_sec_image_id', true );
$sec3_img_url   = $sec3_img_id ? wp_get_attachment_image_url( $sec3_img_id, 'large' ) : '';
$sec3_features  = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_security_features' ) : get_post_meta( $post_id, '_hs_security_features', true );
$sec3_features  = is_array( $sec3_features ) ? $sec3_features : [];
$features_count = count( $sec3_features );
$left_count     = (int) ceil( $features_count / 2 );

// New Section
$new_sec_title   = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_new_section_title' ) : get_post_meta( $post_id, '_hs_new_section_title', true );
$new_sec_text    = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_new_section_content' ) : get_post_meta( $post_id, '_hs_new_section_content', true );
$new_sec_points  = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_new_section_points' ) : get_post_meta( $post_id, '_hs_new_section_points', true );
$new_sec_img_id  = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_new_section_image_id' ) : get_post_meta( $post_id, '_hs_new_section_image_id', true );
$new_sec_img_url = $new_sec_img_id ? wp_get_attachment_image_url( $new_sec_img_id, 'large' ) : '';



// Section 4
$sec4_title   = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_reporting_title' ) : get_post_meta( $post_id, '_hs_reporting_title', true );
$sec4_text    = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_reporting_content' ) : get_post_meta( $post_id, '_hs_reporting_content', true );
$sec4_points  = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_reporting_points' ) : get_post_meta( $post_id, '_hs_reporting_points', true );
$sec4_img_id  = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_reporting_image_id' ) : get_post_meta( $post_id, '_hs_reporting_image_id', true );
$sec4_img_url = $sec4_img_id ? wp_get_attachment_image_url( $sec4_img_id, 'large' ) : '';

// Section 5
$sec5_title   = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_support_title' ) : get_post_meta( $post_id, '_hs_support_title', true );
$sec5_text    = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_support_content' ) : get_post_meta( $post_id, '_hs_support_content', true );
$sec5_points  = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_support_points' ) : get_post_meta( $post_id, '_hs_support_points', true );
$sec5_img_id  = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_hs_support_image_id' ) : get_post_meta( $post_id, '_hs_support_image_id', true );
$sec5_img_url = $sec5_img_id ? wp_get_attachment_image_url( $sec5_img_id, 'large' ) : '';
?>

<section class="how-we-work py-lg-6 smart-banner-hero-section">
  <div class="container">

    <!-- PAGE HEADING -->
    <div class="row justify-content-center mb-5">
      <div class="col-lg-8 text-center hww-section-hero">
        <h1 class="hww-title mb-3"><?php the_title(); ?></h1>
        <div class="hww-intro">
          <?php the_content(); ?>
        </div>
      </div>
    </div>

    <!-- SECTION 1: Understanding Your Requirements -->
    <?php if ( $sec1_title || $sec1_text || $sec1_points || $sec1_img_url ) : ?>
    <div class="row align-items-center gy-4 hww-block mb-5">
      <div class="col-lg-6">
        <?php if ( $sec1_title ) : ?>
          <h2 class="hww-section-title"><?php echo esc_html( $sec1_title ); ?></h2>
        <?php endif; ?>
        <?php if ( $sec1_text ) : ?>
          <div class="hww-text">
            <?php echo wp_kses_post( wpautop( $sec1_text ) ); ?>
          </div>
        <?php endif; ?>
        <?php if ( $sec1_points ) : ?>
          <div class="hww-points">
            <?php echo wp_kses_post( $sec1_points ); ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-lg-6 text-center text-lg-end">
        <?php if ( $sec1_img_url ) : ?>
          <img src="<?php echo esc_url( $sec1_img_url ); ?>" class="img-fluid hww-img" alt="">
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- SECTION 2: Onboarding & Setup (image left) -->
    <?php if ( $sec2_title || $sec2_text || $sec2_points || $sec2_img_url ) : ?>
    <div class="row align-items-center gy-4 hww-block mb-5">
      <div class="col-lg-6">
        <?php if ( $sec2_img_url ) : ?>
          <img src="<?php echo esc_url( $sec2_img_url ); ?>" class="img-fluid hww-img" alt="">
        <?php endif; ?>
      </div>
      <div class="col-lg-6">
        <?php if ( $sec2_title ) : ?>
          <h2 class="hww-section-title"><?php echo esc_html( $sec2_title ); ?></h2>
        <?php endif; ?>
        <?php if ( $sec2_text ) : ?>
          <div class="hww-text">
            <?php echo wp_kses_post( wpautop( $sec2_text ) ); ?>
          </div>
        <?php endif; ?>
        <?php if ( $sec2_points ) : ?>
          <div class="hww-points">
            <?php echo wp_kses_post( $sec2_points ); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- SECTION 3: Data Security & Compliance (big block) -->
    <?php if ( $sec3_title || $sec3_intro || $sec3_img_url || $features_count ) : ?>
    <div class="row align-items-center gy-4 mb-5 hww-block servcie-card-block">
      <div class="col-lg-6">
        <?php if ( $sec3_title ) : ?>
          <h2 class="hww-section-title"><?php echo esc_html( $sec3_title ); ?></h2>
        <?php endif; ?>
        <?php if ( $sec3_subtitle ) : ?>
          <h5 class="hww-subtitle mb-2"><?php echo esc_html( $sec3_subtitle ); ?></h5>
        <?php endif; ?>
        <?php if ( $sec3_intro ) : ?>
          <div class="hww-text mb-3">
            <?php echo wp_kses_post( wpautop( $sec3_intro ) ); ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-lg-6 text-center text-lg-end">
        <?php if ( $sec3_img_url ) : ?>
          <img src="<?php echo esc_url( $sec3_img_url ); ?>" class="img-fluid hww-img" alt="">
        <?php endif; ?>
      </div>
    </div>

    <?php if ( $features_count ) : ?>
    <div class="row gy-4 hww-block hww-security-features">
      <div class="col-md-6">
        <?php for ( $i = 0; $i < $left_count; $i++ ) :
            $f = $sec3_features[ $i ] ?? null;
            if ( ! $f || ( empty( $f['title'] ) && empty( $f['content'] ) ) ) continue;
        ?>
          <div class="hww-feature mb-4">
            <?php if ( ! empty( $f['title'] ) ) : ?>
              <h5 class="hww-feature-title"><?php echo esc_html( $f['title'] ); ?></h5>
            <?php endif; ?>
            <?php if ( ! empty( $f['content'] ) ) : ?>
              <div class="hww-feature-content">
                <?php echo wp_kses_post( $f['content'] ); ?>
              </div>
            <?php endif; ?>
          </div>
        <?php endfor; ?>
      </div>
      <div class="col-md-6">
        <?php for ( $i = $left_count; $i < $features_count; $i++ ) :
            $f = $sec3_features[ $i ] ?? null;
            if ( ! $f || ( empty( $f['title'] ) && empty( $f['content'] ) ) ) continue;
        ?>
          <div class="hww-feature mb-4">
            <?php if ( ! empty( $f['title'] ) ) : ?>
              <h5 class="hww-feature-title"><?php echo esc_html( $f['title'] ); ?></h5>
            <?php endif; ?>
            <?php if ( ! empty( $f['content'] ) ) : ?>
              <div class="hww-feature-content">
                <?php echo wp_kses_post( $f['content'] ); ?>
              </div>
            <?php endif; ?>
          </div>
        <?php endfor; ?>
      </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
    
        <!-- NEW SECTION (image left, same as Onboarding) -->
    <?php if ( $new_sec_title || $new_sec_text || $new_sec_points || $new_sec_img_url ) : ?>
    <div class="row align-items-center gy-4 hww-block mb-5">
      <div class="col-lg-6">
        <?php if ( $new_sec_img_url ) : ?>
          <img src="<?php echo esc_url( $new_sec_img_url ); ?>" class="img-fluid hww-img" alt="">
        <?php endif; ?>
      </div>
      <div class="col-lg-6">
        <?php if ( $new_sec_title ) : ?>
          <h2 class="hww-section-title"><?php echo esc_html( $new_sec_title ); ?></h2>
        <?php endif; ?>
        <?php if ( $new_sec_text ) : ?>
          <div class="hww-text">
            <?php echo wp_kses_post( wpautop( $new_sec_text ) ); ?>
          </div>
        <?php endif; ?>
        <?php if ( $new_sec_points ) : ?>
          <div class="hww-points">
            <?php echo wp_kses_post( $new_sec_points ); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>
    
     <!-- SECTION 5: Ongoing Support & Process Improvement -->
    <?php if ( $sec5_title || $sec5_text || $sec5_points || $sec5_img_url ) : ?>
    <div class="row align-items-center gy-4 hww-block">
      <div class="col-lg-6">
        <?php if ( $sec5_title ) : ?>
          <h2 class="hww-section-title"><?php echo esc_html( $sec5_title ); ?></h2>
        <?php endif; ?>
        <?php if ( $sec5_text ) : ?>
          <div class="hww-text">
            <?php echo wp_kses_post( wpautop( $sec5_text ) ); ?>
          </div>
        <?php endif; ?>
        <?php if ( $sec5_points ) : ?>
          <div class="hww-points">
            <?php echo wp_kses_post( $sec5_points ); ?>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-lg-6 text-center text-lg-end">
        <?php if ( $sec5_img_url ) : ?>
          <img src="<?php echo esc_url( $sec5_img_url ); ?>" class="img-fluid hww-img" alt="">
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- SECTION 4: Reporting & Delivery (image left) -->
    <?php if ( $sec4_title || $sec4_text || $sec4_points || $sec4_img_url ) : ?>
    <div class="row align-items-center gy-4 hww-block mb-5">
      <div class="col-lg-6">
        <?php if ( $sec4_img_url ) : ?>
          <img src="<?php echo esc_url( $sec4_img_url ); ?>" class="img-fluid hww-img" alt="">
        <?php endif; ?>
      </div>
      <div class="col-lg-6">
        <?php if ( $sec4_title ) : ?>
          <h2 class="hww-section-title"><?php echo esc_html( $sec4_title ); ?></h2>
        <?php endif; ?>
        <?php if ( $sec4_text ) : ?>
          <div class="hww-text">
            <?php echo wp_kses_post( wpautop( $sec4_text ) ); ?>
          </div>
        <?php endif; ?>
        <?php if ( $sec4_points ) : ?>
          <div class="hww-points">
            <?php echo wp_kses_post( $sec4_points ); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>

   

  </div>
</section>
<?php 
get_footer();