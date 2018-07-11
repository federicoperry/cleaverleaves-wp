<?php
/**
 * Single Event Meta (Venue) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/venue.php
 *
 * @package TribeEventsCalendar
 */

if ( ! tribe_get_venue_id() ) {
	return;
}

$phone   = tribe_get_phone();
$website = tribe_get_venue_website_link();

?>

<div class="tribe-events-meta-group tribe-events-meta-group-venue">
	<h3 class="tribe-events-single-section-title"> <?php echo ( tribe_get_venue_label_singular() ) ?> </h3>
	<ul>
		<?php do_action( 'tribe_events_single_meta_venue_section_start' ) ?>

		<h5 class="tribe-venue"> <?php echo tribe_get_venue() ?> </h5>

		<?php if ( tribe_address_exists() ) : ?>
			<li class="tribe-venue-location">
				<address class="tribe-events-address">
					<?php echo tribe_get_full_address(); ?>

					<?php if ( tribe_show_google_map_link() ) : ?>
						<?php echo tribe_get_map_link_html(); ?>
					<?php endif; ?>
				</address>
			</li>
		<?php endif; ?>

		<?php if ( ! empty( $phone ) ): ?>
			<li>
				<label> <?php esc_html_e( 'Phone:', 'mediac' ) ?> </label>
				<span class="tribe-venue-tel"> <?php echo trim( $phone ); ?> </span>
			</li>
		<?php endif ?>

		<?php if ( ! empty( $website ) ): ?>
			<li>
				<label> <?php esc_html_e( 'Website:', 'mediac' ) ?> </label>
				<span class="url"> <?php echo trim( $website ); ?> </span>
			</li>
		<?php endif ?>

		<?php do_action( 'tribe_events_single_meta_venue_section_end' ) ?>
	</ul>
</div>
