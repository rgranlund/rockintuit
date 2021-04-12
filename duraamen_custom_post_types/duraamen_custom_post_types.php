<?php

/*
  Plugin Name: Duraamen Custom Post Types
  Plugin URI: http://duraamen.com
  Description: Plugin to register custom post types
  Version: 1.0
  Author: Robert Granlund
  Author URI:http://rockintuit.com
  Textdomain: Rock Intuit
  License: GPLv2
 */

function duraamen_floor_app_post_type() {
    $labels = array(
        'name' => __('Floor Applications', 'duraamen'),
        'singular_name' => __('Floor Application', 'duraamen'),
        'add_new' => __('New Floor Application', 'duraamen'),
        'add_new_item' => __('Add Floor Application', 'duraamen'),
        'edit_item' => __('Edit Floor Application', 'duraamen'),
        'new_item' => __('New Floor Application', 'duraamen'),
        'view_item' => __('View Floor Application', 'duraamen'),
        'search_items' => __('Search Floor Application', 'duraamen'),
        'not_found' => __('No Floor Application Found', 'duraamen'),
        'not_found_in_trash' => __('No Floor Application found in Trash', 'duraamen'),
    );
    $args = array(
        'labels' => $labels,
        'has_archive' => false,
        'public' => true,
        'hierarchical' => true,
        'menu_position' => 5,
        'show_in_rest' => true,
        "rewrite" => array("slug" => "choose-your-floor", "with_front" => false),
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes')
    );
    register_post_type('floor-application', $args);
    //flush_rewrite_rules();
}

add_action('init', 'duraamen_floor_app_post_type');
add_action('init', 'duraamen_floor_app_taxonomies', 0);

function duraamen_floor_app_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name' => _x('Floor Application Categories', 'floor application categories'),
        'singular_name' => _x('Floor Application Category', 'floor application category'),
        'search_items' => __('Search Floor Application Categories'),
        'popular_items' => __('Popular Floor Application Categories'),
        'all_items' => __('All Floor Application Categories'),
        'parent_item' => __('Parent Floor Application'),
        'parent_item_colon' => __('Parent Floor Application:'),
        'edit_item' => __('Edit Floor Application'),
        'update_item' => __('Update Floor Application'),
        'add_new_item' => __('Add New Floor Application'),
        'new_item_name' => __('New Floor Application Name'),
    );
    register_taxonomy('floor-app-tax', array('floor-application'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'with_front' => false,
        'has_archive' => false,
        'show_in_rest' => true,
        'supports' => array('title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes'),
    ));
}

function duraamen_video_gallery_post_type() {
    $labels = array(
        'name' => __('Video Gallery', 'duraamen'),
        'singular_name' => __('Video Gallery', 'duraamen'),
        'add_new' => __('New Video Gallery', 'duraamen'),
        'add_new_item' => __('Add Video Gallery', 'duraamen'),
        'edit_item' => __('Edit Video Gallery', 'duraamen'),
        'new_item' => __('New Video Gallery', 'duraamen'),
        'view_item' => __('View Video Gallery', 'duraamen'),
        'search_items' => __('Search Video Gallery', 'duraamen'),
        'not_found' => __('No Video Gallery Found', 'duraamen'),
        'not_found_in_trash' => __('No Video Gallery found in Trash', 'duraamen'),
    );
    $args = array(
        'labels' => $labels,
        'has_archive' => false,
        'public' => true,
        'hierarchical' => true,
        'menu_position' => 6,
        'show_in_rest' => true,
        "rewrite" => array("slug" => "installation-videos", "with_front" => true),
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes')
    );
    register_post_type('video-gallery', $args);
    //flush_rewrite_rules();
}

add_action('init', 'duraamen_video_gallery_post_type');
add_action('init', 'duraamen_video_gallery_taxonomies', 0);

function duraamen_video_gallery_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name' => _x('Video Gallery Categories', 'video gallery categories'),
        'singular_name' => _x('Video Category', 'video category'),
        'search_items' => __('Search Video Categories'),
        'popular_items' => __('Popular Video Categories'),
        'all_items' => __('All Video Categories'),
        'parent_item' => __('Parent Video Category'),
        'parent_item_colon' => __('Parent Video Gallery:'),
        'edit_item' => __('Edit Video Gallery'),
        'update_item' => __('Update Video Gallery'),
        'add_new_item' => __('Add New Video Gallery'),
        'new_item_name' => __('New Video Gallery Name'),
    );
    register_taxonomy('video-gallery-tax', array('video-gallery'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'show_in_rest' => true,
        'supports' => array('title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes'),
    ));
}

function duraamen_photo_gallery_post_type() {
    $labels = array(
        'name' => __('Photo Gallery', 'duraamen'),
        'singular_name' => __('Photo Gallery', 'duraamen'),
        'add_new' => __('New Photo Gallery', 'duraamen'),
        'add_new_item' => __('Add Photo Gallery', 'duraamen'),
        'edit_item' => __('Edit Photo Gallery', 'duraamen'),
        'new_item' => __('New Photo Gallery', 'duraamen'),
        'view_item' => __('View Photo Gallery', 'duraamen'),
        'search_items' => __('Search Photo Gallery', 'duraamen'),
        'not_found' => __('No Photo Gallery Found', 'duraamen'),
        'not_found_in_trash' => __('No Photo Gallery found in Trash', 'duraamen'),
             'featured_image'        => __( 'Featured Image', 'duraamen' ),
            'set_featured_image'    => __( 'Set featured image', 'duraamen' ),
            'remove_featured_image' => __( 'Remove featured image', 'duraamen' ),
            'use_featured_image'    => __( 'Use as featured image', 'duraamen' ),
    );
    $args = array(
        'labels' => $labels,
        'has_archive' => false,
        'public' => true,
        'hierarchical' => true,
        'menu_position' => 7,
        'show_in_rest' => true,
        "rewrite" => array("slug" => "photo-galleries", "with_front" => false),
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes')
    );
    register_post_type('photo-gallery', $args);
    flush_rewrite_rules();
}

add_action('init', 'duraamen_photo_gallery_post_type');


add_filter('register_post_type_args', 'add_photo_gallery_theme_support', 10, 2);

function add_photo_gallery_theme_support($args, $post_type){
 
    if ($post_type == 'photo-gallery'){
        $args['support'] = 'thumbnail';
    }
    return $args;
}
//  END Photo Gallery Custom Post Type

add_action('init', 'duraamen_photo_gallery_taxonomies', 0);

function duraamen_photo_gallery_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name' => _x('Photo Gallery Categories', 'photo gallery categories'),
        'singular_name' => _x('Photo Category', 'photo gallery category'),
        'search_items' => __('Search Photo Categories'),
        'popular_items' => __('Popular Photo Categories'),
        'all_items' => __('All Photo Categories'),
        'parent_item' => __('Parent Photo Category'),
        'parent_item_colon' => __('Parent Photo Gallery:'),
        'edit_item' => __('Edit Photo Gallery'),
        'update_item' => __('Update Photo Gallery'),
        'add_new_item' => __('Add New Photo Gallery'),
        'new_item_name' => __('New Photo Gallery Name'),
    );
    register_taxonomy('photo-gallery-tax', array('photo-gallery'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'show_in_rest' => true,
          "rewrite" => array("slug" => "", "with_front" => false),
        'supports' => array('title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes'),
    ));
}


function duraamen_breadcrumbs()
{
    // Set variables for later use
    //$here_text        = __( 'You are currently here!' );
    $home_link        = home_url('/');
    $home_text        = __( 'Home' );
    $link_before      = '<span typeof="v:Breadcrumb">';
    $link_after       = '</span>';
    $link_attr        = ' rel="v:url" property="v:title"';
    $link             = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
    $delimiter        = ' / ';              // Delimiter between crumbs
    $before           = '<span class="current">'; // Tag before the current crumb
    $after            = '</span>';                // Tag after the current crumb
    $page_addon       = '';                       // Adds the page number if the query is paged
    $breadcrumb_trail = '';
    $category_links   = '';

    /** 
     * Set our own $wp_the_query variable. Do not use the global variable version due to 
     * reliability
     */
    $wp_the_query   = $GLOBALS['wp_the_query'];
    $queried_object = $wp_the_query->get_queried_object();

    // Handle single post requests which includes single pages, posts and attatchments
    if ( is_singular() ) 
    {
        /** 
         * Set our own $post variable. Do not use the global variable version due to 
         * reliability. We will set $post_object variable to $GLOBALS['wp_the_query']
         */
        $post_object = sanitize_post( $queried_object );

        // Set variables 
        $title          = apply_filters( 'the_title', $post_object->post_title );
        $parent         = $post_object->post_parent;
        $post_type      = $post_object->post_type;

        $post_id        = $post_object->ID;
        $post_link      = $before . $title . $after;
        $parent_string  = '';
        $post_type_link = '';
        
          /*   echo'<pre><b>title:</b><br />';
             var_dump($title);
             echo'</pre><pre><b>parent:</b><br />';
             var_dump( $parent);
              echo'</pre><pre><b>post type:</b><br />';
             var_dump(  $post_type );
              echo'</pre><pre><b>post link:</b><br />';
             var_dump(  $post_link   );
              echo'</pre><br />';
           * */
           
        

        if ( 'post' === $post_type ) 
        {
            // Get the post categories
            $categories = get_the_category( $post_id );
            if ( $categories ) {
                // Lets grab the first category
                $category  = $categories[0];

                $category_links = get_category_parents( $category, true, $delimiter );
                $category_links = str_replace( '<a',   $link_before . '<a' . $link_attr, $category_links );
                $category_links = str_replace( '</a>', '</a>' . $link_after,             $category_links );
            }
        }

        if ( !in_array( $post_type, ['post', 'page', 'attachment'] ) )
        {
            $post_type_object = get_post_type_object( $post_type );
            $archive_link     = esc_url( get_post_type_archive_link( $post_type ) );

            $post_type_link   = sprintf( $link, $archive_link, $post_type_object->labels->singular_name );
        }

        // Get post parents if $parent !== 0
        if ( 0 !== $parent ) 
        {
            $parent_links = [];
            while ( $parent ) {
                $post_parent = get_post( $parent );

                $parent_links[] = sprintf( $link, esc_url( get_permalink( $post_parent->ID ) ), get_the_title( $post_parent->ID ) );

                $parent = $post_parent->post_parent;
            }

            $parent_links = array_reverse( $parent_links );

            $parent_string = implode( $delimiter, $parent_links );
        }

        // Lets build the breadcrumb trail
        if ( $parent_string ) {
            $breadcrumb_trail = $parent_string . $delimiter . $post_link;
        } else {
            $breadcrumb_trail = $post_link;
        }

        if ( $post_type_link )
            $breadcrumb_trail = $post_type_link . $delimiter . $breadcrumb_trail;

        if ( $category_links )
            $breadcrumb_trail = $category_links . $breadcrumb_trail;
    }

    // Handle archives which includes category-, tag-, taxonomy-, date-, custom post type archives and author archives
    if( is_archive() )
    {
        if (    is_category()
             || is_tag()
             || is_tax()
        ) {
            // Set the variables for this section
            $term_object        = get_term( $queried_object );
            $taxonomy           = $term_object->taxonomy;
            if($taxonamy ="photo-gallery-tax") {
                $link = "/photo-gallery/";
            }
            $term_id            = $term_object->term_id;
            $term_name          = $term_object->name;
            $term_parent        = $term_object->parent;
            
            $taxonomy_object    = get_taxonomy( $taxonomy );
            $current_term_link  = $before . ' <a href="'.$link.'">'. $taxonomy_object->labels->singular_name .'</a> '. $delimiter .' '. $term_name . $after;
            $parent_term_string = '';
      /*      echo'<pre><b>Object:</b><br />';
             var_dump($term_object);
             echo'</pre><pre><b>Taxonomy:</b><br />';
             var_dump($taxonomy);
              echo'</pre><pre><b>Term ID:</b><br />';
             var_dump( $term_id );
              echo'</pre><pre><b>Term Name:</b><br />';
             var_dump($term_name );
              echo'</pre><pre><b>Term Parent:</b><br />';
             var_dump($term_parent);
              echo'</pre><pre><b>Taxonomy Object:</b><br />';
              var_dump($taxonomy_object);
               echo'</pre><pre><b>Current Term Link:</b><br />';
               var_dump($current_term_link);
*/

            if ( 0 !== $term_parent )
            {
                // Get all the current term ancestors
                $parent_term_links = [];
                while ( $term_parent ) {
                    $term = get_term( $term_parent, $taxonomy );

                    $parent_term_links[] = sprintf( $link, esc_url( get_term_link( $term ) ), $term->name );

                    $term_parent = $term->parent;
                }

                $parent_term_links  = array_reverse( $parent_term_links );
                $parent_term_string = implode( $delimiter, $parent_term_links );
                
            }

            if ( $parent_term_string ) {
                $breadcrumb_trail = '<a href="'.$link.'">'.$parent_term_string.'</a>' . $delimiter . $current_term_link;
            } else {
                $breadcrumb_trail = $current_term_link;
            }

        } elseif ( is_author() ) {

            $breadcrumb_trail = __( 'Author archive for ') .  $before . $queried_object->data->display_name . $after;

        } elseif ( is_date() ) {
            // Set default variables
            $year     = $wp_the_query->query_vars['year'];
            $monthnum = $wp_the_query->query_vars['monthnum'];
            $day      = $wp_the_query->query_vars['day'];

            // Get the month name if $monthnum has a value
            if ( $monthnum ) {
                $date_time  = DateTime::createFromFormat( '!m', $monthnum );
                $month_name = $date_time->format( 'F' );
            }

            if ( is_year() ) {

                $breadcrumb_trail = $before . $year . $after;

            } elseif( is_month() ) {

                $year_link        = sprintf( $link, esc_url( get_year_link( $year ) ), $year );

                $breadcrumb_trail = $year_link . $delimiter . $before . $month_name . $after;

            } elseif( is_day() ) {

                $year_link        = sprintf( $link, esc_url( get_year_link( $year ) ),             $year       );
                $month_link       = sprintf( $link, esc_url( get_month_link( $year, $monthnum ) ), $month_name );

                $breadcrumb_trail = $year_link . $delimiter . $month_link . $delimiter . $before . $day . $after;
            }

        } elseif ( is_post_type_archive() ) {

            $post_type        = $wp_the_query->query_vars['post_type'];
            $post_type_object = get_post_type_object( $post_type );

            $breadcrumb_trail = $before . $post_type_object->labels->singular_name . $after;

        }
    }   

    // Handle the search page
    if ( is_search() ) {
        $breadcrumb_trail = __( 'Search query for: ' ) . $before . get_search_query() . $after;
    }

    // Handle 404's
    if ( is_404() ) {
        $breadcrumb_trail = $before . __( 'Error 404' ) . $after;
    }

    // Handle paged pages
    if ( is_paged() ) {
        $current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
        $page_addon   = $before . sprintf( __( ' ( Page %s )' ), number_format_i18n( $current_page ) ) . $after;
    }

    $breadcrumb_output_link  = '';
    $breadcrumb_output_link .= '<div class="breadcrumb">';
    if (    is_home()
         || is_front_page()
    ) {
        // Do not show breadcrumbs on page one of home and frontpage
        if ( is_paged() ) {
            $breadcrumb_output_link .= '<a href="' . $home_link . '">' . $home_text . '</a>';
            $breadcrumb_output_link .= $page_addon;
        }
    } else {
        $breadcrumb_output_link .= '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $home_text . '</a>';
        $breadcrumb_output_link .= $delimiter;
        $breadcrumb_output_link .= $breadcrumb_trail;
        $breadcrumb_output_link .= $page_addon;
    }
    $breadcrumb_output_link .= '</div><!-- .breadcrumbs -->';

    return $breadcrumb_output_link;
}
