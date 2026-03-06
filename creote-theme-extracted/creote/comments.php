<?php
/*
 *=================================
 * The Comment template file .
 * @package Creote WordPress Theme
 *==================================
*/
/*
 * ifthe current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if( post_password_required() ) {
	return;
}


?>
 <div class="sec_comments padding-t-8 padding-b-3" id="comment">
        <div class="container_no">
        <div class="row justify-content-center">
            <div class="col-lg-12">
             

                    <?php // You can start editing here -- including this comment! ?>

                    <?php if(have_comments() ) : ?>
                        <div class="comment_box">
                    <div class="title_commnt">
                  <h2>   <?php echo comments_popup_link( 
                esc_html__( '0 Comments', 'creote' ), 
                esc_html__( '1 Comment', 'creote' ), 
                esc_html__( '% Comments', 'creote' ),
                esc_html__( 'Comments are Closed', 'creote' )
            ); ?></h2>
                </div>
                    <?php if(get_comment_pages_count() > 1 && get_option( 'page_comments' )) : // Are there comments to navigate through? ?>
                    <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
                        <h2 class="screen-reader-text">
                            <?php esc_html_e( 'Comment navigation', 'creote' ); ?>
                        </h2>
                        <div class="nav-links">

                            <div class="nav-previous">
                                <?php previous_comments_link( esc_html__( 'Older Comments', 'creote' ) ); ?>
                            </div>
                            <div class="nav-next">
                                <?php next_comments_link( esc_html__( 'Newer Comments', 'creote' ) ); ?>
                            </div>

                        </div>
                        <!-- .nav-links -->
                    </nav>
                    <!-- #comment-nav-above -->
                    <?php endif; // Check for comment navigation. ?>
                    <div class="comment_inner body_commnt">
                        <ol class="comment-list">
                            <?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 65,
				'callback'    => 'creote_comment'
			) );
			?>
                        </ol>
                        <!-- .comment-list -->
                    </div>
                    <?php if( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
                    <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                        <h2 class="screen-reader-text">
                            <?php esc_html_e( 'Comment navigation', 'creote' ); ?>
                        </h2>
                        <div class="nav-links">
                            <div class="nav-previous">
                                <?php previous_comments_link(esc_html__( 'Older Comments', 'creote')); ?>
                            </div>
                            <div class="nav-next">
                                <?php next_comments_link( esc_html__( 'Newer Comments', 'creote')); ?>
                            </div>
                        </div>
                        <!-- .nav-links -->
                    </nav>
                    <!-- #comment-nav-below -->
                    <?php endif; // Check for comment navigation. ?>
                    <?php endif; // Check for have_comments(). ?>
                    <?php
	// ifcomments are closed and there are comments, let's leave a little note, shall we?
	if( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
                        <p class="no-comments">
                            <?php esc_html_e( 'Comments are closed.', 'creote' ); ?>
                        </p>
                        </div>
                        <?php endif; ?>

           
                <?php     $args = array(
		
        'label_submit'          => esc_html__( 'Post  comment', 'creote' ),
        'title_reply' =>  esc_html__( 'Post a comment', 'creote' ),
        'comment_notes_before'=>  '<p class="title_para">'.esc_html__( 'Your email address will not be published.', 'creote' ).'</p>',
		'comment_field'         =>  '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Leave a Reply', 'creote' ) . '</label><textarea placeholder="' . esc_attr__( 'Write your comment here...', 'creote' ) . '" id="comment" name="comment"  rows="12" aria-required="true">' .
		                    '</textarea></p>'
	);
	comment_form( $args );
	?>
            </div>
        </div>   
    </div>
    </div>      