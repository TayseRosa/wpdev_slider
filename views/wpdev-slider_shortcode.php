<h3><?php echo ( ! empty ( $content ) ) ? esc_html( $content ) : esc_html( WPDEV_Slider_Settings::$options['wpdev_slider_title'] ); ?></h3>
<div class="wpdev-slider flexslider <?php echo (isset( WPDEV_Slider_Settings::$options['wpdev_slider_style'] )) ? esc_attr(WPDEV_Slider_Settings::$options['wpdev_slider_style'])  : 'style-1'; ?>">
    <ul class="slides">

      <?php
        $args = array(
          'post_type'=>'wpdev-slider',
          'post_status'=>'publish',
          'post__in'=> $id,
          'orderby'  => $orderby
        );

        $myQuery = new WP_Query( $args );

        if ( $myQuery->have_posts() ):

          while( $myQuery->have_posts() ):$myQuery->the_post();

          $button_text = get_post_meta( get_the_ID(),'wpdev_slider_link_text', true );
          $button_url =  get_post_meta( get_the_ID(),'wpdev_slider_link_url',  true );
      ?>
          <li>
          <?php 
        if( has_post_thumbnail() ){
            the_post_thumbnail( 'full', array( 'class' => 'img-fluid' ) );
        }else{
            echo wpdev_get_placeholder_image();
        }
         
        ?>
            <div class="wpdevs-container">
                <div class="slider-details-container">
                    <div class="wrapper">
                        <div class="slider-title">
                            <h2> <?php the_title();?> </h2>
                        </div>
                        <div class="slider-description">
                            <div class="subtitle"> <?php the_content();?> </div>
                            <a target="_blank" class="link" href="<?php echo esc_url($button_url);?>"> <?php echo esc_html( $button_text ); ?> </a>
                        </div>
                    </div>
                </div>              
            </div>
        </li>

          <?php 
              endwhile;
              wp_reset_postdata();/* para nao afetar outras consultas sql, precisa reinicializar ao estado original. */
            endif;
          ?>

    </ul>
</div>