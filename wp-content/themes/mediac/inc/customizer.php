<?php
 /**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     WpOpal Team <opalwordpress@gmail.com>
 * @copyright  Copyright (C) 2016 http://www.wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */

/**
 * Prestabrain Category Drop Down List Class
 * modified dropdown-pages from wp-includes/class-wp-customize-control.php
 *
 * @since Prestabrain v1.0
 */
if(  class_exists("WP_Customize_Control") ){

    mediac_fnc_includes(  get_template_directory() . '/inc/customizer/*.php' );

}