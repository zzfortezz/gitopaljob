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
class Opaljob_Scripts{

    public static function init(){
        add_action( 'wp_head', array( __CLASS__, 'initAjaxUrl' ), 15 );
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'loadScripts' ) );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'loadAdminStyles') );
    }

    public static function loadScripts(){

       /// wp_enqueue_style( 'bootstrap-css', OPALJOB_PLUGIN_URL . 'assets/css/bootstrap.min.css', null, "1.3", false);
       // wp_enqueue_style( 'font-awesome', OPALJOB_PLUGIN_URL . 'assets/css/font-awesome.min.css');
        wp_enqueue_style( 'opaljob-css', OPALJOB_PLUGIN_URL . 'assets/css/opaljob.css', null, "1.3", false);
        

        $query = Opaljob_Query::getWorkQuery();
        $login_redirect = home_url();
        $apply_redirect = opaljob_submssion_job_apply_page();
        $max_file_size  = 100 * 1000 * 1000;
        $paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
        $max = $query->max_num_pages;
        $plup_url = add_query_arg( array(
            'action' => 'me_upload',
            'base'  =>'1',
            'nonce' => wp_create_nonce('aaiu_allow'),
        ), admin_url('admin-ajax.php') ); 

        if(is_singular('opaljob_work')){
            wp_enqueue_script("opaljob-submission", OPALJOB_PLUGIN_URL . 'assets/js/submission.js', array( 'jquery' ), "1.0.0", true);
        }
        wp_enqueue_script("google-map-api", "//maps.google.com/maps/api/js?sensor=false&amp;key=AIzaSyA-XBs8xkUbYA0ykeWNnxWRP8SMOSQHFW8&amp;language=en", null, "0.0.1", false);

        wp_enqueue_script("jquery-ui", OPALJOB_PLUGIN_URL . 'assets/js/jquery-ui.min.js', array( 'jquery' ), "3.3", false);
        //wp_enqueue_script("boostrap-js", OPALJOB_PLUGIN_URL . 'assets/js/bootstrap.min.js', array( 'jquery' ), "3.3", false);
        wp_enqueue_script("infobox", OPALJOB_PLUGIN_URL . 'assets/js/infobox.js', array( 'jquery' ), "1.3", false);
        wp_enqueue_script("markerclusterer", OPALJOB_PLUGIN_URL . 'assets/js/markerclusterer.js', array( 'jquery' ), "1.3", false);
        wp_enqueue_style("owl-carousel", OPALJOB_PLUGIN_URL . 'assets/js/owl-carousel/owl.carousel.css', null, "1.3", false);
        wp_enqueue_script("opaljob-scripts", OPALJOB_PLUGIN_URL . 'assets/js/scripts.js', array( 'jquery' ), "1.0.0", true);
        wp_enqueue_script("blockUi", OPALJOB_PLUGIN_URL . 'assets/js/blockUi.js', array( 'jquery' ), "1.0.0", true);
        wp_localize_script('opaljob-scripts', 'ajaxcalls_vars', 
            array(
                'login_redirect'        =>  $login_redirect,
                'apply_redirect'        =>  $apply_redirect,
                'admin_url'             =>  get_admin_url(),
                'startPage'             => $paged,
                'maxPages'              => $max,
                'nextLink'              => next_posts($max, false)
            )
        );
        wp_enqueue_script("noUiSlider", OPALJOB_PLUGIN_URL . 'assets/js/nouislider.min.js', array( 'jquery' ), "1.0.0", true);      
        wp_enqueue_script("opaljob-jquery-upload", OPALJOB_PLUGIN_URL . 'assets/js/jquery.fileupload.js', array( 'jquery' ), "1.0.0", true);
        wp_enqueue_script('ajax-upload',OPALJOB_PLUGIN_URL . 'assets/js/ajax-upload.js',array('jquery','plupload-handlers'), '1.0', true);  
        wp_localize_script('ajax-upload', 'ajax_vars', 
            array(  'ajaxurl'           => admin_url('admin-ajax.php'),
                    'nonce'             => wp_create_nonce('aaiu_upload'),
                    'remove'            => wp_create_nonce('aaiu_remove'),
                    'number'            => 1,
                    'warning'           =>  __('Image needs to be at least 500px height  x 500px wide!','opaljob'),
                    'upload_enabled'    => true,
                    'path'              =>  get_template_directory_uri(),
                    'confirmMsg'        => __('Are you sure you want to delete this?','opaljob'),
                    'plupload'         => array(
                                            'runtimes'          => 'html5,flash,html4',
                                            'browse_button'     => 'aaiu-uploader',
                                            'container'         => 'aaiu-upload-container',
                                            'file_data_name'    => 'aaiu_upload_file',
                                            'max_file_size'     => $max_file_size . 'b',
                                            'url'               => $plup_url,
                                            'flash_swf_url'     => includes_url('js/plupload/plupload.flash.swf'),
                                            'filters'           => array(array('title' => __('Allowed Files','opaljob'), 'extensions' => "jpeg,jpg,gif,png,pdf")),
                                            'multipart'         => true,
                                            'urlstream_upload'  => true,
                                            )
                
                )
         );
    }

    
    public static function loadAdminStyles() { 
        wp_enqueue_style( 'opaljob-admin-css', OPALJOB_PLUGIN_URL . 'assets/css/admin.css', array(), '3.0.3' );
        wp_enqueue_script( 'opaljob-admin-js', OPALJOB_PLUGIN_URL . 'assets/js/admin.js', array(), '3.0.3' );
    }

    public static function initAjaxUrl() {
        ?>
        <script type="text/javascript">
            var ajaxurl = '<?php echo esc_js( admin_url('admin-ajax.php') ); ?>';
            var opalsiteurl = '<?php echo OPALJOB_PLUGIN_URL."assets"; ?>';
        </script>
        <?php
    }
}

Opaljob_Scripts::init();

        


