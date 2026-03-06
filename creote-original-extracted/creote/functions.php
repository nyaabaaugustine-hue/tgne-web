<?php
/*
 *=================================
 * Creote Functions and Definitions
 * @package Creote WordPress Theme
 *==================================
*/
// ============================== theme file get ============================
require_once get_template_directory() . '/includes/Mobile_Detect.php';
// Merlin
 
function creote_get_option($option_name, $default_value = '') {
    if (class_exists('Redux')) {
        return Redux::get_option('creote_theme_mod', $option_name, $default_value);
    }
    
    $redux_options = get_option('creote_theme_mod');
    return isset($redux_options[$option_name]) ? $redux_options[$option_name] : $default_value;
}
// Mobile Detect callback
function isMobile() {
    if ( ! class_exists( 'Mobile_Detect' ) ) {
        return false;
    }
    // Validate Mobile_Detect version
    if (!defined('MOBILE_DETECT_VERSION') || version_compare(MOBILE_DETECT_VERSION, '2.8.0', '<')) {
        return false;
    }
    $detect = new Mobile_Detect();
    return ($detect->isMobile() || $detect->isTablet());
}
if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
  }

require_once get_template_directory() . '/includes/theme-file.php'; 
if(class_exists('Creote_Addons')):
add_action( 'vc_before_init', 'creote_vc_remove_css' );
function creote_vc_remove_css() {
    vc_remove_param('vc_row', 'css');
}
endif;
// ============================== theme update - VERIFICATION REMOVED ============================
add_action('init', 'creote_disable_elementor_onboarding_redirect');
function creote_disable_elementor_onboarding_redirect() {
    delete_transient( 'elementor_activation_redirect' );
}
// ============================== Elementor Register Location ============================
function creote_register_elementor_locations( $elementor_theme_manager ) {
    if (!current_user_can('edit_theme_options')) {
        return;
    }
    
    // Validate manager
    if (!method_exists($elementor_theme_manager, 'register_all_core_location')) {
        return;
    }
    $elementor_theme_manager->register_all_core_location();
	$elementor_theme_manager->register_location(
		'footer',
		[
			'hook' => 'creote_elementor_footer',
			'remove_hooks' => [ 'creote_print_elementor_footer' ],
		]
	);
    $elementor_theme_manager->register_location(
		'header',
		[
			'hook' => 'creote_elementor_header',
			'remove_hooks' => [ 'creote_print_elementor_header' ],
		]
	);
	 
}
add_action( 'elementor/theme/register_locations', 'creote_register_elementor_locations' );

// Theme footer
function creote_print_elementor_footer() {
	get_template_part( 'templates-parts/footer' );  
}
add_action( 'creote_elementor_footer', 'creote_print_elementor_footer' );
// Theme header
function creote_print_elementor_header() {
    ?>
	    <?php get_template_part( 'templates-parts/header' ); ?>
    <?php
}
add_action( 'creote_elementor_header', 'creote_print_elementor_header' );
// ============================== Elementor Register Location ============================
 
 
/**
 * Add admin notice for plugin updates.
 */
 add_action('admin_notices', 'custom_plugin_update_notice');

function custom_plugin_update_notice() {
    // URL to the hosted version.json file
    $json_url = 'https://themepanthers.com/updatedplugin/plugins.json';

    // Fetch the JSON file
    $response = wp_remote_get($json_url);

    // Check for errors
    if (is_wp_error($response)) {
        return; // Exit if there's an error fetching the JSON
    }

    // Parse the JSON response
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!isset($data['plugins']) || !is_array($data['plugins'])) {
        return; // Exit if the JSON structure is invalid
    }

    foreach ($data['plugins'] as $plugin) {
        $plugin_path = WP_PLUGIN_DIR . '/' . $plugin['slug'] . '/' . $plugin['slug'] . '.php';

        if (file_exists($plugin_path)) {
            // Get installed plugin data
            $plugin_data = get_plugin_data($plugin_path);
            $installed_version = $plugin_data['Version'];

            // Compare versions
            if (version_compare($installed_version, $plugin['latest_version'], '<')) {
                // Installed version is outdated
                echo '<div class="notice notice-warning is-dismissible">';
                echo '<p>' . sprintf(
                    esc_html__('A new version of %s is available. Installed version: %s, Latest version: %s. You can download the update from %s.', 'risehand'),
                    '<strong>' . esc_html($plugin['name']) . '</strong>',
                    esc_html($installed_version),
                    esc_html($plugin['latest_version']),
                    '<a href="' . esc_url($plugin['source']) . '" target="_blank">' . esc_html__('here', 'risehand') . '</a>'
                ) . '</p>';
                echo '</div>';
            }
        } else {
            // Plugin is not installed
            echo '<div class="notice notice-warning is-dismissible">';
            echo '<p>' . sprintf(
                esc_html__('%s plugin is not installed. You can download it from %s.', 'risehand'),
                '<strong>' . esc_html($plugin['name']) . '</strong>',
                '<a href="' . esc_url($plugin['source']) . '" target="_blank">' . esc_html__('here', 'risehand') . '</a>'
            ) . '</p>';
            echo '</div>';
        }
    }
}


/**
 * Add admin notice for Ecom Theme promotion.
 */
add_action('admin_notices', 'ecom_theme_launch_notice');
function ecom_theme_launch_notice() {
    // Only run for admin users with manage_options capability
    if (!current_user_can('manage_options')) {
        return;
    }

    // Only show on dashboard or plugins page
    $screen = get_current_screen();
    if ($screen->base !== 'dashboard' && $screen->base !== 'plugins') {
        return;
    }

    // Check if notice was permanently dismissed
    if (get_option('ecom_theme_notice_dismissed') === 'permanent') {
        return;
    }

    // Generate nonce for AJAX
    $nonce = wp_create_nonce('ecom_dismiss_nonce');
    ?>
    <style>
        .ecom-admin-notice {
            border: 4px solid var(--color-set-one-2, #FD9636);
            background: var(--background-bg-1, #F0F3F8);
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 8px;
            font-family: var(--font-family-main, "DM Sans", sans-serif);
            color: var(--content-color-one, #425A8B);
            display: flex;
            align-items: center;
            gap: 15px;
            justify-content: space-between;
            position: relative;
        }
        .ecom-admin-notice img {
            width: 40%;
            height: auto;
            border-radius: 4px;
        }
        .ecom-admin-notice > div {
            width: 50%;
        }
        .ecom-admin-notice h2 {
            margin: 0 0 5px;
            font-size: 18px;
            color: var(--heading-color-one, #425A8B);
        }
        .ecom-admin-notice p {
            margin: 0;
            color: var(--content-color-two, #8C9EC5);
            font-size: 14px;
        }
        .ecom-notice-dismiss {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: var(--content-color-two, #8C9EC5);
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ecom-notice-dismiss:hover {
            color: var(--heading-color-one, #425A8B);
        }
    </style>
    <div class="notice notice-info ecom-admin-notice" id="ecom-admin-notice">
        <button class="ecom-notice-dismiss" onclick="dismissEcomNotice()" title="<?php echo esc_attr__('Dismiss permanently', 'risehand'); ?>">×</button>
        <img src="<?php echo esc_url('https://elango.steelthemes.com/ecom/ecom-promo.jpg'); ?>" alt="<?php echo esc_attr__('Ecom Theme', 'risehand'); ?>" />
        <div>
            <h2><strong><?php echo esc_html__('Ecom Multipurpose WooCommerce Theme', 'risehand'); ?></strong></h2>
            <p><?php
                printf(
                    esc_html__('Check the demos: %s | %s', 'risehand'),
                    '<a href="' . esc_url('https://elango.steelthemes.com/ecom/el1/') . '" target="_blank">' . esc_html__('Elementor Page Builder Version', 'risehand') . '</a>',
                    '<a href="' . esc_url('https://elango.steelthemes.com/ecom/wp1') . '" target="_blank">' . esc_html__('Wpbakery Page Builder Version', 'risehand') . '</a>'
                );
                ?><br>
                <?php
                printf(
                    esc_html__('🎉 Launched at just %s first release offer. The price will increase to $59 soon.', 'risehand'),
                    '<strong style="color: var(--color-set-one-2, #FD9636);">$13</strong>'
                );
                ?>
            </p>
            <br>
            <a href="<?php echo esc_url('https://themeforest.net/item/ecom-multipurpose-woocommerce-wp-theme/58774920'); ?>" class="button" target="_blank"><?php echo esc_html__('Purchase and Save 46$ Now', 'risehand'); ?></a>
        </div>
    </div>
    <script>
        function dismissEcomNotice() {
            // Hide the notice immediately
            document.getElementById('ecom-admin-notice').style.display = 'none';

            // Send AJAX request to save dismiss time
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo esc_url(admin_url('admin-ajax.php')); ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onerror = function() {
                alert('<?php echo esc_js(__('Failed to dismiss the notice. Please try again.', 'risehand')); ?>');
                document.getElementById('ecom-admin-notice').style.display = 'block';
            };
            xhr.send('action=dismiss_ecom_notice&nonce=<?php echo esc_js($nonce); ?>');
        }
    </script>
    <?php
}

/**
 * Handle AJAX request to dismiss the Ecom theme notice.
 */
add_action('wp_ajax_dismiss_ecom_notice', 'handle_dismiss_ecom_notice');
function handle_dismiss_ecom_notice() {
    // Verify nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'ecom_dismiss_nonce')) {
        wp_send_json_error('Security check failed', 403);
    }

    // Save permanent dismissal
    update_option('ecom_theme_notice_dismissed', 'permanent');

    wp_send_json_success();
}

/**
 * Reset the Ecom notice dismissal (for testing purposes).
 */
function reset_ecom_notice() {
    delete_option('ecom_theme_notice_dismissed');
}
 
 
add_action('admin_head', 'enqueue_admin_styles');
 function enqueue_admin_styles() {
  ?>
<style>
    :root{
     
    --color-set-one-1:#3f3eed;  
    --color-white:#ffffff!important; 
    --color-d-1:#121623!important; 
    --color-d-2:#161C29!important; 
}
    .creote_page_creote-more-themes , .appearance_page_install-required-plugins , .toplevel_page_creote , .creote_page_creote-theme-options , .appearance_page_one-click-demo-import ,.post-type-footer
        ,.post-type-header ,.post-type-mega_menu{

       
    #wpbody-content{
        width: 99%;
        
    }
    #wpcontent{
        padding: 0px 20px  10px!important;
    }
    .wrap{
        margin: 0px;
        padding-top: 10px!important;
    }
    .notice , .fs-notice , div.fs-notice.updated, div.fs-notice.success, div.fs-notice.promotion{
      display: none!important;
      visibility: hidden;
  }
  .ocdi__theme-about{
    display: none;
}
.admin-notice-creotes , .creote-activate-notice , .admin-notice-debug_enabled{
  display: block!important;
  visibility: visible;
}
    #wpfooter{
      position: relative;
    }
}
            .admin_dashboad {
                padding: 10px;
                margin-top:40px!important;
                background: var(--color-set-one-1);
                border: unset;
                text-align: center; 
                top: 20px;
                left: 0;
                right: 0;
                z-index: 99;
            }
            .admin_dashboad .nav-tab {
                background: unset;
                color: var(--color-white);
                border: 0px;
            }
            .admin_dashboad .nav-tab.nav-tab-active {
                background: var(--color-white);
                color: var(--color-d-1);
            }
            .admin_dashboad .nav-tab span {
                margin: 0px;
            }
            </style>
 <?php
 
}
 
