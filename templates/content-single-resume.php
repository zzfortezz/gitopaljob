<?php global $work, $post; 
	$work = opaljob_resumes( get_the_ID() );

// 	echo '<Pre>'.print_r( $work ,1 );die; 
	$args = array( 'post_id' => get_the_ID() );
?> 
<article id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/RealjobCompany" <?php post_class(); ?>>
	
	<!-- <header>
		<?php //the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header> -->	
	
	<div class="resume-box">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12"> <?php echo Opaljob_Template_Loader::get_template_part( 'single-resume/box' ); ?> </div>
		</div>
	</div> 	
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
	</div><!-- .entry-content -->
 
	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</article><!-- #post-## -->
<?php do_action( 'opaljob_single_content_resume_after' ); ?>