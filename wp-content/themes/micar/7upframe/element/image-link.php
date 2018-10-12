<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
if(!function_exists('s7upf_vc_payment'))
{
    function s7upf_vc_payment($attr, $content = false)
    {
        $html = $item_html = $css_class = '';
        extract(shortcode_atts(array(
            'style'         => '',
            'title'         => '',
			'title_color'   => 'white',
            'list'          => '',
			'align'         => '',
			'class_extra'   => '',
			'custom_css'    => '',
        ),$attr));
		
		if(!empty($custom_css)) $css_class = vc_shortcode_custom_css_class( $custom_css );
		$data = (array) vc_param_group_parse_atts( $list );
		switch($style){
			case 'social-network':
				$html .=    '<div class="connect-social '.esc_attr($style).' '.$css_class.' '.esc_attr($class_extra).' '.esc_attr($align).'">';
				if(!empty($title)){
					$html .= '<span class="'.esc_attr($title_color).' text-uppercase">'.esc_html($title).'</span>';
				}
				if(is_array($data)){
					foreach ($data as $key => $value){
						if(!empty($value['link'])) {
							$html .= '<a class="title18 shop-button" href="'.esc_url($value['link']).'">';
								if($value['type']=='image' && !empty($value['image'])) {
									$html .= wp_get_attachment_image($value['image'],'full');
								}
								if($value['type']=='icon' && !empty($value['icon'])) {
									$html .= '<i class="'.$value['icon'].'"></i>';
								}
							$html .= '</a>';
						}
					}
				}
				$html .=    '</div>';   
			break;
			
			case 'payment-method':
				$html .=    '<div class="'.esc_attr($style).' '.$css_class.' '.esc_attr($class_extra).' '.esc_attr($align).'">';
				if(!empty($title)){
					$html .= '<span class="'.esc_attr($title_color).' text-uppercase">'.esc_html($title).'</span>';
				}
				if(is_array($data)){
					foreach ($data as $key => $value){
						if(!empty($value['link'])) {
							$html .= '<a class="wobble-top" href="'.esc_url($value['link']).'">';
								if($value['type']=='image' && !empty($value['image'])) {
									$html .= wp_get_attachment_image($value['image'],'full');
								}
								if($value['type']=='icon' && !empty($value['icon'])) {
									$html .= '<i class="'.$value['icon'].'"></i>';
								}
							$html .= '</a>';
						}
					}
				}
				$html .=    '</div>';   
			break;
			
			case 'language-flag':
				$html .=    '<div class="list-flag '.esc_attr($style).' '.$css_class.' '.esc_attr($class_extra).' '.esc_attr($align).'">';
				if(!empty($title)){
					$html .= '<span class="'.esc_attr($title_color).' text-uppercase">'.esc_html($title).'</span>';
				}
				if(is_array($data)){
					foreach ($data as $key => $value){
						if(!empty($value['link'])) {
							$html .= '<a href="'.esc_url($value['link']).'">';
								if($value['type']=='image' && !empty($value['image'])) {
									$html .= wp_get_attachment_image($value['image'],'full');
								}
								if($value['type']=='icon' && !empty($value['icon'])) {
									$html .= '<i class="'.$value['icon'].'"></i>';
								}
							$html .= '</a>';
						}
					}
				}
				$html .=    '</div>';   
			break;
			
			default:
				$html .=    '<div class="custom-image-link '.$css_class.' '.esc_attr($class_extra).' '.esc_attr($align).'">';
				if(!empty($title)){
					$html .= '<span class="'.esc_attr($title_color).'">'.esc_html($title).'</span>';
				}
				if(is_array($data)){
					foreach ($data as $key => $value){
						if(!empty($value['link'])) {
							$html .= '<a href="'.esc_url($value['link']).'">';
								if($value['type']=='image' && !empty($value['image'])) {
									$html .= wp_get_attachment_image($value['image'],'full');
								}
								if($value['type']=='icon' && !empty($value['icon'])) {
									$html .= '<i class="'.$value['icon'].'"></i>';
								}
							$html .= '</a>';
						}
					}
				}
				$html .=    '</div>';   
			break;
		}
		return  $html;
    }
}

stp_reg_shortcode('sv_payment','s7upf_vc_payment');


vc_map( array(
    "name"      => esc_html__("SV Image link", 'micar'),
    "base"      => "sv_payment",
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
				esc_html__('Payment Method','micar')=>'payment-method',
				esc_html__('Social Network','micar')=>'connect-social',
				esc_html__('Language Flag','micar')=>'language-flag',
			),
			'edit_field_class'=>'vc_col-sm-6 vc_column',
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Alignment', 'micar' ),
			'param_name' => 'align',
			'value'      => array(
				esc_html__( 'Align Left', 'micar' )     => 'text-left',
				esc_html__( 'Align Center', 'micar' )   => 'text-center',
				esc_html__( 'Align Right', 'micar' )    => 'text-right',
			),
			'edit_field_class'=>'vc_col-sm-6 vc_column',
		),
        array(
			"type" => "textfield",
			"heading" => esc_html__("Title",'micar'),
			"param_name" => "title",
		),
		array(
			'type' => 'dropdown',
			'admin_label' => true,
			'heading' => esc_html__( 'Title Color', 'micar' ),
			'param_name' => 'title_color',
			'value' => array(
				esc_html__('White','micar')=>'white',
				esc_html__('Gray','micar')=>'gray',
				esc_html__('Black','micar')=>'black',
				esc_html__('Smoke','micar')=>'smoke',
				esc_html__('Main Color','micar')=>'color',
			),
		),
		array(
            "type" => "param_group",
            "heading" => esc_html__("Add List Item",'micar'),
            "param_name" => "list",
            "params"    => array(
				array(
					'type' => 'dropdown',
					'admin_label' => true,
					'heading' => esc_html__( 'List Type', 'micar' ),
					'param_name' => 'type',
					'std'   => 'image',  
					'value' => array(
						esc_html__('Image','micar')=>'image',
						esc_html__('Icon','micar')=>'icon',
					),
				),
                array(
                    "type" => "attach_image",
                    "heading" => esc_html__("Image",'micar'),
                    "param_name" => "image",
					"dependency"    =>array(
						'element'   =>'type',
						'value'     =>array('image')
					),
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
					"dependency"    =>array(
						'element'   =>'type',
						'value'     =>array('icon')
					),
				),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Link",'micar'),
                    "param_name" => "link",
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