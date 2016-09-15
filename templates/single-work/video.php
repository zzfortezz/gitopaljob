<?php 
	global $work; 

	$videoURL =  $work->getVideoURL(); 
?>
<?php if( $videoURL  ) : ?>
<div class="work-video-session opaljob-box">
	<h3><?php _e( 'Video' ); ?></h3>

	<div class="box-info">
		<?php echo wp_oembed_get( $videoURL ); ?>
	</div>	
</div>
<?php endif; ?>