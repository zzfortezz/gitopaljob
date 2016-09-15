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
	class Opaljob_Company{

		/**
		 *
		 */
		protected $id; 
		
		/**
		 *
		 */
		protected $content; 
		
		/**
		 *
		 */ 	
		static $_companies = array();

		/**
		 *
		 */
		public function __construct( $post_id=null ){

			global $post;
			$this->post = $post;
		 	$this->id = $post->ID; 
		 
		}

		/**
		 *
		 */
		public function get_socials(){

			$socials = array( 'facebook' 	=> '',
							  'twitter' 	=> '',
							  'pinterest' 	=> '',
							  'google' 		=> '',
							  'instagram' 	=> '',
							  'linkedIn' 	=> ''
			);
			
			$output = array();

			foreach( $socials as $social => $k ){
				$output[$social] = $this->getMeta( $key );
			} 

			return $output;
		}

		/**
		 *
		 */
		public function show_company_banner(){
			$url =  get_post_meta( $this->id , OPALJOB_COMPANY_PREFIX . "avatar", true );

			if( empty($url) ){
				echo  opaljob_get_image_placeholder( 'large' );
				return ;
			}

			echo '<img src="'.$url.'" title="'.esc_attr( $this->post->post_title ).'"/>';

			return ;
		}

		public function get_tag_skills(){

			return wp_get_post_terms( $this->id, "opaljob_tags"  );
		}
		/**
		 *
		 */
		public static function count_work_recuiter_post() {
			$args = array(
				'post_type'         => 'opaljob_work',
				'post_status'         => 'any',
				'meta_query'        => array(
					array(
						'key'       => OPALJOB_WORK_PREFIX . 'company',
						'value'     => get_the_ID(),
						'compare'   => '=',
					),
				),
			);
			
			$loop = new WP_Query($args);
	 		$count = $loop->found_posts();

	 		wp_reset_postdata();
			return $count;
		}

		/**
		 *
		 */
		public static function get_avatar_url( $userID ){
			if( !isset(self::$_companies[$userID]) ){	
				self::$_companies[$userID] = get_post_meta( $userID , OPALJOB_COMPANY_PREFIX . "avatar", true );
			}
			return self::$_companies[$userID]; 
		}

		/**
		 *
		 */
		public function getMeta( $key ){
			return get_post_meta( get_the_ID(), OPALJOB_COMPANY_PREFIX .  $key, true );
		}

		/**
		 *
		 */
		public static function render_contact_form( $post_id ){
			echo Opaljob_Template_Loader::get_template_part( 'single-company/form', array('post_id' => $post_id) );	
		}

		/**
		 *
		 */
		public static function renderBoxInfo( $post_id ){
 			$args = array(
 				'post_type' => 'opaljob_company',
 				'p'	=> $post_id
 			);
 			$loop = new WP_Query($args);

 			if( $loop->have_posts() ){
 				while( $loop->have_posts() ){  $loop->the_post();
 				 	echo Opaljob_Template_Loader::get_template_part( 'single-company/box' );
 				}
 			}
		 	wp_reset_postdata();
		}
	}
?>