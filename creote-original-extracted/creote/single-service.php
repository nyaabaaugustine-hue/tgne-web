<?php
/*
 *=================================
 * The Template for displaying all single Service Posts.
 * @package Creote WordPress Theme
 *==================================
*/
get_header(); ?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) { ?>
<div id="primary" class="content-area service <?php  creote_column_for_service(); ?>">
	<main id="main" class="site-main" role="main">
		<div class="row">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/content','service' ); ?>
			<?php endwhile; // end of the loop. ?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->
<?php   get_sidebar();?>
<?php } ?>
<?php get_footer(); ?>