<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
if(!function_exists('s7upf_vc_category_product_tab'))
{
    function s7upf_vc_category_product_tab($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'         => 'style1',
            'bg_style'      => 'cat-product-dark',
            'title'         => '',
            'link'          => '',
            'image'         => '',
            'cats'          => '',
			'number'        => '6',
        ),$attr));
		ob_start();
		
		if(!empty($cats)){
			
			$cat_slug = explode(',',$cats);
			
			if($style=='style1'){
				?>
				<div class="<?php echo esc_attr($bg_style);?>">
					<div class="cat-title1">
						<?php if(!empty($title)):?>
						<h2 class="title30 white font-bold text-uppercase inline-block"><?php echo esc_html($title);?></h2>
						<?php endif;?>
						<ul class="title-tab1 inline-block list-inline-block">
							<?php
								foreach($cat_slug as $key=>$value):
								$term = get_term_by('slug',$value,'product_cat');
							?>
							<li class="<?php if($key==0){echo "active";}?>"><a href="#tab<?php echo esc_attr($key+1);?>" class="shop-button" data-toggle="tab"><?php echo esc_html($term->name);?></a></li>
							<?php endforeach;?>
						</ul>
						<?php
						$data_link = vc_build_link($link);
						if(!empty($data_link)){
							echo '<a href="'.esc_url($data_link['url']).'" class="link-arrow text-uppercase color wobble-top">'.esc_html($data_link['title']).'<i class="icon ion-ios-arrow-thin-right"></i></a>';
						}
						?>	
					</div>
					<div class="tab-content">
						<div class="cat-thumb1"><?php echo wp_get_attachment_image($image,'full');?></div>
						<?php
							foreach($cat_slug as $key=>$value):
							$term = get_term_by('slug',$value,'product_cat');
						?>
						<div id="tab<?php echo esc_attr($key+1);?>" class="tab-pane <?php if($key==0){echo "active";}?>">
							<div class="content-cate-box1">
								<div class="list-cat-pro1">
									<div class="row">
										<?php
											if(is_object($term) && !empty($term)):
											$term_children = get_term_children( $term->term_id, $term->taxonomy);
											if(!empty($term_children)):
											foreach($term_children as $key=>$children):
											if($key<$number):
											$term = get_term( $children, 'product_cat' );
										?>
										<div class="col-md-4 col-sm-6 col-xs-6">
											<div class="item-cat-pro1 text-center">
												<a href="<?php echo get_term_link($term->term_id,'product_cat');?>">
													<img class="wobble-horizontal" src="<?php echo wp_get_attachment_url(get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ));?>" alt="<?php echo esc_html($term->name);?>" />	
													<h3 class="title14 text-uppercase white"><?php echo esc_html($term->name);?></h3>
												</a>
											</div>
										</div>
										<?php endif;endforeach;endif;endif;?>
									</div>
								</div>
							</div>
						</div>
						<!-- End Tab -->
						<?php endforeach;?>
					</div>
				</div>
				<?php
			}
			if($style=='style2'){
				?>
				<div class="model-title">
					<?php if(isset($title)):?>
					<h2 class="title30 text-uppercase anton-font"><?php echo esc_html($title);?></h2>
					<?php endif;?>
					<ul class="title-tab1 list-inline-block">
						<?php
							foreach($cat_slug as $key=>$value):
							$term = get_term_by('slug',$value,'product_cat');
						?>
						<li class="<?php if($key==0){echo "active";}?>"><a href="#tab<?php echo esc_attr($key+1);?>" class="shop-button" data-toggle="tab"><?php echo esc_html($term->name);?></a></li>
						<?php endforeach;?>
					</ul>
				</div>
				<div class="tab-content">
					<?php
						foreach($cat_slug as $key=>$value):
						$term = get_term_by('slug',$value,'product_cat');
						if(is_object($term) && !empty($term)):
					?>
					<div id="tab<?php echo esc_attr($key+1);?>" class="tab-pane <?php if($key==0){echo "active";}?>">
						<div class="car-model-slider product-slider">
							<div class="wrap-item" data-pagination="false" data-navigation="true" data-itemscustom="[[0,1],[560,2],[768,3],[990,4]]">
								<?php
									$term_children = get_term_children( $term->term_id, $term->taxonomy);
									if(!empty($term_children)):
									foreach($term_children as $key=>$children):
									if($key<$number):
									$term = get_term( $children, 'product_cat' );
								?>
								<div class="item-model-pro item-product text-center">
									<a href="<?php echo get_term_link($term->term_id,'product_cat');?>">
										<img class="wobble-horizontal" src="<?php echo wp_get_attachment_url(get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ));?>" alt="<?php echo esc_html($term->name);?>" />
										<h3 class="title14 text-uppercase"><?php echo esc_html($term->name);?></h3>
									</a>
								</div>
								<?php endif;endforeach;endif;?>
							</div>
						</div>
					</div>
					<!-- End Tab -->
					<?php endif;endforeach;?>
				</div>
				<?php
			}
			if($style=='style3'){
				?>
				<div class="model-title6">
					<?php if(isset($title)):?>
					<h2 class="text-center title30 text-uppercase anton-font"><?php echo esc_html($title);?></h2>
					<?php endif;?>
					<ul class="tab-title6 list-inline-block text-center text-uppercase">
						<?php
							foreach($cat_slug as $key=>$value):
							$term = get_term_by('slug',$value,'product_cat');
						?>
						<li class="<?php if($key==0){echo "active";}?>"><a href="#tab<?php echo esc_attr($key+1);?>" class="shop-button" data-toggle="tab"><?php echo esc_html($term->name);?></a></li>
						<?php endforeach;?>
					</ul>
				</div>
				<div class="tab-content">
					<?php
						foreach($cat_slug as $key=>$value):
						$term = get_term_by('slug',$value,'product_cat');
						if(is_object($term) && !empty($term)):
					?>
					<div id="tab<?php echo esc_attr($key+1);?>" class="tab-pane <?php if($key==0){echo "active";}?>">
						<div class="list-model6">
							<div class="row">
								<?php
									$term_children = get_term_children( $term->term_id, $term->taxonomy);
									if(!empty($term_children)):
									foreach($term_children as $key=>$children):
									if($key<$number):
									$term = get_term( $children, 'product_cat' );
									
									$args = array(
										'post_type'         => 'product',
										'posts_per_page'    => -1,
										'tax_query' => array(
											array(
												'taxonomy' => $term->taxonomy,
												'field'    => 'slug',
												'terms'    => $term->slug,
											),
										),
									);
									global  $woocommerce;
									$product_query = new WP_Query($args);
									
									if($product_query->have_posts()) {
										$min_price     = array();
										while($product_query->have_posts()) {
											$product_query->the_post();
											global $product;
											if( $product->is_type( 'simple' ) ){
												$min_price[]  = (float)$product->get_regular_price();
											} elseif( $product->is_type( 'variable' ) ){
												$min_price[]  = (float)$product->get_variation_price('min');
											}
										}
										$minimum_price = min($min_price);
									}
									wp_reset_postdata();
									
								?>
								<div class="col-md-4 col-sm-6 col-xs-6">
									<div class="item-model6">
										<a href="<?php echo get_term_link($term->term_id,'product_cat');?>">
											<img class="wobble-horizontal" src="<?php echo wp_get_attachment_url(get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ));?>" alt="<?php echo esc_html($term->name);?>" />
										</a>
										<h3 class="title18 text-uppercase"><a href="<?php echo get_term_link($term->term_id,'product_cat');?>"><?php echo esc_html($term->name);?></a></h3>
										<span class="title14 silver"><?php echo esc_html__('from ','micar'); echo get_woocommerce_currency_symbol(); echo esc_html($minimum_price);?></span>
									</div>
								</div>
								<?php endif;endforeach;endif;?>
							</div>
						</div>
					</div>
					<!-- End Tab -->
					<?php endif;endforeach;?>
				</div>
				<?php
			}
		}
		$html = @ob_get_clean();
		return  $html;
    }
}

stp_reg_shortcode('sv_category_product_tab','s7upf_vc_category_product_tab');

$check_add = '';
if(isset($_GET['return'])) $check_add = $_GET['return'];
if(empty($check_add)) add_action( 'vc_before_init_base','sv_add_category_product_tab',10,100 );
if ( ! function_exists( 'sv_add_category_product_tab' ) ) {
	function sv_add_category_product_tab(){
		vc_map( array(
			"name"      => esc_html__("SV Category Product Tab", 'micar'),
			"base"      => "sv_category_product_tab",
			"icon"      => "icon-st",
			"category"  => '7Up-theme',
			"params"    => array(
				array(
					'type' => 'dropdown',
					'admin_label' => true,
					'heading' => esc_html__( 'Style', 'micar' ),
					'param_name' => 'style',
					'value' => array(
						esc_html__('Gallery','micar')=>'style1',
						esc_html__('Slider','micar')=>'style2',
						esc_html__('Grid','micar')=>'style3',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Style Background', 'micar' ),
					'param_name' => 'bg_style',
					'value' => array(
						esc_html__('Dark','micar')        => 'cat-product-dark',
						esc_html__('Light','micar')       => 'cat-product-light',
					),
					"dependency"    => array(
						'element'   => 'style',
						'value'     => array('style1')
					),
				),  
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title Block",'micar'),
					"param_name" => "title",
				),
				array(
					"type" => "vc_link",
					"heading" => esc_html__("Extra Link",'micar'),
					"param_name" => "link",
					"dependency"    =>array(
						'element'   =>'style',
						'value'     =>array('style1')
					),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Image Gallery",'micar'),
					"param_name" => "image",
					"dependency"    =>array(
						'element'   =>'style',
						'value'     =>array('style1')
					),
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
					'description' => esc_html__( 'List Tab Categories', 'micar' ),
				),
				array(
					'heading'     => esc_html__( 'Number', 'micar' ),
					'type'        => 'textfield',
					'description' => esc_html__( 'Enter number sub category . Default is 6.', 'micar' ),
					'param_name'  => 'number',
				),
			)
		));
	}
}	