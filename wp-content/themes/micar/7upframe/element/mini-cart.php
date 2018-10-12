<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('s7upf_vc_mini_cart'))
{
    function s7upf_vc_mini_cart($attr)
    {
        $html = $css_class = '';
        extract(shortcode_atts(array(
            'style'           => 'mini-cart1',
            'custom_css'      => '',
            'class_extra'     => '',
        ),$attr));
		if(!empty($custom_css)) $css_class = vc_shortcode_custom_css_class( $custom_css );
		if(method_exists(WC()->cart,'get_cart_url')){
			switch($style){
				case 'mini-cart1':
					$html .=    '<div class="mini-cart-box dropdown-box inline-block '.esc_attr($style).' '.$css_class.' '.esc_attr($class_extra).'">
									<a class="mini-cart-link micart-link" href="'.wc_get_cart_url().'">
										<span class="mini-cart-icon title48 color"><i class="icon ion-android-cart"></i></span>
										<span class="mini-cart-number">
											<strong class="white text-uppercase">Shopping Cart</strong>
											<span class="color total-price"><span class="cart-item-count set-cart-number">0</span> '.esc_html__("item -","micar").'<span class="total-mini-cart-price set-cart-price">'.WC()->cart->get_cart_total().'</span></span>
										</span>
									</a>
									<div class="dropdown-list mini-cart-main-content mini-cart-content text-left">'.s7upf_mini_cart().'</div>
								</div>';
				break;	
				
				case 'mini-cart2':
					$html .=    '<div class="mini-cart-box dropdown-box '.esc_attr($style).' '.$css_class.' '.esc_attr($class_extra).'">
									<a class="mini-cart-link micart-link gradient" href="'.wc_get_cart_url().'">
										<span class="mini-cart-icon title24 white"><i class="icon ion-android-cart"></i></span>
										<span class="mini-cart-number white bg-color round"><span class="cart-item-count set-cart-number">0</span></span>
									</a>
									<div class="dropdown-list mini-cart-content mini-cart-main-content text-left">'.s7upf_mini_cart().'</div>
								</div>';
				break;	
					
				case 'mini-cart3':
					$html .=    '<div class="mini-cart-box dropdown-box '.esc_attr($style).' '.$css_class.' '.esc_attr($class_extra).'">
									<a class="mini-cart-link micart-link" href="'.wc_get_cart_url().'">
										<span class="mini-cart-icon title30 white"><i class="icon ion-android-cart"></i></span>
										<span class="mini-cart-number round bg-color white title12"><span class="cart-item-count set-cart-number">0</span></span>
									</a>
									<div class="dropdown-list mini-cart-content mini-cart-main-content text-left">'.s7upf_mini_cart().'</div>
								</div>';
				break;	
						
				case 'mini-cart4':
					$html .=    '<div class="mini-cart-box dropdown-box mini-cart2 '.esc_attr($style).' '.$css_class.' '.esc_attr($class_extra).'">
									<a class="mini-cart-link" href="'.wc_get_cart_url().'">
										<span class="mini-cart-icon title24 black"><i class="icon ion-android-cart"></i></span>
										<span class="mini-cart-number white bg-color round"><span class="cart-item-count set-cart-number">0</span></span>
									</a>
									<div class="dropdown-list mini-cart-content mini-cart-main-content text-left">'.s7upf_mini_cart().'</div>
								</div>';
				break;	
					
				case 'mini-cart6':
					$html .=    '<div class="mini-cart-box dropdown-box '.esc_attr($style).' '.$css_class.' '.esc_attr($class_extra).'">
									<a class="mini-cart-link" href="'.wc_get_cart_url().'">
										<span class="mini-cart-label white text-uppercase">'.esc_html__('Cart','micar').'</span>
										<span class="mini-cart-icon title24 white"><i class="icon ion-android-cart"></i></span>
										<span class="mini-cart-number white bg-color round"><span class="cart-item-count set-cart-number">0</span></span>
									</a>
									<div class="dropdown-list mini-cart-content mini-cart-main-content text-left">'.s7upf_mini_cart().'</div>
								</div>';
				break;	
					
				default:
					$html .=    '<div class="mini-cart-box dropdown-box inline-block '.esc_attr($style).' '.$css_class.' '.esc_attr($class_extra).'">
									<a class="mini-cart-link micart-link" href="'.wc_get_cart_url().'">
										<span class="mini-cart-icon title48 color"><i class="icon ion-android-cart"></i></span>
										<span class="mini-cart-number">
											<strong class="white text-uppercase">Shopping Cart</strong>
											<span class="color total-price"><span class="cart-item-count set-cart-number">0</span> '.esc_html__("item -","micar").'<span class="total-mini-cart-price set-cart-price">'.WC()->cart->get_cart_total().'</span></span>
										</span>
									</a>
									<div class="dropdown-list mini-cart-content mini-cart-main-content text-left">'.s7upf_mini_cart().'</div>
									<div class="total-default hidden"><'.wc_price(0).'</div>
								</div>';
				break;		
							
			}	
		}
        return apply_filters('s7upf_tempalte_mini_cart',$html);
    }
}

stp_reg_shortcode('sv_mini_cart','s7upf_vc_mini_cart');

vc_map( array(
    "name"      => esc_html__("SV Mini Cart", 'micar'),
    "base"      => "sv_mini_cart",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            'heading'     => esc_html__( 'Style', 'micar' ),
            'type'        => 'dropdown',
            'param_name'  => 'style',
            'value'       => array(
                esc_html__('Style 1','micar') => 'mini-cart1',
                esc_html__('Style 2','micar') => 'mini-cart2',
                esc_html__('Style 3','micar') => 'mini-cart3',
                esc_html__('Style 4','micar') => 'mini-cart4',
                esc_html__('Style 5','micar') => 'mini-cart6',
                )
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