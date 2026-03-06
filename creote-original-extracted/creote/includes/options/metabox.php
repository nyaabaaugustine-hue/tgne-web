<?php

/**
 * Registering meta boxes
 *
 * Using Meta Box plugin: http://www.deluxeblogtips.com/meta-box/
 *
 * @see http://www.deluxeblogtips.com/meta-box/docs/define-meta-boxes
 *
 * @param array $meta_boxes Default meta boxes. By default, there are no meta boxes.
 *
 * @return array All registered meta boxes
 */

add_filter('rwmb_meta_boxes', 'creote_register_meta_boxes');
function creote_register_meta_boxes($meta_boxes)
{


 
    $meta_boxes[] = array(
        'id' => 'creote-general-settings',
        'title' => esc_html__('General Setting', 'creote') ,
        'pages' => array(
            'page',
            'product',
            'post', 
            'service',
            'project'
        ) ,
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,
        'closed' => 'true' ,
        'fields' => array(
           

            array(
                'name' => esc_html__('Enable Body Padding Css', 'creote') ,
                'id' => 'body_padding_enable',
                'type' => 'switch',
                'std' => false,
                'on_label'  => 'Yes', 
                'off_label' => 'No',
            ) ,
            array(
                'name' => esc_html__('Padding For Body (Desktop)', 'creote') ,
                'id' => 'padding_for_body',
                'type' => 'text',
                'std' => false,
                'placeholder' => esc_html__('0px 0px 0px 0px', 'creote') ,
                'description' => esc_html__('Padding option for body  top right botton left  eg(10px 20px 10px 20px)', 'creote') ,
            ),

            array(
                'name' => esc_html__('Padding For Body (Mobile)', 'creote') ,
                'id' => 'padding_for_body_mb',
                'type' => 'text',
                'std' => false,
                'placeholder' => esc_html__('0px 0px 0px 0px', 'creote') ,
                'description' => esc_html__('Padding option for body  top right botton left  eg(10px 20px 10px 20px)', 'creote') ,
            ),

            array(
                'type' => 'divider',
            ), 
            
            array(
                'name' => esc_html__('Enable Page Header Padding Css', 'creote') ,
                'id' => 'page_header_padding_enable',
                'type' => 'switch',
                'std' => false,
                'on_label'  => 'Yes', 
                'off_label' => 'No',
            ) ,
            array(
                'name' => esc_html__('Padding For Page Header (Desktop)', 'creote') ,
                'id' => 'padding_for_page_header',
                'type' => 'text',
                'std' => false,
                'placeholder' => esc_html__('0px 0px 0px 0px', 'creote') ,
                'description' => esc_html__('Padding option for body top right botton left  eg(10px 20px 10px 20px)', 'creote') ,
            ), 
            array(
                'name' => esc_html__('Padding For Page Header (Mobile)', 'creote') ,
                'id' => 'padding_for_page_header_mb',
                'type' => 'text',
                'std' => false,
                'placeholder' => esc_html__('0px 0px 0px 0px', 'creote') ,
                'description' => esc_html__('Padding option for body top right botton left  eg(10px 20px 10px 20px)', 'creote') ,
            ),
         
              

            array(
                'name' => esc_html__('Header Settings', 'creote') ,
                'id' => 'heading_header',
                'type' => 'heading',
                'class' => 'hide-header-heading',
            ) ,
            array(
                'name' => esc_html__('Enable Header Style', 'creote') ,
                'id' => 'custom_header',
                'type' => 'switch',
                'std' => false,
                'on_label'  => 'Yes', 
                'off_label' => 'No',
            ) ,
            array(
                'name' => esc_html__('Choose Header Style', 'creote') ,
                'id' => 'header_settings_meta',
                'options' => creote_header_query('header'),
                'type' => 'select_advanced',
                'multiple'        => false,
            ),

            array(
                'name' => esc_html__('Disable Sticky Header', 'creote') ,
                'id' => 'custom_sticky_enable',
                'type' => 'switch',
                'std' => false,
                'on_label'  => 'Yes', 
                'off_label' => 'No',
            ) ,

            array(
                'name' => esc_html__('Enable Sticky Header Style', 'creote') ,
                'id' => 'custom_sticky_header',
                'type' => 'switch',
                'std' => false,
                'on_label'  => 'Yes', 
                'off_label' => 'No',
            ) ,
            array(
                'name' => esc_html__('Choose Sticky Header Style', 'creote') ,
                'id' => 'header_sticky_settings_meta',
                'options' => creote_header_query('header'),
                'type' => 'select_advanced',
                'multiple'        => false,
            ),

            
            array(
                'name' => esc_html__('Footer Settings', 'creote') ,
                'id' => 'heading_footer',
                'type' => 'heading',
                'class' => 'hide-footer-heading',
            ) ,
            array(
                'name' => esc_html__('Enable Footer Style', 'creote') ,
                'id' => 'custom_footer',
                'type' => 'switch',
                'std' => false,
                'on_label'  => 'Yes', 
                'off_label' => 'No',
            ) ,
            array(
                'name' => esc_html__('Choose Footer Style', 'creote') ,
                'id' => 'footer_settings_meta',
                'options' => creote_footer_query('footer'),
                'type' => 'select_advanced',
                'multiple'        => false,
            ),
            array(
                'name' => esc_html__('Enable Footer Sticky', 'creote') ,
                'id' => 'custom_footer_sticky',
                'type' => 'switch',
                'std' => false,
                'on_label'  => 'Yes', 
                'off_label' => 'No',
            ) ,
            array(
                'name' => esc_html__('Layout Settings', 'creote') ,
                'id' => 'heading_Layout',
                'type' => 'heading',
                'class' => 'hide-Layout-heading',
            ) ,
            array(
                'name' => esc_html__('Enable Custom Layout', 'creote') ,
                'id' => 'custom_layout',
                'type' => 'switch',
                'std' => false,
                'on_label'  => 'Yes', 
                'off_label' => 'No',
            ) ,
            array(
                'name' => esc_html__('Layout', 'creote') ,
                'id' => 'layout',
                'type' => 'image_select',
                'class' => 'custom-layout',
                'options' => array(
                    'no-sidebar' => get_template_directory_uri() . '/assets/images/full-width.png',
                    'right-sidebar' => get_template_directory_uri() . '/assets/images/right-sidebar.png',
                    'left-sidebar' => get_template_directory_uri() . '/assets/images/left-sidebar.png',
                ) ,

            ) ,

            array(
                'name' => esc_html__('Preloader Settings', 'creote') ,
                'id' => 'preloader_heading',
                'type' => 'heading',
                'class' => 'preloader_heading',
            ) ,
            array(
                'name' => esc_html__('Enable Preloader Style', 'creote') ,
                'id' => 'preloader_custom_enable',
                'type' => 'switch',
                'std' => false,
                'on_label'  => 'Yes', 
                'off_label' => 'No',
            ) ,

            array(
                'name'          => 'Preloader Background Color',
                'id'            => 'preloader_bgcolor',
                'type'          => 'color',
                'alpha_channel' => true,
            ),

            array(
                'name' => esc_html__('Preloader Image', 'creote') ,
                'id' => 'preloader_image',
                'type' => 'image',
                'max_file_uploads' => 1,
                'std' => false,
                'class' => 'preloader_image',
            ) ,
            

        ) ,

    );

    $meta_boxes[] = array(
        'id' => 'creote-page-header',
        'title' => esc_html__('Page Header Setting', 'creote') ,
        'pages' => array(
            'page',
            'post', 
            'product',
            'service',
            'project'
        ) ,
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,
        'closed' => 'true' ,
        'fields' => array(
            
            array(
                'name' => esc_html__('Page Header Settings', 'creote') ,
                'id' => 'page_header_settings',
                'type' => 'heading',
                'class' => 'page-header-heading',
            ) ,
            array(
                'name' => esc_html__('Page Header  Disable', 'creote') ,
                'id' => 'page_header_enable_disable',
                'type' => 'switch',
                'std' => false,
                'on_label'  => 'Yes',
                'off_label' => 'No',
            ),
            array(
                'type' => 'divider',
            ), 
          
            array(
                'name' => esc_html__('Page header Title', 'creote') ,
                'id' => 'page_header_title',
                'type' => 'text',
                'std' => false,
            ), 
            array(
                'name'          => 'Page header Background Color',
                'id'            => 'page_header_bgcolor',
                'type'          => 'color',
                'alpha_channel' => true,
            ),
            array(
                'name' => esc_html__('Page Header background Image', 'creote') ,
                'id' => 'page_header_bgimage',
                'type' => 'image',
                'max_file_uploads' => 1,
                'std' => false,
                'class' => 'page_header_bg_image',
            ) ,
            array(
                'name' => esc_html__('Page Header Text Color ', 'creote') ,
                'id'            => 'text_color_blog',
                'type'          => 'color',
                 // Add alpha channel?
                'alpha_channel' => true,
            ),
      

        ) ,

    );


    

    // service

    $meta_boxes[] = array(
        'id' => 'creote-service-settings',
        'title' => esc_html__('Service Setting', 'creote') ,
        'pages' => array(
            'service',
        ) ,
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,
        'closed' => 'true' ,
        'fields' => array(
            array(
                'name' => esc_html__('Icon Image / Icon Font ( Use Image Or Icon Font)', 'creote') ,
                'id' => 'service_icon_image_ttitle',
                'type' => 'heading',
                'std' => false,
            ), 
            array(
                'name' => esc_html__('Icon', 'creote') ,
                'id' => 'service_icon',
                'options' => creote_get_theme_side_icon_two(),
                'type' => 'select_advanced',
                'multiple'        => false,

            ) ,
            array(
                'type' => 'divider',
            ), 
          
            array(
                'name' => esc_html__('Icon Image', 'creote') ,
                'id' => 'service_icon_image',
                'type' => 'image',
                'name' => esc_html__('Icon Image', 'creote') ,
                'srcset' => 'large.jpg 1920w, medium.jpg 960w, small.jpg 480w' ,
                'sizes' => array(), 
                'image_meta' => array(),
            ),
            array(
                'name' => esc_html__('Transitions Effect Timing', 'creote') ,
                'id' => 'trans_effect_timing_serivcs',
                'type' => 'heading',
                'std' => false,
            ),
            array(
                'name' => esc_html__('Service Transition', 'creote') ,
                'id' => 'transition_timing_service',
                'options' => array(
                    '100' => esc_html__('100ms', 'creote'),
                    '200' => esc_html__('200ms', 'creote'),
                    '300' => esc_html__('300ms', 'creote'),
                    '400' => esc_html__('400ms', 'creote'),
                    '500' => esc_html__('500ms', 'creote'),
                    '600' => esc_html__('600ms', 'creote'),
                    '700' => esc_html__('700ms', 'creote'),
                    '800' => esc_html__('800ms', 'creote'),
                    '900' => esc_html__('900ms', 'creote'),
                    '1000' => esc_html__('100ms', 'creote'),
                    '1100' => esc_html__('1100ms', 'creote'),
                    '1200' => esc_html__('1200ms', 'creote'),
                    '1300' => esc_html__('1300ms', 'creote'),
                    '1400' => esc_html__('1400ms', 'creote'),
                    '1500' => esc_html__('1500ms', 'creote'),
                ),
                'type' => 'select_advanced',
                'multiple'        => false,

            ) ,

        ) ,
    );
     // posts

     $meta_boxes[] = array(
        'id' => 'creote-post-settings',
        'title' => esc_html__('Post Setting', 'creote') ,
        'pages' => array(
            'post',
        ) ,
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,
        'closed' => 'true' ,
        'fields' => array(
            array(
                'name' => esc_html__('Single Page Featured Image Enable / Disable', 'creote') ,
                'id' => 'frature_img_enable',
                'type' => 'switch',
                'std' => true,
                'on_label'  => 'Yes',
                'off_label' => 'No',
            ),

            array(
                'name' => esc_html__('Related Post Enable / Disable', 'creote') ,
                'id' => 'relatedpost_single_enable',
                'type' => 'switch',
                'std' => false,
                'on_label'  => 'Disable',
                'off_label' => 'Enable',
            ),

            array(
                'name' => esc_html__('Transitions Effect Timing', 'creote') ,
                'id' => 'trans_effect_timing_post',
                'type' => 'heading',
                'std' => false,
            ),
            array(
                'name' => esc_html__('Post Transition', 'creote') ,
                'id' => 'transition_timing_post',
                'options' => array(
                    '100' => esc_html__('100ms', 'creote'),
                    '200' => esc_html__('200ms', 'creote'),
                    '300' => esc_html__('300ms', 'creote'),
                    '400' => esc_html__('400ms', 'creote'),
                    '500' => esc_html__('500ms', 'creote'),
                    '600' => esc_html__('600ms', 'creote'),
                    '700' => esc_html__('700ms', 'creote'),
                    '800' => esc_html__('800ms', 'creote'),
                    '900' => esc_html__('900ms', 'creote'),
                    '1000' => esc_html__('100ms', 'creote'),
                    '1100' => esc_html__('1100ms', 'creote'),
                    '1200' => esc_html__('1200ms', 'creote'),
                    '1300' => esc_html__('1300ms', 'creote'),
                    '1400' => esc_html__('1400ms', 'creote'),
                    '1500' => esc_html__('1500ms', 'creote'),
                ),
                'type' => 'select_advanced',
                'multiple'        => false,

            ) ,

        ) ,
    );
   
    // project
    $meta_boxes[] = array(
        'id' => 'project-info',
        'title' => esc_html__('Project Settings', 'creote') ,
        'pages' => array(
            'project'
        ) ,
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(

           
            array(
                'name' => esc_html__('Project Information Enable / Disable', 'creote') ,
                'id' => 'project_information_enable',
                'type' => 'switch',
                'std' => false,
                'on_label'  => 'Yes',
                'off_label' => 'No',
            ),
            array(
                'name' => esc_html__('Client', 'creote') ,
                'id' => 'client_id',
                'type' => 'text',
                'class' => 'clint',
                'placeholder'  =>  esc_html__('The Sixmothers Group', 'creote') ,
            ) ,
        

            array(
                'name' => esc_html__('date', 'creote') ,
                'id' => 'date_id',
                'type' => 'text',
                'class' => 'dte',
                'placeholder'  =>  esc_html__('February 14, 2021', 'creote') ,
            ) ,
 
         

            
            array(
                'name' => esc_html__('Transitions Effect Timing', 'creote') ,
                'id' => 'trans_effect_timing_post',
                'type' => 'heading',
                'std' => false,
            ),
            array(
                'name' => esc_html__('Post Transition', 'creote') ,
                'id' => 'transition_timing_post',
                'options' => array(
                    '100' => esc_html__('100ms', 'creote'),
                    '200' => esc_html__('200ms', 'creote'),
                    '300' => esc_html__('300ms', 'creote'),
                    '400' => esc_html__('400ms', 'creote'),
                    '500' => esc_html__('500ms', 'creote'),
                    '600' => esc_html__('600ms', 'creote'),
                    '700' => esc_html__('700ms', 'creote'),
                    '800' => esc_html__('800ms', 'creote'),
                    '900' => esc_html__('900ms', 'creote'),
                    '1000' => esc_html__('100ms', 'creote'),
                    '1100' => esc_html__('1100ms', 'creote'),
                    '1200' => esc_html__('1200ms', 'creote'),
                    '1300' => esc_html__('1300ms', 'creote'),
                    '1400' => esc_html__('1400ms', 'creote'),
                    '1500' => esc_html__('1500ms', 'creote'),
                ),
                'type' => 'select_advanced',
                'multiple'        => false,

            ) ,
 
        ) ,

    );

       // product

$meta_boxes[] = array(
    'id' => 'product-pages',
    'title' => esc_html__('Product Settings', 'creote') ,
    'pages' => array(
        'product'
    ) ,
    'context' => 'normal',
    'priority' => 'high',
    'autosave' => true,
    'closed' => 'true' ,
    'fields' => array(
        array(
            'name' => esc_html__('Product Attributes Enable / Disable', 'creote') ,
            'id' => 'pro_attri_enable',
            'type' => 'switch',
            'std' => false,
            'on_label'  => 'Yes',
            'off_label' => 'No',
            ) ,
            
        array(
            'name' => esc_html__('Attributes', 'creote') ,
            'id' => 'pro_attribute',
            'type' => 'text',
            'label_description' => 'Example ( sizes , color )',
            'desc'        => 'Enter The Attributes Text To Dispale In Product Show Case',
        ) ,    
        array(
            'name' => esc_html__('Attributes Name', 'creote') ,
            'id' => 'pro_attribute_name',
            'type' => 'text',
            'desc'        => 'Enter The Attributes Name Use Used Above',
        ) ,   

    ) ,

);
 


    return $meta_boxes;

}