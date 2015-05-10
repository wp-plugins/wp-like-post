<?php
/*
Plugin Name: WP Like Post
Plugin URI: https://wordpress.org/plugins/wp-like-post/
Description: helps you to add a like system to any post type on your wordpress site and you can make likes/dislikes per user or visitor.
Version: 1.5.2
Author: Abdelrhman ElGreatly
License: GPLv2
*/
register_activation_hook( __FILE__, 'gs_lp_activate' );
function gs_lp_activate() {
	global $wpdb;
	$table_name = $wpdb->prefix . "gs_like_post";
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		$sql = "CREATE TABLE $table_name (
				  `id` int NOT NULL AUTO_INCREMENT,
				  `post_id` int NOT NULL,
				  `ip` varchar(255) NOT NULL,
				  `user_id` int DEFAULT '0' NOT NULL,
				  `like_num` int DEFAULT '0',
				  `dislike_num` int DEFAULT '0',
				  PRIMARY KEY (id)
				);";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
	$gs_lp_default_options = array(
		'display' => 'both',
		'req_loggin' => 'false',
		'req_loggin_message' => 'you must logged in',
		'gs_post_type' => array(),
		'show_loggin_message' => 'false',
		'color_like_icon' => '#333333',
		'color_dislike_icon' => '#333333',
		'color_border' => '#333333',
	);
	if(!get_option('gs_lp_options')){
		update_option('gs_lp_options', $gs_lp_default_options);
	}
}
add_action('wp_enqueue_scripts', 'gs_lp_add_style');
function gs_lp_add_style() {
	wp_register_style('fonts', plugins_url( 'css/fonts.css', __FILE__ ));
    wp_enqueue_style('fonts');
	
	wp_register_style('like_post_css', plugins_url( 'css/wp-like-post.css', __FILE__ ));
    wp_enqueue_style('like_post_css');
}
add_action('wp_enqueue_scripts', 'gs_lp_add_scripts');
function gs_lp_add_scripts() {
	wp_register_script('like_post_js', plugins_url( 'js/wp-like-post.js', __FILE__ ), array('jquery'));
}
add_action('admin_enqueue_scripts', 'gs_lp_add_admin_scripts');
function gs_lp_add_admin_scripts() {
	wp_register_script('like_post_js', plugins_url( 'js/wp-like-post-admin.js', __FILE__ ), array('jquery', 'wp-color-picker'));
	wp_enqueue_script('like_post_js');
}
define('PLUGIN_PATH', plugin_dir_path(__FILE__));
require_once PLUGIN_PATH . 'includes/like-admin-page.php';
require_once PLUGIN_PATH . 'includes/like-front-end.php';
require_once PLUGIN_PATH . 'includes/like-functions.php';
require_once PLUGIN_PATH . 'includes/shortcodes.php';
?>