<h3><?php echo __('Change Password','opaljob');?> </h3>  
<form class="opaljob-change-password" action="" method="post">    
    <div class="profile-page row">  
        <div class="pass_note"> <?php echo __('*After you change the password you will have to login again.','opaljob')?></div>
        <div id="profile_pass">
        </div> 
        
        <p  class="col-md-4">
            <label for="oldpass"><?php echo __('Old Password','opaljob');?></label>
            <input  id="oldpass" value=""  class="form-control" name="oldpass" type="password">
        </p>
        
        <p  class="col-md-4">
            <label for="newpass"><?php echo __('New Password ','opaljob');?></label>
            <input  id="newpass" value="" class="form-control" name="newpass" type="password">
        </p>
        <p  class="col-md-4">
            <label for="renewpass"><?php echo __('Confirm New Password','opaljob');?></label>
            <input id="renewpass" value=""  class="form-control" name="renewpass"type="password">
        </p>
        <p class="fullp-button">
            <input type="submit" class="wpb_button  wpb_btn-info wpb_btn-large vc_button" id="change_pass" value="<?php echo __('Reset Password','opaljob');?>" />    
        </p>
    </div>
</form>  