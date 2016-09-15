<?php $box= new Opaljob_Resume;

 ?>
<div class="work-resume-contact ">
	<?php $is_sticky = get_post_meta( get_the_ID(), OPALJOB_RESUME_PREFIX . 'sticky', true ); ?>
	<div class="resume-box  row">
	    <?php if ( has_post_thumbnail() ) : ?>
			<div class="resume-box-image <?php if ( ! has_post_thumbnail() ) { echo 'without-image'; } ?> col-lg-6  col-sm-6">
		        <a href="<?php the_permalink(); ?>" class="resume-box-image-inner <?php if ( ! empty( $resume ) ) : ?>has-resume<?php endif; ?>">
	                <?php the_post_thumbnail( 'thumbnail' ); ?>
		        </a>
			</div><!-- /.resume-box-image -->
	    <?php endif; ?>

	    <div class="resume-box-meta col-lg-12 col-sm-12">
	        <h3 class="resume-box-title">
	        <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
	        </h3><!-- /.resume-box-title -->
	        
	        <?php $email = get_post_meta( get_the_ID(), OPALJOB_RESUME_PREFIX . 'email', true ); ?>
	        <?php if ( ! empty( $email ) ) : ?>
	            <div class="resume-box-email">
		            <a href="mailto:<?php echo esc_attr( $email ); ?>">
	                   <i class="fa fa-envelope"></i> <span><?php echo esc_attr( $email ); ?></span>
		            </a>
	            </div><!-- /.resume-box-email -->
	        <?php endif; ?>

	        <?php $phone = get_post_meta( get_the_ID(), OPALJOB_RESUME_PREFIX . 'phone', true ); ?>
	        <?php if ( ! empty( $phone ) ) : ?>
	            <div class="resume-box-phone">
	                <i class="fa fa-phone"></i><span><?php echo esc_attr( $phone ); ?></span>
	            </div><!-- /.resume-box-phone -->
	        <?php endif; ?>

		    <?php $language = get_post_meta( get_the_ID(), OPALJOB_RESUME_PREFIX . 'language', true );  ?>
		    <?php if ( ! empty( $language ) ) : ?>
			    <div class="resume-box-language">
				    <a href="<?php echo esc_attr( $language ); ?>">
				        <i class="fa fa-language "></i> <span><?php echo esc_attr( $language  ); ?></span>
				    </a>
			    </div><!-- /.resume-box-language  -->
		    <?php endif; ?>
		   	<?php $salary = get_post_meta( get_the_ID(), OPALJOB_RESUME_PREFIX . 'salary', true );  ?>
		    <?php if ( ! empty( $salary ) ) : ?>
			    <div class="resume-box-salary">
				    <a href="<?php echo esc_attr( $salary ); ?>">
				        <i class="fa fa-money "></i> <span><?php echo esc_attr( $salary  ); ?></span>
				    </a>
			    </div><!-- /.resume-box-language  -->
		    <?php endif; ?>
		    <?php $year_experience = get_post_meta( get_the_ID(), OPALJOB_RESUME_PREFIX . 'year_experience', true );  ?>
		    <?php if ( ! empty( $year_experience ) ) : ?>
			    <div class="resume-box-year_experience">
				    <a href="<?php echo esc_attr( $year_experience ); ?>">
				        <label><?php echo __('Total Year Experience','opaljob').':'; ?></label> <span><?php echo esc_attr( $year_experience  ); ?></span>
				    </a>
			    </div>
		    <?php endif; ?>
		    <?php $hightest_degree = get_post_meta( get_the_ID(), OPALJOB_RESUME_PREFIX . 'hightest_degree', true );  ?>
		    <?php if ( ! empty( $hightest_degree ) ) : ?>
			    <div class="resume-box-hightest_degree">
				    <a href="<?php echo esc_attr( $hightest_degree ); ?>">
				        <label><?php echo __('Highest Degree Level','opaljob').':'; ?></label> <span><?php echo esc_attr( $hightest_degree  ); ?></span>
				    </a>
			    </div>
		    <?php endif; ?>
		    <?php $skill = get_post_meta( get_the_ID(), OPALJOB_RESUME_PREFIX . 'skill', true );  ?>
		    <?php if ( ! empty( $skill ) ) : ?>
			    <div class="resume-box-skill">
				    <a href="<?php echo esc_attr( $skill ); ?>">
				        <label><?php echo __('Expected Job Level','opaljob').':'; ?></label> <span><?php echo esc_attr( $skill  ); ?></span>
				    </a>
			    </div>
		    <?php endif; ?>
		    <?php $resum_attachment = get_post_meta( get_the_ID(), OPALJOB_RESUME_PREFIX . 'resum_attachment', true );  ?>
		    <?php if ( ! empty( $resum_attachment ) ) : ?>
			    <div class="resume-box-resum_attachment">
				    <a href="<?php echo esc_attr( $resum_attachment ); ?>">
				        <i class="fa fa-money "></i> <a href="<?php echo esc_attr( $resum_attachment  ); ?>" rel="external" target="_blank" ><span><?php echo __('Download CV','opaljob') ?></span>
				    </a>
			    </div><!-- /.resume-box-language  -->
		    <?php endif; ?>
		    <?php if(!empty($box->getEducationGroup() )) { ?>
		    <div class="resume-timeline row">
		    	<div class="col-md-3 col-sm-12">
					<h3 class="title-general">
						<span>Education</span>
					</h3>
				</div>
				<div class="col-md-9 col-sm-12">
					<div id="education-timeline" class="timeline-container education">	
					<?php foreach($box->getEducationGroup() as $education) { ?>
						<div class="timeline-wrapper">
							<div class="timeline-time">
								<span><?php echo $education[OPALJOB_RESUME_PREFIX."education_start_end_date"]; ?>	</span>
							</div>
							<div class="timeline-series">
								<?php echo $education[OPALJOB_RESUME_PREFIX."education_school_name"]; ?>-<span><?php echo $education[OPALJOB_RESUME_PREFIX."education_qualification"]; ?>	</span>
							</div>
						</div>
					<?php } ?>
					</div>
				</div>	
		    </div>	
		    <?php } ?>
		    <?php if(!empty($box->getWorkExperience() )) { ?>
		    <div class="resume-timeline row">
		    	<div class="col-md-3 col-sm-12">
					<h3 class="title-general">
						<span>Work Experience</span>
					</h3>
				</div>
				<div class="col-md-9 col-sm-12">
					<div id="experience-timeline" class="timeline-container experience">	
					<?php 
					foreach($box->getWorkExperience() as $experience) { ?>
						<div class="timeline-wrapper">
							<div class="timeline-time">
								<span><?php echo $experience[OPALJOB_RESUME_PREFIX."work_experience_start_end_date"]; ?>	</span>
							</div>
							<div class="timeline-series">
								<?php echo $experience[OPALJOB_RESUME_PREFIX."work_experience_company"]; ?>-<span><?php echo $experience[OPALJOB_RESUME_PREFIX."work_experience_job_title"]; ?>	</span>
							</div>
						</div>
					<?php } ?>
					</div>
				</div>	
		    </div>	
		    <?php } ?>
		    <?php if(!empty($box->getSummaryOfSkills() )) { ?>
		    <div class="resume-timeline row">
		    	<div class="col-md-3 col-sm-12">
					<h3 class="title-general">
						<span>Summary of Skills</span>
					</h3>
				</div>
				<div class="col-md-9 col-sm-12">
					<div id="skill-timeline" class="timeline-container skill">	
					<?php 
					foreach($box->getSummaryOfSkills() as $skill) { ?>
						<div class="timeline-wrapper">
							<div class="timeline-time">
								<span><?php echo $skill[OPALJOB_RESUME_PREFIX."summary_of_skills_name"]; ?>	</span>
							</div>
							<div class="timeline-series">
								<span><?php echo $skill[OPALJOB_RESUME_PREFIX."summary_of_skills_percent"]; ?>	</span>
							</div>
						</div>
					<?php } ?>
					</div>
				</div>	
		    </div>	
		    <?php } ?>
		    <?php $terms = wp_get_post_terms( get_the_ID(), 'work_category');
			$category = '';
			foreach ($terms as $key => $term) {
				$category .= $term->name.' ';
			}  ?>
		    <?php if ( ! empty( $category ) ) : ?>
			    <div class="resume-box-category">
				    <a href="<?php echo esc_attr( $category ); ?>">
				        <i class="fa fa-briefcase "></i> <span><?php echo esc_attr( $category  ); ?></span>
				    </a>
			    </div><!-- /.resume-box-language  -->
		    <?php endif; ?>
		   


	    </div><!-- /.resume-box-content -->

	    <?php if( is_single() && get_post_type() == 'opaljob_resume' ): ?>
		 <?php else : ?>
		    <div class="resume-box-bio">
		    		<?php the_excerpt();?>
		    </div>
		     <p class="resume-box-readmore">
		    	 <a href="<?php the_permalink(); ?>">
		    		<?php _e( 'View Profile', 'opaljob' ); ?>
		    	</a>
		    </p>
		<?php endif; ?>    
	</div><!-- /.resume-box-->
</div>	