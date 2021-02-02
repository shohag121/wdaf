<?php


namespace Shohag\Applicant\Form\Frontend;

/**
 * Class Shortcode
 *
 * @package Shohag\Applicant\Form\Frontend
 */
class Shortcode {

	/**
	 * Shortcode constructor.
	 */
	public function __construct() {
		add_shortcode( 'applicant_form', array( $this, 'render_shortcode' ) );
	}

	/**
	 * Render the shortcode in frontend.
	 *
	 * @return string
	 */
	public function render_shortcode() {
		wp_enqueue_style( 'wdafcssbs' );
		wp_enqueue_script( 'wdafjsbs' );
		wp_enqueue_script( 'wdafjsfibmit' );
		ob_start();
		?>
		<form name="wdaf-form" id="wdaf-form">
			<?php wp_nonce_field( 'wdaf_handle_submit' ); ?>
			<input type="hidden" name="action" value="wdaf_handle_submit">
			<div class="form-group">
				<label for="first_name"><?php esc_html_e( 'First Name', 'wdaf' ); ?></label>
				<input type="text" class="form-control" id="first_name" name="first_name" aria-describedby="fnameHelp" placeholder="<?php esc_attr_e( 'Enter First Name', 'wdaf' ); ?>">
				<small id="fnameHelp" class="form-text text-muted"><?php esc_html_e( 'Your First Name.', 'wdaf' ); ?></small>
			</div>
			<div class="form-group">
				<label for="last_name"><?php esc_html_e( 'Last Name', 'wdaf' ); ?></label>
				<input type="text" class="form-control" id="last_name" required name="last_name" aria-describedby="lnameHelp" placeholder="<?php esc_attr_e( 'Enter Last Name', 'wdaf' ); ?>">
				<small id="lnameHelp" class="form-text text-muted"><?php esc_html_e( 'Your Last Name.', 'wdaf' ); ?></small>
			</div>
			<div class="form-group">
				<label for="email"><?php esc_html_e( 'Email address', 'wdaf' ); ?></label>
				<input type="email" class="form-control" required id="email" name="email" aria-describedby="emailHelp" placeholder="<?php esc_attr_e( 'Enter email', 'wdaf' ); ?>">
				<small id="emailHelp" class="form-text text-muted"><?php esc_html_e( 'We will never share your email with anyone else.', 'wdaf' ); ?></small>
			</div>
			<div class="form-group">
				<label for="present_address"><?php esc_html_e( 'Present Address', 'wdaf' ); ?></label>
				<input type="text" class="form-control" id="present_address" name="present_address" aria-describedby="paddressHelp" placeholder="<?php esc_attr_e( 'Enter Present Address', 'wdaf' ); ?>">
				<small id="paddressHelp" class="form-text text-muted"><?php esc_html_e( 'Your Present Address.', 'wdaf' ); ?></small>
			</div>
			<div class="form-group">
				<label for="phone"><?php esc_html_e( 'Phone', 'wdaf' ); ?></label>
				<input type="text" class="form-control" id="phone" name="phone" aria-describedby="phoneHelp" placeholder="<?php esc_attr_e( 'Enter Phone Number', 'wdaf' ); ?>">
				<small id="phoneHelp" class="form-text text-muted"><?php esc_html_e( 'Your Phone Number.', 'wdaf' ); ?></small>
			</div>
			<div class="form-group">
				<label for="post_name"><?php esc_html_e( 'Post Name', 'wdaf' ); ?></label>
				<input type="text" class="form-control" id="post_name" name="post_name" aria-describedby="phoneHelp" placeholder="<?php esc_attr_e( 'Enter Desired Post', 'wdaf' ); ?>">
				<small id="phoneHelp" class="form-text text-muted"><?php esc_html_e( 'Your Desired Post.', 'wdaf' ); ?></small>
			</div>
			<div class="custom-file form-group ">
				<label for="cv"><?php esc_html_e( 'Upload Your CV', 'wdaf' ); ?></label>
				<input type="file" class="custom-file-input" id="cv" name="cv">
				<label class="custom-file-label" for="cv"><?php esc_html_e( 'Upload Your CV', 'wdaf' ); ?></label>
			</div>
			<div class="form-group">
				<button type="submit" id="wdaf-form-submit" class="btn btn-primary"><?php esc_html_e( 'Submit', 'wdaf' ); ?></button>
			</div>
		</form>
		<?php
		return ob_get_clean();
	}
}
