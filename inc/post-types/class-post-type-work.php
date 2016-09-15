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
class Opaljob_PostType_Work{

	/**
	 * init action and filter data to define work post type
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'fields_front' ) );
		add_filter( 'manage_edit-opaljob_work_columns', array( __CLASS__,'opaljob_my_columns') );
		add_action( 'transition_opaljob_work_status', array( __CLASS__, 'process_publish_work' ), 10, 1 );
		add_action( 'manage_posts_custom_column', array( __CLASS__, 'opaljob_populate_columns'),10,2  );
		define( 'OPALJOB_WORK_PREFIX', 'opaljob_ppt_' );
	}

	/**
	 *
	 */
	public static function definition(){
		
		$labels = array(
			'name'                  => __( 'Opal Works', 'opaljob' ),
			'singular_name'         => __( 'Work', 'opaljob' ),
			'add_new'               => __( 'Add New Work', 'opaljob' ),
			'add_new_item'          => __( 'Add New Work', 'opaljob' ),
			'edit_item'             => __( 'Edit Work', 'opaljob' ),
			'new_item'              => __( 'New Work', 'opaljob' ),
			'all_items'             => __( 'All Works', 'opaljob' ),
			'view_item'             => __( 'View Work', 'opaljob' ),
			'search_items'          => __( 'Search Work', 'opaljob' ),
			'not_found'             => __( 'No Works found', 'opaljob' ),
			'not_found_in_trash'    => __( 'No Works found in Trash', 'opaljob' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Opal Works', 'opaljob' ),
		);

		$labels = apply_filters( 'opaljob_postype_work_labels' , $labels );

		register_post_type( 'opaljob_work',
			array(
				'labels'            => $labels,
				'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author' ),
				'public'            => true,
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => __( 'works', 'opaljob' ) ),
				'menu_position'     => 51,
				'categories'        => array(),
				'menu_icon'         => 'dashicons-admin-home',
			)
		);
		
        register_taxonomy('work_category', 'opaljob_work', array(
            'labels' => array(
                'name'              => __('Work Categories','reales'),
                'add_new_item'      => __('Add New Work Category','reales'),
                'new_item_name'     => __('New Work Category','reales')
            ),
            'hierarchical'  => true,
         	'query_var'         => 'opal-category',
            'rewrite'       => array('slug' => 'work_category')
        ));
        register_post_status( 'expired', array(
            'label'                     => __( 'expired', 'opaljob' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop( 'Membership Expired <span class="count">(%s)</span>', 'Job Expired <span class="count">(%s)</span>' ),
		    ) ,
		    register_post_status( 'disabled', array(
		            'label'                     => esc_html__(  'disabled', 'opaljob' ),
		            'public'                    => false,
		            'exclude_from_search'       => false,
		            'show_in_admin_all_list'    => true,
		            'show_in_admin_status_list' => true,
		            'label_count'               => _n_noop( 'Disabled by user <span class="count">(%s)</span>', 'Disabled by user <span class="count">(%s)</span>','opaljob' ),
		    )	    
		    )              
		  );
	}

	/**
	 *
	 */

	public static function opaljob_my_columns( $columns ) {
	    $slice=array_slice($columns,2,2);
	    unset( $columns['comments'] );
	    unset( $slice['comments'] );
	    $splice=array_splice($columns, 2);   
	    $columns['work_status']   = __('Status','opaljob');
	    $columns['work_price']    = __('Salary','opaljob');
	    $columns['work_featured'] = __('Featured','opaljob');
	    return  array_merge($columns,array_reverse($slice));
	}
	public static function opaljob_populate_columns( $column ) {
		$prefix = OPALJOB_WORK_PREFIX;
	     if ( 'work_status' == $column ) {
	        $work_status = get_post_status(get_the_ID()); 
	        if($work_status=='publish'){
	            echo __('published','opaljob');
	        }else{
	            echo esc_html($work_status);
	        }   
	    } 

	    if ( 'work_price' == $column ) {	        
	        $price = ( get_post_meta(get_the_ID(), $prefix.'salary', true) );
	        if(is_numeric($price)) {
	            $price = opaljob_price_format($price);    
	        } 
	        
	        echo $price;
	    }
	    
	    if ( 'work_featured' == $column ) {
	        $work_featured = get_post_meta(get_the_ID(), 'prop_featured', true); 
	        if($work_featured==1){
	            $work_featured=__('Yes','opaljob');
	        }else{
	            $work_featured=__('No','opaljob'); 
	        }
	        echo esc_html($work_featured);
	    }
	}
	public static function metaboxes( array $metaboxes ) {
		$prefix = OPALJOB_WORK_PREFIX;
		

		$metaboxes[ $prefix . 'management' ] = array(
			'id'                        => $prefix . 'management',
			'title'                     => __( 'Work Management', 'opaljob' ),
			'object_types'              => array( 'opaljob_work' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_management_fields()
		);
		$metaboxes[ $prefix . 'salary' ] = array(
			'id'                        => $prefix . 'salary',
			'title'                     => __( 'Salary', 'opaljob' ),
			'type'						=> 'text_money',
			'object_types'              => array( 'opaljob_work' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_price_fields()
		);
		
		
		$metaboxes[ $prefix . 'public_facilities' ] = array(
			'id'                        => $prefix . 'public_facilities',
			'title'                     => __( 'Public facilities', 'opaljob' ),
			'object_types'              => array( 'opaljob_work' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_public_facilities_fields()
		);

		$metaboxes[ $prefix . 'company' ] = array(
			'id'                        => $prefix . 'company',
			'title'                     => __( 'Companies Information', 'opaljob' ),
			'object_types'              => array( 'opaljob_work' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_company_fields()
		);

		return $metaboxes;
	}
	
	/**
	 *
	 */	
	public static function metaboxes_management_fields(){
		$prefix = OPALJOB_WORK_PREFIX;
		$fields = array(
			array(
				'name'              => __( 'Featured', 'opaljob' ),
				'id'                => $prefix . 'featured',
				'type'              => 'checkbox'
			),
			array(
				'name'              => __( 'Work SKU', 'opaljob' ),
				'id'                => $prefix . 'sku',
				'type'              => 'text',
				'description' => __('Please Enter Your Work SKU','opaljob')
			),
			array(
				'name'              => __( 'Listing Expiry Date', 'opaljob' ),
				'id'                => $prefix . 'expires',
				'type'              => 'opal_calendar',
				'description' => __('Please Enter Your Work SKU','opaljob')
			),

			array(
				'name'              => __( 'Address', 'opaljob' ),
				'id'                => $prefix . 'address',
				'type'              => 'textarea_small',
				'description' => __('Please Enter Your Address','opaljob')
			),
			array(
				'id'                => $prefix . 'map',
				'name'              => __( 'Location', 'opaljob' ),
				'type'              => 'opal_googlemap',
		
				'sanitization_cb'   => 'opal_map_sanitise',
                'split_values'      => true,
			),
			array(
				'id'   => "{$prefix}gallery",
				'name' => __( 'Images', 'opaljob' ),
				'type' => 'file',
				'description'  => __( 'Select one  images to show as gallery', 'opaljob' ),
			),
		

		);

		return apply_filters( 'opaljob_postype_work_metaboxes_fields_management' , $fields );
	}

	/**
	 *
	 */
	public static function metaboxes_price_fields() {
		$prefix = OPALJOB_WORK_PREFIX;
		$fields = array(
			array(
				'id'                => $prefix . 'salary',
				'name'              => __( 'Salary', 'opaljob' ),
				'type'              => 'text',
				'description'       => __( 'Enter amount without currency.', 'opaljob' ),
			),
			array(
				'id'                => $prefix . 'salarylabel',
				'name'              => __( 'Salary Label', 'opaljob' ),
				'type'              => 'text',
				'description'       => __( 'Salary Label (e.g. "per month")', 'opaljob' ),
			)

		);

		return apply_filters( 'opaljob_postype_work_metaboxes_fields_price' , $fields );
	}

	
	/**
	 *
	 */
	public static function metaboxes_public_facilities_fields() {
		$prefix = OPALJOB_WORK_PREFIX;
		$fields = array(
		   	array(
				'id'                => $prefix . 'public_facilities_group',
				'type'              => 'group',
				'fields'            => array(
					array(
						'id'                => $prefix . 'public_facilities_key',
						'name'              => __( 'Key', 'opaljob' ),
						'type'              => 'text',
					),
					array(
						'id'                => $prefix . 'public_facilities_value',
						'name'              => __( 'Value', 'opaljob' ),
						'type'              => 'text',
					)
				)
			)
		);

		return apply_filters( 'opaljob_postype_work_metaboxes_fields_public_facilities' , $fields );
	}

	/**
	 *
	 */
	public static function metaboxes_company_fields() {
		$prefix = OPALJOB_WORK_PREFIX;
		$companies_objects = Opaljob_Query::get_companies();
		$companies = array( 0 => __('None','opaljob') );
		if ( !empty($companies_objects->posts) && is_array( $companies_objects->posts ) ) {
			foreach( $companies_objects->posts as $object ){
				$companies[$object->ID] = $object->post_title;
			}
		}

		$fields = array(
			array(
				'name' => __( 'Company', 'opaljob' ),
				'id'   => "{$prefix}company",
				'type' => 'select',
				'options'	=> $companies 
			),
		);

		return apply_filters( 'opaljob_postype_work_metaboxes_fields_company' , $fields );
	}

	/**
	 * Defines custom front end fields
	 *
	 * @access public
	 * @param array $metaboxes
	 * @return array
	 */
	public static function fields_front( array $metaboxes ) {
		$prefix = OPALJOB_WORK_PREFIX;
		if ( ! is_admin() ) {

			$management = array(
				array(
					'name'              => __( 'Featured', 'opaljob' ),
					'id'                => $prefix . 'featured',
					'type'              => 'checkbox'
				),
				array(
				'id'                => $prefix . 'map',
				'name'              => __( 'Location', 'opaljob' ),
				'type'              => 'opal_googlemap',
				'sanitization_cb'   => 'opal_map_sanitise',
                'split_values'      => true,
				),

				array(
					'id'   => "{$prefix}gallery",
					'name' => __( 'Images Gallery', 'opaljob' ),
					'type' => 'file_list',
					'description'  => __( 'Select one or more images to show as gallery', 'opaljob' ),
				),

				array(
					'id'   => "{$prefix}video",
					'name' => __( 'Video', 'opaljob' ),
					'type' => 'text',
					'description'  => __( 'Input for videos, audios from Youtube, Vimeo and all supported sites by WordPress. It has preview feature.', 'opaljob' ),
				),

			);
			$fields = array_merge( self::metaboxes_general_fields(), self::metaboxes_price_fields(),
				$management,  
				self::metaboxes_taxonomies_fields() );

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

	public static function metaboxes_general_fields() {
		$prefix = OPALJOB_WORK_PREFIX;
		if ( ! empty( $_GET['id'] ) ) {
			$post = get_post( $_GET['id'] );
			$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $_GET['id'] ) );
		}

		$fields = array(
			array(
				'id'                => $prefix . 'post_type',
				'type'              => 'hidden',
				'default'           => 'opaljob_work',
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
			),
			array(
				'name'              => __( 'Featured Image', 'opaljob' ),
				'id'                => $prefix . 'featured_image',
				'type'              => 'file',
				'default'           => ! empty( $featured_image ) ? $featured_image[0] : '',
			)
		);

		return apply_filters( 'opaljob_postype_work_metaboxes_fields_general' , $fields );
	}

	public static function metaboxes_taxonomies_fields() {
		$prefix = OPALJOB_WORK_PREFIX;
		$fields = array(
			array(
				'name'      => __( 'Categories', 'opaljob' ),
				'id'        => $prefix . 'category',
				'type'      => 'taxonomy_select',
				'taxonomy'  => 'work_category',
			),
			array(
				'name'      => __( 'Locations', 'opaljob' ),
				'id'        => $prefix . 'location',
				'type'      => 'taxonomy_select',
				'taxonomy'  => 'opaljob_location',
			),
			array(
				'name'      => __( 'Types', 'opaljob' ),
				'id'        => $prefix . 'type',
				'type'      => 'taxonomy_select',
				'taxonomy'  => 'opaljob_types',
			),
			array(
				'name'      => __( 'Tags', 'opaljob' ),
				'id'        => $prefix . 'tag',
				'type'      => 'taxonomy_multicheck',
				'taxonomy'  => 'opaljob_tags',
			),
		);

		return apply_filters( 'opaljob_postype_work_metaboxes_fields_taxonomies' , $fields );
	}

	public static function process_publish_work($post) {
		if ( $old_status == 'pending'  &&  $new_status == 'publish' ) {
			$user_id = $post->post_author;
			$user = get_user_by( 'id', $user_id );
			if (!is_object($user)) {
				$from_name = opaljob_get_option('from_name');
				$from_email = opaljob_get_option('from_email');
				$subject = opaljob_get_option('publish_submission_email_subject');
				
				$headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $from_name, $from_email );

				$work_link = get_permalink( $post );
				$tags = array("{first_name}", "{last_name}", "{work_link}");
				$values = array($user->first_name, $user->last_name, $work_link);

				$body = opaljob_get_option('publish_submission_email_body');
				$body = html_entity_decode($body);
				$message = str_replace($tags, $values, $body);

				return wp_mail( $user->user_email, $subject, $message, $headers );
			}
		}
	}
}

Opaljob_PostType_Work::init();