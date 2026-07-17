<?php
/**
 * Template Name: Team Expert Page (Dynamic CPT loop, no pagination)
 */
get_header();
// Use country-specific meta function if available
$post_id = get_the_ID();
$members = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_team_members' ) : get_post_meta( $post_id, '_team_members', true );
$team_description = function_exists('smart_get_country_meta') ? smart_get_country_meta( $post_id, '_team_description' ) : get_post_meta( $post_id, '_team_description', true );

// If no members found, optionally show message or try a fallback (empty array here)
if ( ! is_array( $members ) ) {
    $members = array();
}
?>
<section class="expert-team smart-banner-hero-section">
  <div class="container">
    <div class="heading text-center mb-4">
      <h2 class="title">Our Expert Team</h2>
      <?php if ( ! empty( $team_description ) ) : ?>
        <div class="lead text-muted"><?php echo wp_kses_post( wpautop( $team_description ) ); ?></div>
      <?php endif; ?>
    </div>

    <?php if ( ! empty( $members ) ) : ?>
      <div class="row g-4">
        <?php foreach ( $members as $member ) :
            $img_id = isset( $member['image_id'] ) && $member['image_id'] ? intval( $member['image_id'] ) : 0;
            // prefer a medium/cropped size - change to suit your theme sizes
            $img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'medium' ) : get_stylesheet_directory_uri() . '/images/placeholder-400.jpg';
            $name = isset( $member['name'] ) ? sanitize_text_field( $member['name'] ) : '';
            $designation = isset( $member['designation'] ) ? sanitize_text_field( $member['designation'] ) : '';
        ?>
          <div class="col-lg-3 col-md-6 col-12">
            <div class="team-card h-100 text-center p-3">
              <div class="avatar-wrap mb-2">
                <img class="avatar" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $name ?: 'Team member' ); ?>">
              </div>

              <div class="body">
                <?php if ( $name ) : ?>
                  <div class="team-name"><?php echo esc_html( $name ); ?></div>
                <?php endif; ?>

                <?php if ( $designation ) : ?>
                  <div class="team-role text-muted small"><?php echo esc_html( $designation ); ?></div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <div class="row">
        <div class="col-12">
          <p class="text-center text-muted">No team members added yet. Add members from the Team Members metabox on this page.</p>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php 
get_footer();