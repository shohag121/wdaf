<?php


namespace Shohag\Applicant\Form\Admin;

use Shohag\Applicant\Form\Data\Persistence;
use WP_List_Table;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Application_List_Table extends WP_List_Table {

	/**
	 * Application_List_Table constructor.
	 */
	public function __construct() {
		parent::__construct(
			array(
				'singular' => 'applicant',
				'plural'   => 'applicants',
				'ajax'     => false,
			)
		);
	}

	/**
	 * Message to show if no designation found
	 *
	 * @return void
	 */
	public function no_items() {
		esc_html_e( 'No address found', 'wdaf' );
	}

	/**
	 * Get the column names
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'cb'              => '<input type="checkbox" />',
			'first_name'      => __( 'First Name', 'wdaf' ),
			'last_name'       => __( 'Last Name', 'wdaf' ),
			'email'           => __( 'Email', 'wdaf' ),
			'present_address' => __( 'Address', 'wdaf' ),
			'phone'           => __( 'Phone', 'wdaf' ),
			'created_date'    => __( 'Date', 'wdaf' ),
		);
	}

	/**
	 * Get sortable columns
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'first_name'   => array( 'first_name', true ),
			'last_name'    => array( 'last_name', true ),
			'created_date' => array( 'created_date', true ),
		);

		return $sortable_columns;
	}

	/**
	 * Set the bulk actions
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = array(
			'trash' => __( 'Move to Trash', 'wdaf' ),
		);

		return $actions;
	}

	/**
	 * Default column values
	 *
	 * @param  object $item
	 * @param  string $column_name
	 *
	 * @return string
	 */
	protected function column_default( $item, $column_name ) {

		switch ( $column_name ) {

			case 'created_date':
				return wp_date( get_option( 'date_format' ), strtotime( $item->created_date ) );

			default:
				return isset( $item->$column_name ) ? $item->$column_name : '';
		}
	}

	/**
	 * Render the "first_name" column
	 *
	 * @param  object $item
	 *
	 * @return string
	 */
	public function column_first_name( $item ) {
		$actions = array();

		$actions['delete'] = sprintf( '<a href="#" class="submitdelete" data-id="%s">%s</a>', $item->id, __( 'Delete', 'wdaf' ) );
		return sprintf(
			'<strong>%1$s</strong> %2$s',
			$item->first_name,
			$this->row_actions( $actions )
		);
	}

	/**
	 * Render the "cb" column
	 *
	 * @param  object $item
	 *
	 * @return string
	 */
	protected function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="submission_id[]" value="%d" />',
			$item->id
		);
	}

	/**
	 * Prepare the address items
	 *
	 * @return void
	 */
	public function prepare_items() {
		$column   = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array( $column, $hidden, $sortable );

		$per_page     = 20;
		$current_page = $this->get_pagenum();
		$offset       = ( $current_page - 1 ) * $per_page;

		$args = array(
			'number' => $per_page,
			'offset' => $offset,
		);

		if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
			$args['orderby'] = $_REQUEST['orderby'];
			$args['order']   = $_REQUEST['order'];
		}

		$this->items = Persistence::get( $args );

		$this->set_pagination_args(
			array(
				'total_items' => Persistence::count(),
				'per_page'    => $per_page,
			)
		);
	}
}
