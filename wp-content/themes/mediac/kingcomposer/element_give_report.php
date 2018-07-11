<?php
$atts = array_merge( array(
		'title'         => '',
		'description'   => '',
		'wrap_class'    => '',
	), $atts); 
extract( $atts );

wp_register_script('jquery.drawDoughnutChart', get_template_directory_uri().'/js/jquery.drawDoughnutChart.js', array( 'jquery' ), '20150315', true);
wp_enqueue_script('jquery.drawDoughnutChart');
$_id = mediac_fnc_makeid();

?>


<div class="kc-give-chart-wrapper <?php echo esc_attr( $wrap_class ); ?>">
<div class="list-label-chart">
  
  <ul class="list-unstyled">
  <?php
  if( isset( $options ) ):
    foreach ( $options as $option ): 
    $value = !empty($option->value) ? $option->value : 50;
    $title = !empty($option->label) ? $option->label : 'Label default';
    $color = !empty($option->value_color)? $option->value_color :'#333333';
  ?>
    <li><span class="text"><?php echo trim($title); ?></span> <span class="number" style="color:<?php echo trim($color); ?>"><?php echo trim($value); ?>%</span></li>
  <?php  
    endforeach;
  endif; 
  ?>
  </ul>
</div>
<div  class="chart-wrapper">
  <div id="kc-give-chart-holder<?php echo esc_attr($_id); ?>" class="chart"></div>
</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($){
	$("#kc-give-chart-holder<?php echo esc_attr($_id); ?>").drawDoughnutChart([
      <?php
      if( isset( $options ) ){
        foreach ( $options as $option ) {
          $value = !empty($option->value) ? $option->value : 50;
          $title = !empty($option->label) ? $option->label : 'Label default';
          if( !empty($option->value_color) ){
            $color = esc_attr($option->value_color);
          }else{
            $color = '#333333';
          }
      ?>
      { title: "<?php echo trim($title); ?>",value: <?php echo trim($value) ?>,   color: "<?php echo trim($color); ?>" },
      <?php
        }
      }
      ?>
  ]);

});
</script>
