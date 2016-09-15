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

class Opaljob_Apply {

	public static function countAlertCompany() {
		$args = array(
			'post_type'         => 'opaljob_apply',
			'post_status'         => 'any',
			'meta_query'        => array(
				array(
					'key'       => OPALJOB_APPLY_PREFIX . 'alert_company',
					'value'     => 1,
					'compare'   => '=',
				),
				array(
					'key'       => OPALJOB_APPLY_PREFIX . 'author_id',
					'value'     => get_current_user_id(),
					'compare'   => '=',
				),
			),
		);
		
		$loop = new WP_Query($args);
 		$count = 0;

 		if( $loop->have_posts() ){		
 			while( $loop->have_posts() ){  $loop->the_post();
 				$count ++;
 			}
 		}
 		wp_reset_postdata();

 		if($count == 0) {
 			$count = '';
 		}
		return $count;
	}
	public static function countAlertJobseeker() {
		$args = array(
			'post_type'         => 'opaljob_apply',
			'post_status'         => 'any',
			'meta_query'        => array(
				array(
					'key'       => OPALJOB_APPLY_PREFIX . 'alert_jobseeker',
					'value'     => 1,
					'compare'   => '=',
				),
			),
		);
		
		$loop = new WP_Query($args);
 		$count = 0;

 		if( $loop->have_posts() ){		
 			while( $loop->have_posts() ){  $loop->the_post();
 				$count ++;
 			}
 		}
 		wp_reset_postdata();

 		if($count == 0) {
 			$count = '';
 		}

		return $count;
	}
}