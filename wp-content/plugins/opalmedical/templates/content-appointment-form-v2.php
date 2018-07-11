<div class="appointment-form appointment-form-v2 white-popup">
<div class='appointment-message'></div>
<div class='modal'></div> 
    <div class="">
    <?php if(isset($title) && trim($title)!=''): ?>
      <div class="appointment-title">
        <h3><?php echo __($title); ?></h3>
      </div>
    <?php else: ?>
      <div class="appointment-title">
        <h3><?php echo __('Make An Appointment');?></h3>
      </div>
    <?php endif; ?>
    <?php if(isset($description) && trim($description)!=''): ?>
      <div class="appointment-description">
        <p><?php echo __($description); ?></p>
      </div>
    <?php endif; ?>

    </div> <!--/.col-lg-4 (1) -->
     
     <form class="form-horizontal appointment_post_form_v2" name="appointment_post_form" method="post">
        <?php do_action( 'opalmedical_before_appointment_form' ); ?>
        <div class="clear">
          <div class="row">
            <div class="col-md-12"><input type="text" class="form-control" name="appointment_name" placeholder="Your Name" required ></div>
            <div class="col-md-12"><input type="text" class="form-control" name="appointment_phone" placeholder="Phone Number " required></div>            
          </div>
        </div> <!-- /.col-lg-6 (3.1) -->
        <div class="clear">
          <div class="row">
            <div class="col-md-12">
              <input type="email" class="form-control" name="appointment_mail" placeholder="Email" required >  
            </div>
          </div>        
        </div>
        <div class="fleft">
          <div class="row">
            <div class="col-md-6"><input class="form-control appointment_date" name="appointment_date" type="text" placeholder="_/_/_ " required ></div>
            <div class="col-md-6"><input class="form-control appointment_time" name="appointment_time" type="text" placeholder="00:00 " required ></div>
          </div>                   
        </div> <!-- /.col-lg-6 (3.2) -->
        <?php 
        $topics = opalmedical_get_option("topic_lists_group");
        if($topics): ?>
        <div class="clear">          
          <select class="form-control appointment_topic" name="appointment_topic">
            <?php foreach( $topics as $topic ):  ?>
              <option value="<?php echo $topic['topic_lists_key']; ?>"><?php echo $topic['topic_lists_key']; ?></option>
            <?php endforeach; ?>
          </select>           
        </div>
      <?php endif ?>    

          <div class="ftextarea clear">
                <textarea class="form-control"  rows="3" name="appointment_message" placeholder="Message" ></textarea>
          </div> <!-- /.col-lg-6 (4.1) -->
          <div class="clear">
            <button type="submit" class="btn"><?php echo __('SEND');?></button>
            <?php do_action( 'opalrestaurant_after_appointment_form' ); ?>
            <input type="hidden" name="action" class="appointment_action" value="appointment_post" />
            <?php wp_nonce_field( 'appointment_post','appointment_post_field' ); ?>
          </div> <!-- /.col-lg-6 (4.2) -->

      </form>  
</div> <!--/.appointment-form (0) -->