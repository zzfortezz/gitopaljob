<?php do_action( "opaljob_submission_job_apply_before" ); 
?>
<div class="resume-job-apply">
	<h1><?php _e( 'Job Apply' ); ?></h1>	
	<div data-example-id="striped-table" class="bs-example"> 
		<table class="table table-striped table-bordered bg-white"> 
			<thead> <tr> 
					<th>#</th> 
					<th><?php _e("Position applying", 'opaljob'); ?></th> 
					<th><?php _e("JobSeeked", 'opaljob'); ?></th> 
					<th><?php _e("Message", 'opaljob'); ?></th>
					<th><?php _e("Resume", 'opaljob'); ?></th>
					<th><?php _e("Application date", 'opaljob'); ?></th> 
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
						<td><?php the_title(); ?></td> 
						<td><?php the_content(); ?></td> 
						<td>
							<a href="<?php echo get_post_meta(get_the_ID(),OPALJOB_APPLY_PREFIX . 'resume',true); ?>"><i class="fa fa-file-text-o"></i></a>
							<a href="<?php echo get_permalink(get_post_meta(get_the_ID(),OPALJOB_APPLY_PREFIX . 'resume_id',true)); ?>"><i class="fa fa-eye"></i></a>
						</td>
		
						<td><?php the_date(); ?></td> 
						<td><span class="status-<?php echo get_post_status(); ?>"><?php echo get_post_status(); ?></span></td> 
						<td>
							<a href="#" class="opaljob-approve" data-email ="<?php echo get_post_meta(get_the_ID(),OPALJOB_APPLY_PREFIX . 'email',true) ?>" 
							data-company-id = "<?php echo get_post_meta(get_the_ID(),OPALJOB_APPLY_PREFIX . 'company_id',true); ?>" data-name = "<?php echo get_the_title(); ?>" data-apply-id = "<?php echo get_the_ID(); ?>"	data-toggle="modal" data-target="#approve-now">
								<i class="fa fa-check-square-o"></i>
							</a>
							<a href="#" class="opaljob-rejected" data-email ="<?php echo get_post_meta(get_the_ID(),OPALJOB_APPLY_PREFIX . 'email',true) ?>" 
							data-company-id = "<?php echo get_post_meta(get_the_ID(),OPALJOB_APPLY_PREFIX . 'company_id',true); ?>" data-name = "<?php echo get_the_title(); ?>" data-apply-id = "<?php echo get_the_ID(); ?>"	data-toggle="modal" data-target="#rejected-now">
								<i class="fa fa-ban"></i>
							</a>
							<a href="<?php echo opaljob_submission_apply_delete( array('remove'=>'delete', 'id' => get_the_ID() , 'page' => 'submission_job_apply_page' )); ?>">
								<i class="fa fa-trash-o"></i>
							</a>
						</td>
						
					</tr> 
				<?php endwhile; ?>

			<?php endif; ?>	

			</tbody> 
		</table> 
	</div>
</div>	
 <div class="modal fade" id="approve-now" role="dialog"> 
	<div class="modal-dialog">   
	    <!-- Modal content-->
	    <div class="modal-content">
	        <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal">&times;</button>
	            <h4 class="modal-title">
	                <?php echo __('Approve','opaljob'); ?>
	            </h4>
	        </div>
	        <div class="modal-body">   
	            <div class="box-content approve-contact-form"> 
	            	<div id="approve-contact-notify"></div>             
	                <form method="post" action="" class="opaljob-contact-approve-form">
	                	<input type="hidden" name="post_id" value="">
	                	<input type="hidden" name="company_id" value="">
                        <input type="hidden" name="email" value="">
                        <input type="hidden" name="name" value="">
	                    <div class="form-group">
	                        <input class="form-control" name="title" value="<?php echo opaljob_options('sent_approve_form_email_subject'); ?>" type="text" placeholder="<?php echo __( 'Title', 'opaljob' ); ?>" required="required">
	                    </div><!-- /.form-group -->

	                    <div class="form-group">
	                        <textarea class="form-control" name="message"  type="textarea" placeholder="<?php echo __( 'Message', 'opaljob' ); ?>" required="required"><?php echo opaljob_options('sent_approve_form_email_body'); ?></textarea>
	                    </div><!-- /.form-group -->
	                    <button class="button btn btn-primary btn-3d" type="submit" name="contact-form"><?php echo __( 'Approve', 'opaljob' ); ?></button>
	                </form>
	            </div><!-- /.apply-contact-form -->
	        </div>    
	    </div>    
	</div>        
</div> 
<div class="modal fade" id="rejected-now" role="dialog"> 
	<div class="modal-dialog">   
	    <!-- Modal content-->
	    <div class="modal-content">
	        <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal">&times;</button>
	            <h4 class="modal-title">
	                <?php echo __('Rejected','opaljob'); ?>
	            </h4>
	        </div>
	        <div class="modal-body">   
	            <div class="box-content rejected-contact-form"> 
	            	<div id="rejected-contact-notify"></div>             
	                <form method="post" action="" class="opaljob-contact-rejected-form">
	                	<input type="hidden" name="post_id" value="">
	                	<input type="hidden" name="company_id" value="">
                        <input type="hidden" name="email" value="">
                        <input type="hidden" name="name" value="">
	                    <div class="form-group">
	                        <input class="form-control" name="title" value="<?php echo opaljob_options('sent_rejected_form_email_subject'); ?>" type="text" placeholder="<?php echo __( 'Title', 'opaljob' ); ?>" required="required">
	                    </div><!-- /.form-group -->

	                    <div class="form-group">
	                        <textarea class="form-control" name="message"  type="textarea" placeholder="<?php echo __( 'Message', 'opaljob' ); ?>" required="required"><?php echo opaljob_options('sent_rejected_form_email_body'); ?></textarea>
	                    </div><!-- /.form-group -->
	                    <button class="button btn btn-primary btn-3d" type="submit" name="contact-form"><?php echo __( 'Approve', 'opaljob' ); ?></button>
	                </form>
	            </div><!-- /.rejected-contact-form -->
	        </div>    
	    </div>    
	</div>        
</div> 
<?php wp_reset_query(); ?>
<?php do_action( "opaljob_submission_job_apply_after" ); ?>