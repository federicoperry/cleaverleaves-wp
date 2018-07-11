<?php
	global $service, $post;
	$pricelists = $service->getMetaboxValue("price_lists_group");
?>
<?php if( $pricelists  ): ?>
<div class="widget widget-prices-list widget-style">
	<h3 class="widget-title"><span><?php _e("Price List", "opalmedical"); ?></span></h3>
	<div class="element-prices-list">
		<div class="prices-list">
			<?php foreach( $pricelists as $pricelist ):  ?>
				<div class="price-item">
					<span class="price-label"><?php echo @$pricelist['opal_service_price_lists_key']; ?></span>
					<span class="price-amount"><?php echo '- '.@$pricelist['opal_service_price_lists_value'] ?></span>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<?php endif; ?>