<?php 
  $archive_year  = get_the_time('Y'); 
  $archive_month = get_the_time('m'); 
  $archive_day   = get_the_time('d'); 
?>
<?php
if ( ! function_exists( 'finance_accounting_related_posts_function' ) ) {
	function finance_accounting_related_posts_function() {
		wp_reset_postdata();
		global $post;

		// Define shared post arguments
		$args = array(
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'ignore_sticky_posts'    => 1,
			'orderby'                => 'rand',
			'post__not_in'           => array( $post->ID ),
			'posts_per_page'    => absint( get_theme_mod( 'finance_accounting_change_related_posts_number', '3' ) ),
		);
		// Related by categories
		if ( get_theme_mod( 'finance_accounting_show_related_post', 'categories' ) == 'categories' ) {

			$cats = get_post_meta( $post->ID, 'related-posts', true );

			if ( ! $cats ) {
				$cats                 = wp_get_post_categories( $post->ID, array( 'fields' => 'ids' ) );
				$args['category__in'] = $cats;
			} else {
				$args['cat'] = $cats;
			}
		}
		// Related by tags
		if ( get_theme_mod( 'finance_accounting_show_related_post', 'categories' ) == 'tags' ) {

			$tags = get_post_meta( $post->ID, 'related-posts', true );

			if ( ! $tags ) {
				$tags            = wp_get_post_tags( $post->ID, array( 'fields' => 'ids' ) );
				$args['tag__in'] = $tags;
			} else {
				$args['tag_slug__in'] = explode( ',', $tags );
			}
			if ( ! $tags ) {
				$break = true;
			}
		}

		$query = ! isset( $break ) ? new WP_Query( $args ) : new WP_Query();

		return $query;
	}
}

$related_posts = finance_accounting_related_posts_function(); ?>

<?php if ( $related_posts->have_posts() ): ?>

	<div class="related-posts clearfix">
		<?php if ( get_theme_mod('finance_accounting_change_related_post_title','Related Posts') != '' ) {?>
			<h2 class="related-posts-main-title"><?php echo esc_html( get_theme_mod('finance_accounting_change_related_post_title',__('Related Posts','finance-accounting')) ); ?></h2>
		<?php }?>
		<div class="row">
			<?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
				<div class="col-lg-4 col-md-4">
					<article class="page-box">
						<div class="category">
						  	<a href="<?php echo esc_url( get_permalink() ); ?>"><?php foreach((get_the_category()) as $category) { echo esc_html($category->cat_name) . ' '; } ?><span class="screen-reader-text"><?php esc_html_e( 'Category','finance-accounting' );?></span></a>
						</div>
						<h3><a href="<?php echo esc_url( get_permalink() );  ?>" title="<?php echo the_title_attribute(); ?>"><?php the_title();?><span class="screen-reader-text"><?php the_title(); ?></span></a></h3>
						<div class="post-image">
						    <?php
						      if(has_post_thumbnail() && get_theme_mod('finance_accounting_show_related_post_image',true) != '') {
						        the_post_thumbnail();
						      }
						    ?>
					 	</div>
						<div class="post-info mb-2">
							<?php if( get_theme_mod( 'finance_accounting_related_post_date_hide',true) != '') { ?>
								<span class="entry-date ps-2 pe-3"><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_post_date_icon_changer','fa fa-calendar'));?>"></i> <a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><?php echo esc_html( get_the_date() ); ?><span class="screen-reader-text"><?php echo esc_html( get_the_date() ); ?></span></a></span><?php echo esc_html( get_theme_mod('finance_accounting_blog_post_metabox_seperator') ); ?>
							<?php } ?>
							<?php if( get_theme_mod( 'finance_accounting_related_post_author_hide',true) != '') { ?>
								<span class="entry-author ps-2 pe-3"><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_post_author_icon_changer','fa fa-user'));?>"></i> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' )) ); ?>"><?php the_author(); ?><span class="screen-reader-text"><?php the_author(); ?></span></a></span><?php echo esc_html( get_theme_mod('finance_accounting_blog_post_metabox_seperator') ); ?>
							<?php } ?>
							<?php if( get_theme_mod( 'finance_accounting_related_post_comment_hide',true) != '') { ?>
								<i class="<?php echo esc_attr(get_theme_mod('finance_accounting_post_comment_icon_changer','fas fa-comments'));?> ps-2 pe-2"></i><span class="entry-comments ps-2 pe-2"><?php comments_number( __('0 Comments','finance-accounting'), __('0 Comments','finance-accounting'), __('% Comments','finance-accounting') ); ?></span>
							<?php } ?>
							<?php if( get_theme_mod( 'finance_accounting_related_post_time',true) != '') { ?>
							<span class="entry-time pe-2"><i class="<?php echo esc_attr(get_theme_mod('finance_accounting_post_time_icon_changer','fas fa-clock'));?>"></i> <?php echo esc_html( get_the_time() ); ?></span>
							<?php }?>
							<?php echo esc_html (finance_accounting_edit_link()); ?>
						</div>
				        <?php if(get_the_excerpt()) { ?>
					        <div class="text"><?php $finance_accounting_excerpt = get_the_excerpt(); echo esc_html( finance_accounting_string_limit_words( $finance_accounting_excerpt, esc_attr(get_theme_mod('finance_accounting_related_post_excerpt_number','20')))); ?><?php echo esc_html( get_theme_mod('finance_accounting_post_excerpt_suffix','{...}') ); ?></div>
					    <?php } ?>
					  	<?php if( get_theme_mod('finance_accounting_related_button_text','Continue Reading....') != ''){ ?>
					      <a class="post-link" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html(get_theme_mod('finance_accounting_related_button_text','Continue Reading....'));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('finance_accounting_related_button_text','Continue Reading....'));?></span></a>
					    <?php }?>
					</article>
				</div>
			<?php endwhile; ?>
		</div>

	</div><!--/.post-related-->
<?php endif; ?>

<?php wp_reset_postdata(); ?>
