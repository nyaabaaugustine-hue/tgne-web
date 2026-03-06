<?php
/*
====================
creote Menu Option
====================
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class creote_Admin {
	function __construct() {
		// Register walker replacement
		add_action('wp_update_nav_menu_item', array( $this, 'creote_save_custom_fields' ), 10, 3 );		
		add_action( 'wp_nav_menu_item_custom_fields',   array( $this, 'creote_custom_menu_field'), 10 , 4 );
		if ( is_admin() ) {
		add_action( 'admin_enqueue_scripts', array( $this, 'adminscripts'));
		}
	}
	/*
	==========================================
		admin js
	==========================================
	*/
	public function adminscripts() {
		global $pagenow;	
		wp_enqueue_media();
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		if('nav-menus.php' == $pagenow ) {
			wp_enqueue_script( 'creote-admin-menu', get_template_directory_uri() . '/includes/admin/js/admin-menu.js');
		}
	}
	/*
	==========================================
		Save Fields
	==========================================
	*/
	public function creote_save_custom_fields($menu_id, $menu_item_db_id, $args){
		$creote_fields = array(
			'show_as_megamenu' ,
			'show_bagde',
			'badge_item',
			'badge_color',
			'badge_bg_color',
			'megamenu_select',
			'image_type' ,
			'menu_image',
			'columnsizes' ,
			'dropalign' ,
			'dp_width' , 
			'dp_move' , 
		);

		foreach ( $creote_fields as $key ) {
			$creotevalue = isset($_REQUEST['menu-item-'.$key][$menu_item_db_id]) ? $_REQUEST['menu-item-'.$key][$menu_item_db_id] : '';
			update_post_meta( $menu_item_db_id, 'creote_menu_item_'.$key, $creotevalue );
		}
	}
	/*
	==========================================
		Save Fields
	==========================================
	*/
	public function creote_custom_menu_field($item_id, $item, $depth, $args ){
		$show_as_megamenu  	= 	get_post_meta( $item_id, 'creote_menu_item_show_as_megamenu',  true );
		$show_bagde  		= 	get_post_meta( $item_id, 'creote_menu_item_show_bagde',  true );
		$badge_item  		= 	get_post_meta( $item_id, 'creote_menu_item_badge_item',  true ); 
		$badge_color  		= 	get_post_meta( $item_id, 'creote_menu_item_badge_color',  true ); 
		$badge_bg_color 	= 	get_post_meta( $item_id, 'creote_menu_item_badge_bg_color',  true ); 
		$megamenu_select	= 	get_post_meta( $item_id, 'creote_menu_item_megamenu_select', true );
		$image_type 		= 	get_post_meta( $item_id, 'creote_menu_item_image_type', true );
		$menu_image 		= 	get_post_meta( $item_id, 'creote_menu_item_menu_image', true );
		$columnsizes  		= 	get_post_meta( $item_id, 'creote_menu_item_columnsizes',  true );
		$dropalign  		= 	get_post_meta( $item_id, 'creote_menu_item_dropalign',  true ); 
		$dp_width  			= 	get_post_meta( $item_id, 'creote_menu_item_dp_width',  true );  
		$dp_move  			= 	get_post_meta( $item_id, 'creote_menu_item_dp_move',  true ); 
		$megamenu_hide_show = ($show_as_megamenu != 'enabled') ? 'hidden-field' : '';
		$notmegamenu_hide_show = ($show_as_megamenu == 'enabled') ? 'hidden-field' : '';
		$badge_hide_show = ($show_bagde != 'enabled') ? 'hidden-field' : '';
		?>
		<div class="creote_column_half_menu top_badge_megamenu_box">
			<p class="description-wide badgetext_desc creote_same_call">
			<br><br>
				<label for="label-badge-check-item-<?php echo esc_attr($item_id); ?>">
				<?php _e( 'Enable Badge', 'creote' ); ?>
				<input type="checkbox" id="badge-check-item-<?php echo esc_attr($item_id); ?>" name="menu-item-show_bagde[<?php echo esc_attr($item_id); ?>]" class="badge-enable-oncheck" value="enabled" <?php checked($show_bagde,'enabled')?> />
				</label>
			</p>
			<p class="description description-wide badge_enabledisable_box badgetext_desc creote_same_call <?php echo esc_attr($badge_hide_show);?>">
				<label class="description" for="edit-menu-item-badge-text-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Badge', 'creote' ); ?>
				<br>
				<input type="text" id="badge_item" name="menu-item-badge_item[<?php echo esc_attr($item_id); ?>]" class="widefat" value="<?php echo esc_attr($badge_item); ?>" placeholder="<?php esc_attr_e( 'HOT', 'creote' ); ?>" />
				</label>
			</p>
			<div class="clearfix badge_colors">
			<p class="description-wide creote_same_call badge_enabledisable_box <?php echo esc_attr($badge_hide_show);?>">
				<label class="description" for="edit-menu-item-badge-text-color-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Badge Text Color', 'creote' ); ?>		</label>
				<br>
				<input type="text" id="badge_item_color" name="menu-item-badge_color[<?php echo esc_attr($item_id); ?>]" class="creotemenubger-color-box" value="<?php echo esc_attr($badge_color); ?>" />
			</p>
			<p class="description-wide creote_same_call badge_enabledisable_box <?php echo esc_attr($badge_hide_show);?>">
				<label class="description" for="edit-menu-item-badge-text-bg-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Badge Background Color', 'creote' ); ?>			</label>	
				<br>
				<input type="text" id="badge_bg_color" name="menu-item-badge_bg_color[<?php echo esc_attr($item_id); ?>]" class="creotemenubger-color-box" value="<?php echo esc_attr($badge_bg_color); ?>" />
			</p>
			</div>
			<?php if($item->menu_item_parent == '0' ): ?>
			<p class="description-wide  creote_same_call">
				<label for="menu-item-<?php echo esc_attr($item_id); ?>"><?php _e( 'Enable Mega Menu', 'creote' ); ?> </label>
				<input type="checkbox" id="menu-item-<?php echo esc_attr($item_id); ?>" name="menu-item-show_as_megamenu[<?php echo esc_attr($item_id); ?>]" class="megamenu-enable-oncheck"  value="enabled" <?php checked($show_as_megamenu,'enabled')?> />
			</p>
			<p class="description-wide creote_same_call megamenu_enabledisable_box  <?php echo esc_attr($megamenu_hide_show);?>">
				<label class="description"><?php esc_html_e( 'Megamenu Select', 'creote' ); ?>
				<?php $pageslist = get_posts(
						array(
							'post_type'      => 'mega_menu',
							'posts_per_page' => -1,
						)
					);
				?>
				<select name="menu-item-megamenu_select[<?php echo esc_attr( $item_id ); ?>]" id="megamenu-select">
							<option value=""><?php esc_html_e( 'Select Template', 'creote' ); ?></option>
							<?php if(!empty($pageslist)) {
								foreach ( $pageslist as $page ) {
									if ( ! empty( $megamenu_select ) && $megamenu_select == $page->ID ) {
										echo '<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';
									} else {
										echo '<option value="' . $page->ID . '">' . $page->post_title . '</option>';
									}
								}
							}
						?>
						</select>
					</label>
				</p>
				

			<?php endif; ?>
			<?php if($item->menu_item_parent == '0' ): ?>
				<p class="description-wide creote_same_call notmegamenu_enabledisable_box <?php echo esc_attr($notmegamenu_hide_show);?>">
					<label class="description"><?php esc_html_e( 'Dropdown Column', 'creote' ); ?>
						<select id="edit-menu-item-column-size-<?php echo esc_attr( $item_id ); ?>"  class="widefat creote-menu-columnsize" name="menu-item-columnsizes[<?php echo esc_attr( $item_id ); ?>]">
							<option value="default" <?php selected( esc_attr( $columnsizes ), 'default', true); ?>><?php esc_html_e('Select Column', 'creote'); ?></option>
							<option value="two_column" <?php selected( esc_attr( $columnsizes ), 'two_column', true); ?>><?php esc_html_e('Two Column', 'creote'); ?></option>
							<option value="three_column" <?php selected( esc_attr( $columnsizes ), 'three_column', true); ?>><?php esc_html_e('Three Column', 'creote'); ?></option>
							<option value="four_column" <?php selected( esc_attr( $columnsizes ), 'four_column', true); ?>><?php esc_html_e('Four Column', 'creote'); ?></option>
							<option value="five_column" <?php selected( esc_attr( $columnsizes ), 'five_column', true); ?>><?php esc_html_e('Five Column', 'creote'); ?></option>
						</select>
					</label>
				</p>
				<p class="description-wide creote_same_call">
					<label class="description"><?php esc_html_e( 'Dropdown Right or Left', 'creote' ); ?>	</label>
					<br>
					<select id="edit-menu-item-dropalign-<?php echo esc_attr( $item_id ); ?>"  class="widefat creote-menu-dropalign" name="menu-item-dropalign[<?php echo esc_attr( $item_id ); ?>]">
						<option value="dropdwon_left" <?php selected( esc_attr( $dropalign ), 'dropdwon_left', true); ?>><?php esc_html_e('Dropdown Align Left', 'creote'); ?></option>
						<option value="dropdwon_right" <?php selected( esc_attr( $dropalign ), 'dropdwon_right', true); ?>><?php esc_html_e('Dropdown Align Right', 'creote'); ?></option>
					</select>
				</p>

				<p class="description-wide creote_same_call megamenu_enabledisable_box <?php echo esc_attr($megamenu_hide_show);?>">
					<label class="description"><?php esc_html_e( 'Mega Menu Width', 'creote' ); ?>	</label>
					<br>
					<input type="number" id="drop-<?php echo esc_attr($item_id); ?>" name="menu-item-dp_width[<?php echo esc_attr($item_id); ?>]" class="drop-width" value="<?php echo esc_attr($dp_width); ?>" />
				</p>
				 
				<p class="description-wide creote_same_call dop_ena megamenu_enabledisable_box <?php echo esc_attr($megamenu_hide_show);?> <?php echo esc_attr($dropalign);?>">
					<label class="description"><?php esc_html_e( 'Mega Move Right / Left', 'creote' ); ?>	</label>
					<br>
					<input type="number" id="drop-<?php echo esc_attr($item_id); ?>" name="menu-item-dp_move[<?php echo esc_attr($item_id); ?>]" class="drop-move-right" value="<?php echo esc_attr($dp_move); ?>" />
				</p>
			 
				 
			<?php endif; ?>
			<?php if($depth > 0 ): ?>
				<p class="description-wide creote_same_call">
					<label class="description"><?php esc_html_e( 'Image Style', 'creote' ); ?></label>
					<select id="edit-menu-item-image-type-<?php echo esc_attr( $item_id ); ?>"  class="widefat creote-menu-image_type" name="menu-item-image_type[<?php echo esc_attr( $item_id ); ?>]">
						<option value="img_style_one" <?php selected( esc_attr( $image_type ), 'img_style_one', true); ?>><?php esc_html_e('Image Style One', 'creote'); ?></option>
						<option value="img_style_two" <?php selected( esc_attr( $image_type ), 'img_style_two', true); ?>><?php esc_html_e('Image Style Two', 'creote'); ?></option>
						
					</select>
				</p>
			<?php endif; ?>
			<?php // ============media============== ?>
			<?php // Get WordPress' media upload URL
				$upload_link = esc_url( get_upload_iframe_src( 'image', $item->ID ) );
				$your_img_src = wp_get_attachment_image_src( $menu_image, 'full' );
				$you_have_img = is_array( $your_img_src );
				?>
				<div class="description description-wide jt-bg-image-upload-wrapper">
					<div class="custom-img-container">
						<?php if ( $you_have_img ) : ?>
							<img src="<?php echo esc_attr($your_img_src[0]) ?>" alt="menu-image" style="max-width:100%;" />
						<?php endif; ?>
					</div>

						<!-- Your add & remove image links -->
						<p class="hide-if-no-js">
							<a class="upload-custom-img <?php if ( $you_have_img  ) { echo 'hidden'; } ?>" 
							href="<?php echo esc_attr($upload_link) ?>">
								<?php echo esc_html__('Set custom image' , 'creote'); ?>
							</a>
							<a class="delete-custom-img <?php if ( ! $you_have_img  ) { echo 'hidden'; } ?>" 
							href="#">
								<?php echo esc_html__('Remove this image' , 'creote'); ?>
							</a>
						</p>
					<input class="creote-img-menu-id" name="menu-item-menu_image[<?php echo esc_attr($item->ID); ?>]" type="hidden" value="<?php echo esc_attr( $menu_image ); ?>" />
				</div>
			<?php // ============media============== ?>
			

		</div>
	<?php
	}
}
$obj_creote_admin = new creote_Admin();