<?php
/**
 * TGNE Complete 404 Fixer v4.0
 *
 * USAGE:
 *   1. Upload this file to your WordPress ROOT (where wp-config.php lives)
 *      e.g.  /public_html/tgne-fix.php
 *   2. Visit: https://tgnenewsite.tgnesolutions.com/tgne-fix.php?key=tgne2026fix
 *   3. Read the report — follow any red instructions
 *   4. DELETE this file from the server immediately after!
 *
 * This script fixes ALL known causes of 404 after WordPress import:
 *   - Wrong permalink structure
 *   - Missing / broken .htaccess
 *   - mod_rewrite not enabled
 *   - Pages not published or wrong template
 *   - Front page not set
 *   - Elementor Canvas not applied
 */

/* ── Security gate ──────────────────────────────────── */
if ( ! isset( $_GET['key'] ) || $_GET['key'] !== 'tgne2026fix' ) {
    http_response_code( 403 );
    die( '<h2 style="font-family:sans-serif">403 Forbidden</h2><p>Add <code>?key=tgne2026fix</code> to the URL.</p>' );
}

/* ── Bootstrap WordPress ────────────────────────────── */
$wp_root = dirname( __FILE__ );
if ( ! file_exists( $wp_root . '/wp-load.php' ) ) {
    // Try one level up
    $wp_root = dirname( $wp_root );
}
if ( ! file_exists( $wp_root . '/wp-load.php' ) ) {
    die( '<h2>Cannot find WordPress.</h2><p>Make sure this file is in the same folder as wp-config.php and index.php.</p><p>Current location: ' . __FILE__ . '</p>' );
}
require_once $wp_root . '/wp-load.php';

if ( ! defined( 'ABSPATH' ) ) {
    die( '<h2>WordPress failed to load.</h2>' );
}

/* ── Must be logged-in admin OR run via CLI ─────────── */
if ( ! current_user_can( 'manage_options' ) ) {
    $login = wp_login_url( add_query_arg( 'key', 'tgne2026fix', home_url('/tgne-fix.php') ) );
    die( '<h2 style="font-family:sans-serif">Not logged in as admin.</h2><p><a href="' . esc_url($login) . '">Log in first →</a></p>' );
}

/* ══════════════════════════════════════════════════════
   DIAGNOSTICS + FIXES
══════════════════════════════════════════════════════ */
$report = [];
$fixes  = [];
$errors = [];

/* ── A. Check & fix permalink structure ─────────────── */
$perm = get_option('permalink_structure');
if ( empty($perm) || $perm === '/?p=%post_id%' ) {
    update_option('permalink_structure', '/%postname%/');
    $fixes[] = 'Set permalink structure to /%postname%/';
    $perm = '/%postname%/';
} else {
    $report[] = '✅ Permalink structure: <code>' . esc_html($perm) . '</code>';
}

/* ── B. Check & fix show_on_front ───────────────────── */
$show_front = get_option('show_on_front');
if ( $show_front !== 'page' ) {
    // Find or create a home page
    $home = get_page_by_path('home', OBJECT, 'page');
    if ( ! $home ) {
        $admin = get_user_by('role','administrator');
        $uid   = $admin ? $admin->ID : 1;
        $hid   = wp_insert_post(['post_title'=>'Home','post_name'=>'home','post_status'=>'publish','post_type'=>'page','post_author'=>$uid,'post_content'=>'']);
        if ( $hid && !is_wp_error($hid) ) {
            update_post_meta($hid,'_wp_page_template','elementor_canvas');
            update_post_meta($hid,'_elementor_edit_mode','builder');
            update_option('show_on_front','page');
            update_option('page_on_front',$hid);
            $fixes[] = 'Created Home page (ID:'.$hid.') and set as front page';
        }
    } else {
        update_option('show_on_front','page');
        update_option('page_on_front',$home->ID);
        $fixes[] = 'Set Home page (ID:'.$home->ID.') as front page';
    }
} else {
    $fid = get_option('page_on_front');
    $report[] = '✅ Front page set (page ID: ' . $fid . ')';
}

/* ── C. Check mod_rewrite ───────────────────────────── */
$mod_rewrite = false;
if ( function_exists('apache_get_modules') ) {
    $mod_rewrite = in_array('mod_rewrite', apache_get_modules());
    if ( $mod_rewrite ) {
        $report[] = '✅ mod_rewrite is loaded';
    } else {
        $errors[] = '❌ mod_rewrite is NOT loaded — contact your host to enable it, OR switch to Nginx (no .htaccess needed)';
    }
} else {
    $report[] = '⚠️ Cannot detect mod_rewrite (non-Apache or function disabled) — assuming OK';
    $mod_rewrite = true;
}

/* ── D. Check & fix .htaccess ───────────────────────── */
$htaccess = $wp_root . '/.htaccess';
$ht_ok    = false;
$ht_content = "# BEGIN WordPress\n<IfModule mod_rewrite.c>\nRewriteEngine On\nRewriteBase /\nRewriteRule ^index\\.php$ - [L]\nRewriteCond %{REQUEST_FILENAME} !-f\nRewriteCond %{REQUEST_FILENAME} !-d\nRewriteRule . /index.php [L]\n</IfModule>\n# END WordPress\n";

if ( file_exists($htaccess) ) {
    $existing = file_get_contents($htaccess);
    if ( strpos($existing, 'RewriteRule . /index.php') !== false ) {
        $report[] = '✅ .htaccess has WordPress rewrite rules';
        $ht_ok = true;
    } else {
        // Prepend the WP rules
        $new = $ht_content . "\n" . $existing;
        if ( file_put_contents($htaccess, $new) ) {
            $fixes[] = '✅ Prepended WordPress rewrite rules to existing .htaccess';
            $ht_ok = true;
        } else {
            $errors[] = '❌ .htaccess exists but could not be written — fix permissions (chmod 644)';
        }
    }
} else {
    if ( file_put_contents($htaccess, $ht_content) ) {
        $fixes[] = '✅ Created .htaccess with WordPress rewrite rules';
        $ht_ok = true;
    } else {
        $errors[] = '❌ Cannot create .htaccess — directory not writable. Manually create it (content shown below)';
    }
}

/* ── E. Create / verify all TGNE pages ─────────────── */
$admin_u = get_user_by('role','administrator');
$uid     = $admin_u ? $admin_u->ID : 1;

$all_pages = [
    'Home'                   => 'home',
    'About TGNE'             => 'about',
    'Our Approach'           => 'our-approach',
    'Contact'                => 'contact',
    'Shop'                   => 'shop',
    'Creatives'              => 'creatives',
    'Logos'                  => 'logos',
    'Graphic Design'         => 'graphic-design',
    'Event Vehicle Branding' => 'event-vehicle-branding',
    'Offset Prints'          => 'offset-prints',
    'Digital Prints'         => 'printing',
    'Apparel Prints'         => 'apparel-prints',
    'Branded Souvenirs'      => 'branded-souvenirs',
    'Award Plaques'          => 'award-plaques',
    'Graphics CNC'           => 'graphics-cnc',
    'Graphics Laser'         => 'graphics-laser',
    'Graphics Memorial'      => 'graphics-memorial',
    'Graphics Printing'      => 'graphics-printing',
    'Products Branded'       => 'products-branded',
    'Services Technology'    => 'services-technology',
    'Services Website'       => 'services-website',
    'Training Programs'      => 'training-programs',
    'Training ICT'           => 'training-ict',
    'Training AI Educators'  => 'training-ai-educators',
    'Page Creatives'         => 'page-creatives',
    'Page Logos'             => 'page-logos',
    'Page Digital Prints'    => 'page-digital-prints',
    'Page Offset Prints'     => 'page-offset-prints',
    'Page Apparel Prints'    => 'page-apparel-prints',
    'Page Event Branding'    => 'page-event-branding',
];

$page_results = [];
foreach ( $all_pages as $title => $slug ) {
    $page = get_page_by_path($slug, OBJECT, 'page');
    if ( ! $page ) {
        $id = wp_insert_post([
            'post_title'   => $title,
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_author'  => $uid,
            'post_content' => '',
        ]);
        if ( $id && ! is_wp_error($id) ) {
            update_post_meta($id, '_wp_page_template', 'elementor_canvas');
            update_post_meta($id, '_elementor_edit_mode', 'builder');
            update_post_meta($id, '_elementor_data', '[]');
            $page_results[$slug] = ['status'=>'created','id'=>$id,'url'=>get_permalink($id)];
        } else {
            $page_results[$slug] = ['status'=>'error','id'=>0,'url'=>''];
        }
    } else {
        // Ensure canvas + published
        update_post_meta($page->ID, '_wp_page_template', 'elementor_canvas');
        update_post_meta($page->ID, '_elementor_edit_mode', 'builder');
        if ( $page->post_status !== 'publish' ) {
            wp_update_post(['ID'=>$page->ID,'post_status'=>'publish']);
            $page_results[$slug] = ['status'=>'published','id'=>$page->ID,'url'=>get_permalink($page->ID)];
        } else {
            $page_results[$slug] = ['status'=>'ok','id'=>$page->ID,'url'=>get_permalink($page->ID)];
        }
    }
}

/* ── F. Flush rewrite rules (TWICE for reliability) ── */
flush_rewrite_rules(false);
flush_rewrite_rules(true);
$fixes[] = '✅ Rewrite rules flushed (x2)';

/* ── G. Detect hosting type ─────────────────────────── */
$server_software = $_SERVER['SERVER_SOFTWARE'] ?? 'unknown';
$is_nginx  = stripos($server_software, 'nginx') !== false;
$is_apache = stripos($server_software, 'apache') !== false || stripos($server_software, 'litespeed') !== false;
$is_cpanel = file_exists('/usr/local/cpanel');

/* ══════════════════════════════════════════════════════
   OUTPUT REPORT
══════════════════════════════════════════════════════ */
$created_count = count(array_filter($page_results, fn($r) => $r['status']==='created'));
$ok_count      = count(array_filter($page_results, fn($r) => $r['status']==='ok'));
$error_count   = count(array_filter($page_results, fn($r) => $r['status']==='error'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>TGNE 404 Fix Report</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Segoe UI',system-ui,sans-serif;background:#f0f4ff;padding:30px 16px;color:#1a1a2e}
.wrap{max-width:900px;margin:0 auto}
h1{font-size:24px;font-weight:800;color:#061B33;margin-bottom:4px}
.sub{color:#4A5568;font-size:14px;margin-bottom:24px}
.card{background:white;border-radius:12px;padding:24px;margin-bottom:20px;box-shadow:0 2px 12px rgba(10,76,127,.08)}
.card h2{font-size:16px;font-weight:700;color:#061B33;margin-bottom:14px;padding-bottom:10px;border-bottom:2px solid #f0f4ff}
.badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:700;margin-right:6px}
.ok{background:#e8f5e9;color:#2e7d32}.err{background:#ffebee;color:#c62828}.warn{background:#fff3e0;color:#e65100}.new{background:#e3f2fd;color:#1565c0}.pub{background:#f3e5f5;color:#6a1b9a}
.fix-list,.report-list,.error-list{list-style:none;font-size:14px;line-height:1.8}
.fix-list li{color:#1b5e20;padding:3px 0}.error-list li{color:#b71c1c;padding:4px 0;font-weight:600}
.page-table{width:100%;border-collapse:collapse;font-size:13px}
.page-table th{background:#061B33;color:white;padding:10px 12px;text-align:left;font-weight:600}
.page-table td{padding:9px 12px;border-bottom:1px solid #f0f4ff}
.page-table tr:hover td{background:#f8f9ff}
.actions{display:flex;gap:10px;flex-wrap:wrap;margin-top:10px}
.btn{display:inline-flex;align-items:center;gap:6px;padding:11px 20px;border-radius:8px;font-weight:700;font-size:13px;text-decoration:none;cursor:pointer;border:none}
.btn-orange{background:#FFA866;color:white}.btn-blue{background:#0A4C7F;color:white}.btn-red{background:#ef4444;color:white}
.code-block{background:#061B33;color:#D8E4F0;padding:16px;border-radius:8px;font-family:monospace;font-size:12px;white-space:pre-wrap;margin-top:10px;line-height:1.7}
.warn-banner{background:#fff3e0;border:2px solid #FFA866;border-radius:10px;padding:16px 20px;margin-bottom:20px;font-weight:700;color:#854d0e;font-size:14px}
.host-info{background:#e3f2fd;border-radius:8px;padding:12px 16px;font-size:13px;color:#1565c0;margin-bottom:16px}
</style>
</head>
<body>
<div class="wrap">

<h1>⚡ TGNE 404 Fix Report</h1>
<p class="sub">Generated: <?php echo date('Y-m-d H:i:s T'); ?> | WordPress <?php echo get_bloginfo('version'); ?> | Site: <?php echo esc_html(home_url()); ?></p>

<div class="warn-banner">
    🗑️ DELETE <code>tgne-fix.php</code> from your server immediately after reading this report!
</div>

<!-- HOST INFO -->
<div class="host-info">
    🖥️ Server: <strong><?php echo esc_html($server_software); ?></strong>
    <?php if($is_nginx): ?> — <strong>NGINX detected</strong> (.htaccess does NOT apply — see Nginx fix below)<?php endif; ?>
    <?php if($is_cpanel): ?> | cPanel detected<?php endif; ?>
    | PHP <?php echo PHP_VERSION; ?>
    | ABSPATH: <code><?php echo esc_html(ABSPATH); ?></code>
</div>

<!-- ERRORS (show first if any) -->
<?php if (!empty($errors)): ?>
<div class="card" style="border:2px solid #ef4444">
    <h2>❌ Issues Found — Action Required</h2>
    <ul class="error-list">
        <?php foreach($errors as $e): ?>
        <li>→ <?php echo $e; ?></li>
        <?php endforeach; ?>
    </ul>

    <?php if($is_nginx): ?>
    <h3 style="margin-top:16px;color:#b71c1c">Nginx Fix Required</h3>
    <p style="font-size:13px;margin:8px 0">Nginx does not use .htaccess. Add this to your Nginx server block config:</p>
    <div class="code-block">location / {
    try_files $uri $uri/ /index.php?$args;
}</div>
    <p style="font-size:13px;margin-top:8px">Then restart Nginx: <code>sudo systemctl restart nginx</code></p>
    <?php endif; ?>

    <?php if(!$ht_ok && !$is_nginx): ?>
    <h3 style="margin-top:16px;color:#b71c1c">Manual .htaccess Content</h3>
    <p style="font-size:13px;margin:8px 0">Create a file called <code>.htaccess</code> in your WordPress root with this exact content:</p>
    <div class="code-block"><?php echo htmlspecialchars($ht_content); ?></div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- FIXES APPLIED -->
<?php if (!empty($fixes)): ?>
<div class="card">
    <h2>🔧 Fixes Applied</h2>
    <ul class="fix-list">
        <?php foreach($fixes as $f): ?><li>✅ <?php echo esc_html($f); ?></li><?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<!-- DIAGNOSTICS -->
<div class="card">
    <h2>📋 Diagnostics</h2>
    <ul class="report-list">
        <?php foreach($report as $r): ?><li><?php echo $r; ?></li><?php endforeach; ?>
    </ul>
</div>

<!-- PAGE STATUS -->
<div class="card">
    <h2>📄 Page Status (<?php echo count($page_results); ?> pages — <?php echo $created_count; ?> created, <?php echo $ok_count; ?> verified, <?php echo $error_count; ?> errors)</h2>
    <table class="page-table">
        <thead><tr><th>Slug</th><th>Status</th><th>ID</th><th>URL (click to test)</th></tr></thead>
        <tbody>
        <?php foreach($page_results as $slug => $r):
            $badge = match($r['status']) {
                'created'   => '<span class="badge new">CREATED</span>',
                'ok'        => '<span class="badge ok">OK</span>',
                'published' => '<span class="badge pub">PUBLISHED</span>',
                default     => '<span class="badge err">ERROR</span>',
            };
        ?>
        <tr>
            <td><code>/<?php echo esc_html($slug); ?>/</code></td>
            <td><?php echo $badge; ?></td>
            <td><?php echo $r['id'] ?: '—'; ?></td>
            <td><?php if($r['url']): ?><a href="<?php echo esc_url($r['url']); ?>" target="_blank" style="color:#0A4C7F;font-size:12px"><?php echo esc_html($r['url']); ?></a><?php else: ?>—<?php endif; ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- NEXT STEPS -->
<div class="card">
    <h2>🚀 What To Do Next</h2>
    <ol style="padding-left:20px;font-size:14px;line-height:2">
        <li><strong>Go to WordPress Admin → Settings → Permalinks</strong> → click <strong>Save Changes</strong> (even without changing anything — this flushes rules)</li>
        <li>Click the links in the table above to test each page — they should load (blank but no 404)</li>
        <li>For each page: <strong>Edit in Elementor → Add HTML Widget → Paste the .html file content → Save &amp; Publish</strong></li>
        <li>If pages still 404 after step 1: your host may need <strong>mod_rewrite enabled</strong> — contact cPanel or hosting support</li>
        <li><strong>Delete tgne-fix.php from your server!</strong></li>
    </ol>

    <div class="actions" style="margin-top:20px">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-orange" target="_blank">🏠 Test Homepage</a>
        <a href="<?php echo esc_url(admin_url('edit.php?post_type=page')); ?>" class="btn btn-blue">📄 All Pages in WP</a>
        <a href="<?php echo esc_url(admin_url('options-permalink.php')); ?>" class="btn btn-blue">🔗 Permalink Settings</a>
    </div>
</div>

<!-- cPanel SPECIFIC HELP -->
<?php if($is_cpanel): ?>
<div class="card" style="border:1px solid #FFA866">
    <h2>💡 cPanel / Hostinger / GreenGeeks Specific Fix</h2>
    <ol style="padding-left:20px;font-size:14px;line-height:2.2">
        <li>Log into <strong>cPanel → File Manager</strong></li>
        <li>Navigate to <code>public_html/</code> (your WordPress root)</li>
        <li>Look for <code>.htaccess</code> — if missing, click <strong>+ File</strong> to create it</li>
        <li>Right-click .htaccess → <strong>Edit</strong> → paste the content below → Save</li>
        <li>Also check: cPanel → <strong>Apache Handlers</strong> or <strong>MultiPHP Manager</strong> to ensure mod_rewrite is on</li>
    </ol>
    <div class="code-block"><?php echo htmlspecialchars($ht_content); ?></div>
</div>
<?php endif; ?>

</div><!-- .wrap -->
</body>
</html>
