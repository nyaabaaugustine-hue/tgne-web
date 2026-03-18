<?php
/*
 *=================================
 * Woocommerce Options
 * @package Creote WordPress Theme
 *==================================
*/
Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Woocommerce Settings', 'creote' ),
            'id'     => 'woocommerce_settings',
            'desc'   => esc_html__( '', 'creote' ),
            'icon'   => 'el el-shopping-cart-sign',
            'fields' => array(
                array(
                    'id' => 'login-sec-start',
                    'type' => 'section',
                    'title' => __('Login Left Content', 'creote'),
                    'indent' => true 
                ),
                array(
                    'id'       => 'login_logo',
                    'type'     => 'media', 
                    'url'      => true,
                    'title'    => __('Logo For Login Page', 'creote'),
                ),
                array(
                    'id'       => 'logo_width_mos',
                    'type'     => 'text',
                    'title'    => esc_html__( ' Logo Dimentions', 'creote' ),
                    'default'  => array('200px'),
                ),
                array(
                    'id'       => 'login_text_mids',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Login Text', 'creote' ),
                    'default' => esc_html__('', 'creote') ,
                ),
                array(
                    'id'       => 'login_background_image',
                    'type'     => 'media', 
                    'url'      => true,
                    'title'    => __('Login Background Image', 'creote'),
                ),
                array(
                    'id' => 'login-sec-start-two',
                    'type' => 'section',
                    'title' => __('Login Right Content', 'creote'),
                    'indent' => true 
                ),
                array(
                    'id'       => 'login_right_sm_text',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Form Small Title', 'creote' ),
                    'default' => esc_html__('Start For Free', 'creote') ,
                ),
                array(
                    'id'       => 'login_right_md_text',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Form Title', 'creote' ),
                    'default' => esc_html__('Create New Account', 'creote') ,
                ),


               
               
              
            )
        )
    );