<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('s7upf_vc_banner_advert'))
{
    function s7upf_vc_banner_advert($attr,$content = false)
    {
        $html = $css_class = '';
        extract(shortcode_atts(array(
            'style'            => '',
            'sub_title'        => '',
            'title'            => '',
			'size'             => '', 
            'image'            => '',
            'second_image'     => '',
            'image2'           => '',
            'text_before'      => '',
            'text_after'       => '',
            'link'             => '',
            'desc'             => '',
			'select_post'      => '',
            'comment'          => '',
            'link_download'    => '',
            'bg_color'         => '',
            'animation'        => '',
			'button'           => '',
			'second_button'    => '',
            'class_extra'      => '',
            'custom_css'       => '',
        ),$attr));
		$data_link1 = vc_build_link($button);
		$data_link2 = vc_build_link($second_button);
		if(!empty($custom_css)) $css_class = vc_shortcode_custom_css_class( $custom_css );
		if(!empty($size)) $size = explode('x', $size);
        else $size = 'full';
        if(!empty($bg_color)) $bg_color = S7upf_Assets::build_css('background-color:'.$bg_color);
        switch ($style) {
            case 'item-happend':
				$post_image = $post_link = $post_title = "";
				
				if(!empty($image)){
					$post_image = wp_get_attachment_image($image,$size);
				}else{
					$post_image = wp_get_attachment_image(get_post_thumbnail_id($select_post),$size);
				}
				if(!empty($link)){
					$post_link = $link;
				}else{
					$post_link = get_the_permalink($select_post);
				}
				if(!empty($title)){
					$post_title = $title;
				}else{
					$post_title = get_the_title($select_post);
				}
                $html .=    '<div class="banner-adv '.$css_class.' '.esc_attr($style).' '.esc_attr($animation).' '.esc_attr($class_extra).'">
                                <a href="'.esc_url($post_link).'" class="adv-thumb-link">
									'.$post_image.'
								</a>
								<div class="banner-info">
									<h3 class="title18 text-uppercase white">'.esc_html($post_title).'</h3>
									<a href="'.esc_url($post_link).'" class="link-circle white"><i class="icon ion-ios-arrow-thin-right"></i></a>
								</div>
                            </div>';
                break;

            case 'banner-download':
                $html .=    '<div class="banner-adv '.$css_class.' '.esc_attr($style).' '.esc_attr($animation).' '.esc_attr($class_extra).'">
                                <a href="'.esc_url($link).'" class="adv-thumb-link">
									'.wp_get_attachment_image($image,$size).'
									'.wp_get_attachment_image($second_image,$size).'
								</a>
								<div class="banner-info">
									<a href="'.esc_url($link_download).'" class="shop-button bg-color">
										<i class="icon ion-image"></i>
										<span class="title18">'.esc_html__('Download','micar').'</span>
										<span class="title12">'.esc_html__('e-brochure','micar').'</span>
									</a>
								</div>
                            </div>';
                break;

            case 'item-ads4':
                $html .=    '<div class="banner-adv '.$css_class.' '.esc_attr($style).' '.esc_attr($animation).' '.esc_attr($class_extra).'">
                                <a href="'.esc_url($link).'" class="adv-thumb-link">
									'.wp_get_attachment_image($image,$size).'
									'.wp_get_attachment_image($second_image,$size).'
								</a>
								<div class="banner-info text-uppercase table">
									<div class="text-left">
										<h3 class="title18">'.esc_html($title).'</h3>
									</div>
									<div class="text-right">
										<a href="'.esc_url($link).'" class="link-arrow white wobble-horizontal">'.esc_html__('More Detail','micar').' <i class="icon ion-ios-arrow-thin-right"></i></a>
									</div>
								</div>
                            </div>';
                break;

            case 'banner-ads5':
                $html .=    '<div class="banner-adv '.$css_class.' item-ads4 style2 '.esc_attr($animation).' '.esc_attr($class_extra).'">
                                <a href="'.esc_url($link).'" class="adv-thumb-link">
									'.wp_get_attachment_image($image,$size).'
									'.wp_get_attachment_image($second_image,$size).'
								</a>
								<div class="banner-info text-uppercase table">
									<div class="text-left">
										<h3 class="title18">'.esc_html($title).'</h3>
									</div>
									<div class="text-right">
										<a href="'.esc_url($link).'" class="link-circle bg-white color"><i class="icon ion-ios-arrow-thin-right"></i></a>
									</div>
								</div>
                            </div>';
                break;

            case 'latest-news':
				$args = array( 'numberposts' => '1' );
				$recent_posts = wp_get_recent_posts( $args );
				$post_image = "";
				foreach( $recent_posts as $post ){
				if(!empty($image)){
					$post_image = $image;
				}else{
					$post_image = wp_get_attachment_image(get_post_thumbnail_id($post['ID']),$size);
				}
					$html .=    '<div class="latest-news '.esc_attr($class_extra).'">
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="banner-adv '.esc_attr($animation).'">
												<a href="'.get_the_permalink($post['ID']).'" class="adv-thumb-link">'.$post_image.'</a>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="blog-info4">
												<a href="'.esc_url($link).'"><span class="color">'.esc_html__('Latest News','micar').'</span></a>
												<h2 class="title30 text-uppercase"><a href="'.get_the_permalink($post['ID']).'" class="black">'.esc_html($post['post_title']).'</a></h2>
												<p class="desc">'.esc_html($post['post_excerpt']).'</p>
												<a href="'.get_the_permalink($post['ID']).'" class="text-uppercase color link-arrow">'.esc_html__('More Detail','micar').'<i class="icon ion-ios-arrow-thin-right"></i></a>
												<ul class="list-inline-block">';
													if(!empty($data_link1['url']))	$html .='<li><a href="'.esc_url($data_link1['url']).'" class="shop-button small bg-color">'.esc_html($data_link1['title']).'</a></li>';
													if(!empty($data_link2['url']))	$html .='<li><a href="'.esc_url($data_link2['url']).'" class="shop-button small">'.esc_html($data_link2['title']).'</a></li>';
					$html .= 					'</ul>
											</div>
										</div>
									</div>
								</div>';
				}
                break;
			
            case 'item-news6':
				
				$post_image = $post_link = "";
				
				if(!empty($image)){
					$post_image = wp_get_attachment_image($image,$size);
				}else{
					$post_image = wp_get_attachment_image(get_post_thumbnail_id($select_post),$size);
				}
				if(!empty($link)){
					$post_link = $link;
				}else{
					$post_link = get_the_permalink($select_post);
				}
				$html .=    '<div class="banner-adv '.$css_class.' '.esc_attr($style).' '.esc_attr($animation).' '.esc_attr($class_extra).'">
								<a href="'.esc_url($post_link).'" class="adv-thumb-link">'.$post_image.'</a>
								<div class="banner-info">
									<h3 class="title18 text-uppercase"><a href="'.esc_url($post_link).'" class="white">'.esc_html(get_the_title($select_post)).'</a></h3>
									<p class="desc white">'.esc_html($desc).'</p>';
									if($comment =='yes' ){
				$html .=    		'<ul class="list-inline-block post-comment-like">
										<li><a href="'.esc_url($post_link).'#comment" class="white"><i class="icon ion-chatboxes"></i> '.get_comments_number($select_post).'</a></li>
										<li>'.s7upf_getPostLikeLink($select_post).'</li>
									</ul>';
									}
									
				$html .=    	'</div>
							</div>';
                break;
			
            case 'item-blog-adv4':
				$post_image = $post_link = $post_title = "";
				
				if(!empty($image)){
					$post_image = wp_get_attachment_image($image,$size);
				}else{
					$post_image = wp_get_attachment_image(get_post_thumbnail_id($select_post),$size);
				}
				if(!empty($link)){
					$post_link = $link;
				}else{
					$post_link = get_the_permalink($select_post);
				}
				if(!empty($title)){
					$post_title = $title;
				}else{
					$post_title = get_the_title($select_post);
				}
                $html .=    '<div class="banner-adv  '.$css_class.' '.esc_attr($style).' '.esc_attr($animation).' '.esc_attr($class_extra).'">
								<a href="'.esc_url($post_link).'" class="adv-thumb-link">
									'.$post_image.'
									<div class="banner-info white">
										<span>'.esc_html($sub_title).'</span>
										<h3 class="title18 text-uppercase">'.esc_html($post_title).'</h3>
									</div>
								</a>
							</div>';
                break;

            case 'twentytwenty':
                $html .=    '<div class="item-adv-gal">
								<div class="banner-adv twentytwenty-container" data-before="'.esc_html($text_before).'" data-after="'.esc_html($text_after).'">
									'.wp_get_attachment_image($image,$size).'
									'.wp_get_attachment_image($image2,$size).'
								</div>
								<div class="item-gal-info">
									<h2 class="title18 text-uppercase"><a href="'.esc_url($link).'" class="white">'.esc_html($title).'</a></h2>
									<p class="desc smoke">'.esc_html($desc).'</p>
									<a href="'.esc_url($data_link1['url']).'" class="btn-banner border gradient white text-uppercase"><i class="icon ion-images"></i>'.esc_html($data_link1['title']).'</a>
								</div>
							</div>';
                break;

            default:        
                $html .=    '<div class="banner-adv '.$css_class.' '.esc_attr($animation).' '.esc_attr($class_extra).'">
                                <div class="adv-thumb">
                                    <a href="'.esc_url($link).'" class="adv-thumb-link">
                                        '.wp_get_attachment_image($image,'full').'
                                        '.wp_get_attachment_image($second_image,'full').'
                                    </a>
                                </div>
                            </div>';
                break;
        }
        return $html;
    }
}

stp_reg_shortcode('sv_banner_advert','s7upf_vc_banner_advert');

$check_add = '';
if(isset($_GET['return'])) $check_add = $_GET['return'];
if(empty($check_add)) add_action( 'vc_before_init_base','sv_add_banner_advert',10,100 );
if ( ! function_exists( 'sv_add_banner_advert' ) ) {
	function sv_add_banner_advert(){
		vc_map( array(
			"name"      => esc_html__("SV Banner Advert", 'micar'),
			"base"      => "sv_banner_advert",
			"icon"      => "icon-st",
			"category"  => '7Up-theme',
			"params"    => array(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Style",'micar'),
					"param_name" => "style",
					"value"     => array(
						esc_html__("Default",'micar')   => '',
						esc_html__("Adv Home 1",'micar')   => 'item-happend',
						esc_html__("Adv Home 4",'micar')   => 'item-ads4',
						esc_html__("Adv Home 5",'micar')   => 'banner-ads5',
						esc_html__("Banner Download",'micar')   => 'banner-download',
						esc_html__("Latest Post",'micar')   => 'latest-news',
						esc_html__("Select Post",'micar')   => 'item-news6',
						esc_html__("Blog Adv",'micar')   => 'item-blog-adv4',
						esc_html__("TwentyTwenty",'micar')   => 'twentytwenty',
						)
				),
				array(
					"type"          => "textfield",
					"heading"       => esc_html__("Image Size",'micar'),
					"param_name"    => "size",
					'description'   => esc_html__( 'Enter site thumbnail to crop. [width]x[height]. Example is 300x300', 'micar' ),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Image",'micar'),
					"param_name" => "image",
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Second Image",'micar'),
					"param_name" => "second_immage",
					"dependency"    => array(
						"element"   => "animation",
						"value"   => array("zoom-out"),
					),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Second Image",'micar'),
					"param_name" => "image2",
					"dependency"    => array(
						"element"   => "style",
						"value"   => array("twentytwenty"),
					),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Text Before",'micar'),
					"param_name" => "text_before",
					"dependency"    => array(
						"element"   => "style",
						"value"   => array("twentytwenty"),
					),
				), 
				array(
					"type" => "textfield",
					"heading" => esc_html__("Text After",'micar'),
					"param_name" => "text_after",
					"dependency"    => array(
						"element"   => "style",
						"value"   => array("twentytwenty"),
					),
				), 
				array(
					"type" => "textfield",
					"heading" => esc_html__("Link",'micar'),
					"param_name" => "link",
				), 
				array(
					"type" => "textfield",
					"heading" => esc_html__("Link Download",'micar'),
					"param_name" => "link_download",
					"dependency"    => array(
						"element"   => "style",
						"value"   => array("banner-download"),
						)
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Sub Title",'micar'),
					"param_name" => "sub_title",
					"dependency"    => array(
						"element"   => "style",
						"value"   => array('item-blog-adv4'),
						)
				),  
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title",'micar'),
					"param_name" => "title",
					"dependency"    => array(
						"element"   => "style",
						"value"   => array('item-happend','banner-ads5','item-ads4','item-blog-adv4','twentytwenty'),
					),
				), 
				array(
					"type" => "textfield",
					"heading" => esc_html__("Description",'micar'),
					"param_name" => "desc",
					"dependency"    => array(
						"element"   => "style",
						"value"   => array("twentytwenty",'item-news6'),
					),
				), 
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Show Comment",'micar'),
					"param_name" => "comment",
					"value"     => array(
						esc_html__("No",'micar')   => 'no',
						esc_html__("Yes",'micar')   => 'yes',
						),
					"dependency"    => array(
						"element"   => "style",
						"value"   => array('item-news6'),
					),
				), 
				array(
					'holder'     => 'div',
					'heading'     => esc_html__( 'Select Post Item', 'micar' ),
					'type'        => 'autocomplete',
					'param_name'  => 'select_post',
					'settings' => array(
						'values' => s7upf_list_post(),
					),
					'save_always' => true,
					'description' => esc_html__( 'List of posts', 'micar' ),
					"dependency"    => array(
						"element"   => "style",
						"value"   => array('item-news6','item-blog-adv4','item-happend'),
					),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Animation",'micar'),
					"param_name" => "animation",
					"value"     => array(
						esc_html__("Default",'micar')   => '',
						esc_html__("Zoom",'micar')   => 'zoom-image',
						esc_html__("Pull Curtain",'micar')   => 'pull-curtain',
						esc_html__("Zoom Out",'micar')   => 'zoom-out',
						esc_html__("Fade Out-In",'micar')   => 'fade-out-in',
						esc_html__("Fade In-Out",'micar')   => 'fade-in-out',
						esc_html__("Zoom Fade Out-In",'micar')   => 'zoom-image fade-out-in',
						esc_html__("Zoom Rotate",'micar')   => 'zoom-rotate',
						esc_html__("Overlay",'micar')   => 'overlay-image',
						esc_html__("Overlay Zoom",'micar')   => 'overlay-image zoom-image',
						esc_html__("Line Scale",'micar')   => 'line-scale',
						esc_html__("Zoom Line Scale",'micar')   => 'zoom-image line-scale',
						),
				),
				array(
					"type"          => "vc_link",
					"heading"       => esc_html__("Button",'micar'),
					"param_name"    => "button",
					"dependency"    => array(
						"element"   => "style",
						"value"   => array("latest-news",'twentytwenty'),
						)
				),
				array(
					"type"          => "vc_link",
					"heading"       => esc_html__("Second Button",'micar'),
					"param_name"    => "second_button",
					"dependency"    => array(
						"element"   => "style",
						"value"   => array("latest-news"),
						)
				),
				array(
					"type"          => "colorpicker",
					"heading"       => esc_html__("Background Color",'micar'),
					"param_name"    => "bg_color",
					"dependency"    => array(
						"element"   => "style",
						"value"   => array("abc"),
						)
				),
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"heading" => esc_html__("Content",'micar'),
					"param_name" => "content",
					"dependency"    => array(
						"element"   => "style",
						"value"   => array("abc"),
						)
				),
				array(
					'type' => 'css_editor',
					'heading' => esc_html__( 'Custom Css', 'micar' ),
					'param_name' => 'custom_css',
					'group' => esc_html__( 'Design options', 'micar' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Class Extra', 'micar' ),
					'param_name' => 'class_extra',
					'group' => esc_html__( 'Design options', 'micar' ),
				),
			)
		));
	}
}	