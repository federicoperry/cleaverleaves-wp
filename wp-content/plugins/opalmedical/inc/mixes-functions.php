<?php
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opalmedical
 * @author     Opal  Team <opalwordpressl@gmail.com >
 * @copyright  Copyright (C) 2016 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */
 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function opalmedical_get_departments(){
    
    $query = Opalmedical_Query::get_departments_query();

    $output = array();

    while( $query->have_posts() ){ $query->the_post();
        $output[get_the_ID()] = get_the_title(); 
    }
    
    wp_reset_postdata();

    return $output;
}
/**
 * batch including all files in a path.
 *
 * @param String $path : PATH_DIR/*.php or PATH_DIR with $ifiles not empty
 */
function opalmedical_includes( $path, $ifiles=array() ){

    if( !empty($ifiles) ){
         foreach( $ifiles as $key => $file ){
            $file  = $path.'/'.$file; 
            if(is_file($file)){
                require($file);
            }
         }   
    }else {
        $files = glob($path);
        foreach ($files as $key => $file) {
            if(is_file($file)){
                require($file);
            }
        }
    }
}

/**
* Get data from config files
*
* @param $name
*
* @return mixed
*/
function get_config($name) {
    if (!empty($name)) {
        return require(OPALMEDICAL_LANGUAGE_DIR . "{$name}.php");
    }
}

/**
 *
 */
function opalmedical_menu( $id ){
    global $menu; 

    $menu = new Opalmedical_Menu( $id );

    return $menu; 
}

/**
 *
 */
function opalmedical_doctor( $id ){
    global $doctor; 

    $doctor = new Opalmedical_Doctor( $id );

    return $doctor; 
}

function opalmedical_options( $key, $default = '' ){
    
    global $opalmedical_options; 
    
    $value =  isset($opalmedical_options[ $key ]) ? $opalmedical_options[ $key ] : $default;
    $value = apply_filters( 'opalmedical_option_', $value, $key, $default );
  
    return apply_filters( 'opalmedical_option_' . $key, $value, $key, $default );
}

/**
 * @return integer
 */
function convert_integer( $key, $default = '' ){
    $convert = $key ? $key : $default;
    return (int)$convert;
}

/**
 * @return string boolean
 */
function convert_boolean( $key ){
    if($key == "1"){
       return "true";
    }
    return "false";
}

/**
 *
 */
function opalmedical_register_status() {
    $status = array(
        'opal-closed' => array(
            'label'                     => _x( 'Closed', 'Order status', 'opalmedical' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop( 'Closed <span class="count">(%s)</span>', 'Closed <span class="count">(%s)</span>', 'opalmedical' ),
            'default_bg_color'          => '#dd3333',
            'default_text_color'        => '#fff',
        ),
        'opal-pending' => array(
            'label'                     => _x( 'Pending', 'Order status', 'opalmedical' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop( 'Pending <span class="count">(%s)</span>', 'Pending <span class="count">(%s)</span>', 'opalmedical' ),
            'default_bg_color'          => '#1e73be',
            'default_text_color'        => '#fff',
        ),
        'opal-confirmed' => array(
            'label'                     => _x( 'Confirmed', 'Order status', 'opalmedical' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop( 'Confirmed <span class="count">(%s)</span>', 'Confirmed <span class="count">(%s)</span>', 'opalmedical' ),
            'default_bg_color'          => '#a01497',
            'default_text_color'        => '#fff',
        ),
    );
    return apply_filters( 'opalmedical_register_status', $status );
}
/**
 *
 */
function opalmedical_get_status_label( $status) {
    $label = $status;
    $statuses = opalmedical_register_status();
    if ( isset($statuses[$status]) ) {
        $label = $statuses[$status]['label'];
    }
    return apply_filters( 'opalmedical_get_status_label', $label );
}
/**
 *
 */
function opalmedical_display_status( $post_id ) {
    global $opalmedical_options;

    $post = get_post( $post_id );
    $status = isset( $post ) ? $post->post_status : '';

    $label = opalmedical_get_status_label( $status );

    $style = '';
    if ( isset( $opalmedical_options[ $status.'_bg_color' ] ) && $opalmedical_options[ $status.'_bg_color' ] ) {
        $style = 'background-color: '.$opalmedical_options[ $status.'_bg_color' ].';';
    }

    if ( isset( $opalmedical_options[ $status.'_text_color' ] ) && $opalmedical_options[ $status.'_text_color' ] ) {
        $style .= 'color: '.$opalmedical_options[ $status.'_text_color' ].';';
    }

    if ( !empty($style) ) {
        $style = ' style="'.$style.'"';
    }

    echo apply_filters( 'opalmedical_display_status', '<span class="opal-label"'.$style.'>'.$label.'</span>', $status, $post );
}


/**
 *
 */
function opalmedical_get_currencies() {
    $currencies = array(
        'USD'  => __( 'US Dollars (&#36;)', 'give' ),
        'EUR'  => __( 'Euros (&euro;)', 'give' ),
        'GBP'  => __( 'Pounds Sterling (&pound;)', 'give' ),
        'AUD'  => __( 'Australian Dollars (&#36;)', 'give' ),
        'BRL'  => __( 'Brazilian Real (R&#36;)', 'give' ),
        'CAD'  => __( 'Canadian Dollars (&#36;)', 'give' ),
        'CZK'  => __( 'Czech Koruna', 'give' ),
        'DKK'  => __( 'Danish Krone', 'give' ),
        'HKD'  => __( 'Hong Kong Dollar (&#36;)', 'give' ),
        'HUF'  => __( 'Hungarian Forint', 'give' ),
        'ILS'  => __( 'Israeli Shekel (&#8362;)', 'give' ),
        'JPY'  => __( 'Japanese Yen (&yen;)', 'give' ),
        'MYR'  => __( 'Malaysian Ringgits', 'give' ),
        'MXN'  => __( 'Mexican Peso (&#36;)', 'give' ),
        'NZD'  => __( 'New Zealand Dollar (&#36;)', 'give' ),
        'NOK'  => __( 'Norwegian Krone (Kr.)', 'give' ),
        'PHP'  => __( 'Philippine Pesos', 'give' ),
        'PLN'  => __( 'Polish Zloty', 'give' ),
        'SGD'  => __( 'Singapore Dollar (&#36;)', 'give' ),
        'SEK'  => __( 'Swedish Krona', 'give' ),
        'CHF'  => __( 'Swiss Franc', 'give' ),
        'TWD'  => __( 'Taiwan New Dollars', 'give' ),
        'THB'  => __( 'Thai Baht (&#3647;)', 'give' ),
        'INR'  => __( 'Indian Rupee (&#8377;)', 'give' ),
        'TRY'  => __( 'Turkish Lira (&#8378;)', 'give' ),
        'RIAL' => __( 'Iranian Rial (&#65020;)', 'give' ),
        'RUB'  => __( 'Russian Rubles', 'give' )
    );

    return apply_filters( 'opalmedical_currencies', $currencies );
}

 /**
 * Get the price format depending on the currency position
 *
 * @return string
 */
function opalmedical_price_format_position() {
    global $opalmedical_options;
    $currency_pos = opalmedical_options('currency_position','before');

    $format = '%1$s%2$s';
    switch ( $currency_pos ) {
        case 'before' :
            $format = '%1$s%2$s';
        break;
        case 'after' :
            $format = '%2$s%1$s';
        break;
        case 'left_space' :
            $format = '%1$s&nbsp;%2$s';
        break;
        case 'right_space' :
            $format = '%2$s&nbsp;%1$s';
        break;
    }

    return apply_filters( 'opalmedical_price_format_position', $format, $currency_pos );
}

/**
 *
 */
function opalmedical_price_format( $price, $args=array() ){

    $price = opalmedical_price( $price , $args );
    $price = sprintf( opalmedical_price_format_position(), opalmedical_currency_symbol(), $price );
 
    return apply_filters( 'opalmedical_price_format', $price ); 
}

function opalmedical_get_currency( ){
    return opalmedical_options( 'currency', 'USD' );
}

/**
 *
 */
function opalmedical_currency_symbol( $currency = '' ) {
    if ( ! $currency ) {
        $currency = opalmedical_get_currency();
    }

    switch ( $currency ) {
        case 'AED' :
            $currency_symbol = 'د.إ';
            break;
        case 'BDT':
            $currency_symbol = '&#2547;&nbsp;';
            break;
        case 'BRL' :
            $currency_symbol = '&#82;&#36;';
            break;
        case 'BGN' :
            $currency_symbol = '&#1083;&#1074;.';
            break;
        case 'AUD' :
        case 'CAD' :
        case 'CLP' :
        case 'COP' :
        case 'MXN' :
        case 'NZD' :
        case 'HKD' :
        case 'SGD' :
        case 'USD' :
            $currency_symbol = '&#36;';
            break;
        case 'EUR' :
            $currency_symbol = '&euro;';
            break;
        case 'CNY' :
        case 'RMB' :
        case 'JPY' :
            $currency_symbol = '&yen;';
            break;
        case 'RUB' :
            $currency_symbol = '&#1088;&#1091;&#1073;.';
            break;
        case 'KRW' : $currency_symbol = '&#8361;'; break;
            case 'PYG' : $currency_symbol = '&#8370;'; break;
        case 'TRY' : $currency_symbol = '&#8378;'; break;
        case 'NOK' : $currency_symbol = '&#107;&#114;'; break;
        case 'ZAR' : $currency_symbol = '&#82;'; break;
        case 'CZK' : $currency_symbol = '&#75;&#269;'; break;
        case 'MYR' : $currency_symbol = '&#82;&#77;'; break;
        case 'DKK' : $currency_symbol = 'kr.'; break;
        case 'HUF' : $currency_symbol = '&#70;&#116;'; break;
        case 'IDR' : $currency_symbol = 'Rp'; break;
        case 'INR' : $currency_symbol = 'Rs.'; break;
        case 'NPR' : $currency_symbol = 'Rs.'; break;
        case 'ISK' : $currency_symbol = 'Kr.'; break;
        case 'ILS' : $currency_symbol = '&#8362;'; break;
        case 'PHP' : $currency_symbol = '&#8369;'; break;
        case 'PLN' : $currency_symbol = '&#122;&#322;'; break;
        case 'SEK' : $currency_symbol = '&#107;&#114;'; break;
        case 'CHF' : $currency_symbol = '&#67;&#72;&#70;'; break;
        case 'TWD' : $currency_symbol = '&#78;&#84;&#36;'; break;
        case 'THB' : $currency_symbol = '&#3647;'; break;
        case 'GBP' : $currency_symbol = '&pound;'; break;
        case 'RON' : $currency_symbol = 'lei'; break;
        case 'VND' : $currency_symbol = '&#8363;'; break;
        case 'NGN' : $currency_symbol = '&#8358;'; break;
        case 'HRK' : $currency_symbol = 'Kn'; break;
        case 'EGP' : $currency_symbol = 'EGP'; break;
        case 'DOP' : $currency_symbol = 'RD&#36;'; break;
        case 'KIP' : $currency_symbol = '&#8365;'; break;
        default    : $currency_symbol = ''; break;
    }

    return apply_filters( 'opalmedical_currency_symbol', $currency_symbol, $currency );
} 

/**
 * Return the thousand separator for prices
 * @since  2.3
 * @return string
 */
function opalmedical_get_price_thousand_separator() {
    $separator = stripslashes( opalmedical_options( 'thousands_separator' ) );
    return $separator;
}

/**
 * Return the decimal separator for prices
 * @since  2.3
 * @return string
 */
function opalmedical_get_price_decimal_separator() {
    $separator = stripslashes( opalmedical_options( 'decimal_separator' ,'.') );
    return $separator ? $separator : '.';
}

/**
 * Return the number of decimals after the decimal point.
 * @since  2.3
 * @return int
 */
function opalmedical_get_price_decimals() {
    return absint( opalmedical_options( 'price_num_decimals', 2 ) );
}


/**
 *
 */    
function opalmedical_price( $price, $args=array() ){

    $negative = $price < 0;

    if( $negative ) {
        $price = substr( $price, 1 );  
    }
    

    extract( apply_filters( 'opalmedical_price_args', wp_parse_args( $args, array(
        'ex_tax_label'       => false,
        'decimal_separator'  => opalmedical_get_price_decimal_separator(),
        'thousand_separator' => opalmedical_get_price_thousand_separator(),
        'decimals'           => opalmedical_get_price_decimals(),
 
    ) ) ) );

    $negative        = $price < 0;
    $price           = apply_filters( 'opalmedical_raw_price', floatval( $negative ? $price * -1 : $price ) );
    $price           = apply_filters( 'opalmedical_formatted_price', number_format( $price, $decimals, $decimal_separator, $thousand_separator ), $price, $decimals, $decimal_separator, $thousand_separator );

    return round($price);     
}

/**
 *
 *  Applyer function to show unit for menu
 */

function opalmedical_areasize_unit_format( $value='' ){
    return  $value . ' ' . '<span>'.'m2'.'</span>';
}

add_filter( 'opalmedical_areasize_unit_format', 'opalmedical_areasize_unit_format' );

/**
 *
 *  Applyer function to show unit for excerpt
 */
if(!function_exists('opalmedical_fnc_excerpt')){
    //Custom Excerpt Function
    function opalmedical_fnc_excerpt($limit,$afterlimit='...') {
        $excerpt = get_the_excerpt();
        if( $excerpt != ''){
           $excerpt = @explode(' ', strip_tags( $excerpt ), $limit);
        }else{
            $excerpt = @explode(' ', strip_tags(get_the_content( )), $limit);
        }
        if (count($excerpt)>=$limit) {
            @array_pop($excerpt);
            $excerpt = @implode(" ",$excerpt).' '.$afterlimit;
        } else {
            $excerpt = @implode(" ",$excerpt);
        }
        $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
        return strip_shortcodes( $excerpt );
    }
}

/**
 *
 *  Applyer function to show unit for description 
 */
if(!function_exists('opalmedical_fnc_description')){
    //Custom Excerpt Function
    function opalmedical_fnc_description($limit,$afterlimit='[...]') {
        $excerpt = get_the_content();
        if( $excerpt != ''){
           $excerpt = @explode(' ', strip_tags( $excerpt ), $limit);
        }else{
            $excerpt = @explode(' ', strip_tags(get_the_content( )), $limit);
        }
        if (count($excerpt)>=$limit) {
            @array_pop($excerpt);
            $excerpt = @implode(" ",$excerpt).' '.$afterlimit;
        } else {
            $excerpt = @implode(" ",$excerpt);
        }
        $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
        return strip_shortcodes( $excerpt );
    }
}

/**
 *
 *  Applyer function to show unit for description 
 */
if(!function_exists('opalmedical_fnc_description_tax')){
    //Custom Excerpt Function
    function opalmedical_fnc_description_tax($description, $limit,$afterlimit='[...]') {
        $excerpt = $description;
        if( $excerpt != ''){
           $excerpt = explode(' ', strip_tags( $excerpt ), $limit);
        }else{
            $excerpt = explode(' ', strip_tags($description), $limit);
        }
        if (count($excerpt)>=$limit) {
            array_pop($excerpt);
            $excerpt = implode(" ",$excerpt).' '.$afterlimit;
        } else {
            $excerpt = implode(" ",$excerpt);
        }
        $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
        return strip_shortcodes( $excerpt );
    }
}

/**
 *
 */
function opalmedical_is_own_menu( $post_id, $user_id ){
        
    $post = get_post( $post_id );
    wp_reset_postdata();
    if( !is_object($post)  || !$post->ID ){
        return false;
    }
    return $user_id == $post->post_author;    
}


function opalmedical_get_list_doctors(){
    $args = array( 'posts_per_page' => -1 );
    $query = Opalmedical_Query::get_doctor_query( $args );

    $output = array();
    while( $query->have_posts() ){  $query->the_post(); 
        $output[get_the_ID()] = get_the_title(); 
    }
    wp_reset_postdata();

    return $output;
}


function opalmedical_pagination($pages = '', $range = 2 ) {
    global $paged;

    if(empty($paged))$paged = 1;

    $prev = $paged - 1;
    $next = $paged + 1;
    $showitems = ( $range * 2 )+1;
    $range = 2; // change it to show more links

    if( $pages == '' ){
        global $wp_query;

        $pages = $wp_query->max_num_pages;
        if( !$pages ){
            $pages = 1;
        }
    }

    if( 1 != $pages ){

        echo '<div class="pagination-main">';
            echo '<ul class="pagination">';
                echo ( $paged > 2 && $paged > $range+1 && $showitems < $pages ) ? '<li><a aria-label="First" href="'.get_pagenum_link(1).'"><span aria-hidden="true"><i class="fa fa-angle-double-left"></i></span></a></li>' : '';
                echo ( $paged > 1 ) ? '<li><a aria-label="Previous" href="'.get_pagenum_link($prev).'"><span aria-hidden="true"><i class="fa fa-angle-left"></i></span></a></li>' : '<li class="disabled"><a aria-label="Previous"><span aria-hidden="true"><i class="fa fa-angle-left"></i></span></a></li>';
                for ( $i = 1; $i <= $pages; $i++ ) {
                    if ( 1 != $pages &&( !( $i >= $paged+$range+1 || $i <= $paged-$range-1 ) || $pages <= $showitems ) )
                    {
                        if ( $paged == $i ){
                            echo '<li class="active"><a href="'.get_pagenum_link($i).'">'.$i.' <span class="sr-only"></span></a></li>';
                        } else {
                            echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
                        }
                    }
                }
                echo ( $paged < $pages ) ? '<li><a aria-label="Next" href="'.get_pagenum_link($next).'"><span aria-hidden="true"><i class="fa fa-angle-right"></i></span></a></li>' : '';
                echo ( $paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages ) ? '<li><a aria-label="Last" href="'.get_pagenum_link( $pages ).'"><span aria-hidden="true"><i class="fa fa-angle-double-right"></i></span></a></li>' : '';
            echo '</ul>';
        echo '</div>';

    }
}