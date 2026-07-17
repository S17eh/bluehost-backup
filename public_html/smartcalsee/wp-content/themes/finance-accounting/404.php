<?php
/**
 * The template for displaying 404 pages (not found)
 */
get_header(); ?>

<div id="primary" class="content-area">
	<div class="container">
		<main id="main" class="site-main" role="main">
			<section class="error-404 not-found py-4">
				<header role="banner" class="page-header">
					<h1 class="page-title"><?php echo esc_html(get_theme_mod('finance_accounting_page_not_found_title',__('Oops! That page can&rsquo;t be found.','finance-accounting')));?></h1>
				</header>
				<div class="page-content">
					<p><?php echo esc_html(get_theme_mod('finance_accounting_page_not_found_content',__('It looks like nothing was found at this location. Maybe try a search?','finance-accounting')));?></p>
					<?php get_search_form(); ?>
					
				</div>
			</section>
		</main>
	</div>
</div>

<?php get_footer();
