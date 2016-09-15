<?php global $work, $post; 
	$work = opaljob_works( get_the_ID() );
	$meta   = $work->getMetaShortInfo();
	$work->setPostViews();
?> 
<article id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Work" <?php post_class(); ?>>
	<header>
		<div class="row">
			<div class="col-lg-9">
				<?php the_title( '<h1 class="entry-title pull-left">', '</h1>' ); ?>
				<span class="count"><?php echo $work->getPostViews(); ?></span>
				<span class="count applications"><?php echo $work->countApplyWork(); ?></span>
			 	
				<?php if( $work->isFeatured() ): ?>
				<span class="work-label label label-warning">
					<i class="fa fa-star"></i>
				</span>
				<?php endif; ?>
			</div>
			<div class="col-lg-3">
				<div class="work-price">
					<?php if(is_numeric($work->getPrice())) { ?>
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
					<?php } else { ?>
						<span><?php echo  $work->getPrice(); ?></span>
					<?php } ?>	
				</div>

			</div>
			<?php if($work->getExpires()) : ?>
			<div class="work-expires col-lg-12">
					<?php echo 'Expires on'.':'.$work->getExpires(); ?>
			</div>
			<?php endif; ?>
		</div>

		<div class="work-meta">
			<div class="work-address">
				<?php echo $work->getAddress(); ?>
			</div>		

		</div>	
	
	</header>		
	

	<?php
		/**
		 * opaljob_before_single_work_summary hook
		 *
		 * @hooked opaljob_show_product_sale_flash - 10
		 * @hooked opaljob_show_product_images - 20
		 */
		//do_action( 'opaljob_single_work_preview' ); 
	?>

	<div class="summary entry-summary">
		<div class="row">
			<div class="col-lg-4 col-md-5">
				<?php
					/**
					 * opaljob_single_work_summary hook
					 *
					 * @hooked opaljob_template_single_title - 5
					 * @hooked opaljob_template_single_rating - 10
					 * @hooked opaljob_template_single_price - 10
					 * @hooked opaljob_template_single_excerpt - 20
					 * @hooked opaljob_template_single_add_to_cart - 30
					 * @hooked opaljob_template_single_meta - 40
					 * @hooked opaljob_template_single_sharing - 50
					 */
					do_action( 'opaljob_single_work_summary' );
				?>		
			</div>
			<div class="col-lg-8 col-md-7">	
				<?php echo opaljob_work_content(); ?>	
			</div>
		</div>
	</div><!-- .summary -->
	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</article><!-- #post-## -->
