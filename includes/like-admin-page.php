<?php
// create new submenu for WP Like Post Plugin Page in settings tab
add_action('admin_menu', 'gs_lp_add_page');
function gs_lp_add_page() {
	add_options_page( 'WP Like Post', 'WP Like Post Options', 'manage_options', 'gs_wp_like_post', 'gs_wp_like_post_function' );
}
// content WP Like Post Plugin Page 
function gs_wp_like_post_function() {
	?>
	<div class="wrap">
		<h2> WP Like Post </h2>
		<form action="" method="post">
		<?php
			if(isset($_POST['gs_lp_options'])){
				$all_options = $_POST['gs_lp_options'];
				$gs_lp_new_options;
				if(isset($all_options['display'])){
					$gs_lp_new_options['display'] = $all_options['display'];
				}
				if(isset($all_options['req_loggin'])){
					$gs_lp_new_options['req_loggin'] = $all_options['req_loggin'];
				}
				if(isset($all_options['req_loggin_message'])){
					$gs_lp_new_options['req_loggin_message'] = $all_options['req_loggin_message'];
				}
				if(isset($all_options['gs_post_type'])){
					$gs_lp_new_options['gs_post_type'] = $all_options['gs_post_type'];
				}
				if(isset($all_options['show_loggin_message'])){
					$gs_lp_new_options['show_loggin_message'] = $all_options['show_loggin_message'];
				}
				if(isset($all_options['color_like_icon'])){
					$gs_lp_new_options['color_like_icon'] = $all_options['color_like_icon'];
				}
				if(isset($all_options['color_dislike_icon'])){
					$gs_lp_new_options['color_dislike_icon'] = $all_options['color_dislike_icon'];
				}
				if(isset($all_options['color_border'])){
					$gs_lp_new_options['color_border'] = $all_options['color_border'];
				}
				update_option('gs_lp_options', $gs_lp_new_options);
			}
			settings_fields('gs_wp_like_post_options'); // link with register_settings
			do_settings_sections('gs_wp_like_post'); // link with add_settings_section slug
		?>
			<input name="Submit" type="submit" class="button-primary" value="Save Changes" />
		</form > 
	</div>
<?php
}
// Register and define the settings
add_action('admin_init', 'plugin_test_admin_init');
function plugin_test_admin_init(){
	register_setting('gs_wp_like_post', 'gs_wp_like_post_options', 'gs_lp_validate_options');
	add_settings_section('gs_wp_like_post_setting', 'WP Like Post Settings', 'gs_wp_like_post_section', 'gs_wp_like_post');
	add_settings_field('gs_lp_option_display', 'Display', 'gs_wp_like_post_setting_like_display', 'gs_wp_like_post', 'gs_wp_like_post_setting');
	add_settings_field('gs_lp_option_required_login', 'Required Log in', 'gs_lp_setting_required_loggin', 'gs_wp_like_post', 'gs_wp_like_post_setting');
	add_settings_field('gs_lp_option_show_message', 'Show Log in Message', 'gs_lp_setting_show_message', 'gs_wp_like_post', 'gs_wp_like_post_setting');
	add_settings_field('gs_lp_option_required_login_message', 'Required Log in Message', 'gs_lp_setting_required_loggin_message', 'gs_wp_like_post', 'gs_wp_like_post_setting');
	add_settings_field('gs_lp_option_show_type', 'Which types do you want to show like system ?', 'gs_lp_setting_show_type', 'gs_wp_like_post', 'gs_wp_like_post_setting');
	add_settings_field('gs_lp_option_color_like_icon', 'Like Color', 'gs_lp_setting_color_like_icon', 'gs_wp_like_post', 'gs_wp_like_post_setting');
	add_settings_field('gs_lp_option_color_dislike_icon', 'Dislike Color', 'gs_lp_setting_color_dislike_icon', 'gs_wp_like_post', 'gs_wp_like_post_setting');
	add_settings_field('gs_lp_option_color_border', 'Border Color', 'gs_lp_setting_color_border', 'gs_wp_like_post', 'gs_wp_like_post_setting');
}

// Explanations about this section
function gs_wp_like_post_section() {}
// create fields
function gs_wp_like_post_setting_like_display() {
	if(isset($_POST['gs_lp_options'])){
		$all_options = $_POST['gs_lp_options']; 
	}else{
		$all_options = get_option('gs_lp_options');
	}
	?>
	<input type="radio" name="gs_lp_options[display]" value="like" <?php echo isset($all_options['display'])? checked($all_options['display'], 'like') : '' ?> />Like <br />
	<input type="radio" name="gs_lp_options[display]" value="dislike" <?php echo isset($all_options['display'])? checked($all_options['display'], 'dislike') : '' ?> />Dislike <br />
	<input type="radio" name="gs_lp_options[display]" value="both" <?php echo isset($all_options['display'])? checked($all_options['display'], 'both') : '' ?> />Both <br />
	<?php
}
function gs_lp_setting_required_loggin() {
	if(isset($_POST['gs_lp_options'])){
		$all_options = $_POST['gs_lp_options']; 
	}else{
		$all_options = get_option('gs_lp_options');
	}
	?>
	<input type="checkbox" name="gs_lp_options[req_loggin]" value="true" <?php echo isset($all_options['req_loggin'])? checked($all_options['req_loggin'], 'true') : '' ?> />
	<?php
}
function gs_lp_setting_show_message() {
	if(isset($_POST['gs_lp_options'])){
		$all_options = $_POST['gs_lp_options']; 
	}else{
		$all_options = get_option('gs_lp_options');
	}
	?>
	<input type="checkbox" name="gs_lp_options[show_loggin_message]" value="true" <?php echo isset($all_options['show_loggin_message'])? checked($all_options['show_loggin_message'], 'true') : '' ?> />
	<?php
}
function gs_lp_setting_required_loggin_message() {
	if(isset($_POST['gs_lp_options'])){
		$all_options = $_POST['gs_lp_options']; 
	}else{
		$all_options = get_option('gs_lp_options');
	}
	?>
	<input type="text" name="gs_lp_options[req_loggin_message]" value="<?php echo isset($all_options['req_loggin_message'])? $all_options['req_loggin_message'] : '' ?>" />
	<?php
}
function gs_lp_setting_show_type() {
	if(isset($_POST['gs_lp_options'])){
		$all_options = $_POST['gs_lp_options']; 
	}else{
		$all_options = get_option('gs_lp_options');
	}
	$gs_post_types = get_post_types(array('show_ui' => true));
	foreach($gs_post_types as $gs_post_type){ ?>
		<input type="checkbox" name="gs_lp_options[gs_post_type][<?php echo $gs_post_type ?>]" value="true" <?php echo isset($all_options['gs_post_type'][$gs_post_type])? checked($all_options['gs_post_type'][$gs_post_type], 'true') : '' ?> /> <?php echo $gs_post_type ?> <br />
	<?php }
}
function gs_lp_setting_color_like_icon() {
	if(isset($_POST['gs_lp_options'])){
		$all_options = $_POST['gs_lp_options']; 
	}else{
		$all_options = get_option('gs_lp_options');
	} ?>
	<input type="text" class="gs_lp_color" name="gs_lp_options[color_like_icon]" id="gs_lp_options_color_like_icon" value="<?php echo isset($all_options['color_like_icon'])? $all_options['color_like_icon'] : '' ?>" />
	<?php
}
function gs_lp_setting_color_dislike_icon() {
	if(isset($_POST['gs_lp_options'])){
		$all_options = $_POST['gs_lp_options']; 
	}else{
		$all_options = get_option('gs_lp_options');
	} ?>
	<input type="text" class="gs_lp_color" name="gs_lp_options[color_dislike_icon]" id="gs_lp_options_color_dislike_icon" value="<?php echo isset($all_options['color_dislike_icon'])? $all_options['color_dislike_icon'] : '' ?>" />
	<?php
}
function gs_lp_setting_color_border() {
	if(isset($_POST['gs_lp_options'])){
		$all_options = $_POST['gs_lp_options']; 
	}else{
		$all_options = get_option('gs_lp_options');
	} ?>
	<input type="text" class="gs_lp_color" name="gs_lp_options[color_border]" id="gs_lp_options_color_border" value="<?php echo isset($all_options['color_border'])? $all_options['color_border'] : '' ?>" />
	<?php
}
function gs_lp_validate_options( $input ) {
	return $valid;
}