<?php 
function gs_lp_get_like_count($post_id){
	global $wpdb;
	$table_name = $wpdb->prefix . "gs_like_post";
	$post_like = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $post_id . '" AND like_num = "1" ' );
	return $post_like;
}
function gs_lp_get_dislike_count($post_id){
	global $wpdb;
	$table_name = $wpdb->prefix . "gs_like_post";
	$post_dislike = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $post_id . '" AND dislike_num = "1" ' );
	return $post_dislike;
}
function gs_lp_get_like_users($post_id) {
	global $wpdb;
	$table_name = $wpdb->prefix . "gs_like_post";
	$users = $wpdb->get_results('SELECT user_id FROM '. $table_name . ' WHERE post_id = "' . $post_id . '" AND like_num = "1" ', ARRAY_A );
	return $users;
}
function gs_lp_get_dislike_users($post_id) {
	global $wpdb;
	$table_name = $wpdb->prefix . "gs_like_post";
	$users = $wpdb->get_results('SELECT user_id FROM '. $table_name . ' WHERE post_id = "' . $post_id . '" AND dislike_num = "1" ', ARRAY_A );
	return $users;
}
?>