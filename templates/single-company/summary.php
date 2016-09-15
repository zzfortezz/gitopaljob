<div class="work-company-contact">

	<div class="col-sm-3">
		<div class="work-company-contact">
			<div class="company-box">
			    <?php if ( has_post_thumbnail() ) : ?>
					<div class="company-box-image <?php if ( ! has_post_thumbnail() ) { echo 'without-image'; } ?>">
				        <a href="<?php the_permalink(); ?>" class="company-box-image-inner <?php if ( ! empty( $company ) ) : ?>has-company<?php endif; ?>">
			                <?php the_post_thumbnail( 'thumbnail' ); ?>
				        </a>
					</div><!-- /.company-box-image -->
			    <?php endif; ?>

			    <div class="company-box-meta">
			        
			        <?php $email = get_post_meta( get_the_ID(), OPALJOB_COMPANY_PREFIX . 'email', true ); ?>
			        <?php if ( ! empty( $email ) ) : ?>
			            <div class="company-box-email">
				            <a href="mailto:<?php echo esc_attr( $email ); ?>">
			                   <i class="fa fa-email"></i> <?php echo esc_attr( $email ); ?>
				            </a>
			            </div><!-- /.company-box-email -->
			        <?php endif; ?>

			        <?php $phone = get_post_meta( get_the_ID(), OPALJOB_COMPANY_PREFIX . 'phone', true ); ?>
			        <?php if ( ! empty( $phone ) ) : ?>
			            <div class="company-box-phone">
			                <?php echo esc_attr( $phone ); ?>
			            </div><!-- /.company-box-phone -->
			        <?php endif; ?>

				    <?php $web = get_post_meta( get_the_ID(), OPALJOB_COMPANY_PREFIX . 'web', true ); ?>
				    <?php if ( ! empty( $web ) ) : ?>
					    <div class="company-box-web">
						    <a href="<?php echo esc_attr( $web ); ?>">
						        <?php echo esc_attr( $web ); ?>
						    </a>
					    </div>
				    <?php endif; ?>
			    </div>
			</div>

		</div>	
	</div>
	<div class="col-sm-9">
		<h3 class="company-box-title">
            <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
        </h3>
        <div class="content">
        	<?php the_content(); ?>
        </div>
	</div>
</div>	