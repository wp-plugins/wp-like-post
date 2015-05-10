<?php
add_action('init', 'include_ajax_files');
function include_ajax_files() {
	require_once plugin_dir_path( __FILE__ ) . 'like-post-ajax.php';
}
// add like system in single page content 
add_filter('the_content', 'gs_lp_add_like');
function gs_lp_add_like( $content ) {
	global $wpdb;
	global $post;
	$gs_lp_options = get_option('gs_lp_options');
	$ip;
	if (getenv('HTTP_CLIENT_IP')) {
		$ip = getenv('HTTP_CLIENT_IP');
	} elseif (getenv('HTTP_X_FORWARDED_FOR')) {
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif (getenv('HTTP_X_FORWARDED')) {
		$ip = getenv('HTTP_X_FORWARDED');
	} elseif (getenv('HTTP_FORWARDED_FOR')) {
		$ip = getenv('HTTP_FORWARDED_FOR');
	} elseif (getenv('HTTP_FORWARDED')) {
		$ip = getenv('HTTP_FORWARDED');
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	$gs_lp_user = wp_get_current_user();
	$gs_like_post_params = array(
		'ajaxurl' => admin_url('admin-ajax.php'),
		'ip' => $ip,
		'user_id' => $gs_lp_user->ID,
		'post_id' => $post->ID,
	);
	wp_localize_script('like_post_js', 'gs_like_post', $gs_like_post_params);
    wp_enqueue_script('like_post_js');
	
    if( is_single() ) {
    	if(isset($gs_lp_options['gs_post_type'][get_post_type( $post->ID )]) && $gs_lp_options['gs_post_type'][get_post_type( $post->ID )] == 'true' ){
	    	$table_name = $wpdb->prefix . "gs_like_post";
			$like_count = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $gs_like_post_params["post_id"] . '" AND like_num = "1"' );
			$dislike_count = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $gs_like_post_params["post_id"] . '" AND dislike_num = "1"' );
			if(isset($gs_lp_options['req_loggin']) && $gs_lp_options['req_loggin'] == 'true'){
				$user_like = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $gs_like_post_params["post_id"] . '" AND like_num = "1" AND user_id = "' . $gs_lp_user->ID . '"' );
				$user_dislike = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $gs_like_post_params["post_id"] . '" AND dislike_num = "1" AND user_id = "' . $gs_lp_user->ID . '"' );
			}else {
				$visitor_like = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $gs_like_post_params["post_id"] . '" AND like_num = "1" AND ip = "' . $ip . '"' );
				$visitor_dislike = $wpdb->get_var('SELECT COUNT(*) FROM '. $table_name . ' WHERE post_id = "' . $gs_like_post_params["post_id"] . '" AND dislike_num = "1" AND ip = "' . $ip . '"' );
			}
			if(isset($gs_lp_options['req_loggin']) && $gs_lp_options['req_loggin'] == 'true'){
				$class_active_like = !empty($user_like)? 'activeUser' : '';
				$class_active_dislike = !empty($user_dislike)? 'activeUser' : '';
			}else {
				$class_active_like = !empty($visitor_like)? 'activeUser' : '';
				$class_active_dislike = !empty($visitor_dislike)? 'activeUser' : '';
			}
	        $content_like;
			$like_icon = apply_filters('gs_lp_like_icon', 'icon-like-heart');
			$dislike_icon = apply_filters('gs_lp_dislike_icon', 'icon-like-heart-broken');
			if(isset($gs_lp_options['display']) && $gs_lp_options['display'] == 'like') {
				$content_like = '<div class="gs_lp_like_container">
									<div class="gs_lp_like_col gs_lp_like" data-like_num="'. $like_count .'">
			        					<div class="'. $class_active_like .' gs_lp_like_icon" title="like">
			        						<span class="'. $like_icon .'"></span>
			        					</div>
			        					<p>'. $like_count .'</p>
			        				</div>
		        				</div>';
			}else if(isset($gs_lp_options['display']) && $gs_lp_options['display'] == 'dislike') {
				$content_like = '<div class="gs_lp_like_container">
									<div class="gs_lp_like_col gs_lp_dislike" data-dislike_num="'. $dislike_count .'">
			        					<div class="'. $class_active_dislike .' gs_lp_like_icon" title="dislike">
			        						<span class="'. $dislike_icon .'"></span>
			        					</div>
			        					<p>'. $dislike_count .'</p>
			        				</div>
			        			</div>';
			}else {
				$content_like = '<div class="gs_lp_like_container">
									<div class="gs_lp_like_col gs_lp_like" data-like_num="'. $like_count .'">
			        					<div class="'. $class_active_like .' gs_lp_like_icon" title="like">
			        						<span class="'. $like_icon .'"></span>
			        					</div>
			        					<p>'. $like_count .'</p>
			        				</div>
			        				<div class="gs_lp_like_col gs_lp_dislike" data-dislike_num="'. $dislike_count .'">
			        					<div class="'. $class_active_dislike .' gs_lp_like_icon" title="dislike">
			        						<span class="'. $dislike_icon .'"></span>
			        					</div>
			        					<p>'. $dislike_count .'</p>
			        				</div>
		        				</div>';
			}
			if(isset($gs_lp_options['req_loggin']) && $gs_lp_options['req_loggin'] == 'true'){
	        	if(is_user_logged_in()){
	        		$content .= $content_like;
	        	}else{
	        		if($gs_lp_options['show_loggin_message'] == 'true' ){
	        			$content .= '<div class="gs_lp_like_container">
										<p class="gs_must_login">'. $gs_lp_options['req_loggin_message'] .'</p>
									</div>';
	        		}
	        	}
			}else {
				$content .= $content_like;
			}
			$color_dislike_icon = '';
			$color_like_icon = '';
			$color_border = '';
			if(isset($gs_lp_options['color_border'])) {
				$color_border = '.gs_lp_like_container {
									  border-bottom-color: ' .$gs_lp_options['color_border'] . ';
									  border-top-color: ' . $gs_lp_options['color_border'] . ';
								}';
			}
			if(isset($gs_lp_options['color_dislike_icon'])) {
				$color_dislike_icon = '.gs_lp_like_container .gs_lp_dislike .gs_lp_like_icon {
									border-color: ' . $gs_lp_options['color_dislike_icon'] . ';
								}
								.gs_lp_like_container .gs_lp_dislike .gs_lp_like_icon.activeUser {
									  background: '. $gs_lp_options['color_dislike_icon'] .';
								}
								.gs_lp_like_container .gs_lp_dislike .gs_lp_like_icon span {
									  color: '. $gs_lp_options['color_dislike_icon'] .';
								}
								.gs_lp_like_container .gs_lp_like_col.gs_lp_dislike p {
									color: '. $gs_lp_options['color_dislike_icon'] .';
								}';
			}
			if(isset($gs_lp_options['color_like_icon'])) {
				$color_like_icon = '.gs_lp_like_container .gs_lp_like .gs_lp_like_icon {
									border-color: ' . $gs_lp_options['color_like_icon'] . ';
								}
								.gs_lp_like_container .gs_lp_like .gs_lp_like_icon.activeUser {
									  background: '. $gs_lp_options['color_like_icon'] .';
								}
								.gs_lp_like_container .gs_lp_like .gs_lp_like_icon span {
									  color: '. $gs_lp_options['color_like_icon'] .';
								}
								.gs_lp_like_container .gs_lp_like_col.gs_lp_like p {
									color: '. $gs_lp_options['color_like_icon'] .';
								}';
			}
			$content .= '<style>'
							. $color_like_icon . $color_dislike_icon . $color_border .'
						  </style>';
		}
    }
    return $content;
}

?>