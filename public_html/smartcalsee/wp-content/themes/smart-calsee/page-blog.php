<?php
/**
 * Template Name: Blog page
 * (optional – use if this is a page template)
 */

get_header();

/**
 * 1. Get heading title + description from the page set as "Posts page"
 *    (Settings → Reading → Posts page)
 */
$blog_page_id = get_option( 'page_for_posts' );

// Fallback: if this template is attached directly to a page (e.g. "Blog")
if ( ! $blog_page_id && is_page() ) {
    $blog_page_id = get_queried_object_id();
}

$heading_title = '';
$heading_desc  = '';

if ( $blog_page_id ) {
    $heading_title = get_the_title( $blog_page_id );

    // Page content as description
    $raw_content  = get_post_field( 'post_content', $blog_page_id );
    $heading_desc = apply_filters( 'the_content', $raw_content );
}

/**
 * 2. Blog posts query with pagination
 */
$paged = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;

$blog_query = new WP_Query( [
    'post_type'      => 'post',
    'posts_per_page' => 9,   // 3 x 3 grid
    'paged'          => $paged,
] );
?>

<!-- HEADING SECTION -->
<section class="blog-heading-section smart-banner-hero-section">
  <div class="container text-center">

    <?php if ( $heading_title ) : ?>
      <h1 class="blog-heading-title">
        <?php echo esc_html( $heading_title ); ?>
      </h1>
    <?php endif; ?>

    <?php if ( $heading_desc ) : ?>
      <div class="blog-heading-subtext">
        <?php echo wp_kses_post( $heading_desc ); ?>
      </div>
    <?php endif; ?>

  </div>
</section>

<!-- BLOG GRID -->
<section class="service-blog-section">
  <div class="container">

    <?php if ( $blog_query->have_posts() ) : ?>
      <div class="row g-4">
        <?php
        while ( $blog_query->have_posts() ) :
          $blog_query->the_post();
          $post_id = get_the_ID();
          $thumb   = get_the_post_thumbnail_url( $post_id, 'large' );
        ?>
          <div class="col-lg-4 col-md-6 blog-box-section">
            <article class="blog-card h-100 d-flex flex-column">
              
              <!-- IMAGE -->
              <div class="blog-card-img-wrapper">
                <?php if ( $thumb ) : ?>
                  <a href="<?php the_permalink(); ?>">
                    <img src="<?php echo esc_url( $thumb ); ?>"
                         alt="<?php the_title_attribute(); ?>"
                         class="img-fluid">
                  </a>
                <?php endif; ?>
              </div>

              <!-- CONTENT -->
              <div class="blog-card-body d-flex flex-column">

                <h2 class="blog-card-title">
                  <a href="<?php the_permalink(); ?>">
                    <?php echo wp_trim_words( get_the_title(), 14, '…' ); ?>
                  </a>
                </h2>

                <div class="blog-card-meta mb-3">
                  <span class="blog-card-date-icon"></span>
                  <span class="blog-card-date-text">
                    <?php echo esc_html( get_the_date( 'M d Y' ) ); ?>
                  </span>
                </div>

                <div class="mt-auto">
                  <a href="<?php the_permalink(); ?>" class="blog-card-btn">
                    Read More
                  </a>
                </div>
              </div>

            </article>
          </div>
        <?php endwhile; ?>
      </div>

      <?php
      /**
       * 3. Pagination
       */
      $total_pages = (int) $blog_query->max_num_pages;

      if ( $total_pages > 1 ) :
        $pagination_links = paginate_links( [
          'current'   => $paged,
          'total'     => $total_pages,
          'mid_size'  => 1,
          'prev_text' => '&lsaquo;',
          'next_text' => '&rsaquo;',
          'type'      => 'array',
        ] );

        if ( ! empty( $pagination_links ) ) :
      ?>
        <nav class="blog-pagination-wrapper">
          <ul class="blog-pagination">
            <?php foreach ( $pagination_links as $link ) : ?>
              <li><?php echo $link; // already escaped by paginate_links ?></li>
            <?php endforeach; ?>
          </ul>
        </nav>
      <?php
        endif;
      endif;
      ?>

    <?php else : ?>
      <p>No posts found.</p>
    <?php endif; ?>

  </div>
</section>

<?php
wp_reset_postdata();
get_footer();
