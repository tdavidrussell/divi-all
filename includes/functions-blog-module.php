<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**  override the Blog bulider
 * @see http://www.eleganttweaks.com/divi/change-replace-modules/
 */

add_action( 'wp', 'divi_child_theme_blog_setup', 9999 );

function divi_child_theme_blog_setup() {
	// If the builder not loaded, bail
	if ( ! class_exists('ET_Builder_Module') ) {
		return;
	}
	// load the modified class
	get_template_part( 'includes/class-blog-module' );

	// Make it happen
	$roneBlog2 = new ET_Builder_Module_Blog2();
	remove_shortcode( 'et_pb_blog' );
	add_shortcode( 'et_pb_blog', array( $roneBlog2, '_render' ) );
}



?>