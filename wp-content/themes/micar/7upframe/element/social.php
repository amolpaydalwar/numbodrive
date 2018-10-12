<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */
if(!function_exists('s7upf_vc_social'))
{
    function s7upf_vc_social($attr, $content = false)
    {
        $html = '';
        extract(shortcode_atts(array(
            'title'         => '',
            'title_color'   => 'white',
            'list'          => '',
            'align'         => 'text-left',
            'css_animation' => ''
        ),$attr));
		$data = (array) vc_param_group_parse_atts( $list );
        $html .=    '<div class="connect-social '.$align.'">';
		$html .=		'<span class="'.esc_attr($title_color).' text-uppercase">'.$title.'</span>';
                        if(is_array($data)){
                            foreach ($data as $key => $value){
                                if(isset($value['link']) && isset($value['icon'])) $html .= '<a class="title18 shop-button" href="'.esc_url($value['link']).'"><i class="'.$value['icon'].'"></i></a>';
                            }
                        }
        $html .=    '</div>';   
		return  $html;
    }
}

stp_reg_shortcode('sv_social','s7upf_vc_social');


vc_map( array(
    "name"      => esc_html__("SV Social", 'micar'),
    "base"      => "sv_social",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
		array(
            "type" => "textfield",
            "heading" => esc_html__( "Title", "micar" ),
            "param_name" => "title",
            "description" => esc_html__( "Title Social Network.", "micar" )
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
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Align', 'micar' ),
			'value'      => array(
				esc_html__( 'Align Left', 'micar' )     => 'text-left',
				esc_html__( 'Align Center', 'micar' )   => 'text-center',
				esc_html__( 'Align Right', 'micar' )    => 'text-right',
			),
			'param_name' => 'align',
			'description' => esc_html__( 'Select social layout', 'micar' ),
		),
		
        array(
            "type" => "param_group",
            "heading" => esc_html__("Social List",'micar'),
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
					'description' =>  esc_html__( 'Select icon from Ion icon library.', 'micar' ),
				),
                array(
                    "type"          => "textfield",
                    "heading"       => esc_html__("Link",'micar'),
                    "param_name"    => "link",
                ),
            )
        ),
    )
));