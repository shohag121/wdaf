;(function($) {

	$( 'table.wp-list-table.applicants' ).on(
		'click',
		'a.submitdelete',
		function(e) {
			e.preventDefault();

			if ( ! confirm( wdaf_ajax_object.confirm )) {
				return;
			}

			var self = $( this ),
			id       = self.data( 'id' );
			wp.ajax.post(
				'wdaf_handle_delete',
				{
					id: id,
					_wpnonce: wdaf_ajax_object.nonce
				}
			)
			.done(
				function(response) {

					self.closest( 'tr' )
					.css( 'background-color', 'red' )
					.hide(
						400,
						function() {
							$( this ).remove();
						}
					);

				}
			)
			.fail(
				function() {
					alert( wdaf_ajax_object.error );
				}
			);
		}
	);

})( jQuery );
