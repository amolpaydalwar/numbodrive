<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!class_exists('S7upf_MegaItemController'))
{
    class S7upf_MegaItemController{

        static function _init()
        {
            if(function_exists('stp_reg_post_type'))
            {
                add_action('init',array(__CLASS__,'_add_post_type'));
            }
        }

        static function _add_post_type()
        {
            $labels = array(
                'name'               => esc_html__('Mega Menu','micar'),
                'singular_name'      => esc_html__('Mega Menu','micar'),
                'menu_name'          => esc_html__('Mega Menu','micar'),
                'name_admin_bar'     => esc_html__('Mega Menu','micar'),
                'add_new'            => esc_html__('Add New','micar'),
                'add_new_item'       => esc_html__( 'Add New Mega Menu','micar' ),
                'new_item'           => esc_html__( 'New Mega Menu', 'micar' ),
                'edit_item'          => esc_html__( 'Edit Mega Menu', 'micar' ),
                'view_item'          => esc_html__( 'View Mega Menu', 'micar' ),
                'all_items'          => esc_html__( 'All Mega Menu', 'micar' ),
                'search_items'       => esc_html__( 'Search Mega Menu', 'micar' ),
                'parent_item_colon'  => esc_html__( 'Parent Mega Menu:', 'micar' ),
                'not_found'          => esc_html__( 'No Mega Menu found.', 'micar' ),
                'not_found_in_trash' => esc_html__( 'No Mega Menu found in Trash.', 'micar' )
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 's7upf_mega_item' ),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,
                'menu_icon'          => get_template_directory_uri() . "/assets/admin/image/megamenu-icon.png",
                'supports'           => array( 'title', 'editor' )
            );

            stp_reg_post_type('s7upf_mega_item',$args);
        }
    }

    S7upf_MegaItemController::_init();

}