<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); 


?>

	<section id="main-container" class="site-main container" role="main">
		<main id="primary" class="content content-area">
			<?php if ( have_posts() ) : ?>
				<div class="single-opaljob-container">
					<?php while ( have_posts() ) : the_post(); ?>
					
	                    <?php echo Opaljob_Template_Loader::get_template_part( 'content-single-work' ); ?>
					<?php endwhile; ?>
				</div>
				<?php the_posts_pagination( array(
					'prev_text'          => __( 'Previous page', 'opaljob' ),
					'next_text'          => __( 'Next page', 'opaljob' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'opaljob' ) . ' </span>',
				) ); ?>



				<?php
					/**
					 * opaljob_after_single_work_summary hook
					 *
					 * @hooked opaljob_output_product_data_tabs - 10
					 * @hooked opaljob_upsell_display - 15
					 * @hooked opaljob_output_related_products - 20
					 */
					do_action( 'opaljob_after_single_work_summary' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
										
				?>




			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_footer(); ?>
