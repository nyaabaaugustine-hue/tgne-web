<?php
/*
 *=================================
 * Theme Color Settings
 * @package Creote WordPress Theme
 *==================================
*/
Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Theme Color Settings', 'creote' ),
            'id'     => 'color_scheme',
            'desc'   => esc_html__( '', 'creote' ),
            'icon'   => 'el el-brush',
            'fields' => array(
           
            array(
                'id'       => 'theme_setttings_enable',
                'type'     => 'switch', 
                'title'    => __('Theme Color Settings Enable', 'creote'),
                'default'  => false,
            ),
            array(
                'id'       => 'theme_color_one',
                'type'     => 'color',
                'title'    => __('Theme Color (1)', 'creote'), 
                'validate' => 'color',

            ),
            array(
                'id'       => 'theme_color_two',
                'type'     => 'color',
                'title'    => __('Theme Color (2)', 'creote'), 
                'validate' => 'color',

            ),
            array(
                'id'       => 'theme_color_three',
                'type'     => 'color',
                'title'    => __('Theme Color (3 Light Background) ', 'creote'), 
                'validate' => 'color',
         
            ),
           
            array(
                'id'       => 'heading_color',
                'type'     => 'color',
                'title'    => __('Heading Color', 'creote'), 
                'validate' => 'color',
               
            ),
 
            array(
                'id'       => 'description_color',
                'type'     => 'color',
                'title'    => __('Text , Paragraph and Body  Color', 'creote'), 
                'validate' => 'color',
                
            ),
            array(
                'id'       => 'description_light',
                'type'     => 'color',
                'title'    => __('Text Color (Light) ', 'creote'), 
                'validate' => 'color',
                
            ),
           
            
            array(
                'id'       => 'border_color',
                'type'     => 'color',
                'title'    => __('Border Color', 'creote'), 
                'validate' => 'color',
      
            ),
 
            array(
                'id'       => 'menu_color',
                'type'     => 'color',
                'title'    => __('Menu Color', 'creote'), 
                'validate' => 'color',
              
            ),
           
            array(
                'id'       => 'menu_active_color',
               'type'     => 'color',
               'title'    => __('Menu Active Color', 'creote'), 
               'validate' => 'color',
             
              ),
            
              array(
                'id'       => 'sticky_menu_color',
               'type'     => 'color',
               'title'    => __('Header Sticky Menu  Color', 'creote'), 
               'validate' => 'color',
             
              ),
            
            
              array(
                'id'       => 'sticky_menu_active_color',
               'type'     => 'color',
               'title'    => __('Header Sticky Menu Active Color', 'creote'), 
               'validate' => 'color',
             
              ),

     )
));

