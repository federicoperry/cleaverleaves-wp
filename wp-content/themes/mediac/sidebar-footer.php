<?php
/**
 * The Footer Sidebar
 *
 * @package WpOpal
 * @subpackage Mediac
 * @since Mediac 1.0
 */

?>		<?php if ( is_active_sidebar( 'footer-5' ) ) : ?>
		<div class="mass-bottom bgFull">
			<div class="container">				
					<?php dynamic_sidebar('footer-5'); ?>				
			</div>
		</div>
		<?php endif; ?>
		<div class="container">			
			<section class="footer-top">
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
						<div class="wow fadeInUp" data-wow-duration='0.8s' data-wow-delay="200ms" >
							<?php dynamic_sidebar('footer-1'); ?>
						</div>
						<?php endif; ?>
					</div>

					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
						<div class="wow fadeInUp" data-wow-duration='0.8s' data-wow-delay="400ms" >
							<?php dynamic_sidebar('footer-2'); ?>
						</div>
						<?php endif; ?>
					</div>

					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
						<div class="wow fadeInUp" data-wow-duration='0.8s' data-wow-delay="600ms" >
							<?php dynamic_sidebar('footer-3'); ?>
						</div>
						<?php endif; ?>
					</div>

					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
						<div class="wow fadeInUp" data-wow-duration='0.8s' data-wow-delay="800ms" >
							<?php dynamic_sidebar('footer-4'); ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</section>
		</div>
