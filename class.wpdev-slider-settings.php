<?php
if( !class_exists( 'WPDEV_Slider_Settings' ) ){
  class WPDEV_Slider_Settings{  
    
    public static $options;

    public function __construct(){
      self::$options = get_option( 'wpdev_slider_options' );
      add_action( 'admin_init', array( $this, 'admin_init' ) );
    }

    public function admin_init(){
      
      register_setting( 'wpdev_slider_group', 'wpdev_slider_options', array ($this, 'wpdev_slider_validate') );

      add_settings_section(
        'wpdev_slider_main_section',
        'How does it work?',
        null, 
        'wpdev_slider_page1'
      );

      register_setting( 'wpdev_slider_group', 'wpdev_slider_options' );

      add_settings_section(
        'wpdev_slider_second_section',
        'Other plugins options',
        null, 
        'wpdev_slider_page2'
      );

      add_settings_field(
        'wpdev_slider_shortcode',
        'Shortcode',
        array( $this, 'wpdev_slider_shortcode_callback' ),
        'wpdev_slider_page1',
        'wpdev_slider_main_section'
      );

      add_settings_field(
        'wpdev_slider_banner',
        '',
        array( $this, 'wpdev_slider_banner_callback' ),
        'wpdev_slider_page1',
        'wpdev_slider_main_section'
      );

      add_settings_field(
        'wpdev_slider_title',
        'Slider title',
        array( $this, 'wpdev_slider_title_callback' ),
        'wpdev_slider_page2',
        'wpdev_slider_second_section'
      );

      add_settings_field(
        'wpdev_slider_bullets',
        'Display bullets',
        array( $this, 'wpdev_slider_bullets_callback' ),
        'wpdev_slider_page2',
        'wpdev_slider_second_section'
      );

      add_settings_field(
        'wpdev_slider_style',
        'Slider style',
        array( $this, 'wpdev_slider_style_callback' ),
        'wpdev_slider_page2',
        'wpdev_slider_second_section'
      );

      add_settings_field(
        'wpdev_slider_banner2',
        '',
        array( $this, 'wpdev_slider_banner2_callback' ),
        'wpdev_slider_page2',
        'wpdev_slider_second_section'

      );
    }

    public function wpdev_slider_shortcode_callback(){
      ?>
      <span> Use the shortcode [wpdev] to display the slider in any page/post/widget. </span>
      <?php
    }

    public function wpdev_slider_banner_callback(){
      ?>
        <a href="http://www.wpdev.net.br" target="_blank">
          <img src="<?php echo WPDEV_SLIDER_URL . 'vendor/slider/wpdev_banner_512x280.jpg'?>"  /> 
        </a>

    <?php
    }


    public function wpdev_slider_title_callback(){
      ?>
      <input 
      type="text"
      name="wpdev_slider_options[wpdev_slider_title]" 
      id="wpdev_slider_title"
      value="<?php echo isset( self::$options['wpdev_slider_title'] ) ? esc_attr( self::$options['wpdev_slider_title'] ): '' ?>"
      >
      <?php
    }

    public function wpdev_slider_bullets_callback(){
      ?>
          <input 
              type="checkbox"
              name="wpdev_slider_options[wpdev_slider_bullets]"
              id="wpdev_slider_bullets"
              value="1"
              <?php 
                  if( isset( self::$options['wpdev_slider_bullets'] ) ){
                      checked( "1", self::$options['wpdev_slider_bullets'], true );
                  }    
              ?>
          />
          <label for="wpdev_slider_bullets">Whether to display bullets or not</label>
          
      <?php
  }

  public function wpdev_slider_style_callback(){
      ?>
      <select 
          id="wpdev_slider_style" 
          name="wpdev_slider_options[wpdev_slider_style]">
          <option value="style-1" 
              <?php isset( self::$options['wpdev_slider_style'] ) ? selected( 'style-1', self::$options['wpdev_slider_style'], true ) : ''; ?>>Style-1</option>
          <option value="style-2" 
              <?php isset( self::$options['wpdev_slider_style'] ) ? selected( 'style-2', self::$options['wpdev_slider_style'], true ) : ''; ?>>Style-2</option>
      </select>
      <?php
  }

  public function wpdev_slider_banner2_callback(){
    ?>
      <a href="http://www.wpdev.net.br" target="_blank">
        <img src="<?php echo WPDEV_SLIDER_URL . 'vendor/slider/wpdev_banner_1024x560.jpg'?>"  /> 
      </a>
  <?php
  }

    public function wpdev_slider_validate( $input ){
      $newInput = array();
      foreach( $input as $key=>$value ){
        /* $newInput[$key] = sanitize_text_field($value); */

        switch( $key ){
          case 'wpdev_slider_title':
            if( empty( $value ) ){
              $value = 'Please, type some text..';
            }
            $newInput[$key] = sanitize_text_field( $value );
          break;
          default:
            $newInput[$key] = sanitize_text_field( $value );
          break;
        }
      }
      return $newInput;
    }
  }
}