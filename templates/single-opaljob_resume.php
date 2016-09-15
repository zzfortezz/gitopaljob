<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

get_header(); ?>

	<section id="main-container" class="site-main container" role="main">
		<main id="primary" class="content content-area">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
                    <?php echo Opaljob_Template_Loader::get_template_part( 'content-single-resume' ); ?>
				<?php endwhile; ?>

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
