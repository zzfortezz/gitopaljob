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
class Opaljob_Resume{

	protected $post_id;

	protected $content; 
	protected $author_name; 
	
	static $_companies = array();

	public function __construct( $post_id=null ){

		global $post;

		//$post = get_post( $post_id ); 
		$this->post = $post;
		$this->post_id =  $post->ID;

		$this->author = get_userdata( $post->post_author );
		$this->author_name = !empty($this->author)? sprintf('%s %s', $this->author->first_name, $this->author->last_name):null;
	}



	public function getSalary() {
		if(is_numeric($this->getMeta('salary'))) {
			$salary = opaljob_price_format($this->getMeta('salary'));
		} else {
			$salary = $this->getMeta('salary');
		}
		return $salary;
	}

	public function getLanguage() {
		return $this->getMeta('language');
	}

	public function getHightestDegree() {
		return $this->getMeta('hightest_degree');
	}
	
	public function getYearExperience() {
		return $this->getMeta('year_experience');
	}

	

	public function getSkill() {
		return $this->getMeta('skill');
	}

	public function getResumAttachment() {
		return $this->getMeta('resum_attachment');
	}

	public function getEmail() {
		return $this->getMeta('email');
	}

	public function getPhone() {
		return $this->getMeta('phone');
	}

	public function getAddress() {
		return $this->getMeta('address');
	}

	public function getEducationGroup() {
		return $this->getMeta('education_group');
	}

	public function getWorkExperience() {
		return $this->getMeta('work_experience');
	}

	public function getSummaryOfSkills() {
		return $this->getMeta('summary_of_skills');
	}

	public function showEducationGroup($post_id) {
		return get_post_meta($post_id, OPALJOB_RESUME_PREFIX . 'education_group', true );
	}

	public function showWorkExperience($post_id) {
		return get_post_meta($post_id, OPALJOB_RESUME_PREFIX . 'work_experience', true );
	}

	public function showSummaryOfSkills($post_id) {
		return get_post_meta($post_id, OPALJOB_RESUME_PREFIX . 'summary_of_skills', true );
	}
	/**
	 * Gets Categories
	 *
	 * @access public
	 * @return array
	 */
 	public function getCategories(){
		$terms = wp_get_post_terms( $this->post_id, 'work_category');
		$output = '';
		foreach ($terms as $key => $term) {
			$output .= $term->name.' ';
		}
		return $output; 
	}

	/**
	 * Gets locations
	 *
	 * @access public
	 * @return array
	 */
 	public function getLocations(){
		$terms = wp_get_post_terms($this->post_id, 'opaljob_location');
		$output = '';
		foreach ($terms as $key => $term) {
			$output .= $term->name.' ';
		}
		return $output; 
	}
	

	public function getMeta( $key ){
		return get_post_meta( get_the_ID(), OPALJOB_RESUME_PREFIX .  $key, true );
	}


	public static function isAllowedRemove( $user_id, $item_id ) {
		$item = get_post( $item_id );

		if ( ! empty( $item->post_author ) ) {
			if ( $item->post_author == $user_id ) {
				return true;
			}
		}

		return false;
	}
}
?>