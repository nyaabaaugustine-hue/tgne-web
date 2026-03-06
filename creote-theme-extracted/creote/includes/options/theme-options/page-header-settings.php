<?php
/*
 *=================================
 * Header Settings
 * @package Creote WordPress Theme
 *==================================
*/

Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Page Header Settings', 'creote' ),
            'id'     => 'page_header_settings',
            'desc'   => esc_html__( '', 'creote' ),
            'icon'   => 'el el el-website',
            'fields' => array(
           
            array(
                'id' => 'page-header-sec-start',
                'type' => 'section',
                'title' => __('Page Header  Section', 'creote'),
                'indent' => true 
            ),    
            array(
                'id'       => 'page_header_enable',
                'type'     => 'switch', 
                'title'    => __('Page Header Enable / Disable', 'creote'),
                'default'  => true,
            ),
            array(
                'id'       => 'slect_page_header_title_tag',
               'type'     => 'select',
               'title'    => __('Select Title Tag', 'creote'),  
               'options'  => array(
                   'div' => esc_html__( 'Div Tag', 'creote' ),
                   'h1' => esc_html__( 'H1 Tag', 'creote' ),
                   'h2' => esc_html__( 'H2 Tag', 'creote' ),
                   'h3' => esc_html__( 'H3 Tag', 'creote' ),
                   'h4' => esc_html__( 'H4 Tag', 'creote' ),
                   'h5' => esc_html__( 'H5 Tag', 'creote' ),
                   'h6' => esc_html__( 'H6 Tag', 'creote' ), 
               ),
               'default'  => 'div',
           ),
            array(
                'id'       => 'default_page_header_image',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Pageheader Background Image', 'creote'),
                'default'  => array(
                    'url'=> get_template_directory_uri() . '/assets/images/page-header-default.jpg', 
                ),
            ),
            array(
                'id'       => 'page_header_bg',
                'type'     => 'color',
                'title'    => __('Pageheader Background Color', 'creote'), 
                'validate' => 'color',
            ),

            array(
                'id' => 'page_header_padding-start',
                'type' => 'section',
                'title' => __('Page Header Padding', 'creote'),
                'indent' => true 
            ),
            array(
                'id'       => 'page_header_css_enable',
                'type'     => 'switch', 
                'title'    => __('Page Header Css Enable / Disable', 'creote'),
                'default'  => false,
            ),
            array(
                'id'             => 'page_header_padding',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('em', 'px'),
                'units_extended' => 'false',
                'title'          => __('Page Header  Padding', 'creote'),
                'desc'           => __('Page Header padding you can add padding here.', 'creote'),
                'required' => array( 'page_header_css_enable', '=', true ),
            ),


            array(
                'id'             => 'page_header_padding_mb',
                'type'           => 'spacing',
                'mode'           => 'padding',
                'units'          => array('em', 'px'),
                'units_extended' => 'false',
                'title'          => __('Page Header Padding (Mobile after 1200px)', 'creote'),
                'desc'           => __('Page Header padding you can add padding here.', 'creote'),
                'required' => array( 'page_header_css_enable', '=', true ),
            ),


            

     )
));

