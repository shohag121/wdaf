<?php


namespace Shohag\Applicant\Form\Admin;

use Shohag\Applicant\Form\Data\Persistence;

/**
 * Class HandleDelete.
 *
 * @package Shohag\Applicant\Form\Admin
 */
class HandleDelete {
	/**
	 * HandleDelete constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_wdaf_handle_delete', array( $this, 'handle' ) );
	}

	/**
	 * Handle submission delete.
	 */
	public function handle() {
		wp_verify_nonce( 'wdaf_handle_delete' );

		$id      = $_REQUEST['id'];
		$deleted = Persistence::delete( $id );
		if ( $deleted ) {
			wp_send_json_success();
		} else {
			wp_send_json_error();
		}
	}
}
