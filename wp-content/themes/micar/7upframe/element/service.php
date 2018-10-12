<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('s7upf_vc_service'))
{
    function s7upf_vc_service($attr,$content = false)
    {
        $html = $css_class = '';
        extract(shortcode_atts(array(
            'style'      => 'item-service2',
            'image'      => '',
            'icon'       => '',
            'title'      => '',
            'bg_color'   => '',
            'link'       => '',
            'button'     => '',
			'class_extra'   => '',
			'custom_css'    => '',
        ),$attr));
		if(!empty($custom_css)) $css_class = vc_shortcode_custom_css_class( $custom_css );
		if(!empty($button)) $button = vc_build_link($button);
        if(!empty($bg_color)) $bg_color = S7upf_Assets::build_css('background-color:'.$bg_color);
        if(!empty($icon)) $icon = '<i class="'.esc_attr($icon).'"></i>';
        switch ($style) {
            case 'item-service2':
                $html .=    '<div class="item-service2 table '.$css_class.' '.esc_attr($class_extra).'">
                                <div class="service-icon">
                                    <a class="color title60" href="'.esc_url($link).'">'.$icon.'</a>
                                </div>
                                <div class="service-info">
                                    '.wpb_js_remove_wpautop($content, true).'
                                </div>
                            </div>';
                break;

            case 'item-service3':
                $html .=    '<div class="item-service3 text-center bg-white drop-shadow '.$css_class.' '.esc_attr($class_extra).'">
                                <span class="title60">'.$icon.'</span>
								'.wpb_js_remove_wpautop($content, true).'
								<a href="'.esc_url($button['url']).'" class="shop-button bg-color small">'.esc_html($button['title']).'</a>
                            </div>';
                break;

            case 'item-client2':
                $html .=    '<div class="item-client2 '.esc_attr($bg_color).' '.$css_class.' '.esc_attr($class_extra).'">
								<div class="client-thumb pull-right"><a href="'.esc_url($link).'">'.wp_get_attachment_image($image,array(90,90)).'</a></div>
								'.wpb_js_remove_wpautop($content, true).'
							</div>';
                break;

            case 'item-policy3':
                $html .=    '<div class="item-policy3  '.$css_class.' '.esc_attr($class_extra).'">
								<a href="'.esc_url($link).'" class="shop-button bg-white black title18 text-uppercase"><span class="title30 color">'.$icon.'</span> <span>'.$title.'</span></a>
							</div>';
                break;

            case 'item-custom-box':
                $html .=    '<div class="item-custom-box text-center text-uppercase  '.$css_class.' '.esc_attr($class_extra).'">
								<a href="'.esc_url($link).'" class="color">'.$icon.' <h3 class="title18">'.$title.'</h3></a>
							</div>';
                break;

            case 'contact-box':
                $html .=    '<div class="contact-box  '.$css_class.' '.esc_attr($class_extra).'">
                                <span class="color">'.$icon.'</span>
                                '.wpb_js_remove_wpautop($content, true).'
                            </div>';
                break;

            case 'about-style':
                $html .=    '<div class="item-about-service text-center white '.esc_attr($bg_color).'">
                                <a href="'.esc_url($link).'" class="wobble-horizontal">'.$icon.'</a>
                                '.wpb_js_remove_wpautop($content, true).'
                            </div>';
                break;
            
            default:
                $html .=    '<div class="item-service table '.$css_class.' '.esc_attr($class_extra).'">
                                <div class="service-icon">
                                    <a href="'.esc_url($link).'">'.wp_get_attachment_image($image,'full',0,array('class'=>'pulse round')).'</a>
                                </div>
                                <div class="service-text">
                                    '.wpb_js_remove_wpautop($content, true).'
                                </div>
                            </div>';
                break;
        }        
        
        return $html;
    }
}

stp_reg_shortcode('s7upf_service','s7upf_vc_service');

vc_map( array(
    "name"      => esc_html__("SV Service", 'micar'),
    "base"      => "s7upf_service",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type"          => "dropdown",
            "holder"        => "div",
            "heading"       => esc_html__("Style",'micar'),
            "param_name"    => "style",
            "value"         => array(
                esc_html__("Service Home 2","micar")   => 'item-service2',
                esc_html__("Service Home 3","micar")   => 'item-service3',
                esc_html__("Client Home 2","micar")   => 'item-client2',
                esc_html__("Policy Home 3","micar")   => 'item-policy3',
                esc_html__("Service Home 6","micar")   => 'item-custom-box',
                esc_html__("About style","micar")   => 'about-style',
                esc_html__("Contact box","micar")   => 'contact-box',
                ),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Link",'micar'),
            "param_name" => "link",
        ),
		array(  
			'type' => 'iconpicker' ,
			'heading' => esc_html__('Icon', 'micar'),
			'param_name' => 'icon',
			'value' => '', // default value to backend editor admin_label
			'settings' => array(
				'emptyIcon' => false,
				'type' => 'ionicon',
				'iconsPerPage' => 100,
			),
			'description' =>  esc_html__( 'Select icon from Ion icon library.', 'micar' ),
			'dependency'    => array(
                'element'   => 'style',
                'value'   => array('about-style','contact-box','item-service2','item-service3','item-policy3','item-custom-box'),
            )
		),
        array(
            "type" => "attach_image",
            "heading" => esc_html__("Image",'micar'),
            "param_name" => "image",
            'dependency'    => array(
                'element'   => 'style',
                'value'   => array('item-client2'),
                )
        ),
		array(
            "type" => "textfield",
            "heading" => esc_html__("Title",'micar'),
            "param_name" => "title",
			'dependency'    => array(
                'element'   => 'style',
                'value'   => array('item-policy3','item-custom-box'),
            )
        ),
        array(
            "type"          => "colorpicker",
            "heading"       => esc_html__("Background Color",'micar'),
            "param_name"    => "bg_color",
			'dependency'    => array(
                'element'   => 'style',
                'value'   => array('about-style','item-client2'),
			)
        ),
        array(
            "type"          => "vc_link",
            "heading"       => esc_html__("Button",'micar'),
            "param_name"    => "button",
			'dependency'    => array(
                'element'   => 'style',
                'value'   => array('item-service3'),
			)
        ),
        array(
            "type" => "textarea_html",
            "holder" => "div",
            "heading" => esc_html__("Content",'micar'),
            "param_name" => "content",
			'dependency'    => array(
                'element'   => 'style',
                'value'   => array('about-style','contact-box','item-service2','item-service3'),
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