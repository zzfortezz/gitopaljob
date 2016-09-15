<?php
global $post;
$works = Opaljob_Query::get_company_work( null, get_the_ID(), 3 );
if( $works->have_posts() ) :
?>
<div class="clearfix clear"></div>
<div class="opaljob-box work-same-company-section">
	<h3><?php _e('Jobs','opaljob');?></h3>
	<div class="box-content opaljob-rows">
			<?php while( $works->have_posts() ) : $works->the_post(); ?>
			  	<?php echo Opaljob_Template_Loader::get_template_part( 'content-work-list' ); ?>
			<?php endwhile; ?>	
	</div>
</div>	

<?php endif; ?>
<?php wp_reset_postdata(); ?>