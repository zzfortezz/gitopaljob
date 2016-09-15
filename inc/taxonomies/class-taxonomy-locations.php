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
class Opaljob_Taxonomy_Location{

	/**
	 *
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_filter( 'opaljob_taxomony_location_metaboxes', array( __CLASS__, 'metaboxes' ) );
	}

	/**
	 *
	 */
	public static function definition(){
		
		$labels = array(
			'name'              => __( 'Locations', 'opaljob' ),
			'singular_name'     => __( 'Location', 'opaljob' ),
			'search_items'      => __( 'Search Locations', 'opaljob' ),
			'all_items'         => __( 'All Locations', 'opaljob' ),
			'parent_item'       => __( 'Parent Location', 'opaljob' ),
			'parent_item_colon' => __( 'Parent Location:', 'opaljob' ),
			'edit_item'         => __( 'Edit Location', 'opaljob' ),
			'update_item'       => __( 'Update Location', 'opaljob' ),
			'add_new_item'      => __( 'Add New Location', 'opaljob' ),
			'new_item_name'     => __( 'New Location', 'opaljob' ),
			'menu_name'         => __( 'Locations', 'opaljob' ),
		);

		register_taxonomy( 'opaljob_location', 'opaljob_work', array(
			'labels'            => apply_filters( 'opaljob_taxomony_location_labels', $labels ),
			'hierarchical'      => true,
			'query_var'         => 'work-location',
			'rewrite'           => array( 'slug' => __( 'opal-work-location', 'opaljob' ) ),
			'public'            => true,
			'show_ui'           => true,
		) );

	}

	public static function metaboxes(){

	}


	public static function getList(){
		 return get_terms('opaljob_location', array('hide_empty'=> false));
	}

	public static function dropdownList( $selected=0 ){
		$id = "opaljob_location".rand();
		$args = array( 
				'show_option_none' => __( 'Select Location', 'opaljob' ),
				'id' => $id,
				'class' => 'form-control',
				'name'	=> 'location',
				'show_count' => 1,
				'hierarchical'	=> '',
				'selected'	=> $selected,
				'taxonomy'	=> 'opaljob_location'
		);		

		return wp_dropdown_categories( $args );
	}
}

Opaljob_Taxonomy_Location::init();