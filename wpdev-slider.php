<?php

/**
 * Plugin Name: WPDEV Slider
 * Plugin URI: http://www.wpdev.net.br/plugins/wpdev-slider
 * Description: This is WPDEV Slider Plugin, this plugin helps you to add slider on your website, just by adding a shortcode on your page/post. Come and meet the WPDEV Slider. Learn more about the developer: <a href="http://www.wpdev.net.br" target="_blank">http://www.wpdev.net.br</a>
 * Version: 1.0
 * Requires at least: 5.6
 * Author: WPDev - Plugins Wordpress
 * Author URI: http://www.wpdev.net.br
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wpdev-slider

 */

 /*
WPDEV Slider is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
WPDEV Slider is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with WPDEV Slider. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if( ! defined( 'ABSPATH') ){
    exit;
}

if( ! class_exists( 'WPDEV_Slider' ) ){
    class WPDEV_Slider{
        function __construct(){
            $this->define_constants();

            require_once( WPDEV_SLIDER_PATH . 'functions/functions.php' );

            add_action( 'admin_menu', array( $this, 'add_menu' ) );

            require_once( WPDEV_SLIDER_PATH . 'post-types/class.wpdev-slider-cpt.php' );
            $WPDEV_Slider_Post_Type = new WPDEV_Slider_Post_Type();

            require_once( WPDEV_SLIDER_PATH . 'class.wpdev-slider-settings.php' );
            $wpdev_slider_settings = new WPDEV_Slider_Settings();

            /* Chamando shortcode */
            require_once( WPDEV_SLIDER_PATH . 'shortcodes/class.wpdev-slider-shortcode.php' );
            $wpdev_slider_shortcode = new WPDEV_Slider_Shortcode();

            add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 999 );

            add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts' ) );
            
        }

        public function define_constants(){
            define( 'WPDEV_SLIDER_PATH', plugin_dir_path( __FILE__ ) );
            define( 'WPDEV_SLIDER_URL', plugin_dir_url( __FILE__ ) );
            define( 'WPDEV_SLIDER_VERSION', '1.0.0' );
        }

        public static function activate(){
            update_option( 'rewrite_rules', '' );
        }

        public static function deactivate(){
            flush_rewrite_rules();
            unregister_post_type( 'wpdev-slider' );
        }

        public static function uninstall(){

        }

        public function add_menu(){
            add_menu_page(
                'WPDEV Slider Options',
                'WPDEV Slider',
                'manage_options',
                'wpdev_slider_admin',
                array($this, 'wpdev_slider_settings_page'),
                'dashicons-images-alt2',
            );
            
            add_submenu_page(
                'wpdev_slider_admin',
                'Manage slides',
                'Manage slides',
                'manage_options',
                'edit.php?post_type=wpdev-slider',
                null,
                null
            );

            add_submenu_page(
                'wpdev_slider_admin',
                'Add new Slide',
                'Add new Slide',
                'manage_options',
                'post-new.php?post_type=wpdev-slider',
                null,
                null
            );
        }

        public function wpdev_slider_settings_page(){
            if( !current_user_can( 'manage_options' ) ){
                return;
            }

            /* mensagem de sucesso ou erro */
            if( isset($_GET['settings-updated']) ){
                add_settings_error( 'wpdev_slider_options', 'wpdev_slider_message', 'Settings Saved', 'success' );
            }
            settings_errors( 'wpdev_slider_options');

            require_once( WPDEV_SLIDER_PATH . 'views/settings-page.php');
        }

        public function register_scripts(){
            wp_register_script( 'wpdev-slider-main-jq', WPDEV_SLIDER_URL . 'vendor/flexslider/jquery.flexslider-min.js', array( 'jquery' ), WPDEV_SLIDER_VERSION, true );
            wp_register_style( 'wpdev-slider-main-css', WPDEV_SLIDER_URL . 'vendor/flexslider/flexslider.css', array(), WPDEV_SLIDER_VERSION, 'all' );
            wp_register_style( 'wpdev-slider-style-css', WPDEV_SLIDER_URL . 'assets/css/frontend.css', array(), WPDEV_SLIDER_VERSION, 'all' );
            
        }

        public function register_admin_scripts(){
            global $typenow;
            if( $typenow == 'wpdev-slider' ){
                wp_enqueue_style( 'wpdev-slider-main',WPDEV_SLIDER_URL.'assets/css/admin.css' );
            }

            wp_enqueue_style( 'wpdev-style-admin', WPDEV_SLIDER_URL . 'assets/css/admin.css' );
        }

    }
}

if( class_exists( 'WPDEV_Slider' ) ){
    register_activation_hook( __FILE__, array( 'WPDEV_Slider', 'activate' ) );
    register_deactivation_hook( __FILE__, array( 'WPDEV_Slider', 'deactivate' ) );
    register_uninstall_hook( __FILE__, array( 'WPDEV_Slider', 'uninstall' ) );

    $wpdev_slider = new WPDEV_Slider();
} 
