<?php
/*
  Plugin Name: Duraamen Product Shortcode
  Plugin URI: http://duraamen.com
  Description: Plugin to place a shortcode that contains product info
  Version: 1.0
  Author: Robert Granlund
  Author URI:http://rockintuit.com
  Textdomain: Rock Intuit
  License: GPLv2
 */


/**
 * Add shortcode to allow to display an add to cart button with dropdown menu for variation attributes
 */
function duraamen_product_shortcode($atts) {

    if (empty($atts)) {
        return '';
    }

    if (!isset($atts['id']) && !isset($atts['sku'])) {
        return '';
    }

    $args = array(
        'posts_per_page' => 1,
        'post_type' => 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1,
        'no_found_rows' => 1,
    );

    if (isset($atts['sku'])) {
        $args['meta_query'][] = array(
            'key' => '_sku',
            'value' => sanitize_text_field($atts['sku']),
            'compare' => '=',
        );

        $args['post_type'] = array('product', 'product_variation');
    }

    if (isset($atts['id'])) {
        $args['p'] = absint($atts['id']);
    }

    $single_product = new WP_Query($args);

    $preselected_id = '0';

    $product = wc_get_product($atts['id']);
    $price = $product->get_price_html();
    $description = $product->get_short_description();
    $image = $product->get_image();
    $title = $product->get_name();
    $id = $product->get_id();
         $desc = get_field('product_type', $id);
    $rating  = $product->get_average_rating();
$count = $product->get_rating_count();

    if (isset($atts['sku']) && $single_product->have_posts() && 'product_variation' === $single_product->post->post_type) {

        $variation = new WC_Product_Variation($single_product->post->ID);
        $attributes = $variation->get_attributes();


        $preselected_id = $single_product->post->ID;


        $args = array(
            'posts_per_page' => 1,
            'post_type' => 'product',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'no_found_rows' => 1,
            'p' => $single_product->post->post_parent,
        );

        $single_product = new WP_Query($args);
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                var $variations_form = $('[data-product-page-preselected-id="<?php echo esc_attr($preselected_id); ?>"]').find('form.variations_form');
        <?php foreach ($attributes as $attr => $value) { ?>
                    $variations_form.find('select[name="<?php echo esc_attr($attr); ?>"]').val('<?php echo esc_js($value); ?>');
        <?php } ?>
            });
        </script>
        <?php
    }

    $single_product->is_single = true;
    ob_start();
    global $wp_query;

    $previous_wp_query = $wp_query;

    $wp_query = $single_product;

    wp_enqueue_script('wc-single-product');
    while ($single_product->have_posts()) {
        $single_product->the_post()
        ?>
        <div class="single-product" data-product-page-preselected-id="<?php echo esc_attr($preselected_id); ?>">
        <?php echo '<div class="woocommerce"><div class="container short-code"><div class="img-fluid">' . $image . '</div><div class="col text-center">' . $title . '</div><div class="additional-desc">' . $desc . '</div>'. wc_get_rating_html( $rating, $count ) .'<div class="col text-center">' . $price . '</div>'; ?> 
        <?php woocommerce_template_single_add_to_cart(); ?>
        </div>
        <?php
    }

    $wp_query = $previous_wp_query;

    wp_reset_postdata();
    return '<div class="woocommerce">' . ob_get_clean() . '</div>';
}

add_shortcode('cl_product_price', 'duraamen_product_shortcode');
