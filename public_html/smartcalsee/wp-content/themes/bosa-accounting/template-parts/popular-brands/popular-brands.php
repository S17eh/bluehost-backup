<?php
$popularbrandoneID = get_theme_mod( 'brands_image_one', '' );
$popularbrandcategoryone = get_theme_mod( 'brand_category_one', '' );

$popularbrandtwoID = get_theme_mod( 'brands_image_two','');
$popularbrandcategorytwo = get_theme_mod( 'brand_category_two', '' );

$popularbrandthreeID = get_theme_mod( 'brands_image_three', '' );
$popularbrandcategorythree = get_theme_mod( 'brand_category_three', '' );

$popularbrandfourID = get_theme_mod( 'brands_image_four', '' );
$popularbrandcategoryfour = get_theme_mod( 'brand_category_four', '' );

$popularbrandfiveID = get_theme_mod( 'brands_image_five', '' );
$popularbrandcategoryfive = get_theme_mod( 'brand_category_five', '' );

$popularbrandsixID = get_theme_mod( 'brands_image_six', '' );
$popularbrandcategorysix = get_theme_mod( 'brand_category_six', '' );


$popular_brand_array = array();
$has_brands = false;
if( !empty( $popularbrandoneID ) || !empty( $popularbrandcategoryone ) ){
	$popular_brand_one  = wp_get_attachment_image_src( $popularbrandoneID ,'bosa-420-300');
 	if ( is_array(  $popular_brand_one ) ){
 		$has_brands = true;
   	 	$popular_brands_one = $popular_brand_one[0];
   	 	$popular_brand_array['image_one'] ['ID'] = $popular_brands_one;	 	
  	}
  	if ( !empty($popularbrandcategoryone) ){
 		$has_brands = true;
   	 	$popular_brand_array['image_one']['category'] = $popularbrandcategoryone;	
  	}
}
if( !empty( $popularbrandtwoID ) || !empty( $popularbrandcategorytwo ) ){
	$popular_brand_two = wp_get_attachment_image_src( $popularbrandtwoID,'bosa-420-300');
	if ( is_array(  $popular_brand_two ) ){
		$has_brands = true;	
        $popular_brands_two = $popular_brand_two[0];
        $popular_brand_array['image_two'] ['ID']= $popular_brands_two; 
	}
	if ( !empty($popularbrandcategorytwo) ){
		$has_brands = true;
	 	$popular_brand_array['image_two']['category'] = $popularbrandcategorytwo;	
  	}
}
if( !empty( $popularbrandthreeID ) || !empty( $popularbrandcategorythree ) ){	
	$popular_brand_three = wp_get_attachment_image_src( $popularbrandthreeID,'bosa-420-300');
	if ( is_array(  $popular_brand_three ) ){
		$has_brands = true;
      	$popular_brands_three = $popular_brand_three[0];
      	$popular_brand_array['image_three'] ['ID']= $popular_brands_three;		
  	}
  	if ( !empty($popularbrandcategorythree) ){
		$has_brands = true;
	 	$popular_brand_array['image_three'] ['category'] = $popularbrandcategorythree;	
  	}
}
if( !empty( $popularbrandfourID ) || !empty( $popularbrandcategoryfour ) ){	
	$popular_brand_four = wp_get_attachment_image_src( $popularbrandfourID,'bosa-420-300');
	if ( is_array(  $popular_brand_four ) ){
		$has_brands = true;
      	$popular_brands_four = $popular_brand_four[0];
      	$popular_brand_array['image_four'] ['ID'] = $popular_brands_four;	
  	}
  	if ( !empty($popularbrandcategoryfour) ){
		$has_brands = true;
	 	$popular_brand_array['image_four'] ['category'] = $popularbrandcategoryfour;	
  	}
}
if( !empty( $popularbrandfiveID ) || !empty( $popularbrandcategoryfive ) ){	
	$popular_brand_five = wp_get_attachment_image_src( $popularbrandfiveID,'bosa-420-300');
	if ( is_array(  $popular_brand_five ) ){
		$has_brands = true;
      	$popular_brands_five = $popular_brand_five[0];
      	$popular_brand_array['image_five'] ['ID'] = $popular_brands_five;	
  	}
  	if ( !empty($popularbrandcategoryfive) ){
		$has_brands = true;
	 	$popular_brand_array['image_five'] ['category'] = $popularbrandcategoryfive;	
  	}
}
if( !empty( $popularbrandsixID ) || !empty( $popularbrandcategorysix ) ){	
	$popular_brand_six = wp_get_attachment_image_src( $popularbrandsixID,'bosa-420-300');
	if ( is_array(  $popular_brand_six ) ){
		$has_brands = true;
      	$popular_brands_six = $popular_brand_six[0];
      	$popular_brand_array['image_six'] ['ID'] = $popular_brands_six;	
  	}
  	if ( !empty($popularbrandcategorysix) ){
		$has_brands = true;
	 	$popular_brand_array['image_six'] ['category'] = $popularbrandcategorysix;	
  	}
}

$product_cat = bosa_accounting_get_product_categories();

if( !get_theme_mod( 'disable_popular_brands_section', true ) && ( $has_brands || get_theme_mod('popular_brands_title') || get_theme_mod('popular_brands_sub_title') ) ){ ?>
	<section class="section-popular-area">
		<?php if( get_theme_mod('popular_brands_title') || get_theme_mod('popular_brands_sub_title') ){ ?>
			<div class="section-title-wrap col-lg-6 col-md-8 offset-lg-3 offset-md-2">
				<h2 class="section-title">	
					<?php echo esc_html( get_theme_mod('popular_brands_title') ); ?>
				</h2>
				<p>
					<?php echo esc_html( get_theme_mod('popular_brands_sub_title') ); ?>
				</p>
			</div>
		<?php } ?>
		<div class="content-wrap">
			<?php foreach( $popular_brand_array as $each_popularbrand ){ ?>
				<article class="popular-items">
					<?php if ( isset( $each_popularbrand['ID'] )  && !empty( $each_popularbrand['ID'] ) ){ 
							$cat_url = '';
							if( isset( $each_popularbrand['category'] ) && !empty( $each_popularbrand['category'] ) ) {
								$cat_url = $each_popularbrand['category'];
							}
						?>
						<figure class= "featured-image">
							<a href="<?php echo esc_url( get_category_link( $cat_url ) ); ?>">
								<img src="<?php echo esc_url( $each_popularbrand['ID'] ); ?>">
							</a>	
						</figure>
					<?php } ?>
					<?php if ( isset( $each_popularbrand['category'] ) && !empty( $each_popularbrand['category'] ) ){ ?>
						<h5 class="entry-title">
							<a href="<?php echo esc_url( get_category_link( $each_popularbrand ['category'] ) ); ?>">
								<?php echo esc_html($product_cat[$each_popularbrand['category'] ] ); ?>
							</a>	
						</h5>
					<?php } ?>
				</article>	
			<?php } ?>
		</div>
	</section>
<?php } ?>

