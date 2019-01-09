<?php
/**
 * Child Theme Functions
 *
 * Functions or examples that may be used in a child them. Don't for get to edit them, to get them working.
 *
 * @link                https://make.wordpress.org/core/handbook/inline-documentation-standards/php-documentation-standards/#6-file-headers
 * @since               20151111.1
 *
 * @category            WordPress_Theme
 * @package             Divi_All
 * @subpackage          theme
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RODIVIALL_VERSION', '20181203.1' );
define( 'RODIVIALL_CDIR', get_stylesheet_directory() ); // if child, will be the file path, with out backslash
define( 'RODIVIALL_CURI', get_stylesheet_uri() ); // URL, if child, will be the url to the theme directory, no back slash


require( RODIVIALL_CDIR . '/includes/functions-admin-post-images.php' );
require( RODIVIALL_CDIR . '/includes/functions-blog-module.php' );
//require( RODIVIALL_CDIR . '/includes/functions-divi-projects.php' );
require( RODIVIALL_CDIR . '/includes/functions-header.php' );
require( RODIVIALL_CDIR . '/includes/functions-images.php' );
//require( RODIVIALL_CDIR . '/includes/functions-login.php' );
//require( RODIVIALL_CDIR . '/includes/functions-post-private-note.php' );
require( RODIVIALL_CDIR . '/includes/functions-rone.php' );
//require( RODIVIALL_CDIR . '/includes/functions-users.php' );



/**
 * Setup Child Theme's textdomain.
 *
 * Declare textdomain for this child theme.
 * Translations can be filed in the /languages/ directory.
 */
/*
function rone_theme_setup() {
	load_child_theme_textdomain( 'ro-child-theme', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'rone_theme_setup' );
*/

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
 * Replace the original footer credits
 *
 * @return string
 */
function et_get_original_footer_credits() {

	return sprintf( 'Copyright &copy;  %1$s  %2$s | Divi Child Theme by %3$s', date( "Y" ), get_bloginfo( 'name' ), '<a href="https://timrussell.com/wordpress/" target="_blank">Tim Russell</a>' );
}

/**
 * Register and load font awesome CSS files using a CDN.
 *
 * @link   http://www.bootstrapcdn.com/#fontawesome
 * @author FAT Media
 */
function ro_enqueue_awesome() {
	wp_enqueue_style( 'ro-font-awesome', 'https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css', array(), '4.0.3' );
}

add_action( 'wp_enqueue_scripts', 'ro_enqueue_awesome' );


?>