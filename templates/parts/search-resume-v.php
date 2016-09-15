<?php 
	$fields = Opaljob_Search::getFieldsSetting();
	$slocation  = isset($_GET['location'])?$_GET['location']:0;  
	$stypes 	= isset($_GET['types'])?$_GET['types']:0;
	$sstatus 	= isset($_GET['status'])?$_GET['status']:0;

	$search_min_price = isset($_GET['min_price']) ? $_GET['min_price'] : 0;
	$search_max_price = isset($_GET['max_price']) ? $_GET['max_price'] : 10000000;
?>
<form id="opaljob-search-form-v" class="opaljob-search-form" action="<?php echo opaljob_get_search_link(); ?>" method="get">
	<div class="row">
		<div class="col-md-12"> 
			<ul class="list-inline pull-left">
				<li><i class="fa fa-search"></i></li>
			</ul>
			<?php 
				$statuses = Opaljob_Taxonomy_Status::getList();
 				if( $statuses ): 
			?>
			<ul class="list-inline clearfix list-work-status pull-left">
				<li class="status-item active" data-id="-1">	
					<span><?php _e( 'All', 'opaljob' ); ?></span>
				</li>	
				<?php foreach( $statuses as $status ): ?>

				<li class="status-item" data-id="<?php echo $status->term_id; ?>">
					<span><?php echo $status->name; ?> </span>
				</li>	
				<?php endforeach; ?>
			</ul>	
			<input type="hidden" value="<?php echo $sstatus; ?>" name="status" />
			<?php endif; ?>
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
				<?php Opaljob_Taxonomy_Location::dropdownList( $slocation );?>
			</div>
		</div>
		
		<div class="col-lg-6">
			<div class="form-group">
				<label><?php _e("Type", 'opaljob'); ?></label>
				<?php  Opaljob_Taxonomy_Type::dropdownList( $stypes ); ?>
			</div>
		</div>		
		
		<?php if( $fields ): ?>
			<?php foreach( $fields as $key => $label ):  ?>
			<?php if( $key == "areasize" ) :  continue; ; endif; ?>
			<div class="col-lg-6">
				<div class="form-group">
					<label><?php echo $label; ?></label>
					<?php opaljob_work_render_field_template( $key, __("No . ", 'opaljob' ) . $label ); ?>
				</div>
			</div>
			<?php endforeach; ?>
		<?php endif; ?>
		
		<div class="col-lg-6">
			<div class="form-group">
		 	    <?php 

			 	 	$data = array(
						'id' 	 => 'price',
						'unit'   => '$ ',
						'ranger_min' => 0,
						'ranger_max' => 10000000,
						'input_min'  =>  $search_min_price,
						'input_max'	 => $search_max_price
					);
					opaljob_work_slide_ranger_template( __("Price:",'opaljob'), $data );	
				?>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group">
				<?php echo opaljob_work_areasize_field_template(); ?>
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