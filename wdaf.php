<?php
/**
 * WeDevs Submission Form
 *
 * @package           WDAF
 * @author            Shazahanul Islam Shohag
 * @copyright         2021 Shazahanul Islam Shohag
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       weDevs Submission Form
 * Plugin URI:        https://sis.trade/wdaf
 * Description:       This plugin generate a application form and store the submissions in to db.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shazahanul Islam Shohag
 * Author URI:        https://sis.trade
 * Text Domain:       wdaf
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


use Shohag\Applicant\Form\Admin\AdminPage;
use Shohag\Applicant\Form\Admin\DashboardWidgets;
use Shohag\Applicant\Form\Admin\HandleDelete;
use Shohag\Applicant\Form\Frontend\HandleFormSubmission;
use Shohag\Applicant\Form\Frontend\Shortcode;
use Shohag\Applicant\Form\Install;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
} else {
	return;
}

/**
 * Class WDAF
 */
final class WDAF {

	const VERSION = '1.0.0';

	/**
	 * WDAF constructor.
	 */
	private function __construct() {
		$this->define_constants();
		register_activation_hook( __FILE__, array( $this, 'plugin_activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'plugin_deactivate' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		$this->run_functionality();
	}

	/**
	 * Get the instance of the class.
	 *
	 * @return WDAF
	 */
	public static function get_instance() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Define all the constants
	 */
	public function define_constants() {
		define( 'WDAF_VERSION', self::VERSION );
		define( 'WDAF_FILE', __FILE__ );
		define( 'WDAF_PATH', __DIR__ );
		define( 'WDAF_ASSETS', plugins_url( '', WDAF_FILE ) . '/assets' );
	}

	/**
	 * Define all the plugin assets
	 */
	public function enqueue_scripts() {
		wp_register_style( 'wdafcssbs', WDAF_ASSETS . '/css/bootstrap.min.css', false, filemtime( WDAF_PATH . '/assets/css/bootstrap.min.css' ) );
		wp_register_script( 'wdafjsbs', WDAF_ASSETS . '/js/bootstrap.min.js', array( 'jquery' ), filemtime( WDAF_PATH . '/assets/js/bootstrap.min.js' ), true );
		wp_register_script( 'wdafjsfibmit', WDAF_ASSETS . '/js/form-submit.js', array( 'jquery' ), filemtime( WDAF_PATH . '/assets/js/form-submit.js' ), true );
		wp_localize_script(
			'wdafjsfibmit',
			'wdaf_ajax_object',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'error'   => __( 'Something went wrong!', 'wdaf' ),
			)
		);
	}
	/**
	 * Define all the plugin assets related to admin
	 */
	public function admin_enqueue_scripts() {
		wp_register_style( 'wdafadmincssbs', WDAF_ASSETS . '/css/bootstrap.min.css', false, filemtime( WDAF_PATH . '/assets/css/bootstrap.min.css' ) );

		wp_register_script( 'wdafadminjs', WDAF_ASSETS . '/js/admin.js', array( 'jquery', 'wp-util' ), filemtime( WDAF_PATH . '/assets/js/admin.js' ), true );
		wp_localize_script(
			'wdafadminjs',
			'wdaf_ajax_object',
			array(
				'nonce'   => wp_create_nonce( 'wdaf_applicants_nonce' ),
				'confirm' => __( 'Are you sure?', 'wdaf' ),
				'error'   => __( 'Something went wrong!', 'wdaf' ),
			)
		);
	}

	/**
	 * Run all the plugin functionality.
	 */
	private function run_functionality() {
		if ( is_admin() ) {
			new AdminPage();
			new DashboardWidgets();
		}
		new Shortcode();

		if ( wp_doing_ajax() ) {
			new HandleFormSubmission();
			new HandleDelete();
		}

	}

	/**
	 * Plugin Install function.
	 */
	public function plugin_activate() {
		$install = new Install();
		$install->run();
	}

	/**
	 * Deactivation Code.
	 */
	public function plugin_deactivate() {
		// run code.
	}


}

WDAF::get_instance();
