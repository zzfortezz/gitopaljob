jQuery(document).ready(function($) {
     "use strict";
  
      if (typeof(plupload) !== 'undefined') {
            var uploader = new plupload.Uploader(ajax_vars.plupload);
            uploader.init();
            uploader.bind('FilesAdded', function (up, files) {
               
                $.each(files, function (i, file) {
                    
                    $('#aaiu-upload-imagelist').append(
                        '<div id="' + file.id + '">' +
                        file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
                        '</div>');
                });

                up.refresh(); // Reposition Flash/Silverlight
                uploader.start();
            });

            uploader.bind('UploadProgress', function (up, file) {
                $('#' + file.id + " b").html(file.percent + "%");
            });

            // On erro occur
            uploader.bind('Error', function (up, err) {
                $('#aaiu-upload-imagelist').append("<div>Error: " + err.code +
                    ", Message: " + err.message +
                    (err.file ? ", File: " + err.file.name : "") +
                    "</div>"
                );   
                up.refresh(); // Reposition Flash/Silverlight
            });



            uploader.bind('FileUploaded', function (up, file, response) {
        
               
                var result = $.parseJSON(response.response);
                 
            
                $('#image_warn').remove();
                $('#' + file.id).remove();
                if (result.success) {               
                   
                    $('#profile-image').attr('src',result.html);
                    $('#profile-image').attr('data-profileurl',result.html);
                    $('#profile-image').attr('data-smallprofileurl',result.attach);
                    $('input[name=profile_image_url]').val(result.html);
                    $('input[name=profile_image_url_small]').val(result.attach);
                    var all_id=$('#attachid').val();
                    all_id=all_id+","+result.attach;
                    $('#attachid').val(all_id);
                            
                    if (result.html!==''){
                        if(ajax_vars.is_floor === '1'){
                            $('#no_plan_mess').remove();
                            $('#imagelist').append('<div class="uploaded_images floor_container" data-imageid="'+result.attach+'"><input type="hidden" name="plan_image_attach[]" value="'+result.attach+'"><input type="hidden" name="plan_image[]" value="'+result.html+'"><img src="'+result.html+'" alt="thumb" /><i class="fa deleter fa-trash-o"></i>'+to_insert_floor+'</div>');
                    
                        }else{
                            $('#imagelist').append('<div class="uploaded_images" data-imageid="'+result.attach+'"><img src="'+result.html+'" alt="thumb" /><i class="fa deleter fa-trash-o"></i> </div>');
                        }
                        
                    }else{
                        $('#imagelist').append('<div class="uploaded_images" data-imageid="'+result.attach+'"><img src="'+ajax_vars.path+'/img/pdf.png" alt="thumb" /><i class="fa deleter fa-trash-o"></i> </div>');
                    
                    }
                    // $( "#imagelist" ).sortable({
                        // revert: true,
                        // update: function( event, ui ) {
                            // var all_id,new_id;
                            // all_id="";
                            // $( "#imagelist .uploaded_images" ).each(function(){
                                
                                // new_id = $(this).attr('data-imageid'); 
                                // if (typeof new_id != 'undefined') {
                                    // all_id=all_id+","+new_id; 
                                   
                                // }
                               
                            // });
                          
                            // $('#attachid').val(all_id);
                        // },
                    // });
 
                       
                    //delete_binder();
                    //thumb_setter();
                }else{
                    
                    if (result.image){ 
                        $('#imagelist').before('<div id="image_warn" style="width:100%;float:left;">'+ajax_vars.warning+'</div>');
                    }
                }
            });

     
            $('#aaiu-uploader').click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                uploader.start();
            });
            
            $('#aaiu-uploader2').click(function (e) {
                uploader.start();
                e.preventDefault();
            });
                  
            $('#aaiu-uploader-floor').click(function (e) {
                e.preventDefault();
                $('#aaiu-uploader').trigger('click');
            });      
                     
    }


    if (typeof(plupload) !== 'undefined') {
        var uploaderID = $(".opal_uploader").data('type');
        var config = {
            runtimes        : 'html5,gears,flash,silverlight,browserplus,html4',
            container       : uploaderID + '_container',
            drop_element    : uploaderID + '_container',
            browse_button   : uploaderID + '_browse_button',
            remove_button   : uploaderID + '_remove_button',
            file_data_name  : uploaderID,
            max_file_size   : '3mb',
            url             : ajaxurl,
            //flash_swf_url     : includes_url('js/plupload/plupload.flash.swf'),
            multipart       : true,
            urlstream_upload: true,
            multiple_queues : true,
            multi_selection : false,
            upload_later    : false,
            thumbsize       : 'thumbnail',
            max_file_size   : '3mb',
            //chunk_size                         : '1mb',
            // this filters is an array so if we declare it when init Uploader View, this filters will be replaced instead of extend
            filters: {
                mime_types: [{
                    title: 'Image Files',
                    extensions: (options.extensions) ? options.extensions : 'pdf,jpg,jpeg,png,ico'
                }]
            },
            multipart_params: {
                fileID: uploaderID,
                action: 'opal-upload-files',
                _ajax_nonce: nonce
            },
        }
        var uploader = new plupload.Uploader(config);
        //init upload
        uploader.init();
        uploader.bind('FilesAdded', function (up, files) {
           
            $.each(files, function (i, file) {
                
                $('#aaiu-upload-imagelist').append(
                    '<div id="' + file.id + '">' +
                    file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
                    '</div>');
            });

            up.refresh(); // Reposition Flash/Silverlight
            uploader.start();
        });

        uploader.bind('UploadProgress', function (up, file) {
            $('#' + file.id + " b").html(file.percent + "%");
        });

        // On erro occur
        uploader.bind('Error', function (up, err) {
            $('#aaiu-upload-imagelist').append("<div>Error: " + err.code +
                ", Message: " + err.message +
                (err.file ? ", File: " + err.file.name : "") +
                "</div>"
            );   
            up.refresh(); // Reposition Flash/Silverlight
        });



        uploader.bind('FileUploaded', function (up, file, response) {
    
           
            var result = $.parseJSON(response.response);
             
        
            $('#image_warn').remove();
            $('#' + file.id).remove();
            if (result.success) {               
               
                $('#profile-image').attr('src',result.html);
                $('#profile-image').attr('data-profileurl',result.html);
                $('#profile-image').attr('data-smallprofileurl',result.attach);
                $('input[name=profile_image_url]').val(result.html);
                $('input[name=profile_image_url_small]').val(result.attach);
                var all_id=$('#attachid').val();
                all_id=all_id+","+result.attach;
                $('#attachid').val(all_id);
                        
                if (result.html!==''){
                    if(ajax_vars.is_floor === '1'){
                        $('#no_plan_mess').remove();
                        $('#imagelist').append('<div class="uploaded_images floor_container" data-imageid="'+result.attach+'"><input type="hidden" name="plan_image_attach[]" value="'+result.attach+'"><input type="hidden" name="plan_image[]" value="'+result.html+'"><img src="'+result.html+'" alt="thumb" /><i class="fa deleter fa-trash-o"></i>'+to_insert_floor+'</div>');
                
                    }else{
                        $('#imagelist').append('<div class="uploaded_images" data-imageid="'+result.attach+'"><img src="'+result.html+'" alt="thumb" /><i class="fa deleter fa-trash-o"></i> </div>');
                    }
                    
                }else{
                    $('#imagelist').append('<div class="uploaded_images" data-imageid="'+result.attach+'"><img src="'+ajax_vars.path+'/img/pdf.png" alt="thumb" /><i class="fa deleter fa-trash-o"></i> </div>');
                
                }
                // $( "#imagelist" ).sortable({
                    // revert: true,
                    // update: function( event, ui ) {
                        // var all_id,new_id;
                        // all_id="";
                        // $( "#imagelist .uploaded_images" ).each(function(){
                            
                            // new_id = $(this).attr('data-imageid'); 
                            // if (typeof new_id != 'undefined') {
                                // all_id=all_id+","+new_id; 
                               
                            // }
                           
                        // });
                      
                        // $('#attachid').val(all_id);
                    // },
                // });

                   
                //delete_binder();
                //thumb_setter();
            }else{
                
                if (result.image){ 
                    $('#imagelist').before('<div id="image_warn" style="width:100%;float:left;">'+ajax_vars.warning+'</div>');
                }
            }
        });

 
        $('#aaiu-uploader').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            uploader.start();
        });
        
        $('#aaiu-uploader2').click(function (e) {
            uploader.start();
            e.preventDefault();
        });
              
        $('#aaiu-uploader-floor').click(function (e) {
            e.preventDefault();
            $('#aaiu-uploader').trigger('click');
        });      
                     
    }
});
 