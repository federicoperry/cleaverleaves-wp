<?php
/**
 * function to integrate with WPML which will display languages as buttons
 */

if( !function_exists("mediac_fnc_wpml_language_buttons") ){
   function mediac_fnc_wpml_language_buttons(){
     if( function_exists( 'icl_get_languages' ) ){
       $languages = icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str');
       if( is_array( $languages ) ){

          foreach( $languages as $lang_k=>$lang ){
              if( $lang['active'] ){
                  $active_lang = $lang;
                  unset( $languages[$lang_k] );
              }
          }

          // disabled
          if( count( $languages ) ){
              $lang_status = 'enabled';
          } else {
              $lang_status = 'disabled';
          }

          echo '<div class="language wpml-languages quick-button box-group '. $lang_status .'">';

              echo '<div class="heading active" href="'. esc_url( $active_lang['url'] ).'" ontouchstart="this.classList.toggle(\'hover\');">';
                  echo '<img src="'. esc_url( $active_lang['country_flag_url'] ) .'" alt="'. esc_attr( $active_lang['translated_name'] ) .'"/>';
                  echo esc_attr( $active_lang['translated_name'] );
                  if( count( $languages ) ) echo '<i class="icon-down-open-mini"></i>';
              echo '</div>';

              if( count( $languages ) ){
                  echo '<ul class="wpml-lang-dropdown dropdown-menu list">';
                      foreach( $languages as $lang ){
                          echo '<li><a href="'. esc_url( $lang['url'] ) .'"><img src="'. esc_url( $lang['country_flag_url'] ) .'" alt="'. esc_attr( $lang['translated_name'] ) .'"/>'. esc_attr( $lang['translated_name'] ) .'</a></li>';
                      }
                  echo '</ul>';
              }

          echo '</div>';
        }
      }
   }
}



/**
 * Footer builder profile is custom post type, its content is shortcode rendering with visual composer
 *
 * @param $footer
 *
 */

function mediac_fnc_get_footer_profile_postdata( $footer ){
  if( empty( $footer) || $footer == 'default' ){
    return ;
  }
  if( is_numeric($footer) ){
      $post = get_post( $footer );
  }else {
      $post =  get_posts( array(
          'name' =>  $footer,
          'numberposts' => 1,
          'post_type' => 'footer' ) );
       $post = count($post) && $post?$post[0] :null;
  }
  wp_reset_postdata();
  return $post;
}

function mediac_fnc_render_post_content( $post ){

  global $mediac_wpopconfig, $kc;

  $mediac_wpopconfig['type'] = 'footer';
  if( $post && $kc ){
      echo trim( $kc->do_shortcode( $post->post_content ) );
  }

  $mediac_wpopconfig['type'] = '';
}



/**
 * create a random key to use as primary key.
 */
if(!function_exists('mediac_fnc_makeid')){
    function mediac_fnc_makeid($length = 5){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}



if(!function_exists('mediac_fnc_excerpt')){
    //Custom Excerpt Function
    function mediac_fnc_excerpt($limit,$afterlimit='[...]') {
        $excerpt = get_the_excerpt();
        if( $excerpt != ''){
           $excerpt = explode(' ', strip_tags( $excerpt ), $limit);
        }else{
            $excerpt = explode(' ', strip_tags(get_the_content( )), $limit);
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


function mediac_fnc_get_widget_block_styles(){
   return array(  'default' , 'primary', 'danger' , 'success', 'warning', 'coffe', 'bluesky' );
}
