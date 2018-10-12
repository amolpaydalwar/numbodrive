<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(class_exists("woocommerce")){	
   
    /*********************************** BEGIN ADD TO CART AJAX ****************************************/

	add_action( 'wp_ajax_add_to_cart', 's7upf_minicart_ajax' );
	add_action( 'wp_ajax_nopriv_add_to_cart', 's7upf_minicart_ajax' );
	if(!function_exists('s7upf_minicart_ajax')){
		function s7upf_minicart_ajax() {
			
			$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
			$quantity = empty( $_POST['quantity'] ) ? 1 : apply_filters( 'woocommerce_stock_amount', $_POST['quantity'] );
			$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

			if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity ) ) {
				do_action( 'woocommerce_ajax_added_to_cart', $product_id );
				WC_AJAX::get_refreshed_fragments();
			} else {
				$this->json_headers();

				// If there was an error adding to the cart, redirect to the product page to show any errors
				$data = array(
					'error' => true,
					'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
					);
				echo json_encode( $data );
			}
			die();
		}
	}
	/*********************************** END ADD TO CART AJAX ****************************************/
	
	/*********************************** BEGIN UPDATE CART AJAX ****************************************/
    
    add_action( 'wp_ajax_update_mini_cart', 's7upf_update_mini_cart' );
    add_action( 'wp_ajax_nopriv_update_mini_cart', 's7upf_update_mini_cart' );
    if(!function_exists('s7upf_update_mini_cart')){
        function s7upf_update_mini_cart() {
            WC_AJAX::get_refreshed_fragments();
            die();
        }
    }
	
    /*********************************** END UPDATE CART  AJAX ****************************************/
	
	/********************************** REMOVE ITEM MINICART AJAX ************************************/

	add_action( 'wp_ajax_product_remove', 's7upf_product_remove' );
	add_action( 'wp_ajax_nopriv_product_remove', 's7upf_product_remove' );
	if(!function_exists('s7upf_product_remove')){
		function s7upf_product_remove() {
		    global $wpdb, $woocommerce;
		    $cart_item_key = $_POST['cart_item_key'];
		    if ( $woocommerce->cart->get_cart_item( $cart_item_key ) ) {
				$woocommerce->cart->remove_cart_item( $cart_item_key );
			}
		    exit();
		}
	}

	/********************************** HOOK ************************************/

	//remove woo breadcrumbs
    add_action( 'init','s7upf_remove_wc_breadcrumbs' );

    // Remove page title
    add_filter( 'woocommerce_show_page_title', 's7upf_remove_page_title');

	// remove action wrap main content
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	
    // Custom wrap main content
    add_action('woocommerce_before_main_content', 's7upf_add_before_main_content', 10);
    add_action('woocommerce_after_main_content', 's7upf_add_after_main_content', 10);
    add_action('woocommerce_before_shop_loop', 's7upf_before_shop_loop', 10);
    add_action('woocommerce_after_shop_loop', 's7upf_after_shop_loop', 10);
	
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
   	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
   	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

   	add_filter( 'woocommerce_get_price_html', 's7upf_change_price_html', 100, 2 );

    if(!function_exists('s7upf_before_shop_loop')){
        function s7upf_before_shop_loop(){
            global $wp_query;
            $type = 'grid';
            if(isset($_GET['type'])){
                $type = $_GET['type'];
            }
            $orderby = 'menu_order';
            if(isset($_GET['orderby'])){
                $orderby = $_GET['orderby'];
            }
            $column = s7upf_get_option('woo_shop_column',4);
            $number = s7upf_get_option('woo_shop_number',6);
            if(isset($_GET['column'])){
                $column = $_GET['column'];
            }
            if(isset($_GET['number'])){
                $number = $_GET['number'];
            }
			
            $size = s7upf_get_option('product_size_thumb');           
            s7upf_shop_loop_before($wp_query,$orderby,$type,$number,$column,$size);
        }
    }

    if(!function_exists('s7upf_after_shop_loop')){
        function s7upf_after_shop_loop(){
            global $wp_query;
			// $paged = ( isset($page) ) ? absint( $page ) : 1;
            s7upf_shop_loop_after($wp_query);
        }
    }

   	if(!function_exists('s7upf_change_price_html')){
    	function s7upf_change_price_html($price, $product){
    		$price = str_replace('&ndash;', '<span class="slipt">&ndash;</span>', $price);
    		$price = '<div class="product-price">'.$price.'</div>';
            $show_mode = s7upf_check_catelog_mode();
            $hide_price = s7upf_get_option('hide_price');
            if($show_mode == 'on' && $hide_price == 'on') $price = '';
    		return $price;
    	}
    }

    function s7upf_add_before_main_content() {
        $col_class = 'shop-width-'.s7upf_get_option('woo_shop_column',4);
        global $product;
        global $count_product;
        $count_product = 1;        
        global $wp_query;
        $cats = '';
		
        if(isset($wp_query->query_vars['product_cat'])) $cats = $wp_query->query_vars['product_cat'];
        ?>
        <div id="main-content" class="shop-page <?php echo esc_attr($col_class);?>">
            <?php 
				
				if(is_product()== false){
					s7upf_header_image();
				}
				echo '<div class="container">';
					woocommerce_breadcrumb(array(
            			'delimiter'		=> '<i>-</i>',
            			'wrap_before'	=> '<div class="bread-crumb">',
            			'wrap_after'	=> '</div>',
            		));
				echo '</div>';	
				s7upf_before_detail_gallery();
			?>
            <div class="container">
                <div class="row">
                	<?php s7upf_output_sidebar('left')?>
                	<div class="<?php echo esc_attr(s7upf_get_main_class()); ?>">
        <?php
    }

    function s7upf_add_after_main_content() {
        ?>
                	</div>
                	<?php s7upf_output_sidebar('right')?>
            	</div>
            </div>
        </div>
        <?php
    }

    function s7upf_remove_wc_breadcrumbs()
    {
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
    } 

    function s7upf_remove_page_title() {
        return false;
    }
	/********************************* END REMOVE ITEM MINICART AJAX *********************************/

	/********************************** FANCYBOX POPUP CONTENT ************************************/

	add_action( 'wp_ajax_product_popup_content', 's7upf_product_popup_content' );
	add_action( 'wp_ajax_nopriv_product_popup_content', 's7upf_product_popup_content' );
	if(!function_exists('s7upf_product_popup_content')){
		function s7upf_product_popup_content() {
			$product_id = $_POST['product_id'];
			$query = new WP_Query( array(
				'post_type' => 'product',
				'post__in' => array($product_id)
				));
			if( $query->have_posts() ):
				echo '<div class="woocommerce single-product product-popup-content"><div class="product has-sidebar">';
				while ( $query->have_posts() ) : $query->the_post();	
					global $post,$product,$woocommerce;			
					s7upf_product_main_detail();
				endwhile;
				echo '</div></div>';
			endif;
			wp_reset_postdata();
		}
	}
	//Custom woo shop column
    add_filter( 'loop_shop_columns', 's7upf_woo_shop_columns', 1, 10 );
    function s7upf_woo_shop_columns( $number_columns ) {
        $col = s7upf_get_option('woo_shop_column',3);
        return $col;
    }
    add_filter( 'loop_shop_per_page', 's7upf_woo_shop_number', 20 );
    function s7upf_woo_shop_number( $number) {
        $col = s7upf_get_option('woo_shop_number',12);
        return $col;
    }
    
    // Add Hook
    // Product Bread Crumb
   
    // Catalog mode
    add_filter( 's7upf_tempalte_mini_cart', 's7upf_tempalte_mini_cart', 100, 2 );
    if(!function_exists('s7upf_tempalte_mini_cart')){
        function s7upf_tempalte_mini_cart($html){
            $show_mode = s7upf_check_catelog_mode();
            $hide_minicart = s7upf_get_option('hide_minicart');
            if($show_mode == 'on' && $hide_minicart == 'on') $html = '';
            return $html;
        }
    }
    add_filter( 'woocommerce_loop_add_to_cart_link', 's7upf_custom_add_to_cart_link' );
    if(!function_exists('s7upf_custom_add_to_cart_link')){
        function s7upf_custom_add_to_cart_link($content){
            $show_mode = s7upf_check_catelog_mode();
            if($show_mode == 'on') $content = '';
            return $content;
        }
    }
    add_action( 's7upf_template_single_add_to_cart', 'woocommerce_template_single_add_to_cart', 30 );
    add_action( 's7upf_template_single_add_to_cart', 's7upf_filter_single_add_to_cart', 20 );
    // Catalog mode function
    if(!function_exists('s7upf_check_catelog_mode')){
        function s7upf_check_catelog_mode(){
            $catelog_mode = s7upf_get_option('woo_catelog');
            $hide_other_page = s7upf_get_option('hide_other_page');
            $hide_detail = s7upf_get_option('hide_detail');
            $hide_admin = s7upf_get_option('hide_admin');
            $hide_shop = s7upf_get_option('hide_shop');
            $hide_price = s7upf_get_option('hide_price');
            $show_mode = 'off';
            if($catelog_mode == 'on'){
                if($hide_other_page == 'on' && !is_super_admin() && !is_shop() && !is_single()) $show_mode = 'on';
                if($hide_other_page == 'on' && $hide_admin == 'on' && is_super_admin() && !is_shop() && !is_single() ) $show_mode = 'on';
                if(is_shop()) {
                    if($hide_shop == 'on' && !is_super_admin()) $show_mode = 'on';
                    if($hide_shop == 'on' && $hide_admin == 'on' && is_super_admin()) $show_mode = 'on';
                }
                if(is_single()) {
                    if($hide_detail == 'on' && !is_super_admin()) $show_mode = 'on';
                    if($hide_detail == 'on' && $hide_admin == 'on' && is_super_admin()) $show_mode = 'on';
                }
            }
            return $show_mode;
        }
    }
    if(!function_exists('s7upf_filter_single_add_to_cart')){
        function s7upf_filter_single_add_to_cart(){
            $show_mode = s7upf_check_catelog_mode();
            if($show_mode == 'on'){
                // S7upf_Assets::add_css('.product-available,.product-code{display:none;}');
                remove_action( 's7upf_template_single_add_to_cart', 'woocommerce_template_single_add_to_cart', 30);
            }
        }
    }

    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
    // remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    add_filter( 'yith_woocompare_remove_compare_link_by_cat', 's7upf_remove_compare_link', 30, 2 );
    if(!function_exists('s7upf_remove_compare_link')){
        function s7upf_remove_compare_link(){
            return true;
        }
    }
	add_action( 'woocommerce_single_product_summary', 's7upf_product_link_single', 20 );
	if ( ! function_exists( 's7upf_product_link_single' ) ) {
        function s7upf_product_link_single($style='',$el_class=''){
            $html = $html_wl = '';
            if(class_exists('YITH_WCWL_Init')) $html_wl = '<li><a href="'.esc_url(str_replace('&', '&amp;',add_query_arg( 'add_to_wishlist', get_the_ID() ))).'" class="add_to_wishlist wishlist-link" rel="nofollow" data-product-id="'.get_the_ID().'" data-product-title="'.esc_attr(get_the_title()).'"><i class="color icon ion-android-favorite-outline"></i><span>'.esc_html__("Add to Wishlist","micar").'</span></a></li>';
            $text = esc_html__("Add to Compare","micar");
            echo   '<ul class="list-none detail-extra-link">
                        '.$html_wl.'
                        <li>
                            '.s7upf_compare_url('<i class="color icon ion-ios-browsers-outline"></i>',false,$text).'
                        </li>
                    </ul>';
        }
    }
    add_action( 'wp_ajax_get_coupon', 's7upf_get_coupon' );
    add_action( 'wp_ajax_nopriv_get_coupon', 's7upf_get_coupon' );
    if(!function_exists('s7upf_get_coupon')){
        function s7upf_get_coupon() {
            $coupon = s7upf_get_option('enable_coupon');
            $new_in = s7upf_get_option('new_in');
            $newuser = s7upf_is_newuser($new_in);
            $default_code = $_POST['default_code'];
            if($coupon == 'on' && $newuser){
                $coupon_code = s7upf_create_coupon($default_code);                
                echo apply_filters('s7upf_output_content',$coupon_code);
            }
            else esc_html_e("Sorry. You can't get conpon code.","micar");
        }
    }
    

	if(!function_exists('s7upf_create_coupon')){
		function s7upf_create_coupon($default_code = ''){
			$ip = $_SERVER['REMOTE_ADDR'];
			$ip = str_replace('.', '_', $ip);
			$coupon_code = uniqid().rand(1,9); // Code
			$amount = s7upf_get_option('coupon_amount'); // Amount
			$date = s7upf_get_option('coupon_date'); // Date
			$discount_type = s7upf_get_option('coupon_type'); // Type: fixed_cart, percent, fixed_product, percent_product
			$usage_limit = s7upf_get_option('usage_limit');                    
			$usage_limit_per_user = s7upf_get_option('usage_limit_per_user');                    
			$individual_use = s7upf_get_option('individual_use');                    
			$exclude_sale_items = s7upf_get_option('exclude_sale_items');       
			if(!$default_code){
				$coupon = array(
					'post_title' => $coupon_code,
					'post_content' => '',
					'post_status' => 'publish',
					'post_author' => 1,
					'post_type'     => 'shop_coupon'
				);
									
				$new_coupon_id = wp_insert_post( $coupon );
									
				// Add meta
				update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
				update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
				update_post_meta( $new_coupon_id, 'individual_use', $individual_use );
				update_post_meta( $new_coupon_id, 'exclude_sale_items', $exclude_sale_items );
				update_post_meta( $new_coupon_id, 'product_ids', '' );
				update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
				update_post_meta( $new_coupon_id, 'usage_limit', $usage_limit );
				update_post_meta( $new_coupon_id, 'usage_limit_per_user', $usage_limit_per_user );
				update_post_meta( $new_coupon_id, 'expiry_date', $date );
				update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
				update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
			}
			else{
				$coupon_code = $default_code;
			}
			$current_user = wp_get_current_user();
			if($current_user->ID != 0) update_user_meta($current_user->ID, 'get_code', $coupon_code);
			else{
				$curent_data = get_option('ip_get_coupon');
				if(is_array($curent_data))$curent_data[] = $ip;
				else $curent_data = array();
				update_option( 'ip_get_coupon', $curent_data );
			}
			return $coupon_code;
		}
	}

	//-------- Begin Add Type Attributes------------//
	//Add Type Attributes Woo
	add_action( 'woocommerce_product_option_terms', 's7upf_product_option_terms_attribute' , 10, 2 );
	if(is_admin()){
		add_filter( 'product_attributes_type_selector','s7upf_add_attribute_types'  );
		add_action('admin_enqueue_scripts', 's7upf_attributes_admin_scripts');
		add_action('admin_init','s7upf_init_attribute_hooks');
		add_action( 's7upf_product_attribute_field','s7upf_attribute_fields' , 10, 3 );
	}
	//Font end attribute
	add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 's7upf_get_swatch_html_attribute' , 100, 2 );
	add_filter( 's7upf_filters_swatch_html_attribute','s7upf_swatch_html_attribute' , 5, 4 );
	// End Type Attributes Woo
	
	//Backend end attribute type color, image, label
	if(!function_exists('s7upf_get_tax_attribute')){
		 function s7upf_get_tax_attribute( $taxonomy ) {
			global $wpdb;

			$attr = substr( $taxonomy, 3 );
			$attr = $wpdb->get_row( $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = %s",$attr ));

			return $attr;
		}
	}
	if(!function_exists('s7upf_product_option_terms_attribute')){
		function s7upf_product_option_terms_attribute( $taxonomy, $index ) {
			$types = array(
				'color' => esc_html__( 'Color', 'micar' ),
				'image' => esc_html__( 'Image', 'micar' ),
				'label' => esc_html__( 'Label', 'micar' ),
			);
			if ( ! array_key_exists( $taxonomy->attribute_type,$types) ) {
				return;
			}

			$taxonomy_name = wc_attribute_taxonomy_name( $taxonomy->attribute_name );
			global $thepostid;
			?>

			<select multiple="multiple" data-placeholder="<?php esc_attr_e( 'Select terms', 'micar' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo esc_attr($index); ?>][]">
				<?php

				$all_terms = get_terms( $taxonomy_name, apply_filters( 'woocommerce_product_attribute_terms', array( 'orderby' => 'name', 'hide_empty' => false ) ) );
				if ( $all_terms ) {
					foreach ( $all_terms as $term ) {
						echo '<option value="' . esc_attr( $term->term_id ) . '" ' . selected( has_term( absint( $term->term_id ), $taxonomy_name, $thepostid ), true, false ) . '>' . esc_attr( apply_filters( 'woocommerce_product_attribute_term_name', $term->name, $term ) ) . '</option>';
					}
				}
				?>
			</select>
			<button class="button plus select_all_attributes"><?php esc_html_e( 'Select all', 'micar' ); ?></button>
			<button class="button minus select_no_attributes"><?php esc_html_e( 'Select none', 'micar' ); ?></button>
			<button class="button fr plus tawcvs_add_new_attribute" data-type="<?php echo esc_attr($taxonomy->attribute_type); ?>"><?php esc_html_e( 'Add new', 'micar' ); ?></button>

			<?php
		}
	}
	if(!function_exists('s7upf_init_attribute_hooks')){
		function s7upf_init_attribute_hooks() {
			$attribute_taxonomies = wc_get_attribute_taxonomies();
			if ( empty( $attribute_taxonomies ) ) {
				return;
			}

			foreach ( $attribute_taxonomies as $tax ) {
				add_action( 'pa_' . $tax->attribute_name . '_add_form_fields', 's7up_add_attribute_fields' );
				add_action( 'pa_' . $tax->attribute_name . '_edit_form_fields','s7up_edit_attribute_fields' , 10, 2 );
			}
			add_action( 'created_term', 's7upf_save_term_meta_attribute' , 10, 2 );
			add_action( 'edit_term', 's7upf_save_term_meta_attribute' , 10, 2 );
		}
	}
	if(!function_exists('s7up_add_attribute_fields')){
		function s7up_add_attribute_fields( $taxonomy ) {
			$attr = s7upf_get_tax_attribute( $taxonomy );
			do_action( 's7upf_product_attribute_field', $attr->attribute_type, '', 'add' );
		}
	}
	if(!function_exists('s7up_edit_attribute_fields')){
		function s7up_edit_attribute_fields( $term, $taxonomy ) {
			$attr = s7upf_get_tax_attribute( $taxonomy );
			$value = get_term_meta( $term->term_id, $attr->attribute_type, true );

			do_action( 's7upf_product_attribute_field', $attr->attribute_type, $value, 'edit' );
		}
	}
	if(!function_exists('s7upf_attribute_fields')){
		function s7upf_attribute_fields( $type, $value, $form ) {
			// Return if this is a default attribute type
			if ( in_array( $type, array( 'select', 'text' ) ) ) {
				return;
			}
			$types = array(
				'color' => esc_html__( 'Color', 'micar' ),
				'image' => esc_html__( 'Image', 'micar' ),
				'label' => esc_html__( 'Label', 'micar' ),
			);
			// Print the open tag of field container
			printf(
				'<%s class="form-field">%s<label for="term-%s">%s</label>%s',
				'edit' == $form ? 'tr' : 'div',
				'edit' == $form ? '<th>' : '',
				esc_attr( $type ),
				$types[$type],
				'edit' == $form ? '</th><td>' : ''
			);

			switch ( $type ) {
				case 'image':;
					$image_default ='';
					if(empty($value)){
						$image_default = WC()->plugin_url() . '/assets/images/placeholder.png';
					}
					$image = $value ? $value  : WC()->plugin_url() . '/assets/images/placeholder.png';

					?>
					<div class="wrap-metabox">
						<div class="live-previews">
							<?php if(!empty($image_default)) echo '<img src="'.esc_url($image_default).'"/>'?><?php if(!empty($value)) echo '<img src="'.esc_url($image).'"/>'?>
						</div>
						<a class="button button-primary sv-button-remove "> <?php esc_html_e("Remove","micar")?></a>
						<a class="button button-primary sv-button-upload"><?php esc_html_e("Upload","micar")?></a>
						<input name="image" type="hidden" class="sv-image-value" value="<?php echo esc_attr( $value ) ?>"> </input>
					</div>

					<?php
					break;

				default:
					?>
					<input type="text" id="term-<?php echo esc_attr( $type ) ?>" name="<?php echo esc_attr( $type ) ?>" value="<?php echo esc_attr( $value ) ?>" />
					<?php
					break;
			}

			// Print the close tag of field container
			echo 'edit' == $form ? '</td></tr>' : '</div>';
		}
	}
	if(!function_exists('s7upf_save_term_meta_attribute')){
		function s7upf_save_term_meta_attribute( $term_id, $tt_id ) {
			$types = array(
				'color' => esc_html__( 'Color', 'micar' ),
				'image' => esc_html__( 'Image', 'micar' ),
				'label' => esc_html__( 'Label', 'micar' ),
			);
			foreach ( $types as $type => $label ) {
				if ( isset( $_POST[$type] ) ) {
					update_term_meta( $term_id, $type, $_POST[$type] );
				}
			}
		}
	}
	if(!function_exists('s7upf_add_attribute_types')){
		function s7upf_add_attribute_types($types) {
			$add_type = array(
				'color' => esc_html__( 'Color', 'micar' ),
				'image' => esc_html__( 'Image', 'micar' ),
				'label' => esc_html__( 'Label', 'micar' ),
			);
			$types = array_merge( $types, $add_type);
			return $types;
		}
	}
	if(!function_exists('s7upf_attributes_admin_scripts')){
		function s7upf_attributes_admin_scripts(){
			$screen = get_current_screen();
			if (strpos($screen->id, 'pa_') !== false) :
				wp_enqueue_media();
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'wp-color-picker');
			endif;
		}
	}

	//Font end attribute type color, image, label
	if(!function_exists('s7upf_get_swatch_html_attribute')){
		function s7upf_get_swatch_html_attribute( $html, $args ) {
			$swatch_types = array(
				'color' => esc_html__( 'Color', 'micar' ),
				'image' => esc_html__( 'Image', 'micar' ),
				'label' => esc_html__( 'Label', 'micar' ),
			);
			$attr         = s7upf_get_tax_attribute( $args['attribute'] );
			// Return if this is normal attribute
			if ( empty( $attr ) ) {
				return $html;
			}

			if ( ! array_key_exists( $attr->attribute_type, $swatch_types ) ) {
				return $html;
			}
			$options   = $args['options'];
			$product   = $args['product'];
			$attribute = $args['attribute'];
			$class     = "variation-selector variation-select-{$attr->attribute_type}";
			$swatches  = '';

			if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
				$attributes = $product->get_variation_attributes();
				$options    = $attributes[$attribute];
			}

			if ( array_key_exists( $attr->attribute_type, $swatch_types ) ) {
				if ( ! empty( $options ) && $product && taxonomy_exists( $attribute ) ) {
					// Get terms if this is a taxonomy - ordered. We need the names too.
					$terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

					foreach ( $terms as $term ) {
						if ( in_array( $term->slug, $options ) ) {
							$swatches .= apply_filters( 's7upf_filters_swatch_html_attribute', '', $term, $attr, $args );
						}
					}
				}

				if ( ! empty( $swatches ) ) {
					$class .= ' hidden';

					$swatches = '<div class="tawcvs-swatches" data-attribute_name="attribute_' . esc_attr( $attribute ) . '">' . $swatches . '</div>';
					$html     = '<div class="' . esc_attr( $class ) . '">' . $html . '</div>' . $swatches;
				}
			}

			return $html;
		}
	}
	if(!function_exists('s7upf_swatch_html_attribute')){
		function s7upf_swatch_html_attribute( $html, $term, $attr, $args ) {
			$selected = sanitize_title( $args['selected'] ) == $term->slug ? 'selected' : '';
			$name     = esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) );

			switch ( $attr->attribute_type ) {
				case 'color':
					$color = get_term_meta( $term->term_id, 'color', true );
					list( $r, $g, $b ) = sscanf( $color, "#%02x%02x%02x" );
					$html = sprintf(
						'<span class="swatch swatch-color swatch-%s %s" style="background-color:%s;color:%s;" title="%s" data-value="%s"><span>%s</span></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $color ),
						"rgba($r,$g,$b,0.5)",
						esc_attr( $name ),
						esc_attr( $term->slug ),
						$name
					);
					break;

				case 'image':
					$image = get_term_meta( $term->term_id, 'image', true );
					$image = $image ?  $image : WC()->plugin_url() . '/assets/images/placeholder.png';

					$html  = sprintf(
						'<span class="swatch swatch-image swatch-%s %s" title="%s" data-value="%s"><img src="%s" alt="%s"><span class="hide">%s</span></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						esc_url( $image ),
						esc_attr( $name ),
						esc_attr( $name )
					);
					break;

				case 'label':
					$label = get_term_meta( $term->term_id, 'label', true );
					$label = $label ? $label : $name;
					$html  = sprintf(
						'<span class="swatch swatch-label swatch-%s %s" title="%s" data-value="%s">%s</span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						esc_html( $label )
					);
					break;
			}

			return $html;
		}
	}
	
	//--------- End Add Type Attributes ----------------//
}