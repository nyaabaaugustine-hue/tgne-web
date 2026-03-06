<?php
/*
 *=================================
 * Headers Source 
 * @package Creote WordPress Theme
 *==================================
*/

function creote_enqueue_scripts_before_install_plugin(){
    /*== Register and enqueue styles ==*/
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array() , '4.5.0', 'all');
    wp_enqueue_style('style', get_template_directory_uri().'/style.css' );  
    wp_enqueue_style('icomoon-icons', get_template_directory_uri() . '/assets/css/icomoon.css', array() , '1.0.0', 'all');
    wp_enqueue_style('fontawesome-icons', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array() , '4.7.0', 'all');
    wp_enqueue_style( 'creote-fonts', creote_fonts_url(), array(), null );
    wp_enqueue_style('creote-meta-box', get_template_directory_uri().'/assets/css/metabox.css' );    
    wp_enqueue_style('creote-theme', get_template_directory_uri().'/assets/css/scss/elements/theme-css.css' ); 
    wp_enqueue_style('creote-mobile-header', get_template_directory_uri().'/assets/css/scss/elements/mobile.css' );   
    wp_enqueue_script('bootstrap-bundle', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery') , '5.0.2', true);
    wp_enqueue_script('TweenMax', get_template_directory_uri() . '/assets/js/TweenMax.min.js', array('jquery') , '1.18.0', true);
    wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/js/swiper.min.js', array('jquery') , '6.7.5', true);
    wp_enqueue_script('simpleParallax', get_template_directory_uri() . '/assets/js/simpleParallax.min.js', array('jquery') , '5.2.0', true);
    wp_enqueue_script('hc-sticky', get_template_directory_uri() . '/assets/js/hc-sticky.js', array('jquery') , '2.2.7', true);
    wp_enqueue_script('creote-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery') , '1.0.0', true);
    if(is_singular() && comments_open() && get_option('thread_comments')):
        wp_enqueue_script('comment-reply');
    endif;

    wp_enqueue_script( 'wcqv_frontend_js', get_template_directory_uri() . '/assets/js/shop.js',array('jquery'),'1.0', true);
 
	wp_localize_script( 'wcqv_frontend_js', 'MyAjax', array(
		'ajaxurl' => esc_url(admin_url( 'admin-ajax.php' )),
	));
}
add_action('wp_enqueue_scripts', 'creote_enqueue_scripts_before_install_plugin');

/*
=========================
corona preloader
========================
*/
function creote_preloaders(){
global $creote_theme_mod;
$preloaderimage = get_template_directory_uri() . '/assets/images/preloader.gif';
if(!empty($creote_theme_mod['preloader_image']['url'])){
    $preloaderimage = $creote_theme_mod['preloader_image']['url'];
}
$preloader_get_img  = $preloaderimage;
if(get_post_meta(get_the_ID() , 'preloader_custom_enable', true)){
    $preloader_get_img = get_post_meta(get_the_ID() , 'preloader_image', true);
    $preloader_get_img = $preloader_get_img ? wp_get_attachment_image_src($preloader_get_img, 'full') : wp_get_attachment_image_url(get_the_ID() , 'full'); 
    $preloader_get_img = $preloader_get_img[0];
}
$preloader_mg_get = $preloader_get_img ? 'background-image:url(' . $preloader_get_img . ')!important; ' : '';
$get_pre_style  = "style= $preloader_mg_get ";
?>
<div class="loader-wrap">
    <div class="preloader" <?php echo esc_attr($get_pre_style); ?>>
        <div class="preloader-close"><i class="icon-close"></i></div>
    </div>
        <div class="layer"><span class="overlay"></span></div>      
</div>
<?php  
}
/*
=========================
creote back to top
========================
*/
function creote_back_to_top(){
    global $creote_theme_mod;
    if(!empty($creote_theme_mod['bactotop_enable']) == true){
?>
    <!-- Back to top with progress indicator-->
    <div class="prgoress_indicator">
      <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
      </svg>
    </div>
<?php
}}
add_action('back_to_top_enable', 'creote_back_to_top');

/*
=============================================================
Filter to archive title and add page title for singular pages
=============================================================
*/
function creote_the_archive_title($title)
{
    global $creote_theme_mod;
    if(is_search()):
        $title = sprintf(esc_html__('Search Results', 'creote'));
    elseif(is_404()):
        $title = sprintf(esc_html__('Page Not Found', 'creote'));
    elseif(is_page()):
        $title = get_the_title();
    elseif(is_single()):
        $title = get_the_title();
    elseif (is_home() && is_front_page()):
        $title = esc_html__('The Latest Posts', 'creote');
    elseif (is_home() && !is_front_page()):
        $title = get_the_title(get_option('page_for_posts'));
    elseif(is_singular('project')):
        $title = get_the_title(get_the_ID());
    elseif(is_singular('service')):
        $title = get_the_title(get_the_ID());
    elseif(is_singular('job_listing')):
         $title = get_the_title(get_the_ID()); 
    elseif(is_tax() || is_category()  || is_tag()):
        $title = single_term_title('', false);
    elseif(is_singular('post')):
        $title = get_the_title(get_the_ID());
    elseif(is_post_type_archive('service')):
        $services_page_id = get_option('st_services_page_id');
        if($services_page_id && get_post($services_page_id)):
            $title = get_the_title($services_page_id);
        else:
            $title = esc_html__('Service',  'creote');
        endif;
    elseif(is_post_type_archive('job_listing')):
        $st_job_page_id = get_option('st_job_page_id');
        if($st_job_page_id && get_post($st_job_page_id)):
            $title = get_the_title($st_job_page_id);
        else:
            $title = esc_html__('Job Listing',  'creote');
        endif;       
    elseif(is_post_type_archive('project')):
        $projects_page_id = get_option('st_projects_page_id');
        if($projects_page_id && get_post($projects_page_id)):
            $title = get_the_title($projects_page_id);
        else:
            $title = esc_html__('Project',  'creote');
        endif;
    elseif(is_post_type_archive('product')):
        if(!empty($creote_theme_mod['product_page_name'])):
            $product_page_id = $creote_theme_mod['product_page_name'];
           $title = $product_page_id;
        else:
            $title = esc_html__('Product',  'creote');
        endif;
    endif;
    return $title;
}
add_filter('get_the_archive_title', 'creote_the_archive_title');



/*
=============================================================
share options
=============================================================
*/
add_action('creote_get_share_options_one' , 'creote_share_options_one');
function creote_share_options_one(){ 
    global $creote_theme_mod;
?>
<div class="share_socail">
<div class="title"><?php echo esc_html__('Share' , 'creote');?></div>
<button class="m_icon" data-toggle="tooltip" data-placement="right" title="facebook"
  data-sharer="facebook" data-title="<?php the_title(); ?>" data-url="<?php the_permalink(); ?>">
  <i class="fab fa-facebook"></i>
</button>
<button class="m_icon" data-toggle="tooltip" data-placement="right" title="twitter"
  data-sharer="twitter" data-title="<?php the_title(); ?>" 
  data-url="<?php the_permalink(); ?>">
  <i class="fab fa-twitter"></i>
</button>
<button class="m_icon" data-toggle="tooltip" data-placement="right" title="whatsapp"
  data-sharer="whatsapp" data-title="<?php the_title(); ?>"
  data-url="<?php the_permalink(); ?>">
  <i class="fab fa-whatsapp"></i>
</button>

<button class="m_icon" data-toggle="tooltip" data-placement="right" title="telegram"
  data-sharer="telegram" data-title="<?php the_title(); ?>"
  data-url="<?php the_permalink(); ?>" data-to="+44555-03564">
  <i class="fab fa-telegram"></i>
</button>

<button class="m_icon" data-toggle="tooltip" data-placement="right" title="skype"
  data-sharer="skype" data-url="<?php the_permalink(); ?>"
  data-title="<?php the_title(); ?>">
  <i class="fab fa-skype"></i>
</button>
</div>
<?php
}


/*
=============================================================
Search
=============================================================
*/
add_action('creote_get_simple_search' , 'creote_simple_search');
function creote_simple_search() {
?>
<form role="search" method="get" action="<?php echo esc_url(home_url( '/' )); ?>">
	<input type="search" class="search" placeholder="<?php echo esc_attr__( 'Search...', 'creote' ); ?>" value="<?php echo get_search_query() ?>" name="s" title="Search" />
	<button type="submit" class="sch_btn"> <i class="icon-search"></i></button>
</form>
<?php 
}
/*
=============================================================
Search popup
=============================================================
*/
function creote_search_popup() { ?>
  <div id="search-popup" class="search-popup">
    <div class="close-search"><i class="fas  fa-times"></i></div>
        <div class="popup-inner">
            <div class="overlay-layer"></div>
                <div class="search-form">
                    <fieldset>
                        <form role="search" method="get" action="<?php echo esc_url(home_url( '/' )); ?>">
	                        <input type="search" class="search" placeholder="<?php echo esc_attr__( 'Search...', 'creote' ); ?>" value="<?php echo get_search_query() ?>" name="s" title="Search" />
	                        <button type="submit" class="sch_btn"> <i class="icon-search"></i></button>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
 <?php
}

/*
=============================================================
contact popup
=============================================================
*/
function creote_contact_popup() { ?>
<div id="contact-popup" class="contact-popup">
  <div class="close-contact-popup">
      <i class="fas  fa-times"></i>
  </div>
  <div class="contact-popup-inner">
      <div class="overlay-layer"></div>
  </div>
</div>
<?php }
/*
=============================================================
get icon
=============================================================
*/
if (!function_exists('creote_get_theme_side_icon_two')):
    function creote_get_theme_side_icon_two(){ 
		$get_icon_data = get_transient('creote_get_theme_side_icon_two');
		if (empty($get_icon_data)) {
            global $wp_filesystem;
		    require_once(ABSPATH . '/wp-admin/includes/file.php');
		    WP_Filesystem();
            $file = get_template_directory() . '/assets/css/font-awesome.min.css';
            $theme_pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s*{\s*content/';
            $theme_subject = $wp_filesystem->get_contents( $file );
            preg_match_all($theme_pattern, $theme_subject, $theme_matches, PREG_SET_ORDER);
            $theme_icons = array();
            foreach($theme_matches as $theme_matche):
                $theme_icons[] = array('value' => 'fab fa fas '.$theme_matche[1], 'label' => 'fab '.$theme_matche[1]);
            endforeach;
             //Font Two
            $filetwos = get_template_directory() . '/assets/css/icomoon.css';
            $theme_patterntwo = '/\.(icon-(?:\w+(?:-)?)+):before\s*{\s*content/';
            $theme_subjectwo = $wp_filesystem->get_contents( $filetwos );
            preg_match_all($theme_patterntwo, $theme_subjectwo, $theme_matchestwo, PREG_SET_ORDER);
            foreach($theme_matchestwo as $theme_match):
                $theme_icons[] = array('value' => 'icon '.$theme_match[1], 'label' => 'icon '.$theme_match[1]);
            endforeach;
        $theme_icons = array_column($theme_icons, 'label', 'value');
        //print_r($icons); exit('hellow');
        return $theme_icons;
    }
}
endif;

/*
=============================================================
creote rende content Mega Menu
=============================================================
*/
function creote_render_content($post_id){
    global $creote_theme_mod;
    $content  = '';
    $select_mega_menus = !empty($creote_theme_mod['select_mega_menus']) ? $creote_theme_mod['select_mega_menus'] : '';
    if (!empty($select_mega_menus == 'elementor_mega_menu')){
        if(is_plugin_active('elementor/elementor.php')){
		    $content = Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $post_id );
        }
	}elseif(!empty($select_mega_menus == 'wp_bakery_mega_menu')){
        $content = do_shortcode(get_the_content( null, false, $post_id ));
    }
	return $content;
}
if (!function_exists('creote_footer_query')) {
	function creote_footer_query($post_type){

		$post_list = get_posts(array(
			'post_type' => $post_type,
			'showposts' => -1,
		));
		$posts = array();

		if (!empty($post_list) && !is_wp_error($post_list)) {
			foreach ($post_list as $post) {
				$options[$post->ID] = $post->post_title;
			}
			return $options;
		}

	}
}

if (!function_exists('creote_header_query')) {
	function creote_header_query($post_type){
        $post_list = get_posts(array(
			'post_type' => $post_type,
			'showposts' => -1,
		));
		$posts = array();
		if (!empty($post_list) && !is_wp_error($post_list)) {
			foreach ($post_list as $post) {
				$options[$post->ID] = $post->post_title;
			}
			return $options;
		}
    }
}

/*
=============================================================
creote footer sticky enable
=============================================================
*/
function creote_footer_sticky_enable_footer(){
    global $creote_theme_mod;
    $footer_sticky_foo = '';
    if(isset($creote_theme_mod['footer_sticky_enable']) == true){
        $footer_sticky_foo = 'footer_sticky_enable_foo';
    }
    if(is_singular() && get_post_meta(get_the_ID() , 'custom_footer_sticky', true)){
        $footer_sticky_foo = 'footer_sticky_enable_foo';
    }
    elseif(is_page() && get_post_meta(get_the_ID() , 'custom_footer_sticky', true)){
        $footer_sticky_foo = 'footer_sticky_enable_foo';
    }
    elseif(is_singular('service') && get_post_meta(get_the_ID() , 'custom_footer_sticky', true)){
        $footer_sticky_foo = 'footer_sticky_enable_foo';
    }
    elseif(is_singular('project') && get_post_meta(get_the_ID() , 'custom_footer_sticky', true)){
        $footer_sticky_foo = 'footer_sticky_enable_foo';
    }
    elseif(is_singular('product') && get_post_meta(get_the_ID() , 'custom_footer_sticky', true)){
        $footer_sticky_foo = 'footer_sticky_enable_foo';
    }
    else{
        $footer_sticky_foo = 'no_footer_sticky_enable_foo';
    }
    echo esc_attr($footer_sticky_foo);
}



function creote_footer_sticky_for_body_class(){
    global $creote_theme_mod;
    $footer_sticky_body = '';
    if(isset($creote_theme_mod['footer_sticky_enable']) == true){
        $footer_sticky_body = 'footer_sticky_body';
    }
    if(get_post_meta(get_the_ID() , 'custom_footer_sticky', true)){
        $footer_sticky_body = 'footer_sticky_body';
    }
    else{
        $footer_sticky_body = 'no_footer_sticky_body';
    }
    return $footer_sticky_body;
}
 /*
=========================
corona preloader
========================
*/
function creote_fonts_url() {
   
    $font_url = '';

    $spartan = _x( 'on', 'Spartan font: on or off', 'creote' );
     
    /* Translators: If there are characters in your language that are not
    * supported by Open Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    $inter = _x( 'on', 'Inter font: on or off', 'creote' );
    if ( 'off' !== $spartan || 'off' !== $inter ) {
    $font_families = array();
     
    if ( 'off' !== $spartan ) {
    $font_families[] = 'Spartan:400,500,600,700,800,900';
    }
    if ( 'off' !== $inter ) {
    $font_families[] = 'Inter:300,400,500,600,700,800,900';
    }
    $query_args = array(
        'family' => urlencode( implode( '|', $font_families ) ),
        'subset' => urlencode( 'latin,latin-ext' ),
    );
     
    $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }
 
     
    return esc_url_raw( $fonts_url );
}
 /*
=========================
corona page title
========================
*/
add_action('get_creote_choose_tag' , 'creote_choose_tag');
function creote_choose_tag(){
    global $creote_theme_mod;
    $title_text = get_post_meta(get_the_ID() , 'page_header_title', true); 
 ?>
 <?php if(!empty($creote_theme_mod['slect_page_header_title_tag'] == 'h1')): ?>
  <h1 class="title_page">
  <?php the_archive_title('<span class="main_tit">', '</span>'); ?>
    <?php if(!empty($title_text)): ?>
        <small class="extra_tit"> <?php echo  do_shortcode(wp_kses($title_text , wp_kses_allowed_html('post'))); ?> </small>
    <?php endif; ?>
  </h1>
  <?php elseif(!empty($creote_theme_mod['slect_page_header_title_tag'] == 'h2')): ?>
  <h2 class="title_page">
  <?php the_archive_title('<span class="main_tit">', '</span>'); ?>
    <?php if(!empty($title_text)): ?>
        <small class="extra_tit"> <?php echo  do_shortcode(wp_kses($title_text , wp_kses_allowed_html('post'))); ?> </small>
    <?php endif; ?>
  </h2>
  <?php elseif(!empty($creote_theme_mod['slect_page_header_title_tag'] == 'h3')): ?>
  <h3 class="title_page">
  <?php the_archive_title('<span class="main_tit">', '</span>'); ?>
    <?php if(!empty($title_text)): ?>
        <small class="extra_tit"> <?php echo  do_shortcode(wp_kses($title_text , wp_kses_allowed_html('post'))); ?> </small>
    <?php endif; ?>
  </h3>
  <?php elseif(!empty($creote_theme_mod['slect_page_header_title_tag'] == 'h4')): ?>
  <h4 class="title_page">
  <?php the_archive_title('<span class="main_tit">', '</span>'); ?>
    <?php if(!empty($title_text)): ?>
        <small class="extra_tit"> <?php echo  do_shortcode(wp_kses($title_text , wp_kses_allowed_html('post'))); ?> </small>
    <?php endif; ?>
  </h4>
  <?php elseif(!empty($creote_theme_mod['slect_page_header_title_tag'] == 'h5')): ?>
  <h5 class="title_page">
  <?php the_archive_title('<span class="main_tit">', '</span>'); ?>
    <?php if(!empty($title_text)): ?>
        <small class="extra_tit"> <?php echo  do_shortcode(wp_kses($title_text , wp_kses_allowed_html('post'))); ?> </small>
    <?php endif; ?>
  </h5>
  <?php elseif(!empty($creote_theme_mod['slect_page_header_title_tag'] == 'h6')): ?>
  <h6 class="title_page">
  <?php the_archive_title('<span class="main_tit">', '</span>'); ?>
    <?php if(!empty($title_text)): ?>
        <small class="extra_tit"> <?php echo  do_shortcode(wp_kses($title_text , wp_kses_allowed_html('post'))); ?> </small>
    <?php endif; ?>
  </h6>
  <?php elseif(!empty($creote_theme_mod['slect_page_header_title_tag'] == 'div')): ?>
  <div class="title_page">
  <?php the_archive_title('<span class="main_tit">', '</span>'); ?>
    <?php if(!empty($title_text)): ?>
        <small class="extra_tit"> <?php echo  do_shortcode(wp_kses($title_text , wp_kses_allowed_html('post'))); ?> </small>
    <?php endif; ?>
  </div>
  <?php endif; ?>
 <?php
 }