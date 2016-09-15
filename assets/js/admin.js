jQuery(document).ready(function($){
	$("#install_demo").click(function(){
	  	if($(this).is(":checked")){
            $(this).next('label[for="install_demo"]').text("processing import demo ,please wait ....");
            $.ajax({
            type: 'GET',
            dataType: 'json',
            url: ajaxurl,
            data:  "action=opaljob_ajax_get_import_demo",
            success: function(data) {
                console.log(data);
                $("#install_demo").next('label[for="install_demo"]').addClass(data.status).text(data.message);
            }
        });
        }
    });
    if($("#install_demo").length > 0) {
        $('.opaljob-submit-wrap').css('display','none');
    }
});