<?php

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */

function sydney_contact_box() {
$post_id = get_the_ID();

	$screens = array( 'page' );

	foreach ( $screens as $screen ) {
		if ( 'page-templates/page_contact.php' == get_post_meta( $post_id, '_wp_page_template', true ) ) {
			add_meta_box(
				'sydney_sectionid',
				__( 'Contact info', 'sydney' ),
				'sydney_meta_box_callback',
				$screen
			);
		}
	}
}
add_action( 'add_meta_boxes', 'sydney_contact_box' );

/**
 * Prints the box content.
 * 
 */
function sydney_meta_box_callback( $post ) {
$post_id = get_the_ID();

	if ( 'page-templates/page_contact.php' == get_post_meta( $post_id, '_wp_page_template', true ) ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'sydney_meta_box', 'sydney_meta_box_nonce' );

		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$address = get_post_meta( $post->ID, '_sydney_map_address', true );
		$contact = get_post_meta( $post->ID, '_sydney_map_contact', true );
		$aside_title = get_post_meta( $post->ID, '_sydney_map_aside_title', true );
		$aside_address = get_post_meta( $post->ID, '_sydney_map_aside_address', true );
		$aside_email = get_post_meta( $post->ID, '_sydney_map_aside_email', true );
		$aside_phone = get_post_meta( $post->ID, '_sydney_map_aside_phone', true );

		echo '<p><label for="sydney_new_field">';
		_e( 'Enter your address for the map marker', 'sydney' );
		echo '</label></p>';
		echo '<input class="widefat" type="text" id="sydney_new_field" name="sydney_new_field" value="' . esc_attr( $address ) . '" size="25" />';

		echo '<p><label for="sydney_new_contact">';
		_e( 'Enter your Contact Form 7 ID', 'sydney' );
		echo '</label></p>';
		echo '<input class="widefat" type="text" id="sydney_new_contact" name="sydney_new_contact" value="' . esc_attr( $contact ) . '" size="25" />';

		echo '<h4>Aside contact details (displayed next to the contact form)</h4>';
		echo '<p><label for="sydney_new_atitle">';
		_e( 'Enter your title for the aside contact details', 'sydney' );
		echo '</label></p>';
		echo '<input class="widefat" type="text" id="sydney_new_atitle" name="sydney_new_atitle" value="' . esc_attr( $aside_title ) . '" size="25" />';
		echo '<p><label for="sydney_new_aaddress">';
		_e( 'Enter your address for the aside contact details', 'sydney' );
		echo '</label></p>';
		echo '<input class="widefat" type="text" id="sydney_new_aaddress" name="sydney_new_aaddress" value="' . esc_attr( $aside_address ) . '" size="25" />';
		echo '<p><label for="sydney_new_email">';
		_e( 'Enter your email for the aside contact details', 'sydney' );
		echo '</label></p>';	
		echo '<input class="widefat" type="text" id="sydney_new_email" name="sydney_new_email" value="' . esc_attr( $aside_email ) . '" size="25" />';
		echo '<p><label for="sydney_new_phone">';
		_e( 'Enter your phone number for the aside contact details', 'sydney' );
		echo '</label></p>';
		echo '<input class="widefat" type="text" id="sydney_new_phone" name="sydney_new_phone" value="' . esc_attr( $aside_phone ) . '" size="25" />';
	}
}

/**
 * When the post is saved, saves our custom data.
 *
 */
function sydney_save_meta_box_data( $post_id ) {
	$post_id = get_the_ID();

		if ( 'page-templates/page_contact.php' == get_post_meta( $post_id, '_wp_page_template', true ) ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['sydney_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['sydney_meta_box_nonce'], 'sydney_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( ! isset( $_POST['sydney_new_field'] ) ) {
		return;
	}

	// Sanitize user input.
	$new_address = sanitize_text_field( $_POST['sydney_new_field'] );
	$new_contact = sanitize_text_field( $_POST['sydney_new_contact'] );
	$new_title 	 = wp_kses_post( $_POST['sydney_new_atitle'] );
	$new_aaddress= wp_kses_post( $_POST['sydney_new_aaddress'] );
	$new_email 	 = wp_kses_post( $_POST['sydney_new_email'] );
	$new_phone 	 = wp_kses_post( $_POST['sydney_new_phone'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_sydney_map_address', $new_address );
	update_post_meta( $post_id, '_sydney_map_contact', $new_contact );
	update_post_meta( $post_id, '_sydney_map_aside_title', $new_title );
	update_post_meta( $post_id, '_sydney_map_aside_address', $new_aaddress );
	update_post_meta( $post_id, '_sydney_map_aside_email', $new_email );
	update_post_meta( $post_id, '_sydney_map_aside_phone', $new_phone );
}
}
add_action( 'save_post', 'sydney_save_meta_box_data' );