<?php

function sydney_tables_module_cpt() {

    $slug = apply_filters( 'athemes_pricing_tables_rewrite_slug', 'pricing-tables' ); 

    register_post_type( 'pricing_tables', array(
        'menu_icon' => 'dashicons-cart',
        'labels' => array(
            'name' => __( 'Pricing Tables', 'sydney' ),
            'singular_name' => __( 'Pricing Table', 'sydney' ),
            'add_new' => __( 'Add Table', 'sydney' ),
            'add_new_item' => __( 'Add Table', 'sydney' ),
            'edit' => __( 'Edit Table', 'sydney' ),
            'edit_item' => __( 'Edit Table', 'sydney' ),
            'new_item' => __( 'New Table', 'sydney' ),
            'view' => __( 'View Table', 'sydney' ),
            'view_item' => __( 'View Table', 'sydney' ),
            'search_items' => __( 'Search Tables', 'sydney' ),
            'not_found' => __( 'No Tables found', 'sydney' ),
            'not_found_in_trash' => __( 'No Tables found in Trash', 'sydney' ),
            'parent' => __( 'Parent Table', 'sydney' ),
        ),
        'rewrite' => array(
            'slug' => $slug,
        ),
        'public'            => true,
        'supports'          => array( 'title' ),
        'capability_type'   => 'post',
        'taxonomies'        => array( 'category' ),
    )); 
} 
add_action( 'init', 'sydney_tables_module_cpt' );

/* Pricing Tables */
function sydney_pricing_init() {
    new Sydney_Pro_Pricing_Tables();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'sydney_pricing_init' );
    add_action( 'load-post-new.php', 'sydney_pricing_init' );
}

class Sydney_Pro_Pricing_Tables {

    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post', array( $this, 'save' ) );
    }

    public function add_meta_box( $post_type ) {
        add_meta_box(
            'sydney_pricing_metabox'
            ,__( 'Pricing Tables', 'sydney' )
            ,array( $this, 'render_meta_box_content' )
            ,'pricing_tables'
            ,'advanced'
            ,'high'
        );
    }

    public function save( $post_id ) {
    
        if ( ! isset( $_POST['sydney_pricing_box'] ) ||
        ! wp_verify_nonce( $_POST['sydney_pricing_box'], 'sydney_pricing_box' ) )
            return;
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;
        
        if (!current_user_can('edit_post', $post_id))
            return;
        

        $price = isset( $_POST['sydney_pricing_price'] ) ? wp_kses_post($_POST['sydney_pricing_price']) : false;
        $text = isset( $_POST['sydney_pricing_text'] ) ? sanitize_text_field($_POST['sydney_pricing_text']) : false;
        $link = isset( $_POST['sydney_pricing_link'] ) ? esc_url_raw($_POST['sydney_pricing_link']) : false;
        $icon = isset( $_POST['sydney_pricing_icon'] ) ? sanitize_text_field($_POST['sydney_pricing_icon']) : false;
        $featured = isset( $_POST['sydney_pricing_featured'] ) ? (bool)($_POST['sydney_pricing_featured']) : false;

        update_post_meta( $post_id, '_sydney_pricing_link_key', $link );
        update_post_meta( $post_id, '_sydney_pricing_price_key', $price );
        update_post_meta( $post_id, '_sydney_pricing_text_key', $text );
        update_post_meta( $post_id, '_sydney_pricing_icon', $icon );
        update_post_meta( $post_id, '_sydney_pricing_featured', $featured );
        
        //Repeatable
        $old = get_post_meta($post_id, '_sydney_pricing_key', true);
        $new = array();
        
        $names = $_POST['name'];    
        $count = count( $names );
        
        for ( $i = 0; $i < $count; $i++ ) {
            if ( $names[$i] != '' ) :
                $new[$i]['name'] = stripslashes( strip_tags( $names[$i] ) );
            endif;
        }

        if ( !empty( $new ) && $new != $old )
            update_post_meta( $post_id, '_sydney_pricing_key', $new );
        elseif ( empty($new) && $old )
            delete_post_meta( $post_id, '_sydney_pricing_key', $old );
    }

    public function render_meta_box_content( $post ) {
        global $post;

        $repeatable_fields = get_post_meta($post->ID, '_sydney_pricing_key', true);

        wp_nonce_field( 'sydney_pricing_box', 'sydney_pricing_box' );

        $price = get_post_meta( $post->ID, '_sydney_pricing_price_key', true );
        $text = get_post_meta( $post->ID, '_sydney_pricing_text_key', true );
        $link = get_post_meta( $post->ID, '_sydney_pricing_link_key', true );
        $icon = get_post_meta( $post->ID, '_sydney_pricing_icon', true );
        $featured = get_post_meta( $post->ID, '_sydney_pricing_featured', true );

        ?>
        <p><label for="sydney_pricing_price"><?php _e( 'Price for this plan', 'sydney' ); ?></label></p>
        <p><input type="text" class="widefat" id="sydney_pricing_price" name="sydney_pricing_price" value="<?php echo $price; ?>"></p>
        <p><label for="sydney_pricing_text"><?php _e( 'Button text for this plan', 'sydney' ); ?></label></p>
        <em><?php _e( 'You can wrap the currency symbol in span tags to make it look different than the price. Example <span>$</span>49', 'sydney' ); ?></em>
        <p><input type="text" class="widefat" id="sydney_pricing_text" name="sydney_pricing_text" value="<?php echo $text; ?>"></p>
        <p><label for="sydney_pricing_link"><?php _e( 'Button link for this plan', 'sydney' ); ?></label></p>
        <p><input type="text" class="widefat" id="sydney_pricing_link" name="sydney_pricing_link" value="<?php echo $link; ?>"></p>
        <p><label for="sydney_pricing_icon"><?php _e( 'Icon for this plan (e.g. fa fa-mobile). Full list of icons <a target="_blank" href="http://fontawesome.io/cheatsheet/">here</a>', 'sydney' ); ?></label></p>
        <p><input type="text" class="widefat" id="sydney_pricing_icon" name="sydney_pricing_icon" value="<?php echo $icon; ?>"></p>
        <p><input class="checkbox" type="checkbox" <?php checked( $featured ); ?> id="sydney_pricing_featured" name="sydney_pricing_featured" />
        <label for="sydney_pricing_featured"><?php _e( 'Mark this plan as featured?', 'sydney' ); ?></label></p>

        <script type="text/javascript">
        jQuery(document).ready(function( $ ){
            $( '#add-row' ).on('click', function() {
                var row = $( '.empty-row.screen-reader-text' ).clone(true);
                row.removeClass( 'empty-row screen-reader-text' );
                row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
                return false;
            });
        
            $( '.remove-row' ).on('click', function() {
                $(this).parents('tr').remove();
                return false;
            });
        });
        </script>
      
        <table id="repeatable-fieldset-one" width="100%">
        <thead>
            <tr>
                <th style="text-align:left;margin-bottom: 1em;font-weight:400;display:block;" width="40%">Features</th>
            </tr>
        </thead>
        <tbody>
        <?php
        
        if ( $repeatable_fields ) :
        
        foreach ( $repeatable_fields as $field ) {
        ?>
        <tr>
            <td style="width:100%;"><input type="text" class="widefat" name="name[]" value="<?php if($field['name'] != '') echo esc_attr( $field['name'] ); ?>" /></td>
                    
            <td><a class="button remove-row" href="#">Remove feature</a></td>
        </tr>
        <?php
        }
        else :
        ?>
        <tr>
            <td style="width:100%;"><input type="text" class="widefat" name="name[]" /></td>
                    
            <td><a class="button remove-row" href="#">Remove feature</a></td>
        </tr>
        <?php endif; ?>
        
        <tr class="empty-row screen-reader-text">
            <td><input type="text" class="widefat" name="name[]" /></td>
                                  
            <td><a class="button remove-row" href="#">Remove feature</a></td>
        </tr>
        </tbody>
        </table>
        
        <p><a id="add-row" class="button button-primary" href="#">Add another feature</a></p>
        <?php
    }

}