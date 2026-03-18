<?php
/*
 *=================================
 * All Post General Settings
 * @package Creote WordPress Theme
 *==================================
*/
Redux::setSection( $opt_name, array(
        'title'  => esc_html__( 'All Post General Settings', 'creote' ),
        'id'     => 'post_general_settings',
        'desc'   => esc_html__( '', 'creote' ),
        'icon'   => 'el el-cog',
        'subsection' => true,
        'fields' => array(
        array(
            'id' => 'service_post_secton',
            'type' => 'section',
            'title' => __('Service Section', 'creote'),
            'indent' => true 
        ),
        array(
            'id'       => 'service_breadcrumb_name',
            'type'     => 'text',
            'title'    => esc_html__( 'Service Breadcrumb Name', 'creote' ),
            'default' => esc_html__('Service', 'creote') ,
        ),  
        array(
            'id'       => 'service_breadcrumb_link',
            'type'     => 'text',
            'title'    => esc_html__( 'Service Breadcrumb Link', 'creote' ),
            'default' => esc_html__('#', 'creote') ,
        ),  
        array(
            'id' => 'project_post_secton',
            'type' => 'section',
            'title' => __('Project Section', 'creote'),
            'indent' => true 
        ),
        array(
            'id'       => 'project_breadcrumb_name',
            'type'     => 'text',
            'title'    => esc_html__( 'Project Breadcrumb Name', 'creote' ),
            'default' => esc_html__('Project', 'creote') ,
        ),  
        array(
            'id'       => 'project_breadcrumb_link',
            'type'     => 'text',
            'title'    => esc_html__( 'Project Breadcrumb Link', 'creote' ),
            'default' => esc_html__('#', 'creote') ,
        ),   

        array(
            'id' => 'product_post_secton',
            'type' => 'section',
            'title' => __('Product Section', 'creote'),
            'indent' => true 
        ),
        array(
            'id'       => 'product_page_name',
            'type'     => 'text',
            'title'    => esc_html__( 'Product Page Title', 'creote' ),
            'default' => esc_html__('Product', 'creote') ,
        ),  
        array(
            'id'       => 'product_breadcrumb_name',
            'type'     => 'text',
            'title'    => esc_html__( 'Product Breadcrumb Name', 'creote' ),
            'default' => esc_html__('Product', 'creote') ,
        ),  
        array(
            'id'       => 'product_breadcrumb_link',
            'type'     => 'text',
            'title'    => esc_html__( 'Product Breadcrumb Link', 'creote' ),
            'default' => esc_html__('#', 'creote') ,
        ),  

        array(
            'id' => 'job_post_secton',
            'type' => 'section',
            'title' => __('Job Listing Section', 'creote'),
            'indent' => true 
        ),
        array(
            'id'       => 'job_breadcrumb_name',
            'type'     => 'text',
            'title'    => esc_html__( 'Job Breadcrumb Name', 'creote' ),
            'default' => esc_html__('Job', 'creote') ,
        ),  
        array(
            'id'       => 'job_breadcrumb_link',
            'type'     => 'text',
            'title'    => esc_html__( 'Job Breadcrumb Link', 'creote' ),
            'default' => esc_html__('#', 'creote') ,
        ),  

     )
));