<?php
/**
 * Template Name: Privacy Policy
 */

get_header();
?>

<section class="terms-hero smart-banner-hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="">
<div class="section-header text-center">
                        <h1 class="terms-title"><?php the_title(); ?></h1>
                  </div>
                    <div class="legal-content">
                        <?php
                        while (have_posts()) :
                            the_post();
                            the_content();
                        endwhile;
                        ?>
                    </div>
                </div>
            </div>
        </div>
</section>

<?php
get_footer();
?>