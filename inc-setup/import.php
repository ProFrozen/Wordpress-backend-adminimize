<?php
/**
 * Import settings as json file.
 *
 * @package    Adminimize
 * @subpackage import
 * @author     Frank Bültge
 * @version    2017-04-13
 */

if ( ! function_exists( 'add_action' ) ) {
	echo "Hi there!  I'm just a part of plugin, not much I can do when called directly.";
	exit;
}

add_action( 'admin_init', '_mw_adminimize_import_json' );
/**
 * Process a settings import from a json file.
 */
function _mw_adminimize_import_json() {

	if ( ! is_admin() ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// If is AJAX Call.
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return;
	}

	if ( empty( $_POST[ '_mw_adminimize_action' ] ) || '_mw_adminimize_import' !== $_POST[ '_mw_adminimize_action' ] ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST[ 'mw_adminimize_import_nonce' ], 'mw_adminimize_import_nonce' ) ) {
		return;
	}

	$path      = esc_attr( $_FILES[ 'import_file' ][ 'tmp_name' ] );
	$type      = (string) esc_attr( $_FILES[ 'import_file' ][ 'type' ] );
	$tmp       = explode( '/', $type );
	$extension = end( $tmp );

	if ( 'json' !== $extension ) {
		wp_die(
			sprintf(
				esc_attr__( 'Please upload a valid .json file, Extension check. Your file have the extension %s.', 'adminimize' ),
				$extension
			)
		);
	}

	/**
	 * Check for a valid json file, alternate for the extension check.
	 *
	if ( json_decode($path, true, 32 ) === null || json_last_error() === JSON_ERROR_NONE ) {
		wp_die(
			sprintf(
				esc_attr__( 'Please upload a valid .json file, Extension check. Your file have the extension %s.', 'adminimize' ),
				$extension
			)
		);
	}*/

	if ( empty( $path ) || ! is_readable( $path ) ) {
		wp_die(
			sprintf(
				esc_attr__( 'It is not possible to find a file in %s', 'adminimize' ),
				$path
			)
		);
	}

	// Retrieve the settings from the file and convert the json object to an array.
	$settings = (array) json_decode(
		file_get_contents( $path )
	);
	unlink( $path );

	_mw_adminimize_update_option( $settings );
}
