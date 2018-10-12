<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 05/09/15
 * Time: 10:00 AM
 */
if(class_exists("woocommerce")){
	if(!function_exists('sv_vc_product_category_menu'))
	{
		function sv_vc_product_category_menu($attr, $content = false)
		{
			$html = '';
			extract(shortcode_atts(array(
				'style'           => 'list',
				'title'           => '',
				'number'          => '5',
				'cats'            => '',
			),$attr));
			
			$cat_slug = explode(',',$cats);
			
			switch ($style) {
				case 'dropdown':
					$html .= '<div class="category-dropdown dropdown-box">
								<a href="javascript:void(0)" class="dropdown-link title30 white"><i class="icon ion-ios-keypad"></i>'.esc_html__('Categories','micar').'</a>
								<ul class="list-none dropdown-list">';
									foreach($cat_slug as $key=>$value){
										$term = get_term_by('slug',$value,'product_cat');
										if(is_object($term) && !empty($term)){
										$term_children = get_term_children( $term->term_id, $term->taxonomy);
										$class="";
										if(!empty($term_children)){
											$class="has-cat-mega";
										} 
										$html .= 	'<li class="'.$class.'"><a href="'.get_term_link($term->slug,'product_cat').'"><img src="'.wp_get_attachment_url(get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true )).'" alt="'.esc_html($term->name).'">'.esc_html($term->name).'</a>';
										if(!empty($term_children)) {
											$html .=    '<div class="cat-mega-menu">
															<h2 class="title18 font-bold text-uppercase">'.esc_html($term->name).'</h2>
															<div class="cat-mega-slider line-white">
																<div class="wrap-item group-navi small-navi" data-pagination="false" data-navigation="true" data-itemscustom="[[0,1],[768,2],[990,3]]">';
																foreach($term_children as $key=>$children){
																	$term = get_term( $children, 'product_cat' );
																	if($key<$number){
											$html .=    			'<div class="product-cat-mega">
																		<h3 class="title14 font-bold text-uppercase"><a href="'.get_term_link($term->term_id,'product_cat').'">'.$term->name.'</a></h3>
																		<p class="desc">'.$term->description.'</p>
																		<a href="'.get_term_link($children,'product_cat').'" class="shop-button small bg-color">'.esc_html__('discover more','micar').'</a>
																		<a href="'.get_term_link($children,'product_cat').'" class="wobble-horizontal"><img src="'.wp_get_attachment_url(get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true )).'" alt="'.esc_html($term->name).'" /></a>
																	</div>';
																	}
																}	
											$html .= 			'</div>
															</div>
														</div>';
										}
										$html .=    '</li>';
										}
									}
					$html .=   	'</ul>
							</div>';
					break;
							  
				default:
					$html .= '<div class="mega-menu-box">
								<h2 class="title18 title-mega-menu text-uppercase font-bold">'.esc_html($title).'</h2>
								<ul class="list-none list-cat-mega text-uppercase">';
								foreach($cat_slug as $key=>$value){
									$term = get_term_by('slug',$value,'product_cat');
									if(is_object($term) && !empty($term))
									$html .= 	'<li><a href="'.get_term_link($term->slug,'product_cat').'"><img src="'.wp_get_attachment_url(get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true )).'" alt="'.esc_html($term->name).'">'.esc_html($term->name).'</a></li>';
								}
					$html .=   '</ul>
							  </div>';
					break;
			}
			return $html;
		}
	}

	stp_reg_shortcode('sv_product_category_menu','sv_vc_product_category_menu');

	$check_add = '';
	if(isset($_GET['return'])) $check_add = $_GET['return'];
	if(empty($check_add)) add_action( 'vc_before_init_base','sv_add_product_category_menu',10,100 );
	if ( ! function_exists( 'sv_add_product_category_menu' ) ) {
		function sv_add_product_category_menu(){
			vc_map( array(
				"name"      => esc_html__("SV Product Category Menu", 'micar'),
				"base"      => "sv_product_category_menu",
				"icon"      => "icon-st",
				"category"  => '7Up-theme',
				"params"    => array(
					array(
						'heading'     => esc_html__( 'Style', 'micar' ),
						'holder'      => 'div',
						'type'        => 'dropdown',
						'param_name'  => 'style',
						'value'       => array(                        
							esc_html__('List','micar')     => 'list',
							esc_html__('Dropdown','micar')     => 'dropdown',
							),
					),
					array(
                        'heading'     => esc_html__( 'Title', 'micar' ),
                        'type'        => 'textfield',
                        'param_name'  => 'title',
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
                        'heading'     => esc_html__( 'Number', 'micar' ),
                        'type'        => 'textfield',
                        'description' => esc_html__( 'Enter number sub category . Default is 5.', 'micar' ),
                        'param_name'  => 'number',
						"dependency"    => array(
							"element"   => "style",
							"value"   => array("dropdown"),
							)
                    ),
				)
			));
		}
	}
}