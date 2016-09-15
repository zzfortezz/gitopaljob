
	<div class="opaljob-ajax-result"></div>
	<a class="opaljob-wishlist <?php echo ( opaljob_is_job_saved(0, get_the_ID()) ? 'saved' : '' ); ?> pull-right" href="javascript:void(0);" data-toggle="tooltip" data-job-id="<?php echo esc_attr(get_the_ID()); ?>" data-action="ajax_saves_job" data-security="<?php echo wp_create_nonce( 'opaljob-saves-job' );?>" title="<?php _e('Bookmark Job', 'opaljob'); ?>"><i class="fa fa-heart"></i></a>
