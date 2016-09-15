<?php
global $post;

$related = Opaljob_Query::getRelated($post->ID);
if( $related->have_posts() ): ?>
	<h4>Related Job</h4>
	<div class="row">
	<?php while ( $related->have_posts() ) : $related->the_post(); 	?>
		<div class="widget ">
    		<?php echo Opaljob_Template_Loader::get_template_part( 'content-work-list' ); ?>
    	</div>
	<?php endwhile; ?>
	</div>
<?php wp_reset_postdata(); ?>	
<?php endif; ?>	
	