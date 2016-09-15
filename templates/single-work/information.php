<?php 
	global $work;
	$infos = $work->getMetaFullInfo();
?>
<div class="work-information opaljob-box">
	<h3 class="box-heading"><?php _e( 'Work Information', 'opaljob' ); ?></h3>
	<div class="box-content">
		<ul class="list-info">
			<?php if(  $infos ): ?>
			
				<?php foreach( $infos as $key => $info ) : ?>
					<?php if( $info['value'] ) : ?>
						<li class="work-label-<?php echo $key; ?>"><span><?php echo $info['label']; ?> :</span>  <?php echo apply_filters( 'opaljob_'.$key.'_unit_format',  trim($info['value']) ); ?></li>
					<?php endif; ?>	
				<?php endforeach; ?>
			<?php endif;  ?>
		</ul>	
	</div>	
</div>		