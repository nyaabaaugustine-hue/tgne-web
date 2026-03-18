<?php
/**
 * Single view Company information box
 *
 * Hooked into single_job_listing_start priority 30
 *
 * This template can be overridden by copying it to yourtheme/job_manager/content-single-job_listing-company.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager
 * @category    Template
 * @since       1.14.0
 * @version     1.32.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! get_the_company_name() ) {
	return;
}
?>
<div class="company">
	<div class="com_inner">
	
	<?php the_company_logo(); ?>

<div class="comp_content">
	<ul class="list_meta">
		<?php if ( $website = get_the_company_website() ) : ?>
			<li><a class="website" href="<?php echo esc_url( $website ); ?>" rel="nofollow"><?php esc_html_e( 'Website', 'creote' ); ?></a></li>
		<?php endif; ?>

		<?php the_company_twitter('<li>', '</li>'); ?>

	</ul>
	<h2><?php the_company_name(); ?></h2>
	<?php if(!empty(the_company_tagline())): ?>
	<p class="tagline"><?php the_company_tagline(); ?></p>
	<?php endif; ?>
	</div>
	</div>
	<?php the_company_video(); ?>
</div>
