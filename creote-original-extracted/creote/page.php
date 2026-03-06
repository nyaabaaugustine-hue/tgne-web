<?php
/*
 *=================================
 * The page template file .
 * @package Creote WordPress Theme
 *==================================
*/
get_header(); ?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) { ?>
	<div id="primary" class="content-area  <?php creote_column_for_page(); ?>">
		<main id="main" class="site-main" role="main">
			<div class="row">
			
			<?php while(have_posts()) : the_post(); ?>
			
				<?php get_template_part('template-parts/content', 'page'); ?>
				<div class="col-lg-12 padding_zero">
				<?php
					// ifcomments are open or we have at least one comment, load up the comment template
					if(comments_open() || get_comments_number()) :
						comments_template();
					endif;
				?>
				</div>
			<?php endwhile; ?>
	
		</div><!-- #row -->
		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php } ?>
<?php get_footer(); ?>