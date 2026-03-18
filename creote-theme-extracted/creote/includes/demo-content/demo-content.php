<?php
/*------
Creote Content
-------*/ 
 
function creote_vc_addons_importers_locl() {
  return array(
    array(
      'import_file_name'           => 'Creote Elementor  Demo Content (Home 1 to 12 pages)',
      'local_import_file'            => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-content-version-1/creoteelementor3.xml',  
      'local_import_widget_file'     => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-content-version-1/c-widgets.wie',
      'local_import_redux'               => array(
        array(
        'file_path'   => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-content-version-1/redux_options_3.json',
        'option_name' => 'creote_theme_mod',
        ),
      ),
      'import_preview_image_url'     => get_template_directory_uri() . '/includes/demo-content/demo-content/demo-content-version-1/screenshot.jpg',
      'import_notice'              => __( 'Please keep patients while importing sample data.', 'creote' ),
      'preview_url'                => 'https://themepanthers.com/wp/creote/demo-content/v-new/',
    ),
    array(
      'import_file_name'           => 'Creote Elementor  Demo Content (Home 13 To  16 )',
      'local_import_file'            => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-content-version-2/creote-sml-version-2.xml',
      'local_import_widget_file'     => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-content-version-2/widget-version-2.wie',
      'local_import_redux'               => array(
        array(
        'file_path'   => trailingslashit(get_template_directory())  . '/includes/demo-content/demo-content/demo-content-version-2/redux_options__version-2.json',
        'option_name' => 'creote_theme_mod',
        ),
      ),
      'import_preview_image_url'     => get_template_directory_uri() . '/includes/demo-content/demo-content/demo-content-version-2/screenshot.jpg',
      'import_notice'              => __( 'Please keep patients while importing sample data.', 'creote' ),
      'preview_url'                => 'https://themepanthers.com/wp/creote/demo-content/v2-new',
    ),
    array(
      'import_file_name'           => 'Creote Wpbakery Demo Content',
      'local_import_file'            => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-wpbakery/wp-democontent.xml',
      'local_import_widget_file'     => trailingslashit(get_template_directory()) . '/includes/demo-content/demo-content/demo-wpbakery/wp-widgets.wie',
      'local_import_redux'               => array(
        array(
        'file_path'   => trailingslashit(get_template_directory())  . '/includes/demo-content/demo-content/demo-wpbakery/redux-2.json',
        'option_name' => 'creote_theme_mod',
        ),
      ),
      'import_preview_image_url'     => get_template_directory_uri() . '/includes/demo-content/demo-content/demo-wpbakery/screenshot-wp.jpg',
      'import_notice'              => __( 'Please keep patients while importing sample data.', 'creote' ),
      'preview_url'                => 'https://themepanthers.com/wp/creote/demo-content/version-1/',
    )
  );
 
}
 
add_filter( 'pt-ocdi/import_files', 'creote_vc_addons_importers_locl' );


function creote_after_imports_local() {
    $top_menu = get_term_by('primary', 'primary', 'wp_nav_menu');
        
    set_theme_mod( 'nav_menu_locations' , array( 
        'primary' => $top_menu->term_id, 
       ) 
  );

    //Set Front page
    $page = get_page_by_title( 'Home Default');
    $blogpage = get_page_by_title( 'Blog');
    if ( isset( $page->ID ) ) {
     update_option( 'page_on_front', $page->ID );
     update_option( 'show_on_front', 'page' );
     update_option( 'page_for_posts', $blogpage->ID );
    }


}
add_action( 'pt-ocdi/after_import', 'creote_after_imports_local' );
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

