<?php
global $post;
$company_id = Opaljob_Query::get_company_by_work($post->ID);
$works = Opaljob_Query::get_company_work( get_the_ID(), $company_id, 3 );
if( $works->have_posts() ) :
?>
<div class="box-info work-same-company-section clearfix">
	<h3><?php printf( __( 'Job by %s', 'opaljob' ), get_the_title( $company_id ) ); ?></h3>
	<div class="box-content opaljob-rows">
		<div class="row">
			<?php while( $works->have_posts() ) : $works->the_post(); ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			  	<?php echo Opaljob_Template_Loader::get_template_part( 'content-work-list' ); ?>
			  	</div>
			<?php endwhile; ?>	
		</div>		
	</div>	
</div>	
<?php wp_reset_postdata(); ?>
<?php endif;  ?>

 