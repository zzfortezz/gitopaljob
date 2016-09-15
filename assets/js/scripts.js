

jQuery(document).ready(function($){
 
 
    // jQuery('#opaljob_ppt_text').summernote({
   //     height: 200
    //  });

    //
    $(".owl-carousel-play .owl-carousel").each( function(){
        var config = {
            navigation : false, // Show next and prev buttons
            slideSpeed : 300,
            paginationSpeed : 400,
            pagination : $(this).data( 'pagination' ),
            autoHeight: true,
            pagination : true,
             items : 3,
         }; 
        var owl = $(this);
        if( $(this).data('slide') == 1 ){
            config.singleItem = true;
        }else {
            config.items = $(this).data( 'slide' );
        }
        if ($(this).data('desktop')) {
            config.itemsDesktop = $(this).data('desktop');
        }
        if ($(this).data('desktopsmall')) {
            config.itemsDesktopSmall = $(this).data('desktopsmall');
        }
        if ($(this).data('desktopsmall')) {
            config.itemsTablet = $(this).data('tablet');
        }
        if ($(this).data('tabletsmall')) {
            config.itemsTabletSmall = $(this).data('tabletsmall');
        }
        if ($(this).data('mobile')) {
            config.itemsMobile = $(this).data('mobile');
        }
        $(this).owlCarousel( config );
        $('.opaljob-left',$(this).parent()).click(function(){
              owl.trigger('owl.prev');
              return false; 
        });
        $('.opaljob-right',$(this).parent()).click(function(){
            owl.trigger('owl.next');
            return false; 
        });
    } );
    // apply send email
    $('form.opaljob-contact-form').submit(function(e){
        e.preventDefault();
        if($('.opaljob-contact-form .create-resume').length >0 ) {
            $('.opaljob-contact-form .create-resume').css("color","red");
        } else {
            var data = $('form.opaljob-contact-form').serialize();
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
    // approve send email
    $('form.opaljob-contact-approve-form').submit(function(){

        var data = $('form.opaljob-contact-approve-form').serialize();
        var ajaxurl;
        ajaxurl  =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
        $.ajax({
            url: ajaxurl,
            type:'POST',
            dataType: 'json',
            data:  'action=send_email_contact_approve&' + data
        }).done(function(data) {
            var $parent = $('form.opaljob-contact-approve-form');  
            if( $parent.find('#approve-contact-notify').length > 0 ){
                $parent.find('#approve-contact-notify').html( data.message  );
            }else {
                $('.opaljob-contact-approve-form').prepend('<p id="approve-contact-notify" class="'+ data.status +'">'+ data.message +'</p>'); 
            }
            document.location.href = ajaxcalls_vars.apply_redirect;
        });

        return false;
    });

    // rejected send email
    $('form.opaljob-contact-rejected-form').submit(function(){

        var data = $('form.opaljob-contact-rejected-form').serialize();
        var ajaxurl;
        ajaxurl  =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
        $.ajax({
            url: ajaxurl,
            type:'POST',
            dataType: 'json',
            data:  'action=send_email_contact_rejected&' + data
        }).done(function(data) {
            var $parent = $('form.opaljob-contact-rejected-form');  
            if( $parent.find('#rejected-contact-notify').length > 0 ){
                $parent.find('#rejected-contact-notify').html( data.message  );
            }else {
                $('.opaljob-contact-rejected-form').prepend('<p id="rejected-contact-notify" class="'+ data.status +'">'+ data.message +'</p>'); 
            }
            document.location.href = ajaxcalls_vars.apply_redirect;
        });

        return false;
    });
    // update my profile
    $('form.opaljob-my-profile').submit(function(){

        var data = $('form.opaljob-my-profile').serialize();
        var ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
     
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: 'action=opaljob_update_profile&' + data
        }).done(function(data) {
            var $parent = $('#profile_message');
            if( $parent.length > 0 ){
                $parent.html( data.message  );
            }else {
                $('form.opaljob-my-profile').prepend('<p id="profile_message" class="'+ data.status +'">'+ data.message +'</p>'); 
            }
        });
        return false;
    });

     // change password 
    $('form.opaljob-change-password').submit(function(){

        var data = $('form.opaljob-change-password').serialize();
        var ajaxurl = ajaxcalls_vars.admin_url + 'admin-ajax.php';
     
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: 'action=opaljob_change_password&' + data
        }).done(function(data) {
            var $parent = $('#profile_pass');
            if( $parent.length > 0 ){
                $parent.html( data.message  );
            }else {
                $('form.opaljob-change-password').prepend('<p id="profile_pass" class="'+ data.status +'">'+ data.message +'</p>'); 
            }
        });
        return false;
    });

    // login ajax
    $('form.login-form').submit(function() {

        var data = $('form.login-form').serialize();
        var ajaxurl;
        ajaxurl               =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
        $.ajax({
            url: ajaxurl,
            type:'POST',
            dataType: 'json',
            data:  'action=ajaxDoLogin&' + data
        }).done(function(data) {           
            jQuery('.lead').empty().append('<div class="login-alert">' + data.message + '<div>');
            if (data.loggedin === true) {
              document.location.href = ajaxcalls_vars.login_redirect;
            } else {
                jQuery('input[name=pbr_username]').val('');
                jQuery('input[name=pbr_passwordd').val('');
            }
        });

        return false;
      
    });
    $('#pbrlostpasswordform').hide();
    $('form .toggle-links').on('click', function(){
        $('.form-wrapper').hide();
        $($(this).attr('href')).show(); 
        return false;
    } );

     $('form.lostpassword-form').submit(function() {

        var data = $('form.lostpassword-form').serialize();
        var ajaxurl;
        ajaxurl               =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
        $.ajax({
            url: ajaxurl,
            type:'POST',
            dataType: 'json',
            data:  'action=doForgotPassword&' + data
        }).done(function(data) {           
            jQuery('.lead').empty().append('<div class="login-alert">' + data.message + '<div>');
            if (data.loggedin === true) {
              document.location.href = ajaxcalls_vars.login_redirect;
            } 
        });

        return false;
      
    });

    $('form.signup-form').submit(function() {

        var data = $('form.signup-form').serialize();
        var ajaxurl;
        ajaxurl               =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
        $.ajax({
            url: ajaxurl,
            type:'POST',
            dataType: 'json',
            data:  'action=ajaxDoSignup&' + data
        }).done(function(data) {           
            jQuery('.wpcrl-loader').empty().append('<div class="login-alert">' + data.message + '<div>');
            if (data.signup === true) {
              document.location.href = ajaxcalls_vars.login_redirect;
            } else {
                jQuery('input[name=pbr_username]').val('');
                jQuery('input[name=pbr_passwordd').val('');
            }
        });

        return false;
      
    });

    // save work
    $('a.opaljob-save-work').on("click", function(){

        var $this = $(this);
        var saved = $this.hasClass('saved');
        var ajaxurl;
        ajaxurl   =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
        $.ajax({
            url: ajaxurl,
            type:'POST',
            dataType: 'json',
            data:   {
                action: $this.attr('data-action'),
                security: $this.attr('data-security'),
                job_id: $this.attr('data-job-id')
            }
        }).done(function(data) {   
            $('.opaljob-ajax-result').show().html(data.message);
            if (data.success == true) {
                if( saved )
                    $this.removeClass('saved');
                else
                    $this.addClass('saved');

                $this.closest('.job-action').find('.opaljob-ajax-result').show().html(data.message);
                if (data.redirecturl == null) {
                    // document.location.reload();
                }
                else {
                    document.location.href = data.redirecturl;
                }
            }
        });

        return false;
      
    });
    /**
     *
     */

    $('a.opaljob-read').on("click", function(){

        var $this = $(this);
        var read = $this.hasClass('read');
        var ajaxurl;
        ajaxurl   =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
        $.ajax({
            url: ajaxurl,
            type:'POST',
            dataType: 'json',
            data:   {
                action: $this.attr('data-action'),
                apply_id: $this.attr('data-apply-id')
            }
        }).done(function(data) {   
            $('.opaljob-ajax-result').show().html(data.message);
            if (data.success == true) {
                if( read )
                    $this.removeClass('read');
                else
                    $this.addClass('read');

                $this.closest('.job-action').find('.opaljob-ajax-result').show().html(data.message);
                if (data.redirecturl == null) {
                    // document.location.reload();
                }
                else {
                    document.location.href = data.redirecturl;
                }
            }
        });

        return false;
      
    });
    


  

    $('.opaljob-approve').each( function() {
        $(this).on("click", function() {
            $('input[name=post_id]').val($(this).attr('data-apply-id')); 
            $('input[name=company_id]').val($(this).attr('data-company-id')); 
            $('input[name=email]').val($(this).attr('data-email')); 
            $('input[name=name]').val($(this).attr('data-name'));  
        });

     });

    $('.opaljob-rejected').each( function() {
        $(this).on("click", function() {
            $('input[name=post_id]').val($(this).attr('data-apply-id')); 
            $('input[name=company_id]').val($(this).attr('data-company-id')); 
            $('input[name=email]').val($(this).attr('data-email')); 
            $('input[name=name]').val($(this).attr('data-name'));  
        });

     });

    $('form.opaljob_filters').on('change',function () {
        $('input[name=loadmore]').val(0);
        opaljob_filters();
    });

    $(window).load(function() {
        if($('form.opaljob_filters').length > 0) {
            $('input[name=loadmore]').val(0);
            opaljob_filters();
        }
    });

    $('.load_more_jobs').on('click',function(e) {
        e.preventDefault();
        var total = 7 + parseInt($('input[name=loadmore]').val());
        $('input[name=loadmore]').val(total);
        opaljob_filters();
    });

    function opaljob_filters() {

        var filter_job_type =$( 'input[name="filter_job_type"]:checked').val() ;
        var form = $('form.opaljob_filters').serialize();
        var ajaxurl;
        ajaxurl   =  ajaxcalls_vars.admin_url + 'admin-ajax.php';
        $.ajax( {
            type:'POST',
            url: ajaxurl,
            dataType: 'json',
            data: 'action=ajaxFilterJob&'+form,
        }).done(function(data) { 
            if(data.status == 'hidden') {
                $('.load_more_jobs').addClass(data.status);
            } else {
                $('.load_more_jobs').removeClass('hidden');
            }
            $('ul.job_listings').html(data.message);
        });  
    }
    

    $('.list-work-status li').click( function(){
        $("#opaljob-search-form [name=status]").val( $(this).data('id') );
        $('.list-work-status li').removeClass( 'active' );
        $(this).addClass( 'active' );
    } );  
    if(  $("#opaljob-search-form [name=status]").val() > 0 ){
        var id = $("#opaljob-search-form [name=status]").val();
        $('.list-work-status li').removeClass( 'active' );
        $('.list-work-status [data-id='+id+']').addClass( 'active' );
    }

   
    /**
     *
     */
     if($('#opaljob-map-preview').length > 0) { 
      
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: ajaxurl,
            data:  location.search.substr(1)+"&action=opaljob_ajx_get_works",
            success: function(data) {
               initializePropertiesMap( data );
            }
        });
    }

    if($('.search-resumes-form').length > 0 ) {

        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: ajaxurl,
            data:  location.search.substr(1)+"&action=opaljob_ajax_get_resumes",
            success: function(data) {
              
            }
        });
    }

    
    function initializePropertiesMap( properties ) {

            // Properties Array
            
            var mapOptions = {
                zoom: 12,
                maxZoom: 16,
                scrollwheel: false
            };

            var map = new google.maps.Map( document.getElementById( "opaljob-map-preview" ), mapOptions );

            var bounds = new google.maps.LatLngBounds();

            // Loop to generate marker and infowindow based on properties array
            var markers = new Array();

            for ( var i=0; i < properties.length; i++ ) {

                var url = properties[i].icon;
                var size = new google.maps.Size( 42, 57 );
                if( window.devicePixelRatio > 1.5 ) {
                    if ( properties[i].retinaIcon ) {
                        url = properties[i].retinaIcon;
                        size = new google.maps.Size( 83, 113 );
                    }
                }

                var image = {
                    url: url,
                    size: size,
                    scaledSize: new google.maps.Size( 30, 51 ),
                    origin: new google.maps.Point( 0, 0 ),
                    anchor: new google.maps.Point( 21, 56 )
                };

                markers[i] = new google.maps.Marker({
                    position: new google.maps.LatLng( properties[i].lat, properties[i].lng ),
                    map: map,
                    icon: image,
                    title: properties[i].title,
                    animation: google.maps.Animation.DROP,
                    visible: true
                });

                bounds.extend( markers[i].getPosition() );

                var boxText = document.createElement( "div" );
                var pricelabel = '';
                
                if( properties[i].pricelabel ){
                     pricelabel = ' / ' + properties[i].pricelabel;
                }

                boxText.className = 'map-info-preview media';
                boxText.innerHTML = '<div class="media-left"><a class="thumb-link" href="' + properties[i].url + '">' +
                                        '<img class="prop-thumb" src="' + properties[i].thumb + '" alt="' + properties[i].title + '"/>' +
                                        '</a></div>' +
                                        '<div class="info-container media-body">'  + 
                                        '<h5 class="prop-title"><a class="title-link" href="' + properties[i].url + '">' + properties[i].title + 
                                        '</a></h5><p class="prop-address"><em>' + properties[i].address + '</em></p><p>'+ 
                                        '</p></div><div class="arrow-down"></div>';


                var myOptions = {
                    content: boxText,
                    disableAutoPan: true,
                    maxWidth: 0,
                    alignBottom: true,
                    pixelOffset: new google.maps.Size( -122, -48 ),
                    zIndex: null,
                    closeBoxMargin: "0 0 -16px -16px",
                    closeBoxURL: opalsiteurl+"/images/map/close.png",
                    infoBoxClearance: new google.maps.Size( 1, 1 ),
                    isHidden: false,
                    pane: "floatPane",
                    enableEventPropagation: false
                };

                var ib = new InfoBox( myOptions );

                attachInfoBoxToMarker( map, markers[i], ib );
            }

            map.fitBounds(bounds);

            /* Marker Clusters */
            var markerClustererOptions = {
                ignoreHidden: true,
                maxZoom: 14,
                styles: [{
                    textColor: '#000000',
                    url: opalsiteurl+"/images/map/cluster-icon.png",
                    height: 51,
                    width: 30
                }]
            };

            var markerClusterer = new MarkerClusterer( map, markers, markerClustererOptions );

            function attachInfoBoxToMarker( map, marker, infoBox ){
                google.maps.event.addListener( marker, 'click', function(){
                    var scale = Math.pow( 2, map.getZoom() );
                    var offsety = ( (100/scale) || 0 );
                    var projection = map.getProjection();
                    var markerPosition = marker.getPosition();
                    var markerScreenPosition = projection.fromLatLngToPoint( markerPosition );
                    var pointHalfScreenAbove = new google.maps.Point( markerScreenPosition.x, markerScreenPosition.y - offsety );
                    var aboveMarkerLatLng = projection.fromPointToLatLng( pointHalfScreenAbove );
                    map.setCenter( aboveMarkerLatLng );
                    infoBox.open( map, marker );
                });
            }

        }

        /**
         * Company Map
         */
        function initialize_company_map( data ){

            var propertyMarkerInfo = data; 
            var enable  = true ;
            var url     = propertyMarkerInfo.icon;   
            var size    = new google.maps.Size( 36, 57 );
           

            var allMarkers = []; 
            /**
             *
             */

            var  createMarker = function ( position, icon ) {
                
                var image   = {
                    url: icon,
                    size: size,
                    scaledSize: new google.maps.Size( 36, 57 ),
                    origin: new google.maps.Point( 0, 0 ),
                    anchor: new google.maps.Point( 21, 56 )
                };

                marker = new google.maps.Marker({
                    map: propertyMap,
                    position: position,
                    icon: image
                });
                return marker; 
            }
            var setMapOnAll = function (markers, map) {
                for (var i = 0; i < markers.length; i++) {
                    markers[i].setMap( map );
                }
            }
            // retina
            if( window.devicePixelRatio > 1.5 ) {
                if ( propertyMarkerInfo.retinaIcon ) {
                    url = propertyMarkerInfo.retinaIcon;
                    size = new google.maps.Size( 83, 113 );
                }
            }
            
            var propertyLocation = new google.maps.LatLng( propertyMarkerInfo.latitude, propertyMarkerInfo.longitude  );
            var propertyMapOptions = {
                center: propertyLocation,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: false
            };
            var propertyMap = new google.maps.Map( document.getElementById( "company-map" ), propertyMapOptions );
            var infowindow = new google.maps.InfoWindow();
            createMarker( propertyLocation, url ); 

        }
        if( $("#company-map").length > 0 ){
            initialize_company_map( $("#company-map").data() );
        }     

    /* end */
});
