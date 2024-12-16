( function ( $ ) {
	const surecartBBScript = {
		init() {
      $( 'body' ).on( 'click', '.surecart-edit-bb-form', function ( e ) {
        let formID = $('#fl-field-sc_form_id select').val();
        const editLink = "/wp-admin/post.php?post=" + formID + "&action=edit";

        if ( formID ) {
          let win = window.open(
            editLink,
            '_blank'
          );
          win.focus();
        } else {
          return false;
        }
			} );

      surecartBBScript.setEditLink();

      $( 'body' ).on( 'change', '#fl-field-sc_form_id select', function ( e ) {
        surecartBBScript.setEditLink();
			} );
    },

    /**
		 * Set edit link
		 *
		 * @since x.x.x
		 */
		setEditLink: () => {
      let formID = $('#fl-field-sc_form_id select').val();

      if ( formID ) {
        const editLink = "/wp-admin/post.php?post=" + formID + "&action=edit";
        $(".surecart-edit-bb-form").show();
        $(".surecart-edit-bb-form").attr('href', editLink);
      }
		},
  };
  
  $( function () {
		  surecartBBScript.init();
	} );
} )( jQuery );
