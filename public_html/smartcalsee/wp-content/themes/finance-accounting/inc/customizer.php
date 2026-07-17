<?php
/**
 * Finance Accounting: Customizer
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function finance_accounting_custom_controls() {

	load_template( trailingslashit( get_template_directory() ) . '/inc/custom-control.php' );
}

add_action( 'customize_register', 'finance_accounting_custom_controls' );

function finance_accounting_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-changer.php' );

	$wp_customize->add_panel( 'finance_accounting_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Theme Settings', 'finance-accounting' ),
	    'description' => __( 'Description of what this panel does.', 'finance-accounting' ),
	) );

	// font array
	$finance_accounting_font_array = array(
        '' => 'No Fonts',
        'Abril Fatface' => 'Abril Fatface',
        'Acme' => 'Acme',
        'Anton' => 'Anton',
        'Architects Daughter' => 'Architects Daughter',
        'Arimo' => 'Arimo',
        'Arsenal' => 'Arsenal',
        'Arvo' => 'Arvo',
        'Alegreya' => 'Alegreya',
        'Alfa Slab One' => 'Alfa Slab One',
        'Averia Serif Libre' => 'Averia Serif Libre',
        'Bangers' => 'Bangers',
        'Boogaloo' => 'Boogaloo',
        'Bad Script' => 'Bad Script',
        'Bitter' => 'Bitter',
        'Bree Serif' => 'Bree Serif',
        'BenchNine' => 'BenchNine',
        'Cabin' => 'Cabin',
        'Cardo' => 'Cardo',
        'Courgette' => 'Courgette',
        'Cherry Swash' => 'Cherry Swash',
        'Cormorant Garamond' => 'Cormorant Garamond',
        'Crimson Text' => 'Crimson Text',
        'Cuprum' => 'Cuprum',
        'Cookie' => 'Cookie',
        'Chewy' => 'Chewy',
        'Days One' => 'Days One',
        'Dosis' => 'Dosis',
        'Droid Sans' => 'Droid Sans',
        'Economica' => 'Economica',
        'Fredoka One' => 'Fredoka One',
        'Fjalla One' => 'Fjalla One',
        'Francois One' => 'Francois One',
        'Frank Ruhl Libre' => 'Frank Ruhl Libre',
        'Gloria Hallelujah' => 'Gloria Hallelujah',
        'Great Vibes' => 'Great Vibes',
        'Handlee' => 'Handlee',
        'Hammersmith One' => 'Hammersmith One',
        'Inconsolata' => 'Inconsolata',
        'Indie Flower' => 'Indie Flower',
        'IM Fell English SC' => 'IM Fell English SC',
        'Julius Sans One' => 'Julius Sans One',
        'Josefin Slab' => 'Josefin Slab',
        'Josefin Sans' => 'Josefin Sans',
        'Kanit' => 'Kanit',
        'Lobster' => 'Lobster',
        'Lato' => 'Lato',
        'Lora' => 'Lora',
        'Libre Baskerville' =>'Libre Baskerville',
        'Lobster Two' => 'Lobster Two',
        'Merriweather' =>'Merriweather',
        'Monda' => 'Monda',
        'Montserrat' => 'Montserrat',
        'Muli' => 'Muli',
        'Marck Script' => 'Marck Script',
        'Noto Serif' => 'Noto Serif',
        'Open Sans' => 'Open Sans',
        'Overpass' => 'Overpass',
        'Overpass Mono' => 'Overpass Mono',
        'Oxygen' => 'Oxygen',
        'Orbitron' => 'Orbitron',
        'Patua One' => 'Patua One',
        'Pacifico' => 'Pacifico',
        'Padauk' => 'Padauk',
        'Playball' => 'Playball',
        'Playfair Display' => 'Playfair Display',
        'PT Sans' => 'PT Sans',
        'Philosopher' => 'Philosopher',
        'Permanent Marker' => 'Permanent Marker',
        'Poiret One' => 'Poiret One',
        'Quicksand' => 'Quicksand',
        'Quattrocento Sans' => 'Quattrocento Sans',
        'Raleway' => 'Raleway',
        'Rubik' => 'Rubik',
        'Rokkitt' => 'Rokkitt',
        'Russo One' => 'Russo One',
        'Righteous' => 'Righteous',
        'Slabo' => 'Slabo',
        'Source Sans Pro' => 'Source Sans Pro',
        'Shadows Into Light Two' =>'Shadows Into Light Two',
        'Shadows Into Light' => 'Shadows Into Light',
        'Sacramento' => 'Sacramento',
        'Shrikhand' => 'Shrikhand',
        'Tangerine' => 'Tangerine',
        'Ubuntu' => 'Ubuntu',
        'VT323' => 'VT323',
        'Varela Round' => 'Varela Round',
        'Vampiro One' => 'Vampiro One',
        'Vollkorn' => 'Vollkorn',
        'Volkhov' => 'Volkhov',
        'Yanone Kaffeesatz' => 'Yanone Kaffeesatz',
    );

	//Typography
	$wp_customize->add_section( 'finance_accounting_typography', array(
    	'title'      => __( 'Color / Fonts Settings', 'finance-accounting' ),
		'panel' => 'finance_accounting_panel_id'
	) );

	$wp_customize->add_setting('finance_accounting_typography_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_typography_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_typography'
	));


	// This is Body Color setting
	$wp_customize->add_setting( 'finance_accounting_body_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'finance_accounting_body_color', array(
		'label' => __('Body Color', 'finance-accounting'),
		'section' => 'finance_accounting_typography',
		'settings' => 'finance_accounting_body_color',
	)));

	//This is Body FontFamily  setting
	$wp_customize->add_setting('finance_accounting_body_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control(
		'finance_accounting_body_font_family', array(
		'section'  => 'finance_accounting_typography',
		'label'    => __( 'Body Fonts','finance-accounting'),
		'type'     => 'select',
		'choices'  => $finance_accounting_font_array,
	));

    //This is Body Fontsize setting
	$wp_customize->add_setting('finance_accounting_body_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_body_font_size',array(
		'label'	=> __('Body Font Size','finance-accounting'),
		'section'	=> 'finance_accounting_typography',
		'setting'	=> 'finance_accounting_body_font_size',
		'type'	=> 'text'
	));

	// This is Paragraph Color picker setting
	$wp_customize->add_setting( 'finance_accounting_paragraph_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'finance_accounting_paragraph_color', array(
		'label' => __('Paragraph Color', 'finance-accounting'),
		'section' => 'finance_accounting_typography',
		'settings' => 'finance_accounting_paragraph_color',
	)));

	//This is Paragraph FontFamily picker setting
	$wp_customize->add_setting('finance_accounting_paragraph_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control(
	    'finance_accounting_paragraph_font_family', array(
	    'section'  => 'finance_accounting_typography',
	    'label'    => __( 'Paragraph Fonts','finance-accounting'),
	    'type'     => 'select',
	    'choices'  => $finance_accounting_font_array,
	));

	$wp_customize->add_setting('finance_accounting_paragraph_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_paragraph_font_size',array(
		'label'	=> __('Paragraph Font Size','finance-accounting'),
		'section'	=> 'finance_accounting_typography',
		'setting'	=> 'finance_accounting_paragraph_font_size',
		'type'	=> 'text'
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'finance_accounting_atag_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'finance_accounting_atag_color', array(
		'label' => __('"a" Tag Color', 'finance-accounting'),
		'section' => 'finance_accounting_typography',
		'settings' => 'finance_accounting_atag_color',
	)));

	//This is "a" Tag FontFamily picker setting
	$wp_customize->add_setting('finance_accounting_atag_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control(
	    'finance_accounting_atag_font_family', array(
	    'section'  => 'finance_accounting_typography',
	    'label'    => __( '"a" Tag Fonts','finance-accounting'),
	    'type'     => 'select',
	    'choices'  => $finance_accounting_font_array,
	));

	// This is "a" Tag Color picker setting
	$wp_customize->add_setting( 'finance_accounting_li_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'finance_accounting_li_color', array(
		'label' => __('"li" Tag Color', 'finance-accounting'),
		'section' => 'finance_accounting_typography',
		'settings' => 'finance_accounting_li_color',
	)));

	//This is "li" Tag FontFamily picker setting
	$wp_customize->add_setting('finance_accounting_li_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control(
	    'finance_accounting_li_font_family', array(
	    'section'  => 'finance_accounting_typography',
	    'label'    => __( '"li" Tag Fonts','finance-accounting'),
	    'type'     => 'select',
	    'choices'  => $finance_accounting_font_array,
	));

	// This is H1 Color picker setting
	$wp_customize->add_setting( 'finance_accounting_h1_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'finance_accounting_h1_color', array(
		'label' => __('H1 Color', 'finance-accounting'),
		'section' => 'finance_accounting_typography',
		'settings' => 'finance_accounting_h1_color',
	)));

	//This is H1 FontFamily picker setting
	$wp_customize->add_setting('finance_accounting_h1_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control(
	    'finance_accounting_h1_font_family', array(
	    'section'  => 'finance_accounting_typography',
	    'label'    => __( 'H1 Fonts','finance-accounting'),
	    'type'     => 'select',
	    'choices'  => $finance_accounting_font_array,
	));

	//This is H1 FontSize setting
	$wp_customize->add_setting('finance_accounting_h1_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_h1_font_size',array(
		'label'	=> __('H1 Font Size','finance-accounting'),
		'section'	=> 'finance_accounting_typography',
		'setting'	=> 'finance_accounting_h1_font_size',
		'type'	=> 'text'
	));

	// This is H2 Color picker setting
	$wp_customize->add_setting( 'finance_accounting_h2_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'finance_accounting_h2_color', array(
		'label' => __('h2 Color', 'finance-accounting'),
		'section' => 'finance_accounting_typography',
		'settings' => 'finance_accounting_h2_color',
	)));

	//This is H2 FontFamily picker setting
	$wp_customize->add_setting('finance_accounting_h2_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control(
	    'finance_accounting_h2_font_family', array(
	    'section'  => 'finance_accounting_typography',
	    'label'    => __( 'h2 Fonts','finance-accounting'),
	    'type'     => 'select',
	    'choices'  => $finance_accounting_font_array,
	));

	//This is H2 FontSize setting
	$wp_customize->add_setting('finance_accounting_h2_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_h2_font_size',array(
		'label'	=> __('h2 Font Size','finance-accounting'),
		'section'	=> 'finance_accounting_typography',
		'setting'	=> 'finance_accounting_h2_font_size',
		'type'	=> 'text'
	));

	// This is H3 Color picker setting
	$wp_customize->add_setting( 'finance_accounting_h3_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'finance_accounting_h3_color', array(
		'label' => __('h3 Color', 'finance-accounting'),
		'section' => 'finance_accounting_typography',
		'settings' => 'finance_accounting_h3_color',
	)));

	//This is H3 FontFamily picker setting
	$wp_customize->add_setting('finance_accounting_h3_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control(
	    'finance_accounting_h3_font_family', array(
	    'section'  => 'finance_accounting_typography',
	    'label'    => __( 'h3 Fonts','finance-accounting'),
	    'type'     => 'select',
	    'choices'  => $finance_accounting_font_array,
	));

	//This is H3 FontSize setting
	$wp_customize->add_setting('finance_accounting_h3_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_h3_font_size',array(
		'label'	=> __('h3 Font Size','finance-accounting'),
		'section'	=> 'finance_accounting_typography',
		'setting'	=> 'finance_accounting_h3_font_size',
		'type'	=> 'text'
	));

	// This is H4 Color picker setting
	$wp_customize->add_setting( 'finance_accounting_h4_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'finance_accounting_h4_color', array(
		'label' => __('h4 Color', 'finance-accounting'),
		'section' => 'finance_accounting_typography',
		'settings' => 'finance_accounting_h4_color',
	)));

	//This is H4 FontFamily picker setting
	$wp_customize->add_setting('finance_accounting_h4_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control(
	    'finance_accounting_h4_font_family', array(
	    'section'  => 'finance_accounting_typography',
	    'label'    => __( 'h4 Fonts','finance-accounting'),
	    'type'     => 'select',
	    'choices'  => $finance_accounting_font_array,
	));

	//This is H4 FontSize setting
	$wp_customize->add_setting('finance_accounting_h4_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_h4_font_size',array(
		'label'	=> __('h4 Font Size','finance-accounting'),
		'section'	=> 'finance_accounting_typography',
		'setting'	=> 'finance_accounting_h4_font_size',
		'type'	=> 'text'
	));

	// This is H5 Color picker setting
	$wp_customize->add_setting( 'finance_accounting_h5_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'finance_accounting_h5_color', array(
		'label' => __('h5 Color', 'finance-accounting'),
		'section' => 'finance_accounting_typography',
		'settings' => 'finance_accounting_h5_color',
	)));

	//This is H5 FontFamily picker setting
	$wp_customize->add_setting('finance_accounting_h5_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control(
	    'finance_accounting_h5_font_family', array(
	    'section'  => 'finance_accounting_typography',
	    'label'    => __( 'h5 Fonts','finance-accounting'),
	    'type'     => 'select',
	    'choices'  => $finance_accounting_font_array,
	));

	//This is H5 FontSize setting
	$wp_customize->add_setting('finance_accounting_h5_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_h5_font_size',array(
		'label'	=> __('h5 Font Size','finance-accounting'),
		'section'	=> 'finance_accounting_typography',
		'setting'	=> 'finance_accounting_h5_font_size',
		'type'	=> 'text'
	));

	// This is H6 Color picker setting
	$wp_customize->add_setting( 'finance_accounting_h6_color', array(
		'default' => '',
		'sanitize_callback'	=> 'sanitize_hex_color'
	));
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'finance_accounting_h6_color', array(
		'label' => __('h6 Color', 'finance-accounting'),
		'section' => 'finance_accounting_typography',
		'settings' => 'finance_accounting_h6_color',
	)));

	//This is H6 FontFamily picker setting
	$wp_customize->add_setting('finance_accounting_h6_font_family',array(
	  'default' => '',
	  'capability' => 'edit_theme_options',
	  'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control(
	    'finance_accounting_h6_font_family', array(
	    'section'  => 'finance_accounting_typography',
	    'label'    => __( 'h6 Fonts','finance-accounting'),
	    'type'     => 'select',
	    'choices'  => $finance_accounting_font_array,
	));

	//This is H6 FontSize setting
	$wp_customize->add_setting('finance_accounting_h6_font_size',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_h6_font_size',array(
		'label'	=> __('h6 Font Size','finance-accounting'),
		'section'	=> 'finance_accounting_typography',
		'setting'	=> 'finance_accounting_h6_font_size',
		'type'	=> 'text'
	));

	// background skin mode
	$wp_customize->add_setting('finance_accounting_background_image_type',array(
        'default' => 'Transparent',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_background_image_type',array(
        'type' => 'radio',
        'label' => __('Background Skin Mode','finance-accounting'),
        'section' => 'background_image',
        'choices' => array(
            'Transparent' => __('Transparent','finance-accounting'),
            'Background' => __('Background','finance-accounting'),
        ),
	) );

	// Add the Theme Color Option typography section.
	$wp_customize->add_section( 'finance_accounting_theme_color_option', array(
		'panel' => 'finance_accounting_panel_id',
		'title' => esc_html__( 'Theme Color Option', 'finance-accounting' )
	));

	$wp_customize->add_setting('finance_accounting_typography_theme_color_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_typography_theme_color_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_theme_color_option'
	));

  	$wp_customize->add_setting( 'finance_accounting_first_theme_color', array(
	    'default' => '#53507b',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'finance_accounting_first_theme_color', array(
  		'label' => __( 'First Color Option', 'finance-accounting' ),
	    'description' => __('One can change complete theme color on just one click.', 'finance-accounting'),
	    'section' => 'finance_accounting_theme_color_option',
	    'settings' => 'finance_accounting_first_theme_color',
  	)));

  	$wp_customize->add_setting( 'finance_accounting_second_color', array(
	    'default' => '#4685e7',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'finance_accounting_second_color', array(
  		'label' => __( 'Second Color Option', 'finance-accounting' ),
	    'description' => __('One can change complete theme color on just one click.', 'finance-accounting'),
	    'section' => 'finance_accounting_theme_color_option',
	    'settings' => 'finance_accounting_second_color',
  	)));

  	// woocommerce Options
	$wp_customize->add_section( 'finance_accounting_shop_page_options', array(
    	'title'      => __( 'Shop Page Settings', 'finance-accounting' ),
		'panel' => 'woocommerce'
	) );

	$wp_customize->add_setting('finance_accounting_display_related_products',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_display_related_products',array(
       'type' => 'checkbox',
       'label' => __('Related Product','finance-accounting'),
       'section' => 'finance_accounting_shop_page_options',
    ));

    $wp_customize->add_setting('finance_accounting_shop_products_border',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_shop_products_border',array(
       'type' => 'checkbox',
       'label' => __('Product Border','finance-accounting'),
       'section' => 'finance_accounting_shop_page_options',
    ));

    $wp_customize->add_setting('finance_accounting_shop_page_sidebar',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_shop_page_sidebar',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Shop Page Sidebar','finance-accounting'),
       'section' => 'finance_accounting_shop_page_options',
    ));

    $wp_customize->add_setting('finance_accounting_single_product_sidebar',array(
        'default' => true,
        'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	));
	$wp_customize->add_control('finance_accounting_single_product_sidebar',array(
     	'type' => 'checkbox',
      	'label' => __('Enable / Disable Single Product Sidebar','finance-accounting'),
      	'section' => 'finance_accounting_shop_page_options',
	));

	// shop page sidebar alignment
	$wp_customize->add_setting('finance_accounting_shop_page_layout', array(
		'default'           => 'Right Sidebar',
		'sanitize_callback' => 'finance_accounting_sanitize_choices',
	));
	$wp_customize->add_control('finance_accounting_shop_page_layout',array(
		'type'           => 'radio',
		'label'          => __('Shop Page Layout', 'finance-accounting'),
		'section'        => 'finance_accounting_shop_page_options',
		'choices'        => array(
			'Left Sidebar'  => __('Left Sidebar', 'finance-accounting'),
			'Right Sidebar' => __('Right Sidebar', 'finance-accounting'),
		),
	));

	$wp_customize->add_setting( 'finance_accounting_woocommerce_product_per_columns' , array(
		'default'           => 3,
		'transport'         => 'refresh',
		'sanitize_callback' => 'finance_accounting_sanitize_choices',
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'finance_accounting_woocommerce_product_per_columns', array(
		'label'    => __( 'Total Products Per Columns', 'finance-accounting' ),
		'section'  => 'finance_accounting_shop_page_options',
		'type'     => 'radio',
		'choices'  => array(
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
		),
	) ) );

	$wp_customize->add_setting('finance_accounting_woocommerce_product_per_page',array(
		'default'	=> 9,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_woocommerce_product_per_page',array(
		'label'	=> __('Total Products Per Page','finance-accounting'),
		'section'	=> 'finance_accounting_shop_page_options',
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'finance_accounting_shop_page_top_padding',array(
		'default' => 10,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control( 'finance_accounting_shop_page_top_padding',	array(
		'label' => esc_html__( 'Product Padding (Top Bottom)','finance-accounting' ),
		'section' => 'finance_accounting_shop_page_options',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'finance_accounting_shop_page_left_padding',array(
		'default' => 10,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control( 'finance_accounting_shop_page_left_padding',	array(
		'label' => esc_html__( 'Product Padding (Right Left)','finance-accounting' ),
		'section' => 'finance_accounting_shop_page_options',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'finance_accounting_shop_page_border_radius',array(
		'default' => 0,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_shop_page_border_radius',array(
		'label' => esc_html__( 'Product Border Radius','finance-accounting' ),
		'section' => 'finance_accounting_shop_page_options',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'finance_accounting_shop_page_box_shadow',array(
		'default' => 0,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_shop_page_box_shadow',array(
		'label' => esc_html__( 'Product Shadow','finance-accounting' ),
		'section' => 'finance_accounting_shop_page_options',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number'
	));

	$wp_customize->add_setting( 'finance_accounting_shop_button_padding_top',array(
		'default' => 9,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_shop_button_padding_top',	array(
		'label' => esc_html__( 'Button Padding (Top Bottom)','finance-accounting' ),
		'section' => 'finance_accounting_shop_page_options',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type'		=> 'number',

	));

	$wp_customize->add_setting( 'finance_accounting_shop_button_padding_left',array(
		'default' => 16,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_shop_button_padding_left',array(
		'label' => esc_html__( 'Button Padding (Right Left)','finance-accounting' ),
		'section' => 'finance_accounting_shop_page_options',
		'type'		=> 'number',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting( 'finance_accounting_shop_button_border_radius',array(
		'default' => 0,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_shop_button_border_radius',array(
		'label' => esc_html__( 'Button Border Radius','finance-accounting' ),
		'section' => 'finance_accounting_shop_page_options',
		'type'		=> 'number',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting('finance_accounting_position_product_sale',array(
        'default' => 'Right',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_position_product_sale',array(
        'type' => 'radio',
        'label' => __('Product Sale Position','finance-accounting'),
        'section' => 'finance_accounting_shop_page_options',
        'choices' => array(
            'Right' => __('Right','finance-accounting'),
            'Left' => __('Left','finance-accounting'),
        ),
	) );

	$wp_customize->add_setting( 'finance_accounting_border_radius_product_sale_text',array(
		'default' => 50,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_border_radius_product_sale_text', array(
        'label'  => __('Product Sale Border Radius','finance-accounting'),
        'section'  => 'finance_accounting_shop_page_options',
        'type'        => 'number',
        'input_attrs' => array(
        	'step'=> 1,
            'min' => 0,
            'max' => 50,
        )
    ) );

    $wp_customize->add_setting('finance_accounting_top_bottom_product_sale_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_top_bottom_product_sale_padding',array(
		'label'	=> __('Top / Bottom Product Sale Padding ','finance-accounting'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'finance_accounting_shop_page_options',
		'type'=> 'number'
	));

	$wp_customize->add_setting('finance_accounting_left_right_product_sale_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_left_right_product_sale_padding',array(
		'label'	=> __('Left / Right Product Sale Padding','finance-accounting'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'finance_accounting_shop_page_options',
		'type'=> 'number'
	));

	$wp_customize->add_setting('finance_accounting_product_sale_text_size',array(
		'default'=> 14,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float'
	));
	$wp_customize->add_control('finance_accounting_product_sale_text_size',array(
		'label'	=> __('Product Sale Text Size','finance-accounting'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'finance_accounting_shop_page_options',
		'type'=> 'number'
	));

	$wp_customize->add_setting('finance_accounting_shop_products_navigation',array(
       'default' => 'Yes',
       'sanitize_callback'	=> 'finance_accounting_sanitize_choices'
    ));
    $wp_customize->add_control('finance_accounting_shop_products_navigation',array(
       'type' => 'radio',
       'label' => __('Woocommerce Products Navigation','finance-accounting'),
       'choices' => array(
            'Yes' => __('Yes','finance-accounting'),
            'No' => __('No','finance-accounting'),
        ),
       'section' => 'finance_accounting_shop_page_options',
    ));

	//Layout Settings
	$wp_customize->add_section( 'finance_accounting_width_layout', array(
    	'title'      => __( 'Layout Settings', 'finance-accounting' ),
		'panel' => 'finance_accounting_panel_id'
	) );

	$wp_customize->add_setting('finance_accounting_typography_layout_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_typography_layout_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_width_layout'
	));

	$wp_customize->add_setting( 'finance_accounting_single_page_breadcrumb',array(
		'default' => true,
		'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	  ) );
	  $wp_customize->add_control('finance_accounting_single_page_breadcrumb',array(
	  	'type' => 'checkbox',
	    'label' => __( 'Show / Hide Single Page Breadcrumb','finance-accounting'),
	    'section' => 'finance_accounting_width_layout'
	  ));

	//Sticky Header
	$wp_customize->add_setting( 'finance_accounting_fixed_header',array(
		'default' => false,
      	'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ) );
    $wp_customize->add_control('finance_accounting_fixed_header',array(
    	'type' => 'checkbox',
        'label' => __( 'Enable / Disable Fixed Header','finance-accounting' ),
        'section' => 'finance_accounting_width_layout'
    ));

    $wp_customize->add_setting( 'finance_accounting_fixed_header_padding_option', array(
		'default'=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	) );
	$wp_customize->add_control( 'finance_accounting_fixed_header_padding_option', array(
		'label'       => esc_html__( 'Fixed Header Padding','finance-accounting' ),
		'section'     => 'finance_accounting_width_layout',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('finance_accounting_loader_setting',array(
       'default' => false,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_loader_setting',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Preloader','finance-accounting'),
       'section' => 'finance_accounting_width_layout'
    ));

    $wp_customize->add_setting('finance_accounting_preloader_types',array(
        'default' => 'Default',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_preloader_types',array(
        'type' => 'radio',
        'label' => __('Preloader Option','finance-accounting'),
        'section' => 'finance_accounting_width_layout',
        'choices' => array(
            'Default' => __('Default','finance-accounting'),
            'Circle' => __('Circle','finance-accounting'),
            'Two Circle' => __('Two Circle','finance-accounting')
        ),
	) );

    $wp_customize->add_setting( 'finance_accounting_loader_color_setting', array(
	    'default' => '#fff',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'finance_accounting_loader_color_setting', array(
  		'label' => __('Preloader Color Option', 'finance-accounting'),
	    'section' => 'finance_accounting_width_layout',
	    'settings' => 'finance_accounting_loader_color_setting',
  	)));

  	$wp_customize->add_setting( 'finance_accounting_loader_background_color', array(
	    'default' => '#000',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'finance_accounting_loader_background_color', array(
  		'label' => __('Preloader Background Color Option', 'finance-accounting'),
	    'section' => 'finance_accounting_width_layout',
	    'settings' => 'finance_accounting_loader_background_color',
  	)));

	$wp_customize->add_setting('finance_accounting_theme_options',array(
    'default' => 'Default',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_theme_options',array(
        'type' => 'select',
        'label' => __('Container Box','finance-accounting'),
        'description' => __('Here you can change the Width layout. ','finance-accounting'),
        'section' => 'finance_accounting_width_layout',
        'choices' => array(
            'Default' => __('Default','finance-accounting'),
            'Wide Layout' => __('Wide Layout','finance-accounting'),
            'Box Layout' => __('Box Layout','finance-accounting'),
        ),
	) );

	// Button Settings
	$wp_customize->add_section( 'finance_accounting_button_option', array(
		'title' => __( 'Button', 'finance-accounting' ),
		'panel' => 'finance_accounting_panel_id',
	));

	$wp_customize->add_setting('finance_accounting_typography_button_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_typography_button_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_button_option'
	));

	$wp_customize->add_setting('finance_accounting_button_text',array(
		'default'=> __('Continue Reading....','finance-accounting'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_button_text',array(
		'label'	=> __('Add Button Text','finance-accounting'),
		'section'=> 'finance_accounting_button_option',
		'type'=> 'text'
	));

	//Show /Hide border
	$wp_customize->add_setting( 'finance_accounting_button_border',array(
		'default' => false,
      	'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ) );
    $wp_customize->add_control('finance_accounting_button_border',array(
    	'type' => 'checkbox',
        'label' => __( 'Show / Hide Border for Blog page','finance-accounting' ),
        'section' => 'finance_accounting_button_option'
    ));

	$wp_customize->add_setting('finance_accounting_btn_font_size_option',array(
		'default'=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_btn_font_size_option',array(
		'label'	=> __('Button Font Size','finance-accounting'),
		'input_attrs' => array(
         'step'             => 1,
			'min'              => 0,
			'max'              => 50,
     	),
		'section'=> 'finance_accounting_button_option',
		'type'=> 'number'
	));


	$wp_customize->add_setting('finance_accounting_top_bottom_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_top_bottom_padding',array(
		'label'	=> __('Top and Bottom Padding ','finance-accounting'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'finance_accounting_button_option',
		'type'=> 'number'
	));

	$wp_customize->add_setting('finance_accounting_left_right_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_left_right_padding',array(
		'label'	=> __('Left and Right Padding','finance-accounting'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'finance_accounting_button_option',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'finance_accounting_border_radius', array(
		'default'=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	) );
	$wp_customize->add_control( 'finance_accounting_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','finance-accounting' ),
		'section'     => 'finance_accounting_button_option',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('finance_accounting_button_text_transform',array(
		'default' => 'Uppercase',
		'sanitize_callback' => 'finance_accounting_sanitize_choices'
 	));
 	$wp_customize->add_control('finance_accounting_button_text_transform',array(
		'type' => 'radio',
		'label' => __('Button Text Transform','finance-accounting'),
		'section' => 'finance_accounting_button_option',
		'choices' => array(
		   'Uppercase' => __('Uppercase','finance-accounting'),
		   'Lowercase' => __('Lowercase','finance-accounting'),
		   'Capitalize' => __('Capitalize','finance-accounting'),
		),
	));

	$wp_customize->add_setting('finance_accounting_btn_font_weight',array(
		'default'=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_choices',
	));
	$wp_customize->add_control('finance_accounting_btn_font_weight',array(
		'label'	=> __('Button Font Weight','finance-accounting'),
		'section'=> 'finance_accounting_button_option',
		'type' => 'select',
		'choices' => array(
            '100' => __('100','finance-accounting'),
            '200' => __('200','finance-accounting'),
            '300' => __('300','finance-accounting'),
            '400' => __('400','finance-accounting'),
            '500' => __('500','finance-accounting'),
            '600' => __('600','finance-accounting'),
            '700' => __('700','finance-accounting'),
            '800' => __('800','finance-accounting'),
            '900' => __('900','finance-accounting'),
        ),
	));

	$wp_customize->add_setting('finance_accounting_button_hover_effect',array(
        'default' => '',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
    ));
	$wp_customize->add_control('finance_accounting_button_hover_effect', array(
        'type' => 'select',
        'label' => __( 'Button Hover Effect', 'finance-accounting' ),
        'section' => 'finance_accounting_button_option',
        'choices' => array(
			'pulse'     => __( 'Pulse', 'finance-accounting' ),
			'rubberBand'=> __( 'RubberBand', 'finance-accounting' ),
			'swing'     => __( 'Swing', 'finance-accounting' ),
			'tada'      => __( 'Tada', 'finance-accounting' ),
			'jello'     => __( 'Jello', 'finance-accounting' ),
			'disable'   => __( 'Disabled', 'finance-accounting' )
        ),
    ));

	$wp_customize->add_section( 'finance_accounting_general_option', array(
    	'title'      => __( 'Sidebar Settings', 'finance-accounting' ),
		'panel' => 'finance_accounting_panel_id'
	) );

	$wp_customize->add_setting('finance_accounting_typography_sidebar_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_typography_sidebar_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_general_option'
	));

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('finance_accounting_layout_settings',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_layout_settings',array(
        'type' => 'radio',
        'label' => __('Post Sidebar Layout','finance-accounting'),
        'description' => __('This option work for blog page, blog single page, archive page and search page.','finance-accounting'),
        'section' => 'finance_accounting_general_option',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','finance-accounting'),
            'Right Sidebar' => __('Right Sidebar','finance-accounting'),
            'One Column' => __('One Column','finance-accounting'),
            'Three Columns' => __('Three Columns','finance-accounting'),
            'Four Columns' => __('Four Columns','finance-accounting'),
            'Grid Layout' => __('Grid Layout','finance-accounting')
        ),
	) );

	$wp_customize->add_setting('finance_accounting_page_sidebar_option',array(
        'default' => 'One Column',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_page_sidebar_option',array(
        'type' => 'radio',
        'label' => __('Page Sidebar Layout','finance-accounting'),
        'section' => 'finance_accounting_general_option',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','finance-accounting'),
            'Right Sidebar' => __('Right Sidebar','finance-accounting'),
            'One Column' => __('One Column','finance-accounting')
        ),
	) );

	$wp_customize->add_setting('finance_accounting_single_post_sidebar_option',array(
		'default' => 'Right Sidebar',
		'sanitize_callback' => 'finance_accounting_sanitize_choices'
   ));
   $wp_customize->add_control('finance_accounting_single_post_sidebar_option',array(
		'type' => 'radio',
		'label' => __('Single Post Sidebar Layout','finance-accounting'),
		'section' => 'finance_accounting_general_option',
		'choices' => array(
			'Left Sidebar' => __('Left Sidebar','finance-accounting'),
			'Right Sidebar' => __('Right Sidebar','finance-accounting'),
			'One Column' => __('Full Column','finance-accounting')
		),
   ) );

	//Topbar section
	$wp_customize->add_section('finance_accounting_topbar',array(
		'title'	=> __('Topbar','finance-accounting'),
		'label' => __('Contact Details', 'finance-accounting'),
		'description' => __('Here you can add email address, phone number and timings.','finance-accounting'),
		'priority'	=> null,
		'panel' => 'finance_accounting_panel_id',
	));


	$wp_customize->add_setting('finance_accounting_typography_topbar_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_typography_topbar_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_topbar'
	));

	$wp_customize->add_setting('finance_accounting_time',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_time',array(
		'label'	=> __('Timing','finance-accounting'),
		'section'	=> 'finance_accounting_topbar',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('finance_accounting_time1',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_time1',array(
		'label'	=> __('Add Time','finance-accounting'),
		'section'	=> 'finance_accounting_topbar',
		'setting'	=> 'finance_accounting_time',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('finance_accounting_time_icon_changer',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
        $wp_customize,'finance_accounting_time_icon_changer',array(
		'label'	=> __('Time Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_topbar',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('finance_accounting_mail',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_mail',array(
		'label'	=> __('Email Text','finance-accounting'),
		'section'	=> 'finance_accounting_topbar',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('finance_accounting_email',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_email'
	));
	$wp_customize->add_control('finance_accounting_email',array(
		'label'	=> __('Add Email','finance-accounting'),
		'section'	=> 'finance_accounting_topbar',
		'setting'	=> 'finance_accounting_email',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('finance_accounting_email_icon_changer',array(
		'default'	=> 'fas fa-envelope',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
        $wp_customize,'finance_accounting_email_icon_changer',array(
		'label'	=> __('Email Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_topbar',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('finance_accounting_call',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_call',array(
		'label'	=> __('Phone Text','finance-accounting'),
		'section'	=> 'finance_accounting_topbar',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('finance_accounting_call1',array(
		'default'	=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_phone_number'
	));
	$wp_customize->add_control('finance_accounting_call1',array(
		'label'	=> __('Add Phone Number','finance-accounting'),
		'section'	=> 'finance_accounting_topbar',
		'setting'	=> 'finance_accounting_call',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('finance_accounting_phone_icon_changer',array(
		'default'	=> 'fas fa-mobile-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
        $wp_customize,'finance_accounting_phone_icon_changer',array(
		'label'	=> __('Phone Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_topbar',
		'type'		=> 'icon'
	)));

	//Social Icons
	$wp_customize->add_section('finance_accounting_social_link',array(
		'title'	=> __('Social Media','finance-accounting'),
		'label'	=> __('Social Links','finance-accounting'),
		'description'	=> __('Add Social Media Url here','finance-accounting'),
		'priority'	=> null,
		'panel' => 'finance_accounting_panel_id',
	));

	$wp_customize->add_setting('finance_accounting_typography_social_icons_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_typography_social_icons_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_social_link'
	));

	$wp_customize->add_setting('finance_accounting_facebook_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('finance_accounting_facebook_url',array(
		'label'	=> __('Add Facebook link','finance-accounting'),
		'section'	=> 'finance_accounting_social_link',
		'setting'	=> 'finance_accounting_facebook_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('finance_accounting_facebook_icon_changer',array(
		'default'	=> 'fab fa-facebook-f',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
        $wp_customize,'finance_accounting_facebook_icon_changer',array(
		'label'	=> __('Facebook Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_social_link',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('finance_accounting_vk_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('finance_accounting_vk_url',array(
		'label'	=> __('Add vk link','finance-accounting'),
		'section'	=> 'finance_accounting_social_link',
		'setting'	=> 'finance_accounting_vk_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('finance_accounting_vk_icon_changer',array(
		'default'	=> 'fab fa-vk',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
        $wp_customize,'finance_accounting_vk_icon_changer',array(
		'label'	=> __('vk Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_social_link',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('finance_accounting_youtube_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('finance_accounting_youtube_url',array(
		'label'	=> __('Add Youtube link','finance-accounting'),
		'section'	=> 'finance_accounting_social_link',
		'setting'	=> 'finance_accounting_youtube_url',
		'type'		=> 'url'
	));

	$wp_customize->add_setting('finance_accounting_youtube_icon_changer',array(
		'default'	=> 'fab fa-youtube',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
        $wp_customize,'finance_accounting_youtube_icon_changer',array(
		'label'	=> __('Youtube Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_social_link',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('finance_accounting_linkdin_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	) );
	$wp_customize->add_control('finance_accounting_linkdin_url',array(
		'label'	=> __('Add Linkdin link','finance-accounting'),
		'section'	=> 'finance_accounting_social_link',
		'setting'	=> 'finance_accounting_linkdin_url',
		'type'	=> 'url'
	) );

	$wp_customize->add_setting('finance_accounting_linkedin_icon_changer',array(
		'default'	=> 'fab fa-linkedin-in',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
        $wp_customize,'finance_accounting_linkedin_icon_changer',array(
		'label'	=> __('Linkdin Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_social_link',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('finance_accounting_twitter_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	) );
	$wp_customize->add_control('finance_accounting_twitter_url',array(
		'label'	=> __('Add Twitter link','finance-accounting'),
		'section'	=> 'finance_accounting_social_link',
		'setting'	=> 'finance_accounting_twitter_url',
		'type'	=> 'url'
	) );

	$wp_customize->add_setting('finance_accounting_twitter_icon_changer',array(
		'default'	=> 'fab fa-twitter',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
        $wp_customize,'finance_accounting_twitter_icon_changer',array(
		'label'	=> __('Twitter Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_social_link',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('finance_accounting_instagram_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	) );
	$wp_customize->add_control('finance_accounting_instagram_url',array(
		'label'	=> __('Add Instagram link','finance-accounting'),
		'section'	=> 'finance_accounting_social_link',
		'setting'	=> 'finance_accounting_instagram_url',
		'type'	=> 'url'
	) );

	$wp_customize->add_setting('finance_accounting_instagram_icon_changer',array(
		'default'	=> 'fab fa-instagram',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
        $wp_customize,'finance_accounting_instagram_icon_changer',array(
		'label'	=> __('Instagram Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_social_link',
		'type'		=> 'icon'
	)));

	// navigation menu
	$wp_customize->add_section( 'finance_accounting_navigation_menu' , array(
    	'title'      => __( 'Navigation Menus Settings', 'finance-accounting' ),
		'priority'   => null,
		'panel' => 'finance_accounting_panel_id'
	) );


	$wp_customize->add_setting('finance_accounting_typography_navigation_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_typography_navigation_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_navigation_menu'
	));

	$wp_customize->add_setting('finance_accounting_menu_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'finance_accounting_menu_color', array(
		'label'    => __('Menu Color', 'finance-accounting'),
		'section'  => 'finance_accounting_navigation_menu',
		'settings' => 'finance_accounting_menu_color',
	)));

	$wp_customize->add_setting('finance_accounting_sub_menu_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'finance_accounting_sub_menu_color', array(
		'label'    => __('Submenu Color', 'finance-accounting'),
		'section'  => 'finance_accounting_navigation_menu',
		'settings' => 'finance_accounting_sub_menu_color',
	)));

	$wp_customize->add_setting('finance_accounting_menu_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'finance_accounting_menu_hover_color', array(
		'label'    => __('Menu Hover Color', 'finance-accounting'),
		'section'  => 'finance_accounting_navigation_menu',
		'settings' => 'finance_accounting_menu_hover_color',
	)));

	$wp_customize->add_setting('finance_accounting_sub_menu_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'finance_accounting_sub_menu_hover_color', array(
		'label'    => __('Submenu Hover Color', 'finance-accounting'),
		'section'  => 'finance_accounting_navigation_menu',
		'settings' => 'finance_accounting_sub_menu_hover_color',
	)));

	$wp_customize->add_setting('finance_accounting_navigation_menu_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_navigation_menu_font_size',array(
		'label'	=> __('Navigation Menus Font Size ','finance-accounting'),
		'section'=> 'finance_accounting_navigation_menu',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'type'=> 'number'
	));

	$wp_customize->add_setting('finance_accounting_menu_text_tranform',array(
        'default' => 'Default',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
    ));
    $wp_customize->add_control('finance_accounting_menu_text_tranform',array(
        'type' => 'radio',
        'label' => __('Navigation Menus Text Transform','finance-accounting'),
        'section' => 'finance_accounting_navigation_menu',
        'choices' => array(
            'Default' => __('Default','finance-accounting'),
            'Uppercase' => __('Uppercase','finance-accounting'),
            'Lowercase' => __('Lowercase','finance-accounting'),
        ),
	) );

	$wp_customize->add_setting('finance_accounting_menu_font_weight',array(
		'default' => '',
		'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_menu_font_weight',array(
		'type' => 'select',
		'label' => __('Navigation Menus Font Weight','finance-accounting'),
		'section' => 'finance_accounting_navigation_menu',
		'choices' => array(
		   '100' => __('100','finance-accounting'),
		   '200' => __('200','finance-accounting'),
		   '300' => __('300','finance-accounting'),
		   '400' => __('400','finance-accounting'),
		   '500' => __('500','finance-accounting'),
		   '600' => __('600','finance-accounting'),
		   '700' => __('700','finance-accounting'),
		   '800' => __('800','finance-accounting'),
		   '900' => __('900','finance-accounting'),
		),
	) );


	$wp_customize->add_setting('finance_accounting_menus_item_style',array(
        'default' => 'None',
        'transport' => 'refresh',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_menus_item_style',array(
        'type' => 'select',
		'label' => __('Menu Item Hover Style','finance-accounting'),
		'section' => 'finance_accounting_navigation_menu',
		'choices' => array(
            'None' => __('None','finance-accounting'),
            'Zoom In' => __('Zoom In','finance-accounting'),
        ),
	) );		

	//home page slider
	$wp_customize->add_section( 'finance_accounting_slider' , array(
    	'title'      => __( 'Slider Settings', 'finance-accounting' ),
    	'description'	=> __('Here you can select pages which you have created for slider.','finance-accounting'),
		'priority'   => null,
		'panel' => 'finance_accounting_panel_id'
	) );

	$wp_customize->add_setting('finance_accounting_slider_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_slider_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Include customizable typography settings with a selection of premium fonts.','finance-accounting') ."</li><li>". esc_html__('And so on...','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_slider'
	));

	$wp_customize->add_setting('finance_accounting_slider_hide',array(
       'default' => false,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_slider_hide',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide slider','finance-accounting'),
       'section' => 'finance_accounting_slider',
    ));

    $wp_customize->add_setting('finance_accounting_slider_title',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_slider_title',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Slider Title','finance-accounting'),
       'section' => 'finance_accounting_slider'
    ));

    $wp_customize->add_setting('finance_accounting_slider_content',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_slider_content',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Slider Content','finance-accounting'),
       'section' => 'finance_accounting_slider'
    ));

    $wp_customize->add_setting('finance_accounting_slider_button',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_slider_button',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Slider Button','finance-accounting'),
       'section' => 'finance_accounting_slider'
    ));

	for ( $count = 1; $count <= 4; $count++ ) {

		// Add color scheme setting and control.
		$wp_customize->add_setting( 'finance_accounting_slide_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'finance_accounting_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'finance_accounting_slide_page' . $count, array(
			'label'    => __( 'Select Slide Image Page', 'finance-accounting' ),
			'section'  => 'finance_accounting_slider',
			'type'     => 'dropdown-pages'
		) );

	}

	$wp_customize->add_setting( 'finance_accounting_slider_speed',array(
		'default' => 3000,
		'sanitize_callback'    => 'finance_accounting_sanitize_number_range',
	));
	$wp_customize->add_control( 'finance_accounting_slider_speed',array(
		'label' => esc_html__( 'Slider Speed','finance-accounting' ),
		'section' => 'finance_accounting_slider',
		'type'        => 'range',
		'input_attrs' => array(
			'min' => 1000,
			'max' => 5000,
			'step' => 500,
		),
	));

	$wp_customize->add_setting('finance_accounting_slider_height_option',array(
		'default'=> 600,
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_slider_height_option',array(
		'label'	=> __('Slider Height Option','finance-accounting'),
		'section'=> 'finance_accounting_slider',
		'type'=> 'number'
	));

	//content layout
    $wp_customize->add_setting('finance_accounting_slider_content_option',array(
    	'default' => 'Left',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_slider_content_option',array(
        'type' => 'select',
        'label' => __('Slider Content Layout','finance-accounting'),
        'section' => 'finance_accounting_slider',
        'choices' => array(
            'Center' => __('Center','finance-accounting'),
            'Left' => __('Left','finance-accounting'),
            'Right' => __('Right','finance-accounting'),
        ),
	) );

	$wp_customize->add_setting('finance_accounting_slider_button_text',array(
		'default'=> __('READ MORE','finance-accounting'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_slider_button_text',array(
		'label'	=> __('Slider Button Text','finance-accounting'),
		'section'=> 'finance_accounting_slider',
		'type'=> 'text'
	));

	$wp_customize->add_setting('finance_accounting_slider_button_text_url',array(
		'default'=> __('','finance-accounting'),
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control('finance_accounting_slider_button_text_url',array(
		'label'	=> __('Slider Button Url','finance-accounting'),
		'section'=> 'finance_accounting_slider',
		'type'=> 'url'
	));

    //Slider excerpt
	$wp_customize->add_setting( 'finance_accounting_slider_excerpt_number', array(
		'default'              => 20,
		'sanitize_callback'    => 'finance_accounting_sanitize_number_range',
	) );
	$wp_customize->add_control( 'finance_accounting_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Excerpt length','finance-accounting' ),
		'section'     => 'finance_accounting_slider',
		'type'        => 'range',
		'settings'    => 'finance_accounting_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Opacity
	$wp_customize->add_setting('finance_accounting_slider_opacity_color',array(
      'default'              => 0.7,
      'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control( 'finance_accounting_slider_opacity_color', array(
	'label'       => esc_html__( 'Slider Image Opacity','finance-accounting' ),
	'section'     => 'finance_accounting_slider',
	'type'        => 'select',
	'settings'    => 'finance_accounting_slider_opacity_color',
	'choices' => array(
		'0' =>  esc_attr__('0','finance-accounting'),
		'0.1' =>  esc_attr__('0.1','finance-accounting'),
		'0.2' =>  esc_attr__('0.2','finance-accounting'),
		'0.3' =>  esc_attr__('0.3','finance-accounting'),
		'0.4' =>  esc_attr__('0.4','finance-accounting'),
		'0.5' =>  esc_attr__('0.5','finance-accounting'),
		'0.6' =>  esc_attr__('0.6','finance-accounting'),
		'0.7' =>  esc_attr__('0.7','finance-accounting'),
		'0.8' =>  esc_attr__('0.8','finance-accounting'),
		'0.9' =>  esc_attr__('0.9','finance-accounting')
	),
	));

	$wp_customize->add_setting('finance_accounting_padding_top_bottom_slider_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_padding_top_bottom_slider_content',array(
		'label'	=> __('Top Bottom Slider Content Padding','finance-accounting'),
		'section'=> 'finance_accounting_slider',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'type'=> 'number'
	));

	$wp_customize->add_setting('finance_accounting_padding_left_right_slider_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_padding_left_right_slider_content',array(
		'label'	=> __('Left Right Slider Content Padding','finance-accounting'),
		'section'=> 'finance_accounting_slider',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'type'=> 'number'
	));

	$wp_customize->add_setting('finance_accounting_show_slider_image_overlay',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_show_slider_image_overlay',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Image Overlay Slider','finance-accounting'),
       'section' => 'finance_accounting_slider'
    ));

    $wp_customize->add_setting('finance_accounting_color_slider_image_overlay', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'finance_accounting_color_slider_image_overlay', array(
		'label'    => __('Image Overlay Slider Color', 'finance-accounting'),
		'section'  => 'finance_accounting_slider',
		'settings' => 'finance_accounting_color_slider_image_overlay',
	)));

	//About
	$wp_customize->add_section('finance_accounting_services',array(
		'title'	=> __('Service','finance-accounting'),
		'label'     => __('Our Services Section', 'finance-accounting'),
    	'description'	=> __('','finance-accounting'),
		'panel' => 'finance_accounting_panel_id',
	));

	$wp_customize->add_setting('finance_accounting_about_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_about_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_services'
	));


	$wp_customize->add_setting('finance_accounting_section_title',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_section_title',array(
		'label'	=> __('Section title','finance-accounting'),
		'section'	=> 'finance_accounting_services',
		'setting'	=> 'finance_accounting_section_title',
		'type'		=> 'text'
	));

	$wp_customize->add_setting('finance_accounting_section_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_section_text',array(
		'label'	=> __('Add some text','finance-accounting'),
		'section'	=> 'finance_accounting_services',
		'setting'	=> 'finance_accounting_section_text',
		'type'		=> 'text'
	));

	//Category
	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_post[]= 'select';
	foreach($categories as $category){
	if($i==0){
	$default = $category->slug;
	$i++;
	}
	$cat_post[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('finance_accounting_blogcategory_setting',array(
		'default'	=> 'select',
		'sanitize_callback' => 'finance_accounting_sanitize_choices',
	));
	$wp_customize->add_control('finance_accounting_blogcategory_setting',array(
		'type'    => 'select',
		'choices' => $cat_post,
		'label' => __('Select Category to display Latest Post','finance-accounting'),
		'section' => 'finance_accounting_services',
	));

	//no Result Setting
	$wp_customize->add_section('finance_accounting_no_result_setting',array(
		'title'	=> __('No Results Settings','finance-accounting'),
		'panel' => 'finance_accounting_panel_id',
	));

	$wp_customize->add_setting('finance_accounting_no_result_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_no_result_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_no_result_setting'
	));


	$wp_customize->add_setting('finance_accounting_no_search_result_title',array(
		'default'=> __('Nothing Found','finance-accounting'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_no_search_result_title',array(
		'label'	=> __('No Search Results Title','finance-accounting'),
		'section'=> 'finance_accounting_no_result_setting',
		'type'=> 'text'
	));

	$wp_customize->add_setting('finance_accounting_no_search_result_content',array(
		'default'=> __('Sorry, but nothing matched your search terms. Please try again with some different keywords.','finance-accounting'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_no_search_result_content',array(
		'label'	=> __('No Search Results Content','finance-accounting'),
		'section'=> 'finance_accounting_no_result_setting',
		'type'=> 'text'
	));

	//404 Page Setting
	$wp_customize->add_section('finance_accounting_page_not_found_setting',array(
		'title'	=> __('Page Not Found Settings','finance-accounting'),
		'panel' => 'finance_accounting_panel_id',
	));

	$wp_customize->add_setting('finance_accounting_page_not_found_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_page_not_found_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_page_not_found_setting'
	));

	$wp_customize->add_setting('finance_accounting_page_not_found_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_page_not_found_title',array(
		'label'	=> __('Page Not Found Title','finance-accounting'),
		'section'=> 'finance_accounting_page_not_found_setting',
		'type'=> 'text'
	));

	$wp_customize->add_setting('finance_accounting_page_not_found_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_page_not_found_content',array(
		'label'	=> __('Page Not Found Content','finance-accounting'),
		'section'=> 'finance_accounting_page_not_found_setting',
		'type'=> 'text'
	));

	//Responsive Media Settings
	$wp_customize->add_section('finance_accounting_mobile_media',array(
		'title'	=> __('Mobile Media Settings','finance-accounting'),
		'panel' => 'finance_accounting_panel_id',
	));

	$wp_customize->add_setting('finance_accounting_mobile_media_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_mobile_media_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_mobile_media'
	));

	$wp_customize->add_setting('finance_accounting_enable_disable_sidebar',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_enable_disable_sidebar',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Sidebar','finance-accounting'),
       'section' => 'finance_accounting_mobile_media'
    ));

    $wp_customize->add_setting('finance_accounting_enable_disable_slider',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_enable_disable_slider',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Slider','finance-accounting'),
       'section' => 'finance_accounting_mobile_media'
    ));

    $wp_customize->add_setting('finance_accounting_show_hide_slider_button',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_show_hide_slider_button',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Slider Button','finance-accounting'),
       'section' => 'finance_accounting_mobile_media'
    ));

    $wp_customize->add_setting('finance_accounting_enable_disable_scrolltop',array(
       'default' => false,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_enable_disable_scrolltop',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Scroll To Top','finance-accounting'),
       'section' => 'finance_accounting_mobile_media'
    ));

	//Blog Post
	$wp_customize->add_section('finance_accounting_blog_post',array(
		'title'	=> __('Post Settings','finance-accounting'),
		'panel' => 'finance_accounting_panel_id',
	));

	$wp_customize->add_setting('finance_accounting_post_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_post_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_blog_post'
	));
	
	$wp_customize->add_setting('finance_accounting_caps_enable',
    	array(
        'default' => false,
        'sanitize_callback' => 'finance_accounting_sanitize_checkbox',
    ));
	$wp_customize->add_control( 'finance_accounting_caps_enable', 
		array(
			'label' => esc_html__('Initial Cap (First Big Letter)', 'finance-accounting'),
			'type' => 'checkbox',
			'section' => 'finance_accounting_blog_post',
		)
	);

	$wp_customize->add_setting('finance_accounting_date_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_date_hide',array(
       'type' => 'checkbox',
       'label' => __('Post Date','finance-accounting'),
       'section' => 'finance_accounting_blog_post'
    ));

    $wp_customize->add_setting('finance_accounting_post_date_icon_changer',array(
		'default'	=> 'fa fa-calendar',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
        $wp_customize,'finance_accounting_post_date_icon_changer',array(
		'label'	=> __('Post Date Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_blog_post',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('finance_accounting_comment_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_comment_hide',array(
       'type' => 'checkbox',
       'label' => __('Post Comments','finance-accounting'),
       'section' => 'finance_accounting_blog_post'
    ));

    $wp_customize->add_setting('finance_accounting_post_comment_icon_changer',array(
		'default'	=> 'fas fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
        $wp_customize,'finance_accounting_post_comment_icon_changer',array(
		'label'	=> __('Post Comments Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_blog_post',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('finance_accounting_author_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_author_hide',array(
       'type' => 'checkbox',
       'label' => __('Post Author','finance-accounting'),
       'section' => 'finance_accounting_blog_post'
    ));

    $wp_customize->add_setting('finance_accounting_post_author_icon_changer',array(
		'default'	=> 'fa fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
        $wp_customize,'finance_accounting_post_author_icon_changer',array(
		'label'	=> __('Post Author Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_blog_post',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('finance_accounting_post_time_show',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_post_time_show',array(
       'type' => 'checkbox',
       'label' => __('Post Time','finance-accounting'),
       'section' => 'finance_accounting_blog_post'
    ));

	$wp_customize->add_setting('finance_accounting_post_time_icon_changer',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Finance_Accounting_Icon_Changer(
        $wp_customize,'finance_accounting_post_time_icon_changer',array(
		'label'	=> __('Post Time Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_blog_post',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('finance_accounting_blog_post_featured_image',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_blog_post_featured_image',array(
       'type' => 'checkbox',
       'label' => __('Post Image','finance-accounting'),
       'section' => 'finance_accounting_blog_post'
    ));

    $wp_customize->add_setting( 'finance_accounting_blog_post_img_border_radius', array(
		'default'=> 0,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	) );
	$wp_customize->add_control( 'finance_accounting_blog_post_img_border_radius', array(
		'label'       => esc_html__( 'Post Image Border Radius','finance-accounting' ),
		'section'     => 'finance_accounting_blog_post',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 100,
		),
	) );

	$wp_customize->add_setting( 'finance_accounting_blog_post_img_box_shadow',array(
		'default' => 0,
		'sanitize_callback'    => 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_blog_post_img_box_shadow',array(
		'label' => esc_html__( 'Post Image Shadow','finance-accounting' ),
		'section' => 'finance_accounting_blog_post',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type' => 'number'
	));

    $wp_customize->add_setting( 'finance_accounting_blog_post_metabox_seperator', array(
		'default'   => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'finance_accounting_blog_post_metabox_seperator', array(
		'label'       => esc_html__( 'Blog Post Meta Box Seperator','finance-accounting' ),
		'section'     => 'finance_accounting_blog_post',
		'description' => __('Add the seperator for meta box. Example: ",",  "|", "/", etc. ','finance-accounting'),
		'type'        => 'text',
		'settings'    => 'finance_accounting_blog_post_metabox_seperator',
	) );

    $wp_customize->add_setting('finance_accounting_blog_post_layout',array(
        'default' => 'Default',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
    ));
    $wp_customize->add_control('finance_accounting_blog_post_layout',array(
        'type' => 'radio',
        'label' => __('Post Layout Option','finance-accounting'),
        'section' => 'finance_accounting_blog_post',
        'choices' => array(
            'Default' => __('Default','finance-accounting'),
            'Left' => __('Left','finance-accounting'),
            'Image and Content' => __('Image and Content','finance-accounting'),
			'Content and Image' => __('Content and Image','finance-accounting'),
        ),
	) );

	$wp_customize->add_setting('finance_accounting_post_break_block_setting',array(
        'default' => 'Into Blocks',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_post_break_block_setting',array(
        'type' => 'radio',
        'label' => __('Display Blog Page posts','finance-accounting'),
        'section' => 'finance_accounting_blog_post',
        'choices' => array(
            'Into Blocks' => __('Into Blocks','finance-accounting'),
            'Without Blocks' => __('Without Blocks','finance-accounting'),
        ),
	) );

	$wp_customize->add_setting('finance_accounting_post_image_dimention',array(
       'default' => 'Default',
       'sanitize_callback'	=> 'finance_accounting_sanitize_choices'
    ));
    $wp_customize->add_control('finance_accounting_post_image_dimention',array(
       'type' => 'radio',
       'label'	=> __('Post Featured Image Dimention','finance-accounting'),
       'choices' => array(
            'Default' => __('Default','finance-accounting'),
            'Custom Image Size' => __('Custom Image Size','finance-accounting'),
        ),
      	'section'	=> 'finance_accounting_blog_post'
    ));

    $wp_customize->add_setting( 'finance_accounting_post_featured_image_width',array(
		'default' => '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_number_range'
	));
	$wp_customize->add_control('finance_accounting_post_featured_image_width',	array(
		'label' => esc_html__( 'Blog Post Custom Width','finance-accounting' ),
		'section' => 'finance_accounting_blog_post',
		'input_attrs' => array(
			'min' => 0,
			'max' => 500,
			'step' => 1,
		),
		'type' => 'range',
		'active_callback' => 'finance_accounting_enable_image_dimention'
	));

	$wp_customize->add_setting( 'finance_accounting_post_featured_image_height',array(
		'default' => '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_number_range'
	));
	$wp_customize->add_control('finance_accounting_post_featured_image_height',	array(
		'label' => esc_html__( 'Blog Post Custom Height','finance-accounting' ),
		'section' => 'finance_accounting_blog_post',
		'input_attrs' => array(
			'min' => 0,
			'max' => 350,
			'step' => 1,
		),
		'type' => 'range',
		'active_callback' => 'finance_accounting_enable_image_dimention'
	));

	$wp_customize->add_setting('finance_accounting_blog_description',array(
    	'default'   => 'Post Excerpt',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_blog_description',array(
        'type' => 'select',
        'label' => __('Post Description','finance-accounting'),
        'section' => 'finance_accounting_blog_post',
        'choices' => array(
            'None' => __('None','finance-accounting'),
            'Post Excerpt' => __('Post Excerpt','finance-accounting'),
            'Post Content' => __('Post Content','finance-accounting'),
        ),
	) );

    $wp_customize->add_setting( 'finance_accounting_excerpt_number', array(
		'default'              => 20,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	) );
	$wp_customize->add_control( 'finance_accounting_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','finance-accounting' ),
		'section'     => 'finance_accounting_blog_post',
		'type'        => 'range',
		'settings'    => 'finance_accounting_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'finance_accounting_post_excerpt_suffix', array(
		'default'   =>  __('{...}','finance-accounting'),
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'finance_accounting_post_excerpt_suffix', array(
		'label'       => esc_html__( 'Excerpt Indicator','finance-accounting' ),
		'section'     => 'finance_accounting_blog_post',
		'type'        => 'text',
		'settings'    => 'finance_accounting_post_excerpt_suffix',
	) );

	$wp_customize->add_setting('finance_accounting_show_post_pagination',array(
       'default' => true,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('finance_accounting_show_post_pagination',array(
       'type' => 'checkbox',
       'label' => __('Post Pagination','finance-accounting'),
       'section' => 'finance_accounting_blog_post'
    ));

    $wp_customize->add_setting('finance_accounting_post_pagination_option',array(
    	'default' => 'Left',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_post_pagination_option',array(
        'type' => 'select',
        'label' => __('Post Pagination Alignment','finance-accounting'),
        'section' => 'finance_accounting_blog_post',
        'choices' => array(
            'Center' => __('Center','finance-accounting'),
            'Left' => __('Left','finance-accounting'),
            'Right' => __('Right','finance-accounting'),
        ),
	) );

	$wp_customize->add_setting( 'finance_accounting_pagination_option', array(
        'default'			=>  'Default',
        'sanitize_callback'	=> 'finance_accounting_sanitize_choices'
    ));
    $wp_customize->add_control( 'finance_accounting_pagination_option', array(
        'section' => 'finance_accounting_blog_post',
        'type' => 'radio',
        'label' => __( 'Post Pagination', 'finance-accounting' ),
        'choices'		=> array(
            'Default'  => __( 'Default', 'finance-accounting' ),
            'next-prev' => __( 'Next / Previous', 'finance-accounting' ),
    )));

	// Single post setting
    $wp_customize->add_section('finance_accounting_single_post_section',array(
		'title'	=> __('Single Post Settings','finance-accounting'),
		'panel' => 'finance_accounting_panel_id',
	));

	$wp_customize->add_setting('finance_accounting_single_post_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_single_post_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_single_post_section'
	));


	$wp_customize->add_setting('finance_accounting_single_post_breadcrumb',array(
		'default' => false,
		'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	));
	$wp_customize->add_control('finance_accounting_single_post_breadcrumb',array(
		'type' => 'checkbox',
		'label' => __('Enable / Disable Breadcrumb','finance-accounting'),
		'section' => 'finance_accounting_single_post_section',
	));

	$wp_customize->add_setting('finance_accounting_tags_hide',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_tags_hide',array(
       'type' => 'checkbox',
       'label' => __('Single Post Tags','finance-accounting'),
       'section' => 'finance_accounting_single_post_section'
    ));

    $wp_customize->add_setting('finance_accounting_single_post_image',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_single_post_image',array(
       'type' => 'checkbox',
       'label' => __('Single Post Featured Image','finance-accounting'),
       'section' => 'finance_accounting_single_post_section'
    ));

    $wp_customize->add_setting( 'finance_accounting_single_post_img_border_radius', array(
		'default'=> 0,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	) );
	$wp_customize->add_control( 'finance_accounting_single_post_img_border_radius', array(
		'label'       => esc_html__( 'Single Post Image Border Radius','finance-accounting' ),
		'section'     => 'finance_accounting_single_post_section',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 100,
		),
	) );

	$wp_customize->add_setting( 'finance_accounting_single_post_img_box_shadow',array(
		'default' => 0,
		'sanitize_callback'    => 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_single_post_img_box_shadow',array(
		'label' => esc_html__( 'Single Post Image Shadow','finance-accounting' ),
		'section' => 'finance_accounting_single_post_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type' => 'number'
	));

	$wp_customize->add_setting('finance_accounting_single_post_image_dimention',array(
		'default' => 'Default',
		'sanitize_callback'	=> 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_single_post_image_dimention',array(
		'type' => 'radio',
		'label'	=> __('Single Post Featured Image Dimention','finance-accounting'),
		'choices' => array(
			'Default' => __('Default','finance-accounting'),
			'Custom Image Size' => __('Custom Image Size','finance-accounting'),
		),
		'section'	=> 'finance_accounting_single_post_section'
	));

	$wp_customize->add_setting( 'finance_accounting_single_post_featured_image_width',array(
		'default' => '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_number_range'
	));
	$wp_customize->add_control('finance_accounting_single_post_featured_image_width',	array(
		'label' => esc_html__( 'Single Blog Post Custom Width','finance-accounting' ),
		'section' => 'finance_accounting_single_post_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 900,
			'step' => 1,
		),
		'type' => 'range',
		'active_callback' => 'finance_accounting_enable_single_post_image_dimention'
	));
 
	$wp_customize->add_setting( 'finance_accounting_single_post_featured_image_height',array(
		'default' => '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_number_range'
	));
	$wp_customize->add_control('finance_accounting_single_post_featured_image_height',	array(
		'label' => esc_html__( 'Single Blog Post Custom Height','finance-accounting' ),
		'section' => 'finance_accounting_single_post_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 900,
			'step' => 1,
		),
		'type' => 'range',
		'active_callback' => 'finance_accounting_enable_single_post_image_dimention'
	)); 

	$wp_customize->add_setting('finance_accounting_single_post_date',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_single_post_date',array(
       'type' => 'checkbox',
       'label' => __('Single Post Date','finance-accounting'),
       'section' => 'finance_accounting_single_post_section'
    ));

	$wp_customize->add_setting('finance_accounting_single_post_date_icon_changer',array(
		'default'	=> 'fa fa-calendar',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Finance_Accounting_Icon_Changer(
     	$wp_customize,'finance_accounting_single_post_date_icon_changer',array(
		'label'	=> __('Single Post Date Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_single_post_section',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('finance_accounting_single_post_comment',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_single_post_comment',array(
       'type' => 'checkbox',
       'label' => __('Single Post Comments','finance-accounting'),
       'section' => 'finance_accounting_single_post_section'
    ));

	$wp_customize->add_setting('finance_accounting_single_post_comment_icon_changer',array(
		'default'	=> 'fas fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Finance_Accounting_Icon_Changer(
        $wp_customize,'finance_accounting_single_post_comment_icon_changer',array(
		'label'	=> __('Single Post Comment Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_single_post_section',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('finance_accounting_single_post_author',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_single_post_author',array(
       'type' => 'checkbox',
       'label' => __('Single Post Author','finance-accounting'),
       'section' => 'finance_accounting_single_post_section'
    ));

	$wp_customize->add_setting('finance_accounting_single_post_author_icon_changer',array(
		'default'	=> 'fa fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Finance_Accounting_Icon_Changer(
        $wp_customize,'finance_accounting_single_post_author_icon_changer',array(
		'label'	=> __('Single Post Author Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_single_post_section',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('finance_accounting_single_post_time_show',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_single_post_time_show',array(
       'type' => 'checkbox',
       'label' => __('Single Post Time','finance-accounting'),
       'section' => 'finance_accounting_single_post_section'
    ));

	$wp_customize->add_setting('finance_accounting_single_post_time_icon_changer',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Finance_Accounting_Icon_Changer(
        $wp_customize,'finance_accounting_single_post_time_icon_changer',array(
		'label'	=> __('Single Post Time Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_single_post_section',
		'type'		=> 'icon'
	)));

    $wp_customize->add_setting('finance_accounting_show_single_post_pagination',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_show_single_post_pagination',array(
       'type' => 'checkbox',
       'label' => __('Single Post Pagination','finance-accounting'),
       'section' => 'finance_accounting_single_post_section'
    ));

    $wp_customize->add_setting('finance_accounting_show_hide_single_post_categories',array(
		'default' => true,
		'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
 	));
 	$wp_customize->add_control('finance_accounting_show_hide_single_post_categories',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Categories','finance-accounting'),
		'section' => 'finance_accounting_single_post_section'
	));

    $wp_customize->add_setting( 'finance_accounting_seperator_metabox', array(
		'default'   => '',
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'finance_accounting_seperator_metabox', array(
		'label'       => esc_html__( 'Single Post Meta Box Seperator','finance-accounting' ),
		'section'     => 'finance_accounting_single_post_section',
		'description' => __('Add the seperator for meta box. Example: ",",  "|", "/", etc. ','finance-accounting'),
		'type'        => 'text',
		'settings'    => 'finance_accounting_seperator_metabox',
	) );

	$wp_customize->add_setting('finance_accounting_comment_form_heading',array(
       'default' => __('Leave a Reply','finance-accounting'),
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('finance_accounting_comment_form_heading',array(
       'type' => 'text',
       'label' => __('Comment Form Heading','finance-accounting'),
       'section' => 'finance_accounting_single_post_section'
    ));

    $wp_customize->add_setting('finance_accounting_comment_button_text',array(
       'default' => __('Post Comment','finance-accounting'),
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('finance_accounting_comment_button_text',array(
       'type' => 'text',
       'label' => __('Comment Submit Button Text','finance-accounting'),
       'section' => 'finance_accounting_single_post_section'
    ));

    $wp_customize->add_setting( 'finance_accounting_comment_form_size',array(
		'default' => 100,
		'sanitize_callback'    => 'finance_accounting_sanitize_number_range',
	));
	$wp_customize->add_control('finance_accounting_comment_form_size',	array(
		'label' => esc_html__( 'Comment Form Size','finance-accounting' ),
		'section' => 'finance_accounting_single_post_section',
		'type' => 'range',
		'input_attrs' => array(
			'min' => 0,
			'max' => 100,
			'step' => 1,
		),
	));

	$wp_customize->add_setting('finance_accounting_post_comment_enable',array(
		'default' => true,
		'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	));
	$wp_customize->add_control('finance_accounting_post_comment_enable',array(
		'type' => 'checkbox',
		'label' => __('Enable / Disable Post Comment','finance-accounting'),
		'section' => 'finance_accounting_single_post_section',
	));

	$wp_customize->add_setting('finance_accounting_nav_links',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_nav_links',array(
       'type' => 'checkbox',
       'label' => __('Enable / Disable Nav Links','finance-accounting'),
       'section' => 'finance_accounting_single_post_section'
    ));

    $wp_customize->add_setting('finance_accounting_prev_text',array(
       'default' => '',
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('finance_accounting_prev_text',array(
       'type' => 'text',
       'label' => __('Previous Navigation Text','finance-accounting'),
       'section' => 'finance_accounting_single_post_section'
    ));

    $wp_customize->add_setting('finance_accounting_next_text',array(
       'default' => '',
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('finance_accounting_next_text',array(
       'type' => 'text',
       'label' => __('Next Navigation Text','finance-accounting'),
       'section' => 'finance_accounting_single_post_section'
    ));

    // related post setting
    $wp_customize->add_section('finance_accounting_related_post_section',array(
		'title'	=> __('Related Post Settings','finance-accounting'),
		'panel' => 'finance_accounting_panel_id',
	));

	$wp_customize->add_setting('finance_accounting_related_post_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_related_post_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_related_post_section',
	
	));
	$wp_customize->add_setting('finance_accounting_related_posts',array(
       'default' => true,
       'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
    ));
    $wp_customize->add_control('finance_accounting_related_posts',array(
       'type' => 'checkbox',
       'label' => __('Related Post','finance-accounting'),
       'section' => 'finance_accounting_related_post_section',
    ));

	$wp_customize->add_setting( 'finance_accounting_show_related_post', array(
        'default' => 'By Categories',
        'sanitize_callback'	=> 'finance_accounting_sanitize_choices'
    ));
    $wp_customize->add_control( 'finance_accounting_show_related_post', array(
        'section' => 'finance_accounting_related_post_section',
        'type' => 'radio',
        'label' => __( 'Show Related Posts', 'finance-accounting' ),
        'choices' => array(
            'categories'  => __('By Categories', 'finance-accounting'),
            'tags' => __( 'By Tags', 'finance-accounting' ),
    )));

    $wp_customize->add_setting('finance_accounting_change_related_post_title',array(
		'default'=> __('Related Posts','finance-accounting'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_change_related_post_title',array(
		'label'	=> __('Change Related Post Title','finance-accounting'),
		'section'=> 'finance_accounting_related_post_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('finance_accounting_related_post_date_hide',array(
		'default' => true,
		'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	));
	$wp_customize->add_control('finance_accounting_related_post_date_hide',array(
		'type' => 'checkbox',
		'label' => __('Post Date','finance-accounting'),
		'section' => 'finance_accounting_related_post_section'
	));

	$wp_customize->add_setting('finance_accounting_related_post_author_hide',array(
		'default' => true,
		'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	));
	$wp_customize->add_control('finance_accounting_related_post_author_hide',array(
		'type' => 'checkbox',
		'label' => __('Post Author','finance-accounting'),
		'section' => 'finance_accounting_related_post_section'
	));

	$wp_customize->add_setting('finance_accounting_related_post_comment_hide',array(
		'default' => true,
		'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	));
	$wp_customize->add_control('finance_accounting_related_post_comment_hide',array(
		'type' => 'checkbox',
		'label' => __('Post Comments','finance-accounting'),
		'section' => 'finance_accounting_related_post_section'
	));

	$wp_customize->add_setting('finance_accounting_related_post_time',array(
		'default' => true,
		'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	));
	$wp_customize->add_control('finance_accounting_related_post_time',array(
		'type' => 'checkbox',
		'label' => __('Post Time','finance-accounting'),
		'section' => 'finance_accounting_related_post_section'
	));

   	$wp_customize->add_setting('finance_accounting_change_related_posts_number',array(
		'default'=> 3,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_change_related_posts_number',array(
		'label'	=> __('Change Related Post Number','finance-accounting'),
		'section'=> 'finance_accounting_related_post_section',
		'type'=> 'number',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
	));

	$wp_customize->add_setting( 'finance_accounting_related_post_excerpt_number',array(
		'default' =>20,
		'sanitize_callback' => 'finance_accounting_sanitize_number_range'
	));

	$wp_customize->add_control( 'finance_accounting_related_post_excerpt_number',	array(
		'label' => esc_html__( 'Content Limit','finance-accounting' ),
		'section' => 'finance_accounting_related_post_section',
		'type'        => 'range',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	$wp_customize->add_setting('finance_accounting_show_related_post_image',array(
		'default' => true,
		'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	 ));
	 $wp_customize->add_control('finance_accounting_show_related_post_image',array(
		'type' => 'checkbox',
		'label' => __('Post Image','finance-accounting'),
		'section' => 'finance_accounting_related_post_section'
	 ));

	 $wp_customize->add_setting( 'finance_accounting_related_post_image_shadow',array(
		'default' => 0,
		'sanitize_callback'    => 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_related_post_image_shadow',array(
		'label' => esc_html__( 'Post Image Shadow','finance-accounting' ),
		'section' => 'finance_accounting_related_post_section',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
		'type' => 'number'
	));

	$wp_customize->add_setting('finance_accounting_related_button_text',array(
		'default'=> esc_html__('Continue Reading....','finance-accounting'),
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_related_button_text',array(
		'label'	=> esc_html__('Add Button Text','finance-accounting'),
		'input_attrs' => array(
        'placeholder' => esc_html__( 'Read More', 'finance-accounting' ),
        ),
		'section'=> 'finance_accounting_related_post_section',
		'type'=> 'text'
	));

	// Grid post
	$wp_customize->add_section( 'finance_accounting_grid_layout_settings', array(
		'title' => __( 'Grid Layout Settings', 'finance-accounting' ),
		'panel' => 'finance_accounting_panel_id',
	));

	$wp_customize->add_setting('finance_accounting_grid_post_metabox_seperator',array(
		'default' => '|',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_grid_post_metabox_seperator',array(
		'type' => 'text',
		'label' => __('Metabox Seperator','finance-accounting'),
		'description' => __('Ex: "/", "|", "-", ...','finance-accounting'),
		'section' => 'finance_accounting_grid_layout_settings'
	));

	$wp_customize->add_setting('finance_accounting_grid_post_date',array(
		'default' => 'true',
		'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	));
	$wp_customize->add_control('finance_accounting_grid_post_date',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Date ','finance-accounting'),
		'section' => 'finance_accounting_grid_layout_settings'
	));

	$wp_customize->add_setting('finance_accounting_grid_post_date_icon',array(
		'default'	=> 'fas fa-calendar-alt',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Finance_Accounting_Icon_Changer(
		$wp_customize,'finance_accounting_grid_post_date_icon',array(
		'label'	=> __('Grid Post Date Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_grid_layout_settings',
		'setting'	=> 'finance_accounting_grid_post_date_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('finance_accounting_grid_post_author',array(
		'default' => 'true',
		'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	));
	$wp_customize->add_control('finance_accounting_grid_post_author',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Author','finance-accounting'),
		'section' => 'finance_accounting_grid_layout_settings'
	));

	$wp_customize->add_setting('finance_accounting_grid_post_author_icon',array(
		'default'	=> 'fa fa-user',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Finance_Accounting_Icon_Changer(
		$wp_customize,'finance_accounting_grid_post_author_icon',array(
		'label'	=> __('Grid Post Author Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_grid_layout_settings',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('finance_accounting_grid_post_comment',array(
		'default' => 'true',
		'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	));
	$wp_customize->add_control('finance_accounting_grid_post_comment',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Comments','finance-accounting'),
		'section' => 'finance_accounting_grid_layout_settings'
	));

	$wp_customize->add_setting('finance_accounting_grid_post_comment_icon',array(
		'default'	=> 'fas fa-comments',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Finance_Accounting_Icon_Changer(
		$wp_customize,'finance_accounting_grid_post_comment_icon',array(
		'label'	=> __('Grid Post Comments Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_grid_layout_settings',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('finance_accounting_grid_post_time',array(
		'default' => 'true',
		'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	));
	$wp_customize->add_control('finance_accounting_grid_post_time',array(
		'type' => 'checkbox',
		'label' => __('Show / Hide Time','finance-accounting'),
		'section' => 'finance_accounting_grid_layout_settings'
	));

	$wp_customize->add_setting('finance_accounting_grid_post_time_icon',array(
		'default'	=> 'fas fa-clock',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new Finance_Accounting_Icon_Changer(
		$wp_customize,'finance_accounting_grid_post_time_icon',array(
		'label'	=> __('Grid Post Time Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_grid_layout_settings',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('finance_accounting_grid_post_content',array(
    	'default'   => 'Post Excerpt',
     	'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_grid_post_content',array(
		'type' => 'select',
		'label' => __('Grid Post Description','finance-accounting'),
		'section' => 'finance_accounting_grid_layout_settings',
		'choices' => array(
		   'None' => __('None','finance-accounting'),
		   'Post Excerpt' => __('Post Excerpt','finance-accounting'),
		   'Post Content' => __('Post Content','finance-accounting'),
		),
	) );

 	$wp_customize->add_setting( 'finance_accounting_grid_excerpt_number', array(
		'default'              => 20,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	) );
	$wp_customize->add_control( 'finance_accounting_grid_excerpt_number', array(
		'label'       => esc_html__( 'Grid Post Excerpt length','finance-accounting' ),
		'section'     => 'finance_accounting_grid_layout_settings',
		'type'        => 'range',
		'settings'    => 'finance_accounting_grid_excerpt_number',
		'input_attrs' => array(
			'step'             => 2,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting( 'finance_accounting_grid_excerpt_suffix', array(
		'default'   => __('{...}','finance-accounting'),
		'sanitize_callback'	=> 'sanitize_text_field'
	) );
	$wp_customize->add_control( 'finance_accounting_grid_excerpt_suffix', array(
		'label'       => esc_html__( 'Grid Post Excerpt Indicator','finance-accounting' ),
		'section'     => 'finance_accounting_grid_layout_settings',
		'type'        => 'text',
		'settings'    => 'finance_accounting_grid_excerpt_suffix',
	) );

	//Footer
	$wp_customize->add_section( 'finance_accounting_footer' , array(
    	'title' => __( 'Footer Section', 'finance-accounting' ),
		'priority'   => null,
		'panel' => 'finance_accounting_panel_id'
	) );

	$wp_customize->add_setting('finance_accounting_footer_premium_info',array(
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_footer_premium_info',array(
		'type'=> 'hidden',
		'label'	=> __('Premium Features','finance-accounting'),
		'description' => "<ul><li>". esc_html__('Please explore our premium theme for additional settings and features.','finance-accounting') ."</li></ul><a target='_blank' href='". esc_url(FINANCE_ACCOUNTING_BUY_PRO) ." '>". esc_html__('Upgrade to Pro','finance-accounting') ."</a>",
		'section'=> 'finance_accounting_footer'
	));

	$wp_customize->add_setting('finance_accounting_show_hide_footer',array(
		'default' => true,
		'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	));
	$wp_customize->add_control('finance_accounting_show_hide_footer',array(
     	'type' => 'checkbox',
      'label' => __('Enable / Disable Footer','finance-accounting'),
      'section' => 'finance_accounting_footer',
	));

	$wp_customize->add_setting('finance_accounting_footer_widget',array(
        'default'           => 4,
        'sanitize_callback' => 'finance_accounting_sanitize_choices',
    ));
    $wp_customize->add_control('finance_accounting_footer_widget',array(
        'type'        => 'radio',
        'label'       => __('No. of Footer widget area', 'finance-accounting'),
        'section'     => 'finance_accounting_footer',
        'description' => __('Select the number of footer widget areas and after that, go to Appearance > Widgets and add your widgets in the footer.', 'finance-accounting'),
        'choices' => array(
            '1'     => __('One', 'finance-accounting'),
            '2'     => __('Two', 'finance-accounting'),
            '3'     => __('Three', 'finance-accounting'),
            '4'     => __('Four', 'finance-accounting')
        ),
    ));

    $wp_customize->add_setting( 'finance_accounting_footer_widget_background', array(
	    'default' => '#000',
	    'sanitize_callback' => 'sanitize_hex_color'
  	));
  	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'finance_accounting_footer_widget_background', array(
  		'label' => __('Footer Widget Background','finance-accounting'),
	    'section' => 'finance_accounting_footer',
  	)));

  	$wp_customize->add_setting('finance_accounting_footer_widget_image',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'finance_accounting_footer_widget_image',array(
        'label' => __('Footer Widget Background Image','finance-accounting'),
        'section' => 'finance_accounting_footer'
	)));

	$wp_customize->add_setting('finance_accounting_img_footer',array(
		'default'=> 'scroll',
		'sanitize_callback'	=> 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_img_footer',array(
		'type' => 'select',
		'label'	=> __('Footer Background Attatchment','finance-accounting'),
		'choices' => array(
            'fixed' => __('fixed','finance-accounting'),
            'scroll' => __('scroll','finance-accounting'),
        ),
		'section'=> 'finance_accounting_footer',
	));

	$wp_customize->add_setting('finance_accounting_footer_img_position',array(
		'default' => 'center center',
		'transport' => 'refresh',
		'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));

	$wp_customize->add_control('finance_accounting_footer_img_position',array(
		'type' => 'select',
		'label' => __('Footer Image Position','finance-accounting'),
		'section' => 'finance_accounting_footer',
		'choices' 	=> array(
			'left top' 		=> esc_html__( 'Top Left', 'finance-accounting' ),
			'center top'   => esc_html__( 'Top', 'finance-accounting' ),
			'right top'   => esc_html__( 'Top Right', 'finance-accounting' ),
			'left center'   => esc_html__( 'Left', 'finance-accounting' ),
			'center center'   => esc_html__( 'Center', 'finance-accounting' ),
			'right center'   => esc_html__( 'Right', 'finance-accounting' ),
			'left bottom'   => esc_html__( 'Bottom Left', 'finance-accounting' ),
			'center bottom'   => esc_html__( 'Bottom', 'finance-accounting' ),
			'right bottom'   => esc_html__( 'Bottom Right', 'finance-accounting' ),
		),
	));

	$wp_customize->add_setting('finance_accounting_footer_heading_option',array(
    	'default' => 'Left',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_footer_heading_option',array(
        'type' => 'select',
        'label' => __('Footer Heading Alignment','finance-accounting'),
        'section' => 'finance_accounting_footer',
        'choices' => array(
            'Center' => __('Center','finance-accounting'),
            'Left' => __('Left','finance-accounting'),
            'Right' => __('Right','finance-accounting'),
        ),
	) );

	$wp_customize->add_setting('finance_accounting_footer_text_tranform',array(
		'default' => 'Capitalize',
		'sanitize_callback' => 'finance_accounting_sanitize_choices'
 	));
 	$wp_customize->add_control('finance_accounting_footer_text_tranform',array(
		'type' => 'select',
		'label' => __('Footer Heading Text Transform','finance-accounting'),
		'section' => 'finance_accounting_footer',
		'choices' => array(
		   'Uppercase' => __('Uppercase','finance-accounting'),
		   'Lowercase' => __('Lowercase','finance-accounting'),
		   'Capitalize' => __('Capitalize','finance-accounting'),
		),
	) );

	$wp_customize->add_setting('finance_accounting_heading_fontsize',array(
		'default'	=> 25,
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));	
	$wp_customize->add_control('finance_accounting_heading_fontsize',array(
		'label'	=> __('Footer Heading Font Size','finance-accounting'),
		'section'	=> 'finance_accounting_footer',
		'type'		=> 'number'
	));

	$wp_customize->add_setting('finance_accounting_footer_content_option',array(
    	'default' => 'Left',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_footer_content_option',array(
        'type' => 'select',
        'label' => __('Footer Content Alignment','finance-accounting'),
        'section' => 'finance_accounting_footer',
        'choices' => array(
            'Center' => __('Center','finance-accounting'),
            'Left' => __('Left','finance-accounting'),
            'Right' => __('Right','finance-accounting'),
        ),
	) );

	$wp_customize->add_setting('finance_accounting_footer_padding',array(
		'default'=> '',
		'sanitize_callback' => 'sanitize_text_field'
		));
	$wp_customize->add_control('finance_accounting_footer_padding',array(
		'label' => __('Footer Top Bottom Padding','finance-accounting'),
		'description' => __('Enter a value in pixels. Example:20px','finance-accounting'),
		'input_attrs' => array(
			'placeholder' => __( '10px', 'finance-accounting' ),
		),
		'section'=> 'finance_accounting_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('finance_accounting_hide_show_scroll',array(
        'default' => true,
        'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	));
	$wp_customize->add_control('finance_accounting_hide_show_scroll',array(
     	'type' => 'checkbox',
      	'label' => __('Show / Hide Scroll To Top','finance-accounting'),
      	'section' => 'finance_accounting_footer',
	));
	
	$wp_customize->add_setting('finance_accounting_scroll_icon_changer',array(
		'default'	=> 'fas fa-long-arrow-alt-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
     	$wp_customize,'finance_accounting_scroll_icon_changer',array(
		'label'	=> __('Scroll To Top Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_footer',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('finance_accounting_footer_options',array(
        'default' => 'Right align',
        'sanitize_callback' => 'finance_accounting_sanitize_choices'
	));
	$wp_customize->add_control('finance_accounting_footer_options',array(
        'type' => 'select',
        'label' => __('Scroll To Top','finance-accounting'),
        'description' => __('Here you can change the Footer layout. ','finance-accounting'),
        'section' => 'finance_accounting_footer',
        'choices' => array(
            'Left align' => __('Left align','finance-accounting'),
            'Right align' => __('Right align','finance-accounting'),
            'Center align' => __('Center align','finance-accounting'),
        ),
	) );

	$wp_customize->add_setting('finance_accounting_scroll_top_fontsize',array(
		'default'=> '',
		'sanitize_callback'    => 'finance_accounting_sanitize_number_range',
	));
	$wp_customize->add_control('finance_accounting_scroll_top_fontsize',array(
		'label'	=> __('Scroll To Top Font Size','finance-accounting'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'finance_accounting_footer',
		'type'=> 'range'
	));

	$wp_customize->add_setting('finance_accounting_scroll_top_bottom_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_scroll_top_bottom_padding',array(
		'label'	=> __('Scroll Top Bottom Padding ','finance-accounting'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'finance_accounting_footer',
		'type'=> 'number'
	));

	$wp_customize->add_setting('finance_accounting_scroll_left_right_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_scroll_left_right_padding',array(
		'label'	=> __('Scroll Left Right Padding','finance-accounting'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'finance_accounting_footer',
		'type'=> 'number'
	));

	$wp_customize->add_setting( 'finance_accounting_scroll_border_radius', array(
		'default'=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	) );
	$wp_customize->add_control( 'finance_accounting_scroll_border_radius', array(
		'label'       => esc_html__( 'Scroll To Top Border Radius','finance-accounting' ),
		'section'     => 'finance_accounting_footer',
		'type'        => 'number',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('finance_accounting_scroll_background_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'finance_accounting_scroll_background_color', array(
		'label'    => __('Scroll To Top Background Color', 'finance-accounting'),
		'section'  => 'finance_accounting_footer',
	)));

	$wp_customize->add_setting('finance_accounting_scroll_icon_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'finance_accounting_scroll_icon_color', array(
		'label'    => __('Scroll To Top Color', 'finance-accounting'),
		'section'  => 'finance_accounting_footer',
	)));

	$wp_customize->add_setting('finance_accounting_scroll_background_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'finance_accounting_scroll_background_hover_color', array(
		'label'    => __('Scroll To Top Background Hover Color', 'finance-accounting'),
		'section'  => 'finance_accounting_footer',
	)));

	$wp_customize->add_setting('finance_accounting_footer_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('finance_accounting_footer_text',array(
		'label'	=> __('Add Copyright Text','finance-accounting'),
    	'description'	=> __('Here you can add copyright text.','finance-accounting'),
		'section'	=> 'finance_accounting_footer',
		'setting'	=> 'finance_accounting_footer_text',
		'type'		=> 'text'
	));

    $wp_customize->add_setting('finance_accounting_copyright_top_bottom_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_copyright_top_bottom_padding',array(
		'label'	=> __('Copyright Top and Bottom Padding','finance-accounting'),
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'section'=> 'finance_accounting_footer',
		'type'=> 'number'
	));

	 $wp_customize->add_setting('finance_accounting_copyright_background_color', array(
		'default'           => '#53507b',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'finance_accounting_copyright_background_color', array(
		'label'    => __('Copyright Background Color', 'finance-accounting'),
		'section'  => 'finance_accounting_footer',
	)));

	$wp_customize->add_setting('finance_accounting_copyright_text_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'finance_accounting_copyright_text_color', array(
		'label'    => __('Copyright text Color', 'finance-accounting'),
		'section'  => 'finance_accounting_footer',
	)));

	$wp_customize->add_setting('finance_accounting_footer_text_font_size',array(
		'default'=> 16,
		'sanitize_callback'    => 'finance_accounting_sanitize_float',
	));
	$wp_customize->add_control('finance_accounting_footer_text_font_size',array(
		'label'	=> __('Footer Text Font Size','finance-accounting'),
		'section'=> 'finance_accounting_footer',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 50,
        ),
		'type'=> 'number'
	));
	//Footer Social Icons
	$wp_customize->add_section('finance_accounting_social_icons_section',array(
		'title'	=> __('Footer Social Icons','finance-accounting'),
		'priority'	=> null,
		'panel' => 'finance_accounting_panel_id',
	));
	$wp_customize->selective_refresh->add_partial(
		'finance_accounting_facebook_url',
		array(
			'selector'        => '.social-media',
			'render_callback' => 'finance_accounting_customize_partial_finance_accounting_facebook_url',
		)
	);
	$wp_customize->add_setting('finance_accounting_show_footer_social_icon',array(
        'default' => true,
        'sanitize_callback'	=> 'finance_accounting_sanitize_checkbox'
	));
	$wp_customize->add_control('finance_accounting_show_footer_social_icon',array(
     	'type' => 'checkbox',
      	'label' => __('Show/Hide Social Icons','finance-accounting'),
      	'section' => 'finance_accounting_social_icons_section',
	));
	$wp_customize->add_setting('finance_accounting_footer_facebook_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('finance_accounting_footer_facebook_url',array(
		'label'	=> __('Add Facebook URL','finance-accounting'),
		'section'	=> 'finance_accounting_social_icons_section',
		'setting'	=> 'finance_accounting_footer_facebook_url',
		'type'	=> 'url'
	));
	$wp_customize->add_setting('finance_accounting_footer_facebook_icon',array(
		'default'	=> 'fab fa-facebook-f',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
		$wp_customize,'finance_accounting_footer_facebook_icon',array(
		'label'	=> __('Add Facebook Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_social_icons_section',
		'setting'	=> 'finance_accounting_footer_facebook_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('finance_accounting_footer_twitter_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('finance_accounting_footer_twitter_url',array(
		'label'	=> __('Add Twitter URL','finance-accounting'),
		'section'	=> 'finance_accounting_social_icons_section',
		'setting'	=> 'finance_accounting_footer_twitter_url',
		'type'	=> 'url'
	));
	$wp_customize->add_setting('finance_accounting_footer_twitter_icon',array(
		'default'	=> 'fab fa-twitter',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
		$wp_customize,'finance_accounting_footer_twitter_icon',array(
		'label'	=> __('Add Twitter Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_social_icons_section',
		'setting'	=> 'finance_accounting_footer_twitter_icon',
		'type'		=> 'icon'
	)));
	$wp_customize->add_setting('finance_accounting_footer_instagram_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('finance_accounting_footer_instagram_url',array(
		'label'	=> __('Add Instagram URL','finance-accounting'),
		'section'	=> 'finance_accounting_social_icons_section',
		'setting'	=> 'finance_accounting_footer_instagram_url',
		'type'	=> 'url'
	));
	$wp_customize->add_setting('finance_accounting_footer_instagram_icon',array(
		'default'	=> 'fab fa-instagram',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
		$wp_customize,'finance_accounting_footer_instagram_icon',array(
		'label'	=> __('Add Instagram Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_social_icons_section',
		'setting'	=> 'finance_accounting_footer_instagram_icon',
		'type'		=> 'icon'
	)));
	$wp_customize->add_setting('finance_accounting_footer_linkedin_url',array(
        'default' => '',
        'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('finance_accounting_footer_linkedin_url',array(
     	'type' => 'url',
	   	'label' => __('Add Linkedin URL','finance-accounting'),
	   	'section' => 'finance_accounting_social_icons_section',
	));

	$wp_customize->add_setting('finance_accounting_footer_linkedin_icon',array(
		'default'	=> 'fab fa-linkedin',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
        $wp_customize,'finance_accounting_footer_linkedin_icon',array(
		'label'	=> __('Add Linkedin Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_social_icons_section',
		'setting'	=> 'finance_accounting_linkedin_icon',
		'type'		=> 'icon'
	)));	

	$wp_customize->add_setting('finance_accounting_footer_vk_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('finance_accounting_footer_vk_url',array(
		'label'	=> __('Add vk link','finance-accounting'),
		'section'	=> 'finance_accounting_social_icons_section',
		'setting'	=> 'finance_accounting_vk_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('finance_accounting_footer_vk_icon',array(
		'default'	=> 'fab fa-vk',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
        $wp_customize,'finance_accounting_footer_vk_icon',array(
		'label'	=> __('vk Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_social_icons_section',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('finance_accounting_footer_youtube_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('finance_accounting_footer_youtube_url',array(
		'label'	=> __('Add Youtube link','finance-accounting'),
		'section'	=> 'finance_accounting_social_icons_section',
		'setting'	=> 'finance_accounting_youtube_url',
		'type'		=> 'url'
	));

	$wp_customize->add_setting('finance_accounting_footer_youtube_icon',array(
		'default'	=> 'fab fa-youtube',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control(new finance_accounting_Icon_Changer(
        $wp_customize,'finance_accounting_footer_youtube_icon',array(
		'label'	=> __('Youtube Icon','finance-accounting'),
		'transport' => 'refresh',
		'section'	=> 'finance_accounting_social_icons_section',
		'type'		=> 'icon'
	)));
	$wp_customize->add_setting( 'finance_accounting_footer_icon_font_size', array(
		'default'           => '',
		'sanitize_callback' => 'finance_accounting_sanitize_float',
	) );
	$wp_customize->add_control( 'finance_accounting_footer_icon_font_size', array(
		'label' => __( 'Icon Font Size','finance-accounting' ),
		'section'     => 'finance_accounting_social_icons_section',
		'type'        => 'number',
		'input_attrs' => array(
			'step' => 1,
			'min' => 0,
			'max' => 50,
		),
	) );

	$wp_customize->add_setting('finance_accounting_footer_icon_color', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'finance_accounting_footer_icon_color', array(
		'label'    => __('Icon Color', 'finance-accounting'),
		'section'  => 'finance_accounting_social_icons_section',
	)));

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'finance_accounting_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'finance_accounting_customize_partial_blogdescription',
	) );

}
add_action( 'customize_register', 'finance_accounting_customize_register' );

// logo resize
load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Finance Accounting 1.0
 * @see finance-accounting_customize_register()
 *
 * @return void
 */
function finance_accounting_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Finance Accounting 1.0
 * @see finance-accounting_customize_register()
 *
 * @return void
 */
function finance_accounting_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Return whether we're on a view that supports a one or two column layout.
 */
function finance_accounting_is_view_with_layout_option() {
	// This option is available on all pages. It's also available on archives when there isn't a sidebar.
	return ( is_page() || ( is_archive() && ! is_active_sidebar( 'footer-1' ) ) );
}

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Finance_Accounting_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Finance_Accounting_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Finance_Accounting_Customize_Section_Pro(
				$manager,
				'finance_accounting_example_1',
				array(
					'priority'   => 9,
					'title'    => esc_html__( 'EXPLORE OUR PREMIUM FEATURES', 'finance-accounting' ),
					'pro_text' => esc_html__( 'Upgrade To Pro', 'finance-accounting' ),
					'pro_url'  => esc_url('https://www.themescaliber.com/products/accounting-finance-wordpress-theme'),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'finance-accounting-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'finance-accounting-customize-controls', trailingslashit( esc_url(get_template_directory_uri()) ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Finance_Accounting_Customize::get_instance();
