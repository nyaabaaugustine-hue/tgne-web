<?php
/*
** ============================== 
**  Get Plugin List with Page Builder Support + Conflict Prevention
** ==============================
*/
class Getrequiredpluigns {
    public function __construct() {
        add_action('tgmpa_register', array($this, 'creote_register_required_plugins'));
    }
    
    public function creote_register_required_plugins() { 
        // Get the selected page builder with conflict awareness
        $selected_builder = creote_get_safe_page_builder_selection();
        
        // Base plugins that are always included regardless of page builder
        $base_plugins = array(
            array(
                'name'               => esc_html__('1 Contact Form 7', 'creote'),
                'slug'               => 'contact-form-7',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'               => esc_html__('2 One Click Demo Import', 'creote'),
                'slug'               => 'one-click-demo-import',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),
            array(
                'name'               => esc_html__('3 WooCommerce', 'creote'),
                'slug'               => 'woocommerce',
                'required'           => false,
                'force_activation'   => false,
                'force_deactivation' => false,
            ),  
            array(
                'name'               => esc_html__('4 The MailChimp for WordPress', 'creote'),
                'slug'               => 'mailchimp-for-wp',
                'required'           => false,
                'force_activation'   => false,
                'force_deactivation' => false,
            ), 
            array(
                'name' => esc_html__('5 Revslider', 'creote') ,
                'slug' => 'revslider', 
                'source'   =>  'https://themepanthers.com/updatedplugin/revslider.zip',
                'required' => true,
                'force_activation' => false,
                'force_deactivation' => false,
            ) ,
            array(
                'name' => esc_html__('Meta Box', 'creote') ,
                'slug' => 'meta-box',
                'required' => true,
                'force_activation' => false,
                'force_deactivation' => false,
            ) , 
            array(
                'name' => esc_html__('YITH WooCommerce Compare', 'creote'),
                'slug' => 'yith-woocommerce-compare',
                'required' => false,
                'force_activation' => false,
                'force_deactivation' => false,
            ),
            array(
                'name' => esc_html__('YITH WooCommerce Wishlist', 'creote'),
                'slug'   => 'yith-woocommerce-wishlist',
                'required' => false,
                'force_activation' => false,
                'force_deactivation' => false,
            ),
           
            array(
                'name' => esc_html__('WP Job Manager', 'creote'),
                'slug'   => 'wp-job-manager',
                'required' => true,
                'force_activation' => false,
                'force_deactivation' => false,
            ),
        );

        // Page builder specific plugins
        $builder_plugins = array();
        
        // Don't add page builder plugins if there's a conflict
        if ($selected_builder !== 'conflict') {
            if ($selected_builder === 'elementor') {
                $builder_plugins = array(
                    array(
                        'name'               => esc_html__('8 Elementor', 'creote'),
                        'slug'               => 'elementor',
                        'required'           => true,
                        'force_activation'   => false,
                        'force_deactivation' => false,
                    ),
                      array(
                        'name' => esc_html__('Z Creote Addons', 'creote') ,
                        'slug' => 'creote-addons',
                        'source'  => get_template_directory() . '/includes/plugins/creote-addons.zip',
                        'required' => true,
                        'force_activation' => false,
                        'force_deactivation' => false,
                    ) ,
                );
            } elseif ($selected_builder === 'wpbakery') {
                $builder_plugins = array(
                    array(
                        'name'               => esc_html__('8 WPBakery Page Builder', 'creote'),
                        'slug'               => 'js_composer',
                       'source'   =>  'https://themepanthers.com/updatedplugin/js_composer.zip',
                        'required'           => true,
                        'force_activation'   => false,
                        'force_deactivation' => false,
                        'external_url'       => 'https://wpbakery.com/',
                    ),  
                     array(
                        'name' => esc_html__('Z Creote Addons', 'creote') ,
                        'slug' => 'creote-addons',
                        'source'  => get_template_directory() . '/includes/plugins/creote-addons.zip',
                        'required' => true,
                        'force_activation' => false,
                        'force_deactivation' => false,
                    ) ,
                );
            }
        }

        // Merge base plugins with builder-specific plugins
        $plugins = array_merge($base_plugins, $builder_plugins);

        $config = array(
            'domain'       => 'creote', // Text domain - likely want to be the same as your theme.
            'default_path' => '', // Default absolute path to pre-packaged plugins
            'parent_slug'  => 'themes.php',
            'menu'         => 'install-required-plugins', // Menu slug
            'has_notices'  => true, // Show admin notices or not
            'is_automatic' => false, // Automatically activate plugins after installation or not
            'message'      => '', // Message to output right before the plugins table
            'strings'      => array(
                'page_title'                      => esc_html__('Install Required Plugins', 'creote'),
                'menu_title'                      => esc_html__('Install Plugins', 'creote'),
                'installing'                      => esc_html__('Installing Plugin: %s', 'creote'), // %1$s = plugin name
                'oops'                            => esc_html__('Something went wrong with the plugin API.', 'creote'),
                'notice_can_install_required'     => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'creote'), // %1$s = plugin name(s)
                'notice_can_install_recommended'  => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'creote'), // %1$s = plugin name(s)
                'notice_cannot_install'           => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'creote'), // %1$s = plugin name(s)
                'notice_can_activate_required'    => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'creote'), // %1$s = plugin name(s)
                'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'creote'), // %1$s = plugin name(s)
                'notice_cannot_activate'          => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'creote'), // %1$s = plugin name(s)
                'notice_ask_to_update'            => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'creote'), // %1$s = plugin name(s)
                'notice_cannot_update'            => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'creote'), // %1$s = plugin name(s)
                'install_link'                    => _n_noop('Begin installing plugin', 'Begin installing plugins', 'creote'),
                'activate_link'                   => _n_noop('Activate installed plugin', 'Activate installed plugins', 'creote'),
                'return'                          => esc_html__('Return to Required Plugins Installer', 'creote'),
                'plugin_activated'                => esc_html__('Plugin activated successfully.', 'creote'),
                'complete'                        => esc_html__('All plugins installed and activated successfully. %s', 'creote'), // %1$s = dashboard link
                'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated' or 'error'
            ),
        );

        tgmpa($plugins, $config);
    }
}
new Getrequiredpluigns();

/**
 * Helper function to check if Elementor is active
 * Uses class_exists instead of is_plugin_active for better reliability
 */
function creote_is_elementor_active() {
    return class_exists('\\Elementor\\Plugin');
}

/**
 * Helper function to check if WPBakery Page Builder is active
 * Uses class_exists instead of is_plugin_active for better reliability
 */
function creote_is_wpbakery_active() {
    return class_exists('Vc_Manager') || function_exists('vc_map');
}

/**
 * Helper function to get safe page builder selection
 * This ensures we don't have conflicting selections
 */
function creote_get_safe_page_builder_selection() {
    $elementor_active = creote_is_elementor_active();
    $wpbakery_active = creote_is_wpbakery_active();
    
    // If both are active, return 'conflict' to indicate issue
    if ($elementor_active && $wpbakery_active) {
        return 'conflict';
    }
    
    // If only one is active, return that one and update option
    if ($elementor_active) {
        update_option('creote_selected_page_builder', 'elementor');
        return 'elementor';
    }
    
    if ($wpbakery_active) {
        update_option('creote_selected_page_builder', 'wpbakery');
        return 'wpbakery';
    }
    
    // If neither is active, return the saved option or default
    return get_option('creote_selected_page_builder', 'elementor');
}

/**
 * Check for page builder conflicts and show admin notice
 */
function creote_check_page_builder_conflicts() {
    // Don't show on plugin activation/deactivation pages to avoid conflicts
    $screen = get_current_screen();
    if ($screen && (strpos($screen->base, 'plugins') !== false)) {
        return;
    }
    
    $elementor_active = creote_is_elementor_active();
    $wpbakery_active = creote_is_wpbakery_active();
    
    // If both are active, show conflict notice
    if ($elementor_active && $wpbakery_active) {
        ?>
        <div class="notice notice-error is-dismissible creote-page-builder-conflict">
            <h3><?php _e('⚠️ Page Builder Conflict Detected!', 'creote'); ?></h3>
            <p><?php _e('Both Elementor and WPBakery Page Builder are currently active. Having multiple page builders active can cause conflicts and performance issues.', 'creote'); ?></p>
            <p><strong><?php _e('Please choose one page builder to keep active:', 'creote'); ?></strong></p>
            
            <div style="margin: 15px 0;">
                <button type="button" class="button button-primary creote-keep-elementor" style="margin-right: 10px; background: #9b51e0;">
                    <span class="dashicons dashicons-admin-customizer" style="margin-top: 3px;"></span>
                    <?php _e('Keep Elementor (Deactivate WPBakery)', 'creote'); ?>
                </button>
                <button type="button" class="button button-primary creote-keep-wpbakery" style="background: #1e73be;">
                    <span class="dashicons dashicons-admin-page" style="margin-top: 3px;"></span>
                    <?php _e('Keep WPBakery (Deactivate Elementor)', 'creote'); ?>
                </button>
            </div>
            
            <p class="description">
                <span class="dashicons dashicons-info" style="color: #0073aa;"></span>
                <?php _e('This action will deactivate the other page builder but will not delete any data. You can always reactivate it later if needed.', 'creote'); ?>
            </p>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            // Handle keeping Elementor
            $('.creote-keep-elementor').on('click', function(e) {
                e.preventDefault();
                var button = $(this);
                button.prop('disabled', true).html('<span class="dashicons dashicons-update-alt"></span> <?php _e('Processing...', 'creote'); ?>');
                
                $.post(ajaxurl, {
                    action: 'creote_resolve_page_builder_conflict',
                    keep_builder: 'elementor',
                    nonce: '<?php echo wp_create_nonce('creote_resolve_conflict'); ?>'
                }, function(response) {
                    if (response.success) {
                        $('.creote-page-builder-conflict').removeClass('notice-error').addClass('notice-success');
                        $('.creote-page-builder-conflict h3').html('✅ <?php _e('Conflict Resolved!', 'creote'); ?>');
                        $('.creote-page-builder-conflict p').first().text('<?php _e('WPBakery Page Builder has been deactivated. Elementor is now your active page builder.', 'creote'); ?>');
                        $('.creote-page-builder-conflict div, .creote-page-builder-conflict p.description').hide();
                        
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        alert('<?php _e('Error: Could not resolve conflict. Please try manually.', 'creote'); ?>');
                        button.prop('disabled', false).html('<span class="dashicons dashicons-admin-customizer"></span> <?php _e('Keep Elementor (Deactivate WPBakery)', 'creote'); ?>');
                    }
                });
            });
            
            // Handle keeping WPBakery
            $('.creote-keep-wpbakery').on('click', function(e) {
                e.preventDefault();
                var button = $(this);
                button.prop('disabled', true).html('<span class="dashicons dashicons-update-alt"></span> <?php _e('Processing...', 'creote'); ?>');
                
                $.post(ajaxurl, {
                    action: 'creote_resolve_page_builder_conflict',
                    keep_builder: 'wpbakery',
                    nonce: '<?php echo wp_create_nonce('creote_resolve_conflict'); ?>'
                }, function(response) {
                    if (response.success) {
                        $('.creote-page-builder-conflict').removeClass('notice-error').addClass('notice-success');
                        $('.creote-page-builder-conflict h3').html('✅ <?php _e('Conflict Resolved!', 'creote'); ?>');
                        $('.creote-page-builder-conflict p').first().text('<?php _e('Elementor has been deactivated. WPBakery Page Builder is now your active page builder.', 'creote'); ?>');
                        $('.creote-page-builder-conflict div, .creote-page-builder-conflict p.description').hide();
                        
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        alert('<?php _e('Error: Could not resolve conflict. Please try manually.', 'creote'); ?>');
                        button.prop('disabled', false).html('<span class="dashicons dashicons-admin-page"></span> <?php _e('Keep WPBakery (Deactivate Elementor)', 'creote'); ?>');
                    }
                });
            });
        });
        </script>
        
        <style>
        .creote-page-builder-conflict {
            border-left: 4px solid #dc3232;
            padding: 15px;
        }
        .creote-page-builder-conflict.notice-success {
            border-left: 4px solid #46b450;
        }
        .creote-page-builder-conflict .dashicons {
            margin-right: 5px;
        }
        .creote-keep-elementor:hover {
            background: #8a47cc !important;
        }
        .creote-keep-wpbakery:hover {
            background: #1a5a8a !important;
        }
        </style>
        <?php
    }
}
add_action('admin_notices', 'creote_check_page_builder_conflicts');

/**
 * AJAX handler to resolve page builder conflicts
 */
function creote_resolve_page_builder_conflict() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'creote_resolve_conflict')) {
        wp_die('Security check failed');
    }
    
    // Check user capabilities
    if (!current_user_can('activate_plugins')) {
        wp_send_json_error('Insufficient permissions');
    }
    
    $keep_builder = sanitize_text_field($_POST['keep_builder']);
    
    // Include plugin.php to access deactivate_plugins function
    if (!function_exists('deactivate_plugins')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    
    if ($keep_builder === 'elementor') {
        // Keep Elementor, deactivate WPBakery
        if (creote_is_wpbakery_active()) {
            deactivate_plugins('js_composer/js_composer.php');
        }
        // Update the selected page builder option
        update_option('creote_selected_page_builder', 'elementor');
        
        wp_send_json_success('WPBakery deactivated, Elementor kept active');
        
    } elseif ($keep_builder === 'wpbakery') {
        // Keep WPBakery, deactivate Elementor
        if (creote_is_elementor_active()) {
            deactivate_plugins('elementor/elementor.php');
        }
        // Update the selected page builder option
        update_option('creote_selected_page_builder', 'wpbakery');
        
        wp_send_json_success('Elementor deactivated, WPBakery kept active');
        
    } else {
        wp_send_json_error('Invalid builder selection');
    }
}
add_action('wp_ajax_creote_resolve_page_builder_conflict', 'creote_resolve_page_builder_conflict');

/**
 * Prevent activation of conflicting page builder
 */
function creote_prevent_page_builder_conflict($plugin) {
    $elementor_active = creote_is_elementor_active();
    $wpbakery_active = creote_is_wpbakery_active();
    
    // Include plugin.php to access deactivate_plugins function
    if (!function_exists('deactivate_plugins')) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    
    // If trying to activate Elementor while WPBakery is active
    if ($plugin === 'elementor/elementor.php' && $wpbakery_active) {
        // Set a transient to show warning message
        set_transient('creote_page_builder_activation_warning', 'elementor_blocked', 30);
        
        // Deactivate the plugin that was just activated
        deactivate_plugins($plugin);
        
        // Redirect to avoid the "Plugin activated" message
        wp_redirect(admin_url('plugins.php?creote_builder_conflict=elementor'));
        exit;
    }
    
    // If trying to activate WPBakery while Elementor is active
    if ($plugin === 'js_composer/js_composer.php' && $elementor_active) {
        // Set a transient to show warning message
        set_transient('creote_page_builder_activation_warning', 'wpbakery_blocked', 30);
        
        // Deactivate the plugin that was just activated
        deactivate_plugins($plugin);
        
        // Redirect to avoid the "Plugin activated" message
        wp_redirect(admin_url('plugins.php?creote_builder_conflict=wpbakery'));
        exit;
    }
}
add_action('activated_plugin', 'creote_prevent_page_builder_conflict');

/**
 * Show warning message when page builder activation is blocked
 */
function creote_show_page_builder_activation_warning() {
    // Check if we're on plugins page and there's a conflict parameter
    if (!isset($_GET['creote_builder_conflict'])) {
        return;
    }
    
    $blocked_builder = sanitize_text_field($_GET['creote_builder_conflict']);
    $warning = get_transient('creote_page_builder_activation_warning');
    
    if ($warning) {
        delete_transient('creote_page_builder_activation_warning');
        
        if ($blocked_builder === 'elementor' && $warning === 'elementor_blocked') {
            ?>
            <div class="notice notice-warning is-dismissible">
                <h3><span class="dashicons dashicons-warning" style="color: #f56e28;"></span> <?php _e('Page Builder Activation Blocked', 'creote'); ?></h3>
                <p><?php _e('Elementor activation was prevented because WPBakery Page Builder is already active.', 'creote'); ?></p>
                <p><strong><?php _e('To use Elementor:', 'creote'); ?></strong> <?php _e('Please first deactivate WPBakery Page Builder, then activate Elementor.', 'creote'); ?></p>
            </div>
            <?php
        } elseif ($blocked_builder === 'wpbakery' && $warning === 'wpbakery_blocked') {
            ?>
            <div class="notice notice-warning is-dismissible">
                <h3><span class="dashicons dashicons-warning" style="color: #f56e28;"></span> <?php _e('Page Builder Activation Blocked', 'creote'); ?></h3>
                <p><?php _e('WPBakery Page Builder activation was prevented because Elementor is already active.', 'creote'); ?></p>
                <p><strong><?php _e('To use WPBakery:', 'creote'); ?></strong> <?php _e('Please first deactivate Elementor, then activate WPBakery Page Builder.', 'creote'); ?></p>
            </div>
            <?php
        }
    }
}
add_action('admin_notices', 'creote_show_page_builder_activation_warning');

/**
 * Function to get page builder aware plugin rcreotemendations
 * This can be used by the setup wizard to show contextual plugin suggestions
 */
function creote_get_page_builder_plugins() {
    $selected_builder = creote_get_safe_page_builder_selection();
    
    $plugins = array();
    
    if ($selected_builder === 'elementor') {
        $plugins = array(
            'required' => array(
                'elementor' => array(
                    'name' => 'Elementor',
                    'description' => 'The leading website builder platform for professionals on WordPress.',
                    'url' => 'https://wordpress.org/plugins/elementor/',
                ),
                'creote-addons' => array(
                    'name' => 'creote Addons for Elementor',
                    'description' => 'Essential widgets and extensions specifically designed for creote theme with Elementor.',
                    'bundled' => true,
                ),
            ),
            'recommended' => array(
                'elementor-pro' => array(
                    'name' => 'Elementor Pro',
                    'description' => 'The most advanced website builder for WordPress with exclusive pro widgets.',
                    'url' => 'https://elementor.com/pro/',
                    'external' => true,
                ),
                'creote-template-importer' => array(
                    'name' => 'creote Template Importer',
                    'description' => 'Import pre-built Elementor templates specifically designed for creote theme.',
                    'bundled' => true,
                ),
            ),
        );
    } elseif ($selected_builder === 'wpbakery') {
        $plugins = array(
            'required' => array(
                'js_composer' => array(
                    'name' => 'WPBakery Page Builder',
                    'description' => 'Drag and drop page builder for WordPress with frontend and backend editing.',
                    'bundled' => true,
                ),
                'creote-wpbakery-addons' => array(
                    'name' => 'creote Addons for WPBakery',
                    'description' => 'Essential elements and modules specifically designed for creote theme with WPBakery.',
                    'bundled' => true,
                ),
            ),
            'recommended' => array(
                'Ultimate_VC_Addons' => array(
                    'name' => 'Ultimate Addons for WPBakery',
                    'description' => 'Ultimate collection of addons for WPBakery Page Builder.',
                    'bundled' => true,
                ),
                'creote-wpbakery-template-importer' => array(
                    'name' => 'creote Template Importer for WPBakery',
                    'description' => 'Import pre-built WPBakery templates specifically designed for creote theme.',
                    'bundled' => true,
                ),
            ),
        );
    }
    
    return $plugins;
}

/**
 * Function to check if the current page builder setup is complete
 */
function creote_is_page_builder_setup_complete() {
    $selected_builder = creote_get_safe_page_builder_selection();
    
    if ($selected_builder === 'conflict') {
        return false; // Can't be complete if there's a conflict
    }
    
    if ($selected_builder === 'elementor') {
        // Check if Elementor is installed and activated
        return creote_is_elementor_active();
    } elseif ($selected_builder === 'wpbakery') {
        // Check if WPBakery is installed and activated
        return creote_is_wpbakery_active();
    }
    
    return false;
}

/**
 * Function to get page builder specific demo content information
 */
function creote_get_page_builder_demos() {
    $selected_builder = creote_get_safe_page_builder_selection();
    
    $demos = array();
    
    if ($selected_builder === 'elementor') {
        $demos = array(
            array(
                'id' => 'elementor-v1',
                'name' => 'Elementor Demo 1',
                'description' => 'Modern business website with Elementor - includes 8 unique home pages',
                'screenshot' => get_template_directory_uri() . '/includes/admin/dashboard/demos/elementor/v1/screenshot.jpg',
                'preview_url' => 'https://creote.themepanthers.com/elementor-demo',
                'features' => array('8 Home Pages', '20+ Inner Pages', 'Modern Design', 'Mobile Optimized'),
            ),
            array(
                'id' => 'elementor-v2',
                'name' => 'Elementor Demo 2',
                'description' => 'Creative agency website with Elementor - includes 8 more unique home pages',
                'screenshot' => get_template_directory_uri() . '/includes/admin/dashboard/demos/elementor/v2/screenshot.jpg',
                'preview_url' => 'https://creote.themepanthers.com/elementor-demo-2',
                'features' => array('8 Home Pages', '15+ Inner Pages', 'Creative Design', 'Portfolio Ready'),
            ),
        );
    } elseif ($selected_builder === 'wpbakery') {
        $demos = array(
            array(
                'id' => 'wpbakery-v1',
                'name' => 'WPBakery Demo 1',
                'description' => 'Professional business website with WPBakery - includes 8 unique home pages',
                'screenshot' => get_template_directory_uri() . '/includes/admin/dashboard/demos/wpbakery/v1/screenshot.jpg',
                'preview_url' => 'https://creote.themepanthers.com/wpbakery-demo',
                'features' => array('8 Home Pages', '20+ Inner Pages', 'Professional Design', 'Business Ready'),
            ),
            array(
                'id' => 'wpbakery-v2',
                'name' => 'WPBakery Demo 2',
                'description' => 'Corporate website with WPBakery - includes 8 more unique home pages',
                'screenshot' => get_template_directory_uri() . '/includes/admin/dashboard/demos/wpbakery/v2/screenshot.jpg',
                'preview_url' => 'https://creote.themepanthers.com/wpbakery-demo-2',
                'features' => array('8 Home Pages', '15+ Inner Pages', 'Corporate Design', 'Enterprise Ready'),
            ),
        );
    }
    
    return $demos;
}

/**
 * Admin notice to show page builder selection
 */
function creote_page_builder_selection_notice() {
    // Don't show on the setup wizard page itself
    $screen = get_current_screen();
    if ($screen && (strpos($screen->base, 'creote') !== false || strpos($screen->base, 'one-click-demo-import') !== false)) {
        return;
    }
    
    // Check if user has already selected a page builder
    $selected_builder = get_option('creote_selected_page_builder', '');
    
    if (empty($selected_builder)) {
        ?>
        <div class="notice notice-info is-dismissible creote-page-builder-notice">
            <h3><?php _e('Complete creote Theme Setup', 'creote'); ?></h3>
            <p><?php _e('Please complete the theme setup wizard to select your preferred page builder and install the necessary plugins.', 'creote'); ?></p>
            <p>
                <a href="<?php echo esc_url(admin_url('admin.php?page=creote')); ?>" class="button button-primary">
                    <?php _e('Complete Setup', 'creote'); ?>
                </a>
                <a href="#" class="button button-secondary creote-dismiss-notice">
                    <?php _e('Dismiss', 'creote'); ?>
                </a>
            </p>
        </div>
        
        <script>
        jQuery(document).ready(function($) {
            $('.creote-dismiss-notice').on('click', function(e) {
                e.preventDefault();
                $(this).closest('.notice').fadeOut();
                
                // Set a flag to not show this notice again for this session
                $.post(ajaxurl, {
                    action: 'creote_dismiss_page_builder_notice',
                    nonce: '<?php echo wp_create_nonce('creote_dismiss_notice'); ?>'
                });
            });
        });
        </script>
        <?php
    }
} 
add_action('admin_notices', 'creote_page_builder_selection_notice');

/**
 * AJAX handler for dismissing the page builder notice
 */
function creote_dismiss_page_builder_notice() {
    check_ajax_referer('creote_dismiss_notice', 'nonce');
    
    // Set a transient to hide the notice for 24 hours
    set_transient('creote_page_builder_notice_dismissed', true, DAY_IN_SECONDS);
    
    wp_die();
}
add_action('wp_ajax_creote_dismiss_page_builder_notice', 'creote_dismiss_page_builder_notice');