
<article itemscope itemtype="http://schema.org/Work" <?php post_class(); ?>>
	
	<?php do_action( 'opaljob_before_work_loop_item' ); ?>

	<header>
		<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); ?>
	</header>	
	
	<div class="entry-content">

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="work-box-image">
		        <a href="<?php the_permalink(); ?>" class="company-box-image-inner ">
	                <?php the_post_thumbnail( 'thumbnail' ); ?>
		        </a>
			</div>
	    <?php endif; ?>

	</div><!-- .entry-content -->
 
	<?php do_action( 'opaljob_after_work_loop_item' ); ?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</article><!-- #post-## -->
