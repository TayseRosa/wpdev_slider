<?php

if( !function_exists('wpdev_get_placeholder_image') ){
  function wpdev_get_placeholder_image(){
    return "<img src='" . WPDEV_SLIDER_URL . "assets/images/default.jpg' class='img-fluid wp-post-image' />";
  }

}

if ( ! function_exists( 'wpdev_slider_options' ) ){
  function wpdev_slider_options(){
    $show_bullets =isset( WPDEV_Slider_Settings::$options['wpdev_slider_bullets'] ) && WPDEV_Slider_Settings::$options['wpdev_slider_bullets'] == 1 ? true : false;

    wp_enqueue_script( 'wpdev-slider-options-js', WPDEV_SLIDER_URL . 'vendor/flexslider/flexslider.js', array( 'jquery' ), WPDEV_SLIDER_VERSION, true );
    
    /* identificador do script | nome de um objeto que vai fazer com que essa função e o JS "conversem" | array com chaves e valores que vc quer passar para o script. */
    wp_localize_script( 'wpdev-slider-options-js','SLIDER_OPTIONS', array(
      'controlNav' => $show_bullets
    ) );
  }
}