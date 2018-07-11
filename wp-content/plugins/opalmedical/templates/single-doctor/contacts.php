<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$email = get_bloginfo( 'admin_email' );

?>

<?php if ( ! empty( $email ) ) : ?>
    <div class="opalmedical-contact-form-container">
        <h3><?php echo __( 'Contact', 'opalmedical' ); ?></h3>

        <div class="box-content opalmedical-contact-forms">
            
            <form method="post" action="" class="opalmedical-contact-form">
                <input type="hidden" name="doctor_id" value="<?php the_ID(); ?>">
                <div class="form-group">
                    <input class="form-control" name="name" type="text" placeholder="<?php echo __( 'Your Name', 'opalmedical' ); ?>" required="required">
                </div><!-- /.form-group -->

                <div class="form-group">
                    <input class="form-control" name="phone" type="text" placeholder="<?php echo __( 'Phone Number', 'opalmedical' ); ?>" required="required">
                </div><!-- /.form-group -->

                <div class="form-group">
                    <input class="form-control" name="email" type="email" placeholder="<?php echo __( 'E-mail', 'opalmedical' ); ?>" required="required">
                </div><!-- /.form-group -->

                <div class="form-group">
                    <textarea class="form-control" name="message" placeholder="<?php echo __( 'Message', 'opalmedical' ); ?>" style="overflow: hidden; word-wrap: break-word; height: 68px;"></textarea>
                </div><!-- /.form-group -->
                
                <button class="button btn btn-primary" type="submit" name="contact-form"><?php echo __( 'Send ', 'opalmedical' ); ?></button>
            </form>
        </div><!-- /.opalmedical-contact-form -->
    </div><!-- /.opalmedical-contact-->
<?php endif; ?>
