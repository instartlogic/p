<?php
/**
 * Page templates category metabox
 *
 * @package Sydney
 */


function call_Sydney_PT_Metabox() {
    new Sydney_PT_Metabox();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'call_Sydney_PT_Metabox' );
    add_action( 'load-post-new.php', 'call_Sydney_PT_Metabox' );
}

class Sydney_PT_Metabox {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}


	public function add_meta_box( $post_type ) {
        $post_types = array('page');
        if ( in_array( $post_type, $post_types )) {
			add_meta_box(
				'sydney_cat_metabox'
				,__( 'Custom post type category', 'sydney' )
				,array( $this, 'render_meta_box_content' )
				,$post_type
				,'advanced'
				,'high'
			);
        }
	}

	public function save( $post_id ) {
	
		if ( ! isset( $_POST['sydney_inner_custom_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['sydney_inner_custom_box_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'sydney_inner_custom_box' ) )
			return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$mydata = sanitize_text_field( $_POST['sydney_cat_field'] );

		update_post_meta( $post_id, '_sydney_pt_category', $mydata );
	}

	public function render_meta_box_content( $post ) {
	
		wp_nonce_field( 'sydney_inner_custom_box', 'sydney_inner_custom_box_nonce' );
		$value = get_post_meta( $post->ID, '_sydney_pt_category', true );
		echo '<p><label for="sydney_cat_field">';
		_e( 'Enter the slug for the category you wish to display posts from. Leave empty to show from all categories.', 'sydney' );
		echo '</label></p>';
		echo '<input class="widefat" type="text" id="sydney_cat_field" name="sydney_cat_field"';
                echo ' value="' . esc_attr( $value ) . '" size="25" />';
	}
}