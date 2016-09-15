<?php 
$query = Opaljob_Query::getWorkQuery();
$types =Opaljob_Taxonomy_Type::getList();

?>
<div class="container">
	<div class="row">
		<div class="opaljob-recent-jobs" data-paginate="loadmore">
			<h3 class="widget-title widget-title--home"><?php echo __('Recents Job','opaljob'); ?></h3>
			<form class="opaljob_filters" action="" method="post">
				<div class="opaljob_search">
					<input name="search_keywords" id="search_keywords" placeholder="Keywords" value="" type="text">		
					<input name="loadmore" id="loadmore" type="hidden" value="0" />
				</div>
				<ul class="opaljob_types">
				<?php foreach ($types as $key => $type) { ?>
					<li class="radio">
						<input class="form-control" type="radio" value="<?php echo $type->slug; ?>" name="filter_job_type">
						<i></i>
						<?php echo $type->name; ?>
					</li>
				<?php }	?>
				</ul>
			</form>	
			<ul class="job_listings">
				<?php 
				if( $query->have_posts() ):
					while ( $query->have_posts() ) : $query->the_post(); 
						echo '<li id="job_listing" class="job_listing">';	
						echo Opaljob_Template_Loader::get_template_part('content-work-list'); 
						echo '</li>';
					endwhile;	
				endif;
				?>
			</ul>		
			<a href="#" class="btn btn-default btn-block btn-loadmore load_more_jobs" title="Load More">Load More</a>
		</div>
	</div>
</div>			