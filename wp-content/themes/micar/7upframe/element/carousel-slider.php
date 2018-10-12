<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 31/08/15
 * Time: 10:00 AM
 */
/************************************Main Carousel*************************************/
if(!function_exists('s7upf_vc_carousel_slider'))
{
    function s7upf_vc_carousel_slider($attr, $content = false)
    {
        $html = $css_class = '';
        extract(shortcode_atts(array(
            'control_nav'     => '',
			'itemscustom'     => '',
            'autoplay'        => 'false',
            'pagination'      => 'false',
            'navigation'      => 'false',
            'transition'      => '',
			'class_extra'     => '',
            'custom_css'      => '',
        ),$attr));
		if(!empty($custom_css)) $css_class = vc_shortcode_custom_css_class( $custom_css );
        $html .=    '<div class="carousel-slider '.$css_class.' '.esc_attr($class_extra).'">';
        $html .=        '<div class="wrap-item '.esc_attr($control_nav).'" data-autoplay="'.esc_attr($autoplay).'" data-pagination="'.esc_attr($pagination).'" data-navigation="'.esc_attr($navigation).'" data-transition="'.esc_attr($transition).'" data-itemscustom="'.s7upf_convert_itemscustom($itemscustom).'">';
        $html .=            wpb_js_remove_wpautop($content, false);
        $html .=        '</div>';
        $html .=    '</div>';
        return $html;
    }
}
stp_reg_shortcode('carousel_slider','s7upf_vc_carousel_slider');
vc_map(
    array(
        'name'     => esc_html__( 'SV Carousel Slider', 'micar' ),
        'base'     => 'carousel_slider',
        'category' => esc_html__( '7Up-theme', 'micar' ),
        'icon'     => 'icon-st',
        'as_parent' => array( 'only' => 'adv_slider_item,client_slider_item,brand_slider_item' ),
        'content_element' => true,
        'js_view' => 'VcColumnView',
        'params'   => array(                       
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Style Control Nav', 'micar' ),
                'param_name'  => 'control_nav',
                'value'       => array(
                    esc_html__( 'Default', 'micar' )        => '',
                    esc_html__( 'Group Navi', 'micar' )     => 'group-navi',
                    esc_html__( 'Rect Navi', 'micar' )      => 'rect-navi',
                    )
            ),
            array(
                'heading'     => esc_html__( 'Custom Items', 'micar' ),
                'type'        => 'textfield',
                'description'   => esc_html__( 'Enter item for screen width(px) format is width:value and separate values by ",". Example is 0:2,480:3,768:4,1024:5. Default is auto.', 'micar' ),
                'param_name'  => 'itemscustom',
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
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Class Extra', 'micar' ),
                'param_name'  => 'class_extra',
            ),
            array(
                "type"          => "css_editor",
                "heading"       => esc_html__("Custom Style",'micar'),
                "param_name"    => "custom_css",
                'group'         => esc_html__('Design Option','micar')
            ),
        )
    )
);

/*******************************************END MAIN*****************************************/

/**************************************BEGIN ADV SLIDER************************************/
//Banner item Frontend
if(!function_exists('s7upf_vc_adv_slider_item'))
{
    function s7upf_vc_adv_slider_item($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'         => '',
            'link'          => '', 
			'size'          => '', 
            'image'         => '',
            'second_image'  => '',
            'video'         => '',
            'title'         => '',
            'sub_title'     => '',
            'desc'      	=> '',           
            'button'        => '',
			'animation'     => '', 
        ),$attr));
		
		if(!empty($size)) $size = explode('x', $size);
        else $size = 'full';
		$data_link = vc_build_link($button);
		
        switch ($style) {
            case 'item-adv1':
                $html .=    '<div class="banner-adv '.esc_attr($style).' '.esc_attr($animation).'">
                               <a href="'.esc_url($link).'" class="adv-thumb-link">
									'.wp_get_attachment_image($image,$size).'
									'.wp_get_attachment_image($second_image,$size).'
								</a>
                                <div class="info-adv1 white">
                                    <h3 class="title18 text-uppercase font-bold"><a href="'.esc_url($link).'" class="white">'.esc_html($title).'</a></h3>
                                    <p class="desc white font-light">'.esc_html($desc).'</p>
                                    <a href="'.esc_url($data_link['url']).'" class="color text-uppercase wobble-skew">'.esc_html($data_link['title']).' <i class="icon ion-ios-arrow-thin-right"></i></a>
                                </div>
                            </div>';
                break;
            
            case 'item-adv2':
                $html .=    '<div class="banner-adv '.esc_attr($style).' '.esc_attr($animation).'">
                               <a href="'.esc_url($link).'" class="adv-thumb-link">
									'.wp_get_attachment_image($image,$size).'
									'.wp_get_attachment_image($second_image,$size).'
								</a>
								<div class="adv-info2">
									<a href="'.esc_url($link).'" class="silver">'.esc_html($sub_title).'</a>
									<h3 class="title18 text-uppercase"><a href="'.esc_url($link).'">'.esc_html($title).'</a></h3>
									<p class="desc">'.esc_html($desc).'</p>
									<a href="'.esc_url($data_link['url']).'" class="link-arrow text-uppercase color2">'.esc_html($data_link['title']).' <i class="icon ion-ios-arrow-thin-right"></i></a>
								</div>
                            </div>';
                break;
            
            case 'item-video-highlight':
                $html .=    '<div class="item-video-highlight">
								<div class="banner-adv">
								   <a href="'.esc_url($video).'" class="adv-thumb-link fancybox-media"> 
										'.wp_get_attachment_image($image,$size).'
									</a>
								</div>
								<h3 class="title18 text-uppercase font-bold"><a href="'.esc_url($link).'" class="black">'.esc_html($title).'</a></h3>
								<p class="desc">'.esc_html($desc).'</p>
                            </div>';
                break;
            
            default:
                $html .=    '<div class="banner-adv '.esc_attr($animation).'">
                               <a href="'.esc_url($link).'" class="adv-thumb-link">
									'.wp_get_attachment_image($image,$size).'
									'.wp_get_attachment_image($second_image,$size).'
								</a>
                                <div class="info-adv1 white">
                                    <h3 class="title18 text-uppercase font-bold"><a href="'.esc_url($link).'" class="white">'.esc_html($title).'</a></h3>
                                    <p class="desc white font-light">'.esc_html($desc).'</p>
                                    <a href="'.esc_url($data_link['url']).'" class="color text-uppercase wobble-skew">'.esc_html($data_link['title']).' <i class="icon ion-ios-arrow-thin-right"></i></a>
                                </div>
                            </div>';
                break;
        }        
        return $html;
    }
}
stp_reg_shortcode('adv_slider_item','s7upf_vc_adv_slider_item');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Adv Slider Item', 'micar' ),
        'base'     => 'adv_slider_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'carousel_slider'),
        'params'   => array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Style', 'micar' ),
                'param_name'  => 'style',
                'value'       => array(
                    esc_html__( 'Default', 'micar' ) => '',
                    esc_html__( 'Adv Home 1', 'micar' ) => 'item-adv1',
                    esc_html__( 'Adv Home 2', 'micar' ) => 'item-adv2',
                    esc_html__( 'Video Hight Light', 'micar' ) => 'item-video-highlight',
                    )
            ),  
			array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Link', 'micar' ),
                'param_name'  => 'link',
            ),
			array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Image Size', 'micar' ),
                'param_name'  => 'size',
				'description'   => esc_html__( 'Enter site thumbnail to crop. [width]x[height]. Example is 300x300', 'micar' ),
            ),
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Image', 'micar' ),
                'param_name'  => 'image',
            ),
			array(
				"type" => "dropdown",
				"heading" => esc_html__("Animation",'micar'),
				"param_name" => "animation",
				"value"     => array(
					esc_html__("Default",'micar')   => '',
					esc_html__("Zoom",'micar')   => 'zoom-image',
					esc_html__("Zoom Out",'micar')   => 'zoom-out',
					esc_html__("Fade Out-In",'micar')   => 'fade-out-in',
					esc_html__("Fade In-Out",'micar')   => 'fade-in-out',
					esc_html__("Zoom Fade Out-In",'micar')   => 'zoom-image fade-out-in',
					esc_html__("Zoom Rotate",'micar')   => 'zoom-rotate',
					esc_html__("Overlay",'micar')   => 'overlay-image',
					esc_html__("Overlay Zoom",'micar')   => 'overlay-image zoom-image',
					esc_html__("Zoom Line Scale",'micar')   => 'zoom-image line-scale',
					),
			),
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Second Image', 'micar' ),
                'param_name'  => 'second_image',
				"dependency"    =>array(
					'element'   =>'animation',
					'value'     =>array('zoom-out'),
				),
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Link Video', 'micar' ),
                'param_name'  => 'video',
				"dependency"    =>array(
					'element'   =>'style',
					'value'     =>array('item-video-highlight'),
				),
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Sub Title', 'micar' ),
                'param_name'  => 'sub_title',
				"dependency"    =>array(
					'element'   =>'style',
					'value'     =>array('item-adv2'),
				),
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Title', 'micar' ),
                'param_name'  => 'title',
            ),
            array(
                "type"          => "textarea",
                "heading"       => esc_html__("Description",'micar'),
                "param_name"    => "desc",
            ),
			array(
				"type" => "vc_link",
				"heading" => esc_html__("Extra Link",'micar'),
				"param_name" => "button",
				"dependency"    =>array(
					'element'   =>'style',
					'value'     =>array('item-adv1','item-adv2'),
				),
			),
        )
    )
);

/**************************************END ADV SLIDER************************************/
/**************************************BEGIN CLIENT SLIDER************************************/
//Banner item Frontend
if(!function_exists('s7upf_vc_client_slider_item'))
{
    function s7upf_vc_client_slider_item($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'         => '',
            'link'          => '', 
			'size'          => '', 
            'image'         => '',
            'name'          => '',
            'desc'      	=> '',           
            'info'          => '',
        ),$attr));
		
		if(!empty($size)) $size = explode('x', $size);
        else $size = 'full';
		
        switch ($style) {
            case 'item-about-client':
                $html .=    '<div class="item-about-client">
                               <div class="client-thumb">
								   <a href="'.esc_url($link).'">
										'.wp_get_attachment_image($image,$size).'
									</a>
								</div>	
                                <div class="client-info">
									<p class="desc navi">'.esc_html($desc).'</p>
                                    <h3 class="title14"><a href="'.esc_url($link).'" class="color">'.esc_html($name).'</a></h3>
                                    <span class="navi opaci">'.esc_html($info).'</span>
                                </div>
                            </div>';
                break;
            
            default:
                $html .=    '<div class="item-about-client">
                               <div class="client-thumb">
								   <a href="'.esc_url($link).'">
										'.wp_get_attachment_image($image,$size).'
									</a>
								</div>	
                                <div class="client-info">
									<p class="desc navi">'.esc_html($desc).'</p>
                                    <h3 class="title14"><a href="'.esc_url($link).'" class="color">'.esc_html($name).'</a></h3>
                                    <span class="navi opaci">'.esc_html($info).'</span>
                                </div>
                            </div>';
                break;
        }        
        return $html;
    }
}
stp_reg_shortcode('client_slider_item','s7upf_vc_client_slider_item');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Client Slider Item', 'micar' ),
        'base'     => 'client_slider_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'carousel_slider'),
        'params'   => array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Style', 'micar' ),
                'param_name'  => 'style',
                'value'       => array(
                    esc_html__( 'Default', 'micar' ) => '',
                    esc_html__( 'About Client', 'micar' ) => 'item-about-client',
                    )
            ),  
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Client Avatar', 'micar' ),
                'param_name'  => 'image',
            ),
			array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Client Url', 'micar' ),
                'param_name'  => 'link',
            ),
			array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Avatar Size', 'micar' ),
                'param_name'  => 'size',
				'description'   => esc_html__( 'Enter site thumbnail to crop. [width]x[height]. Example is 300x300', 'micar' ),
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Client Name', 'micar' ),
                'param_name'  => 'name',
            ),
            array(
                "type"          => "textarea",
                "heading"       => esc_html__("Client Review",'micar'),
                "param_name"    => "desc",
            ),
			array(
				"type" => "textfield",
				"heading" => esc_html__("Client Infomation",'micar'),
				"param_name" => "info",
			),
        )
    )
);

/**************************************END ITEM************************************/

/**************************************BEGIN BRAND SLIDER************************************/
//Banner item Frontend
if(!function_exists('s7upf_vc_brand_slider_item'))
{
    function s7upf_vc_brand_slider_item($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'style'         => '',
            'link'          => '', 
			'size'          => '', 
            'image'         => '',
        ),$attr));
		
		if(!empty($size)) $size = explode('x', $size);
        else $size = 'full';
		
        switch ($style) {
            default:
                $html .=    '<div class="item-brand">
								<a class="pulse" href="'.esc_url($link).'">
									'.wp_get_attachment_image($image,$size).'
								</a>
                            </div>';
                break;
        }        
        return $html;
    }
}
stp_reg_shortcode('brand_slider_item','s7upf_vc_brand_slider_item');

// Banner item
vc_map(
    array(
        'name'     => esc_html__( 'Brand Slider Item', 'micar' ),
        'base'     => 'brand_slider_item',
        'icon'     => 'icon-st',
        'content_element' => true,
        'as_child' => array('only' => 'carousel_slider'),
        'params'   => array(
            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Style', 'micar' ),
                'param_name'  => 'style',
                'value'       => array(
                    esc_html__( 'Default', 'micar' ) => '',
                    )
            ),  
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__( 'Brand Logo', 'micar' ),
                'param_name'  => 'image',
            ),
			array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Brand Logo Size', 'micar' ),
                'param_name'  => 'size',
				'description'   => esc_html__( 'Enter site thumbnail to crop. [width]x[height]. Example is 300x300', 'micar' ),
            ),
			array(
                'type'        => 'textfield',
                'heading'     => esc_html__( 'Brand Url', 'micar' ),
                'param_name'  => 'link',
            ),
        )
    )
);

/**************************************END ITEM************************************/

//Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_Carousel_slider extends WPBakeryShortCodesContainer {}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
    class WPBakeryShortCode_Adv_Slider_item extends WPBakeryShortCode {}    
    class WPBakeryShortCode_Client_Slider_Item extends WPBakeryShortCode {}
    class WPBakeryShortCode_Brand_Slider_Item extends WPBakeryShortCode {}
}