<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     WpOpal Team <help@wpopal.com, info@wpopal.com>
 * @copyright  Copyright (C) 2015 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = array(
	'post_type'         => 'opaljob_work',
	'posts_per_page'	=> $num,
 	'meta_key' => 'opaljob_ppt_featured',
	'meta_value' => 'on',
	'meta_compare' => '='
);

$loop = new WP_Query( $args );

if($loop->have_posts()): 

	echo trim($before_widget);

	if( $title )
		echo ($before_title)  . trim( $title ) . $after_title;
?>

<div class="widget-content">
<?php
	while ( $loop->have_posts()): $loop->the_post();
	
	$work = opaljob_works( get_the_ID() );


	$meta   = $work->getMetaShortInfo();

	$query = Opaljob_Query::getWorkQuery();

	?>
	<article itemscope itemtype="http://schema.org/Work" <?php post_class(); ?>>
		<div class="media">
			<div class="media-left">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="work-box-image">
				        <a href="<?php the_permalink(); ?>" class="company-box-image-inner ">
				            <?php the_post_thumbnail( 'medium' ); ?>
				        </a>
					</div>
				<?php endif; ?>	

			</div>

			<div class="media-body">
				<div class="entry-content">
				
					<?php the_title( '<h6 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h6>' ); ?>

					<div class="work-price">
						<span class="text-primary"><?php echo  opaljob_price_format( $work->getPrice() ); ?></span>

						<?php if( $work->getSalePrice() ): ?>
						<span class="work-saleprice">
							<?php echo  opaljob_price_format( $work->getSalePrice() ); ?>
						</span>
						<?php endif; ?>

						<?php if( $work->getPriceLabel() ): ?>
						<span class="work-price-label">
							/ <?php echo $work->getPriceLabel(); ?>
						</span>	
						<?php endif; ?>
					</div>	

				</div><!-- .entry-content -->
			</div> 
		</div>	

	</article><!-- #post-## -->
	<?php  endwhile; ?>
</div>


<?php echo trim($after_widget); ?>

<?php endif; ?>

<?php wp_reset_postdata(); ?>