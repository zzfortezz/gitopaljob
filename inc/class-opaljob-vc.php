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


if( class_exists("WPBakeryVisualComposerAbstract") ){
    function opaljob_vc_get_term_object( $term ) {
		$vc_taxonomies_types = vc_taxonomies_types();

		return array(
			'label' => $term->name,
			'value' => $term->slug,
			'group_id' => $term->taxonomy,
			'group' => isset( $vc_taxonomies_types[ $term->taxonomy ], $vc_taxonomies_types[ $term->taxonomy ]->labels, $vc_taxonomies_types[ $term->taxonomy ]->labels->name ) ? $vc_taxonomies_types[ $term->taxonomy ]->labels->name : esc_html__( 'Taxonomies', 'mode' ),
		);
	}

	function opaljob_category_field_search( $search_string ) {
		$data = array();
		$vc_taxonomies_types = array('work_category');
		$vc_taxonomies = get_terms( $vc_taxonomies_types, array(
			'hide_empty' => false,
			'search' => $search_string
		) );
		if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
			foreach ( $vc_taxonomies as $t ) {
				if ( is_object( $t ) ) {
					$data[] = opaljob_vc_get_term_object( $t );
				}
			}
		}

		return $data;
	}
	
	function opaljob_category_render($query) {  
		$category = get_term_by('slug', $query['value'], 'work_category');
		if ( ! empty( $query ) && !empty($category)) {
			$data = array();
			$data['value'] = $category->slug;
			$data['label'] = $category->name;
			return ! empty( $data ) ? $data : false;
		}
		return false;
	}

	function opaljob_location_field_search( $search_string ) {

		$data = array();
		$vc_taxonomies_types = array('opaljob_location');
		$vc_taxonomies = get_terms( $vc_taxonomies_types, array(
			'hide_empty' => false,
			'search' => $search_string
		) );

		if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
			foreach ( $vc_taxonomies as $t ) {
				if ( is_object( $t ) ) {
					$data[] = opaljob_vc_get_term_object( $t );
				}
			}
		}

		return $data;
	}
	
	function opaljob_location_render($query) {  
		$category = get_term_by('slug', $query['value'], 'opaljob_location');
		if ( ! empty( $query ) && !empty($category)) {
			$data = array();
			$data['value'] = $category->slug;
			$data['label'] = $category->name;
			return ! empty( $data ) ? $data : false;
		}
		return false;
	}

	function opaljob_types_field_search( $search_string ) {
		$data = array();
		$vc_taxonomies_types = array('opaljob_types');
		$vc_taxonomies = get_terms( $vc_taxonomies_types, array(
			'hide_empty' => false,
			'search' => $search_string
		) );
		if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
			foreach ( $vc_taxonomies as $t ) {
				if ( is_object( $t ) ) {
					$data[] = opaljob_vc_get_term_object( $t );
				}
			}
		}

		return $data;
	}
	
	function opaljob_types_render($query) {  
		$category = get_term_by('slug', $query['value'], 'opaljob_types');
		if ( ! empty( $query ) && !empty($category)) {
			$data = array();
			$data['value'] = $category->slug;
			$data['label'] = $category->name;
			return ! empty( $data ) ? $data : false;
		}
		return false;
	}

	$shortcodes = array( 'pbr_job_filter_work' ); 

	foreach( $shortcodes as $shortcode ){   

		add_filter( 'vc_autocomplete_'.$shortcode .'_work_category_callback', 'opaljob_category_field_search', 10, 1 );
	 	add_filter( 'vc_autocomplete_'.$shortcode .'_work_category_render', 'opaljob_category_render', 10, 1 );

	 	add_filter( 'vc_autocomplete_'.$shortcode .'_opaljob_location_callback', 'opaljob_location_field_search', 10, 1 );
	 	add_filter( 'vc_autocomplete_'.$shortcode .'_opaljob_location_render', 'opaljob_location_render', 10, 1 );

	 	add_filter( 'vc_autocomplete_'.$shortcode .'_opaljob_types_callback', 'opaljob_types_field_search', 10, 1 );
	 	add_filter( 'vc_autocomplete_'.$shortcode .'_opaljob_types_render', 'opaljob_types_render', 10, 1 );
	}

      vc_map( array(
          "name" => __("job Search Work Box ", "opaljob"),
          "base" => "pbr_job_searchbox",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('Opaljob', "opaljob"),
          "params" => array(
        	array(
	            "type" => "textfield",
	            "heading" => __("Title", "opaljob"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	        ),
	         array(
	            "type" => "textfield",
	            "heading" => __("Column", "opaljob"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	        ),
          )
      ));

    vc_map( array(
          "name" 		=> __("job Featured Work", "opaljob"),
          "base" 		=> "pbr_featured_work",
          "class" 		=> "",
          "description" => 'Get data from post type Team',
          "category" 	=> __('Opaljob', "opaljob"),
          "params" => array(
        	array(
	            "type" => "textfield",
	            "heading" => __("Title", "opaljob"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	        ),
	        array(
			    'type' => 'colorpicker',
			    'heading' => esc_html__( 'Title Color', 'opaljob' ),
			    'param_name' => 'title_color',
			    'description' => esc_html__( 'Select font color', 'opaljob' )
			),
	         array(
	            "type" => "textfield",
	            "heading" => __("Description", "opaljob"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	        ),

	        
	        array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opaljob"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit featured works showing', 'opaljob')
	        ),
          )
      ));
	
	 vc_map( array(
          "name" => __("job Carousel Work", "opaljob"),
          "base" => "pbr_job_carousel_work",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('Opaljob', "opaljob"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opaljob"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("description", "opaljob"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Column", "opaljob"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),

	         array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opaljob"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit featured works showing', 'opaljob')
	        ),

	        array(
				"type" => "dropdown",
				"heading" => esc_html__("Enable Thumbnail", 'fullhouse'),
				"param_name" => "enable_thumbnail",
				'value' 	=> array(
					esc_html__('Disable', 'fullhouse') => 0, 
					esc_html__('Enable', 'fullhouse') => 1, 
					
				),
				'std' => 0
			),
          )
      ));

      vc_map( array(
          "name" => __("job Grid Work", "opaljob"),
          "base" => "pbr_job_grid_work",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('Opaljob', "opaljob"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opaljob"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Description", "opaljob"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Show Sort By", "opaljob"),
	            "param_name" => "showsortby"
	        ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Column", "opaljob"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),

	         array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opaljob"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit featured works showing', 'opaljob')
	        ),
	         array(
	            "type" => "checkbox",
	            "heading" => __("Don't show Description", "opaljob"),
	            "param_name" => "description"
	        ),
	         array(
	            "type" => "checkbox",
	            "heading" => __("Pagination", "opaljob"),
	            "param_name" => "pagination"
	        ),
          )
      ));

      vc_map( array(
          "name" => __("job Filter Work", "opaljob"),
          "base" => "pbr_job_filter_work",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('Opaljob', "opaljob"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opaljob"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Description", "opaljob"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	        array(
			    'type' => 'autocomplete',
			    'heading' => esc_html__( 'Categories', 'opaljob' ),
			    'value' => '',
			    'param_name' => 'work_category',
			    "admin_label" => true,
			    'description' => esc_html__( 'Select Categories', 'opaljob' ),
			    'settings' => array(
			     	'multiple' => true,
			     	'unique_values' => true,
			     // In UI show results except selected. NB! You should manually check values in backend
			    ),
		   	),
		   	array(
			    'type' => 'autocomplete',
			    'heading' => esc_html__( 'Locations', 'opaljob' ),
			    'value' => '',
			    'param_name' => 'opaljob_location',
			    "admin_label" => true,
			    'description' => esc_html__( 'Select Locations', 'opaljob' ),
			    'settings' => array(
			     	'multiple' => true,
			     	'unique_values' => true,
			     // In UI show results except selected. NB! You should manually check values in backend
			    ),
		   	),
		   	array(
			    'type' => 'autocomplete',
			    'heading' => esc_html__( 'Types', 'opaljob' ),
			    'value' => '',
			    'param_name' => 'opaljob_types',
			    "admin_label" => true,
			    'description' => esc_html__( 'Select Types', 'opaljob' ),
			    'settings' => array(
			     	'multiple' => true,
			     	'unique_values' => true,
			     // In UI show results except selected. NB! You should manually check values in backend
			    ),
		   	),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Show Sort By", "opaljob"),
	            "param_name" => "showsortby"
	        ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Column", "opaljob"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),

	         array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opaljob"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit featured works showing', 'opaljob')
	        ),
	         array(
	            "type" => "checkbox",
	            "heading" => __("Don't show Description", "opaljob"),
	            "param_name" => "description"
	        ),
	         array(
	            "type" => "checkbox",
	            "heading" => __("Pagination", "opaljob"),
	            "param_name" => "pagination"
	        ),
          )
      ));

      vc_map( array(
          "name" => __("job List Work", "opaljob"),
          "base" => "pbr_job_list_work",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('Opaljob', "opaljob"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opaljob"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("description", "opaljob"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Show Sort By", "opaljob"),
	            "param_name" => "showsortby"
	        ),
	           array(
	            "type" => "textfield",
	            "heading" => __("Column", "opaljob"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Limit per page", "opaljob"),
	            "param_name" => "limit",
	            "value" => 10,
	            'description' =>  __('Limit featured works showing', 'opaljob')
	        ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Don't show Description", "opaljob"),
	            "param_name" => "description"
	        ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Pagination", "opaljob"),
	            "param_name" => "pagination"
	        ),
          )
      ));


      vc_map( array(
          "name" => __("job Grid Company", "opaljob"),
          "base" => "pbr_job_grid_company",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('Opaljob', "opaljob"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opaljob"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("description", "opaljob"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Column", "opaljob"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opaljob"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit featured companies showing', 'opaljob')
	          ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Pagination", "opaljob"),
	            "param_name" => "pagination"
	        ),
          )
      ));

      vc_map( array(
          "name" => __("job List Company", "opaljob"),
          "base" => "pbr_job_list_company",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('Opaljob', "opaljob"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opaljob"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("description", "opaljob"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Column", "opaljob"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opaljob"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit featured works showing', 'opaljob')
	        ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Pagination", "opaljob"),
	            "param_name" => "pagination"
	        ),
          )
      ));
	  vc_map( array(
          "name" => __("job List Resume", "opaljob"),
          "base" => "pbr_job_list_resume",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('Opaljob', "opaljob"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opaljob"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("description", "opaljob"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Column", "opaljob"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opaljob"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit featured works showing', 'opaljob')
	        ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Pagination", "opaljob"),
	            "param_name" => "pagination"
	        ),
          )
      ));
	
      
      class WPBakeryShortCode_Pbr_featured_work  extends WPBakeryShortCode {}
      class WPBakeryShortCode_Pbr_job_searchbox   extends WPBakeryShortCode {}
      class WPBakeryShortCode_pbr_job_grid_work  extends WPBakeryShortCode {}
      class WPBakeryShortCode_pbr_job_list_work  extends WPBakeryShortCode {}
      class WPBakeryShortCode_pbr_job_filter_work  extends WPBakeryShortCode {}

      class WPBakeryShortCode_pbr_job_grid_company  extends WPBakeryShortCode {}
      class WPBakeryShortCode_pbr_job_list_company  extends WPBakeryShortCode {}
      class WPBakeryShortCode_pbr_job_list_resume  extends WPBakeryShortCode {}
      class WPBakeryShortCode_pbr_job_carousel_work  extends WPBakeryShortCode {}
  }