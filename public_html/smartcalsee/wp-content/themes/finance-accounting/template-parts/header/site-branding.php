<?php
/**
 * Displays header site branding
 */

?>

<div class="site-branding">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-12 align-self-center">
				<div class="logo text-lg-start text-center align-self-center mb-md-0 mb-3">
		      		<?php if ( has_custom_logo() ) : ?>
						<div class="site-logo"><?php the_custom_logo(); ?></div>
		            <?php endif; ?>   
					<?php $blog_info = get_bloginfo( 'name' ); ?>
					<?php if ( ! empty( $blog_info ) ) : ?>
		              	<?php if( get_theme_mod('finance_accounting_show_site_title',true) != ''){ ?>
			                <?php if ( is_front_page() && is_home() ) : ?>
			                  <h1 class="site-title m-0 text-capitalize"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-capitalize"><?php bloginfo( 'name' ); ?></a></h1>
			                <?php else : ?>
			                  <p class="site-title m-0 text-capitalize"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			                <?php endif; ?>
			            <?php }?>
		            <?php endif; ?>
		              	<?php
			              $description = get_bloginfo( 'description', 'display' );
			              if ( $description || is_customize_preview() ) :
		                ?>
	              		<?php if( get_theme_mod('finance_accounting_show_tagline',false) != ''){ ?>
			              <p class="site-description m-0">
			                <?php echo esc_html($description); ?>
			              </p>
			          	<?php }?>
		            <?php endif; ?>   
			    </div>
			</div>
			<div class="col-lg-8 col-md-12 align-self-center">
	        	<div class="row">
					<div class=" col-lg-4 col-md-4 align-self-center">
						<div class="row top-data text-md-start text-center my-2 align-self-center">
							<?php if( get_theme_mod( 'finance_accounting_time','' ) != '') { ?>
			                <div class="col-lg-2 col-md-2 align-self-center">
			                  	<i class="<?php echo esc_attr(get_theme_mod('finance_accounting_time_icon_changer','fas fa-clock')); ?>"></i>
			                </div>
			                <div class="col-lg-10 col-md-10 align-self-center">
			                  	<p class="heavy mb-0"><?php echo esc_html( get_theme_mod( 'finance_accounting_time','' )); ?></p>
			                  	<p class="mb-0"><?php echo esc_html( get_theme_mod('finance_accounting_time1','' )); ?></p>
			                </div>
			                <?php } ?>
			             </div>
				    </div>
				    <div class=" col-lg-4 col-md-4 align-self-center">
				      	<div class="row top-data text-md-start text-center my-2 align-self-center">
				      		<?php if( get_theme_mod( 'finance_accounting_mail','' ) != '') { ?>
			                <div class="col-lg-2 col-md-2">
			                  	<i class="<?php echo esc_attr(get_theme_mod('finance_accounting_email_icon_changer','fas fa-envelope')); ?>"></i>
			                </div>
			                <div class="col-lg-10 col-md-10">
		                  		<p class="heavy mb-0"><?php echo esc_html( get_theme_mod( 'finance_accounting_mail','' ) ); ?></p>
		                  		<a href="mailto:<?php echo esc_attr( get_theme_mod('finance_accounting_email','') ); ?>" class="mb-0"><?php echo esc_html( get_theme_mod('finance_accounting_email','' )); ?><span class="screen-reader-text"><?php echo esc_html( get_theme_mod('finance_accounting_email','' )); ?></span></a>
			                </div>
			                <?php } ?>
		              	</div>
				    </div>
				    <div class=" col-lg-4 col-md-4 align-self-center">
				      	<div class="row top-data text-md-start text-center my-2 align-self-center">
				      		<?php if( get_theme_mod( 'finance_accounting_call','' ) != '') { ?>
			                <div class="col-lg-2 col-md-2">
			                  	<i class="<?php echo esc_attr(get_theme_mod('finance_accounting_phone_icon_changer','fas fa-mobile-alt')); ?>"></i>
			                </div>
			                <div class="col-lg-10 col-md-10">
		                  		<p class="heavy mb-0"><?php echo esc_html( get_theme_mod('finance_accounting_call','') ); ?></p>
		                  		<a href="tel:<?php echo esc_attr( get_theme_mod('finance_accounting_call1','' )); ?>" class="mb-0"><?php echo esc_html( get_theme_mod('finance_accounting_call1','' )); ?><span class="screen-reader-text"><?php echo esc_html( get_theme_mod('finance_accounting_call1','' )); ?></span></a>
			                </div>
			                <?php } ?>
		              	</div>
				    </div>
				</div>
			</div>
		</div>		
	</div>
</div>
