<div id="opal-topbar" class="opal-topbar hidden-xs hidden-sm">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <div class="hidden-xs hidden-sm">
                    <?php if ( is_active_sidebar( 'header-support' ) ) : ?>
                        <div class="header-support">
                        <?php dynamic_sidebar('header-support'); ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">

                <div class="search-cart pull-right">


                    <div class="pull-right">
                        <?php do_action( "mediac_template_header_right" ); ?>
                    </div>
                    <span class="space-lf-10 space-line pull-right"></span>

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

                    <span class="space-lf-10 space-line pull-right"></span>
                </div> <!-- end cart search -->

                <ul class="list-inline pull-right">
                    <?php if( !is_user_logged_in() ){ ?>
                        <?php do_action( 'opal-account-buttons' ); ?>
                    <?php }else{ ?>
                        <?php $current_user = wp_get_current_user(); ?>
                      <li>  <span class="hidden-xs"><?php esc_html_e('Welcome ','mediac'); ?><?php echo esc_html( $current_user->display_name); ?> !</span></li>
                      <li><a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><?php esc_html_e('Logout', 'mediac'); ?></a></li>
                    <?php } ?>

                </ul>

            </div>
        </div>
    </div>
</div>