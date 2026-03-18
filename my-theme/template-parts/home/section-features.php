<?php
/**
 * Template Part: Features Section
 * @package MyTheme
 */
$features = array(
    array( 'icon' => 'fa-solid fa-palette',       'title' => 'Creative Design',     'desc' => 'Logos, flyers, event branding, vehicle wraps, and full brand identity systems crafted with precision.' ),
    array( 'icon' => 'fa-solid fa-print',          'title' => 'Premium Printing',    'desc' => 'Offset and digital prints, apparel, branded souvenirs, and award plaques — all with fast turnaround.' ),
    array( 'icon' => 'fa-solid fa-laptop-code',    'title' => 'Web & Technology',    'desc' => 'Modern, fast websites and digital solutions tailored to your business needs and goals.' ),
    array( 'icon' => 'fa-solid fa-graduation-cap', 'title' => 'Training & Education','desc' => 'ICT training, AI education, and professional development programmes for individuals and organisations.' ),
    array( 'icon' => 'fa-solid fa-gauge-high',     'title' => 'Fast Delivery',       'desc' => 'Same-day digital prints, quick project turnarounds, and reliable delivery you can count on.' ),
    array( 'icon' => 'fa-solid fa-headset',        'title' => '24/7 Support',        'desc' => 'Dedicated support available via phone and WhatsApp to keep your projects moving at all times.' ),
);
?>
<section class="section section--alt features-section" id="features">
    <div class="container">
        <header class="section__header">
            <span class="section__label"><?php esc_html_e( 'Why Choose TGNE', 'my-theme' ); ?></span>
            <h2 class="section__title"><?php esc_html_e( 'Everything Your Brand Needs', 'my-theme' ); ?></h2>
            <p class="section__desc"><?php esc_html_e( 'From concept to delivery, we combine creativity, technology, and expertise to produce results that exceed expectations.', 'my-theme' ); ?></p>
        </header>
        <div class="grid grid--3">
            <?php foreach ( $features as $feature ) : ?>
                <article class="feature-card">
                    <div class="feature-card__icon" aria-hidden="true">
                        <i class="<?php echo esc_attr( $feature['icon'] ); ?>"></i>
                    </div>
                    <h3 class="feature-card__title"><?php echo esc_html( $feature['title'] ); ?></h3>
                    <p class="feature-card__desc"><?php echo esc_html( $feature['desc'] ); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
