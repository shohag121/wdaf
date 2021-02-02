<?php


namespace Shohag\Applicant\Form\Frontend;

use Shohag\Applicant\Form\Data\Persistence;

/**
 * Class HandleFormSubmission
 *
 * @package Shohag\Applicant\Form\Frontend
 */
class HandleFormSubmission {

	/**
	 * HandleFormSubmission constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_nopriv_wdaf_handle_submit', array( $this, 'handle' ) );
		add_action( 'wp_ajax_wdaf_handle_submit', array( $this, 'handle' ) );
	}

	/**
	 * Handle the Ajax form Response.
	 */
	public function handle() {

		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'wdaf_handle_submit' ) ) {
			wp_send_json_error( 'Nonce Verification error!' );
		}

		$submission_id = Persistence::save( $_REQUEST );
		if ( $submission_id ) {
			if ( isset( $data['email'] ) ) {
				wp_mail( $data['email'], __( 'Submission Confirmation', 'wdaf' ), __( 'We have successfully Received your Request!', 'wdaf' ) );
			}
			wp_send_json_success( __( 'Data Submitted Successfully!', 'wdaf' ) );
		} else {
			wp_send_json_error( __( 'Data Save Error!', 'wdaf' ) );

		}

	}
}
