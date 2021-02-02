<?php


namespace Shohag\Applicant\Form\Admin;

use Shohag\Applicant\Form\Data\Persistence;

/**
 * Class DashboardWidgets.
 *
 * @package Shohag\Applicant\Form\Admin
 */
class DashboardWidgets {
	/**
	 * DashboardWidgets constructor.
	 */
	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'submission_widgets' ) );
	}

	/**
	 * Add Applicants widgets.
	 */
	public function submission_widgets() {
		wp_add_dashboard_widget( 'wdaf_dashboard_widget_applicant', __( 'Applicants', 'wdaf' ), array( $this, 'submission_widgets_handler' ) );
	}

	/**
	 * Handle Applicant widget display.
	 */
	public function submission_widgets_handler() {
		wp_enqueue_style( 'wdafadmincssbs' );

		$entries = Persistence::get(
			array(
				'limit' => 5,
				'order' => 'DESC',
			)
		);

		ob_start();
		?>
		<table class="table">
			<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col"><?php esc_html_e( 'First Name', 'wdaf' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Last Name', 'wdaf' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Email', 'wdaf' ); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php
			if ( ! empty( $entries ) ) :
				foreach ( $entries as $key => $entry ) :
					?>
			<tr>
				<th scope="row"><?php esc_html_e( $key ); ?></th>
				<td><?php esc_html_e( $entry->first_name ); ?></td>
				<td><?php esc_html_e( $entry->last_name ); ?></td>
				<td><?php esc_html_e( $entry->email ); ?></td>
			</tr>
					<?php
				endforeach;
			endif;
			?>
			</tbody>
		</table>
		<?php
		echo ob_get_clean();
	}
}
