<?php
Class Opal_Mailing extends Opal_Base{
	static $instance;
	public function get_instance(){
		if(self::$instance == null){
			self::$instance = new Opal_Mailing();
		}
		return self::$instance;
	}
	function __construct(){
	}

	public function inbox_mail($author, $mes){
		
		$body = opaljob_options('sent_contact_form_email_body');
	}
}
?>