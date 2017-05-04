<?php
/**
 * Sydney Theme Customizer - WooCommerce options
 *
 * @package Sydney
 */

function sydney_customize_register_wc( $wp_customize ) {



    //___Woocommerce___//
    $wp_customize->add_panel( 'sydney_woocommerce', array(
        'priority'       => 19,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Woocommerce', 'sydney'),
    ) );

    //___Header___//
    $wp_customize->add_section(
        'sydney_wc_general',
        array(
            'title'     => __('General', 'sydney'),
            'priority'  => 10,
            'panel'     => 'sydney_woocommerce',
        )
    );
    //Menu cart
    $wp_customize->add_setting(
        'swc_show_cart_menu',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'swc_show_cart_menu',
        array(
            'type'      => 'checkbox',
            'label'     => __('Show cart and account links in the menu?', 'sydney'),
            'section'   => 'sydney_wc_general',
            'priority'  => 10,
        )
    );
    //Sidebar position
    $wp_customize->add_setting(
        'swc_content_position',
        array(
            'sanitize_callback' => 'sydney_sanitize_swc_content',
            'default'           => 'right'
        )
    );
    $wp_customize->add_control(
        'swc_content_position',
        array(
            'type'        => 'radio',
            'label'       => __('Content position', 'sydney'),
            'description' => __('Content position on all WooCommerce pages', 'sydney'),
            'section'     => 'sydney_wc_general',
            'priority'    => 12,
            'choices' => array(
                'left'      => __('Left', 'sydney'),
                'right'     => __('Right', 'sydney'),
            ),
        )
    );
    //___Archives___//
    $wp_customize->add_section(
        'sydney_wc_archives',
        array(
            'title'     => __('Archives', 'sydney'),
            'priority'  => 11,
            'panel'     => 'sydney_woocommerce',
        )
    );
    //Products no.
    $wp_customize->add_setting(
        'swc_products_number',
        array(
            'sanitize_callback' => 'absint',
            'default'           => get_option( 'posts_per_page' ),
        )       
    );
    $wp_customize->add_control( 'swc_products_number', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'sydney_wc_archives',
        'label'       => __('Number of products on shop archives', 'sydney'),
        'input_attrs' => array(
            'min'   => 1,
            'max'   => 100,
            'step'  => 1,
        ),
    ) );
    //Columns
    $wp_customize->add_setting(
        'swc_columns_number',
        array(
            'sanitize_callback' => 'sydney_sanitize_swc_columns',
            'default'           => '3'
        )
    );
    $wp_customize->add_control(
        'swc_columns_number',
        array(
            'type'        => 'select',
            'label'       => __('Columns on shop archives', 'sydney'),
            'section'     => 'sydney_wc_archives',
            'priority'    => 13,
            'choices' => array(
                '1'     => __('One', 'sydney'),
                '2'     => __('Two', 'sydney'),
                '3'     => __('Three', 'sydney'),
                '4'     => __('Four', 'sydney'),
            ),
        )
    ); 
    //Sidebar
    $wp_customize->add_setting(
        'swc_sidebar_archives',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'swc_sidebar_archives',
        array(
            'type'      => 'checkbox',
            'label'     => __('Remove sidebar from archives?', 'sydney'),
            'section'   => 'sydney_wc_archives',
            'priority'  => 14,
        )
    );
    //Price
    $wp_customize->add_setting(
        'swc_archive_price',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'swc_archive_price',
        array(
            'type'      => 'checkbox',
            'label'     => __('Hide product price on archives?', 'sydney'),
            'section'   => 'sydney_wc_archives',
            'priority'  => 15,
        )
    );
    //Ratings
    $wp_customize->add_setting(
        'swc_archive_ratings',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'swc_archive_ratings',
        array(
            'type'      => 'checkbox',
            'label'     => __('Hide product ratings on archives?', 'sydney'),
            'section'   => 'sydney_wc_archives',
            'priority'  => 15,
        )
    );
    //Results
    $wp_customize->add_setting(
        'swc_archive_results',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'swc_archive_results',
        array(
            'type'      => 'checkbox',
            'label'     => __('Hide number of results on archives?', 'sydney'),
            'section'   => 'sydney_wc_archives',
            'priority'  => 16,
        )
    );
    //Sorting
    $wp_customize->add_setting(
        'swc_archive_sorting',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'swc_archive_sorting',
        array(
            'type'      => 'checkbox',
            'label'     => __('Hide sorting on archives?', 'sydney'),
            'section'   => 'sydney_wc_archives',
            'priority'  => 17,
        )
    );         
    //___Single products___//
    $wp_customize->add_section(
        'sydney_wc_singles',
        array(
            'title'     => __('Single products', 'sydney'),
            'priority'  => 13,
            'panel'     => 'sydney_woocommerce',
        )
    );
    //Sidebar
    $wp_customize->add_setting(
        'swc_sidebar_products',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'swc_sidebar_products',
        array(
            'type'      => 'checkbox',
            'label'     => __('Remove sidebar from single products?', 'sydney'),
            'section'   => 'sydney_wc_singles',
            'priority'  => 14,
        )
    );    
    //Ratings
    $wp_customize->add_setting(
        'swc_product_ratings',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'swc_product_ratings',
        array(
            'type'      => 'checkbox',
            'label'     => __('Hide product ratings on single products?', 'sydney'),
            'section'   => 'sydney_wc_singles',
            'priority'  => 15,
        )
    );
    //Categories
    $wp_customize->add_setting(
        'swc_product_cats',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'swc_product_cats',
        array(
            'type'      => 'checkbox',
            'label'     => __('Hide product categories on single products?', 'sydney'),
            'section'   => 'sydney_wc_singles',
            'priority'  => 16,
        )
    );    
}
add_action( 'customize_register', 'sydney_customize_register_wc' );

//Sidebar position
function sydney_sanitize_swc_content( $input ) {
    if ( in_array( $input, array( 'left', 'right' ), true ) ) {
        return $input;
    }
}
//Columns
function sydney_sanitize_swc_columns( $input ) {
    if ( in_array( $input, array( '1', '2', '3', '4' ), true ) ) {
        return $input;
    }
}


/**
 * Customizer styles
 */
function sydney_pro_customizer_styles() {

    wp_enqueue_style( 'sydney-wc-customizer-styles', get_template_directory_uri() . '/css/customizer.css' );

}
add_action( 'customize_controls_print_styles', 'sydney_pro_customizer_styles' );