<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('s7upf_vc_product_ajax_filter'))
{
    function s7upf_vc_product_ajax_filter($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'           => 'loadmore',
			'bg_style'        => 'load-more-light',
			'title'           => '',
            'number'          => '',
            'col'             => '',            
            'product_type'    => '', 
			'itemscustom'     => '',	
            'orderby'         => 'none',            
            'order'           => 'DESC',           
        ),$attr));
        ob_start();
		
		if($style=='loadmore'){
			
			?>
			<div class="<?php echo esc_attr($bg_style);?>">
				<div class="car-filter-form car-filter bg-white border">
					<h3 class="title18 title-car-filter text-uppercase text-right silver"><?php echo esc_html__('FILTERS','micar')?> </h3>
					<form  method="get" class="form-filter">
						<div class="row">
							<?php
								$woo_tax = s7upf_get_option('woo_taxonomy_product');
								if(!empty($woo_tax)):
								foreach ($woo_tax as $key => $value):
								$title = $value['title'];
								$slug  = $value['taxonomy_slug'];
								$filter  = $value['show_tax_filter'];
								$slug = 'tax_'.$slug;
								$array = s7upf_get_product_taxonomy($slug);
								if($filter=='on'):
							?>
							<div class="col-md-2 colsm-6 col-xs-6">
								<div class="select-box select-box-filter">
									<select class="select-taxonomy" name="<?php echo esc_attr($slug);?>">
										<option value=""> <?php echo esc_html__('Select','micar')?> <?php echo esc_html($value['title']);?> </option>
										<?php
											foreach ($array as $key => $tax):
										?>
										<option value="<?php echo esc_attr($tax['value']);?>"><?php echo esc_attr($tax['label']);?></option>
										<?php endforeach;?>
									</select>
								</div>
							</div>
							<?php endif;endforeach;endif;?>
							<?php
								global $product; 
								$attribute = wc_get_attribute_taxonomies();
								foreach($attribute as $key=>$value):
								$terms = get_terms('pa_'.$value->attribute_name);
								if(!empty($terms)):
							?>
							<div class="col-md-2 colsm-6 col-xs-6">
								<div class="select-box select-box-filter">
									<select class="select-attribute" name="<?php  echo 'pa_'.$value->attribute_name;?>">
										<option value=""> <?php echo esc_html__('Select','micar')?> <?php echo esc_attr($value->attribute_label);?> </option>
										<?php
											foreach ($terms as $key => $term):
											if(is_object($term) && !empty($term)):
										?>
										<option value="<?php echo esc_attr($term->slug);?>"><?php  echo esc_attr($term->name);?></option>
										<?php endif;endforeach;?>
									</select>
								</div>
							</div>
							<?php endif;endforeach;?>
							<div class="col-md-2 colsm-6 col-xs-6">
								<div class="submit-filter shop-button gradient">
									<input type="submit" class="btn-car-filter" value="Search" />
								</div>
							</div>
						</div>
					</form>
				</div>
				<!-- End Car Filter -->
				<div class="product-box-filter">
					<div class="ajax-product-filter">
						<div class="row">
						<?php
							$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
							$args=array(
								'post_type'         => 'product',
								'posts_per_page'    => $number,
								'orderby'           => $orderby,
								'order'             => $order,
								'paged'             => $paged,
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
							$attr_taxquery = array();
							
							if(!empty($attr_taxquery)) $args['tax_query'] = $attr_taxquery;
							
							$product_query = new WP_Query($args);
							$max_page = $product_query->max_num_pages;
							$size = s7upf_get_option('product_size_thumb');
							if(empty($size)) $size = array(500,280);
							else $size = explode('x', $size);
							$item_num = $col;
							if(empty($item_num)) $item_num = 3;
							if($product_query->have_posts()) {
								while($product_query->have_posts()) {
									$product_query->the_post();
									global $product;
									if($bg_style == 'load-more-dark'){
										echo s7upf_product_item('item-produc-grid',$item_num,'',$size);
									}else{
										echo s7upf_product_item('item-produc-grid',$item_num,'inner-zoom',$size);
									}
								}
							}
							wp_reset_postdata();
						?>
						</div>
					</div>
					<?php if($max_page > 1):?>
					<div class="load-more-link text-center">
						<a href="#" data-number="<?php echo esc_attr($number);?>" data-maxpage="<?php echo esc_attr($max_page);?>" data-orderby="<?php echo esc_attr($orderby);?>" data-order="<?php echo esc_attr($order);?>" data-paged="1" data-type="<?php echo esc_attr($product_type);?>" class="shop-button btn-load-more-ajax bg-color title18"><?php echo esc_html__('load more','micar')?> <i class="icon ion-android-arrow-down"></i></a>
					</div>
					<?php endif;?>
				</div>
			</div>
			<?php
		}
		if($style=='filter'){
			?>
			<div class="car-find bg-color text-center">
				<h2 class="title30 white anton-font text-uppercase"><?php echo esc_html($title);?></h2>
				<form class="form-find-car">
					<div class="row">
						<?php
							$woo_tax = s7upf_get_option('woo_taxonomy_product');
							foreach ($woo_tax as $key => $value):
							$title = $value['title'];
							$slug  = $value['taxonomy_slug'];
							$filter  = $value['show_tax_filter'];
							$tax_desc  = $value['taxonomy_desc'];
							$slug = 'tax_'.$slug;
							$array = s7upf_get_product_taxonomy($slug);
							if($filter=='on'):
						?>
						<div class="col-md-2 col-sm-6 col-xs-6">
							<p class="desc white"><?php echo esc_html($tax_desc);?></p>
							<div class="select-box select-box-filter">
								<select class="<?php echo esc_attr($slug);?>" name="<?php echo esc_attr($slug);?>">
									<option value=""> <?php echo esc_html__('Select','micar')?> <?php echo esc_html($value['title']);?> </option>
									<?php
										foreach ($array as $key => $tax):
									?>
									<option value="<?php echo esc_attr($tax['value']);?>"><?php echo esc_attr($tax['label']);?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div>
						<?php endif;endforeach;?>
					</div>
					<div class="submit-form">
						<input class="btn-filter-ajax" type="submit" value="" data-orderby="<?php echo esc_attr($orderby);?>" data-order="<?php echo esc_attr($order);?>"  data-type="<?php echo esc_attr($product_type);?>"  data-number="<?php echo esc_attr($number);?>" data-items="<?php echo esc_attr($itemscustom);?>"/>
					</div>
				</form>
			</div>
			<!-- End Car Find -->
			<div class="product-slider product-slider4 filter-product-tax">
				<div class="wrap-item" data-pagination="false" data-navigation="true" data-itemscustom="<?php echo s7upf_convert_itemscustom($itemscustom);?>">
					<?php
						$args = array(
							'post_type'         => 'product',
							'posts_per_page'    => -1,
							'showposts'         => $number,
							'orderby'           => $orderby,
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
									
						$product_query = new WP_Query($args);
						
						$size = s7upf_get_option('product_size_thumb');
						if(empty($size)) $size = array(500,280);
						else $size = explode('x', $size);
						if($product_query->have_posts()) {
							while($product_query->have_posts()) {
								$product_query->the_post();
								global $product;
								echo s7upf_product_item('style1','','',$size);
							}
						}
						wp_reset_postdata();
					?>
				</div>
			</div>
			<!-- End Product Slider -->
			<?php
		}	
		$html = @ob_get_clean();
		return  $html;
    }
}

stp_reg_shortcode('sv_product_ajax_filter','s7upf_vc_product_ajax_filter');

vc_map( array(
    "name"      => esc_html__("SV Product Ajax Filter", 'micar'),
    "base"      => "sv_product_ajax_filter",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(  
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style', 'micar' ),
			'param_name' => 'style',
			'value' => array(
				esc_html__('Load More Ajax','micar')       => 'loadmore',
				esc_html__('Filter Ajax','micar')          => 'filter',
			),
		),  
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Style Background', 'micar' ),
			'param_name' => 'bg_style',
			'value' => array(
				esc_html__('Light','micar')       => 'load-more-light',
				esc_html__('Dark','micar')        => 'load-more-dark',
			),
			"dependency"    => array(
				'element'   => 'style',
				'value'     => array('loadmore')
			),
		),  
		array(
            "type"          => "textfield",
            "heading"       => esc_html__("Title Box Filter",'micar'),
            "param_name"    => "title",
			"dependency"    => array(
				'element'   => 'style',
				'value'     => array('filter')
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
		),
        array(
            "type"          => "textfield",
            "heading"       => esc_html__("Number Product View",'micar'),
            "param_name"    => "number",
        ),
		array(
			'heading'     => esc_html__( 'Custom Items Slider', 'micar' ),
			'type'        => 'textfield',
			'description'   => esc_html__( 'Enter item for screen width(px) format is width:value and separate values by ",". Example is 0:2,480:3,768:4,1024:5. Default is auto.', 'micar' ),
			'param_name'  => 'itemscustom',
			"dependency"    => array(
				'element'   => 'style',
				'value'     => array('filter')
			),
		),
        array(
            "type"          => "textfield",
            "heading"       => esc_html__("Product Column",'micar'),
            "param_name"    => "col",
			"dependency"    => array(
				'element'   => 'style',
				'value'     => array('loadmore')
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
    )
));