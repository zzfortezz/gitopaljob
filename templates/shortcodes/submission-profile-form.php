<div class="profile-submission-form">
	<?php if( !$post_id ) : ?>
	<h1><?php _e( "Company", 'opaljob' ); ?></h1>
	<?php else : ?>
	<h1><?php _e( "Edit Company Info", 'opaljob' ) ; ?></h1>
	<?php endif;  ?>
	<?php 
	// echo '<pre>'.print_r( $metaboxes ,1 );die;
			do_action( 'opaljob_submission_profile_form_before' );
			echo cmb2_get_metabox_form( $metaboxes[ OPALJOB_COMPANY_PREFIX . 'front' ], $post_id, array(
				'form_format2' => '<form action="//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<input type="submit" name="submit-cmb" value="%4$s" class="button-primary btn btn-primary"></form>',
				'save_button' => __( 'Save profile', 'opaljob' ),
			) );

			do_action( 'opaljob_submission_profile_form_after' );
	?>
</div>