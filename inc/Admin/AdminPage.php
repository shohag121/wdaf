<?php


namespace Shohag\Applicant\Form\Admin;

/**
 * Class AdminPage
 *
 * @package Shohag\Applicant\Form\Admin
 */
class AdminPage {
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	public function admin_menu() {
		add_menu_page(
			__( 'Applicants', 'wdaf' ),
			__( 'Applicants' ),
			'manage_options',
			'wdaf_applicants',
			array( $this, 'render_page' ),
			'dashicons-media-spreadsheet',
			6
		);
		add_submenu_page(
			'wdaf_applicants',
			__( 'Applicants', 'wdaf' ),
			__( 'All Submission', 'wdaf' ),
			'manage_options',
			'wdaf_applicants',
			array( $this, 'render_page' ),
			1
		);
	}

	public function render_page() {
		wp_enqueue_script( 'wdafadminjs' );
		ob_start();
		?>
		<div class="wrap">
			<h1 class="wp-heading-inline"><?php esc_html_e( 'All Applicants', 'wdaf' ); ?></h1>
			<form action="" method="post">
				<?php
				$table = new Application_List_Table();
				$table->prepare_items();
				$table->search_box( 'search', 'search_id' );
				$table->display();
				?>
			</form>
		</div>
		<?php
		echo ob_get_clean();
	}
}
