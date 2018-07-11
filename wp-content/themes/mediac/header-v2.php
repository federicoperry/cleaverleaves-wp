<?php
/**
 * The Header for our theme: Main Darker Background. Logo left + Main menu and Right sidebar. Below Category Search + Mini Shopping basket.
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WpOpal
 * @subpackage Mediac
 * @since Mediac 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site"><div class="opal-page-inner row-offcanvas row-offcanvas-left">
	<?php if ( get_header_image() ) : ?>
	<div id="site-header" class="hidden-xs hidden-sm">
		<a href="<?php echo esc_url( get_option('header_image_link','#') ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
		</a>
	</div>
	<?php endif; ?>
	<?php get_template_part( 'page-templates/parts/topbar', 'mobile' ); ?>
	<header id="opal-masthead" class="site-header header-v2">
		<div class="header-main">
			<div class="container">
				<div class="row">
					<div class="logo-wrapper col-md-3">
			 			<?php get_template_part( 'page-templates/parts/logo' ); ?>
					</div>
					<div class="opal-header-right  col-md-9">
						<div class="hidden-xs hidden-sm hidden-md pull-right">
							<!-- make an appoitment button -->
							<a class="btn btn-appointment" href="<?php echo esc_js( admin_url('admin-ajax.php') ); ?>?action=appointment_form"><?php esc_html_e( ' Make an appointment', 'mediac' ) ?></a>
						</div>
						<?php get_template_part( 'page-templates/parts/topbar-v1'); ?>
					</div>
				</div>
			</div>
		</div>
		<section id="opal-mainmenu" class="opal-mainmenu">
			<div class="container">
				<div class="pull-left"><?php get_template_part( 'page-templates/parts/nav' ); ?></div>

				<div class="search-cart pull-right hidden-xs hidden-sm">
			        <div class="pull-right">
			            <?php do_action( "mediac_template_header_right" ); ?>
			        </div>

			        <div id="search-container" class="search-box-wrapper pull-right">
			            <div class="opal-dropdow-search dropdown">
			                <a data-target=".bs-search-modal-lg" data-toggle="modal" class="search-focus dropdown-toggle dropdown-toggle-overlay">
			                    <i class="fa fa-search"></i>
			                </a>
			                <div class="modal fade bs-search-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
			                  <div class="modal-dialog modal-lg">
			                    <div class="modal-content">
			                        <div class="modal-header">
			                          <button aria-label="Close" data-dismiss="modal" class="close btn btn-sm btn-primary pull-right" type="button"><span aria-hidden="true">x</span></button>
			                          <h4 id="gridSystemModalLabel" class="modal-title"><?php esc_html_e( 'Search', 'mediac' ); ?></h4>
			                        </div>
			                        <div class="modal-body">
			                          <?php get_template_part( 'page-templates/parts/search-overlay' ); ?>
			                        </div>
			                    </div>
			                  </div>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
		</section>
	</header><!-- #masthead -->

	<?php do_action( 'mediac_template_header_after' ); ?>

	<section id="main" class="site-main">
