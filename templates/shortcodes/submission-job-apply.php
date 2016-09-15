<?php

	if(get_user_role() == 'opaljob_company' || get_user_role() == 'administrator') { 
		echo Opaljob_Template_Loader::get_template_part( 'apply/apply-company-form' , array( 'loop' => $loop ));
	} elseif(get_user_role() == 'opaljob_jobseeker') {
		echo Opaljob_Template_Loader::get_template_part( 'apply/apply-jobseeker-form' , array( 'loop' => $loop ));
	}
?>