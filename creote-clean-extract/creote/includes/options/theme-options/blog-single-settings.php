<?php
/*
 *=================================
 * Blog Single Settings
 * @package Creote WordPress Theme
 *==================================
*/
Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Blog Single Settings', 'creote' ),
            'id'     => 'blog_single_settings_all',
            'desc'   => esc_html__( '', 'creote' ),
            'icon'   => 'el el-bold',
            'subsection' => true,
            'fields' => array( 
                /*--array(
                    'id'       => 'authour_enable',
                    'type'     => 'switch', 
                    'default'  => false,
                    'title'    => __('Authour Enable / Disable', 'creote'),
                    'desc'       => esc_html__('This is used to enable and disable Authour in blog single', 'creote'),
                ),*/
                array(
                    'id'       => 'share_disable',
                    'type'     => 'switch', 
                    'default'  => false,
                    'title'    => __('Share Enable / Disable ', 'creote'),
                    'desc'       => esc_html__( 'This is used to enable and disable Share in blog single', 'creote'),
                ),
                array(
                    'id'       => 'tag_disable',
                    'type'     => 'switch', 
                    'default'  => false,
                    'title'    => __('Tag Enable / Disable', 'creote'),
                    'desc'       => esc_html__('This is used to enable and disable Tags in blog single', 'creote'),
                ),

                array(
                    'id'       => 'post_nav_enable',
                    'type'     => 'switch', 
                    'default'  => false,
                    'title'    => __('Prev - Next Post Navigation Enable / Disable', 'creote'),
                    'desc'       => esc_html__('This is used to enable and disable AuthoPrev - Next Post Navigationur in blog single', 'creote'),
                ),
            
                array(
                    'id'       => 'enable_related_post',
                    'type'     => 'switch', 
                    'default'  => true,
                    'title'    => __('Related posts Enbale / Disable', 'creote'),
                    'desc'       => esc_html__( 'This is used to enable and disable Related Posts in blog single', 'creote' ),
                ),

                array(
                    'id'       => 'related_post_title',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Related Post Title', 'creote' ),
                    'required' => array( 'enable_related_post', '=', true ),
                    'default' => esc_html__('Related Posts', 'creote') ,
                ),
                array(
                    'id'       => 'related_post_count',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Related Post Count', 'creote' ),
                    'required' => array( 'enable_related_post', '=', true ),
                    'default' => esc_html__('4', 'creote') ,
                ),
                array(
                    'id'       => 'related_carousel_items',
                   'type'     => 'select',
                   'title'    => __('Items To Display', 'creote'), 
                   'options'  => array(
                       'related_posts_swiper' => esc_html__( 'Three Items', 'creote' ),
                       'related_posts_swiper_two' => esc_html__( 'Two Items ', 'creote' ),
                   ),
                   'default'  => 'related_posts_swiper_two',
                   'required' => array( 'enable_related_post', '=', true ),
               ),
     )
 ) );