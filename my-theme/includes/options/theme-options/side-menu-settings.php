<?php
/*
 *=================================
 * Header Extra Settings
 * @package creote WordPress Theme
 *==================================
*/

Redux::set_section( $opt_name, array(
            'title'  => esc_html__( 'Side Menu Settings', 'creote' ),
            'id'     => 'side_menu_settings',
            'desc'   => esc_html__( '', 'creote' ),
            'icon'   => 'el el-cog',
            'fields' => array(
            array(
                'id'       => 'side_menu_enable',
                'type'     => 'switch', 
                'title'    => __('Side Menu  Enable', 'creote'),
                'default'  => false,
            ),

            array(
                'id'       => 'side_menu_icon_image',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Side Menu Icon Image ', 'creote'),
                'required' => array( 'side_menu_enable', '=', true ),
                'default'  => array(
                    'url'=> get_template_directory_uri() . '/assets/images/demo.svg', 
                ),
            ),

            array(
                'id'       => 'side_menu_button_texts',
                'type'     => 'text',
                'title'    => esc_html__( 'Side Menu  Text', 'creote' ),
                'placeholder' => esc_html__('Demos', 'creote') ,
                'default' => esc_html__('Demos', 'creote') ,
                'required' => array( 'side_menu_enable', '=', true ),
            ),   
            
            array(
                'id'       => 'side_menu_display_area',
                'type'     => 'select',
                'title'    => __('Select Mega Menu Style For display in Side Menu', 'creote'),  
                // Must provide key => value pairs for select options
                'options'  => creote_header_query('mega_menu'),
                'required' => array( 'side_menu_enable', '=', true ),
            ),


            array(
                'id' => 'color-switcher-start',
                'type' => 'section',
                'title' => __('Color Switcher Section', 'creote'),
                'indent' => true 
            ),
 
            array(
                'id'       => 'color_scheme_option',
                'type'     => 'switch', 
                'default'  => true,
                'title'    => __('Color Switcher Enable / Disable', 'creote'),
            ),

            array(
                'id'       => 'color_sc_icon_image',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Color Switcher Icon Image ', 'creote'),
                'required' => array( 'color_scheme_option', '=', true ),
                'default'  => array(
                    'url'=> get_template_directory_uri() . '/assets/images/color.svg', 
                ),
            ),

            array(
                'id'       => 'color_button_texts',
                'type'     => 'text',
                'title'    => esc_html__( 'Color Scheme Menu  Text', 'creote' ),
                'placeholder' => esc_html__('Colors', 'creote') ,
                'default' => esc_html__('Colors', 'creote') ,
                'required' => array( 'color_scheme_option', '=', true ),
            ), 

            array(
                'id' => 'cart-sec-start',
                'type' => 'section',
                'title' => __('Mini Cart Content', 'creote'),
                'indent' => true 
            ),
            array(
                'id' => 'mini_cart_enable',
                'type' => 'switch',
                'title' => esc_html__('Mini Cart Enable / Disable', 'creote'),
                'desc' => esc_html__('Enable Mini cart', 'creote'),
            ),


            array(
                'id'       => 'mini_cart_icon_img',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Color Switcher Icon Image ', 'creote'),
                'required' => array( 'mini_cart_enable', '=', true ),
                'default'  => array(
                    'url'=> get_template_directory_uri() . '/assets/images/cart.svg', 
                ),
            ),

            array(
                'id'       => 'mini_cart_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Minu Cart Button Text', 'creote' ),
                'placeholder' => esc_html__('Cart', 'creote') ,
                'default' => esc_html__('Cart', 'creote') ,
                'required' => array( 'mini_cart_enable', '=', true ),
            ), 

 
            array(
                'id' => 'extra-Contant-start',
                'type' => 'section',
                'title' => __('Extra Content Section', 'creote'),
                'indent' => true 
            ),


            array(
                'id'       => 'content_one_enable',
                'type'     => 'switch', 
                'default'  => true,
                'title'    => __('Content One Enable / Disable', 'creote'),
            ),

            array(
                'id'       => 'content_one_icon_image',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Content One Icon Image ', 'creote'),
                'required' => array( 'content_one_enable', '=', true ),
                'default'  => array(
                    'url'=> get_template_directory_uri() . '/assets/images/docs.svg', 
                ),
            ),

            array(
                'id'       => 'content_one_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Content One Menu  Text', 'creote' ),
                'placeholder' => esc_html__('Docs', 'creote') ,
                'default' => esc_html__('Docs', 'creote') ,
                'required' => array( 'content_one_enable', '=', true ),
            ), 

            array(
                'id'       => 'content_one_text_link',
                'type'     => 'text',
                'title'    => esc_html__( 'Content One Menu  Link', 'creote' ),
                'placeholder' => esc_html__('#', 'creote') ,
                'default' => esc_html__('#', 'creote') ,
                'required' => array( 'content_one_enable', '=', true ),
            ), 

 
            array(
                'id'       => 'content_two_enable',
                'type'     => 'switch', 
                'default'  => true,
                'title'    => __('Content Two Enable / Disable', 'creote'),
            ),

            array(
                'id'       => 'content_two_icon_image',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Content Two Icon Image ', 'creote'),
                'required' => array( 'content_two_enable', '=', true ),
                'default'  => array(
                    'url'=> get_template_directory_uri() . '/assets/images/support.svg', 
                ),
            ),

            array(
                'id'       => 'content_two_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Content Two Menu  Text', 'creote' ),
                'placeholder' => esc_html__('Support', 'creote') ,
                'default' => esc_html__('Support', 'creote') ,
                'required' => array( 'content_two_enable', '=', true ),
            ), 

            array(
                'id'       => 'content_two_link',
                'type'     => 'text',
                'title'    => esc_html__( 'Content Two Menu  Link', 'creote' ),
                'placeholder' => esc_html__('#', 'creote') ,
                'default' => esc_html__('#', 'creote') ,
                'required' => array( 'content_two_enable', '=', true ),
            ), 
          
          
          
    )
));


 