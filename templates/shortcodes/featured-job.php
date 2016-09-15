<?php 

if( class_exists("Opaljob_Query") ):
	$query = Opaljob_Query::getFeaturedWorks( array("posts_per_page" => 6 ) );  
?>
<div class="widget widget-estate-work">
	
	<h4 class="widget-title text-center">
		<span><?php echo __('Featured Jobs','opaljob'); ?></span>
	</h4>

	<div class="widget-content">
		<div class="opaljob-featured-work owl-carousel-play opaljob-rows">
			<?php if( $query->have_posts() ): ?> 
				 <div class="owl-carousel" data-slide="3"  data-singleItem="true" data-navigation="true" data-pagination="false">
					<?php $cnt=0; while ( $query->have_posts() ) : $query->the_post(); ?>
						<div class="item">
		                	<?php echo Opaljob_Template_Loader::get_template_part( 'content-work-grid' ); ?>
		            	</div>
					<?php $cnt++; endwhile; ?>
				</div>

				<?php //if( $cnt > $limit ) : ?>
				<a class="left carousel-control radius-x" href="#post-slide-<?php $id; ?>" data-slide="prev">
	                <span class="fa fa-angle-left"></span>
	            </a>
	            <a class="right carousel-control radius-x" href="#post-slide-<?php $id; ?>" data-slide="next">
	                <span class="fa fa-angle-right"></span>
	            </a>
	       	 <?php //endif; ?>
			<?php else: ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>	
		</div>
	</div>	
</div>	
<?php endif; ?>
<?php wp_reset_query(); ?>