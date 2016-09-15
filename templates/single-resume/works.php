?php
global $post;
$works = Opaljob_Query::get_company_work( null, get_the_ID(), 3 );
if( $works->have_posts() ) :
?>
<div class="clearfix clear"></div>
<div class="opaljob-box work-same-company-section">
	<h3><?php _e('Jobs','opaljob');?></h3>
	<div class="box-content opaljob-rows">
		<div class="row">
			<?php while( $works->have_posts() ) : $works->the_post(); ?>
			  	<div class="col-lg-12 col-md-12 col-sm-12">
			  	 <?php echo Opaljob_Template_Loader::get_template_part( 'content-work-list' ); ?>
			  	</div> 
			<?php endwhile; ?>	
		</div>
	</div>	
</div>	
<?php endif; ?>
<?php wp_reset_postdata(); ?>