<?php
/*
 *=================================
 * The Single template file .
 * @package Creote WordPress Theme
 *==================================
*/
get_header(); 
?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) { ?>
<div id="primary" class="content-area <?php creote_column_for_blog(); ?>">
	<main id="main" class="site-main" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', 'single' ); ?>
		<?php endwhile; // end of the loop. ?>
	</main><!-- #main -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php } ?>
<?php get_footer(); ?>