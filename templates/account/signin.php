<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="modalLoginForm">
    <div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="inner">
		    		<a href="<?php echo esc_url(get_site_url()); ?>">
						<img class="img-responsive center-image" src="<?php echo get_template_directory_uri().'/images/logo.png'; ?>" alt="" >
					</a>
				   <div id="pbrloginform" class="form-wrapper"> 
				   		<form class="login-form" action="" method="post">			     
					    	<p class="lead"><?php echo esc_html__("Hello, Welcome Back!", 'opaljob'); ?></p>
						    <div class="form-group">
							    <input autocomplete="off" type="text" name="pbr_username"  id="pbr_username"class="required form-control"  placeholder="<?php echo esc_html__("Username",'opaljob'); ?>" />
						    </div>
						    <div class="form-group">
							    <input autocomplete="off" type="password" class="password required form-control" placeholder="<?php echo esc_html__("Password",'opaljob'); ?>" name="pbr_password" id="pbr_password" >
						    </div>
						     <div class="form-group">
						   	 	<label for="pbr-user-remember" ><input type="checkbox" name="remember" id="pbr-user-remember" value="true"><?php echo esc_html__("Remember Me",'opaljob'); ?></label>
						    </div>
						    <div class="form-group">
						    	<input type="submit" class="btn btn-primary radius-6x" name="submit" value="<?php echo esc_html__("Log In",'opaljob'); ?>"/>
						    	<input type="button" class="btn btn-default btn-cancel radius-6x" name="cancel" value="<?php echo esc_html__("Cancel",'opaljob'); ?>"/>
						    </div>

							<p><a href="#pbrlostpasswordform" class="toggle-links" title="'.esc_html__("Forgot Password",'opaljob').'"><?php echo esc_html__("Lost Your Password?",'opaljob'); ?></a></p>	
						</form>
					</div>
					<div id="pbrlostpasswordform" class="form-wrapper">
					<?php echo opaljob_account_reset(); ?>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>
<?php
if (!is_user_logged_in()) :
?>
<div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="modalLoginForm">
    <div class="modal-dialog" role="document">
		<div class="modal-content"><div class="modal-body">
	   		<div id="pbrregisterform" class="form-wrapper">
	   		<?php echo opaljob_account_signup(); ?>
			</div>
		</div>
	</div>
</div>
<?php
endif;	
?>