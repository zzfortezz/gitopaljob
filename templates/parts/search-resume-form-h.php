
<form id="opaljob-search-resume-form" class="opaljob-search-resume-form" action="<?php echo opaljob_get_search_resume_link(); ?>" method="get">
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-3">   
			<h3><?php _e( 'Quick Search', 'opaljob' ); ?></h3>
		</div>
		
	</div>	
	<div class="row">
		<div class="col-lg-10 col-md-10 col-sm-10">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-3">   
					<label><?php _e("Keyword", 'opaljob'); ?></label>
					<input class="form-control" name="search_text"> 
				 
				</div> 
				
				<div class="col-lg-3 col-md-3 col-sm-3">
					<label><?php _e("Location", 'opaljob'); ?></label>
					<?php echo Opaljob_Query::get_resume_location();?>
				</div>
				
				<div class="col-lg-3 col-md-3 col-sm-3">
					<label><?php _e("Catefory", 'opaljob'); ?></label>
					<?php  echo Opaljob_Query::get_resume_category(); ?>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3">
					<label><?php _e("Total year experience", 'opaljob'); ?></label>
					<?php echo Opaljob_Query::select_year_experience(); ?>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-md-2  col-sm-2">
			<button type="submit" class="btn btn-danger btn-lg btn-search">
				<?php _e('Search'); ?>
			</button>
		</div>
	</div>	
</form>