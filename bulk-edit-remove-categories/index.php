<?php

/*
Plugin Name: Bulk Edit Remove Categories
Plugin URI: Rock INtuit
Description: Removes categories when bulk editing posts.
Version: 1.0.0
Author: Rock INtuit
Author URI: https://rockintuit.com
*/

/**
 * Rock INtuit testing area below
 * 
 * @toDo -- remove this testing when client is happy with result
 */

/*
function rockintuit_bulk_edit_remove_categories( $post_ID, $data ){

	if( isset( $_REQUEST['bulk_edit'] ) && 'product' == $data['post_type'] ){
		wp_set_object_terms( $post_ID, array(), 'product_cat', false );
	}
	
}
add_action( 'pre_post_update', 'rockintuit_bulk_edit_remove_categories', 1, 2 );
*/

/*function rockintuit_bulk_edit_remove_categories( $terms, $object_ids, $taxonomies, $args ){
	if( isset( $_REQUEST['bulk_edit'] ) && 'product_cat' == $taxonomies[0] ){
		$terms = array();
	}
	return $terms;
}
add_filter( 'get_object_terms', 'rockintuit_bulk_edit_remove_categories', 10, 4 );
*/


//$post_IDs = array_map( 'intval', (array) $_POST['post'] );

// /wp-admin/edit.php?s=&post_status=all&post_type=product&_wpnonce=ba6f1702be&_wp_http_referer=%2Fwp-admin%2Fedit.php%3Fpost_type%3Dproduct%26paged%3D1&action=edit&product_cat=&product_type=&stock_status=&paged=1&tax_input%5Bproduct_cat%5D%5B%5D=0&comment_status=&_status=-1&tax_input%5Bproduct_tag%5D=&change_regular_price=&_regular_price=&change_sale_price=&_sale_price=&change_weight=&_weight=&change_dimensions=&_length=&_width=&_height=&_shipping_class=&_visibility=&_featured=&_stock_status=&_manage_stock=&change_stock=&_stock=&_backorders=&_sold_individually=&woocommerce_bulk_edit=1&woocommerce_quick_edit_nonce=2399739c34&bulk_edit=Update&post_view=list&screen=edit-product&post%5B%5D=1842&action2=-1

if(!( function_exists( 'rockintuit_bulk_edit_remove_categories' ) )){
	function rockintuit_bulk_edit_remove_categories(){
		
		/**
		 * Cache the request
		 */
		$request = $_REQUEST;
		
		/**
		 * $request['bulk_edit']                   = Check we're bulk editing
		 * $request['post_type']                   = Check that the post type argument exists
		 * 'product' == $request['post_type']      = Check that we're editing a product
		 * $request['tax_input']['product_cat'][1] = Check that we're assigning a new category
		 */
		if( 
			isset( $request['bulk_edit'] ) && 
			isset( $request['post_type'] ) && 
			'product' == $request['post_type'] && 
			isset( $request['tax_input']['product_cat'][1] ) 
		){
			
			/**
			 * Ensure we have an array of items
			 */
			if( is_array( $request['post'] ) ){
			
				/**
				 * Loop through the array of item IDs
				 */
				foreach( $request['post'] as $post_id ){
					
					/**
					 * Remove the first array item, it's empty and useless
					 */
					unset( $request['tax_input']['product_cat'][0] );
					
					/**
					 * Get the new terms from the request, ensure we're dealing with unique integers
					 */
					$new_terms = array_unique( 
						array_map( 'intval', $request['tax_input']['product_cat'] ) 
					);
					
					/**
					 * Set the object terms to the new terms. This will replace (remove) the older terms set also.
					 */
					wp_set_object_terms( $post_id, array_values( $new_terms ), 'product_cat', false );
					
				}
				
			}
			
		}
		
	}
	add_action( 'admin_init', 'rockintuit_bulk_edit_remove_categories', 10 );
}