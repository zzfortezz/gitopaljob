<div class="container-form">
  
    <?php
    $wpcrl_settings = get_option('wpcrl_settings');
    $form_heading = empty($wpcrl_settings['wpcrl_signup_heading']) ? esc_html__('Register','fullhouse') : $wpcrl_settings['wpcrl_signup_heading'];
    // check if the user already login
     ?>
        
    <form class="signup-form" name="wpcrlRegisterForm" id="wpcrlRegisterForm" method="post">
        <h3>Sign Up</h3>

        <div id="wpcrl-reg-loader-info" class="wpcrl-loader">

        </div>
        <div id="wpcrl-register-alert" class="alert alert-danger" role="alert" style="display:none;"></div>
        <div id="wpcrl-mail-alert" class="alert alert-danger" role="alert" style="display:none;"></div>
        <?php   if(isset($token_verification) && $token_verification): ?>
        <div class="alert alert-info" role="alert"><?php esc_html_e('Your account has been activated, you can login now.', 'fullhouse'); ?></div>
        <?php endif; ?>
        <div class="form-group">
            
            <input type="text" class="form-control" name="wpcrl_fname" id="wpcrl_fname" placeholder="First name">
        </div>
        <div class="form-group">
            
            <input type="text" class="form-control" name="wpcrl_lname" id="wpcrl_lname" placeholder="Last name">
        </div>
        <div class="form-group">
            
            <input type="text" class="form-control" name="wpcrl_username" id="wpcrl_username" placeholder="Username">
        </div>
        <div class="form-group">
           
            <input type="text" class="form-control" name="wpcrl_email" id="wpcrl_email" placeholder="Email">
        </div>
        <div class="form-group">
            
            <input type="password" class="form-control" name="wpcrl_password" id="wpcrl_password" placeholder="Password" >
        </div>
        <div class="form-group">
            
            <input type="password" class="form-control" name="wpcrl_password2" id="wpcrl_password2" placeholder="Confirm Password" >
        </div>
        <div class="form-group">
        	<label class="radio-inline"><input type="radio" value="opaljob_company" name="opal_role"><?php echo __('Company','opaljob'); ?></label>
			<label class="radio-inline"><input type="radio" value="opaljob_jobseeker" name="opal_role"><?php echo __('Candidate','opaljob'); ?></label>
		<div>	
        <input type="hidden" name="wpcrl_current_url" id="wpcrl_current_url" value="<?php echo get_permalink(); ?>" />
        <input type="hidden" name="redirection_url" id="redirection_url" value="<?php echo get_permalink(); ?>" />

        <?php
        // this prevent automated script for unwanted spam
        if (function_exists('wp_nonce_field'))
            wp_nonce_field('wpcrl_register_action', 'wpcrl_register_nonce');

        ?>
        <button type="submit" class="btn btn-primary radius-6x">
            <?php
            $submit_button_text = empty($wpcrl_settings['wpcrl_signup_button_text']) ? 'Register' : $wpcrl_settings['wpcrl_signup_button_text'];
            echo trim( $submit_button_text );

            ?></button>
    </form>
</div>