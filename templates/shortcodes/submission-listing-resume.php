<?php do_action( "opaljob_submission_listing_before" ); ?>
<div class="resume-listing">
	<h1><?php _e( 'Edit' ); ?></h1>	
	<div data-example-id="striped-table" class="bs-example"> 
		<table class="table table-striped table-bordered bg-white"> 
			<thead> <tr> 
					<th>#</th> 
					<th><?php _e("ID", 'opaljob'); ?></th> 
					<th><?php _e("Title", 'opaljob'); ?></th> 
					<th><?php _e("Status", 'opaljob'); ?></th> 
					<th><?php _e("Action", 'opaljob'); ?></th> 
					
				</tr> 
				</thead> 
			<tbody> 
			
			<?php if( $loop->have_posts() ): ?> 	
				
				<?php $cnt=0; while ( $loop->have_posts() ) : $loop->the_post(); global $post;  ?>
					<tr>
						<th scope="row"><?php echo ++$cnt; ?></th> 
						<td><?php the_ID(); ?></td>
						<td><a href="<?php echo opaljob_submission_resume_edit( array( 'id' => $post->ID ) ); ?>"><?php the_title(); ?></a></td> 
						<td><span class="status-<?php echo get_post_status(); ?>"><?php echo get_post_status(); ?></span></td> 
						<td>
							<a href="<?php echo opaljob_submission_resume_edit( array( 'id' => $post->ID ) ); ?>"><?php _e( 'Edit', 'opaljob' ); ?></a>
							<a href="<?php echo opaljob_submission_resume_delete( array('remove'=>'delete', 'id' => $post->ID , 'page' => 'submission_list_resume_page' ) ); ?>"><?php _e( 'Delete', 'opaljob' ); ?></a>

						</td> 
						
					</tr> 
				<?php endwhile; ?>

			<?php endif; ?>	

			</tbody> 
		</table> 
	</div>
</div>	
<?php wp_reset_query(); ?>
<?php do_action( "opaljob_submission_listing_after" ); ?>