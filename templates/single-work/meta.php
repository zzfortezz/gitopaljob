<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $work, $post;

$meta   = $work->getMetaShortInfo();
?>
<div class="work-meta">
	<div class="row">
		<div class="col-lg-3 col-md-3">
			<div class="work-price">
				<span><?php _e('Price:', 'opaljob'); ?> <?php echo opaljob_price_format( $work->getPrice() ); ?></span>

				<?php if( $work->getSalePrice() ): ?>
				<span class="work-saleprice">
					<?php echo opaljob_price_format( $work->getSalePrice() ); ?>
				</span>
				<?php endif; ?>

				<?php if( $work->getPriceLabel() ):  ?>
				<span class="work-price-label">
					/ <?php echo $work->getPriceLabel(); ?>
				</span>	
				<?php endif; ?>
			</div>
		</div>
		<div class="col-lg-9 col-md-9">	
			<ul class="work-meta-list list-inline">
				<?php if( $meta ) : ?>
					<?php foreach( $meta as $key => $info ) : ?>
						<li class="work-label-<?php echo $key; ?>"><i class="icon-work-<?php echo $key; ?>"></i><?php echo $info['label']; ?> <span><?php echo apply_filters( 'opaljob_'.$key.'_unit_format',  trim($info['value']) ); ?></span></li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>	
		</div>	
	</div>
</div>	