<?php
$current_user = wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;
$first_name             =   get_the_author_meta( 'first_name' , $userID );
$last_name              =   get_the_author_meta( 'last_name' , $userID );
$user_mail              =   get_the_author_meta( 'email' , $userID );
$user_mobile            =   get_the_author_meta( 'mobile' , $userID );
$user_phone             =   get_the_author_meta( 'phone' , $userID );
$description            =   get_the_author_meta( 'description' , $userID );
$facebook               =   get_the_author_meta( 'facebook' , $userID );
$twitter                =   get_the_author_meta( 'twitter' , $userID );
$linkedin               =   get_the_author_meta( 'linkedin' , $userID );
$pinterest              =   get_the_author_meta( 'pinterest' , $userID );
$user_skype             =   get_the_author_meta( 'skype' , $userID );


$user_title             =   get_the_author_meta( 'title' , $userID );
$user_custom_picture    =   get_the_author_meta( 'custom_picture' , $userID );
$user_small_picture     =   get_the_author_meta( 'small_custom_picture' , $userID );
$image_id               =   get_the_author_meta( 'small_custom_picture',$userID); 
$about_me               =   get_the_author_meta( 'description' , $userID );
if($user_custom_picture==''){
    $user_custom_picture=get_template_directory_uri().'/images/default_user.png';
}
?>
<div class="user_profile_div"> 
    <h3><?php echo __('Welcome back, ','opaljob'); echo esc_html($user_login).'!';?></h3>
    <div id="profile_message"></div>    
    <form class="opaljob-my-profile profile-page row" method="post" action =""> 
        <div class="add-estate profile-page row">   
            <div class="profile_div col-md-4" id="profile-div">
                <?php print '<img id="profile-image" src="'.$user_custom_picture.'" alt="user image" data-profileurl="'.$user_custom_picture.'" data-smallprofileurl="'.$image_id.'" >'; ?>
                <div id="upload-container">                 
                    <div id="aaiu-upload-container">                 
              
                        <button id="aaiu-uploader" class="wpb_button  wpb_btn-success wpb_btn-large vc_button"><?php echo __('Upload Profile Image','opaljob');?></button>
                        <div id="aaiu-upload-imagelist">
                            <ul id="aaiu-ul-list" class="aaiu-upload-list"></ul>
                        </div>
                    </div>  
                </div>
                <span class="upload__xplain"><?php echo __('*minimum 500px x 500px','opaljob');?></span>
                <input type="hidden" id="profile_image_url_small" class="form-control" value="<?php echo $image_id;?>"  name="profile_image_url_small">
                <input type="hidden" id="profile_image_url" class="form-control" value="<?php echo $user_custom_picture;?>"  name="profile_image_url">
            </div>
            <div class="col-md-4">
                <p>
                    <label for="firstname"><?php echo __('First Name','opaljob');?></label>
                    <input type="text" id="firstname" class="form-control" value="<?php echo esc_html($first_name);?>"  name="firstname">
                </p>
      
                <p>
                    <label for="secondname"><?php echo __('Last Name','opaljob');?></label>
                    <input type="text" id="secondname" class="form-control" value="<?php echo esc_html($last_name);?>"  name="secondname">
                </p>                
                <p>
                    <label for="useremail"><?php echo __('Email','opaljob');?></label>
                    <input type="text" id="useremail"  class="form-control" value="<?php echo esc_html($user_mail);?>"  name="useremail">
                </p>               
            </div>
            <div class="col-md-4">            
                <p>
                    <label for="userphone"><?php echo __('Phone','opaljob');?></label>
                    <input type="text" id="userphone" class="form-control" value="<?php echo esc_html($user_phone);?>"  name="userphone">
                </p>
                <p>
                    <label for="usermobile"><?php echo __('Mobile','opaljob');?></label>
                    <input type="text" id="usermobile" class="form-control" value="<?php echo esc_html($user_mobile);?>"  name="usermobile">
                </p>
                
                <p>
                    <label for="userskype"><?php echo __('Skype','opaljob');?></label>
                    <input type="text" id="userskype" class="form-control" value="<?php echo esc_html($user_skype);?>"  name="userskype">
                </p>
            </div>
        </div>
   
        <div class="add-estate profile-page row">  
            <div class="col-md-4">
                <p>
                    <label for="userfacebook"><?php echo __('Facebook Url','opaljob');?></label>
                    <input type="text" id="userfacebook" class="form-control" value="<?php echo esc_html($facebook);?>"  name="userfacebook">
                </p>
                
                 <p>
                    <label for="usertwitter"><?php echo __('Twitter Url','opaljob');?></label>
                    <input type="text" id="usertwitter" class="form-control" value="<?php echo esc_html($twitter);?>"  name="usertwitter">
                </p>
                
                 <p>
                    <label for="userlinkedin"><?php echo __('Linkedin Url','opaljob');?></label>
                    <input type="text" id="userlinkedin" class="form-control"  value="<?php echo esc_html($linkedin);?>"  name="userlinkedin">
                </p>
                
                 <p>
                    <label for="userpinterest"><?php echo __('Pinterest Url','opaljob');?></label>
                    <input type="text" id="userpinterest" class="form-control" value="<?php echo esc_html($pinterest);?>"  name="userpinterest">
                </p> 
            </div>
                
            <div class="col-md-8">
                 <p>
                    <label for="usertitle"><?php echo __('Title/Position','opaljob');?></label>
                    <input type="text" id="usertitle" class="form-control" value="<?php echo esc_html($user_title);?>"  name="usertitle">
                </p>
                 <p>
                    <label for="about_me"><?php echo __('About Me','opaljob');?></label>
                    <textarea id="about_me" name="description" class="form-control" name="about_me"><?php echo esc_html($about_me);?></textarea>
                </p>
                
            </div>
            
            <p class="fullp-button">
                <input type="submit"  class="wpb_button  wpb_btn-info wpb_btn-large" id="update_profile" value="<?php echo __('Update profile','opaljob');?>" />
            </p>
            
        </div>
    </form>
      
</div>