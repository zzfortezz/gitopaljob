<?php
$output = sprintf('
	<form name="lostpasswordform" id="lostpasswordform" class="lostpassword-form" action="%s" method="post">
		<p class="lead">%s</p>
		<div class="lostpassword-fields">
		<div id="forgot_pass_area"></div>
		<p class="form-group">
			<label>%s<br />
			
			<input id="forgot_email" type="text" name="forgot_email" class="user_login form-control" value="" size="20" tabindex="10" /></label>
		</p>',
				site_url('wp-login.php?action=lostpassword', 'login_post'),
				esc_html__('Reset Password', 'fullhouse'),
				esc_html__('Username or E-mail:', 'fullhouse')
			);

			ob_start();
			do_action('lostpassword_form');

			wp_nonce_field('ajax-pbr-lostpassword-nonce', 'security');
			$output .= ob_get_clean();

			$output .= sprintf('
		<p class="submit">
			<input id="wp-submit" type="submit" class="btn btn-primary radius-6x" name="wp-submit" value="%s" tabindex="100" />
			<input type="button" class="btn btn-default btn-cancel radius-6x" value="%s" tabindex="101" />
		</p>
		<p class="nav">
			',
				esc_html__('Get New Password', 'fullhouse'),
				esc_html__('Cancel', 'fullhouse')
				 
				
			);
			$output .= '
		</p>
		</div>
			<div class="lostpassword-link"><a href="#pbrloginform" class="toggle-links">'.esc_html__('Back To Login', 'fullhouse').'</a></div>
	</form>';
echo $output;
?>	