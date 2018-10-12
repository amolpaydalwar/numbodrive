<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
	 
	global $product;
	$has_sidebar='';
	$check_sidebar = s7upf_check_sidebar();
	if($check_sidebar == true){
		$has_sidebar='has-sidebar';
	}
?>
<div class="content-product-detail <?php echo esc_attr($has_sidebar);?>">
	<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php 
			$style = s7upf_get_value_by_id('product_layout');
			switch($style){
				case 'style3':
				case 'style2':
					?>
						<div class="product-detail fixed-detail-info border">
							<?php s7upf_product_main_detail()?>
							<?php s7upf_product_tab_detail();?>			
						</div>
					<?php
					break;
					
				case 'style4':
					?>
						<div class="product-detail-gallery">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<?php s7upf_product_main_detail()?>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<?php s7upf_product_tab_detail('gallery');?>	
								</div>
							</div>
						</div>
					<?php
					break;
					
				case 'style5':
					$detail_360 = get_post_meta(get_the_ID(),'detail_view_360',true);
					?>
						<?php if (!empty($detail_360)): ?>
						<div class="detail-car-color detail-car-360 text-center text-uppercase">
							<h2 class="title30 anton-font text-center"><?php echo get_the_title();?></h2>
							<div class="detail-tab-color">
								<div class="tab-content">
									<?php
										foreach($detail_360 as $key=>$data):
										$active="";
										if($key==0){$active="active";}
										$gal_view = explode(',', $data['image_view']);
									?>
									<div id="color_<?php echo esc_attr($key);?>" class="tab-pane <?php echo esc_attr($active);?>">
										<div class="slider-view-360">
											<div class="wrap-item" data-itemscustom="[[0,1]]" data-navigation="true" data-pagination="false" data-transition="fade">
												<?php
													foreach($gal_view as $key=>$value){
														echo '<div class="item"><img src="'.wp_get_attachment_url($value).'" alt="" /></div>';
													}
												?>
											</div>
										</div>
										<h2 class="title18 title-color-360"><?php echo esc_attr($data['title']);?></h2>
									</div>
									<?php endforeach;?>
								</div>
								<ul class="list-tab-color list-inline-block">
									<?php
										foreach($detail_360 as $key=>$value){
											$active="";
											if($key==0){$active="active";}
											echo '<li class="'.$active.'"><a href="#color_'.$key.'" data-toggle="tab"><span style="background:'.$value['color_view'].'"></span></a></li>';
										}
									?>
								</ul>
							</div>
						</div>
						<?php endif;?>
						<div class="product-detail-gallery">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<?php s7upf_product_main_detail()?>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<?php s7upf_product_tab_detail('gallery');?>	
								</div>
							</div>
						</div>
					<?php
					break;
					
				default:
					?>
						<div class="product-detail border">
							<?php s7upf_product_main_detail()?>
							<?php s7upf_product_tab_detail();?>			
						</div>
					<?php
					break;
			}
		?>	
		<?php
			s7upf_single_relate_product();
			s7upf_single_upsell_product();
			s7upf_single_latest_product();
		?>
	</div>
	<?php do_action( 'woocommerce_after_single_product' ); ?>
</div>
