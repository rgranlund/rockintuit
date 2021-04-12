<?php
/*
  Plugin Name: Low Stock Filter
  Plugin URI: http://rockintuit.com
  Description: Filter stock by inventory level
  Version: 1.0
  Author: Robert Granlund
  Author URI:http://rockintuit.com
  Textdomain: Rock Intuit
  License: GPLv2
 */
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
/*
 * Add Filter For Managed Products
 */
add_action('restrict_manage_posts', 'my_theme_admin_posts_filter_restrict_manage_posts');

function my_theme_admin_posts_filter_restrict_manage_posts() {

    $type = 'product';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }

    //only add filter to post type you want
    if ('product' == $type) {
        //change this to the list of values you want to show
        //in 'label' => 'value' format
        $values = array(
            __('Managed Stock', 'woocommerce') => 'yes',
        );
        ?>
        <select name="Stock">
            <option value="">- <?php _e('Managed Stock', 'woocommerce'); ?> -</option>
            <?php
            $current_v = isset($_GET['Stock']) ? $_GET['Stock'] : '';
            foreach ($values as $label => $value) {
                printf
                        (
                        '<option value="%s"%s>%s</option>',
                        $value,
                        $value == $current_v ? ' selected="selected"' : '',
                        $label
                );
            }
            ?>
        </select>
        <?php
    }
}

add_filter('parse_query', 'my_theme_posts_filter');

function my_theme_posts_filter($query) {
    global $pagenow;

    $type = 'product';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ('product' == $type && is_admin() && $pagenow == 'edit.php' && isset($_GET['Stock']) && $_GET['Stock'] != '') {

        $query->query_vars['meta_query'][] = array(
            'relation' => 'AND',
            array(
                'relation' => 'AND',
                array(
                    'key' => '_manage_stock',
                    'value' => 'yes',
                ),
                array(
                    'key' => '_stock',
                    'value' => 1,
                    'type' => 'numeric',
                    'compare' => '>=',
                ),
                 array(
                    'key' => '_stock_status',
                    'value' => 'instock',
                ),
                array(
                    'key' => '_low_stock_amount',
                    'value' => 150,
                    'type' => 'numeric',
                    'compare' => '<=',
                ), 
                 
            )
        );
    }
    return $query;
}

/*
 * END Stock Filter
 */



// ADDING A CUSTOM COLUMN TITLE TO ADMIN PRODUCTS LIST
add_filter('manage_edit-product_columns', 'custom_product_column', 11);

function custom_product_column($columns) {
    //add columns
    return array_slice( $columns, 0, 5, true ) + array( 'lowstock' => 'Low Stock Thershold' ) + array_slice( $columns, 5, count( $columns ) - 5, true );

}

// ADDING THE DATA FOR EACH PRODUCTS BY COLUMN (EXAMPLE)
add_action('manage_product_posts_custom_column', 'custom_product_list_column_content', 10, 2);

function custom_product_list_column_content($column, $product_id) {
    global $post;

    // HERE get the data from your custom field (set the correct meta key below)
    $stock = get_post_meta($product_id, '_stock', true);
    $manage = get_post_meta($product_id, '_manage_stock', true);
    $low_set = get_post_meta($product_id, '_low_stock_amount', true);
    $low = '';
    if ($manage == 'yes' && ($low_set > $stock)) {
        $low = '<span style="color:red;">' . $low_set . '</span>';
    } else {
       // $low = '<span style="color:green;">Stock Level Good</span>';
        $low = $low_set;
    }

    switch ($column) {
        case 'lowstock' :
            echo $low;
            break;
    }
}

add_filter('manage_edit-product_sortable_columns', 'gardener_admin_products_visibility_column_sortable');

function gardener_admin_products_visibility_column_sortable($columns) {
    $columns['lowstock'] = 'lowstock';
    return $columns;
}

/*
 * ADD Filter to sort
 */

function my_sort_custom_column_query($query) {
    global $post;

    $orderby = $query->get('orderby');

    if ('lowstock' == $orderby) {


        $query->set('meta_key', '_low_stock_amount');
        $query->set('orderby','meta_value_num');
    }
    return $query;
}

add_action('pre_get_posts', 'my_sort_custom_column_query');
