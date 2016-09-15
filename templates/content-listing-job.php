<?php 
if( $query->have_posts() ):
	while ( $query->have_posts() ) : $query->the_post(); 
		echo '<li id="job_listing" class="job_listing">';	
		echo Opaljob_Template_Loader::get_template_part('content-work-list'); 
		echo '</li>';
	endwhile;	
endif;
?>