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
class Opaljob_PostType_Apply{

	/**
	 *
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'fields_front' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
		add_filter( 'enter_title_here', array( __CLASS__, 'opal_change_title_text'));
		define( 'OPALJOB_APPLY_PREFIX', 'opaljob_apply_' );
	}

	/**
	 *
	 */
	public static function definition(){
		
		$labels = array(
			'name'                  => __( 'Opal Applies', 'opaljob' ),
			'singular_name'         => __( 'Work', 'opaljob' ),
			'add_new'               => __( 'Add New Apply', 'opaljob' ),
			'add_new_item'          => __( 'Add New Apply', 'opaljob' ),
			'edit_item'             => __( 'Edit Apply', 'opaljob' ),
			'new_item'              => __( 'New Apply', 'opaljob' ),
			'all_items'             => __( 'All Applies', 'opaljob' ),
			'view_item'             => __( 'View Apply', 'opaljob' ),
			'search_items'          => __( 'Search Apply', 'opaljob' ),
			'not_found'             => __( 'No Applies found', 'opaljob' ),
			'not_found_in_trash'    => __( 'No Applies found in Trash', 'opaljob' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Opal Applies', 'opaljob' ),
		);

		$labels = apply_filters( 'opaljob_postype_apply_labels' , $labels );

		register_post_type( 'opaljob_apply',
			array(
				'labels'            => $labels,
				'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author', 'excerpt' ),
				'public'            => true,
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => __( 'work-apply', 'opaljob' ) ),
				'menu_position'     => 51,
				'categories'        => array(),
				'menu_icon'         => 'dashicons-admin-home',
		 
			)
		);
		register_post_status( 'approve', array(
            'label'                     => __( 'approve', 'opaljob' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop( 'Job Approve <span class="count">(%s)</span>', 'Job Approve <span class="count">(%s)</span>' ),
	        ) 			      
	    );

	    register_post_status( 'rejected', array(
            'label'                     => __( 'rejected', 'opaljob' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop( 'Job Rejected <span class="count">(%s)</span>', 'Job Rejected <span class="count">(%s)</span>' ),
	        ) 			      
	    );
	}

	/**
	 *
	 */
	public static function metaboxes_fields(){
		$prefix = OPALJOB_APPLY_PREFIX;
		$fields =  array(
			 
			array(
				'name' => __( 'Email Jobseeker', 'opaljob' ),
				'id'   => "{$prefix}email",
				'type' => 'text'
			),
			array(
				'name' => __( 'Position applying', 'opaljob' ),
				'id'   => "{$prefix}position_applying",
				'type' => 'text'
			), 
			array(
				'name' => __( 'Resume', 'opaljob' ),
				'id'   => "{$prefix}resume",
				'type'      => 'file',
				'desc'		=> 'Allowed file: doc,pdf'
			),
			array(
				'name' => __( 'Company ID', 'opaljob' ),
				'id'   => "{$prefix}company_id",
				'type'      => 'hidden',
			),
			array(
				'name' => __( 'Jobseeker ID', 'opaljob' ),
				'id'   => "{$prefix}jobseeker_id",
				'type'      => 'hidden',
			),
			array(
				'name' => __( 'Resume ID', 'opaljob' ),
				'id'   => "{$prefix}resume_id",
				'type'      => 'hidden',
			),
			array(
				'name' => __( 'Alert Company', 'opaljob' ),
				'id'   => "{$prefix}alert_company",
				'type'      => 'hidden',
			),
			array(
				'name' => __( 'Alert Jobseeker', 'opaljob' ),
				'id'   => "{$prefix}alert_jobseeker",
				'type'      => 'hidden',
			),
			array(
				'name' => __( 'Alert Jobseeker', 'opaljob' ),
				'id'   => "{$prefix}message_apply",
				'type'      => 'hidden',
			),	
		);  


		return apply_filters( 'opaljob_postype_apply_metaboxes_fields' , $fields );
	}
	/**
	 *
	 */
	public static function metaboxes_general_fields() {
		$prefix = OPALJOB_APPLY_PREFIX;
		if ( ! empty( $_GET['id'] ) ) {
			$post = get_post( $_GET['id'] );
		}

		$fields = array(
			array(
				'id'                => $prefix . 'post_type',
				'type'              => 'hidden',
				'default'           => 'opaljob_apply',
			),
			array(
				'name'              => __( 'Title', 'opaljob' ),
				'id'                => $prefix . 'title',
				'type'              => 'text_medium',
				'default'           => ! empty( $post ) ? $post->post_title : '',
			),
			array(
				'name'              => __( 'Description', 'opaljob' ),
				'id'                => $prefix . 'text',
				'type'              => 'wysiwyg',
				'default'           => ! empty( $post ) ? $post->post_content : '',
			)
		);

		return apply_filters( 'opaljob_postype_apply_metaboxes_fields_general' , $fields );
	}
	/**
	 *
	 */
	public static function metaboxes(array $metaboxes){
		$prefix = OPALJOB_APPLY_PREFIX;
	    
	    $metaboxes[ $prefix . 'info' ] = array(
			'id'                        => $prefix . 'info',
			'title'                     => __( 'Apply Information', 'opaljob' ),
			'object_types'              => array( 'opaljob_apply' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_fields()
		);

	    return $metaboxes;
	}
	/**
	 * Defines custom front end fields
	 *
	 * @access public
	 * @param array $metaboxes
	 * @return array
	 */
	public static function fields_front( array $metaboxes ) {
		$prefix = OPALJOB_APPLY_PREFIX;
		if ( ! is_admin() ) {

			
			$fields = array_merge( self::metaboxes_general_fields() , self::metaboxes_fields() );

			$metaboxes[ $prefix . 'front' ] = array(
				'id'                        => $prefix . 'front',
				'title'                     => __( 'Name and Description', 'opaljob' ),
				'object_types'              => array( 'opaljob_work' ),
				'context'                   => 'normal',
				'priority'                  => 'high',
				'show_names'                => true,
				'fields'                    => $fields
			);


		}
		return $metaboxes;
	}
	/**
	 *
	 */
	public static function opal_change_title_text( $title ){
	    $screen = get_current_screen();
	 
	    if  ( 'opaljob_apply' == $screen->post_type ) {
	         $title = 'Enter company';
	    }
	 
	    return $title;
	}
}

Opaljob_PostType_Apply::init();