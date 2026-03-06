<?php
/*
 *=================================
 * Modal Content Settings
 * @package Creote WordPress Theme
 *==================================
*/
Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Modal Content Settings', 'creote' ),
            'id'     => 'header_modal_settings',
            'desc'   => esc_html__( '', 'creote' ),
            //'subsection' => true,
            'icon'   => 'el el-th',
            'fields' => array(
                array(
                    'id'       => 'modal_box_enable',
                    'type'     => 'switch', 
                    'title'    => __('Modal Enable', 'creote'),
                    'default'  => true,
               ),
            array(
                'id'       => 'modal_form_short_code',
                'type'     => 'textarea',
                'title'    => esc_html__( 'Modal Form Shortcode', 'creote' ),
                'desc' => esc_html__('Enter Contact Form 7 Short Code here', 'creote') ,
                'placeholder'     => esc_html__( '[contact-form-7 id="344" title="Contact Form"]', 'creote' ),
            ),
             
            array(
                'id'       => 'company_logo_modal',
                'type'     => 'media', 
                'url'      => true,
                'title'    => __('Logo', 'creote'),
            ),

            array(
                'id'       => 'about_company_modal',
                'type'     => 'textarea',
                'title'    => esc_html__( 'About Company', 'creote' ),
                'desc'     => esc_html__( '', 'creote' ),
                'default' => esc_html__('Denounce with righteous indignation and dislike men who are beguiled
                and demoralized by the charms pleasure moment so blinded desire that
                they cannot foresee the pain and trouble.', 'creote') ,
            ),
            array(
                'id'       => 'modal_read_more',
                'type'     => 'text',
                'title'    => esc_html__( 'Read More', 'creote' ),
                'default' => esc_html__('Read More', 'creote') ,
            ),
            array(
                'id'       => 'modal_read_more_link',
                'type'     => 'text',
                'title'    => esc_html__( ' Link (url)', 'creote' ),
                'desc'     => esc_html__( 'Enter the url here', 'creote' ),
                'default' => esc_html__('#', 'creote') ,
            ),
            array(
                'id'       => 'post_enable_modal',
                'type'     => 'switch', 
                'title'    => __('Post Enable', 'creote'),
                'default'  => true,
           ),
            
            array(
                'id'       => 'post_title_modal',
                'type'     => 'text',
                'title'    => esc_html__( 'Title', 'creote' ),
                'desc'     => esc_html__( '', 'creote' ),
                'default' => esc_html__('Latest Projects', 'creote') , 
                'required' => array( 'post_enable_modal', '=', true ),
            ),
            array(
                'id'       => 'post_style_modal',
                'type'     => 'select',
                'title'    => __('Select Post To Display', 'creote'),  
                // Must provide key => value pairs for select options
                'options'  => array(
                    'service' => esc_html__( 'Service Post', 'creote' ),   
                    'project' => esc_html__( 'Project Post', 'creote' ),   
                    'post' => esc_html__( 'Post', 'creote'),   
                ),
                'required' => array( 'post_enable_modal', '=', true ),
            ),
            array(
                'id'       => 'copy_right_modal',
                'type'     => 'text',
                'title'    => esc_html__( 'Copy Right', 'creote' ),
                'desc'     => esc_html__( '', 'creote' ),
                'default' => esc_html__('© 2023 Creote. All Rights Reserved.', 'creote') , 
            ),
     )
 ) );