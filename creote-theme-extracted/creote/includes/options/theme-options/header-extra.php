<?php
/*
 *=================================
 * Header Extra Settings
 * @package Creote WordPress Theme
 *==================================
*/

Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Mobile Header Settings', 'creote' ),
            'id'     => 'mobile_header_settings',
            'desc'   => esc_html__( '', 'creote' ),
            //'subsection' => true,
            'icon'   => 'el el-iphone-home',
            'fields' => array(

                
                array(
                    'id'       => 'header_mobile_style',
                    'type'     => 'select',
                    'title'    => __('Select Header Style', 'creote'),  
                    // Must provide key => value pairs for select options
                    'options'  => array(
                        'mobile_header_style_one' => esc_html__( 'Mobile Header Style One', 'creote' ),   
                        'mobile_header_style_two' => esc_html__( 'Mobile Header Style Two', 'creote' ),   
                    ),
                    'default' => esc_html__('mobile_header_style_two', 'creote') ,
                ),
            array(
                'id'       => 'search_enable',
                'type'     => 'switch', 
                'title'    => __('Search Enable', 'creote'),
                'default'  => true,
            ),
            array(
                'id'       => 'mobile_phone_enable',
                'type'     => 'switch', 
                'title'    => __('Phone Number Enable', 'creote'),
                'default'  => true,
            ),
            array(
                'id'       => 'mobile_phone_number',
                'type'     => 'text',
                'title'    => esc_html__( 'Phone Number', 'creote' ),
                'required' => array( 'mobile_phone_enable', '=', true ),
                'default' => esc_html__('9806071234', 'creote') ,
            ),

            array(
                'id'       => 'mobile_email_enable',
                'type'     => 'switch', 
                'title'    => __('Mail Enable', 'creote'),
                'default'  => true,
            ),
            array(
                'id'       => 'mobile_mail_number',
                'type'     => 'text',
                'title'    => esc_html__( 'Mail Id', 'creote' ),
                'required' => array( 'mobile_email_enable', '=', true ),
                'default' => esc_html__('sendmail@example.com', 'creote') ,
            ),


            array(
                'id'       => 'mobile_logo',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Logo', 'creote'),
            ),
            array(
                'id'       => 'mobile_logo_link',
                'type'     => 'text',
                'title'    => esc_html__( 'Logo LInk', 'creote' ),
                'placeholder' => esc_html__('https://example.com', 'creote') ,
            ),      

            array(
                'id'       => 'mobile_logo_width',
                'type'     => 'dimensions',
                'units'    => array('em','px','%'),
                'title'    => esc_html__('Logo Width', 'creote'),
                'height' => false,
                'subtitle' => esc_html__('Allow your users to choose width', 'creote'),
                'desc'     => esc_html__('Enable or disable any piece of this field. Width, or Units.', 'creote'),
                'default'  => array(
                    'Width'   => '150', 
                    'Height'  => false
                ),
            ),
               
            array(
                'id'       => 'mobile_btn_enable_disable',
                'type'     => 'switch', 
                'title'    => __('Mobile Button Enable / Disable', 'creote'),
                'default'  => false,
            ),
             
            array(
                'id'       => 'mobile_button_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Button Text', 'creote' ),
                'default' => esc_html__('Contact Us', 'creote') ,
                'required' => array( 'mobile_btn_enable_disable', '=', true ),
            ),
            array(
                'id'       => 'mobile_button_link',
                'type'     => 'text',
                'title'    => esc_html__( 'Button LInk', 'creote' ),
                'placeholder' => esc_html__('https://example.com', 'creote') ,
                'default' => esc_html__('#', 'creote') ,
                'required' => array( 'mobile_btn_enable_disable', '=', true ),
            ),    
              
            array(
                'id'       => 'mobile_mini_cart_enable',
                'type'     => 'switch', 
                'title'    => __('Mini Cart Enable', 'creote'),
                'default'  => false,
                'required' => array( 'header_mobile_style', '=', 'mobile_header_style_one' ),
            ),
            array(
                'id'       => 'mobile_option_enable',
                'type'     => 'switch', 
                'title'    => __('Option Panel Enable', 'creote'),
                'default'  => false,
                'required' => array( 'header_mobile_style', '=', 'mobile_header_style_one' ),
            ),
        
    )
));