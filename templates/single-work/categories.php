<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $work, $post;

$categories = $work->getCategory();

if ( !empty($categories) ) :
?>
<div class="opaljob-box work-category-section">
	<h3 class="box-heading"><?php _e( 'Category','opaljob' ); ?></h3>
	<div class="box-content">
		<div id="work-category">
		<?php foreach ($categories as $category) : ?>
			<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" title="<?php echo esc_attr( $category->name ); ?>">
				<?php echo $category->name; ?>
			</a>
		<?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>