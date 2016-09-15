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

class Opaljob_Work {
	/**
	 *
	 */
	protected $post_id; 

	protected $metabox_company;

	protected $metabox_salarys; 

	protected $metabox_info; 

	protected $salary;

	protected $expires;

	protected $salarylabel;

	protected $salesalary; 

	protected $map; 

	protected $address; 

	/**
	 * Constructor 
	 */
	public function __construct( $post_id ){
		
		$this->post_id = $post_id; 

		$this->map 		 	= $this->getMetaboxValue( 'map' );  
		$this->address   	= $this->getMetaboxValue( 'address' );  
		$this->salary 	 	= $this->getMetaboxValue( 'salary' );   
		$this->salarylabel	= $this->getMetaboxValue( 'salarylabel' );
		$this->expires		= $this->getMetaboxValue( 'expires' );   
		$this->salesalary 	= $this->getMetaboxValue( 'salesalary' );   
		$this->featured  	= $this->getMetaboxValue( 'featured' );   

		// echo '<pre>'.print_r( $this->getMetaboxValue('map') ,1  );die ;
	}

	/**
	 * Gets Amenities
	 *
	 * @access public
	 * @param string $all
	 * @return array
	 */
	public function getMetaFullInfo(){

		/*if( empty($this->metabox_info) ){

			$fields = Opaljob_PostType_Work::metaboxes_info_fields();

			foreach( $fields as $field ){ 
				$id = str_replace( OPALJOB_WORK_PREFIX, "", $field['id']); 
				$this->metabox_info[$id] = array( 'label' => $field['name'] , 'value' => get_post_meta($this->post_id, $field['id'], true)  ); 
			}

		}
		return $this->metabox_info;	*/
		return;
	}

	public function isFeatured(){
		return $this->featured;
	}

	
	public function getMetaSearchObjects(){
		$prop = new stdClass();
		$map  = $this->getMetaboxValue('map');
		$map  =	explode(',', $map);
		$url  = '';
		if(get_post_thumbnail_id($this->post_id)) {
			$url = wp_get_attachment_url( get_post_thumbnail_id($this->post_id) );
		} elseif($this->getGallery()) {
			$url = $this->getGallery();
		}
        $prop->id = $this->post_id;
        $prop->title = get_the_title();
        $prop->url = get_permalink( $this->post_id );
 
        $prop->lat =  $map[0];
        $prop->lng =  $map[1];
        $prop->address =  $this->address;
     
     	if(is_numeric($this->getPrice())) {
        	$prop->salaryhtml =  opaljob_price_format( $this->getPrice() );
        } else {
        	$prop->salaryhtml =  $this->getPrice();
        }	
        $prop->salarylabel = $this->getPriceLabel();
        $prop->thumb = $url;

        $prop->icon = OPALJOB_PLUGIN_URL.'assets/images/map/market_icon.png';
        
        $prop->featured = $this->featured;

        
        return $prop;
	}
	/**
	 * Gets Amenities
	 *
	 * @access public
	 * @param string $all
	 * @return array
	 */
	public function getMetaShortInfo(){

		$output = array();
		$meta = array ( 'amountrooms', 'bathrooms', 'bedrooms', 'parking' );
		$meta = apply_filters( 'opaljob_work_meta_shortinfo_fields', $meta );

		if( !empty($meta) ){
			$fields = $this->getMetaFullInfo();


			foreach( $meta as $key => $value  ){
				if( isset($fields[$value]) ){
					$output[$value] = $fields[$value];
				}
			}
		}
	
		return $output;
	}

	/**
	 * Gets Logo company
	 *
	 * @access public
	 * @return array
	 */
 	public function render_company_logo() {
		$companyId = $this->getMetaboxValue( 'company' );
		$url = Opaljob_Company::get_avatar_url( $companyId ); 
		$avatar = $url ? '<img class="avatar" src="'.$url.'" alt="" />':"";
		if(empty($url)) {
			$avatar = '';
		}
		return $avatar; 
	}
	/**
	 * Gets name company
	 *
	 * @access public
	 * @return array
	 */
 	public function getNameCompany() {
 		$companyId = $this->getMetaboxValue( 'company' );
		$name = get_the_title($companyId );
		return $name; 
	}

 	/**
	 * Gets locations
	 *
	 * @access public
	 * @return array
	 */
 	public function getLocations(){
		$terms = wp_get_post_terms( $this->post_id, 'opaljob_location' );
		return $terms; 
	}
	/**
	 * Gets types
	 *
	 * @access public
	 * @return array
	 */

	public function getTypes(){
		$terms = wp_get_post_terms( $this->post_id, 'opaljob_types' );
		return $terms; 
	}

	public function renderTypes(){
		$types = $this->getTypes();

		if( empty($types) ){
			return ;
		}
		
		$output = '<div class="work-types">';
		foreach( $types as $key => $value ) {

			$output .= '<div class="work-type-item '.$value->slug.'">
							<a  href="'.get_the_permalink().'">
								<i class="fa fa-bookmark"></i><span>'.$value->name.'</span>
							</a>
					    </div>';
		
		}
		$output .= '</div>';

		return $output;
	}


	public function render_locations(){
		$locations = $this->getLocations();
		if( empty($locations) ){
			return ;
		}
			
		// 	echo '<pre>'.print_r( $locations ,1 );die;
		$output = '<div class="work-location"> <i class="fa fa-map-marker"></i> ';
		foreach( $locations as $key => $value ){  
			$output .= ' <a class="work-location-item" href="'.get_term_link( $value->term_id ).'"><span>'.$value->name.'</span></a>';
		}
		$output .= '</div>';

		return $output;

		return $output;
	}
	public function getAuthor(){

	}

	

	public function renderAuthorLink(){
		$userId = $this->getMetaboxValue( 'company' );
		$url = Opaljob_Company::get_avatar_url( $userId );  
		
		$company =  get_post( $userId );		
				
		$avatar = $url ? '<img class="avatar" src="'.$url.'" alt="" />':"";
		return '<a href="'.get_permalink($company->ID).'" class="author-link">'.$avatar.'<span>'. $company->post_title.'</span>'.'</a>';
	}
	/**
	 * Gets categoreis
	 *
	 * @access public
	 * @return array
	 */
	public function getCategory(){
		$terms = wp_get_post_terms( $this->post_id, 'work_category' );
		return $terms; 
	}
	/**
	 * Gets tag
	 *
	 * @access public
	 * @return array
	 */
	public function getTags(){
		$terms = wp_get_post_terms( $this->post_id, 'opaljob_tags' );
		return $terms; 
	}
	/**
	 * Gets meta box value
	 *
	 * @access public
	 * @param $key
	 * @param $single
	 * @return string
	 */
	public function getMetaboxValue( $key, $single = true ) {
		return get_post_meta( $this->post_id, OPALJOB_WORK_PREFIX.$key, $single ); 
	}
	/**
	 * Gets map value
	 *
	 * @access public
	 * @return string
	 */
	public function getMap(){
		return $this->map;
	}
	/**
	 * Gets address value
	 *
	 * @access public
	 * @return string
	 */
	public function getAddress(){
		return $this->address;
	}
	public function getDateExpires(){
		$expires = strtotime($this->expires);
		return date("F j, Y",$expires);
	}
	public function getExpires() {
		if(time() > strtotime($this->expires) && !empty($this->expires)) {
			$expires = 'expired';
		} else {
			$expires = $this->expires;
		}
		return $expires;
	}

	/**
	 * Gets video url value
	 *
	 * @access public
	 * @return string
	 */
	public function getVideoURL(){
		return $this->getMetaboxValue( 'video' );
	}
	
	/**
	 * Gets gallery ids value
	 *
	 * @access public
	 * @return array
	 */
	public function getGallery() {
		return $this->getMetaboxValue( 'gallery' );
	}
	
	/**
	 * Gets salary value
	 *
	 * @access public
	 * @return string
	 */
	public function getPrice() {
		return $this->salary;
	}

	/**
	 * Gets salary value
	 *
	 * @access public
	 * @return string
	 */
	public function getPriceLabel(){
		return $this->salarylabel;
	}

	/**
	 * Gets sale salary value
	 *
	 * @access public
	 * @return string
	 */
	public function getSalePrice() {
		return $this->salesalary;
	}
	/**
	 * Gets salary format value
	 *
	 * @access public
	 * @return string
	 */
	public function getFormatPrice() {
		return $this->getMetaboxValue( 'formatsalary' );
	}

	public function countApplyWork() {

		$title = get_the_title();

		$args = array(
			'post_type'         => 'opaljob_apply',
			'post_status'         => 'any',
			'meta_query'        => array(
				array(
					'key'       => OPALJOB_APPLY_PREFIX . 'position_applying',
					'value'     => $title,
					'compare'   => '=',
				),
			),
		);
		$loop = new WP_Query($args);
		$count = 0;

	 		if( $loop->have_posts() ){		
	 			while( $loop->have_posts() ){  $loop->the_post();
	 				$count ++;
	 			}
	 		}
	 		wp_reset_postdata();
		return $count.' '.__('Apply','opaljob');

	}
	public static function isAllowedRemove( $user_id, $item_id ) {

		$item = get_post( $item_id );

		if ( ! empty( $item->post_author ) ) {
			if ( $item->post_author == $user_id || get_user_role() == 'opaljob_company' || get_user_role() == 'administrator') {
				return true;
			}
		}

		return false;
	}

	public function setPostViews() {
		$postID = $this->post_id;
	    $user_ip = $_SERVER['REMOTE_ADDR']; //retrieve the current IP address of the visitor
	    $key = $user_ip . 'x' . $postID; //combine post ID & IP to form unique key
	    $value = array($user_ip, $postID); // store post ID & IP as separate values (see note)
	    $visited = get_transient($key); //get transient and store in variable

	    //check to see if the Post ID/IP ($key) address is currently stored as a transient
	    if ( false === ( $visited ) ) {

	        //store the unique key, Post ID & IP address for 12 hours if it does not exist
	       // set_transient( $key, $value, 60*60*12 );

	        // now run post views function
	        $count_key = 'views';
	        $count = get_post_meta($postID, $count_key, true);
	        if($count==''){
	            $count = 0;
	            delete_post_meta($postID, $count_key);
	            add_post_meta($postID, $count_key, '0');
	        }else{
	            $count++;
	            update_post_meta($postID, $count_key, $count);
	        }


	    }

	}

	public function getPostViews(){
	    $count_key = 'views';
	    $count = get_post_meta( $this->post_id, $count_key, true);
	    if($count==''){
	        delete_post_meta( $this->post_id, $count_key);
	        add_post_meta( $this->post_id, $count_key, '0');
	        return "0 ".__('View','opaljob');
	    }
	    return $count.' '.__('Views','opaljob');
	}

}