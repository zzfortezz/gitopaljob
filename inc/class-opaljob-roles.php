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
 * Opaljob_Roles Class
 *
 * This class handles the role creation and assignment of capabilities for those roles.
 *
 * These roles let us have Opaljob Accountants, Opaljob Workers, etc, each of whom can do
 * certain things within the plugin
 *
 * @since 1.0.0
 */
class Opaljob_Roles {

	/**
	 * Get things going
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		add_filter( 'opaljob_map_meta_cap', array( $this, 'meta_caps' ), 10, 4 );
	}

	/**
	 * Add new shop roles with default WP caps
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function add_roles() {
		add_role( 'opaljob_manager', __( 'Opal job Manager', 'opaljob' ), array(
			'read'                   => true,
			'edit_posts'             => true,
			'delete_posts'           => true,
			'unfiltered_html'        => true,
			'upload_files'           => true,
			'export'                 => true,
			'import'                 => true,
			'delete_others_pages'    => true,
			'delete_others_posts'    => true,
			'delete_pages'           => true,
			'delete_private_pages'   => true,
			'delete_private_posts'   => true,
			'delete_published_pages' => true,
			'delete_published_posts' => true,
			'edit_others_pages'      => true,
			'edit_others_posts'      => true,
			'edit_pages'             => true,
			'edit_private_pages'     => true,
			'edit_private_posts'     => true,
			'edit_published_pages'   => true,
			'edit_published_posts'   => true,
			'manage_categories'      => true,
			'manage_links'           => true,
			'moderate_comments'      => true,
			'publish_pages'          => true,
			'publish_posts'          => true,
			'read_private_pages'     => true,
			'read_private_posts'     => true
		) );
 

		add_role( 'opaljob_company', __( 'Company', 'opaljob' ), array(
			'read'                   => true,
			'edit_posts'             => false,
			'upload_files'           => true,
			'delete_posts'           => false
		) );
		add_role( 'opaljob_jobseeker', __( 'Jobseeker', 'opaljob' ), array(
			'read'                   => true,
			'edit_posts'             => false,
			'upload_files'           => true,
			'delete_posts'           => false
		) );
	}

	/**
	 * Add new shop-specific capabilities
	 *
	 * @access public
	 * @since  1.0.0
	 * @global WP_Roles $wp_roles
	 * @return void
	 */
	public function add_caps() {
		global $wp_roles;

		if ( class_exists('WP_Roles') ) {
			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}
		}

		if ( is_object( $wp_roles ) ) {
			$wp_roles->add_cap( 'opaljob_manager', 'view_opaljob_reports' );
			$wp_roles->add_cap( 'opaljob_manager', 'view_opaljob_sensitive_data' );
			$wp_roles->add_cap( 'opaljob_manager', 'export_opaljob_reports' );
			$wp_roles->add_cap( 'opaljob_manager', 'manage_opaljob_settings' );

			$wp_roles->add_cap( 'administrator', 'view_opaljob_reports' );
			$wp_roles->add_cap( 'administrator', 'view_opaljob_sensitive_data' );
			$wp_roles->add_cap( 'administrator', 'export_opaljob_reports' );
			$wp_roles->add_cap( 'administrator', 'manage_opaljob_settings' );

			// Add the main post type capabilities
			$capabilities = $this->get_core_caps();
			foreach ( $capabilities as $cap_group ) {
				foreach ( $cap_group as $cap ) {
					$wp_roles->add_cap( 'opaljob_manager', $cap );
					$wp_roles->add_cap( 'administrator', $cap );
					$wp_roles->add_cap( 'opaljob_company', $cap );
				}
			}

			$wp_roles->add_cap( 'opaljob_jobseeker', 'edit_opaljob_works' );
			$wp_roles->add_cap( 'opaljob_jobseeker', 'read_private_forms' );
			$wp_roles->add_cap( 'opaljob_jobseeker', 'view_opaljob_reports' );
			$wp_roles->add_cap( 'opaljob_jobseeker', 'export_opaljob_reports' );
			$wp_roles->add_cap( 'opaljob_jobseeker', 'edit_opaljob_payments' );

		}
	}

	/**
	 * Gets the core post type capabilities
	 *
	 * @access public
	 * @since  1.0.0
	 * @return array $capabilities Core post type capabilities
	 */
	public function get_core_caps() {
		$capabilities = array();

		$capability_types = array( 'opaljob_works', 'opaljob_companies' );

		foreach ( $capability_types as $capability_type ) {
			$capabilities[ $capability_type ] = array(
				// Post type
				"edit_{$capability_type}",
				"read_{$capability_type}",
				"delete_{$capability_type}",
				"edit_{$capability_type}s",
				"edit_others_{$capability_type}s",
				"publish_{$capability_type}s",
				"read_private_{$capability_type}s",
				"delete_{$capability_type}s",
				"delete_private_{$capability_type}s",
				"delete_published_{$capability_type}s",
				"delete_others_{$capability_type}s",
				"edit_private_{$capability_type}s",
				"edit_published_{$capability_type}s",

				// Terms
				"manage_{$capability_type}_terms",
				"edit_{$capability_type}_terms",
				"delete_{$capability_type}_terms",
				"assign_{$capability_type}_terms",

				// Custom
				"view_{$capability_type}_stats"
			);
		}

		return $capabilities;
	}

	/**
	 * Map meta caps to primitive caps
	 *
	 * @access public
	 * @since  2.0
	 * @return array $caps
	 */
	public function meta_caps( $caps, $cap, $user_id, $args ) {

		switch( $cap ) {

			case 'view_opaljob_works_stats' :
				
				if( empty( $args[0] ) ) {
					break;
				}
				
				$form = get_post( $args[0] );
				if ( empty( $form ) ) {
					break;
				}

				if( user_can( $user_id, 'view_opaljob_reports' ) || $user_id == $form->post_author ) {
					$caps = array();
				}

				break;
		}

		return $caps;

	}

	/**
	 * Remove core post type capabilities (called on uninstall)
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function remove_caps() {
		
		global $wp_roles;

		if ( class_exists( 'WP_Roles' ) ) {
			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}
		}

		if ( is_object( $wp_roles ) ) {
			/** Opaljob Manager Capabilities */
			$wp_roles->remove_cap( 'opaljob_manager', 'view_opaljob_reports' );
			$wp_roles->remove_cap( 'opaljob_manager', 'view_opaljob_sensitive_data' );
			$wp_roles->remove_cap( 'opaljob_manager', 'export_opaljob_reports' );
			$wp_roles->remove_cap( 'opaljob_manager', 'manage_opaljob_settings' );

			/** Site Administrator Capabilities */
			$wp_roles->remove_cap( 'administrator', 'view_opaljob_reports' );
			$wp_roles->remove_cap( 'administrator', 'view_opaljob_sensitive_data' );
			$wp_roles->remove_cap( 'administrator', 'export_opaljob_reports' );
			$wp_roles->remove_cap( 'administrator', 'manage_opaljob_settings' );

			/** Remove the Main Post Type Capabilities */
			$capabilities = $this->get_core_caps();

			foreach ( $capabilities as $cap_group ) {
				foreach ( $cap_group as $cap ) {
					$wp_roles->remove_cap( 'opaljob_manager', $cap );
					$wp_roles->remove_cap( 'administrator', $cap );
					$wp_roles->remove_cap( 'opaljob_worker', $cap );
				}
			}

			/** Shop Accountant Capabilities */
			$wp_roles->remove_cap( 'opaljob_company', 'edit_opaljob_works' );
			$wp_roles->remove_cap( 'opaljob_company', 'read_private_forms' );
			$wp_roles->remove_cap( 'opaljob_company', 'view_opaljob_reports' );
			$wp_roles->remove_cap( 'opaljob_company', 'export_opaljob_reports' );

		}
	}
}
