<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function rone_add_svg_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'rone_add_svg_mime_types' );


/**
 * Since it about photos, quality should be 100%
 */
function rone_jpeg_quality() {
	return 100;
}

add_filter( 'jpeg_quality', 'rone_jpeg_quality' );

/**
 * Get all the registered image sizes along with their dimensions
 *
 * @global array $_wp_additional_image_sizes
 *
 * @link http://core.trac.wordpress.org/ticket/18947 Reference ticket
 *
 * @return array $image_sizes The image sizes
 */
function rone_get_all_image_sizes() {
	global $_wp_additional_image_sizes;

	$default_image_sizes = get_intermediate_image_sizes();

	foreach ( $default_image_sizes as $size ) {
		$image_sizes[ $size ]['width']  = intval( get_option( "{$size}_size_w" ) );
		$image_sizes[ $size ]['height'] = intval( get_option( "{$size}_size_h" ) );
		$image_sizes[ $size ]['crop']   = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
	}

	if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
		$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
	}

	return $image_sizes;
}

/**
 * So I don't lose my mind on what images sizes are currently set...
 *
 */
function rone_debug_print_image_sizes() {

	$rone_image_sizes = rone_get_all_image_sizes();
	print '<pre>';
	print_r( $rone_image_sizes );
	print '</pre>';

	//print_r($rone_image_sizes['et-builder-post-main-image']);


}

/**
 * The gallery module not recognise the image orientation.
 * All images reduced to the fixed sizes and may be cropped.
 * We can change those fixed sizes. Please add the following
 * code to the functions.php :
 *
 * @link ET Forums: https://www.elegantthemes.com/forum/viewtopic.php?f=187&t=470086&p=2610589&hilit=image+sizes+gallery+image+cropped#p2610589
 *
 * @param $height
 *
 * @return string
 */
function rone_gallery_size_h( $height ) {
	return '1280';
}

add_filter( 'et_pb_gallery_image_height', 'rone_gallery_size_h' );

function rone_gallery_size_w( $width ) {
	return '9999';
}

add_filter( 'et_pb_gallery_image_width', 'rone_gallery_size_w' );

/**
 * this will change the auto height cropping of featured images
 */
function rone_disable_cropping_on_featured_images() {
	add_image_size( 'divi-image-single-post', 1280, 9999, false );
}

add_action( 'after_setup_theme', 'rone_disable_cropping_on_featured_images', 11 );

/**
 * Stop cropping the height of images
 * @link https://divibooster.com/stop-divi-from-cropping-feature-post-heights/
 *
 */
//add_filter('et_theme_image_sizes', 'rone_remove_featured_post_cropping');
function rone_remove_featured_post_cropping( $sizes ) {

		if (isset($sizes['1080x675'])) {
			unset($sizes['1080x675']);
			$sizes['1080x9998'] = 'et-pb-post-main-image-fullwidth';
		}


	// this does not work, added new image size
	if ( isset( $sizes['440x264'] ) ) {
		unset( $sizes['440x264'] );
		$sizes['440x998'] = 'extra-image-small';
	}

	return $sizes;
}

/**
 * START: Disable responsive images, disable srcset on frontend,
 */
add_filter( 'wp_get_attachment_image_attributes', function ( $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		unset( $attr['sizes'] );
	}
	if ( isset( $attr['srcset'] ) ) {
		unset( $attr['srcset'] );
	}

	return $attr;
}, PHP_INT_MAX );
add_filter( 'wp_calculate_image_sizes', '__return_false', PHP_INT_MAX );
add_filter( 'wp_calculate_image_srcset', '__return_false', PHP_INT_MAX );
remove_filter( 'the_content', 'wp_make_content_images_responsive' );
/**
 * END: Disable Responsive Images
 */

/*
 * Turns off the responsive images
 * @param $sources
 *
 * @return bool
*/
function rone_disable_srcset( $sources ) {
	return false;
}

add_filter( 'wp_calculate_image_srcset', 'rone_disable_srcset' );





?>