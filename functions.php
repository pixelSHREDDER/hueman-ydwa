<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

function add_app_color_meta() {
   echo '<meta name="theme-color" content="' . maybe_hash_hex_color(hu_get_option('color-1')) . '"/>';
}
add_action('wp_head', 'add_app_color_meta');

/*add_filter( 'hu_get_primary_color_style', 'add_custom_color_styles');
function add_custom_color_styles() {
   //return array('#header #nav-mobile { background-color: ' . maybe_hash_hex_color(hu_get_option('color-1')) . '; }');
   //$styles = '#header #nav-mobile { background-color: ' . maybe_hash_hex_color(hu_get_option('color-1')) . '; }';
   //wp_add_inline_style('hueman-main-style', apply_filters('ha_user_options_style', $styles));
}
//add_action('wp_head', 'add_custom_color_styles');*/

global $plugins;
$plugins = array(
   'jetpack' => array(
      'file' => 'jetpack',
      'active' => false
   ),
   'events-made-easy' => array(
      'file' => 'events-manager',
      'active' => false
   ),
   'give' => array(
      'file' => 'give',
      'active' => false
   ),
   'contact-form-7' => array(
      'file' => 'wp-contact-form-7',
      'active' => false
   ),
   'ultimate-member' => array(
      'file' => 'ultimate-member',
      'active' => false
   ),
   'paid-memberships-pro' => array(
      'file' => 'paid-memberships-pro',
      'active' => false
   ),
   'woocommerce' => array(
      'file' => 'woocommerce',
      'active' => false
   )
);

add_action( 'wp_head', 'plugins_style', 100 );

function plugins_style() {
   global $plugins;
   include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

   foreach ($plugins as $key => $plugin) {
      if (is_plugin_active($key . '/' . $plugin['file'] . '.php')) {
         $plugins[$key]['active'] = true;
         wp_register_style($key, get_stylesheet_directory_uri() . '/styles/' . $key . '.css');
         wp_enqueue_style($key);
      }
   }
}

add_action( 'wp_head', 'custom_colors_style', 100 );

function custom_colors_style() {
   global $plugins;
   $prim_color = maybe_hash_hex_color(hu_get_option('color-1'));
   $sec_color = maybe_hash_hex_color(hu_get_option('color-2'));

   if (!empty($prim_color) || !empty($sec_color)) {
      echo '<style type="text/css">';
      if (!empty($prim_color)) {
         echo '.btn {background-color:' . $prim_color . ' !important;}';
         if ($plugins['ultimate-member']['active']) {
            echo
               '.um .um-field-group-head,.picker__box,.picker__nav--prev:hover,.picker__nav--next:hover,' .
               '.um .um-members-pagi span.current,.um .um-members-pagi span.current:hover,.um .um-profile-nav-item.active a,' .
               '.um .um-profile-nav-item.active a:hover,.upload,.um-modal-header,.um-modal-btn:not(.alt),.um-modal-btn.disabled:not(.alt),' .
               '.um-modal-btn.disabled:not(.alt):hover,div.uimob800 .um-account-side li a.current,div.uimob800 .um-account-side li a.current:hover,' .
               '.um input[type="submit"].um-button:not(.alt),.um input[type="submit"].um-button:not(.alt):focus,.um a.um-button:not(.alt),' . 
               '.um a.um-button.um-disabled:not(.alt):hover,.um a.um-button.um-disabled:not(.alt):focus,.um a.um-button.um-disabled:not(.alt):active,' .
               '.um .um-field-group-head:hover,.picker__header,.picker__day--infocus:hover,.picker__day--outfocus:hover,' .
               '.picker__day--highlighted:hover,.picker--focused .picker__day--highlighted,.picker__list-item:hover,' .
               '.picker__list-item--highlighted:hover,.picker--focused .picker__list-item--highlighted,' .
               '.picker__list-item--selected,.picker__list-item--selected:hover,' .
               '.picker--focused .picker__list-item--selected {background:' . $prim_color . ' !important;}';
         }
         if ($plugins['paid-memberships-pro']['active']) {
            echo
               '.pmpro_btn,.pmpro_btn:link,.pmpro_content_message a,.pmpro_content_message a:link {' .
               'background-color: ' . $prim_color . ' !important; border-color: ' . $prim_color . ' !important;}';
         }
      }
      if (!empty($sec_color)) {
         if ($plugins['ultimate-member']['active']) {
            echo
               '.um .um-dropdown {background: ' . $sec_color . ' !important;}';
            echo
               '.um-profile.um .um-profile-headericon > a:hover,.um-profile.um .um-profile-edit-a.active' .
               ' {color: ' . $sec_color . ' !important;}';
         }
      }
      echo '</style>';
   }
}

/*function replace_text($text) {
   $text = str_replace(
      '<div class="um-member-metaline um-member-metaline-leg_dist"><span><strong>Legislative District (required) <a href="http://app.leg.wa.gov/districtfinder/" target="_blank">(Don\'t know? Find out here!)</a>:</strong>',
      '<div class="um-member-metaline um-member-metaline-leg_dist"><span><strong>Legislative District:</strong>',
      $text);
	//$text = str_replace('look-for-that-string', 'replace-with-that-string', $text);
	return $text;
}
add_filter('the_content', 'replace_text');*/
if ($plugins['ultimate-member']['active'] || $plugins['paid-memberships-pro']['active']) {
   add_action( 'wp_footer', function() {
      echo 
         "<script>" .
            "(function($) {" .
               "'use strict';" .
               "$(document).on('ready', function() {";

      if ($plugins['paid-memberships-pro']['active']) {
            echo
                  "$('.pmpro_checkout-field-username > label').text('Username (required)');" .
                  "$('.pmpro_checkout-field-password > label').text('Password (required)');" .
                  "$('.pmpro_checkout-field-password2 > label').text('Confirm Password (required)');" .
                  "$('.pmpro_checkout-field-bemail > label').text('Email Address (required)');" .
                  "$('.pmpro_checkout-field-bconfirmemail > label').text('Confirm Email Address (required)');";
      }
      if ($plugins['ultimate-member']['active']) {
            echo
                  "$('.um-member-metaline-leg_dist strong').text('Legislative District:');";
      }
      echo
               "});" .
            "} (jQuery));" .
         "</script>";
   });
}
?>