<?php
/*
  Plugin Name: Custom Tabs
  Plugin URI: http://rockintuit.com
  Description: Custom Tabs For Products
  Version: 1.0
  Author: Robert Granlund
  Author URI:http://rockintuit.com
  Textdomain: Rock Intuit
  License: GPLv2
 */
/**
 * Rename product data tabs
 */

add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {
global $product;

        $tabs['reviews']['title'] = __( 'Reviews ⭐⭐⭐⭐⭐ (' . $product->get_review_count() . ') ' );

	return $tabs;

}

//Custom Tabs for WooCommerce
add_filter('woocommerce_product_tabs', 'woo_custom_video_tab');

function woo_custom_video_tab($tabs) {
global $product;
    // Adds the Videos tab
    $video = get_field('video_content');
    $video_file = get_field('videos');
    if ($video || $video_file) {
        $tabs['videos_tab'] = array(
            'title' => __('Product Videos <i class="fas fa-play-circle"></i>', 'woocommerce'),
            'priority' => 110,
            'callback' => 'woo_videos_tab_content'
        );
    }
    return $tabs;
}


/*
 * Videos Loop
 */
function woo_videos_tab_content() {
    global $product;
    $video = get_field('video_content');
    $video_file = get_field('videos');
    // The qty pricing tab content
    if ($video || $video_file) {
        // The new tab content
        echo $video;
        if (have_rows('videos')):
            while (have_rows('videos')): the_row();
                $title = get_sub_field('title');
                $embed_code = get_sub_field('embed_code');               
                echo '<strong>' . $title . '</strong><div class="embed-responsive"><iframe src="https://player.vimeo.com/video/' . $embed_code . '" width="640" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe></div>';
            endwhile;
        endif;
    }
}


//Custom Tabs for WooCommerce
add_filter('woocommerce_product_tabs', 'woo_custom_bio_tab');

function woo_custom_bio_tab($tabs) {
global $product;
    // Adds the Videos tab
    $bio = get_field('bio');
    if ($bio) {
        $tabs['bio_tab'] = array(
            'title' => __('Bio', 'woocommerce'),
            'priority' => 111,
            'callback' => 'woo_bio_tab_content'
        );
    }
    return $tabs;
}


/*
 * Videos Loop
 */
function woo_bio_tab_content() {
    $bio = get_field('bio');
    // The qty pricing tab content
    if ($bio) {
        // The new tab content
        echo $bio;
    }
}