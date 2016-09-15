<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( ! empty( $name ) ) : ?>
    <strong><?php echo __( 'Name', 'opaljob' ); ?>: </strong> <?php echo esc_attr( $name ); ?><br>
<?php endif; ?>

    <br>

<?php if ( ! empty( $email ) ) : ?>
    <strong><?php echo __( 'E-mail', 'opaljob' ); ?>: </strong> <?php echo esc_attr( $email ); ?><br>
<?php endif; ?>

    <br>

<?php $permalink = get_permalink( $post_id ); ?>
<?php if ( ! empty( $permalink ) ) : ?>
    <strong><?php echo __( 'URL', 'opaljob' ); ?>: </strong> <?php echo esc_attr( $permalink ); ?><br>
<?php endif; ?>

    <br>

<?php if ( ! empty( $message ) ) : ?>
    <?php echo $message; ?>
<?php endif; ?>
