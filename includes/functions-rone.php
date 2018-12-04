<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Raging One functions
 */

/*
 * Will add et page builder to RO Resources custom post type
 * @link: https://www.elegantthemes.com/blog/divi-resources/how-to-add-the-divi-builder-to-custom-post-types-divi-nation-short
 *
 * PLEASE NOTE ADD this styling
 *
 *  Replace “POST_TYPE” with the slug for your new CPT created with CPTUI.
    .et_pb_pagebuilder_layout.single-POST_TYPE #page-container .et_pb_row {
        width: 100%;
    }
    .et_pb_pagebuilder_layout.single-POST_TYPE #page-container .et_pb_with_background .et_pb_row {
        width: 80%;
    }
 *
*/

function rone_custom_post_types_addto_et_builder( $post_types ) {
	$post_types[] = 'resources';
	//$post_types[] = 'ANOTHER_CPT_HERE';

	return $post_types;
}
add_filter( 'et_builder_post_types', 'rone_custom_post_types_addto_et_builder' );



/**
 * for the RO Resources Plugin
 */
if ( ! function_exists( 'et_pb_resources_meta_box' ) ) :
	function et_pb_resources_meta_box() {
		global $post;

		$cpt_post_cf = get_post_custom_values("rone_resource_link_url");
		?>

		<div class="et_project_meta">

			<span class="published"><?php echo esc_html__( 'Posted on', 'Divi' ); ?> <?php echo get_the_date(); ?> </span> |

			<?php echo get_the_term_list( get_the_ID(), 'resource-categories', '', ', ' ); ?>
			<!--
			<span class="published"><?php echo esc_html__( 'Visit', 'Divi' ); ?>: <a href="<?php echo get_metadata("post",$post->ID,"rone_resource_link_url",true);?>" target="_blank" > <?php echo $post->ID; the_title();?></a></span>
			-->
			<p>
				<span class="published">
					<?php echo esc_html__( 'Visit', 'Divi' ); ?>: <a href="<?php echo $cpt_post_cf[0]?>" target="_blank" > <?php the_title();?></a>
				</span>
			</p>


		</div>
	<?php }
endif;


?>