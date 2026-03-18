<?php
/**
 * TGNE Custom Header — Theme Integration
 *
 * Ported from tgne-custom-header plugin (v5.0.0) into MyTheme.
 * Zero plugin dependency — all hooks run through the theme.
 *
 * Sections:
 *  1. Global flag (print once)
 *  2. Elementor Canvas enforcement (3 hooks)
 *  3. Enqueue: Poppins font + inline CSS + inline JS
 *  4. wp_head overrides at priority 9999
 *  5. tgne_render_header() — called from header.php
 *  6. HTML template
 *  7. CSS
 *  8. JS
 *
 * @package MyTheme
 * @version 5.0.0
 */

defined( 'ABSPATH' ) || exit;

/* ─────────────────────────────────────────────────────
   1. GLOBAL FLAG — only ever print header once
───────────────────────────────────────────────────── */
global $tgne_header_done;
$tgne_header_done = false;

/* ─────────────────────────────────────────────────────
   2. ELEMENTOR CANVAS ENFORCEMENT
───────────────────────────────────────────────────── */

// On every page save
add_action( 'save_post', 'tgne_canvas_on_save', 999 );
function tgne_canvas_on_save( $id ) {
    if ( wp_is_post_revision( $id ) || wp_is_post_autosave( $id ) ) return;
    if ( get_post_type( $id ) !== 'page' ) return;
    if ( get_post_meta( $id, '_elementor_edit_mode', true ) !== 'builder' ) return;
    remove_action( 'save_post', 'tgne_canvas_on_save', 999 );
    update_post_meta( $id, '_wp_page_template', 'elementor_canvas' );
    add_action( 'save_post', 'tgne_canvas_on_save', 999 );
}

// On every page load — silently fix if wrong
add_action( 'wp', 'tgne_canvas_on_wp' );
function tgne_canvas_on_wp() {
    if ( ! is_singular( 'page' ) ) return;
    $id = get_the_ID();
    if ( ! $id ) return;
    if ( get_post_meta( $id, '_elementor_edit_mode', true ) !== 'builder' ) return;
    if ( get_post_meta( $id, '_wp_page_template', true ) !== 'elementor_canvas' ) {
        update_post_meta( $id, '_wp_page_template', 'elementor_canvas' );
    }
}

// Force canvas template file at render time
add_filter( 'template_include', 'tgne_canvas_template_include', 9999 );
function tgne_canvas_template_include( $tpl ) {
    if ( ! is_singular() ) return $tpl;
    $id = get_the_ID();
    if ( ! $id ) return $tpl;
    if ( get_post_meta( $id, '_elementor_edit_mode', true ) !== 'builder' ) return $tpl;
    $paths = array(
        WP_PLUGIN_DIR . '/elementor/modules/page-templates/templates/canvas.php',
        WP_PLUGIN_DIR . '/elementor-pro/modules/page-templates/templates/canvas.php',
    );
    foreach ( $paths as $p ) {
        if ( file_exists( $p ) ) return $p;
    }
    return $tpl;
}

/* ─────────────────────────────────────────────────────
   3. ENQUEUE — Poppins font + inline CSS + inline JS
───────────────────────────────────────────────────── */

add_action( 'wp_enqueue_scripts', 'tgne_enqueue_assets', 20 );
function tgne_enqueue_assets() {
    wp_enqueue_style(
        'tgne-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500&display=swap',
        array(), null
    );
    wp_add_inline_style( 'my-theme-style', tgne_get_css() );
    wp_add_inline_script( 'my-theme-main', tgne_get_js() );
}

/* ─────────────────────────────────────────────────────
   4. wp_head OVERRIDES (priority 9999)
───────────────────────────────────────────────────── */

add_action( 'wp_head', 'tgne_head_overrides', 9999 );
function tgne_head_overrides() { ?>
<style id="tgne-overrides">
html,body{margin-top:0!important}
body{padding-top:115px!important}
header.site-header,.site-header,#masthead,#site-header,#header,
.header-area,header#header,.main-header,.header-main,.header-wrapper,
.nav-header,[data-elementor-type="header"],.elementor-location-header,
body>header:first-of-type{display:none!important;height:0!important;overflow:hidden!important}
#tgne-prog{display:block!important;visibility:visible!important;position:fixed!important;top:0;left:0;right:0;z-index:100000!important;height:3px!important}
#tgne-ann{display:flex!important;visibility:visible!important;position:fixed!important;top:3px!important;left:0;right:0;z-index:99999!important;height:auto!important}
#tgne-nav{display:flex!important;visibility:visible!important;position:fixed!important;top:37px!important;left:0!important;right:0!important;height:74px!important;z-index:99998!important;align-items:center!important;justify-content:space-between!important;padding:0 5%!important;background:rgba(6,27,51,.6)!important;backdrop-filter:blur(22px)!important;-webkit-backdrop-filter:blur(22px)!important;border-bottom:1px solid rgba(255,255,255,.07)!important;box-sizing:border-box!important;transform:none!important;opacity:1!important;overflow:visible!important}
#tgne-nav.tn-scrolled{background:rgba(6,27,51,.97)!important;box-shadow:0 4px 40px rgba(0,0,0,.35)!important;top:0!important}
#tgne-nav.tn-hidden{transform:translateY(-200%)!important}
#hero-slider{position:relative!important;display:block!important;width:100vw!important;max-width:none!important;margin-left:calc(-50vw + 50%)!important;margin-right:calc(-50vw + 50%)!important;height:calc(100vh - 115px)!important;min-height:560px!important;overflow:hidden!important;margin-top:0!important;box-sizing:border-box!important}
#hero-slider .hs-track{display:flex!important;flex-direction:row!important;flex-wrap:nowrap!important;height:100%!important;width:100%!important;will-change:transform!important}
#hero-slider .hs-slide{flex:0 0 100%!important;min-width:100%!important;max-width:100%!important;width:100%!important;height:100%!important;position:relative!important;display:flex!important;align-items:center!important;overflow:hidden!important}
</style>
<?php }

/* ─────────────────────────────────────────────────────
   5. PUBLIC RENDER FUNCTION — called from header.php
───────────────────────────────────────────────────── */

function tgne_render_header() {
    global $tgne_header_done;
    if ( $tgne_header_done ) return;
    $tgne_header_done = true;
    echo tgne_get_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/* ─────────────────────────────────────────────────────
   6. HTML TEMPLATE
───────────────────────────────────────────────────── */

function tgne_get_html() {
    $home    = esc_url( home_url( '/' ) );
    $logo    = 'https://res.cloudinary.com/dwsl2ktt2/image/upload/v1773810792/cyber_rj2j14.png';
    $wa      = 'https://wa.me/233558122767';
    $contact = esc_url( home_url( '/contact/' ) );
    $is_home = is_front_page() || is_home();
    $is_con  = is_page( 'contact' );
    $is_shop = is_page( 'shop' ) || ( function_exists( 'is_shop' ) && is_shop() );
    ob_start();
?>
<!-- TGNE Header v5.0.0 -->
<div id="tgne-prog"><div id="tgne-prog-fill"></div></div>

<div id="tgne-ann">
    <div class="ta-in">
        <div class="ta-l">
            <span class="ta-dot"></span>
            <span class="ta-pill">New</span>
            <span>AI Solutions &amp; Automation are now live &mdash; <a href="https://cybertechgh.netlify.app" target="_blank" rel="noopener">See Preview &rarr;</a></span>
        </div>
        <div class="ta-r">
            <a class="ta-lk" href="tel:+233558122767">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.18 1.18 2 2 0 012.18 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.91 7.09a16 16 0 006 6l.91-.91a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                +233 55 812 2767
            </a>
            <span class="ta-sp"></span>
            <a class="ta-lk" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener noreferrer">&#128172; WhatsApp</a>
        </div>
    </div>
</div>

<nav id="tgne-nav" role="navigation" aria-label="<?php esc_attr_e( 'Main navigation', 'my-theme' ); ?>">

    <a href="<?php echo $home; ?>" class="tn-logo" aria-label="<?php esc_attr_e( 'TGNE Solutions — Home', 'my-theme' ); ?>">
        <div class="tn-lw">
            <img src="<?php echo esc_url( $logo ); ?>" alt="<?php esc_attr_e( 'TGNE Solutions', 'my-theme' ); ?>" width="44" height="44" loading="eager"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
            <div class="tn-lfb" style="display:none" aria-hidden="true">TGNE</div>
            <span class="tn-lg" aria-hidden="true"></span>
        </div>
        <div class="tn-lt">
            <strong>TGNE <em>Solutions</em></strong>
            <small>Technology &middot; Graphics &middot; Education</small>
        </div>
    </a>

    <ul class="tn-nav" role="list">
        <li><a href="<?php echo $home; ?>"<?php echo $is_home ? ' class="tn-cur" aria-current="page"' : ''; ?>><?php esc_html_e( 'Home', 'my-theme' ); ?></a></li>

        <li class="tn-dd">
            <button class="tn-db" aria-haspopup="true" aria-expanded="false"><?php esc_html_e( 'About', 'my-theme' ); ?>
                <svg class="tn-ch" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="tn-dp tn-dp-sm" role="menu">
                <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="tn-di" role="menuitem">
                    <span class="tn-ic tn-c1" aria-hidden="true">&#127970;</span>
                    <span class="tn-dt"><strong><?php esc_html_e( 'About TGNE', 'my-theme' ); ?></strong><small><?php esc_html_e( 'Who we are & our story', 'my-theme' ); ?></small></span>
                </a>
                <hr class="tn-hr">
                <a href="<?php echo esc_url( home_url( '/our-approach/' ) ); ?>" class="tn-di" role="menuitem">
                    <span class="tn-ic tn-c2" aria-hidden="true">&#127919;</span>
                    <span class="tn-dt"><strong><?php esc_html_e( 'Our Approach', 'my-theme' ); ?></strong><small><?php esc_html_e( 'How we work & our values', 'my-theme' ); ?></small></span>
                </a>
            </div>
        </li>

        <li class="tn-dd">
            <button class="tn-db" aria-haspopup="true" aria-expanded="false"><?php esc_html_e( 'Graphics, Print & Souvenirs', 'my-theme' ); ?>
                <svg class="tn-ch" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="tn-dp tn-dp-lg" role="menu">
                <div class="tn-mega">
                    <div class="tn-mf">
                        <span class="tn-ml"><?php esc_html_e( 'Creative Studio', 'my-theme' ); ?></span>
                        <p class="tn-mt"><?php esc_html_e( 'Graphics, Print', 'my-theme' ); ?> <strong>&amp; <?php esc_html_e( 'Souvenirs', 'my-theme' ); ?></strong></p>
                        <p class="tn-md"><?php esc_html_e( 'Logo design, event branding, premium printing, branded merchandise and award plaques.', 'my-theme' ); ?></p>
                        <a href="<?php echo esc_url( home_url( '/home/' ) ); ?>" class="tn-mb"><?php esc_html_e( 'Browse All →', 'my-theme' ); ?></a>
                    </div>
                    <div class="tn-mc">
                        <span class="tn-mh"><?php esc_html_e( 'Design', 'my-theme' ); ?></span>
                        <a href="<?php echo esc_url( home_url( '/creatives/' ) ); ?>" class="tn-mi" role="menuitem"><span class="tn-ic tn-c1" aria-hidden="true">&#127912;</span><span class="tn-mx"><strong><?php esc_html_e( 'Creatives', 'my-theme' ); ?></strong><small><?php esc_html_e( 'Flyers, posters & graphics', 'my-theme' ); ?></small></span></a>
                        <a href="<?php echo esc_url( home_url( '/logos/' ) ); ?>" class="tn-mi" role="menuitem"><span class="tn-ic tn-c5" aria-hidden="true">&#11088;</span><span class="tn-mx"><strong><?php esc_html_e( 'Logos', 'my-theme' ); ?></strong><small><?php esc_html_e( 'Brand identity & logo design', 'my-theme' ); ?></small></span></a>
                        <a href="<?php echo esc_url( home_url( '/graphic-design/' ) ); ?>" class="tn-mi" role="menuitem"><span class="tn-ic tn-c4" aria-hidden="true">&#128187;</span><span class="tn-mx"><strong><?php esc_html_e( 'Digital Design', 'my-theme' ); ?></strong><small><?php esc_html_e( 'Social media & web graphics', 'my-theme' ); ?></small></span></a>
                        <a href="<?php echo esc_url( home_url( '/event-vehicle-branding/' ) ); ?>" class="tn-mi" role="menuitem"><span class="tn-ic tn-c3" aria-hidden="true">&#127882;</span><span class="tn-mx"><strong><?php esc_html_e( 'Event Branding', 'my-theme' ); ?></strong><small><?php esc_html_e( 'Backdrops, banners & programmes', 'my-theme' ); ?></small></span></a>
                    </div>
                    <div class="tn-mc">
                        <span class="tn-mh"><?php esc_html_e( 'Print & Souvenirs', 'my-theme' ); ?></span>
                        <a href="<?php echo esc_url( home_url( '/offset-prints/' ) ); ?>" class="tn-mi" role="menuitem"><span class="tn-ic tn-c2" aria-hidden="true">&#128438;</span><span class="tn-mx"><strong><?php esc_html_e( 'Offset Prints', 'my-theme' ); ?></strong><small><?php esc_html_e( 'High-volume printing', 'my-theme' ); ?></small></span></a>
                        <a href="<?php echo esc_url( home_url( '/printing/' ) ); ?>" class="tn-mi" role="menuitem"><span class="tn-ic tn-c4" aria-hidden="true">&#9889;</span><span class="tn-mx"><strong><?php esc_html_e( 'Digital Prints', 'my-theme' ); ?></strong><small><?php esc_html_e( 'Fast short-run & same-day', 'my-theme' ); ?></small></span></a>
                        <a href="<?php echo esc_url( home_url( '/apparel-prints/' ) ); ?>" class="tn-mi" role="menuitem"><span class="tn-ic tn-c3" aria-hidden="true">&#128085;</span><span class="tn-mx"><strong><?php esc_html_e( 'Apparel Prints', 'my-theme' ); ?></strong><small><?php esc_html_e( 'T-shirts, polos & uniforms', 'my-theme' ); ?></small></span></a>
                        <a href="<?php echo esc_url( home_url( '/branded-souvenirs/' ) ); ?>" class="tn-mi" role="menuitem"><span class="tn-ic tn-c6" aria-hidden="true">&#127873;</span><span class="tn-mx"><strong><?php esc_html_e( 'Branded Souvenirs', 'my-theme' ); ?></strong><small><?php esc_html_e( 'Gifts & merchandise', 'my-theme' ); ?></small></span></a>
                        <a href="<?php echo esc_url( home_url( '/award-plaques/' ) ); ?>" class="tn-mi" role="menuitem"><span class="tn-ic tn-c5" aria-hidden="true">&#127942;</span><span class="tn-mx"><strong><?php esc_html_e( 'Award Plaques', 'my-theme' ); ?></strong><small><?php esc_html_e( 'Trophies & plaques', 'my-theme' ); ?></small></span></a>
                    </div>
                </div>
            </div>
        </li>

        <li><a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>"<?php echo $is_shop ? ' class="tn-cur" aria-current="page"' : ''; ?>><?php esc_html_e( 'Shop', 'my-theme' ); ?></a></li>
        <li><a href="<?php echo $contact; ?>"<?php echo $is_con ? ' class="tn-cur" aria-current="page"' : ''; ?>><?php esc_html_e( 'Contact', 'my-theme' ); ?></a></li>
    </ul>

    <div class="tn-acts">
        <button id="tn-sb" aria-label="<?php esc_attr_e( 'Search', 'my-theme' ); ?>">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </button>
        <a href="<?php echo $contact; ?>" class="tn-cta"><span class="tn-cd" aria-hidden="true"></span><?php esc_html_e( 'Get a Quote', 'my-theme' ); ?></a>
        <button id="tn-bg" class="tn-bg" aria-label="<?php esc_attr_e( 'Open menu', 'my-theme' ); ?>" aria-expanded="false" aria-controls="tn-dr">
            <span></span><span></span><span></span>
        </button>
    </div>

</nav>

<div id="tn-sov" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Site search', 'my-theme' ); ?>">
    <div class="tn-sb2">
        <label class="tn-sl" for="tn-si"><?php esc_html_e( 'Search TGNE Solutions', 'my-theme' ); ?></label>
        <div class="tn-sbar">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#B0C4D8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input id="tn-si" type="search" placeholder="<?php esc_attr_e( 'Search services, products, blog...', 'my-theme' ); ?>" autocomplete="off" aria-label="<?php esc_attr_e( 'Search query', 'my-theme' ); ?>">
            <button id="tn-sc" aria-label="<?php esc_attr_e( 'Close search', 'my-theme' ); ?>">&#215;</button>
        </div>
        <p class="tn-sh"><?php esc_html_e( 'Press', 'my-theme' ); ?> <kbd>Enter</kbd> <?php esc_html_e( 'to search', 'my-theme' ); ?> &middot; <kbd>Esc</kbd> <?php esc_html_e( 'to close', 'my-theme' ); ?></p>
    </div>
</div>

<div id="tn-ov" aria-hidden="true"></div>

<div id="tn-dr" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Navigation menu', 'my-theme' ); ?>">
    <div class="tn-dh">
        <a href="<?php echo $home; ?>" class="tn-dlogo">
            <img src="<?php echo esc_url( $logo ); ?>" alt="<?php esc_attr_e( 'TGNE', 'my-theme' ); ?>" width="36" height="36" loading="lazy"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
            <div class="tn-lfb" style="display:none;width:36px;height:36px;font-size:9px" aria-hidden="true">TGNE</div>
            <span>TGNE <em>Solutions</em></span>
        </a>
        <button id="tn-dc" aria-label="<?php esc_attr_e( 'Close menu', 'my-theme' ); ?>">&#215;</button>
    </div>
    <div class="tn-db2">
        <ul class="tn-mul">
            <li><a href="<?php echo $home; ?>"><?php esc_html_e( 'Home', 'my-theme' ); ?></a></li>
            <li>
                <button class="tn-ab" aria-expanded="false" data-p="tn-a0"><?php esc_html_e( 'About', 'my-theme' ); ?>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div id="tn-a0" class="tn-ap">
                    <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><span aria-hidden="true">&#127970;</span> <?php esc_html_e( 'About TGNE', 'my-theme' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/our-approach/' ) ); ?>"><span aria-hidden="true">&#127919;</span> <?php esc_html_e( 'Our Approach', 'my-theme' ); ?></a>
                </div>
            </li>
            <li>
                <button class="tn-ab" aria-expanded="false" data-p="tn-a1"><?php esc_html_e( 'Graphics, Print & Souvenirs', 'my-theme' ); ?>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div id="tn-a1" class="tn-ap">
                    <a href="<?php echo esc_url( home_url( '/creatives/' ) ); ?>"><span aria-hidden="true">&#127912;</span> <?php esc_html_e( 'Creatives', 'my-theme' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/logos/' ) ); ?>"><span aria-hidden="true">&#11088;</span> <?php esc_html_e( 'Logos', 'my-theme' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/graphic-design/' ) ); ?>"><span aria-hidden="true">&#128187;</span> <?php esc_html_e( 'Digital Design', 'my-theme' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/event-vehicle-branding/' ) ); ?>"><span aria-hidden="true">&#127882;</span> <?php esc_html_e( 'Event Branding', 'my-theme' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/offset-prints/' ) ); ?>"><span aria-hidden="true">&#128438;</span> <?php esc_html_e( 'Offset Prints', 'my-theme' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/digital-prints/' ) ); ?>"><span aria-hidden="true">&#9889;</span> <?php esc_html_e( 'Digital Prints', 'my-theme' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/apparel-prints/' ) ); ?>"><span aria-hidden="true">&#128085;</span> <?php esc_html_e( 'Apparel Prints', 'my-theme' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/branded-souvenirs/' ) ); ?>"><span aria-hidden="true">&#127873;</span> <?php esc_html_e( 'Branded Souvenirs', 'my-theme' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/award-plaques/' ) ); ?>"><span aria-hidden="true">&#127942;</span> <?php esc_html_e( 'Award Plaques', 'my-theme' ); ?></a>
                </div>
            </li>
            <li><a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>"><?php esc_html_e( 'Shop', 'my-theme' ); ?></a></li>
            <li><a href="<?php echo $contact; ?>" class="tn-hi"><?php esc_html_e( 'Contact', 'my-theme' ); ?></a></li>
        </ul>
    </div>
    <div class="tn-df">
        <a href="<?php echo $contact; ?>" class="tn-dcta">&#128197;&nbsp; <?php esc_html_e( 'Get a Free Quote', 'my-theme' ); ?></a>
        <div class="tn-dsoc">
            <a href="https://facebook.com/tgnesolutions"        class="tn-s tn-fb" target="_blank" rel="noopener noreferrer" aria-label="Facebook">f</a>
            <a href="https://instagram.com/tgnesolutions"        class="tn-s tn-ig" target="_blank" rel="noopener noreferrer" aria-label="Instagram">&#128247;</a>
            <a href="https://linkedin.com/company/tgnesolutions" class="tn-s tn-li" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">in</a>
            <a href="<?php echo esc_url( $wa ); ?>"             class="tn-s tn-wa" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">&#128172;</a>
        </div>
    </div>
</div>
<!-- /TGNE Header -->
<?php
    return ob_get_clean();
}

/* ─────────────────────────────────────────────────────
   7. CSS
───────────────────────────────────────────────────── */

function tgne_get_css() {
    return '
:root{--sd:#061B33;--sb:#0A4C7F;--sm:#0D5E9E;--sl:#2C7FB8;--lg:#4CAF88;--lo:#FFA866;--ld:#E8914A;--sw:#D8E4F0;--mw:#C8D8E8;--gw:#B0C4D8;--f:"Poppins",sans-serif;--t:all .3s cubic-bezier(.4,0,.2,1)}
#tgne-prog{position:fixed;top:0;left:0;right:0;height:3px;z-index:100000;pointer-events:none;background:rgba(255,255,255,.05)}
#tgne-prog-fill{height:100%;width:0%;background:linear-gradient(90deg,var(--lo),var(--lg),var(--lo));background-size:200%;animation:tgne-shim 2.5s linear infinite;border-radius:0 2px 2px 0;transition:width .1s linear}
@keyframes tgne-shim{0%{background-position:0%}100%{background-position:200%}}
#tgne-ann{position:fixed;top:3px;left:0;right:0;z-index:99999;background:linear-gradient(90deg,var(--sd),var(--sb),var(--sd));border-bottom:1px solid rgba(255,255,255,.06)}
.ta-in{display:flex;align-items:center;justify-content:space-between;padding:8px 5%;gap:10px}
.ta-dot{display:inline-block;width:6px;height:6px;border-radius:50%;background:var(--lg);box-shadow:0 0 7px rgba(76,175,136,.8);animation:tgne-blink 1.8s infinite;flex-shrink:0}
@keyframes tgne-blink{0%,100%{opacity:1}50%{opacity:.25}}
.ta-pill{background:rgba(255,168,102,.2);border:1px solid rgba(255,168,102,.4);color:var(--lo);font-family:var(--f);font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;padding:2px 8px;border-radius:20px;flex-shrink:0}
.ta-l{display:flex;align-items:center;gap:8px;font-family:var(--f);font-size:11px;color:rgba(255,255,255,.78);flex-wrap:wrap}
.ta-l a{color:var(--lo);text-decoration:none;font-weight:600}
.ta-l a:hover{text-decoration:underline}
.ta-r{display:flex;align-items:center;gap:12px;flex-shrink:0}
.ta-lk{font-family:var(--f);font-size:11px;color:rgba(255,255,255,.65);text-decoration:none;display:flex;align-items:center;gap:5px;white-space:nowrap;transition:color .2s}
.ta-lk:hover{color:var(--lo)}
.ta-sp{width:1px;height:12px;background:rgba(255,255,255,.15)}
#tgne-nav{transition:var(--t);box-sizing:border-box}
.tn-logo{display:flex;align-items:center;gap:11px;text-decoration:none;flex-shrink:0}
.tn-lw{position:relative;width:44px;height:44px;flex-shrink:0}
.tn-lw img{width:44px;height:44px;object-fit:contain;border-radius:0;background:transparent;display:block;transition:transform .35s cubic-bezier(.34,1.56,.64,1);filter:drop-shadow(0 0 8px rgba(255,168,102,.3))}
.tn-lfb{width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,var(--sb),var(--sl));display:flex;align-items:center;justify-content:center;font-family:var(--f);font-weight:900;font-size:12px;color:white}
.tn-logo:hover .tn-lw img{transform:scale(1.08) rotate(-3deg)}
.tn-lg{position:absolute;inset:-4px;border-radius:14px;background:radial-gradient(circle,rgba(255,168,102,.4),transparent 70%);opacity:0;transition:opacity .3s;pointer-events:none}
.tn-logo:hover .tn-lg{opacity:1}
.tn-lt{line-height:1}
.tn-lt strong{font-family:var(--f);font-weight:800;font-size:16px;color:var(--sw);display:block;letter-spacing:-.2px;font-style:normal}
.tn-lt strong em{color:var(--lo);font-style:normal}
.tn-lt small{font-family:var(--f);font-size:8px;font-weight:600;letter-spacing:2.5px;text-transform:uppercase;color:rgba(255,168,102,.65);display:block;margin-top:2px}
.tn-nav{display:flex;align-items:center;gap:2px;list-style:none;margin:0;padding:0}
.tn-nav>li{position:relative;list-style:none}
.tn-nav>li>a,.tn-nav>li>button{font-family:var(--f);font-size:13px;font-weight:500;color:var(--mw);text-decoration:none;padding:8px 12px;border-radius:8px;display:flex;align-items:center;gap:5px;background:none;border:none;cursor:pointer;transition:color .2s,background .2s;white-space:nowrap;position:relative;line-height:1.3}
.tn-nav>li>a:hover,.tn-nav>li>button:hover,.tn-dd.tn-open>button{color:#fff;background:rgba(255,255,255,.07)}
.tn-nav>li>a.tn-cur{color:var(--lo)}
.tn-nav>li>a::after{content:"";position:absolute;bottom:2px;left:12px;right:12px;height:2px;background:var(--lo);border-radius:2px;transform:scaleX(0);transition:transform .28s}
.tn-nav>li>a.tn-cur::after,.tn-nav>li>a:hover::after{transform:scaleX(1)}
.tn-ch{width:13px;height:13px;flex-shrink:0;transition:transform .28s}
.tn-dd.tn-open>.tn-db .tn-ch{transform:rotate(180deg)}
.tn-dp{position:absolute;top:calc(100% + 10px);left:50%;transform:translateX(-50%) translateY(6px);background:rgba(5,20,42,.98);backdrop-filter:blur(26px);-webkit-backdrop-filter:blur(26px);border:1px solid rgba(255,255,255,.09);border-radius:16px;padding:8px;box-shadow:0 20px 60px rgba(0,0,0,.5);opacity:0;visibility:hidden;pointer-events:none;transition:opacity .22s,transform .22s,visibility .22s;z-index:99990}
.tn-dp::before{content:"";position:absolute;top:-16px;left:0;right:0;height:16px}
.tn-dd:hover .tn-dp,.tn-dd.tn-open .tn-dp{opacity:1;visibility:visible;pointer-events:auto;transform:translateX(-50%) translateY(0)}
.tn-dp-sm{min-width:240px}
.tn-di{display:flex;align-items:center;gap:11px;padding:10px 12px;border-radius:10px;text-decoration:none;transition:background .16s}
.tn-di:hover{background:rgba(255,255,255,.06)}
.tn-hr{border:none;border-top:1px solid rgba(255,255,255,.07);margin:5px 0}
.tn-dt{display:flex;flex-direction:column}
.tn-dt strong{font-family:var(--f);font-size:13px;font-weight:600;color:var(--sw);line-height:1.2;font-style:normal}
.tn-dt small{font-size:11px;color:rgba(176,196,216,.6);margin-top:2px;line-height:1.3}
.tn-ic{width:34px;height:34px;min-width:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;transition:transform .2s}
.tn-di:hover .tn-ic,.tn-mi:hover .tn-ic{transform:scale(1.1)}
.tn-c1{background:rgba(10,76,127,.25)}.tn-c2{background:rgba(76,175,136,.2)}.tn-c3{background:rgba(255,168,102,.18)}.tn-c4{background:rgba(44,127,184,.2)}.tn-c5{background:rgba(255,193,7,.15)}.tn-c6{background:rgba(139,92,246,.2)}
.tn-dp-lg{min-width:700px}
.tn-mega{display:grid;grid-template-columns:1.1fr 1fr 1fr;gap:4px}
.tn-mf{background:linear-gradient(135deg,rgba(10,76,127,.4),rgba(13,94,158,.3));border-radius:12px;padding:20px;border:1px solid rgba(255,255,255,.07);display:flex;flex-direction:column;position:relative;overflow:hidden}
.tn-mf::before{content:"";position:absolute;top:-28px;right:-28px;width:90px;height:90px;border-radius:50%;background:radial-gradient(circle,rgba(255,168,102,.15),transparent 70%);pointer-events:none}
.tn-ml{font-family:var(--f);font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--lo);margin-bottom:8px;display:block}
.tn-mt{font-family:var(--f);font-size:17px;font-weight:800;color:var(--sw);line-height:1.2;margin-bottom:9px}
.tn-mt strong{color:var(--lo)}
.tn-md{font-size:12px;color:var(--gw);line-height:1.62;margin-bottom:18px;flex:1}
.tn-mb{display:inline-flex;align-items:center;gap:5px;background:var(--lo);color:white;font-family:var(--f);font-weight:600;font-size:12px;padding:8px 15px;border-radius:8px;text-decoration:none;width:fit-content;transition:background .2s,transform .2s}
.tn-mb:hover{background:var(--ld);transform:translateY(-1px)}
.tn-mc{padding:4px}
.tn-mh{font-family:var(--f);font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.3);padding:4px 10px 8px;display:block}
.tn-mi{display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:10px;text-decoration:none;transition:background .16s}
.tn-mi:hover{background:rgba(255,255,255,.06)}
.tn-mx{display:flex;flex-direction:column}
.tn-mx strong{font-family:var(--f);font-size:12.5px;font-weight:600;color:var(--sw);line-height:1.2;font-style:normal}
.tn-mx small{font-size:10.5px;color:rgba(176,196,216,.58);margin-top:2px;line-height:1.3}
.tn-acts{display:flex;align-items:center;gap:8px;flex-shrink:0}
#tn-sb{width:36px;height:36px;border-radius:9px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.09);color:var(--mw);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:var(--t)}
#tn-sb:hover{background:rgba(255,255,255,.13);color:white}
.tn-cta{display:inline-flex;align-items:center;gap:7px;background:var(--lo);color:white;font-family:var(--f);font-weight:700;font-size:13px;padding:9px 20px;border-radius:10px;text-decoration:none;border:2px solid var(--lo);white-space:nowrap;transition:var(--t)}
.tn-cta:hover{background:var(--ld);border-color:var(--ld);transform:translateY(-2px);box-shadow:0 8px 22px rgba(255,168,102,.4);color:white}
.tn-cd{width:6px;height:6px;border-radius:50%;background:white;animation:tgne-blink 2s infinite;flex-shrink:0}
.tn-bg{display:none;flex-direction:column;gap:5px;width:40px;height:40px;border-radius:9px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);cursor:pointer;padding:0;align-items:center;justify-content:center;transition:background .2s}
.tn-bg:hover{background:rgba(255,255,255,.12)}
.tn-bg span{display:block;height:2px;width:22px;background:var(--sw);border-radius:2px;transition:transform .32s,opacity .32s}
.tn-bg.tn-open span:nth-child(1){transform:translateY(7px) rotate(45deg)}
.tn-bg.tn-open span:nth-child(2){opacity:0;transform:scaleX(0)}
.tn-bg.tn-open span:nth-child(3){transform:translateY(-7px) rotate(-45deg)}
#tn-sov{position:fixed;inset:0;z-index:99998;background:rgba(5,16,38,.96);backdrop-filter:blur(20px);display:flex;align-items:flex-start;justify-content:center;padding-top:130px;opacity:0;pointer-events:none;transition:opacity .26s}
#tn-sov.tn-on{opacity:1;pointer-events:auto}
.tn-sb2{width:90%;max-width:640px;transform:translateY(-16px);transition:transform .3s}
#tn-sov.tn-on .tn-sb2{transform:translateY(0)}
.tn-sl{font-family:var(--f);font-size:11px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:rgba(255,168,102,.75);margin-bottom:11px;display:block}
.tn-sbar{display:flex;align-items:center;gap:11px;background:rgba(255,255,255,.07);border:1.5px solid rgba(255,255,255,.13);border-radius:12px;padding:12px 15px;transition:border .2s}
.tn-sbar:focus-within{border-color:var(--lo)}
#tn-si{flex:1;background:none;border:none;outline:none;font-family:var(--f);font-size:19px;font-weight:500;color:white}
#tn-si::placeholder{color:rgba(255,255,255,.27)}
#tn-sc{background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);border-radius:7px;color:var(--gw);width:33px;height:33px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:18px;line-height:1;transition:background .2s,color .2s;flex-shrink:0}
#tn-sc:hover{background:rgba(220,50,50,.4);color:white}
.tn-sh{margin-top:9px;font-size:12px;color:rgba(176,196,216,.42)}
.tn-sh kbd{background:rgba(255,255,255,.1);border-radius:4px;padding:2px 6px;font-size:11px;color:var(--lo)}
#tn-ov{position:fixed;inset:0;z-index:99994;background:rgba(0,0,0,.65);backdrop-filter:blur(4px);opacity:0;pointer-events:none;transition:opacity .32s}
#tn-ov.tn-on{opacity:1;pointer-events:auto}
#tn-dr{position:fixed;top:0;right:-110%;bottom:0;width:min(88vw,380px);background:linear-gradient(175deg,#061B33,#0A2B50);border-left:1px solid rgba(255,168,102,.14);box-shadow:-16px 0 60px rgba(0,0,0,.5);z-index:99995;display:flex;flex-direction:column;overflow:hidden;transition:right .4s cubic-bezier(.4,0,.2,1)}
#tn-dr.tn-on{right:0}
.tn-dh{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid rgba(255,255,255,.08);background:rgba(0,0,0,.18);flex-shrink:0}
.tn-dlogo{display:flex;align-items:center;gap:9px;text-decoration:none}
.tn-dlogo img{width:36px;height:36px;object-fit:contain;border-radius:0;background:transparent;filter:drop-shadow(0 0 6px rgba(255,168,102,.3))}
.tn-dlogo span{font-family:var(--f);font-weight:700;font-size:14.5px;color:var(--sw)}
.tn-dlogo em{color:var(--lo);font-style:normal}
#tn-dc{width:33px;height:33px;border-radius:8px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);color:var(--gw);display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:19px;line-height:1;transition:background .2s,color .2s,transform .2s;flex-shrink:0}
#tn-dc:hover{background:rgba(220,50,50,.3);color:white;transform:rotate(90deg)}
.tn-db2{flex:1;overflow-y:auto;padding:6px 0 16px}
.tn-mul{list-style:none;margin:0;padding:0}
.tn-mul>li>a{display:flex;align-items:center;padding:15px 22px;font-family:var(--f);font-size:15px;font-weight:500;color:var(--sw);text-decoration:none;border-bottom:1px solid rgba(255,255,255,.06);transition:background .15s,color .15s,padding-left .15s}
.tn-mul>li>a:hover{background:rgba(255,255,255,.04);color:var(--lo);padding-left:28px}
.tn-hi{color:var(--lo)!important;font-weight:600!important}
.tn-ab{display:flex;align-items:center;justify-content:space-between;width:100%;padding:15px 22px;font-family:var(--f);font-size:15px;font-weight:500;color:var(--sw);background:none;border:none;border-bottom:1px solid rgba(255,255,255,.06);cursor:pointer;transition:background .15s,color .15s;text-align:left}
.tn-ab:hover,.tn-ab[aria-expanded="true"]{background:rgba(255,168,102,.07);color:var(--lo)}
.tn-ab svg{transition:transform .3s;flex-shrink:0}
.tn-ab[aria-expanded="true"] svg{transform:rotate(180deg)}
.tn-ap{max-height:0;overflow:hidden;transition:max-height .36s cubic-bezier(.4,0,.2,1);background:rgba(0,0,0,.18)}
.tn-ap.tn-on{max-height:1000px}
.tn-ap a{display:flex;align-items:center;gap:10px;padding:12px 22px 12px 36px;font-family:var(--f);font-size:13.5px;font-weight:400;color:var(--gw);text-decoration:none;border-bottom:1px solid rgba(255,255,255,.04);transition:background .14s,color .14s,padding-left .14s}
.tn-ap a:hover{background:rgba(255,168,102,.07);color:var(--lo);padding-left:44px}
.tn-ap a span{font-size:15px}
.tn-df{padding:17px 20px;border-top:1px solid rgba(255,255,255,.07);background:rgba(0,0,0,.14);flex-shrink:0}
.tn-dcta{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:13px;background:linear-gradient(135deg,var(--lo),var(--ld));color:white;font-family:var(--f);font-weight:700;font-size:14px;text-decoration:none;border-radius:11px;box-shadow:0 5px 18px rgba(255,168,102,.3);transition:transform .2s,box-shadow .2s}
.tn-dcta:hover{transform:translateY(-2px);box-shadow:0 9px 26px rgba(255,168,102,.44)}
.tn-dsoc{display:flex;gap:9px;justify-content:center;margin-top:13px}
.tn-s{width:36px;height:36px;border-radius:9px;display:flex;align-items:center;justify-content:center;color:white;text-decoration:none;font-family:var(--f);font-weight:700;font-size:13px;transition:opacity .2s,transform .2s}
.tn-s:hover{opacity:.8;transform:translateY(-2px)}
.tn-fb{background:#1877F2}.tn-ig{background:linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888)}.tn-li{background:#0A66C2}.tn-wa{background:#25D366}
@media(max-width:1100px){.tn-nav{display:none!important}.tn-bg{display:flex!important}.tn-dp-lg{min-width:auto}}
@media(max-width:600px){.ta-r{display:none}#tgne-nav{padding:0 4%!important}.tn-lt small{display:none}.tn-cta{padding:9px 14px;font-size:12px}}
@media(max-width:380px){.tn-cta{display:none}}
body.tn-lock{overflow:hidden!important}
';
}

/* ─────────────────────────────────────────────────────
   8. JS
───────────────────────────────────────────────────── */

function tgne_get_js() {
    return '
(function(){
"use strict";
function fixSlider(){
  var el=document.getElementById("hero-slider");
  if(!el)return;
  var track=el.querySelector(".hs-track");
  if(!track)return;
  el.style.cssText=["position:relative","overflow:hidden","height:calc(100vh - 115px)","min-height:560px","width:100vw","max-width:100vw","margin-left:calc(-50vw + 50%)","margin-right:calc(-50vw + 50%)","margin-top:0","box-sizing:border-box","display:block"].join("!important;")+"!important";
  track.style.cssText=["display:flex","flex-direction:row","flex-wrap:nowrap","height:100%","will-change:transform"].join("!important;")+"!important";
  var slides=track.querySelectorAll(".hs-slide");
  slides.forEach(function(s){s.style.cssText=["flex:0 0 100%","min-width:100%","max-width:100%","width:100%","height:100%","position:relative","display:flex","align-items:center","overflow:hidden","flex-shrink:0"].join("!important;")+"!important";});
}
if(document.readyState==="loading"){document.addEventListener("DOMContentLoaded",fixSlider);}else{fixSlider();}
window.addEventListener("load",fixSlider);
var nav=document.getElementById("tgne-nav"),bg=document.getElementById("tn-bg"),dr=document.getElementById("tn-dr"),ov=document.getElementById("tn-ov"),dc=document.getElementById("tn-dc"),sb=document.getElementById("tn-sb"),sov=document.getElementById("tn-sov"),sc=document.getElementById("tn-sc"),si=document.getElementById("tn-si"),pf=document.getElementById("tgne-prog-fill");
if(!nav)return;
var ly=0,tk=false;
window.addEventListener("scroll",function(){if(tk)return;tk=true;requestAnimationFrame(function(){var y=window.pageYOffset||0;nav.classList.toggle("tn-scrolled",y>55);nav.classList.toggle("tn-hidden",y>ly&&y>110);ly=y<0?0:y;if(pf){var h=document.documentElement.scrollHeight-document.documentElement.clientHeight;pf.style.width=(h>0?(y/h)*100:0)+"%";}tk=false;});},{passive:true});
function cdd(){document.querySelectorAll(".tn-dd.tn-open").forEach(function(l){l.classList.remove("tn-open");var b=l.querySelector(".tn-db");if(b)b.setAttribute("aria-expanded","false");});}
document.querySelectorAll(".tn-db").forEach(function(b){b.addEventListener("click",function(e){e.stopPropagation();var li=b.closest(".tn-dd"),o=li.classList.contains("tn-open");cdd();if(!o){li.classList.add("tn-open");b.setAttribute("aria-expanded","true");}});});
document.addEventListener("click",cdd);
function odr(){dr&&dr.classList.add("tn-on");ov&&ov.classList.add("tn-on");bg&&bg.classList.add("tn-open");bg&&bg.setAttribute("aria-expanded","true");document.body.classList.add("tn-lock");}
function cdr(){dr&&dr.classList.remove("tn-on");ov&&ov.classList.remove("tn-on");bg&&bg.classList.remove("tn-open");bg&&bg.setAttribute("aria-expanded","false");document.body.classList.remove("tn-lock");}
if(bg)bg.addEventListener("click",odr);
if(dc)dc.addEventListener("click",cdr);
if(ov)ov.addEventListener("click",cdr);
if(dr)dr.querySelectorAll("a").forEach(function(a){a.addEventListener("click",cdr);});
document.querySelectorAll(".tn-ab").forEach(function(b){b.addEventListener("click",function(){var id=b.getAttribute("data-p"),p=id&&document.getElementById(id);if(!p)return;var o=p.classList.contains("tn-on");document.querySelectorAll(".tn-ap.tn-on").forEach(function(x){x.classList.remove("tn-on");});document.querySelectorAll(".tn-ab[aria-expanded=true]").forEach(function(x){x.setAttribute("aria-expanded","false");});if(!o){p.classList.add("tn-on");b.setAttribute("aria-expanded","true");}});});
function os(){sov&&sov.classList.add("tn-on");document.body.classList.add("tn-lock");setTimeout(function(){si&&si.focus();},280);}
function cs(){sov&&sov.classList.remove("tn-on");document.body.classList.remove("tn-lock");}
if(sb)sb.addEventListener("click",os);
if(sc)sc.addEventListener("click",cs);
if(si)si.addEventListener("keydown",function(e){if(e.key==="Enter"&&si.value.trim())window.location.href=window.location.origin+"/?s="+encodeURIComponent(si.value.trim());});
document.addEventListener("keydown",function(e){if(e.key==="Escape"){cs();cdr();cdd();}});
var cur=window.location.pathname;
document.querySelectorAll(".tn-nav a").forEach(function(a){if(a.getAttribute("href")===cur)a.classList.add("tn-cur");});
}());
';
}
