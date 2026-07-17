<?php
/**
 * Displays footer site info
 */

?>
<?php if( get_theme_mod( 'finance_accounting_hide_show_scroll',true) != '' || get_theme_mod( 'finance_accounting_enable_disable_scrolltop',true) != '') { ?>
    <?php $finance_accounting_theme_lay = get_theme_mod( 'finance_accounting_footer_options','Right');
        if($finance_accounting_theme_lay == 'Left align'){ ?>
            <a href="#" class="scrollup left"><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_scroll_icon_changer','fas fa-long-arrow-alt-up')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'Scroll Up', 'finance-accounting' ); ?></span></a>
        <?php }else if($finance_accounting_theme_lay == 'Center align'){ ?>
            <a href="#" class="scrollup center"><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_scroll_icon_changer','fas fa-long-arrow-alt-up')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'Scroll Up', 'finance-accounting' ); ?></span></a>
        <?php }else{ ?>
            <a href="#" class="scrollup"><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_scroll_icon_changer','fas fa-long-arrow-alt-up')); ?>"></i><span class="screen-reader-text"><?php esc_html_e( 'Scroll Up', 'finance-accounting' ); ?></span></a>
    <?php }?>
<?php }?>
<div class="site-info">
	<div class="container">
        <div class="row">
		<div class="col-lg-4 col-md-12 col-12 align-self-center"><?php finance_accounting_credit(); ?> <?php echo esc_html(get_theme_mod('finance_accounting_footer_text',__('By Themescaliber','finance-accounting'))); ?> </div>
         <div class="col-lg-4 col-md-12 col-12 align-self-center">
           <?php if (get_theme_mod('finance_accounting_show_footer_social_icon', true)){ ?> 
           <div class="socialicons">                      
            <?php if( get_theme_mod( 'finance_accounting_footer_facebook_url') != '') { ?>
				<a href="<?php echo esc_url( get_theme_mod( 'finance_accounting_footer_facebook_url','' ) ); ?>" target="_blank" ><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_footer_facebook_icon','fab fa-facebook-f')); ?> ps-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Facebook','finance-accounting' );?></span></a>
			<?php } ?>
			<?php if( get_theme_mod( 'finance_accounting_footer_vk_url') != '') { ?>
				<a href="<?php echo esc_url( get_theme_mod( 'finance_accounting_footer_vk_url','' ) ); ?>" target="_blank" ><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_footer_vk_icon','fab fa-vk')); ?> ps-2"></i><span class="screen-reader-text"><?php esc_html_e( 'VK','finance-accounting' );?></span></a>
			<?php } ?>
			<?php if( get_theme_mod( 'finance_accounting_footer_youtube_url') != '') { ?>
				<a href="<?php echo esc_url( get_theme_mod( 'finance_accounting_footer_youtube_url','' ) ); ?>" target="_blank" ><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_youtube_icon_changer','fab fa-youtube')); ?> ps-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Youtube','finance-accounting' );?></span></a>
			<?php } ?>	          
			<?php if( get_theme_mod( 'finance_accounting_footer_linkedin_url') != '') { ?>
				<a href="<?php echo esc_url( get_theme_mod( 'finance_accounting_footer_linkedin_url','' ) ); ?>" target="_blank" ><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_footer_linkedin_icon','fab fa-linkedin-in')); ?> ps-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Linkedin','finance-accounting' );?></span></a>
			<?php } ?>
			<?php if( get_theme_mod( 'finance_accounting_footer_twitter_url') != '') { ?>
				<a href="<?php echo esc_url( get_theme_mod( 'finance_accounting_footer_twitter_url','' ) ); ?>" target="_blank" ><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_footer_youtube_icon','fab fa-twitter')); ?> ps-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Twitter','finance-accounting' );?></span></a>
			<?php } ?>
			<?php if( get_theme_mod( 'finance_accounting_footer_instagram_url') != '') { ?>
				<a href="<?php echo esc_url( get_theme_mod( 'finance_accounting_footer_instagram_url','' ) ); ?>" target="_blank" ><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_footer_instagram_icon','fab fa-instagram')); ?> ps-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Instagram','finance-accounting' );?></span></a>
			<?php } ?>	
           </div>	
          <?php } ?> 
        </div> 
        <div class="footer_text col-lg-4 col-md-12 col-12 align-self-center"><?php echo esc_html_e('Powered By WordPress','finance-accounting') ?></div>
	</div>
  </div>
</div>