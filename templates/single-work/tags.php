<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $work, $post;

$tags = $work->getTags();

if ( !empty($tags) ) :
?>
<div class="opaljob-box work-tag-section">
	<h3 class="box-heading"><?php _e( 'Tag','opaljob' ); ?></h3>
	<div class="box-content">
		<div id="work-tag">
		<?php foreach ($tags as $tag) : ?>
			<a href="<?php echo esc_url( get_term_link( $tag ) ); ?>" title="<?php echo esc_attr( $tag->name ); ?>">
				<?php echo $tag->name; ?>
			</a>
		<?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>