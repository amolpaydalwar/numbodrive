<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('s7upf_vc_banner_background'))
{
    function s7upf_vc_banner_background($attr,$content=false)
    {
        $html = $css_class = '';
        extract(shortcode_atts(array(
            'style'       => '',
            'image'       => '',      
			'class_extra'     => '',
			'custom_css'      => '',           
        ),$attr));
		if(!empty($custom_css)) $css_class = vc_shortcode_custom_css_class( $custom_css );
		if(!empty($image)){
			switch($style){
				
				case 'banner-zoom-way':
				
					$html .=   	'<div class="'.$style.' '.$css_class.' '.$class_extra.' banner-background" data-image="'.wp_get_attachment_url($image).'">
									<div class="container text-uppercase">
										'.wpb_js_remove_wpautop($content, true).'
									</div> 
								</div>'; 
								
				break;
				
				case 'banner-gal5':
				
					$html .=   	'<div class="'.$style.' '.$css_class.' '.$class_extra.' parallax" data-image="'.wp_get_attachment_url($image).'">
									<div class="banner-info white text-uppercase">
										<div class="container">
											'.wpb_js_remove_wpautop($content, true).'
										</div> 
									</div> 
								</div>'; 
								
				break;
				
				default:
				
					$html .=   	'<div class="'.$class_extra.' '.$css_class.' banner-background" data-image="'.wp_get_attachment_url($image).'">
										'.wpb_js_remove_wpautop($content, true).'
								</div>'; 
								
				break;	
			}
			
		}
        return $html;
    }
}

stp_reg_shortcode('sv_banner_background','s7upf_vc_banner_background');

vc_map( array(
    "name"      => esc_html__("SV Banner Background", 'micar'),
    "base"      => "sv_banner_background",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(        
        array(
			'type' => 'dropdown',
			'admin_label' => true,
			'heading' => esc_html__( 'Style', 'micar' ),
			'param_name' => 'style',
			'value' => array(
				esc_html__('Default','micar')=>'',
				esc_html__('Home 1','micar')=>'banner-zoom-way',
				esc_html__('Home 5','micar')=>'banner-gal5',
			),
			'description' => esc_html__( 'Select style', 'micar' )
		),
        array(
			"type" => "attach_image",
			"heading" => esc_html__("Image Background",'micar'),
			"param_name" => "image",
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"heading" => esc_html__("Content",'micar'),
			"param_name" => "content",
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