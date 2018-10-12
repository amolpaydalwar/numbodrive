<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product;
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;
?>
<?php
	$type = 'grid';
    if(isset($_GET['type'])){
        $type = $_GET['type'];
    }
    $item_num = 4;
	$col_option = $woocommerce_loop['columns'];
	if(isset($_GET['column'])){
        $col_option = $_GET['column'];
    }
	if(!empty($col_option)) $item_num = $col_option;
	$size = s7upf_get_option('product_size_thumb');
	if(empty($size)) $size = array(500,280);
	else $size = explode('x', $size);
?>
<?php if($type == 'list'){	
	echo 	s7upf_product_item('item-produc-list','','list-thumb',$size);
	}
	else{		
		echo 	s7upf_product_item('item-produc-grid',$item_num,'inner-zoom',$size);
	}
?>