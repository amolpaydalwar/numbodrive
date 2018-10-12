<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('s7upf_vc_profile'))
{
    function s7upf_vc_profile($attr,$content = false)
    {
        $html = $item_html = $css_class = '';
        extract(shortcode_atts(array(
            'style'         => '',
            'login'     	=> '',
            'register'     	=> '',
			'list'          => '',
			'class_extra'   => '',
			'custom_css'    => '',
        ),$attr));
		if(!empty($custom_css)) $css_class = vc_shortcode_custom_css_class( $custom_css );
		$data = (array) vc_param_group_parse_atts( $list );
		if(empty($login)) $login = get_permalink( get_option('woocommerce_myaccount_page_id'));
		if(empty($register)) $register = get_permalink( get_option('woocommerce_myaccount_page_id'));
		
		if(is_user_logged_in()){  
			$current_user = wp_get_current_user();
			if(isset($current_user->user_login)) $user_name = $current_user->user_login;
			if(isset($current_user->display_name)) $display_name = $current_user->display_name;
			if(isset($current_user->roles)) $user_roles = $current_user->roles[0];
			if($user_roles != 'vendor'){
				$item_html .=    '<ul class="list-none dropdown-list">';
									if(is_array($data)){
										foreach ($data as $key => $value){
											if(!empty($value['link'])) {
												if($value['role']!='vendor'){
													$item_html .= '<li><a href="'.esc_url($value['link']).'"><i class="'.$value['icon'].'"></i>';
														if(!empty($value['text'])) {
															$item_html .= esc_html($value['text']);
														}
													$item_html .= '</a></li>';
												}
											}
										}
									}
				$item_html .=    		'<li><a href="'.wp_logout_url( home_url() ).'"><i class="icon ion-log-out"></i>'.esc_html__('Log Out','micar').'</a></li>
								</ul>';
			}else{
				$item_html .=    '<ul class="list-none dropdown-list">';
									if(is_array($data)){
										foreach ($data as $key => $value){
											if(!empty($value['link'])) {
												$item_html .= '<li><a href="'.esc_url($value['link']).'"><i class="'.$value['icon'].'"></i>';
													if(!empty($value['text'])) {
														$item_html .= esc_html($value['text']);
													}
												$item_html .= '</a></li>';
											}
										}
									}
				$item_html .=    		'<li><a href="'.wp_logout_url( home_url() ).'"><i class="icon ion-log-out"></i>'.esc_html__('Log Out','micar').'</a></li>
								</ul>';
			}
		}else{
			$item_html .=   '<ul class="list-none dropdown-list">
								<li><a href="'.esc_url($login).'"><i class="icon ion-log-in"></i>'.esc_html__('Log In','micar').'</a></li>
								<li><a href="'.esc_url($register).'"><i class="icon ion-unlocked"></i>'.esc_html__('Register','micar').'</a></li>
							</ul>';
		}
        switch ($style) {
            case 'style1':
                $html .=    '<div class="profile-box dropdown-box '.esc_attr($css_class).' '.esc_attr($class_extra).'">
								<a href="'.get_permalink( get_option('woocommerce_myaccount_page_id')).'" class="dropdown-link title24 white bg-color2 gradient"><i class="icon ion-ios-contact-outline"></i></a>
								'.$item_html.'
							</div>';
                break;
				
            case 'style2':
                $html .=    '<div class="profile-box profile-box3 dropdown-box '.esc_attr($css_class).' '.esc_attr($class_extra).'">
								<a href="'.get_permalink( get_option('woocommerce_myaccount_page_id')).'" class="dropdown-link white"><i class="icon title30 ion-ios-contact-outline"></i><sup class="title12 white bg-color round"><i class="icon ion-ios-arrow-down"></i></sup></a>
								'.$item_html.'
							</div>';
                break;
				
            case 'style3':
                $html .=    '<div class="profile-box profile-box4 dropdown-box '.esc_attr($css_class).' '.esc_attr($class_extra).'">
								<a href="'.get_permalink( get_option('woocommerce_myaccount_page_id')).'" class="dropdown-link title24 black"><i class="icon ion-ios-contact-outline"></i></a>
								'.$item_html.'
							</div>';
                break;
				
            default:
                $html .=    '<div class="profile-box dropdown-box '.esc_attr($css_class).' '.esc_attr($class_extra).'">
								<a href="'.get_permalink( get_option('woocommerce_myaccount_page_id')).'" class="dropdown-link title24 white bg-color2 gradient"><i class="icon ion-ios-contact-outline"></i></a>
								'.$item_html.'
							</div>';
                break;
        }        
        
        return $html;
    }
}

stp_reg_shortcode('s7upf_profile','s7upf_vc_profile');

vc_map( array(
    "name"      => esc_html__("SV Profile", 'micar'),
    "base"      => "s7upf_profile",
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
                esc_html__("Style 1","micar")   => 'style1',
                esc_html__("Style 2","micar")   => 'style2',
                esc_html__("Style 3","micar")   => 'style3',
                ),
        ),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Log In",'micar'),
			"param_name" => "login",
		),
		array(
			"type" => "textfield",
			"heading" => esc_html__("Register",'micar'),
			"param_name" => "register",
		),
		array(
            "type" => "param_group",
            "heading" => esc_html__("Add List Link",'micar'),
            "param_name" => "list",
            "params"    => array(
				array(
					"type"          => "dropdown",
					"holder"        => "div",
					"heading"       => esc_html__("Account Role",'micar'),
					"param_name"    => "role",
					"value"         => array(
						esc_html__("Default",'micar')   => 'default',
						esc_html__("Vendor",'micar')   => 'vendor',
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
				),
                array(
                    "type" => "textfield",
                    "heading" => esc_html__("Text",'micar'),
                    "param_name" => "text",
                ),
            ),
			'description' =>  esc_html__( 'List links only show when you was login.', 'micar' ),
        ),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Class Extra', 'micar' ),
			'param_name'  => 'class_extra',
			'group'         => esc_html__('Design Option','micar')
		),
		array(
			"type"          => "css_editor",
			"heading"       => esc_html__("Custom Style",'micar'),
			"param_name"    => "custom_css",
			'group'         => esc_html__('Design Option','micar')
		),
    )
));