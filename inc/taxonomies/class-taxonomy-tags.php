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
class Opaljob_Taxonomy_Tag{

	/**
	 *
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_filter( 'opaljob_taxomony_tags_metaboxes', array( __CLASS__, 'metaboxes' ) );
	}

	/**
	 *
	 */
	public static function definition(){
		
		$labels = array(
			'name'              => __( 'Tags', 'opaljob' ),
			'singular_name'     => __( 'Tag', 'opaljob' ),
			'search_items'      => __( 'Search Tags', 'opaljob' ),
			'all_items'         => __( 'All Tags', 'opaljob' ),
			'parent_item'       => __( 'Parent Tag', 'opaljob' ),
			'parent_item_colon' => __( 'Parent Tag:', 'opaljob' ),
			'edit_item'         => __( 'Edit Tag', 'opaljob' ),
			'update_item'       => __( 'Update Tag', 'opaljob' ),
			'add_new_item'      => __( 'Add New Tag', 'opaljob' ),
			'new_item_name'     => __( 'New Tag', 'opaljob' ),
			'menu_name'         => __( 'Tags', 'opaljob' ),
		);

		register_taxonomy( 'opaljob_tags', 'opaljob_work', array(
			'labels'            => apply_filters( 'opaljob_taxomony_tags_labels', $labels ),
			'hierarchical'      => true,
			'query_var'         => 'tag-skill',
			'rewrite'           => array( 'slug' => __( 'tag-skill', 'opaljob' ) ),
			'public'            => true,
			'show_ui'           => true,
		) );
	}

	public static function metaboxes(){

	}
	public static function getList(){
		 return get_terms('opaljob_tags', array('hide_empty'=> false));
	}
	public static function dropdownList( $selected=0 ){

		$id = "opaljob_tags".rand();
		
		$args = array( 
				'show_option_none' => __( 'Select Tags', 'opaljob' ),
				'id' => $id,
				'class' => 'form-control',
				'show_count' => 1,
				'hierarchical'	=> '',
				'name'	=> 'tags',
				'selected'	=> $selected,
				'taxonomy'	=> 'opaljob_tags'
		);		

		 
		return wp_dropdown_categories( $args );
	}

}

Opaljob_Taxonomy_Tag::init();