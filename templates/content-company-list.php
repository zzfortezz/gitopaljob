<?php
$company = new Opaljob_Company();
$recruier_id = get_post_meta(get_the_ID(),OPALJOB_COMPANY_PREFIX .'company',true);

?>
<a href="<?php echo get_permalink(); ?>" title="<?php  echo get_the_title(); ?>">
	<?php  echo get_the_title().'('.$company->count_work_recuiter_post(get_the_ID()).')'; ?>
</a>

	