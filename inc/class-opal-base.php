<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if (!class_exists('Opal_Base')) {
	Class Opal_Base{
		const AJAX_PREFIX = 'wp_ajax_';
	    const AJAX_NOPRIV_PREFIX = 'wp_ajax_nopriv_';
	/**
     * Add an action hook
     * @param $hook
     * @param $callback
     * @param $priority
     * @param $accepted_args
     */
    public function add_action($hook, $callback, $priority = 10, $accepted_args = 1) {
        add_action($hook, array(
            $this,
            $callback
        ) , $priority, $accepted_args);
    }
    
	public function add_ajax($hook, $callback, $priv = true, $no_priv = true, $priority = 10, $accepted_args = 1) {
	        if ($priv) $this->add_action(self::AJAX_PREFIX . $hook, $callback, $priority, $accepted_args);
	        if ($no_priv) $this->add_action(self::AJAX_NOPRIV_PREFIX . $hook, $callback, $priority, $accepted_args);
	    }
	}
}
/**
* Class opal_post will control all post data
* @version 1.0
* @package Opal
* @author Dattq
*/
Class Opal_Post{
	static $instance;
	public $convert;
	public $current_post;
	public static function get_instance(){
		if(self::$instance == null){
			self::$instance = new Opal_Post('post');
		}
		return self::$instance;
	}

	/**
    * construct a object post with meta data
    * @param string $post_type object post name
    * @param array $taxs array of tax name assigned to post type
    * @param array $meta_data all post meta data you want to control
    * @author Dattq
    * @since 1.0
    */

	public function __construct($post_type = '', $taxs = array(), $meta_data = array()){
		$post_type = ($post_type) ? $post_type : "post";
		$this->post_type = $post_type;

		if($post_type == "post" && empty($taxs)){
			$taxs = array(
				"tag",
				"category"
				);
		}
		$this->taxs = apply_filters('ae_post_taxs', $taxs, $post_type);
		$this->taxs = $taxs;

		$defaults = array(
            'address',
            'post_count',
            'comment_count',
            );
		$this->meta = wp_parse_args( $defaults, $meta_data );

		//set default data for convert function
		$this->convert = array(
            'post_parent',
            'post_title',
            'post_name',
            'post_content',
            'post_excerpt',
            'post_author',
            'post_status',
            'ID',
            'post_type',
            'comment_count',
            'guid'
        );
	}
	/**
	* function convert post_data to object with metadata
	* @param object $post_data 
	* @param boolean $singular (default: false) return a single value or listing.
	* @param string $prefix 
	* @author Dattq
	*/
	public function convert($post_data,$prefix, $singular = false){
		$result = array();
		$post = (array) $post_data;
		foreach ($this->convert as $key) {
			if(isset($post[$key])) $result[$key] = $post[$key];
		}
		$result['post_date'] = get_the_date('', $post['ID']);

		// generate post taxonomy
        if (!empty($this->taxs)) {

            foreach ($this->taxs as $name) {
                $terms = wp_get_object_terms($post['ID'], $name);
                $arr = array();
                if (is_wp_error($terms)) continue;

                foreach ($terms as $term) {
                    $arr[] = $term->term_id;
                }
                $result[$name] = $arr;
                $result['tax_input'][$name] = $terms;
            }
        }

		$meta = $this->meta;
		foreach($meta as $key){
			$result[$key] = get_post_meta( $post['ID'], 'opaljob_'.$prefix."_".$key, $singular ); 
		}

		unset($result['post_password']);
		$result['permalink'] = get_permalink( $post['ID']);
		$result['unfilter_content'] = $result['post_content'];

		ob_start();
		echo apply_filters( 'the_content', $result['post_content'] );
		$the_content = ob_get_clean();

		$result['post_content'] = $the_content;

		// set except
		if(isset($result['post_excerpt']) && $result['post_excerpt'] == ''){
			$result['post_excerpt'] = wp_trim_words($the_content, 20);
		}
		$this->current_post = apply_filters( 'op_convert_'. $this->post_type, (object)$result );
		return $this->current_post;
	}
	/**
	 * return instance post after convert data
	 * @author Dattq
	 * @return object post data
	*/
	public function get_current_data(){
		return $this->current_post;
	}
}

/**
 * class AE_PostFact
 * factory class to generate ae post object
 * @author Dattq
 */
class Opal_PostFact
{

    static $objects;

    /**
     * contruct init post type
     */
    function __construct() {
        self::$objects = array(
            'post' => Opal_Post::get_instance()
        );
    }

    /**
     * set a post type object to machine
     * @param String $post_type
     * @param AE_Post object $object
     */
    public function set($post_type, $object) {
        self::$objects[$post_type] = $object;
    }

    /**
     * get post type object in class object instance
     * @param String $post_type The post type want to use
     * @return Object
     */
    public function get($post_type) {
        if (isset(self::$objects[$post_type])) return self::$objects[$post_type];
        return null;
    }
}

/**
 * set a global object factory
 */
global $opal_post_factory;
$opal_post_factory = new Opal_PostFact();
$opal_post_factory->set('post', new Opal_Post('post'));





?>