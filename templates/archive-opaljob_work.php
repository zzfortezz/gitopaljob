<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); ?>
	<section id="main-container" class="site-main container" role="main">
		
		<?php //do_shortcode( '[opaljob_search_works]' ) ;?>

		<main id="primary" class="content content-area">
			<?php if ( have_posts() ) : ?>
				<header class="page-header">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header><!-- .page-header -->

				<div class="opaleslate-archive-container">
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
						<div class="row">
							<?php if ( (isset($_COOKIE['opaljob_displaymode']) && $_COOKIE['opaljob_displaymode'] == 'list') || (!isset($_COOKIE['opaljob_displaymode']) && opaljob_options('displaymode', 'grid') == 'list') ):?>
								<?php while ( have_posts() ) : the_post(); ?>
									<div class="col-lg-12 col-md-12 col-sm-12">
				                    	<?php echo Opaljob_Template_Loader::get_template_part( 'content-work-list' ); ?>
				                	</div>
				                <?php endwhile; ?>
							<?php else : ?>
								<?php 
								$column = 4; 
								$cnt = 0;
								while ( have_posts() ) : the_post(); 
								$cls = '';
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
					</div>	

				</div>
				<?php the_posts_pagination( array(
					'prev_text'          => __( 'Previous page', 'opaljob' ),
					'next_text'          => __( 'Next page', 'opaljob' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'opaljob' ) . ' </span>',
				) ); ?>
				
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->


<?php get_footer(); ?>
