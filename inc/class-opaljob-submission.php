<?php 
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opaljob
 * @author     Opal  Team <opalwordpressl@gmail.com >
 * @copyright  Copyright (C) 2016 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}  
class Opaljob_Submission{
	
	/**
	 *
	 */
	static $shortcodes; 

	/**
	 *
	 */
	public static function init(){
	 	
	 	self::$shortcodes = array(
	 		'submission' 		   => array( 'code' => 'submission', 'label' 		   => __('Submission Form') ),
	 		'submission_resume' 		   => array( 'code' => 'submission_resume', 'label' 		   => __('Submission Resume Form') ),
	 		'submission_list' => array( 'code' => 'submission_list', 'label' => __('My Works') ),
	 		'submission_list_wishlist' => array( 'code' => 'submission_list_wishlist', 'label' => __('Save job') ),
	 		'submission_list_resume' => array( 'code' => 'submission_list_resume', 'label' => __('My Resume') ),
	 		'submission_profile' => array( 'code' => 'submission_profile', 'label' => __('My Profile') ),
	 		'submission_job_apply' => array( 'code' => 'submission_job_apply', 'label' => __('Job Apply') ),
	 	);

	 	foreach( self::$shortcodes as $shortcode ){
	 		add_shortcode( 'opaljob_'.$shortcode['code'] , array( __CLASS__, $shortcode['code'] ) );
	 	}

	 	if( self::is_submission_page() ){
	 		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_scripts' ) );
	 	}
	 	add_action ('wp_loaded', array( __CLASS__, 'submission_delete'));
	 	add_action ('wp_loaded', array( __CLASS__, 'submission_list_wishlist_remove'));
	 	add_filter( 'pre_get_posts', array( __CLASS__, 'show_current_user_attachments') );

	 	add_action( 'init', array( __CLASS__, 'process_submission' ), 10000 );
	}

 	public static function is_submission_page(){
 		return (false);
 	}

	/**
	 * FrontEnd Submission
	 */
	public static function show_current_user_attachments( $wp_query_obj ) {
	   
	    global $current_user, $pagenow;
 	 
	    if( !is_a( $current_user, 'WP_User') )
	        return;

	    if( !in_array( $pagenow, array( 'upload.php', 'admin-ajax.php' ) ))
	        return;

	    if( !empty($current_user->roles) ){
	    	if( in_array( "opaljob_company", $current_user->roles) ){
	    		 $wp_query_obj->set('author', $current_user->ID );
	    	}
	    }	 
	    return;
	}


	/**
	 * FrontEnd Submission
	 */
	public static function submission(){
		 
		global $current_user; 

		if ( ! is_user_logged_in() ) {
		    echo Opaljob_Template_Loader::get_template_part( 'not-allowed' );
		    return;
	    }
	    

		$metaboxes = apply_filters( 'cmb2_meta_boxes', array() );

		if ( ! isset( $metaboxes[ OPALJOB_WORK_PREFIX . 'front' ] ) ) {
			return __( 'A metabox with the specified \'metabox_id\' doesn\'t exist.', 'opaljob' );
		}

		// CMB2 is getting fields values from current post what means it will fetch data from submission page
		// We need to remove all data before.
		$post_id = ! empty( $_GET['id'] ) ? $_GET['id'] : false;
		if ( false == $post_id && empty( $_GET['id'] ) ) {
			unset( $_POST );
			foreach ( $metaboxes[ OPALJOB_WORK_PREFIX . 'front' ]['fields'] as $field_name => $field_value ) {
				delete_post_meta( get_the_ID(), $field_value['id'] );
			}
		}

		if ( ! empty( $post_id ) && ! empty( $_POST['object_id'] ) ) {
			$post_id = $_POST['object_id'];
		}

		if(  $post_id && !opaljob_is_own_work( $post_id, $current_user->ID) ){
			 echo Opaljob_Template_Loader::get_template_part( 'parts/submission-form' ); die;
		}
		
	    echo Opaljob_Template_Loader::get_template_part( 'shortcodes/submission-form', array( 'post_id' => $post_id, 'metaboxes' => $metaboxes, 'post_id' => $post_id) );
	}
	

	/**
	 * FrontEnd Submission Resume
	 */
	public static function submission_resume(){
		 
		global $current_user; 

		if ( ! is_user_logged_in() ) {
		    echo Opaljob_Template_Loader::get_template_part( 'not-allowed' );
		    return;
	    }
	    

		$metaboxes = apply_filters( 'cmb2_meta_boxes', array() );

		if ( ! isset( $metaboxes[ OPALJOB_RESUME_PREFIX . 'front' ] ) ) {
			return __( 'A metabox with the specified \'metabox_id\' doesn\'t exist.', 'opaljob' );
		}

		// CMB2 is getting fields values from current post what means it will fetch data from submission page
		// We need to remove all data before.
		$post_id = ! empty( $_GET['id'] ) ? $_GET['id'] : false;
		if ( false == $post_id && empty( $_GET['id'] ) ) {
			unset( $_POST );
			foreach ( $metaboxes[ OPALJOB_RESUME_PREFIX . 'front' ]['fields'] as $field_name => $field_value ) {
				delete_post_meta( get_the_ID(), $field_value['id'] );
			}
		}

		if ( ! empty( $post_id ) && ! empty( $_POST['object_id'] ) ) {
			$post_id = $_POST['object_id'];
		}

		if(  $post_id && !opaljob_is_own_work( $post_id, $current_user->ID) ){
			 echo Opaljob_Template_Loader::get_template_part( 'parts/submission-resume-form' ); die;
		}
		
	    echo Opaljob_Template_Loader::get_template_part( 'shortcodes/submission-resume-form', array( 'post_id' => $post_id, 'metaboxes' => $metaboxes, 'post_id' => $post_id) );
	}
	
	/**
	 * FrontEnd Submission Frofile
	 */
	public static function submission_profile(){
		 
		global $current_user; 

		if ( ! is_user_logged_in() ) {
		    echo Opaljob_Template_Loader::get_template_part( 'not-allowed' );
		    return;
	    }

	    if( get_user_role() == 'opaljob_company' || get_user_role() == 'administrator') {
		    $metaboxes = apply_filters( 'cmb2_meta_boxes', array() );

			if ( ! isset( $metaboxes[ OPALJOB_WORK_PREFIX . 'front' ] ) ) {
				return __( 'A metabox with the specified \'metabox_id\' doesn\'t exist.', 'opaljob' );
			}
			
			$user_id 	= get_current_user_id();
			$post_id 	= Opaljob_Query::get_post_id_company($user_id);		

		    echo Opaljob_Template_Loader::get_template_part( 'shortcodes/submission-profile-form', array( 'post_id' => $post_id, 'metaboxes' => $metaboxes, 'post_id' => $post_id) );
		    self::opaljob_update_user_meta($post_id);
		} elseif( get_user_role() == 'opaljob_jobseeker') {
			echo Opaljob_Template_Loader::get_template_part( 'account/my-profile');
		}
		
		echo Opaljob_Template_Loader::get_template_part( 'account/change-password');
	}
	/**
	 * FrontEnd Submission
	 */
	public static function process_submission() {
		self::process('opaljob_company',OPALJOB_COMPANY_PREFIX,opaljob_submssion_profile_page());
		self::process('opaljob_work',OPALJOB_WORK_PREFIX,opaljob_submssion_page());
		self::process('opaljob_resume',OPALJOB_RESUME_PREFIX,opaljob_submssion_resume_page());
		return;
	}
	/**
	 * FrontEnd Process
	 */
	public static function process($post_type,$prefix,$link) {
		
		if ( ! isset( $_POST['submit-cmb'] ) && ! empty( $_POST['post_type'] ) && $post_type == $_POST['post_type'] ) {
			return;
		}

		do_action( "opaljob_submission_profile_form_before" );

		// Setup and sanitize data
		if ( isset( $_POST[ $prefix . 'title' ] ) ) {

			if($post_type == 'opaljob_company') {
				$post_id = ! empty( $_POST['object_id'] ) ? $_POST['object_id'] : false;
			} else {
				$post_id = ! empty( $_GET['id'] ) ? $_GET['id'] : false;
			}
			$review_before = opaljob_options( 'admin_approve' );
			$post_status = 'pending';

			if ( !$review_before ) {
				$post_status = 'pending';
			}
			
			// If we are updating the post get old one. We need old post to set proper
			// post_date value because just modified post will at the top in archive pages.
			if ( ! empty( $post_id ) ) {
				$old_post = get_post( $post_id );
				$post_date = $old_post->post_date;
			} else {
				$post_date = '';
			}

			$user_id = get_current_user_id();
			$data = array(
				'post_title'     => sanitize_text_field( $_POST[ $prefix . 'title' ] ),
				'post_author'    => $user_id,
				'post_status'    => $post_status,
				'post_type'      => $post_type,
				'post_date'      => $post_date,
				'post_content'   => wp_kses( $_POST[ $prefix . 'text' ], '<b><strong><i><em><h1><h2><h3><h4><h5><h6><pre><code><span>' ),
			);

			if( empty($data['post_title']) || empty($data['post_author']) || empty($data['post_content']) ){
				wp_redirect( opaljob_submssion_page() );
				exit;
			}

			if ( ! empty( $post_id ) ) {
				$data['ID'] = $post_id;
				$post_id        = wp_update_post( $data, true );
			} else {
				$post_id        = wp_insert_post( $data, true );
			}

			$current_user   = wp_get_current_user();
			$userID         =   $current_user->ID;
			
			
			if ( ! empty( $post_id ) && ! empty( $_POST['object_id'] ) ) {
								
				$_POST['object_id'] = $post_id;
				$post_id = $_POST['object_id'];
				$metaboxes = apply_filters( 'cmb2_meta_boxes', array() );
				cmb2_get_metabox_form( $metaboxes[ $prefix . 'front' ], $post_id );

				// Create featured image
				$featured_image = get_post_meta( $post_id, $prefix . 'featured_image', true );
				if ( ! empty( $_POST[ $prefix . 'featured_image' ] ) ) {
					$featured_image_id = get_post_meta( $post_id, $prefix . 'featured_image_id', true );
					set_post_thumbnail( $post_id, $featured_image_id );
				} else {
					update_post_meta( $post_id, $prefix . 'featured_image', null );
					delete_post_thumbnail( $post_id );
				}
				$user = get_user_by( 'id', $user_id );
				// send email
				$from_name 	= opaljob_options('from_name');
				$from_email = opaljob_options('from_email');
				$subject 	= opaljob_options('submission_email_subject');
				
				$headers 	= sprintf( "From: %s <%s>\r\n Content-type: text/html", $from_name, $from_email );

				$tags 		= array("{first_name}", "{last_name}");
				$values 	= array($user->first_name, $user->last_name);

				$body 		= opaljob_options('submission_email_body');
				$body 		= html_entity_decode($body);
				$message 	= str_replace($tags, $values, $body);

				wp_mail( $user->user_email, $subject, $message, $headers );

				//redirect
				$_SESSION['messages'][] = array( 'success', __( 'Work has been successfully updated.', 'opaljob' ) );

				do_action( "opaljob_process_submission_after" );
				
				wp_redirect($link);
				exit();
			}
		}

		return;
	}


	/**
	 * FrontEnd Submission
	 */
	public static function submission_list() {
		if ( ! is_user_logged_in() ) {
		    echo Opaljob_Template_Loader::get_template_part( 'not-allowed' );
		    return;
	    }

	   
	    $loop = Opaljob_Query::get_works_by_user( null, get_current_user_id() );

		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/submission-listing', array( 'loop' => $loop ) );
	}

	public static function submission_list_wishlist() {
		if ( ! is_user_logged_in() ) {
		    echo Opaljob_Template_Loader::get_template_part( 'not-allowed' );
		    return;
	    }

	   
	    $loop = Opaljob_Query::get_wishlists( null, get_current_user_id() );

		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/submission-listing-save-work', array( 'loop' => $loop ) );
	}

	public static function submission_delete() {
		if ( isset($_GET['id']) && isset($_GET['remove']) ) {
	    	$is_allowed = Opaljob_Work::isAllowedRemove( get_current_user_id(), $_GET['id'] );
			if ( ! $is_allowed ) {
		        echo Opaljob_Template_Loader::get_template_part( 'not-allowed' );
				return;
			}
			if ( wp_delete_post( $_GET['id'] ) ) {
				$_SESSION['messages'][] = array( 'success', __( 'Work has been successfully removed.', 'opaljob' ) );
			} else {
				$_SESSION['messages'][] = array( 'danger', __( 'An error occured when removing an item.', 'opaljob' ) );
			}

			wp_redirect(get_permalink( opaljob_get_option( $_GET['page'], '/' ) ));
			exit();
	    }

	}

	
	public static function submission_list_wishlist_remove() {
		$user_id =  get_current_user_id();
		if ( isset($_GET['id']) && isset($_GET['remove_save']) ) {

			$post_id = $_GET['id'];
			$savejob = get_option("opaljob_saves_job_{$user_id}", array()); 
			unset($savejob[$post_id]);

			if ( update_option("opaljob_saves_job_{$user_id}",$savejob,true) ) {
				$_SESSION['messages'][] = array( 'success', __( 'Resume has been successfully removed.', 'opaljob' ) );
			} else {
				$_SESSION['messages'][] = array( 'danger', __( 'An error occured when removing an item.', 'opaljob' ) );
			}
			wp_redirect( get_permalink( opaljob_options( 'submission_list_wishlist_page' ) ) );
			exit();
	    }
	}
	/**
	 * FrontEnd Submission List Resume
	 */
	public static function submission_list_resume() {
		if ( ! is_user_logged_in() ) {
		    echo Opaljob_Template_Loader::get_template_part( 'not-allowed' );
		    return;
	    }

	   

	    $loop = Opaljob_Query::get_resumes_by_user( null, get_current_user_id() );

		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/submission-listing-resume', array( 'loop' => $loop ) );
	}
	/**
	 * FrontEnd Submission List Resume
	 */
	public static function submission_job_apply() {
		if ( ! is_user_logged_in() ) {
		    echo Opaljob_Template_Loader::get_template_part( 'not-allowed' );
		    return;
	    }


	    $loop = Opaljob_Query::get_apply_by_user( null, get_current_user_id() );

		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/submission-job-apply', array( 'loop' => $loop ) );
	}

	//update user meta

	public static function opaljob_update_user_meta($post_id) {

		$current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;

		$useremail 		= get_post_meta($post_id,OPALJOB_COMPANY_PREFIX . 'email',true);
		$usermobile 	= get_post_meta($post_id,OPALJOB_COMPANY_PREFIX . 'phone',true);
		$userfacebook 	= get_post_meta($post_id,OPALJOB_COMPANY_PREFIX . 'facebook',true);
		$usertwitter 	= get_post_meta($post_id,OPALJOB_COMPANY_PREFIX . 'twitter',true);
		$userlinkedin 	= get_post_meta($post_id,OPALJOB_COMPANY_PREFIX . 'linkedin',true);
		$userpinterest 	= get_post_meta($post_id,OPALJOB_COMPANY_PREFIX . 'pinterest',true);
		$profile_image_url 	= get_post_meta($post_id,OPALJOB_COMPANY_PREFIX . 'avatar',true);
		$userurl 		= get_post_meta($post_id,OPALJOB_COMPANY_PREFIX . 'website',true);

                      
        update_user_meta( $userID, 'custom_picture',$profile_image_url);
        update_user_meta( $userID, 'small_custom_picture',$profile_image_url);     
        update_user_meta( $userID, 'mobile' , $usermobile) ;
        update_user_meta( $userID, 'facebook' , $userfacebook) ;
        update_user_meta( $userID, 'twitter' , $usertwitter) ;
        update_user_meta( $userID, 'linkedin' , $userlinkedin) ;
        update_user_meta( $userID, 'pinterest' , $userpinterest) ;
        update_user_meta( $userID, 'description' , get_the_content()) ;
        update_user_meta( $userID, 'website' , $userurl) ;

        $company_id=get_user_meta( $userID, 'user_company_id',true);
        if($current_user->user_email != $useremail ) {
            $user_id=email_exists( $useremail ) ;
            if ( $user_id){
                _e('The email was not saved because it is used by another user.</br>','opaljob');
            } else{
               $args = array(
                      'ID'         => $userID,
                      'user_email' => $useremail
                  ); 
                 wp_update_user( $args );
            } 
        }
	}
	
	/**
	 *
	 */
	public static function load_scripts(){

		wp_enqueue_style("opaljob-summernote", OPALJOB_PLUGIN_URL . 'assets/summernote.css', null, "1.3", false);
		wp_enqueue_script("opaljob-summernote", OPALJOB_PLUGIN_URL . 'assets/js/summernote.js', array( 'jquery' ), "1.0.0", true);
		wp_enqueue_script("opaljob-submission", OPALJOB_PLUGIN_URL . 'assets/js/submission.js', array( 'jquery' ), "1.0.0", true);
	}

}

Opaljob_Submission::init();

		


