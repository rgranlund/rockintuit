<?php
/*
Plugin Name: Ad Display Shortcode
Plugin URI: https://rockintuit.com
Description: A lightweight plugin that creates a shortcode to display Ads In Sidebar. Use [sidebar-ads] placed in Sidebar (Use Shortcode Widget)
Version: 1.0
Author: Robert Granlund
Author URI: https://rockintuit.com
*/
/*
Create shortcode that displays adds in sidebar
*/

// Disable direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ads_styles() {
	wp_enqueue_style('ads-styles', plugin_dir_url( __FILE__ ) . 'css/ads-styles.css' );
}
add_action( 'wp_enqueue_scripts','ads_styles');


function sidebar_ads_attr() {

    // Grab all of thags and use the ones set for advertising on specific page
    $posttags = get_the_tags();
    if ($posttags) {
        $data = array();
        
      foreach($posttags as $tag) {
        $name = $tag->name;
          
        if($name == "A") {
            $data[] = '<a href="#"><div class="ad-cont"><div class="ad-image"><img src="images/file-icon.png" alt="FORM '.$name.'"/></div><div class="ad-title"><h2>AD TITLE HERE</h2><span>FORM '.$name.'</span></div></div></a>';
        }
        if($name == "B") {
            $data[] = '<a href="#"><div class="ad-cont"><div class="ad-image"><img src="images/file-icon.png" alt="FORM '.$name.'"/></div><div class="ad-title"><h2>AD TITLE HERE</h2><span>FORM '.$name.'</span></div></div></a>';
        }
 
      }
    
    if($data) {
        echo '<div class="ads-container">'; 
        echo '<div class="ads-banner">TITLE HERE</div>';
        echo '<div class="ads-subtitle">SUBTITLE HERE</div>';

    $i = 1;
    foreach($data as $tag) {
        if($i <= 3) {
        echo $tag;
        }
        $i++;
    }
    echo '<div class="ad-tag">AD TAG HERE</div>';
    echo'</div>';
}
    }
    }
    add_shortcode('sidebar_ads', 'sidebar_ads_attr');

?>