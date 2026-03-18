<?php
/**
 * Template Part: TGNE Footer Widgets
 * Location map, floating WhatsApp button, and dark/light theme toggle.
 * Ported from tgne-custom-header/test.html into the theme.
 *
 * Usage: get_template_part( 'template-parts/tgne-footer-widgets' );
 *        Called from footer.php just before </footer>
 *
 * @package MyTheme
 */
?>

<!-- TGNE Map / Location Section -->
<section id="location" aria-label="<?php esc_attr_e( 'Visit Us', 'my-theme' ); ?>">
    <div class="map-wrapper">

        <div class="map-info-col">

            <div class="slabel lb-orange"><?php esc_html_e( 'Find Us', 'my-theme' ); ?></div>

            <h2 class="stitle ondk">
                <?php esc_html_e( 'Visit', 'my-theme' ); ?>
                <span class="to">TGNE</span>
                <?php esc_html_e( 'Solutions', 'my-theme' ); ?>
            </h2>

            <p class="ssub ondk" style="max-width:380px;margin:0 0 32px;">
                <?php esc_html_e( 'Come see us in person — our team is ready to welcome you and discuss how we can help your business grow.', 'my-theme' ); ?>
            </p>

            <div class="map-items-wrap">

                <div class="map-item">
                    <div class="map-item-ic mi-orange" aria-hidden="true">📍</div>
                    <div>
                        <div class="map-item-label lb-orange"><?php esc_html_e( 'Address', 'my-theme' ); ?></div>
                        <div class="map-item-val"><?php esc_html_e( 'TGNE Solutions, Tema, Community 11, Ghana', 'my-theme' ); ?></div>
                    </div>
                </div>

                <div class="map-item">
                    <div class="map-item-ic mi-green" aria-hidden="true">📞</div>
                    <div>
                        <div class="map-item-label lb-green"><?php esc_html_e( 'Phone', 'my-theme' ); ?></div>
                        <div class="map-item-val">
                            <a href="tel:+233558122767" style="color:inherit;text-decoration:none;">+233 55 812 2767</a>
                        </div>
                    </div>
                </div>

                <div class="map-item">
                    <div class="map-item-ic mi-blue" aria-hidden="true">🕐</div>
                    <div>
                        <div class="map-item-label lb-blue"><?php esc_html_e( 'Opening Hours', 'my-theme' ); ?></div>
                        <div class="map-item-val"><?php esc_html_e( 'Mon–Fri: 8AM – 6PM · Sat: 9AM – 2PM', 'my-theme' ); ?></div>
                    </div>
                </div>

                <div class="map-item">
                    <div class="map-item-ic mi-orange" aria-hidden="true">📧</div>
                    <div>
                        <div class="map-item-label lb-orange"><?php esc_html_e( 'Email', 'my-theme' ); ?></div>
                        <div class="map-item-val">
                            <a href="mailto:info@tgnesolutions.com" style="color:inherit;text-decoration:none;">info@tgnesolutions.com</a>
                        </div>
                    </div>
                </div>

            </div><!-- .map-items-wrap -->

            <div style="margin-top:28px;">
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"
                   style="font-size:13.5px;padding:11px 22px;display:inline-flex;align-items:center;gap:8px;background:var(--lo,#FFA866);color:white;border-radius:10px;font-family:'Poppins',sans-serif;font-weight:700;text-decoration:none;">
                    &#128197;&nbsp;<?php esc_html_e( 'Book a Visit', 'my-theme' ); ?>
                </a>
            </div>

        </div><!-- .map-info-col -->

        <div class="map-iframe-col">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15883.4!2d-0.0167!3d5.6408!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfdf818b29a000001%3A0xa1b2c3d4e5f60001!2sTema%20Community%2011%2C%20Tema%2C%20Ghana!5e0!3m2!1sen!2sgh!4v1741000000000!5m2!1sen!2sgh"
                title="<?php esc_attr_e( 'TGNE Solutions location on Google Maps', 'my-theme' ); ?>"
                width="600"
                height="450"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
            <div class="map-badge" aria-hidden="true">
                <div class="mb-dot"></div>
                <span class="mb-text"><?php esc_html_e( 'TGNE Solutions, Tema, Ghana', 'my-theme' ); ?></span>
            </div>
        </div><!-- .map-iframe-col -->

    </div><!-- .map-wrapper -->
</section><!-- #location -->


<!-- TGNE Floating Widgets: WhatsApp + Theme Toggle -->
<div class="floating-widgets-container" aria-label="<?php esc_attr_e( 'Quick contact and theme options', 'my-theme' ); ?>">

    <button class="theme-toggle"
            id="tgne-theme-toggle"
            aria-label="<?php esc_attr_e( 'Toggle dark and light theme', 'my-theme' ); ?>"
            title="<?php esc_attr_e( 'Toggle Dark/Light Theme', 'my-theme' ); ?>">
        <span class="tt-icon tt-sun" aria-hidden="true">☀️</span>
        <span class="tt-icon tt-moon" aria-hidden="true">🌙</span>
    </button>

    <a href="https://wa.me/233558122767"
       class="float-btn float-wa"
       target="_blank"
       rel="noopener noreferrer"
       aria-label="<?php esc_attr_e( 'Chat with us on WhatsApp', 'my-theme' ); ?>">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
        <span><?php esc_html_e( 'Chat on WhatsApp', 'my-theme' ); ?></span>
    </a>

</div><!-- .floating-widgets-container -->
