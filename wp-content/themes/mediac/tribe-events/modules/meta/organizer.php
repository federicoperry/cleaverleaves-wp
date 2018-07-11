<?php
/**
 * Single Event Meta (Organizer) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @package TribeEventsCalendar
 */

$organizer_ids = tribe_get_organizer_ids();
$multiple = count( $organizer_ids ) > 1;

$phone = tribe_get_organizer_phone();
$email = tribe_get_organizer_email();
$website = tribe_get_organizer_website_link();
?>

<div class="tribe-events-meta-group tribe-events-meta-group-organizer">
	<h3 class="tribe-events-single-section-title"><?php echo tribe_get_organizer_label( ! $multiple ); ?></h3>
	<ul>
		<?php
		do_action( 'tribe_events_single_meta_organizer_section_start' );

		foreach ( $organizer_ids as $organizer ) {
			if ( ! $organizer ) {
				continue;
			}

			?>

			<h5 class="tribe-organizer">
				<?php echo tribe_get_organizer_link( $organizer ) ?>
			</h5>
			<?php
		}

		if ( ! $multiple ) { // only show organizer details if there is one
			if ( ! empty( $phone ) ) {
				?>
				<li>
				<label>
					<?php esc_html_e( 'Phone:', 'mediac' ) ?>
				</label>
				<span class="tribe-organizer-tel">
					<?php echo esc_html( $phone ); ?>
				</span>
				</li>
				<?php
			}//end if

			if ( ! empty( $email ) ) {
				?>
				<li>
				<label>
					<?php esc_html_e( 'Email:', 'mediac' ) ?>
				</label>
				<span class="tribe-organizer-email">
					<?php echo esc_html( $email ); ?>
				</span>
				</li>
				<?php
			}//end if

			if ( ! empty( $website ) ) {
				?>
				<li>
				<label>
					<?php esc_html_e( 'Website:', 'mediac' ) ?>
				</label>
				<span class="tribe-organizer-url">
					<?php echo trim( $website ); ?>
				</span>
				</li>
				<?php
			}//end if
		}//end if

		do_action( 'tribe_events_single_meta_organizer_section_end' );
		?>
	</ul>
</div>
