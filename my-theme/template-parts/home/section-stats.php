<?php
/**
 * Template Part: Stats Section
 * @package MyTheme
 */
$stats = array(
    array( 'number' => '500+', 'label' => 'Projects Delivered' ),
    array( 'number' => '98%',  'label' => 'Client Satisfaction' ),
    array( 'number' => '12+',  'label' => 'Years Experience' ),
    array( 'number' => '50+',  'label' => 'Expert Team Members' ),
);
?>
<section class="section stats-section" id="stats" aria-label="<?php esc_attr_e( 'Our Statistics', 'my-theme' ); ?>">
    <div class="container">
        <div class="grid grid--4">
            <?php foreach ( $stats as $stat ) : ?>
                <div class="stat-item">
                    <div class="stat-item__number" aria-label="<?php echo esc_attr( $stat['number'] ); ?>">
                        <?php echo esc_html( $stat['number'] ); ?>
                    </div>
                    <p class="stat-item__label"><?php echo esc_html( $stat['label'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
