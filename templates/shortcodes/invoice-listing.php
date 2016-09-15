<?php do_action( "opaljob_invoice_listing_before" ); ?>
<div class="work-listing">
	<h1><?php _e( 'My Invoices','opaljob' ); ?></h1>	
	<div data-example-id="striped-table" class="bs-example"> 
		<table class="table table-striped table-bordered bg-white"> 
			<thead> <tr> 
					<th>#</th> 
					<th><?php _e("ID", 'opaljob'); ?></th> 
					<th><?php _e("Title", 'opaljob'); ?></th>
					<th><?php _e("Package", 'opaljob'); ?></th>
					<th><?php _e("Price", 'opaljob'); ?></th>  				
					<th><?php _e("Purchase Date", 'opaljob'); ?></th> 				
				</tr> 
				</thead> 
			<tbody> 
			
			<?php if( $loop->have_posts() ): ?> 	
				
				<?php $cnt=0; while ( $loop->have_posts() ) : $loop->the_post(); global $post;  ?>
					<tr>
						<th scope="row"><?php echo ++$cnt; ?></th> 
						<td><?php the_ID(); ?></td>
						<td><?php the_title(); ?></td> 
						<td><?php echo get_post_meta(get_the_ID(),'opaljob_ivc_package_name',true);  ?></td> 
						<td><?php echo opaljob_price_format(get_post_meta(get_the_ID(),'opaljob_ivc_package_price',true));  ?></td>
						<td><?php echo get_post_meta(get_the_ID(),'opaljob_ivc_purchase_date',true);  ?></td>
					</tr> 
				<?php endwhile; ?>

			<?php endif; ?>	

			</tbody> 
		</table> 
	</div>
</div>	
<?php wp_reset_query(); ?>
<?php do_action( "opaljob_invoice_listing_after" ); ?>