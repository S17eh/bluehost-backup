<?php
/**
 * Displays top navigation
 */

?>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'finance-accounting' ); ?>">
	<button role="tab" class="menu-toggle p-3 my-3 mx-auto" aria-controls="top-menu" aria-expanded="false">
		<?php
			esc_html_e( 'Menu', 'finance-accounting' );
		?>
	</button>

	<?php wp_nav_menu( array(
		'theme_location' => 'top',
		'menu_id'        => 'top-menu',
	) ); ?>
	
</nav>