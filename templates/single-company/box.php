<div class="company-contact ">
	<?php $is_sticky = get_post_meta( get_the_ID(), OPALJOB_COMPANY_PREFIX . 'sticky', true ); ?>
	<div class="company-box  row">
 
		<div class="company-avatar col-lg-3 col-sm-3">
		</div>    

	    <div class="company-box-meta col-lg-6 col-sm-6">

	        <h3 class="company-box-title">
	      		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	        </h3><!-- /.company-box-title -->
	        
	        <?php $email = get_post_meta( get_the_ID(), OPALJOB_COMPANY_PREFIX . 'email', true ); ?>
	        <?php if ( ! empty( $email ) ) : ?>
	            <div class="company-box-email">
		            <a href="mailto:<?php echo esc_attr( $email ); ?>">
	                   <i class="fa fa-envelope"></i> <span><?php echo esc_attr( $email ); ?></span>
		            </a>
	            </div><!-- /.company-box-email -->
	        <?php endif; ?>

	        <?php $phone = get_post_meta( get_the_ID(), OPALJOB_COMPANY_PREFIX . 'phone', true ); ?>
	        <?php if ( ! empty( $phone ) ) : ?>
	            <div class="company-box-phone">
	                <i class="fa fa-phone"></i><span><?php echo esc_attr( $phone ); ?></span>
	            </div><!-- /.company-box-phone -->
	        <?php endif; ?>

		    <?php $web = get_post_meta( get_the_ID(), OPALJOB_COMPANY_PREFIX . 'web', true ); ?>
		    <?php if ( ! empty( $web ) ) : ?>
			    <div class="company-box-web">
				    <a href="<?php echo esc_attr( $web ); ?>">
				        <i class="fa fa-globe"></i> <span><?php echo esc_attr( $web ); ?></span>
				    </a>
			    </div><!-- /.company-box-web -->
		    <?php endif; ?>
		   	
		   	<?php 
					$facebook 	= get_post_meta( get_the_ID(), OPALJOB_COMPANY_PREFIX . 'facebook', true );
					$twitter 	= get_post_meta( get_the_ID(), OPALJOB_COMPANY_PREFIX . 'twitter', true );
					$pinterest  = get_post_meta( get_the_ID(), OPALJOB_COMPANY_PREFIX . 'pinterest', true );
					$google 	= get_post_meta( get_the_ID(), OPALJOB_COMPANY_PREFIX . 'google', true );
					$instagram	= get_post_meta( get_the_ID(), OPALJOB_COMPANY_PREFIX . 'instagram', true );
					$linkedIn = get_post_meta( get_the_ID(), OPALJOB_COMPANY_PREFIX . 'linkedIn', true );
				?>

		        <div class="bo-social-icons">
		        	<?php if( $facebook && $facebook != "#" && !empty($facebook) ){  ?>
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $facebook ); ?>"> <i  class="fa fa-facebook"></i> </a>
						<?php } ?>
					<?php if( $twitter && $twitter != "#" && !empty($twitter) ){  ?>
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $twitter ); ?>"><i  class="fa fa-twitter"></i> </a>
					<?php } ?>
					<?php if( $pinterest && $pinterest != "#" && !empty($pinterest)){  ?>
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $pinterest ); ?>"><i  class="fa fa-pinterest"></i> </a>
					<?php } ?>
					<?php if( $google && $google != "#" && !empty($google) ){  ?>
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $google ); ?>"> <i  class="fa fa-google"></i></a>
					<?php } ?>

					<?php if( $instagram && $instagram != "#" && !empty($instagram) ){  ?>
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $google ); ?>"> <i  class="fa fa-instagram"></i></a>
					<?php } ?>

					<?php if( $linkedIn && $linkedIn != "#" && !empty($linkedIn) ){  ?>
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $linkedIn ); ?>"> <i  class="fa fa-linkedIn"></i></a>
					<?php } ?>
		                              
		        </div> 
	    </div><!-- /.company-box-content -->

	    <div class="company-buttons">
	    	<a href="#add-review" class="btn btn-default"><?php _e( 'Add To Review', 'opaljob' ); ?></a>

	    	<a href="#follow" class="btn btn-primary"> <?php _e( 'Follow', 'opaljob' ); ?> </a>
	    </div>	
   	
	</div><!-- /.company-box-->
</div>	