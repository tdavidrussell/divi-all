<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *    This will hide the "Project" post type.
 *    Thanks to georgiee (https://gist.github.com/EngageWP/062edef103469b1177bc#gistcomment-1801080) for his improved solution.
 */
add_filter( 'et_project_posttype_args', 'rone_et_project_posttype_args', 10, 1 );
function rone_et_project_posttype_args( $args ) {
	return array_merge( $args, array(
		'public'              => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => false,
		'show_in_nav_menus'   => false,
		'show_ui'             => false
	) );
}



?>