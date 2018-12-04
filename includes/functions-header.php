<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Site Headers functions
 */

/**
 * By default WordPress adds all sorts of code between the opening and closing head tags of a WordPress theme
 * So lets clean out some of them
 *
 */
function rone_removeHeadLinks() {
	/** remove some header information  **/
	remove_action( 'wp_head', 'feed_links_extra', 3 );  //category feeds
	remove_action( 'wp_head', 'feed_links', 2 );        //post and comments feed, see ro_enqueue_default_feed_link()
	remove_action( 'wp_head', 'rsd_link' );              //only required if you are looking to blog using an external tool
	remove_action( 'wp_head', 'wlwmanifest_link' );      //something to do with windows live writer
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 ); //next previous post links
	remove_action( 'wp_head', 'wp_generator' );          //generator tag ie WordPress version info
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );  //short links like ?p=124
}

add_action( 'init', 'rone_removeHeadLinks' );


/**
 * above we remove all feed (RSS) links lets put them back, for post content.
 * in ro_remove_head_links() we had to remove the post and comments rss link
 * now we want to add rss back just for post content
 * because feed_links() adds both the comments and posts feeds
 *
 * @see rone_remove_head_links()
 */
function rone_enqueue_default_feed_link() {
	echo "<link rel='alternate' type='application/rss+xml' title='" . get_bloginfo( 'name' ) . " &raquo; Feed' href='" . get_feed_link() . "' />";
}

add_action( 'wp_head', 'rone_enqueue_default_feed_link' );


/**
 * Add custom style sheet to the HTML Editor
 **/
function rone_theme_add_editor_styles() {
	if ( file_exists( get_stylesheet_directory() . "/editor-style.css" ) ) {
		add_editor_style( 'editor-style.css' );
	}
}

add_action( 'init', 'rone_theme_add_editor_styles' );

/**
 * enqueue parent theme css, instead doing @import
 * Faster than @import
 * @link https://kovshenin.com/2014/child-themes-import/
 */
function rone_enqueue_child_theme_css() {
	wp_enqueue_style( 'ro-parent-css', get_template_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'rone_enqueue_child_theme_css' );

/**
 * Load a custom.css style sheet, if it exists in a child theme.
 *
 * @return void
 */
function rone_enqueue_custom_stylesheets() {
	if ( ! is_admin() ) {
		if ( is_child_theme() ) {
			if ( file_exists( get_stylesheet_directory() . "/custom.css" ) ) {
				wp_enqueue_style( 'ro-theme-custom-css', get_template_directory_uri() . '/custom.css' );
			}
		}
	}
}

//add_action( 'wp_enqueue_scripts', 'rone_enqueue_custom_stylesheets', 11 );


/**
 * add custom login css and js for a single site, not multi site
 * @link https://codex.wordpress.org/Customizing_the_Login_Form
 *
 */
/*
function rone_enqueue_login_scripts() {
	if ( is_child_theme() ) {
		if ( file_exists( get_stylesheet_directory() . "/css/custom-login.css" ) ) {
			wp_enqueue_style( 'ro-custom-login-css', get_stylesheet_directory_uri() . '/css/custom-login.css' );
		}
		if ( file_exists( get_stylesheet_directory() . "/js/custom-login.js" ) ) {
			wp_enqueue_script( 'ro-custom-login-js', get_stylesheet_directory_uri() . '/js/custom-login.js' );
		}
	}
}
*/
//add_action( 'login_enqueue_scripts', 'rone_enqueue_login_scripts' );


?>