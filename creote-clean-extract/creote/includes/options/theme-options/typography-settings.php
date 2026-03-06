<?php
/*
 *=================================
 * Typography Settings
 * @package Creote WordPress Theme
 *==================================
*/
Redux::setSection( $opt_name, array(

    'title'         => esc_html__( 'Typography Settings', 'creote' ),
    'id'         => 'typography_setting',
    'desc'          => '',
    'icon'          => 'el el-fontsize',
    'fields' => array(  

        array(

            'id' => 'font_family_enable',
    
            'type' => 'switch',
    
            'title' => esc_html__('Default Font Family Enable', 'creote'),
    
            'desc' => esc_html__('Enable to fontfamily to change font family', 'creote'),
    
        ),
    
        array(
            'id' => 'font_familt_common',
            'type' => 'typography',
            'title' => esc_html__('Font Family Primary', 'creote'),
            'google' => true,
            'color' => false,
            'font-backup' => true,
            'font-family' => true,
            'subsets' => false,
            'font-size' => false,
            'font-weight' => false,
            'font-style' => false,
            'line-height' => false,
            'text-align' => false,
            'units' => 'px',
            'default' => array(
             'font-family' => '', 
             ),
             'required' => array('font_family_enable', '=', true),
    
        ),
    
        array(
            'id' => 'font_familt_common_two',
            'type' => 'typography',
            'title' => esc_html__('Font Family Secondary', 'creote'),
            'google' => true,
            'color' => false,
            'font-backup' => true,
            'font-family' => true,
            'subsets' => false,
            'text-align' => false,
            'font-size' => false,
            'font-style' => false,
            'font-weight' => false,
            'line-height' => false,
            'units' => 'px',
            'default' => array(
             'font-family' => '', 
             ),
             'required' => array('font_family_enable', '=', true),
    
        ),
        

        array(

        'id' => 'heading_style_h1_enable_desk',

        'type' => 'switch',

        'title' => esc_html__('Enable H1 Custom Font (Desktop)', 'creote'),

        'desc' => esc_html__('Enable to customize the theme heading h1 tag font (Desktop)', 'creote'),

        ),

    array(

        'id' => 'h1_typography',
        'type' => 'typography',
        'title' => esc_html__('H1 Font Typography (Desktop)', 'creote'),
        'google' => false,
        'color' => false,
        'font-backup' => false,
        'font-family' => false,
        'subsets' => false,
        'units' => 'px',
        'subtitle' => esc_html__('Apply options to customize the h1 heading font for the theme (Desktop)', 'creote'),
        'default' => array(
         'font-style' => '',
         'google' => true,
         'font-size' => ' ',
         'line-height' => ''
         ),

         'required' => array('heading_style_h1_enable_desk', '=', true),

    ),



        array(

         'id' => 'heading_style_h1_enable_mob',
    
         'type' => 'switch',
    
         'title' => esc_html__('Enable H1 Custom Font (Mobile)', 'creote'),
    
         'desc' => esc_html__('Enable to customize the theme heading h1 tag font (Mobile)', 'creote'),
    
         ),
    
        array(
         'id' => 'h1_typography_mobile',
         'type' => 'typography',
         'title' => esc_html__('H1 Font Typography (Mobile)', 'creote'),
         'font-family' => false,
         'text-align' => false,
         'color' => false,
         'font-style' => false,
         'google' => false,
         'font-weight' => false,
         'subsets' => false,
         'font-backup' => false,
         'output' => array('' ),
         'units' => 'px',
         'subtitle' => esc_html__('Apply options to customize the h1 heading font for the theme (Mobile)', 'creote'),
         'default' => array(
             'font-style' => '',
             'font-size' => ' ',
             'line-height' => ''
             ),
             'required' => array('heading_style_h1_enable_mob', '=', true),
         ),


        // h2 custom fonts

    array(

        'id' => 'heading_style_h2_enable_desk',

        'type' => 'switch',

        'title' => esc_html__('Enable H2 Custom Font (Desktop)', 'creote'),

        'desc' => esc_html__('Enable to customize the theme heading h2 tag font (Desktop)', 'creote'),

        ),

    array(

        'id' => 'h2_typography',
        'type' => 'typography',
        'title' => esc_html__('H2 Font Typography (Desktop)', 'creote'),
        'google' => false,
        'color' => false,
        'font-backup' => false,
        'font-family' => false,
        'subsets' => false,
        'units' => 'px',
        'subtitle' => esc_html__('Apply options to customize the h2 heading font for the theme (Desktop)', 'creote'),
        'default' => array(
         'color' => '',
         'font-style' => '',
         
         'google' => true,
         'font-size' => '',
         'line-height' => ''
         ),


        'required' => array('heading_style_h2_enable_desk', '=', true),

        ),

        array(

         'id' => 'heading_style_h2_enable_mob',
    
         'type' => 'switch',
    
         'title' => esc_html__('Enable H2 Custom Font (Mobile)', 'creote'),
    
         'desc' => esc_html__('Enable to customize the theme heading h2 tag font (Mobile)', 'creote'),
    
         ),
    
         array(
             'id' => 'h2_typography_mobile',
             'type' => 'typography',
             'title' => esc_html__('H2 Font Typography (Mobile)', 'creote'),
             'font-family' => false,
             'text-align' => false,
             'color' => false,
             'google' => false,
             'font-weight' => false,
             'font-style' => false,
             'subsets' => false,
             'font-backup' => false,
             'units' => 'px',
             'subtitle' => esc_html__('Apply options to customize the h2 heading font for the theme (Mobile)', 'creote'),
             'default' => array(
                 'font-style' => '',
                 'font-size' => ' ',
                 'line-height' => ''
                 ),
                 'required' => array('heading_style_h2_enable_mob', '=', true),
             ),


         // h3 custom fonts

    array(

        'id' => 'heading_style_h3_enable_desk',

        'type' => 'switch',

        'title' => esc_html__('Enable H3 Custom Font (Desktop)', 'creote'),

        'desc' => esc_html__('Enable to customize the theme heading h3 tag font (Desktop)', 'creote'),

        ),

    array(
        'id' => 'h3_typography',
        'type' => 'typography',
        'title' => esc_html__('H3 Font Typography (Desktop)', 'creote'),
        'google' => false,
        'color' => false,
        'font-backup' => false,
        'font-family' => false,
        'subsets' => false,
        'output' => array('body h3', 'h3'),
        'units' => 'px',
        'subtitle' => esc_html__('Apply options to customize the h3 heading  for the theme (Desktop)', 'creote'),
        'default' => array(
         'font-style' => '',
         
         'google' => true,
         'font-size' => '',
         'line-height' => ''
         ),
        'required' => array('heading_style_h3_enable_desk', '=', true),
        ),

        array(
         'id' => 'heading_style_h3_enable_mob',
         'type' => 'switch',
         'title' => esc_html__('Enable H3 Custom Font (Mobile)', 'creote'),
         'desc' => esc_html__('Enable to customize the theme heading h3 tag font (Mobile)', 'creote'),
         ),
    
         array(
             'id' => 'h3_typography_mobile',
             'type' => 'typography',
             'title' => esc_html__('H3 Font Typography (Mobile)', 'creote'),
             'font-family' => false,
             'text-align' => false,
             'font-weight' => false,
             'font-style' => false,
             'color' => false,
             'google' => false,
             'subsets' => false,
             'font-backup' => false,
             'output' => array('' ),
             'units' => 'px',
             'subtitle' => esc_html__('Apply options to customize the h3 heading font for the theme (Mobile)', 'creote'),
             'default' => array(
                 'font-style' => '',
                 'font-size' => ' ',
                 'line-height' => ''
            ),
            'required' => array('heading_style_h3_enable_mob', '=', true),
        ),

          // h4 custom fonts
    array(
        'id' => 'heading_style_h4_enable_desk',
        'type' => 'switch',
        'title' => esc_html__('Enable H4 Custom Font', 'creote'),
        'desc' => esc_html__('Enable to customize the theme heading h4 tag font', 'creote'),
        ),
    array(
        'id' => 'h4_typography',
        'type' => 'typography',
        'title' => esc_html__('H4 Font Typography', 'creote'),
        'google' => false,
        'color' => false,
        'font-backup' => false,
        'font-family' => false,
        'subsets' => false,
        'output' => array('body h4', 'h4'),
        'units' => 'px',
        'subtitle' => esc_html__('Apply options to customize the h4 heading font for the theme', 'creote'),
        'default' => array(
         'font-style' => '',
         
         'google' => true,
         'font-size' => '',
         'line-height' => ''
         ),
        'required' => array('heading_style_h4_enable_desk', '=', true),
    ),
    array(
        'id' => 'heading_style_h4_enable_mob',
        'type' => 'switch',
        'title' => esc_html__('Enable H4 Custom Font (Mobile)', 'creote'),
        'desc' => esc_html__('Enable to customize the theme heading h4 tag font (Mobile)', 'creote'),
    ),

    array(
        'id' => 'h4_typography_mobile',
        'type' => 'typography',
        'title' => esc_html__('H4 Font Typography (Mobile)', 'creote'),
        'font-family' => false,
        'text-align' => false,
        'color' => false,
        'google' => false,
        'font-weight' => false,
        'font-style' => false,
        'subsets' => false,
        'font-backup' => false,
        'output' => array('' ),
        'units' => 'px',
        'subtitle' => esc_html__('Apply options to customize the h4 heading font for the theme (Mobile)', 'creote'),
        'default' => array(
         'font-style' => '',
         'font-size' => ' ',
         'line-height' => ''
         ),
         'required' => array('heading_style_h4_enable_mob', '=', true),
        ),
    // h5 custom fonts
    array(
        'id' => 'heading_style_h5_enable_desk',
        'type' => 'switch',
        'title' => esc_html__('Enable H5 Custom Font', 'creote'),
        'desc' => esc_html__('Enable to customize the theme heading h5 tag font', 'creote'),
        ),
    array(
        'id' => 'h5_typography',
        'type' => 'typography',
        'title' => esc_html__('H5 Font Typography', 'creote'),
        'google' => false,
        'color' => false,
        'font-backup' => false,
        'font-family' => false,
        'subsets' => false,
        'output' => array('body h5', 'h5'),
        'units' => 'px',
        'subtitle' => esc_html__('Apply options to customize the h5 heading font for the theme', 'creote'),
        'default' => array(
         'font-style' => '',
         
         'google' => true,
         'font-size' => '',
         'line-height' => ''
         ),
        'required' => array('heading_style_h5_enable_desk', '=', true),
        ),
        array(
         'id' => 'heading_style_h5_enable_mob',
         'type' => 'switch',
         'title' => esc_html__('Enable H5 Custom Font (Mobile)', 'creote'),
         'desc' => esc_html__('Enable to customize the theme heading h5 tag font (Mobile)', 'creote'),
         ),
    
        array(
         'id' => 'h5_typography_mobile',
         'type' => 'typography',
         'title' => esc_html__('H5 Font Typography (Mobile)', 'creote'),
         'font-family' => false,
         'text-align' => false,
         'color' => false,
         'google' => false,
         'font-weight' => false,
         'font-style' => false,
         'subsets' => false,
         'font-backup' => false,
         'output' => array('' ),
         'units' => 'px',
         'subtitle' => esc_html__('Apply options to customize the h5 heading font for the theme (Mobile)', 'creote'),
         'default' => array(
             'font-style' => '',
             'font-size' => ' ',
             'line-height' => ''
             ),
             'required' => array('heading_style_h5_enable_mob', '=', true),
         ),

         // h6 csutom fonts

    array(

        'id' => 'heading_style_h6_enable_desk',

        'type' => 'switch',

        'title' => esc_html__('Enable H6 Custom Font', 'creote'),

        'desc' => esc_html__('Enable to customize the theme heading h6 tag font', 'creote'),

        ),

    array(
        'id' => 'h6_typography',
        'type' => 'typography',
        'title' => esc_html__('H6 Font Typography', 'creote'),
        'google' => false,
        'color' => false,
        'font-backup' => false,
        'font-family' => false,
        'subsets' => false,
        'output' => array('body h6', 'h6'),
        'units' => 'px',
        'subtitle' => esc_html__('Apply options to customize the h6 heading font for the theme', 'creote'),
        'default' => array(
         'font-style' => '',
         
         'google' => true,
         'font-size' => '',
         'line-height' => ''
        ),
        'required' => array('heading_style_h6_enable_desk', '=', true),
    ),

    array(
        'id' => 'heading_style_h6_enable_mob',
        'type' => 'switch',
        'title' => esc_html__('Enable H6 Custom Font (Mobile)', 'creote'),
        'desc' => esc_html__('Enable to customize the theme heading h6 tag font (Mobile)', 'creote'),
    ),
    
    array(
        'id' => 'h6_typography_mobile',
         'type' => 'typography',
         'title' => esc_html__('H6 Font Typography (Mobile)', 'creote'),
         'font-family' => false,
         'text-align' => false,
         'color' => false,
         'google' => false,
         'font-weight' => false,
         'font-style' => false,
         'subsets' => false,
         'font-backup' => false,
         'output' => array('' ),
         'units' => 'px',
         'subtitle' => esc_html__('Apply options to customize the h6 heading font for the theme (Mobile)', 'creote'),
         'default' => array(
             'font-style' => '',
             'font-size' => ' ',
             'line-height' => ''
             ),
             'required' => array('heading_style_h6_enable_mob', '=', true),
         ),


        array(
         'id' => 'body_custom_fonts',
         'type' => 'switch',
         'title' => esc_html__('Use Body,Paragraph Custom Font', 'creote'),
         'desc' => esc_html__('Enable to customize the theme body,p tag font', 'creote'),
        ),
        array(
         'id' => 'body_typography',
         'type' => 'typography',
         'title' => esc_html__('Body Font Typography', 'creote'),
         'google' => false,
         'color' => false,
         'font-backup' => false,
         'font-family' => false,
         'subsets' => false,
         'output' => array('body p' , 'body'),
         'units' => 'px',
         'subtitle' => esc_html__('Apply options to customize the body,paragraph font for the theme', 'creote'),
         'default' => array(
       
             'font-style' => '',
             
             'google' => true,
             'font-size' => '',
             'line-height' => ''
         ),
         'required' => array('body_custom_fonts', '=', true),
        ),
 

    ),
));
