<?php do_shortcode( '[opaljob_search_works]' ) ;?>

<div id="main-content" class="main-content col-xs-12 col-lg-12 col-md-12">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				if( class_exists("OpalJob_Search") ): 

					$query = OpalJob_Search::getSearchResultsQuery();
				?>
				<div class="opaljob-archive-container">
						<div class="opaljob-archive-top"><div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6">
								 <?php opaljob_show_display_modes(); ?>
							</div>

							<div class="col-lg-6 col-md-6 col-sm-6">
								<div class="opaljob-sortable pull-right">
									<?php echo opaljob_render_sortable_dropdown(); ?>
								</div>	
							</div>
						</div></div>	

						<div class="opaljob-archive-bottom opaljob-rows">
							<?php if( $query->have_posts() ): ?> 
								<div class="row">
									<?php if ( (isset($_COOKIE['opaljob_displaymode']) && $_COOKIE['opaljob_displaymode'] == 'list') || (!isset($_COOKIE['opaljob_displaymode']) && opaljob_options('displaymode', 'grid') == 'list') ):?>
										<?php while ( $query->have_posts() ) : $query->the_post(); ?>
											<div class="col-lg-12 col-md-12 col-sm-12">
						                    	<?php echo Opaljob_Template_Loader::get_template_part( 'content-work-list' ); ?>
						                	</div>
						                <?php endwhile; ?>
									<?php else : ?>
										<?php $cnt = 0; while ( $query->have_posts() ) : $query->the_post(); 
										$cls = '';$column = 4; 
										if( $cnt++%$column==0 ){
											$cls .= ' first-child';
										}

										?>
											<div class="<?php echo $cls; ?>col-lg-4 col-md-4 col-sm-6">
						                    	<?php echo Opaljob_Template_Loader::get_template_part( 'content-work-grid' ); ?>
						                	</div>
										<?php endwhile; ?>
									<?php endif; ?>
								</div>
							<?php else: ?>
								<?php get_template_part( 'content', 'none' ); ?>
							<?php endif; ?>	
						</div>	
					</div>
				<?php endif; 	
			?>	

		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
	
</div><!-- #main-content -->
 
<?php get_sidebar('left'); ?>

<?php