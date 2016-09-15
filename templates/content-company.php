<?php global $work, $post; 
	$work = opaljob_works( get_the_ID() );

// 	echo '<Pre>'.print_r( $work ,1 );die; 
	$args = array( 'post_id' => get_the_ID() );
?> 
<article itemscope itemtype="https://schema.org/RealjobCompany" <?php post_class(); ?>>
	
	<header>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>	
	
	<div class="company-box">
		<div class="row">
			<div class="col-lg-12"> <?php echo Opaljob_Template_Loader::get_template_part( 'single-company/box' ); ?> </div>
		</div>
	</div> 	
	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s', 'opaljob' ),
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
 
	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</article><!-- #post-## -->
<?php do_action( 'opaljob_single_content_company_after' ); ?>