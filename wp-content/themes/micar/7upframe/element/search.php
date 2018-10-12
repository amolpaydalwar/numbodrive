<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('s7upf_vc_search'))
{
    function s7upf_vc_search($attr,$content = false)
    {
        $html = $css_class = '';
        extract(shortcode_atts(array(
            'style'         => '',
            'placeholder'   => '',
			'class_extra'   => '',
			'custom_css'    => '',
        ),$attr));
		if(!empty($custom_css)) $css_class = vc_shortcode_custom_css_class( $custom_css );
        switch ($style) {
            case 'search-form2':
                $html .=    '<form action="'.esc_url(home_url( '/' )).'" method="get" class="search-form2 '.$css_class.' '.esc_attr($class_extra).'">
								<input type="text" name="s" placeholder="'.esc_attr($placeholder).'" value="">
								<div class="submit-form gradient bg-color2">
									<input type="submit">
								</div>
							</form>';
                break;
				
            case 'search-form4':
                $html .=    '<form action="'.esc_url(home_url( '/' )).'" method="get" class="search-form2 '.esc_attr($style).' '.$css_class.' '.esc_attr($class_extra).'">
								<input type="text" name="s" placeholder="'.esc_attr($placeholder).'" value="">
								<div class="submit-form">
									<input type="submit">
								</div>
							</form>';
                break;
				
            default:
                $html .=    '<form action="'.esc_url(home_url( '/' )).'" method="get" class="search-form-default '.$css_class.' '.esc_attr($class_extra).'">
								<input type="text" name="s" placeholder="'.esc_attr($placeholder).'" value="">
								<div class="submit-form">
									<input type="submit">
								</div>
							</form>';
                break;
        }        
        
        return $html;
    }
}

stp_reg_shortcode('s7upf_search','s7upf_vc_search');

vc_map( array(
    "name"      => esc_html__("SV Search", 'micar'),
    "base"      => "s7upf_search",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type"          => "dropdown",
            "holder"        => "div",
            "heading"       => esc_html__("Style",'micar'),
            "param_name"    => "style",
            "value"         => array(
                esc_html__("Default","micar")   => '',
                esc_html__("Search Form 2","micar")   => 'search-form2',
                esc_html__("Search Form 4","micar")   => 'search-form4',
                ),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Text Place Holder",'micar'),
            "param_name" => "placeholder",
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