<?php 

if( ! class_exists('WPDEV_Slider_Shortcode')){
    class WPDEV_Slider_Shortcode{
        public function __construct(){
            add_shortcode( 'wpdev_slider', array( $this, 'add_shortcode' ) );
        }

        public function add_shortcode( $atts = array(), $content = null, $tag = '' ){

            $atts = array_change_key_case( (array) $atts, CASE_LOWER );

            extract( shortcode_atts(
                array(
                    'id' => '',
                    'orderby' => 'date'
                ),
                $atts,
                $tag
            ));

            if( !empty( $id ) ){
                $id = array_map( 'absint', explode( ',', $id ) );
            }

            ob_start();/* Pega toda a saida html e joga no buffer */
            require( WPDEV_SLIDER_PATH . 'views/wpdev-slider_shortcode.php' );

            /* Chamando arquivos js e css */

            wp_enqueue_script( 'wpdev-slider-main-jq' );
            wp_enqueue_style( 'wpdev-slider-main-css' );
            wp_enqueue_style( 'wpdev-slider-style-css' );
            wpdev_slider_options();

            return ob_get_clean();/* devolve o html retornando o resultado da função ob_get_clean */
        }
    }
}