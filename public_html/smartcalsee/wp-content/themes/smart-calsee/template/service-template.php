<?php
/**
 * Template Name: Our Service Page (Dynamic CPT loop, no pagination)
 */
get_header();

$post_id = get_the_ID();
$service_title = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_service_page_title') : get_post_meta($post_id, '_service_page_title', true);
$service_desc = function_exists('smart_get_country_meta') ? smart_get_country_meta($post_id, '_service_page_description') : get_post_meta($post_id, '_service_page_description', true);

if (empty($service_title)) $service_title = 'Our Services';
if (empty($service_desc)) $service_desc = 'SmartCalsee brings global expertise to Australian accounting firms, ensuring compliance with ATO, ASIC, and SMSF regulations.';
?>

<section class="smart-services smart-banner-hero-section">
  <div class="container">
    <!-- Section Heading -->
    <div class="section-header text-center">
      <h1><?php echo esc_html($service_title); ?></h1>
      <p class="text-muted">
        <?php echo wp_kses_post($service_desc); ?>
      </p>
    </div>

    <!-- Services Grid -->
    <div class="row g-4 services-card-col">
      <?php
      // IMPORTANT: confirm your CPT slug. Use 'service' or 'services' to match registration.
      $args = array(
        'post_type'      => 'services',    // <-- CHANGE if your CPT slug is 'service'
        'posts_per_page' => -1,
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
      );

      $services = new WP_Query( $args );

      if ( $services->have_posts() ) :
        while ( $services->have_posts() ) : $services->the_post();
          // Get service categories (countries) for this service - use slugs for SEO
          $categories = wp_get_post_terms(get_the_ID(), 'service_category', array('fields' => 'all'));
          $country_attr = '';
          if (!empty($categories) && function_exists('smart_get_country_slug')) {
            $country_slug = smart_get_country_slug($categories[0]);
            $country_attr = ' data-country="' . esc_attr($country_slug) . '"';
          } elseif (!empty($categories)) {
            // Fallback to slug if function doesn't exist
            $country_attr = ' data-country="' . esc_attr($categories[0]->slug) . '"';
          }
        ?>
          <div class="col-lg-4 col-md-6 col-12 service-item"<?php echo $country_attr; ?>>
            <div id="post-<?php the_ID(); ?>" <?php post_class('service-card h-100'); ?>>
              <?php
              // Wrap image in .img-wrap and use .ss-img
              if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>" class="img-wrap" aria-hidden="true">
                  <?php the_post_thumbnail( 'large', array( 'class' => 'ss-img', 'alt' => the_title_attribute( array('echo' => false) ) ) ); ?>
                </a>
              <?php else :
                $placeholder = get_stylesheet_directory_uri() . '/images/placeholder-600x400.jpg'; ?>
                <a href="<?php the_permalink(); ?>" class="img-wrap" aria-hidden="true">
                  <img src="<?php echo esc_url( $placeholder ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="ss-img" />
                </a>
              <?php endif; ?>

              <div class="card-body">
                <h5 class="card-title">
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h5>

                <?php
                if ( function_exists('get_field') && get_field('short_description') ) {
                  echo '<p class="card-text text-muted service-card-dec">' . wp_kses_post( wp_trim_words( get_field('short_description'), 20 ) ) . '</p>';
                } else {
                  if ( has_excerpt() ) {
                    echo '<p class="card-text text-muted service-card-dec">' . wp_kses_post( wp_trim_words( get_the_excerpt(), 20 ) ) . '</p>';
                  } else {
                    echo '<p class="card-text text-muted service-card-dec">' . wp_kses_post( wp_trim_words( get_the_content(), 20 ) ) . '</p>';
                  }
                }
                ?>

                <a href="<?php the_permalink(); ?>" class="btn-read">Read More</a>
              </div>
            </div>
          </div>
        <?php endwhile;
        wp_reset_postdata();
      else:
        echo '<div class="col-12"><p>' . esc_html__( 'No services found.', 'your-textdomain' ) . '</p></div>';
      endif;
      ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
