<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 26/12/15
 * Time: 10:00 AM
 */

if(!function_exists('s7upf_vc_mailchimp'))
{
    function s7upf_vc_mailchimp($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
			'style'         => '',
            'title'         => '',
            'desc'           => '',
            'placeholder'   => '',
            'submit'        => '',
            'form_id'       => '',
			'class_extra'   => '',
        ),$attr));
        $form_html = apply_filters('sv_remove_autofill',do_shortcode('[mc4wp_form id="'.$form_id.'"]'));
		$html .=    '<div class="newsletter-signup '.esc_attr($class_extra).'">';
			if(!empty($title)) $html .=    '<h2 class="title30 anton-font color text-uppercase">'.esc_html($title).'</h2>';
			if(!empty($desc)) $html .=    '<p class="desc silver">'.esc_html($desc).'</p>';
		$html .=        '<div class="form-newsletter">'.$form_html.'</div>';
		$html .=    '</div>';
        return $html;
    }
}

stp_reg_shortcode('sv_mailchimp','s7upf_vc_mailchimp');

vc_map( array(
    "name"      => esc_html__("SV MailChimp", 'micar'),
    "base"      => "sv_mailchimp",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Form ID",'micar'),
            "param_name" => "form_id",
        ),
        array(
            "type" => "textfield",
            'holder'      => 'div',
            "heading" => esc_html__("Title",'micar'),
            "param_name" => "title",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Description",'micar'),
            "param_name" => "desc",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Placeholder Input",'micar'),
            "param_name" => "placeholder",
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__("Submit Label",'micar'),
            "param_name" => "submit",
        ),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Class Extra', 'micar' ),
			'param_name'  => 'class_extra',
		),
    )
));