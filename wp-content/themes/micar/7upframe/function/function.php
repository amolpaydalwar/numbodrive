<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
 
/******************************************Core Function******************************************/
add_action( 'init', 's7upf_get_product_taxonomy' );
//Get option
if(!function_exists('s7upf_get_option')){
	function s7upf_get_option($key,$default=NULL)
    {
        if(function_exists('ot_get_option'))
        {
            return ot_get_option($key,$default);
        }

        return $default;
    }
}
//Get list post type
if(!function_exists('s7upf_list_post_type')){
    function s7upf_list_post_type($post_type = 'page',$type = true){
        global $post;
        $post_temp = $post;
        $page_list = array();
        if($type){
            $page_list[] = array(
                'value' => '',
                'label' => esc_html__('-- Choose One --','micar')
            );
        }
        else $page_list[] = esc_html__('-- Choose One --','micar');
        if(is_admin()){
            $pages = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) );
            if(is_array($pages)){
                foreach ($pages as $page) {
                    if($type){
                        $page_list[] = array(
                            'value' => $page->ID,
                            'label' => $page->post_title,
                        );
                    }
                    else $page_list[$page->ID] = $page->post_title;
                }
            }
        }
        $post = $post_temp;
        return $page_list;
    }
}
//Get list header page
if(!function_exists('s7upf_list_header_page'))
{
    function s7upf_list_header_page()
    {
        global $post;
        $page_list = array();
        $page_list[] = array(
            'value' => '',
            'label' => esc_html__('-- Choose One --','micar')
        );
        $args= array(
        'post_type' => 'page',
        'posts_per_page' => -1, 
        );
        $query = new WP_Query($args);
        if($query->have_posts()): while ($query->have_posts()):$query->the_post();
            if (strpos($post->post_content, '[s7upf_logo') ||  strpos($post->post_content, '[s7upf_menu')) {
                $page_list[] = array(
                    'value' => $post->ID,
                    'label' => $post->post_title
                );
            }
            endwhile;
        endif;
        wp_reset_postdata();
        return $page_list;
    }
}

//Get list sidebar
if(!function_exists('s7upf_get_sidebar_ids'))
{
    function s7upf_get_sidebar_ids($for_optiontree=false)
    {
        global $wp_registered_sidebars;
        $r = array();
        $r[]=esc_html__('--Select--','micar');
        if(!empty($wp_registered_sidebars)){
            foreach($wp_registered_sidebars as $key=>$value)
            {

                if($for_optiontree){
                    $r[]=array(
                        'value'=>$value['id'],
                        'label'=>$value['name']
                    );
                }else{
                    $r[$value['id']]=$value['name'];
                }
            }
        }
        return $r;
    }
}

//Get order list
if(!function_exists('s7upf_get_order_list'))
{
    function s7upf_get_order_list($current=false,$extra=array(),$return='array')
    {
        $default = array(
            esc_html__('None','micar')               => 'none',
            esc_html__('Post ID','micar')            => 'ID',
            esc_html__('Author','micar')             => 'author',
            esc_html__('Post Title','micar')         => 'title',
            esc_html__('Post Name','micar')          => 'name',
            esc_html__('Post Date','micar')          => 'date',
            esc_html__('Last Modified Date','micar') => 'modified',
            esc_html__('Post Parent','micar')        => 'parent',
            esc_html__('Random','micar')             => 'rand',
            esc_html__('Comment Count','micar')      => 'comment_count',
            esc_html__('View Post','micar')          => 'post_views',
            esc_html__('Like Post','micar')          => '_post_like_count',
            esc_html__('Custom Modified Date','micar')=> 'time_update',            
        );

        if(!empty($extra) and is_array($extra))
        {
            $default=array_merge($default,$extra);
        }

        if($return=="array")
        {
            return $default;
        }elseif($return=='option')
        {
            $html='';
            if(!empty($default)){
                foreach($default as $key=>$value){
                    $selected=selected($value,$current,false);
                    $html.="<option {$selected} value='{$value}'>{$key}</option>";
                }
            }
            return $html;
        }
    }
}

// Get sidebar
if(!function_exists('s7upf_get_sidebar'))
{
    function s7upf_get_sidebar()
    {
        $default=array(
            'position'=>'right',
            'id'      =>'blog-sidebar'
        );

        return apply_filters('s7upf_get_sidebar',$default);
    }
}

//Fill css background
if(!function_exists('s7upf_fill_css_background'))
{
    function s7upf_fill_css_background($data)
    {
        $string = '';
        if(!empty($data['background-color'])) $string .= 'background-color:'.$data['background-color'].';'."\n";
        if(!empty($data['background-repeat'])) $string .= 'background-repeat:'.$data['background-repeat'].';'."\n";
        if(!empty($data['background-attachment'])) $string .= 'background-attachment:'.$data['background-attachment'].';'."\n";
        if(!empty($data['background-position'])) $string .= 'background-position:'.$data['background-position'].';'."\n";
        if(!empty($data['background-size'])) $string .= 'background-size:'.$data['background-size'].';'."\n";
        if(!empty($data['background-image'])) $string .= 'background-image:url("'.$data['background-image'].'");'."\n";
        if(!empty($string)) return S7upf_Assets::build_css($string);
        else return false;
    }
}

// Get list menu
if(!function_exists('s7upf_list_menu_name'))
{
    function s7upf_list_menu_name()
    {
        $menu_nav = wp_get_nav_menus();
        $menu_list = array('Default' => '');
        if(is_array($menu_nav) && !empty($menu_nav))
        {
            foreach($menu_nav as $item)
            { 
                if(is_object($item))
                {
                    $menu_list[$item->name] = $item->slug;
                }
            }
        }
        return $menu_list;
    }
}

//Display BreadCrumb
if(!function_exists('s7upf_display_breadcrumb'))
{
    function s7upf_display_breadcrumb()
    {
		
		$breadcrumb = s7upf_get_option('s7upf_show_breadrumb');
        if($breadcrumb == 'on'){ 
		?>
		<div class="tp-breadcrumb">
			<div class="container">
				<div class="bread-crumb">
				<?php 
					if(function_exists('bcn_display')) bcn_display();
					else s7upf_breadcrumb();
				?>
				</div>
			</div>
		</div>
        <?php }
    }
}

//Custom BreadCrumb
if(!function_exists('s7upf_breadcrumb'))
{
    function s7upf_breadcrumb() {
        global $post;
        if (!is_home() || (is_home() && !is_front_page())) {
            echo '<a href="';
            echo esc_url(home_url('/'));
            echo '">';
            echo esc_html__('Home','micar');
            echo '</a>'.'<i>-</i></span> ';
            if(is_home() && !is_front_page()){
                echo '<span>'.esc_html__('Blog','micar').'</span>'; 
            }
            if (is_category() || is_single()) {
                the_category('<i>-</i></span> ');
                if (is_single()) {
                    echo '<i>-</i><span> ';
                    the_title();
                    echo '</span>';
                }
            } elseif (is_page()) {
                if($post->post_parent){
                    $anc = get_post_ancestors( get_the_ID() );
                    $title = get_the_title();
                    foreach ( $anc as $ancestor ) {
                        $output = '<a href="'.esc_url(get_permalink($ancestor)).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a><i>-</i><span> ';
                    }
                    echo apply_filters('s7upf_output_content',$output);
                    echo '<span> '.$title.'</span>';
                } else {
                    echo '<span> '.get_the_title().'</span>';
                }
            }
        }
        elseif (is_tag()) {single_tag_title();}
        elseif (is_day()) {echo"<span>".esc_html_e("Archive for ","micar"); the_time(get_option( 'date_format' )); echo'</span>';}
        elseif (is_month()) {echo"<span>".esc_html_e("Archive for ","micar"); echo get_the_time('F, Y'); echo'</span>';}
        elseif (is_year()) {echo"<span>".esc_html_e("Archive for ","micar"); echo getthe_time('Y'); echo'</span>';}
        elseif (is_author()) {echo"<span>".esc_html_e("Author Archive ","micar"); echo'</span>';}
        elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<span>".esc_html_e("Blog Archives","micar"); echo'</span>';}
        elseif (is_search()) {echo"<span>".esc_html_e("Search Results","micar"); echo'</span>';}
    }
}

//Get page value by ID
if(!function_exists('s7upf_get_value_by_id'))
{   
    function s7upf_get_value_by_id($key)
    {
        if(!empty($key)){
            $id = get_the_ID();
            if(is_front_page() && is_home()) $id = (int)get_option( 'page_on_front' );
            if(!is_front_page() && is_home()) $id = (int)get_option( 'page_for_posts' );
            if(is_archive() || is_search()) $id = 0;
            if (class_exists('woocommerce')) {
                if(is_shop()) $id = (int)get_option('woocommerce_shop_page_id');
                if(is_cart()) $id = (int)get_option('woocommerce_cart_page_id');
                if(is_checkout()) $id = (int)get_option('woocommerce_checkout_page_id');
                if(is_account_page()) $id = (int)get_option('woocommerce_myaccount_page_id');
            }
            $value = get_post_meta($id,$key,true);
            if(empty($value)) $value = s7upf_get_option($key);
            return $value;
        }
        else return 'Missing a variable of this funtion';
    }
}

//Check woocommerce page
if (!function_exists('s7upf_is_woocommerce_page')) {
    function s7upf_is_woocommerce_page() {
        if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
                return true;
        }
        $woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
                                        "woocommerce_terms_page_id" ,
                                        "woocommerce_cart_page_id" ,
                                        "woocommerce_checkout_page_id" ,
                                        "woocommerce_pay_page_id" ,
                                        "woocommerce_thanks_page_id" ,
                                        "woocommerce_myaccount_page_id" ,
                                        "woocommerce_edit_address_page_id" ,
                                        "woocommerce_view_order_page_id" ,
                                        "woocommerce_change_password_page_id" ,
                                        "woocommerce_logout_page_id" ,
                                        "woocommerce_lost_password_page_id" ) ;
        foreach ( $woocommerce_keys as $wc_page_id ) {
                if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
                        return true ;
                }
        }
        return false;
    }
}

//navigation
if(!function_exists('s7upf_paging_nav'))
{
    function s7upf_paging_nav()
    {
        // Don't print empty markup if there's only one page.
        if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
            return;
        }

        $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
        $pagenum_link = html_entity_decode( get_pagenum_link() );
        $query_args   = array();
        $url_parts    = explode( '?', $pagenum_link );

        if ( isset( $url_parts[1] ) ) {
            wp_parse_str( $url_parts[1], $query_args );
        }

        $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
        $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

        $format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
        $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

        // Set up paginated links.
        $links = paginate_links( array(
            'base'     => $pagenum_link,
            'format'   => $format,
            'total'    => $GLOBALS['wp_query']->max_num_pages,
            'current'  => $paged,
            'mid_size' => 1,
            'add_args' => array_map( 'urlencode', $query_args ),
            'prev_text' => '<i class="icon ion-ios-arrow-back"></i>',
            'next_text' => '<i class="icon ion-ios-arrow-forward"></i>',
        ) );

        if ($links) : ?>
        <div class="row">
            <div class="col-md-12 tp-pagination">
                <nav class="navigation paging-navigation" role="navigation">
                    <div class="pagination loop-pagination pagi-nav text-center">
                        <?php echo apply_filters('s7upf_output_content',$links); ?>
                    </div><!-- .pagination -->
                </nav><!-- .navigation -->
            </div>
        </div>
        <?php endif;
    }
}

//Set post view
if(!function_exists('s7upf_set_post_view'))
{
    function s7upf_set_post_view($post_id=false)
    {
        if(!$post_id) $post_id=get_the_ID();

        $view=(int)get_post_meta($post_id,'post_views',true);
        $view++;
        update_post_meta($post_id,'post_views',$view);
    }
}

if(!function_exists('s7upf_get_post_view'))
{
    function s7upf_get_post_view($post_id=false)
    {
        if(!$post_id) $post_id=get_the_ID();

        return (int)get_post_meta($post_id,'post_views',true);
    }
}

//remove attr embed
if(!function_exists('s7upf_remove_w3c')){
    function s7upf_remove_w3c($embed_code){
        $embed_code=str_replace('webkitallowfullscreen','',$embed_code);
        $embed_code=str_replace('mozallowfullscreen','',$embed_code);
        $embed_code=str_replace('frameborder="0"','',$embed_code);
        $embed_code=str_replace('frameborder="no"','',$embed_code);
        $embed_code=str_replace('scrolling="no"','',$embed_code);
        $embed_code=str_replace('&','&amp;',$embed_code);
        return $embed_code;
    }
}

// MetaBox
if(!function_exists('s7upf_display_metabox'))
{
    function s7upf_display_metabox($type ='') {
		$comment_num = get_comments_number();
		$comment_text = esc_html__('Comments','micar');
		if($comment_num == 1){
			$comment_text = esc_html__('Comment','micar');
		}
        switch ($type) {
            case 'blog':
                break;

            default:
			?>
                
                <div class="post-cat-comment table border-bottom">
                    <div class="text-left">
                        <ul class="post-date-cat list-inline-block">
							<li><i class="fa fa-calendar"></i><a href="<?php echo esc_url(the_permalink()); ?>"><span class="navi"><?php echo get_the_date(get_option('date_format'))?></span></a></li>
							<li><i class="fa fa-user"></i><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="silver"><?php echo get_the_author(); ?></a></li>
						</ul>
                    </div>
                    <div class="text-right">
						<i class="fa fa-comment"></i>
                        <span class="navi"><?php echo esc_html($comment_text)?></span>
                        <a href="#comments" class="silver"><?php echo get_comments_number(); ?></a>
                    </div>
                </div>
				<?php $cats = get_the_category_list(' ');?>
					<div class="post-tabs inline-block">
						<i class="fa fa-folder"></i>
						<?php if($cats) echo apply_filters('s7upf_output_content',$cats); else esc_html_e("No Category",'micar');?>
					</div>	
				<?php
				$cats = get_the_tag_list(' ',' ',' ');
				if($cats){?>
					<div class="post-tabs inline-block post-tabs-cats">
						<i class="fa fa-tags"></i>
						<?php echo apply_filters('s7upf_output_content',$cats);?>
					</div>
				<?php }
                break;
        }
    ?>        
    <?php
    }
}
if(!function_exists('s7upf_get_header_default')){
    function s7upf_get_header_default(){
        ?>
        <div id="header" class="header header-default">
			<div class="main-header4">
				<div class="container">
					<div class="logo">
						<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr__("logo","micar");?>">
							<?php $s7upf_logo=s7upf_get_option('logo');?>
							<?php if($s7upf_logo!=''){
								echo '<h1 class="hidden">'.get_bloginfo('name', 'display').'</h1><img src="' . esc_url($s7upf_logo) . '" alt="logo">';
							}   else { echo '<h1>'.get_bloginfo('name', 'display').'</h1>'; }
							?>
						</a>
					</div>
				</div>
			</div>
			<div class="header-nav4 bg-color2">
				<div class="container">
					<nav class="main-nav main-nav1 style2">
						<?php if ( has_nav_menu( 'primary' ) ) {
							wp_nav_menu( array(
									'theme_location' => 'primary',
									'container'=>false,
									'walker'=>new S7upf_Walker_Nav_Menu(),
								 )
							);
						} ?>
						<a class="toggle-mobile-menu" href="#"><span></span></a>
					</nav>
				</div>
            </div>
        </div>
        <?php
    }
}
if(!function_exists('s7upf_get_footer_default')){
    function s7upf_get_footer_default(){
        ?>
        <div id="footer" class="default-footer footer1">
            <div class="container">
                <p class="copyright desc white"><?php esc_html_e("Copyright &copy; by 7up. All Rights Reserved. Designed by","micar")?> <a href="#" class="smoke"><span><?php esc_html_e("7uptheme","micar")?></span>.<?php esc_html_e("com","micar")?></a>.</p>
            </div>
        </div>
        <?php
    }
}
if(!function_exists('s7upf_get_footer_visual')){
    function s7upf_get_footer_visual($page_id){
        ?>
        <div id="footer" class="footer-page">
            <div class="container">
                <?php echo S7upf_Template::get_vc_pagecontent($page_id);?>
            </div>
        </div>
        <?php
    }
}
if(!function_exists('s7upf_get_header_visual')){
    function s7upf_get_header_visual($page_id){
        ?>
        <div id="header" class="header-page">
            <div class="container">
                <?php echo S7upf_Template::get_vc_pagecontent($page_id);?>
            </div>
        </div>
        <?php
    }
}
if(!function_exists('s7upf_get_main_class')){
    function s7upf_get_main_class(){
        $sidebar=s7upf_get_sidebar();
        $sidebar_pos=$sidebar['position'];
        $main_class = 'col-md-12';
        if($sidebar_pos != 'no') $main_class = 'col-md-9 col-sm-8 col-xs-12';
        return $main_class;
    }
}
if(!function_exists('s7upf_output_sidebar')){
    function s7upf_output_sidebar($position){
        $sidebar = s7upf_get_sidebar();
        $sidebar_pos = $sidebar['position'];
		
        if($sidebar_pos == $position) get_sidebar();
    }
}
if(!function_exists('s7upf_get_import_category')){
    function s7upf_get_import_category($taxonomy){
        $cats = get_terms($taxonomy);
        $data_json = '{';
        foreach ($cats as $key => $term) {
            $thumb_cat_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
            $term_pa = get_term_by( 'id',$term->parent, $taxonomy );
            if(isset($term_pa->slug)) $slug_pa = $term_pa->slug;
            else $slug_pa = '';
            if($key > 0) $data_json .= ',';
            $data_json .= '"'.$term->slug.'":{"thumbnail":"'.$thumb_cat_id.'","parent":"'.$slug_pa.'"}';
        }
        $data_json .= '}';
        echo apply_filters('s7upf_output_content',$data_json);
    }
}
if(!function_exists('s7upf_fix_import_category')){
    function s7upf_fix_import_category($taxonomy){
        global $s7upf_config;
        $data = $s7upf_config['import_category'];
        if(!empty($data)){
            $data = json_decode($data,true);
            foreach ($data as $cat => $value) {
                $parent_id = 0;
                $term = get_term_by( 'slug',$cat, $taxonomy );
                $term_parent = get_term_by( 'slug', $value['parent'], $taxonomy );
                if(isset($term_parent->term_id)) $parent_id = $term_parent->term_id;
                if($parent_id) wp_update_term( $term->term_id, $taxonomy, array('parent'=> $parent_id) );
                if($value['thumbnail']){
                    if($taxonomy == 'product_cat')  update_woocommerce_term_meta( $term->term_id, 'thumbnail_id', $value['thumbnail']);
                    else{
                        update_term_meta( $term->term_id, 'thumbnail_id', $value['thumbnail']);
                    }
                }
            }
        }
    }
}

if ( ! function_exists( 's7upf_get_google_link' ) ) {
    function s7upf_get_google_link() {
        $protocol = is_ssl() ? 'https' : 'http';
        $fonts_url = '';
        $fonts  = array(
                    'Poppins:300,400,700',
                    'Anton',
                );
        if ( $fonts ) {
            $fonts_url = add_query_arg( array(
                'family' => urlencode( implode( '|', $fonts ) ),
            ), $protocol.'://fonts.googleapis.com/css' );
        }

        return $fonts_url;
    }
}
// get list taxonomy
if(!function_exists('s7upf_list_taxonomy'))
{
    function s7upf_list_taxonomy($taxonomy,$show_all = true)
    {
        if($show_all) $list = array('--Select--' => '');
        else $list = array();
        if(!isset($taxonomy) || empty($taxonomy)) $taxonomy = 'category';
        $tags = get_terms($taxonomy);
        if(is_array($tags) && !empty($tags)){
            foreach ($tags as $tag) {
                $list[$tag->name] = $tag->slug;
            }
        }
        return $list;
    }
}

if(!function_exists('s7upf_get_custom_javascript')){
    function s7upf_get_custom_javascript(){
        $custom_js = s7upf_get_option('s7upf_custom_javascript');
        if(!empty($custom_js)){
            ?><script type="text/javascript"><?php
                print $custom_js;
                ?></script><?php
        }
    }
}
/***************************************END Core Function***************************************/


/***************************************Add Theme Function***************************************/
//Get Product Taxonomy
if(!function_exists('s7upf_get_product_taxonomy')){
    function s7upf_get_product_taxonomy($taxonomy = 'product_cat') {    
        $result = array();
        $tags = get_terms($taxonomy);
        if(is_array($tags) && !empty($tags)){
            foreach ($tags as $tag) {
                $list[$tag->name] = $tag->slug;
                $result[] = array(
                    'value' => $tag->slug,
                    'label' => $tag->name,
                );
            }
        }
        return $result;
    }
}
if(!function_exists('s7upf_shop_loop_before')){
    function s7upf_shop_loop_before($query,$orderby = 'menu_order',$type = 'grid',$number = '',$column = '',$size='full'){
        if(empty($number)) $number = 6;
        if(empty($column)) $column = 3;
        ?>
			<div class="title-page">
				<div class="row">
					<div class="col-md-12">
						<h2 class="title30 anton-font text-uppercase pull-left"><?php single_cat_title();?></h2>
						<ul class="sort-pagi-bar list-inline-block pull-right">
							<li>
								<div class="dropdown-box sort-by select-box">
									<span class="text-uppercase gray"><?php esc_html_e("Sort By:","micar")?></span>
									<?php s7upf_catalog_ordering($query,$orderby)?>
								</div>
							</li>
							<li>
								<div class="dropdown-box show-by">
									<a href="javascript:void(0)" class="dropdown-link"><span class="text-uppercase gray">Show by:</span><span class="shop-show-value show-number-item silver"><?php echo esc_html($number)?></span></a>
									<ul class="dropdown-list list-none">
										<li><a data-number="6" href="<?php echo esc_url(s7upf_get_key_url('number','6'))?>"><?php esc_html_e("6","micar")?></a></li>
										<li><a data-number="9" href="<?php echo esc_url(s7upf_get_key_url('number','9'))?>"><?php esc_html_e("9","micar")?></a></li>
										<li><a data-number="12" href="<?php echo esc_url(s7upf_get_key_url('number','12'))?>"><?php esc_html_e("12","micar")?></a></li>
										<li><a data-number="18" href="<?php echo esc_url(s7upf_get_key_url('number','18'))?>"><?php esc_html_e("18","micar")?></a></li>
										<li><a data-number="24" href="<?php echo esc_url(s7upf_get_key_url('number','24'))?>"><?php esc_html_e("24","micar")?></a></li>
										<li><a data-number="48" href="<?php echo esc_url(s7upf_get_key_url('number','48'))?>"><?php esc_html_e("48","micar")?></a></li>
									</ul>
								</div>
							</li>
							<li>
								<div class="view-type">
									<a data-type="grid" href="<?php echo esc_url(s7upf_get_key_url('type','grid'))?>" class="<?php if($type == 'grid') echo 'active'?>"><i class="icon ion-grid"></i></a>
									<a data-type="list" href="<?php echo esc_url(s7upf_get_key_url('type','list'))?>" class="<?php if($type == 'list') echo 'active'?>"><i class="icon ion-navicon"></i></a>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- End Title Page -->
			<?php 
				$has_sidebar = s7upf_check_sidebar();
				if($has_sidebar!='true'){
					echo s7upf_search_filter();
				}
			?>
			<div class="product-box-<?php echo esc_attr($type)?>">
				<div class="row">
        <?php
    }
}
if(!function_exists('s7upf_shop_loop_after')){
    function s7upf_shop_loop_after($query,$paged = false){
        if(!$paged) $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $max_page = $query->max_num_pages;
        ?>
				</div>
				<div class="pagi-nav text-center">
					<?php
						echo paginate_links( array(
							'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
							'format'       => '',
							'add_args'     => '',
							'current'      => max( 1, $paged ),
							'total'        => $query->max_num_pages,
							'prev_text'    => '<i class="icon ion-android-arrow-back"></i>',
							'next_text'    => '<i class="icon ion-android-arrow-forward"></i>',
							'type'         => 'plain',
							'end_size'     => 2,
							'mid_size'     => 1
						) );
					?>
				</div>
			</div>
        <?php
    }
}
//Get type url
if(!function_exists('s7upf_get_key_url')){
    function s7upf_get_key_url($key,$value){
        if(function_exists('s7upf_get_current_url')) $current_url = s7upf_get_current_url();
        else{
            if(function_exists('wc_get_page_id')) $current_url = get_permalink( wc_get_page_id( 'shop' ) );
            else $current_url = get_permalink();
        }
        if(isset($_GET[$key])){
            $current_url = str_replace('&'.$key.'='.$_GET[$key], '', $current_url);
            $current_url = str_replace('?'.$key.'='.$_GET[$key], '?', $current_url);
        }
        if(strpos($current_url,'?') > -1 ){
            $current_url .= '&amp;'.$key.'='.$value;
        }
        else {
            $current_url .= '?'.$key.'='.$value;
        }
        return $current_url;
    }
}
//get type url
if(!function_exists('s7upf_get_filter_url')){
    function s7upf_get_filter_url($key,$value){
        if(function_exists('s7upf_get_current_url')) $current_url = s7upf_get_current_url();
        else{
            if(function_exists('wc_get_page_id')) $current_url = get_permalink( wc_get_page_id( 'shop' ) );
            else $current_url = get_permalink();
        }
        if(isset($_GET[$key])){
            $current_val_string = $_GET[$key];
            if($current_val_string == $value){
                $current_url = str_replace('&'.$key.'='.$_GET[$key], '', $current_url);
                $current_url = str_replace('?'.$key.'='.$_GET[$key], '?', $current_url);
            }
            $current_val_key = explode(',', $current_val_string);
            $val_encode = str_replace(',', '%2C', $current_val_string);
            if(!empty($current_val_string)){
                if(!in_array($value, $current_val_key)) $current_val_key[] = $value;
                else{
                    $pos = array_search($value, $current_val_key);
                    unset($current_val_key[$pos]);
                }            
                $new_val_string = implode('%2C', $current_val_key);
                $current_url = str_replace($key.'='.$val_encode, $key.'='.$new_val_string, $current_url);
                if (strpos($current_url, '?') == false) $current_url = str_replace('&','?',$current_url);
            }
            else $current_url = str_replace($key.'=', $key.'='.$value, $current_url);     
        }
        else{
            if(strpos($current_url,'?') > -1 ){
                $current_url .= '&amp;'.$key.'='.$value;
            }
            else {
                $current_url .= '?'.$key.'='.$value;
            }
        }
        return $current_url;
    }
}
//Catalog Ordering
if ( ! function_exists( 's7upf_catalog_ordering' ) ) {
    function s7upf_catalog_ordering($query,$set_orderby = '') {        
        $orderby                 = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
        if(!empty($set_orderby)) $orderby = $set_orderby;
        $show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
        $catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
            'menu_order' => esc_html__( 'Default sorting', 'micar' ),
            'popularity' => esc_html__( 'Popularity', 'micar' ),
            'rating'     => esc_html__( 'Average rating', 'micar' ),
            'date'       => esc_html__( 'Newness', 'micar' ),
            'price'      => esc_html__( 'Price: low to high', 'micar' ),
            'price-desc' => esc_html__( 'Price: high to low', 'micar' )
        ) );

        if ( ! $show_default_orderby ) {
            unset( $catalog_orderby_options['menu_order'] );
        }

        if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
            unset( $catalog_orderby_options['rating'] );
        }

        wc_get_template( 'loop/orderby.php', array( 'catalog_orderby_options' => $catalog_orderby_options, 'orderby' => $orderby, 'show_default_orderby' => $show_default_orderby ) );
    }
}
// Mini cart
if(!function_exists('s7upf_mini_cart')){
    function s7upf_mini_cart($echo = false){
        $html = '';
        if ( ! WC()->cart->is_empty() ){
            $count_item = 0; $html = '';
            $html .=    '<h2 class="title18 font-bold rale-font">(<span class="cart-item-count set-cart-number">0</span>) '.esc_html__('ITEMS IN MY CART','micar').'</h2>
                        <ul class="list-none list-mini-cart-item">';                    
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                $count_item++;
                $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                $product_quantity = woocommerce_quantity_input( array(
                    'input_name'  => "cart[{$cart_item_key}][qty]",
                    'input_value' => $cart_item['quantity'],
                    'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
                    'min_value'   => '0'
                ), $_product, false );
                $thumb_html = '';
                if(has_post_thumbnail($product_id)) $thumb_html = $_product->get_image(array(80,80));
                $html .=    '<li class=" item-info-cart" data-key="'.$cart_item_key.'">
								<div class="product-mini-cart table">
									<div class="mini-cart-thumb product-thumb">
										<a class="product-thumb-link" href="'.esc_url( $_product->get_permalink( $cart_item )).'">'.$thumb_html.'</a>
									</div>
									<div class="mini-cart-info product-info">
										<h3 class="product-title title14 text-uppercase font-bold"><a href="'.esc_url( $_product->get_permalink( $cart_item )).'">'.$_product->get_title().'</a></h3>
										<div class="info-price product-price">
											<ins class="mini-cart-price title14 color"><span>'.apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ).'</span></ins>
										</div>
										<div class="qty-product mini-cart-qty">
											<label class="qty-mini-cart">'.esc_html__("Qty:","micar").'</label> <span class="qty-num">'.$cart_item['quantity'].'</span>
										</div>
									</div>
									<div class="mini-cart-edit product-delete product-remove text-right">
										<a class="delete-mini-cart-item btn-remove remove-product remove" href="#"><i class="icon ion-trash-a"></i></a>
									</div>
								</div>
                            </li>';
            }
            $html .=    '</ul><input class="get-cart-number" id="count-cart-item" type="hidden" value="'.$count_item.'">';
            $html .=    '<div class="mini-cart-total text-uppercase rale-font title18 clearfix">
                            <span class="pull-left">'.esc_html__("TOTAL","micar").'</span>
                            <strong class="pull-right color total-price get-cart-price">'.WC()->cart->get_cart_subtotal().'</strong>
                        </div>
                        <div class="mini-cart-button">
                            <a href="'.esc_url(wc_get_cart_url()).'" class="mini-cart-view shop-button">'.esc_html__("View cart ","micar").'</a>
                            <a href="'.esc_url(wc_get_checkout_url()).'" class="mini-cart-checkout shop-button">'.esc_html__("Checkout","micar").'</a>
                        </div>';
        }
        else $html .= '<h5 class="mini-cart-head">'.esc_html__("No Product in your cart.","micar").'</h5>';
        if($echo) echo apply_filters('s7upf_output_content',$html);
        else return $html;
    }
}
// Mini cart
if(!function_exists('s7upf_search_filter')) {
    function s7upf_search_filter(){
		
		?>
		<div class="car-filter bg-white border">
			<h3 class="title18 title-car-filter text-uppercase text-right silver"><?php echo esc_html__('FILTERS','micar')?> </h3>
			<form  class="form-filter">
				<div class="row">
					<?php
						$woo_tax = s7upf_get_option('woo_taxonomy_product');
						foreach ($woo_tax as $key => $value):
						$title = $value['title'];
						$slug  = $value['taxonomy_slug'];
						$filter  = $value['show_tax_filter'];
						$slug = 'tax_'.$slug;
						$array = s7upf_get_product_taxonomy($slug);
						$get_tax = '';
						if(isset($_GET[$slug])){
							$get_tax = $_GET[$slug];
						}
						if($filter=='on'):
					?>
					<div class="col-md-4 colsm-6 col-xs-6">
						<div class="select-box select-box-filter">
							<select  name="<?php echo esc_attr($slug);?>">
								<option value=""> <?php echo esc_html__('Select','micar')?> <?php echo esc_html($value['title']);?> </option>
								<?php
									foreach ($array as $key => $tax):
									$selected='';
									if($tax['value']==$get_tax){$selected='selected';}
								?>
								<option <?php echo esc_attr($selected);?> value="<?php echo esc_attr($tax['value']);?>"><?php echo esc_attr($tax['label']);?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
					<?php endif;endforeach;?>
					<?php
						global $product; 
						$attribute = wc_get_attribute_taxonomies();
						foreach($attribute as $key=>$value):
						$terms = get_terms('pa_'.$value->attribute_name);
						if(!empty($terms)):
						$filter='filter_'.$value->attribute_name;
					?>
					<div class="col-md-4 colsm-6 col-xs-6">
						<div class="select-box select-box-filter">
							<select name="<?php  echo 'filter_'.$value->attribute_name;?>">
								<option value=""> <?php echo esc_html__('Select','micar')?> <?php echo esc_attr($value->attribute_label);?> </option>
								<?php
									foreach ($terms as $key => $term):
									$get_pa = '';
									if(isset($_GET[$filter])){
										$get_pa = $_GET[$filter];
									}
									$selected='';
									if($term->slug==$get_pa){$selected='selected';}
								?>
								<option <?php echo esc_attr($selected);?> value="<?php echo esc_attr($term->slug);?>"><?php  echo esc_attr($term->name);?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
					<?php endif;endforeach;?>
					<div class="col-md-4 colsm-6 col-xs-6">
						<div class="submit-filter shop-button gradient">
							<input type="submit" value="Search" />
						</div>
					</div>
				</div>
			</form>
		</div>
		<!-- End Car Filter -->
		<?php
	}
}
if(!function_exists('s7upf_header_image')){
    function s7upf_header_image(){        
        $header_show = s7upf_get_value_by_id('show_header_page');
        $header_images = s7upf_get_value_by_id('header_page_image');
        $html = ''; 
		$html .=    '<div class="banner-slider bg-slider banner-shop parallax-slider">
						<div class="wrap-item" data-itemscustom="[[0,1]]">';
		if(!empty($header_images) && is_array($header_images)){
			foreach ($header_images as $item) {
				$html .=    '<div class="item-slider item-shop-slider">
								<div class="banner-thumb">
									<a href="'.esc_url($item['header_link']).'"><img src="'.esc_url($item['header_image']).'" alt=""></a>
								</div>
								<div class="banner-info text-center white">
									<h2 class="title60 anton-font text-uppercase">'.esc_html($item['title']).'</h2>
								</div>
							</div>';
			}
		}
		$html .=        '</div>
					</div>';
        echo apply_filters('s7upf_output_content',$html);
    }
}
if(!function_exists('s7upf_share_box')){
    function s7upf_share_box($style = ''){
        global $post;
        switch ($style) {
            case 'product':
                $html = '<div class="social-footer">
                            <a href="'.esc_url('http://www.facebook.com/sharer.php?u='.get_the_permalink()).'" class="float-shadow inline-block round navi"><i class="ion-social-facebook"></i></a>
                            <a href="'.esc_url('http://www.twitter.com/share?url='.get_the_permalink()).'" class="float-shadow inline-block round navi"><i class="ion-social-twitter"></i></a>
                            <a href="'.esc_url('http://pinterest.com/pin/create/button/?url='.get_the_permalink().'&amp;media='.wp_get_attachment_url(get_post_thumbnail_id())).'" class="float-shadow inline-block round navi"><i class="ion-social-pinterest-outline"></i></a>
                            <a href="'.esc_url('https://plus.google.com/share?url='.get_the_permalink()).'" class="float-shadow inline-block round navi"><i class="ion-social-googleplus-outline"></i></a>
                        </div>';
                break;
            
            default:
                $html = '<div class="social-footer">
                            <a href="'.esc_url('http://www.facebook.com/sharer.php?u='.get_the_permalink()).'" class="inline-block round navi"><i class="ion-social-facebook"></i></a>
                            <a href="'.esc_url('http://www.twitter.com/share?url='.get_the_permalink()).'" class="inline-block round navi"><i class="ion-social-twitter"></i></a>
                            <a href="'.esc_url('http://pinterest.com/pin/create/button/?url='.get_the_permalink().'&amp;media='.wp_get_attachment_url(get_post_thumbnail_id())).'" class="inline-block round navi"><i class="ion-social-pinterest-outline"></i></a>
                            <a href="'.esc_url('https://plus.google.com/share?url='.get_the_permalink()).'" class="inline-block round navi"><i class="ion-social-googleplus-outline"></i></a>
                        </div>';
                break;
        }        
        return $html;
    }
}
if(!function_exists('s7upf_author_box')){
    function s7upf_author_box(){ 
        $des = get_the_author_meta('description');
        if(!empty($des)){
            $user_info = get_userdata(get_the_author_meta( 'ID' ));
        ?>
        <div class="single-info-author table">
            <div class="author-thumb">
                <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>">
                    <?php echo get_avatar(get_the_author_meta('email'),'100'); ?>
                </a>
            </div>
            <div class="author-info">
                <span class="navi"><?php esc_html_e("Written By","micar")?></span>
                <h3 class="title18 rale-font font-bold text-uppercase"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>" class="navi"><?php echo get_the_author_meta( 'user_nicename' ); ?></a></h3>
                <p class="navi"><?php echo get_the_author_meta('description'); ?></p>
                <div class="author-social">
                    <?php
                        global $post;
                        $sl=array(
                            'googleplus'    =>  "ion-social-googleplus",
                            'facebook'      =>  "ion-social-facebook",
                            'twitter'       =>  "ion-social-twitter",
                            'linkedin'      =>  "ion-social-linkedin",
                            'github'        =>  'ion-social-github',
                            'tumblr'        =>  'ion-social-tumblr',
                            'youtube'       =>  'ion-social-youtube',
                            'instagram'     =>  'ion-social-instagram',
                            'vimeo'         =>  'ion-social-vimeo'
                        );
                        if(isset($post->post_author)){
                            foreach($sl as $type=>$class){
                                $url  = get_user_option( $type, $post->post_author );
                                if($url==true){?>
                                    <a href="<?php echo esc_url($url);?>" class="title18 navi"><i class="<?php echo esc_attr($class);?>"></i></a>
                                <?php }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    <?php }
    }
}
//Convert Itemscustom
if(!function_exists('s7upf_convert_itemscustom')){
	function s7upf_convert_itemscustom($itemscustom){
		$itemscustom = str_replace(' ','',$itemscustom);
		$itemscustom = explode(",",$itemscustom);
		$itemscustom = implode("][",$itemscustom);
		$itemscustom = '['.$itemscustom.']';
		$itemscustom = str_replace(':',',',$itemscustom);
		$itemscustom = str_replace('][','],[',$itemscustom);
		$itemscustom = '['.$itemscustom.']';
		return $itemscustom;
	}
}
//Check Sidebar
if(!function_exists('s7upf_check_sidebar')){
    function s7upf_check_sidebar(){
        $sidebar = s7upf_get_sidebar();
        if($sidebar['position'] == 'no') return false;
        else return true;
    }
}
//Add Cart Link
if ( ! function_exists( 's7upf_addtocart_link' ) ) {
    function s7upf_addtocart_link($style = ''){
        global $product;
        switch ($style) {
            case 'style2':
                $icon = '<i class="icon ion-android-cart"></i>';
                $text = $product->add_to_cart_text();
                $btn_class = 'addcart-link';
                break;
            case 'style3':
                $icon = '<i class="icon ion-android-cart"></i>';
                $text = $product->add_to_cart_text();
                $btn_class = 'addcart-link link-btn gradient';                
                break;
            default:
                $icon = '<i class="icon ion-android-cart"></i>';
                $text = $product->add_to_cart_text();
                $btn_class = 'addcart-link shop-button bg-color';                
                break;
        }
        $button_html =  apply_filters( 'woocommerce_loop_add_to_cart_link',
            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s">'.$icon.'<span>%s</span></a>',
                esc_url( $product->add_to_cart_url() ),
                esc_attr( $product->get_id() ),
                esc_attr( $product->get_sku() ),
                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button '.$btn_class : ''.$btn_class,
                esc_attr( $product->get_type() ),
                esc_html( $text )
            ),
        $product );
        return $button_html;
    }
}
//Compare URL
if(!function_exists('s7upf_compare_url')){
    function s7upf_compare_url($id = false){
        $html = '';
        $icon = '<i class="icon ion-ios-browsers-outline"></i>';
        if(class_exists('YITH_Woocompare')){
            if(!$id) $id = get_the_ID();
            $cp_link = str_replace('&', '&amp;',add_query_arg( array('action' => 'yith-woocompare-add-product','id' => $id )));
            $html = '<a href="'.esc_url($cp_link).'" class="product-compare compare compare-link color" data-product_id="'.get_the_ID().'">'.$icon.'<span>'.esc_html__("Compare","micar").'</span></a>';
        }
        return $html;
    }
}

//Product Extra Link
if ( ! function_exists( 's7upf_product_link' ) ) {
    function s7upf_product_link($style=''){
        $html = $html_wl = '';
        if(class_exists('YITH_WCWL_Init')) $html_wl = '<a href="'.esc_url(str_replace('&', '&amp;',add_query_arg( 'add_to_wishlist', get_the_ID() ))).'" class="add_to_wishlist wishlist-link color" rel="nofollow" data-product-id="'.get_the_ID().'" data-product-title="'.esc_attr(get_the_title()).'"><i class="icon ion-android-favorite-outline"></i><span>'.esc_html__("Wishlist","micar").'</span></a>';
        switch ($style) {
            case 'text-left':
                $html .=     '<div class="product-extra-link clearfix product style1 '.esc_attr($style).'">';
                $html .=        s7upf_addtocart_link();
                $html .=        $html_wl;
                $html .=        s7upf_compare_url();
                $html .=    '</div>';
                break;
            
            case 'style2':
                $html .=     '<div class="product-extra-link clearfix product '.esc_attr($style).'">';
				$html .=    	'<a  data-product-id="'.get_the_id().'"  href="'.esc_url(get_the_permalink()).'" class="product-quick-view quickview-link"><i class="icon ion-eye"></i><span>'.esc_html__('Quick view','micar').'</span></a>';
                $html .=        s7upf_addtocart_link('style2');
                $html .=    '</div>';
                break;
            
            case 'style3':
                $html .=     '<div class="product-extra-link clearfix product '.esc_attr($style).'">';
				$html .=        s7upf_addtocart_link('style3');
                $html .=        $html_wl;
                $html .=        s7upf_compare_url();
                $html .=    '</div>';
                break;
            
            default:
                $html .=     '<div class="product-extra-link clearfix product style1 text-right'.esc_attr($style).'">';
                $html .=        s7upf_addtocart_link();
                $html .=        $html_wl;
                $html .=        s7upf_compare_url();
                $html .=    '</div>';
                break;
        }
        return $html;
    }
}
//Get Product Price
if(!function_exists('s7upf_get_price_html')){
    function s7upf_get_price_html($style = ''){
        global $product;
        switch ($style) {
            case 'sale-style':
                $from = $product->get_regular_price();
                $to = $product->get_price();
                $percent = $percent_html =  '';
                if($from != $to && $from > 0){
                    $percent = round(($from-$to)/$from*100);            
                    $percent_html = '<div class="sale-content"><span class="saleoff5">-'.$percent.'%</span></div>';
                }
                $html =    '<div class="price-sale">
                                '.$product->get_price_html().'
                                '.$percent_html.'
                            </div>';
                break;

            default:                
                $html =    $product->get_price_html();
                break;
        }
        return $html;
    }
}
//Product Thumb
if ( ! function_exists( 's7upf_thumb_product' ) ) {
    function s7upf_thumb_product($thumb_style='',$size='full'){
        global $post,$product;
        $html = $zoom_class = '';
		$zoom_on = s7upf_get_option('s7upf_zoom_product');
		if($zoom_on=='on'){
			$zoom_class = 'inner-zoom';
		}else{
			$zoom_class = '';
		}
        switch ($thumb_style) {
			
			case 'list-thumb':
				$html .=    '<div class="product-thumb">
								<a  data-product-id="'.get_the_id().'"  href="'.esc_url(get_the_permalink()).'" class="product-quick-view quickview-link gradient"><i class="icon ion-eye"></i></a>
								<a href="'.esc_url(get_the_permalink()).'" class="product-thumb-link '.esc_attr($zoom_class).'">
									'.get_the_post_thumbnail(get_the_ID(),$size).'
								</a>
								'.s7upf_product_link('text-left').'
							</div>';
				break;
				
			case 'style2':
				$html .=    '<div class="product-thumb">
								<a href="'.esc_url(get_the_permalink()).'" class="product-thumb-link">
									'.get_the_post_thumbnail(get_the_ID(),$size).'
								</a>
								'.s7upf_product_link('style2').'
							</div>';
				break;
					
			case 'style3':
				$img_hover = get_post_meta(get_the_ID(),'product_thumb_hover',true);
				if(!empty($img_hover)) $img_hover_html = s7upf_get_image_by_url($img_hover,$size);
				else $img_hover_html = get_the_post_thumbnail(get_the_ID(),$size);
				$html .=    '<div class="product-thumb">
								<a href="'.esc_url(get_the_permalink()).'" class="product-thumb-link translate-thumb">
									'.get_the_post_thumbnail(get_the_ID(),$size).'
									'.$img_hover_html.'
								</a>
							</div>';
				break;
				
            case 'inner-zoom':
				if($zoom_on=='on'){
					$html .=    '<div class="product-thumb">
								<a href="'.esc_url(get_the_permalink()).'" class="product-thumb-link '.$thumb_style.'">
									'.get_the_post_thumbnail(get_the_ID(),$size).'
								</a>
							</div>';
				}else{
					$html .=    '<div class="product-thumb">
								<a href="'.esc_url(get_the_permalink()).'" class="product-thumb-link">
									'.get_the_post_thumbnail(get_the_ID(),$size).'
								</a>
							</div>';
				}
				
                break;
            
            default:
                $html .=    '<div class="product-thumb">
                                <a href="'.esc_url(get_the_permalink()).'" class="product-thumb-link">
                                    '.get_the_post_thumbnail(get_the_ID(),$size).'
                                </a>
                            </div>';
                break;
        }
        return $html;
    }
}
// product item list
if(!function_exists('s7upf_product_item'))
{
    function s7upf_product_item($item_style = '',$item_num='',$thumb_style='',$size='full')
    {
		global $product;
		$product_cats = wp_get_post_terms( $product->get_id(), 'product_cat' );
		$cat_html = '';
		if(!empty($product_cats)){
			$cat_html = '<a href="'.esc_url(get_term_link($product_cats[0]->term_id)).'" class="silver">'.esc_html($product_cats[0]->name).'</a>';
		}
		$car_local = get_post_meta($product->get_id(),'local_map',true );
		$car_local_html = '';
		$local_class = 'map-none';
		if(!empty($car_local)){
			$local_class = '';
			$car_local_html =  '<div class="car-local">
									<a class="desc silver text-upercase" target="_blank" href="'.get_post_meta($product->get_id(),'local_map',true ).'"><i class="icon ion-ios-location"></i>'.get_post_meta($product->get_id(),'shop_local',true ).'</a>
								</div>';
		}
		
        $html = '';
        switch ($item_style) {
            case 'item-produc-grid':
				
				$html = '<div class="item-product-grid '.$local_class.' grid-'.esc_attr($item_num).'-item ">
							<div class="item-product style1 border bg-white">
								<div class="product-info-top text-center">
									'.$cat_html.'
									<h3 class="title18 font-bold text-uppercase product-title"><a href="'.esc_url(get_the_permalink()).'" title="'.esc_attr(get_the_title()).'" class="black">'.get_the_title().'</a></h3>
									<a  data-product-id="'.get_the_id().'"  href="'.esc_url(get_the_permalink()).'" class="product-quick-view quickview-link gradient"><i class="icon ion-eye"></i></a>
								</div>
								'.s7upf_thumb_product($thumb_style,$size).'
								<div class="product-info-buttom">
									<span class="silver text-uppercase">'.esc_html('Total Msrp','micar').'</span>
									'.s7upf_get_price_html().'
									'.s7upf_get_rating_html().'
									<div class="engine-info">
										'.get_the_excerpt().'
									</div>
									'.$car_local_html.'
									'.s7upf_product_link().'
								</div>
							</div>
                        </div>';
                break;
			case 'item-produc-list':
				$html = '<div class="item-product-list '.$local_class.' border bg-white">
							<div class="row">
								<div class="col-md-5 col-sm-5 col-xs-12">
									'.s7upf_thumb_product('list-thumb',$size).'
								</div>
								<div class="col-md-7 col-sm-7 col-xs-12">
									<div class="product-info">
										'.$cat_html.'
										<h3 class="title18 font-bold text-uppercase product-title"><a href="'.esc_url(get_the_permalink()).'" title="'.esc_attr(get_the_title()).'" class="black">'.get_the_title().'</a></h3>
										<span class="silver text-uppercase">'.esc_html('Total Msrp','micar').'</span>
										'.s7upf_get_price_html().'
										<div class="product-desc desc">'.esc_html(get_post_meta($product->get_id(),'extra_desc',true )).'</div>
										<div class="engine-info">
											'.get_the_excerpt().'
										</div>
										'.$car_local_html.'
									</div>
								</div>
							</div>
                        </div>';
                break;
				
			case 'style1':	
				$html = '<div class="item-product style1 '.$local_class.' border bg-white">
							<div class="product-info-top text-center">
									'.$cat_html.'
									<h3 class="title18 font-bold text-uppercase product-title"><a href="'.esc_url(get_the_permalink()).'" title="'.esc_attr(get_the_title()).'" class="black">'.get_the_title().'</a></h3>
									<a  data-product-id="'.get_the_id().'"  href="'.esc_url(get_the_permalink()).'" class="product-quick-view quickview-link gradient"><i class="icon ion-eye"></i></a>
								</div>
								'.s7upf_thumb_product('inner-zoom',$size).'
								<div class="product-info-buttom">
									<span class="silver text-uppercase">'.esc_html('Total Msrp','micar').'</span>
									'.s7upf_get_price_html().'
									'.s7upf_get_rating_html().'
									<div class="engine-info">
										'.get_the_excerpt().'
									</div>
									'.$car_local_html.'
									'.s7upf_product_link().'
								</div>
                        </div>';
				break;
				
			case 'style2':	
				if(class_exists('YITH_WCWL_Init')) $html_wl = '<a href="'.esc_url(str_replace('&', '&amp;',add_query_arg( 'add_to_wishlist', get_the_ID() ))).'" class="add_to_wishlist wishlist-link" rel="nofollow" data-product-id="'.get_the_ID().'" data-product-title="'.esc_attr(get_the_title()).'"><i class="icon ion-android-favorite-outline"></i></a>';
				$html = '<div class="item-product style2">
							'.s7upf_thumb_product('style2',$size).'
							<div class="product-info">
								<h3 class="title18 font-bold text-uppercase product-title"><a href="'.esc_url(get_the_permalink()).'" title="'.esc_attr(get_the_title()).'" class="black">'.get_the_title().'</a></h3>
								'.s7upf_get_price_html().'
								'.s7upf_get_rating_html().'
								'.$html_wl.'
								'.s7upf_compare_url().'
							</div>
						</div>';
				break;
				
			case 'style3':	
				$html = '<div class="item-product style3 bg-white">
							'.s7upf_thumb_product('style3',$size).'
							<div class="product-info">
								<h3 class="title18 font-bold text-uppercase product-title"><a href="'.esc_url(get_the_permalink()).'" title="'.esc_attr(get_the_title()).'" class="black">'.get_the_title().'</a></h3>
								'.s7upf_get_price_html().'
								'.s7upf_get_rating_html().'
								'.s7upf_product_link('style3').'
							</div>
						</div>';
				break;
				
            default:
                $html = '<div class="item-product '.$local_class.' style1 border bg-white">
							<div class="product-info-top text-center">
									'.$cat_html.'
									<h3 class="title18 font-bold text-uppercase product-title"><a href="'.esc_url(get_the_permalink()).'" title="'.esc_attr(get_the_title()).'" class="black">'.get_the_title().'</a></h3>
									<a  data-product-id="'.get_the_id().'"  href="'.esc_url(get_the_permalink()).'" class="product-quick-view quickview-link gradient"><i class="icon ion-eye"></i></a>
								</div>
								'.s7upf_thumb_product($thumb_style,$size).'
								<div class="product-info-buttom">
									<span class="silver text-uppercase">'.esc_html('Total Msrp','micar').'</span>
									'.s7upf_get_price_html().'
									'.s7upf_get_rating_html().'
									<div class="engine-info">
										'.get_the_excerpt().'
									</div>
									'.$car_local_html.'
									'.s7upf_product_link().'
								</div>
                        </div>';
                break;
        }
        return $html;
    }
}
//product main detail
if(!function_exists('s7upf_product_main_detail')){
    function s7upf_product_main_detail($style=''){
		if(empty($style)) $style = s7upf_get_value_by_id('product_layout');
        global $post, $product, $woocommerce;
		$sales_price_to = (int)get_post_meta($post->ID, '_sale_price_dates_to', true);
		$current_time = getdate();
		$time = $sales_price_to - $current_time[0];
		$time_html = '';
		if($time>0){
			$time_html = '<div class="countdown-master flip-clock-wrapper" data-time="'.esc_attr($time).'"></div>';
		}
        s7upf_set_post_view();
        $size = 'full';
        $thumb_id = array(get_post_thumbnail_id());
        $attachment_ids = $product->get_gallery_image_ids();
        $attachment_ids = array_merge($thumb_id,$attachment_ids);
        $ul_block = ''; $i = 1;
		switch($style){
			case 'style2':
			case 'style3':
				$col_class = 'col-md-12 col-sm-12';
				foreach ( $attachment_ids as $attachment_id ) {
                    $image_link = wp_get_attachment_url( $attachment_id );
                    if ( ! $image_link )
                        continue;
                    $image_title    = esc_attr( get_the_title( $attachment_id ) );
                    $image_caption  = esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );
                    $image       = wp_get_attachment_image( $attachment_id, $size, 0, $attr = array(
                        'title' => $image_title,
                        'alt'   => $image_title
                        ) );
                    if($i == 1) $el_class = 'col-xs-12';
                    else $el_class = 'hidden-xs';
                    $i++;
                    $ul_block .=    '<div class="'.esc_attr($col_class).' '.esc_attr($el_class).'">
                                        <a class="fancybox-buttons" href="'.wp_get_attachment_image_url($attachment_id,'full').'" data-fancybox-group="gallery">'.$image.'</a>
                                    </div>';                    
                }
				$thumb_html =   '<div class="popup-gallery">
									<div class="list-popup-gallery">
										<div class="row">
											'.$ul_block.'
										</div>
									</div>
								</div>';
				break;
			default:
				foreach ( $attachment_ids as $attachment_id ) {
					$image_link = wp_get_attachment_url( $attachment_id );
					if ( ! $image_link )
						continue;
					$image_title    = esc_attr( get_the_title( $attachment_id ) );
					$image_caption  = esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );
					$image       = wp_get_attachment_image( $attachment_id, $size, 0, $attr = array(
						'title' => $image_title,
						'alt'   => $image_title
						) );
					if($i == 1) $active = 'active';
					else $active = '';
					$page_index = $i-1;
					$ul_block .= '<li><a href="#" class="'.esc_attr($active).'">'.$image.'</a></li>';
					$i++;
				}
				
				$thumb_html =   '<div class="detail-gallery images">
									<div class="mid woocommerce-product-gallery__image">
										'.get_the_post_thumbnail(get_the_ID(),'full').'
									</div>';
									if(!empty($attachment_ids)){
				$thumb_html .=			'<div class="gallery-control">
											<a href="#" class="prev"><i class="fa fa-angle-left"></i></a>
											<div class="carousel" data-visible="3">
												<ul class="list-none">
													'.$ul_block.'
												</ul>
											</div>
											<a href="#" class="next"><i class="fa fa-angle-right"></i></a>
										</div>';
									}
				$thumb_html .=	'</div>';
				break;
		}
        
        $sku = get_post_meta(get_the_ID(),'_sku',true);
        $stock = $product->get_availability();
        $s_class = '';
		$review_html = '';
		$review_count = $product->get_review_count();
		if($review_count>0){
			$review_html = '<ul class="list-inline-block review-rating">
								<li>
									'.s7upf_get_rating_html().'
								</li>
								<li>
									<span class="number-rate silver">('.esc_html($review_count).'s)</span>
								</li>
								<li>
									<a href="javascript:void(0)" class="add-review silver">'.esc_html__('Add your review','micar').'</a>
								</li>
							</ul>';
			
		}else{
			$review_html = '<p class="sub-title-detail">'.esc_html__('Be the first to review this product','micar').'</p>';
		}
        if(is_array($stock)){
            if(!empty($stock['class'])) $s_class = $stock['class'];
            if(!empty($stock['availability'])) $stock = $stock['availability'];
            else {
                if($stock['class'] == 'in-stock') $stock = esc_html__("In stock","micar");
                else $stock = esc_html__("Out of stock","micar");
            }
        }
		switch($style){
			case 'style2':
				echo        '<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									'.$thumb_html.'
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="detail-float">
										<div class="detail-info">
											<h2 class="title-detail text-uppercase">'.get_the_title().'</h2>
											'.$review_html.'
											'.$time_html.'
											<div class="product-desc desc">'.get_post_meta($product->get_id(),'extra_desc',true ).'</div>
											<div class="available">
												<span>'.esc_html__("Availability:","micar").' </span>
												<span class="in-stock">'.esc_html($stock).'</span>
											</div>
											'.s7upf_get_price_html().'
											<a class="mail-to-friend" href="mailto:?subject='.esc_attr__("I wanted you to see this site&amp;body=Check out this site","micar").' '.get_the_permalink().'">'.esc_html__("Email to a Friend:","micar").'</a>
											<div class="engine-info">'.get_the_excerpt().'</div>
											<div class="detail-extralink">';
												do_action('s7upf_template_single_add_to_cart');   
				echo                   		'</div>';
											do_action( 'woocommerce_single_product_summary' );
				echo                    '</div>
									</div>
								</div>
							</div>';
				break;
				
			case 'style3':
				echo        '<div class="row">
								<div class="col-md-3 col-sm-3 col-xs-12">
									<div class="detail-float info-left">
										<div class="detail-info">
											<h2 class="title-detail text-uppercase">'.get_the_title().'</h2>
											'.$review_html.'
											'.$time_html.'
											<div class="product-desc desc">'.get_post_meta($product->get_id(),'extra_desc',true ).'</div>
											<div class="available">
												<span>'.esc_html__("Availability:","micar").' </span>
												<span class="in-stock">'.esc_html($stock).'</span>
											</div>
											'.s7upf_get_price_html().'
											<a class="mail-to-friend" href="mailto:?subject='.esc_attr__("I wanted you to see this site&amp;body=Check out this site","micar").' '.get_the_permalink().'">'.esc_html__("Email to a Friend:","micar").'</a>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									'.$thumb_html.'
								</div>
								<div class="col-md-3 col-sm-3 col-xs-12">
									<div class="detail-float info-right">
										<div class="detail-info">
											<div class="engine-info">'.get_the_excerpt().'</div>
											<div class="detail-extralink">';
												do_action('s7upf_template_single_add_to_cart');   
				echo                 	    '</div>';
											do_action( 'woocommerce_single_product_summary' );
				echo               		'</div>
									</div>
								</div>
							</div>';
				break;
				
			case 'style4':
			case 'style5':
				echo        '<div class="detail-info-left">
								'.$review_html.'
								'.$time_html.'
								<div class="product-desc desc">'.get_post_meta($product->get_id(),'extra_desc',true ).'</div>
								<div class="detail-extralink">';
									do_action('s7upf_template_single_add_to_cart');   
				echo            '</div>';
								do_action( 'woocommerce_single_product_summary' );
				echo		'</div>';
				break;
				
			default:
				echo        '<div class="row">
								<div class="col-md-5 col-sm-12 col-xs-12">
									'.$thumb_html.'
								</div>
								<div class="col-md-7 col-sm-12 col-xs-12">
									<div class="detail-info">
										<h2 class="title-detail text-uppercase">'.get_the_title().'</h2>
										'.$review_html.'
										'.$time_html.'
										<div class="product-desc desc">'.get_post_meta($product->get_id(),'extra_desc',true ).'</div>
										<div class="available">
											<span>'.esc_html__("Availability:","micar").' </span>
											<span class="in-stock">'.esc_html($stock).'</span>
										</div>
										'.s7upf_get_price_html().'
										<a class="mail-to-friend" href="mailto:?subject='.esc_attr__("I wanted you to see this site&amp;body=Check out this site","micar").' '.get_the_permalink().'">'.esc_html__("Email to a Friend:","micar").'</a>
										<div class="engine-info">'.get_the_excerpt().'</div>
										<div class="detail-extralink">';
											do_action('s7upf_template_single_add_to_cart');   
				echo                    '</div>';
										do_action( 'woocommerce_single_product_summary' );
				echo                '</div>
								</div>
							</div>';
				
				break;	
		}
        
    }
}
//Product Rate
if(!function_exists('s7upf_get_rating_html')){
    function s7upf_get_rating_html(){
        global $product;
        $html = '';
        $star = $product->get_average_rating();
        $width = $star / 5 * 100;
        $html .=    '<div class="product-rate">
                        <div class="product-rating" style="width:'.$width.'%;"></div>';
        $html .=    '</div>';
        return $html;
    }
}
//Product Social
if(!function_exists('s7upf_get_product_detail_link')){
    function s7upf_get_product_detail_link($style = ''){
        global $post;
        $html =     '<div class="detail-social">
						<a href="'.esc_url('http://www.facebook.com/sharer.php?u='.get_the_permalink()).'" class="float-shadow inline-block round title18"><i class="icon ion-social-facebook"></i></a>
						<a href="'.esc_url('http://www.twitter.com/share?url='.get_the_permalink()).'" class="float-shadow inline-block round title18"><i class="icon ion-social-twitter"></i></a>
						<a href="'.esc_url('http://pinterest.com/pin/create/button/?url='.get_the_permalink().'&amp;media='.wp_get_attachment_url(get_post_thumbnail_id())).'" class="float-shadow inline-block round title18"><i class="icon ion-social-pinterest"></i></a>
						<a href="'.esc_url('https://plus.google.com/share?url='.get_the_permalink()).'" class="float-shadow inline-block round title18"><i class="icon ion-social-googleplus"></i></a>
                    </div>';
        return $html;
    }
}
//Detail Product Tab
if(!function_exists('s7upf_product_tab_detail')){
    function s7upf_product_tab_detail($style=''){
        $tabs = apply_filters( 'woocommerce_product_tabs', array() );
		if($style=='gallery'){
			?>
				<div class="detail-info-right">
					<div class="title-tab-detail">
						<ul class="list-inline-block">
							<?php 
								$num=0;
								foreach ( $tabs as $key => $tab ) : 
								$num++;
							?>
									<li class="<?php if($num==1){echo 'active';}?>" role="presentation">
										<a href="<?php echo esc_url( '#sv-'.$key ); ?>" aria-controls="sv-<?php echo esc_attr( $key ); ?>" role="tab" data-toggle="tab"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
									</li>
								
							<?php 
								endforeach; 
							?>          
							<?php 
								$custom_tab = get_post_meta(get_the_ID(),'product_tab_data',true);
								if(!empty($custom_tab) && is_array($custom_tab)){
									foreach ($custom_tab as $c_tab) {
										$tab_slug = str_replace(' ', '-', $c_tab['title']);
										$tab_slug = strtolower($tab_slug);
										echo '<li><a href="'.esc_url('#sv-'.$tab_slug).'" data-toggle="tab">'.$c_tab['title'].'</a></li>';
									}
								}
							?>
						</ul>
					</div>
					<div class="tab-content">
						<?php 
							$num=0;
							foreach ( $tabs as $key => $tab ) : 
							$num++;
						?>
							<div class="tab-pane <?php if($num==1){echo 'active';}?>" id="sv-<?php echo esc_attr( $key ); ?>">
								<div class="detail-tab-content">
									<?php call_user_func( $tab['callback'], $key, $tab ); ?>
								</div>
							</div>
						<?php endforeach; ?> 
						<?php 
							if(!empty($custom_tab) && is_array($custom_tab)){
								foreach ($custom_tab as $c_tab) {
									$tab_slug = str_replace(' ', '-', $c_tab['title']);
									$tab_slug = strtolower($tab_slug);
									echo    '<div class="tab-pane" id="sv-'.$tab_slug.'">
												<div class="detail-tab-content">
													'.apply_filters('the_content',$c_tab['tab_content']).'
												</div>
											</div>';
								}
							}
						?>
					</div>	
				</div>
			<?php
		}else{
			?>
			<div class="tab-detail toggle-tab">
				<?php 
					$num=0;
					foreach ( $tabs as $key => $tab ) : 
					$num++;
				?>
				<div class="item-toggle-tab <?php if($num==1){echo 'active';}?>">
					<h2 class="toggle-tab-title title14 text-uppercase border"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></h2>
					<div class="toggle-tab-content">
						<div class="detail-tab-content">
							<?php call_user_func( $tab['callback'], $key, $tab ); ?>
						</div>
					</div>
				</div>
				<?php 
					endforeach; 
				?> 
				<?php 
					$custom_tab = get_post_meta(get_the_ID(),'product_tab_data',true);
					if(!empty($custom_tab) && is_array($custom_tab)){
						foreach ($custom_tab as $c_tab) {
							$tab_slug = str_replace(' ', '-', $c_tab['title']);
							$tab_slug = strtolower($tab_slug);
							echo 	'<div class="item-toggle-tab">
										<h2 class="toggle-tab-title title14 text-uppercase border">'.$c_tab['title'].'</h2>
										<div class="toggle-tab-content">
											<div class="detail-tab-content">
												'.apply_filters('the_content',$c_tab['tab_content']).'
											</div>
										</div>
									</div>';
						}
					}
				?>
			</div>
			<?php
		}	
    }
}
//Related Product
if(!function_exists('s7upf_single_relate_product'))
{
    function s7upf_single_relate_product()
    {
        global $product;
        $check_show = s7upf_get_value_by_id('show_single_relate');
        $number = s7upf_get_value_by_id('show_single_number');
        if(!$number) $number = 6;
		$size = s7upf_get_option('product_size_thumb');
		if(empty($size)) $size = array(500,280);
		else $size = explode('x', $size);
        $related = wc_get_related_products($product->get_id(),$number);
        if($check_show == 'on' || $check_show == 'yes'){
		?>  
            <div class="product-related">
                <h2 class="title24 font-bold text-uppercase"><?php esc_html_e("Related Product","micar")?></h2>
				<?php
					$itemscustom = '';
					$check_sidebar = s7upf_check_sidebar();
					if($check_sidebar == false){
						$itemscustom = '[[0,1],[768,2],[990,3]]';
					}else{
						$itemscustom = '[[0,1],[768,2]]';
					}
				?>
                <div class="product-slider product-related-slider">
                    <?php echo '<div class="wrap-item small-navi group-navi" data-itemscustom="'.esc_attr($itemscustom).'" data-pagination="false" data-navigation="true">';?>
                        <?php
                            $args = array(
                                'post_type'           => 'product',
                                'ignore_sticky_posts'  => 1,
                                'no_found_rows'        => 1,
                                'posts_per_page'       => $number,                                    
                                'orderby'              => 'ID',
                                'post__in'             => $related,
                                'post__not_in'         => array( $product->get_id() )
                            );
                            $products = new WP_Query( $args );
                            if ( $products->have_posts() ) :
                                while ( $products->have_posts() ) : 
                                    $products->the_post();  	
                                    global $product;
                                    echo    s7upf_product_item('','','',$size);
                        ?>
                        
                        <?php   endwhile;
                            endif;
                            wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
        <?php
        }
    }
}
if(!function_exists('s7upf_single_upsell_product'))
{
    function s7upf_single_upsell_product()
    {
        $check_show = s7upf_get_value_by_id('show_single_upsell');
        $number = s7upf_get_value_by_id('show_single_number');
        if(!$number) $number = 6;
		$size = s7upf_get_option('product_size_thumb');
		if(empty($size)) $size = array(500,280);
		else $size = explode('x', $size);
		global $product;
		$upsells = $product->get_upsell_ids();
        if(($check_show == 'on' || $check_show == 'yes') && $upsells){
            
            ?>  
			<div class="product-related">
                <h2 class="title24 font-bold text-uppercase"><?php esc_html_e("Upsell Products","micar")?></h2>
				<?php
					$itemscustom = '';
					$check_sidebar = s7upf_check_sidebar();
					if($check_sidebar == false){
						$itemscustom = '[[0,1],[768,2],[990,3]]';
					}else{
						$itemscustom = '[[0,1],[768,2]]';
					}
				?>
                <div class="product-slider product-related-slider">
                    <?php echo '<div class="wrap-item small-navi group-navi" data-itemscustom="'.esc_attr($itemscustom).'" data-pagination="false" data-navigation="true">';?>
						<?php
							$meta_query = WC()->query->get_meta_query();
							$args = array(
								'post_type'           => 'product',
								'ignore_sticky_posts' => 1,
								'no_found_rows'       => 1,
								'posts_per_page'      => $number,
								'post__in'            => $upsells,
								'post__not_in'        => array( $product->get_id() ),
								'meta_query'          => $meta_query
							);
							$products = new WP_Query( $args );
							if ( $products->have_posts() ) :
								while ( $products->have_posts() ) : 
									$products->the_post();  	
									global $product;
									echo    s7upf_product_item('','','',$size);
						?>
						
						<?php   endwhile;
							endif;
							wp_reset_postdata();
						?>
					</div>
				</div>
			</div>
        <?php
        }
    }
}
if(!function_exists('s7upf_single_latest_product'))
{
    function s7upf_single_latest_product()
    {
        $check_show = s7upf_get_value_by_id('show_single_lastest');
        $number = s7upf_get_value_by_id('show_single_number');
        if(!$number) $number = 6;
		$size = s7upf_get_option('product_size_thumb');
		if(empty($size)) $size = array(500,280);
		else $size = explode('x', $size);
        if($check_show == 'on' || $check_show == 'yes'){
            global $product;
            ?>  
			<div class="product-related">
                <h2 class="title24 font-bold text-uppercase"><?php esc_html_e("Latest products","micar")?></h2>
				<?php
					$itemscustom = '';
					$check_sidebar = s7upf_check_sidebar();
					if($check_sidebar == false){
						$itemscustom = '[[0,1],[768,2],[990,3]]';
					}else{
						$itemscustom = '[[0,1],[768,2]]';
					}
				?>
                <div class="product-slider product-related-slider">
                    <?php echo '<div class="wrap-item small-navi group-navi" data-itemscustom="'.esc_attr($itemscustom).'" data-pagination="false" data-navigation="true">';?>
						<?php
							$args = array(
								'post_type'           => 'product',
								'ignore_sticky_posts' => 1,
								'posts_per_page'      => $number,
								'post__not_in'        => array( $product->get_id() ),
								'orderby'             => 'date'
							);
							$products = new WP_Query( $args );
							if ( $products->have_posts() ) :
								while ( $products->have_posts() ) : 
									$products->the_post();  	
									global $product;
									echo    s7upf_product_item('','','',$size);
						?>
						
						<?php   endwhile;
							endif;
							wp_reset_postdata();
						?>
					</div>
				</div>
			</div>
        <?php
        }
    }
}
//Get all page
if(!function_exists('s7upf_list_all_page'))
{
    function s7upf_list_all_page()
    {
        global $post;
        $page_list = array(
            esc_html__('-- Choose One --','micar') => '',
            );
        $args= array(
        'post_type' => 'page',
        'posts_per_page' => -1, 
        );
        $query = new WP_Query($args);
        if($query->have_posts()): while ($query->have_posts()):$query->the_post();
            $page_list[$post->post_title] = $post->ID;
            endwhile;
        endif;
        wp_reset_postdata();
        return $page_list;
    }
}
if(!function_exists('s7upf_get_label_html')){
    function s7upf_get_label_html($wrap = false){
        global $post,$product;
        $label_html = '';
        $date_pro = strtotime($post->post_date);
        $date_now = strtotime('now');
        $set_timer = s7upf_get_option( 'sv_set_time_woo', 30);
        $uppsell = ($date_now - $date_pro - $set_timer*24*60*60);
        if($wrap) $label_html .=  '<div class="product-label">';
        if($uppsell < 0) $label_html .=  '<span class="new-label">'.esc_html__("new","micar").'</span>';
        if($product->is_on_sale()) $label_html .=  '<span class="sale-label">'.esc_html__("sale","micar").'</span>';
        if($wrap) $label_html .=  '</div>';
        return $label_html;
    }
}
if(!function_exists('s7upf_get_deals_time')){
    function s7upf_get_deals_time($time = '0:0'){
        $curren_time = getdate();
        $time2 = explode(':', $time);
        $hours = $min = 0;
        if(isset($time2[0])) $hours = (int)$time2[0];
        if(isset($time2[1])) $min = (int)$time2[1];
        $data_h = $hours - $curren_time['hours'];
        $data_m = $min - $curren_time['minutes'];
        $time = $data_h*3600+$data_m*60+60-$curren_time['seconds'];
        return $time;
    }
}
if(!function_exists('s7upf_scroll_top')){
    function s7upf_scroll_top(){
        $scroll_top = s7upf_get_value_by_id('show_scroll_top');
        if($scroll_top == 'on'):?>
        <a href="#" class="scroll-top dark"><i class="icon ion-android-arrow-up"></i></a>
        <?php endif;
    }
}
if(!function_exists('s7upf_before_detail_gallery')){
	function s7upf_before_detail_gallery(){
		$check = get_post_meta(get_the_ID(),'product_layout',true);
		if(is_product() && $check == 'style4'){
			$gal_slider = get_post_meta(get_the_ID(),'detail_slider',true);
			$detail_intro = get_post_meta(get_the_ID(),'detail_intro_tab',true);
			$detail_intro_title = get_post_meta(get_the_ID(),'title_intro_tab',true);
			?>
				<?php if (!empty($gal_slider)): ?>
				<div class="banner-slider banner-slick banner-gallery">
					<div class="slick center">
						<?php 
							$gal = explode(',', $gal_slider);
							if(is_array($gal) && !empty($gal)){
								foreach ($gal as $key => $item) {
									$thumbnail_url = wp_get_attachment_url($item);
									echo 	'<div class="item-slider">
												<div class="banner-thumb">
													<img src="' . esc_url($thumbnail_url) . '" alt="image-slider">
												</div>
											</div>';
								}
							}
						?>
					</div>
					<div class="banner-info text-center">
						<ul class="list-inline-block detail-title-price">
							<li>
								<h2 class="text-uppercase title30 white font-bold"><?php the_title();?></h2>
							</li>
							<li>
								<?php echo s7upf_get_price_html();?>
							</li>
						</ul>
					</div>
				</div>
				<?php endif;?>
				<?php if (!empty($detail_intro)): ?>
					<div class="container">
						<div class="detail-car-color text-center text-uppercase">
							<?php if (!empty($detail_intro_title)){echo '<h2 class="title24">'.esc_html($detail_intro_title).'</h2>';} ?>
							<div class="detail-tab-color">
								<ul class="list-tab-color list-inline-block">
									<?php
										foreach($detail_intro as $key=>$value){
											$active="";
											if($key==0){$active="active";}
											echo '<li class="'.$active.'"><a href="#color_'.$key.'" data-toggle="tab" title="'.$value['title'].'"><span style="background:'.$value['color_intro'].'"></span></a></li>';
										}
									?>
								</ul>
								<div class="tab-content">
									<?php
										foreach($detail_intro as $key=>$data):
										$active="";
										if($key==0){$active="active";}
										$gal_intro = explode(',', $data['image_intro']);
									?>
									<div id="color_<?php echo esc_attr($key);?>" class="tab-pane <?php echo esc_attr($active);?>">
										<div class="bx-slider">
											<ul class="bxslider list-none">
												<?php
													foreach($gal_intro as $key=>$value){
														echo '<li><img src="'.wp_get_attachment_url($value).'" alt="" /></li>';
													}
												?>
											</ul>
											<div class="bx-pager">
												<?php
													foreach($gal_intro as $key=>$value){
														echo '<a data-slide-index="'.esc_attr($key).'" href="#">'.get_the_title($value).'</a>';
													}
												?>
											</div>
										</div>
									</div>
									<?php endforeach;?>
								</div>
							</div>
						</div>
					</div>
				<?php endif;?>
			<?php
		}
    }
}
// get list post
if(!function_exists('s7upf_list_post'))
{
    function s7upf_list_post( $post_type = 'post' ) {
		$posts = get_posts( array(
			'posts_per_page' 	=> -1,
			'post_type'			=> $post_type,
		));
		$result = array();
		foreach ( $posts as $post )	{
			$result[] = array(
				'value' => $post->ID,
				'label' => $post->post_title,
			);
		}
		return $result;
	}
}

/***************************************END Theme Function***************************************/

/*************************************************************************************************
										Ajax Function
**************************************************************************************************/

/********************************** Begin product load more ************************************/

add_action( 'wp_ajax_load_more_product', 's7upf_load_more_product' );
add_action( 'wp_ajax_nopriv_load_more_product', 's7upf_load_more_product' );
if(!function_exists('s7upf_load_more_product')){
	function s7upf_load_more_product() {
	?>	
		<?php
			//Tax
			$tax = $_POST['tax'];
			//Attr
			$attr = $_POST['attr'];
			
			$number = $_POST['number'];
			$paged = $_POST['paged'];
			$check_filter = $_POST['check_filter'];
	
			$order = $_POST['order'];
			$orderby = $_POST['orderby'];
			$product_type = $_POST['product_type'];
			
			$args=array(
				'post_type'         => 'product',
				'posts_per_page'    => $number,
				'orderby'           => $orderby,
				'order'             => $order,
			);
			if($check_filter == 'false'){
				$args['paged'] = $paged + 1;
			}
			if($product_type == 'trendding'){
				$args['meta_query'][] = array(
						'key'     => 'trending_product',
						'value'   => 'on',
						'compare' => '=',
					);
			}
			if($product_type == 'toprate'){
				$args['meta_key'] = '_wc_average_rating';
				$args['orderby'] = 'meta_value_num';
				$args['meta_query'] = WC()->query->get_meta_query();
				$args['tax_query'][] = WC()->query->get_tax_query();
			}
			if($product_type == 'mostview'){
				$args['meta_key'] = 'post_views';
				$args['orderby'] = 'meta_value_num';
			}
			if($product_type == 'bestsell'){
				$args['meta_key'] = 'total_sales';
				$args['orderby'] = 'meta_value_num';
			}
			if($product_type=='onsale'){
				$args['meta_query']['relation']= 'OR';
				$args['meta_query'][]=array(
					'key'   => '_sale_price',
					'value' => 0,
					'compare' => '>',                
					'type'          => 'numeric'
				);
				$args['meta_query'][]=array(
					'key'   => '_min_variation_sale_price',
					'value' => 0,
					'compare' => '>',                
					'type'          => 'numeric'
				);
			}
			if($product_type == 'featured'){
				$args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'featured',
					'operator' => 'IN',
				);
			}
			$attr_taxquery = array();
			
			//Taxonomy
			$woo_tax = $tax;
			if(!empty($woo_tax)){
				foreach ($woo_tax as $key => $value){
					$slug  = explode(':',$value);
					if(!empty($slug[1])){
						$attr_taxquery[]=array(
							'taxonomy'=>$slug[0],
							'field' => 'slug',
							'terms' => $slug[1]
						);
					}
				} 
			} 
			//Attribute
			$woo_attr = $attr;
			if(!empty($woo_attr)){
				foreach ($woo_attr as $key => $value){
					$slug  = explode(':',$value);
					if(!empty($slug[1])){
						$attr_taxquery[]=array(
							'taxonomy'=>$slug[0],
							'field' => 'slug',
							'terms' => $slug[1]
						);
					}
				} 
			} 
			if(!empty($attr_taxquery)) $args['tax_query'] = $attr_taxquery;
			$product_query = new WP_Query($args);
			$size = s7upf_get_option('product_size_thumb');
			if(empty($size)) $size = array(500,280);
			else $size = explode('x', $size);
			$item_num = $col;
			if(empty($item_num)) $item_num = 3;
			$count_product = 1;
			$max_page = $product_query->max_num_pages;
			if($product_query->have_posts()) {
				while($product_query->have_posts()) {
					$product_query->the_post();
					global $product;
					echo s7upf_product_item('item-produc-grid',$item_num,'inner-zoom',$size);
					$count_product++;
				}
				echo '<input class="current-maxpage hidden" type="hidden" value="'.$max_page.'" />';
			}
			wp_reset_postdata();
		?>
	<?php	
	die();
	}	
}
/********************************** End product load more **************************************/

/********************************** Begin filter Product ************************************/

add_action( 'wp_ajax_filter_product_tax', 's7upf_filter_product_tax' );
add_action( 'wp_ajax_nopriv_filter_product_tax', 's7upf_filter_product_tax' );
if(!function_exists('s7upf_filter_product_tax')){
	function s7upf_filter_product_tax() {
	?>	
	<?php
		$filter = $_POST['filter'];
		$limit = $_POST['limit'];
		$order = $_POST['order'];
		$orderby = $_POST['orderby'];
		$product_type = $_POST['product_type'];
	?>
		<?php
			
		$args = array(
			'post_type'         => 'product',
			'posts_per_page'    => -1,
			'showposts'         => $limit,
			'orderby'           => $orderby,
			'order'             => $order,
		);
		if($product_type == 'trendding'){
			$args['meta_query'][] = array(
					'key'     => 'trending_product',
					'value'   => 'on',
					'compare' => '=',
				);
		}
		if($product_type == 'toprate'){
			$args['meta_key'] = '_wc_average_rating';
			$args['orderby'] = 'meta_value_num';
			$args['meta_query'] = WC()->query->get_meta_query();
			$args['tax_query'][] = WC()->query->get_tax_query();
		}
		if($product_type == 'mostview'){
			$args['meta_key'] = 'post_views';
			$args['orderby'] = 'meta_value_num';
		}
		if($product_type == 'bestsell'){
			$args['meta_key'] = 'total_sales';
			$args['orderby'] = 'meta_value_num';
		}
		if($product_type=='onsale'){
			$args['meta_query']['relation']= 'OR';
			$args['meta_query'][]=array(
				'key'   => '_sale_price',
				'value' => 0,
				'compare' => '>',                
				'type'          => 'numeric'
			);
			$args['meta_query'][]=array(
				'key'   => '_min_variation_sale_price',
				'value' => 0,
				'compare' => '>',                
				'type'          => 'numeric'
			);
		}
		if($product_type == 'featured'){
			$args['tax_query'][] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
				'operator' => 'IN',
			);
		}
		$attr_taxquery = array();
		//Taxonomy
		$woo_tax = $filter;
		if(!empty($woo_tax)){
			foreach ($woo_tax as $key => $value){
				$slug  = explode(':',$value);
				if(!empty($slug[1])){
					$attr_taxquery[]=array(
						'taxonomy'=>$slug[0],
						'field' => 'slug',
						'terms' => $slug[1]
					);
				}
			} 
		} 
		if(!empty($attr_taxquery)) $args['tax_query'] = $attr_taxquery;
		$product_query = new WP_Query($args);
		$size = s7upf_get_option('product_size_thumb');
		if(empty($size)) $size = array(500,280);
		else $size = explode('x', $size);
		
		$count_product = 1;
		if($product_query->have_posts()) {
			while($product_query->have_posts()) {
				$product_query->the_post();
				global $product;
				echo s7upf_product_item('style1','','',$size);
				$count_product++;
			}
		}
		wp_reset_postdata();
		?>
	<?php	
	die();
	}
	
}
/********************************** End filter product ************************************/