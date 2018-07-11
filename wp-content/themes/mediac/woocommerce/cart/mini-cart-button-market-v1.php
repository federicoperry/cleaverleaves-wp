<?php   global $woocommerce; ?>
<div class="opal-topcart">
 <div id="cart" class="dropdown version-1 box-top">
        <span class="cart-icon box-icon">
            <i class="fa fa-shopping-cart"></i>
        </span>
        <a class="dropdown-toggle mini-cart box-wrap" data-toggle="dropdown" aria-expanded="true" role="button" aria-haspopup="true" data-delay="0" href="#" title="<?php esc_html_e('View your shopping cart', 'mediac'); ?>">
            <span class="box-title">
                <span class="title-cart">
            	   <?php esc_html_e('Cart: ','mediac'); ?>
                </span>
                <span class="mini-cart-items">
            	   <?php echo sprintf(_n(' <span class="mini-cart-items"> %d  item</span> ', ' <span class="mini-cart-items"> %d item </span> ', $woocommerce->cart->cart_contents_count, 'mediac'), $woocommerce->cart->cart_contents_count);?>
                </span>
            </span>
            <?php echo trim( $woocommerce->cart->get_cart_total() ); ?>
            </a>
        <div class="dropdown-menu"><div class="widget_shopping_cart_content">
            <?php woocommerce_mini_cart(); ?>
        </div></div>
    </div>
</div>
