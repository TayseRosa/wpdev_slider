<?php
    $meta = get_post_meta( $post->ID );
?>

<table class="form-table wpdev-slider-metabox"> 
    <input type="hidden" name="wpdev_slider_nonce" value="<?php echo wp_create_nonce('wpdev_slider_nonce');?>">
    <tr>
        <th>
            <label for="wpdev_slider_link_text">Link Text</label>
        </th>
        <td>
            <input 
                type="text" 
                name="wpdev_slider_link_text" 
                id="wpdev_slider_link_text" 
                class="regular-text link-text"
                value="<?php echo (isset ($meta['wpdev_slider_link_text'][0]) ) ? esc_html($meta['wpdev_slider_link_text'][0]) : '';?>"
                required
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="wpdev_slider_link_url">Link URL</label>
        </th>
        <td>
            <input 
                type="url" 
                name="wpdev_slider_link_url" 
                id="wpdev_slider_link_url" 
                class="regular-text link-url"
                value="<?php echo ( isset($meta['wpdev_slider_link_url'][0])) ? esc_url($meta['wpdev_slider_link_url'][0])  : '' ?>"
                required
            >
        </td>
    </tr>               
</table>