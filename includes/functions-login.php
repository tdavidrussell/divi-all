<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}




/**
 * adds login/logout to the primary menu if defined
 *
 * @param $items
 * @param $args
 *
 * @return string
 */
add_filter( 'wp_nav_menu_items', 'rone_add_login_logout_register_menu', 199, 2 );
function rone_add_login_logout_register_menu( $items, $args ) {

	if ( $args->theme_location != 'primary-menu' ) {
		return $items;
	}

	if ( is_user_logged_in() ) {
		$items .= '<li><a href="' . wp_logout_url() . '">' . __( 'Log Out', 'theme-text-domain' ) . '</a><li>';
	} else {
		$items .= '<li><a href="' . wp_login_url() . '">' . __( 'Login', 'theme-text-domain' ) . '</a></li>';
		if ( get_option( 'users_can_register' ) ) {
			$items .= '<li><a href="' . wp_registration_url() . '">' . __( 'Sign Up', 'theme-text-domain' ) . '</a></li>';
		}
	}

	return $items;
}

/**
 * https://trickspanda.com/auto-redirect-users-logout-wordpress/
 *
 */
add_action( 'wp_logout', 'rone_auto_redirect_after_logout' );
function rone_auto_redirect_after_logout() {
	wp_redirect( home_url() );
	exit();
}

/**
 * redirect login to main site, instead to the admin/profile page.
 *
 * @param $redirect_to
 * @param $request
 *
 * @return string|void
 */
add_filter( "login_redirect", "rone_login_redirect", 10, 3 );
function rone_login_redirect( $redirect_to, $request ) {
	//$redirect_url = get_bloginfo( 'url' ) . '/blog/';
	$redirect_url = get_bloginfo( 'url' );

	return $redirect_url;
}


?>