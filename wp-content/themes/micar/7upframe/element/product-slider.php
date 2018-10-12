<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 05/09/15
 * Time: 10:00 AM
 */
if(class_exists("woocommerce")){
	if(!function_exists('sv_vc_product_slider'))
	{
		function sv_vc_product_slider($attr, $content = false)
		{
			$html = $css_class = '';
			extract(shortcode_atts(array(
				'style'           => '',
				'number'          => '8',
				'cats'            => '',
				'order_by'        => 'date',
				'order'           => 'DESC',
				'product_type'    => '',
				'product_style'   => '',
				'size'            => '',
				'control_nav'     => '',
				'itemscustom'     => '',
				'autoplay'        => 'false',
				'pagination'      => 'false',
				'navigation'      => 'false',
				'class_extra'     => '',
				'custom_css'      => '',
			),$attr));
			if(!empty($custom_css)) $css_class = vc_shortcode_custom_css_class( $custom_css );
			if(!empty($cats)) $cats = str_replace(' ', '', $cats);
			$animation_class = '';
			if(!empty($animation)) {
				$animation_class = ' wow '.$animation;
			}
			$custom_list = array();
			$args = array(
				'post_type'         => 'product',
				'posts_per_page'    => -1,
				'showposts'         => $number,
				'orderby'           => $order_by,
				'order'             => $order,
			);
			if($product_type == 'trendding'){
				$args['meta_query'][] = array(
						'key'     => 'trending_product',
						'value'   => 'on',
						'compare' => '=',
					);
			}
			if($product_type == 'toprate'){
				$args['meta_key'] = '_wc_average_rating';
				$args['orderby'] = 'meta_value_num';
				$args['meta_query'] = WC()->query->get_meta_query();
				$args['tax_query'][] = WC()->query->get_tax_query();
			}
			if($product_type == 'mostview'){
				$args['meta_key'] = 'post_views';
				$args['orderby'] = 'meta_value_num';
			}
			if($product_type == 'bestsell'){
				$args['meta_key'] = 'total_sales';
				$args['orderby'] = 'meta_value_num';
			}
			if($product_type=='onsale'){
				$args['meta_query']['relation']= 'OR';
				$args['meta_query'][]=array(
					'key'   => '_sale_price',
					'value' => 0,
					'compare' => '>',                
					'type'          => 'numeric'
				);
				$args['meta_query'][]=array(
					'key'   => '_min_variation_sale_price',
					'value' => 0,
					'compare' => '>',                
					'type'          => 'numeric'
				);
			}
			if($product_type == 'featured'){
				$args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'featured',
					'operator' => 'IN',
				);
			}
			if(!empty($cats)) {
				$custom_list = explode(",",$cats);
				$args['tax_query'][]=array(
					'taxonomy'=>'product_cat',
					'field'=>'slug',
					'terms'=> $custom_list
				);
			}
			$product_query = new WP_Query($args);
			$count = 1;
			$count_query = $product_query->post_count;
			if(!empty($size)){
				$size = explode('x', $size);
			}else{
				$size = s7upf_get_option('product_size_thumb');
			}
			switch ($style) {
				
				case 'product-slider2':
					$html .= '<div class="product-slider2 '.esc_attr($class_extra).' '.esc_attr($css_class).'">
								<div class="wrap-item '.esc_attr($control_nav).'" data-pagination="'.esc_attr($pagination).'" data-navigation="'.esc_attr($navigation).'" data-autoplay="'.esc_attr($autoplay).'" data-itemscustom="'.s7upf_convert_itemscustom($itemscustom).'">';
					if($product_query->have_posts()) {
						while($product_query->have_posts()) {
							$product_query->the_post();
							$html .=  s7upf_product_item($product_style,'','',$size);
						}
					}	
					$html .= 	'</div>
					          </div>';
					break;
							  
				default:
					$html .= '<div class="product-slider '.esc_attr($class_extra).' '.esc_attr($css_class).'">
								<div class="wrap-item '.esc_attr($control_nav).'" data-pagination="'.esc_attr($pagination).'" data-navigation="'.esc_attr($navigation).'" data-autoplay="'.esc_attr($autoplay).'" data-itemscustom="'.s7upf_convert_itemscustom($itemscustom).'">';
					if($product_query->have_posts()) {
						while($product_query->have_posts()) {
							$product_query->the_post();
							$html .=  s7upf_product_item($product_style,'','',$size);
						}
					}	
					$html .= 	'</div>
					          </div>';
					break;
			}
			wp_reset_postdata();
			return $html;
		}
	}

	stp_reg_shortcode('sv_product_slider','sv_vc_product_slider');

	$check_add = '';
	if(isset($_GET['return'])) $check_add = $_GET['return'];
	if(empty($check_add)) add_action( 'vc_before_init_base','sv_add_slider_product',10,100 );
	if ( ! function_exists( 'sv_add_slider_product' ) ) {
		function sv_add_slider_product(){
			vc_map( array(
				"name"      => esc_html__("SV Product Slider", 'micar'),
				"base"      => "sv_product_slider",
				"icon"      => "icon-st",
				"category"  => '7Up-theme',
				"params"    => array(
					array(
						'heading'     => esc_html__( 'Style', 'micar' ),
						'holder'      => 'div',
						'type'        => 'dropdown',
						'param_name'  => 'style',
						'value'       => array(                        
							esc_html__('Default','micar')     => '',
							esc_html__('Product Slider 2','micar')     => 'product-slider2',
							),
					),
					array(
						'heading'     => esc_html__( 'Product Type', 'micar' ),
						'type'        => 'dropdown',
						'param_name'  => 'product_type',
						'value' => array(
							esc_html__('Default','micar')            => '',
							esc_html__('Trendding','micar')          => 'trendding',
							esc_html__('Featured Products','micar')  => 'featured',
							esc_html__('Best Sellers','micar')       => 'bestsell',
							esc_html__('On Sale','micar')            => 'onsale',
							esc_html__('Top rate','micar')           => 'toprate',
							esc_html__('Most view','micar')          => 'mostview',
						),
						'description' => esc_html__( 'Select Product View Type', 'micar' ),
						'edit_field_class'=>'vc_col-sm-6 vc_column',
					),
					array(
						'heading'     => esc_html__( 'Product Style', 'micar' ),
						'type'        => 'dropdown',
						'description' => esc_html__( 'Choose style for product.', 'micar' ),
						'param_name'  => 'product_style',
						'value'       => array(                        
							esc_html__('Default','micar')     => '',
							esc_html__('Style 1','micar')     => 'style1',
							esc_html__('Style 2','micar')     => 'style2',
							esc_html__('Style 3','micar')     => 'style3',
							),
						'edit_field_class'=>'vc_col-sm-6 vc_column',
					),
					array(
						'heading'     => esc_html__( 'Number', 'micar' ),
						'type'        => 'textfield',
						'description' => esc_html__( 'Enter number of product. Default is 8.', 'micar' ),
						'param_name'  => 'number',
						'edit_field_class'=>'vc_col-sm-6 vc_column',
					),
					array(
						"type"          => "textfield",
						"heading"       => esc_html__("Size Thumbnail",'micar'),
						"param_name"    => "size",
						'description'   => esc_html__( 'Enter site thumbnail to crop. [width]x[height]. Example is 300x300', 'micar' ),
						'edit_field_class'=>'vc_col-sm-6 vc_column',
					),
					array(
						'holder'     => 'div',
						'heading'     => esc_html__( 'Product Categories', 'micar' ),
						'type'        => 'autocomplete',
						'param_name'  => 'cats',
						'settings' => array(
							'multiple' => true,
							'sortable' => true,
							'values' => s7upf_get_product_taxonomy(),
						),
						'save_always' => true,
						'description' => esc_html__( 'List of product categories', 'micar' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Order By', 'micar' ),
						'value' => s7upf_get_order_list(),
						'param_name' => 'orderby',
						'description' => esc_html__( 'Select Orderby Type ', 'micar' ),
						'edit_field_class'=>'vc_col-sm-6 vc_column',
					),
					array(
						'heading'     => esc_html__( 'Order', 'micar' ),
						'type'        => 'dropdown',
						'param_name'  => 'order',
						'value' => array(                   
							esc_html__('Desc','micar')  => 'DESC',
							esc_html__('Asc','micar')  => 'ASC',
						),
						'description' => esc_html__( 'Select Order Type ', 'micar' ),
						'edit_field_class'=>'vc_col-sm-6 vc_column',
					),
					array(
						'heading'     => esc_html__( 'Custom Items', 'micar' ),
						'type'        => 'textfield',
						'description'   => esc_html__( 'Enter item for screen width(px) format is width:value and separate values by ",". Example is 0:2,480:3,768:4,1024:5. Default is auto.', 'micar' ),
						'param_name'  => 'itemscustom',
						'group'         => esc_html__('Slider Control','micar'),	
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Navigation Control', 'micar' ),
						'param_name'  => 'navigation',
						'value'       => array(
							esc_html__( 'False', 'micar' )        => 'false',
							esc_html__( 'True', 'micar' )        => 'true',
							),
						'group'         => esc_html__('Slider Control','micar'),	
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Pagination Control', 'micar' ),
						'param_name'  => 'pagination',
						'value'       => array(
							esc_html__( 'False', 'micar' )        => 'false',
							esc_html__( 'True', 'micar' )        => 'true',
							),
						'group'         => esc_html__('Slider Control','micar'),	
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Auto Play Control', 'micar' ),
						'param_name'  => 'autoplay',
						'value'       => array(
							esc_html__( 'False', 'micar' )        => 'false',
							esc_html__( 'True', 'micar' )        => 'true',
							),
						'group'         => esc_html__('Slider Control','micar'),
							
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Style Control Nav', 'micar' ),
						'param_name'  => 'control_nav',
						'value'       => array(
							esc_html__( 'Default', 'micar' )        => '',
							esc_html__( 'Group Navi', 'micar' )     => 'group-navi',
							esc_html__( 'Rect Navi', 'micar' )      => 'rect-navi',
							esc_html__( 'Hidden Navi', 'micar' )    => 'nav-hidden',
							esc_html__( 'Group Small', 'micar' )    => 'small-navi group-navi',
							esc_html__( 'Pagination Border', 'micar' )    => 'border-pagi',
							),
						'group'         => esc_html__('Slider Control','micar'),	
					),
					array(
						"type"          => "css_editor",
						"heading"       => esc_html__("Custom Style",'micar'),
						"param_name"    => "custom_css",
						'group'         => esc_html__('Design Option','micar')
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Class Extra', 'micar' ),
						'param_name'  => 'class_extra',
						'group'         => esc_html__('Design Option','micar')
					),
				)
			));
		}
	}
}