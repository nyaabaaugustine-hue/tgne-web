<?php
/**
 * Template Part: Testimonials Section
 * @package MyTheme
 */
$testimonials = array(
    array(
        'stars' => 5,
        'text'  => 'TGNE Solutions delivered our full brand identity — logo, print materials, and website — in record time. The quality exceeded everything we expected. Highly recommended!',
        'name'  => 'Kwame Asante',
        'role'  => 'CEO, Accra Business Hub',
    ),
    array(
        'stars' => 5,
        'text'  => 'The event branding and backdrop prints for our conference were absolutely stunning. Professional service, beautiful work, fast delivery. Will use TGNE again without hesitation.',
        'name'  => 'Abena Mensah',
        'role'  => 'Events Director, GoldCoast Conferences',
    ),
    array(
        'stars' => 5,
        'text'  => 'Our custom branded souvenirs and award plaques were the highlight of our annual awards night. TGNE understood exactly what we needed and delivered perfection.',
        'name'  => 'Emmanuel Tetteh',
        'role'  => 'Managing Director, Tema Industrial Group',
    ),
);
?>
<section class="section testimonials-section" id="testimonials">
    <div class="container">
        <header class="section__header">
            <span class="section__label"><?php esc_html_e( 'Testimonials', 'my-theme' ); ?></span>
            <h2 class="section__title"><?php esc_html_e( 'What Our Clients Say', 'my-theme' ); ?></h2>
            <p class="section__desc"><?php esc_html_e( "Don't just take our word for it — hear from the businesses and organisations we've helped grow.", 'my-theme' ); ?></p>
        </header>
        <div class="grid grid--3">
            <?php foreach ( $testimonials as $t ) : ?>
                <article class="testimonial-card">
                    <div class="testimonial-card__stars" aria-label="<?php printf( esc_attr__( '%d out of 5 stars', 'my-theme' ), $t['stars'] ); ?>">
                        <?php echo str_repeat( '★', intval( $t['stars'] ) ); // phpcs:ignore ?>
                    </div>
                    <blockquote class="testimonial-card__text"><?php echo esc_html( $t['text'] ); ?></blockquote>
                    <div class="testimonial-card__author">
                        <div>
                            <div class="testimonial-card__name"><?php echo esc_html( $t['name'] ); ?></div>
                            <div class="testimonial-card__role"><?php echo esc_html( $t['role'] ); ?></div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
