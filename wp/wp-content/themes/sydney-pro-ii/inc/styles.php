<?php
/**
 * @package Sydney
 */

//Converts hex colors to rgba for the menu background color
function sydney_hex2rgba($color, $opacity = false) {

        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        $rgb =  array_map('hexdec', $hex);
        $opacity = 0.9;
        $output = 'rgba('.implode(",",$rgb).','.$opacity.')';

        return $output;
}

//Dynamic styles
function sydney_custom_styles($custom) {

	$custom = '';
	//Header
	$menu_bg_color = get_theme_mod( 'menu_bg_color', '#000000' );
	$rgba 	= sydney_hex2rgba($menu_bg_color, 0.9);	
	if ( (get_theme_mod('front_header_type','slider') == 'nothing' && is_front_page()) || (get_theme_mod('site_header_type') == 'nothing' && !is_front_page()) || is_page_template('page-templates/page_contact.php') || is_page_template('page-templates/page_no-header.php') || is_page_template('page-templates/page_no-header-wide.php') ) {
		$custom .= ".site-header { background-color:" . esc_attr($rgba) . ";}" . "\n";
		$custom .= ".site-header.float-header {padding:20px 0;}"."\n";		
	}
	//Fonts
	$body_fonts = get_theme_mod('body_font_family');	
	$headings_fonts = get_theme_mod('headings_font_family');
	if ( $body_fonts !='' ) {
		$custom .= "body, #mainnav ul ul a { font-family:" . $body_fonts . "!important;}"."\n";
	}
	if ( $headings_fonts !='' ) {
		$custom .= "h1, h2, h3, h4, h5, h6, #mainnav ul li a, .portfolio-info, .roll-testimonials .name, .roll-team .team-content .name, .roll-team .team-item .team-pop .name, .roll-tabs .menu-tab li a, .roll-testimonials .name, .roll-project .project-filter li a, .roll-button, .roll-counter .name-count, .roll-counter .numb-count button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"] { font-family:" . $headings_fonts . ";}"."\n";
	}
    //Site title
    $site_title_size = get_theme_mod( 'site_title_size', '32' );
    if ($site_title_size) {
        $custom .= ".site-title { font-size:" . intval($site_title_size) . "px; }"."\n";
    }
    //Site description
    $site_desc_size = get_theme_mod( 'site_desc_size', '16' );
    if ($site_desc_size) {
        $custom .= ".site-description { font-size:" . intval($site_desc_size) . "px; }"."\n";
    }
    //Menu
    $menu_size = get_theme_mod( 'menu_size', '14' );
    if ($menu_size) {
        $custom .= "#mainnav ul li a { font-size:" . intval($menu_size) . "px; }"."\n";
    }    	    	
	//H1 size
	$h1_size = get_theme_mod( 'h1_size','52' );
	if ($h1_size) {
		$custom .= "h1 { font-size:" . intval($h1_size) . "px; }"."\n";
	}
    //H2 size
    $h2_size = get_theme_mod( 'h2_size','42' );
    if ($h2_size) {
        $custom .= "h2 { font-size:" . intval($h2_size) . "px; }"."\n";
    }
    //H3 size
    $h3_size = get_theme_mod( 'h3_size','32' );
    if ($h3_size) {
        $custom .= "h3 { font-size:" . intval($h3_size) . "px; }"."\n";
    }
    //H4 size
    $h4_size = get_theme_mod( 'h4_size','25' );
    if ($h4_size) {
        $custom .= "h4 { font-size:" . intval($h4_size) . "px; }"."\n";
    }
    //H5 size
    $h5_size = get_theme_mod( 'h5_size','20' );
    if ($h5_size) {
        $custom .= "h5 { font-size:" . intval($h5_size) . "px; }"."\n";
    }
    //H6 size
    $h6_size = get_theme_mod( 'h6_size','18' );
    if ($h6_size) {
        $custom .= "h6 { font-size:" . intval($h6_size) . "px; }"."\n";
    }
    //Body size
    $body_size = get_theme_mod( 'body_size', '14' );
    if ($body_size) {
        $custom .= "body { font-size:" . intval($body_size) . "px; }"."\n";
    }

	//Header image
	$header_bg_size = get_theme_mod('header_bg_size','cover');	
	$header_height = get_theme_mod('header_height','300');
	$custom .= ".header-image { background-size:" . esc_attr($header_bg_size) . ";}"."\n";
	$custom .= ".header-image { height:" . intval($header_height) . "px; }"."\n";

	//Menu style
	$sticky_menu = get_theme_mod('sticky_menu','sticky');
	if ($sticky_menu == 'static') {
		$custom .= ".site-header.fixed { position: absolute;}"."\n";
	}
	$menu_style = get_theme_mod('menu_style','inline');
	if ($menu_style == 'centered') {
		$custom .= ".header-wrap .col-md-4, .header-wrap .col-md-8 { width: 100%; text-align: center;}"."\n";
		$custom .= "#mainnav { float: none;}"."\n";
		$custom .= "#mainnav li { float: none; display: inline-block;}"."\n";
		$custom .= "#mainnav ul ul li { display: block; text-align: left; float:left;}"."\n";
		$custom .= ".site-logo, .header-wrap .col-md-4 { margin-bottom: 15px; }"."\n";
		$custom .= ".btn-menu { margin: 0 auto; float: none; }"."\n";
		$custom .= ".header-wrap .container > .row { display: block; }"."\n";
	}	


	//__COLORS
	//Primary color
	$primary_color = get_theme_mod( 'primary_color', '#d65050' );
	if ( $primary_color != '#d65050' ) {
	$custom .= ".style1 .plan-icon, .style3 .plan-icon, .roll-team.type-b .team-social li a,#mainnav ul li a:hover, .sydney_contact_info_widget span, .roll-team .team-content .name,.roll-team .team-item .team-pop .team-social li:hover a,.roll-infomation li.address:before,.roll-infomation li.phone:before,.roll-infomation li.email:before,.roll-testimonials .name,.roll-button.border,.roll-button:hover,.roll-icon-list .icon i,.roll-icon-list .content h3 a:hover,.roll-icon-box.white .content h3 a,.roll-icon-box .icon i,.roll-icon-box .content h3 a:hover,.switcher-container .switcher-icon a:focus,.go-top:hover,.hentry .meta-post a:hover,#mainnav > ul > li > a.active, #mainnav > ul > li > a:hover, button:hover, input[type=\"button\"]:hover, input[type=\"reset\"]:hover, input[type=\"submit\"]:hover, .text-color, .social-menu-widget a, .social-menu-widget a:hover, .archive .team-social li a, a, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color:" . esc_attr($primary_color) . "}"."\n";
	$custom .= ".project-filter li a.active, .project-filter li a:hover,.woocommerce div.product .woocommerce-tabs ul.tabs li.active,.woocommerce #respond input#submit,.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.project-filter li.active, .project-filter li:hover,.roll-team.type-b .team-item .team-social li:hover a,.preloader .pre-bounce1, .preloader .pre-bounce2,.roll-team .team-item .team-pop,.roll-progress .progress-animate,.roll-socials li a:hover,.roll-project .project-item .project-pop,.roll-project .project-filter li.active,.roll-project .project-filter li:hover,.roll-button.light:hover,.roll-button.border:hover,.roll-button,.roll-icon-box.white .icon,.owl-theme .owl-controls .owl-page.active span,.owl-theme .owl-controls.clickable .owl-page:hover span,.go-top,.bottom .socials li:hover a,.sidebar .widget:before,.blog-pagination ul li.active,.blog-pagination ul li:hover a,.content-area .hentry:after,.text-slider .maintitle:after,.error-wrap #search-submit:hover,#mainnav .sub-menu li:hover > a,#mainnav ul li ul:after, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"], .panel-grid-cell .widget-title:after, .cart-amount { background-color:" . esc_attr($primary_color) . "}"."\n";
	$custom .= ".roll-team.type-b .team-social li a,.roll-socials li a:hover,.roll-socials li a,.roll-button.light:hover,.roll-button.border,.roll-button,.roll-icon-list .icon,.roll-icon-box .icon,.owl-theme .owl-controls .owl-page span,.comment .comment-detail,.widget-tags .tag-list a:hover,.blog-pagination ul li,.hentry blockquote,.error-wrap #search-submit:hover,textarea:focus,input[type=\"text\"]:focus,input[type=\"password\"]:focus,input[type=\"datetime\"]:focus,input[type=\"datetime-local\"]:focus,input[type=\"date\"]:focus,input[type=\"month\"]:focus,input[type=\"time\"]:focus,input[type=\"week\"]:focus,input[type=\"number\"]:focus,input[type=\"email\"]:focus,input[type=\"url\"]:focus,input[type=\"search\"]:focus,input[type=\"tel\"]:focus,input[type=\"color\"]:focus, button, input[type=\"button\"], input[type=\"reset\"], input[type=\"submit\"], .archive .team-social li a { border-color:" . esc_attr($primary_color) . "}"."\n";
	}
	//Menu background
	$menu_bg_color = get_theme_mod( 'menu_bg_color', '#000000' );
	$rgba = sydney_hex2rgba($menu_bg_color, 0.9);
	$custom .= ".site-header.float-header { background-color:" . esc_attr($rgba) . ";}" . "\n";
	$custom .= "@media only screen and (max-width: 1024px) { .site-header { background-color:" . esc_attr($menu_bg_color) . ";}}" . "\n";
	//Site title
	$site_title = get_theme_mod( 'site_title_color', '#ffffff' );
	$custom .= ".site-title a, .site-title a:hover { color:" . esc_attr($site_title) . "}"."\n";
	//Site desc
	$site_desc = get_theme_mod( 'site_desc_color', '#ffffff' );
	$custom .= ".site-description { color:" . esc_attr($site_desc) . "}"."\n";
	//Top level menu items color
	$top_items_color = get_theme_mod( 'top_items_color', '#ffffff' );
	$custom .= "#mainnav ul li a, #mainnav ul li::before { color:" . esc_attr($top_items_color) . "}"."\n";
	//Sub menu items color
	$submenu_items_color = get_theme_mod( 'submenu_items_color', '#ffffff' );
	$custom .= "#mainnav .sub-menu li a { color:" . esc_attr($submenu_items_color) . "}"."\n";
	//Sub menu background
	$submenu_background = get_theme_mod( 'submenu_background', '#1c1c1c' );
	$custom .= "#mainnav .sub-menu li a { background:" . esc_attr($submenu_background) . "}"."\n";
	//Header slider text
	$slider_text = get_theme_mod( 'slider_text', '#ffffff' );
	$custom .= ".text-slider .maintitle, .text-slider .subtitle { color:" . esc_attr($slider_text) . "}"."\n";
	//Body
	$body_text = get_theme_mod( 'body_text_color', '#767676' );
	$custom .= "body { color:" . esc_attr($body_text) . "}"."\n";
	//Sidebar background
	$sidebar_background = get_theme_mod( 'sidebar_background', '#ffffff' );
	$custom .= "#secondary { background-color:" . esc_attr($sidebar_background) . "}"."\n";
	//Sidebar color
	$sidebar_color = get_theme_mod( 'sidebar_color', '#767676' );
	$custom .= "#secondary, #secondary a, #secondary .widget-title { color:" . esc_attr($sidebar_color) . "}"."\n";	
	//Footer widget area background
	$footer_widgets_background = get_theme_mod( 'footer_widgets_background', '#252525' );
	$custom .= ".footer-widgets { background-color:" . esc_attr($footer_widgets_background) . "}"."\n";	
	//Footer widget area color
	$footer_widgets_color = get_theme_mod( 'footer_widgets_color', '#767676' );
	if ( $footer_widgets_color != '#767676' ) {
		$custom .= "#sidebar-footer,#sidebar-footer a,.footer-widgets .widget-title { color:" . esc_attr($footer_widgets_color) . "}"."\n";	
	}
	//Footer background
	$footer_background = get_theme_mod( 'footer_background', '#1c1c1c' );
	$custom .= ".site-footer { background-color:" . esc_attr($footer_background) . "}"."\n";	
	//Footer color
	$footer_color = get_theme_mod( 'footer_color', '#666666' );
	$custom .= ".site-footer,.site-footer a { color:" . esc_attr($footer_color) . "}"."\n";	
	//Rows overlay
	$rows_overlay = get_theme_mod( 'rows_overlay', '#000000' );
	$custom .= ".overlay { background-color:" . esc_attr($rows_overlay) . "}"."\n";	
	//Mobile menu icon
	$mobile_menu_color = get_theme_mod( 'mobile_menu_color', '#ffffff' );
	$custom .= ".btn-menu { color:" . esc_attr($mobile_menu_color) . "}"."\n";




	//Menu items hover
	$menu_items_hover = get_theme_mod( 'menu_items_hover', '#d65050' );
	$custom .= "#mainnav ul li a:hover { color:" . esc_attr($menu_items_hover) . "}"."\n";	

	//PRO STYLES
	//Footer center
	$footer_center = get_theme_mod( 'footer_center' );
	if ($footer_center) {
		$custom 	 .= ".site-info { text-align: center; }"."\n";
	}
	//Margin
	$title_margin = get_theme_mod( 'section_title_margin', '50' );
	$custom 	 .= ".panel-grid-cell .widget-title { margin-bottom:" . intval($title_margin) . "px; }"."\n";
	//Transform
	$title_transform = get_theme_mod( 'section_title_transform', 'uppercase' );
	$custom 	 	.= ".panel-grid-cell .widget-title { text-transform:" . esc_attr($title_transform) . "; }"."\n";
	//Italicize
	$title_italicize = get_theme_mod( 'section_title_italicize' );
	if ($title_italicize) {
		$custom 	 	.= ".panel-grid-cell .widget-title { font-style: italic; }"."\n";
	}
	//Align
	$title_style 	= get_theme_mod( 'section_title_style', 'default' );
	if ($title_style == 'bordered') {
		$custom 	 .= ".panel-grid-cell .widget-title:after { display:none; }"."\n";
		$custom 	 .= ".panel-grid-cell .widget-title { border: 2px solid; border-radius: 5px;display: table; padding: 15px 10px; }"."\n";
	} elseif ($title_style == 'solid') {
		$custom 	 .= ".panel-grid-cell .widget-title { display: table; border-radius: 5px; padding: 15px 10px; background-color: #444; color: #fff; }"."\n";
		$custom 	 .= ".panel-grid-cell .widget-title:after { display:none; }"."\n";
	}
	//Contact info
	if (get_theme_mod('toggle_contact') && ((is_front_page() && get_theme_mod('front_header_type','slider') != 'nothing') || (!is_front_page() && get_theme_mod('site_header_type','slider') != 'nothing')) ) {
		$custom .= ".site-header {margin-top: 55px;}"."\n";
		$custom .= "@media only screen and (max-width: 991px) { .site-header {margin-top: 0;} }"."\n";
		$custom .= ".site-header.fixed {margin-top: 0;}"."\n";
	}
	if (get_theme_mod('contact_center')) {
		$custom .= ".header-contact {text-align: center;}"."\n";
	}
	$contact_background = get_theme_mod( 'contact_background', '#1c1c1c' );
	$custom .= ".header-contact { background-color:" . esc_attr($contact_background) . "}"."\n";
	$contact_color = get_theme_mod( 'contact_color', '#c5c5c5' );
	$custom .= ".header-contact { color:" . esc_attr($contact_color) . "}"."\n";

	//Buttons
	$buttons_type = get_theme_mod('buttons_type','default');
	if ($buttons_type != 'default') {
		if ($buttons_type == 'bordered-left-fill') {
			//Fill left to right
			$custom .= ".roll-button:hover { background-color: transparent;color:#fff;}"."\n";
			$custom .= ".roll-button:after { border-radius:" . intval(get_theme_mod( 'buttons_radius','3' )) . "px;background-color:" . esc_attr($primary_color) . "; width: 0; height: 100%; position: absolute; top: 0;left:0;z-index:-1;content: '';transition: all 0.3s;-webkit-transition: all 0.3s;}"."\n";
			$custom .= ".roll-button { background-color: transparent;position: relative;z-index:1;color:" . esc_attr($primary_color) . ";}"."\n";
			$custom .= ".roll-button:hover:after { width: 100%;}"."\n";
		} elseif ($buttons_type == 'bordered-top-fill') {
			//Fill top to bottom
			$custom .= ".roll-button:hover { background-color: transparent;color:#fff;}"."\n";
			$custom .= ".roll-button:after { border-radius:" . intval(get_theme_mod( 'buttons_radius','3' )) . "px;background-color:" . esc_attr($primary_color) . "; width: 100%; height: 0; position: absolute; top: 0;left:0;z-index:-1;content: '';transition: all 0.3s;-webkit-transition: all 0.3s;}"."\n";
			$custom .= ".roll-button { background-color: transparent;position: relative;z-index:1;color:" . esc_attr($primary_color) . ";}"."\n";
			$custom .= ".roll-button:hover:after { height: 100%;}"."\n";
		} elseif ($buttons_type == 'bordered-center-fill') {
			//Fill center to sides
			$custom .= ".roll-button:hover { background-color: transparent;color:#fff;}"."\n";
			$custom .= ".roll-button:after { border-radius:" . intval(get_theme_mod( 'buttons_radius','3' )) . "px;background-color:" . esc_attr($primary_color) . "; width: 0; height: 100%; position: absolute; top: 0;left:50%;z-index:-1;content: '';transition: all 0.3s;-webkit-transition: all 0.3s;}"."\n";
			$custom .= ".roll-button { background-color: transparent;position: relative;z-index:1;color:" . esc_attr($primary_color) . ";}"."\n";
			$custom .= ".roll-button:hover:after { width: 102%;transform:translateX(-50%);}"."\n";
		} elseif ($buttons_type == 'solid') {
			//Filled
			$custom .= ".roll-button.border { color: #fff;background-color:" . esc_attr($primary_color) . ";}"."\n";
			$custom .= ".roll-button.border:hover { background-color: transparent;color:" . esc_attr($primary_color) . ";}"."\n";	
		} elseif ($buttons_type == 'bordered') {
			//Bordered
			$custom .= ".roll-button { color:" . esc_attr($primary_color) . ";background-color:transparent;}"."\n";
			$custom .= ".roll-button:hover { color: #fff;background-color:" . esc_attr($primary_color) . ";}"."\n";
		}

	}

	//Button sizes
	$buttons_tb_padding = get_theme_mod( 'buttons_tb_padding','12' );
	$custom .= ".roll-button { padding-top:" . intval($buttons_tb_padding) . "px;padding-bottom:" . intval($buttons_tb_padding) . "px; }"."\n";
	$buttons_lr_padding = get_theme_mod( 'buttons_lr_padding','35' );
	$custom .= ".roll-button { padding-left:" . intval($buttons_lr_padding) . "px;padding-right:" . intval($buttons_lr_padding) . "px; }"."\n";
	$custom .= ".roll-button { font-size:" . intval(get_theme_mod( 'buttons_font_size','13' )) . "px; }"."\n";
	$custom .= ".roll-button { border-radius:" . intval(get_theme_mod( 'buttons_radius','3' )) . "px; }"."\n";

	//Below header widget area
	$center_bh_widgets = get_theme_mod( 'center_bh_widgets','0' );
	if ($center_bh_widgets) {
		$custom .= ".header-widgets {text-align: center;}"."\n";
	}
	$bg_bh_widgets = get_theme_mod( 'bg_bh_widgets','#ffffff' );
	$custom .= ".header-widgets {background-color:" . esc_attr($bg_bh_widgets) . ";}"."\n";
	$color_bh_widgets = get_theme_mod( 'color_bh_widgets','#767676' );
	$custom .= ".header-widgets {color:" . esc_attr($color_bh_widgets) . ";}"."\n";




	//Post/page options
    $background_img 	= get_post_meta( get_the_ID(), 'wpcf-single-background-image', true );
    $background_color 	= get_post_meta( get_the_ID(), 'wpcf-single-background-color', true );
    $hide_title 		= get_post_meta( get_the_ID(), 'wpcf-single-hide-title', true );
    $content_opacity 	= get_post_meta( get_the_ID(), 'wpcf-single-content-opacity', true );
    global $post;
    if ( $background_img ) {
    	if (is_single()) {
       		$custom .= ".postid-" . $post->ID . " { background-image: url('" . esc_url($background_img) . "') !important; background-attachment: fixed !important; background-repeat: no-repeat !important; background-size: cover;}"."\n";
    	} elseif (is_page()){
        	$custom .= ".page-id-" . $post->ID . " { background-image: url('" . esc_url($background_img) . "') !important; background-attachment: fixed !important; background-repeat: no-repeat !important; background-size: cover;}"."\n";
    	}
    }
    if ($hide_title) {
    	if (is_single()) {
       		$custom .= ".postid-" . $post->ID . " .entry-header { display: none;}"."\n";
    	} elseif (is_page()){
        	$custom .= ".page-id-" . $post->ID . " .entry-header { display: none;}"."\n";
    	}    	
    }
    if ( $background_color ) {
    	if (is_single()) {
       		$custom .= ".postid-" . $post->ID . " { background-color:" . esc_attr($background_color) . " !important; background-image: none !important;}"."\n";
    	} elseif (is_page()){
        	$custom .= ".page-id-" . $post->ID . " { background-color:" . esc_attr($background_color) . " !important; background-image: none !important;}"."\n";
    	}
    }
    if ($content_opacity) {
    	if (is_single()) {
       		$custom .= ".postid-" . $post->ID . " .page-wrap .content-wrapper { background-color: rgba(255,255,255," . esc_attr($content_opacity) . ");}"."\n";
    	} elseif (is_page()){
        	$custom .= ".page-id-" . $post->ID . " .page-wrap .content-wrapper { background-color: rgba(255,255,255," . esc_attr($content_opacity) . ");}"."\n";
    	}    	
    }

    //Woocommerce
    if ( class_exists('Woocommerce') ) {
	    $wc_content_layout = get_theme_mod( 'swc_content_position', 'right' );
		$custom .= ".woocommerce .content-area, .woocommerce-cart .content-area, .woocommerce-checkout .content-area {float:" . $wc_content_layout . ";}"."\n"; 
		$shop_columns = get_theme_mod( 'swc_columns_number', 3 );
		if ( $shop_columns == 3 ) {
			$custom .= "@media only screen and (min-width: 769px) {.woocommerce .content-area ul.products li.product, .woocommerce-page .content-area ul.products li.product { width: 30.8%; } }"."\n"; 
		} elseif ( $shop_columns == 2 ) {
			$custom .= "@media only screen and (min-width: 769px) {.woocommerce .content-area ul.products li.product, .woocommerce-page .content-area ul.products li.product { width: 48.1%; } }"."\n"; 

		} elseif ( ( $shop_columns == 1 ) &&  ( sydney_wc_archive_check() ) ) {
			$custom .= "@media only screen and (min-width: 769px) {.woocommerce .content-area ul.products li.product, .woocommerce-page .content-area ul.products li.product { width: 100%; } }"."\n"; 
			$custom .= "@media only screen and (min-width: 769px) {.woocommerce ul.products li.product .woocommerce-LoopProduct-link h3, .woocommerce ul.products li.product .woocommerce-LoopProduct-link .price, .woocommerce ul.products li.product .woocommerce-LoopProduct-link p { width: 70%; float: left; } }"."\n"; 
			$custom .= "@media only screen and (min-width: 769px) {.woocommerce ul.products li.product .woocommerce-LoopProduct-link img { width: 30%; float: left; } }"."\n"; 		
			$custom .= "@media only screen and (min-width: 769px) {.woocommerce ul.products li.product .woocommerce-LoopProduct-link img { padding-right: 30px; } }"."\n"; 
			$custom .= "@media only screen and (min-width: 769px) {.woocommerce ul.products li.product .onsale { left: 0; right: auto; } }"."\n"; 
			$custom .= "@media only screen and (min-width: 769px) {.woocommerce .content-area ul.products li.product, .woocommerce-page .content-area ul.products li.product { padding-bottom:15px; border-bottom: 1px solid #ebe9eb; } }"."\n"; 
		}
		$archive_price 		= get_theme_mod( 'swc_archive_price' );
		$archive_ratings 	= get_theme_mod( 'swc_archive_ratings' );
		if ( $archive_price ) {
			$custom .= ".woocommerce.post-type-archive-product ul.products li.product .price {display:none;}"."\n";
		}
		if ( $archive_ratings) {
			$custom .= ".woocommerce.post-type-archive-product ul.products li.product .star-rating {display:none;}"."\n";
		}
	    $product_ratings    = get_theme_mod( 'swc_product_ratings' );
	    if ( $product_ratings) {
	        $custom .= ".single-product .woocommerce-product-rating .star-rating {display:none;}"."\n";
	    }
	    $product_cats    = get_theme_mod( 'swc_product_cats' );
	    if ( $product_cats) {
	        $custom .= ".single-product .product_meta {display:none;}"."\n";
	    }
	    $archive_results    = get_theme_mod( 'swc_archive_results' );
	    if ( $archive_results ) {
	        $custom .= ".woocommerce .woocommerce-result-count {display:none;}"."\n";
	    }   
	    $archive_sorting    = get_theme_mod( 'swc_archive_sorting' );
	    if ( $archive_sorting ) {
	        $custom .= ".woocommerce .woocommerce-ordering {display:none;}"."\n";
	    } 
	}

	//Page wrapper padding
	$pw_top_padding = get_theme_mod( 'wrapper_top_padding', '83' );
	$pw_bottom_padding = get_theme_mod( 'wrapper_bottom_padding', '100' );
	$custom .= ".page-wrap { padding-top:" . intval($pw_top_padding) . "px;}"."\n";	
	$custom .= ".page-wrap { padding-bottom:" . intval($pw_bottom_padding) . "px;}"."\n";	    

    $text_slide = get_theme_mod('textslider_slide', 0);
    if ( $text_slide ) {
		$custom .= ".slide-inner { display:none;}"."\n";	
		$custom .= ".slide-inner.text-slider-stopped { display:block;}"."\n";	
    }

    $mobile_slider = get_theme_mod('mobile_slider', 'responsive');
    if ( $mobile_slider == 'responsive' ) {
			$custom .= "@media only screen and (max-width: 1025px) {		
			.mobile-slide {
				display: block;
			}
			.slide-item {
				background-image: none !important;
			}
			.header-slider {
			}
			.slide-item {
				height: auto !important;
			}
			.slide-inner {
				min-height: initial;
			} 
		}"."\n";     	
    }

/* GET RID OF ALL CUSTOM */
$custom = '';

	//Output all the styles
	wp_add_inline_style( 'sydney-style', $custom );	
}
add_action( 'wp_enqueue_scripts', 'sydney_custom_styles' );