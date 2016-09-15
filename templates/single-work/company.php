<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;

$contact_id = (int)Opaljob_Query::get_company_by_work($post->ID);

?>
<?php if( $contact_id ): ?> 
<div class="opaljob-box work-company-section">
	<h3><?php _e( 'Company', 'opaljob' ); ?></h3>
	<div class="row">
		<div class="col-lg-12 work-company-info">
			<?php Opaljob_Company::renderBoxInfo( $contact_id  ); ?>
		</div>
	</div>	
</div>
<?php endif; ?>