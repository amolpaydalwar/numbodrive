<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 05/09/15
 * Time: 10:00 AM
 */
if(class_exists("woocommerce")){
	if(!function_exists('sv_vc_product_gallery'))
	{
		function sv_vc_product_gallery($attr, $content = false)
		{
			$html = $view_html = '';
			extract(shortcode_atts(array(
				'title'			  => '',	
				'desc'			  => '',	
				'style'           => '',
				'color'           => '',
				'access'          => '',
				'class_extra'     => '',
				'custom_css'      => '',
			),$attr));
			
			ob_start();
			?>
			<div class="featured-product2 <?php echo esc_attr($class_extra);?>">
				<div class="container">
					<?php if(!empty($title)):?>
					<div class="intro-product-box2 text-center text-uppercase">
						<h2 class="title30 anton-font"><?php echo esc_html($title);?></h2>
						<?php if(!empty($desc)):?>	
						<h3 class="title18 font-light"><?php echo esc_html($desc);?></h3>
						<?php endif;?>
					</div>
					<?php endif;?>
					<div class="featured-tab2">
						<?php
							$data_style = (array) vc_param_group_parse_atts( $style );
							if(isset($data_style)): 
						?>
						<div id="style" class="bx-slider bx-style">
							<ul class="list-none bxslider">
								<?php foreach ($data_style as $key => $value):?>
								<li><img src="<?php echo wp_get_attachment_url($value['image_intro']);?>" alt="" /></li>
								<?php endforeach;?>
							</ul>
							<div class="bx-pager">
								<?php foreach ($data_style as $key => $value):?>
								<a data-slide-index="<?php echo esc_attr($key);?>" href=""><img src="<?php echo wp_get_attachment_url($value['image_thumb']);?>" alt="" /></a>
								<?php endforeach;?>
							</div>
						</div>
						<?php endif;?>
						<?php
							$data_color = (array) vc_param_group_parse_atts( $color );
							if(isset($data_color)): 
						?>
						<div id="color" class="bx-slider bx-color active">
							<ul class="list-none bxslider">
								<?php foreach ($data_color as $key => $value):?>
								<li><img src="<?php echo wp_get_attachment_url($value['image']);?>" alt="" /></li>
								<?php endforeach;?>
							</ul>
							<div class="bx-pager">
								<?php foreach ($data_color as $key => $value):?>
								<a data-slide-index="<?php echo esc_attr($key);?>" class="shop-button gradient <?php echo S7upf_Assets::build_css('background: '.$value['color'].';');?>" href=""></a>
								<?php endforeach;?>
							</div>
						</div>
						<?php endif;?>
						<?php
							$data_access = (array) vc_param_group_parse_atts( $access );
							if(isset($data_access)): 
						?>
						<div id="access" class="bx-slider bx-access">
							<ul class="list-none bxslider">
								<?php foreach ($data_access as $key => $value):?>
								<li><img src="<?php echo wp_get_attachment_url($value['image']);?>" alt="" /></li>
								<?php endforeach;?>
							</ul>
						</div>
						<?php endif;?>
					</div>
				</div>
				<div class="tab-control">
					<div class="container">
						<div class="inner-tab-control text-center">
							<a href="#" data-control="style" class="shop-button"><?php echo esc_html__('styling','micar')?></a>
							<a href="#" data-control="color" class="shop-button active"><?php echo esc_html__('colors','micar')?></a>
							<a href="#" data-control="access" class="shop-button"><?php echo esc_html__('accessories','micar')?></a>
						</div>
					</div>
				</div>
			</div>
			<!-- End Featured Product -->
			<?php
			
			$html = @ob_get_clean();
			return $html;
		}
	}

	stp_reg_shortcode('sv_product_gallery','sv_vc_product_gallery');

	vc_map( array(
		"name"      => esc_html__("SV Product Gallery", 'micar'),
		"base"      => "sv_product_gallery",
		"icon"      => "icon-st",
		"category"  => '7Up-theme',
		"params"    => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__("Title",'micar'),
				"param_name" => "title",
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Description",'micar'),
				"param_name" => "desc",
			),
			array(
				'heading'     => esc_html__( 'Style', 'micar' ),
				'type'        => 'param_group',
				'param_name'  => 'style',
				"params"    => array(
					array(
						"type" => "attach_image",
						"heading" => esc_html__("Image Thumbnail",'micar'),
						"param_name" => "image_thumb",
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__("Image Intro",'micar'),
						"param_name" => "image_intro",
					),
				),
			),
			array(
				'heading'     => esc_html__( 'Color', 'micar' ),
				'type'        => 'param_group',
				'param_name'  => 'color',
				"params"    => array(
					array(
						"type" => "colorpicker",
						"heading" => esc_html__("Color",'micar'),
						"param_name" => "color",
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__("Image",'micar'),
						"param_name" => "image",
					),
				),
			),
			array(
				'heading'     => esc_html__( 'Accessories', 'micar' ),
				'type'        => 'param_group',
				'param_name'  => 'access',
				"params"    => array(
					array(
						"type" => "attach_image",
						"heading" => esc_html__("Image Access",'micar'),
						"param_name" => "image",
					),
				),
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
