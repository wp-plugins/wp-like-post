<?php 
register_activation_hook( __FILE__, 'gs_lp_activate' );
function boj_myplugin_activate() {
	//register the uninstall function
	register_uninstall_hook( __FILE__, 'gs_lp_uninstaller' );
}
function gs_lp_uninstaller() {
	//delete any options, tables, etc the plugin created
}
?>