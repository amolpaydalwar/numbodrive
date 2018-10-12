<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 31/08/15
 * Time: 10:00 AM
 */
if(!function_exists('s7upf_vc_banner_slider'))
{
    function s7upf_vc_banner_slider($attr, $content = false)
    {
        $html = $css_class = '';
        extract(shortcode_atts(array(
            'style' => '',
            'autoplay' => 'false',
            'pagination' => 'false',
            'navigation' => 'false',
            'transition' => '',
			'control_nav'     => '',
            'custom_css' => '',
			'class_extra' => '',
        ),$attr));
		if(!empty($custom_css)) $css_class = vc_shortcode_custom_css_class( $custom_css );
        $html .=    '<div class="banner-slider '.$css_class.' '.esc_attr($class_extra).' '.esc_attr($style).'">';
        $html .=        '<div class="wrap-item '.esc_attr($control_nav).'" data-autoplay="'.esc_attr($autoplay).'" data-pagination="'.esc_attr($pagination).'" data-navigation="'.esc_attr($navigation).'" data-transition="'.esc_attr($transition).'" data-itemscustom="[[0,1]]">';
        $html .=            wpb_js_remove_wpautop($content, false);
        $html .=        '</div>';
        $html .=    '</div>';
        return $html;
    }
}
stp_reg_shortcode('banner_slider','s7upf_vc_banner_slider');
vc_map(
    array(
        'name'     => esc_html__( 'SV Banner Slider', 'micar' ),
        'base'     => 'banner_slider',
        'category' => esc_html__( '7Up-theme', 'micar' ),
        'icon'     => 'icon-st',
        'as_parent' => array( 'only' => 'banner_slider_item' ),
        'content_element' => true,
        'js_view' => 'VcColumnView',
        'params'   => array(   
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Banner Style', 'micar' ),
                'param_name'  => 'style',
                'value'       => array(
                    esc_html__( 'Default', 'micar' )                  => '',
                    esc_html__( 'Banner Background', 'micar' )      => 'bg-slider',
                    esc_html__( 'Banner Background Parallax', 'micar' )      => 'bg-slider parallax-slider',
                ),
            ),
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Slider Transition', 'micar' ),
                'param_name'  => 'transition',
                'value'       => array(
                    esc_html__( 'None', 'micar' )        => '',
                    esc_html__( 'Fade', 'micar' )        => 'fade',
                    esc_html__( 'BackSlide', 'micar' )   => 'backSlide',
                    esc_html__( 'GoDown', 'micar' )      => 'goDown',
                    esc_html__( 'FadeUp', 'micar' )      => 'fadeUp',
                    )
            ),
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Navigation Control', 'micar' ),
                'param_name'  => 'navigation',
                'value'       => array(
                    esc_html__( 'False', 'micar' )        => 'false',
                    esc_html__( 'True', 'micar' )        => 'true',
                    )
            ),
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Pagination Control', 'micar' ),
                'param_name'  => 'pagination',
                'value'       => array(
                    esc_html__( 'False', 'micar' )        => 'false',
                    esc_html__( 'True', 'micar' )        => 'true',
                    )
            ),
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Auto Play Control', 'micar' ),
                'param_name'  => 'autoplay',
                'value'       => array(
                    esc_html__( 'False', 'micar' )        => 'false',
                    esc_html__( 'True', 'micar' )        => 'true',
                    )
            ),
			array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Style Control Nav', 'micar' ),
                'param_name'  => 'control_nav',
                'value'       => array(
                    esc_html__( 'Default', 'micar' )        => '',
                    esc_html__( 'Rect Navi', 'micar' )      => 'rect-navi',
                    esc_html__( 'Pagination Border', 'micar' )      => 'border-pagi',
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
    )
);

/*******************************************END MAIN*****************************************/


/**************************************BEGIN ITEM************************************/
//Banner item Frontend
if(!function_exists('s7upf_vc_banner_slider_item'))
{
    function s7upf_vc_banner_slider_item($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'         => '',
            'image'         => '',
            'link'          => '', 
			'effect'		=> '',
			'image_content'		=> '',
			'image_effect'		=> '',
			'offset_left'		=> '',
			'offset_bottom'		=> '',
        ),$attr));
		$info_class = "";
        if(!empty($image)){
            if(!empty($effect)) $info_class .= 'animated';
            
			$html .=        '<div class="item-slider '.esc_attr($style).'">
							    <div class="banner-thumb">
								    <a href="'.esc_url($link).'"><img src="'.wp_get_attachment_url($image).'" alt="" /></a>
							    </div>';
			if(!empty($content)){
				switch ($style){
					
					case 'item-slider1':
					
						$html .=	'<div class="banner-info text-uppercase '.esc_attr($info_class).'" data-animated="'.esc_attr($effect).'">
										<div class="container">';
						$html .=			wpb_js_remove_wpautop($content, true);
						$html .=		'</div>
									</div>';
					
						break;
					
					case 'item-slider2':
					
						$html .=	'<div class="banner-info">
										<div class="container">
											<div class="banner-info-text '.esc_attr($info_class).'"  data-animated="'.esc_attr($effect).'">';
						$html .=				wpb_js_remove_wpautop($content, true);
						$html .=			'</div>
											<img class="banner-info-image animated '.S7upf_Assets::build_css('left: '.esc_attr($offset_left).'!important;'.'bottom: '.esc_attr($offset_bottom).'!important;').'" data-animated="'.esc_attr($image_effect).'" src="'.wp_get_attachment_url($image_content).'" alt="" />
										</div>
						            </div>';
					
						break;
					
					case 'item-slider3':
					
						$html .=	'<div class="banner-info white text-left text-uppercase '.esc_attr($info_class).'" data-animated="'.esc_attr($effect).'">';
						$html .=		wpb_js_remove_wpautop($content, true);
						$html .=	'</div>';
					
						break;
					
					case 'item-slider4':
					
						$html .=	'<div class="banner-info text-center white text-uppercase '.esc_attr($info_class).'" data-animated="'.esc_attr($effect).'">';
						$html .=		wpb_js_remove_wpautop($content, true);
						$html .=	'</div>';
					
						break;
					
					case 'item-slider6':
					
						$html .=	'<div class="banner-info text-center white text-uppercase '.esc_attr($info_class).'" data-animated="'.esc_attr($effect).'">';
						$html .=		wpb_js_remove_wpautop($content, true);
						$html .=	'</div>';
					
						break;
					
					case 'item-collection':
					
						$html .=	'<div class="banner-info white '.esc_attr($info_class).'" data-animated="'.esc_attr($effect).'">
										<div class="container">
										    <div class="item-collection-info">';
						$html .=			    wpb_js_remove_wpautop($content, true);
						$html .=	        '</div>
									    </div>
									</div>';	
					
						break;
					
					case 'item-slider-bottom':
					
						$html .=	'<div class="banner-info '.esc_attr($info_class).'" data-animated="'.esc_attr($effect).'">
										<div class="container">
										    <div class="banner-bottom-info white bg-color">';
						$html .=			    wpb_js_remove_wpautop($content, true);
						$html .=	        '</div>
									    </div>
									</div>';	
					
						break;
					
					case 'default':
					
						$html .=	'<div class="banner-info '.esc_attr($info_class).'" data-animated="'.esc_attr($effect).'">
										<div class="container">';
						$html .=			wpb_js_remove_wpautop($content, true);
						$html .=		'</div>
									</div>';
					
						break;
				}
			}
			$html .=         '</div>';
        }
        return $html;
    }
}
stp_reg_shortcode('banner_slider_item','s7upf_vc_banner_slider_item');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Banner Item', 'micar' ),
        'base'     => 'banner_slider_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'banner_slider'),
        'params'   => array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Style', 'micar' ),
                'param_name'  => 'style',
                'value'       => array(
                    esc_html__( 'Default', 'micar' )      => '',
                    esc_html__( 'Style Home 1', 'micar' ) => 'item-slider1',
                    esc_html__( 'Style Home 2', 'micar' ) => 'item-slider2',
                    esc_html__( 'Style Home 3', 'micar' ) => 'item-slider3',
                    esc_html__( 'Style Home 4', 'micar' ) => 'item-slider4',
                    esc_html__( 'Style Home 5', 'micar' ) => 'item-slider5',
                    esc_html__( 'Style Home 6', 'micar' ) => 'item-slider6',
                    esc_html__( 'Collection Home 4', 'micar' ) => 'item-collection',
                    esc_html__( 'Slider Bottom Home 6', 'micar' ) => 'item-slider-bottom',
                    )
            ),            
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Image Background', 'micar' ),
                'param_name'  => 'image',
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Link Banner', 'micar' ),
                'param_name'  => 'link',
            ),
            array(
                'type'        => 'animation_style',
                'heading'     => esc_html__( 'Content Effect', 'micar' ),
                'param_name'  => 'effect',
            ),  
            array(
                "type" => "textarea_html",
                "holder" => "div",
                "heading" => esc_html__("Content",'micar'),
                "param_name" => "content",
            ),    
			array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Image Content', 'micar' ),
                'param_name'  => 'image_content',
				"dependency" => array(
					"element" => "style",
					"value" => "item-slider2"
				)
            ),
			array(
                'type'        => 'animation_style',
                'heading'     => esc_html__( 'Content Image Effect', 'micar' ),
                'param_name'  => 'image_effect',
				"dependency" => array(
					"element" => "style",
					"value" => "item-slider2"
				)
            ),  
			array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Image Offset Left', 'micar' ),
                'param_name'  => 'offset_left',
				"dependency" => array(
					"element" => "style",
					"value" => "item-slider2"
				)
            ), 
			array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Image Offset Bottom', 'micar' ),
                'param_name'  => 'offset_bottom',
				"dependency" => array(
					"element" => "style",
					"value" => "item-slider2"
				)
            ),
        )
    )
);

/**************************************END ITEM************************************/

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Banner_Slider extends WPBakeryShortCodesContainer {}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Banner_Slider_Item extends WPBakeryShortCode {}    
}