<?php
global $work;
$maps = $work->getMap();

if ( !empty($maps) ):
?>
<div class="opaljob-box work-map-section">
	<h3 class="box-heading"><?php _e( 'Location' ); ?></h3>
	<div class="box-content">
		   <div id="work-map" style="height:400px"></div>
	</div>
</div>

<script type="text/javascript">

    /* Work Detail Page - Google Map for Work Location */
    function initialize_work_map(){

        var workMarkerInfo = {"lat":"<?php echo (isset($maps['latitude']) ? $maps['latitude'] : ''); ?>","lang":"<?php echo (isset($maps['longitude']) ? $maps['longitude'] : ''); ?>","icon":"http:\/\/realplaces.inspirythemes.biz\/wp-content\/themes\/inspiry-real-places\/images\/map\/single-family-home-map-icon.png","retinaIcon":"http:\/\/realplaces.inspirythemes.biz\/wp-content\/themes\/inspiry-real-places\/images\/map\/single-family-home-map-icon@2x.png"}
        var url = workMarkerInfo.icon;
        var size = new google.maps.Size( 42, 57 );

        // retina
        if( window.devicePixelRatio > 1.5 ) {
            if ( workMarkerInfo.retinaIcon ) {
                url = workMarkerInfo.retinaIcon;
                size = new google.maps.Size( 83, 113 );
            }
        }
        var image = {
            url: url,
            size: size,
            scaledSize: new google.maps.Size( 42, 57 ),
            origin: new google.maps.Point( 0, 0 ),
            anchor: new google.maps.Point( 21, 56 )
        };
        var workLocation = new google.maps.LatLng( workMarkerInfo.lat, workMarkerInfo.lang );
        var workMapOptions = {
            center: workLocation,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false
        };
        var workMap = new google.maps.Map( document.getElementById( "work-map" ), workMapOptions );
        var workMarker = new google.maps.Marker({
            position: workLocation,
            map: workMap,
            icon: image
        });
    }

    window.onload = initialize_work_map();

</script>
<?php endif;?>
