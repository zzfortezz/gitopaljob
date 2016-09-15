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
class Opaljob_Query {
	
	public static function get_companies( $args = array() ){
	 	$default = array(
			'post_type'         => 'opaljob_company',
			'posts_per_page'    => 10,
		);
		$args = array_merge( $default, $args );
 		return new WP_Query( $args );
	}

	public static function get_resumes( $args = array() ){
	 	$default = array(
			'post_type'         => 'opaljob_resume',
			'posts_per_page'    => 10,
		);
		$args = array_merge( $default, $args );
 		return new WP_Query( $args );
	}

 	public static function get_company_work( $post_id = null, $company_id = null, $per_page = 10 ) {
		if ( null == $post_id ) {
			$post_id = get_the_ID();
		}

		$args = array(
			'post_type'         => 'opaljob_work',
			'posts_per_page'    => $per_page,
			'post__not_in' 		=> array($post_id),

			'meta_query'        => array(
				array(
					'key'       => OPALJOB_WORK_PREFIX . 'company',
					'value'     => $company_id,
					'compare'   => '=',
				),
			),
		);
		
		return new WP_Query( $args );
	}

	public static function getFeaturedWorks( $args=array() ){
		$default = array(
			'post_type'         => 'opaljob_work',
			'posts_per_page'	=> 10,
			'meta_query'        => array(
				array(
					'key'       => OPALJOB_WORK_PREFIX . 'featured',
					'value'     => 'on',
					'compare'   => '=',
				),
			),
		 
		);

		$args = array_merge( $default, $args );
		return new WP_Query( $args );
	}

	public static function getWorkQuery( $args=array() ){
		$default = array(
			'post_type'         => 'opaljob_work',
			'posts_per_page'	=> 7 ,
			
		);

		$args = array_merge( $default, $args );
	 	if( isset($args['sortable']) ){
	 		$tmp = explode( "_", $args['sortable'] );

	 		if( count($tmp) == 2 ){

	 			$search = array( 
					'meta_key' 			=> OPALJOB_WORK_PREFIX.'price',
					'orderby'   => $tmp[0],
					'order'     => $tmp[1]
				);
	 			switch ( $tmp[0] ) {
	 				case 'price':
	 						
	 					$search['meta_key'] = OPALJOB_WORK_PREFIX.'price';
	 					break;
	 			}
	 		}
			unset( $args['sortable'] );
			$args = array_merge( $search, $args );
	 	}
		return new WP_Query( $args );
	}
	public static function getCompanyQuery( $args=array() ){
		$args = array(
			'post_type'         => 'opaljob_company',
			'post_status'	=> 'any',
			'posts_per_page'	=> -1 ,			
		);
		
		return new WP_Query( $args );
	}
	public static function get_company_by_work( $post_id = null ) {
		if ( null == $post_id ) {
			$post_id = get_the_ID();
		}
		$company_id = get_post_meta( $post_id, OPALJOB_WORK_PREFIX . 'company', true );

		return $company_id;
	}

	public static function select_resume_by_user(){
		$user_id = get_current_user_id();
 		$args = array(
 			'post_type' => 'opaljob_resume',
 			'post_status'	=> 'any',
 			'meta_query'        => array(
				array(
					'key'       => OPALJOB_RESUME_PREFIX . 'user_meta_id',
					'value'     => $user_id,
					'compare'   => '=',
				),
			),
 			
 		);
 		$loop = new WP_Query($args);
 		$resume = '';

 		if( $loop->have_posts() ){
  			$resume .= '<select name="resume">';			
 			while( $loop->have_posts() ){  $loop->the_post();
 				$resume .= '<option value="'.get_the_ID().'">'.get_the_title().'</option>';
 			}
 			$resume .= '</select>';
 		}
 		

		wp_reset_postdata();

		return  $resume;
	}

	public static function select_year_experience(){
		$qvalue = isset($_GET['year_experience'])?$_GET['year_experience']:"";
 		$args = array(
 			'post_type' => 'opaljob_resume',
 			'post_status'	=> 'any',
			
 			
 		);
 		$loop = new WP_Query($args);
 		$arrays = array();
 		if( $loop->have_posts() ){			
 			while( $loop->have_posts() ){  $loop->the_post();
 				$arrays[] = get_post_meta(get_the_ID(),OPALJOB_RESUME_PREFIX . 'year_experience',true);
 			}
 		}
 		
 		$arrays = array_unique($arrays);
		wp_reset_postdata();
		$output = '<select name="year_experience" id="year_experience'.rand().'" class="form-control">';
		$output .='<option value="">'.__('No.Year Experience','opaljob').'</option>';
		foreach ($arrays as $key => $array) {
			$selected = $array == $qvalue ? 'selected="selected"':'';
			$output .='<option '.$selected.' value="'.$array.'">'.$array.'</option>';
		}
		$output .= '</select>';
		return  $output;
	}

	public static function get_resume_location(){
		$qvalue = isset($_GET['location'])?$_GET['location']:"";

 		$terms = get_terms('opaljob_location');
 		$output = '<select name="location" id="location'.rand().'" class="form-control">';
		$output .='<option value="">'.__('Select Location','opaljob').'</option>';
 		foreach ($terms as $key => $term) {
 			$selected = $term->term_id == $qvalue ? 'selected="selected"':'';
			$output .='<option '.$selected.' value="'.$term->term_id.'">'.$term->name.'</option>';
 		}
 		$output .= '</select>';
		return $output;
	}

	public static function get_resume_type(){
		$qvalue = isset($_GET['types'])?$_GET['types']:"";
 		$terms = get_terms('opaljob_types');
 		$output = '<select name="type" id="types'.rand().'" class="form-control">';
		$output .='<option value="">'.__('Select Type','opaljob').'</option>';
 		foreach ($terms as $key => $term) {
 			$selected = $term->term_id == $qvalue ? 'selected="selected"':'';
			$output .='<option '.$selected.' value="'.$term->term_id.'">'.$term->name.'</option>';
 		}
 		$output .= '</select>';
		return $output;
	}

	public static function get_resume_category(){
		$qvalue = isset($_GET['category'])?$_GET['category']:"";
 		$terms = get_terms('work_category');
 		$output = '<select name="category" id="category'.rand().'" class="form-control">';
		$output .='<option value="">'.__('Select Category','opaljob').'</option>';
 		foreach ($terms as $key => $term) {
 			$selected = $term->term_id == $qvalue ? 'selected="selected"':'';
			$output .='<option '.$selected.' value="'.$term->term_id.'">'.$term->name.'</option>';
 		}
 		$output .= '</select>';
		return $output;
	}

	public static function get_works_by_user( $post_id, $user_id = null, $per_page = -1 ) {
		
		$args = array(
			'post_type'         => 'opaljob_work',
			'posts_per_page'    => $per_page,
			'post_status' => 'any',
			'author'       => $user_id
			
		);
		if ( !empty( $post_id ) ) {
			$args['post__not_in'] = array($post_id);
		}
		
		return new WP_Query( $args );
	}

	public static function get_wishlists( $post_id, $user_id = null, $per_page = -1 ) {
		$saves = get_option("opaljob_saves_job_{$user_id}", array());
		if(empty($saves)) {
			$saves =array(0);
		}
		$args = array(
			'post_type'         => 'opaljob_work',
			'posts_per_page'    => $per_page,
			'post_status' => 'any',	
			'post__in'=>array_keys($saves)	
		);
		if ( !empty( $post_id ) ) {
			$args['post__not_in'] = array($post_id);
		}
	
		return new WP_Query( $args );
	}
	public static function get_resumes_by_user( $post_id, $user_id = null, $per_page = -1 ) {
		
		$args = array(
			'post_type'         => 'opaljob_resume',
			'posts_per_page'    => $per_page,
			'post_status' => 'any',
			'author'       => $user_id
			
		);
		if ( !empty( $post_id ) ) {
			$args['post__not_in'] = array($post_id);
		}
		
		return new WP_Query( $args );
	}

	public static function get_invoice_by_user( $post_id, $user_id = null, $per_page = -1 ) {
		
		$args = array(
			'post_type'         => 'opaljob_invoice',
			'posts_per_page'    => $per_page,
			'post_status' => 'any',
			'author'       => $user_id			
		);
		if ( !empty( $post_id ) ) {
			$args['post__not_in'] = array($post_id);
		}
		
		return new WP_Query( $args );
	}

	public static function get_post_id_company( $user_id = null, $per_page = -1 ) {
		
		$args = array(
			'post_type'         => 'opaljob_company',
			'posts_per_page'    => $per_page,
			'post_status' => 'any',
			'meta_query'        => array(
				array(
					'key'       => OPALJOB_COMPANY_PREFIX . 'user_meta_id',
					'value'     => $user_id,
					'compare'   => '=',
				),
			),
		);
		
		$loop = new WP_Query( $args );
		$post_id ='';

		while ( $loop->have_posts() ) : $loop->the_post(); global $post; 
			$post_id = get_the_ID();
		endwhile;

		return $post_id;
	}
	public static function get_apply_by_user($post_id, $user_id = null, $per_page = -1 ) {
		if(get_user_role() == 'opaljob_company' || get_user_role() == 'administrator') { 
			$key = OPALJOB_APPLY_PREFIX . 'company_id';
		} elseif(get_user_role() == 'opaljob_jobseeker') {
			$key = OPALJOB_APPLY_PREFIX . 'jobseeker_id';
		}
		$args = array(
			'post_type'         => 'opaljob_apply',
			'posts_per_page'    => $per_page,
			'post_status' => 'any',
			'meta_query'        => array(
				array(
					'key'       => $key,
					'value'     => $user_id,
					'compare'   => '=',
				),
			),
		);

		if ( !empty( $post_id ) ) {
			$args['post__not_in'] = array($post_id);
		}		
		
		return new WP_Query( $args );
	}
	/**
	 * Gets related
	 *
	 * @access public
	 * @return array
	 */
	public static function getRelated($post_id){
		$args = array(
			'post_type'      => 'opaljob_work',
			'post_status'    => 'publish',
			'posts_per_page' => 3,
			'post__not_in'   => array($post_id)
		);

		$opaljob_categorys 	= get_the_terms( $post_id, 'work_category' );
		$opaljob_types 		= get_the_terms( $post_id, 'opaljob_types' );
		$opaljob_locations 	= get_the_terms( $post_id, 'opaljob_location' );
		$opaljob_tags 		= get_the_terms( $post_id, 'opaljob_tags' );

		$args['tax_query'] = array( 'relation' => 'AND' );
		if ( $opaljob_categorys ) {
			$term_job_category = array(); 
			foreach ($opaljob_categorys as $opaljob_category) {
				$term_job_category = array_merge( $term_job_category, (array) $opaljob_category->slug );
			}
			$args['tax_query'][] = array(
				'taxonomy' => 'work_category',
				'field' => 'slug',
				'terms' => $term_job_category
			);
		}

		if ( $opaljob_types ) {
			$term_job_type = array();
			foreach ($opaljob_types as $opaljob_type) {
				$term_job_type = array_merge( $term_job_type, (array) $opaljob_type->slug );
			}
			$args['tax_query'][] = array(
				'taxonomy' => 'opaljob_types',
				'field' => 'slug',
				'terms' => $term_job_type
			);
		}

		if ( $opaljob_tags ) {
			$term_job_type = array();
			foreach ($opaljob_tags as $opaljob_type) {
				$term_job_type = array_merge( $term_job_type, (array) $opaljob_type->slug );
			}
			$args['tax_query'][] = array(
				'taxonomy' => 'opaljob_tags',
				'field' => 'slug',
				'terms' => $term_job_type
			);
		}
		
		if( $opaljob_locations ) {
			$term_job_location = array(); 
			foreach ($opaljob_locations as $opaljob_location) {
				$term_job_location = array_merge( $term_job_location, (array) $opaljob_location->slug );
			}
			$args['tax_query'][] = array(
				'taxonomy' => 'opaljob_location',
				'field' => 'slug',
				'terms' => $term_job_location
			);
		}
		return new WP_Query( $args );
	}

}