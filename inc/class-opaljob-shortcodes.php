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
class Opaljob_Shortcodes{
	
	/**
	 *
	 */
	static $shortcodes; 

	/**
	 *
	 */
	public static function init(){
	 	
	 	self::$shortcodes = array(
	 		'change_company_profile' 	=> array( 'code' => 'change_company_profile', 'label' => __('Company Profile') ),
	 		'wishlists'    			=> array( 'code' => 'wishlists', 'label' => __('Save Works') ),
	 		'search_works'    			=> array( 'code' => 'search_works', 'label' => __('Search Works') ),
	 		'search_works_result'    	=> array( 'code' => 'search_works_result', 'label' => __('Search Works Result') ),
	 		'search_resumes'    		=> array( 'code' => 'search_resumes', 'label' => __('Search Resumes') ),
	 		'search_resumes_result'    	=> array( 'code' => 'search_resumes_result', 'label' => __('Search Resumes Result') ),
	 		'search_works_v'    		=> array( 'code' => 'search_works_v', 'label' => __('Search Works Vertical') ),
	 		'search_resumes_v'    		=> array( 'code' => 'search_resumes_v', 'label' => __('Search Resumes Vertical') ),
	 		'listing_job'				=> array( 'code' => 'listing_job', 'label' => __('Listing Job')),
	 		'featured_job'				=> array( 'code' => 'featured_job', 'label' => __('Featured Job')),
	 		'listing_company'			=> array( 'code' => 'listing_company', 'label' => __('Listing Company')),
	 		'account'    				=> array( 'code' => 'account', 'label' => __('Account') ),
	 	);

	 	foreach( self::$shortcodes as $shortcode ){
	 		add_shortcode( 'opaljob_'.$shortcode['code'] , array( __CLASS__, $shortcode['code'] ) );
	 	}
	 	
	 	if( is_admin() ){
	 		add_action( 'media_buttons', array( __CLASS__, 'shortcode_button' ) );
	 	}

	}

	public static function company_work(){
		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/company-work-listing' );
	}
	

	/**
	 *
	 */
	public static function search_works(){
		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/search-works', array( 'loop' => '') );
	}
	/**
	 *
	 */
	public static function search_works_result(){
		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/search-works-result', array( 'loop' => '') );
	}
	/**
	 *
	 */
	public static function wishlists(){
		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/save-works', array( 'loop' => '') );
	}
	/**
	 *
	 */
	public static function search_resumes(){
		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/search-resumes', array( 'loop' => '') );
	}
	/**
	 *
	 */
	public static function search_resumes_result(){
		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/search-resumes-result', array( 'loop' => '') );
	}
	/**
	 *
	 */
	public static function search_works_v(){
		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/search-works-v', array( 'loop' => '') );
	}
	/**
	 *
	 */
	public static function search_resumes_v(){
		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/search-resumes-v', array( 'loop' => '') );
	}
	/**
	 *
	 */
	public static function listing_job(){
		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/listing-job');
	}
	/**
	 *
	 */
	public static function featured_job(){
		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/featured-job');
	}
	/**
	 *
	 */
	public static function listing_company(){
		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/listing-company');
	}
	/**
	 *
	 */
	public static function account(){
		echo Opaljob_Template_Loader::get_template_part( 'shortcodes/account');
	}
	/**
	 *
	 */
	public static function change_company_profile(){

	}

	/**
	 *
	 */
	public static function shortcode_button() {

	 
	}
}

Opaljob_Shortcodes::init();

		


