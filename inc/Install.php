<?php


namespace Shohag\Applicant\Form;

/**
 * Class Install
 * @package Shohag\Applicant\Form
 */
class Install {
	/**
	 * Install constructor.
	 */
	public function __construct() {
	}

	/**
	 * Install functionality.
	 *
	 * @return void
	 */
	public function run() {
		$this->set_installed_time();
		$this->create_tables();
	}

	/**
	 * Set Plugin First Installed Time.
	 *
	 * @return void
	 */
	private function set_installed_time() {
		$installed_time = get_option( 'wdaf_installed' );
		if ( ! $installed_time ) {
			update_option( 'wdaf_installed', time() );
		}
	}

	/**
	 * Create necessary database tables.
	 *
	 * @return void
	 */
	private function create_tables() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$schema          = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}applicant_submissions` (
							  `id` int unsigned NOT NULL AUTO_INCREMENT,
							  `first_name` varchar(100)  DEFAULT NULL,
							  `last_name` varchar(100)  DEFAULT NULL,
							  `present_address` text ,
							  `email` varchar(150)  DEFAULT NULL,
							  `phone` varchar(20)  DEFAULT NULL,
							  `post_name` varchar(150)  DEFAULT NULL,
							  `cv` int DEFAULT NULL,
							  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
							  PRIMARY KEY (`id`)
							) {$charset_collate}";

		if ( ! function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . '/wp-admin/includes/upgrade.php';
		}
		dbDelta( $schema );
	}
}
