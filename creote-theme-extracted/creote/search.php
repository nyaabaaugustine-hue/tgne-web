<?php get_header(); ?>
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) { ?>
<div id="primary" class="content-area blog_masonry col-lg-8 m-auto">
    <main id="main" class="site-main">
        <div class="row loop-grid">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'post_type' => array('post', 'page', 'product' , 'service' , 'project'),
                's' => get_search_query(),
                'paged' => $paged
            );
            $query = new WP_Query($args);
            
            if ($query->have_posts()):
                ?>
                <div class="search-form search_file text-center mb-30">
                    <?php do_action('creote_get_simple_search'); ?>
                </div>
                <?php
                while ($query->have_posts()):
                    $query->the_post();
                    get_template_part('template-parts/content', 'search');
                endwhile;
                
                // Pagination
				  // Pagination with custom HTML and no next/prev text
				  $big = 999999999; // need an unlikely integer
				  $pagination = paginate_links(array(
					  'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
					  'format' => '?paged=%#%',
					  'current' => max(1, get_query_var('paged')),
					  'total' => $query->max_num_pages,
					  'type' => 'array',
					  'prev_text' => '&laquo;', // Left arrow
					  'next_text' => '&raquo;', // Right arrow
				  ));
				  
				  if ($pagination) {
					  echo '<div class="pagination_wrapper">';
					  echo '<ul class="pagination">';
					  foreach ($pagination as $page_link) {
						  echo '<li class="page-item">' . $page_link . '</li>';
					  }
					  echo '</ul>';
					  echo '</div>';
				  }
				  

                
                wp_reset_postdata();
            else:
                get_template_part('template-parts/content', 'none');
            endif;
            ?>
        </div>
    </main>
</div>
<?php } ?>
<?php get_footer(); ?>