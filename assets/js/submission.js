(function ($){
	$(function(){
		$('form#frm_apply_job').submit(function(e){
	        e.preventDefault();
	        if($('.opaljob-contact-form .create-resume').length >0 ) {
	            $('.opaljob-contact-form .create-resume').css("color","red");
	        } else {
	            var data = $('form.opaljob-contact-form').serialize();
	            console.log(data);
	            return false;
	            var ajaxurl;
	            ajaxurl  =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
	            $.ajax({
	                url: ajaxurl,
	                type:'POST',
	                dataType: 'json',
	                data:  'action=send_email_contact&' + data
	            }).done(function(data) {
	                var $parent = $('form.opaljob-contact-form').parent();  
	                if( $parent.find('#work-contact-notify').length > 0 ){
	                    $parent.find('#work-contact-notify').html( data.message  );
	                }else {
	                    $('form.opaljob-contact-form').prepend('<p id="work-contact-notify" class="'+ data.status +'">'+ data.message +'</p>'); 
	                }
	                document.location.href = ajaxcalls_vars.apply_redirect;
	            });

	            return false;
	        }
	    });
	})
}(jQuery));
