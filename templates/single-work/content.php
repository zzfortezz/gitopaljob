<?php 
global $work;
 ?>
<div class="entry-content">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="work-single-image">
	        <a href="<?php the_permalink(); ?>" class="company-box-image-inner ">
	            <?php the_post_thumbnail( 'thumbnail' ); ?>
	        </a>
		</div>
	<?php  elseif($work->getGallery()) : ?>
		<div class="work-box-image">
	        <a href="<?php the_permalink(); ?>" class="company-box-image-inner ">
	           <img src="<?php echo $work->getGallery(); ?>" />
	        </a>
	    </div>    	
	<?php endif; ?>
	<h3 class="box-heading"><?php _e( 'Work Description', 'opaljob' ); ?></h3>
	<?php
		/* translators: %s: Name of current post */
		the_content( sprintf(
			__( 'Continue reading %s ', 'opaljob' ),
			the_title( '<span class="screen-reader-text">', '</span>', false )
		) );

		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'opaljob' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
		) );
	?>
</div><!-- .entry-content -->