<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 05/09/15
 * Time: 10:00 AM
 */
if(class_exists("woocommerce")){
    if(!function_exists('s7upf_vc_product_tab'))
    {
        function s7upf_vc_product_tab($attr, $content = false)
        {
            $html = '';
            extract(shortcode_atts(array(
                'style'             => '',
                'title'             => '',
                'tabs'              => '',
				'product_style'     => '',
                'number'            => '',
				'control_nav'       => '',
                'order_by'          => 'date',
                'order'             => 'DESC',
                'itemscustom'       => '',
                'size'              => '',
                'class_extra'       => '',
            ),$attr));
            if(!empty($size)){
				$size = explode('x', $size);
			}else{
				$size = s7upf_get_option('product_size_thumb');
			}
            $args=array(
                'post_type'         => 'product',
                'posts_per_page'    => -1,
				'showposts'         => $number,
                'orderby'           => $order_by,
                'order'             => $order
            );
            $pre = rand(1,100);
            if(!empty($tabs)){
                $tabs = explode(',', $tabs);
                $tab_html = $content_html = '';
                foreach ($tabs as $key => $tab) {
                    switch ($tab) {
                        case 'bestsell':
                            $tab_title =    esc_html__("Best Seller","micar");
                            $args['meta_key'] = 'total_sales';
                            $args['orderby'] = 'meta_value_num';
                            break;

                        case 'toprate':
                            $tab_title =    esc_html__("Top Rate","micar");
                            unset($args['meta_key']);
                            $args['meta_key'] = '_wc_average_rating';
                            $args['orderby'] = 'meta_value_num';
                            $args['meta_query'] = WC()->query->get_meta_query();
                            $args['tax_query'][] = WC()->query->get_tax_query();
                            break;
                        
                        case 'mostview':
                            $tab_title =    esc_html__("Popular","micar");
                            unset($args['no_found_rows']);
                            unset($args['meta_query']);
                            unset($args['tax_query']);
                            $args['meta_key'] = 'post_views';
                            $args['orderby'] = 'meta_value_num';
                            break;

                        case 'featured':
                            $tab_title =    esc_html__("Featured","micar");
                            $args['orderby'] = $order_by;
                            $args['tax_query'][] = array(
                                'taxonomy' => 'product_visibility',
                                'field'    => 'name',
                                'terms'    => 'featured',
                                'operator' => 'IN',
                            );
                            break;

                        case 'trendding':
                            unset($args['meta_key']);
                            unset($args['meta_value']);
                            $tab_title =    esc_html__("Tredding","micar");
                            $args['meta_query'][] = array(
                                'key'     => 'trending_product',
                                'value'   => 'on',
                                'compare' => '=',
                            );
                            break;
                        
                        case 'onsale':
                            $tab_title =    esc_html__("On sale","micar");
                            unset($args['meta_query']);
                            unset($args['meta_key']);
                            unset($args['meta_value']);
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
                            break;
                        
                        default:
                            $tab_title =    esc_html__("New arrivals","micar");
                            $args['orderby'] = 'date';
                            break;
                    }
                    if($key == 0) $f_class = 'active';
                    else $f_class = '';
                    $product_query = new WP_Query($args);
                    $count_query = $product_query->post_count;
                    switch ($style) {
                       
                        default:
							$tab_html .=    '<li class="'.esc_attr($f_class).'"><a href="'.esc_url('#'.$tab.'_'.$pre).'" class="shop-button small" data-toggle="tab">'.$tab_title.'</a></li>';
							
							$content_html .=    '<div id="'.$tab.'_'.$pre.'" class="tab-pane '.$f_class.'">
                                                    <div class="product-slider2 ">
                                                        <div class="wrap-item '.esc_attr($control_nav).'"  data-pagination="false" data-navigation="true" data-itemscustom="'.s7upf_convert_itemscustom($itemscustom).'">';
                            if($product_query->have_posts()) {
                                while($product_query->have_posts()) {
                                    $product_query->the_post();
									
                                    $content_html .=    s7upf_product_item($product_style,'','',$size);
                                }
                            }
                            $content_html .=            '</div>
                                                    </div>
                                                </div>';
							
							break;
                    } 
                }   
				   
				switch ($style) {
					default:
						$html .=    '<div class="product-box3 '.esc_attr($class_extra).'">
										<div class="title-product-box3 text-center">
											<h2 class="title30 text-uppercase font-bold">'.esc_html($title).'</h2>';
						$html .=       		'<ul class="list-inline-block title-tab3">
												'.$tab_html.'
											</ul>
										</div>
										<div class="tab-content">
											'.$content_html.'
										</div>
									</div>';
						break;
				}		
            }
            wp_reset_postdata();
            return $html;
        }
    }

    stp_reg_shortcode('sv_product_tab','s7upf_vc_product_tab');
    if(isset($_GET['return'])) $check_add = $_GET['return'];
    if(empty($check_add)) add_action( 'vc_before_init_base','s7upf_add_product_tab',10,100 );
    if ( ! function_exists( 's7upf_add_product_tab' ) ) {
        function s7upf_add_product_tab(){
            vc_map( array(
                "name"      => esc_html__("SV Product Tab", 'micar'),
                "base"      => "sv_product_tab",
                "icon"      => "icon-st",
                "category"  => '7Up-theme',
                "params"    => array(
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Style",'micar'),
                        "param_name" => "style",
                        "value"     => array(
                            esc_html__("Default",'micar')   => '',
						)
                    ),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Title Box', 'micar' ),
						'param_name'  => 'title',
					),
                    array(
                        "type" => "checkbox",
                        "heading" => esc_html__("Tabs",'micar'),
                        "param_name" => "tabs",
                        "value" => array(
                            esc_html__("New Arrivals",'micar')    => 'newarrival',
                            esc_html__("Best Seller",'micar')     => 'bestsell',
                            esc_html__("Top Rate",'micar')     => 'toprate',
                            esc_html__("Popular",'micar')       => 'mostview',
                            esc_html__("Featured",'micar')        => 'featured',
                            esc_html__("Trendding",'micar')       => 'trendding',
                            esc_html__("On Sale",'micar')         => 'onsale',
						),
                    ),
                    array(
                        'heading'     => esc_html__( 'Number', 'micar' ),
                        'type'        => 'textfield',
                        'description' => esc_html__( 'Enter number of product. Default is 10.', 'micar' ),
                        'param_name'  => 'number',
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
                        "type"          => "textfield",
                        "heading"       => esc_html__("Size Thumbnail",'micar'),
                        "param_name"    => "size",
                        'description'   => esc_html__( 'Enter site thumbnail to crop. [width]x[height]. Example is 300x300', 'micar' ),
                    ),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Class Extra', 'micar' ),
						'param_name'  => 'class_extra',
					),
                    array(
                        "type"          => "textfield",
                        "heading"       => esc_html__("Item Responsive",'micar'),
                        "param_name"    => "itemscustom",
                        "group"         => esc_html__("Slider Settings",'micar'),
                        'description'   => esc_html__( 'Enter item for screen width(px) format is width:value and separate values by ",". Example is 0:2,600:3,1000:4. Default is auto.', 'micar' ),
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
							),
						'group'         => esc_html__('Slider Settings','micar'),	
					),
                )
            ));
        }
    }
}
