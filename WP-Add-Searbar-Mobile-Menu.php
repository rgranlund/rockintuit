<?php
/*
 * Add Searchbar to Mobile Menu
 */

function duraamen_mobile_nav_search($items, $args)
{
    // If this isn't the primary menu, do nothing
    if (($args->theme_location == 'mobile')) {
        $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . site_url() . '">
  <div>
    <button type="search" id="searchsubmit">search <i class="fa fa-search"></i></button><input type="text" class="mobile-search" value="" name="s" id="s">
  </div>
</form>';
        return '<li class="mobile-search-block">' . $form . '</li>' . $items;
    } else {
        return $items;
    }
}

add_filter('wp_nav_menu_items', 'duraamen_mobile_nav_search', 10, 2);
