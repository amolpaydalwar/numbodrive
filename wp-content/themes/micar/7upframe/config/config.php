<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!function_exists('s7upf_set_theme_config')){
    function s7upf_set_theme_config(){
        global $s7upf_dir,$s7upf_config;
        /**************************************** BEGIN ****************************************/
        $s7upf_dir = get_template_directory_uri() . '/7upframe';
        $s7upf_config = array();
        $s7upf_config['dir'] = $s7upf_dir;
        $s7upf_config['css_url'] = $s7upf_dir . '/assets/css/';
        $s7upf_config['js_url'] = $s7upf_dir . '/assets/js/';
        $s7upf_config['nav_menu'] = array(
            'primary' => esc_html__( 'Primary Navigation', 'micar' ),
        );
        $s7upf_config['mega_menu'] = '1';
        $s7upf_config['sidebars']=array(
            array(
                'name'              => esc_html__( 'Blog Sidebar', 'micar' ),
                'id'                => 'blog-sidebar',
                'description'       => esc_html__( 'Widgets in this area will be shown on all blog page.', 'micar'),
                'before_title'      => '<h3 class="widget-title">',
                'after_title'       => '</h3>',
                'before_widget'     => '<div id="%1$s" class="sidebar-widget widget %2$s">',
                'after_widget'      => '</div>',
            )
        );
        $s7upf_config['import_config'] = array(
                'homepage_default'          => 'Home',
                'blogpage_default'          => 'Blog',
                'menu_locations'            => array("Main Menu" => "primary"),
                'set_woocommerce_page'      => 1
            );
        $s7upf_config['import_theme_option'] = 'YTo0MTp7czoxNzoiczd1cGZfaGVhZGVyX3BhZ2UiO3M6MjoiMTkiO3M6MTc6InM3dXBmX2Zvb3Rlcl9wYWdlIjtzOjI6IjExIjtzOjIwOiJzN3VwZl9zaG93X2JyZWFkcnVtYiI7czoyOiJvbiI7czoxNjoic2hvd19oZWFkZXJfcGFnZSI7czoyOiJvbiI7czoxNzoiaGVhZGVyX3BhZ2VfaW1hZ2UiO2E6MTp7aTowO2E6Mzp7czo1OiJ0aXRsZSI7czoxNjoiUkVBRFksIENJVFksIEdPISI7czoxMjoiaGVhZGVyX2ltYWdlIjtzOjc5OiJodHRwOi8vN3VwdGhlbWUuY29tL3dvcmRwcmVzcy9jYXJyZXRhaWxlci93cC1jb250ZW50L3VwbG9hZHMvMjAxNy8wNy9iYW5uZXIuanBnIjtzOjExOiJoZWFkZXJfbGluayI7czoxOiIjIjt9fXM6MTA6Im1haW5fY29sb3IiO3M6NzoiIzE4ODhjOCI7czoxMToibWFpbl9jb2xvcjIiO3M6MDoiIjtzOjE0OiJzN3VwZl80MDRfcGFnZSI7czowOiIiO3M6MjE6InM3dXBmX2dyYWRpZW50X2J1dHRvbiI7czoyOiJvbiI7czoxNToic2hvd19zY3JvbGxfdG9wIjtzOjI6Im9uIjtzOjExOiJtYXBfYXBpX2tleSI7czozOToiQUl6YVN5QlgySWlFQmctMGxRS1FRNndrNnNXUkdRbldJN2lvZ2YwIjtzOjEwOiJlbmFibGVfcnRsIjtzOjM6Im9mZiI7czoxMDoiY3VzdG9tX2NzcyI7czowOiIiO3M6MjM6InM3dXBmX2N1c3RvbV9qYXZhc2NyaXB0IjtzOjA6IiI7czo0OiJsb2dvIjtzOjc3OiJodHRwOi8vN3VwdGhlbWUuY29tL3dvcmRwcmVzcy9jYXJyZXRhaWxlci93cC1jb250ZW50L3VwbG9hZHMvMjAxNy8wNy9sb2dvLnBuZyI7czo3OiJmYXZpY29uIjtzOjc2OiJodHRwOi8vN3VwdGhlbWUuY29tL3dvcmRwcmVzcy9jYXJyZXRhaWxlci93cC1jb250ZW50L3VwbG9hZHMvMjAxNy8wNy9jYXIucG5nIjtzOjE2OiJzN3VwZl9tZW51X2NvbG9yIjtzOjA6IiI7czoyMjoiczd1cGZfbWVudV9jb2xvcl9ob3ZlciI7czowOiIiO3M6MjM6InM3dXBmX21lbnVfY29sb3JfYWN0aXZlIjtzOjA6IiI7czoyNzoiczd1cGZfc2lkZWJhcl9wb3NpdGlvbl9ibG9nIjtzOjI6Im5vIjtzOjE4OiJzN3VwZl9zaWRlYmFyX2Jsb2ciO3M6MTI6ImJsb2ctc2lkZWJhciI7czoyNzoiczd1cGZfc2lkZWJhcl9wb3NpdGlvbl9wYWdlIjtzOjI6Im5vIjtzOjE4OiJzN3VwZl9zaWRlYmFyX3BhZ2UiO3M6MDoiIjtzOjM1OiJzN3VwZl9zaWRlYmFyX3Bvc2l0aW9uX3BhZ2VfYXJjaGl2ZSI7czoyOiJubyI7czoyNjoiczd1cGZfc2lkZWJhcl9wYWdlX2FyY2hpdmUiO3M6MTI6ImJsb2ctc2lkZWJhciI7czoyNzoiczd1cGZfc2lkZWJhcl9wb3NpdGlvbl9wb3N0IjtzOjU6InJpZ2h0IjtzOjE4OiJzN3VwZl9zaWRlYmFyX3Bvc3QiO3M6MTI6ImJsb2ctc2lkZWJhciI7czoxNzoiczd1cGZfYWRkX3NpZGViYXIiO2E6Mjp7aTowO2E6Mjp7czo1OiJ0aXRsZSI7czoxMjoiU2hvcCBTaWRlYmFyIjtzOjIwOiJ3aWRnZXRfdGl0bGVfaGVhZGluZyI7czoyOiJoMyI7fWk6MTthOjI6e3M6NToidGl0bGUiO3M6MTU6IlByb2R1Y3QgU2lkZWJhciI7czoyMDoid2lkZ2V0X3RpdGxlX2hlYWRpbmciO3M6MjoiaDMiO319czoxMjoiZ29vZ2xlX2ZvbnRzIjthOjI6e2k6MDthOjI6e3M6NjoiZmFtaWx5IjtzOjc6InBvcHBpbnMiO3M6ODoidmFyaWFudHMiO2E6Mzp7aTowO3M6MzoiMzAwIjtpOjE7czo3OiJyZWd1bGFyIjtpOjI7czozOiI3MDAiO319aToxO2E6Mjp7czo2OiJmYW1pbHkiO3M6NToiYW50b24iO3M6ODoidmFyaWFudHMiO2E6MTp7aTowO3M6NzoicmVndWxhciI7fX19czoyNjoiczd1cGZfc2lkZWJhcl9wb3NpdGlvbl93b28iO3M6NDoibGVmdCI7czoxNzoiczd1cGZfc2lkZWJhcl93b28iO3M6MTI6InNob3Atc2lkZWJhciI7czoxNToid29vX3Nob3BfY29sdW1uIjtzOjE6IjIiO3M6MTU6InN2X3NldF90aW1lX3dvbyI7czowOiIiO3M6MTU6Indvb19zaG9wX251bWJlciI7czoxOiI2IjtzOjE4OiJwcm9kdWN0X3NpemVfdGh1bWIiO3M6NzoiNTAweDI4MCI7czoyMDoid29vX3RheG9ub215X3Byb2R1Y3QiO2E6NDp7aTowO2E6NDp7czo1OiJ0aXRsZSI7czo0OiJNYWtlIjtzOjEzOiJ0YXhvbm9teV9zbHVnIjtzOjQ6Im1ha2UiO3M6MTM6InRheG9ub215X2Rlc2MiO3M6MjU6IldoYXQgbWF0dGVycyBtb3N0IHRvIHlvdT8iO3M6MTU6InNob3dfdGF4X2ZpbHRlciI7czoyOiJvbiI7fWk6MTthOjQ6e3M6NToidGl0bGUiO3M6NDoiVHlwZSI7czoxMzoidGF4b25vbXlfc2x1ZyI7czo0OiJ0eXBlIjtzOjEzOiJ0YXhvbm9teV9kZXNjIjtzOjI5OiJXaGF0IGRvIHlvdSB1c2UgeW91ciBjYXIgZm9yPyI7czoxNToic2hvd190YXhfZmlsdGVyIjtzOjI6Im9uIjt9aToyO2E6NDp7czo1OiJ0aXRsZSI7czo0OiJTZWF0IjtzOjEzOiJ0YXhvbm9teV9zbHVnIjtzOjQ6InNlYXQiO3M6MTM6InRheG9ub215X2Rlc2MiO3M6Mjc6IkhvdyBtYW55IHNlYXRzIGRvIHlvdSBuZWVkPyI7czoxNToic2hvd190YXhfZmlsdGVyIjtzOjI6Im9uIjt9aTozO2E6NDp7czo1OiJ0aXRsZSI7czo0OiJZZWFyIjtzOjEzOiJ0YXhvbm9teV9zbHVnIjtzOjQ6InllYXIiO3M6MTM6InRheG9ub215X2Rlc2MiO3M6MjQ6IldoaWNoIHllYXIgeW91ciB2ZWhpY2xlPyI7czoxNToic2hvd190YXhfZmlsdGVyIjtzOjI6Im9uIjt9fXM6MzA6InN2X3NpZGViYXJfcG9zaXRpb25fd29vX3NpbmdsZSI7czo1OiJyaWdodCI7czoyMToic3Zfc2lkZWJhcl93b29fc2luZ2xlIjtzOjE1OiJwcm9kdWN0LXNpZGViYXIiO3M6MTk6InNob3dfc2luZ2xlX2xhc3Rlc3QiO3M6Mzoib2ZmIjtzOjE4OiJzaG93X3NpbmdsZV91cHNlbGwiO3M6Mjoib24iO3M6MTg6InNob3dfc2luZ2xlX3JlbGF0ZSI7czoyOiJvbiI7fQ==';
        $s7upf_config['import_widget'] = '{"blog-sidebar":{"woocommerce_product_categories-9":{"title":"Categories","orderby":"name","dropdown":0,"count":0,"hierarchical":0,"show_children_only":1,"hide_empty":1},"s7upf_listpostswidget-6":{"title":"LATEST POSTS","posts_per_page":"3","category":"0","order":"desc","order_by":"None"},"s7upf_recentcommentwidget-5":{"title":"RECENT COMMENTS","number":5},"tag_cloud-5":{"title":"TAG CLOUD","count":0,"taxonomy":"post_tag"}},"shop-sidebar":{"woocommerce_product_categories-3":{"title":"Categories","orderby":"name","dropdown":0,"count":0,"hierarchical":1,"show_children_only":1,"hide_empty":0},"woocommerce_price_filter-2":{"title":"Price"},"woocommerce_layered_nav-6":{"title":"Color","attribute":"color","display_type":"list","query_type":"or"},"text-2":{"title":"SERVICES","text":"<ul class=\"list-none list-wg-service\">\t\t\t\t\t\t\t\t\t<li><a href=\"#\">Quality Control<\/a><\/li>\t\t\t\t\t\t\t\t\t<li><a href=\"#\">Personalize Your New Home<\/a><\/li>\t\t\t\t\t\t\t\t\t<li><a href=\"#\">Vehicles Packages<\/a><\/li>\t\t\t\t\t\t\t\t\t<li><a href=\"#\">Customer Support<\/a><\/li>\t\t\t\t\t\t\t\t\t<li><a href=\"#\">Our Reviews<\/a><\/li>\t\t\t\t\t\t\t<\/ul>","filter":true,"visual":true}},"product-sidebar":{"s7upf_advantage_widget-2":{"title":"","advs":{"1":{"link":"#","image":"http:\/\/7uptheme.com\/wordpress\/carretailer\/wp-content\/uploads\/2017\/07\/ad1.jpg"},"2":{"link":"#","image":"http:\/\/7uptheme.com\/wordpress\/carretailer\/wp-content\/uploads\/2017\/07\/ad2.jpg"},"3":{"link":"#","image":"http:\/\/7uptheme.com\/wordpress\/carretailer\/wp-content\/uploads\/2017\/07\/ad3.jpg"}}},"s7upf_list_products-5":{"title":"BEST SELLERS","number":"5","product_type":""}}}';
        $s7upf_config['import_category'] = '{"car-yaris":{"thumbnail":"118","parent":"toyota"},"mazda":{"thumbnail":"496","parent":""},"mazda-3":{"thumbnail":"89","parent":"mazda"},"mazda-6":{"thumbnail":"90","parent":"mazda"},"mazda-cx3":{"thumbnail":"91","parent":"mazda"},"mazda-cx9":{"thumbnail":"93","parent":"mazda"},"mazda-mx3":{"thumbnail":"94","parent":"mazda"},"mazda-cx5":{"thumbnail":"92","parent":"mazda"},"audi":{"thumbnail":"501","parent":""},"audi-a3":{"thumbnail":"77","parent":"audi"},"audi-q7":{"thumbnail":"78","parent":"audi"},"audi-r8-coupe":{"thumbnail":"76","parent":"audi"},"audi-rs7":{"thumbnail":"79","parent":"audi"},"audi-sedan":{"thumbnail":"80","parent":"audi"},"audi-wagon":{"thumbnail":"81","parent":"audi"},"hyundai":{"thumbnail":"500","parent":""},"honda":{"thumbnail":"499","parent":""},"ford":{"thumbnail":"498","parent":""},"ford-escape":{"thumbnail":"103","parent":"ford"},"ford-fiesta":{"thumbnail":"104","parent":"ford"},"ford-fusion":{"thumbnail":"105","parent":"ford"},"ford-mustang":{"thumbnail":"106","parent":"ford"},"ford-super":{"thumbnail":"107","parent":"ford"},"ford-taurus":{"thumbnail":"108","parent":"ford"},"toyota":{"thumbnail":"497","parent":""},"car-86":{"thumbnail":"111","parent":"toyota"},"avalon":{"thumbnail":"114","parent":"toyota"},"camry":{"thumbnail":"115","parent":"toyota"},"corolla":{"thumbnail":"116","parent":"toyota"},"car-sienna":{"thumbnail":"117","parent":"toyota"}}';

        /**************************************** PLUGINS ****************************************/

        $s7upf_config['require-plugin'] = array(    
            array(
                'name'               => esc_html__('Option Tree', 'micar'), // The plugin name.
                'slug'               => 'option-tree', // The plugin slug (typically the folder name).
                'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            ),
            array(
                'name'      => esc_html__( 'Contact Form 7', 'micar'),
                'slug'      => 'contact-form-7',
                'required'  => true,
            ),
            array(
                'name'      => esc_html__( 'Visual Composer', 'micar'),
                'slug'      => 'js_composer',
                'required'  => true,
                'source'    =>get_template_directory().'/plugins/js_composer.zip'
            ),
            array(
                'name'      => esc_html__( '7up Core', 'micar'),
                'slug'      => '7up-core',
                'required'  => true,
                'source'    =>get_template_directory().'/plugins/7up-core.zip'
            ),
            array(
                'name'      => esc_html__( 'WooCommerce', 'micar'),
                'slug'      => 'woocommerce',
                'required'  => true,
            ),
            array(
                'name'      => esc_html__('MailChimp for WordPress Lite','micar'),
                'slug'      => 'mailchimp-for-wp',
                'required'  => true,
            ),
            array(
                'name'      => esc_html__('Yith Woocommerce Compare','micar'),
                'slug'      => 'yith-woocommerce-compare',
                'required'  => true,
            ),
            array(
                'name'      => esc_html__('Yith Woocommerce Wishlist','micar'),
                'slug'      => 'yith-woocommerce-wishlist',
                'required'  => true,
            )
        );

    /**************************************** PLUGINS ****************************************/
        $s7upf_config['theme-option'] = array(
            'sections' => array(
                array(
                    'id' => 'option_general',
                    'title' => '<i class="fa fa-cog"></i>'.esc_html__(' General Settings', 'micar')
                ),
                array(
                    'id' => 'option_logo',
                    'title' => '<i class="fa fa-image"></i>'.esc_html__(' Logo Settings', 'micar')
                ),
                array(
                    'id' => 'option_menu',
                    'title' => '<i class="fa fa-align-justify"></i>'.esc_html__(' Menu Settings', 'micar')
                ),
                array(
                    'id' => 'option_layout',
                    'title' => '<i class="fa fa-columns"></i>'.esc_html__(' Layout Settings', 'micar')
                ),
                array(
                    'id' => 'option_typography',
                    'title' => '<i class="fa fa-font"></i>'.esc_html__(' Typography', 'micar')
                )
            ),
            'settings' => array(
                 /*----------------Begin General --------------------*/
                array(
                    'id' => 'tab_general_theme',
                    'type' => 'tab',
                    'section' => 'option_general',
                    'label' => esc_html__('General theme','micar')
                ),
                array(
                    'id'          => 's7upf_header_page',
                    'label'       => esc_html__( 'Header Page', 'micar' ),
                    'desc'        => esc_html__( 'Include Header content. Go to Header in admin menu to edit/create header content. Note this value default for all pages of your site, If have any page/single page display other content pehaps you are set specific header for it', 'micar' ),
                    'type'        => 'select',
                    'section'     => 'option_general',
                    'choices'     => s7upf_list_post_type('s7upf_header')
                ),
                array(
                    'id'          => 's7upf_footer_page',
                    'label'       => esc_html__( 'Footer Page', 'micar' ),
                    'desc'        => esc_html__( 'Include Footer content. Go to Footer in admin menu to edit/create footer content.  Note this value default for all pages of your site, If have any page/single page display other content pehaps you are set specific footer for it', 'micar' ),
                    'type'        => 'select',
                    'section'     => 'option_general',
                    'choices'     => s7upf_list_post_type('s7upf_footer')
                ),
				array(
                    'id' => 's7upf_show_breadrumb',
                    'label' => esc_html__('Show BreadCrumb', 'micar'),
                    'desc' => esc_html__('This allow you to show or hide BreadCrumb', 'micar'),
                    'type' => 'on-off',
                    'section' => 'option_general',
                    'std' => 'on'
                ),
				array(
                    'id'          => 'show_header_page',
                    'label'       => esc_html__('Header page image','micar'),
                    'type'        => 'on-off',
                    'section'     => 'option_general',
                    'std'         => 'off'
                ),
                array(
                    'id'          => 'header_page_image',
                    'label'       => esc_html__('Header page Image','micar'),
                    'type'        => 'list-item',
                    'section'     => 'option_general',
                    'condition'   => 'show_header_page:is(on)',
                    'settings'    => array( 
                        array(
                            'id'          => 'header_image',
                            'label'       => esc_html__('Header image','micar'),
                            'type'        => 'upload',
                        ),
                        array(
                            'id'          => 'header_link',
                            'label'       => esc_html__('Link','micar'),
                            'type'        => 'text',
                        ),
                    ),
                ),
                array(
                    'id'          => 'main_color',
                    'label'       => esc_html__('Main color','micar'),
                    'type'        => 'colorpicker',
                    'section'     => 'option_general',
                ), 
				array(
                    'id'          => 'main_color2',
                    'label'       => esc_html__('Main color 2','micar'),
                    'type'        => 'colorpicker',
                    'section'     => 'option_general',
                ), 
                array(
                    'id'          => 's7upf_404_page',
                    'label'       => esc_html__( '404 Page', 'micar' ),
                    'desc'        => esc_html__( 'Include page to 404 page', 'micar' ),
                    'type'        => 'page-select',
                    'section'     => 'option_general'
                ),  
				array(
                    'id' => 's7upf_show_breadrumb',
                    'label' => esc_html__('Show BreadCrumb', 'micar'),
                    'desc' => esc_html__('This allow you to show or hide BreadCrumb', 'micar'),
                    'type' => 'on-off',
                    'section' => 'option_general',
                    'std' => 'on'
                ),  
				array(
                    'id' => 's7upf_gradient_button',
                    'label' => esc_html__('Button Gradient', 'micar'),
                    'type' => 'on-off',
                    'section' => 'option_general',
                    'std' => 'on'
                ), 
                array(
                    'id' => 'show_scroll_top',
                    'label' => esc_html__('Show Scroll Top', 'micar'),
                    'desc' => esc_html__('This allow you to show or hide Scroll top button', 'micar'),
                    'type' => 'on-off',
                    'section' => 'option_general',
                    'std' => 'on'
                ),        
                array(
                    'id'          => 'map_api_key',
                    'label'       => esc_html__('Map API key','micar'),
                    'type'        => 'text',
                    'section'     => 'option_general',
                    'std'         => 'AIzaSyBX2IiEBg-0lQKQQ6wk6sWRGQnWI7iogf0',
                ),
                array(
                    'id' => 'enable_rtl',
                    'label' => esc_html__('Enqueue RTL style', 'micar'),
                    'type' => 'on-off',
                    'section' => 'option_general',
                    'std' => 'off'
                ),
                
                /*----------------End General ----------------------*/

                /*----------------Begin Logo --------------------*/
                array(
                    'id' => 'logo',
                    'label' => esc_html__('Logo', 'micar'),
                    'desc' => esc_html__('This allow you to change logo', 'micar'),
                    'type' => 'upload',
                    'section' => 'option_logo',
                ),  
                /*----------------End Logo ----------------------*/

                /*----------------Begin Menu --------------------*/
                
                array(
                    'id'          => 's7upf_menu_color',
                    'label'       => esc_html__('Menu style','micar'),
                    'type'        => 'typography',
                    'section'     => 'option_menu',
                ),
                array(
                    'id'          => 's7upf_menu_color_hover',
                    'label'       => esc_html__('Hover color','micar'),
                    'desc'        => esc_html__('Choose color','micar'),
                    'type'        => 'colorpicker',
                    'section'     => 'option_menu',
                ),
                array(
                    'id'          => 's7upf_menu_color_active',
                    'label'       => esc_html__('Active color','micar'),
                    'desc'        => esc_html__('Choose color','micar'),
                    'type'        => 'colorpicker',
                    'section'     => 'option_menu',
                ),
                /*----------------End Menu ----------------------*/
                

                /*----------------Begin Layout --------------------*/
                array(
                    'id'          => 's7upf_sidebar_position_blog',
                    'label'       => esc_html__('Sidebar Blog','micar'),
                    'type'        => 'select',
                    'section'     => 'option_layout',
                    'desc'=>esc_html__('Left, or Right, or Center','micar'),
                    'choices'     => array(
                        array(
                            'value'=>'no',
                            'label'=>esc_html__('No Sidebar','micar'),
                        ),
                        array(
                            'value'=>'left',
                            'label'=>esc_html__('Left','micar'),
                        ),
                        array(
                            'value'=>'right',
                            'label'=>esc_html__('Right','micar'),
                        )
                    )
                ),
                array(
                    'id'          => 's7upf_sidebar_blog',
                    'label'       => esc_html__('Sidebar select display in blog','micar'),
                    'type'        => 'sidebar-select',
                    'section'     => 'option_layout',
                    'condition'   => 's7upf_sidebar_position_blog:not(no)',
                ),
                /****end blog****/
                array(
                    'id'          => 's7upf_sidebar_position_page',
                    'label'       => esc_html__('Sidebar Page','micar'),
                    'type'        => 'select',
                    'section'     => 'option_layout',
                    'desc'=>esc_html__('Left, or Right, or Center','micar'),
                    'choices'     => array(
                        array(
                            'value'=>'no',
                            'label'=>esc_html__('No Sidebar','micar'),
                        ),
                        array(
                            'value'=>'left',
                            'label'=>esc_html__('Left','micar'),
                        ),
                        array(
                            'value'=>'right',
                            'label'=>esc_html__('Right','micar'),
                        )
                    )
                ),
                array(
                    'id'          => 's7upf_sidebar_page',
                    'label'       => esc_html__('Sidebar select display in page','micar'),
                    'type'        => 'sidebar-select',
                    'section'     => 'option_layout',
                    'condition'   => 's7upf_sidebar_position_page:not(no)',
                ),
                /****end page****/
                array(
                    'id'          => 's7upf_sidebar_position_page_archive',
                    'label'       => esc_html__('Sidebar Position on Page Archives:','micar'),
                    'type'        => 'select',
                    'section'     => 'option_layout',
                    'desc'=>esc_html__('Left, or Right, or Center','micar'),
                    'choices'     => array(
                        array(
                            'value'=>'no',
                            'label'=>esc_html__('No Sidebar','micar'),
                        ),
                        array(
                            'value'=>'left',
                            'label'=>esc_html__('Left','micar'),
                        ),
                        array(
                            'value'=>'right',
                            'label'=>esc_html__('Right','micar'),
                        )
                    )
                ),
                array(
                    'id'          => 's7upf_sidebar_page_archive',
                    'label'       => esc_html__('Sidebar select display in page Archives','micar'),
                    'type'        => 'sidebar-select',
                    'section'     => 'option_layout',
                    'condition'   => 's7upf_sidebar_position_page_archive:not(no)',
                ),
                // END
                array(
                    'id'          => 's7upf_sidebar_position_post',
                    'label'       => esc_html__('Sidebar Single Post','micar'),
                    'type'        => 'select',
                    'section'     => 'option_layout',
                    'desc'=>esc_html__('Left, or Right, or Center','micar'),
                    'choices'     => array(
                        array(
                            'value'=>'no',
                            'label'=>esc_html__('No Sidebar','micar'),
                        ),
                        array(
                            'value'=>'left',
                            'label'=>esc_html__('Left','micar'),
                        ),
                        array(
                            'value'=>'right',
                            'label'=>esc_html__('Right','micar'),
                        )
                    )
                ),
                array(
                    'id'          => 's7upf_sidebar_post',
                    'label'       => esc_html__('Sidebar select display in single post','micar'),
                    'type'        => 'sidebar-select',
                    'section'     => 'option_layout',
                    'condition'   => 's7upf_sidebar_position_post:not(no)',
                ),
                array(
                    'id'          => 's7upf_add_sidebar',
                    'label'       => esc_html__('Add SideBar','micar'),
                    'type'        => 'list-item',
                    'section'     => 'option_layout',
                    'std'         => '',
                    'settings'    => array( 
                        array(
                            'id'          => 'widget_title_heading',
                            'label'       => esc_html__('Choose heading title widget','micar'),
                            'type'        => 'select',
                            'std'        => 'h3',
                            'choices'     => array(
                                array(
                                    'value'=>'h1',
                                    'label'=>esc_html__('H1','micar'),
                                ),
                                array(
                                    'value'=>'h2',
                                    'label'=>esc_html__('H2','micar'),
                                ),
                                array(
                                    'value'=>'h3',
                                    'label'=>esc_html__('H3','micar'),
                                ),
                                array(
                                    'value'=>'h4',
                                    'label'=>esc_html__('H4','micar'),
                                ),
                                array(
                                    'value'=>'h5',
                                    'label'=>esc_html__('H5','micar'),
                                ),
                                array(
                                    'value'=>'h6',
                                    'label'=>esc_html__('H6','micar'),
                                ),
                            )
                        ),
                    ),
                ),
                /*----------------End Layout ----------------------*/

                /*----------------Begin Blog ----------------------*/       
                

                /*----------------End BLOG----------------------*/

                /*----------------Begin Typography ----------------------*/
                array(
                    'id'          => 's7upf_custom_typography',
                    'label'       => esc_html__('Add Settings','micar'),
                    'type'        => 'list-item',
                    'section'     => 'option_typography',
                    'std'         => '',
                    'settings'    => array(
                        array(
                            'id'          => 'typo_area',
                            'label'       => esc_html__('Choose Area to style','micar'),
                            'type'        => 'select',
                            'std'        => 'main',
                            'choices'     => array(
                                array(
                                    'value'=>'header',
                                    'label'=>esc_html__('Header','micar'),
                                ),
                                array(
                                    'value'=>'main',
                                    'label'=>esc_html__('Main Content','micar'),
                                ),
                                array(
                                    'value'=>'widget',
                                    'label'=>esc_html__('Widget','micar'),
                                ),
                                array(
                                    'value'=>'footer',
                                    'label'=>esc_html__('Footer','micar'),
                                ),
                            )
                        ),
                        array(
                            'id'          => 'typo_heading',
                            'label'       => esc_html__('Choose heading Area','micar'),
                            'type'        => 'select',
                            'std'        => 'h3',
                            'choices'     => array(
                                array(
                                    'value'=>'h1',
                                    'label'=>esc_html__('H1','micar'),
                                ),
                                array(
                                    'value'=>'h2',
                                    'label'=>esc_html__('H2','micar'),
                                ),
                                array(
                                    'value'=>'h3',
                                    'label'=>esc_html__('H3','micar'),
                                ),
                                array(
                                    'value'=>'h4',
                                    'label'=>esc_html__('H4','micar'),
                                ),
                                array(
                                    'value'=>'h5',
                                    'label'=>esc_html__('H5','micar'),
                                ),
                                array(
                                    'value'=>'h6',
                                    'label'=>esc_html__('H6','micar'),
                                ),
                                array(
                                    'value'=>'a',
                                    'label'=>esc_html__('a','micar'),
                                ),
                                array(
                                    'value'=>'p',
                                    'label'=>esc_html__('p','micar'),
                                ),
                            )
                        ),
                        array(
                            'id'          => 'typography_style',
                            'label'       => esc_html__('Add Style','micar'),
                            'type'        => 'typography',
                            'section'     => 'option_typography',
                        ),
                    ),
                ),        
                array(
                    'id'          => 'google_fonts',
                    'label'       => esc_html__('Add Google Fonts','micar'),
                    'type'        => 'google-fonts',
                    'section'     => 'option_typography',
                ),
                /*----------------End Typography ----------------------*/
            )
        );
        if(class_exists( 'WooCommerce' )){
            array_push($s7upf_config['theme-option']['sections'], array(
                                                        'id' => 'option_woo',
                                                        'title' => '<i class="fa fa-shopping-cart"></i>'.esc_html__(' Shop Settings', 'micar')
                                                    ));
            array_push($s7upf_config['theme-option']['settings'],array(
                                                        'id'          => 's7upf_sidebar_position_woo',
                                                        'label'       => esc_html__('Sidebar Position WooCommerce page','micar'),
                                                        'type'        => 'select',
                                                        'section'     => 'option_woo',
                                                        'desc'=>esc_html__('Left, or Right, or Center','micar'),
                                                        'choices'     => array(
                                                            array(
                                                                'value'=>'no',
                                                                'label'=>esc_html__('No Sidebar','micar'),
                                                            ),
                                                            array(
                                                                'value'=>'left',
                                                                'label'=>esc_html__('Left','micar'),
                                                            ),
                                                            array(
                                                                'value'=>'right',
                                                                'label'=>esc_html__('Right','micar'),
                                                            )
                                                        )
                                                    ));
            array_push($s7upf_config['theme-option']['settings'],array(
                                                        'id'          => 's7upf_sidebar_woo',
                                                        'label'       => esc_html__('Sidebar select WooCommerce page','micar'),
                                                        'type'        => 'sidebar-select',
                                                        'section'     => 'option_woo',
                                                        'condition'   => 's7upf_sidebar_position_woo:not(no)',
                                                        'desc'        => esc_html__('Choose one style of sidebar for WooCommerce page','micar'),

                                                    ));
            array_push($s7upf_config['theme-option']['settings'],array(
                                                        'id'          => 'woo_shop_column',
                                                        'label'       => esc_html__('Choose shop column','micar'),
                                                        'type'        => 'select',
                                                        'section'     => 'option_woo',
                                                        'choices'     => array(     
                                                            array(
                                                                'value'=> 1,
                                                                'label'=> 1,
                                                            ), 
                                                            array(
                                                                'value'=> 2,
                                                                'label'=> 2,
                                                            ),
                                                            array(
                                                                'value'=> 3,
                                                                'label'=> 3,
                                                            ),
                                                            array(
                                                                'value'=> 4,
                                                                'label'=> 4,
                                                            ),
                                                            array(
                                                                'value'=> 6,
                                                                'label'=> 6,
                                                            ),
                                                        )
                                                    ));
			array_push($s7upf_config['theme-option']['settings'],array(
                                                        'id'          => 'sv_set_time_woo',
                                                        'label'       => esc_html__('Product new in(days)','micar'),
                                                        'type'        => 'text',
                                                        'section'     => 'option_woo',
                                                        'desc'        => esc_html__('Enter number to set time for product is new. Unit day. Default is 30.','micar')
                                                    ));        
			
            array_push($s7upf_config['theme-option']['settings'],array(
                                                        'id'          => 'woo_shop_number',
                                                        'label'       => esc_html__('Product Number','micar'),
                                                        'type'        => 'text',
                                                        'section'     => 'option_woo',
                                                        'desc'        => esc_html__('Enter number product to display per page. Default is 12.','micar')
                                                    ));			

            array_push($s7upf_config['theme-option']['settings'],array(
														'id' => 's7upf_zoom_product',
														'label' => esc_html__('Zoom Product', 'micar'),
														'type' => 'on-off',
														'section' => 'option_woo',
														'std' => 'on'
													));	 

			/*----------------End Shop ----------------------*/
													
			array_push($s7upf_config['theme-option']['sections'], array(
                                                        'id' => 'option_product',
                                                        'title' => '<i class="fa fa-th-large"></i>'.esc_html__(' Product Settings', 'micar')
                                                    ));	
			
            array_push($s7upf_config['theme-option']['settings'],array(
                                                        'id'          => 'product_size_thumb',
                                                        'label'       => esc_html__('Product size thumbnail','micar'),
                                                        'type'        => 'text',
                                                        'section'     => 'option_product',
                                                        'std'         => '',
                                                        'desc'        => esc_html__('Enter site thumbnail to crop. [width]x[height]. Example is 300x300.','micar')
                                                    ));												
			array_push($s7upf_config['theme-option']['settings'],array(
                                                        'id'          => 'woo_taxonomy_product',
                                                        'label'       => esc_html__('Product Taxonomy','micar'),
                                                        'type'        => 'list-item',
                                                        'section'     => 'option_product',
                                                        'std'         => '',
                                                        'settings'    => array( 
                                                            array(
                                                                'id'          => 'taxonomy_slug',
                                                                'label'       => esc_html__('Taxonomy Slug Product','micar'),
                                                                'type'        => 'text',
                                                            ),
															array(
                                                                'id'          => 'taxonomy_desc',
                                                                'label'       => esc_html__('Taxonomy Filter Description','micar'),
                                                                'type'        => 'text',
                                                            ),
															array(
																'id'          => 'show_tax_filter',
																'label'       => esc_html__('Used Filter','micar'),
																'type'        => 'on-off',
																'section'     => 'option_product',
																'std'         => 'on'
															)
                                                        ),
                                                    ));		 
			array_push($s7upf_config['theme-option']['settings'],array(
                                                        'id'          => 'sv_sidebar_position_woo_single',
                                                        'label'       => esc_html__('Sidebar Position WooCommerce Single','micar'),
                                                        'type'        => 'select',
                                                        'section'     => 'option_product',
                                                        'desc'=>esc_html__('Left, or Right, or Center','micar'),
                                                        'std'         => 'no',
                                                        'choices'     => array(
                                                            array(
                                                                'value'=>'no',
                                                                'label'=>esc_html__('No Sidebar','micar'),
                                                            ),
                                                            array(
                                                                'value'=>'left',
                                                                'label'=>esc_html__('Left','micar'),
                                                            ),
                                                            array(
                                                                'value'=>'right',
                                                                'label'=>esc_html__('Right','micar'),
                                                            ),
                                                        )
                                                    ));
            array_push($s7upf_config['theme-option']['settings'],array(
                                                        'id'          => 'sv_sidebar_woo_single',
                                                        'label'       => esc_html__('Sidebar select WooCommerce Single','micar'),
                                                        'type'        => 'sidebar-select',
                                                        'section'     => 'option_product',
                                                        'condition'   => 'sv_sidebar_position_woo_single:not(no)',
                                                        'desc'        => esc_html__('Choose one style of sidebar for WooCommerce page','micar'),
                                                    ));							
			 array_push($s7upf_config['theme-option']['settings'],array(
                                                        'id'          => 'show_single_lastest',
                                                        'label'       => esc_html__('Show Single Lastest Products','micar'),
                                                        'type'        => 'on-off',
                                                        'section'     => 'option_product',
                                                        'std'         => 'off'
                                                    ));
            array_push($s7upf_config['theme-option']['settings'],array(
                                                        'id'          => 'show_single_upsell',
                                                        'label'       => esc_html__('Show Single Upsell Products','micar'),
                                                        'type'        => 'on-off',
                                                        'section'     => 'option_product',
                                                        'std'         => 'on'
                                                    ));
            array_push($s7upf_config['theme-option']['settings'],array(
                                                        'id'          => 'show_single_relate',
                                                        'label'       => esc_html__('Show Single Relate Products','micar'),
                                                        'type'        => 'on-off',
                                                        'section'     => 'option_product',
                                                        'std'         => 'off'
                                                    ));     
			/*----------------End Product ----------------------*/											
        }
    }
}
s7upf_set_theme_config();