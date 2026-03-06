<?php
/*
 *=================================
 * calling post meta.
 * @package Creote WordPress Theme
 *==================================
*/

/*
=========================
Creote Category
========================
*/
if(!function_exists('creote_category')):
    function creote_category(){
      $categories = get_the_category();
      if(!empty( $categories)){
          echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="categories"><i class="icon-folder"></i>' . esc_html( $categories[0]->name ) . '</a>';
      } 
    }
endif;
/*
=========================
Creote Category
========================
*/
if(!function_exists('creote_category_two')):
  function creote_category_two(){
    $categors = get_the_category();
    if(!empty($categors)){
      echo '<div class="category"><a href="' . esc_url( get_category_link( $categors[0]->term_id ) ) . '" class="categors"><i class="icon-folder"></i>' . esc_html( $categors[0]->name ) . '</a></div>';
    }
  }
endif;

/*
=========================
Get Comments
========================
*/
if(!function_exists('creote_comments')):
function creote_comments(){
?>
<div class="comments">
  <i class="icon-text"></i>
  <?php echo comments_popup_link( 
    esc_html__( 'Post Comment', 'creote' ), 
    esc_html__( '1 Comment', 'creote' ), 
    esc_html__( '% Comments', 'creote' ),
    esc_html__( 'Comments are Closed', 'creote' )
  ); ?>   
  </div>
  <?php 
}
endif;


/*
=========================
Get tags and share
========================
*/
if(!function_exists('creote_tags_and_share')):
  function creote_tags_and_share()
  { global $creote_theme_mod;
    $tags = get_the_tags();
          ?>
            <div class="tags_and_share <?php if((!empty($tags)) && (!empty($creote_theme_mod['tag_disable']) == true)):?> yes_tags <?php endif; ?> <?php  if(!empty($creote_theme_mod['share_disable']) == true):?> yes_share <?php endif; ?>">
              <div class="d-flex">
           
                  <?php if(!empty($creote_theme_mod['tag_disable']) == true):?>
                    <?php 
              if(!empty($tags)): ?>
                    <div class="tags_content left_one">
         
                <div class="box_tags_psot">
              <div class="title"><?php echo esc_html__('Tags' , 'creote'); ?></div>
             <?php
               foreach ($tags as $tag):?>
                <a class="btn" href="<?php echo get_term_link($tag); ?>"><?php echo esc_html__('#' , 'creote');?><?php echo esc_attr($tag->name); ?></a>
              <?php endforeach; ?>
              </div>
              </div>
              <?php endif;?>
              
              <?php endif;?>
               <?php if(!empty($creote_theme_mod['share_disable']) == true): ?>
                  <div class="share_content right_one">
                        <?php do_action('creote_get_share_options_one'); ?>
                  </div>
                  <?php endif;?>
            </div></div>
      <?php 
}
endif;

/*
=========================
Get comment tminig 
========================
*/
if(!function_exists('creote_comment_timing')):
  function creote_comment_timing() { 
      $comment_date = get_comment_time('U');
      $dayscommnet = round((date('U') - get_comment_time('U')) / (60*60*24));
      $deltacomment = time() - $comment_date;
      if( $deltacomment < 60 ) {
          echo esc_html__('Less than a minute ago' , 'creote');
      }
      elseif($deltacomment > 60 && $deltacomment < 120){
          echo esc_html__('About a minute ago' , 'creote');
      }
      elseif($deltacomment > 120 && $deltacomment < (60*60)){
          echo strval(round(($deltacomment/60),0)), ' minutes ago';
      }
      elseif($deltacomment > (60*60) && $deltacomment < (120*60)){
          echo esc_html__('About an hour ago' , 'creote');
      }
      elseif($deltacomment > (120*60) && $deltacomment < (24*60*60)){
          echo strval(round(($deltacomment/3600),0)), ' hours ago';
      }
      else {
          echo  get_comment_date();
      }
}
endif;

 
/*
=========================
blog-meta-for-type-one
========================
*/
if (!function_exists('creote_blog_meta_for_type_one')):
  function creote_blog_meta_for_type_one()
  {
      $time_string = '<time class="date published updated" datetime="%1$s">%2$s</time>';
      if (get_the_time('U') !== get_the_modified_time('U'))
      {
          $time_string = '<time class="date published" datetime="%1$s">%2$s</time>';
      }
      $time_string = sprintf($time_string, esc_attr(get_the_date('c')) , esc_html(get_the_date('j M , Y ')));
      $posted_on = '<a href="' . esc_url(get_permalink()) . '" rel="bookmark"><i class="far  fa-calendar"></i>' . $time_string . '</a>';

      $author_id = get_the_author_meta( 'ID' );
  
      $allowed_tags = wp_kses_allowed_html('post');
  ?>
      <ul class="post-info clearfix">
          <li class="authour_name"><i class="far fa-user"></i><a href="<?php get_the_author_meta( 'url', $author_id ); ?>"> <?php the_author(); ?> </a> </li>
          <li class="date">  <?php echo wp_kses($posted_on , $allowed_tags); ?> </li> 
      </ul>
<?php }
endif;
 
/*
=========================
blog-meta-type-two
========================
*/
if (!function_exists('creote_blog_meta_for_type_two')):
  function creote_blog_meta_for_type_two()
  {
      $time_string = '<time class="date published updated" datetime="%1$s">%2$s</time>';
      if (get_the_time('U') !== get_the_modified_time('U'))
      {
          $time_string = '<time class="date published" datetime="%1$s">%2$s</time>';
      }
      $time_string = sprintf($time_string, esc_attr(get_the_date('c')) , esc_html(get_the_date('j M , Y ')));
      $posted_on = '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>';

      $author_id = get_the_author_meta( 'ID' );
      
      $allowed_tags = wp_kses_allowed_html('post');
       ?>
  <div class="authour_details">
    <h6><a href="<?php get_the_author_meta( 'url', $author_id ); ?>"> <?php the_author(); ?> </a> </h6>
    <p>  <?php echo wp_kses($posted_on  , $allowed_tags); ?> </p>
  </div><?php
  }
endif;
/*-----------blog-meta-type-classic-------------*/