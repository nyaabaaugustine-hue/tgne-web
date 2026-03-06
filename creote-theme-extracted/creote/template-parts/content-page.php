<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package creote wordpress theme
 */
$clerfix = 'clearfix';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($clerfix); ?>>
	<div class="entry-content clearfix">
		<?php the_content(); ?>
		<div class="clearfix"></div>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'creote' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php // creote_edit_post_link(); ?>
</article><!-- #post-## -->