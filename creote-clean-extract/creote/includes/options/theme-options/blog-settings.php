<?php
/*
 *=================================
 * Blog Options
 * @package Creote WordPress Theme
 *==================================
*/
Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Post Settings', 'creote' ),
            'id'     => 'blog_settings_all',
            'desc'   => esc_html__( '', 'creote' ),
            'icon'   => 'el el-bold',
            'fields' => array( 
                array(
                    'id'       => 'blog_layout_styles',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Blog Styles', 'creote' ),
                    'subtitle' => esc_html__( 'Blog Styles', 'creote' ),
                    'options'  => array(
                        'style_one'   => esc_html__( 'Blog Classic', 'creote' ),
                        'style_two'   => esc_html__( 'Blog List View', 'creote' ),
                    ),
    
                    'default' => 'style_two',
                ), 
                array(
                    'id'       => 'blog_layout_column',
                   'type'     => 'select',
                   'title'    => __('Blog Column', 'creote'), 
                   // Must provide key => value pairs for select options
                   'options'  => array(
                    'one_column'   => esc_html__( 'One Column', 'creote' ),
                    'two_column'   => esc_html__( 'Two Column', 'creote' ),
                    'three_column' => esc_html__( 'Three Column', 'creote' ),
                    'four_column' => esc_html__( 'Four Column', 'creote' ),
                   ),
                   'default'  => 'three_column',
               ), 
                    
     )
 ) );