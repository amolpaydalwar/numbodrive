<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
// vc_map_add_css_animation()
//s7upf_getCSSAnimation($css_animation)
if(!function_exists('s7upf_vc_logo'))
{
    function s7upf_vc_logo($attr,$content = false)
    {
        $html = $logo = $css_class = '';
        extract(shortcode_atts(array(
            'style'      => '',
            'logo_img'      => '',
            'class_extra'         => '',
            'custom_css'          => '',
        ),$attr));
		if(!empty($custom_css)) $css_class = vc_shortcode_custom_css_class( $custom_css );
        if(!empty($logo_img)){
            $img = wp_get_attachment_image_src( $logo_img ,"full");
            $logo .= $img[0];
        }
        else{
            $logo .= s7upf_get_option('logo');
        }
        if(!empty($logo)){
			switch($style){
				case 'text':
				$html .=    '<div class="logo '.$css_class.' '.esc_attr($class_extra).'">
								<h1 class="hidden">'.get_bloginfo('name', 'display').'</h1>	
								<a href="'.esc_url(get_home_url('/')).'">
									'.wpb_js_remove_wpautop($content, true).'
								</a>
							</div>';
				break;
				
				default:
				$html .=    '<div class="logo '.$css_class.' '.esc_attr($class_extra).'">
								<h1 class="hidden">'.get_bloginfo('name', 'display').'</h1>	
								<a href="'.esc_url(get_home_url('/')).'"><img src="'.esc_url($logo).'" alt="logo"></a>
							</div>';
				break;			
			}			
        }
        
        return $html;
    }
}

stp_reg_shortcode('s7upf_logo','s7upf_vc_logo');

vc_map( array(
    "name"      => esc_html__("SV Logo", 'micar'),
    "base"      => "s7upf_logo",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
		array(
            "type"          => "dropdown",
            "holder"        => "div",
            "heading"       => esc_html__("Style",'micar'),
            "param_name"    => "style",
            "value"         => array(
                esc_html__("Default","micar")   => 'default',
                esc_html__("Text","micar")   => 'text',
			),
        ),
		array(
            "type" => "textarea_html",
            "holder" => "div",
            "heading" => esc_html__("Content",'micar'),
            "param_name" => "content",
			'dependency'    => array(
                'element'   => 'style',
                'value'   => array('text'),
			)
        ),
        array(
            "type" => "attach_image",
            "holder" => "div",
            "heading" => esc_html__("Logo image",'micar'),
            "param_name" => "logo_img",
			'dependency'    => array(
                'element'   => 'style',
                'value'   => array('default'),
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