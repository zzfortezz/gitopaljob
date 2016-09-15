<?php 

	$slocation  = isset($_GET['location'])?$_GET['location']:0;  
	$stypes 	= isset($_GET['types'])?$_GET['types']:0;

?>
<form id="opaljob-search-form" class="opaljob-search-form" action="<?php echo opaljob_get_search_link(); ?>" method="get">
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
				
				<div class="col-lg-4 col-md-4 col-sm-4">
					<label><?php _e("Location", 'opaljob'); ?></label>
					<?php Opaljob_Taxonomy_Location::dropdownList( $slocation );?>
				</div>
				
				<div class="col-lg-4 col-md-4 col-sm-4">
					<label><?php _e("Type", 'opaljob'); ?></label>
					<?php  Opaljob_Taxonomy_Type::dropdownList( $stypes ); ?>
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