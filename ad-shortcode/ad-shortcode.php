<?php
/*
Plugin Name: Ad Display Shortcode
Plugin URI: https://citizenpath.com
Description: A lightweight plugin that creates a shortcode to display Ads. Use [sidebar-ads] placed in Sidebar
Version: 1.0
Author: Robert Granlund
Author URI: https://rockintuit.com
Text Domain: pro-chilld
*/
/*
Create shortcode that displays adds in sidebar
*/

// Disable direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//  START Enqueue Stylesheet to be used for Ads
function citizens_ads_styles() {
	wp_enqueue_style('citizens-ads-styles', plugin_dir_url( __FILE__ ) . 'css/citizens-ads-styles.css' );
}
add_action( 'wp_enqueue_scripts','citizens_ads_styles');
//  END Enqueue Stylesheet to be used for Ads


//  START CREATE SHORTCODE FUNCTION
function sidebar_ads_attr() {

    //  Get all the Tags associated with the specific post being viewed.
    $posttags = get_the_tags();

    //  START If there are Tags for the page being viewed by user
    if ($posttags) {
        //  If there are tags start a data array.
        $data = array();

        //  Create variable for file image
        $img = plugin_dir_url( __FILE__ ) . 'img/file-icon.png';
        
      foreach($posttags as $tag) {
        //  Foreach Tag associated with the page assign the variable $name to contain the Tag name
        //  The $data variable is creating an array of ads to be displayed if the Tag Name matches Tags being used on the page being displayed to the user.

        $name = $tag->name;
          //  AD I-90
        if($name == "I-90") {
            $data[] = '<a href="../i-90-renew-replace-green-card/"><div class="ad-cont"><div class="ad-image"><img src="'.$img.'" alt="FORM '.$name.'"/></div><div class="ad-title"><h2>Renew or Replace A Green Card</h2><span>FORM '.$name.'</span></div></div></a>';
        }
        //  END AD I-90

        //  AD I-129F
        if($name == "I-129F") {
            $data[] = '<a href="../form-i-129f-petition-alien-fiance/"><div class="ad-cont"><div class="ad-image"><img src="'.$img.'" alt="FORM '.$name.'"/></div><div class="ad-title"><h2>Petition for Alien Fiancé</h2><span>FORM '.$name.'</span></div></div></a>';
        }
         //  END AD I-129F

         //  AD I-130
        if($name == "I-130") {
            $data[] = '<a href="../form-i-130-petition-for-alien-relative/"><div class="ad-cont"><div class="ad-image"><img src="'.$img.'" alt="FORM '.$name.'"/></div><div class="ad-title"><h2>Petition for Alien Relative</h2><span>FORM '.$name.'</span></div></div></a>';
        }
        //  END AD I-130

        //  AD I-131
        if($name == "I-131") {
            $data[] = '<a href="../i-131-advance-parole-travel-document-application/"><div class="ad-cont"><div class="ad-image"><img src="'.$img.'" alt="FORM '.$name.'"/></div><div class="ad-title"><h2>Application for Travel Document</h2><span>FORM '.$name.'</span></div></div></a>';
        }
        //  END AD I-131

        //  AD I-134
        if($name == "I-134") {
            $data[] = '<a href="../form-i-134-declaration-of-financial-support/"><div class="ad-cont"><div class="ad-image"><img src="'.$img.'" alt="FORM '.$name.'"/></div><div class="ad-title"><h2>Declaration of Financial Support</h2><span>FORM '.$name.'</span></div></div></a>';
        }
        //  END AD I-134

        //  AD I-485
        if($name == "I-485") {
            $data[] = '<a href="../form-i-485-adjustment-of-status-application/"><div class="ad-cont"><div class="ad-image"><img src="'.$img.'" alt="FORM '.$name.'"/></div><div class="ad-title"><h2>Application to Adjust Status</h2><span>FORM '.$name.'</span></div></div></a>';
        }
        //  END AD I-485

        //  AD I-751
        if($name == "I-751") {
            $data[] = '<a href="../i-751-remove-conditions-residence-green-card/"><div class="ad-cont"><div class="ad-image"><img src="'.$img.'" alt="FORM '.$name.'"/></div><div class="ad-title"><h2>Petition to Remove Conditions on Residence</h2><span>FORM '.$name.'</span></div></div></a>';
        }
        //  END AD I-751

        //  AD I-821D
        if($name == "I-821D") {
            $data[] = '<a href="../daca-application-form-i821d/"><div class="ad-cont"><div class="ad-image"><img src="'.$img.'" alt="FORM '.$name.'"/></div><div class="ad-title"><h2>Deferred Action for Childhood Arrivals (DACA)</h2><span>FORM '.$name.'</span></div></div></a>';
        }
        //  END AD I-821D

        //  AD I-864
        if($name == "I-864") {
            $data[] = '<a href="../form-i-864-affidavit-of-support/"><div class="ad-cont"><div class="ad-image"><img src="'.$img.'" alt="FORM '.$name.'"/></div><div class="ad-title"><h2>Affidavit of Support</h2><span>FORM '.$name.'</span></div></div></a>';
        }
        //  END AD I-864

        //  AD N-400
        if($name == "N-400") {
            $data[] = '<a href="../form-n-400-application-naturalization/"><div class="ad-cont"><div class="ad-image"><img src="'.$img.'" alt="FORM '.$name.'"/></div><div class="ad-title"><h2>Application for Naturalization</h2><span>FORM '.$name.'</span></div></div></a>';
        }
        //  END AD N-400

        // AD N-565
        if($name == "N-565") {
            $data[] = '<a href="../form-n-565-replace-citizenship-document/"><div class="ad-cont"><div class="ad-image"><img src="'.$img.'" alt="FORM '.$name.'"/></div><div class="ad-title"><h2>Application for Replacement Citizenship Document</h2><span>FORM '.$name.'</span></div></div></a>';
        }
        //  END AD N-565

        //  AD N-600
        if($name == "N-600") {
            $data[] = '<a href="../form-n-600-certificate-citizenship/"><div class="ad-cont"><div class="ad-image"><img src="'.$img.'" alt="FORM '.$name.'"/></div><div class="ad-title"><h2>Application for Certificate of Citizenship</h2><span>FORM '.$name.'</span></div></div></a>';
        }
        //  END AD N-600
      }
    
      //  START If there are Ads to be displayed
    if($data) {
        //  START Top of Ad Container and verbiage
        echo '<div class="ads-container">'; 
        echo '<div class="ads-banner">Get Started For Free</div>';
        echo '<div class="ads-subtitle">Quick, Step-By-Step Help Preparing</div>';
        //  END Top of Ad Container and verbiage


        //  START Count and display of Ads in Array and limit the display to 3 Ads.  This can be changed to whatever number is desired within the if($i <=3) change the 3 to the desired integer.
    $i = 1;
    foreach($data as $tag) {
        if($i <= 3) {
        echo $tag;
        }
        $i++;
    }
    //  END Count and display of Ads

    //  START Closing verbiage
    echo '<div class="ad-tag">Easy to prepare and guaranteed USCIS approval</div>';
    echo'</div>';
    //  END Closing verbiage

        }
         //  END If there are Ads to be displayed

    }
     //  END If there are Tags for the page being viewed by user
}
//  END CREATE SHORTCODE FUNCTION

    //  Create Shortcode
    add_shortcode('sidebar_ads', 'sidebar_ads_attr');

?>