<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Smart-Calsee
 */

get_header();
?>

	<section class="single-post-section smart-banner-hero-section">
  <div class="container">

    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>

        <?php
        $post_id     = get_the_ID();
        $post_date   = get_the_date( 'M d Y', $post_id );
        $featured    = get_the_post_thumbnail_url( $post_id, 'large' );
        ?>

        <div>

          <!-- DATE + TITLE -->
          <div class="single-post-header mb-4">
			<h1 class="single-post-title">
              <?php the_title(); ?>
            </h1>
            <div class="single-post-meta d-flex align-items-center mb-3">
              <span class="single-post-date-icon"></span>
              <span class="single-post-date-text">
                <?php echo esc_html( $post_date ); ?>
              </span>
            </div>
            
	</div>

          <!-- FEATURED IMAGE -->
          <?php if ( $featured ) : ?>
            <div class="single-post-image mb-2">
              <img src="<?php echo esc_url( $featured ); ?>"
                   alt="<?php the_title_attribute(); ?>"
                   class="img-fluid">
            </div>
          <?php endif; ?>

          <!-- CONTENT -->
          <div class="single-post-content">
            <?php the_content(); ?>
          </div>

		  </div>

      <?php endwhile; ?>
    <?php endif; ?>

  </div>
</section>

<?php
get_footer();
