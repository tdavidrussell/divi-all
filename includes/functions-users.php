<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Site User functions
 */


/** Removes the WordPress logo on ther user side. */
add_action( 'admin_bar_menu', 'rone_remove_wp_logo', 9999 );

function rone_remove_wp_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'wp-logo' );
	//$wp_admin_bar->remove_node( 'et-use-visual-builder' );
}


/**
 ** http://wpsnipp.com/index.php/functions-php/extend-auto-logout-period/
 **/
function rone_logged_in_time( $expirein ) {

	if ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) {
		// stuff here for admins or editors
		//return 31556926; // 1 year in seconds
		return 604800; // 1 week in seconds
	} else {
		return $expirein;
	}

}

//add_filter( 'auth_cookie_expiration', 'rone_logged_in_time' );

/* http://code.tutsplus.com/articles/customizing-your-wordpress-admin--wp-24941 */
/* Change the Posts menu item to Blogs
 *
 */
function rone_edit_admin_menus() {
	global $menu;
	global $submenu;

	$menu[5][0]                 = 'Blog'; // Change Posts to Blog
	$submenu['edit.php'][5][0]  = 'All Blogs Post';
	$submenu['edit.php'][10][0] = 'Add a Blog Post';
	$submenu['edit.php'][15][0] = 'Blog Category';
	$submenu['edit.php'][16][0] = 'Blog Tags';
}

//add_action( 'admin_menu', 'rone_edit_admin_menus' );




?>