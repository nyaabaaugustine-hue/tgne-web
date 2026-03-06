<?php
/**
 * Enhanced Server Capability Check
 * Add this file to includes/main/Demo/enhanced-server-capability-check.php
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class Theme_Server_Capability_Check {
    /**
     * Singleton instance
     */
    private static $instance = null;
    
    /**
     * Get singleton instance
     * 
     * @return Theme_Server_Capability_Check
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor to set up AJAX handlers and scripts
     */
    private function __construct() {
        // Register AJAX action for server check refresh
        add_action('wp_ajax_refresh_server_check', array($this, 'ajax_refresh_server_check'));
         
    }
    
    /**
     * Convert memory/file size string to bytes
     * 
     * @param string $value Size value (e.g., '128M')
     * @return int Size in bytes
     */
    private static function convert_to_bytes($value) {
        $value = trim($value);
        $last = strtolower(substr($value, -1));
        $numeric_value = (int)$value;
        
        switch ($last) {
            case 'g':
                $numeric_value *= 1024;
            case 'm':
                $numeric_value *= 1024;
            case 'k':
                $numeric_value *= 1024;
        }
        
        return $numeric_value;
    }
    
    /**
     * Format bytes to human-readable format
     * 
     * @param int $bytes The number of bytes
     * @param int $precision Decimal precision
     * @return string Formatted size
     */
    private static function format_bytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Check server capabilities for import with extended checks
     * 
     * @return array Server capability check results
     */
    public static function check_server_capabilities() {
        // Add this caching code at the beginning
        $cached_results = get_transient('theme_server_capability_results');
        if ($cached_results !== false) {
            return $cached_results;
        }
        
        $capabilities = array(
            'php_version' => array(
                'status' => version_compare(PHP_VERSION, '7.4', '>=') ? 'good' : 
                           (version_compare(PHP_VERSION, '7.0', '>=') ? 'warning' : 'bad'),
                'value'  => PHP_VERSION,
                'recommendation' => '7.4 or higher'
            ),
            'allow_url_fopen' => array(
                'status' => ini_get('allow_url_fopen') ? 'good' : 'bad',
                'value'  => ini_get('allow_url_fopen') ? 'Enabled' : 'Disabled',
                'recommendation' => 'Enabled'
            ),
            'max_execution_time' => array(
                'status' => (int)ini_get('max_execution_time') >= 300 || ini_get('max_execution_time') == 0 ? 'good' : 
                           ((int)ini_get('max_execution_time') >= 180 ? 'warning' : 'bad'),
                'value'  => ini_get('max_execution_time') == 0 ? 'Unlimited' : ini_get('max_execution_time') . ' seconds',
                'recommendation' => '300 seconds or more'
            ),
            'memory_limit' => array(
                'status' => self::convert_to_bytes(ini_get('memory_limit')) >= 268435456 ? 'good' : 
                           (self::convert_to_bytes(ini_get('memory_limit')) >= 134217728 ? 'warning' : 'bad'),
                'value'  => ini_get('memory_limit') . ' (' . self::format_bytes(self::convert_to_bytes(ini_get('memory_limit'))) . ')',
                'recommendation' => '256MB or more'
            ),
            'max_input_time' => array(
                'status' => (int)ini_get('max_input_time') >= 300 || ini_get('max_input_time') == -1 ? 'good' : 
                           ((int)ini_get('max_input_time') >= 180 ? 'warning' : 'bad'),
                'value'  => ini_get('max_input_time') == -1 ? 'Unlimited' : ini_get('max_input_time') . ' seconds',
                'recommendation' => '300 seconds or more'
            ),
            'upload_max_filesize' => array(
                'status' => self::convert_to_bytes(ini_get('upload_max_filesize')) >= 268435456 ? 'good' : 
                           (self::convert_to_bytes(ini_get('upload_max_filesize')) >= 41943040 ? 'warning' : 'bad'),
                'value'  => ini_get('upload_max_filesize') . ' (' . self::format_bytes(self::convert_to_bytes(ini_get('upload_max_filesize'))) . ')',
                'recommendation' => '256MB or more'
            ),
            'post_max_size' => array(
                'status' => self::convert_to_bytes(ini_get('post_max_size')) >= 268435456 ? 'good' : 
                           (self::convert_to_bytes(ini_get('post_max_size')) >= 41943040 ? 'warning' : 'bad'),
                'value'  => ini_get('post_max_size') . ' (' . self::format_bytes(self::convert_to_bytes(ini_get('post_max_size'))) . ')',
                'recommendation' => '256MB or more'
            ),
            'max_input_vars' => array(
                'status' => (int)ini_get('max_input_vars') >= 5000 ? 'good' : 
                           ((int)ini_get('max_input_vars') >= 3000 ? 'warning' : 'bad'),
                'value'  => ini_get('max_input_vars'),
                'recommendation' => '5000 or more'
            ),
            'curl' => array(
                'status' => function_exists('curl_version') ? 'good' : 'bad',
                'value'  => function_exists('curl_version') ? 'Enabled' : 'Disabled',
                'recommendation' => 'Enabled'
            ),
            'zip' => array(
                'status' => class_exists('ZipArchive') ? 'good' : 'bad',
                'value'  => class_exists('ZipArchive') ? 'Enabled' : 'Disabled',
                'recommendation' => 'Enabled'
            ),
            'file_get_contents' => array(
                'status' => function_exists('file_get_contents') ? 'good' : 'bad',
                'value'  => function_exists('file_get_contents') ? 'Enabled' : 'Disabled',
                'recommendation' => 'Enabled'
            ),
            'dom_extension' => array(
                'status' => extension_loaded('dom') ? 'good' : 'warning',
                'value'  => extension_loaded('dom') ? 'Enabled' : 'Disabled',
                'recommendation' => 'Enabled'
            ),
            'xml_extension' => array(
                'status' => extension_loaded('xml') ? 'good' : 'warning',
                'value'  => extension_loaded('xml') ? 'Enabled' : 'Disabled',
                'recommendation' => 'Enabled'
            ),
            'mysql_version' => array(
                'status' => self::get_mysql_version_status(),
                'value'  => self::get_mysql_version(),
                'recommendation' => '5.6 or higher'
            ),
        );
        
        // Check WordPress upload directory is writable
        $upload_dir = wp_upload_dir();
        $upload_dir_writable = wp_is_writable($upload_dir['basedir']);
        $capabilities['upload_dir_writable'] = array(
            'status' => $upload_dir_writable ? 'good' : 'bad',
            'value'  => $upload_dir_writable ? 'Writable' : 'Not Writable',
            'recommendation' => 'Writable'
        );
        
        // Check available disk space
        $disk_space = self::get_available_disk_space($upload_dir['basedir']);
        $capabilities['available_disk_space'] = array(
            'status' => $disk_space['bytes'] >= 104857600 ? 'good' : 
                       ($disk_space['bytes'] >= 52428800 ? 'warning' : 'bad'),
            'value'  => $disk_space['formatted'],
            'recommendation' => '100MB or more'
        );
        
        // Test database write permissions
        $db_write_test = self::test_database_write_permissions();
        $capabilities['database_write_permissions'] = array(
            'status' => $db_write_test['success'] ? 'good' : 'bad',
            'value'  => $db_write_test['success'] ? 'Yes' : 'No - ' . $db_write_test['message'],
            'recommendation' => 'Required for import'
        );
        
        // Check for transient support
        $test_transient = set_transient('theme_test_transient', 'test', 60);
        $capabilities['transient_support'] = array(
            'status' => $test_transient ? 'good' : 'warning',
            'value'  => $test_transient ? 'Working' : 'Not working properly',
            'recommendation' => 'Working'
        );
        delete_transient('theme_test_transient');
        
        // Check for outbound connections
        $response = wp_remote_get('https://api.wordpress.org/');
        $capabilities['outbound_connections'] = array(
            'status' => !is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200 ? 'good' : 'bad',
            'value'  => !is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200 ? 'Working' : 'Not working properly',
            'recommendation' => 'Working'
        );
        
        // Check active plugins count
        $active_plugins = get_option('active_plugins');
        $plugin_count = count($active_plugins);
        $capabilities['active_plugins'] = array(
            'status' => $plugin_count < 20 ? 'good' : ($plugin_count < 30 ? 'warning' : 'bad'),
            'value'  => $plugin_count,
            'recommendation' => 'Less than 20 for optimal performance'
        );
        
        // Check WordPress memory limit
        $wp_memory_limit = WP_MEMORY_LIMIT;
        $capabilities['wp_memory_limit'] = array(
            'status' => self::convert_to_bytes($wp_memory_limit) >= 268435456 ? 'good' : 
                       (self::convert_to_bytes($wp_memory_limit) >= 134217728 ? 'warning' : 'bad'),
            'value'  => $wp_memory_limit . ' (' . self::format_bytes(self::convert_to_bytes($wp_memory_limit)) . ')',
            'recommendation' => '256MB or more'
        );
         
        // Add this caching code before the return statement
        set_transient('theme_server_capability_results', $capabilities, HOUR_IN_SECONDS * 6); // Cache for 6 hours
        
        return $capabilities;
    }
    
    /**
     * Get MySQL version
     */
    private static function get_mysql_version() {
        global $wpdb;
        return $wpdb->db_version();
    }
    
    /**
     * Get MySQL version status
     */
    private static function get_mysql_version_status() {
        $version = self::get_mysql_version();
        if (version_compare($version, '5.6', '>=')) {
            return 'good';
        } elseif (version_compare($version, '5.0', '>=')) {
            return 'warning';
        }
        return 'bad';
    }
    
    /**
     * Get available disk space
     */
    private static function get_available_disk_space($path) {
        if (function_exists('disk_free_space')) {
            $bytes = @disk_free_space($path);
            if ($bytes === false) {
                return array(
                    'bytes' => 0,
                    'formatted' => 'Unknown'
                );
            }
            return array(
                'bytes' => $bytes,
                'formatted' => self::format_bytes($bytes)
            );
        }
        return array(
            'bytes' => 0,
            'formatted' => 'Unknown (disk_free_space function not available)'
        );
    }
    
    /**
     * Test database write permissions
     */
    private static function test_database_write_permissions() {
        global $wpdb;
        
        $test_table_name = $wpdb->prefix . 'test_import_capability';
        $result = array(
            'success' => false,
            'message' => ''
        );
        
        // Try to create a test table
        $create_query = "CREATE TABLE IF NOT EXISTS $test_table_name (
            id INT AUTO_INCREMENT PRIMARY KEY,
            test_value VARCHAR(255)
        )";
        
        if ($wpdb->query($create_query) === false) {
            $result['message'] = 'Cannot create tables';
            return $result;
        }
        
        // Try to insert data
        $insert_result = $wpdb->insert(
            $test_table_name,
            array('test_value' => 'test_' . time()),
            array('%s')
        );
        
        if ($insert_result === false) {
            $result['message'] = 'Cannot insert data';
            // Clean up
            $wpdb->query("DROP TABLE IF EXISTS $test_table_name");
            return $result;
        }
        
        // Try to delete data
        $delete_result = $wpdb->delete(
            $test_table_name,
            array('id' => $wpdb->insert_id),
            array('%d')
        );
        
        if ($delete_result === false) {
            $result['message'] = 'Cannot delete data';
            // Clean up
            $wpdb->query("DROP TABLE IF EXISTS $test_table_name");
            return $result;
        }
        
        // Drop the test table
        $wpdb->query("DROP TABLE IF EXISTS $test_table_name");
        
        $result['success'] = true;
        return $result;
    }
    
    /**
     * Get overall server status
     * 
     * @return string Status: 'good', 'warning', or 'critical'
     */
    public static function get_server_status() {
        $capabilities = self::check_server_capabilities();
        $has_critical = false;
        $has_warning = false;
        
        foreach ($capabilities as $capability) {
            if ($capability['status'] === 'bad') {
                $has_critical = true;
            } elseif ($capability['status'] === 'warning') {
                $has_warning = true;
            }
        }
        
        if ($has_critical) {
            return 'critical';
        } elseif ($has_warning) {
            return 'warning';
        } else {
            return 'good';
        }
    }
    
    /**
     * Get critical issues
     * 
     * @return array Critical issues
     */
    public static function get_critical_issues() {
        $capabilities = self::check_server_capabilities();
        $critical_issues = array();
        
        foreach ($capabilities as $key => $capability) {
            if ($capability['status'] === 'bad') {
                $critical_issues[$key] = $capability;
            }
        }
        
        return $critical_issues;
    }
    
    /**
     * Get warning issues
     * 
     * @return array Warning issues
     */
    public static function get_warning_issues() {
        $capabilities = self::check_server_capabilities();
        $warning_issues = array();
        
        foreach ($capabilities as $key => $capability) {
            if ($capability['status'] === 'warning') {
                $warning_issues[$key] = $capability;
            }
        }
        
        return $warning_issues;
    }
    
    /**
     * Clear server capability check cache
     */
    public static function clear_server_capability_cache() {
        return delete_transient('theme_server_capability_results');
    }
    
    /**
     * Display server capability check results
     */
    public static function display_server_capability_check() {
        $capabilities = self::check_server_capabilities();
        $critical_issues = self::get_critical_issues();
        $warning_issues = self::get_warning_issues();
        
        // Get overall status
        $overall_status = self::get_server_status();
        
        // Display capability check results
        ?>
    <div class="server-check_box         <?php if ($overall_status !== 'good'): ?> two_part_box  <?php endif ?>">
        <div class="server-check left">
            <div class="server-check-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h3 style="margin: 0;"><?php _e('Server Capability Check', 'creote'); ?></h3>
                <button type="button" id="refresh-server-check" class="button button-secondary">
                    <span class="dashicons dashicons-update" style="margin-top: 3px; margin-right: 5px;"></span>
                    <?php _e('Refresh Server Check', 'creote'); ?>
                </button>
            </div>
            <p class="description"><?php _e('If you have updated your server configuration, click the Refresh button to see the latest values.', 'creote'); ?></p>
            
            <?php if ($overall_status === 'critical'): ?>
                <div class="notice notice-error">
                    <p><strong><?php _e('Critical Issues Detected', 'creote'); ?></strong></p>
                    <p><?php _e('Your server configuration has critical issues that may prevent the demo import from working properly. Please resolve these issues before proceeding.', 'creote'); ?></p>
                </div>
            <?php elseif ($overall_status === 'warning'): ?>
                <div class="notice notice-warning">
                    <p><strong><?php _e('Potential Issues Detected', 'creote'); ?></strong></p>
                    <p><?php _e('Your server configuration has some issues that may affect the demo import process. Consider resolving these issues for a better experience.', 'creote'); ?></p>
                </div>
            <?php else: ?>
                <div class="notice notice-success">
                    <p><strong><?php _e('All Good!', 'creote'); ?></strong></p>
                    <p><?php _e('Your server configuration looks good! The demo import should work without any issues.', 'creote'); ?></p>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($critical_issues)): ?>
                <div class="critical-issues">
                    <h4><?php _e('Critical Issues', 'creote'); ?></h4>
                    <p><?php _e('The following issues must be fixed for the import to work properly:', 'creote'); ?></p>
                    <ul>
                        <?php foreach ($critical_issues as $key => $issue): ?>
                            <li>
                                <strong><?php echo esc_html(ucwords(str_replace('_', ' ', $key))); ?>:</strong> 
                                <?php echo esc_html($issue['value']); ?> -
                                <?php _e('Recommended:', 'creote'); ?> <?php echo esc_html($issue['recommendation']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <table class="server-check-table">
                <thead>
                    <tr>
                        <th><?php _e('Setting', 'creote'); ?></th>
                        <th><?php _e('Current Value', 'creote'); ?></th>
                        <th><?php _e('Recommended', 'creote'); ?></th>
                        <th><?php _e('Status', 'creote'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($capabilities as $name => $capability): ?>
                        <tr>
                            <td><?php echo esc_html(ucwords(str_replace('_', ' ', $name))); ?></td>
                            <td><?php echo esc_html($capability['value']); ?></td>
                            <td><?php echo esc_html($capability['recommendation']); ?></td>
                            <td>
                                <span class="status status-<?php echo esc_attr($capability['status']); ?>">
                                    <?php if ($capability['status'] === 'good'): ?>
                                        <span class="dashicons dashicons-yes-alt"></span>
                                    <?php elseif ($capability['status'] === 'warning'): ?>
                                        <span class="dashicons dashicons-warning"></span>
                                    <?php else: ?>
                                        <span class="dashicons dashicons-no-alt"></span>
                                    <?php endif; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
          
            <?php if ($overall_status !== 'good'): ?>
                <div class="server-check right">
                <div class="server-check-help">
                    <h4><?php _e('How to Resolve Server Issues', 'creote'); ?></h4>
                    <p><?php _e('Try these solutions to fix the issues above:', 'creote'); ?></p>
                    
                    <h5><?php _e('Option 1: Contact Your Hosting Provider', 'creote'); ?></h5>
                    <p><?php _e('Ask your hosting provider to increase these PHP limits for your account:', 'creote'); ?></p>
                    <ul>
                        <li>memory_limit: 256M or higher</li>
                        <li>max_execution_time: 300 seconds or higher</li>
                        <li>upload_max_filesize: 256M or higher</li>
                        <li>post_max_size: 256M or higher</li>
                        <li>max_input_vars: 5000 or higher</li>
                        <li>max_input_time: 300 seconds or higher</li>
                    </ul>
                    
                    <h5><?php _e('Option 2: Modify wp-config.php File', 'creote'); ?></h5>
                    <p><?php _e('Add the following to your wp-config.php file before the line that says "That\'s all, stop editing! Happy publishing.":', 'creote'); ?></p>
                    <pre><code>
/* Increase memory limits */
define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');

/* Increase timeout */
set_time_limit(300);
                    </code></pre>
                    
                    <h5><?php _e('Option 3: Create or Modify .htaccess File', 'creote'); ?></h5>
                    <p><?php _e('If you\'re on an Apache server, add these lines to your .htaccess file:', 'creote'); ?></p>
                    <pre><code>
# PHP Settings
php_value memory_limit 256M
php_value upload_max_filesize 256M
php_value post_max_size 256M
php_value max_execution_time 300
php_value max_input_time 300
php_value max_input_vars 5000
                    </code></pre>
                    
                    <h5><?php _e('Option 4: Use Manual Import', 'creote'); ?></h5>
                    <p><?php _e('If you cannot resolve these issues, use the "Manual Import" option which breaks the import into smaller chunks that are less likely to hit limits.', 'creote'); ?></p>
                </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
 
    /**
     * AJAX handler to refresh server capability check
     */
    public function ajax_refresh_server_check() {
        // Verify nonce for security
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'refresh_server_check_nonce')) {
            wp_send_json_error(array('message' => 'Security check failed'));
            exit;
        }
        
        // Clear the cache
        $success = self::clear_server_capability_cache();
        
        if ($success) {
            wp_send_json_success(array('message' => 'Server check cache cleared successfully'));
        } else {
            wp_send_json_error(array('message' => 'Failed to clear server check cache'));
        }
        
        exit;
    }

   
}

// Initialize the class
add_action('init', array('Theme_Server_Capability_Check', 'get_instance'));