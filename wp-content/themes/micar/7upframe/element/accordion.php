<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
if(!function_exists('s7upf_vc_accordion'))
{
    function s7upf_vc_accordion($attr, $content = false)
    {
        $html = $list_html = '';
        extract(shortcode_atts(array(
            'style'         => '',
            'title'         => '',
            'icon'         => '',
            'list'          => '',
            'css'          => '',
            'class'          => '',
        ),$attr));
		$data = (array) vc_param_group_parse_atts( $list );
		
		switch ($style) {
			
            case 'contact-accordion':
				if(is_array($data)){
					$active="";
					if(is_array($data)){
						foreach ($data as $key => $value) {
							if($key==0){$class="active";}
							$list_html .=   '<div class="item-toggle-tab '.$active.'">
												<h2 class="toggle-tab-title navi">'.esc_html($value['title']).'</h2>
												<p class="desc toggle-tab-content navi opaci">'.esc_html($value['desc']).'</p>
											</div>';
						}
					}
					$html .=    '<div class="contact-faq '.esc_attr($class).'">';
					$html .=    	'<h2 class="title18 navi font-bold text-uppercase rale-font">'.esc_html($title).'</h2>';
					$html .=    	'<div class="toggle-tab '.esc_attr($style).'">';
					$html .=       		 $list_html;
					$html .=    	'</div>';
					$html .=    '</div>';
                }
                
			break;

            case 'about-accordion':
				if(is_array($data)){
					$active="";
					if(is_array($data)){
						foreach ($data as $key => $value) {
							if($key==0){$active="active";}
							$list_html .=   '<div class="item-toggle-tab '.$active.'">
												<div class="toggle-tab-title"><span class="bg-color"><i class="'.$value['icon'].'"></i></span><h2 class="navi">'.esc_html($value['title']).'</h2></div>
												<p class="desc toggle-tab-content navi opaci">'.esc_html($value['desc']).'</p>
											</div>';
						}
					}
					$html .=    '<div class="about-why-choise '.esc_attr($class).'">';
					$html .=    	'<h2 class="title18 navi font-bold text-uppercase rale-font">'.esc_html($title).'</h2>';
					$html .=    	'<div class="toggle-tab '.esc_attr($style).'">';
					$html .=       		 $list_html;
					$html .=    	'</div>';
					$html .=    '</div>';
                }
                
			break;

            default:        
                if(is_array($data)){
					$active="";
					if(is_array($data)){
						foreach ($data as $key => $value) {
							if($key==0){$active="active";}
							$list_html .=   '<div class="item-toggle-tab '.$active.'">
												<h2 class="title18 toggle-tab-title">'.esc_html($value['title']).'</h2>
												<p class="desc toggle-tab-content">'.esc_html($value['desc']).'</p>
											</div>';
						}
					}
					$html .=    	'<div class="toggle-tab '.esc_attr($class).'">';
					$html .=       		 $list_html;
					$html .=    	'</div>';
                }
			break;
        }
        return $html;
    }
}

stp_reg_shortcode('sv_accordion','s7upf_vc_accordion');


vc_map( array(
    "name"      => esc_html__("SV Accordion", 'micar'),
    "base"      => "sv_accordion",
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
				esc_html__('Contact Accordion','micar')=>'contact-accordion',
				esc_html__('About Accordion','micar')=>'about-accordion',
			),
		),
        array(
			"type" => "textfield",
			"heading" => esc_html__("Title",'micar'),
			"param_name" => "title",
		),
		array(
            "type" => "param_group",
            "heading" => esc_html__("Add List Accordion",'micar'),
            "param_name" => "list",
            "params"    => array(
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
				),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Title",'micar'),
                    "param_name" => "title",
                ),
                array(
                    "type" => "textarea",
                    "heading" => esc_html__("Content",'micar'),
                    "param_name" => "desc",
                ),
            ),
        ),
		array(
            'type' => 'css_editor',
            'heading' => esc_html__( 'Custom Style', 'micar' ),
            'param_name' => 'css',
            'group' => esc_html__( 'Design options', 'micar' ),
        ),
		array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Class Extra', 'micar' ),
            'param_name' => 'class',
            'group' => esc_html__( 'Design options', 'micar' ),
        ),
    )
));