<?php 
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     WpOpal Team <opalwordpress@gmail.com>
 * @copyright  Copyright (C) 2015 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */
class Opaljob_Account{

	/**
	 * @var boolean $ispopup 
	 */
	private $ispopup = true; 

	/**
	 * Constructor 
	 */
	public static function init(){
		
		add_action('init', array( __CLASS__,'setup'), 1000);
		add_action( 'wp_ajax_ajaxDoLogin',  array( __CLASS__,'ajaxDoLogin') );
		add_action( 'wp_ajax_nopriv_ajaxDoLogin',  array( __CLASS__,'ajaxDoLogin') );
		add_action( 'wp_ajax_ajaxDoSignup',  array( __CLASS__,'ajaxDoSignup') );
		add_action( 'wp_ajax_nopriv_ajaxDoSignup',  array( __CLASS__,'ajaxDoSignup') );
		add_action( 'wp_ajax_doForgotPassword',  array( __CLASS__,'doForgotPassword') );
		add_action( 'wp_ajax_nopriv_doForgotPassword',  array( __CLASS__,'doForgotPassword') );
		add_filter('user_contactmethods', array( __CLASS__,'opaljob_modify_contact_methods'));     

	}


	/**
	 * process login function with ajax request
	 *
 	 * ouput Json Data with messsage and login status
	 */
	public static function ajaxDoLogin(){
		// First check the nonce, if it fails the function will break
   		//check_ajax_referer( 'ajax-pbr-login-nonce', 'security1' );
   		$result = self::doLogin($_POST['pbr_username'], $_POST['pbr_password'],  isset($_POST['remember']) ); 
   		
   		echo trim($result);
   		die();
	}


	/**
	 * process user login with username/password
	 *
	 * return Json Data with messsage and login status
	 */
	public static function doLogin( $username, $password, $remember=false ){
		$info = array();
   		
   		$info['user_login'] = $username;
	    $info['user_password'] = $password;
	    $info['remember'] = $remember;
		
		$user_signon = wp_signon( $info, false );
	    if ( is_wp_error($user_signon) ){
			return json_encode(array('loggedin'=>false, 'message'=>esc_html__('Wrong username or password. Please try again!!!', 'opaljob')));
	    } else {
			wp_set_current_user($user_signon->ID); 
	        return json_encode(array('loggedin'=>true, 'message'=>esc_html__('Signin successful, redirecting...', 'opaljob')));
	    }
	}

	public static function ajaxDoSignup(){

        $allowed_html   =   array();
        $first_name     =   trim( sanitize_text_field(wp_kses( $_POST['wpcrl_fname'] ,$allowed_html) ) );
        $last_name      =   trim( sanitize_text_field(wp_kses( $_POST['wpcrl_lname'] ,$allowed_html) ) );
        $user_email     =   trim( sanitize_text_field(wp_kses( $_POST['wpcrl_email'] ,$allowed_html) ) );
        $user_name      =   trim( sanitize_text_field(wp_kses( $_POST['wpcrl_username'] ,$allowed_html) ) );
        $user_role      =   trim( sanitize_text_field(wp_kses( $_POST['opal_role'] ,$allowed_html) ) );      
        
        if (preg_match("/^[0-9A-Za-z_]+$/", $user_name) == 0) {
			print json_encode(array('signup'=>false, 'message'=>esc_html__('Invalid username (do not use special characters or spaces)!', 'opaljob')));            
            die();
        }
        if ($user_email=='' || $user_name=='' ){
        	print json_encode(array('signup'=>false, 'message'=>esc_html__('Username and/or Email field is empty!', 'opaljob'))); 
          	exit();
        }
        if($user_role =='') {
        	print json_encode(array('signup'=>false, 'message'=>esc_html__('Role field is empty!', 'opaljob'))); 
          	exit();
        }
        if(filter_var($user_email,FILTER_VALIDATE_EMAIL) === false) {
            print json_encode(array('signup'=>false, 'message'=>esc_html__('The email doesn\'t look right !', 'opaljob'))); 
            exit();
        }
        
        $domain = mb_substr(strrchr($user_email, "@"), 1);
        if( !checkdnsrr ($domain) ){
        	print json_encode(array('signup'=>false, 'message'=>esc_html__('The email\'s domain doesn\'t look right.', 'opaljob')));
            exit();
        }
        
        
        $user_id     =   username_exists( $user_name );
        if ($user_id){
        	print json_encode(array('signup'=>false, 'message'=>esc_html__('Username already exists.  Please choose a new one.', 'opaljob')));
            exit();
        }
        
    
        $user_pass              =   trim( sanitize_text_field(wp_kses( $_POST['wpcrl_password'] ,$allowed_html) ) );
        $user_pass_retype       =   trim( sanitize_text_field(wp_kses( $_POST['wpcrl_password2'] ,$allowed_html) ) );
        
        if ($user_pass=='' || $user_pass_retype=='' ){
        	print json_encode(array('signup'=>false, 'message'=>esc_html__('One of the password field is empty!', 'opaljob')));
            exit();
        }
            
        if ($user_pass !== $user_pass_retype ){
        	print json_encode(array('signup'=>false, 'message'=>esc_html__('Passwords do not match', 'opaljob')));
            exit();
        }
        if ( !$user_id and email_exists($user_email) == false ) {
     
            $user_password = $user_pass; // no so random now!
            
            $userdata = array(
                'user_login'  =>    $user_name,
			    'user_email'  =>    $user_email,
			    'user_pass'   =>    $user_password,
			    'first_name'  =>    $first_name,
			    'last_name'   =>    $last_name,
			    'role'		  =>	$user_role,	
            );
            $user_id = wp_insert_user( $userdata ) ;
            //$user_id         = wp_create_user( $user_name, $user_password, $user_email );
         
            if ( is_wp_error($user_id) ){
               // print_r($user_id);
            }else{
            	print json_encode(array('signup'=>true, 'message'=>esc_html__('Your account was created and you can login now!', 'opaljob')));
                
             }
             
        } else {
           print json_encode(array('signup'=>false, 'message'=>esc_html__('Email already exists.  Please choose a new one.', 'opaljob')));
        }
        die(); 
              
	}

	/**
	 * process user doForgotPassword with username/password
	 *
	 * return Json Data with messsage and login status
	 */	
	public static function doForgotPassword(){
	 
		// First check the nonce, if it fails the function will break
	    check_ajax_referer( 'ajax-pbr-lostpassword-nonce', 'security' );
		
		global $wpdb;
		
		$account = $_POST['forgot_email'];
		
		if( empty( $account ) ) {
			$error = esc_html__( 'Enter an username or e-mail address.', 'opaljob' );
		} else {
			if(is_email( $account )) {
				if( email_exists($account) ) 
					$get_by = 'email';
				else	
					$error = esc_html__( 'There is no user registered with that email address.', 'opaljob' );			
			}
			else if (validate_username( $account )) {
				if( username_exists($account) ) 
					$get_by = 'login';
				else	
					$error = esc_html__( 'There is no user registered with that username.', 'opaljob' );				
			}
			else
				$error = esc_html__(  'Invalid username or e-mail address.', 'opaljob' );		
		}	
		
		if(empty ($error)) {
			$random_password = wp_generate_password();

			$user = get_user_by( $get_by, $account );
				
			$update_user = wp_update_user( array ( 'ID' => $user->ID, 'user_pass' => $random_password ) );
				
			if( $update_user ) {
				
				$from = get_option('admin_email'); // Set whatever you want like mail@yourdomain.com
				
				if(!(isset($from) && is_email($from))) {		
					$sitename = strtolower( $_SERVER['SERVER_NAME'] );
					if ( substr( $sitename, 0, 4 ) == 'www.' ) {
						$sitename = substr( $sitename, 4 );					
					}
					$from = 'do-not-reply@'.$sitename; 
				}
				
				$to = $user->user_email;
				$subject = esc_html__( 'Your new password', 'opaljob' );
				$sender = 'From: '.get_option('name').' <'.$from.'>' . "\r\n";
				
				$message = esc_html__( 'Your new password is: ', 'opaljob' ) .$random_password;
					
				$headers[] = 'MIME-Version: 1.0' . "\r\n";
				$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers[] = "X-Mailer: PHP \r\n";
				$headers[] = $sender;
					
				$mail = wp_mail( $to, $subject, $message, $headers );
				if( $mail ) 
					$success = esc_html__( 'Check your email address for you new password.', 'opaljob' );
				else
					$error = esc_html__( 'System is unable to send you mail containg your new password.', 'opaljob' );						
			} else {
				$error =  esc_html__( 'Oops! Something went wrong while updating your account.', 'opaljob' );
			}
		}
	
		if( ! empty( $error ) )
			echo json_encode(array('loggedin'=>false, 'message'=> ($error)));
				
		if( ! empty( $success ) )
			echo json_encode(array('loggedin'=>false, 'message'=> $success ));	
		die();
	}


	/**
	 * add all actions will be called when user login.
	 */
	public static function setup(){
		if ( !is_user_logged_in() ) {
			add_action('wp_footer', array( __CLASS__,'signin') );
		}
		add_action( 'pbr-account-buttons', array( __CLASS__, 'button' ) );

	}

	/**
	 * render link login or show greeting when user logined in
	 *
	 * @return String.
	 */
	public static function button(){
		if ( !is_user_logged_in() ) {
			echo '<li><a href="#"  data-toggle="modal" data-target="#modalLoginForm" class="pbr-user-login">'.esc_html__( 'Login','opaljob' ).'</a></li>';
			echo '<li><a href="#"  data-toggle="modal" data-target="#modalRegisterForm" class="pbr-user-register">'.esc_html__( 'Register','opaljob' ).'</a></li>';
		}else {
			return self::greetingContext();
		}
	}

	/**
	 * check if user not login that showing the form
	 */
	public static function signin(){
		if ( !is_user_logged_in() ) {
 			return self::form();
		}	
	}

	/**
	 * Display greeting words
	 */
	public static function greeting(){
		$current_user = wp_get_current_user();
		$link = esc_url(wp_logout_url( home_url() ));
		printf('Greeting %s (%s)', $current_user->user_nicename, '<a href="'.esc_url($link).'" title="'.esc_html__( 'Logout', 'opaljob' ).'">'.esc_html__( 'Logout', 'opaljob' ).'</a>' );
	}

	/**
	 *
	 */
	public static function greetingContext(){
		$current_user = wp_get_current_user();
		$link = esc_url(wp_logout_url( home_url() ));

		echo ' <div class="account-links dropdown">
				  <a href="#" class="dropdown-toggle"  id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				    '.esc_html__( 'Howdy', 'opaljob').', '.$current_user->user_nicename.'
				    <span class="caret"></span>
				  </a>
				 <a class="signout" href="'.esc_url($link).'" title="'.esc_html__( 'Logout', 'opaljob' ).'">'.esc_html__( 'Logout', 'opaljob' ).'</a>
				<div class="dropdown-menu">';
				    $args = array(
                        'theme_location'  => 'accountmenu',
                        'container_class' => '',
                        'menu_class'      => 'myaccount-menu'
                    );
                    wp_nav_menu($args);
	 	     
		echo		  '</div>
				</div>';

	}

	/**
	 * render login form
	 */
	public static function form(){
		 return opaljob_account_signin();				
	}
 	
	

	public static function opaljob_modify_contact_methods($profile_fields) {
		// Add new fields
	    $profile_fields['facebook']                     = 'Facebook';
	    $profile_fields['twitter']                      = 'Twitter';
	    $profile_fields['linkedin']                     = 'Linkedin';
	    $profile_fields['pinterest']                    = 'Pinterest';
	    $profile_fields['website']                      = 'Website';
		$profile_fields['phone']                        = 'Phone';
	    $profile_fields['mobile']                       = 'Mobile';
		$profile_fields['skype']                        = 'Skype';
		$profile_fields['title']                        = 'Title/Position';
	    $profile_fields['custom_picture']               = 'Picture Url';
	    $profile_fields['small_custom_picture']         = 'Small Picture Url';
	    
		return $profile_fields;
	}
	

}

Opaljob_Account::init();
?>