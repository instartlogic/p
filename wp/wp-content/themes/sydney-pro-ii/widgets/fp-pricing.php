<?php
/**
 * Pricing tables widget
 *
 * @package Sydney
 */

class Sydney_Pricing_Tables extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'sydney_pricing_widget', 'description' => __( 'Show what plans you are able to provide.', 'sydney') );
        parent::__construct(false, $name = __('Sydney: Pricing tables', 'sydney'), $widget_ops);
		$this->alt_option_name = 'sydney_pricing_widget';
			
    }
	
	function form($instance) {
		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    		= isset( $instance['number'] ) ? intval( $instance['number'] ) : -1;
		$category   	= isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
		$see_all   		= isset( $instance['see_all'] ) ? esc_url( $instance['see_all'] ) : '';		
		$see_all_text  	= isset( $instance['see_all_text'] ) ? esc_html( $instance['see_all_text'] ) : '';
		$style  		= isset( $instance['style'] ) ? esc_attr( $instance['style'] ) : '';			
    	$newtab   		= isset( $instance['newtab'] ) ? (bool) $instance['newtab'] : false;

	?>

	<p><?php _e('In order to display this widget, you must first add some pricing tables from your admin area.', 'sydney'); ?></p>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of pricing tables to show (-1 shows all of them):', 'sydney' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
    <p><label for="<?php echo $this->get_field_id('see_all'); ?>"><?php _e('The URL for your button [In case you want a button below your pricing tables block]', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all' ); ?>" name="<?php echo $this->get_field_name( 'see_all' ); ?>" type="text" value="<?php echo $see_all; ?>" size="3" /></p>	
    <p><label for="<?php echo $this->get_field_id('see_all_text'); ?>"><?php _e('The text for the button [Defaults to <em>See all our plans</em> if left empty]', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all_text' ); ?>" name="<?php echo $this->get_field_name( 'see_all_text' ); ?>" type="text" value="<?php echo $see_all_text; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Enter the slug for your category or leave empty to show all pricing tables.', 'sydney' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo $category; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Pick the style for this widget:', 'sydney'); ?></label>
        <select name="<?php echo $this->get_field_name('style'); ?>" id="<?php echo $this->get_field_id('style'); ?>">		
			<option value="style1" <?php if ( 'style1' == $style ) echo 'selected="selected"'; ?>><?php echo __('Style 1', 'sydney'); ?></option>
			<option value="style2" <?php if ( 'style2' == $style ) echo 'selected="selected"'; ?>><?php echo __('Style 2', 'sydney'); ?></option>
			<option value="style3" <?php if ( 'style3' == $style ) echo 'selected="selected"'; ?>><?php echo __('Style 3', 'sydney'); ?></option>
       	</select>
    </p>	
	<p><input class="checkbox" type="checkbox" <?php checked( $newtab ); ?> id="<?php echo $this->get_field_id( 'newtab' ); ?>" name="<?php echo $this->get_field_name( 'newtab' ); ?>" />
   	<label for="<?php echo $this->get_field_id( 'newtab' ); ?>"><?php _e( 'Open button links in a new tab?', 'sydney' ); ?></label></p>    
	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= sanitize_text_field($new_instance['title']);
		$instance['number'] 		= sanitize_text_field($new_instance['number']);
		$instance['see_all'] 		= esc_url_raw( $new_instance['see_all'] );	
		$instance['see_all_text'] 	= sanitize_text_field($new_instance['see_all_text']);
		$instance['category'] 		= sanitize_text_field($new_instance['category']);
		$instance['style'] = sanitize_text_field($new_instance['style']);
		$instance['newtab']    = is_null( $new_instance['newtab'] ) ? 0 : 1;		
		return $instance;
	}
	
	function widget($args, $instance) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title 			= ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title 			= apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$see_all 		= isset( $instance['see_all'] ) ? esc_url($instance['see_all']) : '';
		$see_all_text 	= isset( $instance['see_all_text'] ) ? esc_html($instance['see_all_text']) : '';		
		$number 		= ( ! empty( $instance['number'] ) ) ? intval( $instance['number'] ) : -1;
		if ( ! $number )
			$number 	= -1;				
		$category 		= isset( $instance['category'] ) ? esc_attr($instance['category']) : '';
		$style = isset( $instance['style'] ) ? esc_html($instance['style']) : 'style1';
    	$newtab	   = isset( $instance['newtab'] ) ? $instance['newtab'] : false;

    	if ( $newtab ) {
    		$target = '_blank';
    	} else {
    		$target = '_self';
    	}

		$plans = new WP_Query( array(
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'post_type' 		  => 'pricing_tables',
			'posts_per_page'	  => $number,
			'category_name'		  => $category			
		) );

		echo $args['before_widget'];

		if ($plans->have_posts()) :
?>
			<?php if ( $title ) echo $args['before_title'] . $title . $args['after_title']; ?>

			<div class="pricing-section <?php echo $style; ?>">
				<?php while ( $plans->have_posts() ) : $plans->the_post(); ?>
					<?php global $post; ?>
					<?php $features = get_post_meta($post->ID, '_sydney_pricing_key', true); ?>
					<?php $price = get_post_meta( $post->ID, '_sydney_pricing_price_key', true ); ?>
					<?php $text = get_post_meta( $post->ID, '_sydney_pricing_text_key', true ); ?>
					<?php $link = get_post_meta( $post->ID, '_sydney_pricing_link_key', true );	?>					
					<?php $icon = get_post_meta( $post->ID, '_sydney_pricing_icon', true );	?>					
					<?php $featured = get_post_meta( $post->ID, '_sydney_pricing_featured', true );	?>					
					<?php if ( $featured ) {
						$plan_type = 'featured-plan';
					} else {
						$plan_type = 'normal-plan';
					} ?>

					<div class="sydney-pricing-table">
						<div class="plan-item <?php echo $plan_type; ?>">
							<div class="plan-icon">
								<i class="<?php echo esc_html($icon); ?>"></i>
							</div>
							<h4><?php the_title(); ?></h4>
							<div class="plan-price">
								<?php echo wp_kses_post($price); ?>
							</div>							
							<div class="plan-text">
								<?php if ( is_array($features) ) : ?>
									<?php foreach ( $features as $feature ) : ?>
									<div class="plan-feature"><?php echo esc_html($feature['name']); ?></div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
							<?php if ( $link ) : ?>
							<div class="plan-btn">
								<a target="<?php echo $target; ?>" class="roll-button button" href="<?php echo esc_url($link); ?>"><?php echo esc_html($text); ?></a>
							</div>
							<?php endif; ?>	
						</div>
					</div>

				<?php endwhile; ?>

				<?php if ($see_all != '') : ?>
				<a href="<?php echo esc_url($see_all); ?>" class="button roll-button">
					<?php if ($see_all_text) : ?>
						<?php echo $see_all_text; ?>
					<?php else : ?>
						<?php echo __('See all our plans', 'sydney'); ?>
					<?php endif; ?>
				</a>
				<?php endif; ?>	
			</div>			
	<?php
		wp_reset_postdata();
		endif;
		echo $args['after_widget'];

	}
	
}