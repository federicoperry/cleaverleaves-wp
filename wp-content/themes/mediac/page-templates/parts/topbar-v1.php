<div class="topbar-v1" id="opal-topbar">
    <ul class="pull-right hidden-xs hidden-sm">
        <?php if( !is_user_logged_in() ){ ?>
            <?php do_action( 'opal-account-buttons' ); ?>
        <?php }else{ ?>
            <?php $current_user = wp_get_current_user(); ?>
          <li><span class="hidden-xs"><?php esc_html_e('Welcome ','mediac'); ?><?php echo esc_html( $current_user->display_name); ?> !</span></li>
          <li><a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><?php esc_html_e('Logout', 'mediac'); ?></a></li>
        <?php } ?>

    </ul>
    <?php if ( is_active_sidebar( 'custom-service' ) ) : ?>
        <div class="custom-service pull-right hidden-xs hidden-sm">
        <?php dynamic_sidebar('custom-service'); ?>
        </div>
    <?php endif; ?>

</div>