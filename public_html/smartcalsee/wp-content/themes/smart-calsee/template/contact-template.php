<?php
/**
 * Template Name: Contact Page
 */
get_header();
$post_id = get_the_ID();

// Get current country for debugging
$current_country = function_exists('smart_get_current_country') ? smart_get_current_country() : 'au';

// Use country-specific meta function if available
$phone    = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_contact_phone' ) : get_post_meta( $post_id, '_contact_phone', true );
$email    = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_contact_email' ) : get_post_meta( $post_id, '_contact_email', true );
$address  = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_contact_address' ) : get_post_meta( $post_id, '_contact_address', true );
$hours    = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_contact_hours' ) : get_post_meta( $post_id, '_contact_hours', true );
$desc     = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_contact_description' ) : get_post_meta( $post_id, '_contact_description', true );

?>
<section class="contact-hero smart-banner-hero-section">
  <div class="container">
    <h1 class="contact-title"><?php the_title(); // "Contact Us" ?></h1>

    <?php if ( ! empty( $desc ) ) : ?>
      <p class="contact-subtitle">
        <?php echo wp_kses_post( $desc ); ?>
      </p>
    <?php endif; ?>

    <div class="contact-info-box">

      <?php if ( ! empty( $phone ) ) : ?>
        <div class="info-item">
          <span class="info-label">Phone No:</span>
          <span class="info-value"><?php echo esc_html( $phone ); ?></span>
        </div>
      <?php endif; ?>

      <?php if ( ! empty( $email ) ) : ?>
        <div class="info-item">
          <span class="info-label">Email Address:</span>
          <span class="info-value"><?php echo esc_html( $email ); ?></span>
        </div>
      <?php endif; ?>

      <?php if ( ! empty( $address ) ) : ?>
        <div class="info-item">
          <span class="info-label">Our Address:</span>
          <span class="info-value"><?php echo nl2br( esc_html( $address ) ); ?></span>
        </div>
      <?php endif; ?>

      <?php if ( ! empty( $hours ) ) : ?>
        <div class="info-item">
          <span class="info-label">Business Hours:</span>
          <span class="info-value"><?php echo esc_html( $hours ); ?></span>
        </div>
      <?php endif; ?>

    </div>
  </div>
</section>

<div class="contact-section-hero">
     <?php echo do_shortcode('[contact-form-7 id="b93cd90" title="contact form smart"]'); ?>
      </div>

<?php 
get_footer();