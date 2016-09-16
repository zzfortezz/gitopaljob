<?php 
Class Opal_Theme_Action extends Opal_Base{
    function __construct(){
        $this->add_ajax('opal-upload-files','upload_image');
    }
    
    /**
     * process uploaded image: save to upload_dir & create multiple sizes & generate metadata
     * @param  [type]  $file     [the $_FILES['data_name'] in request]
     * @param  [type]  $author   [ID of the author of this attachment]
     * @param  integer $parent=0 [ID of the parent post of this attachment]
     * @param  array [$mimes] [array of supported file extensions]
     * @return [int/WP_Error]   [attachment ID if successful, or WP_Error if upload failed]
     * @author anhcv
     */
    function opal_process_file_upload($file, $author = 0, $parent = 0, $mimes = array()) {
        global $user_ID;
        $author = (0 == $author || !is_numeric($author)) ? $user_ID : $author;

        if (isset($file['name']) && $file['size'] > 0) {

            // setup the overrides
            $overrides['test_form'] = false;
            if (!empty($mimes) && is_array($mimes)) {
                $overrides['mimes'] = $mimes;
            }

            // this function also check the filetype & return errors if having any
            if (!function_exists('wp_handle_upload')) {
                require_once (ABSPATH . 'wp-admin/includes/file.php');
            }
            $uploaded_file = wp_handle_upload($file, $overrides);

            //if there was an error quit early
            if (isset($uploaded_file['error'])) {
                return new WP_Error('upload_error', $uploaded_file['error']);
            } elseif (isset($uploaded_file['file'])) {

                // The wp_insert_attachment function needs the literal system path, which was passed back from wp_handle_upload
                $file_name_and_location = $uploaded_file['file'];

                // Generate a title for the image that'll be used in the media library
                $file_title_for_media_library = sanitize_file_name($file['name']);

                $wp_upload_dir = wp_upload_dir();

                // Set up options array to add this file as an attachment
                $attachment = array(
                    'guid' => $uploaded_file['url'],
                    'post_mime_type' => $uploaded_file['type'],
                    'post_title' => $file_title_for_media_library,
                    'post_content' => '',
                    'post_status' => 'inherit',
                    'post_author' => $author
                );

                // Run the wp_insert_attachment function. This adds the file to the media library and generates the thumbnails. If you wanted to attch this image to a post, you could pass the post id as a third param and it'd magically happen.
                $attach_id = wp_insert_attachment($attachment, $file_name_and_location, $parent);
                require_once (ABSPATH . "wp-admin" . '/includes/image.php');

                //generates metadata for an image attachment. It also creates a thumbnail and other intermediate sizes of the image attachment based on the sizes defined on the Settings_Media_Screen.
                $attach_data = wp_generate_attachment_metadata($attach_id, $file_name_and_location);
				wp_update_attachment_metadata($attach_id, $attach_data);
                return $attach_id;
            } else {
                 // wp_handle_upload returned some kind of error. the return does contain error details, so you can use it here if you want.
                return new WP_Error('upload_error', __('There was a problem with your upload.', 'opaljob'));
            }
        } else {
             // No file was passed
            return new WP_Error('upload_error', __('Where is the file?', 'opaljob'));
        }
    }

    /**
     * update branding : logo, mobile icon
     */
    function upload_image() {
        global $user_ID;
        $res = array(
            'success' => false,
            'msg' => __('There is an error occurred', opaljob) ,
            'code' => 400,
        );

        /**
         * User must login to upload image
         */
        if(!$user_ID) {
            $res['msg'] = __("You must login to upload image.", 'opaljob');
            wp_send_json( $res );
        }

        // check fileID
        if (!isset($_POST['fileID']) || empty($_POST['fileID'])) {
            $res['msg'] = __('Missing image ID', 'opaljob');
        } else {
            $fileID = $_POST["fileID"];
            $imgType = $fileID;
            // check ajax nonce
            if (!check_ajax_referer($imgType . '_uploader', false, false) ) {
                $res['msg'] = __('Security error!', 'opaljob');
            } elseif (isset($_FILES[$fileID])) {
                //
                $upload_mimes = apply_filters('et_upload_file_upload_mimes', array(
                    'jpg|jpeg|jpe' => 'image/jpeg',
                    //'gif' => 'image/gif',
                    'png' => 'image/png',
                    'bmp' => 'image/bmp',
                    //'tif|tiff' => 'image/tiff',
                     //'doc|docx' => 'application/msword' ,
                     'pdf' => 'application/pdf',
                    // 'zip' => 'multipart/x-zip'
                ));
                $attach_id = $this->opal_process_file_upload($_FILES[$fileID], 0, 0, $upload_mimes);

                if (!is_wp_error($attach_id)) {
                    try {
                    	if ($_FILES[$fileID]['type'] =="application/pdf") {
                    		$attach_data['title'] = get_the_title( $attach_id );
                    		$attach_data['type'] = "pdf";
                            $attach_data['id'] = $attach_id;
                    	}else{
                    		$attach_data = wp_get_attachment_metadata($attach_id);
                    	}
                        
                        $res = array('success' => true,
                        	'code' => 200,
                        	'msg' => __('Your file has been uploaded', 'opaljob'),
                        	'data' => $attach_data,
                        	);
                    }
                    catch(Exception $e) {
                        $res['msg'] = __('Error when updating settings.', 'opaljob');
                    }
                } else {
                    $res['msg'] = $attach_id->get_error_message();
                }

            } else {
                $res['msg'] = __('Uploaded file not found', 'opaljob');
            }
        }
        // send json to client
        wp_send_json($res);
    }

}
/**
 * Class init all function action of Opaljob
 * @package Opaljob
 * @author Dattq
*/
Class Opal_Init extends Opal_Base{
	static $instance;
	public static function get_instance(){
		if(self::$instance == null){
			self::$instance = new Opal_init();
		}
		return self::$instance;
	}
	public function __construct(){
		//new class
		new Opal_Theme_Action();
		$this->add_action( 'wp_footer', 'load_modal_template', 10, 1 );


		
	}
	function load_modal_template(){
		if(is_singular('opaljob_work')){
			echo Opaljob_Template_Loader::get_template_part('modal/modal-apply-job');
		}
	}
	
}

//add action run init function after theme setup
if(!function_exists('opal_init_function')){
	function opal_init_function(){
		Opal_Init::get_instance();
	}
}
add_action('after_setup_theme','opal_init_function');


?>