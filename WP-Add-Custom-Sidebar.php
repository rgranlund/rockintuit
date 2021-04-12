<?php

/*
 * Add Custom Sidebar
 */

function duraamen_category_sidebar()
{
    register_sidebar(
        array(
                'name' => __('Duraamen Custom', 'duraamen'),
                'id' => 'duraamen-custom-widget',
                'description' => __('Duraamen Category Sidebar', 'duraamen'),
                'before_widget' => '<div class="duraamen-widget">',
                'after_widget' => "</div>",
            )
    );
}

add_action('widgets_init', 'duraamen_category_sidebar');


add_filter('wp_dropdown_cats', function ($html, $args) {
    if ($args['show_children_only'] || !empty($args['include'])) {
        // we have 'show children' turned on
        $html = str_replace('<select', '<select data-placeholder="Subcategory"', $html);
    }

    return $html;
}, 11, 2);