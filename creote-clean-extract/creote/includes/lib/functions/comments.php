<?php
/*
 *=================================
 * Custom functions for displaying comments
 * @package Creote WordPress Theme
 *==================================
*/
/**
 * Comment callback function
 * @param object $comment
 * @param array  $args
 * @param int    $depth
**/
function creote_comment($comment, $args, $depth) {
    if('div' === $args['style']):
        $tag       = 'div';
        $add_below = 'comment';
    else: 
        $tag       = 'li';
        $add_below = 'div-comment';
    endif;?>
    <<?php echo esc_attr($tag); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>">
    <?php 
    if('div' != $args['style']): ?>
        <div id="div-comment-<?php comment_ID(); ?>" class="comments-outer  clearfix">
        <div class="inner-coment item_commnt one clearfix"><?php
    endif; ?>
    <div class="media">
        <?php if( $args['avatar_size'] != 0 ):
            echo get_avatar( $comment, $args['avatar_size'] ); 
        endif; ?>
        <div class="comment-text">
            <div class="txt">
                <h3 class="name"> <?php comment_author(); ?></h3>
                <span class="date"><?php creote_comment_timing();?></span>
                <?php if($comment->comment_approved == '0'): ?>
                 	<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'creote' ); ?><br/></em><?php 
                endif; ?>
                <p class="content"><?php echo get_comment_text(); ?></p>
                    <div class="reply">
                        <p><i class="icon-share-1"></i>
                            <?php comment_reply_link( 
                                array_merge( 
                                    $args, 
                                        array( 
                                            'add_below' => $add_below, 
                                            'depth'     => $depth, 
                                            'max_depth' => $args['max_depth'],
                                        ) 
                                    ) 
                                ); ?>
                        </p>
                        <p><?php edit_comment_link(esc_html__( 'Edit', 'creote' ), '  ', '' ); ?></p>
                    </div>
                </div> 
            </div>
<?php if('div' != $args['style']): ?>
        </div>
    </div>
</div>
<?php endif;
}
/*
=========================
Custom comment form
========================
*/
function creote_comment_form( $fields ) {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $fields['url'] = '<p class="comment-form-url">    <label for="name">' . esc_html__( 'Website Url', 'creote' ) . '</label>
    <input id="url" name="url" placeholder="' . esc_attr__( 'ex. www.example.com', 'creote' ) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /> ' .
  '</p>';
    $fields['email'] = '<p class="comment-form-email">
    <label for="comment">' . esc_html__( 'Email address', 'creote' ) . '</label>
		<input id="email" placeholder="' . esc_attr__( 'ex. john@mail.com', 'creote' ) . '" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
	 '" size="30"' . $aria_req . ' />'  .'</p>';
    $fields['author'] = '<p class="comment-form-author">
    <label for="name">' . esc_html__( 'Full Name', 'creote' ) . '</label>
        <input id="author" placeholder="' . esc_attr__( 'ex. John Doe', 'creote' ) . '" name="author" type="text" value="' .
      esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />'.
      '</p>';                                               
    $fields['cookies'] = ' <p class="custom-control custom-checkbox">
  <input id="wp-comment-cookies-consent"  class="custom-control-input" name="wp-comment-cookies-consent" type="checkbox" value="">
  <label  class="custom-control-label pl-1 c-gray" for="wp-comment-cookies-consent">
  '.esc_html__('Save my name, and email in this browser for the next time I comment.' , 'creote') .' '. '</label></p>';
	$fields['clear'] = '<div class="clearfix"></div>';
	return $fields;
}
add_filter('comment_form_default_fields','creote_comment_form'); 