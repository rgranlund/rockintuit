<?php
/**
 * Plugin Name:  The RockIntuit Five Star Reviews
 * Description:  Functionality to Display random 5 Star Reviews
 * Plugin URI:   https://rockintuit.com
 * Author:       Robert Granlund
 * Version:      1.0
 * License:      GPL v2 or later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.txt
 *

 */

// Disable direct file access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//  Load Five Star Styles
function five_star_styles() {
	wp_enqueue_style('five-star-styles', plugin_dir_url( __FILE__ ) . 'css/five_star_rating.css', array(), filemtime( plugin_dir_path( __FILE__ ) .  'css/five_star_rating.css' ) );
}
add_action( 'wp_enqueue_scripts','five_star_styles');
/*
Calculate the total of 5 star reviews
*/

function get_all_product_review_ratings(){
    global $wpdb;

    if ( false === ( $review_ratings = get_transient( 'all_product_review_ratings' ))){ //Checking if we have previously cached query results in order to save resources and increase speed
	    $review_ratings = $wpdb->get_results("
	    	SELECT meta_value
	    	FROM {$wpdb->prefix}commentmeta as commentmeta
	    	JOIN {$wpdb->prefix}comments as comments ON comments.comment_id = commentmeta.comment_id
	    	WHERE commentmeta.meta_key = 'rating' AND comments.comment_approved = 1
	    	ORDER BY commentmeta.meta_value
	    ", ARRAY_A);

	    $expiration = 60 * 5; //Expiring query results after 5 minutes
	    set_transient( 'all_product_review_ratings', $review_ratings, $expiration ); //Temporarily storing cached data in the database by giving it a custom name and a timeframe after which it will expire and be deleted

	    return $review_ratings;
	}else{
		return $review_ratings;
	}
}

/*
Display the 5 Star Rating count
*/
    
    function get_all_product_review_counts_by_ratings(){
        $minimum_rating = 5;
        $maximum_rating = 5;

        $all_product_review_ratings = get_all_product_review_ratings();
      
       
        if($all_product_review_ratings){ //If we have reviews
           $all_product_review_ratings_one_dimensional_array = array_map("current", $all_product_review_ratings); //Converting two dimensional array to one dimensional array
     
           $rating_counts = array_count_values($all_product_review_ratings_one_dimensional_array); //Creating array that consists of rating counts
     $star = '';
           $ratings = array();
     
           $star.= '<div style="width: 100%; margin: 0 0 2.5% 0;"><b>Over ';
           while($maximum_rating >= $minimum_rating){
              if(array_key_exists($maximum_rating, $rating_counts)){
                 $star_count = $rating_counts[$maximum_rating];
              }else{
                 $star_count = 0;
              }
     
              //Creating array that contains information about 
              $ratings[] = array(
                 "value" => $maximum_rating,
                 "amount" => $star_count
              );
     
              $maximum_rating--;
           }
           $rate = $ratings[0]['amount'];
    
           $star.= $rate.'</b> Five Star Ratings and Growing!</div>';

           return $star;
           
        }else{
           return;
        }
        
     }

     
     //  Creat Shortcode to display the Rendom Reviews

     function get_random_five_stars_products_reviews() {
        
        $html = '';

        $args = array("a"=>"Great customer service, and fast shipping. You can email the team with questions about their products and get a prompt response.",
       
    );
    
        shuffle($args);
    
    
        $html = '<div class="products-reviews">';
        $html .= '<h2>'.get_all_product_review_counts_by_ratings().'</h2>';
                $html .= '<i>"'.$args[0];
                $html .= '"</i></div>';
        return $html;
    }
    add_shortcode('woo_reviews', 'get_random_five_stars_products_reviews');

?>