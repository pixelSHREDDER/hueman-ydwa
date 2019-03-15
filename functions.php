<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

function add_app_color_meta() {
   echo '<meta name="theme-color" content="' . maybe_hash_hex_color(hu_get_option('color-1')) . '"/>';
}
add_action('wp_head', 'add_app_color_meta');

 /* Add additional custom color styles */
add_filter( 'hu_get_primary_color_style', 'add_custom_color_styles');
function add_custom_color_styles() {
   return array('#header #nav-mobile { background-color: ' . maybe_hash_hex_color(hu_get_option('color-1')) . '; }');
   //$styles = '#header #nav-mobile { background-color: ' . maybe_hash_hex_color(hu_get_option('color-1')) . '; }';
   //wp_add_inline_style('hueman-main-style', apply_filters('ha_user_options_style', $styles));
}
//add_action('wp_head', 'add_custom_color_styles');
?>