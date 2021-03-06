<?php   global $woocommerce; ?>
<div class="opal-topcart">
 <div id="cart" class="dropdown version-1 box-top">
        <a class="dropdown-toggle mini-cart box-wrap" data-toggle="dropdown" aria-expanded="true" role="button" aria-haspopup="true" data-delay="0" href="#" title="<?php esc_html_e('View your shopping cart', 'mediac'); ?>">
            <span class="cart-icon box-icon">
                <i class="fa fa-shopping-cart"></i>
                <b><?php echo sprintf(_n(' <span class="mini-cart-items"> %d item</span> ', ' <span class="mini-cart-items"> %d item </span> ', $woocommerce->cart->cart_contents_count, 'mediac'), $woocommerce->cart->cart_contents_count);?></b>
            </span>
            <span class="box-title hidden">
                <span class="title-cart">
            	   <?php esc_html_e('SHOPPING BAG','mediac'); ?>
                </span>
            	<strong>
                 <?php echo trim( $woocommerce->cart->get_cart_total() ); ?>
                 </strong>
            </span>

            </a>
        <div class="dropdown-menu"><div class="widget_shopping_cart_content">
            <?php woocommerce_mini_cart(); ?>
        </div></div>
    </div>
</div>
