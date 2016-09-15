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
class Opaljob_Search{

	/**
	 *
	 */
	public static function getSearchResultsQuery(){
		
		global $paged;

		
		$posts_per_page = 10; 

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        if(isset($_GET['search_text'])) {
        	$search_text = $_GET['search_text'];
        } else {
        	$search_text = '';
        }
       
		$infos = array();
		
		$args = array(
            'posts_per_page'=> $posts_per_page,
            'paged' 		=> $paged,
            'post_type' 	=> 'opaljob_work',
            'post_status' 	=> 'publish',
            's'				=> $search_text
        );
		
		$tax_query = array();

		if( isset( $_GET['location']) && (int) $_GET['location'] > 0 ){
			$tax_query = array(
			    array(
			        'taxonomy' => 'opaljob_location',
			        'field'    => 'id',
			        'terms'    => (int)$_GET['location'],
			    ),
			);	
		}

		if( isset( $_GET['types']) && (int) $_GET['types'] > 0 ){
			$tax_query = array(
			    array(
			        'taxonomy' => 'opaljob_types',
			        'field'    => 'id',
			        'terms'    => (int)$_GET['types'],
			    ),
			);	
		}
		
		
		if( $tax_query  ){
			$args['tax_query'] = array('relation' => 'AND');
			$args['tax_query'] = array_merge( $args['tax_query'], $tax_query );
		}
		
		$args['meta_query'] = array('relation' => 'AND');

     	// echo '<Pre>'.print_r( $args , 1 ); die; 
		$query = new WP_Query($args);
        wp_reset_postdata();
       
        return $query;
	}
	/**
	 *
	 */
	public static function getSearchResumeResultsQuery(){
		
		global $paged;

		
		$posts_per_page = 10; 
		
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $search_text = $_GET['search_text'] ? $_GET['search_text'] : '';
		$infos = array();
		
		$args = array(
            'posts_per_page' => $posts_per_page,
            'paged' 		 => $paged,
            'post_type' 	 => 'opaljob_resume',
            'post_status' 	 => 'publish',
            's'				=> $search_text
        );
		
		$tax_query = array();

		if( isset( $_GET['location']) && (int) $_GET['location'] > 0 ){
			$tax_query = array(
			    array(
			        'taxonomy' => 'opaljob_location',
			        'field'    => 'id',
			        'terms'    => (int)$_GET['location'],
			    ),
			);	
		}

		if( isset( $_GET['category']) && (int) $_GET['category'] > 0 ){
			$tax_query = array(
			    array(
			        'taxonomy' => 'work_category',
			        'field'    => 'id',
			        'terms'    => (int)$_GET['category'],
			    ),
			);	
		}
		
		if( $tax_query  ){
			$args['tax_query'] = array('relation' => 'AND');
			$args['tax_query'] = array_merge( $args['tax_query'], $tax_query );
		}
		$args['meta_query'] = array('relation' => 'AND');
		if( isset( $_GET['year_experience']) && (int) $_GET['year_experience'] > 0 ){
			array_push($args['meta_query'], array(
                'key'     => OPALJOB_RESUME_PREFIX.'year_experience',
            	'value'   => (int)$_GET['year_experience'],
            	'compare' => '>=',
            	'type' => 'NUMERIC'
            ));	
		}
		

     	// echo '<Pre>'.print_r( $args , 1 ); die; 
		$query = new WP_Query($args);

        wp_reset_postdata();
       
        return $query;
	}
	

	/**
	 *
	 */
	public static function init(){
		add_action( 'wp_ajax_opaljob_ajx_get_works', array( __CLASS__, 'getSearchJson' ) );
		add_action( 'wp_ajax_nopriv_opaljob_ajx_get_works', array( __CLASS__, 'getSearchJson' ) );
		add_action( 'wp_ajax_opaljob_ajax_get_resumes', array( __CLASS__, 'getSearchResumeJson' ) );
		add_action( 'wp_ajax_nopriv_opaljob_ajax_get_resumes', array( __CLASS__, 'getSearchResumeJson' ) );
	}

	/**
	 *
	 */
	public static function getSearchJson(){

	 
		$query = self::getSearchResultsQuery();

		$output = array(); 

		while( $query->have_posts() ) {

	        $query->the_post();
			$work = opaljob_works( get_the_ID() );
			$output[]  = $work->getMetaSearchObjects();
	    }        
	 
	    wp_reset_query();

	    echo json_encode( $output ); exit;

	}
	/**
	 *
	 */
	public static function getSearchResumeJson(){
	 
		$query = self::getSearchResumeResultsQuery();

		return;

	}
	/**
	 *
	 */
	public static function renderHorizontalForm(){
	
		echo Opaljob_Template_Loader::get_template_part( 'parts/search-form-h' );
	}
	/**
	 *
	 */
	public static function renderResumeHorizontalForm(){
	
		echo Opaljob_Template_Loader::get_template_part( 'parts/search-resume-form-h' );
	}

	/**
	 *
	 */
	public static function renderVerticalForm(){
	
		echo Opaljob_Template_Loader::get_template_part( 'parts/search-form-v' );
	}
	/**
	 *
	 */
	public static function renderResumeVerticalForm(){
	
		echo Opaljob_Template_Loader::get_template_part( 'parts/search-resume-form-v' );
	}
	/**
	 *
	 */
	public static function renderFieldPrice(){
		
	}

	/**
	 *
	 */
	public static function renderFieldArea(){
		
	}
}

Opaljob_Search::init();
?>