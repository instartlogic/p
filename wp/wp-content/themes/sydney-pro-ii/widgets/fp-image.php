<?php

class Sydney_Image_Widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'sydney_image_widget_widget', 'description' => __( 'Display an image from your media library.', 'sydney') );
        parent::__construct(false, $name = __('Sydney: Image', 'sydney'), $widget_ops);
		$this->alt_option_name = 'sydney_image_widget';

		add_action('admin_enqueue_scripts', array($this, 'scripts'));
	}
	
	function form($instance) {
		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$url    		= isset( $instance['url'] ) ? esc_url( $instance['url'] ) : '';
		$custom_url    	= isset( $instance['custom_url'] ) ? esc_url( $instance['custom_url'] ) : '';
		$max_width      = isset( $instance['max-width'] ) ? absint( $instance['max-width'] ) : '';
	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p><label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'URL of your image:', 'sydney' ); ?></label>
	<input class="image-url widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo $url; ?>" size="3" />
    <button class="image-upload button button-primary">Click to select</button></p>
	
	<p><label for="<?php echo $this->get_field_id( 'custom_url' ); ?>"><?php _e( 'Add a link here if you want your image to link somewhere:', 'sydney' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'custom_url' ); ?>" name="<?php echo $this->get_field_name( 'custom_url' ); ?>" type="text" value="<?php echo $custom_url; ?>" size="3" />

	<p>
	<label for="<?php echo $this->get_field_id('max-width'); ?>"><?php _e('Maximum width for the image (units will be applied automatically)', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('max-width'); ?>" name="<?php echo $this->get_field_name('max-width'); ?>" type="text" value="<?php echo $max_width; ?>" />
	</p>	
	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 		= strip_tags($new_instance['title']);
		$instance['url'] 		= esc_url_raw($new_instance['url']);
		$instance['custom_url'] = esc_url_raw($new_instance['custom_url']);
		$instance['max-width']  = absint($new_instance['max-width']);
		  
		return $instance;
	}

	function widget($args, $instance) {

		extract($args);

		$title 			= ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title 			= apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$url   			= isset( $instance['url'] ) ? esc_url( $instance['url'] ) : '';
		$custom_url   	= isset( $instance['custom_url'] ) ? esc_url( $instance['custom_url'] ) : '';
		$max_width   	= isset( $instance['max-width'] ) ? intval( $instance['max-width'] ) : '';

		if ( $max_width ) {
			$max_width = $max_width . 'px';
		} else {
			$max_width = '100%';
		}


		echo $before_widget;
		
		if ( $title ) echo $before_title . $title . $after_title;
		
		if( $url ) {
			echo '<div style="display:inline-block;max-width:' . $max_width . ';" class="sydney-image">';
			if ( $custom_url ) {
				echo '<a href="' . $custom_url . '"><img src="' . $url . '"/></a>';
			} else {
				echo '<img src="' . $url . '"/>';
			}
			echo '</div>';
		}
		echo $after_widget;

	}

	public function scripts() {
	    wp_enqueue_script( 'media-upload' );
	    wp_enqueue_media();
	    wp_enqueue_script('sydney-media-upload', get_template_directory_uri() . '/js/media-uploader.js', array('jquery'));
	}	
	
}	