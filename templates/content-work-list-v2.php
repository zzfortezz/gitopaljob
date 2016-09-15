<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$work = opaljob_works( get_the_ID() );

global $work, $post;

$meta   = $work->getMetaShortInfo();

?>
<article itemscope itemtype="http://schema.org/Work" <?php post_class(); ?>><div class="work-list-style">
	<?php do_action( 'opaljob_before_work_loop_item' ); ?>
	<div class="work-list container-cols-3">
		<header>
			<?php if ( !empty($work->render_company_logo()) ) : ?>
				<div class="work-box-image">
			        <a href="<?php the_permalink(); ?>" class="company-box-image-inner ">
			            <?php echo $work->render_company_logo(); ?>
			        </a>
				</div>
			<?php endif; ?>
			<?php echo $work->renderStatuses(); ?>
			
		</header>

		<div class="abs-col-item">
			<div class="entry-content">
			
				<?php the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
				<?php echo $work->renderTypes(); ?>	
			  	<div class="work-date">
					<?php  the_date(); ?>
				</div>
			  	<div class="work-address">
					<?php echo $work->getAddress(); ?>
				</div>

				<div class="work-price">
					<span><?php echo  opaljob_price_format( $work->getPrice() ); ?></span>

					<?php if( $work->getSalePrice() ): ?>
					<span class="work-saleprice">
						<?php echo  opaljob_price_format( $work->getSalePrice() ); ?>
					</span>
					<?php endif; ?>

					<?php if( $work->getPriceLabel() ): ?>
					<span class="work-price-label">
						/ <?php echo $work->getPriceLabel(); ?>
					</span>	
					<?php endif; ?>
				</div>


			</div><!-- .entry-content -->
		</div> 
		
		<div class="entry-summary">
			<h5><?php echo __( 'Description', 'opaljob' ); ?></h5>
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	</div>	
	

     





	<?php do_action( 'opaljob_after_work_loop_item' ); ?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div></article><!-- #post-## -->
