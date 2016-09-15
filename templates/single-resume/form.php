?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$email = get_post_meta( $post_id, OPALJOB_COMPANY_PREFIX . 'email', true );
$user_meta_id = get_post_meta( $post_id, OPALJOB_COMPANY_PREFIX . 'user_meta_id', true );
$current_user = wp_get_current_user();
?>


<?php if ( ! empty( $email ) ) : ?>
    <div class="company-contact-form-container">
        <button class="btn btn-info " data-target="#apply-now" data-toggle="modal" type="button">
            <h3><?php echo __( 'Apply Now', 'opaljob' ); ?></h3>
        </button>
        <div class="modal fade" id="apply-now" role="dialog"> 
            <div class="modal-dialog">   
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">
                            <?php echo __('You are applying for work','opaljob').' '.get_the_title(); ?>
                        </h4>
                    </div>
                    <div class="modal-body">   
                        <div class="box-content company-contact-form">              
                            <form method="post" action="" class="opaljob-contact-form">
                                <input type="hidden" name="post_id" value="<?php the_ID(); ?>">
                                <input type="hidden" name="company_id" value="<?php echo $post_id; ?>">
                                <input type="hidden" name="user_meta_id" value="<?php echo $user_meta_id; ?>">
                                <input type="hidden" name="work_title" value="<?php echo get_the_title(); ?>">
                                <div class="form-group">
                                    <input class="form-control" name="name" value="<?php echo $current_user->user_firstname.' '.$current_user->user_lastname; ?>" type="text" placeholder="<?php echo __( 'Name', 'opaljob' ); ?>" required="required">
                                </div><!-- /.form-group -->

                                <div class="form-group">
                                    <input class="form-control" name="email" value="<?php echo $current_user->user_email; ?>" type="email" placeholder="<?php echo __( 'E-mail', 'opaljob' ); ?>" required="required">
                                </div><!-- /.form-group -->

                                <div class="form-group">
                                    <?php if(empty(Opaljob_Query::select_resume_by_user())) { ?>
                                    <label>
                                        <a href="<?php echo opaljob_submssion_resume_page(); ?>" >
                                        <?php echo __('Please create resume','opaljob'); ?>
                                        </a>
                                    </label>
                                    <?php } else { ?>
                                    <label><?php echo __('Select resume','opaljob') ?></label>
                                    <?php echo Opaljob_Query::select_resume_by_user(); ?>
                                    <?php } ?>
                                </div><!-- /.form-group -->

                                <div class="form-group">
                                    <textarea class="form-control" name="message" placeholder="<?php echo __( 'Message', 'opaljob' ); ?>" style="overflow: hidden; word-wrap: break-word; height: 68px;" required="required"></textarea>
                                </div><!-- /.form-group -->
                                
                                <button class="button btn btn-primary btn-3d" type="submit" name="contact-form"><?php echo __( 'Send message', 'opaljob' ); ?></button>
                            </form>
                        </div><!-- /.company-contact-form -->
                    </div>    
                </div>    
            </div>        
        </div>    
    </div><!-- /.company-contact-->
<?php endif; ?>
