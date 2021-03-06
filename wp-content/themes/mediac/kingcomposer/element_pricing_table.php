<?php
// $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
 
extract( $atts );

$class = $featured ? "featured-plan pricing-highlight": '';
$class .= ' ' . $el_class;
?>

<div class="pricing pricing-<?php echo esc_attr($skin); ?> <?php echo esc_attr($class); ?>">
    <div class="pricing-header">
        <div class="pricing-header-inner">
            <h4 class="plan-title">
                <?php echo  esc_html($title); ?>
            </h4>                       
            <div class="plan-price-wrap">
                <div class="plan-price-block">
                    <div class="plan-price">
                        <div class="plan-price-inner">
                            <span class="plan-currency"><?php echo esc_html($currency); ?></span> 
                            <span class="plan-figure"><?php echo esc_html($price); ?></span>
                            <p><?php echo esc_html($period); ?></p>
                        </div>
                    </div>        
                </div>
            </div>  
        </div>    
    </div>
    <div class="pricing-body">
        <div class="plain-info">
           <?php echo do_shortcode(  ($content_html) ); ?>
        </div>
        <?php if( isset($linktitle) && $linktitle ): ?>
            <div class="pricing-footer">
                <a class="btn btn-theme inverse" href="<?php echo esc_html($link); ?>"><?php echo  esc_html($linktitle); ?></a>                        
            </div>
        <?php endif; ?>
    </div>
    
</div>