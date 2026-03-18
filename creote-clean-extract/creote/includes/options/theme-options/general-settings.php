<?php
/*
 *=================================
 * General Settings
 * @package Creote WordPress Theme
 *==================================
*/
Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'General Settings', 'creote' ),
            'id'     => 'general_settings',
            'desc'   => esc_html__( '', 'creote' ),
            'icon'   => 'el el-wrench',
            'fields' => array(
                array(
                    'id' => 'body_padding_sec-start',
                    'type' => 'section',
                    'title' => __('Body Settings Section', 'creote'),
                    'indent' => true 
                ),
                array(
                    'id'       => 'body_css_enable',
                    'type'     => 'switch', 
                    'title'    => __('Body Css Enable / Disable', 'creote'),
                    'default'  => false,
                ),
                array(
                    'id'             => 'body_padding_totals',
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'units'          => array('em', 'px'),
                    'units_extended' => 'false',
                    'title'          => __('Body Padding Option', 'creote'),
                    'desc'           => __('Whole Body padding you can add padding here.', 'creote'),
                    'required' => [ 'body_css_enable', '=', true ],
                  
                ),

                array(
                    'id'             => 'body_padding_total_mbss',
                    'type'           => 'spacing',
                    'mode'           => 'padding',
                    'units'          => array('em', 'px'),
                    'units_extended' => 'false',
                    'title'          => __('Body Padding Option (Mobile after 1200px)', 'creote'),
                    'desc'           => __('Whole Body padding you can add padding here.', 'creote'),
                    'required' => [ 'body_css_enable', '=', true ],
                ),

                array(
                    'id' => 'backtopreloader-sec-start',
                    'type' => 'section',
                    'title' => __('Preloader / Backtotop Section', 'creote'),
                    'indent' => true 
                ),
                //preloader
                array(
                    'id'       => 'preloader_show',
                    'type'     => 'switch', 
                    'title'    => __('Preloader Hide  / show', 'creote'),
                    'subtitle' => __('Preloader', 'creote'),
                    'default'  => true,
                ),  
              
                 array(
                    'id'       => 'preloader_image',
                    'type'     => 'media', 
                    'url'      => true,
                    'title'    => __('Preloader Image', 'creote'),
                    'required' => [ 'preloader_show', '=', true ],
                ),
                array(         
                    'id'       => 'pre_loader_background',
                    'type'     => 'color',
                    'title'    => __('Preloader Background', 'creote'),
                    'subtitle' => __('Preloader background color, etc.', 'creote'),
                    'validate' => 'color',
                    'required' => [ 'preloader_show', '=', true ],
                ),

                //preloader
                array(
                    'id'       => 'bactotop_enable',
                    'type'     => 'switch', 
                    'default'  => false,
                    'title'    => __('Back to top Enable /Disable', 'creote'),
                ),
                array(
                    'id' => 'animation-sec-start',
                    'type' => 'section',
                    'title' => __('Animation Section', 'creote'),
                    'indent' => true 
                ),
                array(
                    'id'       => 'aos_animation_stop',
                    'type'     => 'switch', 
                    'default'  => true,
                    'title'    => __('Fade Anmation Effects On /Off', 'creote'),
                ),

                  array(
                    'id' => 'rtl-sec-start',
                    'type' => 'section',
                    'title' => __('Rtl Section', 'creote'),
                    'indent' => true 
                  ),

                  array(
                    'id'       => 'rtl_enable_all',
                    'type'     => 'switch', 
                    'default'  => false,
                    'title'    => __('RTL Enable', 'creote'),
                    'description'    => __('This Option Is For Full RTL', 'creote'),
                ),

                array(
                    'id' => 'sidebar-sticky-start',
                    'type' => 'section',
                    'title' => __('Sidebar Section', 'creote'),
                    'indent' => true 
                  ),

                  array(
                    'id'       => 'sidebar_sticky_enables',
                    'type'     => 'switch', 
                    'default'  => true,
                    'title'    => __('Sidebar Sticky Enable / Disable', 'creote'),
                ), 
                array(
                    'id'       => 'admin_notice_enable',
                    'type'     => 'switch', 
                    'title'    => __('Admin Panel Notice Enable  / Disable', 'creote'), 
                    'default'  => true,
                ),    
                array(
                    'id'       => 'smoothscroll',
                    'type'     => 'switch', 
                    'default'  => true,
                    'title'    => __('Smooth Scroll On /Off', 'creote'),
                ),
            ),
        ));