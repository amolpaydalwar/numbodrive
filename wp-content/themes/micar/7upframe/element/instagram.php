<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('s7upf_vc_instagram_box'))
{
    function s7upf_vc_instagram_box($attr)
    {
        $html = '';
        extract(shortcode_atts(array(
            'user'       => '',
            'title'      => '',
            'photos'     => '',            
        ),$attr));
        $html .=    '<div class="instagram-box">';
        if(!empty($title)) $html .=    '<h2 class="title30 anton-font color text-uppercase">'.esc_html($title).'</h2>';
        $html .=        '<ul class="list-instagram list-inline-block">';
        if ($user != '' && function_exists('s7upf_scrape_instagram')){
            $media_array = s7upf_scrape_instagram($user, $photos);
            if(!empty($media_array)){
                foreach ($media_array as $item) {
                    if(isset($item['link']) && isset($item['thumbnail_src'])){
                        $html .= '<li><a href="'. esc_url( $item['link'] ) .'" ><img src="'. esc_url($item['thumbnail_src']) .'" alt=""></a></li>';
                    }
                }              
            }
        }
        $html .=     	'</ul>'; 
        $html .=     '</div>'; 
        return $html;
    }
}

stp_reg_shortcode('sv_instagram_box','s7upf_vc_instagram_box');

vc_map( array(
    "name"      => esc_html__("SV Instagram Box", 'micar'),
    "base"      => "sv_instagram_box",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(        
        array(
            "type"          => "textfield",
            "holder"        => "div",
            "heading"       => esc_html__("Title",'micar'),
            "param_name"    => "title",
        ),
        array(
            "type"          => "textfield",
            "heading"       => esc_html__("User",'micar'),
            "param_name"    => "user",
        ),
        array(
            "type"          => "textfield",
            "heading"       => esc_html__("Number",'micar'),
            "param_name"    => "photos",
        )
    )
));