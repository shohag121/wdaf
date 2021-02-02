<?php


namespace Shohag\Applicant\Form\Data;

/**
 * Class Persistence
 *
 * @package Shohag\Applicant\Form\Data
 */
class Persistence {

	/**
	 * Save the data to DB.
	 *
	 * @param array $data_array Submitted Data Array.
	 *
	 * @return int
	 */
	public static function save( $data_array ) {

		// TODO: need to handle cv file upload to wp media.
		global $wpdb;
		$table  = $wpdb->prefix . 'applicant_submissions';
		$data   = array(
			'first_name'      => isset( $data_array['first_name'] ) ? sanitize_text_field( $data_array['first_name'] ) : '',
			'last_name'       => isset( $data_array['last_name'] ) ? sanitize_text_field( $data_array['last_name'] ) : '',
			'present_address' => isset( $data_array['present_address'] ) ? sanitize_text_field( $data_array['present_address'] ) : '',
			'email'           => isset( $data_array['email'] ) ? sanitize_text_field( $data_array['email'] ) : '',
			'phone'           => isset( $data_array['phone'] ) ? sanitize_text_field( $data_array['phone'] ) : '',
			'post_name'       => isset( $data_array['post_name'] ) ? sanitize_text_field( $data_array['post_name'] ) : '',
		);
		$format = array( '%s', '%s', '%s', '%s', '%s', '%s' );
		$wpdb->insert( $table, $data, $format );

		// TODO: reset object cache.

		return $wpdb->insert_id;
	}

	/**
	 * Get the submission.
	 *
	 * @param array $args
	 *
	 * @return array|object|null
	 */
	public static function get( $args = array() ) {
		global $wpdb;

		$defaults = array(
			'number'  => 20,
			'offset'  => 0,
			'orderby' => 'id',
			'order'   => 'ASC',
		);

		$args = wp_parse_args( $args, $defaults );

		$sql = $wpdb->prepare(
			"SELECT * FROM {$wpdb->prefix}applicant_submissions
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d",
			$args['offset'],
			$args['number']
		);

		$items = $wpdb->get_results( $sql );

		return $items;
	}

	/**
	 * Delete Submission.
	 *
	 * @param $id
	 *
	 * @return bool|int
	 */
	public static function delete( $id ) {
		global $wpdb;

		return $wpdb->delete(
			$wpdb->prefix . 'applicant_submissions',
			array( 'id' => $id )
		);
	}

	/**
	 * Get submission count.
	 *
	 * @return int
	 */
	public static function count() {
		global $wpdb;

		return (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}applicant_submissions" );
	}
}
