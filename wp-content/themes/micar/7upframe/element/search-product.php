<?php
/**
 * Created by Sublime text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:00 AM
 */

if(!function_exists('s7upf_vc_search_form'))
{
    function s7upf_vc_search_form($attr)
    {
        $html = $label_sm = '';
        extract(shortcode_atts(array(
            'style'             => 'smart-search1',
            'placeholder'       => '',
            'live_search'       => 'on',
            'cats'              => '',
            'cats_hidden'       => '',
        ),$attr));
        if(!empty($cats)) $cats = str_replace(' ', '', $cats);
        ob_start();
        $search_val = get_search_query();
            ?>
			<div class="smart-search <?php echo esc_attr($style)?> inline-block live-search-<?php echo esc_attr($live_search)?>">
				<form class="smart-search-form" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
					<?php if($cats_hidden !== 'off'):?>
					<div class="select-category select-box gray">
						<select name="product_cat">
							<option value=''><?php echo esc_html__( 'All Categories','micar' ); ?></option>
							<?php 
								if(!empty($cats)){
									$custom_list = explode(",",$cats);
									foreach ($custom_list as $key => $cat) {
										$term = get_term_by( 'slug',$cat, 'product_cat' );
										if(!empty($term) && is_object($term)){
											if(!empty($term) && is_object($term)){
												echo '<option value="'.$term->slug.'">'.$term->name.'</option>';
											}
										}
									}
								}
								else{
									$product_cat_list = get_terms('product_cat');
									if(is_array($product_cat_list) && !empty($product_cat_list)){
										foreach ($product_cat_list as $cat) {
											echo '<option value="'.$term->slug.'">'.$term->name.'</option>';
										}
									}
								}
							?>
						</select> 
					</div>
					<?php endif;?>
					<input name="s" type="text" value="<?php echo esc_attr($search_val);?>" placeholder="<?php echo esc_attr($placeholder)?>">
					<input type="hidden" name="post_type" value="product" />
					<div class="submit-form gradient radius4 bg-color">
						<input type="submit" class="shop-button" value="<?php esc_html_e('Search','micar')?>">
					</div>
					<div class="list-product-search">
						<p class="text-center"><?php esc_html_e("Please enter key search to display results.","micar")?></p>
					</div>
				</form>
			</div>
			<?php
        $html .=    ob_get_clean();
        return $html;
    }
}

stp_reg_shortcode('sv_search_form','s7upf_vc_search_form');
$check_add = '';
if(isset($_GET['return'])) $check_add = $_GET['return'];
if(empty($check_add)) add_action( 'vc_before_init_base','sv_add_admin_search',10,100 );
if ( ! function_exists( 'sv_add_admin_search' ) ) {
    function sv_add_admin_search(){
        vc_map( array(
            "name"      => esc_html__("SV Search Product", 'micar'),
            "base"      => "sv_search_form",
            "icon"      => "icon-st",
            "category"  => '7Up-theme',
            "params"    => array(
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Style",'micar'),
                    "param_name" => "style",
                    "value"     => array(
                        esc_html__("Style 1",'micar')   => 'smart-search1',
                        esc_html__("Style 2",'micar')   => 'smart-search3',
                        )
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => esc_html__("Place holder input",'micar'),
                    "param_name" => "placeholder",
                ),
                array(
                    'holder'     => 'div',
                    'heading'     => esc_html__( 'Product Categories', 'micar' ),
                    'type'        => 'autocomplete',
                    'param_name'  => 'cats',
                    'settings' => array(
                        'multiple' => true,
                        'sortable' => true,
                        'values' => s7upf_get_product_taxonomy(),
                    ),
                    'save_always' => true,
                    'description' => esc_html__( 'List of product categories', 'micar' ),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Live Search",'micar'),
                    "param_name" => "live_search",
                    "value"     => array(
                        esc_html__("Yes",'micar')   => 'on',
                        esc_html__("No",'micar')   => 'off',
                        )
                ),
            )
        ));
    }
}
add_action( 'wp_ajax_live_search', 's7upf_live_search' );
add_action( 'wp_ajax_nopriv_live_search', 's7upf_live_search' );
if(!function_exists('s7upf_live_search')){
    function s7upf_live_search() {
        $key = $_POST['key'];
        $cat = $_POST['cat'];
        $post_type = $_POST['post_type'];
        $trim_key = trim($key);
        $args = array(
            'post_type' => $post_type,
            's'         => $key,
            );
        if(!empty($cat)) {
            $args['tax_query'][]=array(
                'taxonomy'  =>  'product_cat',
                'field'     =>  'slug',
                'terms'     =>  $cat
            );
        }
        $query = new WP_Query( $args );
        if( $query->have_posts() && !empty($key) && !empty($trim_key)){
            while ( $query->have_posts() ) : $query->the_post();
                global $product;
                echo    '<div class="item-search-pro table">
                            <div class="search-ajax-thumb product-thumb">
                                <a href="'.esc_url(get_the_permalink()).'" class="product-thumb-link">
                                    '.get_the_post_thumbnail(get_the_ID(),s7upf_get_option('product_size_thumb')).'
                                </a>
                            </div>
							<div class="product-info">
								<div class="search-ajax-title"><h3 class="title14"><a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a></h3></div>
								<div class="search-ajax-price">
									'.s7upf_get_price_html().'
								</div>
							</div>
                        </div>';
            endwhile;
        }
        else{
            echo '<p class="text-center">'.esc_html__("No any results with this keyword.","micar").'</p>';
        }
        wp_reset_postdata();
    }
}