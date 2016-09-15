<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$work = opaljob_works( get_the_ID() );
global $work, $post;
$meta   = $work->getMetaShortInfo();

?>
<div class="opal-work-list">
	<article itemscope itemtype="http://schema.org/Work" <?php post_class(); ?> ><div class="work-list-style">
		<?php do_action( 'opaljob_before_work_loop_item' ); ?>
		<div class="work-list">
			<div class="work-thumbnail">
		        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		            <?php echo $work->render_company_logo(); ?>
		        </a>
			</div>
			<div class="work-content">
				<?php the_title( '<h4 class="work-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
				
				<div class="work-meta">
					<div class="work-company">
						<?php echo $work->getNameCompany(); ?>
					</div>
					<?php echo $work->renderTypes(); ?>	
				  	<div class="work-date">
				  		<time class="entry-date">
				  			<i class="fa fa-calendar"></i>
							<span><?php  echo get_the_date(); ?></span>
							<span>-<?php  echo $work->getDateExpires(); ?></span>
						</time>
					</div>
					<?php echo $work->render_locations(); ?>
				</div>	

			</div><!-- .entry-content -->
			<?php do_action( 'opaljob_after_work_loop_item' ); ?>
		</div>
		<meta itemprop="url" content="<?php the_permalink(); ?>" />
	</article><!-- #post-## -->
</div>	
