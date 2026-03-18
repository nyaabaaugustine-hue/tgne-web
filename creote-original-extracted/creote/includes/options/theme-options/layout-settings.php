<?php
/*
 *=================================
 * Layout Settings
 * @package Creote WordPress Theme
 *==================================
*/
Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Layout Settings', 'creote' ),
            'id'     => 'layout_settings_all',
            'desc'   => esc_html__( '', 'creote' ),
            'icon'   => 'el el-list',
            'fields' => array(
                array(
                    'id'       => 'layout_default',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Default Layouts', 'creote' ),
                    'subtitle' => esc_html__( 'Choose your layouts Styles', 'creote' ),
                    'options'  => array(
        
                        'no-sidebar'  => array(
                            'alt' => esc_html__( 'Full Width', 'creote' ),
                            'img' => get_template_directory_uri() . '/assets/images/full-width.png',
                        ),
                        'right-sidebar'  => array(
                            'alt' => esc_html__( 'Right Sidebar', 'creote' ),
                            'img' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
                        ),
                        'left-sidebar'  => array(
                            'alt' => esc_html__( 'Left Sidebar', 'creote' ),
                            'img' => get_template_directory_uri() . '/assets/images/left-sidebar.png',
                        ),
                       
                    ),

                    'default' => 'right-sidebar',
                ),
                array(
                    'id'       => 'layout_page',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Page Layouts', 'creote' ),
                    'subtitle' => esc_html__( 'Choose your layouts Styles', 'creote' ),
                    'options'  => array(
                        'no-sidebar'  => array(
                            'alt' => esc_html__( 'Full Width', 'creote' ),
                            'img' => get_template_directory_uri() . '/assets/images/full-width.png',
                        ),
                        'right-sidebar'  => array(
                            'alt' => esc_html__( 'Right Sidebar', 'creote' ),
                            'img' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
                        ),
                        'left-sidebar'  => array(
                            'alt' => esc_html__( 'Left Sidebar', 'creote' ),
                            'img' => get_template_directory_uri() . '/assets/images/left-sidebar.png',
                        ),
                       
                    ),

                    'default' => 'right-sidebar',
                ),
                array(
                    'id'       => 'layout_service',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Service Layouts', 'creote' ),
                    'subtitle' => esc_html__( 'Choose your layouts Styles', 'creote' ),
                    'options'  => array(
        
                        'no-sidebar'  => array(
                            'alt' => esc_html__( 'Full Width', 'creote' ),
                            'img' => get_template_directory_uri() . '/assets/images/full-width.png',
                        ),
                        'right-sidebar'  => array(
                            'alt' => esc_html__( 'Right Sidebar', 'creote' ),
                            'img' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
                        ),
                        'left-sidebar'  => array(
                            'alt' => esc_html__( 'Left Sidebar', 'creote' ),
                            'img' => get_template_directory_uri() . '/assets/images/left-sidebar.png',
                        ),
                       
                    ),

                    'default' => 'no-sidebar',
                ),    
                
                array(
                    'id'       => 'layout_shop',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Shop Layouts', 'creote' ),
                    'subtitle' => esc_html__( 'Choose your layouts Styles', 'creote' ),
                    'options'  => array(
        
                        'no-sidebar'  => array(
                            'alt' => esc_html__( 'Full Width', 'creote' ),
                            'img' => get_template_directory_uri() . '/assets/images/full-width.png',
                        ),
                        'right-sidebar'  => array(
                            'alt' => esc_html__( 'Right Sidebar', 'creote' ),
                            'img' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
                        ),
                        'left-sidebar'  => array(
                            'alt' => esc_html__( 'Left Sidebar', 'creote' ),
                            'img' => get_template_directory_uri() . '/assets/images/left-sidebar.png',
                        ),
                       
                    ),

                    'default' => 'no-sidebar',
                ),  
     )
 ) );

