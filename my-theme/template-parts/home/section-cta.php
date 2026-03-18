<?php
/**
 * Template Part: CTA Section
 * @package MyTheme
 */
?>
<section class="section cta-section">
    <div class="container">
        <div class="cta-banner">
            <span class="section__label" style="color:rgba(255,255,255,0.8);">
                <?php esc_html_e( 'Ready to Start?', 'my-theme' ); ?>
            </span>
            <h2><?php esc_html_e( "Let's Build Something Amazing Together", 'my-theme' ); ?></h2>
            <p><?php esc_html_e( 'From logo to launch, TGNE Solutions is your complete creative and technology partner. Get your free consultation today.', 'my-theme' ); ?></p>
            <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--white btn--lg">
                    <?php esc_html_e( 'Get a Free Quote', 'my-theme' ); ?>
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
                <a href="tel:+233558122767" class="btn btn--lg" style="color:#fff;border-color:rgba(255,255,255,0.4);background:rgba(255,255,255,0.1);">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                    +233 55 812 2767
                </a>
            </div>
        </div>
    </div>
</section>
