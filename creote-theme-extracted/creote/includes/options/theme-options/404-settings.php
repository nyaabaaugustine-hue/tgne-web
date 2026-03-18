<?php
/*
 *=================================
 * 404-options
 * @package Creote WordPress Theme
 *==================================
*/
 

Redux::setSection( $opt_name, array(
            'title'  => esc_html__( '404 Settings', 'creote' ),
            'id'     => 'fournotfour_settings',
            'desc'   => esc_html__( '', 'creote' ),
            'icon'   => 'el el-check-empty',
            'fields' => array(
              
                array(
                    'id'             => '404_padding',
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'units'          => array('em', 'px' , 'rem'),
                    'units_extended' => 'false',
                    'title'          => __('Padding for 404', 'creote'),
                    'subtitle'       => __('Allow your users to choose the spacing or padding they want.', 'creote'),
                    'default'            => array(
                        'padding-top'     => '', 
                        'padding-right'   => '', 
                        'padding-bottom'  => '', 
                        'padding-left'    => '',
                        'units'          => 'px', 
                    ),
                    'output'    => array('.error404 .site-content'),
                ),

                array(         
                    'id'       => '404_bg_color',
                    'type'     => 'background',
                    'title'    => __('404 Background', 'creote'),
                    'subtitle' => __('404 background with image, color, etc.', 'creote'),
                    'output'    => array('.error404 .site-content '),
                ),
                array(
                    'id'       => 'fournotbg_image',
                    'type'     => 'media', 
                    'url'      => true,
                    'title'    => __('404 Image', 'creote'),
                ),
                      
     )
 ) );