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
class Opaljob_PostType_Company{

	/**
	 *
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'fields_front' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
		add_filter( 'enter_title_here', array( __CLASS__, 'opal_change_title_text'));
		define( 'OPALJOB_COMPANY_PREFIX', 'opaljob_agt_' );
	}

	/**
	 *
	 */
	public static function definition(){
		
		$labels = array(
			'name'                  => __( 'Opal Companies', 'opaljob' ),
			'singular_name'         => __( 'Work', 'opaljob' ),
			'add_new'               => __( 'Add New Company', 'opaljob' ),
			'add_new_item'          => __( 'Add New Company', 'opaljob' ),
			'edit_item'             => __( 'Edit Company', 'opaljob' ),
			'new_item'              => __( 'New Company', 'opaljob' ),
			'all_items'             => __( 'All Companies', 'opaljob' ),
			'view_item'             => __( 'View Company', 'opaljob' ),
			'search_items'          => __( 'Search Company', 'opaljob' ),
			'not_found'             => __( 'No Companies found', 'opaljob' ),
			'not_found_in_trash'    => __( 'No Companies found in Trash', 'opaljob' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Opal Companies', 'opaljob' ),
		
		);

		$labels = apply_filters( 'opaljob_postype_company_labels' , $labels );

		register_post_type( 'opaljob_company',
			array(
				'labels'            => $labels,
				'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author', 'excerpt' ),
				'public'            => true,
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => __( 'work-company', 'opaljob' ) ),
				'menu_position'     => 51,
				'categories'        => array(),
				'menu_icon'         => 'dashicons-admin-home',
		 
			)
		);
	}

	/**
	 *
	 */
	public static function metaboxes_fields(){
		$prefix = OPALJOB_COMPANY_PREFIX;
		$user_id 	= get_current_user_id();
		$fields =  array(
			array(
				'id'   => "{$prefix}avatar",
				'name' => __( 'Logo Company', 'opaljob' ),
				'type' => 'file',
				'description'  => __( 'Select one or more images to show as gallery', 'opaljob' ),
			),


			array(
			    'name'     => __('Tag Skills' ,'opaljob'),
			    'desc'     => __('Select one or multiple to show company skill', 'opaljob'),
			    'id'       => $prefix."tags",
			    'taxonomy' => 'opaljob_tags', //Enter Taxonomy Slug
			    'type'     => 'taxonomy_multicheck',
			) ,


			array(
				'name' 		=> __( 'user_meta_id', 'opaljob' ),
				'id'   		=> "{$prefix}user_meta_id",
				'type' 		=> 'hidden',
				'default' 	=> $user_id
			), 
		
			array(
				'name' => __( 'Email', 'opaljob' ),
				'id'   => "{$prefix}email",
				'type' => 'text'
			), 

			array(
				'name' => __( 'Phone', 'opaljob' ),
				'id'   => "{$prefix}phone",
				'type' => 'text'
			), 

			array(
				'name' => __( 'Mobile', 'opaljob' ),
				'id'   => "{$prefix}mobile",
				'type' => 'text'
			), 

			array(
				'name' => __( 'Fax', 'opaljob' ),
				'id'   => "{$prefix}fax",
				'type' => 'text'
			), 
			array(
				'name' => __( 'Website', 'opaljob' ),
				'id'   => "{$prefix}web",
				'type' => 'text'
			), 

			
			array(
				'name' => __( 'Twitter', 'opaljob' ),
				'id'   => "{$prefix}twitter",
				'type' => 'text'
			), 

			array(
				'name' => __( 'Facebook', 'opaljob' ),
				'id'   => "{$prefix}facebook",
				'type' => 'text'
			), 

			array(
				'name' => __( 'Google', 'opaljob' ),
				'id'   => "{$prefix}google",
				'type' => 'text'
			), 

			array(
				'name' => __( 'LinkedIn', 'opaljob' ),
				'id'   => "{$prefix}linkedin",
				'type' => 'text'
			), 

			array(
				'name' => __( 'Pinterest', 'opaljob' ),
				'id'   => "{$prefix}pinterest",
				'type' => 'text'
			),
			array(
				'name' => __( 'Instagram', 'opaljob' ),
				'id'   => "{$prefix}instagram",
				'type' => 'text'
			),

			array(
				'name' => __( 'Video', 'opaljob' ),
				'id'   => "{$prefix}video",
				'type' => 'oembed'
			),

			array(
				'name' => __( 'Address', 'opaljob' ),
				'id'   => "{$prefix}address",
				'type' => 'text'
			), 

			array(
			    'name'     => __('Location' ,'opaljob'),
			    'desc'     => __('Select one, to add new you create in location of estate panel','opaljob'),
			    'id'       => $prefix."type",
			    'taxonomy' => 'opaljob_location', //Enter Taxonomy Slug
			    'type'     => 'taxonomy_select',
			) ,
			array(
				'id'            	=> "{$prefix}map",
				'name'          	=> __( 'Map', 'opaljob' ),
				'type'              => 'opal_map',
				'sanitization_cb'   => 'opal_map_sanitise',
                'split_values'      => true,
			)
		);  


		return apply_filters( 'opaljob_postype_company_metaboxes_fields' , $fields );
	}
	/**
	 *
	 */
	public static function metaboxes_general_fields() {
		$prefix = OPALJOB_COMPANY_PREFIX;
		if ( ! empty( $_GET['id'] ) ) {
			$post = get_post( $_GET['id'] );
		}

		$fields = array(
			array(
				'id'                => $prefix . 'post_type',
				'type'              => 'hidden',
				'default'           => 'opaljob_company',
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

		return apply_filters( 'opaljob_postype_company_metaboxes_fields_general' , $fields );
	}
	/**
	 *
	 */
	public static function metaboxes(array $metaboxes){
		$prefix = OPALJOB_COMPANY_PREFIX;
	    
	    $metaboxes[ $prefix . 'info' ] = array(
			'id'                        => $prefix . 'info',
			'title'                     => __( 'Company Information', 'opaljob' ),
			'object_types'              => array( 'opaljob_company' ),
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
		$prefix = OPALJOB_COMPANY_PREFIX;
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
	 
	    if  ( 'opaljob_company' == $screen->post_type ) {
	         $title = 'Enter company';
	    }
	 
	    return $title;
	}
}

Opaljob_PostType_Company::init();