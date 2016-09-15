<?php
$company = new Opaljob_Company();
$job='';?>
<article <?php post_class(); ?>>
	<div class="team-v1">
	    <div class="team-header">
	       <?php fullhouse_fnc_post_thumbnail(); ?>
	    </div>     
	    <div class="team-body">
	        <div class="team-body-content">
	            <h5 class="company-box-title text-uppercase">
		            <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
		        </h5><!-- /.company-box-title -->
	            <h3 class="team-name hide"><?php the_title(); ?></h3>
	            <?php
	            	$job = get_post_meta( get_the_ID(), OPALJOB_COMPANY_PREFIX . 'job', true );
	            ?>
	            <p class="company-job"><?php echo esc_html($job); ?></p>
	        </div>      
	         <div class="company-box-meta">
		        
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
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $instagram ); ?>"> <i  class="fa fa-instagram"></i></a>
					<?php } ?>

					<?php if( $linkedIn && $linkedIn != "#" && !empty($linkedIn) ){  ?>
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $linkedIn ); ?>"> <i  class="fa fa-linkedIn"></i></a>
					<?php } ?>
		                              
		        </div> 

			   
		    </div><!-- /.company-box-content -->                     
	    </div>  
	    <p class="team-info">
	        <?php echo opaljob_fnc_excerpt( 15, "..." ); ?>
	    </p>                                      
	</div>
</article>	