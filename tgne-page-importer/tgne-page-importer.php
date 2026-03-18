<?php
/**
 * Plugin Name: TGNE Page Importer & 404 Fixer
 * Plugin URI:  https://tgnesolutions.com
 * Description: Auto-creates all TGNE pages with correct slugs, sets them to Elementor Canvas, and fixes 404 permalink errors. Run once then deactivate.
 * Version:     3.0.0
 * Author:      TGNE Solutions
 * Author URI:  https://tgnesolutions.com
 * License:     GPL-2.0-or-later
 */

defined( 'ABSPATH' ) || exit;

/* ═══════════════════════════════════════════════════════
   1. ADMIN NOTICE — shows status on every admin page
═══════════════════════════════════════════════════════ */
add_action( 'admin_notices', 'tgne_importer_admin_notice' );
function tgne_importer_admin_notice() {
    $done  = get_option( 'tgne_import_done', false );
    $count = get_option( 'tgne_import_count', 0 );
    $url   = admin_url( 'admin-post.php?action=tgne_run_importer&_wpnonce=' . wp_create_nonce( 'tgne_run_importer' ) );
    $flush = admin_url( 'admin-post.php?action=tgne_flush_permalinks&_wpnonce=' . wp_create_nonce( 'tgne_flush_permalinks' ) );

    if ( ! $done ) {
        echo '<div class="notice notice-warning" style="padding:16px;border-left:4px solid #FFA866;">
            <h3 style="margin:0 0 8px;color:#061B33;">⚡ TGNE Page Importer — Action Required</h3>
            <p style="margin:0 0 10px;">Click the button below to <strong>auto-create all TGNE pages</strong> and fix 404 errors.</p>
            <a href="' . esc_url( $url ) . '" class="button button-primary" style="background:#FFA866;border-color:#E8914A;margin-right:8px;">▶ Create All Pages + Fix 404s</a>
            <a href="' . esc_url( $flush ) . '" class="button">🔄 Flush Permalinks Only</a>
        </div>';
    } else {
        echo '<div class="notice notice-success is-dismissible" style="padding:14px;border-left:4px solid #4CAF88;">
            <h3 style="margin:0 0 6px;color:#061B33;">✅ TGNE Pages Imported Successfully</h3>
            <p style="margin:0;">' . (int) $count . ' pages created/verified. Permalinks flushed. 
            <strong>You can now deactivate this plugin.</strong> 
            Go to <a href="' . esc_url( admin_url( 'edit.php?post_type=page' ) ) . '">All Pages</a> to see them.</p>
        </div>';
    }
}

/* ═══════════════════════════════════════════════════════
   2. FLUSH PERMALINKS ONLY
═══════════════════════════════════════════════════════ */
add_action( 'admin_post_tgne_flush_permalinks', 'tgne_flush_only' );
function tgne_flush_only() {
    check_admin_referer( 'tgne_flush_permalinks' );
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Unauthorised' );

    // Force permalink structure to Post name if not already set
    $structure = get_option( 'permalink_structure' );
    if ( empty( $structure ) || $structure === '/?p=%post_id%' ) {
        update_option( 'permalink_structure', '/%postname%/' );
    }
    flush_rewrite_rules( true );
    wp_redirect( admin_url( 'options-permalink.php?tgne_flushed=1' ) );
    exit;
}

/* ═══════════════════════════════════════════════════════
   3. MAIN IMPORTER — creates all pages
═══════════════════════════════════════════════════════ */
add_action( 'admin_post_tgne_run_importer', 'tgne_run_importer' );
function tgne_run_importer() {
    check_admin_referer( 'tgne_run_importer' );
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Unauthorised' );

    /* ── All TGNE pages: title => slug ── */
    $pages = array(
        'Home'                     => '',           // front page — handled separately
        'About TGNE'               => 'about',
        'Our Approach'             => 'our-approach',
        'Contact'                  => 'contact',
        'Shop'                     => 'shop',
        'Creatives'                => 'creatives',
        'Logos'                    => 'logos',
        'Graphic Design'           => 'graphic-design',
        'Event Vehicle Branding'   => 'event-vehicle-branding',
        'Offset Prints'            => 'offset-prints',
        'Digital Prints'           => 'printing',
        'Apparel Prints'           => 'apparel-prints',
        'Branded Souvenirs'        => 'branded-souvenirs',
        'Award Plaques'            => 'award-plaques',
        'Graphics CNC'             => 'graphics-cnc',
        'Graphics Laser'           => 'graphics-laser',
        'Graphics Memorial'        => 'graphics-memorial',
        'Graphics Printing'        => 'graphics-printing',
        'Products Branded'         => 'products-branded',
        'Services Technology'      => 'services-technology',
        'Services Website'         => 'services-website',
        'Training Programs'        => 'training-programs',
        'Training ICT'             => 'training-ict',
        'Training AI Educators'    => 'training-ai-educators',
        'Page Creatives'           => 'page-creatives',
        'Page Logos'               => 'page-logos',
        'Page Digital Prints'      => 'page-digital-prints',
        'Page Offset Prints'       => 'page-offset-prints',
        'Page Apparel Prints'      => 'page-apparel-prints',
        'Page Event Branding'      => 'page-event-branding',
    );

    $created = 0;
    $admin   = get_user_by( 'role', 'administrator' );
    $author  = $admin ? $admin->ID : 1;

    foreach ( $pages as $title => $slug ) {

        // Skip the home/front page from slug iteration
        if ( $slug === '' ) continue;

        // Check if page with this slug already exists
        $existing = get_page_by_path( $slug, OBJECT, 'page' );

        if ( ! $existing ) {
            // Create the page
            $page_id = wp_insert_post( array(
                'post_title'   => $title,
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_author'  => $author,
                'post_content' => '',
                'meta_input'   => array(
                    '_wp_page_template'    => 'elementor_canvas',
                    '_elementor_edit_mode' => 'builder',
                    '_elementor_template_type' => 'wp-page',
                    '_elementor_version'   => '3.0.0',
                    '_elementor_data'      => '[]',
                ),
            ) );

            if ( $page_id && ! is_wp_error( $page_id ) ) {
                // Make sure Elementor canvas is set
                update_post_meta( $page_id, '_wp_page_template', 'elementor_canvas' );
                update_post_meta( $page_id, '_elementor_edit_mode', 'builder' );
                $created++;
                error_log( "TGNE Importer: Created page '{$title}' → /{$slug}/" );
            }
        } else {
            // Page exists — make sure it has Elementor Canvas
            update_post_meta( $existing->ID, '_wp_page_template', 'elementor_canvas' );
            update_post_meta( $existing->ID, '_elementor_edit_mode', 'builder' );
            $created++;
            error_log( "TGNE Importer: Verified page '{$title}' → /{$slug}/" );
        }
    }

    // ── Handle front page ──────────────────────────────
    $front = get_option( 'page_on_front' );
    if ( ! $front ) {
        // Look for a page called "Home" or "home"
        $home_page = get_page_by_path( 'home', OBJECT, 'page' );
        if ( ! $home_page ) {
            $home_id = wp_insert_post( array(
                'post_title'  => 'Home',
                'post_name'   => 'home',
                'post_status' => 'publish',
                'post_type'   => 'page',
                'post_author' => $author,
                'post_content'=> '',
                'meta_input'  => array(
                    '_wp_page_template'    => 'elementor_canvas',
                    '_elementor_edit_mode' => 'builder',
                    '_elementor_data'      => '[]',
                ),
            ) );
            if ( $home_id && ! is_wp_error( $home_id ) ) {
                update_option( 'show_on_front', 'page' );
                update_option( 'page_on_front', $home_id );
                $created++;
            }
        } else {
            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front', $home_page->ID );
            update_post_meta( $home_page->ID, '_wp_page_template', 'elementor_canvas' );
        }
    } else {
        update_post_meta( $front, '_wp_page_template', 'elementor_canvas' );
        update_post_meta( $front, '_elementor_edit_mode', 'builder' );
    }

    // ── Fix permalink structure ─────────────────────────
    $structure = get_option( 'permalink_structure' );
    if ( empty( $structure ) || $structure === '/?p=%post_id%' || $structure === false ) {
        update_option( 'permalink_structure', '/%postname%/' );
    }

    // ── Flush rewrite rules ─────────────────────────────
    flush_rewrite_rules( true );

    // ── Mark done ──────────────────────────────────────
    update_option( 'tgne_import_done', true );
    update_option( 'tgne_import_count', $created );

    wp_redirect( admin_url( 'edit.php?post_type=page&tgne_imported=' . $created ) );
    exit;
}

/* ═══════════════════════════════════════════════════════
   4. SUCCESS NOTICE ON PAGES LIST
═══════════════════════════════════════════════════════ */
add_action( 'admin_notices', 'tgne_import_success_notice' );
function tgne_import_success_notice() {
    if ( ! isset( $_GET['tgne_imported'] ) ) return;
    $n = absint( $_GET['tgne_imported'] );
    echo '<div class="notice notice-success is-dismissible"><p>
        ✅ TGNE Importer: <strong>' . $n . ' pages</strong> created/verified. Permalinks flushed. All pages are set to Elementor Canvas. 
        You can now <a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">deactivate this plugin</a>.
    </p></div>';
}

/* ═══════════════════════════════════════════════════════
   5. AUTO-FIX: On every 404, check if it's a TGNE page
   that exists but has wrong permalink structure
═══════════════════════════════════════════════════════ */
add_action( 'template_redirect', 'tgne_404_auto_fix' );
function tgne_404_auto_fix() {
    if ( ! is_404() ) return;

    $requested = trim( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
    if ( empty( $requested ) ) return;

    // Try to find page by slug
    $page = get_page_by_path( $requested, OBJECT, 'page' );
    if ( $page && $page->post_status === 'publish' ) {
        // Page exists — permalink structure is wrong, redirect correctly
        wp_redirect( get_permalink( $page->ID ), 301 );
        exit;
    }

    // Try without trailing segment
    $parts = explode( '/', $requested );
    $last  = end( $parts );
    if ( $last !== $requested ) {
        $page2 = get_page_by_path( $last, OBJECT, 'page' );
        if ( $page2 && $page2->post_status === 'publish' ) {
            wp_redirect( get_permalink( $page2->ID ), 301 );
            exit;
        }
    }
}

/* ═══════════════════════════════════════════════════════
   6. ACTIVATION HOOK — flush immediately on activate
═══════════════════════════════════════════════════════ */
register_activation_hook( __FILE__, 'tgne_importer_activate' );
function tgne_importer_activate() {
    // Reset done flag so the notice shows
    delete_option( 'tgne_import_done' );
    delete_option( 'tgne_import_count' );

    // Fix permalink structure immediately
    $structure = get_option( 'permalink_structure' );
    if ( empty( $structure ) || $structure === '/?p=%post_id%' ) {
        update_option( 'permalink_structure', '/%postname%/' );
    }
    flush_rewrite_rules( true );
}

/* ═══════════════════════════════════════════════════════
   7. DEACTIVATION — clean up options
═══════════════════════════════════════════════════════ */
register_deactivation_hook( __FILE__, 'tgne_importer_deactivate' );
function tgne_importer_deactivate() {
    flush_rewrite_rules( true );
}

/* ═══════════════════════════════════════════════════════
   8. ADMIN PAGE — full dashboard with page status table
═══════════════════════════════════════════════════════ */
add_action( 'admin_menu', 'tgne_importer_menu' );
function tgne_importer_menu() {
    add_management_page(
        'TGNE Page Importer',
        '🔧 TGNE Importer',
        'manage_options',
        'tgne-importer',
        'tgne_importer_page'
    );
}

function tgne_importer_page() {
    $slugs = array(
        'home', 'about', 'our-approach', 'contact', 'shop',
        'creatives', 'logos', 'graphic-design', 'event-vehicle-branding',
        'offset-prints', 'printing', 'apparel-prints', 'branded-souvenirs',
        'award-plaques', 'graphics-cnc', 'graphics-laser', 'graphics-memorial',
        'graphics-printing', 'products-branded', 'services-technology',
        'services-website', 'training-programs', 'training-ict',
        'training-ai-educators', 'page-creatives', 'page-logos',
        'page-digital-prints', 'page-offset-prints', 'page-apparel-prints',
        'page-event-branding',
    );

    $run_url   = admin_url( 'admin-post.php?action=tgne_run_importer&_wpnonce=' . wp_create_nonce( 'tgne_run_importer' ) );
    $flush_url = admin_url( 'admin-post.php?action=tgne_flush_permalinks&_wpnonce=' . wp_create_nonce( 'tgne_flush_permalinks' ) );
    $permalink = get_option( 'permalink_structure' );

    echo '<div class="wrap" style="font-family:\'Poppins\',sans-serif">';
    echo '<h1 style="color:#061B33;">⚡ TGNE Page Importer v3.0</h1>';

    // Permalink status
    $pl_ok = ! empty( $permalink ) && $permalink !== '/?p=%post_id%';
    echo '<div style="background:' . ( $pl_ok ? '#e8f5e9' : '#fff3e0' ) . ';border:1px solid ' . ( $pl_ok ? '#4CAF88' : '#FFA866' ) . ';border-radius:8px;padding:14px 18px;margin-bottom:20px;">';
    echo '<strong>Permalink Structure:</strong> <code>' . esc_html( $permalink ?: '(default — broken!)' ) . '</code> ';
    echo $pl_ok ? '✅ Good' : '❌ <strong>Needs fixing — this causes all 404 errors!</strong>';
    echo '</div>';

    echo '<p style="margin-bottom:16px;">';
    echo '<a href="' . esc_url( $run_url ) . '" class="button button-primary" style="background:#FFA866;border-color:#E8914A;font-size:14px;height:36px;line-height:34px;padding:0 18px;margin-right:8px;">▶ Create All Pages + Fix Permalinks</a>';
    echo '<a href="' . esc_url( $flush_url ) . '" class="button" style="font-size:14px;height:36px;line-height:34px;padding:0 18px;">🔄 Flush Permalinks Only</a>';
    echo '</p>';

    echo '<h2>Page Status</h2>';
    echo '<table class="widefat striped" style="max-width:900px">';
    echo '<thead><tr><th>Slug</th><th>Status</th><th>Template</th><th>URL</th></tr></thead><tbody>';

    foreach ( $slugs as $slug ) {
        $page = ( $slug === 'home' )
            ? get_post( get_option( 'page_on_front' ) )
            : get_page_by_path( $slug, OBJECT, 'page' );

        if ( $page ) {
            $template = get_post_meta( $page->ID, '_wp_page_template', true );
            $canvas   = ( $template === 'elementor_canvas' );
            $status   = $page->post_status;
            echo '<tr>';
            echo '<td><code>/' . esc_html( $slug ) . '/</code></td>';
            echo '<td>' . ( $status === 'publish' ? '✅ Published' : '⚠️ ' . esc_html( $status ) ) . '</td>';
            echo '<td>' . ( $canvas ? '✅ Canvas' : '❌ <strong>' . esc_html( $template ?: 'default' ) . '</strong>' ) . '</td>';
            echo '<td><a href="' . esc_url( get_permalink( $page->ID ) ) . '" target="_blank">' . esc_html( get_permalink( $page->ID ) ) . '</a></td>';
            echo '</tr>';
        } else {
            echo '<tr style="background:#fff3e0">';
            echo '<td><code>/' . esc_html( $slug ) . '/</code></td>';
            echo '<td colspan="3">❌ <strong>Page does not exist</strong> — click "Create All Pages" above</td>';
            echo '</tr>';
        }
    }

    echo '</tbody></table>';
    echo '<p style="margin-top:20px;color:#666;">After creating pages, paste the content from each <code>.html</code> file into its Elementor HTML widget, then Save &amp; Publish.</p>';
    echo '</div>';
}
