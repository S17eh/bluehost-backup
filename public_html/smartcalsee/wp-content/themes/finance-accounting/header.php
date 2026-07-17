<?php
/**
 * The header for our theme 
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php if ( function_exists( 'wp_body_open' ) ) 
	  {
	    wp_body_open();
	  }else{
	    do_action('wp_body_open');
	  } 
	?>
	<?php if(get_theme_mod('finance_accounting_loader_setting',false)){ ?>
	    <div id="pre-loader">
	      <div class='demo'>
	        <?php $finance_accounting_theme_lay = get_theme_mod( 'finance_accounting_preloader_types','Default');
	        if($finance_accounting_theme_lay == 'Default'){ ?>
				<div class='circle'>
					<div class='inner'></div>
				</div>
				<div class='circle'>
					<div class='inner'></div>
				</div>
				<div class='circle'>
					<div class='inner'></div>
				</div>
	        <?php }elseif($finance_accounting_theme_lay == 'Circle'){ ?>
				<div class='circle'>
					<div class='inner'></div>
				</div>
	        <?php }elseif($finance_accounting_theme_lay == 'Two Circle'){ ?>
				<div class='circle'>
					<div class='inner'></div>
				</div>
				<div class='circle'>
					<div class='inner'></div>
				</div>
	        <?php } ?>
	      </div>
	    </div>
		<?php }?>
	<div id="page" class="site">
		<header id="masthead" class="site-header" role="banner">
			<a class="screen-reader-text skip-link" href="#main" ><?php esc_html_e( 'Skip to content', 'finance-accounting' ); ?></a>
			<?php get_template_part( 'template-parts/header/header', 'image' ); ?>
			<div class="menu-pack <?php if( get_theme_mod( 'finance_accounting_fixed_header', false) != '') { ?> sticky-header"<?php } else { ?>close-sticky <?php } ?>">
				<div class="container">
					<div class="row">
						<div class="col-md-9">
							<div class="navigation-top">
								<div class="wrap">
									<?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
								</div>
							</div>
						</div>
				        <div class="social-media col-md-3 col-sm-3 p-3 text-md-end text-center align-self-center">
							<?php if( get_theme_mod( 'finance_accounting_facebook_url') != '') { ?>
								<a href="<?php echo esc_url( get_theme_mod( 'finance_accounting_facebook_url','' ) ); ?>" target="_blank" ><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_facebook_icon_changer','fab fa-facebook-f')); ?> ps-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Facebook','finance-accounting' );?></span></a>
							<?php } ?>
							<?php if( get_theme_mod( 'finance_accounting_vk_url') != '') { ?>
								<a href="<?php echo esc_url( get_theme_mod( 'finance_accounting_vk_url','' ) ); ?>" target="_blank" ><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_vk_icon_changer','fab fa-vk')); ?> ps-2"></i><span class="screen-reader-text"><?php esc_html_e( 'VK','finance-accounting' );?></span></a>
							<?php } ?>
							<?php if( get_theme_mod( 'finance_accounting_youtube_url') != '') { ?>
								<a href="<?php echo esc_url( get_theme_mod( 'finance_accounting_youtube_url','' ) ); ?>" target="_blank" ><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_youtube_icon_changer','fab fa-youtube')); ?> ps-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Youtube','finance-accounting' );?></span></a>
							<?php } ?>	          
							<?php if( get_theme_mod( 'finance_accounting_linkdin_url') != '') { ?>
								<a href="<?php echo esc_url( get_theme_mod( 'finance_accounting_linkdin_url','' ) ); ?>" target="_blank" ><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_linkedin_icon_changer','fab fa-linkedin-in')); ?> ps-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Linkedin','finance-accounting' );?></span></a>
							<?php } ?>
							<?php if( get_theme_mod( 'finance_accounting_twitter_url') != '') { ?>
								<a href="<?php echo esc_url( get_theme_mod( 'finance_accounting_twitter_url','' ) ); ?>" target="_blank" ><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_twitter_icon_changer','fab fa-twitter')); ?> ps-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Twitter','finance-accounting' );?></span></a>
							<?php } ?>
							<?php if( get_theme_mod( 'finance_accounting_instagram_url') != '') { ?>
								<a href="<?php echo esc_url( get_theme_mod( 'finance_accounting_instagram_url','' ) ); ?>" target="_blank" ><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_instagram_icon_changer','fab fa-instagram')); ?> ps-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Instagram','finance-accounting' );?></span></a>
							<?php } ?>		          	           
			        	</div>
			        </div>
			    </div>
			</div>
		</header>
		<div class="site-content-contain">
			<div id="content">
