<?php
/**
 * Created by Sublime Text 2.
 * User: thanhhiep992
 * Date: 12/08/15
 * Time: 10:20 AM
 */
if(!class_exists('S7upf_TaxonomyController'))
{
    class S7upf_TaxonomyController{
		
		static function _init()
        {
            if(function_exists('stp_reg_post_type'))
            {
                add_action('init',array(__CLASS__,'_add_taxonomy'));
            }
        }
		
        static  function  _add_taxonomy (){
			$tax = s7upf_get_option('woo_taxonomy_product');
			if(!empty($tax)){
				foreach ($tax as $key => $value){
					$title = $value['title'];
					$slug  = $value['taxonomy_slug'];
					stp_reg_taxonomy(
						'tax_'.$slug,
						'product',
						array(
							'label' => esc_html( $title, 'micar' ),
							'rewrite' => array( 'slug' => $slug, 'micar' ),
							'hierarchical' => true,
							'query_var'  => true
						)
					);
				}
			}
        }
    }

    S7upf_TaxonomyController::_init();

}


