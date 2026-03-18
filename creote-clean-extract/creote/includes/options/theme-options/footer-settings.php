<?php
/*
 *=================================
 * Footer Settings
 * @package Creote WordPress Theme
 *==================================
*/
Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Footer Settings', 'creote' ),
            'id'     => 'footer_settings_all',
            'desc'   => esc_html__( '', 'creote' ),
            'icon'   => 'el el-friendfeed',
            'fields' => array(
            array(
                'id'       => 'footer_custom',
                'type'     => 'switch', 
                'title'    => __('Footer Custom Enable / Disable', 'creote'),
                'default'  => false,
            ),
             array(
                'id'       => 'footer_style',
               'type'     => 'select',
               'title'    => __('Select Footer Style', 'creote'), 
               // Must provide key => value pairs for select options
               'options'  => creote_footer_query('footer'),
               'required' => array( 'footer_custom', '=', true ),
           ),

           array(
            'id'       => 'footer_sticky_enable',
            'type'     => 'switch', 
            'title'    => __('Footer Sticky Enable / Disable', 'creote'),
            'default'  => false,
        ),
                  
     )
 ) );