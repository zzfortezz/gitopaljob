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
class Opaljob_PostType_Resume {

	/**
	 *
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'fields_front' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
		add_filter( 'enter_title_here', array( __CLASS__, 'opal_change_title_text'));
		define( 'OPALJOB_RESUME_PREFIX', 'opaljob_resume_' );
	}

	/**
	 *
	 */
	public static function definition(){
		
		$labels = array(
			'name'                  => __( 'Opal Resumes', 'opaljob' ),
			'singular_name'         => __( 'Resume', 'opaljob' ),
			'add_new'               => __( 'Add New Resume', 'opaljob' ),
			'add_new_item'          => __( 'Add New Resume', 'opaljob' ),
			'edit_item'             => __( 'Edit Resume', 'opaljob' ),
			'new_item'              => __( 'New Resume', 'opaljob' ),
			'all_items'             => __( 'All Resume', 'opaljob' ),
			'view_item'             => __( 'View Resume', 'opaljob' ),
			'search_items'          => __( 'Search Resume', 'opaljob' ),
			'not_found'             => __( 'No Resume found', 'opaljob' ),
			'not_found_in_trash'    => __( 'No Resume found in Trash', 'opaljob' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Opal Resumes', 'opaljob' ),
		);

		$labels = apply_filters( 'opaljob_postype_resume_labels' , $labels );

		register_post_type( 'opaljob_resume',
			array(
				'labels'            => $labels,
				'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author', 'excerpt' ),
				'public'            => true,
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => __( 'work-resume', 'opaljob' ) ),
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
		$prefix = OPALJOB_RESUME_PREFIX;
		$user_id 	= get_current_user_id();
		$fields =  array(
			array(
				'id'   => "{$prefix}salary",
				'name' => __( 'Salary', 'opaljob' ),
				'type' => 'text',
				'description'  => __( 'Salary', 'opaljob' ),
			),
			array(
				'id'   => "{$prefix}language",
				'name' => __( 'Language', 'opaljob' ),
				'type' => 'text',
				'description'  => __( 'Your working language', 'opaljob' ),
			),
			array(
				'name' 		=> __( 'user_meta_id', 'opaljob' ),
				'id'   		=> "{$prefix}user_meta_id",
				'type' 		=> 'hidden',
				'default' 	=> $user_id
			),
			array(
				'name' => __( 'Highest Degree Level', 'opaljob' ),
				'id'   => "{$prefix}hightest_degree",
				'type' => 'text'
			), 
			
			array(
				'name' => __( 'Total Year Experience', 'opaljob' ),
				'id'   => "{$prefix}year_experience",
				'type' => 'text'
			), 
			array(
				'name'      => __( 'Job Category', 'opaljob' ),
				'id'        => "{$prefix}work_category",
				'type'      => 'taxonomy_multicheck',
				'taxonomy'  => 'work_category',
			),
			array(
				'name'      => __( 'Skill job', 'opaljob' ),
				'id'        => "{$prefix}skill",
				'type'      => 'text',

			),
			array(
				'name'      => __( 'Resume Location', 'opaljob' ),
				'id'        => "{$prefix}work_location",
				'type'      => 'taxonomy_select',
				'taxonomy'  => 'opaljob_location',
			),
			array(
				'name'      => __( 'Resume Attachment', 'opaljob' ),
				'id'        => "{$prefix}resum_attachment",
				'type'      => 'file',
				'desc'		=> 'Allowed file: doc,pdf'
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
				'name' => __( 'Address', 'opaljob' ),
				'id'   => "{$prefix}address",
				'type' => 'text'
			), 
		);  


		return apply_filters( 'opaljob_postype_resume_metaboxes_fields' , $fields );
	}
	/**
	 *
	 */
	public static function metaboxes_education_fields() {
		$prefix = OPALJOB_RESUME_PREFIX;
		$fields = array(
		   	array(
				'id'                => $prefix . 'education_group',
				'type'              => 'group',
				'fields'            => array(
					array(
						'id'                => $prefix . 'education_school_name',
						'name'              => __( 'School name', 'opaljob' ),
						'type'              => 'text',
					),
					array(
						'id'                => $prefix . 'education_qualification',
						'name'              => __( 'Qualification', 'opaljob' ),
						'type'              => 'text',
					),
					array(
						'id'                => $prefix . 'education_start_end_date',
						'name'              => __( 'Start/end date', 'opaljob' ),
						'type'              => 'text',
					)
				)
			)
		);
		return apply_filters( 'opaljob_postype_company_metaboxes_fields_education' , $fields );
	}
	/**
	 *
	 */
	public static function metaboxes_work_experience_fields() {
		$prefix = OPALJOB_RESUME_PREFIX;
		$fields = array(
		   	array(
				'id'                => $prefix . 'work_experience',
				'type'              => 'group',
				'fields'            => array(
					array(
						'id'                => $prefix . 'work_experience_company',
						'name'              => __( 'Company', 'opaljob' ),
						'type'              => 'text',
					),
					array(
						'id'                => $prefix . 'work_experience_job_title',
						'name'              => __( 'Job title', 'opaljob' ),
						'type'              => 'text',
					),
					array(
						'id'                => $prefix . 'work_experience_start_end_date',
						'name'              => __( 'Start/end date', 'opaljob' ),
						'type'              => 'text',
					)
				)
			)
		);
		return apply_filters( 'opaljob_postype_company_metaboxes_fields_work_experience' , $fields );
	}
	/**
	 *
	 */
	public static function metaboxes_summary_of_skills_fields() {
		$prefix = OPALJOB_RESUME_PREFIX;
		$fields = array(
		   	array(
				'id'                => $prefix . 'summary_of_skills',
				'type'              => 'group',
				'fields'            => array(
					array(
						'id'                => $prefix . 'summary_of_skills_name',
						'name'              => __( 'Skill name', 'opaljob' ),
						'type'              => 'text',
					),
					array(
						'id'                => $prefix . 'summary_of_skills_percent',
						'name'              => __( 'Percent % (1 to 100)', 'opaljob' ),
						'type'              => 'text',
					),
				)
			)
		);
		return apply_filters( 'opaljob_postype_company_metaboxes_fields_summary_of_skills' , $fields );
	}				
	/**
	 *
	 */
	public static function metaboxes_general_fields() {
		$prefix = OPALJOB_RESUME_PREFIX;
		if ( ! empty( $_GET['id'] ) ) {
			$post = get_post( $_GET['id'] );
		}

		$fields = array(
			array(
				'id'                => $prefix . 'post_type',
				'type'              => 'hidden',
				'default'           => 'opaljob_resume',
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

		return apply_filters( 'opaljob_postype_resume_metaboxes_fields_general' , $fields );
	}
	/**
	 *
	 */
	public static function metaboxes(array $metaboxes){
		$prefix = OPALJOB_RESUME_PREFIX;
	    
	    $metaboxes[ $prefix . 'info' ] = array(
			'id'                        => $prefix . 'info',
			'title'                     => __( 'Resumes Information', 'opaljob' ),
			'object_types'              => array( 'opaljob_resume' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_fields()
		);
	    $metaboxes[ $prefix . 'education' ] = array(
			'id'                        => $prefix . 'education',
			'title'                     => __( 'Education', 'opaljob' ),
			'object_types'              => array( 'opaljob_resume' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_education_fields()
		);
		$metaboxes[ $prefix . 'work_experience' ] = array(
			'id'                        => $prefix . 'work_experience',
			'title'                     => __( 'Work experience', 'opaljob' ),
			'object_types'              => array( 'opaljob_resume' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_work_experience_fields()
		);
		$metaboxes[ $prefix . 'summary_of_skills' ] = array(
			'id'                        => $prefix . 'summary_of_skills',
			'title'                     => __( 'Summary of Skills', 'opaljob' ),
			'object_types'              => array( 'opaljob_resume' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_summary_of_skills_fields()
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
		$prefix = OPALJOB_RESUME_PREFIX;
		if ( ! is_admin() ) {

			
			$fields = array_merge( self::metaboxes_general_fields() , self::metaboxes_fields() ,
			self::metaboxes_education_fields() , self::metaboxes_work_experience_fields() , 
			self::metaboxes_summary_of_skills_fields()	);

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
	 
	    if  ( 'opaljob_resume' == $screen->post_type ) {
	         $title = 'Enter resum';
	    }
	 
	    return $title;
	}
}

Opaljob_PostType_Resume::init();