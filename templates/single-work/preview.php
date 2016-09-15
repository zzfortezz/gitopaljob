<div class="work-preview">
	<?php
	global $work;
	$galleries = $work->getGallery();
	if ( has_post_thumbnail() || !empty( $galleries ) ):
	?>

	<div class="owl-carousel-play" data-ride="carousel">
		<div class="owl-carousel-wrapper">
			<div id="sync1" class="owl-carousel" data-slide="1"  data-singleItem="true" data-navigation="true" data-pagination="false">

				<?php if ( has_post_thumbnail() ): ?>
					<?php the_post_thumbnail( 'full' ); ?>
				<?php endif; ?>

				<?php if( isset($galleries[0]) ): ?>
					<?php foreach ($galleries[0] as $src): ?>
						<img src="<?php echo $src; ?>" alt="gallery">
					<?php endforeach; ?>
				<?php endif; ?>
				
			</div>

			<a class="opaljob-left carousel-control carousel-md radius-x" data-slide="prev" href="#">
				<span class="fa fa-angle-left"></span>
			</a>
			<a class="opaljob-right carousel-control carousel-md radius-x" data-slide="next" href="#">
				<span class="fa fa-angle-right"></span>
			</a>

		</div>

		<div class="owl-thumb-wrapper">
			<div id="sync2" class="owl-carousel">
			  	<?php if ( has_post_thumbnail() ): ?>
					<?php the_post_thumbnail( 'full' ); ?>
				<?php endif; ?>

				<?php if( isset($galleries[0]) ): ?>
					<?php foreach ($galleries[0] as $src): ?>
						<img src="<?php echo $src; ?>" alt="gallery">
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>		
	 	
	</div>

	<?php endif; ?>

</div>