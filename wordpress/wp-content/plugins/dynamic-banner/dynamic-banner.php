<?php
/*
Plugin Name: Dynamic Banner
Description: Change banner background in function of the menu
Version: 1.0
Author: Diego Gutierrez
*/

function dynamic_banner_enqueue_scripts() {
    wp_enqueue_style('dynamic-banner-style', plugins_url('/assets/css/banner.css', __FILE__));
    wp_enqueue_script('jquery');
    wp_enqueue_script('dynamic-banner-script', plugins_url('/assets/js/banner.js', __FILE__), array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'dynamic_banner_enqueue_scripts');

// Function to add the banner to the page
function dynamic_banner_display() {
    echo '<div class="banner" id="banner"></div>';
}
add_action('wp_head', 'dynamic_banner_display');

// Function to determine the image of the banner of the selected menu
function dynamic_banner_get_root() {
    if (is_page()) {
        $post = get_post();
        $ancestors = get_post_ancestors($post->ID);
        if (!empty($ancestors)) {
            $root_id = array_pop($ancestors);
            $root_title = get_the_title($root_id);
            return $root_title;
        }
    }
    return '';
    
}
function dynamic_banner_pass_data() {
    $root = dynamic_banner_get_root();
    echo "<script>jQuery(document).ready(function($) { $('body').data('root', '$root'); });</script>";
}
add_action('wp_footer', 'dynamic_banner_pass_data');