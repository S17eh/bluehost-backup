<?php
//about theme info
add_action( 'admin_menu', 'finance_accounting_gettingstarted' );
function finance_accounting_gettingstarted() {
	add_theme_page( esc_html__('About Theme', 'finance-accounting'), esc_html__('About Theme', 'finance-accounting'), 'edit_theme_options', 'finance-accounting-guide-page', 'finance_accounting_mostrar_guide');   
}

// Add a Custom CSS file to WP Admin Area
function finance_accounting_admin_theme_style() {
   wp_enqueue_style('finance-accounting-custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/dashboard/get_started_info.css');
   wp_enqueue_script('tabs', esc_url(get_template_directory_uri()) . '/inc/dashboard/js/tab.js');
}
add_action('admin_enqueue_scripts', 'finance_accounting_admin_theme_style');

//guidline for about theme
function finance_accounting_mostrar_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme( 'finance-accounting' );
?>

<div class="wrapper-info">  
	<div id="tc-header">
		<div class="tc-container main-header">
			<a class="tc-logo"> 
				<img role="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/dashboard/media/logo.png" alt="" />
			</a>
			<span class="tc-header-action">
			<a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e('Customize', 'finance-accounting'); ?></a>
			<a href="<?php echo esc_url( FINANCE_ACCOUNTING_FREE_DOC ); ?>" target="_blank"> <?php esc_html_e( 'Documentation', 'finance-accounting' ); ?></a>
			<a href="<?php echo esc_url( FINANCE_ACCOUNTING_BUY_PRO); ?>" target="_blank"> <?php esc_html_e( 'Get Premium', 'finance-accounting' ); ?></a>
			<a href="<?php echo esc_url( 'https://www.themescaliber.com/products/wordpress-theme-bundle' ); ?>" class="bundle_btn" target="_blank"> <?php esc_html_e( 'Bundle of 220+ Themes at $99', 'finance-accounting' ); ?></a>
			</span>
		</div>
	</div>
	<div class="tc-container tab-sec">
		<div class="tc-tabs">
			<ul>
				<li class="tablinks home active" onclick="finance_accounting_openCity(event, 'tc_index')">
					<a href="#">
						<?php esc_html_e( 'Free Theme Information', 'finance-accounting' ); ?>
					</a>
				</li>
				<li class="tablinks" onclick="finance_accounting_openCity(event, 'tc_pro')">
					<a href="#">
						<?php esc_html_e( 'Premium Theme Information', 'finance-accounting' ); ?>
					</a>
				</li>
				<li class="tablinks" onclick="finance_accounting_openCity(event, 'tc_create')">
					<a href="#">
						<?php esc_html_e( 'Theme Support', 'finance-accounting' ); ?>
					</a>
				</li>
			</ul>
		</div><!-- END .tc-tabs -->
	</div>

	<div class="tc-container">
		<div class="tc-section">
			<div  id="tc_index" class="tabcontent">
				<h2><?php esc_html_e( 'Welcome to Finance Accounting Theme', 'finance-accounting' ); ?> <span class="version">Version: <?php echo esc_html($theme['Version']);?></span></h2>
				<hr>
				<div class="info-link">
					<a href="<?php echo esc_url( FINANCE_ACCOUNTING_FREE_DOC ); ?>" target="_blank"> <?php esc_html_e( 'Documentation', 'finance-accounting' ); ?></a>
					<a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e('Customizing', 'finance-accounting'); ?></a>
					<a class="get-pro" href="<?php echo esc_url( FINANCE_ACCOUNTING_BUY_PRO ); ?>" target="_blank"><?php esc_html_e('Get Pro', 'finance-accounting'); ?></a>
				</div>
				<div class="col-tc-6">
					<img role="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png" alt="" />
				</div>
				<div class="col-tc-6">
					<P><?php esc_html_e( 'Finance Accounting is a professional looking WordPress theme for finance and accounting businesses. It is dedicatedly designed for financial advisors, law firms, accountants, consults, wealth advisors and investors. The theme can be used by general corporate websites, financial centers and advisors, investors, Agency, finance recruitment,consults, wealth advisors, Accounting Company, Estate/Trust Accounting, Accounting Information Technology/Systems, Chartered Accounting Agency, Micro-Finance Bank, Fund Raising Consultant, Private Finance Blog, Finance Consulting Firm, Allowance Consultant, Mutual Fund Investment Agency, Book Maintenance investors cooperatives, start-ups and business ventures. Its professional look makes it apt for serious businesses and corporate websites. It has stunning and modern design. The user-friendly interface caters hassle-free navigation. It provides easy customization. The theme has all the essential plugins just enough to set up a finance site. It supports third party plugins to extend the functionality and include a specific function. It has multiple page layouts, threaded comments and Four Columns layout for different pages. You can include banner to give it an altogether different look. The Finance and Accounting theme is responsive to adjust its layout across any device size; cross-browser compatible to load on all browsers and translation ready to serve a particular region or population. It has search engine optimized code which pushes for faster page loading. The theme is made in bootstrap framework. Short codes allow clean and secure theme designing. It has a testimonial section for your users to share their experience about your site and services. This will give more insight to other users.', 'finance-accounting' ); ?></P>
				</div>
			</div>
		</div><!-- END .tc-section -->
	</div>

	<div class="tc-container">
		<div class="tc-section">
			<div id="tc_pro" class="tabcontent">
				<h3><?php esc_html_e( 'Finance Accounting Theme Information', 'finance-accounting' ); ?></h3>
				<hr>
				<div class="info-link-pro">
					<a href="<?php echo esc_url( FINANCE_ACCOUNTING_BUY_PRO ); ?>" target="_blank"> <?php esc_html_e( 'Buy Now', 'finance-accounting' ); ?></a>
					<a href="<?php echo esc_url( FINANCE_ACCOUNTING_LIVE_DEMO ); ?>" target="_blank"> <?php esc_html_e( 'Live Demo', 'finance-accounting' ); ?></a>
					<a href="<?php echo esc_url( FINANCE_ACCOUNTING_PRO_DOC ); ?>" target="_blank"> <?php esc_html_e( 'Pro Documentation', 'finance-accounting' ); ?></a>
				</div>
				<div class="pro-image">
					<img role="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/dashboard/media/responsive.png" alt="" />
				</div>
			<div class="col-pro-5">
				<h4><?php esc_html_e( 'Finance Accounting Pro Theme', 'finance-accounting' ); ?></h4>
				<p><?php esc_html_e( 'The finance WordPress theme is highly effective and efficient theme oriented to consulting, accounting and financing websites. It is a thoughtfully designed theme well suited for financial advisors, corporate websites, startups, and business ventures. The framework of this theme is best for designing a sophisticated website.This fully responsive theme looks beautiful on all devices irrespective of their size and screen resolution. It is rigorously tested to make compatible with various browsers. With theme options panel, you can customize the theme to change its logo, color, background, header, footer, menu, and various other elements. The theme is optimized for faster loading. It is translation ready to attend maximum people. With banners and sliders, the theme has been given an attractive look. You can choose from a combination of Google Fonts and unlimited colors to try various looks for your site. The finance WordPress theme has several options to change the layout of the theme homepage and inner pages. With multiple templates and numerous inner pages, you can implement a particular layout to a single page or on all of the pages of the theme. It is SEO-friendly and implements social media icons for better exposure to the world. It has shortcodes to be applied to the widgetized area to implement any feature instantly. We provide full documentation and prompt support for any query you have regarding our theme functionality. The various sections like the testimonial section, subscription area and gallery will help connect with users in an advanced way. Brand yourself with this premium finance theme for better customer response.', 'finance-accounting' ); ?></P>		
			</div>
			<div class="col-pro-6">				
				<h4><?php esc_html_e( 'Theme Features', 'finance-accounting' ); ?></h4>
				<ul>
					<li><?php esc_html_e( 'Theme Options using Customizer API', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Responsive design', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Favicon, Logo, title, and tagline customization', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Advanced Color options', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( '100+ Font Family Options', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Background Image Option', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Simple Menu Option', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Additional section for products', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Enable-Disable options on All sections', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Home Page setting for different sections', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Advance Slider with unlimited slides', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Partner Section', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Promotional Banner Section for Products', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Separate Newsletter Section', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Text and call to action button for each slide', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Pagination option', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Custom CSS option', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Translations Ready', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Custom Backgrounds, Colors, Headers, Logo & Menu', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Customizable Home Page', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Full-Width Template', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Footer Widgets & Editor Style', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Banner & Post Type Plugin Functionality', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Testimonial Post type', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Woo Commerce Compatible', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Multiple Inner Page Templates', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Product Sliders', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Testimonial Slider', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Contact page template', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Contact Widget', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Advance Social Media Feature', 'finance-accounting' ); ?></li>
					<li><?php esc_html_e( 'Testimonial Listing With Shortcode', 'finance-accounting' ); ?></li>
				</ul>				
			</div>	
		</div><!-- END .tc-section -->
	</div>

	<div class="tc-container">
		<div class="tc-section">
			<div id="tc_create" class="tabcontent">
				<div class="tab-cont">
					<h4><?php esc_html_e( 'Need Support?', 'finance-accounting' ); ?></h4>				
					<div class="info-link-support">
						<P><?php esc_html_e( 'Our team is obliged to help you in every way possible whenever you face any type of difficulties and doubts.', 'finance-accounting' ); ?></P>
						<a href="<?php echo esc_url( FINANCE_ACCOUNTING_FREE_SUPPORT ); ?>" target="_blank"> <?php esc_html_e( 'Support Forum', 'finance-accounting' ); ?></a>
					</div>
				</div>
				<div class="tab-cont">	
					<h4><?php esc_html_e('Reviews', 'finance-accounting'); ?></h4>				
					<div class="info-link-support">
						<P><?php esc_html_e( 'It is commendable to have such a theme inculcated with amazing features and robust functionalities. I feel grateful to recommend this theme to one and all.', 'finance-accounting' ); ?></P>
						<a href="<?php echo esc_url( FINANCE_ACCOUNTING_REVIEW ); ?>" target="_blank"><?php esc_html_e('Reviews', 'finance-accounting'); ?></a>
					</div>
				</div>

				<div class="tc-section large-section">
					<h2>Let‘s customize your website</h2>
					<p>There are many changes you can make to customize your website. Explore customization options and make it unique.</p>
					<div class="tc-buttons">
						<a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>" class="tc-btn primary large-button"><?php esc_html_e('Start Customizing', 'finance-accounting'); ?></a>
					</div><!-- END .tc-buttons -->
				</div>
			</div>
		</div><!-- END .tc-section -->
	</div>
</div>
<?php } ?>