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

/**
 *
 */
function opaljob_template_init(){
	if( isset($_GET['display']) && ($_GET['display']=='list' || $_GET['display']=='grid') ){  
		setcookie( 'opaljob_displaymode', trim($_GET['display']) , time()+3600*24*100,'/' );
		$_COOKIE['opaljob_displaymode'] = trim($_GET['display']);
	}
}

add_action( 'init', 'opaljob_template_init' );

function opaljob_get_current_url(){

	global $wp;
	$current_url = home_url(add_query_arg(array(),$wp->request));
 	
 	return $current_url;
}

/**
 *
 */
function opaljob_render_sortable_dropdown( $selected='', $class='' ){


	$output = '';
		$modes = array(
			'price_asc' => __( 'Price Ascending', 'opaljob' ),
			'price_desc' => __( 'Price Desending', 'opaljob' ),
			'title_asc' => __( 'Title Ascending', 'opaljob' ),
			'title_desc' => __( 'Title Desending', 'opaljob' )
		);
		$modes  = apply_filters( 'opaljob_sortable_modes', $modes );
		$modes  = array_merge( array('' => __('Sort By','opaljob') ), $modes );
		$output = '<form id="opaljob-sortable-form" action="" method="POST"><select name="opalsortable" class="form-control sortable-dropdown" >';
		foreach( $modes as $key => $mode ){

			$sselected = $key == $selected ? 'selected="selected"' : "";
			$output .= '<option '.$sselected.' value="'.$key.'">'.$mode.'</option>';
		}
 
		$output .= '</select></form>';

	return $output;
}

/**
 *
 */
function opaljob_show_display_modes($default = 'list'){
	global $wp;
	$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );  
	$op_display = opaljob_get_display_mode($default);

	echo '<form action="'.  $current_url  .'" class="display-mode" method="get">';
		echo '<button title="'.esc_html__('Grid','opaljob').'" class="btn '.($op_display == 'grid' ? 'active' : '').'" value="grid" name="display" type="submit"><i class="fa fa-th"></i></button>';	
		echo '<button title="'.esc_html__( 'List', 'opaljob' ).'" class="btn '.($op_display == 'list' ? 'active' : '').'" value="list" name="display" type="submit"><i class="fa fa-th-list"></i></button>';	
	echo '</form>'; 
}

function opaljob_get_display_mode($default = ''){
	$op_display = $default ? $default : opaljob_options('displaymode', 'grid');
	if ( isset($_COOKIE['opaljob_displaymode']) ) {
		$op_display = $_COOKIE['opaljob_displaymode'];
	}
	return $op_display;
}
/**
 *
 */
function opaljob_get_search_link() {
    return get_permalink( opaljob_get_option( 'search_work_page', '/' ) );
}

function opaljob_get_search_resume_link() {
    return get_permalink( opaljob_get_option( 'search_resume_page', '/' ) );
}

function opaljob_submssion_page(){
	return get_permalink( opaljob_get_option( 'submission_page', '/' ) );
}

function opaljob_submssion_list_page(){
	return get_permalink( opaljob_get_option( 'submission_list_page', '/' ) );
}

function opaljob_submssion_list_wishlist_page(){
	return get_permalink( opaljob_get_option( 'submission_list_wishlist_page', '/' ) );
}

function opaljob_submssion_profile_page(){
	return get_permalink( opaljob_get_option( 'submission_profile_page', '/' ) );
}

function opaljob_submssion_resume_page(){
	return get_permalink( opaljob_get_option( 'submission_resume_page', '/' ) );
}
function opaljob_submssion_resume_list_page(){
	return get_permalink( opaljob_get_option( 'submission_list_resume_page', '/' ) );
}

function opaljob_submssion_job_apply_page() {
	return get_permalink( opaljob_get_option( 'submission_job_apply_page', '/' ) );
}
function opaljob_submission_edit( $args=array() ){
	$redirect = opaljob_submssion_page();
		
	if ( ! empty( $args ) ) {
		if ( is_string( $args ) ){
			$args = str_replace( '?', '', $args );
		}	
		$args = wp_parse_args( $args );
		$redirect = add_query_arg( $args, $redirect );
	}

	return $redirect;
}
function opaljob_submission_remove( $args=array() ){
	$redirect = opaljob_submssion_list_wishlist_page();
		
	if ( ! empty( $args ) ) {
		if ( is_string( $args ) ){
			$args = str_replace( '?', '', $args );
		}	
		$args = wp_parse_args( $args );
		$redirect = add_query_arg( $args, $redirect );
	}

	return $redirect;
}
function opaljob_submission_delete( $args=array() ){
	$redirect = opaljob_submssion_list_page();
		
	if ( ! empty( $args ) ) {
		if ( is_string( $args ) ){
			$args = str_replace( '?', '', $args );
		}	
		$args = wp_parse_args( $args );
		$redirect = add_query_arg( $args, $redirect );
	}

	return $redirect;
}

function opaljob_submission_resume_edit( $args=array() ){
	$redirect = opaljob_submssion_resume_page();
		
	if ( ! empty( $args ) ) {
		if ( is_string( $args ) ){
			$args = str_replace( '?', '', $args );
		}	
		$args = wp_parse_args( $args );
		$redirect = add_query_arg( $args, $redirect );
	}

	return $redirect;
}

function opaljob_submission_resume_delete( $args=array() ){
	$redirect = opaljob_submssion_resume_list_page();
		
	if ( ! empty( $args ) ) {
		if ( is_string( $args ) ){
			$args = str_replace( '?', '', $args );
		}	
		$args = wp_parse_args( $args );
		$redirect = add_query_arg( $args, $redirect );
	}

	return $redirect;
}

function opaljob_submission_apply_delete( $args=array() ){
	$redirect = opaljob_submssion_job_apply_page();
		
	if ( ! empty( $args ) ) {
		if ( is_string( $args ) ){
			$args = str_replace( '?', '', $args );
		}	
		$args = wp_parse_args( $args );
		$redirect = add_query_arg( $args, $redirect );
	}

	return $redirect;
}

/**
 * Single work logic functions
 */
 

/**
 * Single work logic functions
 */
function opaljob_work_meta(){
	echo Opaljob_Template_Loader::get_template_part( 'single-work/meta' );
}
/**
 * Single work logic functions
 */
function opaljob_work_preview(){
	echo Opaljob_Template_Loader::get_template_part( 'single-work/preview' );
}

/**
 *
 */
function opaljob_work_content(){
	echo Opaljob_Template_Loader::get_template_part( 'single-work/content' );
}

/**
 *
 */

function opaljob_work_information(){
	echo Opaljob_Template_Loader::get_template_part( 'single-work/information' );
}

/**
 *
 */
function opaljob_account_signin(){
	echo Opaljob_Template_Loader::get_template_part( 'account/signin' );
}

function opaljob_account_signup(){
	echo Opaljob_Template_Loader::get_template_part( 'account/signup' );
}

function opaljob_account_reset(){
	echo Opaljob_Template_Loader::get_template_part( 'account/reset' );
}
/**
 *
 */
function opaljob_work_categories(){
	echo Opaljob_Template_Loader::get_template_part( 'single-work/categories' );
}
function opaljob_work_tags(){
	echo Opaljob_Template_Loader::get_template_part( 'single-work/tags' );
}

function opaljob_work_related(){
	echo Opaljob_Template_Loader::get_template_part( 'single-work/related' );	
}

function opaljob_work_map(){
	echo Opaljob_Template_Loader::get_template_part( 'single-work/map' );	
}

function opaljob_work_save(){
	echo Opaljob_Template_Loader::get_template_part( 'single-work/wishlist' );	
}

function opaljob_work_share(){
	echo Opaljob_Template_Loader::get_template_part( 'single-work/share-job' );	
}

function opaljob_work_company(){
	echo Opaljob_Template_Loader::get_template_part( 'single-work/company' );	
}

function opaljob_work_apply(){
	echo Opaljob_Template_Loader::get_template_part( 'single-work/applywork' );	
}

function opaljob_work_video(){
	echo Opaljob_Template_Loader::get_template_part( 'single-work/video' );	
}

function opaljob_works_same_company(){
	echo Opaljob_Template_Loader::get_template_part( 'single-work/samecompany' );	
}

 

function opaljob_work_location(){
	echo Opaljob_Template_Loader::get_template_part( 'single-work/location' );	
}
 


add_action( 'opaljob_single_work_preview', 'opaljob_work_preview', 15 );


add_action( 'opaljob_single_work_summary', 'opaljob_work_company', 10 );
add_action( 'opaljob_single_work_summary', 'opaljob_work_apply', 11 );
add_action( 'opaljob_single_work_summary', 'opaljob_work_save', 12 );
add_action( 'opaljob_single_work_summary', 'opaljob_work_share', 13 );

//add_action( 'opaljob_after_single_work_summary', 'opaljob_work_video', 20 );
//add_action( 'opaljob_after_single_work_summary', 'opaljob_work_map', 40 );
add_action( 'opaljob_after_single_work_summary', 'opaljob_work_categories', 5 );
add_action( 'opaljob_after_single_work_summary', 'opaljob_work_tags', 25 );
add_action( 'opaljob_after_single_work_summary', 'opaljob_work_related', 30 );

/**
 *
 */
add_action( 'opaljob_after_single_work_summary', 'opaljob_works_same_company', 35 );


function opaljob_company_summary() {
	echo Opaljob_Template_Loader::get_template_part( 'single-company/summary' );	
}

function opaljob_company_works() {
	echo Opaljob_Template_Loader::get_template_part( 'single-company/works' );
}

function opaljob_company_map() {
	echo Opaljob_Template_Loader::get_template_part( 'single-company/map' );
}

function opaljob_company_contactform() {
	global $post;
	$args = array( 'post_id' => $post->ID );
	echo Opaljob_Template_Loader::get_template_part( 'single-company/form', $args );
}


add_action( 'opaljob_single_company_summary', 'opaljob_company_summary', 5 ); 
add_action( 'opaljob_single_content_company_after', 'opaljob_company_works', 15 );

add_action( 'opaljob_single_content_company_after', 'opaljob_company_map', 15 );
/**
 *
 */
function opaljob_company_navbar(){

}
add_action( 'opaljob_single_company_summary', 'opaljob_company_navbar', 5 ); 
