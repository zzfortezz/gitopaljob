<?php
$resume = new Opaljob_Resume();
$job='';?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="team-v2">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
				<h5 class="resume-box-title text-uppercase">
		            <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
		        </h5><!-- /.resume-box-title -->
	            <h3 class="team-name hide"><?php the_title(); ?></h3>
	            <p><?php echo $resume->getCategories(); ?></p>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	            <p><?php echo $resume->getSkill().' '.$resume->getYearExperience().' '.__('Year','opaljob'); ?></p>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	            <p><?php echo $resume->getSalary(); ?></p>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
	            <p><?php echo $resume->getLocations(); ?></p>
			</div>
		</div>         
	                                          
	</div>
</article>	