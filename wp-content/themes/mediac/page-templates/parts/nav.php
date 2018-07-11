<nav  data-duration="<?php echo mediac_fnc_theme_options('megamenu-duration',400); ?>" class="hidden-xs hidden-sm opal-megamenu <?php echo mediac_fnc_theme_options('magemenu-animation','slide'); ?> animate navbar navbar-mega">

	    <?php
	        $args = array(  'theme_location' => 'primary',
	                        'container_class' => 'collapse navbar-collapse navbar-mega-collapse nopadding',
	                        'menu_class' => 'nav navbar-nav megamenu',
	                        'fallback_cb' => '',
	                        'menu_id' => 'primary-menu'
                        );
	        if( class_exists("Wpopal_bootstrap_navwalker") ){

	            $args['walker'] = new Wpopal_bootstrap_navwalker();
	        }

	        wp_nav_menu($args);
	    ?>


</nav>