;( function( $ ) {

	$( document ).ready(
		function() {
			$( "#wdaf-form" ).submit(
				function(event){
					event.preventDefault();

					var formData = $( this ).serialize()

					$.post(
						wdaf_ajax_object.ajaxurl,
						formData,
						function( response ) {
							console.log( response );
							var alertType = 'alert-error';
							if (response.success) {
								alertType = 'alert-success';
							}
							$( "#wdaf-form" ).append( '<div class="alert ' + alertType + '" role="alert">' + response.data + '</div>' );

						}
					)
						.fail(
							function () {
								$( "#wdaf-form" ).append( '<div class="alert alert-error" role="alert">' + wdaf_ajax_object.error + '</div>' );
							}
						);

				}
			);

		}
	);

})( jQuery );
