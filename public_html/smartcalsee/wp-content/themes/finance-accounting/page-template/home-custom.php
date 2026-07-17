<?php
/**
 * Template Name: Home Custom Page
 */

get_header(); ?>

<main role="main" id="main">
  <?php do_action( 'finance_accounting_before_slider' ); ?>

  <?php if( get_theme_mod('finance_accounting_slider_hide', false) != '' || get_theme_mod( 'finance_accounting_enable_disable_slider', true) != ''){ ?>
    <section id="slider-section">
      <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-interval="<?php echo esc_attr(get_theme_mod('finance_accounting_slider_speed', 3000)); ?>">
        <?php $finance_accounting_slider_pages = array();
          for ( $count = 1; $count <=4; $count++ ) {
            $mod = intval( get_theme_mod( 'finance_accounting_slide_page' . $count ));
            if ( 'page-none-selected' != $mod ) {
              $finance_accounting_slider_pages[] = $mod;
            }
          }
          if( !empty($finance_accounting_slider_pages) ) :
          $args = array(
              'post_type' => 'page',
              'post__in' => $finance_accounting_slider_pages,
              'orderby' => 'post__in'
          );
          $query = new WP_Query( $args );
          if ( $query->have_posts() ) :
            $i = 1;
        ?>
        <div class="carousel-inner" role="listbox">
          <?php  while ( $query->have_posts() ) : $query->the_post(); ?>
            <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
              <?php if(has_post_thumbnail()){
                   the_post_thumbnail();
                  } else{?>
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/slider.png" alt="" />
              <?php } ?>
              <div class="carousel-caption">
                <?php if( get_theme_mod( 'finance_accounting_slider_title',true) != '' || get_theme_mod('finance_accounting_slider_content',true) != '' || get_theme_mod('finance_accounting_slider_button',true) != '') { ?>
                  <div class="inner_carousel">
                    <?php if( get_theme_mod('finance_accounting_slider_title',true) != ''){ ?>
                      <h1><a href="<?php echo esc_url( get_permalink() );?>" class="text-capitalize"><?php the_title(); ?><span class="screen-reader-text"><?php the_title(); ?></span></a></h1>
                      <hr class="slide ms-0 mt-0 mb-2">
                    <?php } ?>
                    <?php if( get_theme_mod('finance_accounting_slider_content',true) != ''){ ?>
                      <p><?php $finance_accounting_excerpt = get_the_excerpt(); echo esc_html( finance_accounting_string_limit_words( $finance_accounting_excerpt, esc_attr(get_theme_mod('finance_accounting_slider_excerpt_number','20')))); ?></p>
                    <?php } ?>
                    <?php if (get_theme_mod( 'finance_accounting_slider_button',true) != '' || get_theme_mod( 'finance_accounting_show_hide_slider_button',true) != ''){ ?>
                      <?php if( get_theme_mod('finance_accounting_slider_button_text','READ MORE') != ''){ ?>
                        <div class="slide-button mt-3">
                          <a href="<?php echo esc_url( get_theme_mod('finance_accounting_slider_button_text_url','') );?>"><?php echo esc_html(get_theme_mod('finance_accounting_slider_button_text','READ MORE'));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('finance_accounting_slider_button_text','READ MORE'));?></span></a>
                        </div>
                      <?php } ?>
                    <?php } ?>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php $i++; endwhile;
          wp_reset_postdata();?>
        </div>
        <?php else : ?>
        <div class="no-postfound"></div>
          <?php endif;
        endif;?>
        <a class="carousel-control-prev" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev" role="button">
          <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-angle-left"></i></span>
          <span class="screen-reader-text"><?php esc_html_e( 'Previous','finance-accounting' );?></span>
        </a>
        <a class="carousel-control-next" data-bs-target="#carouselExampleCaptions" data-bs-slide="next" role="button">
          <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-angle-right"></i></span>
          <span class="screen-reader-text"><?php esc_html_e( 'Next','finance-accounting' );?></span>
        </a>
      </div>
      <div class="clearfix"></div>
    </section>
  <?php }?>

  <?php do_action( 'finance_accounting_after_slider' ); ?>

  <?php if( get_theme_mod('finance_accounting_section_title') != '' || get_theme_mod('finance_accounting_section_text') != '' || get_theme_mod('finance_accounting_blogcategory_setting') != ''){ ?>
    <section id="services" class="py-5 text-center">
      <div class="container services-content">
        <?php if(get_theme_mod('finance_accounting_section_title','') == true){ ?>
          <h2 class="py-2 px-4 text-uppercase"><?php echo esc_html(get_theme_mod('finance_accounting_section_title','')); ?></h2>
        <?php }?>
        <?php if(get_theme_mod('finance_accounting_section_text','') == true){ ?>
          <p class="service-title mb-4"><?php echo esc_html(get_theme_mod('finance_accounting_section_text','')); ?></p>
        <?php }?>
        <div class="row">
          <?php
            $finance_accounting_catData=  get_theme_mod('finance_accounting_blogcategory_setting');
            if($finance_accounting_catData){
              $page_query = new WP_Query(array( 'category_name' => esc_html( $finance_accounting_catData ,'finance-accounting')));?>
            <?php while( $page_query->have_posts() ) : $page_query->the_post(); ?>
              <div class="col-lg-4 col-md-4 serive-box">
                <div class="trainerbox">
                  <div class="abt-img-box"><?php if(has_post_thumbnail()) { ?><?php the_post_thumbnail(); ?><?php } ?></div>
                </div>
                <h3><a href="<?php the_permalink(); ?>" class="text-capitalize"><?php the_title(); ?><span class="screen-reader-text"><?php the_title(); ?></span></a></h3>
                <?php the_excerpt(); ?>
              </div>
            <?php endwhile;
            wp_reset_postdata();
          }
          ?>
          <div class="clearfix"></div>
        </div>
      </div>
    </section>
  <?php }?>
</main>

<?php do_action( 'finance_accounting_after_services' ); ?>

<?php get_footer(); ?>
