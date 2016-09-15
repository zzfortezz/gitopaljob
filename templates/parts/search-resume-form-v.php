<?php 



?>
<form id="opaljob-search-form-v" class="opaljob-search-form" action="<?php echo opaljob_get_search_resume_link(); ?>" method="get">
	<div class="row">
		<div class="col-md-12"> 
			<ul class="list-inline pull-left">
				<li><i class="fa fa-search"></i></li>
			</ul>
			
		</div>
	</div>	
	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">   
				<label><?php _e("Keyword", 'opaljob'); ?></label>
				<input class="form-control" name="search_text">			 
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group">
				<label><?php _e("Location", 'opaljob'); ?></label>
				<?php echo Opaljob_Query::get_resume_location();?>
			</div>
		</div>
		
		<div class="col-lg-6">
			<div class="form-group">
				<label><?php _e("Category", 'opaljob'); ?></label>
				<?php  echo Opaljob_Query::get_resume_category(); ?>
			</div>
		</div>	

		<div class="col-lg-6">
			<div class="form-group">
				<label><?php _e("Total year experience", 'opaljob'); ?></label>
				<?php echo Opaljob_Query::select_year_experience(); ?>
			</div>
		</div>	

		<div class="col-lg-12">
			<div class="form-group">
				<button type="submit" class="btn btn-danger btn-lg btn-search btn-block">
					<?php _e('Search'); ?>
				</button>
			</div>
		</div>
		
	</div>	
</form>