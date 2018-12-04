<?php



if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



/**
 * Private Note
 * https://code.rohitink.com/2017/11/30/add-wysiwyg-editor-textarea-custom-meta-box-wordpress/
 */

function ronepn_add_meta_box() {
	add_meta_box( 'rone-pn-meta', __( 'Private Notes', 'text-domain' ), 'ronepn_meta_html', 'post', //Post Type
		'normal', //Location
		'high' //Priority
	);
}

add_action( 'add_meta_boxes', 'ronepn_add_meta_box', 1 );

function ronepn_meta_html2( $post ) {
	wp_nonce_field( '_rone_pn_meta_nonce', 'rone_pn_meta_nonce' ); ?>
	<p>
		<!--
        <label for="rrone-privatenote"><?php _e( 'Note', 'text-domain' ); ?></label><br>
        -->
		<textarea name="rone_privatenote" id="rone_privatenote"><?php echo ronepn_get_meta( 'rone_privatenote' ); ?>"></textarea>
	</p>
<? } //endfunction

function ronepn_meta_html( $post ) {

	wp_nonce_field( '_rone_pn_meta_nonce', 'rone_pn_meta_nonce' ); ?>
	<!--
    <p><label for="rone-privatenote"><?php _e( 'Note', 'text-domain' ); ?></label></p><br>
    -->
	<?php
	$meta_content = wpautop( ronepn_get_meta( 'rone_privatenote' ), true );
	wp_editor( $meta_content, 'rone_privatenote', array(
		'wpautop'       => true,
		'media_buttons' => false,
		'textarea_name' => 'rone_privatenote',
		'textarea_rows' => 10,
		'teeny'         => false
	) );
	?>
<? } //endfunction


function ronepn_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function ronepn_meta_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['rone_privatenote'] ) || ! wp_verify_nonce( $_POST['rone_pn_meta_nonce'], '_rone_pn_meta_nonce' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['rone_privatenote'] ) ) {
		update_post_meta( $post_id, 'rone_privatenote', esc_attr( $_POST['rone_privatenote'] ) );
	}
}

add_action( 'save_post', 'ronepn_meta_save' );



?>