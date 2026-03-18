<?php
/*
 *=================================
 * Custom functions for breadcrumbs.
 * @package Creote WordPress Theme
 *==================================
*/
add_action('creote_get_numeric_posts_nav' , 'creote_numeric_posts_nav');
function creote_numeric_posts_nav() {
    if(is_singular())
        return;
    global $wp_query;
    /** Stop execution ifthere's only 1 page */
    if($wp_query->max_num_pages <= 1 )
        return;
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
    /** Add current page to the array */
    if($paged >= 1)
        $links[] = $paged;
    /** Add the pages around the current page to the array */
    if($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
    if(( $paged + 2) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
    echo '<nav aria-label="Page navigation example"><ul class="pagination text-center">' . "\n";
    /** Previous Post Link */
    if( get_previous_posts_link() )
        printf( '<li class="prev_link">%s</li>' . "\n", get_previous_posts_link('<div class="nav-previous"><i class="fas fa-angle-left"></i></div>') );
 
    /** Link to first page, plus ellipses ifnecessary */
    if( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';
 
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
 
        if( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }
    /** Link to current page, plus 2 pages in either direction ifnecessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }
    /** Link to last page, plus ellipses ifnecessary */
    if( ! in_array( $max, $links ) ) {
        if( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";
 
        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
    /** Next Post Link */
    if( get_next_posts_link() )
        printf( '<li class="next_link">%s</li>' . "\n", get_next_posts_link('<div class="nav-next"><i class="fas fa-angle-right"></i></div>') );
    echo '</ul></nav>' . "\n";
}
/*
=========================
creote_image_nav_links
========================
*/
add_action('creote_entry_nav_footer', 'creote_image_nav_links', 25 );
function creote_image_nav_links() {
$previous = get_previous_post();
$next = get_next_post();
if(is_singular('post')): ?>
<div class="previouse_next_post">
    <ul class="clearfix">
        <?php if($prev_post = get_previous_post()): ?>
            <li class="first-child">
                <div class="prev_post  blp">
                    <a href="<?php echo get_permalink( $prev_post->ID ); ?>"  class="arrow">  <i class="icon-right-arrow"></i></a>
                        <div class="text">
                            <p><?php esc_html_e('Previous Post', 'creote') ?> </a></p>
                            <?php if(get_previous_post()): ?>
                                <h2><a href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo get_the_title($previous) ?></a></h2>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
            <?php endif;  ?>
            <?php if($next_post = get_next_post()): ?>
                <li class="second-child">
                    <div class="next_post  blp">
                        <a href="<?php echo get_permalink( $next_post->ID ); ?>" class="arrow"><i class="icon-right-arrow"></i></a>
                            <div class="text">
                                <p><?php esc_html_e('Next Post', 'creote') ?> </p>
                                <?php if(get_next_post()): ?>
                                    <h2><a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo get_the_title($next) ?></a></h2>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endif; ?> 
            </ul>
        </div>
    <?php endif; 
} 
