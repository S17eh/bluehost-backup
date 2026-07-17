<?php
/**
 * The template for displaying all single posts
 */
get_header(); ?>

<main id="main" role="main">
	<div class="container">
		<div class="row">
			<?php
		    $finance_accounting_single_post_sidebar_option = get_theme_mod( 'finance_accounting_single_post_sidebar_option','Right Sidebar');
			if($finance_accounting_single_post_sidebar_option == 'Left Sidebar'){ ?>
			    <div id="sidebox" class="col-lg-4 col-md-4">
					<?php get_sidebar(); ?>
				</div>
				<div class="col-lg-8 col-md-8">
					<?php if (get_theme_mod('finance_accounting_single_post_breadcrumb',false) != ''){ ?>
						<div class="breadcrumb">
							<?php finance_accounting_the_breadcrumb(); ?>
						</div>
					<?php }?>
					<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/post/single-post' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'finance-accounting' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
								'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'finance-accounting' ) . ' </span>%',
								'separator'   => '<span class="screen-reader-text">, </span>',
							) );?>

							<?php if( get_theme_mod( 'finance_accounting_show_single_post_pagination',true) != '') {

							the_post_navigation( array(
								'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'finance-accounting' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'finance-accounting' ) . '</span>',
								'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'finance-accounting' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'finance-accounting' ) . '</span>',
							) );
						}

						endwhile; // End of the loop.

					?>
				</div>
			<?php }else if($finance_accounting_single_post_sidebar_option == 'Right Sidebar'){ ?>
				<div class="col-lg-8 col-md-8">
					<?php if (get_theme_mod('finance_accounting_single_post_breadcrumb',false) != ''){ ?>
						<div class="breadcrumb">
							<?php finance_accounting_the_breadcrumb(); ?>
						</div>
					<?php }?>
					<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/post/single-post' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'finance-accounting' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
								'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'finance-accounting' ) . ' </span>%',
								'separator'   => '<span class="screen-reader-text">, </span>',
							) );?>

							<?php if( get_theme_mod( 'finance_accounting_show_single_post_pagination',true) != '') {

							the_post_navigation( array(
								'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'finance-accounting' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'finance-accounting' ) . '</span>',
								'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'finance-accounting' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'finance-accounting' ) . '</span>',
							) );
						}

						endwhile; // End of the loop.

					?>
				</div>
				<div id="sidebox" class="col-lg-4 col-md-4">
					<?php get_sidebar(); ?>
				</div>
			<?php }else if($finance_accounting_single_post_sidebar_option == 'One Column'){ ?>
				<div class="col-lg-12 col-md-12">
					<?php if (get_theme_mod('finance_accounting_single_post_breadcrumb',false) != ''){ ?>
						<div class="breadcrumb">
							<?php finance_accounting_the_breadcrumb(); ?>
						</div>
					<?php }?>
					<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/post/single-post' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'finance-accounting' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
								'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'finance-accounting' ) . ' </span>%',
								'separator'   => '<span class="screen-reader-text">, </span>',
							) );?>

							<?php if( get_theme_mod( 'finance_accounting_show_single_post_pagination',true) != '') {

							the_post_navigation( array(
								'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'finance-accounting' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'finance-accounting' ) . '</span>',
								'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'finance-accounting' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'finance-accounting' ) . '</span>',
							) );
						}

						endwhile; // End of the loop.

					?>
				</div>
			<?php }else {?>
				<div class="col-lg-8 col-md-8">
					<?php if (get_theme_mod('finance_accounting_single_post_breadcrumb',false) != ''){ ?>
						<div class="breadcrumb">
							<?php finance_accounting_the_breadcrumb(); ?>
						</div>
					<?php }?>
					<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/post/single-post' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'finance-accounting' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
								'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'finance-accounting' ) . ' </span>%',
								'separator'   => '<span class="screen-reader-text">, </span>',
							) );?>

							<?php if( get_theme_mod( 'finance_accounting_show_single_post_pagination',true) != '') {

							the_post_navigation( array(
								'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'finance-accounting' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'finance-accounting' ) . '</span>',
								'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'finance-accounting' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'finance-accounting' ) . '</span>',
							) );
						}

						endwhile; // End of the loop.

					?>
				</div>
				<div id="sidebox" class="col-lg-4 col-md-4">
					<?php dynamic_sidebar('sidebar-1'); ?>
				</div>
			<?php }?>
		</div>
	</div>
</main>

<?php get_footer();
