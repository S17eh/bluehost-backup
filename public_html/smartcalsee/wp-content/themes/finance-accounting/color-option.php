<?php

	/*-----------------First highlight color-------------------*/
	$finance_accounting_first_theme_color = get_theme_mod('finance_accounting_first_theme_color');

	$finance_accounting_custom_css = '';
	$finance_accounting_custom_css .='a.wc-block-components-totals-coupon-link, a.components-button.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained, a.wc-block-components-checkout-return-to-cart-button, .wc-block-components-totals-coupon__button.contained, button.wc-block-components-checkout-place-order-button ,.top-data i, .slide-button a, .site-info, .woocommerce span.onsale, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, nav.woocommerce-MyAccount-navigation ul li, button.search-submit:hover, .search-form .search-submit, .prev.page-numbers, .next.page-numbers, a.page-numbers, button, input[type="button"], input[type="submit"],.scrollup i,.tags p a, .comment-reply-link, .post-navigation .nav-next a, .post-navigation .nav-previous a,horizontal .ui-slider-range, .woocommerce .widget_price_filter .ui-slider-horizontal .ui-slider-range, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .site-footer form.woocommerce-product-search button:hover, .widget .tagcloud a:hover, .widget .tagcloud a:focus, .widget.widget_tag_cloud a:hover, .widget.widget_tag_cloud a:focus, .wp_widget_tag_cloud a:hover, .wp_widget_tag_cloud a:focus, #sidebox .search-form .search-submit, .site-footer .search-form .search-submit, .wp-block-button a, .nav-links .nav-previous a, .nav-links .nav-next a,.site-footer button[type="submit"], #sidebox button[type="submit"] , .breadcrumb a , .breadcrumb span{';
		$finance_accounting_custom_css .='background-color: '.esc_attr($finance_accounting_first_theme_color).';';
	$finance_accounting_custom_css .='}';

	$finance_accounting_custom_css .='.logo h1 a, .post-info i, a.post-link:hover, #services h5 a,.main-navigation li li:focus > a,
.main-navigation li li:hover > a,.main-navigation ul ul li a,.logo h1 a,.site-title, .site-title a, .blogger.singlebox .category a:hover,#sidebox ul li a:hover,.post-info a:hover, #services h3 a, .social-media a i:hover, .top-data a:hover, .blogger a:hover, .site-footer .widget a:hover, #comments .logged-in-as a:hover, #sidebox a:hover,.related-posts h3 a:hover,.page-box a:hover{';
		$finance_accounting_custom_css .='color: '.esc_attr($finance_accounting_first_theme_color).';';
	$finance_accounting_custom_css .='}';

	$finance_accounting_custom_css .='hr.slide,.scrollup i{';
		$finance_accounting_custom_css .='border-color: '.esc_attr($finance_accounting_first_theme_color).';';
	$finance_accounting_custom_css .='}';

	$finance_accounting_custom_css .='.main-navigation ul ul li:hover{';
		$finance_accounting_custom_css .='border-left-color: '.esc_attr($finance_accounting_first_theme_color).';';
	$finance_accounting_custom_css .='}';

	$finance_accounting_custom_css .='.wc-block-grid__product-onsale{';
		$finance_accounting_custom_css .='background-color: '.esc_attr($finance_accounting_first_theme_color).'!important;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_custom_css .='.wc-block-grid__product-onsale{';
		$finance_accounting_custom_css .='border-color: '.esc_attr($finance_accounting_first_theme_color).'!important;';
	$finance_accounting_custom_css .='}';

	/*-------------Second highlight color-------------------*/
	$finance_accounting_second_color = get_theme_mod('finance_accounting_second_color');

	$finance_accounting_custom_css .='button.wc-block-components-checkout-place-order-button:hover, a.wc-block-components-totals-coupon-link:hover, a.components-button.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained:hover, a.wc-block-components-checkout-return-to-cart-button:hover , .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .slide-button a:hover, button:hover,  input[type="button"]:hover, input[type="button"]:focus, input[type="submit"]:hover, input[type="submit"]:focus,.comment-reply-link:hover,.tags p a:hover,.post-navigation .nav-next a:hover, .post-navigation .nav-previous a:hover, .woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content, .wp-block-button a:hover,.nav-links .nav-previous a:hover, .nav-links .nav-next a:hover, #comments input[type="submit"]:hover,.search-form button[type="submit"]:hover, .site-footer button[type="submit"]:hover, #sidebox button[type="submit"]:hover,.scrollup i:hover{';
		$finance_accounting_custom_css .='background-color: '.esc_attr($finance_accounting_second_color).';';
	$finance_accounting_custom_css .='}';

	$finance_accounting_custom_css .='.wp-block-button a:hover{';
		$finance_accounting_custom_css .='background-color: '.esc_attr($finance_accounting_second_color).' !important;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_custom_css .='{';
		$finance_accounting_custom_css .='color: '.esc_attr($finance_accounting_second_color).';';
	$finance_accounting_custom_css .='}';

	$finance_accounting_custom_css .='#services h2{';
		$finance_accounting_custom_css .='border-color: '.esc_attr($finance_accounting_second_color).';';
	$finance_accounting_custom_css .='}';

	$finance_accounting_custom_css .='.woocommerce-info::before{';
		$finance_accounting_custom_css .='color: '.esc_attr($finance_accounting_second_color).';';
	$finance_accounting_custom_css .='}';

	$finance_accounting_custom_css .='.woocommerce-info{';
		$finance_accounting_custom_css .='border-top-color: '.esc_attr($finance_accounting_second_color).';';
	$finance_accounting_custom_css .='}';

	/*---------------------------Width Layout -------------------*/
	$finance_accounting_theme_lay = get_theme_mod( 'finance_accounting_theme_options','Default');
    if($finance_accounting_theme_lay == 'Default'){
		$finance_accounting_custom_css .='body{';
			$finance_accounting_custom_css .='max-width: 100%;';
		$finance_accounting_custom_css .='}';
		$finance_accounting_custom_css .='.page-template-custom-home-page .middle-header{';
			$finance_accounting_custom_css .='width: 97.3%';
		$finance_accounting_custom_css .='}';
	}else if($finance_accounting_theme_lay == 'Wide Layout'){
		$finance_accounting_custom_css .='body{';
			$finance_accounting_custom_css .='width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;';
		$finance_accounting_custom_css .='}';
		$finance_accounting_custom_css .='.page-template-custom-home-page .middle-header{';
			$finance_accounting_custom_css .='width: 97.7%';
		$finance_accounting_custom_css .='}';
	}else if($finance_accounting_theme_lay == 'Box Layout'){
		$finance_accounting_custom_css .='body{';
			$finance_accounting_custom_css .='max-width: 1140px; width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto;';
		$finance_accounting_custom_css .='}';
	}

	/*--------------------------- Slider Opacity -------------------*/
	$finance_accounting_slider_layout = get_theme_mod( 'finance_accounting_slider_opacity_color','0.7');
	if($finance_accounting_slider_layout == '0'){
		$finance_accounting_custom_css .='#slider-section img{';
			$finance_accounting_custom_css .='opacity:0';
		$finance_accounting_custom_css .='}';
		}else if($finance_accounting_slider_layout == '0.1'){
		$finance_accounting_custom_css .='#slider-section img{';
			$finance_accounting_custom_css .='opacity:0.1';
		$finance_accounting_custom_css .='}';
		}else if($finance_accounting_slider_layout == '0.2'){
		$finance_accounting_custom_css .='#slider-section img{';
			$finance_accounting_custom_css .='opacity:0.2';
		$finance_accounting_custom_css .='}';
		}else if($finance_accounting_slider_layout == '0.3'){
		$finance_accounting_custom_css .='#slider-section img{';
			$finance_accounting_custom_css .='opacity:0.3';
		$finance_accounting_custom_css .='}';
		}else if($finance_accounting_slider_layout == '0.4'){
		$finance_accounting_custom_css .='#slider-section img{';
			$finance_accounting_custom_css .='opacity:0.4';
		$finance_accounting_custom_css .='}';
		}else if($finance_accounting_slider_layout == '0.5'){
		$finance_accounting_custom_css .='#slider-section img{';
			$finance_accounting_custom_css .='opacity:0.5';
		$finance_accounting_custom_css .='}';
		}else if($finance_accounting_slider_layout == '0.6'){
		$finance_accounting_custom_css .='#slider-section img{';
			$finance_accounting_custom_css .='opacity:0.6';
		$finance_accounting_custom_css .='}';
		}else if($finance_accounting_slider_layout == '0.7'){
		$finance_accounting_custom_css .='#slider-section img{';
			$finance_accounting_custom_css .='opacity:0.7';
		$finance_accounting_custom_css .='}';
		}else if($finance_accounting_slider_layout == '0.8'){
		$finance_accounting_custom_css .='#slider-section img{';
			$finance_accounting_custom_css .='opacity:0.8';
		$finance_accounting_custom_css .='}';
		}else if($finance_accounting_slider_layout == '0.9'){
		$finance_accounting_custom_css .='#slider-section img{';
			$finance_accounting_custom_css .='opacity:0.9';
		$finance_accounting_custom_css .='}';
		}

	/*--------------------Slider Content Layout -------------------*/
	$finance_accounting_slider_layout = get_theme_mod( 'finance_accounting_slider_content_option','Left');
    if($finance_accounting_slider_layout == 'Left'){
		$finance_accounting_custom_css .='#slider-section .carousel-caption{';
			$finance_accounting_custom_css .='text-align:left; left:10%; right:50%;';
		$finance_accounting_custom_css .='}';
		$finance_accounting_custom_css .='
		@media screen and (max-width: 990px) and (min-width: 768px){
		#slider .carousel-caption{';
		$finance_accounting_custom_css .='top:57%;';
		$finance_accounting_custom_css .='} }';
		$finance_accounting_custom_css .='
		@media screen and (max-width: 768px){
		#slider-section .slide-button a{';
		$finance_accounting_custom_css .='font-size:10px;';
		$finance_accounting_custom_css .='}
		#slider-section .carousel-caption{';
		$finance_accounting_custom_css .='top:52%;';
		$finance_accounting_custom_css .='} }';
	}else if($finance_accounting_slider_layout == 'Center'){
		$finance_accounting_custom_css .='#slider-section .carousel-caption{';
			$finance_accounting_custom_css .='text-align:center; left:30%; right:30%;';
		$finance_accounting_custom_css .='}';
		$finance_accounting_custom_css .='#slider-section .inner_carousel{';
			$finance_accounting_custom_css .='text-align:center;';
		$finance_accounting_custom_css .='}';
		$finance_accounting_custom_css .='hr.slide{';
			$finance_accounting_custom_css .='margin:0 auto 1rem !important;';
		$finance_accounting_custom_css .='}';
		$finance_accounting_custom_css .='
		@media screen and (max-width: 768px){
		#slider-section .slide-button a{';
		$finance_accounting_custom_css .='font-size:10px;';
		$finance_accounting_custom_css .='} }';
	}else if($finance_accounting_slider_layout == 'Right'){
		$finance_accounting_custom_css .='#slider-section .carousel-caption{';
			$finance_accounting_custom_css .='text-align:right; left:50%; right:10%;';
		$finance_accounting_custom_css .='}';
		$finance_accounting_custom_css .='#slider-section .inner_carousel{';
			$finance_accounting_custom_css .='text-align:right;';
		$finance_accounting_custom_css .='}';
		$finance_accounting_custom_css .='hr.slide{';
			$finance_accounting_custom_css .='margin-right:0  !important; margin-left:auto !important;';
		$finance_accounting_custom_css .='}';
		$finance_accounting_custom_css .='
		@media screen and (max-width: 768px){
		#slider-section .slide-button a{';
		$finance_accounting_custom_css .='font-size:10px;';
		$finance_accounting_custom_css .='}
		#slider-section .carousel-caption{';
		$finance_accounting_custom_css .='top:52%;';
		$finance_accounting_custom_css .='} }';
	}

	/*------------------------------ Button Settings option-----------------------*/

    $finance_accounting_btn_font_size_option = get_theme_mod('finance_accounting_btn_font_size_option', 15);
	$finance_accounting_custom_css .='a.post-link,.slide-button a, .form-submit input[type="submit"]{';
	$finance_accounting_custom_css .='font-size: '.esc_attr($finance_accounting_btn_font_size_option).'px;';
	$finance_accounting_custom_css .='}';


	$finance_accounting_top_bottom_padding = get_theme_mod('finance_accounting_top_bottom_padding');
	$finance_accounting_left_right_padding = get_theme_mod('finance_accounting_left_right_padding');
	$finance_accounting_custom_css .='a.post-link, .slide-button a, .form-submit input[type="submit"]{';
		$finance_accounting_custom_css .='padding-top: '.esc_attr($finance_accounting_top_bottom_padding).'px; padding-bottom: '.esc_attr($finance_accounting_top_bottom_padding).'px; padding-left: '.esc_attr($finance_accounting_left_right_padding).'px; padding-right: '.esc_attr($finance_accounting_left_right_padding).'px; display:inline-block;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_border_radius = get_theme_mod('finance_accounting_border_radius');
	$finance_accounting_custom_css .='a.post-link,.slide-button a, .form-submit input[type="submit"]{';
		$finance_accounting_custom_css .='border-radius: '.esc_attr($finance_accounting_border_radius).'px;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_show_header = get_theme_mod( 'finance_accounting_button_border', false);
	if($finance_accounting_show_header == true){
		$finance_accounting_custom_css .='a.post-link{';
			$finance_accounting_custom_css .='border:2px solid #53507b;margin:10px 0;';
		$finance_accounting_custom_css .='}';
	}

		// Button Text Transform
		$finance_accounting_theme_lay = get_theme_mod( 'finance_accounting_button_text_transform','Uppercase');
		if($finance_accounting_theme_lay == 'Uppercase'){
		 $finance_accounting_custom_css .='a.post-link,.slide-button a, .form-submit input[type="submit"]{';
		 $finance_accounting_custom_css .='text-transform: uppercase;';
		 $finance_accounting_custom_css .='}';
		}else if($finance_accounting_theme_lay == 'Lowercase'){
		 $finance_accounting_custom_css .='a.post-link,.slide-button a, .form-submit input[type="submit"]{';
		 $finance_accounting_custom_css .='text-transform: lowercase;';
		 $finance_accounting_custom_css .='}';
		}
		else if($finance_accounting_theme_lay == 'Capitalize'){
		 $finance_accounting_custom_css .='a.post-link,.slide-button a, .form-submit input[type="submit"]{';
		 $finance_accounting_custom_css .='text-transform: capitalize;';
		 $finance_accounting_custom_css .='}';
		}
 
	 // font weight
		$finance_accounting_btn_font_weight = get_theme_mod('finance_accounting_btn_font_weight');{
		$finance_accounting_custom_css .='a.post-link,.slide-button a, .form-submit input[type="submit"]{';
		$finance_accounting_custom_css .='font-weight: '.esc_attr($finance_accounting_btn_font_weight).';';
		$finance_accounting_custom_css .='}';
	}  

	//Button hover effect
	$finance_accounting_button_hover_effect = get_theme_mod('finance_accounting_button_hover_effect', 'disable');
	if ($finance_accounting_button_hover_effect !== 'disable') {
		$finance_accounting_custom_css .= 'a.post-link { display: inline-block; }';
		$finance_accounting_custom_css .= 'a.post-link:hover {';
		switch ($finance_accounting_button_hover_effect) {
			case 'pulse':
				$finance_accounting_custom_css .= 'animation: pulse 0.5s ease-in-out;';
				break;
			case 'rubberBand':
				$finance_accounting_custom_css .= 'animation: rubberBand 0.5s ease-in-out;';
				break;
			case 'swing':
				$finance_accounting_custom_css .= 'animation: swing 0.5s ease-in-out;';
				break;
			case 'tada':
				$finance_accounting_custom_css .= 'animation: tada 0.5s ease-in-out;';
				break;
			case 'jello':
				$finance_accounting_custom_css .= 'animation: jello 0.5s ease-in-out;';
				break;
		}
		$finance_accounting_custom_css .= '}';
	}

	//keyframes for all animations
	$finance_accounting_custom_css .= '
	@keyframes pulse {
		0% { transform: scale(1); }
		50% { transform: scale(1.1); }
		100% { transform: scale(1); }
	}

	@keyframes rubberBand {
		0% { transform: scale(1); }
		30% { transform: scaleX(1.25) scaleY(0.75); }
		40% { transform: scaleX(0.75) scaleY(1.25); }
		50% { transform: scale(1); }
	}

	@keyframes swing {
		20% { transform: rotate(15deg); }
		40% { transform: rotate(-10deg); }
		60% { transform: rotate(5deg); }
		80% { transform: rotate(-5deg); }
		100% { transform: rotate(0deg); }
	}

	@keyframes tada {
		0% { transform: scale(1); }
		10%, 20% { transform: scale(0.9) rotate(-3deg); }
		30%, 50%, 70%, 90% { transform: scale(1.1) rotate(3deg); }
		40%, 60%, 80% { transform: scale(1.1) rotate(-3deg); }
		100% { transform: scale(1) rotate(0); }
	}

	@keyframes jello {
		0%, 11.1%, 100% { transform: none; }
		22.2% { transform: skewX(-12.5deg) skewY(-12.5deg); }
		33.3% { transform: skewX(6.25deg) skewY(6.25deg); }
		44.4% { transform: skewX(-3.125deg) skewY(-3.125deg); }
		55.5% { transform: skewX(1.5625deg) skewY(1.5625deg); }
		66.6% { transform: skewX(-0.78125deg) skewY(-0.78125deg); }
		77.7% { transform: skewX(0.390625deg) skewY(0.390625deg); }
		88.8% { transform: skewX(-0.1953125deg) skewY(-0.1953125deg); }
	}';
	 
	
	/*---------------------------Blog Layout -------------------*/
	$finance_accounting_theme_lay = get_theme_mod( 'finance_accounting_blog_post_layout','Default');
    if($finance_accounting_theme_lay == 'Default'){
		$finance_accounting_custom_css .='.blogger{';
			$finance_accounting_custom_css .='';
		$finance_accounting_custom_css .='}';
	}elseif($finance_accounting_theme_lay == 'Left'){
		$finance_accounting_custom_css .='.blogger, .blogger h2, .post-info, .text p, .blogger .post-link{';
			$finance_accounting_custom_css .='text-align:left;';
		$finance_accounting_custom_css .='}';
		$finance_accounting_custom_css .='.post-info{';
			$finance_accounting_custom_css .='margin-top:10px;';
		$finance_accounting_custom_css .='}';
		$finance_accounting_custom_css .='.blogger .post-link{';
			$finance_accounting_custom_css .='margin-top:25px;';
		$finance_accounting_custom_css .='}';
	}elseif($finance_accounting_theme_lay == 'Image and Content'){
		$finance_accounting_custom_css .='.blogger, .blogger h2, .post-info, .text p, #our-services p{';
			$finance_accounting_custom_css .='text-align:Left;';
		$finance_accounting_custom_css .='}';
		$finance_accounting_custom_css .='.blogger .post-link{';
			$finance_accounting_custom_css .='text-align:right;';
		$finance_accounting_custom_css .='}';
	}elseif($finance_accounting_theme_lay == 'Content and Image'){
		$finance_accounting_custom_css .='.blogger, .blogger h2, .post-info, .text p, #our-services p{';
			$finance_accounting_custom_css .='text-align:Left;';
		$finance_accounting_custom_css .='}';
		$finance_accounting_custom_css .='.blogger .post-link{';
			$finance_accounting_custom_css .='text-align:right;';
		$finance_accounting_custom_css .='}';
	}

	/*--------- Preloader Color Option -------*/
	$finance_accounting_loader_color_setting = get_theme_mod('finance_accounting_loader_color_setting');
	$finance_accounting_custom_css .=' .circle .inner{';
		$finance_accounting_custom_css .='border-color: '.esc_attr($finance_accounting_loader_color_setting).';';
	$finance_accounting_custom_css .='} ';

	$finance_accounting_loader_background_color = get_theme_mod('finance_accounting_loader_background_color');
	$finance_accounting_custom_css .=' #pre-loader{';
		$finance_accounting_custom_css .='background-color: '.esc_attr($finance_accounting_loader_background_color).';';
	$finance_accounting_custom_css .='} ';

	$finance_accounting_theme_lay = get_theme_mod( 'finance_accounting_preloader_types','Default');
    if($finance_accounting_theme_lay == 'Default'){
		$finance_accounting_custom_css .='{';
			$finance_accounting_custom_css .='';
		$finance_accounting_custom_css .='}';
	}elseif($finance_accounting_theme_lay == 'Circle'){
		$finance_accounting_custom_css .='.circle .inner{';
			$finance_accounting_custom_css .='width:unset;';
		$finance_accounting_custom_css .='}';
	}elseif($finance_accounting_theme_lay == 'Two Circle'){
		$finance_accounting_custom_css .='.circle .inner{';
			$finance_accounting_custom_css .='width:80%;
    border-right: 5px;';
		$finance_accounting_custom_css .='}';
	}

	// Responsive Media
	$finance_accounting_sidebar = get_theme_mod( 'finance_accounting_enable_disable_sidebar',true);
    if($finance_accounting_sidebar == true){
    	$finance_accounting_custom_css .='@media screen and (max-width:575px) {';
		$finance_accounting_custom_css .='#sidebox{';
			$finance_accounting_custom_css .='display:block;';
		$finance_accounting_custom_css .='} }';
	}else if($finance_accounting_sidebar == false){
		$finance_accounting_custom_css .='@media screen and (max-width:575px) {';
		$finance_accounting_custom_css .='#sidebox{';
			$finance_accounting_custom_css .='display:none;';
		$finance_accounting_custom_css .='} }';
	}

	$finance_accounting_slider = get_theme_mod( 'finance_accounting_enable_disable_slider', true);
	if($finance_accounting_slider == true && get_theme_mod( 'finance_accounting_slider_hide', false) == false){
    	$finance_accounting_custom_css .='#slider-section{';
			$finance_accounting_custom_css .='display:none;';
		$finance_accounting_custom_css .='} ';
	}
    if($finance_accounting_slider == true){
    	$finance_accounting_custom_css .='@media screen and (max-width:575px) {';
		$finance_accounting_custom_css .='#slider-section{';
			$finance_accounting_custom_css .='display:block;';
		$finance_accounting_custom_css .='} }';
	}else if($finance_accounting_slider == false){
		$finance_accounting_custom_css .='@media screen and (max-width:575px){';
		$finance_accounting_custom_css .='#slider-section{';
			$finance_accounting_custom_css .='display:none;';
		$finance_accounting_custom_css .='} }';
	}

	$finance_accounting_scroll = get_theme_mod( 'finance_accounting_enable_disable_scrolltop',false);
	if($finance_accounting_scroll == true && get_theme_mod( 'finance_accounting_hide_show_scroll',false) != true){
    	$finance_accounting_custom_css .='.scrollup i{';
			$finance_accounting_custom_css .='display:none;';
		$finance_accounting_custom_css .='} ';
	}
    if($finance_accounting_scroll == true){
    	$finance_accounting_custom_css .='@media screen and (max-width:575px) {';
		$finance_accounting_custom_css .='.scrollup i{';
			$finance_accounting_custom_css .='display:block;';
		$finance_accounting_custom_css .='} }';
	}else if($finance_accounting_scroll == false){
		$finance_accounting_custom_css .='@media screen and (max-width:575px){';
		$finance_accounting_custom_css .='.scrollup i{';
			$finance_accounting_custom_css .='display:none;';
		$finance_accounting_custom_css .='} }';
	}

	$finance_accounting_sliderbutton = get_theme_mod( 'finance_accounting_show_hide_slider_button',true);
	if($finance_accounting_sliderbutton == true && get_theme_mod( 'finance_accounting_slider_button', true) == false){
    	$finance_accounting_custom_css .='#slider-section .slide-button{';
			$finance_accounting_custom_css .='display:none;';
		$finance_accounting_custom_css .='} ';
	}
    if($finance_accounting_sliderbutton == true){
    	$finance_accounting_custom_css .='@media screen and (max-width:575px) {';
		$finance_accounting_custom_css .='#slider-section .slide-button{';
			$finance_accounting_custom_css .='display:block;';
		$finance_accounting_custom_css .='} }';
	}else if($finance_accounting_sliderbutton == false){
		$finance_accounting_custom_css .='@media screen and (max-width:575px){';
		$finance_accounting_custom_css .='#slider-section .slide-button{';
			$finance_accounting_custom_css .='display:none;';
		$finance_accounting_custom_css .='} }';
	}

	// Copyright top-bottom padding setting
	$finance_accounting_copyright_top_bottom_padding = get_theme_mod('finance_accounting_copyright_top_bottom_padding');
	$finance_accounting_custom_css .='.site-info{';
		$finance_accounting_custom_css .='padding-top: '.esc_attr($finance_accounting_copyright_top_bottom_padding).'px; padding-bottom: '.esc_attr($finance_accounting_copyright_top_bottom_padding).'px;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_footer_text_font_size = get_theme_mod('finance_accounting_footer_text_font_size', 16);
	$finance_accounting_custom_css .='.site-info{';
		$finance_accounting_custom_css .='font-size: '.esc_attr($finance_accounting_footer_text_font_size).'px;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_footer_heading_alignment = get_theme_mod( 'finance_accounting_footer_heading_option','Left');
    if($finance_accounting_footer_heading_alignment == 'Left'){
		$finance_accounting_custom_css .='.site-footer h3{';
		$finance_accounting_custom_css .='text-align: left;';
		$finance_accounting_custom_css .='}';
	}else if($finance_accounting_footer_heading_alignment == 'Center'){
		$finance_accounting_custom_css .='.site-footer h3{';
			$finance_accounting_custom_css .='text-align: center;';
		$finance_accounting_custom_css .='}';
	}else if($finance_accounting_footer_heading_alignment == 'Right'){
		$finance_accounting_custom_css .='.site-footer h3{';
			$finance_accounting_custom_css .='text-align: right;';
		$finance_accounting_custom_css .='}';
	}

	// Footer Heading Text Transform
	$finance_accounting_theme_lay = get_theme_mod( 'finance_accounting_footer_text_tranform','Capitalize');
	if($finance_accounting_theme_lay == 'Uppercase'){
		$finance_accounting_custom_css .='.site-footer h3{';
			$finance_accounting_custom_css .='text-transform: Uppercase!important;';
		$finance_accounting_custom_css .='}';
	}else if($finance_accounting_theme_lay == 'Lowercase'){
		$finance_accounting_custom_css .='.site-footer h3{';
			$finance_accounting_custom_css .='text-transform: Lowercase!important;';
		$finance_accounting_custom_css .='}';
	}
	else if($finance_accounting_theme_lay == 'Capitalize'){
		$finance_accounting_custom_css .='.site-footer h3{';
			$finance_accounting_custom_css .='text-transform: Capitalize!important;';
		$finance_accounting_custom_css .='}';
	}
	
	// footer heading font size
	$finance_accounting_heading_fontsize = get_theme_mod('finance_accounting_heading_fontsize',25);
	if($finance_accounting_heading_fontsize != false){
		$finance_accounting_custom_css .='.site-footer h3, .site-footer h2, .site-footer .wp-block-search__label,.site-footer .wp-block-heading{';
			$finance_accounting_custom_css .='font-size: '.esc_attr($finance_accounting_heading_fontsize).'px; ';
		$finance_accounting_custom_css .='}';
	}

	$finance_accounting_footer_content_alignment = get_theme_mod( 'finance_accounting_footer_content_option','Left');
    if($finance_accounting_footer_content_alignment == 'Left'){
		$finance_accounting_custom_css .='.site-footer ul, .site-footer p, .site-footer .tagcloud{';
		$finance_accounting_custom_css .='text-align: left;';
		$finance_accounting_custom_css .='}';
	}else if($finance_accounting_footer_content_alignment == 'Center'){
		$finance_accounting_custom_css .='.site-footer ul, .site-footer p, .site-footer .tagcloud{';
			$finance_accounting_custom_css .='text-align: center;';
		$finance_accounting_custom_css .='}';
	}else if($finance_accounting_footer_content_alignment == 'Right'){
		$finance_accounting_custom_css .='.site-footer ul, .site-footer p, .site-footer .tagcloud{';
			$finance_accounting_custom_css .='text-align: right;';
		$finance_accounting_custom_css .='}';
	}

	// scroll to top setting
	$finance_accounting_scroll_border_radius = get_theme_mod('finance_accounting_scroll_border_radius');
	$finance_accounting_custom_css .='.scrollup i{';
		$finance_accounting_custom_css .='border-radius: '.esc_attr($finance_accounting_scroll_border_radius).'px;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_scroll_top_fontsize = get_theme_mod('finance_accounting_scroll_top_fontsize');
	$finance_accounting_custom_css .='.scrollup i{';
		$finance_accounting_custom_css .='font-size: '.esc_attr($finance_accounting_scroll_top_fontsize).'px;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_scroll_top_bottom_padding = get_theme_mod('finance_accounting_scroll_top_bottom_padding');
	$finance_accounting_scroll_left_right_padding = get_theme_mod('finance_accounting_scroll_left_right_padding');
	$finance_accounting_custom_css .='.scrollup i{';
	$finance_accounting_custom_css .='padding-top: '.esc_attr($finance_accounting_scroll_top_bottom_padding).'px;';
	$finance_accounting_custom_css .='padding-bottom: '.esc_attr($finance_accounting_scroll_top_bottom_padding).'px;';
	$finance_accounting_custom_css .='padding-left: '.esc_attr($finance_accounting_scroll_left_right_padding).'px;';
	$finance_accounting_custom_css .= 'padding-right: '.esc_attr($finance_accounting_scroll_left_right_padding).'px;';
	$finance_accounting_custom_css .='}';

	// Slider Height
	$finance_accounting_slider_height_option = get_theme_mod('finance_accounting_slider_height_option');
	$finance_accounting_custom_css .='#slider-section img{';
		$finance_accounting_custom_css .='height: '.esc_attr($finance_accounting_slider_height_option).'px;';
	$finance_accounting_custom_css .='}';

	// comment settings
	$finance_accounting_comment_button_text = get_theme_mod('finance_accounting_comment_button_text', 'Post Comment');
	if($finance_accounting_comment_button_text == ''){
		$finance_accounting_custom_css .='#comments p.form-submit {';
			$finance_accounting_custom_css .='display: none;';
		$finance_accounting_custom_css .='}';
	}

	$finance_accounting_comment_form_heading = get_theme_mod('finance_accounting_comment_form_heading', 'Leave a Reply');
	if($finance_accounting_comment_form_heading == ''){
		$finance_accounting_custom_css .='#comments h2#reply-title {';
			$finance_accounting_custom_css .='display: none;';
		$finance_accounting_custom_css .='}';
	}

	$finance_accounting_comment_form_size = get_theme_mod( 'finance_accounting_comment_form_size',100);
	$finance_accounting_custom_css .='#comments textarea{';
		$finance_accounting_custom_css .='width: '.esc_attr($finance_accounting_comment_form_size).'%;';
	$finance_accounting_custom_css .='}';

	/*------------ Woocommerce Settings  --------------*/
	$finance_accounting_shop_button_padding_top = get_theme_mod('finance_accounting_shop_button_padding_top', 9);
	$finance_accounting_custom_css .='.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled]{';
		$finance_accounting_custom_css .='padding-top: '.esc_attr($finance_accounting_shop_button_padding_top).'px; padding-bottom: '.esc_attr($finance_accounting_shop_button_padding_top).'px;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_shop_button_padding_left = get_theme_mod('finance_accounting_shop_button_padding_left', 16);
	$finance_accounting_custom_css .='.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled]{';
		$finance_accounting_custom_css .='padding-left: '.esc_attr($finance_accounting_shop_button_padding_left).'px; padding-right: '.esc_attr($finance_accounting_shop_button_padding_left).'px;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_shop_button_border_radius = get_theme_mod('finance_accounting_shop_button_border_radius',0);
	$finance_accounting_custom_css .='.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt{';
		$finance_accounting_custom_css .='border-radius: '.esc_attr($finance_accounting_shop_button_border_radius).'px;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_display_related_products = get_theme_mod('finance_accounting_display_related_products',true);
	if($finance_accounting_display_related_products == false){
		$finance_accounting_custom_css .='.related.products{';
			$finance_accounting_custom_css .='display: none;';
		$finance_accounting_custom_css .='}';
	}

	$finance_accounting_shop_products_border = get_theme_mod('finance_accounting_shop_products_border', true);
	if($finance_accounting_shop_products_border == false){
		$finance_accounting_custom_css .='.woocommerce .products li{';
			$finance_accounting_custom_css .='border: none;';
		$finance_accounting_custom_css .='}';
	}

	$finance_accounting_shop_page_top_padding = get_theme_mod('finance_accounting_shop_page_top_padding',10);
	$finance_accounting_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
		$finance_accounting_custom_css .='padding-top: '.esc_attr($finance_accounting_shop_page_top_padding).'px !important; padding-bottom: '.esc_attr($finance_accounting_shop_page_top_padding).'px !important;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_shop_page_left_padding = get_theme_mod('finance_accounting_shop_page_left_padding',10);
	$finance_accounting_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
		$finance_accounting_custom_css .='padding-left: '.esc_attr($finance_accounting_shop_page_left_padding).'px !important; padding-right: '.esc_attr($finance_accounting_shop_page_left_padding).'px !important;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_shop_page_border_radius = get_theme_mod('finance_accounting_shop_page_border_radius',0);
	$finance_accounting_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
		$finance_accounting_custom_css .='border-radius: '.esc_attr($finance_accounting_shop_page_border_radius).'px;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_shop_page_box_shadow = get_theme_mod('finance_accounting_shop_page_box_shadow',0);
	$finance_accounting_custom_css .='.woocommerce ul.products li.product, .woocommerce-page ul.products li.product{';
		$finance_accounting_custom_css .='box-shadow: '.esc_attr($finance_accounting_shop_page_box_shadow).'px '.esc_attr($finance_accounting_shop_page_box_shadow).'px '.esc_attr($finance_accounting_shop_page_box_shadow).'px #e4e4e4;';
	$finance_accounting_custom_css .='}';

	// footer widget background
	$finance_accounting_footer_widget_background = get_theme_mod('finance_accounting_footer_widget_background', '#000');
	$finance_accounting_custom_css .='.site-footer{';
		$finance_accounting_custom_css .='background-color: '.esc_attr($finance_accounting_footer_widget_background).';';
	$finance_accounting_custom_css .='}';

	$finance_accounting_footer_widget_image = get_theme_mod('finance_accounting_footer_widget_image');
	if($finance_accounting_footer_widget_image != false){
		$finance_accounting_custom_css .='.site-footer{';
			$finance_accounting_custom_css .='background: url('.esc_attr($finance_accounting_footer_widget_image).');';
			$finance_accounting_custom_css .='background-repeat: no-repeat;';
			$finance_accounting_custom_css .='background-size: cover;';
		$finance_accounting_custom_css .='}';
	}

	$finance_accounting_theme_lay = get_theme_mod( 'finance_accounting_img_footer','scroll');
	if($finance_accounting_theme_lay == 'fixed'){
		$finance_accounting_custom_css .='.site-footer{';
			$finance_accounting_custom_css .='background-attachment: fixed !important;';
		$finance_accounting_custom_css .='}';
	}elseif ($finance_accounting_theme_lay == 'scroll'){
		$finance_accounting_custom_css .='.site-footer{';
			$finance_accounting_custom_css .='background-attachment: scroll !important;';
		$finance_accounting_custom_css .='}';
	}

	$finance_accounting_footer_img_position = get_theme_mod('finance_accounting_footer_img_position','center center');
	if($finance_accounting_footer_img_position != false){
		$finance_accounting_custom_css .='.site-footer{';
			$finance_accounting_custom_css .='background-position: '.esc_attr($finance_accounting_footer_img_position).'!important;';
		$finance_accounting_custom_css .='}';
	} 

	//Footer Social Icon Font size
	$finance_accounting_footer_icon_font_size = get_theme_mod('finance_accounting_footer_icon_font_size');
	$finance_accounting_custom_css .='.site-info .socialicons a{';
	$finance_accounting_custom_css .='font-size: '.esc_attr($finance_accounting_footer_icon_font_size).'px;';
	$finance_accounting_custom_css .='}';

	//footer icon color
	$finance_accounting_footer_icon_color = get_theme_mod('finance_accounting_footer_icon_color', '');
	$finance_accounting_custom_css .='.site-info .socialicons a{';
	$finance_accounting_custom_css .='color: '.esc_attr($finance_accounting_footer_icon_color).'!important;';
	$finance_accounting_custom_css .='}';	

	/*---------------------------Footer top bottom padding -------------------*/
	$finance_accounting_footer_padding = get_theme_mod('finance_accounting_footer_padding');
	if($finance_accounting_footer_padding != false){
		$finance_accounting_custom_css .='.site-footer{';
			$finance_accounting_custom_css .='padding: '.esc_attr($finance_accounting_footer_padding).' 0 !important;';
		$finance_accounting_custom_css .='}';
	}

	/*------------- Navigation Menu Font Size ------------------*/
	$finance_accounting_navigation_menu_font_size = get_theme_mod('finance_accounting_navigation_menu_font_size');{
		$finance_accounting_custom_css .='.main-navigation a, .navigation-top a{';
			$finance_accounting_custom_css .='font-size: '.esc_attr($finance_accounting_navigation_menu_font_size).'px;';
		$finance_accounting_custom_css .='}';
	}

	$finance_accounting_theme_lay = get_theme_mod( 'finance_accounting_menu_text_tranform','Default');
	if($finance_accounting_theme_lay == 'Uppercase'){
		$finance_accounting_custom_css .='.main-navigation a, .navigation-top a,.main-navigation ul ul a, .main-navigation ul ul li a{';
			$finance_accounting_custom_css .='text-transform:Uppercase;';
		$finance_accounting_custom_css .='}';
	}else if($finance_accounting_theme_lay == 'Lowercase'){
		$finance_accounting_custom_css .='.main-navigation a, .navigation-top a,.main-navigation ul ul a, .main-navigation ul ul li a{';
			$finance_accounting_custom_css .='text-transform:lowercase;';
		$finance_accounting_custom_css .='}';
	}
	
	/*------------- Navigation Menu Font Weight ------------------*/
	$finance_accounting_menu_font_weight = get_theme_mod('finance_accounting_menu_font_weight');
	$finance_accounting_custom_css .='.main-navigation a, .navigation-top a,.main-navigation ul li a{';
		$finance_accounting_custom_css .='font-weight: '.esc_attr($finance_accounting_menu_font_weight).';';
	$finance_accounting_custom_css .='}';

	// menu color
	$finance_accounting_menu_color = get_theme_mod('finance_accounting_menu_color');
	$finance_accounting_custom_css .='.main-navigation a, .main-navigation ul li a, #site-navigation li a{';
			$finance_accounting_custom_css .='color: '.esc_attr($finance_accounting_menu_color).' !important;';
	$finance_accounting_custom_css .='}';

	// Sub menu color
	$finance_accounting_sub_menu_color = get_theme_mod('finance_accounting_sub_menu_color');
	$finance_accounting_custom_css .='.main-navigation ul.sub-menu a, .main-navigation ul.sub-menu li a, #site-navigation ul.sub-menu li a{';
			$finance_accounting_custom_css .='color: '.esc_attr($finance_accounting_sub_menu_color).' !important;';
	$finance_accounting_custom_css .='}';

	// menu hover color
	$finance_accounting_menu_hover_color = get_theme_mod('finance_accounting_menu_hover_color');
	$finance_accounting_custom_css .='.main-navigation a:hover, .main-navigation ul li a:hover, .main-navigation .current_page_item > a:hover, .main-navigation .current-menu-item > a:hover, .main-navigation .current_page_ancestor > a:hover, #site-navigation li a:hover{';
			$finance_accounting_custom_css .='color: '.esc_attr($finance_accounting_menu_hover_color).' !important;';
	$finance_accounting_custom_css .='}';

	// Sub menu hover color
	$finance_accounting_sub_menu_hover_color = get_theme_mod('finance_accounting_sub_menu_hover_color');
	$finance_accounting_custom_css .='.main-navigation ul.sub-menu a:hover, .main-navigation ul.sub-menu li a:hover, .main-navigation .current_page_item > a:hover, .main-navigation .current-menu-item > a:hover, .main-navigation .current_page_ancestor > a:hover, #site-navigation ul.sub-menu li a:hover{';
			$finance_accounting_custom_css .='color: '.esc_attr($finance_accounting_sub_menu_hover_color).' !important;';
	$finance_accounting_custom_css .='}';

	// menu hover effect
	$finance_accounting_menus_item = get_theme_mod( 'finance_accounting_menus_item_style','None');
    if($finance_accounting_menus_item == 'None'){
		$finance_accounting_custom_css .='.main-navigation ul li a{';
			$finance_accounting_custom_css .='';
		$finance_accounting_custom_css .='}';
	}else if($finance_accounting_menus_item == 'Zoom In'){
		$finance_accounting_custom_css .='.main-navigation ul li a:hover{';
			$finance_accounting_custom_css .='transition: all 0.3s ease-in-out !important; transform: scale(1.2) !important;';
		$finance_accounting_custom_css .='}';
	}

	// site title font size option
	$finance_accounting_site_title_font_size = get_theme_mod('finance_accounting_site_title_font_size', 35);{
	$finance_accounting_custom_css .='.logo h1, .site-title a{';
	$finance_accounting_custom_css .='font-size: '.esc_attr($finance_accounting_site_title_font_size).'px;';
		$finance_accounting_custom_css .='}';
	}

	$finance_accounting_site_tagline_font_size_settings = get_theme_mod('finance_accounting_site_tagline_font_size_settings', 14);{
	$finance_accounting_custom_css .='.logo p{';
	$finance_accounting_custom_css .='font-size: '.esc_attr($finance_accounting_site_tagline_font_size_settings).'px !important;';
		$finance_accounting_custom_css .='}';
	}

	// -------------- site logo margin ------------
	$finance_accounting_logo_margin = get_theme_mod('finance_accounting_logo_margin', '');{
	$finance_accounting_custom_css .='.logo{';
	$finance_accounting_custom_css .='margin: '.esc_attr($finance_accounting_logo_margin).'px ;';
	$finance_accounting_custom_css .='}';
	}
   //  ------------------logo padding-----------
   $finance_accounting_logo_padding = get_theme_mod('finance_accounting_logo_padding');
   $finance_accounting_custom_css .='.logo{';
   $finance_accounting_custom_css .='padding: '.esc_attr($finance_accounting_logo_padding).'px;';
   $finance_accounting_custom_css .='}';

	/*------------------ Background Skin Option  -------------------*/
	$finance_accounting_theme_lay = get_theme_mod( 'finance_accounting_background_image_type','Transparent');
    if($finance_accounting_theme_lay == 'Background'){
		$finance_accounting_custom_css .='.blogger, #sidebox .widget, .related-posts .page-box, .woocommerce ul.products li.product, .woocommerce-page ul.products li.product, .background-img-skin, .pages-te, .woocommerce .woocommerce-ordering, #masthead, #services .services-content{';
			$finance_accounting_custom_css .='background-color: #fff; padding:10px;';
		$finance_accounting_custom_css .='}';
		$finance_accounting_custom_css .='#sidebox .widget{';
			$finance_accounting_custom_css .='padding:10px;;';
		$finance_accounting_custom_css .='}';
	}else if($finance_accounting_theme_lay == 'Transparent'){
		$finance_accounting_custom_css .='{';
			$finance_accounting_custom_css .='background-color: transparent;';
		$finance_accounting_custom_css .='}';
	}

	// slider overlay
	$finance_accounting_show_slider_image_overlay = get_theme_mod('finance_accounting_show_slider_image_overlay', true);
	if($finance_accounting_show_slider_image_overlay == false){
		$finance_accounting_custom_css .='#slider-section img{';
			$finance_accounting_custom_css .='opacity:1;';
		$finance_accounting_custom_css .='}';
	}
	$finance_accounting_color_slider_image_overlay = get_theme_mod('finance_accounting_color_slider_image_overlay', true);
	if($finance_accounting_show_slider_image_overlay != false){
		$finance_accounting_custom_css .='#slider-section{';
			$finance_accounting_custom_css .='background-color: '.esc_attr($finance_accounting_color_slider_image_overlay).';';
		$finance_accounting_custom_css .='}';
	}

	// woocommerce product sale settings
	$finance_accounting_border_radius_product_sale_text = get_theme_mod('finance_accounting_border_radius_product_sale_text',50);
	$finance_accounting_custom_css .='.woocommerce span.onsale {';
		$finance_accounting_custom_css .='border-radius: '.esc_attr($finance_accounting_border_radius_product_sale_text).'%;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_position_product_sale = get_theme_mod('finance_accounting_position_product_sale', 'Right');
	if($finance_accounting_position_product_sale == 'Right' ){
		$finance_accounting_custom_css .='.woocommerce ul.products li.product .onsale{';
			$finance_accounting_custom_css .=' left:auto; right:0;';
		$finance_accounting_custom_css .='}';
	}elseif($finance_accounting_position_product_sale == 'Left' ){
		$finance_accounting_custom_css .='.woocommerce ul.products li.product .onsale{';
			$finance_accounting_custom_css .=' left:0; right:auto;';
		$finance_accounting_custom_css .='}';
	}

	$finance_accounting_product_sale_text_size = get_theme_mod('finance_accounting_product_sale_text_size',14);
	$finance_accounting_custom_css .='.woocommerce span.onsale{';
		$finance_accounting_custom_css .='font-size: '.esc_attr($finance_accounting_product_sale_text_size).'px;';
	$finance_accounting_custom_css .='}';

	$finance_accounting_top_bottom_product_sale_padding = get_theme_mod('finance_accounting_top_bottom_product_sale_padding');
	$finance_accounting_left_right_product_sale_padding = get_theme_mod('finance_accounting_left_right_product_sale_padding');
	$finance_accounting_custom_css .='.woocommerce span.onsale{';
		$finance_accounting_custom_css .='padding-top: '.esc_attr($finance_accounting_top_bottom_product_sale_padding).'px; padding-bottom: '.esc_attr($finance_accounting_top_bottom_product_sale_padding).'px; padding-left: '.esc_attr($finance_accounting_left_right_product_sale_padding).'px; padding-right: '.esc_attr($finance_accounting_left_right_product_sale_padding).'px; display:inline-block;';
	$finance_accounting_custom_css .='}';

	// woocommerce Product Navigation
	$finance_accounting_shop_products_navigation = get_theme_mod('finance_accounting_shop_products_navigation', 'Yes');
	if($finance_accounting_shop_products_navigation == 'No'){
		$finance_accounting_custom_css .='.woocommerce nav.woocommerce-pagination{';
			$finance_accounting_custom_css .='display: none;';
		$finance_accounting_custom_css .='}';
	}

	// Post Block
	$finance_accounting_post_break_block_setting = get_theme_mod( 'finance_accounting_post_break_block_setting','Into Blocks');
    if($finance_accounting_post_break_block_setting == 'Without Blocks'){
		$finance_accounting_custom_css .='.blogger, .blogger:hover{';
			$finance_accounting_custom_css .='border: none; margin:30px 0; box-shadow:none;';
		$finance_accounting_custom_css .='}';
	}

	// Pagination Alignment
	$finance_accounting_post_pagination_alignment = get_theme_mod( 'finance_accounting_post_pagination_option','Left');
    if($finance_accounting_post_pagination_alignment == 'Left'){
		$finance_accounting_custom_css .='.navigation nav.pagination{';
		$finance_accounting_custom_css .='justify-content: left;';
		$finance_accounting_custom_css .='}';
	}else if($finance_accounting_post_pagination_alignment == 'Center'){
		$finance_accounting_custom_css .='.navigation nav.pagination{';
			$finance_accounting_custom_css .='justify-content: center;';
		$finance_accounting_custom_css .='}';
	}else if($finance_accounting_post_pagination_alignment == 'Right'){
		$finance_accounting_custom_css .='.navigation nav.pagination{';
			$finance_accounting_custom_css .='justify-content: right;';
		$finance_accounting_custom_css .='}';
	}

	// fixed header padding option
	$finance_accounting_fixed_header_padding_option = get_theme_mod('finance_accounting_fixed_header_padding_option');
	$finance_accounting_custom_css .='.fixed-header{';
		$finance_accounting_custom_css .='padding: '.esc_attr($finance_accounting_fixed_header_padding_option).'px;';
	$finance_accounting_custom_css .='}';

	// slider top and bottom padding
	$finance_accounting_padding_top_bottom_slider_content = get_theme_mod('finance_accounting_padding_top_bottom_slider_content');
	$finance_accounting_padding_left_right_slider_content = get_theme_mod('finance_accounting_padding_left_right_slider_content');
	$finance_accounting_custom_css .='#slider-section .carousel-caption{';
		$finance_accounting_custom_css .='top: '.esc_attr($finance_accounting_padding_top_bottom_slider_content).'%; bottom: '.esc_attr($finance_accounting_padding_top_bottom_slider_content).'%;left: '.esc_attr($finance_accounting_padding_left_right_slider_content).'%;right: '.esc_attr($finance_accounting_padding_left_right_slider_content).'%;';
	$finance_accounting_custom_css .='}';

    //Copyright background css
	$finance_accounting_copyright_background_color = get_theme_mod('finance_accounting_copyright_background_color');
	$finance_accounting_custom_css .='.site-info{';
		$finance_accounting_custom_css .='background-color: '.esc_attr($finance_accounting_copyright_background_color).';';
	$finance_accounting_custom_css .='}';

	$finance_accounting_copyright_text_color = get_theme_mod('finance_accounting_copyright_text_color');
	$finance_accounting_custom_css .='.site-info , .site-info a{';
		$finance_accounting_custom_css .='color: '.esc_attr($finance_accounting_copyright_text_color).'!important;';
	$finance_accounting_custom_css .='}';

    // featured image dimention
	$finance_accounting_post_image_dimention = get_theme_mod('finance_accounting_post_image_dimention', 'Default');
	$finance_accounting_post_featured_image_width = get_theme_mod('finance_accounting_post_featured_image_width');
	$finance_accounting_post_featured_image_height = get_theme_mod('finance_accounting_post_featured_image_height');
	if($finance_accounting_post_image_dimention == 'Custom Image Size'){
		$finance_accounting_custom_css .='.blogger .post-image img{';
			$finance_accounting_custom_css .='width: '.esc_attr($finance_accounting_post_featured_image_width).'px; height: '.esc_attr($finance_accounting_post_featured_image_height).'px;';
		$finance_accounting_custom_css .='}';
	}

	// site title color option
	$finance_accounting_site_title_color_setting = get_theme_mod('finance_accounting_site_title_color_setting');
	$finance_accounting_custom_css .=' .logo h1 a,.site-title a{';
		$finance_accounting_custom_css .='color: '.esc_attr($finance_accounting_site_title_color_setting).';';
	$finance_accounting_custom_css .='} ';

	$finance_accounting_tagline_color_setting = get_theme_mod('finance_accounting_tagline_color_setting');
	$finance_accounting_custom_css .=' .logo p.site-description{';
		$finance_accounting_custom_css .='color: '.esc_attr($finance_accounting_tagline_color_setting).';';
	$finance_accounting_custom_css .='} ';

    // Single Post Categories
	$finance_accounting_show_hide_single_post_categories = get_theme_mod('finance_accounting_show_hide_single_post_categories',false);
	if ($finance_accounting_show_hide_single_post_categories == false) {
	$finance_accounting_custom_css .='.post-info{';
	$finance_accounting_custom_css .=' margin-top:20px;';
	$finance_accounting_custom_css .='}';
	}

	// Blog post image border radius
    $finance_accounting_blog_post_img_border_radius = get_theme_mod('finance_accounting_blog_post_img_border_radius', 0);
	$finance_accounting_custom_css .='.blogger .post-image img{';
		$finance_accounting_custom_css .='border-radius: '.esc_attr($finance_accounting_blog_post_img_border_radius).'px;';
	$finance_accounting_custom_css .='}';

     // Blog post image box shadow
	$finance_accounting_blog_post_img_box_shadow = get_theme_mod('finance_accounting_blog_post_img_box_shadow',0);
	$finance_accounting_custom_css .='.blogger .post-image img{';
		$finance_accounting_custom_css .='box-shadow: '.esc_attr($finance_accounting_blog_post_img_box_shadow).'px '.esc_attr($finance_accounting_blog_post_img_box_shadow).'px '.esc_attr($finance_accounting_blog_post_img_box_shadow).'px #ccc;';
	$finance_accounting_custom_css .='}';

    // Single post image border radious
	$finance_accounting_single_post_img_border_radius = get_theme_mod('finance_accounting_single_post_img_border_radius', 0);
	$finance_accounting_custom_css .='.blogger.singlebox img{';
		$finance_accounting_custom_css .='border-radius: '.esc_attr($finance_accounting_single_post_img_border_radius).'px;';
	$finance_accounting_custom_css .='}';

	 // Single post image box shadow
	$finance_accounting_single_post_img_box_shadow = get_theme_mod('finance_accounting_single_post_img_box_shadow',0);
	$finance_accounting_custom_css .='.blogger.singlebox img{';
		$finance_accounting_custom_css .='box-shadow: '.esc_attr($finance_accounting_single_post_img_box_shadow).'px '.esc_attr($finance_accounting_single_post_img_box_shadow).'px '.esc_attr($finance_accounting_single_post_img_box_shadow).'px #ccc;';
	$finance_accounting_custom_css .='}';

	// Single post comments
	$finance_accounting_post_comment_enable = get_theme_mod('finance_accounting_post_comment_enable',true);
	if($finance_accounting_post_comment_enable == false){
		$finance_accounting_custom_css .='#comments{';
			$finance_accounting_custom_css .='display: none;';
		$finance_accounting_custom_css .='}';
	}

	// single post image dimention
	$finance_accounting_single_post_image_dimention = get_theme_mod('finance_accounting_single_post_image_dimention', 'Default');
	$finance_accounting_single_post_featured_image_width = get_theme_mod('finance_accounting_single_post_featured_image_width');
	$finance_accounting_single_post_featured_image_height = get_theme_mod('finance_accounting_single_post_featured_image_height');
	if($finance_accounting_single_post_image_dimention == 'Custom Image Size'){
		$finance_accounting_custom_css .='.blogger.singlebox .single-post-image img{';
			$finance_accounting_custom_css .='width: '.esc_attr($finance_accounting_single_post_featured_image_width).'px; height: '.esc_attr($finance_accounting_single_post_featured_image_height).'px;';
		$finance_accounting_custom_css .='}';
	}

	// Related post image box shadow
	$finance_accounting_related_post_image_shadow = get_theme_mod('finance_accounting_related_post_image_shadow',0);
	if($finance_accounting_related_post_image_shadow != false){
		$finance_accounting_custom_css .='.page-box .post-image img{';
			$finance_accounting_custom_css .='box-shadow: '.esc_attr($finance_accounting_related_post_image_shadow).'px '.esc_attr($finance_accounting_related_post_image_shadow).'px '.esc_attr($finance_accounting_related_post_image_shadow).'px #cccccc;';
		$finance_accounting_custom_css .='}';
	}

	//scroll to top css
	$finance_accounting_scroll_background_color = get_theme_mod('finance_accounting_scroll_background_color');
	$finance_accounting_custom_css .='.scrollup i{';
	$finance_accounting_custom_css .='background: '.esc_attr($finance_accounting_scroll_background_color).';';
	$finance_accounting_custom_css .='border-color: '.esc_attr($finance_accounting_scroll_background_color).';';
	$finance_accounting_custom_css .='}';

	$finance_accounting_scroll_icon_color = get_theme_mod('finance_accounting_scroll_icon_color');
	$finance_accounting_custom_css .='.scrollup i{';
	$finance_accounting_custom_css .='color: '.esc_attr($finance_accounting_scroll_icon_color).';';
	$finance_accounting_custom_css .='}';

	$finance_accounting_scroll_background_hover_color = get_theme_mod('finance_accounting_scroll_background_hover_color');
	$finance_accounting_custom_css .='.scrollup i:hover{';
	$finance_accounting_custom_css .='background: '.esc_attr($finance_accounting_scroll_background_hover_color).';';
	$finance_accounting_custom_css .='border-color: '.esc_attr($finance_accounting_scroll_background_hover_color).';';
	$finance_accounting_custom_css .='}';

	//Initial Cap
	$finance_accounting_caps_enable = get_theme_mod('finance_accounting_caps_enable', 'false');
	if($finance_accounting_caps_enable == 'true' ){
	$finance_accounting_custom_css .='.blogger .text p:nth-of-type(1)::first-letter{';
	$finance_accounting_custom_css .=' font-size: 60px; font-weight: 800;';
	$finance_accounting_custom_css .=' margin-right: 10px;';
	$finance_accounting_custom_css .=' font-family: "Vollkorn", serif;';
	$finance_accounting_custom_css .=' line-height: 1;';
	$finance_accounting_custom_css .='}';
	}elseif($finance_accounting_caps_enable == 'false' ){
	$finance_accounting_custom_css .='.blogger .text p:nth-of-type(1)::first-letter {';
	$finance_accounting_custom_css .='display: none;';
	$finance_accounting_custom_css .='}';
	}