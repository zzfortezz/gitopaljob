<?php 
	
$work = opaljob_works( get_the_ID() );

$company = new Opaljob_Company();

?>
<article id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/RealjobCompany" <?php post_class(); ?>>
	<div class="company-header">
		<div class="company-banner">
			<?php $company->show_company_banner(); ?>
		</div>

		<div class="company-box">
			 <?php echo Opaljob_Template_Loader::get_template_part( 'single-company/box' ); ?>  
		</div> 	
	</div>	


	<div id="company-tabs">	
		<ul class="nav nav-tabs">
			<li class="active"><a  href="#overview" data-toggle="tab"><?php _e( 'Overview', 'opaljob' ) ;?></a></li>
			<li><a href="#review" data-toggle="tab"><?php _e( 'Review', 'opaljob' ) ;?></a></li>
		</ul>

		<div class="tab-content ">
			<div class="tab-pane active" id="overview">
		     		
					<div class="entry-content">
						<?php
							/* translators: %s: Name of current post */
							the_content( sprintf(
								__( 'Continue reading %s', 'prestabase' ),
								the_title( '<span class="screen-reader-text">', '</span>', false )
							) );

							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'prestabase' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
							) );
						?>

						<?php $tags = $company->get_tag_skills(); ?>
						<?php if( $tags ): ?>
						<div class="company-skills">
							
							<?php foreach( $tags as $tag ):   ?>
							<a class="company-skill-item label label-info" href="<?php echo get_term_link( $tag->term_id ); ?>" title="<?php echo esc_attr( $tag->name ); ?>"><?php echo $tag->name; ?></a>

							<?php endforeach; ?>

						</div>	
						<?php endif; ?>
					</div><!-- .entry-content -->

			</div>
			<div class="tab-pane out" id="review">
		      	<?php 
		      		if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				?>
			</div>
		</div>
	</div>	
	<meta itemprop="url" content="<?php the_permalink(); ?>" />
</article><!-- #post-## -->
<?php do_action( 'opaljob_single_content_company_after' ); ?>