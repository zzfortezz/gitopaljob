<?php do_action( "opaljob_submission_job_apply_before" ); 

?>
<div class="resume-job-apply">
	<h1><?php _e( 'Job Apply' ); ?></h1>	
	<div data-example-id="striped-table" class="bs-example"> 
		<table class="table table-striped table-bordered bg-white"> 
			<thead> 
				<tr> 
					<th>#</th> 
					<th><?php _e("Position applying", 'opaljob'); ?></th> 				
					<th><?php _e("Application date", 'opaljob'); ?></th>
					<th><?php _e("Company's message", 'opaljob'); ?></th> 
					<th><?php _e("Status", 'opaljob'); ?></th> 
					<th><?php _e("Action", 'opaljob'); ?></th>					
				</tr> 
			</thead> 
			<tbody> 
			
			<?php if( $loop->have_posts() ): ?> 	
				
				<?php $cnt=0; while ( $loop->have_posts() ) : $loop->the_post(); global $post;  ?>
					<tr>
						<th scope="row"><?php echo ++$cnt; ?></th> 
						<td><?php echo get_post_meta(get_the_ID(),OPALJOB_APPLY_PREFIX . 'position_applying',true); ?></td>
						<td><?php the_date(); ?></td> 
						<td><?php the_content(); ?></td>
						<td><span class="status-<?php echo get_post_status(); ?>"><?php echo get_post_status(); ?></span></td> 
						<td>
							<?php if(get_post_meta(get_the_ID(),OPALJOB_APPLY_PREFIX . 'alert_jobseeker') == 1) { ?>
								<a href="#" class="opaljob-read" data-action ="opaljob_ajax_make_read"
								data-apply-id = "<?php echo get_the_ID(); ?>">
									<i class="fa fa-eye"></i>
								</a>
							<?php } else { ?>
								<a class="read" >
									<i class="fa fa-eye-slash"></i>
								</a>
							<?php } ?>	
							<a href="<?php echo opaljob_submission_apply_delete( array('remove'=>'delete', 'id' => get_the_ID() ) ); ?>">
								<i class="fa fa-remove-o"></i>
							</a>			
						</td>
						
					</tr> 
				<?php endwhile; ?>

			<?php endif; ?>	

			</tbody> 
		</table> 
	</div>
</div>	
<?php wp_reset_query(); ?>
<?php do_action( "opaljob_submission_job_apply_after" ); ?>