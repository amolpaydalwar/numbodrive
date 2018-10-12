<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
if(!function_exists('s7upf_vc_calendar'))
{
    function s7upf_vc_calendar($attr,$content=false)
    {
        $html = $css_class = '';
        extract(shortcode_atts(array(
            'title'               => '',
            'class_extra'         => '',
            'custom_css'          => '',
        ),$attr));
		if(!empty($custom_css)) $css_class = vc_shortcode_custom_css_class( $custom_css );
        $html .=    '<div class="open-store text-uppercase dropdown-box '.$css_class.' '.esc_attr($class_extra).'">';
		$html .=		'<p class="desc white text-right"><i class="icon ion-clock"></i>'.esc_attr($title).'</p>';
		$html .=		'<div class="dropdown-list">'.wpb_js_remove_wpautop($content, true).'</div>';
        $html .=    '</div>';   
		return  $html;
    }
}

stp_reg_shortcode('sv_calendar','s7upf_vc_calendar');


vc_map( array(
    "name"      => esc_html__("SV Calendar", 'micar'),
    "base"      => "sv_calendar",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
		array(
            "type" => "textfield",
            "heading" => esc_html__( "Title", "micar" ),
            "param_name" => "title",
            "description" => esc_html__( "Title Calender.", "micar" )
        ),
        array(
			'type'       => 'textarea_html',
			'heading'    => esc_html__( 'Content', 'micar' ),
			'param_name' => 'content',
			'description' => esc_html__( 'Content Calendar', 'micar' ),
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