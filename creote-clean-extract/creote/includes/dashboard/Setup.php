<?php
/**
 * MINIMAL FIXES ONLY - Just Security & Menu Issues
 * Your original code with only essential security fixes and menu fix
 * Enhanced with Revolution Slider Import Support
 */

/**
 * Include theme setup wizard
 */
require_once get_template_directory() . '/includes/dashboard/Themewizard.php';  

/**
 * Theme Setup Wizard Redirection - SECURITY FIX ADDED
 */
function theme_setup_wizard_redirect() {
    global $pagenow;
    
    // SECURITY FIX: Add capability check
    if (!current_user_can('switch_themes')) {
        return;
    }
    
    // Check if we're on the theme activation page
    if (is_admin() && 'themes.php' == $pagenow && isset($_GET['activated'])) {
        // SECURITY FIX: Sanitize input
        $activated = sanitize_text_field($_GET['activated']);
        if ($activated === '1') {
            wp_redirect(admin_url('admin.php?page=creote'));
            exit;
        }
    }
}
add_action('admin_init', 'theme_setup_wizard_redirect');

/**
 * Optional: Add a cleanup function to remove activation flags for old themes
 */
function theme_setup_wizard_cleanup_activation_flags() {
    // SECURITY FIX: Add capability check
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Get all themes
    $themes = wp_get_themes();
    
    // Collect current theme slugs
    $current_theme_slugs = array_map(function($theme) {
        return $theme->get_stylesheet();
    }, $themes);
    
    // Find and delete old activation flags
    $option_prefix = 'theme_first_activation_';
    
    global $wpdb;
    $activation_flags = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT option_name FROM {$wpdb->options} 
             WHERE option_name LIKE %s",
            $wpdb->esc_like($option_prefix) . '%'
        )
    );
    
    foreach ($activation_flags as $flag) {
        $theme_slug = str_replace($option_prefix, '', $flag->option_name);
        
        // Remove flag if theme no longer exists
        if (!in_array($theme_slug, $current_theme_slugs)) {
            delete_option($flag->option_name);
        }
    }
}
add_action('after_switch_theme', 'theme_setup_wizard_cleanup_activation_flags');

// Include TGM Plugin Activation
require_once get_template_directory() . '/includes/dashboard/class-tgm-plugin-activation.php'; 
require_once get_template_directory() . '/includes/dashboard/Plugins.php'; 
 
/**
 * Enhanced demo import function with Revolution Slider support
 * Replace your existing creote_ocdi_import_files function with this
 */
function creote_ocdi_import_files() {
    // SECURITY FIX: Add capability check
    if (!current_user_can('import')) {
        return array();
    }
    
    $selected_builder = get_option('creote_selected_page_builder', 'elementor');
    
    $demos = array();
	$theme_directory_url = get_template_directory_uri();
	$image_path1 = $theme_directory_url . '/includes/demo-content/demo-content/demo-content-version-2/screenshot.jpg'; 
	$image_path2 = $theme_directory_url . '/includes/demo-content/demo-content/demo-wpbakery/screenshot-wp.jpg';   
    
    if ($selected_builder === 'elementor') {
        $demos = array(
            array(
			'import_file_name'           => 'Creote Elementor  Demo Content (Home 1 to 12 pages)',
            'description'    => 'The demo comes with version 1 pages with home 1 to home 12',
			'local_import_file'            => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-content-version-1/creoteelementor3.xml',  
			'local_import_widget_file'     => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-content-version-1/c-widgets.wie',
			'local_import_redux'               => array(
			  array(
			  'file_path'   => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-content-version-1/redux_options_3.json',
			  'option_name' => 'creote_theme_mod',
			  ),
			),
			'import_rev_slider_file_url' => array(
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/home-eleven.zip',
                    'name'     => 'Home Slider 1',
                    'alias'    => 'slider-11', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/Home-Four.zip',
					'name'     => 'Home Slider 2',
                    'alias'    => 'Home-Four', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/home-one.zip',
					'name'     => 'Home Slider 3',
                    'alias'    => 'home-one', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/Home-Three.zip',
					'name'     => 'Home Slider 4',
                    'alias'    => 'Home-Three', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/home-twelve.zip',
					'name'     => 'Home Slider 5',
                    'alias'    => 'slider-1-1', // Slider alias for easier reference
                ), 
				array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/slider-1.zip',
                	 'name'     => 'Home Slider 6',
                    'alias'    => 'slider-1', // Slider alias for easier reference
                ), 
				array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/slider-2.zip',
					'name'     => 'Home Slider 7',
                    'alias'    => 'slider-2', // Slider alias for easier reference
                ), 
            ),
			'import_preview_image_url'   => esc_url($image_path1), 
			'import_notice'              => __( 'Creote Elementor  Demo Content (Home 11 To  12 )', 'creote' ),
			'preview_url'                => 'https://themepanthers.com/wp/creote/demo-content/v-new/',
		  ),   
            array(
			'import_file_name'           => 'Creote Elementor  Demo Content (Home 13 To  16 )',
              'description'    => 'The demo comes with version 2 pages with home 13 to home 16',
			'local_import_file'            => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-content-version-2/creote-sml-version-2.xml',
			'local_import_widget_file'     => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-content-version-2/widget-version-2.wie',
			'local_import_redux'               => array(
			  array(
			  'file_path'   => trailingslashit(get_template_directory())  . '/includes/demo-content/demo-content/demo-content-version-2/redux_options__version-2.json',
			  'option_name' => 'creote_theme_mod',
			  ),
			),
			'import_rev_slider_file_url' => array(
               array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/home-eleven.zip',
                    'name'     => 'Home Slider 1',
                    'alias'    => 'slider-11', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/Home-Four.zip',
					'name'     => 'Home Slider 2',
                    'alias'    => 'Home-Four', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/home-one.zip',
					'name'     => 'Home Slider 3',
                    'alias'    => 'home-one', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/Home-Three.zip',
					'name'     => 'Home Slider 4',
                    'alias'    => 'Home-Three', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/home-twelve.zip',
					'name'     => 'Home Slider 5',
                    'alias'    => 'slider-1-1', // Slider alias for easier reference
                ), 
				array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/slider-1.zip',
                	 'name'     => 'Home Slider 6',
                    'alias'    => 'slider-1', // Slider alias for easier reference
                ), 
				array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/slider-2.zip',
					'name'     => 'Home Slider 7',
                    'alias'    => 'slider-2', // Slider alias for easier reference
                ), 
            ),
			'import_preview_image_url'   => esc_url($image_path1), 
			'import_notice'              => __( 'Creote Elementor  Demo Content (Home 13 To  16 )', 'creote' ),
			'preview_url'                => 'https://themepanthers.com/wp/creote/demo-content/v2-new',
		  ),
        );
    } elseif ($selected_builder === 'wpbakery') {
        $demos = array(
           array(
			'import_file_name'           => 'Creote Wpbakery Demo Content',
                        'description'    => 'The demo comes with all pages with home 1 to home 4',
			'local_import_file'            => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-wpbakery/content-wpbakery.xml',
			'local_import_widget_file'     => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-wpbakery/widget.wie',
			'local_import_redux'               => array(
			  array(
			  'file_path'   => trailingslashit(get_template_directory())  . '/includes/demo-content/demo-content/demo-wpbakery/wp_redux.json',
			  'option_name' => 'creote_theme_mod',
			  ),
			),
			'import_preview_image_url'   => esc_url($image_path2), 
			'import_rev_slider_file_url' => array(
              array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/home-eleven.zip',
                    'name'     => 'Home Slider 1',
                    'alias'    => 'slider-11', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/Home-Four.zip',
					'name'     => 'Home Slider 2',
                    'alias'    => 'Home-Four', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/home-one.zip',
					'name'     => 'Home Slider 3',
                    'alias'    => 'home-one', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/Home-Three.zip',
					'name'     => 'Home Slider 4',
                    'alias'    => 'Home-Three', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/home-twelve.zip',
					'name'     => 'Home Slider 5',
                    'alias'    => 'slider-1-1', // Slider alias for easier reference
                ), 
				array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/slider-1.zip',
                	 'name'     => 'Home Slider 6',
                    'alias'    => 'slider-1', // Slider alias for easier reference
                ), 
				array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/slider-2.zip',
					'name'     => 'Home Slider 7',
                    'alias'    => 'slider-2', // Slider alias for easier reference
                ), 
            ), 
			'import_notice'              => __( 'Creote Wpbakery Demo Content One Main Demo Home 1 to 4', 'creote' ),
			'preview_url'                => 'https://themepanthers.com/wp/creote/demo-content/version-1/',
		  )
        );
    } else {
        // Default to Elementor
        $demos = array(
            array(
			'import_file_name'           => 'Creote Elementor  Demo Content (Home 1 to 12 pages)',
            'description'    => 'The demo comes with version 1 pages with home 1 to home 12',
			'local_import_file'            => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-content-version-1/creoteelementor3.xml',  
			'local_import_widget_file'     => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-content-version-1/c-widgets.wie',
			'local_import_redux'               => array(
			  array(
			  'file_path'   => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-content-version-1/redux_options_3.json',
			  'option_name' => 'creote_theme_mod',
			  ),
			),
			'import_rev_slider_file_url' => array(
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/home-eleven.zip',
                    'name'     => 'Home Slider 1',
                    'alias'    => 'slider-11', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/Home-Four.zip',
					'name'     => 'Home Slider 2',
                    'alias'    => 'Home-Four', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/home-one.zip',
					'name'     => 'Home Slider 3',
                    'alias'    => 'home-one', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/Home-Three.zip',
					'name'     => 'Home Slider 4',
                    'alias'    => 'Home-Three', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/home-twelve.zip',
					'name'     => 'Home Slider 5',
                    'alias'    => 'slider-1-1', // Slider alias for easier reference
                ), 
				array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/slider-1.zip',
                	 'name'     => 'Home Slider 6',
                    'alias'    => 'slider-1', // Slider alias for easier reference
                ), 
				array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/slider-2.zip',
					'name'     => 'Home Slider 7',
                    'alias'    => 'slider-2', // Slider alias for easier reference
                ), 
            ),
			'import_preview_image_url'   => esc_url($image_path1), 
			'import_notice'              => __( 'Creote Elementor  Demo Content (Home 11 To  12 )', 'creote' ),
			'preview_url'                => 'https://themepanthers.com/wp/creote/demo-content/v-new/',
		  ), 
            array(
			'import_file_name'           => 'Creote Elementor  Demo Content (Home 13 To  16 )',
                 'description'    => 'The demo comes with version 2 pages with home 13 to home 16',
			'local_import_file'            => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-content-version-2/creote-sml-version-2.xml',
			'local_import_widget_file'     => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-content-version-2/widget-version-2.wie',
			'local_import_redux'               => array(
			  array(
			  'file_path'   => trailingslashit(get_template_directory())  . '/includes/demo-content/demo-content/demo-content-version-2/redux_options__version-2.json',
			  'option_name' => 'creote_theme_mod',
			  ),
			),
			'import_rev_slider_file_url' => array(
                 array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/home-eleven.zip',
                    'name'     => 'Home Slider 1',
                    'alias'    => 'slider-11', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/Home-Four.zip',
					'name'     => 'Home Slider 2',
                    'alias'    => 'Home-Four', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/home-one.zip',
					'name'     => 'Home Slider 3',
                    'alias'    => 'home-one', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/Home-Three.zip',
					'name'     => 'Home Slider 4',
                    'alias'    => 'Home-Three', // Slider alias for easier reference
                ),
                array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/home-twelve.zip',
					'name'     => 'Home Slider 5',
                    'alias'    => 'slider-1-1', // Slider alias for easier reference
                ), 
				array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/slider-1.zip',
                	 'name'     => 'Home Slider 6',
                    'alias'    => 'slider-1', // Slider alias for easier reference
                ), 
				array(
                    'file_url' => 'https://themepanthers.com/wp/creote/demo-content/slider-2.zip',
					'name'     => 'Home Slider 7',
                    'alias'    => 'slider-2', // Slider alias for easier reference
                ),  
            ),
			'import_preview_image_url'   => esc_url($image_path1), 
			'import_notice'              => __( 'Creote Elementor  Demo Content (Home 13 To  16 )', 'creote' ),
			'preview_url'                => 'https://themepanthers.com/wp/creote/demo-content/v2-new',
		  ),
        );
    }
    
    return $demos;
}

add_filter('ocdi/import_files', 'creote_ocdi_import_files');

/**
 * Enhanced Revolution Slider import handler
 * This function handles the actual import of Revolution Slider files
 */
function creote_import_revolution_sliders($selected_import) {
    // Check if Revolution Slider plugin is active
    if (!class_exists('RevSlider')) {
        error_log('creote REVSLIDER ERROR: Revolution Slider plugin is not active');
        return false;
    }
    
    // Check if we have slider data to import
    if (empty($selected_import['import_rev_slider_file_url'])) {
        error_log('creote REVSLIDER INFO: No Revolution Slider data to import');
        return true;
    }
    
    $slider_import_success = true;
    
    foreach ($selected_import['import_rev_slider_file_url'] as $slider_data) {
        $slider_file = '';
        
        // Try to get the slider file - first check local path, then remote URL
        if (!empty($slider_data['file_path']) && file_exists($slider_data['file_path'])) {
            $slider_file = $slider_data['file_path'];
            error_log('creote REVSLIDER INFO: Using local slider file: ' . $slider_file);
        } elseif (!empty($slider_data['file_url'])) {
            // Download remote file to temporary location
            $slider_file = creote_download_slider_file($slider_data['file_url'], $slider_data['name']);
            if (!$slider_file) {
                error_log('creote REVSLIDER ERROR: Failed to download slider: ' . $slider_data['name']);
                $slider_import_success = false;
                continue;
            }
        } else {
            error_log('creote REVSLIDER ERROR: No valid slider file source for: ' . $slider_data['name']);
            $slider_import_success = false;
            continue;
        }
        
        // Import the slider
        $import_result = creote_import_single_revolution_slider($slider_file, $slider_data);
        
        if (!$import_result) {
            error_log('creote REVSLIDER ERROR: Failed to import slider: ' . $slider_data['name']);
            $slider_import_success = false;
        } else {
            error_log('creote REVSLIDER SUCCESS: Imported slider: ' . $slider_data['name']);
        }
        
        // Clean up temporary file if it was downloaded
        if (strpos($slider_file, wp_upload_dir()['basedir']) !== false) {
            @unlink($slider_file);
        }
    }
    
    return $slider_import_success;
}

/**
 * Download Revolution Slider file from remote URL
 */
function creote_download_slider_file($url, $slider_name) {
    // Create uploads directory for temporary files
    $upload_dir = wp_upload_dir();
    $temp_dir = $upload_dir['basedir'] . '/creote-temp-sliders/';
    
    if (!file_exists($temp_dir)) {
        wp_mkdir_p($temp_dir);
    }
    
    // Generate safe filename
    $filename = sanitize_file_name($slider_name . '.zip');
    $local_file = $temp_dir . $filename;
    
    // Download the file
    $response = wp_remote_get($url, array(
        'timeout' => 300,
        'sslverify' => false
    ));
    
    if (is_wp_error($response)) {
        error_log('creote REVSLIDER DOWNLOAD ERROR: ' . $response->get_error_message());
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    
    if (empty($body)) {
        error_log('creote REVSLIDER DOWNLOAD ERROR: Empty response body for: ' . $url);
        return false;
    }
    
    // Save file
    $saved = file_put_contents($local_file, $body);
    
    if ($saved === false) {
        error_log('creote REVSLIDER DOWNLOAD ERROR: Could not save file: ' . $local_file);
        return false;
    }
    
    return $local_file;
}

/**
 * Import a single Revolution Slider
 */
function creote_import_single_revolution_slider($slider_file, $slider_data) {
    if (!class_exists('RevSlider')) {
        return false;
    }
    
    try {
        // Get Revolution Slider import class
        $slider = new RevSlider();
        
        // Check if the method exists (different versions might have different methods)
        if (method_exists($slider, 'importSliderFromPost')) {
            // For newer versions
            $response = $slider->importSliderFromPost(true, true, $slider_file);
        } elseif (method_exists('RevSliderSlider', 'importSliderFromPost')) {
            // Alternative method
            $response = RevSliderSlider::importSliderFromPost(true, true, $slider_file);
        } elseif (class_exists('RevSliderSliderImport')) {
            // For some versions
            $import = new RevSliderSliderImport();
            $response = $import->import_slider(true, $slider_file);
        } else {
            // Try the most basic import method
            if (function_exists('rs_import_slider_from_file')) {
                $response = rs_import_slider_from_file($slider_file);
            } else {
                error_log('creote REVSLIDER ERROR: No compatible import method found');
                return false;
            }
        }
        
        // Check if import was successful
        if (isset($response['success']) && $response['success'] === true) {
            error_log('creote REVSLIDER SUCCESS: ' . $slider_data['name'] . ' imported successfully');
            
            // If we have an alias, try to set it
            if (!empty($slider_data['alias']) && isset($response['sliderID'])) {
                creote_set_slider_alias($response['sliderID'], $slider_data['alias']);
            }
            
            return true;
        } elseif (isset($response['error'])) {
            error_log('creote REVSLIDER ERROR: ' . $response['error']);
            return false;
        } else {
            error_log('creote REVSLIDER WARNING: Unclear import result for ' . $slider_data['name']);
            return true; // Assume success if no clear error
        }
        
    } catch (Exception $e) {
        error_log('creote REVSLIDER EXCEPTION: ' . $e->getMessage());
        return false;
    }
}

/**
 * Set Revolution Slider alias
 */
function creote_set_slider_alias($slider_id, $alias) {
    if (!class_exists('RevSlider')) {
        return false;
    }
    
    try {
        global $wpdb;
        
        // Update slider alias in the database
        $table_name = $wpdb->prefix . 'revslider_sliders';
        
        $result = $wpdb->update(
            $table_name,
            array('alias' => $alias),
            array('id' => $slider_id),
            array('%s'),
            array('%d')
        );
        
        if ($result !== false) {
            error_log('creote REVSLIDER SUCCESS: Set alias "' . $alias . '" for slider ID ' . $slider_id);
            return true;
        } else {
            error_log('creote REVSLIDER ERROR: Failed to set alias for slider ID ' . $slider_id);
            return false;
        }
        
    } catch (Exception $e) {
        error_log('creote REVSLIDER ALIAS ERROR: ' . $e->getMessage());
        return false;
    }
}

/**
 * Clean up temporary slider files
 */
function creote_cleanup_temp_slider_files() {
    $upload_dir = wp_upload_dir();
    $temp_dir = $upload_dir['basedir'] . '/creote-temp-sliders/';
    
    if (file_exists($temp_dir)) {
        $files = glob($temp_dir . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
        @rmdir($temp_dir);
    }
}

/**
 * Function to import theme options from JSON file - SECURITY FIXES ADDED
 */
function creote_import_theme_options_from_file($selected_import) {
    // SECURITY FIX: Add capability check
    if (!current_user_can('import')) {
        return false;
    }
    
    if (!isset($selected_import['local_theme_options_file']) || empty($selected_import['local_theme_options_file'])) {
        return false;
    }
    
    $theme_options_file = $selected_import['local_theme_options_file'];
    
    // SECURITY FIX: Validate file path is within theme directory
    $theme_dir = realpath(get_template_directory());
    $real_file_path = realpath($theme_options_file);
    
    if (!$real_file_path || strpos($real_file_path, $theme_dir) !== 0) {
        error_log('creote SECURITY ERROR: Invalid file path: ' . $theme_options_file);
        return false;
    }
    
    // SECURITY FIX: Check file extension
    if (strtolower(pathinfo($theme_options_file, PATHINFO_EXTENSION)) !== 'json') {
        error_log('creote SECURITY ERROR: Invalid file extension');
        return false;
    }
    
    if (!file_exists($theme_options_file)) {
        error_log('creote THEME OPTIONS ERROR: Theme options file not found: ' . $theme_options_file);
        return false;
    }
    
    // SECURITY FIX: Check file size
    if (filesize($theme_options_file) > 1048576) { // 1MB limit
        error_log('creote SECURITY ERROR: File too large');
        return false;
    }
    
    $json_content = file_get_contents($theme_options_file);
    
    if ($json_content === false) {
        error_log('creote THEME OPTIONS ERROR: Could not read theme options file: ' . $theme_options_file);
        return false;
    }
    
    $theme_options = json_decode($json_content, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('creote THEME OPTIONS ERROR: Invalid JSON in theme options file: ' . $theme_options_file);
        return false;
    }
    
    if (!is_array($theme_options)) {
        error_log('creote THEME OPTIONS ERROR: Theme options data is not an array in file: ' . $theme_options_file);
        return false;
    }
    
    // SECURITY FIX: Enhanced sanitization
    $sanitized_options = creote_basic_sanitize_theme_options($theme_options);
    
    update_option('steelthemes_options', $sanitized_options);
    
    error_log('creote THEME OPTIONS SUCCESS: Theme options imported successfully from: ' . $theme_options_file);
    return true;
}

/**
 * SECURITY FIX: Enhanced sanitization function
 */
function creote_basic_sanitize_theme_options($options) {
    $sanitized = array();
    
    if (!is_array($options)) {
        return $sanitized;
    }
    
    foreach ($options as $key => $value) {
        $clean_key = sanitize_key($key);
        
        if (is_array($value)) {
            $sanitized[$clean_key] = creote_basic_sanitize_theme_options($value);
        } elseif (is_string($value)) {
            // SECURITY FIX: Check for potential XSS
            if (preg_match('/<script|javascript:|on\w+\s*=/i', $value)) {
                $sanitized[$clean_key] = wp_strip_all_tags($value);
            } elseif (strpos($value, '#') === 0 && strlen($value) === 7) {
                $sanitized[$clean_key] = sanitize_hex_color($value);
            } elseif (filter_var($value, FILTER_VALIDATE_URL)) {
                $sanitized[$clean_key] = esc_url_raw($value);
            } else {
                $sanitized[$clean_key] = sanitize_text_field($value);
            }
        } elseif (is_numeric($value)) {
            $sanitized[$clean_key] = is_float($value + 0) ? floatval($value) : intval($value);
        } else {
            $sanitized[$clean_key] = $value;
        }
    }
    
    return $sanitized;
}

/**
 * Enhanced after import setup with IMPROVED MENU FIX for specific demos
 */
function theme_ocdi_after_import_setup($selected_import) {
    // SECURITY FIX: Add capability check
    if (!current_user_can('import')) {
        return;
    }
    
    $selected_builder = get_option('creote_selected_page_builder', 'elementor');
    
    // FIRST: Import theme options
    creote_import_theme_options_from_file($selected_import);
    
    // Import Revolution Sliders
    error_log('creote REVSLIDER: Starting Revolution Slider import process');
    $slider_import_result = creote_import_revolution_sliders($selected_import);
    
    if ($slider_import_result) {
        error_log('creote REVSLIDER: All sliders imported successfully');
    } else {
        error_log('creote REVSLIDER: Some sliders failed to import');
    }
    
    // Assign menus to their locations
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'creote'),
    )); 
    
    // IMPROVED MENU FIX: Map demos to their specific menus
    $import_name = $selected_import['import_file_name'];
    $target_menu = null;
    
    // Define which menu should be kept for each demo
     if ($import_name == "Creote Elementor  Demo Content (Home 1 to 12 pages)") {
        $target_menu = 'Main Menu Elementor';
    } 
     elseif ($import_name == "Creote Elementor  Demo Content (Home 13 To  16 )") {
        $target_menu = 'main menu'; // WPBakery uses Menu 1  	
     }
      elseif ($import_name == "Creote Wpbakery Demo Content") {
        $target_menu = 'main menu'; // WPBakery uses Menu 1  			
    }
    
    // All possible menus that could exist
    $all_demo_menus = array('Main Menu Elementor', '');
    
    // Find all existing demo menus
    $existing_menus = array();
    foreach ($all_demo_menus as $menu_name) {
        $menu = wp_get_nav_menu_object($menu_name);
        if ($menu && !is_wp_error($menu)) {
            $existing_menus[$menu_name] = $menu;
        }
    }
    
    // Clean up menus: keep only the target menu, delete others
    if (!empty($existing_menus)) {
        foreach ($existing_menus as $menu_name => $menu) {
            if ($menu_name === $target_menu) {
                // Keep this menu and assign it to primary location
                $locations = get_theme_mod('nav_menu_locations', array());
                $locations['primary'] = $menu->term_id;
                set_theme_mod('nav_menu_locations', $locations);
                error_log('creote MENU RETAINED: Keeping menu "' . $menu->name . '" (ID: ' . $menu->term_id . ') for demo: ' . $import_name);
            } else {
                // Delete this menu as it's not needed for current demo
                wp_delete_nav_menu($menu->term_id);
                error_log('creote MENU DELETION: Deleted menu "' . $menu->name . '" (ID: ' . $menu->term_id . ') as it\'s not needed for demo: ' . $import_name);
            }
        }
    } else {
        // No demo menus found, try to assign any available menu
        creote_fix_menu_assignments();
        error_log('creote MENU CHECK: No demo-specific menus found, using fallback assignment for demo: ' . $import_name);
    }
    
    // Set Front page based on selected import
    $front_page = null;

    if ($import_name == "Creote Elementor  Demo Content (Home 1 to 12 pages)") {
        $front_page = get_page_by_title('Home Default');
    }
    elseif ($import_name == "Creote Elementor  Demo Content (Home 13 To  16 )") {
        $front_page = get_page_by_title('Home');
    }
    elseif ($import_name == "Creote Wpbakery Demo Content") {
        $front_page = get_page_by_title('Home Default');
    }
     
    if ($front_page) {
        update_option('page_on_front', $front_page->ID);
        update_option('show_on_front', 'page');
    }

    // Set Blog page
    $blogpage = get_page_by_title('Blog');
    if ($blogpage) {
        update_option('page_for_posts', $blogpage->ID);
    }

    update_option('permalink_structure', '/%postname%/');

    if ($selected_builder === 'wpbakery') {
        if (class_exists('Vc_Manager')) {
            $vc_settings = array(
                'vc_settings' => array(
                    'not_responsive_css' => '1',
                    'js_view_autoplay' => '',
                    'vc_grid_ajax_url' => admin_url('admin-ajax.php'),
                )
            );
            
            foreach ($vc_settings['vc_settings'] as $key => $value) {
                update_option($key, $value);
            }
        }
    }
    
    // MENU FIX: Schedule delayed menu fix as backup
    wp_schedule_single_event(time() + 3, 'creote_delayed_menu_fix', array($target_menu));
}
add_action('ocdi/after_import', 'theme_ocdi_after_import_setup');

/**
 * Hook Revolution Slider import into the after import process
 */
add_action('ocdi/after_import', 'creote_after_import_revolution_sliders', 15);

function creote_after_import_revolution_sliders($selected_import) {
    // SECURITY FIX: Add capability check
    if (!current_user_can('import')) {
        return;
    }
    
    // Clean up temporary files after import
    creote_cleanup_temp_slider_files();
}

/**
 * IMPROVED MENU FIX: Enhanced delayed menu assignment with target menu parameter
 */
function creote_delayed_menu_fix($target_menu = null) {
    if ($target_menu) {
        // Try to assign the specific target menu
        $menu = wp_get_nav_menu_object($target_menu);
        if ($menu && !is_wp_error($menu)) {
            $locations = get_theme_mod('nav_menu_locations', array());
            $locations['primary'] = $menu->term_id;
            set_theme_mod('nav_menu_locations', $locations);
            error_log('creote DELAYED MENU FIX: Assigned target menu "' . $target_menu . '" to primary location');
            return;
        }
    }
    
    // Fallback to original menu assignment logic
    creote_fix_menu_assignments();
    error_log('creote DELAYED MENU FIX: Used fallback menu assignment');
}
add_action('creote_delayed_menu_fix', 'creote_delayed_menu_fix');

/**
 * ENHANCED: Function to assign imported menus to locations with better logic
 */
function creote_fix_menu_assignments() {
    $menus = wp_get_nav_menus();
    
    if (empty($menus)) {
        return false;
    }
    
    $locations = get_theme_mod('nav_menu_locations', array());
    
    // Priority order for menu assignment
    $menu_priority = array('Menu 1', 'Menu Grocery', 'Menu Tools', 'Menu Furniture', 'Menu Plants');
    
    // First, try to find a menu from our priority list
    foreach ($menu_priority as $priority_menu) {
        foreach ($menus as $menu) {
            if ($menu->name === $priority_menu) {
                $locations['primary'] = $menu->term_id;
                set_theme_mod('nav_menu_locations', $locations);
                return true;
            }
        }
    }
    
    // If no priority menu found, look for main/primary/header menu
    foreach ($menus as $menu) {
        $menu_name = strtolower($menu->name);
        if (stripos($menu_name, 'main') !== false || 
            stripos($menu_name, 'primary') !== false ||
            stripos($menu_name, 'header') !== false) {
            $locations['primary'] = $menu->term_id;
            set_theme_mod('nav_menu_locations', $locations);
            return true;
        }
    }
    
    // If no specific menu found, use first menu
    if (empty($locations['primary']) && !empty($menus)) {
        $locations['primary'] = $menus[0]->term_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
    
    return true;
}

/**
 * Function to validate page builder selection before demo import
 */
function creote_validate_page_builder_before_import() {
    $selected_builder = get_option('creote_selected_page_builder', '');
    
    if (empty($selected_builder)) {
        wp_redirect(admin_url('admin.php?page=creote&step=page_builder'));
        exit;
    }
}

/**
 * Add page builder info to OCDI import page
 */
function creote_add_page_builder_info_to_ocdi() {
    $selected_builder = get_option('creote_selected_page_builder', 'elementor');
    $builder_name = $selected_builder === 'elementor' ? 'Elementor' : 'WPBakery Page Builder';
    
    ?>
    <div class="notice notice-info">
        <p>
            <strong><?php _e('Selected Page Builder:', 'creote'); ?></strong> <?php echo esc_html($builder_name); ?>
            <a href="<?php echo esc_url(admin_url('admin.php?page=creote&step=page_builder')); ?>" class="button button-small" style="margin-left: 10px;">
                <?php _e('Change', 'creote'); ?>
            </a>
        </p>
        <p><?php printf(__('The demos below are optimized for %s. Make sure you have completed the plugin installation before importing.', 'creote'), $builder_name); ?></p>
    </div>
    
    <style>
    .ocdi__demo-import-notice {
        margin-top: 10px;
        padding: 10px;
        background: #f0f8ff;
        border-left: 4px solid #0073aa;
    }
    
    .ocdi__demo-import-notice h4 {
        margin-top: 0;
        color: #0073aa;
    }
    </style>
    <?php
}
add_action('ocdi/before_content_import_form', 'creote_add_page_builder_info_to_ocdi');

/**
 * Add Revolution Slider status to the import notice
 */
add_filter('ocdi/import_files', 'creote_add_revslider_status_to_demos');

function creote_add_revslider_status_to_demos($demo_files) {
    $revslider_active = class_exists('RevSlider');
    
    foreach ($demo_files as &$demo) {
        if (!empty($demo['import_rev_slider_file_url'])) {
            $slider_count = count($demo['import_rev_slider_file_url']);
            
            if ($revslider_active) {
                $demo['import_notice'] = (isset($demo['import_notice']) ? $demo['import_notice'] . ' ' : '') . 
                    sprintf(__('Includes %d Revolution Slider(s) that will be automatically imported.', 'creote'), $slider_count);
            } else {
                $demo['import_notice'] = (isset($demo['import_notice']) ? $demo['import_notice'] . ' ' : '') . 
                    sprintf(__('Includes %d Revolution Slider(s). Please install Revolution Slider plugin first.', 'creote'), $slider_count);
            }
        }
    }
    
    return $demo_files;
}

/**
 * Check Revolution Slider plugin status before import
 */
add_action('ocdi/before_content_import', 'creote_check_revslider_before_import');

function creote_check_revslider_before_import($selected_import) {
    if (!empty($selected_import['import_rev_slider_file_url']) && !class_exists('RevSlider')) {
        error_log('creote REVSLIDER WARNING: Revolution Slider plugin is not active, but demo includes slider content');
        
        // Add admin notice
        add_action('admin_notices', function() {
            echo '<div class="notice notice-warning"><p>';
            echo __('Revolution Slider plugin is not active. Slider content will be skipped during import.', 'creote');
            echo '</p></div>';
        });
    }
}

/**
 * Log Revolution Slider import process
 */
function creote_log_revslider_import($selected_import) {
    if (!empty($selected_import['import_rev_slider_file_url'])) {
        $slider_count = count($selected_import['import_rev_slider_file_url']);
        error_log('creote REVSLIDER: Demo includes ' . $slider_count . ' Revolution Slider(s)');
        
        foreach ($selected_import['import_rev_slider_file_url'] as $slider) {
            error_log('creote REVSLIDER: - ' . $slider['name'] . ' (' . (isset($slider['alias']) ? $slider['alias'] : 'no alias') . ')');
        }
    }
}

add_action('ocdi/before_content_import', 'creote_log_revslider_import');

/**
 * Display Revolution Slider import status in admin
 */
function creote_display_revslider_import_status() {
    if (!class_exists('RevSlider')) {
        return;
    }
    
    // Get imported sliders
    global $wpdb;
    $table_name = $wpdb->prefix . 'revslider_sliders';
    $sliders = $wpdb->get_results("SELECT id, title, alias FROM {$table_name}");
    
    if (!empty($sliders)) {
        echo '<div class="notice notice-info">';
        echo '<h4>' . __('Revolution Sliders Imported:', 'creote') . '</h4>';
        echo '<ul>';
        foreach ($sliders as $slider) {
            echo '<li>' . esc_html($slider->title) . 
                 ((!empty($slider->alias)) ? ' (' . esc_html($slider->alias) . ')' : '') . 
                 ' - ID: ' . esc_html($slider->id) . '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
}

// Show slider status after import (if on the right page)
add_action('admin_notices', function() {
    if (isset($_GET['page']) && $_GET['page'] === 'one-click-demo-import' && isset($_GET['step']) && $_GET['step'] === 'import') {
        creote_display_revslider_import_status();
    }
});

// Rest of your original code continues unchanged...
function creote_add_page_builder_to_demo_items($demo_items) {
    $selected_builder = get_option('creote_selected_page_builder', 'elementor');
    
    foreach ($demo_items as &$demo) {
        if (isset($demo['page_builder'])) {
            $demo['import_notice'] = isset($demo['import_notice']) ? $demo['import_notice'] : '';
        }
        
        if (isset($demo['page_builder']) && $demo['page_builder'] === $selected_builder) {
            $demo['categories'] = isset($demo['categories']) ? $demo['categories'] : array();
            $demo['categories'][] = 'recommended';
        }
    }
    
    return $demo_items;
}
add_filter('ocdi/import_files', 'creote_add_page_builder_to_demo_items', 20);

/**
 * Add custom CSS for OCDI page based on selected page builder
 */
function creote_add_custom_ocdi_styles() {
    $screen = get_current_screen();
    if (!$screen || strpos($screen->base, 'one-click-demo-import') === false) {
        return;
    }
    
    ?>
    <style>
    .ocdi__demo-item[data-categories*="recommended"] {
        border: 2px solid #0073aa;
        position: relative;
    }
    
    .ocdi__demo-item[data-categories*="recommended"]:before {
        content: "recommended";
        position: absolute;
        top: -1px;
        right: -1px;
        background: #0073aa;
        color: white;
        padding: 4px 8px;
        font-size: 12px;
        border-radius: 0 0 0 4px;
        z-index: 10;
    }
    
    .ocdi__demo-import-notice {
        margin: 10px 0;
        padding: 10px;
        background: #f8f9fa;
        border-left: 4px solid #28a745;
        font-size: 14px;
    }
    
    .page-builder-badge {
        display: inline-block;
        background: #e7f3ff;
        color: #0073aa;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 11px;
        margin-left: 5px;
    }
    </style>
    <?php
}
add_action('admin_head', 'creote_add_custom_ocdi_styles');

/**
 * Disable OCDI branding and speed up import
 */
add_filter('ocdi/disable_pt_branding', '__return_true');
add_filter('ocdi/regenerate_thumbnails_in_content_import', '__return_false'); 
  
/**
 * Add logging to track which demo import is running
 */
function log_demo_import_process($selected_import) {
    // SECURITY FIX: Add capability check
    if (!current_user_can('import')) {
        return;
    }
    
    error_log('creote IMPORTING DEMO: ' . $selected_import['import_file_name']);
    error_log('creote IMPORT FILE: ' . $selected_import['local_import_file']);
}
add_action('ocdi/before_content_import', 'log_demo_import_process');

/**
 * Log when the import is complete
 */
function log_demo_import_completion($selected_import) {
    // SECURITY FIX: Add capability check
    if (!current_user_can('import')) {
        return;
    }
    
    error_log('creote IMPORT COMPLETED: ' . $selected_import['import_file_name']);
    
    $log_file = WP_CONTENT_DIR . '/creote-import-log.txt';
    $log_message = date('[Y-m-d H:i:s]') . ' Import completed: ' . $selected_import['import_file_name'] . PHP_EOL;
    
    file_put_contents($log_file, $log_message, FILE_APPEND);
}
//add_action('ocdi/after_import', 'log_demo_import_completion');

/**
 * Admin page for manual cleanup - SECURITY FIXES ADDED
 */
add_action('creote_cleanup_duplicates_page' , 'cleanup_duplicates_page');
function cleanup_duplicates_page() {
    // SECURITY FIX: Add capability check
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have permission to access this page.', 'creote'));
    }
    
    ?>
    <div class="duplicatecleaner">
        <?php 
        // Check if cleanup action was requested
        if (isset($_POST['cleanup_duplicates']) && wp_verify_nonce($_POST['_wpnonce'], 'cleanup_duplicates_nonce')) {
            $results = cleanup_existing_duplicates();
            echo '<div class="resultcleanup"><p>Cleanup completed. ' . $results['count'] . ' post duplicates and ' . $results['media_count'] . ' media duplicates removed.</p></div>';
        }
        ?>
        <h1>Post-Import Duplicate Cleanup</h1>
        <div class=" notice-warning" style="padding: 10px; margin: 10px 0;">
            <h3 style="margin-top: 0; color: #d63638;">⚠️ IMPORTANT: Use Only AFTER Import</h3>
            <p><strong>This tool should only be used AFTER your One-Click Demo Import is complete!</strong></p>
            <p>Running this before or during import may cause issues with your site content.</p>
        </div>
        
        <p>This tool will scan for and remove duplicate posts, pages, footers, headers, and other custom post types created during the import process.</p>
        
        <h3>What This Tool Will Do:</h3>
        <ol>
            <li>Find and remove duplicate <strong>posts</strong>, <strong>pages</strong>, <strong>service</strong>, <strong>portfolio</strong> items</li>
            <li>Find and remove duplicate <strong>headers</strong>, <strong>footers</strong>, and <strong>mega_menu</strong> items</li>
            <li>Find and remove duplicate <strong>blocks</strong>, <strong>sliders</strong>, and <strong>team</strong> items</li>
            <li>Find and remove duplicate <strong>media files</strong> (images) using both filename and content analysis</li>
        </ol>
        
        <h3>Recommended Steps:</h3>
        <ol>
            <li>Complete your One-Click Demo Import</li>
            <li>Make a backup of your site</li>
            <li>Run this cleanup tool</li>
            <li>Verify your site content</li>
        </ol>
        
        <form method="post">
            <?php wp_nonce_field('cleanup_duplicates_nonce'); ?>
            <input type="submit" name="cleanup_duplicates" class="button button-primary" value="Run Post-Import Cleanup">
        </form>
    </div>
    <?php
}

/**
 * Function to clean up existing duplicates - SECURITY FIXES ADDED
 */
function cleanup_existing_duplicates() {
    // SECURITY FIX: Multiple security checks
    if (!current_user_can('delete_posts') || !current_user_can('delete_pages')) {
        wp_die(__('You do not have sufficient permissions to perform this action.', 'creote'));
    }
    
    // SECURITY FIX: Add nonce verification
    if (!wp_verify_nonce($_POST['_wpnonce'], 'cleanup_duplicates_nonce')) {
        wp_die(__('Security check failed.', 'creote'));
    }
    
    // SECURITY FIX: Rate limiting
    $user_id = get_current_user_id();
    $rate_limit_key = 'cleanup_duplicates_' . $user_id;
    
    if (get_transient($rate_limit_key)) {
        wp_die(__('Please wait before running cleanup again.', 'creote'));
    }
    
    set_transient($rate_limit_key, true, HOUR_IN_SECONDS);
    
    global $wpdb;
    $count = 0;
    $media_count = 0;
    
    // Post types to check
    $post_types = [
        'post', 'page', 'service', 'portfolio', 
        'blocks', 'sliders', 'team', 
        'header', 'footer', 'mega_menu'
    ];
    
    foreach ($post_types as $post_type) {
        // Get all posts of this type, ordered by ID (oldest first)
        $posts = get_posts([
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'orderby' => 'ID',
            'order' => 'ASC',
        ]);
        
        $processed_titles = [];
        
        foreach ($posts as $post) {
            if (in_array($post->post_title, $processed_titles)) {
                // This is a duplicate, remove it
                wp_delete_post($post->ID, true);
                $count++;
            } else {
                // Add to processed titles
                $processed_titles[] = $post->post_title;
            }
        }
    }
    
    // Now clean up duplicate media files
    $media_count = cleanup_duplicate_media();
    
    return ['success' => true, 'count' => $count, 'media_count' => $media_count];
}

/**
 * Clean up duplicate media files - SECURITY FIX ADDED
 */
function cleanup_duplicate_media() {
    // SECURITY FIX: Add capability check
    if (!current_user_can('delete_posts')) {
        return 0;
    }
    
    global $wpdb;
    $count = 0;
    
    // Get all attachments
    $attachments = $wpdb->get_results(
        "SELECT ID, post_title, guid FROM {$wpdb->posts} 
         WHERE post_type = 'attachment' 
         ORDER BY ID ASC"
    );
    
    // Group by filename
    $file_groups = [];
    $processed_files = [];
    
    foreach ($attachments as $attachment) {
        $file_url = $attachment->guid;
        $filename = basename($file_url);
        
        if (!isset($file_groups[$filename])) {
            $file_groups[$filename] = [];
        }
        
        $file_groups[$filename][] = $attachment->ID;
    }
    
    // Find and remove duplicates
    foreach ($file_groups as $filename => $attachment_ids) {
        if (count($attachment_ids) > 1) {
            // Keep the first one, delete the rest
            $keep_id = array_shift($attachment_ids);
            
            foreach ($attachment_ids as $delete_id) {
                wp_delete_attachment($delete_id, true);
                $count++;
            }
        }
    }
    
    // Look for more duplicates by checking file hashes (for files with different names but same content)
    if (function_exists('md5_file')) {
        $hash_groups = [];
        $uploads_dir = wp_upload_dir();
        $base_dir = $uploads_dir['basedir'];
        
        $remaining_attachments = get_posts([
            'post_type' => 'attachment',
            'posts_per_page' => -1,
        ]);
        
        foreach ($remaining_attachments as $attachment) {
            $file_path = get_attached_file($attachment->ID);
            
            if (file_exists($file_path)) {
                $hash = md5_file($file_path);
                
                if (!isset($hash_groups[$hash])) {
                    $hash_groups[$hash] = [];
                }
                
                $hash_groups[$hash][] = $attachment->ID;
            }
        }
        
        // Remove duplicates with the same hash
        foreach ($hash_groups as $hash => $attachment_ids) {
            if (count($attachment_ids) > 1) {
                // Keep the first one, delete the rest
                $keep_id = array_shift($attachment_ids);
                
                foreach ($attachment_ids as $delete_id) {
                    wp_delete_attachment($delete_id, true);
                    $count++;
                }
            }
        }
    }
    
    return $count;
}

/**
 * AJAX handler for duplicate cleanup - SECURITY FIXES ADDED
 */
function creote_cleanup_duplicates_ajax_handler() {
    // SECURITY FIX: Verify nonce
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'cleanup_duplicates_nonce')) {
        wp_send_json_error(array('message' => 'Nonce verification failed. Please refresh the page and try again.'));
    }

    // SECURITY FIX: Check permissions
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => 'You do not have permission to perform this action.'));
    }

    // Call the cleanup function
    $results = cleanup_existing_duplicates();

    // Return the results
    if ($results && isset($results['success']) && $results['success']) {
        wp_send_json_success(array(
            'count' => $results['count'],
            'media_count' => $results['media_count']
        ));
    } else {
        wp_send_json_error(array('message' => 'Error during cleanup process.'));
    }
}
add_action('wp_ajax_cleanup_duplicates_action', 'creote_cleanup_duplicates_ajax_handler');

/**
 * creote - OCDI Enhancement Implementation
 * Advanced UI Improvements for One Click Demo Import
 */

/**
 * Enqueue custom styles and scripts to enhance One Click Demo Import UI
 */
function creote_enhance_ocdi_interface() {
    // Only run on OCDI pages
    $screen = get_current_screen();
    if (!$screen || (strpos($screen->base, 'one-click-demo-import') === false && 
                    !isset($_GET['page']) || $_GET['page'] !== 'one-click-demo-import')) {
        return;
    }
    
    // Enqueue the custom CSS
    wp_enqueue_style(
        'creote-ocdi-enhanced',
        get_template_directory_uri() . '/includes/dashboard/assets/css/ocdi-enhanced.css',
        array(),
        '1.0.2'
    );
    
    // Enqueue the custom JavaScript
    wp_enqueue_script(
        'creote-ocdi-enhanced',
        get_template_directory_uri() . '/includes/dashboard/assets/js/ocdi-enhanced.js',
        array('jquery'),
        '1.0.2', 
        true
    );
    
    // Enqueue dashicons if not already loaded
    wp_enqueue_style('dashicons');
}
add_action('admin_enqueue_scripts', 'creote_enhance_ocdi_interface', 20);

/**
 * Add dashboard link to all OCDI pages
 */
function creote_add_dashboard_link() {
    $screen = get_current_screen();
    if (!$screen || (strpos($screen->base, 'one-click-demo-import') === false && 
                    !isset($_GET['page']) || $_GET['page'] !== 'one-click-demo-import')) {
        return;
    }
    
    echo '<a href="' . esc_url(admin_url('index.php')) . '" class="creote-dashboard-link">' . 
         '<span class="dashicons dashicons-arrow-left-alt"></span> Back to Dashboard</a>';
}
add_action('admin_notices', 'creote_add_dashboard_link');

/**
 * Add top navigation to OCDI pages
 */
function creote_add_ocdi_top_navigation() {
    $screen = get_current_screen();
    if (!$screen || (strpos($screen->base, 'one-click-demo-import') === false && 
                    !isset($_GET['page']) || $_GET['page'] !== 'one-click-demo-import')) {
        return;
    }
    
    ?>
    <div class="ocdi-top-navigation">
        <a href="<?php echo esc_url(admin_url('admin.php?page=creote&step=demo_import')); ?>" class="import-more-demos">
            Import More Demos
        </a>
        <a href="<?php echo esc_url(admin_url('index.php')); ?>" class="dashboard-link">
            <span class="dashicons dashicons-arrow-right-alt2"></span> Dashboard
        </a>
    </div>
    <?php
}
add_action('admin_notices', 'creote_add_ocdi_top_navigation', 1);

/**
 * Modify import buttons
 */
function creote_modify_import_buttons($buttons) {
    $modified_buttons = array(
        array(
            'title' => 'Theme Settings',
            'url'   => admin_url('customize.php'),
            'class' => 'button button-primary',
        ),
        array(
            'title' => 'Visit Site',
            'url'   => home_url(),
            'class' => 'button button-secondary',
        ),
        array(
            'title' => 'Import More Demos',
            'url'   => admin_url('admin.php?page=creote&step=demo_import'),
            'class' => 'button button-secondary',
        ),
        array(
            'title' => 'Go to Dashboard',
            'url'   => admin_url('index.php'),
            'class' => 'button button-secondary',
        )
    );
    
    return $modified_buttons;
}
add_filter('ocdi/import_done_buttons', 'creote_modify_import_buttons');

/**
 * Remove admin notices on OCDI pages
 */
function creote_remove_ocdi_notices() {
    $screen = get_current_screen();
    if (!$screen || (strpos($screen->base, 'one-click-demo-import') === false && 
                    !isset($_GET['page']) || $_GET['page'] !== 'one-click-demo-import')) {
        return;
    }
    
    remove_all_actions('admin_notices');
    remove_all_actions('all_admin_notices');
}
add_action('admin_head', 'creote_remove_ocdi_notices', 1);

/**
 * DEBUG FUNCTION - Remove this after testing
 * This will show which page builder is currently selected
 */
function debug_page_builder_selection() {
    if (current_user_can('manage_options') && isset($_GET['page']) && $_GET['page'] === 'creote') {
        $selected = get_option('creote_selected_page_builder', 'not set');
        echo '<div class="notice notice-info"><p><strong>Debug:</strong> Selected Page Builder = ' . esc_html($selected) . '</p></div>';
    }
}
add_action('admin_notices', 'debug_page_builder_selection');

/**
 * Clear page builder cache when option changes
 */
function creote_clear_page_builder_cache() {
    delete_transient('creote_filtered_plugins');
    delete_transient('creote_demo_content_cache');
}
add_action('updated_option_creote_selected_page_builder', 'creote_clear_page_builder_cache');