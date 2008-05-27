<?php
/*
Plugin Name: Mudim
Plugin URI: http://mudim.googlecode.com
Description: Mudim plugin integrates Mudim (Mudzot's Vietnamese input method) , allows typing Vietnamese anywhere in your blog.
Author: Mudzot
Version: 0.1
Author URI: http://mudim.googlecode.com
*/

function include_js() {
	echo '<script src="'.get_bloginfo('url').'/wp-content/plugins/mudim/mudim.js"></script>';
}
add_action('admin_head', 'include_js');
add_action('wp_head', 'include_js');

?>