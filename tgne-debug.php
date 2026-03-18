<?php
/**
 * TGNE WordPress Debug Enabler
 *
 * INSTRUCTIONS:
 * 1. Upload to your WordPress ROOT (same folder as wp-config.php)
 * 2. Visit: https://tgnenewsite.tgnesolutions.com/tgne-debug.php?key=tgne2026fix
 * 3. It will temporarily enable WP_DEBUG so errors show on screen
 * 4. Then visit your site to see the actual error message
 * 5. DELETE this file after use!
 *
 * OR — directly edit wp-config.php and add before "That's all":
 *   define( 'WP_DEBUG', true );
 *   define( 'WP_DEBUG_DISPLAY', true );
 *   define( 'WP_DEBUG_LOG', true );
 *   ini_set( 'display_errors', 1 );
 */

if ( ! isset( $_GET['key'] ) || $_GET['key'] !== 'tgne2026fix' ) {
    die( 'Add ?key=tgne2026fix to URL' );
}

$wp_config = dirname(__FILE__) . '/wp-config.php';
if ( ! file_exists($wp_config) ) {
    die('wp-config.php not found in: ' . dirname(__FILE__));
}

$content = file_get_contents($wp_config);

// Check current debug state
$debug_on = strpos($content, "define( 'WP_DEBUG', true )") !== false;

if ( isset($_GET['action']) && $_GET['action'] === 'enable' ) {
    // Enable debug
    $debug_code = "\n// TGNE Debug - REMOVE AFTER USE\ndefine( 'WP_DEBUG', true );\ndefine( 'WP_DEBUG_DISPLAY', true );\ndefine( 'WP_DEBUG_LOG', true );\nini_set( 'display_errors', 1 );\nini_set( 'error_reporting', E_ALL );\n";
    
    // Remove existing debug lines first
    $content = preg_replace("/\/\/ TGNE Debug.*?ini_set\s*\(\s*'error_reporting'.*?\);\n/s", '', $content);
    // Also remove existing WP_DEBUG defines
    $content = preg_replace("/define\s*\(\s*'WP_DEBUG'[^;]+;\n?/", '', $content);
    $content = preg_replace("/define\s*\(\s*'WP_DEBUG_DISPLAY'[^;]+;\n?/", '', $content);
    $content = preg_replace("/define\s*\(\s*'WP_DEBUG_LOG'[^;]+;\n?/", '', $content);
    
    // Insert before "That's all"
    $content = str_replace("/* That's all", $debug_code . "\n/* That's all", $content);
    
    if ( file_put_contents($wp_config, $content) ) {
        header('Location: /tgne-debug.php?key=tgne2026fix&msg=enabled');
        exit;
    } else {
        die('Cannot write wp-config.php — check file permissions (should be 644)');
    }
}

if ( isset($_GET['action']) && $_GET['action'] === 'disable' ) {
    // Remove debug lines
    $content = preg_replace("/\/\/ TGNE Debug.*?ini_set\s*\(\s*'error_reporting'.*?\);\n/s", '', $content);
    $content = preg_replace("/define\s*\(\s*'WP_DEBUG'\s*,\s*true\s*\)\s*;\n?/", "define( 'WP_DEBUG', false );\n", $content);
    
    if ( file_put_contents($wp_config, $content) ) {
        header('Location: /tgne-debug.php?key=tgne2026fix&msg=disabled');
        exit;
    }
}

if ( isset($_GET['action']) && $_GET['action'] === 'clear_log' ) {
    $log_file = dirname(__FILE__) . '/wp-content/debug.log';
    if ( file_exists($log_file) ) unlink($log_file);
    header('Location: /tgne-debug.php?key=tgne2026fix');
    exit;
}

$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>TGNE Debug Control</title>
<style>
body{font-family:system-ui,sans-serif;background:#f0f4ff;padding:40px 20px;color:#1a1a2e}
.box{max-width:600px;margin:0 auto;background:white;border-radius:12px;padding:32px;box-shadow:0 4px 20px rgba(10,76,127,.1)}
h1{color:#061B33;margin:0 0 8px}
.status{padding:12px 16px;border-radius:8px;margin:16px 0;font-weight:600}
.on{background:#ffebee;color:#c62828;border:1px solid #ef9a9a}
.off{background:#e8f5e9;color:#2e7d32;border:1px solid #a5d6a7}
.btn{display:inline-block;padding:12px 24px;border-radius:8px;font-weight:700;font-size:14px;text-decoration:none;margin:4px}
.btn-red{background:#ef4444;color:white}
.btn-green{background:#4CAF88;color:white}
.btn-blue{background:#0A4C7F;color:white}
.warn{background:#fff3e0;border:1px solid #FFA866;border-radius:8px;padding:12px 16px;margin-top:16px;font-size:13px}
pre{background:#061B33;color:#D8E4F0;padding:16px;border-radius:8px;font-size:12px;line-height:1.6;margin-top:16px;white-space:pre-wrap}
</style>
</head>
<body>
<div class="box">
<h1>🐛 TGNE Debug Control</h1>
<p>wp-config.php: <code><?php echo htmlspecialchars($wp_config); ?></code></p>

<?php if ($msg === 'enabled'): ?>
<div class="status on">✅ Debug mode ENABLED — visit your site now to see the error!</div>
<?php elseif ($msg === 'disabled'): ?>
<div class="status off">✅ Debug mode DISABLED — site back to normal</div>
<?php endif; ?>

<div class="status <?php echo $debug_on ? 'on' : 'off'; ?>">
    Debug is currently: <strong><?php echo $debug_on ? 'ON (errors will show)' : 'OFF (normal mode)'; ?></strong>
</div>

<p>
    <a href="?key=tgne2026fix&action=enable" class="btn btn-red">🔴 Enable Debug (show errors)</a>
    <a href="?key=tgne2026fix&action=disable" class="btn btn-green">🟢 Disable Debug (normal)</a>
    <a href="/" class="btn btn-blue" target="_blank">🏠 Visit Site</a>
</p>

<div class="warn">
⚠️ <strong>After enabling debug:</strong> Visit your site — the white screen will show the actual PHP error.<br>
Then come back here and click "Disable Debug" when done.<br>
<strong>Delete tgne-debug.php from the server after use!</strong>
</div>

<?php
$log_file = dirname(__FILE__) . '/wp-content/debug.log';
if ( file_exists($log_file) && filesize($log_file) > 0 ) {
    $log_size = filesize($log_file);
    $read_len = min(4096, $log_size); // Read last 4KB
    $log_content = file_get_contents($log_file, false, null, $log_size - $read_len);
    echo '<div style="margin-top:24px;border-top:2px solid #eee;padding-top:16px;">';
    echo '<h3 style="margin:0 0 8px">📄 Last Recorded Errors (wp-content/debug.log)</h3>';
    echo '<pre style="max-height:400px;overflow:auto;background:#f8f9fa;color:#c62828;border:1px solid #ddd;">' . htmlspecialchars($log_content) . '</pre>';
    echo '<a href="?key=tgne2026fix&action=clear_log" class="btn btn-blue" style="font-size:12px;padding:8px 16px;">🗑️ Clear Log</a>';
    echo '</div>';
}
?>

<h3>Manual wp-config.php fix</h3>
<p>Find <code>/* That's all, stop editing! */</code> in wp-config.php and add this BEFORE it:</p>
<pre>define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'WP_DEBUG_LOG', true );
ini_set( 'display_errors', 1 );</pre>

</div>
</body>
</html>
