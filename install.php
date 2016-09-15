<?php 

function opaljob_install(){


	global $opaljob_options;
 

	// Clear the permalinks
	flush_rewrite_rules( false );

	// Add Upgraded From Option
	$current_version = get_option( 'opaljob_version' );
	if ( $current_version ) {
		update_option( 'opaljob_version_upgraded_from', $current_version );
	}

	// Setup some default options
	$options = array();

	// Checks if the Success Page option exists AND that the page exists
	if ( ! get_post( opaljob_get_option( 'submission_page' ) ) ) {

		// Purchase Confirmation (Success) Page
		$submission_page = wp_insert_post(
			array(
				'post_title'     => __( 'Confirmation Page', 'opaljob' ),
				'post_content'   => __( '[opaljob_submission]', 'opaljob' ),
				'post_status'    => 'publish',
				'post_author'    => 1,
				'post_type'      => 'page',
				'comment_status' => 'closed'
			)
		);

		// Store our page IDs
		$options['submission_page'] = $submission_page;
	}
 	

	//Fresh Install? Setup Test Mode, Base Country (US), Test Gateway, Currency
	if ( empty( $current_version ) ) {
	
		$options['test_mode']          = 1;
		$options['currency']           = 'USD';
		$options['currency_position']  = 'before';
		
		$options['sq ft']              = 'sq ft';	
	}

	// Populate some default values
	update_option( 'opaljob_settings', array_merge( $opaljob_options, $options ) );
	update_option( 'opaljob_version', GIVE_VERSION );

	 
	// Create Give roles
	$roles = new Opaljob_Roles();
	$roles->add_roles();
	$roles->add_caps();
 
	// Add a temporary option to note that Give pages have been created
	set_transient( '_opaljob_installed', $options, 30 );

 
	// Bail if activating from network, or bulk
	if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	}
	// Add the transient to redirect
	set_transient( '_opaljob_activation_redirect', true, 30 );

}
	

/**
 * Install user roles on sub-sites of a network
 *
 * Roles do not get created when Give is network activation so we need to create them during admin_init
 *
 * @since 1.0
 * @return void
 */
function opaljob_install_roles_on_network() {

	global $wp_roles;

	if ( ! is_object( $wp_roles ) ) {
		return;
	}
 
	if ( ! array_key_exists( 'opaljob_manager', $wp_roles->roles ) ) {
		
 
		$roles = new Opaljob_Roles;
		$roles->add_roles();
		$roles->add_caps();

	}else {  
	//	remove_role( 'opaljob_manager' );
	//  remove_role( 'opaljob_manager' );
	//	$roles = new Opaljob_Roles;
	//	$roles->remove_caps();
	}
}

function opaljob_create_pages() {

	$job_list_page = opaljob_get_option( 'submission_list_page' );
	$update = false;

	if ( empty( $job_list_page ) ) {

		$list_args = array(
			'post_content'   => '[opaljob_submission_list]',
			'post_title'     => wp_strip_all_tags( __( 'Opal List Job', 'opalticket' ) ),
			'post_name'      => sanitize_title( __( 'Opal List Job', 'opalticket' ) ),
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'ping_status'    => 'closed',
			'comment_status' => 'closed'
		);

		$list = wp_insert_post( $list_args, true );

		if ( !is_wp_error( $list ) && is_int( $list ) ) {
			opaljob_update_option( 'submission_list_page', $list );
			$update = true;
		}
	}

	$job_submission_page = opaljob_get_option( 'submission_page' );
	if ( empty( $job_submission_page ) ) {

		$submit_args = array(
			'post_content'   => '[opaljob_submission]',
			'post_title'     => wp_strip_all_tags( __( 'Opal Post job', 'opaljob' ) ),
			'post_name'      => sanitize_title( __( 'Opal Post job', 'opaljob' ) ),
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'ping_status'    => 'closed',
			'comment_status' => 'closed'
		);
	
		$submit = wp_insert_post( $submit_args, true );

		if ( !is_wp_error( $submit ) && is_int( $submit ) ) {
			opaljob_update_option( 'submission_page', $submit );
			$update = true;
		}
	}

	$job_submission_profile_page = opaljob_get_option( 'submission_profile_page' );
	if ( empty( $job_submission_profile_page ) ) {

		$submit_args = array(
			'post_content'   => '[opaljob_submission_profile]',
			'post_title'     => wp_strip_all_tags( __( 'Opal Profile', 'opaljob' ) ),
			'post_name'      => sanitize_title( __( 'Opal Profile', 'opaljob' ) ),
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'ping_status'    => 'closed',
			'comment_status' => 'closed'
		);
	
		$submit = wp_insert_post( $submit_args, true );

		if ( !is_wp_error( $submit ) && is_int( $submit ) ) {
			opaljob_update_option( 'submission_profile_page', $submit );
			$update = true;
		}
	}

	$job_submission_resume_page = opaljob_get_option( 'submission_resume_page' );
	if ( empty( $job_submission_resume_page ) ) {

		$submit_args = array(
			'post_content'   => '[opaljob_submission_resume]',
			'post_title'     => wp_strip_all_tags( __( 'Opal Post Resume', 'opaljob' ) ),
			'post_name'      => sanitize_title( __( 'Opal Post Resume', 'opaljob' ) ),
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'ping_status'    => 'closed',
			'comment_status' => 'closed'
		);
	
		$submit = wp_insert_post( $submit_args, true );

		if ( !is_wp_error( $submit ) && is_int( $submit ) ) {
			opaljob_update_option( 'submission_resume_page', $submit );
			$update = true;
		}
	}

	$job_submission_list_resume_page = opaljob_get_option( 'submission_list_resume_page' );
	if ( empty( $job_submission_list_resume_page ) ) {

		$submit_args = array(
			'post_content'   => '[opaljob_submission_list_resume]',
			'post_title'     => wp_strip_all_tags( __( 'Opal List Resume', 'opaljob' ) ),
			'post_name'      => sanitize_title( __( 'Opal List Resume', 'opaljob' ) ),
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'ping_status'    => 'closed',
			'comment_status' => 'closed'
		);
	
		$submit = wp_insert_post( $submit_args, true );

		if ( !is_wp_error( $submit ) && is_int( $submit ) ) {
			opaljob_update_option( 'submission_list_resume_page', $submit );
			opaljob_update_option( 'submission_edit_resume_page', $submit );
			$update = true;
		}
	}

	$job_submission_job_apply_page = opaljob_get_option( 'submission_job_apply_page' );
	if ( empty( $job_submission_job_apply_page ) ) {

		$submit_args = array(
			'post_content'   => '[opaljob_submission_job_apply]',
			'post_title'     => wp_strip_all_tags( __( 'Opal Job Apply', 'opaljob' ) ),
			'post_name'      => sanitize_title( __( 'Opal Job Apply', 'opaljob' ) ),
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'ping_status'    => 'closed',
			'comment_status' => 'closed'
		);
	
		$submit = wp_insert_post( $submit_args, true );

		if ( !is_wp_error( $submit ) && is_int( $submit ) ) {
			opaljob_update_option( 'submission_job_apply_page', $submit );;
			$update = true;
		}
	}

	$job_submission_search_resume_result_page = opaljob_get_option( 'search_resume_page' );
	if ( empty( $job_submission_search_resume_result_page ) ) {

		$submit_args = array(
			'post_content'   => '[opaljob_search_resumes_result]',
			'post_title'     => wp_strip_all_tags( __( 'Opal Search Resume Result', 'opaljob' ) ),
			'post_name'      => sanitize_title( __( 'Opal Search Resume Result', 'opaljob' ) ),
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'ping_status'    => 'closed',
			'comment_status' => 'closed'
		);
	
		$submit = wp_insert_post( $submit_args, true );

		if ( !is_wp_error( $submit ) && is_int( $submit ) ) {
			opaljob_update_option( 'search_resume_page', $submit );;
			$update = true;
		}
	}

	$job_submission_search_work_result_page = opaljob_get_option( 'search_work_page' );
	if ( empty( $job_submission_search_work_result_page ) ) {

		$submit_args = array(
			'post_content'   => '[opaljob_search_works_result]',
			'post_title'     => wp_strip_all_tags( __( 'Opal Search Work Result', 'opaljob' ) ),
			'post_name'      => sanitize_title( __( 'Opal Search Work Result', 'opaljob' ) ),
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'ping_status'    => 'closed',
			'comment_status' => 'closed'
		);
	
		$submit = wp_insert_post( $submit_args, true );

		if ( !is_wp_error( $submit ) && is_int( $submit ) ) {
			opaljob_update_option( 'search_work_page', $submit );;
			$update = true;
		}
	}
	
	$submit_args = array(
		'post_content'   => '[opaljob_search_resumes]',
		'post_title'     => wp_strip_all_tags( __( 'Opal Search Resume', 'opaljob' ) ),
		'post_name'      => sanitize_title( __( 'Opal Search Resume', 'opaljob' ) ),
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'ping_status'    => 'closed',
		'comment_status' => 'closed'
	);

	$submit = wp_insert_post( $submit_args, true );

	$submit_args = array(
		'post_content'   => '[opaljob_search_works]',
		'post_title'     => wp_strip_all_tags( __( 'Opal Search Work', 'opaljob' ) ),
		'post_name'      => sanitize_title( __( 'Opal Search Work', 'opaljob' ) ),
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'ping_status'    => 'closed',
		'comment_status' => 'closed'
	);

	$submit = wp_insert_post( $submit_args, true );

	$submit_args = array(
		'post_content'   => '[opaljob_account]',
		'post_title'     => wp_strip_all_tags( __( 'Opal Account', 'opaljob' ) ),
		'post_name'      => sanitize_title( __( 'Opal Account', 'opaljob' ) ),
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'ping_status'    => 'closed',
		'comment_status' => 'closed'
	);

	$submit = wp_insert_post( $submit_args, true );
	

	$job_submission_list_wishlist_page= opaljob_get_option( 'submission_list_wishlist_page' );
	if ( empty( $job_submission_list_wishlist_page ) ) {

		$submit_args = array(
			'post_content'   => '[opaljob_submission_list_wishlist]',
			'post_title'     => wp_strip_all_tags( __( 'Opal List Save Work', 'opaljob' ) ),
			'post_name'      => sanitize_title( __( 'Opal List Save Work', 'opaljob' ) ),
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'ping_status'    => 'closed',
			'comment_status' => 'closed'
		);
	
		$submit = wp_insert_post( $submit_args, true );

		if ( !is_wp_error( $submit ) && is_int( $submit ) ) {
			opaljob_update_option( 'submission_list_wishlist_page', $submit );;
			$update = true;
		}
	}

	
	$current_user = wp_get_current_user();
	$args = array(
		'post_type' 	=> 'opaljob_company',
		'post_author'	=> 1,
		'post_status'	=> 'publish',
		'post_title'	=> $current_user->display_name,
	);
	$insert = wp_insert_post( $args, true );
	
	update_post_meta($insrt,OPALJOB_COMPANY_PREFIX .'email',$current_user->user_email);
	update_post_meta($insrt,OPALJOB_COMPANY_PREFIX .'user_meta_id',$current_user->ID);
}

add_action( 'admin_init', 'opaljob_install_roles_on_network' );	
?>