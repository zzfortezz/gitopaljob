<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
Hi <?php echo $user->first_name . ' ' . $user->last_name; ?>,

Your work have published.

<br>

<?php $permalink = get_permalink( $post->ID ); ?>
<?php if ( ! empty( $permalink ) ) : ?>
    <strong><?php echo __( 'URL', 'opaljob' ); ?>: </strong> <?php echo esc_attr( $permalink ); ?><br>
<?php endif; ?>