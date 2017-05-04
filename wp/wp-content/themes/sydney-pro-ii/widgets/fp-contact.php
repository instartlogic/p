<?php

class Sydney_FP_Contact_Info extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'sydney_contact_widget', 'description' => __( 'Display your contact info on your front page', 'sydney') );
        parent::__construct(false, $name = __('Sydney FP: Contact', 'sydney'), $widget_ops);
		$this->alt_option_name = 'sydney_contact_widget';
		
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );		
    }
	
	function form($instance) {

		$title    		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$above_address  = isset( $instance['above_address'] ) ? esc_html( $instance['above_address'] ) : '';		
		$address  		= isset( $instance['address'] ) ? esc_html( $instance['address'] ) : '';
		$above_phone    = isset( $instance['above_phone'] ) ? esc_html( $instance['above_phone'] ) : '';
		$phone    		= isset( $instance['phone'] ) ? esc_html( $instance['phone'] ) : '';
		$above_email    = isset( $instance['above_email'] ) ? esc_html( $instance['above_email'] ) : '';
		$email    		= isset( $instance['email'] ) ? esc_html( $instance['email'] ) : '';
	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p><label for="<?php echo $this->get_field_id( 'above_address' ); ?>"><?php _e( 'A short call to action above your address', 'sydney' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'above_address' ); ?>" name="<?php echo $this->get_field_name( 'above_address' ); ?>" type="text" value="<?php echo $above_address; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Enter your address', 'sydney' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" type="text" value="<?php echo $address; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id( 'above_phone' ); ?>"><?php _e( 'A short call to action above your phone number', 'sydney' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'above_phone' ); ?>" name="<?php echo $this->get_field_name( 'above_phone' ); ?>" type="text" value="<?php echo $above_phone; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Enter your phone number', 'sydney' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>" name="<?php echo $this->get_field_name( 'phone' ); ?>" type="text" value="<?php echo $phone; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id( 'above_email' ); ?>"><?php _e( 'A short call to action above your email address', 'sydney' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'above_email' ); ?>" name="<?php echo $this->get_field_name( 'above_email' ); ?>" type="text" value="<?php echo $above_email; ?>" size="3" /></p>	
	<p><label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Enter your email address', 'sydney' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo $email; ?>" size="3" /></p>	

	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['address'] = strip_tags($new_instance['address']);
		$instance['phone'] = strip_tags($new_instance['phone']);
		$instance['email'] = strip_tags($new_instance['email']);
		$instance['above_address'] = strip_tags($new_instance['above_address']);
		$instance['above_phone'] = strip_tags($new_instance['above_phone']);
		$instance['above_email'] = strip_tags($new_instance['above_email']);

		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['sydney_contact_info']) )
			delete_option('sydney_contact_info');		  
		  
		return $instance;
	}
	
	function flush_widget_cache() {
		wp_cache_delete('sydney_contact_info', 'widget');
	}
	
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'sydney_contact_info', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title 		= ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title 		= apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$address   	= isset( $instance['address'] ) ? esc_html( $instance['address'] ) : '';
		$phone   	= isset( $instance['phone'] ) ? esc_html( $instance['phone'] ) : '';
		$email   	= isset( $instance['email'] ) ? esc_html( $instance['email'] ) : '';
		$above_address  = isset( $instance['above_address'] ) ? esc_html( $instance['above_address'] ) : '';
		$above_phone   	= isset( $instance['above_phone'] ) ? esc_html( $instance['above_phone'] ) : '';
		$above_email   	= isset( $instance['above_email'] ) ? esc_html( $instance['above_email'] ) : '';

		echo $before_widget;
		
		if ( $title ) echo $before_title . $title . $after_title;
		
		if( ($address) ) {
			echo '<div class="fp-contact">';
			echo '<span><i class="fa fa-home"></i></span>';
			if( ($above_address) ) {
			echo '<span class="contact-above">' . $above_address . '</span>';
			}
			echo '<span>' . $address . '</span>';
			echo '</div>';
		}
		if( ($phone) ) {
			echo '<div class="fp-contact">';
			echo '<span><i class="fa fa-phone"></i></span>';
			if( ($above_phone) ) {
			echo '<span class="contact-above">' . $above_phone . '</span>';
			}			
			echo '<span>' . $phone . '</span>';
			echo '</div>';
		}
		if( ($email) ) {
			echo '<div class="fp-contact">';
			echo '<span><i class="fa fa-envelope"></i></span>';
			if( ($above_email) ) {
			echo '<span class="contact-above">' . $above_email . '</span>';
			}			
			echo '<span>' . $email . '</span>';
			echo '</div>';
		}				

		echo $after_widget;


		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'sydney_contact_info', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}	