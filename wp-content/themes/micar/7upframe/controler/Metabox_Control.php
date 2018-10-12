<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */

add_action('admin_init', 's7upf_custom_meta_boxes');
if(!function_exists('s7upf_custom_meta_boxes')){
    function s7upf_custom_meta_boxes(){
        //Format content
        $format_metabox = array(
            'id' => 'block_format_content',
            'title' => esc_html__('Format Settings', 'micar'),
            'desc' => '',
            'pages' => array('post'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(                
                array(
                    'id' => 'format_image',
                    'label' => esc_html__('Upload Image', 'micar'),
                    'type' => 'upload',
                ),
                array(
                    'id' => 'format_gallery',
                    'label' => esc_html__('Add Gallery', 'micar'),
                    'type' => 'Gallery',
                ),
                array(
                    'id' => 'format_media',
                    'label' => esc_html__('Link Media', 'micar'),
                    'type' => 'text',
                )
            ),
        );
        // SideBar
    	$sidebar_metabox_default = array(
            'id'        => 's7upf_sidebar_option',
            'title'     => 'Advanced Settings',
            'desc'      => '',
            'pages'     => array( 'page','post','product'),
            'context'   => 'side',
            'priority'  => 'low',
            'fields'    => array(
                array(
                    'id'          => 's7upf_sidebar_position',
                    'label'       => esc_html__('Sidebar position ','micar'),
                    'type'        => 'select',
                    'std' => '',
                    'choices'     => array(
                        array(
                            'label'=>esc_html__('--Select--','micar'),
                            'value'=>'',
                        ),
                        array(
                            'label'=>esc_html__('No Sidebar','micar'),
                            'value'=>'no'
                        ),
                        array(
                            'label'=>esc_html__('Left sidebar','micar'),
                            'value'=>'left'
                        ),
                        array(
                            'label'=>esc_html__('Right sidebar','micar'),
                            'value'=>'right'
                        ),
                    ),

                ),
                array(
                    'id'        =>'s7upf_select_sidebar',
                    'label'     =>esc_html__('Selects sidebar','micar'),
                    'type'      =>'sidebar-select',
                    'condition' => 's7upf_sidebar_position:not(no),s7upf_sidebar_position:not()',
                ),
                array(
                    'id'          => 's7upf_show_breadrumb',
                    'label'       => esc_html__('Show Breadcrumb','micar'),
                    'type'        => 'select',
                    'choices'     => array(
                        array(
                            'label'=>esc_html__('--Select--','micar'),
                            'value'=>'',
                        ),
                        array(
                            'label'=>esc_html__('Yes','micar'),
                            'value'=>'on'
                        ),
                        array(
                            'label'=>esc_html__('No','micar'),
                            'value'=>'off'
                        ),
                    ),

                ),
                array(
                    'id'          => 's7upf_show_header_image',
                    'label'       => esc_html__('Show Header Image','micar'),
                    'type'        => 'select',
                    'choices'     => array(
                        array(
                            'label'=>esc_html__('--Select--','micar'),
                            'value'=>'',
                        ),
                        array(
                            'label'=>esc_html__('Yes','micar'),
                            'value'=>'yes'
                        ),
                        array(
                            'label'=>esc_html__('No','micar'),
                            'value'=>'no'
                        ),
                    ),

                ),
				array(
                    'id'          => 's7upf_header_page',
                    'label'       => esc_html__('Choose page header','micar'),
                    'type'        => 'select',
                    'choices'     => s7upf_list_post_type('s7upf_header')
                ),
                array(
                    'id'          => 's7upf_footer_page',
                    'label'       => esc_html__('Choose page footer','micar'),
                    'type'        => 'select',
                    'choices'     => s7upf_list_post_type('s7upf_footer')
                ),       
            )
        );   
		//Product
        $product_trendding = array(
            'id' => 'product_trendding',
            'title' => esc_html__('Product Type', 'micar'),
            'desc' => '',
            'pages' => array('product'),
            'context' => 'side',
            'priority' => 'high',
            'fields' => array(                
                array(
                    'id'    => 'trending_product',
                    'label' => esc_html__('Product Trendding', 'micar'),
                    'type'        => 'on-off',
                    'std'         => 'off'
                ),
            ),
        );
		$product_extra_desc = array(
            'id' => 'product_extra_desc',
            'title' => esc_html__('Extra Description', 'micar'),
            'desc' => '',
            'pages' => array('product'),
            'context' => 'normal',
            'priority' => 'low',
            'fields' => array(    
				array(
                    'id' => 'shop_local',
                    'label' => esc_html__('Shop Location', 'micar'),
                    'type' => 'text',
                ),               
				array(
                    'id' => 'local_map',
                    'label' => esc_html__('Link Google Map', 'micar'),
                    'type' => 'text',
                ),            
                array(
                    'id'    => 'extra_desc', 
					'label' => esc_html__('More Description', 'micar'),
                    'type'        => 'textarea',
                ),
            ),
        );	
		$product_custom_tab = array(
            'id' => 'block_product_custom_tab',
            'title' => esc_html__('Product Tabs Extra', 'micar'),
            'desc' => '',
            'pages' => array('product'),
            'context' => 'normal',
            'priority' => 'low',
            'fields' => array(                
                array(
                    'id'          => 'product_tab_data',
                    'label'       => esc_html__('Custom Tab','micar'),
                    'type'        => 'list-item',
                    'settings'    => array(
                        array(
                            'id' => 'tab_content',
                            'label' => esc_html__('Content', 'micar'),
                            'type' => 'textarea',
                        ),
                    )
                ), 
            ),
        );
		//Product Hover
		$product_metabox = array(
            'id' => 'block_product_thumb_hover',
            'title' => esc_html__('Product Second Image', 'micar'),
            'desc' => '',
            'pages' => array('product'),
            'context' => 'side',
            'priority' => 'low',
            'fields' => array(                
                array(
                    'id'    => 'product_thumb_hover',
                    'type'  => 'upload',
                ),
            ),
        );
		// Product Special
    	$block_product_special = array(
            'id'        => 's7upf_product_special',
            'title'     => 'Product Layout',
            'pages'     => array( 'product'),
            'context'   => 'normal',
            'priority'  => 'low',
            'fields'    => array(
				array(
                    'id' => 'product_layout',
                    'label' => esc_html__('Select Product layout', 'micar'),
                    'type' => 'select',
                    'choices'     => array(  
                        array(
                            'value'=> '',
                            'label'=> esc_html__("Default", 'micar'),
                        ),                                                  
                        array(
                            'value'=> 'style2',
                            'label'=> esc_html__("Fixed Left", 'micar'),
                        ),
                        array(
                            'value'=> 'style3',
                            'label'=> esc_html__("Fixed Center", 'micar'),
                        ),
                        array(
                            'value'=> 'style4',
                            'label'=> esc_html__("Special", 'micar'),
                        ),
                        array(
                            'value'=> 'style5',
                            'label'=> esc_html__("View 360", 'micar'),
                        ),
                    )
                ),
                array(
                    'id'        =>'detail_slider',
                    'label'     =>esc_html__('Upload Gallery','micar'),
                    'type'      =>'gallery',
                    'condition' => 'product_layout:is(style4)',
                ),
				array(
                    'id'        =>'title_intro_tab',
                    'label'     =>esc_html__('Title Block Introduce','micar'),
                    'type'      =>'text',
					'condition' => 'product_layout:is(style4)',
                ),
                array(
                    'id'        =>'detail_intro_tab',
                    'label'     =>esc_html__('Block Introduce','micar'),
                    'type'      =>'list-item',
                    'condition' => 'product_layout:is(style4)',
					'settings'    => array( 
                        array(
                            'id'          => 'color_intro',
                            'label'       => esc_html__('Color','micar'),
                            'type'        => 'colorpicker',
                        ),
						array(
							'id'        =>'image_intro',
							'label'     =>esc_html__('Image Introduce','micar'),
							'type'      =>'gallery',
							'desc'      => 'Set title of image gallery is title for tab control',
						),
                    ),
                ),
                array(
                    'id'        =>'detail_view_360',
                    'label'     =>esc_html__('Gallery View 360','micar'),
                    'type'      =>'list-item',
                    'condition' => 'product_layout:is(style5)',
					'settings'    => array( 
                        array(
                            'id'          => 'color_view',
                            'label'       => esc_html__('Color','micar'),
                            'type'        => 'colorpicker',
                        ),
						array(
							'id'        =>'image_view',
							'label'     =>esc_html__('Gallery Image','micar'),
							'type'      =>'gallery',
						),
                    ),
                ),
            )
        );   
		//Show page title
        $show_page_title = array(
            'id' => 'page_title_setting',
            'title' => esc_html__('Page setting', 'micar'),
            'pages' => array('page'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id' => 'show_title_page',
                    'label' => esc_html__('Show title', 'micar'),
                    'type' => 'on-off',
                    'std'   => 'off',
                ),
                array(
                    'id'          => 'main_color',
                    'label'       => esc_html__('Main color','micar'),
                    'type'        => 'colorpicker',
                ),
                array(
                    'id'          => 'main_color2',
                    'label'       => esc_html__('Main color 2','micar'),
                    'type'        => 'colorpicker',
                ),
				array(
                    'id'          => 'body_bg',
                    'label'       => esc_html__('Body Background','micar'),
                    'type'        => 'colorpicker',
                ),
            )
        );
		
        if (function_exists('ot_register_meta_box')){
            ot_register_meta_box($format_metabox);
            ot_register_meta_box($sidebar_metabox_default);
            ot_register_meta_box($product_trendding);
            ot_register_meta_box($product_extra_desc);
            ot_register_meta_box($product_custom_tab);
            ot_register_meta_box($block_product_special);
            ot_register_meta_box($product_metabox);
            ot_register_meta_box($show_page_title);
        }
    }
}
?>