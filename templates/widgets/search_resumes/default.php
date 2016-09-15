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



?>

<div class="widget-content">
	<div class="search-works-form">
		<form id="opaljob-search-form-v" class="opaljob-search-form" action="<?php echo opaljob_get_search_resume_link(); ?>" method="get">
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
						<?php echo Opaljob_Query::get_resume_location();?>
					</div>

					<div class="form-group">
						<label><?php _e("Category", 'opaljob'); ?></label>
						<?php  echo  Opaljob_Query::get_resume_location()); ?>
					</div>


					<div class="form-group">
						 <label><?php _e("Total year experience", 'opaljob'); ?></label>
						 <?php echo Opaljob_Query::select_year_experience(); ?>
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

