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
Class Opaljob_wishlist{
	public static function init(){
		add_action( 'wp_ajax_nopriv_ajax_saves_job', array(__CLASS__, 'ajax_saves_job') );
		add_action( 'wp_ajax_ajax_saves_job', array(__CLASS__, 'ajax_saves_job') );
	}
	public static function ajax_saves_job() {
		if ( !is_user_logged_in() ) {
			$result = array(
				'success' => false,
				'message' => '<span class="error-response">'.__( 'You are not logged in yet', 'opaljob' ).'</span>',
			);

			wp_send_json($result);
			return;
		}

		if( !check_ajax_referer('opaljob-saves-job', 'security', false) ) {
			$result = array(
				'success' => false,
				'message' => '<span class="error-response">'.__( 'Your session is expired or you submitted an invalid form.', 'opaljob' ).'</span>',
			);

			wp_send_json($result);
			return;
		}

		if( ! isset($_POST['job_id']) || empty($_POST['job_id']) ) {
			$result = array(
				'success' => false,
				'message' => '<span class="error-response">'.__('There\'s an unknown error. Please retry or contact Administrator.', 'opaljob').'</span>',
			);

			wp_send_json($result);
			return;
		}

		$current_user = wp_get_current_user();

		$user_id		= $current_user->ID;
		$job_id			= $_POST['job_id'];

		$saves = get_option("opaljob_saves_job_{$user_id}", array());


		if( opaljob_is_job_saved($user_id, $job_id) ) {
			if( opaljob_job_clear_saved($user_id, $job_id) ) {
				$result = array(
					'success' => true,
					'message' => '<span class="success-response">'.__( 'Save removed.', 'opaljob' )
				);
				wp_send_json($result);
			}
		} else {
			if( opaljob_job_set_saved($user_id, $job_id) ) {
				$result = array(
					'success' => true,
					'message' => '<span class="success-response">'.__( 'Job saved.', 'opaljob' )
				);
				wp_send_json($result);
			}
		}
		
		$result = array(
			'success' => false,
			'message' => '<span class="error-response">'.__('There\'s an unknown error. Please retry or contact Administrator.', 'opaljob').'</span>',
		);

		wp_send_json($result);
	} 
	
}
Opaljob_wishlist::init();

if( !function_exists( 'opaljob_job_set_saved' ) ) :
	function opaljob_job_set_saved( $user_id = 0, $job_id = 0 ) {
		if( empty($user_id) ) {
			$user_id = get_current_user_id();
		}

		if( empty($user_id) ) {
			return false;
		}

		if( empty($job_id) ) {
			$job_id = get_the_ID();
		}

		$job_id = absint( $job_id );

		$saves = get_option("opaljob_saves_job_{$user_id}");
		if( empty( $saves ) || !is_array( $saves ) ) {
			$saves = array();
		}

		if( isset( $saves[$job_id] ) && $saves[$job_id] == 1 ) {
			return true;
		} else {
			$saves[$job_id] = 1;
		}
		return update_option("opaljob_saves_job_{$user_id}", $saves);
	}
endif;

if( !function_exists( 'opaljob_job_clear_saved' ) ) :
	function opaljob_job_clear_saved( $user_id = 0, $job_id = 0 ) {
		if( empty($user_id) ) {
			$user_id = get_current_user_id();
		}

		if( empty($user_id) ) {
			return false;
		}

		if( empty($job_id) ) {
			$job_id = get_the_ID();
		}

		$job_id = absint( $job_id );

		$saves = get_option("opaljob_saves_job_{$user_id}", array());
		if( empty( $saves ) || !is_array( $saves ) ) {
			$saves = array();
		}

		if( !isset($saves[$job_id]) ) {
			return true;
		}

		unset($saves[$job_id] );
		return update_option("opaljob_saves_job_{$user_id}", $saves);
	}
endif;

if( !function_exists( 'opaljob_is_job_saved' ) ) :
	function opaljob_is_job_saved( $user_id = 0, $job_id = 0 ) {
		if( empty($user_id) ) {
			$user_id = get_current_user_id();
		}

		if( empty($user_id) ) {
			return false;
		}

		if( empty($job_id) ) {
			$job_id = get_the_ID();
		}

		if( empty($job_id) || 'opaljob_work' != get_post_type( $job_id ) ) {
			return false;
		}

		$job_id = absint( $job_id );

		$saves = get_option("opaljob_saves_job_{$user_id}", array());

		if( empty( $saves ) || !is_array( $saves ) ) {
			return false;
		}

		return ( isset($saves[$job_id]) && !empty($saves[$job_id]) );
	}
endif;

