<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}




/**
 * Add the feature image to the post admin page.
 *
 * https://premium.wpmudev.org/blog/easy-featured-images/
 * https://wordpress.org/plugins/featured-image-column/
 * https://wordpress.stackexchange.com/questions/111183/post-featured-image-column-on-admin-post-list-page
 * http://www.wpbeginner.com/plugins/how-to-add-a-featured-image-column-to-your-wordpress-admin-panel/
 *
 * // these two link is where the code is.
 * @link https://github.com/robincornett/add-featured-image-column
 * @link https://robincornett.com/featured-image-column/
 */
add_filter( 'manage_posts_columns', 'rone_posts_columns', 5 );
add_action( 'manage_posts_custom_column', 'rone_posts_custom_columns', 5, 2 );
function rone_posts_columns( $columns ) {
	$new_columns = $columns;
	array_splice( $new_columns, 1 );
	$new_columns['featured_image'] = __( 'Featured Image', 'add-featured-image-column' );

	return array_merge( $new_columns, $columns );
}

function rone_posts_custom_columns( $column_name, $id ) {

	if ( $column_name === 'featured_image' ) {
		if ( has_post_thumbnail() ) {
			//echo the_post_thumbnail( 'thumbnail' );
			//https://developer.wordpress.org/reference/functions/get_the_post_thumbnail/ SEE COMMENTS
			echo preg_replace( '/(width|height)=\"\d*\"\s/', "", get_the_post_thumbnail() );

		} else {
			echo "N/A";
		}
	}
}


add_action( 'admin_enqueue_scripts', 'rone_featured_image_column_width' );
/**
 * Creates an inline stylesheet to set featured image column width
 */

function rone_featured_image_column_width() {
	$screen = get_current_screen();
	if ( ! post_type_supports( $screen->post_type, 'thumbnail' ) ) {
		return;
	}
	if ( in_array( $screen->base, array( 'edit' ), true ) ) { ?>
		<style type="text/css">

			.column-featured_image {
				width: 200px;
			}

			.column-featured_image img {
				margin: 0 auto;
				height: auto;
				width: auto;
				max-width: 200px;
			}

			@media screen and (max-width: 782px) {
				.column-featured_image {
					display: table-cell !important;
					width: 52px;
				}

				.column-featured_image img {
					margin: 0;
					max-width: 42px;
				}
			}
		</style> <?php
	}

}


?>