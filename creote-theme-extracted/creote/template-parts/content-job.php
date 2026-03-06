<?php
/**
 * The template used for displaying single services content in single pages for custom Post tyes
 *
 * @package Creote wordpress theme
 */
$clerfix = 'clearfix col-lg-12';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($clerfix); ?>>

	<div class="entry-content pro ser clearfix">
		<?php the_content(); ?>
		<div class="clearfix"></div>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Service:', 'creote' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php wp_link_pages(); ?>
</article><!-- #post-## -->