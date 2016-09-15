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
// send mail apply
if (!function_exists('opaljob_process_send_email')) {
	function opaljob_process_send_email() {

		$name = esc_html( $_POST['name'] );
		$email = esc_html( $_POST['email'] );
		$message = esc_html( $_POST['message'] );
		$post_id = esc_html( $_POST['post_id'] );
		$company_id = esc_html( $_POST['company_id'] );
		$user_meta_id = esc_html( $_POST['user_meta_id'] );

		$subject = opaljob_options('sent_contact_form_email_subject');
		$headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $name, $email );

		$company = get_post( $company_id );
		$company_email = get_post_meta( $company_id, OPALJOB_COMPANY_PREFIX . 'email', true );
		$recruier_name = $company->name;
		
		if ( !empty($post_id) ) {
			$work_link = get_permalink( $post_id );
		} else {
			$work_link = '';
		}
		$link_resume = get_permalink ($_POST['resume'],'/');
		$tags = array("{recruier_name}", "{name}", "{email}", "{work_link}", "{message}","{link_resume}");
		$values = array($recruier_name, $name, $email, $work_link, $message,$link_resume);

		$body = opaljob_options('sent_contact_form_email_body');
		$body = html_entity_decode($body);
		$message = str_replace($tags, $values, $body);
		

		$status = wp_mail( $company_email, $subject, $message, $headers );
		
		if ( ! empty( $status ) && 1 == $status ) {
			$return = array( 'status' => 'success', 'message' => __( 'Message has been successfully sent.', 'opaljob' ) );
		} else {
			$return = array( 'status' => 'danger', 'message' => __( 'Unable to send a message.', 'opaljob' ) );
		}
		$user_id = get_current_user_id();
		$data = array(
			'post_title'     => sanitize_text_field( $_POST['name']),
			'post_author'    => $user_id,
			'post_status'    => 'pending',
			'post_type'      => 'opaljob_apply',
			'post_content'   => wp_kses( $_POST['message'], '<b><strong><i><em><h1><h2><h3><h4><h5><h6><pre><code><span>' ),

		);
		$post_id = wp_insert_post( $data, true );
		add_post_meta($post_id,OPALJOB_APPLY_PREFIX.'email',$_POST['email']);
		add_post_meta($post_id,OPALJOB_APPLY_PREFIX.'position_applying',$_POST['work_title']);
		add_post_meta($post_id,OPALJOB_APPLY_PREFIX.'resume',get_post_meta($_POST['resume'],OPALJOB_RESUME_PREFIX. 'resum_attachment',true));
		add_post_meta($post_id,OPALJOB_APPLY_PREFIX.'resume_id',$_POST['resume']);
		add_post_meta($post_id,OPALJOB_APPLY_PREFIX.'company_id',$user_meta_id);
		add_post_meta($post_id,OPALJOB_APPLY_PREFIX.'alert_company',1);
		add_post_meta($post_id,OPALJOB_APPLY_PREFIX.'jobseeker_id',$user_id);

		echo json_encode($return); die();
	}
	add_action( 'wp_ajax_send_email_contact', 'opaljob_process_send_email' );
	add_action( 'wp_ajax_nopriv_send_email_contact', 'opaljob_process_send_email' );
}
// send email approve
if (!function_exists('opaljob_process_send_email_approve')) {
	function opaljob_process_send_email_approve() {

		$current_user = wp_get_current_user();

		$name = esc_html( $_POST['name'] );
		$email = esc_html( $_POST['email'] );
		$message = esc_html( $_POST['message'] );
		$post_id = esc_html( $_POST['post_id'] );
		$company_id = esc_html( $_POST['company_id'] );
		$company_email = get_post_meta( $company_id, OPALJOB_COMPANY_PREFIX . 'email', true );
		$subject = esc_html( $_POST['title'] );
		$headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $name, $company_email );

		$receive_name = $current_user->user_firstname.' '.$current_user->user_lastname; 
		if ( !empty($post_id) ) {
			$work_link = get_permalink( $post_id );
		} else {
			$work_link = '';
		}


		$status = wp_mail( $email, $subject, $message, $headers);
		
		if ( ! empty( $status ) && 1 == $status ) {
			$return = array( 'status' => 'success', 'message' => __( 'Message has been successfully sent.', 'opaljob' ) );
		} else {
			$return = array( 'status' => 'danger', 'message' => __( 'Unable to send a message.', 'opaljob' ) );
		}
		$prop = array(
                'ID'            => $post_id,
                'post_type'     => 'opaljob_apply',
                'post_status'   => 'approve',
                'post_per_page' => -1,
        );			           
		wp_update_post($prop); 
		update_post_meta($post_id,OPALJOB_APPLY_PREFIX.'alert_company',0);
		update_post_meta($post_id,OPALJOB_APPLY_PREFIX.'alert_jobseeker',1);
		update_post_meta($post_id,OPALJOB_APPLY_PREFIX.'message_apply',$message);
		echo json_encode($return); die();
	}
	add_action( 'wp_ajax_send_email_contact_approve', 'opaljob_process_send_email_approve' );
	add_action( 'wp_ajax_nopriv_send_email_contact_approve', 'opaljob_process_send_email_approve' );
}


if (!function_exists('opaljob_process_send_email_rejected')) {
	function opaljob_process_send_email_rejected() {

		$current_user = wp_get_current_user();

		$name = esc_html( $_POST['name'] );
		$email = esc_html( $_POST['email'] );
		$message = esc_html( $_POST['message'] );
		$post_id = esc_html( $_POST['post_id'] );
		$company_id = esc_html( $_POST['company_id'] );
		$company_email = get_post_meta( $company_id, OPALJOB_COMPANY_PREFIX . 'email', true );
		$subject = esc_html( $_POST['title'] );
		$headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $name, $company_email );

		$receive_name = $current_user->user_firstname.' '.$current_user->user_lastname; 
		if ( !empty($post_id) ) {
			$work_link = get_permalink( $post_id );
		} else {
			$work_link = '';
		}


		$status = wp_mail( $email, $subject, $message, $headers);
		
		if ( ! empty( $status ) && 1 == $status ) {
			$return = array( 'status' => 'success', 'message' => __( 'Message has been successfully sent.', 'opaljob' ) );
		} else {
			$return = array( 'status' => 'danger', 'message' => __( 'Unable to send a message.', 'opaljob' ) );
		}
		 $prop = array(
                'ID'            => $post_id,
                'post_type'     => 'opaljob_apply',
                'post_status'   => 'rejected',
                'post_per_page' => -1,
        );			           
		wp_update_post($prop); 
		update_post_meta($post_id,OPALJOB_APPLY_PREFIX.'alert_company',0);
		update_post_meta($post_id,OPALJOB_APPLY_PREFIX.'alert_jobseeker',1);
		update_post_meta($post_id,OPALJOB_APPLY_PREFIX.'message_apply',$message);
		echo json_encode($return); die();
	}
	add_action( 'wp_ajax_send_email_contact_rejected', 'opaljob_process_send_email_rejected' );
	add_action( 'wp_ajax_nopriv_send_email_contact_rejected', 'opaljob_process_send_email_rejected' );
}

if (!function_exists('opaljob_ajax_make_read')) {
	function opaljob_ajax_make_read() {

		$apply_id = esc_html( $_POST['apply_id'] );

		if (update_post_meta($apply_id,OPALJOB_APPLY_PREFIX.'alert_jobseeker',0)) {
			$return = array( 'status' => 'success', 'message' => __( 'Make read success.', 'opaljob' ) );
		} else {
			$return = array( 'status' => 'danger', 'message' => __( 'Make read fail.', 'opaljob' ) );
		}
		echo json_encode($return); die();
	}
	add_action( 'wp_ajax_opaljob_ajax_make_read', 'opaljob_ajax_make_read' );
	add_action( 'wp_ajax_nopriv_opaljob_ajax_make_read', 'opaljob_ajax_make_read' );
}
if (!function_exists('opaljob_update_profile')) { 
	function opaljob_update_profile() {
		$current_user   =   wp_get_current_user();
        $userID         =   $current_user->ID;
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }	

        $allowed_html   =   array();
        $firstname      =   sanitize_text_field ( wp_kses( $_POST['firstname'] ,$allowed_html) );
        $secondname     =   sanitize_text_field ( wp_kses( $_POST['secondname'] ,$allowed_html) );
        $useremail      =   sanitize_text_field ( wp_kses( $_POST['useremail'] ,$allowed_html) );
        $userphone      =   sanitize_text_field ( wp_kses( $_POST['userphone'] ,$allowed_html) );
        $usermobile     =   sanitize_text_field ( wp_kses( $_POST['usermobile'] ,$allowed_html) );
        $userskype      =   sanitize_text_field ( wp_kses( $_POST['userskype'] ,$allowed_html) );
        $usertitle      =   sanitize_text_field ( wp_kses( $_POST['usertitle'] ,$allowed_html) );
        $about_me       =   sanitize_text_field ( wp_kses( $_POST['description'],$allowed_html) );
        $profile_image_url_small   = sanitize_text_field ( wp_kses($_POST['profile_image_url_small'],$allowed_html) );
        $profile_image_url= sanitize_text_field ( wp_kses($_POST['profile_image_url'],$allowed_html) );       
        $userfacebook   =   sanitize_text_field ( wp_kses( $_POST['userfacebook'],$allowed_html) );
        $usertwitter    =   sanitize_text_field ( wp_kses( $_POST['usertwitter'],$allowed_html) );
        $userlinkedin   =   sanitize_text_field ( wp_kses( $_POST['userlinkedin'],$allowed_html) );
        $userpinterest  =   sanitize_text_field ( wp_kses( $_POST['userpinterest'],$allowed_html ) );
          
        
        update_user_meta( $userID, 'first_name', $firstname ) ;
        update_user_meta( $userID, 'last_name',  $secondname) ;
        update_user_meta( $userID, 'phone' , $userphone) ;               
        update_user_meta( $userID, 'skype' , $userskype) ;
        update_user_meta( $userID, 'title', $usertitle) ;
        update_user_meta( $userID, 'custom_picture',$profile_image_url);
        update_user_meta( $userID, 'small_custom_picture',$profile_image_url_small);     
        update_user_meta( $userID, 'mobile' , $usermobile) ;
        update_user_meta( $userID, 'facebook' , $userfacebook) ;
        update_user_meta( $userID, 'twitter' , $usertwitter) ;
        update_user_meta( $userID, 'linkedin' , $userlinkedin) ;
        update_user_meta( $userID, 'pinterest' , $userpinterest) ;
        update_user_meta( $userID, 'description' , $about_me) ;

        if($current_user->user_email != $useremail ) {
            $user_id=email_exists( $useremail ) ;
            if ( $user_id){
                $return = array( 'danger' => 'success', 'message' => __( 'The email was not saved because it is used by another user', 'opaljob' ) );
            } else{
               $args = array(
                      'ID'         => $userID,
                      'user_email' => $useremail
                  ); 
                 wp_update_user( $args );
            } 
        }
        $return = array( 'status' => 'success', 'message' => __( 'Profile updated', 'opaljob' ) );
        echo json_encode($return); die();
	}
	add_action( 'wp_ajax_opaljob_update_profile', 'opaljob_update_profile' );
	add_action( 'wp_ajax_nopriv_opaljob_update_profile', 'opaljob_update_profile' );
}
if( !function_exists('opaljob_change_password') ):
	function opaljob_change_password(){
        $current_user   = wp_get_current_user();
        $allowed_html   =   array();
        $userID         =   $current_user->ID;
        
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }
        
        $oldpass        =  sanitize_text_field ( wp_kses( $_POST['oldpass'] ,$allowed_html) );
        $newpass        =  sanitize_text_field ( wp_kses( $_POST['newpass'] ,$allowed_html) );
        $renewpass      =  sanitize_text_field ( wp_kses( $_POST['renewpass'] ,$allowed_html) ) ;
        
        if($newpass=='' || $renewpass=='' ){
             $return = array( 'status' => 'danger', 'message' => __( 'The new password is blank','opaljob'));
            die();
        }
       
        if($newpass != $renewpass){
             $return = array( 'status' => 'danger', 'message' => __( 'Passwords do not match','opaljob'));
            die();
        }
        
        $user = get_user_by( 'id', $userID );
        if ( $user && wp_check_password( $oldpass, $user->data->user_pass, $user->ID) ){
            wp_set_password( $newpass, $user->ID );
            $return = array( 'status' => 'success', 'message' => __('Password Updated','opaljob'));
        }else{
            $return = array( 'status' => 'danger', 'message' => __( 'Old Password is not correct','opaljob'));
        }

     	echo json_encode($return); die();      
   	}
   	add_action( 'wp_ajax_opaljob_change_password', 'opaljob_change_password' );
	add_action( 'wp_ajax_nopriv_opaljob_change_password', 'opaljob_change_password' );
endif; 
if(!function_exists('opaljob_ajax_facebooklogin'))  :
	function opaljob_ajax_facebooklogin() {
		require 'vendors/facebook/facebook.php';
	    $app_id               =   esc_html ( opaljob_options('facebook_api_key','') );
	    $app_secret            =   esc_html ( opaljob_options('facebook_secret','') );
	    
	    //New Facebook
		$facebook = new Facebook(array(
		'appId'     => $app_id,
		'secret'    => $app_secret,
		'cookie'    => TRUE, /* Optional */
		'oath'      => TRUE  /* Optional */
		));

		//Login URL
		$loginUrl = $facebook->getLoginUrl(array(
		    'scope'     => 'email,user_birthday',
		    'redirect_uri'  => home_url(),
		    ));

		//Get FacebookUserID
		$fbuser = $facebook->getUser();
		
    	die();
	}
	add_action('wp_ajax_opaljob_ajax_facebooklogin','opaljob_ajax_facebooklogin');
    add_action('wp_ajax_nopriv_opaljob_ajax_facebooklogin','opaljob_ajax_facebooklogin');
endif;
if( !function_exists('me_upload') ):
    function me_upload(){
        $current_user = wp_get_current_user();
        $userID =   $current_user->ID;
    
        if ( !is_user_logged_in() ) {   
            exit('ko');
        }
        if($userID === 0 ){
            exit('out pls');
        }

        $filename = convertAccentsAndSpecialToNormal($_FILES['aaiu_upload_file']['tmp_name']);
        $base='';
        $allowed_html =array();
        list($width, $height) = getimagesize($filename);
        if(isset($_GET['base'])){
            $base=esc_html( wp_kses( $_GET['base'], $allowed_html ) );
        }
        
        $file = array(
            'name'      => convertAccentsAndSpecialToNormal($_FILES['aaiu_upload_file']['name']),
            'type'      => $_FILES['aaiu_upload_file']['type'],
            'tmp_name'  => $_FILES['aaiu_upload_file']['tmp_name'],
            'error'     => $_FILES['aaiu_upload_file']['error'],
            'size'      => $_FILES['aaiu_upload_file']['size'],
            'width'     =>  $width,
            'height'    =>  $height,
            'base'      =>  $base
        );
        $file = fileupload_process($file);
    }  
    add_action('wp_ajax_me_upload','me_upload');
    add_action('wp_ajax_nopriv_me_upload','me_upload');
endif; 
function ajaxFilterJob() {
	if(isset($_POST['filter_job_type'] )) {
		$term_job_type = $_POST['filter_job_type'];
	}else {
		$term_job_type ='';
	} 
	$posts_per_page = 7;
	$count_posts = (array)wp_count_posts('opaljob_work');
	$count_post = $count_posts["publish"];
	$number_posts = $posts_per_page + $_POST['loadmore'];
	$args = array(
		'post_type'      => 'opaljob_work',
		'post_status'    => 'publish',
		'posts_per_page' => $number_posts,
		's'				=> $_POST['search_keywords']
	);
	$args['tax_query'] = array( 'relation' => 'AND' );
	$args['tax_query'][] = array(
		'taxonomy' => 'opaljob_types',
		'field' => 'slug',
		'terms' => $term_job_type
	);
	$query = new WP_Query( $args );
	$count = 0;
	$out_put ='';
	if( $query->have_posts() ):
		while ( $query->have_posts() ) : $query->the_post();
			$count++; 
			$out_put .= '<li id="job_listing" class="job_listing">';	
			$out_put .= Opaljob_Template_Loader::get_template_part('content-work-list'); 
			$out_put .= '</li>';
		endwhile;	
	endif;
	wp_reset_postdata();
	if(empty($out_put)) {
		$out_put = __('Not found','opaljob');
	}

	if($number_posts > $count_post || $count < $number_posts) {
		$return = array( 'status' => 'hidden', 'message' => ($out_put));
	} else {
		$return = array( 'status' => 'success', 'message' => ($out_put));
	}
	echo  json_encode($return); die();	
}
add_action('wp_ajax_ajaxFilterJob','ajaxFilterJob');
add_action('wp_ajax_nopriv_ajaxFilterJob','ajaxFilterJob');

