<?php
/**
 * Theme Setup Wizard with Integrated Plugin Installation and Demo Import
 * This file handles the theme setup wizard functionality with inline plugin installation
 * and demo content import without redirecting to separate pages
 * Place this file in your theme's includes/main/Demo/ directory
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Include dependencies
require_once get_template_directory() . '/includes/dashboard/Capability.php'; 
 
/**
 * Theme Setup Wizard Class
 */
class Integrated_Theme_Setup_Wizard {
    /**
     * Current step
     */
    private $step = '';
    
    /**
     * Steps for the setup wizard
     */
    private $steps = array();
    
    /**
     * Theme name
     */
    private $theme_name = '';
    
    /**
     * Theme slug
     */
    private $theme_slug = '';
     
    /**
     * Required plugins
     */
    private $required_plugins = array();
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->theme_name = wp_get_theme()->get('Name');
        $this->theme_slug = wp_get_theme()->get_stylesheet();
        
        add_action('admin_head', array($this, 'remove_admin_notices'), 1);
     $this->steps = array(
            'welcome'      => array(
                'name'    => __('Welcome', 'creote'),
                'view'    => array($this, 'welcome_step'),
                'handler' => '',
            ),
            'page_builder' => array(
                'name'    => __('Page Builder', 'creote'),
                'view'    => array($this, 'page_builder_step'),
                'handler' => array($this, 'process_page_builder_step'),
            ),
            'child_theme'  => array(
                'name' => __('Child Theme', 'creote'),
                'view' => array($this, 'child_theme_step'),
                'handler' => array($this, 'process_child_theme_step'),
            ),
            'plugins'      => array(
                'name'    => __('Plugins', 'creote'),
                'view'    => array($this, 'plugins_step'),
                'handler' => '',
            ), 
            'demo_import'  => array(
                'name'    => __('Demo Import', 'creote'), 
                'view'    => array($this, 'demo_import_step'), 
                'handler' => '',
            ),
            'done'         => array(
                'name'    => __('Done', 'creote'),
                'view'    => array($this, 'done_step'),
                'handler' => '',
            ),
        );
         
        // Get required plugins based on user choice
        $this->get_required_plugins();
        
        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Add admin scripts
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        
        // AJAX handlers
        add_action('wp_ajax_install_child_theme', array($this, 'ajax_install_child_theme'));
        add_action('wp_ajax_activate_child_theme', array($this, 'ajax_activate_child_theme'));
        add_action('wp_ajax_install_plugin', array($this, 'ajax_install_plugin'));
        add_action('wp_ajax_activate_plugin', array($this, 'ajax_activate_plugin')); 
        add_action('wp_ajax_deactivate_plugin', array($this, 'ajax_deactivate_plugin'));
        add_action('wp_ajax_save_page_builder_selection', array($this, 'ajax_save_page_builder_selection'));
        // Additional actions from Theme_Admin_Panel
        add_action("admin_init", [$this, "register_settings"]);
        add_action("admin_notices", [$this, "display_admin_notice"]); 
 
        add_action('template_redirect', [$this, 'maintenance_mode_redirect'], 1);
        add_action("admin_notices", [$this, "display_header_admin_notice"], 110); 
         
        // Check current step
        if (isset($_GET['step'])) {
            $this->step = sanitize_key($_GET['step']);
        } else {
            $this->step = array_keys($this->steps)[0];
        }
         
       // Handle form submissions (non-AJAX)
        if (!empty($_POST) && isset($_POST['wizard_nonce']) && !wp_doing_ajax()) {
            if (wp_verify_nonce($_POST['wizard_nonce'], 'wizard_nonce')) {
                if (isset($_POST['save_step']) && isset($this->steps[$this->step]['handler']) && !empty($this->steps[$this->step]['handler'])) {
                    $result = call_user_func($this->steps[$this->step]['handler']);
                    
                    if ($result) {
                        $next_url = $this->get_next_step_link();
                        wp_redirect(esc_url_raw($next_url));
                        exit;
                    }
                }
            }
        }
        // Add theme activation redirect hook
add_action('after_switch_theme', array($this, 'theme_activation_redirect'));
    }
    public function theme_activation_redirect() {
    if (!current_user_can('switch_themes') || wp_doing_ajax() || wp_doing_cron() || is_network_admin()) {
        return;
    }
    
    if (!get_option('creote_setup_wizard_redirect_done')) {
        update_option('creote_setup_wizard_redirect_done', true);
        
        wp_redirect(admin_url('admin.php?page=creote'));
        exit;
    }
}
 public function remove_admin_notices() {
        $screen = get_current_screen();
        if ($screen && $screen->id === 'toplevel_page_creote') {
            remove_all_actions('admin_notices');
            remove_all_actions('all_admin_notices');
        }
    }
    /**
     * Get user's selected page builder
     */
    private function get_selected_page_builder() {
        return get_option('creote_selected_page_builder', 'elementor'); // Default to Elementor
    }

    /**
     * Check if plugin is active using reliable methods
     */
 private function is_plugin_active_reliable($plugin_slug) {
    switch ($plugin_slug) {
        // Base plugins (in order from get_plugin_path)
        case 'contact-form-7':
            return class_exists('WPCF7');
        case 'one-click-demo-import':
            return class_exists('OCDI_Plugin');
        case 'woocommerce':
            return class_exists('WooCommerce');
        case 'mailchimp-for-wp':
            return function_exists('mc4wp');
        case 'revslider':
            return class_exists('RevSlider');
        case 'meta-box':
            return class_exists('RWMB_Loader');
        case 'wp-job-manager':
            return class_exists('WP_Job_Manager_Autoload');
        
        // Page builder specific plugins
        case 'elementor':
            return class_exists('Elementor\Plugin');
        case 'js_composer':
            return class_exists('Vc_Manager');
        case 'creote-addons':
            return class_exists('Creote_Addons');
        
        // YITH WooCommerce plugins
        case 'yith-woocommerce-compare':
            return class_exists('YITH_Woocompare');
        case 'yith-woocommerce-wishlist':
            return class_exists('YITH_WCWL');
        
        // Default fallback
        default:
            // Fallback to file existence check
            $plugin_path = $this->get_plugin_path($plugin_slug);
            return file_exists(WP_PLUGIN_DIR . '/' . $plugin_path);
    }
}
 
/**
 * Helper method to output the wizard steps HTML
 * This is used by multiple hooks
 */
private function output_wizard_steps_html() {
    // Output the wizard steps HTML
    echo '<div class="theme-setup-wizard ocdi-wizard-steps">';
    echo '<header class="wizard-header">';
    echo '<h1>' . sprintf(__('%s Setup', 'creote'), $this->theme_name) . '</h1>';
    echo '</header>';
    
    // Output the wizard steps
    echo '<ul class="wizard-steps">';
    $current_step = 'demo_import'; // Set current step to demo_import
    
    foreach ($this->steps as $step_key => $step) {
        $class = '';
        
        if ($step_key === $current_step) {
            $class = 'active';
        } elseif ($this->is_step_completed($step_key)) {
            $class = 'done';
        }
        
        echo '<li class="' . esc_attr($class) . '">';
        echo esc_html($step['name']);
        echo '</li>';
    }
    
    echo '</ul>';
    echo '</div>';
}
  /**
 * Page Builder Selection Step - FIXED VERSION
 */
public function page_builder_step() {
    $selected_builder = get_option('creote_selected_page_builder', '');
    
    // Debug: Show current selection
    if (current_user_can('manage_options') && isset($_GET['debug'])) {
 echo '<div class="notice notice-info"><p>' . esc_html__( 'DEBUG: Current saved builder', 'creote' ) . ' = ' . esc_html( $selected_builder ) . '</p></div>';

    }
    ?>
    <div class="wizard-step-content page-builder-selection">
        <h2><?php _e('Choose Your Page Builder', 'creote'); ?></h2>
        <p><?php _e('Select your preferred page builder. This will determine which plugins and demo content are installed.', 'creote'); ?></p>
        
        <form method="post" class="page-builder-form">
            <?php wp_nonce_field('wizard_nonce', 'wizard_nonce'); ?>
            <input type="hidden" name="save_step" value="1">
            
            <div class="page-builder-options">
                <div class="page-builder-option <?php echo esc_attr($selected_builder === 'elementor' ? 'selected' : ''); ?>">
                    <label>
                        <input type="radio" name="page_builder" value="elementor" <?php checked($selected_builder, 'elementor'); ?>>
                        <div class="page-builder-card">
                            <div class="page-builder-icon">
                              <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/elementor.png'); ?>" alt="Elementor" />
                                </div>
                            <h3><?php _e('Elementor', 'creote'); ?></h3>
                            <p><?php _e('Modern drag & drop page builder with extensive widgets and templates.', 'creote'); ?></p>
                            <div class="page-builder-features">
                                <span class="feature"><?php _e('Free & Pro versions', 'creote'); ?></span>
                                <span class="feature"><?php _e('Modern interface', 'creote'); ?></span>
                                <span class="feature"><?php _e('Live editing', 'creote'); ?></span>
                            </div>
                        </div>
                    </label>
                </div>
                
                <div class="page-builder-option <?php echo esc_attr($selected_builder === 'wpbakery' ? 'selected' : ''); ?>">
                    <label>
                        <input type="radio" name="page_builder" value="wpbakery" <?php checked($selected_builder, 'wpbakery'); ?>>
                        <div class="page-builder-card">
                            <div class="page-builder-icon">
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/wpbakery.jpg'); ?>" alt="Wp-bakery" />
                               </div>
                            <h3><?php _e('WPBakery Page Builder', 'creote'); ?></h3>
                            <p><?php _e('Classic page builder with frontend and backend editing capabilities.', 'creote'); ?></p>
                            <div class="page-builder-features">
                                <span class="feature"><?php _e('Frontend/Backend editing', 'creote'); ?></span>
                                <span class="feature"><?php _e('Extensive add-ons', 'creote'); ?></span>
                                <span class="feature"><?php _e('Template library', 'creote'); ?></span>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" name="save_step" class="button button-primary button-hero">
                    <span class="continue-text"><?php _e('Continue with Selected Builder', 'creote'); ?></span>
                    <span class="dashicons dashicons-arrow-right-alt"></span>
                </button>
            </div>
        </form>
    </div>

    <script>
    jQuery(document).ready(function($) {
        // Update button text when selection changes
        $('input[name="page_builder"]').on('change', function() {
            var selectedBuilder = $(this).val();
            var builderName = selectedBuilder === 'elementor' ? 'Elementor' : 'WPBakery Page Builder';
            $('.continue-text').text('Continue with ' + builderName);
            
            // Update selected class
            $('.page-builder-option').removeClass('selected');
            $(this).closest('.page-builder-option').addClass('selected');
        });
        
        // Trigger initial update
        $('input[name="page_builder"]:checked').trigger('change');
    });
    </script>

    <style>
    /* Your existing styles here */
    .page-builder-selection {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .page-builder-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin: 30px 0;
    }
    
    .page-builder-option {
        position: relative;
    }
    
    .page-builder-option label {
        display: block;
        cursor: pointer;
    }
    
    .page-builder-option input[type="radio"] {
        position: absolute;
        opacity: 0;
    }
    
    .page-builder-card {
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        background: #fff;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .page-builder-option.selected .page-builder-card,
    .page-builder-option input[type="radio"]:checked + .page-builder-card {
        border-color: #0073aa;
        box-shadow: 0 0 0 2px rgba(0, 115, 170, 0.1);
        background: #f7f9fc;
    }
    
    .page-builder-card:hover {
        border-color: #0073aa;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .page-builder-icon {
        margin-bottom: 15px;
    }
    
    .page-builder-icon img {
        width: 64px;
        height: 64px;
        border-radius: 8px;
    }
    
    .page-builder-card h3 {
        margin: 0 0 10px 0;
        color: #1e1e1e;
        font-size: 18px;
    }
    
    .page-builder-card p {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
        flex: 1;
    }
    
    .page-builder-features {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .page-builder-features .feature {
        background: #e7f3ff;
        color: #0073aa;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
    }
    
    .form-actions {
        text-align: center;
        margin-top: 30px;
    }
    
    .form-actions .button-hero {
        padding: 15px 30px;
        font-size: 16px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }
    
    @media (max-width: 768px) {
        .page-builder-options {
            grid-template-columns: 1fr;
        }
    }
    </style>
    <?php
}
 /**
 * Process page builder step - FIXED VERSION with Debug
 */ 
 public function process_page_builder_step() {
    if (isset($_POST['page_builder'])) {
        $selected_builder = sanitize_text_field($_POST['page_builder']);
        
        if (in_array($selected_builder, array('elementor', 'wpbakery'))) {
            update_option('creote_selected_page_builder', $selected_builder);
            
            delete_transient('creote_filtered_plugins');
            delete_transient('creote_demo_content_cache');
            
            $this->required_plugins = array();
            $this->get_required_plugins();
            
            return true;
        }
    }
    
    return false;
}

    /**
 * Get required plugins based on selected page builder - FIXED VERSION
 */
private function get_required_plugins() {
    $selected_builder = get_option('creote_selected_page_builder', 'elementor');
    
  
    // Base plugins that are always included
    $base_plugins = array(
         array(
                'name'               => esc_html__('1 Contact Form 7', 'creote'),
                'slug'               => 'contact-form-7',
                'source'   => '',
                'required'           => true, 
            ),
            array(
                'name'               => esc_html__('2 One Click Demo Import', 'creote'),
                'slug'               => 'one-click-demo-import',
                'required'           => true,
                 'source'   => '',
            ),
            array(
                'name'               => esc_html__('3 WooCommerce', 'creote'),
                'slug'               => 'woocommerce',
                'required'           => false,
                    'source'   => '',
            ),  
            array(
                'name'               => esc_html__('4 The MailChimp for WordPress', 'creote'),
                'slug'               => 'mailchimp-for-wp',
                'required'           => false,
                   'source'   => '',
            ), 
            array(
                'name' => esc_html__('5 Revslider', 'creote') ,
                'slug' => 'revslider', 
                'source'   =>  'https://themepanthers.com/updatedplugin/revslider.zip',
                'required' => true, 
            ) ,
            array(
                'name' => esc_html__('Meta Box', 'creote') ,
                'slug' => 'meta-box',
                'required' => true,
                      'source'   => '',
            ) , 
            array(
                'name' => esc_html__('YITH WooCommerce Compare', 'creote'),
                'slug' => 'yith-woocommerce-compare',
                'required' => false,
                   'source'   => '',
            ),
            array(
                'name' => esc_html__('YITH WooCommerce Wishlist', 'creote'),
                'slug'   => 'yith-woocommerce-wishlist',
                'required' => false, 
                    'source'   => '',
            ),
           
            array(
                'name' => esc_html__('WP Job Manager', 'creote'),
                'slug'   => 'wp-job-manager',
                'required' => true,
                    'source'   => '',
            ),
    );

    // Page builder specific plugins
    $builder_plugins = array();
    
    if ($selected_builder === 'elementor') {
        $builder_plugins = array(
            array(
                'name'     => 'Elementor',
                'slug'     => 'elementor',
                'source'   => '',
                'required' => true,
            ),
             array(
                        'name' => esc_html__('Creote Addons', 'creote') ,
                        'slug' => 'creote-addons',
                        'source'  => get_template_directory() . '/includes/plugins/creote-addons.zip',
                        'required' => true, 
                    ) ,
        );
    } elseif ($selected_builder === 'wpbakery') {
        // WPBakery specific plugins - THIS WAS THE ISSUE
        $builder_plugins = array(
            array(
                'name'     => 'WPBakery Page Builder',
                'slug'     => 'js_composer',
                     'source'   =>  'https://themepanthers.com/updatedplugin/js_composer.zip',
                'required' => true,
            ),  
             array(
                        'name' => esc_html__('Creote Addons', 'creote') ,
                        'slug' => 'creote-addons',
                        'source'  => get_template_directory() . '/includes/plugins/creote-addons.zip',
                        'required' => true, 
                    ) ,
        );
    }

    // Merge base plugins with builder-specific plugins
    $this->required_plugins = array_merge($base_plugins, $builder_plugins);
    
    
}
/**
 * AJAX handler for page builder selection - ADD THIS NEW FUNCTION
 */
public function ajax_save_page_builder_selection() {
    check_ajax_referer('theme_setup_wizard', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => __('Permission denied.', 'creote')));
    }
    
    $page_builder = isset($_POST['page_builder']) ? sanitize_text_field($_POST['page_builder']) : '';
    
    if (empty($page_builder) || !in_array($page_builder, array('elementor', 'wpbakery'))) {
        wp_send_json_error(array('message' => __('Invalid page builder selection.', 'creote')));
    }
    
    // Save the selection
    update_option('creote_selected_page_builder', $page_builder);
    
    // Clear any caches
    delete_transient('creote_filtered_plugins');
    delete_transient('creote_demo_content_cache');
    
    wp_send_json_success(array(
        'message' => __('Page builder selection saved.', 'creote'),
        'selected_builder' => $page_builder
    ));
}
    
    /**
     * Add admin menu
     * This combines both the original menu function and Theme_Admin_Panel's function
     */
    public function add_admin_menu() {
        // Add a top-level menu item with a specific position
        add_menu_page(
            "creote", // Page title
            "creote", // Menu title
            "manage_options", // Capability required to access the menu item
            "creote", // Menu slug
            [$this, "setup_wizard"], // Callback function to render the page
            "dashicons-admin-settings", // Icon for the menu item
            2
        );
        
        // Add subpages
        add_submenu_page(
            "creote",
            "Theme Setup / Import",
            "Theme Setup / Import ",
            "manage_options",
            "creote",
            [$this, "setup_wizard"],
            0
        );
        
        // creote Imported
        if (class_exists("creote_importer") && class_exists("creote_importer")) {
            add_submenu_page(
                'creote', // Parent menu slug
                'Template Importer', // Page title
                'Template Importer', // Menu title
                'manage_options', // Capability required to access the submenu item
                'elementor-template-importer', // Menu slug
                'elementor_template_importer_page', // Callback function to render the page 
            );
        } 
        
       
    }
    
   
/**
 * Enqueue additional scripts and styles
 * Add this to the enqueue_scripts method
 */
public function enqueue_scripts() {
    $screen = get_current_screen();

    // Check for creote related admin pages
    if (isset($_GET['page']) && ($_GET['page'] === 'creote' || $_GET['page'] === 'one-click-demo-import')) {
        // Enqueue modern dashboard styles
        wp_enqueue_style('creote-modern-dashboard', get_template_directory_uri() . '/includes/dashboard/assets/css/modern-dashboard.css', array(), '2.0.0');
        
        // Enqueue ONLY modern dashboard script - removing wizard.js reference
        wp_enqueue_script('creote-modern-dashboard', get_template_directory_uri() . '/includes/dashboard/assets/js/modern-dashboard.js', array('jquery'), '2.0.0', true);
        
        // Localize script with combined data from both previous localizations
        wp_localize_script('creote-modern-dashboard', 'theme_setup_wizard', array(
            'ajaxurl'       => admin_url('admin-ajax.php'),
            'nonce'         => wp_create_nonce('theme_setup_wizard'),
            'admin_url'     => admin_url('admin.php?page=creote'),
            'plugin_texts'  => array(
                'installing'        => __('Installing...', 'creote'),
                'installed'         => __('Installed', 'creote'),
                'install_failed'    => __('Installation Failed', 'creote'),
                'activating'        => __('Activating...', 'creote'),
                'activated'         => __('Activated', 'creote'),
                'activation_failed' => __('Activation Failed', 'creote'),
                'deactivating'      => __('Deactivating...', 'creote'),
                'deactivated'       => __('Deactivated', 'creote'),
                'deactivation_failed' => __('Deactivation Failed', 'creote'),
            ),
            'texts' => array(
                'installing' => __('Installing...', 'creote'),
                'installed' => __('Installed', 'creote'),
                'error' => __('Error', 'creote'),
            )
        ));
        
        // Add server check localization to the same script
        wp_localize_script('creote-modern-dashboard', 'creote_server_check', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('refresh_server_check_nonce'),
            'refreshing_text' => __('Refreshing...', 'creote')
        ));
    }
}

    
    
    
    /**
     * Register theme settings from Theme_Admin_Panel
     */
    public function register_settings() {
        // Register any settings you need for your theme options
    }
     
/**
 * Advanced maintenance mode implementation
 */
public function check_maintenance_mode() {
 $enable_custom_feature = get_theme_mod('enable_custom_feature', false);
$custom_image = get_theme_mod('custom_image_setting');
$custom_text = get_theme_mod('custom_text_setting');
$custom_text_setting_two = get_theme_mod('custom_text_setting_two');

    if ($enable_custom_feature && !is_user_logged_in() && !is_admin()) {
        // Set proper HTTP status and headers
        status_header(503);
        header('Retry-After: 3600');
        nocache_headers();
        
        // Start output buffering
        ob_start();
        
        // Load WordPress environment properly
        get_header(); // This will include wp_head() and all styles/scripts
        
        ?>
       <div id="page" class="page_wapper maintenance hfeed site"> 

<div class="maintenance-content">
    <?php 
    if ($enable_custom_feature) {
        // Display content when staging site is enabled
        if ($custom_image) {
            echo '<img src="' . esc_url($custom_image) . '" alt="Custom Image">';
        }
    }
        ?>
        <div class="box_content">
        <?php
         if ($enable_custom_feature) {
        if ($custom_text_setting_two) {
            echo '<h2>' . esc_html($custom_text_setting_two) . '</h2>';
        }else{
                   echo '<h2>' . esc_html__('Site Under Maintenance.' , 'creote') . '</h2>';
        }
        if ($custom_text) {
            echo '<p>' . esc_html($custom_text) . '</p>';
        }else{
            echo '<p>' . esc_html__('This website is currently undergoing maintenance.' , 'creote') . '</p>';
        }
    }  
 ?>
 </div>
</div>
        <?php
        
        get_footer(); // This will include wp_footer() and all scripts
        
        // End output buffering and send
        ob_end_flush();
        exit;
    }
}
 

public function maintenance_mode_redirect() {
  $maintenance_enabled = get_theme_mod('enable_custom_feature', false);

    if ($maintenance_enabled && !is_user_logged_in() && !is_admin()) {
        // Set proper HTTP status and headers
        status_header(503);
        header('Retry-After: 3600');
        nocache_headers();
        
        // Load maintenance template
        $maintenance_template = locate_template('maintenance-mode.php');
        
        if ($maintenance_template) {
            // Use custom maintenance template if it exists
            include($maintenance_template);
        } else {
            // Use default maintenance content with proper WordPress structure
            get_header();
            ?>
            <div class="maintenance-mode-wrapper">
                <div class="container">
                    <?php
                    $maintenance_mode_blocks = creote_get_option('maintance_mode_blocks');
                    
                    if (!empty($maintenance_mode_blocks)) {
                        echo do_shortcode('[creote-blocks id="' . esc_attr($maintenance_mode_blocks) . '"]');
                    } else {
                        ?>
                        <div class="maintenance-content">
                            <h1><?php _e('Site Under Maintenance', 'creote'); ?></h1>
                            <p><?php _e('We are currently performing scheduled maintenance. Please check back later.', 'creote'); ?></p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            get_footer();
        }
        exit;
    }
} 
    
    /**
     * Display admin notice from Theme_Admin_Panel
     */
    public function display_admin_notice() { 
        $admin_notice_enable = function_exists('creote_get_option') ? creote_get_option('admin_notice', true) : true; 
        $admin_dashboard_url = admin_url('admin.php?page=creote'); 
        ?>
       <div class="admin-notice admin-notice-creotess notice notice-info is-dismissible <?php if($admin_notice_enable == false): ?> disable_copt_notice <?php endif; ?>">
        <ul> 
            <li><?php echo esc_html('Before Import Demo Content Check the server configuration here', 'creote'); ?> <a target="_blank" href="<?php echo esc_url($admin_dashboard_url);?>"><?php echo esc_html('Click here...', 'creote'); ?></a></li>
            <li><?php echo esc_html('We are here to help you.For any issues please submit your ticket here', 'creote'); ?> <a target="_blank" href="https://steelthemes.ticksy.com/submit/#100016764"><?php echo esc_html('Get Support', 'creote'); ?></a></li>
            <li><?php echo esc_html('Looking for creote Documentation', 'creote'); ?> <a target="_blank" href="https://themepanthers.com/documentation/creote/"><?php echo esc_html('Click here', 'creote'); ?></a></li>
            </ul>
            <p>To disable this notice go to CreIt ▸ Theme Options  ▸ creote Header / Footer Settings ▸  Admin Notice</p>
          </div> 
       <?php
    }
    
    /**
     * Display header admin notice from Theme_Admin_Panel
     */
    public function display_header_admin_notice() {
        $screen = get_current_screen();
        if (class_exists("creote_Addons")) {
            // Check if the current screen is the header post type edit screen
            if ($screen && $screen->post_type === "header") {
                $this->add_single_tabs("header");
            }
            // Check if the current screen is the footer post type edit screen
            if ($screen && $screen->post_type === "footer") {
                $this->add_single_tabs("footer");
            }
            // Check if the current screen is the mega_menu post type edit screen
            if ($screen && $screen->post_type === "mega_menu") {
                $this->add_single_tabs("megamenu");
            }
            // Check if the current screen is the theme otpion post type edit screen
            if (
                isset($_GET["page"]) &&
                $_GET["page"] === "creote-theme-options"
            ) {
                $this->add_single_tabs("themeoptions");
            }
        }
        if (class_exists("creote_importer")) {
            // Check if the current screen is the theme otpion post type edit screen
              if (isset($_GET["page"]) && $_GET["page"] === "elementor-template-importer") {
                  $this->add_single_tabs("elementortemplateimporter");
              }
          }
        if ($screen && $screen->base === "nav-menus") {
            $this->add_single_tabs("menus");
        }
        if ($screen && $screen->base === "widgets") {
            $this->add_single_tabs("widgets"); 
        }
        if ($screen->id === 'appearance_page_install-required-plugins') {
            $this->add_single_tabs("plugin");
        }
        if (class_exists("OCDI_Plugin")) {
            // Check if the current screen is the one click post type edit screen
            if (
                isset($_GET["page"]) &&
                $_GET["page"] === "one-click-demo-import"
            ) {
                $this->add_single_tabs("oneclick");
            }
        }
    }
    
    /**
     * Add single tabs from Theme_Admin_Panel
     */
 
public function add_single_tabs($tab_activate) {
    $navtabs["main"] = [
        "title" => esc_html__("Theme Setup", "creote"),
        "link" => "admin.php?page=creote",
    ];
    $navtabs["plugin"] = [
        "title" => esc_html__("Install Plugins", "creote"),
        "link" => "themes.php?page=install-required-plugins",
    ];
    if (class_exists("OCDI_Plugin")) {
        $navtabs["oneclick"] = [
            "title" => esc_html__("Import Demo Content", "creote"),
            "link" => "themes.php?page=one-click-demo-import",
        ];
    }
    $navtabs["menus"] = [
        "title" => esc_html__("Menu", "creote"),
        "link" => "nav-menus.php",
    ];
    $navtabs["widgets"] = [
        "title" => esc_html__("Widgets", "creote"),
        "link" => "widgets.php",
    ];
    if (class_exists("creote_Addons")) {
        $navtabs["header"] = [
            "title" => esc_html__("Create Header", "creote"),
            "link" => "edit.php?post_type=header",
        ];
        $navtabs["footer"] = [
            "title" => esc_html__("Create Footer", "creote"),
            "link" => "edit.php?post_type=footer",
        ];
        $navtabs["megamenu"] = [
            "title" => esc_html__("Create Megamenu", "creote"),
            "link" => "edit.php?post_type=mega_menu",
        ];
        $navtabs["themeoptions"] = [
            "title" => esc_html__("Theme Options", "creote"),
            "link" => "customize.php",
        ];
    } 
    ?>
        <div class="nav-tab-wrapper admin_dashboad">
        <?php foreach ($navtabs as $key => $tab) {
                if ($tab_activate == $key){ ?>
                <span class="nav-tab nav-tab-active"><?php echo esc_html($tab["title"]); ?></span>
               <?php }else{ ?>
                <a href="<?php echo esc_url($tab["link"]); ?>" class="nav-tab"><?php echo esc_html($tab["title"]); ?></a>
                <?php
                }
            } ?>
        </div>
    <?php
}
    
    /**
     * Get the next step link
     */
    public function get_next_step_link() {
        $keys = array_keys($this->steps);
        $current_step_index = array_search($this->step, $keys);
        
        if ($current_step_index < count($keys) - 1) {
            $next_step = $keys[$current_step_index + 1];
            return add_query_arg('step', $next_step, admin_url('admin.php?page=creote'));
        }
        
        return admin_url();
    }
    
    /**
     * Get the previous step link
     */
    public function get_prev_step_link() {
        $keys = array_keys($this->steps);
        $current_step_index = array_search($this->step, $keys);
        
        if ($current_step_index > 0) {
            $prev_step = $keys[$current_step_index - 1];
            return add_query_arg('step', $prev_step, admin_url('admin.php?page=creote'));
        }
        
        return admin_url();
    }
    
    /**
     * Setup wizard page
     */
    public function setup_wizard() {
        $this->setup_wizard_header();
        $this->setup_wizard_steps();
        $this->setup_wizard_content();
        $this->setup_wizard_footer();
    }
    
   
/**
 * Add header enhancements for the theme setup wizard
 * Add this to the setup_wizard_header method
 */
public function setup_wizard_header() {
    ?>
   
    <div class="theme-setup-wizard-body">
        <div class="theme-setup-wizard">
            <header class="wizard-header">
                <div class="wizard-header-logo">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/steellogo.png'); ?>" alt="<?php echo esc_attr($this->theme_name); ?> Logo">
                    <h1><?php printf(__('%s Setup', 'creote'), $this->theme_name); ?></h1>
                </div>
                <div class="wizard-header-actions">
                    
                        <a href="<?php echo esc_url(admin_url('index.php')); ?>" class="button button-secondary">
                            <span class="dashicons dashicons-dashboard"></span> Dashboard
                        </a>
                  
                </div>
            </header>
    <?php
}
    /**
     * Setup wizard steps
     */
    public function setup_wizard_steps() {
        $current_step = $this->step;
        
        ?>
        <ul class="wizard-steps">
            <?php foreach ($this->steps as $step_key => $step) : ?>
              <li class="<?php echo esc_attr($step_key === $current_step ? 'active' : ($this->is_step_completed($step_key) ? 'done' : '')); ?>">
                    <?php echo esc_html($step['name']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
    }
    
    /**
     * Check if step is completed
     */
    private function is_step_completed($step) {
        $keys = array_keys($this->steps);
        $current_step_index = array_search($this->step, $keys);
        $step_index = array_search($step, $keys);
        
        return $step_index < $current_step_index;
    }
    
    /**
     * Setup wizard content
     */
    public function setup_wizard_content() {
        echo '<div class="wizard-content">';
        
        if (!empty($this->steps[$this->step]['view'])) {
            call_user_func($this->steps[$this->step]['view']);
        }
        
        echo '</div>';
    }
    
    /**
     * Setup wizard footer
     */
    public function setup_wizard_footer() {
        ?>
                <footer class="wizard-footer">
                    <div class="wizard-footer-links">
                        <?php if ($this->step !== array_keys($this->steps)[0]) : ?>
                            <a class="button button-secondary" href="<?php echo esc_url($this->get_prev_step_link()); ?>"><?php _e('Back', 'creote'); ?></a>
                        <?php endif; ?>
                        
                        <?php if ($this->step !== array_keys($this->steps)[count($this->steps) - 1]) : ?>
                            <a class="button button-primary next-step" href="<?php echo esc_url($this->get_next_step_link()); ?>"><?php _e('Next', 'creote'); ?></a>
                        <?php endif; ?>
                    </div>
                </footer>
            </div>
            <?php wp_print_scripts(); ?>
            <?php do_action('admin_print_scripts'); ?>
            <?php do_action('admin_footer'); ?>
                        </div> 
        <?php
        exit;
    }
    
   /**
 * Enhanced welcome step with better UI
 * Replace the existing welcome_step method
 */
public function welcome_step() {
    ?>
    <div class="wizard-step-content welcome_content">
        <div class="welcomeblocks">
            <h2><?php printf(__('Welcome to %s Setup Wizard', 'creote'), $this->theme_name); ?></h2>
            <p><?php _e('Thank you for choosing our theme. This wizard will help you set up your website quickly and easily.', 'creote'); ?></p>
            <p><?php _e('This wizard will guide you through:', 'creote'); ?></p>
            <ol>
                <li><?php _e('Installing and activating essential plugins', 'creote'); ?></li>
                <li><?php _e('Creating a child theme (optional but recommended)', 'creote'); ?></li>
                <li><?php _e('Importing demo content to match our theme demos', 'creote'); ?></li>
            </ol>
        </div>
        
        <p><?php _e('The setup should only take a few minutes to complete.', 'creote'); ?></p>
        
        <div class="notice notice-info">
            <p><?php _e('Using a child theme is recommended if you plan to customize your site. Demo content import is optional and can be skipped if you prefer to start with a blank site.', 'creote'); ?></p>
        </div>
        
        <?php 
        // Display server capability check
        Theme_Server_Capability_Check::display_server_capability_check();
        ?>
        
        <div class="wizard-action-buttons">
            <a class="button button-primary button-hero" href="<?php echo esc_url($this->get_next_step_link()); ?>">
                <?php _e('Let\'s Get Started', 'creote'); ?>
                <span class="dashicons dashicons-arrow-right-alt"></span>
            </a>
        </div>
    </div>
    <?php
}
    
    /**
     * Improved child theme step with better detection of existing active child theme
     */
    public function child_theme_step() {
        // Get current active theme
        $current_theme = wp_get_theme();
        $parent_theme = $current_theme->parent() ? $current_theme->parent() : $current_theme;
        
        // Get theme info
        $parent_theme_name = $parent_theme->get('Name');
        $parent_theme_slug = $parent_theme->get_stylesheet();
        
        // Check for any child theme of this parent
        $is_child_theme = ($current_theme->parent() && $current_theme->parent()->get_stylesheet() === $parent_theme_slug);
        
        // Alternative detection specifically for a theme named with "-child" suffix
        $child_theme_slug = $parent_theme_slug . '-child';
        $specific_child_theme = wp_get_theme($child_theme_slug);
        $specific_child_exists = $specific_child_theme->exists();
        $specific_child_active = ($current_theme->get_stylesheet() === $child_theme_slug);
        
        // Check both detection methods - either we're on ANY child theme of this parent, or specifically on the "-child" named version
        $is_on_child_theme = $is_child_theme || $specific_child_active;
        
        ?>
        <div class="wizard-step-content">
            <h2><?php esc_html_e('Child Theme Setup', 'creote'); ?></h2>
            <p><?php esc_html_e('A child theme allows you to make customizations without losing your changes when updating the parent theme.', 'creote'); ?></p>
            
            <?php if ($is_on_child_theme): ?>
                <div class="notice notice-success">
                    <p><?php esc_html_e('You are already using a child theme.', 'creote'); ?></p>
                    <p><strong><?php esc_html_e('Active theme:', 'creote'); ?></strong> <?php echo esc_html($current_theme->get('Name')); ?></p>
                    <p><strong><?php esc_html_e('Parent theme:', 'creote'); ?></strong> <?php echo esc_html($parent_theme->get('Name')); ?></p>
                </div>
            <?php elseif ($specific_child_exists): ?>
                <div class="notice notice-info">
                    <p><?php esc_html_e('Child theme is installed but not active.', 'creote'); ?></p>
                    <p><strong><?php esc_html_e('Theme name:', 'creote'); ?></strong> <?php echo esc_html($specific_child_theme->get('Name')); ?></p>
                    <button type="button" class="button button-primary activate-child-theme" data-theme="<?php echo esc_attr($child_theme_slug); ?>">
                        <?php esc_html_e('Activate Child Theme', 'creote'); ?>
                    </button>
                </div>
            <?php else: ?>
                <div class="child-theme-option">
                    <label>
                        <input type="checkbox" name="install_child_theme" value="1" checked>
                        <?php esc_html_e('Install and activate a child theme', 'creote'); ?>
                    </label>
                    <div class="child-theme-details">
                        <p><?php esc_html_e('Child theme name:', 'creote'); ?> <strong><?php echo esc_html($parent_theme_name); ?> Child</strong></p>
                        <div id="child_theme_status"></div>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="child-theme-info">
                <h3><?php esc_html_e('Why use a child theme?', 'creote'); ?></h3>
                <ul>
                    <li><?php esc_html_e('Preserves your customizations during theme updates', 'creote'); ?></li>
                    <li><?php esc_html_e('Makes your site more maintainable', 'creote'); ?></li>
                    <li><?php esc_html_e('Allows for safer customization of theme files', 'creote'); ?></li>
                </ul>
            </div>
        </div>
        <?php
    }

    /**
     * Process child theme step
     */
    public function process_child_theme_step() {
        if (isset($_POST['install_child_theme']) && $_POST['install_child_theme'] === '1') {
            if (!$this->check_child_theme_exists()) {
                $this->create_child_theme();
            }
        }
        return true;
    }
    
    /**
     * Enhanced check if child theme exists and is active
     * This method is more robust in detecting child themes
     */
    private function check_child_theme_exists() {
        // Get current active theme
        $current_theme = wp_get_theme();
        $parent_theme = $current_theme->parent() ? $current_theme->parent() : $current_theme;
        $parent_theme_slug = $parent_theme->get_stylesheet();
        
        // Check if current theme is ANY child theme of this parent
        if ($current_theme->parent() && $current_theme->parent()->get_stylesheet() === $parent_theme_slug) {
            return true;
        }
        
        // Check for specific named child theme
        $child_theme_slug = $parent_theme_slug . '-child';
        
        // If current theme is the specific named child theme
        if ($current_theme->get_stylesheet() === $child_theme_slug) {
            return true;
        }
        
        // Check if specific named child theme exists but isn't active
        $child_theme = wp_get_theme($child_theme_slug);
        return $child_theme->exists();
    }
    
    /**
     * Create and activate child theme
     */
    private function create_child_theme() {
        $parent_theme = wp_get_theme();
        $parent_theme_name = $parent_theme->get('Name');
        $parent_theme_slug = $parent_theme->get_stylesheet();
        $child_theme_slug = $parent_theme_slug . '-child';
        
        $child_theme_path = WP_CONTENT_DIR . '/themes/' . $child_theme_slug;
        
        // Create child theme directory
        if (!file_exists($child_theme_path)) {
            wp_mkdir_p($child_theme_path);
        }

        // Create style.css
        $style_css = "/*
Theme Name: {$parent_theme_name} Child
Theme URI: 
Description: A child theme of {$parent_theme_name}
Author: 
Author URI: 
Template: {$parent_theme_slug}
Version: 1.0.0
Text Domain: {$parent_theme_slug}-child
*/

/* Add your custom styles below this line */
";
        file_put_contents($child_theme_path . '/style.css', $style_css);

        // Create functions.php
        $functions_php = "<?php
/**
 * {$parent_theme_name} Child Theme functions and definitions
 */

function {$parent_theme_slug}_child_enqueue_styles() {
    wp_enqueue_style( '{$parent_theme_slug}-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( '{$parent_theme_slug}-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( '{$parent_theme_slug}-style' ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', '{$parent_theme_slug}_child_enqueue_styles' );

// Add custom functions below this line
";
        file_put_contents($child_theme_path . '/functions.php', $functions_php);

        // Create screenshot.png
        $parent_screenshot = get_template_directory() . '/screenshot.jpg';  // Try jpg first
        if (!file_exists($parent_screenshot)) {
            $parent_screenshot = get_template_directory() . '/screenshot.png';  // Try png if jpg doesn't exist
        }
        
        if (file_exists($parent_screenshot)) {
            copy($parent_screenshot, $child_theme_path . '/' . basename($parent_screenshot));
        }

        // Activate child theme
        $child_theme = wp_get_theme($child_theme_slug);
        if ($child_theme->exists()) {
            switch_theme($child_theme->get_stylesheet());
            return true;
        }
        
        throw new Exception(__('Child theme created but could not be activated.', 'creote'));
    }
    
    /**
     * AJAX handler for installing child theme
     */
    public function ajax_install_child_theme() {
        check_ajax_referer('theme_setup_wizard', 'nonce');
        
        if (!current_user_can('install_themes')) {
            wp_send_json_error(array('message' => __('You do not have permission to install themes.', 'creote')));
        }

        try {
            $this->create_child_theme();
            wp_send_json_success(array('message' => __('Child theme installed and activated successfully.', 'creote')));
        } catch (Exception $e) {
            wp_send_json_error(array('message' => $e->getMessage()));
        }
    }
    
    /**
     * AJAX handler for activating existing child theme
     */
    public function ajax_activate_child_theme() {
        check_ajax_referer('theme_setup_wizard', 'nonce');
        
        if (!current_user_can('switch_themes')) {
            wp_send_json_error(array('message' => __('You do not have permission to switch themes.', 'creote')));
        }
        
        $theme_slug = isset($_POST['theme']) ? sanitize_text_field($_POST['theme']) : '';
        
        if (empty($theme_slug)) {
            wp_send_json_error(array('message' => __('Theme slug is required.', 'creote')));
        }
        
        // Check if theme exists
        $theme = wp_get_theme($theme_slug);
        if (!$theme->exists()) {
            wp_send_json_error(array('message' => __('Theme does not exist.', 'creote')));
        }
        
        // Activate the theme
        switch_theme($theme_slug);
        
        // Check if activation was successful
        $active_theme = wp_get_theme();
        if ($active_theme->get_stylesheet() === $theme_slug) {
            wp_send_json_success(array('message' => __('Child theme activated successfully.', 'creote')));
        } else {
            wp_send_json_error(array('message' => __('Failed to activate child theme.', 'creote')));
        }
    }
    
 /**
 * Enhanced plugins step - FIXED VERSION
 */
public function plugins_step() {
    // Force refresh plugins based on current selection
    $this->get_required_plugins();
    
    $selected_builder = get_option('creote_selected_page_builder', 'elementor');
    $builder_name = $selected_builder === 'elementor' ? 'Elementor' : 'WPBakery Page Builder';
    ?>
    <div class="wizard-step-content plugins-page">
        <h2><?php _e('Manage Plugins', 'creote'); ?></h2>
        <p><?php printf(__('Install, activate, or deactivate plugins for your website with %s.', 'creote'), $builder_name); ?></p>
        
        <div class="notice notice-info">
            <p><strong><?php _e('Selected Page Builder:', 'creote'); ?></strong> <?php echo esc_html($builder_name); ?></p>
        </div>
        
        <div class="plugin-installation">
            <table class="plugin-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all-plugins"></th>
                        <th><?php _e('Plugin', 'creote'); ?></th>
                        <th><?php _e('Status', 'creote'); ?></th>
                        <th><?php _e('Action', 'creote'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->required_plugins as $plugin) : 
                        $plugin_path = $this->get_plugin_path($plugin['slug']);
                        $is_installed = file_exists(WP_PLUGIN_DIR . '/' . $plugin_path);
                        $is_active = $this->is_plugin_active_reliable($plugin['slug']);
                        $plugin_status = 'not-installed';
                        
                        if ($is_installed) {
                            $plugin_status = $is_active ? 'active' : 'inactive';
                        }
                        
                        $button_text = '';
                        $button_class = '';
                        $button_action = '';
                        
                        if ($plugin_status === 'not-installed') {
                            $button_text = __('Install', 'creote');
                            $button_class = 'install-plugin';
                            $button_action = 'install';
                        } elseif ($plugin_status === 'inactive') {
                            $button_text = __('Activate', 'creote');
                            $button_class = 'activate-plugin';
                            $button_action = 'activate';
                        } else {
                            // For active plugins, show deactivate button (unless required)
                            if ($plugin['required']) {
                                $button_text = __('Active (Required)', 'creote');
                                $button_class = 'button-disabled';
                                $button_action = '';
                            } else {
                                $button_text = __('Deactivate', 'creote');
                                $button_class = 'deactivate-plugin';
                                $button_action = 'deactivate';
                            }
                        }
                    ?>
                        <tr data-plugin-slug="<?php echo esc_attr($plugin['slug']); ?>" 
                            data-plugin-source="<?php echo esc_attr($plugin['source']); ?>" 
                            data-plugin-path="<?php echo esc_attr($plugin_path); ?>">
                            <td>
                                <input type="checkbox" 
                                       class="plugin-checkbox" 
                                       <?php echo esc_attr($plugin['required'] ? 'checked disabled' : ''); ?> 
                                    data-required='<?php echo esc_attr($plugin['required'] ? '1' : '0'); ?>'>
                            </td>
                            <td>
                                <strong><?php echo esc_html($plugin['name']); ?></strong>
                                <?php if ($plugin['required']) : ?>
                                    <span class="required-label"><?php _e('(Required)', 'creote'); ?></span>
                                <?php else : ?>
                                    <span class="recommended-label"><?php _e('(Recommended)', 'creote'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="plugin-status <?php echo esc_attr($plugin_status); ?>">
                                <?php 
                                if ($plugin_status === 'active') {
                                    _e('Active', 'creote');
                                } elseif ($plugin_status === 'inactive') {
                                    _e('Installed', 'creote');
                                } else {
                                    _e('Not Installed', 'creote');
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($button_class !== 'button-disabled') : ?>
                                    <button 
                                        class="button <?php echo esc_attr($button_class); ?>" 
                                        data-action="<?php echo esc_attr($button_action); ?>">
                                        <?php echo esc_html($button_text); ?>
                                    </button>
                                <?php else : ?>
                                    <span class="plugin-status-text"><?php echo esc_html($button_text); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="plugin-installation-status">
                <p class="plugin-installation-progress"></p>
            </div>
            
            <div class="plugin-installation-actions">
                <button class="button button-primary install-selected-plugins"><?php _e('Install & Activate Selected', 'creote'); ?></button>
                <button class="button button-secondary deactivate-selected-plugins"><?php _e('Deactivate Selected', 'creote'); ?></button>
            </div>
        </div>
    </div>
    <?php
}
    
   
  
 /**
 * Enhanced demo import step that shows builder-specific content
 */
public function demo_import_step() {
    $selected_builder = $this->get_selected_page_builder();
    $builder_name = $selected_builder === 'elementor' ? 'Elementor' : 'WPBakery Page Builder';
    
    // Get demos for the selected builder
    $demos = creote_ocdi_import_files();
    ?>
    <div class="wizard-step-content">
        <h2><?php _e('Demo Content Import', 'creote'); ?></h2>
        <p><?php printf(__('Choose a demo layout built for %s to quickly set up your website with pre-designed content.', 'creote'), $builder_name); ?></p>
        
        <div class="selected-builder-info">
            <div class="notice notice-info">
                <p>
                    <strong><?php _e('Selected Page Builder:', 'creote'); ?></strong> <?php echo esc_html($builder_name); ?>
                    <a href="<?php echo esc_url(add_query_arg('step', 'page_builder', admin_url('admin.php?page=creote'))); ?>" class="button button-small" style="margin-left: 10px;">
                        <?php _e('Change Builder', 'creote'); ?>
                    </a>
                </p>
            </div>
        </div>
        
        <div class="demo-import-section">
            <?php 
            // Check if One Click Demo Import plugin is installed and active
            $is_ocdi_active = $this->is_plugin_active_reliable('one-click-demo-import');
            
            if ($is_ocdi_active) : ?>
                <div class="notice notice-info">
                    <p><?php printf(__('One Click Demo Import plugin is ready. Select a %s demo below to begin importing.', 'creote'), $builder_name); ?></p>
                </div>
                
                <div class="stats-card-row">
                    <div class="stats-card">
                        <h4 class="stats-card-title"><?php _e('Available Demos', 'creote'); ?></h4>
                        <h3 class="stats-card-value"><?php echo count($demos); ?></h3>
                    </div>
                    <div class="stats-card">
                        <h4 class="stats-card-title"><?php _e('Page Builder', 'creote'); ?></h4>
                        <h3 class="stats-card-value"><?php echo esc_html($builder_name); ?></h3>
                    </div>
                    <div class="stats-card">
                        <h4 class="stats-card-title"><?php _e('Import Time', 'creote'); ?></h4>
                        <h3 class="stats-card-value">~5-10min</h3>
                    </div>
                </div>
                
                <div class="demo-selection">
                    <?php foreach ($demos as $index => $demo) : ?>
                        <div class="demo-item">
                            <h3><?php echo esc_html($demo['import_file_name']); ?></h3>
                            
                            <div class="demo-preview">
                                <?php if (!empty($demo['import_preview_image_url'])) : ?>
                                    <img src="<?php echo esc_url($demo['import_preview_image_url']); ?>" 
                                         alt="<?php echo esc_attr($demo['import_file_name']); ?> Screenshot" 
                                         class="demo-screenshot">
                                <?php endif; ?>
                                
                                <div class="demo-actions">
                                    <?php if (!empty($demo['preview_url'])) : ?>
                                        <a href="<?php echo esc_url($demo['preview_url']); ?>" 
                                           class="button button-secondary" 
                                           target="_blank">
                                            <span class="dashicons dashicons-visibility"></span>
                                            <?php _e('Preview', 'creote'); ?>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <a href="<?php echo esc_url(admin_url('themes.php?page=one-click-demo-import&step=import&import=' . $index)); ?>" 
                                       class="button button-primary import-demo-button">
                                        <span class="dashicons dashicons-download"></span>
                                        <?php _e('Import Demo', 'creote'); ?>
                                    </a>
                                </div>
                            </div>
                            
                            <p><?php echo esc_html($demo['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else : ?>
                <div class="notice notice-warning">
                    <p><?php _e('One Click Demo Import plugin is not active. Please install and activate it first.', 'creote'); ?></p>
                </div>
                <div class="demo-import-actions">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=creote&step=plugins')); ?>" 
                       class="button button-primary button-hero">
                        <span class="dashicons dashicons-admin-plugins"></span>
                        <?php _e('Go to Plugins Step', 'creote'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="demo-import-note">
            <div class="notice notice-info">
                <h4><?php _e('Import Information', 'creote'); ?></h4>
                <p><?php printf(__('Importing demo content will add pages, posts, images, and theme settings optimized for %s to your site.', 'creote'), $builder_name); ?></p>
                <p><?php _e('We rcreotemend doing this on a fresh WordPress installation to avoid conflicts with your existing content.', 'creote'); ?></p>
                <p><strong><?php _e('Note:', 'creote'); ?></strong> <?php _e('The import process may take several minutes depending on your server configuration.', 'creote'); ?></p>
            </div>
        </div>
        
        <style>
        .selected-builder-info {
            margin: 20px 0;
        }
        
        .selected-builder-info .notice {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .selected-builder-info .notice p {
            margin: 0;
            display: flex;
            align-items: center;
        }
        </style>
        
        <?php do_action('creote_cleanup_duplicates_page') ?>
    </div>
    <?php
}

    
  
/**
 * Enhanced done step with better UI
 * Replace the existing done_step method
 */
public function done_step() {
     // Get current theme
     $current_theme = wp_get_theme();
     $parent_theme = $current_theme->parent() ? $current_theme->parent() : $current_theme;
     $parent_theme_slug = $parent_theme->get_stylesheet();
     $child_theme_slug = $parent_theme_slug . '-child';
 
     // Check child theme status
     $child_theme_status = 'Not Created';
     $child_theme_exists = wp_get_theme($child_theme_slug);
     
     if ($current_theme->parent()) {
         $child_theme_status = 'Active';
     } elseif ($child_theme_exists->exists()) {
         $child_theme_status = 'Installed (Not Active)';
     }
 
    ?>
    <div class="wizard-step-content">
    <div class="completed_setup">
    <div class="setup-complete-icon">
            <span class="dashicons dashicons-yes-alt"></span>
        </div>
        <h2><?php _e('Setup Complete!', 'creote'); ?></h2>
        <p><?php printf(__('Congratulations! %s has been set up successfully.', 'creote'), $this->theme_name); ?></p>
</div>
        
        <div class="stats-card-row">
            <div class="stats-card">
                <h4 class="stats-card-title"><?php _e('Theme', 'creote'); ?></h4>
                <h3 class="stats-card-value"><?php echo esc_html($this->theme_name); ?> <span class="dashicons dashicons-yes-alt" style="color:var(--success-color);"></span></h3>
            </div>
            <div class="stats-card">
                <h4 class="stats-card-title"><?php _e('Plugins Activated', 'creote'); ?></h4>
                <h3 class="stats-card-value">
                    <?php 
                    $active_plugins = count(get_option('active_plugins'));
                 echo esc_html($active_plugins);
                    ?>
                </h3>
            </div>
            <div class="stats-card">
                <h4 class="stats-card-title"><?php _e('Child Theme', 'creote'); ?></h4>
                <h3 class="stats-card-value">
                <?php 
                    if ($child_theme_status === 'Active') {
                        echo '<span style="color:var(--success-color)"><span class="dashicons dashicons-yes-alt"></span> Active</span>';
                    } elseif ($child_theme_status === 'Installed (Not Active)') {
                        echo '<span style="color:var(--warning-color)"><span class="dashicons dashicons-warning"></span> Installed (Not Active)</span>';
                    } else {
                        echo '<span style="color:var(--text-medium)">Not Created</span>';
                    }
                    ?>
                </h3>
            </div>
        </div>
        
        <div class="next-steps">
            <h3><?php _e('Next Steps', 'creote'); ?></h3>
            <ul class="next-steps-list">
                <li>
                    <span class="dashicons dashicons-admin-appearance"></span>
                    <div class="next-step-content">
                        <h4><?php _e('Customize Your Theme', 'creote'); ?></h4>
                        <p><?php _e('Adjust colors, layouts, and more to match your brand.', 'creote'); ?></p>
                        <a class="button button-primary" href="<?php echo esc_url(admin_url('customize.php')); ?>">
                            <?php _e('Customize Theme', 'creote'); ?>
                        </a>
                    </div>
                </li>
                <li>
                    <span class="dashicons dashicons-admin-page"></span>
                    <div class="next-step-content">
                        <h4><?php _e('Edit Your Pages', 'creote'); ?></h4>
                        <p><?php _e('Review and modify your imported pages or create new ones.', 'creote'); ?></p>
                        <a class="button button-secondary" href="<?php echo esc_url(admin_url('edit.php?post_type=page')); ?>">
                            <?php _e('Manage Pages', 'creote'); ?>
                        </a>
                    </div>
                </li>
                <li>
                    <span class="dashicons dashicons-dashboard"></span>
                    <div class="next-step-content">
                        <h4><?php _e('Return to Dashboard', 'creote'); ?></h4>
                        <p><?php _e('Go back to WordPress dashboard to manage your content.', 'creote'); ?></p>
                        <a class="button button-secondary" href="<?php echo esc_url(admin_url()); ?>">
                            <?php _e('Go to Dashboard', 'creote'); ?>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
        
     
    </div>
    
    <style>
        .setup-complete-icon {
            text-align: center;
            margin: 0 auto 30px;
        }
        .setup-complete-icon .dashicons {
            font-size: 80px;
            width: 80px;
            height: 80px;
            background: var(--success-color);
            color: white;
            border-radius: 50%;
            padding: 20px;
        }
        .next-steps-list {
            list-style: none;
            padding: 0;
            margin: 30px 0;
            display: flex;
            gap: 1rem;
        }
        .next-steps-list li {
            display: flex;
            margin-bottom: 20px;
            padding: 20px;
            background: var(--bg-light);
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
        }
        .next-steps-list .dashicons {
            font-size: 30px;
            width: 30px;
            height: 30px;
            margin-right: 20px;
            color: var(--primary-color);
        }
        .next-step-content {
            flex: 1;
        }
        .next-step-content h4 {
            margin-top: 0;
            margin-bottom: 10px;
        }
        .next-step-content p {
            margin-bottom: 15px;
        }
        .setup-complete-message {
            text-align: center;
            margin-top: 40px;
        }
    </style>
    <?php
}

     /**
 * Get plugin path based on slug
 */
 private function get_plugin_path($plugin_slug) {
    switch ($plugin_slug) {
        // Base plugins (in order from the attachment)
        case 'contact-form-7':
            return 'contact-form-7/wp-contact-form-7.php';
        case 'one-click-demo-import':
            return 'one-click-demo-import/one-click-demo-import.php';
        case 'woocommerce':
            return 'woocommerce/woocommerce.php';
        case 'mailchimp-for-wp':
            return 'mailchimp-for-wp/mailchimp-for-wp.php';
        case 'revslider':
            return 'revslider/revslider.php';
        case 'meta-box':
            return 'meta-box/meta-box.php';
        case 'kirki':
            return 'kirki/kirki.php'; 
        
        // Page builder specific plugins
        case 'elementor':
            return 'elementor/elementor.php';
        case 'js_composer':
            return 'js_composer/js_composer.php';
        case 'creote-addons':
            return 'creote-addons/creote-addon.php'; 
        
        // YITH WooCommerce plugins
        case 'yith-woocommerce-compare':
            return 'yith-woocommerce-compare/init.php';
        case 'yith-woocommerce-wishlist':
            return 'yith-woocommerce-wishlist/init.php';
        
        // Default fallback
        default:
            return $plugin_slug . '/' . $plugin_slug . '.php';
    }
}
    
    /**
     * AJAX handler for plugin installation
     */
    public function ajax_install_plugin() {
        // Check nonce
        check_ajax_referer('theme_setup_wizard', 'nonce');
        
        // Check permissions
        if (!current_user_can('install_plugins')) {
            wp_send_json_error(array('message' => __('You do not have permission to install plugins.', 'creote')));
        }
        
        // Get plugin slug
        $plugin_slug = isset($_POST['slug']) ? sanitize_text_field($_POST['slug']) : '';
        $plugin_source = isset($_POST['source']) ? sanitize_text_field($_POST['source']) : '';
        
        if (empty($plugin_slug)) {
            wp_send_json_error(array('message' => __('Plugin slug is required.', 'creote')));
        }
        
        // Include required files for plugin installation
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php';
        
        // Check if plugin is already installed
        $plugin_path = $this->get_plugin_path($plugin_slug);
        if (file_exists(WP_PLUGIN_DIR . '/' . $plugin_path)) {
            wp_send_json_success(array(
                'message' => __('Plugin is already installed.', 'creote'),
                'slug' => $plugin_slug,
                'path' => $plugin_path
            ));
        }
        
        // Set up the upgrader
        $skin = new WP_Ajax_Upgrader_Skin();
        $upgrader = new Plugin_Upgrader($skin);
        
        // Install from custom source (bundled plugin) or WordPress repository
        if (!empty($plugin_source)) {
            // Install from local source
            $result = $upgrader->install($plugin_source);
        } else {
            // Get plugin info from repository
            $api = plugins_api('plugin_information', array(
                'slug' => $plugin_slug,
                'fields' => array(
                    'short_description' => false,
                    'sections' => false,
                    'requires' => false,
                    'rating' => false,
                    'ratings' => false,
                    'downloaded' => false,
                    'last_updated' => false,
                    'added' => false,
                    'tags' => false,
                    'compatibility' => false,
                    'homepage' => false,
                    'donate_link' => false,
                ),
            ));
            
            if (is_wp_error($api)) {
                wp_send_json_error(array('message' => $api->get_error_message()));
            }
            
            // Install from WordPress repository
            $result = $upgrader->install($api->download_link);
        }
        
        // Check for installation errors
        if (is_wp_error($result)) {
            wp_send_json_error(array('message' => $result->get_error_message()));
        } elseif (is_wp_error($skin->result)) {
            wp_send_json_error(array('message' => $skin->result->get_error_message()));
        } elseif ($skin->get_errors()->has_errors()) {
            wp_send_json_error(array('message' => $skin->get_error_messages()));
        } elseif (is_null($result)) {
            wp_send_json_error(array('message' => __('Plugin installation failed for an unknown reason.', 'creote')));
        }
        
        // Installation was successful, return success response
        wp_send_json_success(array(
            'message' => __('Plugin installed successfully.', 'creote'),
            'slug' => $plugin_slug,
            'path' => $plugin_path
        ));
    }
    /**
 * AJAX handler for plugin deactivation
 */
public function ajax_deactivate_plugin() {
    // Check nonce
    check_ajax_referer('theme_setup_wizard', 'nonce');
    
    // Check permissions
    if (!current_user_can('deactivate_plugins')) {
        wp_send_json_error(array('message' => __('You do not have permission to deactivate plugins.', 'creote')));
    }
    
    // Get plugin path
    $plugin_path = isset($_POST['path']) ? sanitize_text_field($_POST['path']) : '';
    
    if (empty($plugin_path)) {
        wp_send_json_error(array('message' => __('Plugin path is required.', 'creote')));
    }
    
    // Include required files
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    
    // Check if plugin is active using reliable method
    $plugin_slug = basename(dirname($plugin_path));
    if (!$this->is_plugin_active_reliable($plugin_slug)) {
        wp_send_json_success(array(
            'message' => __('Plugin is already deactivated.', 'creote'),
            'path' => $plugin_path
        ));
    }
    
    // Deactivate the plugin
    deactivate_plugins($plugin_path);
    
    // Check if deactivation was successful using reliable method
    if (!$this->is_plugin_active_reliable($plugin_slug)) {
        wp_send_json_success(array(
            'message' => __('Plugin deactivated successfully.', 'creote'),
            'path' => $plugin_path
        ));
    } else {
        wp_send_json_error(array('message' => __('Failed to deactivate plugin.', 'creote')));
    }
}
    /**
     * AJAX handler for plugin activation
     */
    public function ajax_activate_plugin() {
        // Check nonce
        check_ajax_referer('theme_setup_wizard', 'nonce');
        
        // Check permissions
        if (!current_user_can('activate_plugins')) {
            wp_send_json_error(array('message' => __('You do not have permission to activate plugins.', 'creote')));
        }
        
        // Get plugin path
        $plugin_path = isset($_POST['path']) ? sanitize_text_field($_POST['path']) : '';
        
        if (empty($plugin_path)) {
            wp_send_json_error(array('message' => __('Plugin path is required.', 'creote')));
        }
        
        // Include required files
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        
        // Check if plugin is already active using reliable method
        $plugin_slug = basename(dirname($plugin_path));
        if ($this->is_plugin_active_reliable($plugin_slug)) {
            wp_send_json_success(array(
                'message' => __('Plugin is already active.', 'creote'),
                'path' => $plugin_path
            ));
        }
        
        // Activate the plugin
        $result = activate_plugin($plugin_path);
        
        // Check for activation errors
        if (is_wp_error($result)) {
            wp_send_json_error(array('message' => $result->get_error_message()));
        }
        
        // Activation was successful, return success response
        wp_send_json_success(array(
            'message' => __('Plugin activated successfully.', 'creote'),
            'path' => $plugin_path
        ));
    }
}

// Initialize the class
add_action( 'init', function() {
	new Integrated_Theme_Setup_Wizard();
} );