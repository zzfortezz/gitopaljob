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
class Opaljob_Taxonomy_Type{

	/**
	 *
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_filter( 'opaljob_taxomony_types_metaboxes', array( __CLASS__, 'metaboxes' ) );
	}

	/**
	 *
	 */
	public static function definition(){
		
		$labels = array(
			'name'              => __( 'Types', 'opaljob' ),
			'singular_name'     => __( 'Type', 'opaljob' ),
			'search_items'      => __( 'Search Types', 'opaljob' ),
			'all_items'         => __( 'All Types', 'opaljob' ),
			'parent_item'       => __( 'Parent Type', 'opaljob' ),
			'parent_item_colon' => __( 'Parent Type:', 'opaljob' ),
			'edit_item'         => __( 'Edit Type', 'opaljob' ),
			'update_item'       => __( 'Update Type', 'opaljob' ),
			'add_new_item'      => __( 'Add New Type', 'opaljob' ),
			'new_item_name'     => __( 'New Type', 'opaljob' ),
			'menu_name'         => __( 'Types', 'opaljob' ),
		);

		register_taxonomy( 'opaljob_types', 'opaljob_work', array(
			'labels'            => apply_filters( 'opaljob_taxomony_types_labels', $labels ),
			'hierarchical'      => true,
			'query_var'         => 'work-type',
			'rewrite'           => array( 'slug' => __( 'work-type', 'opaljob' ) ),
			'public'            => true,
			'show_ui'           => true,
		) );
	}

	public static function metaboxes(){

	}
	public static function getList(){
		 return get_terms('opaljob_types', array('hide_empty'=> false));
	}
	public static function dropdownList( $selected=0 ){

		$id = "opaljob_types".rand();
		
		$args = array( 
				'show_option_none' => __( 'Select Types', 'opaljob' ),
				'id' => $id,
				'class' => 'form-control',
				'show_count' => 1,
				'hierarchical'	=> '',
				'name'	=> 'types',
				'selected'	=> $selected,
				'taxonomy'	=> 'opaljob_types'
		);		

		 
		return wp_dropdown_categories( $args );
	}

}

Opaljob_Taxonomy_Type::init();