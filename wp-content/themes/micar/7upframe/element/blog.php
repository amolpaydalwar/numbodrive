<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 29/02/16
 * Time: 10:00 AM
 */

if(!function_exists('s7upf_vc_blog'))
{
    function s7upf_vc_blog($attr)
    {
        $html = $class_nav = '';
        extract(shortcode_atts(array(
            'style'      => 'content',
            'number'     => '',
            'sv_excerpt'    => '',
            'cats'      => '',
            'order'      => '',
            'order_by'   => '',
        ),$attr));
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $args=array(
            'post_type'         => 'post',
            'posts_per_page'    => $number,
            'orderby'           => $order_by,
            'order'             => $order,
            'paged'             => $paged,
        );
        if($order_by == 'post_views'){
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'post_views';
        }
        if($order_by == 'time_update'){
            $args['orderby'] = 'meta_value';
            $args['meta_key'] = 'time_update';
        }
        if($order_by == '_post_like_count'){
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = '_post_like_count';
        }
        if(!empty($cats)) {
            $custom_list = explode(",",$cats);
            $args['tax_query'][]=array(
                'taxonomy'=>'category',
                'field'=>'slug',
                'terms'=> $custom_list
            );
        }
        $query = new WP_Query($args);
        global $count;
        $count = 1;
        $count_query = $query->post_count;
        $max_page = $query->max_num_pages;
        $html .=    '<div class="blog-list">';
        ob_start();
        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                get_template_part( 's7upf_templates/blog-content/content');
                $count++;
            }
        }
        $html .=    ob_get_clean();
            $big = 999999999;
			$html .= 			'<div class="pagi-nav text-center">';
            $html .=            paginate_links( array(
                                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                    'format'       => '&page=%#%',
                                    'current'      => max( 1, $paged ),
                                    'total'        => $query->max_num_pages,                                    
                                    'mid_size'     => 1,
                                    'type'         => 'plain',
                                    'prev_text'    => '<i class="icon ion-ios-arrow-back"></i>',
                                    'next_text'    => '<i class="icon ion-ios-arrow-forward"></i>',
                                ) );
			 $html .=           '</div>';					
								
        $html .=    '</div>';
        wp_reset_postdata();
        return $html;
    }
}

stp_reg_shortcode('sv_blog','s7upf_vc_blog');

vc_map( array(
    "name"      => esc_html__("SV Blog", 'micar'),
    "base"      => "sv_blog",
    "icon"      => "icon-st",
    "category"  => '7Up-theme',
    "params"    => array(
        array(
            "type" => "textfield",
            "heading" => esc_html__("Number post",'micar'),
            "param_name" => "number",
            'description'   => esc_html__( 'Number of post display in this element. Default is 10.', 'micar' ),
        ),       
        array(
            'holder'     => 'div',
            'heading'     => esc_html__( 'Categories', 'micar' ),
            'type'        => 'checkbox',
            'param_name'  => 'cats',
            'value'       => s7upf_list_taxonomy('category',false)
        ),
        array(
            "type"          => "dropdown",
            "heading"       => esc_html__("Order",'micar'),
            "param_name"    => "order",
            "value"         => array(
                esc_html__('Desc','micar') => 'DESC',
                esc_html__('Asc','micar')  => 'ASC',
                ),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
        array(
            "type"          => "dropdown",
            "heading"       => esc_html__("Order By",'micar'),
            "param_name"    => "order_by",
            "value"         => s7upf_get_order_list(),
            'edit_field_class'=>'vc_col-sm-6 vc_column'
        ),
    )
));