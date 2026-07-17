<?php
/**
 * Custom template tags for this theme
 */


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function finance_accounting_categorized_blog() {
	$category_count = get_transient( 'finance_accounting_categories' );

	if ( false === $category_count ) {
		// Create an array of all the categories that are attached to posts.
		$categories = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$category_count = count( $categories );

		set_transient( 'finance_accounting_categories', $category_count );
	}

	// Allow viewing case of 0 or 1 categories in post preview.
	if ( is_preview() ) {
		return true;
	}

	return $category_count > 1;
}


/**
 * Flush out the transients used in finance-accounting_categorized_blog.
 */
function finance_accounting_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'finance_accounting_categories' );
}
add_action( 'edit_category', 'finance_accounting_category_transient_flusher' );
add_action( 'save_post',     'finance_accounting_category_transient_flusher' );

/**
 * Posts pagination.
 */
if ( ! function_exists( 'finance_accounting_pagination_option' ) ) {
	function finance_accounting_pagination_type() {
		$finance_accounting_pagination_type = get_theme_mod( 'finance_accounting_pagination_option', 'Default' );
		if ( $finance_accounting_pagination_type == 'Default' ) {
			the_posts_pagination();
		} else {
			the_posts_navigation();
		}
	}
}