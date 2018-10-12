<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!defined('ABSPATH')) return;

if(!class_exists('S7upf_BaseController'))
{
    class S7upf_BaseController
    {
        static function _init()
        {
            //Default Framwork Hooked
            add_filter( 'wp_title', array(__CLASS__,'_wp_title'), 10, 2 );
            add_action( 'wp', array(__CLASS__,'_setup_author') );
            add_action( 'after_setup_theme', array(__CLASS__,'_after_setup_theme') );
            add_action('widgets_init',array(__CLASS__,'_add_sidebars'));
            add_action('wp_enqueue_scripts',array(__CLASS__,'_add_scripts'));
            add_action('wp_footer', 's7upf_get_custom_javascript');
			
            //Custom hooked
            add_filter('s7upf_get_sidebar',array(__CLASS__,'_blog_filter_sidebar'));
            add_action('admin_enqueue_scripts',array(__CLASS__,'_add_admin_scripts'));
            add_filter( 'style_loader_src',array(__CLASS__,'_remove_enqueue_ver'), 10, 2 );
            add_filter( 'script_loader_src',array(__CLASS__,'_remove_enqueue_ver'), 10, 2 );
			if(class_exists("woocommerce") && !is_admin()){
                add_action( 'pre_get_posts', array(__CLASS__,'_product_widget_filter'),100);
            }
			add_filter('body_class', array(__CLASS__,'s7upf_body_classes'));
        }
	
        static function _add_scripts()
        {
            $css_url = get_template_directory_uri() . '/assets/css/';
            $js_url = get_template_directory_uri() . '/assets/js/';
            $api_key = s7upf_get_option('map_api_key');
            /*
             * Javascript
             * */
            if ( is_singular() && comments_open()){
            wp_enqueue_script( 'comment-reply' );
            }
            //Register JS
            wp_register_script( 'bootstrap',$js_url.'lib/bootstrap.min.js',array('jquery'),null,true);
            wp_register_script( 'google-map', "//maps.google.com/maps/api/js?key=".$api_key, array('jquery'), null, true );
            wp_register_script( 's7upf-script-map',$js_url.'map.js',array('jquery'),null,true);
            wp_register_script( 's7upf-script',$js_url.'script.js',array('jquery'),null,true);
            //ENQUEUE JS
            if(class_exists("woocommerce")){
                global $woocommerce;
                wp_enqueue_script( 'wc-add-to-cart-variation', $woocommerce->plugin_url() . '/assets/js/frontend/add-to-cart-variation.min.js', array('jquery'), '1.6', true );
            }
            wp_enqueue_script( 'bootstrap',$js_url.'lib/bootstrap.min.js',array('jquery'),null,true);
            if(!empty($api_key)) wp_enqueue_script( 'google-map', "//maps.google.com/maps/api/js?key=".$api_key, array('jquery'), null, true );
            wp_enqueue_script( 'jquery-fancybox',$js_url.'lib/jquery.fancybox.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'jquery-fancybox-media',$js_url.'lib/jquery.fancybox-media.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'jquery-fancybox-buttons',$js_url.'lib/jquery.fancybox-buttons.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'jquery-ui-widget');
            wp_enqueue_script( 'jquery-flipclock',$js_url.'lib/flipclock.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'owl-carousel',$js_url.'lib/owl.carousel.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'jquery-jcarousellite',$js_url.'lib/jquery.jcarousellite.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'jquery-elevatezoom',$js_url.'lib/jquery.elevatezoom.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'jquery-event-move',$js_url.'lib/jquery.event.move.min.js',array('jquery'),null,true); 
            wp_enqueue_script( 'jquery-twentytwenty',$js_url.'lib/jquery.twentytwenty.min.js',array('jquery'),null,true); 
            wp_enqueue_script( 'slick',$js_url.'lib/slick.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'jquery-bxslider',$js_url.'lib/jquery.bxslider.min.js',array('jquery'),null,true);
            wp_enqueue_script( 'timecircles',$js_url.'lib/timecircles.min.js',array('jquery'),null,true);
            if(!empty($api_key)) wp_enqueue_script( 's7upf-script-map',$js_url.'map.js',array('jquery'),null,true);
            wp_enqueue_script( 's7upf-theme',$js_url.'theme.js',array('jquery'),null,true);
            wp_enqueue_script( 's7upf-script',$js_url.'script.js',array('jquery'),null,true);
            wp_enqueue_script( 's7upf-ajax', $js_url.'ajax.js', array( 'jquery' ),null,true);
            wp_localize_script( 's7upf-ajax', 'ajax_process', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
            
			//tool panel color
            

            // CSS
			// CSS
            wp_enqueue_style('s7upf-google-fonts',s7upf_get_google_link() );
            wp_enqueue_style('bootstrap',$css_url.'lib/bootstrap.min.css');
            wp_enqueue_style('font-awesome-css',$css_url.'lib/font-awesome.min.css');
            wp_enqueue_style('font-ionicons-css',$css_url.'lib/ionicons.min.css');
            wp_enqueue_style('bootstrap-theme',$css_url.'lib/bootstrap-theme.min.css');
            wp_enqueue_style('fancybox',$css_url.'lib/jquery.fancybox.min.css');
            wp_enqueue_style('fancybox-buttons',$css_url.'lib/jquery.fancybox-buttons.min.css');
            wp_enqueue_style('flipclock',$css_url.'lib/flipclock.min.css');
            // wp_enqueue_style( 'jquery-ui-core');
            wp_enqueue_style('jquery-ui',$css_url.'lib/jquery-ui.min.css');
            wp_enqueue_style('owl-carousel',$css_url.'lib/owl.carousel.min.css');
            wp_enqueue_style('owl-transitions',$css_url.'lib/owl.transitions.min.css');
            wp_enqueue_style('owl-theme',$css_url.'lib/owl.theme.min.css');
            wp_enqueue_style('animate',$css_url.'lib/animate.min.css');
            wp_enqueue_style('hover',$css_url.'lib/hover.min.css');
            wp_enqueue_style('click',$css_url.'lib/slick.min.css');
            wp_enqueue_style('twentytwenty',$css_url.'lib/twentytwenty.min.css');
            wp_enqueue_style('s7upf-color',$css_url.'lib/color.css');
            wp_enqueue_style('s7upf-theme-unitest',$css_url.'theme-unitest.css');            
            wp_enqueue_style('s7upf-theme',$css_url.'lib/theme.css');
            wp_enqueue_style('s7upf-theme-style',$css_url.'custom-style.css');
            wp_enqueue_style('s7upf-responsive',$css_url.'lib/responsive.css');  
			$custom_style = S7upf_Template::load_view('custom_css');
            if(!empty($custom_style)) {
                wp_add_inline_style('s7upf-theme-style',$custom_style);
            }
            $rtl_check = s7upf_get_option('enable_rtl');
            if($rtl_check == 'on' || is_rtl()) wp_enqueue_style('s7upf-rtl',$css_url.'lib/rtl.css');
            wp_enqueue_style('s7upf-responsive-fix',$css_url.'lib/responsive-fix.css');
            wp_enqueue_style('s7upf-browser',$css_url.'lib/browser.css');
            wp_enqueue_style('s7upf-theme-default',get_stylesheet_uri());
			
			$css=S7upf_Template::load_view('custom_css',null,array('main_color'=>'__main_color__'));
            wp_localize_script('jquery','st_demo_css',array(
                'color'     =>$css
            ));

        }


        static function _blog_filter_sidebar($sidebar)
        {
            if((!is_front_page() && is_home()) || (is_front_page() && is_home())){
                $pos=s7upf_get_option('s7upf_sidebar_position_blog');
                $sidebar_id=s7upf_get_option('s7upf_sidebar_blog');
            }
            else{
                if(is_single()){
                    $pos = s7upf_get_option('s7upf_sidebar_position_post');
                    $sidebar_id = s7upf_get_option('s7upf_sidebar_post');
                }
                else{
                    $pos = s7upf_get_option('s7upf_sidebar_position_page');
                    $sidebar_id = s7upf_get_option('s7upf_sidebar_page');
                }        
            }
            if(class_exists( 'WooCommerce' )){
                if(s7upf_is_woocommerce_page()){
                    $pos = s7upf_get_option('s7upf_sidebar_position_woo');
                    $sidebar_id = s7upf_get_option('s7upf_sidebar_woo');    
                }
                if(is_product()){
                    $pos = s7upf_get_option('sv_sidebar_position_woo_single');
                    $sidebar_id = s7upf_get_option('sv_sidebar_woo_single');
                }
            }
            if(is_archive() && !s7upf_is_woocommerce_page()){
                $pos = s7upf_get_option('s7upf_sidebar_position_page_archive');
                $sidebar_id = s7upf_get_option('s7upf_sidebar_page_archive');
            }
			
            if(is_archive() && !s7upf_is_woocommerce_page()){
                $pos = s7upf_get_option('s7upf_sidebar_position_page_archive');
                $sidebar_id = s7upf_get_option('s7upf_sidebar_page_archive');
            }
                
            else{
                if(!is_home()){
                    $id = get_the_ID();
                    if(is_404()) $id = s7upf_get_option('s7upf_404_page');
                    if(is_front_page()) $id = (int)get_option('page_on_front');
                    if(is_archive() || is_search()) $id = 0;
                    if (class_exists('woocommerce')) {
                        if(is_shop()) $id = (int)get_option('woocommerce_shop_page_id');
                        if(is_cart()) $id = (int)get_option('woocommerce_cart_page_id');
                        if(is_checkout()) $id = (int)get_option('woocommerce_checkout_page_id');
                        if(is_account_page()) $id = (int)get_option('woocommerce_myaccount_page_id');
                    }
                    $sidebar_pos = get_post_meta($id,'s7upf_sidebar_position',true);
                    $id_side_post = get_post_meta($id,'s7upf_select_sidebar',true);
                    if(!empty($sidebar_pos)){
                        $pos = $sidebar_pos;
                        if(!empty($id_side_post)) $sidebar_id = $id_side_post;
                    }
                }
            }
            if(is_search()) {
                $sidebar_id = 'blog-sidebar';
                $pos = 'right';
                if(s7upf_is_woocommerce_page()){
                    $pos = 'left';
                    if(is_active_sidebar('woocommerce-sidebar')) $sidebar_id = 'woocommerce-sidebar';
                }
            }
            if($sidebar_id){
                $sidebar['id']=$sidebar_id;
            }

            if($pos){
                $sidebar['position']=$pos;
            }

            return $sidebar;
        }
        
        
        // -----------------------------------------------------
        // Default Hooked, Do not edit

        /**
         * Hook setup theme
         *
         *
         * */

        static function _after_setup_theme()
        {
            /*
             * Make theme available for translation.
             * Translations can be filed in the /languages/ directory.
             * If you're building a theme based on stframework, use a find and replace
             * to change LANGUAGE to the name of your theme in all the template files
             */

            // This theme uses wp_nav_menu() in one location.
            global $s7upf_config;
            $menus= $s7upf_config['nav_menu'];
            if(is_array($menus) and !empty($menus) )
            {
                register_nav_menus($menus);
            }


            add_theme_support( "title-tag" );
            add_theme_support('automatic-feed-links');
            add_theme_support('post-thumbnails');
            add_theme_support('html5',array(
                'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
            ));
            add_theme_support('post-formats',array(
                'image', 'video', 'gallery','audio','quote'
            ));
            add_theme_support('custom-header');
            add_theme_support('custom-background');
            add_theme_support('woocommerce');
        }

        /**
         * Add default sidebar to website
         *
         *
         * */
        static function _add_sidebars()
        {
            // From config file
            global $s7upf_config;
            $sidebars = $s7upf_config['sidebars'];
            if(is_array($sidebars) and !empty($sidebars) )
            {
                foreach($sidebars as $value){
                    register_sidebar($value);
                }
            }
            $add_sidebars = s7upf_get_option('s7upf_add_sidebar');
            if(is_array($add_sidebars) and !empty($add_sidebars) )
            {
                foreach($add_sidebars as $sidebar){
                    if(!empty($sidebar['title'])){
                        $id = strtolower(str_replace(' ', '-', $sidebar['title']));
                        $custom_add_sidebar = array(
                                'name' => $sidebar['title'],
                                'id' => $id,
                                'description' => esc_html__( 'SideBar created by add sidebar in theme options.', 'micar'),
                                'before_title' => '<'.$sidebar['widget_title_heading'].' class="widget-title">',
                                'after_title' => '</'.$sidebar['widget_title_heading'].'>',
                                'before_widget' => '<div id="%1$s" class="sidebar-widget widget %2$s">',
                                'after_widget'  => '</div>',
                            );
                        register_sidebar($custom_add_sidebar);
                        unset($custom_add_sidebar);
                    }
                }
            }

        }


        /**
         * Set up author data
         *
         * */
        static function _setup_author() {
            global $wp_query;

            if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
                $GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
            }
        }


        /**
         * Hook to wp_title
         *
         * */
        static function _wp_title($title,$sep)
        {
            return $title;
        }


        static function _add_admin_scripts()
        {
            $admin_url = get_template_directory_uri().'/assets/admin/';
            wp_enqueue_media();
            wp_enqueue_script( 's7upf-admin-js', $admin_url . '/js/admin.js', array( 'jquery' ),null,true );
            wp_enqueue_script('s7upf-iconpicker',$admin_url.'/js/fontawesome-iconpicker.js',array('jquery'),null,true);
            add_editor_style();
            wp_enqueue_style( 'font-awesome',$admin_url.'css/font-awesome.css');
            wp_enqueue_style( 's7upf-custom-admin',$admin_url.'css/custom.css');
            wp_enqueue_style( 's7upf-iconpicker',$admin_url.'css/fontawesome-iconpicker.min.css');
            wp_enqueue_style( 's7upf-ionicons',$admin_url.'css/ionicons.min.css');
            wp_enqueue_style( 's7upf-custom-option',$admin_url.'css/custom-option.css');
        }

        static function _remove_enqueue_ver($src)    {
            if (strpos($src, '?ver='))
                $src = remove_query_arg('ver', $src);
            return $src;
        }
		
		
        static function _product_widget_filter($query) {
            global $wp_query,$wpdb,$post;  
            if(is_object($query)){
                if( $query->is_main_query() and
                    ( ( $query->get( 'post_type' ) == 'product' or $query->get( 'product_cat' ) )
                    or
                    $query->is_page() && 'page' == get_option( 'show_on_front' ) && $query->get('page_id') == wc_get_page_id('shop')
                    or is_product_taxonomy() )
                ) {
                    $attr_taxquery = array();
                    if( isset( $_REQUEST['number'])) $query->set( 'posts_per_page',$_REQUEST['number']);
                    $attribute_taxonomies = wc_get_attribute_taxonomies();
                    if(!empty($attribute_taxonomies)){
                        foreach($attribute_taxonomies as $attr){
                            if(isset($_REQUEST['pa_'.$attr->attribute_name])){
                                $term = $_REQUEST['pa_'.$attr->attribute_name];
                                $term = explode(',', $term);
                                $attr_taxquery[] =  array(
                                                        'taxonomy'      => 'pa_'.$attr->attribute_name,
                                                        'terms'         => $term,
                                                        'field'         => 'slug',
                                                        'operator'      => 'IN'
                                                    );
                            }
                        }
                    }
                    if ( !is_admin() && !empty($attr_taxquery)){
                        $attr_taxquery['relation'] =  'AND';
                        if(empty($current_meta)){
                            $query->set( 'meta_query', array(
                                array(
                                        'key'           => '_visibility',
                                        'value'         => array('catalog', 'visible'),
                                        'compare'       => 'IN'
                                    )
                                ));
                        }
                        $query->set( 'tax_query', $attr_taxquery);
                        return;
                    }
                }
            }
        }
		
		static function s7upf_body_classes($classes) {
            $page_style = s7upf_get_value_by_id('s7upf_page_style');
            $menu_fixed = s7upf_get_value_by_id('s7upf_menu_fixed');
            $shop_ajax = s7upf_get_value_by_id('shop_ajax');
            if(!empty($page_style)) $classes[] = $page_style;
            if($shop_ajax == 'on') $classes[] = 'shop-ajax-enable';
            if($menu_fixed == 'on') $classes[] = 'menu-fixed-enable';
            $rtl_check = s7upf_get_option('enable_rtl');
            $show_preload = s7upf_get_option('show_preload');
            if($rtl_check == 'on' || is_rtl()) $classes[] = 'rtl-enable';
            if($show_preload == 'on') $classes[] = 'preload';
			$gradient_button = s7upf_get_option('s7upf_gradient_button');
			if($gradient_button == 'off') $classes[] = 'gradient-button-none';
			$breadcrumb = s7upf_get_value_by_id('s7upf_show_breadrumb');
			if($breadcrumb != 'on') $classes[] = 'hidden-breadcrumb';
            $theme_info = wp_get_theme();
            $classes[] = 'theme-ver-'.$theme_info['Version'];
            global $post;
            if(isset($post->post_content)){
                if(strpos($post->post_content, '[sv_shop')) {
                    $classes[] = 'woocommerce';
                }
            }
            return $classes;
        }

    }

    S7upf_BaseController::_init();
}
