<?php
// call when click in like button
add_action('wp_ajax_gs_lp_like_post','gs_lp_like_post');
add_action('wp_ajax_nopriv_gs_lp_like_post','gs_lp_like_post');
function gs_lp_like_post(){
	global $wpdb;
	$gs_lp_options = get_option('gs_lp_options');
	$table_name = $wpdb->prefix . "gs_like_post";
	if(isset($gs_lp_options['req_loggin']) && $gs_lp_options['req_loggin'] == 'true'){
		$like_count = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $_POST["post_id"] . '" AND like_num = "1" AND user_id = "' . $_POST["user_id"] . '"');
		$dislike_count = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $_POST["post_id"] . '" AND dislike_num = "1" AND user_id = "' . $_POST["user_id"] . '"');
	}else {
		$like_count = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $_POST["post_id"] . '" AND like_num = "1" AND ip = "' . $_POST["ip"] . '"');
		$dislike_count = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $_POST["post_id"] . '" AND dislike_num = "1" AND ip = "' . $_POST["ip"] . '"');
	}
	if(isset($like_count) && empty($like_count)){
		$_POST['like_num']++;
		if(isset($dislike_count) && !empty($dislike_count)){
			$_POST['dislike_num']--;
			if(isset($gs_lp_options['req_loggin']) && $gs_lp_options['req_loggin'] == 'true'){
				$wpdb->delete( $table_name, array( 'post_id' => $_POST['post_id'], 'user_id' => $_POST['user_id'], 'dislike_num' => 1 ) );
			}else{
				$wpdb->delete( $table_name, array( 'post_id' => $_POST['post_id'], 'ip' => $_POST['ip'], 'dislike_num' => 1 ) );
			}
		}
		$new_data = array(
			'post_id' => $_POST['post_id'],
			'user_id' => $_POST['user_id'],
			'ip' => $_POST['ip'],
			'like_num' => 1,
		);
		$wpdb->insert($table_name, $new_data);
		$likess_dislikes_count = array(
			'like_num' => $_POST['like_num'],
			'dislike_num' => $_POST['dislike_num'],
		);
		echo json_encode($likess_dislikes_count);
	}else{
		$_POST['like_num']--;
		if(isset($gs_lp_options['req_loggin']) && $gs_lp_options['req_loggin'] == 'true'){
			$wpdb->delete( $table_name, array( 'post_id' => $_POST['post_id'], 'user_id' => $_POST['user_id'], 'like_num' => 1 ) );
		}else {
			$wpdb->delete( $table_name, array( 'post_id' => $_POST['post_id'], 'ip' => $_POST['ip'], 'like_num' => 1 ) );
		}
		$likess_dislikes_count = array(
			'like_num' => $_POST['like_num'],
			'dislike_num' => $_POST['dislike_num'],
		);
		echo json_encode($likess_dislikes_count);
	}
	wp_die();
}
// call when click in dislike button
add_action('wp_ajax_gs_lp_dislike_post','gs_lp_dislike_post');
add_action('wp_ajax_nopriv_gs_lp_dislike_post','gs_lp_dislike_post');
function gs_lp_dislike_post(){
	global $wpdb;
	$gs_lp_options = get_option('gs_lp_options');
	$table_name = $wpdb->prefix . "gs_like_post";
	if(isset($gs_lp_options['req_loggin']) && $gs_lp_options['req_loggin'] == 'true'){
		$like_count = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $_POST["post_id"] . '" AND like_num = "1" AND user_id = "' . $_POST["user_id"] . '"');
		$dislike_count = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $_POST["post_id"] . '" AND dislike_num = "1" AND user_id = "' . $_POST["user_id"] . '"');
	}else {
		$like_count = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $_POST["post_id"] . '" AND like_num = "1" AND ip = "' . $_POST["ip"] . '"');
		$dislike_count = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $_POST["post_id"] . '" AND dislike_num = "1" AND ip = "' . $_POST["ip"] . '"');
	}
	if(isset($dislike_count) && empty($dislike_count)){
		$_POST['dislike_num']++;
		if(isset($like_count) && !empty($like_count)){
			$_POST['like_num']--;
			if(isset($gs_lp_options['req_loggin']) && $gs_lp_options['req_loggin'] == 'true'){
				$wpdb->delete( $table_name, array( 'post_id' => $_POST['post_id'], 'user_id' => $_POST['user_id'], 'like_num' => 1 ) );
			}else{
				$wpdb->delete( $table_name, array( 'post_id' => $_POST['post_id'], 'ip' => $_POST['ip'], 'like_num' => 1 ) );
			}
		}
		$new_data = array(
			'post_id' => $_POST['post_id'],
			'user_id' => $_POST['user_id'],
			'ip' => $_POST['ip'],
			'dislike_num' => 1,
		);
		$wpdb->insert($table_name, $new_data);
		$likess_dislikes_count = array(
			'like_num' => $_POST['like_num'],
			'dislike_num' => $_POST['dislike_num'],
		);
		echo json_encode($likess_dislikes_count);
	}else{
		$_POST['dislike_num']--;
		$wpdb->delete( $table_name, array( 'post_id' => $_POST['post_id'], 'ip' => $_POST['ip'], 'dislike_num' => 1 ) );
		$likess_dislikes_count = array(
			'like_num' => $_POST['like_num'],
			'dislike_num' => $_POST['dislike_num'],
		);
		echo json_encode($likess_dislikes_count);
	}
	wp_die();
}