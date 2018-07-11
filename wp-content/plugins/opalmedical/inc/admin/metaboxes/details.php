<?php
/**
 * Booking Status.
 *
 * This metabox is used to display the medical current status
 * and change it in one click.
 *
 * For more details on how the medical status is changed,
 * @see Awesome_Support_Admin::custom_actions()
 *
 * @since 3.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

global $pagenow, $post;

/* Current status */
//$medical_status = get_post_meta( get_the_ID(), '_wpas_status', true );

/** 
 * Status action link
 * 
 * @var string
 * @see admin/class-opalmedical-admin.php
 */

/**
 * Get available statuses.
 */
$statuses = opalmedical_register_status();

/* Get post status */
$post_status = isset( $post ) ? $post->post_status : '';
$booking_type_object = get_post_type_object( $post->post_type );
?>
<div class="opal-medical-status submitbox">
	<p>
		<strong><?php _e( 'Booking status:', 'opalmedical' ); ?></strong>
		<?php if ( 'post-new.php' != $pagenow ):
			opalmedical_display_status( $post->id );
		?>
		<?php else: ?>
			<span><?php echo _x( 'Creating...', 'Booking creation', 'opalmedical' ); ?></span>
		<?php endif; ?>
	</p>
	
	<label for="opal-post-status"><strong><?php _e( 'Current state:', 'opalmedical' ); ?></strong></label>
	<p>
		<select id="opal-post-status" name="post_status_override" style="width: 100%">
			<?php foreach ( $statuses as $status => $args ):
				$selected = ( $post_status === $status ) ? 'selected="selected"' : '';

				if ( 'auto-draft' === $post_status && 'processing' === $status ) {
					$selected = 'selected="selected"';
				}
			?>
				<option value="<?php echo $status; ?>" <?php echo $selected; ?>><?php echo $args['label']; ?></option>

			<?php endforeach; ?>

		</select>
		<?php if ( isset( $_GET['post'] ) ): ?>
			<input type="hidden" name="opal_post_parent" value="<?php echo $_GET['post']; ?>">
		<?php endif; ?>
	</p>
	
	<div id="major-publishing-actions1">
		<input type="submit" class="button save_order button-primary tips" name="publish" value="<?php printf( __( 'Save %s', 'opalmedical' ), $booking_type_object->labels->singular_name ); ?>" data-tip="<?php printf( __( 'Save/update the %s', 'opalmedical' ), $booking_type_object->labels->singular_name ); ?>" />
		<div class="clear"></div>
	</div>
</div>