<?php
/**
 * Timeline widget
 *
 * @package Sydney
 */

class Sydney_Timeline extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'sydney_timeline_widget', 'description' => __( 'Display your timeline.', 'sydney') );
        parent::__construct(false, $name = __('Sydney FP: Timeline', 'sydney'), $widget_ops);
		$this->alt_option_name = 'sydney_timeline_widget';
		
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );		
    }
	
	function form($instance) {
		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    		= isset( $instance['number'] ) ? intval( $instance['number'] ) : -1;
		$category   	= isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
		$see_all   		= isset( $instance['see_all'] ) ? esc_url_raw( $instance['see_all'] ) : '';		
		$see_all_text  	= isset( $instance['see_all_text'] ) ? esc_html( $instance['see_all_text'] ) : '';
	?>

	<p><?php _e('This widget requires you to re-import the settings file and create some timeline events.', 'sydney'); ?></p>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'sydney'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of timeline events to show (-1 shows all of them):', 'sydney' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
    <p><label for="<?php echo $this->get_field_id('see_all'); ?>"><?php _e('The URL for your button [In case you want a button below your timeline block]', 'sydney'); ?></label>
	<input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'see_all' ); ?>" name="<?php echo $this->get_field_name( 'see_all' ); ?>" type="text" value="<?php echo $see_all; ?>" size="3" /></p>	
    <p><label for="<?php echo $this->get_field_id('see_all_text'); ?>"><?php _e('The text for the button [Defaults to <em>See all our events</em> if left empty]', 'sydney'); ?></label>
	<input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'see_all_text' ); ?>" name="<?php echo $this->get_field_name( 'see_all_text' ); ?>" type="text" value="<?php echo $see_all_text; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Enter the slug for your category or leave empty to show all events.', 'sydney' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo $category; ?>" size="3" /></p>

	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['number'] 		= strip_tags($new_instance['number']);
		$instance['see_all'] 		= esc_url_raw( $new_instance['see_all'] );	
		$instance['see_all_text'] 	= strip_tags($new_instance['see_all_text']);		
		$instance['category'] 		= strip_tags($new_instance['category']);
		    			
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['sydney_timeline']) )
			delete_option('sydney_timeline');		  
		  
		return $instance;
	}
	
	function flush_widget_cache() {
		wp_cache_delete('sydney_timeline', 'widget');
	}
	
	function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'sydney_timeline', 'widget' );
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

		$title 			= ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title 			= apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$see_all 		= isset( $instance['see_all'] ) ? esc_url($instance['see_all']) : '';
		$see_all_text 	= isset( $instance['see_all_text'] ) ? esc_html($instance['see_all_text']) : '';		
		$number 		= ( ! empty( $instance['number'] ) ) ? intval( $instance['number'] ) : -1;
		if ( ! $number )
			$number 	= -1;				
		$category 		= isset( $instance['category'] ) ? esc_attr($instance['category']) : '';

		$timeline = new WP_Query( array(
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'post_type' 		  => 'timeline-events',
			'order'				  => 'ASC',
			'posts_per_page'	  => $number,
			'category_name'		  => $category			
		) );

		echo $args['before_widget'];

		if ($timeline->have_posts()) :
?>
			<?php if ( $title ) echo $before_title . $title . $after_title; ?>
					<?php $counter = 0; ?>
					<?php while ( $timeline->have_posts() ) : $timeline->the_post(); $counter++; ?>
						<?php $date 	  = get_post_meta( get_the_ID(), 'wpcf-event-date', true ); ?>
						<?php $icon 	  = get_post_meta( get_the_ID(), 'wpcf-event-icon', true ); ?>
						<?php $icon_color = get_post_meta( get_the_ID(), 'wpcf-event-icon-color', true ); ?>
						<?php $link 	  = get_post_meta( get_the_ID(), 'wpcf-event-url', true ); ?>
						<?php if ( $counter % 2 != 0 ) : ?>
						<div class="timeline timeline-even clearfix">
							<div class="timeline-inner clearfix">						
								<div class="content">
									<h3>
										<?php if ($link) : ?>
											<a href="<?php echo esc_url($link); ?>"><?php the_title(); ?></a>
										<?php else : ?>
											<?php the_title(); ?>
										<?php endif; ?>
									</h3>
									<?php if ($date) : ?>
										<span class="timeline-date"><?php echo $date; ?></span>
									<?php endif; ?>									
									<?php the_content(); ?>
								</div><!--.info-->
								<?php if ($icon) : ?>			
									<div class="icon" style="background-color: <?php echo esc_attr($icon_color); ?>;">
										<?php echo '<i class="fa ' . esc_html($icon) . '"></i>'; ?>
									</div>
								<?php endif; ?>						
							</div>
						</div>
					<?php else : ?>
						<div class="timeline timeline-odd clearfix">
							<div class="timeline-inner clearfix">									
								<?php if ($icon) : ?>			
									<div class="icon" style="background-color: <?php echo esc_attr($icon_color); ?>;">
										<?php echo '<i class="fa ' . esc_html($icon) . '"></i>'; ?>
									</div>
								<?php endif; ?>													
								<div class="content">
									<h3>
										<?php if ($link) : ?>
											<a href="<?php echo esc_url($link); ?>"><?php the_title(); ?></a>
										<?php else : ?>
											<?php the_title(); ?>
										<?php endif; ?>
									</h3>
									<?php if ($date) : ?>
										<span class="timeline-date"><?php echo $date; ?></span>
									<?php endif; ?>									
									<?php the_content(); ?>
								</div><!--.info-->	
							</div>
						</div>
					<?php endif; ?>					
					<?php endwhile; ?>

				<?php if ($see_all != '') : ?>
					<a href="<?php echo esc_url($see_all); ?>" class="roll-button more-button">
						<?php if ($see_all_text) : ?>
							<?php echo $see_all_text; ?>
						<?php else : ?>
							<?php echo __('See all our timeline', 'sydney'); ?>
						<?php endif; ?>
					</a>
				<?php endif; ?>				
	<?php
		wp_reset_postdata();
		endif;
		echo $args['after_widget'];

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'sydney_timeline', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
	
}