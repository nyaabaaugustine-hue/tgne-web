<?php
/*
 *=================================
 * The main template file .
 * @package Creote WordPress Theme
 *==================================
*/
get_header(); 

?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) { ?>
<div id="primary" class="content-area   <?php creote_column_for_blog(); ?>">
	<main id="main" class="site-main" role="main">
	 <div class="row grid_layout clearfix">
		<?php if( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
					/* Include the Post-Format-specific template for the content.
					 * ifyou want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part('template-parts/content-blog');
				?>
			<?php endwhile; ?>
		<?php else : ?>
			<?php get_template_part('template-parts/content', 'none'); ?>
		<?php endif; ?>
		</div>
		<div class="row">
		  <div class="col-lg-12">
			<?php creote_numeric_posts_nav(); ?>
		</div>
	</div>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php } ?>
<?php get_footer(); ?>