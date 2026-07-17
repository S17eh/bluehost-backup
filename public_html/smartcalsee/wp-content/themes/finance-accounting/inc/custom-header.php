<?php
/**
 * Custom header implementation
 */

function finance_accounting_custom_header_setup() {

	add_theme_support( 'custom-header', apply_filters( 'finance_accounting_custom_header_args', array(

		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1355,
		'height'                 => 208,
		'flex-width'         	=> true,
        'flex-height'        	=> true,
		'wp-head-callback'       => 'finance_accounting_header_style',
	) ) );

}

add_action( 'after_setup_theme', 'finance_accounting_custom_header_setup' );

if ( ! function_exists( 'finance_accounting_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see finance_accounting_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'finance_accounting_header_style' );
function finance_accounting_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$finance_accounting_custom_css = "
        #masthead{
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
		}";
	   	wp_add_inline_style( 'finance-accounting-style', $finance_accounting_custom_css );
	endif;
}
endif; // finance_accounting_header_style