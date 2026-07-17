<?php
get_header();
$post_id      = get_the_ID();
$hero_title   = get_post_meta($post_id, '_sc_hero_title', true);
$hero_desc    = get_post_meta($post_id, '_sc_hero_desc', true);
$hero_image   = get_the_post_thumbnail_url($post_id, 'large');

$about_title = get_post_meta($post_id, '_sc_about_title', true);
$about_text  = get_post_meta($post_id, '_sc_about_text', true);

$other_title = get_post_meta($post_id, '_sc_other_title', true);
$other_desc = get_post_meta($post_id, '_sc_other_desc', true);

$solutions_title  = get_post_meta($post_id, '_sc_solutions_title', true);
$solutions_intro  = get_post_meta($post_id, '_sc_solutions_intro', true);
$solutions        = get_post_meta($post_id, '_sc_solutions', true);
if (! is_array($solutions)) {
  $solutions = [];
}

$out_title = get_post_meta($post_id, '_sc_out_title', true);
$out_desc  = get_post_meta($post_id, '_sc_out_desc', true);
$out_left  = get_post_meta($post_id, '_sc_out_left', true);
$out_right = get_post_meta($post_id, '_sc_out_right', true);

$left_lines  = preg_split("/\r\n|\r|\n/", (string) $out_left);
$right_lines = preg_split("/\r\n|\r|\n/", (string) $out_right);

$has_left  = array_filter(array_map('trim', $left_lines));
$has_right = array_filter(array_map('trim', $right_lines));

$faq_title = get_post_meta($post_id, '_sc_faq_title', true);
$faq_desc = get_post_meta($post_id, '_sc_faq_desc', true);
$faqs      = get_post_meta($post_id, '_sc_faqs', true);

if ( ! is_array( $faqs ) ) {
    $faqs = [];
}

$industry_title = get_post_meta($post_id, '_sc_industry_title', true);
$industry_desc = get_post_meta($post_id, '_sc_industry_desc', true);
$industry_items = get_post_meta($post_id, '_sc_industry_items', true);
if ( ! is_array( $industry_items ) ) {
    $industry_items = [];
}
?>

<section class="hero-section">
  <div class="container py-lg-5 service-details-container">
    <div class="row align-items-center">

      <!-- LEFT TEXT -->
      <div class="col-lg-6 mb-4 mb-lg-0">
        <h1 class="mb-3 service-details-heading"><?php the_title(); ?> </h1>

        <?php if (! empty($hero_title)) : ?>
          <h4 class="mb-3 service-details-title">
            <?php echo esc_html($hero_title); ?>
          </h4>
        <?php endif; ?>

        <?php if (! empty($hero_desc)) : ?>
          <p class="service-details-dec">
            <?php echo wp_kses_post($hero_desc); ?>
          </p>
        <?php endif; ?>
      </div>

      <!-- RIGHT IMAGE -->
      <div class="col-lg-6 d-flex justify-content-center justify-content-lg-end">
        <div class="image-card">
          <img
            src="<?php echo esc_url($hero_image); ?>"
            alt="<?php echo esc_attr(get_the_title()); ?>"
            class="img-fluid rounded-4 service-single-image">
        </div>
      </div>

    </div>
  </div>
</section>

<?php if ($about_title || $about_text) : ?>
  <section class="about-payroll-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-10">

          <?php if ($about_title) : ?>
            <h2 class="about-service-title mb-3">
              <?php echo esc_html($about_title); ?>
            </h2>
          <?php endif; ?>

          <?php if ($about_text) : ?>
            <div class="about-service-text">
              <?php
              // since you're using wp_editor for this field, it already contains HTML
              echo wp_kses_post($about_text);
              ?>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- PAYROLL SOLUTIONS SECTION -->
 <?php if ( $industry_title || ! empty( $industry_items ) ) : ?>
<section class="industry-section">
  <div class="container">

    <?php if ( $industry_title ) : ?>
      <h2 class="industry-title mb-3">
        <?php echo esc_html( $industry_title ); ?>
      </h2>
    <?php endif; ?>

    <?php if ( $industry_desc ) : ?>
      <div class="industry-description mb-5">
        <?php echo wp_kses_post( $industry_desc ); ?>
      </div>
    <?php endif; ?>

    <?php if ( ! empty( $industry_items ) ) : ?>
    <div class="row g-4">
      <?php foreach ( $industry_items as $item ) :
        $icon  = $item['icon']  ?? '';
        $title = $item['title'] ?? '';
        $desc  = $item['desc']  ?? '';

        if ( $title === '' && $desc === '' ) {
            continue;
        }
      ?>
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="industry-card h-100 text-center">
            <?php if ( $icon ) : ?>
              <div class="industry-icon mb-4">
                <img src="<?php echo esc_url( $icon ); ?>" alt="<?php echo esc_attr( $title ); ?>">
              </div>
            <?php endif; ?>

            <?php if ( $title ) : ?>
              <h5 class="industry-card-title"><?php echo esc_html( $title ); ?></h5>
            <?php endif; ?>

            <?php if ( $desc ) : ?>
              <p class="industry-card-text mb-0">
                <?php echo esc_html( $desc ); ?>
              </p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

  </div>
</section>
<?php endif; ?>

<?php if ($solutions_title || $solutions_intro || ! empty($solutions)) : ?>
  <section class="solutions-section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">

          <?php if ($solutions_title) : ?>
            <h2 class="solutions-title mb-3">
              <?php echo esc_html($solutions_title); ?>
            </h2>
          <?php endif; ?>

          <?php if ($solutions_intro) : ?>
            <p class="text-muted mb-4">
              <?php echo wp_kses_post($solutions_intro); ?>
            </p>
          <?php endif; ?>

          <?php if (! empty($solutions)) : ?>
            <div class="accordion solutions-accordion" id="payrollSolutions">

              <?php foreach ($solutions as $index => $item) :

                // ALWAYS define these inside the foreach
                $item_title   = isset($item['title']) ? $item['title'] : '';
                $item_content = isset($item['content']) ? $item['content'] : '';

                if ($item_title === '' && $item_content === '') {
                  continue;
                }

                // unique IDs for accordion
                $heading_id  = 'solutionHeading_' . $index;
                $collapse_id = 'solutionCollapse_' . $index;

                // first item open
                $is_first   = ($index === 0);
                $show_class = $is_first ? 'show' : '';
                $collapsed  = $is_first ? '' : 'collapsed';
                $expanded   = $is_first ? 'true' : 'false';
              ?>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="<?php echo esc_attr($heading_id); ?>">
                    <button class="accordion-button <?php echo esc_attr($collapsed); ?>"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#<?php echo esc_attr($collapse_id); ?>"
                      aria-expanded="<?php echo esc_attr($expanded); ?>"
                      aria-controls="<?php echo esc_attr($collapse_id); ?>">
                      <?php echo esc_html($item_title); ?>
                    </button>
                  </h2>

                  <div id="<?php echo esc_attr($collapse_id); ?>"
                    class="accordion-collapse collapse <?php echo esc_attr($show_class); ?>"
                    aria-labelledby="<?php echo esc_attr($heading_id); ?>"
                    data-bs-parent="#payrollSolutions">
                    <div class="accordion-body">
                      <?php
                      echo wp_kses_post($item_content);
                      ?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>

            </div><!-- /accordion -->
          <?php endif; ?>

        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<?php if ($out_title || $out_desc || $has_left || $has_right) : ?>
  <section class="why-vcfo-section">
    <div class="container">

      <?php if ($out_title) : ?>
        <h2 class="why-vcfo-title mb-3">
          <?php echo esc_html($out_title); ?>
        </h2>
      <?php endif; ?>
		<?php if ($out_desc) : ?>
        <div class="why-vcfo-description mb-5">
          <?php echo wp_kses_post($out_desc); ?>
        </div>
      <?php endif; ?>

      <div class="row">

        <!-- LEFT COLUMN -->
        <div class="col-md-6 mb-4 mb-md-0">
          <?php
          foreach ($left_lines as $line) {
            $line = trim(wp_strip_all_tags($line));
            if ($line === '') {
              continue;
            }

            // Split into "Title - Description"
            $parts = explode(' - ', $line, 2);
            $title = trim($parts[0]);
            $desc  = isset($parts[1]) ? trim($parts[1]) : '';
          ?>
            <div class="vcfo-item d-flex mb-4">
              <span class="vcfo-icon"></span>
              <div class="vcfo-text">
                <h5><?php echo esc_html($title); ?></h5>
                <p><?php echo esc_html($desc); ?></p>
              </div>
            </div>
          <?php } ?>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-md-6">
          <?php
          foreach ($right_lines as $line) {
            $line = trim(wp_strip_all_tags($line));
            if ($line === '') {
              continue;
            }

            $parts = explode(' - ', $line, 2);
            $title = trim($parts[0]);
            $desc  = isset($parts[1]) ? trim($parts[1]) : '';
          ?>
            <div class="vcfo-item d-flex mb-4">
              <span class="vcfo-icon"></span>
              <div class="vcfo-text">
                <h5><?php echo esc_html($title); ?></h5>
                <p><?php echo esc_html($desc); ?></p>
              </div>
            </div>
          <?php } ?>
        </div>

      </div>
    </div>
  </section>
<?php endif; ?>

<?php if ($other_title || $other_desc) : ?>
<section class="other-section" style="padding-top: 100px;">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <?php if ($other_title) : ?>
          <h2 class="faq-title mb-3"><?php echo esc_html($other_title); ?></h2>
        <?php endif; ?>
        <?php if ($other_desc) : ?>
          <div class="why-vcfo-description">
            <?php echo wp_kses_post($other_desc); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<?php if ( $faq_title || $faq_desc || ! empty( $faqs ) ) : ?>
<section class="faq-section">
  <div class="container">

    <?php if ( $faq_title ) : ?>
      <h2 class="faq-title mb-4"><?php echo esc_html( $faq_title ); ?></h2>
    <?php endif; ?>
	 <?php if ( $faq_desc ) : ?>
      <div class="faq-description mb-4"><?php echo wp_kses_post( $faq_desc ); ?></div>
    <?php endif; ?>
    <div class="accordion faq-accordion" id="faqAccordion">

      <?php foreach ( $faqs as $index => $faq ) : 
        $question = isset( $faq['question'] ) ? trim( $faq['question'] ) : '';
        $answer   = isset( $faq['answer'] ) ? wp_kses_post( $faq['answer'] ) : '';

        if ( $question === '' && $answer === '' ) continue;

        $heading_id  = "faqHeading_$index";
        $collapse_id = "faqCollapse_$index";

        $is_first   = ($index === 0);
        $show_class = $is_first ? 'show' : '';
        $collapsed  = $is_first ? '' : 'collapsed';
        $expanded   = $is_first ? 'true' : 'false';
      ?>

      <div class="accordion-item">
        <h2 class="accordion-header" id="<?php echo esc_attr( $heading_id ); ?>">
          <button class="accordion-button <?php echo esc_attr( $collapsed ); ?>"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#<?php echo esc_attr( $collapse_id ); ?>"
                  aria-expanded="<?php echo esc_attr( $expanded ); ?>"
                  aria-controls="<?php echo esc_attr( $collapse_id ); ?>">
              <?php echo esc_html( $question ); ?>
          </button>
        </h2>

        <div id="<?php echo esc_attr( $collapse_id ); ?>" 
             class="accordion-collapse collapse <?php echo esc_attr( $show_class ); ?>"
             aria-labelledby="<?php echo esc_attr( $heading_id ); ?>"
             data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            <?php echo wp_kses_post( $answer ); ?>
          </div>
        </div>
      </div>

      <?php endforeach; ?>

    </div>

  </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>