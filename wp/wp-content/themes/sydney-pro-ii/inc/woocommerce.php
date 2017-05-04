<?php
/**
 * Woocommerce Compatibility 
 *
 * @package Sydney Pro
 */


if ( !class_exists('WooCommerce') )
    return;

/**
 * Declare support
 */
function sydney_wc_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'sydney_wc_support' );

/**
 * Add and remove actions
 */
function sydney_woo_actions() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
    add_action('woocommerce_before_main_content', 'sydney_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'sydney_wrapper_end', 10);
}
add_action('wp','sydney_woo_actions');

/**
 * Archive titles
 */
function sydney_woo_archive_title() {
    echo '<h3 class="archive-title">';
    echo woocommerce_page_title();
    echo '</h3>';
}
add_filter( 'woocommerce_show_page_title', 'sydney_woo_archive_title' );

/**
 * Theme wrappers
 */
function sydney_wrapper_start() {

    $archive_check = sydney_wc_archive_check();
    $rs_archives = get_theme_mod( 'swc_sidebar_archives' );
    $rs_products = get_theme_mod( 'swc_sidebar_products' );

    if ( ( $archive_check && $rs_archives ) || ( is_product() && $rs_products ) ) {
        $cols = 'col-md-12';
    } else {
        $cols = 'col-md-9';
    }

    echo '<div id="primary" class="content-area ' . $cols . '">';
        echo '<main id="main" class="site-main" role="main">';
}

function sydney_wrapper_end() {
        echo '</main>';
    echo '</div>';
}

/**
 * Remove default WooCommerce CSS
 */
function sydney_dequeue_styles( $enqueue_styles ) {
    unset( $enqueue_styles['woocommerce-general'] ); 
    return $enqueue_styles;
}
add_filter( 'woocommerce_enqueue_styles', 'sydney_dequeue_styles' );

/**
 * Enqueue custom CSS for Woocommerce
 */
function sydney_woocommerce_css() {
    wp_enqueue_style( 'sydney-wc-css', get_template_directory_uri() . '/woocommerce/css/wc.css' );
}
add_action( 'wp_enqueue_scripts', 'sydney_woocommerce_css', 1 );

/**
 * Number of related products
 */
function sydney_related_products_args( $args ) {
    $args['posts_per_page'] = 3;
    $args['columns'] = 3;
    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'sydney_related_products_args' );

/**
 * Variable products button
 */
function sydney_single_variation_add_to_cart_button() {
    global $product;
    ?>
    <div class="woocommerce-variation-add-to-cart variations_button">
        <?php
            do_action( 'woocommerce_before_add_to_cart_quantity' );

            woocommerce_quantity_input( array(
                'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1,
            ) );

            do_action( 'woocommerce_after_add_to_cart_quantity' );
        ?>
        <button type="submit" class="roll-button cart-button"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
        <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
        <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
        <input type="hidden" name="variation_id" class="variation_id" value="0" />
    </div>
     <?php
}
add_action( 'woocommerce_single_variation', 'sydney_single_variation_add_to_cart_button', 21 );

/**
 * Update cart
 */
function sydney_header_add_to_cart_fragment( $fragments ) {
    ob_start();
    ?>
    <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i><span class="cart-amount"><?php echo WC()->cart->cart_contents_count; ?></span></a>
    <?php
    
    $fragments['a.cart-contents'] = ob_get_clean();
    
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'sydney_header_add_to_cart_fragment' );

/**
 * Add cart to menu
 */
function sydney_nav_cart ( $items, $args ) {
    $swc_show_cart_menu = get_theme_mod('swc_show_cart_menu');
    if ( $swc_show_cart_menu ) {
        if ( $args -> theme_location == 'primary' ) {
            $items .= '<li class="nav-cart"><a class="cart-contents" href="' . WC()->cart->get_cart_url() . '"><i class="fa fa-shopping-cart"></i><span class="cart-amount">' . WC()->cart->cart_contents_count . '</span></a></li>';
        }
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'sydney_nav_cart', 10, 2 );

/**
 * Woocommerce account link in header
 */
function sydney_woocommerce_account_link( $items, $args ) {
    $swc_show_cart_menu = get_theme_mod('swc_show_cart_menu');
    if ( $swc_show_cart_menu && ( $args -> theme_location == 'primary' ) ) {
        if ( is_user_logged_in() ) {
            $account = __( 'My Account', 'sydney' );
        } else {
            $account = __( 'Login/Register', 'sydney' );
        }
        $items .= '<li class="header-account"><a href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . '" title="' . $account . '"><i class="fa fa-user"></i></a></li>';
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'sydney_woocommerce_account_link', 10, 2 );

/**
 * Number of products
 */
function sydney_woocommerce_products_number() {
    $default = get_option( 'posts_per_page' );
    $number  = get_theme_mod( 'swc_products_number', $default);

    return $number;
}
add_filter( 'loop_shop_per_page', 'sydney_woocommerce_products_number', 20 );

/**
 * Number of columns per row
 */
function sydney_shop_columns() {
    $number = get_theme_mod( 'swc_columns_number', 3 );
    return $number;
}
add_filter('loop_shop_columns', 'sydney_shop_columns');

/**
 * Show product descriptions when layout is set to 1 column
 */
function sydney_shop_descriptions() { 
    $number = get_theme_mod( 'swc_columns_number', 3 );

    if ( $number == 1 ) {
        the_excerpt(); 
    }
} 
add_action( 'woocommerce_after_shop_loop_item_title', 'sydney_shop_descriptions', 11, 2); 

/**
 * Returns true if current page is shop, product archive or product tag
 */
function sydney_wc_archive_check() {
    if ( is_shop() || is_product_category() || is_product_tag() ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Remove sidebar from all archives
 */
function sydney_remove_wc_sidebar_archives() {
    $archive_check = sydney_wc_archive_check();
    $rs_archives = get_theme_mod( 'swc_sidebar_archives' );
    $rs_products = get_theme_mod( 'swc_sidebar_products' );

    if ( ( $rs_archives && $archive_check ) || ( $rs_products && is_product() ) ) {
        remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    }   
}
add_action( 'wp', 'sydney_remove_wc_sidebar_archives' );