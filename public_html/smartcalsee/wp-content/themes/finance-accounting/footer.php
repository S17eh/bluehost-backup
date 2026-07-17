<?php
/**
 * The template for displaying the footer
 */

?>
<footer id="colophon" class="site-footer mt-4" role="contentinfo">
	<div class="container">
		<?php get_template_part( 'template-parts/footer/footer', 'widgets' );?>
	</div>
</footer>
<?php get_template_part( 'template-parts/footer/site', 'info' );?>
<?php wp_footer(); ?>
</body>
</html>