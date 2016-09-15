<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     WpOpal Team <help@wpopal.com, info@wpopal.com>
 * @copyright  Copyright (C) 2015 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo trim($before_widget);
if( $title )
	echo ($before_title)  . trim( $title ) . $after_title;

	$fields = Opaljob_Search::getFieldsSetting();
	$slocation  = isset($_GET['location'])?$_GET['location']:0;  
	$stypes 	= isset($_GET['types'])?$_GET['types']:0;

	$search_min_price = isset($_GET['min_price']) ? $_GET['min_price'] : 0;
	$search_max_price = isset($_GET['max_price']) ? $_GET['max_price'] : 10000000;
?>

<div class="widget-content">
	<div class="search-works-form">
		<form id="opaljob-search-form-v" class="opaljob-search-form" action="<?php echo opaljob_get_search_link(); ?>" method="get">
			<div class="row">
				<div class="col-md-12"> 
					<ul class="list-inline pull-left">
						<li><i class="fa fa-search"></i></li>
					</ul>
				</div>
			</div>	
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">   
						<label><?php _e("Keyword", 'opaljob'); ?></label>
						<input class="form-control" name="search_text">			 
					</div>

					<div class="form-group">
						<label><?php _e("Location", 'opaljob'); ?></label>
						<?php Opaljob_Taxonomy_Location::dropdownList( $slocation );?>
					</div>

					<div class="form-group">
						<label><?php _e("Type", 'opaljob'); ?></label>
						<?php  Opaljob_Taxonomy_Type::dropdownList( $stypes ); ?>
					</div>

					<?php if( $fields ): ?>
						<?php foreach( $fields as $key => $label ):  ?>
						<div class="form-group">
							<label><?php echo $label; ?></label>
							<?php opaljob_work_render_field_template( $key, __("No . ", 'opaljob' ) . $label ); ?>
						</div>
						<?php endforeach; ?>
					<?php endif; ?>

					<div class="form-group">
						 <div class="cost-price-content">
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

					<div class="form-group">
						 <div class="area-range-content">
							<?php echo opaljob_work_areasize_field_template(); ?>
						</div>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-danger btn-lg btn-search btn-block">
							<?php _e('Search'); ?>
						</button>
					</div>

				</div>
				
			</div>	
		</form>
	</div>
</div>

