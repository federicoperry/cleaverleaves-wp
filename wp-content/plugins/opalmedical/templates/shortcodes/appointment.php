<div class="widget widget-medical-appointment-table">
	<div class="widget-content">
		<div class="opalmedical-recent-appointment rows">
			<div class="row">
				<div class="col-lg-12">
					<?php if( isset($layout) ) : ?>
						<?php echo Opalmedical_Template_Loader::get_template_part( 'content-appointment-form-'.$layout,array('title'=>$title,'description'=>$description)); ?>
					<?php else: ?>
						<?php echo Opalmedical_Template_Loader::get_template_part( 'content-appointment-form',array('title'=>$title,'description'=>$description)); ?>	
					<?php endif; ?>
				</div>
			</div>	
		</div>
	</div>	
</div>	
