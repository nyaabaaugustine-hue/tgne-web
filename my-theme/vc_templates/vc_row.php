<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $equal_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $parallax_speed_bg
 * @var $parallax_speed_video
 * @var $content - shortcode content
 * @var $css_animation
 * @var $height
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */
$el_class = $full_height = $parallax_speed_bg = $parallax_speed_video = $full_width = $equal_height = $rtl_reverse = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = $css_animation = $height = $layout = 
$layout_padding = $custom_margin = $custom_padding = $custom_border_width = $custom_border_style = $custom_border_color  = $custom_background_color = $custom_background_image = $custom_background_repeat = '';
$custom_background_position = $custom_background_size = $layout_border_width = $layout_border_style = $layout_border_color = $layout_background_color = ''; 
$output = $after_output = '';
$atts = vc_map_get_attributes( $this->getShortcode( 
    array( 
		'layout' => 'container', 
		'layout_padding' => '' ,
		'custom_margin' => '' ,
		'custom_padding' => '' ,
		'custom_border_width' => '' ,
		'custom_border_style' => '' ,
		'custom_border_color' => '' ,
		'custom_background_color' => '' ,
		'custom_background_image' => '' ,
		'custom_background_repeat' => '' ,
		'custom_background_position' => '' ,
		'custom_background_size' => '' ,
		'layout_border_width'  => '' ,
		'layout_border_style'  => '' ,
		'layout_border_color'  => '' ,
		'layout_background_color'  => '' ,
       ),
  ), $atts );
extract( $atts );
 
// Define variables to avoid undefined key notices

$custom_margin = isset($atts['custom_margin']) ? $atts['custom_margin'] : '';
$custom_padding = isset($atts['custom_padding']) ? $atts['custom_padding'] : '';
$custom_border_width = isset($atts['custom_border_width']) ? $atts['custom_border_width'] : '';
$custom_border_style = isset($atts['custom_border_style']) ? $atts['custom_border_style'] : '';
$custom_border_color  = isset($atts['custom_border_color']) ? $atts['custom_border_color'] : '';
$custom_background_color  = isset($atts['custom_background_color']) ? $atts['custom_background_color'] : '';
$custom_background_image  = isset($atts['custom_background_image']) ? $atts['custom_background_image'] : ''; 
$custom_background_repeat  = isset($atts['custom_background_repeat']) ? $atts['custom_background_repeat'] : '';
$custom_background_position  = isset($atts['custom_background_position']) ? $atts['custom_background_position'] : '';
$custom_background_size  = isset($atts['custom_background_size']) ? $atts['custom_background_size'] : '';
$layout_padding = isset($atts['layout_padding']) ? $atts['layout_padding'] : '';
$layout_border_width = isset($atts['layout_border_width']) ? $atts['layout_border_width'] : '';
$layout_border_style = isset($atts['layout_border_style']) ? $atts['layout_border_style'] : '';
$layout_border_color = isset($atts['layout_border_color']) ? $atts['layout_border_color'] : '';
$layout_background_color = isset($atts['layout_background_color']) ? $atts['layout_background_color'] : '';
// Variables for layout styles

$custom_margin_out = ! empty( $custom_margin ) ? "margin: $custom_margin!important;" : '';
$custom_padding_out = ! empty( $custom_padding ) ? "padding: $custom_padding!important;" : '';
$custom_border_width_out = ! empty( $custom_border_width ) ? "border-width: $custom_border_width!important;" : '';
$custom_border_style_out = ! empty( $custom_border_style ) ? "border-style: $custom_border_style!important;" : '';
$custom_border_color = ! empty( $custom_border_color ) ? "border-color: $custom_border_color!important;" : '';
$custom_background_color = ! empty( $custom_background_color ) ? "background: $custom_background_color!important;" : '';
$custom_background_image = wp_get_attachment_image_src( intval( $custom_background_image ), 'full' );
$custom_background_image_out = ! empty( $custom_background_image ) ? "background-image:  url($custom_background_image[0])!important;" : ''; 
$custom_background_repeat = ! empty( $custom_background_repeat ) ? "background-repeat: $custom_background_repeat!important;" : '';
$custom_background_position = ! empty( $custom_background_position ) ? "background-position: $custom_background_position!important;" : '';
$custom_background_size = ! empty( $custom_background_size ) ? "background-size: $custom_background_size!important;" : '';
$layout_padding_out = ! empty( $layout_padding ) ? "padding: $layout_padding!important;" : '';
$layout_border_width_out = ! empty( $layout_border_width ) ? "border-width: $layout_border_width!important;" : '';
$layout_border_style_out = ! empty( $layout_border_style ) ? "border-style: $layout_border_style!important;" : '';
$layout_border_color_out = ! empty( $layout_border_color ) ? "border-color: $layout_border_color!important;" : '';
$layout_background_color_out = ! empty( $layout_background_color ) ? "background-color: $layout_background_color!important;" : '';
  
//================================================
// Get Bowtied Mod
//================================================
 
$columns_height = '';
$style_css  = '';
$style_two_css  = '';
$height_class = "";
// css
if ($height != "") $height_class = ' min-height:'.$height.'; '; 

if(!empty($custom_margin_out) ||  !empty($custom_padding_out) || !empty($custom_border_width_out) || !empty($custom_border_style_out) || !empty($custom_border_color) || !empty($custom_background_color) || !empty($custom_background_image_out) || !empty($custom_background_repeat) || !empty($custom_background_position) || !empty($custom_background_size)):
	$style_css  = "$custom_margin_out $custom_padding_out $custom_border_width_out $custom_border_style_out $custom_border_color $custom_background_color $custom_background_image_out $custom_background_repeat $custom_background_position $custom_background_size";
endif;


if (!empty($layout_padding_out) || !empty($layout_border_width_out) || !empty($layout_border_style_out) || !empty($layout_border_color_out) || !empty($layout_background_color_out)) {
	$style_two_css .= "$layout_padding_out $layout_background_color_out $layout_border_style_out $layout_border_width_out $layout_border_color_out";
}
// height
$columns_height_class = " " . $columns_height;

//================================================
// /Get Bowtied Mod
//================================================

wp_enqueue_script( 'wpb_composer_front_js' );

$el_class = $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );

$css_classes = array(
	//'row', // Get Bowtied Mod
	$columns_height_class, // Get Bowtied Mod
	'vc_row',
	'wpb_row', //deprecated
	'vc_row-fluid',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

if ( 'yes' === $disable_element ) {
	if ( vc_is_page_editable() ) {
		$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
	} else {
		return '';
	}
}

if ( vc_shortcode_custom_css_has_property( $css, array(
		'border',
		'background',
	) ) || $video_bg || $parallax
) {
	$css_classes[] = 'vc_row-has-fill';
}

if ( ! empty( $atts['gap'] ) ) {
	$css_classes[] = 'vc_column-gap-' . $atts['gap'];
}

$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if ( ! empty( $full_width ) ) {
	$wrapper_attributes[] = 'data-vc-full-width="true"';
	$wrapper_attributes[] = 'data-vc-full-width-init="false"';
	if ( 'stretch_row_content' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
	} elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
		$css_classes[] = 'vc_row-no-padding';
	}
	$after_output .= '<div class="vc_row-full-width vc_clearfix"></div>';
}

if ( ! empty( $full_height ) ) {
	$css_classes[] = 'vc_row-o-full-height';
	if ( ! empty( $columns_placement ) ) {
		$flex_row = true;
		$css_classes[] = 'vc_row-o-columns-' . $columns_placement;
		if ( 'stretch' === $columns_placement ) {
			$css_classes[] = 'vc_row-o-equal-height';
		}
	}
}

if ( ! empty( $equal_height ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-equal-height';
}
if ( ! empty( $rtl_reverse ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_rtl-columns-reverse';
}

$unique_id = uniqid();
$unique_id_two = uniqid();
//================================================
// Get Bowtied Mod
//================================================

if ( $columns_height == "adjust_cols_height" ) {
	$flex_row = true;
	$css_classes[] = ' vc_row-o-equal-height';
} 
//================================================
// /Get Bowtied Mod
//================================================

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = 'vc_row-flex';
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

$parallax_speed = $parallax_speed_bg;
if ( $has_video_bg ) {
	$parallax = $video_bg_parallax;
	$parallax_speed = $parallax_speed_video;
	$parallax_image = $video_bg_url;
	$css_classes[] = 'vc_video-bg-container';
	wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}

if ( ! empty( $parallax ) ) {
	wp_enqueue_script( 'vc_jquery_skrollr_js' );
	$wrapper_attributes[] = 'data-vc-parallax="' . esc_attr( $parallax_speed ) . '"'; // parallax speed
	$css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
	if ( false !== strpos( $parallax, 'fade' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fade';
		$wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
	} elseif ( false !== strpos( $parallax, 'fixed' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fixed';
	}
}
 
if ( ! empty( $parallax_image ) ) {
	if ( $has_video_bg ) {
		$parallax_image_src = $parallax_image;
	} else {
		$parallax_image_id = preg_replace( '/[^\d]/', '', $parallax_image );
		$parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
		if ( ! empty( $parallax_image_src[0] ) ) {
			$parallax_image_src = $parallax_image_src[0];
		}
	}
	$wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
}
if ( ! $parallax && $has_video_bg ) {
	$wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}
 
$css_classes[] = 'creote_section_' . $unique_id_two;
 
$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"'; 
$output .= '<div '  . implode( ' ', $wrapper_attributes ) .'>'; 
if (!empty($style_css)) {
    $output .= '<style type="text/css" data-type="vc_shortcodes-custom"> .creote_section_'.$unique_id_two.'{' . $style_css . '}</style>';
} 
 
if (!empty($style_two_css)) {
    $output .= '<style type="text/css" data-type="vc_shortcodes-custom">  .creote_container_'.$unique_id.'.common_container{' . $style_two_css . '}</style>';
}   
 
$output .= '<div class="'.$layout.' creote_container_'.$unique_id.' common_container clearfix">';
 
$output .= wpb_js_remove_wpautop( $content );
 
$output .= '</div>';
$output .= '</div>';
 
$output .= $after_output;

echo $output;
 
