<?php 
$query = Opaljob_Query::getCompanyQuery();
$args = array();
if( $query->have_posts() ):
	while ( $query->have_posts() ) : $query->the_post(); 
		$args[] = substr(get_the_title(), 0, 1);
	endwhile;	
endif;
$args = array_unique($args);
sort($args );
?>
<div class="container">
	<div class="row">
		<div class="opaljob-conpany-jobs" data-paginate="loadmore">
			<h3 class="widget-title widget-title--home"><?php echo __('Company','opaljob'); ?></h3>
			<div class="company-letters">
				<?php foreach ($args as $key => $arg) {
					echo '<a href="#'.$arg.'">'.$arg.'</a>';
				}	?>
			</div>
			<ul class="company_listings">
				<?php 
				if( $query->have_posts() ):
					foreach ($args as $key => $arg) {
					echo '<div id="'.$arg.'" class="company-letter">'.$arg.'</div>';
					echo '<li id="company_listing" class="company_listing">';	
					while ( $query->have_posts() ) : $query->the_post(); 
						if($arg == substr(get_the_title(), 0, 1)) { 
							echo '<ul>
								<li class="company-name">'.Opaljob_Template_Loader::get_template_part('content-company-list').'</li>
							</ul>';
						}						
					endwhile;
					echo '</li>';
					}	
				endif;
				?>
			</ul>		
		</div>
	</div>
</div>			