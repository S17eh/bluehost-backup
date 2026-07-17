<?php
/**
 * The template for displaying search results pages
 */

get_header(); ?>

<main id="main" role="main">
	<div class="container">
		<header role="banner" class="page-header">
			<?php if ( have_posts() ) : ?>
				<h1 class="search-title"><?php /* translators: %s: search term */ printf( esc_html__( 'Search Results for: %s','finance-accounting'), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
			<?php else : ?>
				<h1 class="page-title"><?php echo esc_html(get_theme_mod('finance_accounting_no_search_result_title',__('Nothing Found','finance-accounting')));?></h1>
			<?php endif; ?>
		</header>
		<div class="row">
			<?php
		    $finance_accounting_layout_setting = get_theme_mod( 'finance_accounting_layout_settings','Right Sidebar');
		    if($finance_accounting_layout_setting == 'Left Sidebar'){ ?>
			    <div id="sidebox" class="col-lg-4 col-md-4">
					<?php get_sidebar(); ?>
				</div>
				<div class="col-lg-8 col-md-8">
					<?php
						if ( have_posts() ) :

							/* Start the Loop */
							while ( have_posts() ) : the_post();
								
								get_template_part( 'template-parts/post/content', get_post_format() );

							endwhile;

						else : ?>

							<p><?php echo esc_html(get_theme_mod('finance_accounting_no_search_result_content',__('Sorry, but nothing matched your search terms. Please try again with some different keywords.','finance-accounting')));?></p>
							<?php
								get_search_form();

						endif;
					?>
					<?php if( get_theme_mod( 'finance_accounting_show_post_pagination',true) != '') { ?>
						<div class="navigation">
			                <?php finance_accounting_pagination_type(); ?>
		       	 		</div>
		       	 	<?php } ?>
				</div>
			<?php }else if($finance_accounting_layout_setting == 'Right Sidebar'){ ?>
				<div class="col-lg-8 col-md-8">
					<?php
						if ( have_posts() ) :

							/* Start the Loop */
							while ( have_posts() ) : the_post();
								
								get_template_part( 'template-parts/post/content', get_post_format() );

							endwhile;

						else : ?>

							<p><?php echo esc_html(get_theme_mod('finance_accounting_no_search_result_content',__('Sorry, but nothing matched your search terms. Please try again with some different keywords.','finance-accounting')));?></p>
							<?php
								get_search_form();

						endif;
					?>
					<?php if( get_theme_mod( 'finance_accounting_show_post_pagination',true) != '') { ?>
						<div class="navigation">
			                <?php finance_accounting_pagination_type(); ?>
		       	 		</div>
		       	 	<?php } ?>
				</div>
				<div id="sidebox" class="col-lg-4 col-md-4">
					<?php get_sidebar(); ?>
				</div>
			<?php }else if($finance_accounting_layout_setting == 'One Column'){ ?>
				<div class="content-area">
					<?php
						if ( have_posts() ) :

							/* Start the Loop */
							while ( have_posts() ) : the_post();
								
								get_template_part( 'template-parts/post/content', get_post_format() );

							endwhile;

						else : ?>

							<p><?php echo esc_html(get_theme_mod('finance_accounting_no_search_result_content',__('Sorry, but nothing matched your search terms. Please try again with some different keywords.','finance-accounting')));?></p>
							<?php
								get_search_form();

						endif;
					?>
					<?php if( get_theme_mod( 'finance_accounting_show_post_pagination',true) != '') { ?>
						<div class="navigation">
			                <?php finance_accounting_pagination_type(); ?>
		       	 		</div>
		       	 	<?php } ?>
				</div>
			<?php }else if($finance_accounting_layout_setting == 'Three Column'){ ?>
				<div id="sidebox" class="col-lg-3 col-md-3">
					<?php dynamic_sidebar('sidebar-1'); ?>
				</div>
				<div class="col-lg-6 col-md-6">
					<?php
						if ( have_posts() ) :

							/* Start the Loop */
							while ( have_posts() ) : the_post();
								
								get_template_part( 'template-parts/post/content', get_post_format() );

							endwhile;

						else : ?>

							<p><?php echo esc_html(get_theme_mod('finance_accounting_no_search_result_content',__('Sorry, but nothing matched your search terms. Please try again with some different keywords.','finance-accounting')));?></p>
							<?php
								get_search_form();

						endif;
					?>
					<?php if( get_theme_mod( 'finance_accounting_show_post_pagination',true) != '') { ?>
						<div class="navigation">
			                <?php finance_accounting_pagination_type(); ?>
		       	 		</div>
		       	 	<?php } ?>
				</div>
				<div id="sidebox" class="col-lg-3 col-md-3">
					<?php dynamic_sidebar('sidebox-2'); ?>
				</div>
			<?php }else if($finance_accounting_layout_setting == 'Four Column'){ ?>
				<div id="sidebox" class="col-lg-3 col-md-3">
					<?php dynamic_sidebar('sidebar-1'); ?>
				</div>
				<div class="col-lg-3 col-md-3">
					<?php
						if ( have_posts() ) :

							/* Start the Loop */
							while ( have_posts() ) : the_post();
								
								get_template_part( 'template-parts/post/content', get_post_format() );

							endwhile;

						else : ?>

							<p><?php echo esc_html(get_theme_mod('finance_accounting_no_search_result_content',__('Sorry, but nothing matched your search terms. Please try again with some different keywords.','finance-accounting')));?></p>
							<?php
								get_search_form();

						endif;
					?>
					<?php if( get_theme_mod( 'finance_accounting_show_post_pagination',true) != '') { ?>
						<div class="navigation">
			                <?php finance_accounting_pagination_type(); ?>
		       	 		</div>
		       	 	<?php } ?>
				</div>
				<div id="sidebox" class="col-lg-3 col-md-3">
					<?php dynamic_sidebar('sidebox-2'); ?>
				</div>
				<div id="sidebox" class="col-lg-3 col-md-3">
					<?php dynamic_sidebar('sidebox-3'); ?>
				</div>
			<?php }else if($finance_accounting_layout_setting == 'Grid Layout'){ ?>
				<div class="col-lg-9 col-md-9">
					<div class="row">
						<?php
							if ( have_posts() ) :

								/* Start the Loop */
								while ( have_posts() ) : the_post();
									
									get_template_part( 'template-parts/post/gridlayout' );

								endwhile;

							else : ?>

								<p><?php echo esc_html(get_theme_mod('finance_accounting_no_search_result_content',__('Sorry, but nothing matched your search terms. Please try again with some different keywords.','finance-accounting')));?></p>
								<?php
									get_search_form();

							endif;
						?>
						<?php if( get_theme_mod( 'finance_accounting_show_post_pagination',true) != '') { ?>
							<div class="navigation">
				                <?php finance_accounting_pagination_type(); ?>
			       	 		</div>
			       	 	<?php } ?>
		       	 	</div>
				</div>
				<div id="sidebox" class="col-lg-3 col-md-3">
					<?php dynamic_sidebar('sidebar-1'); ?>
				</div>
			<?php }else {?>
				<div class="col-lg-8 col-md-8">
					<?php
						if ( have_posts() ) :

							/* Start the Loop */
							while ( have_posts() ) : the_post();
								
								get_template_part( 'template-parts/post/content', get_post_format() );

							endwhile;

						else : ?>

							<p><?php echo esc_html(get_theme_mod('finance_accounting_no_search_result_content',__('Sorry, but nothing matched your search terms. Please try again with some different keywords.','finance-accounting')));?></p>
							<?php
								get_search_form();

						endif;
					?>
					<?php if( get_theme_mod( 'finance_accounting_show_post_pagination',true) != '') { ?>
						<div class="navigation">
			                <?php finance_accounting_pagination_type(); ?>
		       	 		</div>
		       	 	<?php } ?>
				</div>
				<div id="sidebox" class="col-lg-4 col-md-4">
					<?php dynamic_sidebar('sidebar-1'); ?>
				</div>
			<?php } ?>
		</div>
	</div>
</main>

<?php get_footer();
