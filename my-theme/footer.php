                    <?php  global $creote_theme_mod; ?>
                  </div>
                </div>
              </div>
            </div>

            <?php do_action( 'creote_elementor_footer' ); ?>
            <?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) { ?>
          <?php  get_template_part('template-parts/footer/default', 'footer');  ?>
          <?php } ?>
       
       
          <?php // mobile nav ?>
            <?php do_action('get_creote_mobile_menu'); ?>
        <?php // mobile nav ?>
        <?php   // search popupp ?>
            <?php  creote_search_popup(); ?>
        <?php ?>
        <?php   // Modal popupp ?>
          <?php if(!empty($creote_theme_mod['modal_box_enable']) == true):  do_action('modal_box_one'); endif; ?>
        <?php ?>
        <?php if(class_exists('woocommerce')):
          creote_mini_cart();
          endif; ?>
        <div class="cart_notice"></div>
    <div class="wcqv_contend"> </div>

    <?php do_action('back_to_top_enable'); ?>

    </div>

<?php wp_footer(); ?>
</body>
</html>