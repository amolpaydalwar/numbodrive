<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 18/08/15
 * Time: 10:00 AM
 */
// Start 15/10/2016
if(!function_exists('s7upf_vc_menu'))
{
    function s7upf_vc_menu($attr,$content = false)
    {
        $html = $css_class = '';
        extract(shortcode_atts(array(
            'style'           => 'main-nav1',
            'menu'            => '',
            'custom_css'      => '',
            'class_extra'     => '',
        ),$attr));
		if(!empty($custom_css)) $css_class = vc_shortcode_custom_css_class( $custom_css );
        if(!empty($menu)){
            $html .=    '<nav class="main-nav '.esc_attr($style).' '.$css_class.' '.esc_attr($class_extra).'">';
                            ob_start();
                            wp_nav_menu( array(
                                'menu' => $menu,
                                'container'=>false,
                                'walker'=>new S7upf_Walker_Nav_Menu(),
                            ));
            $html .=        @ob_get_clean();
            $html .=        '<a href="#" class="toggle-mobile-menu"><span></span></a>';
            $html .=    '</nav>';
        }
        else{
            $html .=    '<nav class="main-nav '.esc_attr($style).' '.$css_class.' '.esc_attr($class_extra).'">';
                            ob_start();
                            wp_nav_menu( array(
                                'theme_location' => 'primary',
                                'container'=>false,
                                'walker'=>new S7upf_Walker_Nav_Menu(),
                            ));
            $html .=        @ob_get_clean();
            $html .=        '<a href="#" class="toggle-mobile-menu"><span></span></a>';
            $html .=    '</nav>';
        }        
        return $html;
    }
}

stp_reg_shortcode('sv_menu','s7upf_vc_menu');

vc_map( array(
    "name"      => esc_html__("SV Menu", 'micar'),
    "base"      => "sv_menu",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type"              => "dropdown",
            "heading"           => esc_html__("Style",'micar'),
            "param_name"        => "style",
            "value"             => array(
                                    esc_html__("Style 1",'micar')   => 'main-nav1',
                                    esc_html__("Style 2",'micar')   => 'main-nav2',
                                    esc_html__("Style 3",'micar')   => 'main-nav3',
                                    esc_html__("Style 4",'micar')   => 'main-nav4',
                                    esc_html__("Style 5",'micar')   => 'main-nav5',
                                    esc_html__("Style 6",'micar')   => 'main-nav6',
                                )
        ),
        array(
            'type'              => 'dropdown',
            'holder'            => 'div',
            'heading'           => esc_html__( 'Menu name', 'micar' ),
            'param_name'        => 'menu',
            'value'             => s7upf_list_menu_name(),
            'description'       => esc_html__( 'Select Menu name to display', 'micar' )
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