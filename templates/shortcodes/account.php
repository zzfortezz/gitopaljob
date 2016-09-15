<div class="user-login pull-right">

    <ul class="list-inline">
        <?php  ;
        	 if( !is_user_logged_in() ){ ?>
            <li> <a data-toggle="modal" data-target="#modalRegisterForm" class="btn btn-primary btn-3d radius-6x" href="#" title="<?php _e('Sign up','fullhouse'); ?>"> <?php _e('Sign up', 'fullhouse'); ?> </a></li>
            <li> <a href="#"  data-toggle="modal" data-target="#modalLoginForm" class="pbr-user-login btn btn-white btn-3d radius-6x"><?php _e( 'Sign In','fullhouse' ); ?></a></li>
            
        <?php }else{ 
      
        	$current_user = wp_get_current_user(); 
            if(get_user_role() == 'opaljob_company' || get_user_role() == 'administrator') { ?>
            <div class="dropdown">
			    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><?php echo __('My Profile','opaljob').'('.Opaljob_Apply::countAlertCompany().')';?>
			    <span class="caret"></span></button>
			    <ul class="dropdown-menu">
			      	<li><a href="<?php echo opaljob_submssion_profile_page(); ?>">Company Profile</a></li>
			      	<li><a href="<?php echo opaljob_submssion_page(); ?>">Post Job</a></li>
			      	<li><a href="<?php echo opaljob_submssion_list_page(); ?>">List Job</a></li>
			      	<li><a href="<?php echo opaljob_submssion_job_apply_page(); ?>">Job Apply(<?php echo Opaljob_Apply::countAlertCompany(); ?>)</a></li>				      	
			    	<li><a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a></li>
			    </ul>
			 </div>   
          	<li>  <span class="hidden-xs"><?php echo esc_html__('Welcome ','fullhouse'); ?><?php echo esc_html( $current_user->display_name); ?> !</span></li>

           	<?php } elseif(get_user_role() == 'opaljob_jobseeker') { ?>
    		<div class="dropdown">
			    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><?php echo __('My Profile','opaljob').'('.Opaljob_Apply::countAlertJobseeker().')';?>
			    <span class="caret"></span></button>
			    <ul class="dropdown-menu">
			    	<li><a href="<?php echo opaljob_submssion_profile_page(); ?>">My profile</a></li>
			      	<li><a href="<?php echo opaljob_submssion_resume_page(); ?>">Post Resume</a></li>
			      	<li><a href="<?php echo opaljob_submssion_resume_list_page(); ?>">List Resume</a></li>
			      	<li><a href="<?php echo opaljob_submssion_list_wishlist_page(); ?>">Save job</a></li>
			      	<li><a href="<?php echo opaljob_submssion_job_apply_page(); ?>">Job Apply(<?php echo Opaljob_Apply::countAlertJobseeker(); ?>)</a></li>				      	
			    	<li><a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a></li>
			    </ul>
			 </div>   
          	<li>  <span class="hidden-xs"><?php echo esc_html__('Welcome ','fullhouse'); ?><?php echo esc_html( $current_user->display_name); ?> !</span></li>
    		<?php
    		} 
    	} ?>
    </ul>

</div>   