<?php
/*
====================
General Settings
====================
*/
Redux::setSection( $opt_name, array(
            'title'  => esc_html__( 'Performance Settings', 'creote' ),
            'id'     => 'performance_settings',
            'desc'   => esc_html__( '', 'creote' ),
            'icon'   => 'el el-wrench',
            'fields' => array(
                // elemntor
                array(
                    'id' => 'site_per',
                    'type' => 'section',
                    'title' => __('For Elementor (After complete all your work enable these option and again going to work disable this options)', 'creote'),
                    'indent' => true ,
                ), 
                array(
                    'id'       => 'disable_font_awesome',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Remove fontawesome', 'creote' ),
                    'description'    => esc_html__( 'Enabling this option will Remove Elementor fontawesome from loading.', 'creote' ), 
                    'default'  => false,
                ), 
                array(
                    'id'       => 'disable_elementor_pro',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Remove Elementor pro script', 'creote' ),
                    'description'    => esc_html__( 'By enabling this option, some features of Elementor may stop working.', 'creote' ), 
                    'default'  => false,
                ),  
                array(
                    'id'       => 'disable_elementor_editor_script',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Remove Elementor editor script', 'creote' ),
                    'description'    => esc_html__( 'By enabling this option, some features of Elementor may stop working on the backend.', 'creote' ), 
                    'default'  => false,
                ), 
                array(
                    'id'       => 'disable_google_fonts',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Remove Google fonts', 'creote' ),
                    'description'    => esc_html__( 'Enabling this option will Remove  Elementor Google fonts from loading.', 'creote' ),
                    'default'  => false,
                ),  
                array(
                    'id'       => 'disable_icons',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Remove Icons', 'creote' ),
                    'description'    => esc_html__( 'Enabling this option will Remove  Elementor icons from loading.', 'creote' ), 
                    'default'  => false,
                ),  
                array(
                    'id'       => 'disable_animation',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Remove Animations', 'creote' ),
                    'description'    => esc_html__( 'Enabling this option will Remove Elementor animations on your website.', 'creote' ), 
                    'default'  => false,
                ),   
                array(
                    'id' => 'site_pertwo',
                    'type' => 'section',
                    'title' => __('Other Settings - (After complete all your work enable these option and again going to work disable this options)', 'creote'),
                    'indent' => true ,
                ), 
                array(
                    'id'       => 'disable_wp_block_library',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Remove Wp block library', 'creote' ),
                    'description'    => esc_html__( 'This option will disable WP Block Library (Does not include single posts).', 'creote' ),
                    'default'  => false,
                ),  
                array(
                    'id'       => 'disable_migrate_jquery',
                    'type'     => 'switch',
                    'title'    => esc_html__('Remove jQuery migrate', 'creote' ),
                    'description'    => esc_html__( 'This option will Remove jQuery Migrate.', 'creote' ),
                    'default'  => false,
                ),    
                array(
                    'id'       => 'disable_query_strings',
                    'type'     => 'switch',
                    'title'    => esc_html__('Remove query strings', 'creote' ),
                    'description'    => esc_html__( 'This option will Remove styles and scripts query strings.', 'creote' ),
                    'default'  => false,
                ),  
                array(
                    'id'       => 'disable_emoji',
                    'type'     => 'switch',
                    'title'    => esc_html__('Remove emoji', 'creote' ),
                    'description'    => esc_html__( 'Enabling this option will Remove  WP emojis from loading.', 'creote' ),
                    'default'  => false,
                ),  
                // elemntor end
            ),
        ));