<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
if(class_exists("woocommerce")){
	if(!function_exists('s7upf_vc_shop'))
	{
		function s7upf_vc_shop($attr)
		{
			$html = '';
			extract(shortcode_atts(array(
				'shop_title' => '',
				'style'      => 'grid',
				'number'     => '12',
				'orderby'    => 'menu_order',
				'column'     => '1',
			),$attr));
			$size = s7upf_get_option('product_size_thumb');
			if(empty($size)) $size = 'full';
			else $size = explode('x', $size);
			$item_num = $column;
			$type = $style;
			if(isset($_GET['orderby'])){
				$orderby = $_GET['orderby'];
			}
			if(isset($_GET['type'])){
				$type = $_GET['type'];
			}
			if(isset($_GET['number'])){
				$number = $_GET['number'];
			} 
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array(
				'post_type'         => 'product',
				'posts_per_page'    => $number,
				'paged'             => $paged,
				);
			
			$attr_taxquery = array();
			global $wpdb;
			//Taxonomy
			$woo_tax = s7upf_get_option('woo_taxonomy_product');
			if(!empty($woo_tax)){
				foreach ($woo_tax as $key => $value){
					$title = $value['title'];
					$slug  = $value['taxonomy_slug'];
					$slug = 'tax_'.$slug;
					if(!empty($_REQUEST[$slug])){
						$tax = $_REQUEST[$slug];
						$attr_taxquery[]=array(
							'taxonomy'=>$slug,
							'field' => 'slug',
							'terms' => $tax
						);
					}
				} 
			} 
			//Attribute
			$attribute_taxonomies = wc_get_attribute_taxonomies();
			if(!empty($attribute_taxonomies)){
				foreach($attribute_taxonomies as $attr){
					if(!empty($_REQUEST['filter_'.$attr->attribute_name])){
						$term = $_REQUEST['filter_'.$attr->attribute_name];
						$attr_taxquery[] =  array(
												'taxonomy'      => 'pa_'.$attr->attribute_name,
												'field'         => 'slug',
												'terms'         => $term,
											);
					}
				}            
			}
			//Category
			if(isset( $_GET['product_cat'])) $cats = $_GET['product_cat'];
			if(!empty($cats)) {
				$cats = explode(",",$cats);
				$attr_taxquery[]=array(
					'taxonomy'=>'product_cat',
					'field'=>'slug',
					'terms'=> $cats
				);
			}
			//Price
			if( isset( $_GET['min_price']) && isset( $_GET['max_price']) ){
				$min = $_GET['min_price'];
				$max = $_GET['max_price'];
				$args['post__in'] = s7upf_filter_price($min,$max);
			}
			//Order By
			switch ($orderby) {
				case 'price' :
					$args['orderby']  = "meta_value_num ID";
					$args['order']    = 'ASC';
					$args['meta_key'] = '_price';
				break;

				case 'price-desc' :
					$args['orderby']  = "meta_value_num ID";
					$args['order']    = 'DESC';
					$args['meta_key'] = '_price';
				break;

				case 'popularity' :
					$args['meta_key'] = 'total_sales';
					add_filter( 'posts_clauses', array( WC()->query, 'order_by_popularity_post_clauses' ) );
				break;

				case 'rating' :
					add_filter( 'posts_clauses', array( WC()->query, 'order_by_rating_post_clauses' ) );
				break;

				case 'date':
					$args['orderby'] = 'date';
					break;
				
				default:
					$args['orderby'] = 'menu_order title';
					break;
			}
			//View Tye
			$grid_active = $list_active = '';
			if($type == 'grid') $grid_active = 'active'; 
			if($type == 'list') $list_active = 'active';
			
			if(!empty($attr_taxquery)) $args['tax_query'] = $attr_taxquery;
			
			$product_query = new WP_Query($args);
			$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
			ob_start();?>
			<div class="main-shop-load woocommerce">
				<div class="title-page">
					<div class="row">
						<div class="col-md-12">
							<?php if(!empty($shop_title)):?>
							<h2 class="title30 anton-font text-uppercase pull-left"><?php echo esc_html($shop_title);?></h2>
							<?php endif;?>
							<ul class="sort-pagi-bar list-inline-block pull-right">
								<li>
									<div class="dropdown-box sort-by select-box">
										<span class="text-uppercase gray"><?php esc_html_e("Sort By:","micar")?></span>
										<?php s7upf_catalog_ordering($product_query,$orderby)?>
									</div>
								</li>
								<li>
									<div class="dropdown-box show-by">
										<a href="javascript:void(0)" class="dropdown-link"><span class="text-uppercase gray">Show by:</span><span class="shop-show-value show-number-item silver"><?php echo esc_html($number)?></span></a>
										<ul class="dropdown-list list-none">
											<li><a data-number="6" href="<?php echo esc_url(s7upf_get_key_url('number','6'))?>"><?php esc_html_e("6","micar")?></a></li>
											<li><a data-number="9" href="<?php echo esc_url(s7upf_get_key_url('number','9'))?>"><?php esc_html_e("9","micar")?></a></li>
											<li><a data-number="12" href="<?php echo esc_url(s7upf_get_key_url('number','12'))?>"><?php esc_html_e("12","micar")?></a></li>
											<li><a data-number="18" href="<?php echo esc_url(s7upf_get_key_url('number','18'))?>"><?php esc_html_e("18","micar")?></a></li>
											<li><a data-number="24" href="<?php echo esc_url(s7upf_get_key_url('number','24'))?>"><?php esc_html_e("24","micar")?></a></li>
											<li><a data-number="48" href="<?php echo esc_url(s7upf_get_key_url('number','48'))?>"><?php esc_html_e("48","micar")?></a></li>
										</ul>
									</div>
								</li>
								<li>
									<div class="view-type">
										<a data-type="grid" href="<?php echo esc_url(s7upf_get_key_url('type','grid'))?>" class="<?php if($type == 'grid') echo 'active'?>"><i class="icon ion-grid"></i></a>
										<a data-type="list" href="<?php echo esc_url(s7upf_get_key_url('type','list'))?>" class="<?php if($type == 'list') echo 'active'?>"><i class="icon ion-navicon"></i></a>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- End Title Page -->
				<?php
					$check_sidebar = s7upf_check_sidebar(); 
					if($check_sidebar == false ){
						s7upf_search_filter();
					}
				?>
				<div class="product-box-<?php echo esc_attr($type)?>">
					<div class="row">
					<?php
						$count_product = 1;
						if($product_query->have_posts()) {
							while($product_query->have_posts()) {
								$product_query->the_post();
								global $product;
								if($type=='list'){
									echo s7upf_product_item('item-produc-list','','',$size);
								}	
								if($type=='grid'){
									echo s7upf_product_item('item-produc-grid',$item_num,'inner-zoom',$size);
								}
								$count_product++;
							}
						}
					?>
					</div>
				</div>
				<div class="pagi-nav text-center">
					<?php
						echo paginate_links( array(
							'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
							'format'       => '',
							'add_args'     => '',
							'current'      => max( 1, $paged ),
							'total'        => $product_query->max_num_pages,
							'prev_text'    => '<i class="icon ion-android-arrow-back"></i>',
							'next_text'    => '<i class="icon ion-android-arrow-forward"></i>',
							'type'         => 'plain',
							'end_size'     => 2,
							'mid_size'     => 1
						) );
					?>
				</div>
			</div>
			<?php
			$html .= ob_get_clean();
			wp_reset_postdata();
			return $html;
		}
	}

	stp_reg_shortcode('sv_shop','s7upf_vc_shop');

	vc_map( array(
		"name"      => esc_html__("SV Shop", 'micar'),
		"base"      => "sv_shop",
		"icon"      => "icon-st",
		"category"  => '7Up-theme',
		"params"    => array(
			array(
				'heading'     => esc_html__( 'Shop Title', 'micar' ),
				'type'        => 'textfield',
				'param_name'  => 'shop_title', 
				),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Style",'micar'),
				"param_name" => "style",
				"value"     => array(
					esc_html__("Grid",'micar')   => 'grid',
					esc_html__("List",'micar')   => 'list',
					),
				),
			array(
				'heading'     => esc_html__( 'Number', 'micar' ),
				'type'        => 'textfield',
				'description' => esc_html__( 'Enter number of product. Default is 12.', 'micar' ),
				'param_name'  => 'number',
				),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Order By",'micar'),
				"param_name" => "orderby",
				"value"         => array(
					esc_html__( 'Default sorting (custom ordering + name)', 'micar' ) => 'menu_order',
					esc_html__( 'Popularity (sales)', 'micar' )       => 'popularity',
					esc_html__( 'Average Rating', 'micar' )           => 'rating',
					esc_html__( 'Sort by most recent', 'micar' )      =>'date',
					esc_html__( 'Sort by price (asc)', 'micar' )      => 'price',
					esc_html__( 'Sort by price (desc)', 'micar' )     =>'price-desc',
					),
				),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Column",'micar'),
				"param_name" => "column",
				"value"         => array(
					esc_html__("1 Column","micar")          => '1',
					esc_html__("2 Column","micar")          => '2',
					esc_html__("3 Column","micar")          => '3',
					esc_html__("4 Column","micar")          => '4',
					esc_html__("6 Column","micar")          => '6',
					),
				"dependency"    => array(
					"element"   => "style",
					"value"   => "grid",
					)
				),
			),
	));
}