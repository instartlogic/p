<?php
/**
 * Sydney Theme Customizer
 *
 * @package Sydney
 */

function sydney_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->remove_control( 'header_textcolor' );
    $wp_customize->remove_control( 'display_header_text' );
    $wp_customize->get_section( 'header_image' )->panel = 'sydney_header_panel';
    $wp_customize->get_section( 'header_image' )->priority = '13';
    $wp_customize->get_section( 'title_tagline' )->priority = '9';
    $wp_customize->get_section( 'title_tagline' )->title = __('Site title/tagline/logo', 'sydney');
    $wp_customize->get_section( 'colors' )->title = __('General', 'sydney');
    $wp_customize->get_section( 'colors' )->panel = 'sydney_colors_panel';
    $wp_customize->get_section( 'colors' )->priority = '10';
    
    //Divider
    class Sydney_Divider extends WP_Customize_Control {
         public function render_content() {
            echo '<hr style="margin: 15px 0;border-top: 1px dashed #919191;" />';
         }
    }
    //Titles
    class Sydney_Info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() {
        ?>
            <h3 style="margin-top:30px;border:1px solid;padding:5px;color:#58719E;text-transform:uppercase;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    }    

    //___General___//
    $wp_customize->add_section(
        'sydney_general',
        array(
            'title' => __('General', 'sydney'),
            'priority' => 8,
        )
    );
    //Favicon Upload
    $wp_customize->add_setting(
        'site_favicon',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_favicon',
            array(
               'label'          => __( 'Upload your favicon', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_general',
               'settings'       => 'site_favicon',
               'priority'       => 10,
            )
        )
    );
    //Top padding
    $wp_customize->add_setting(
        'wrapper_top_padding',
        array(
            'default' => __('83','sydney'),
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'wrapper_top_padding',
        array(
            'label'         => __( 'Page wrapper - top padding', 'sydney' ),
            'section'       => 'sydney_general',
            'type'          => 'number',
            'description'   => __('Top padding for the page wrapper (the space between the header and the page title)', 'sydney'),       
            'priority'      => 10,
            'input_attrs' => array(
                'min'   => 0,
                'max'   => 160,
                'step'  => 1,
            ),            
        )
    );
    //Bottom padding
    $wp_customize->add_setting(
        'wrapper_bottom_padding',
        array(
            'default' => __('100','sydney'),
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'wrapper_bottom_padding',
        array(
            'label'         => __( 'Page wrapper - bottom padding', 'sydney' ),
            'section'       => 'sydney_general',
            'type'          => 'number',
            'description'   => __('Bottom padding for the page wrapper (the space between the page content and the footer)', 'sydney'),       
            'priority'      => 10,
            'input_attrs' => array(
                'min'   => 0,
                'max'   => 160,
                'step'  => 1,
            ),            
        )
    );    
    //___Header area___//
    $wp_customize->add_panel( 'sydney_header_panel', array(
        'priority'       => 10,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Header area', 'sydney'),
    ) );
    //___Header type___//
    $wp_customize->add_section(
        'sydney_header_type',
        array(
            'title'         => __('Header type', 'sydney'),
            'priority'      => 10,
            'panel'         => 'sydney_header_panel', 
            'description'   => __('You can select your header type from here. After that, continue below to the next two tabs (Header Slider and Header Image) and configure them.', 'sydney'),
        )
    );

    if ( ( get_theme_mod('site_header_type') == 'video' ) || ( get_theme_mod('front_header_type') == 'video' ) ) {
        $choices =  array(
                'crelly'    => __('Crelly Slider', 'sydney'),
                'slider'    => __('Full screen slider', 'sydney'),
                'image'     => __('Image', 'sydney'),
                'video'     => __('Video[deprecated - please use the video option below]', 'sydney'),               
                'core-video'=> __('Video', 'sydney'),
                'shortcode' => __('Shortcode', 'sydney'),
                'nothing'   => __('No header (only menu)', 'sydney')
            );
    } else {
        $choices =  array(
                'crelly'    => __('Crelly Slider', 'sydney'),
                'slider'    => __('Full screen slider', 'sydney'),
                'image'     => __('Image', 'sydney'),
                'core-video'=> __('Video', 'sydney'),
                'shortcode' => __('Shortcode', 'sydney'),
                'nothing'   => __('No header (only menu)', 'sydney')
            );
    }

    //Front page
    $wp_customize->add_setting(
        'front_header_type',
        array(
            'default'           => 'slider',
            'sanitize_callback' => 'sydney_sanitize_layout',
        )
    );
    $wp_customize->add_control(
        'front_header_type',
        array(
            'type'        => 'radio',
            'label'       => __('Front page header type', 'sydney'),
            'section'     => 'sydney_header_type',
            'description' => __('Select the header type for your front page', 'sydney'),
            'choices' => $choices,
        )
    );
    //Site
    $wp_customize->add_setting(
        'site_header_type',
        array(
            'default'           => 'image',
            'sanitize_callback' => 'sydney_sanitize_layout',
        )
    );
    $wp_customize->add_control(
        'site_header_type',
        array(
            'type'        => 'radio',
            'label'       => __('Site header type', 'sydney'),
            'section'     => 'sydney_header_type',
            'description' => __('Select the header type for all pages except the front page', 'sydney'),
            'choices' => $choices,
        )
    );
    //___Shortcode___//
    $wp_customize->add_section(
        'sydney_shortcode',
        array(
            'title'         => __('Shortcode', 'sydney'),
            'description' => __( 'You can add any kind of shortcode you want. Ideally, you\'ll add a shortcode for a slider plugin. Please keep in mind that you also need to go to <strong>Header Type</strong> and select the <strong>Shortcode</strong> mode.', 'sydney'),
            'priority'      => 11,
            'panel'         => 'sydney_header_panel',
        )
    );
    //Alias
    $wp_customize->add_setting(
        'header_shortcode',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'header_shortcode',
        array(
            'label'     => __( 'Add your shortcode here', 'sydney' ),
            'section'   => 'sydney_shortcode',
            'type'      => 'text',
            'priority'  => 11
        )
    ); 

    //___Crelly Slider___//
    $wp_customize->add_section(
        'sydney_rev',
        array(
            'title'         => __('Crelly Slider', 'sydney'),
            'description'   => __('Make sure you have installed Crelly Slider when prompted by the theme if you plan to use it. Go to the <strong>Header Type</strong> tab to choose where to display Crelly Slider', 'sydney'),
            'priority'      => 11,
            'panel'         => 'sydney_header_panel',
        )
    );
    //Alias
    $wp_customize->add_setting(
        'rev_alias',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'rev_alias',
        array(
            'label'     => __( 'Add the alias for the slider you created in Crelly Slider', 'sydney' ),
            'section'   => 'sydney_rev',
            'type'      => 'text',
            'priority'  => 11
        )
    );  

    //___Slider___//
    $wp_customize->add_section(
        'sydney_slider',
        array(
            'title'         => __('Header Slider', 'sydney'),
            'description'   => __('You can add up to 5 images in the slider. Make sure you select where to display your slider from the Header Type section found above. You can also add a Call to action button (scroll down to find the options)', 'sydney'),
            'priority'      => 11,
            'panel'         => 'sydney_header_panel',
        )
    );

    //Mobile slider
    $wp_customize->add_setting(
        'mobile_slider',
        array(
            'default'           => 'responsive',
            'sanitize_callback' => 'sydney_sanitize_mslider',
        )
    );
    $wp_customize->add_control(
        'mobile_slider',
        array(
            'type'        => 'radio',
            'label'       => __('Slider mobile behavior', 'sydney'),
            'section'     => 'sydney_slider',
            'priority'    => 99,
            'choices' => array(
                'fullscreen'    => __('Full screen', 'sydney'),
                'responsive'    => __('Responsive', 'sydney'),
            ),
        )
    );

    //Speed
    $wp_customize->add_setting(
        'slider_speed',
        array(
            'default' => __('4000','sydney'),
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'slider_speed',
        array(
            'label' => __( 'Slider speed', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'number',
            'description'   => __('Slider speed in miliseconds. Use 0 to disable [default: 4000]', 'sydney'),       
            'priority' => 7
        )
    );      
    $wp_customize->add_setting(
        'textslider_slide',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'textslider_slide',
        array(
            'type'      => 'checkbox',
            'label'     => __('Stop the text slider?', 'sydney'),
            'section'   => 'sydney_slider',
            'priority'  => 9,
        )
    );    
    //Image 1
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 's1', array(
        'label' => __('First slide', 'sydney'),
        'section' => 'sydney_slider',
        'settings' => 'sydney_options[info]',
        'priority' => 10
        ) )
    );    
    $wp_customize->add_setting(
        'slider_image_1',
        array(
            'default' => get_template_directory_uri() . '/images/1.jpg',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_1',
            array(
               'label'          => __( 'Upload your first image for the slider', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_slider',
               'settings'       => 'slider_image_1',
               'priority'       => 11,
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'slider_title_1',
        array(
            'default' => __('Welcome to Sydney','sydney'),
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'slider_title_1',
        array(
            'label' => __( 'Title for the first slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 12
        )
    );
    //Subtitle
    $wp_customize->add_setting(
        'slider_subtitle_1',
        array(
            'default' => __('Feel free to look around','sydney'),
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'slider_subtitle_1',
        array(
            'label' => __( 'Subtitle for the first slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 13
        )
    );           
    //Image 2
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 's2', array(
        'label' => __('Second slide', 'sydney'),
        'section' => 'sydney_slider',
        'settings' => 'sydney_options[info]',
        'priority' => 14
        ) )
    );    
    $wp_customize->add_setting(
        'slider_image_2',
        array(
            'default' => get_template_directory_uri() . '/images/2.jpg',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_2',
            array(
               'label'          => __( 'Upload your second image for the slider', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_slider',
               'settings'       => 'slider_image_2',
               'priority'       => 15,
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'slider_title_2',
        array(
            'default' => __('Ready to begin your journey?','sydney'),
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'slider_title_2',
        array(
            'label' => __( 'Title for the second slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 16
        )
    );
    //Subtitle
    $wp_customize->add_setting(
        'slider_subtitle_2',
        array(
            'default' => __('Click the button below','sydney'),
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'slider_subtitle_2',
        array(
            'label' => __( 'Subtitle for the second slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 17
        )
    );    
    //Image 3
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 's3', array(
        'label' => __('Third slide', 'sydney'),
        'section' => 'sydney_slider',
        'settings' => 'sydney_options[info]',
        'priority' => 18
        ) )
    );    
    $wp_customize->add_setting(
        'slider_image_3',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_3',
            array(
               'label'          => __( 'Upload your third image for the slider', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_slider',
               'settings'       => 'slider_image_3',
               'priority'       => 19,
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'slider_title_3',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'slider_title_3',
        array(
            'label' => __( 'Title for the third slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 20
        )
    );
    //Subtitle
    $wp_customize->add_setting(
        'slider_subtitle_3',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'slider_subtitle_3',
        array(
            'label' => __( 'Subtitle for the third slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 21
        )
    );            
    //Image 4
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 's4', array(
        'label' => __('Fourth slide', 'sydney'),
        'section' => 'sydney_slider',
        'settings' => 'sydney_options[info]',
        'priority' => 22
        ) )
    );    
    $wp_customize->add_setting(
        'slider_image_4',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_4',
            array(
               'label'          => __( 'Upload your fourth image for the slider', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_slider',
               'settings'       => 'slider_image_4',
               'priority'       => 23,
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'slider_title_4',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'slider_title_4',
        array(
            'label' => __( 'Title for the fourth slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 24
        )
    );
    //Subtitle
    $wp_customize->add_setting(
        'slider_subtitle_4',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'slider_subtitle_4',
        array(
            'label' => __( 'Subtitle for the fourth slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 25
        )
    );    
    //Image 5
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 's5', array(
        'label' => __('Fifth slide', 'sydney'),
        'section' => 'sydney_slider',
        'settings' => 'sydney_options[info]',
        'priority' => 26
        ) )
    );    
    $wp_customize->add_setting(
        'slider_image_5',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'slider_image_5',
            array(
               'label'          => __( 'Upload your fifth image for the slider', 'sydney' ),
               'type'           => 'image',
               'section'        => 'sydney_slider',
               'settings'       => 'slider_image_5',
               'priority'       => 27,
            )
        )
    );
    //Title
    $wp_customize->add_setting(
        'slider_title_5',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'slider_title_5',
        array(
            'label' => __( 'Title for the fifth slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 28
        )
    );
    //Subtitle
    $wp_customize->add_setting(
        'slider_subtitle_5',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'slider_subtitle_5',
        array(
            'label' => __( 'Subtitle for the fifth slide', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 29
        )
    );
    //Header button
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'hbutton', array(
        'label' => __('Call to action button', 'sydney'),
        'section' => 'sydney_slider',
        'settings' => 'sydney_options[info]',
        'priority' => 30
        ) )
    );     
    $wp_customize->add_setting(
        'slider_button_url',
        array(
            'default' => '#primary',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        'slider_button_url',
        array(
            'label' => __( 'URL for your call to action button', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 31
        )
    );
    $wp_customize->add_setting(
        'slider_button_text',
        array(
            'default' => __('Click to begin','sydney'),
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'slider_button_text',
        array(
            'label' => __( 'Text for your call to action button', 'sydney' ),
            'section' => 'sydney_slider',
            'type' => 'text',
            'priority' => 32
        )
    );     

    if ( ( get_theme_mod('site_header_type') == 'video' ) || ( get_theme_mod('front_header_type') == 'video' ) ) {
    //Remove custom video header section if it's not in use already
        //___Video___//
        $wp_customize->add_section(
            'sydney_video',
            array(
                'title'         => __('Video', 'sydney'),
                'description'   => __('Add your video links here and then go above to Header Type to enable your video in the header. Having your video in all the types requested below assures a higher browser compatibility.', 'sydney'),
                'priority'      => 13,
                'panel'         => 'sydney_header_panel',
            )
        );
        $wp_customize->add_setting(
            'video_mp4',
            array(
                'default' => '',
                'sanitize_callback' => 'sydney_sanitize_text',
            )
        );
        $wp_customize->add_control(
            'video_mp4',
            array(
                'label'     => __( 'MP4 video link', 'sydney' ),
                'section'   => 'sydney_video',
                'type'      => 'text',
                'priority'  => 10
            )
        );
        $wp_customize->add_setting(
            'video_webm',
            array(
                'default' => '',
                'sanitize_callback' => 'sydney_sanitize_text',
            )
        );
        $wp_customize->add_control(
            'video_webm',
            array(
                'label'     => __( 'WEBM video link', 'sydney' ),
                'section'   => 'sydney_video',
                'type'      => 'text',
                'priority'  => 10
            )
        );
        $wp_customize->add_setting(
            'video_ogv',
            array(
                'default' => '',
                'sanitize_callback' => 'sydney_sanitize_text',
            )
        );
        $wp_customize->add_control(
            'video_ogv',
            array(
                'label'     => __( 'OGV video link', 'sydney' ),
                'section'   => 'sydney_video',
                'type'      => 'text',
                'priority'  => 10
            )
        );
        $wp_customize->add_setting(
            'video_poster',
            array(
                'default-image' => '',
                'sanitize_callback' => 'esc_url_raw',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'video_poster',
                array(
                   'label'          => __( 'Poster for your video', 'sydney' ),
                   'type'           => 'image',
                   'section'        => 'sydney_video',
                   'priority'       => 10,
                )
            )
        );

    }

    //___Menu style___//
    $wp_customize->add_section(
        'sydney_menu_style',
        array(
            'title'         => __('Menu style', 'sydney'),
            'priority'      => 15,
            'panel'         => 'sydney_header_panel', 
        )
    );
    //Sticky menu
    $wp_customize->add_setting(
        'sticky_menu',
        array(
            'default'           => 'sticky',
            'sanitize_callback' => 'sydney_sanitize_sticky',
        )
    );
    $wp_customize->add_control(
        'sticky_menu',
        array(
            'type' => 'radio',
            'priority'    => 10,
            'label' => __('Sticky menu', 'sydney'),
            'section' => 'sydney_menu_style',
            'choices' => array(
                'sticky'   => __('Sticky', 'sydney'),
                'static'   => __('Static', 'sydney'),
            ),
        )
    );
    //Menu style
    $wp_customize->add_setting(
        'menu_style',
        array(
            'default'           => 'inline',
            'sanitize_callback' => 'sydney_sanitize_menu_style',
        )
    );
    $wp_customize->add_control(
        'menu_style',
        array(
            'type'      => 'radio',
            'priority'  => 11,
            'label'     => __('Menu style', 'sydney'),
            'section'   => 'sydney_menu_style',
            'choices'   => array(
                'inline'     => __('Inline', 'sydney'),
                'centered'   => __('Centered (menu and site logo)', 'sydney'),
            ),
        )
    );
    //Header image size
    $wp_customize->add_setting(
        'header_bg_size',
        array(
            'default'           => 'cover',
            'sanitize_callback' => 'sydney_sanitize_bg_size',
        )
    );
    $wp_customize->add_control(
        'header_bg_size',
        array(
            'type' => 'radio',
            'priority'    => 10,
            'label' => __('Header background size', 'sydney'),
            'section' => 'header_image',
            'choices' => array(
                'cover'     => __('Cover', 'sydney'),
                'contain'   => __('Contain', 'sydney'),
            ),
        )
    );
    //Header height
    $wp_customize->add_setting(
        'header_height',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '300',
        )       
    );
    $wp_customize->add_control( 'header_height', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'header_image',
        'label'       => __('Header height [default: 300px]', 'sydney'),
        'input_attrs' => array(
            'min'   => 250,
            'max'   => 600,
            'step'  => 5,
        ),
    ) );
    //Disable overlay
    $wp_customize->add_setting(
        'hide_overlay',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'hide_overlay',
        array(
            'type'      => 'checkbox',
            'label'     => __('Disable the overlay?', 'sydney'),
            'section'   => 'header_image',
            'priority'  => 12,
        )
    );      
    //Logo Upload
    $wp_customize->add_setting(
        'site_logo',
        array(
            'default-image' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'site_logo',
            array(
               'label'          => __( 'Upload your logo', 'sydney' ),
               'type'           => 'image',
               'section'        => 'title_tagline',
               'priority'       => 12,
            )
        )
    );
    //___Blog options___//
    $wp_customize->add_section(
        'blog_options',
        array(
            'title' => __('Blog options', 'sydney'),
            'priority' => 13,
        )
    );  
    // Blog layout
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'layout', array(
        'label' => __('Layout', 'sydney'),
        'section' => 'blog_options',
        'settings' => 'sydney_options[info]',
        'priority' => 10
        ) )
    );    
    $wp_customize->add_setting(
        'blog_layout',
        array(
            'default'           => 'classic',
            'sanitize_callback' => 'sydney_sanitize_blog',
        )
    );
    $wp_customize->add_control(
        'blog_layout',
        array(
            'type'      => 'radio',
            'label'     => __('Blog layout', 'sydney'),
            'section'   => 'blog_options',
            'priority'  => 11,
            'choices'   => array(
                'classic'           => __( 'Classic', 'sydney' ),
                'fullwidth'         => __( 'Full width (no sidebar)', 'sydney' ),
                'masonry-layout'    => __( 'Masonry (grid style)', 'sydney' )
            ),
        )
    ); 
    //Full width singles
    $wp_customize->add_setting(
        'fullwidth_single',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'fullwidth_single',
        array(
            'type'      => 'checkbox',
            'label'     => __('Full width single posts?', 'sydney'),
            'section'   => 'blog_options',
            'priority'  => 12,
        )
    );
    //Content/excerpt
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'content', array(
        'label' => __('Content/excerpt', 'sydney'),
        'section' => 'blog_options',
        'settings' => 'sydney_options[info]',
        'priority' => 13
        ) )
    );          
    //Full content posts
    $wp_customize->add_setting(
      'full_content_home',
      array(
        'sanitize_callback' => 'sydney_sanitize_checkbox',
        'default' => 0,     
      )   
    );
    $wp_customize->add_control(
        'full_content_home',
        array(
            'type' => 'checkbox',
            'label' => __('Check this box to display the full content of your posts on the home page.', 'sydney'),
            'section' => 'blog_options',
            'priority' => 14,
        )
    );
    $wp_customize->add_setting(
      'full_content_archives',
      array(
        'sanitize_callback' => 'sydney_sanitize_checkbox',
        'default' => 0,     
      )   
    );
    $wp_customize->add_control(
        'full_content_archives',
        array(
            'type' => 'checkbox',
            'label' => __('Check this box to display the full content of your posts on all archives.', 'sydney'),
            'section' => 'blog_options',
            'priority' => 15,
        )
    );    
    //Excerpt
    $wp_customize->add_setting(
        'exc_lenght',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '55',
        )       
    );
    $wp_customize->add_control( 'exc_lenght', array(
        'type'        => 'number',
        'priority'    => 16,
        'section'     => 'blog_options',
        'label'       => __('Excerpt lenght', 'sydney'),
        'description' => __('Choose your excerpt length. Default: 55 words', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 200,
            'step'  => 5,
        ),
    ) );
    //Meta
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'meta', array(
        'label' => __('Meta', 'sydney'),
        'section' => 'blog_options',
        'settings' => 'sydney_options[info]',
        'priority' => 17
        ) )
    ); 
    //Hide meta index
    $wp_customize->add_setting(
      'hide_meta_index',
      array(
        'sanitize_callback' => 'sydney_sanitize_checkbox',
        'default' => 0,     
      )   
    );
    $wp_customize->add_control(
      'hide_meta_index',
      array(
        'type' => 'checkbox',
        'label' => __('Hide post meta on index, archives?', 'sydney'),
        'section' => 'blog_options',
        'priority' => 18,
      )
    );
    //Hide meta single
    $wp_customize->add_setting(
      'hide_meta_single',
      array(
        'sanitize_callback' => 'sydney_sanitize_checkbox',
        'default' => 0,     
      )   
    );
    $wp_customize->add_control(
      'hide_meta_single',
      array(
        'type' => 'checkbox',
        'label' => __('Hide post meta on singles?', 'sydney'),
        'section' => 'blog_options',
        'priority' => 19,
      )
    );
    //Featured images
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'images', array(
        'label' => __('Featured images', 'sydney'),
        'section' => 'blog_options',
        'settings' => 'sydney_options[info]',
        'priority' => 21
        ) )
    );     
    //Index images
    $wp_customize->add_setting(
        'index_feat_image',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'index_feat_image',
        array(
            'type' => 'checkbox',
            'label' => __('Check this box to hide featured images on index, archives etc.', 'sydney'),
            'section' => 'blog_options',
            'priority' => 22,
        )
    );
    //Post images
    $wp_customize->add_setting(
        'post_feat_image',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'post_feat_image',
        array(
            'type' => 'checkbox',
            'label' => __('Check this box to hide featured images on single posts', 'sydney'),
            'section' => 'blog_options',
            'priority' => 23,
        )
    );

    //___Footer___//
    $wp_customize->add_section(
        'sydney_footer',
        array(
            'title'         => __('Footer', 'sydney'),
            'priority'      => 18,
        )
    );
    //Front page
    $wp_customize->add_setting(
        'footer_widget_areas',
        array(
            'default'           => '3',
            'sanitize_callback' => 'sydney_sanitize_fw',
        )
    );
    $wp_customize->add_control(
        'footer_widget_areas',
        array(
            'type'        => 'radio',
            'label'       => __('Footer widget area', 'sydney'),
            'section'     => 'sydney_footer',
            'description' => __('Select the number of widget areas you want in the footer. After that, go to Appearance > Widgets and add your widgets.', 'sydney'),
            'choices' => array(
                '1'     => __('One', 'sydney'),
                '2'     => __('Two', 'sydney'),
                '3'     => __('Three', 'sydney'),
                '4'     => __('Four', 'sydney')
            ),
        )
    );



    //___Fonts___//
    $wp_customize->add_section(
        'sydney_fonts',
        array(
            'title' => __('Fonts', 'sydney'),
            'priority' => 15,
            'description' => __('Google Fonts can be found here: google.com/fonts. See the documentation if you need help in selecting Google Fonts: athemes.com/documentation/sydney', 'sydney'),
        )
    );
    //Body fonts title
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'body_fonts', array(
        'label' => __('Body fonts', 'sydney'),
        'section' => 'sydney_fonts',
        'settings' => 'sydney_options[info]',
        'priority' => 10
        ) )
    );    


    //Body fonts
    $wp_customize->add_setting(
        'body_font_name',
        array(
            'default' => 'Source+Sans+Pro:400,400italic,600',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'body_font_name',
        array(
            'label' => __( 'Font name/style/sets', 'sydney' ),
            'section' => 'sydney_fonts',
            'type' => 'text',
            'priority' => 11
        )
    );
    //Body fonts family
    $wp_customize->add_setting(
        'body_font_family',
        array(
            'default' => '\'Source Sans Pro\', sans-serif',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'body_font_family',
        array(
            'label' => __( 'Font family', 'sydney' ),
            'section' => 'sydney_fonts',
            'type' => 'text',
            'priority' => 12
        )
    );
    //Headings fonts title
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'headings_fonts', array(
        'label' => __('Headings fonts', 'sydney'),
        'section' => 'sydney_fonts',
        'settings' => 'sydney_options[info]',
        'priority' => 13
        ) )
    );      
    //Headings fonts
    $wp_customize->add_setting(
        'headings_font_name',
        array(
            'default' => 'Raleway:400,500,600',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'headings_font_name',
        array(
            'label' => __( 'Font name/style/sets', 'sydney' ),
            'section' => 'sydney_fonts',
            'type' => 'text',
            'priority' => 14
        )
    );
    //Headings fonts family
    $wp_customize->add_setting(
        'headings_font_family',
        array(
            'default' => '\'Raleway\', sans-serif',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'headings_font_family',
        array(
            'label' => __( 'Font family', 'sydney' ),
            'section' => 'sydney_fonts',
            'type' => 'text',
            'priority' => 15
        )
    );
    //Font sizes title
    $wp_customize->add_setting('sydney_options[info]', array(
            'type'              => 'info_control',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'esc_attr',            
        )
    );
    $wp_customize->add_control( new Sydney_Info( $wp_customize, 'font_sizes', array(
        'label' => __('Font sizes', 'sydney'),
        'section' => 'sydney_fonts',
        'settings' => 'sydney_options[info]',
        'priority' => 16
        ) )
    );
    // Site title
    $wp_customize->add_setting(
        'site_title_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '32',
        )       
    );
    $wp_customize->add_control( 'site_title_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'sydney_fonts',
        'label'       => __('Site title', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 90,
            'step'  => 1,
        ),
    ) ); 
    // Site description
    $wp_customize->add_setting(
        'site_desc_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '16',
        )       
    );
    $wp_customize->add_control( 'site_desc_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'sydney_fonts',
        'label'       => __('Site description', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 50,
            'step'  => 1,
        ),
    ) );  
    // Nav menu
    $wp_customize->add_setting(
        'menu_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '14',
        )       
    );
    $wp_customize->add_control( 'menu_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'sydney_fonts',
        'label'       => __('Menu items', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 50,
            'step'  => 1,
        ),
    ) );           
    //H1 size
    $wp_customize->add_setting(
        'h1_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '52',
        )       
    );
    $wp_customize->add_control( 'h1_size', array(
        'type'        => 'number',
        'priority'    => 17,
        'section'     => 'sydney_fonts',
        'label'       => __('H1 font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H2 size
    $wp_customize->add_setting(
        'h2_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '42',
        )       
    );
    $wp_customize->add_control( 'h2_size', array(
        'type'        => 'number',
        'priority'    => 18,
        'section'     => 'sydney_fonts',
        'label'       => __('H2 font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H3 size
    $wp_customize->add_setting(
        'h3_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '32',
        )       
    );
    $wp_customize->add_control( 'h3_size', array(
        'type'        => 'number',
        'priority'    => 19,
        'section'     => 'sydney_fonts',
        'label'       => __('H3 font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H4 size
    $wp_customize->add_setting(
        'h4_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '25',
        )       
    );
    $wp_customize->add_control( 'h4_size', array(
        'type'        => 'number',
        'priority'    => 20,
        'section'     => 'sydney_fonts',
        'label'       => __('H4 font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H5 size
    $wp_customize->add_setting(
        'h5_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '20',
        )       
    );
    $wp_customize->add_control( 'h5_size', array(
        'type'        => 'number',
        'priority'    => 21,
        'section'     => 'sydney_fonts',
        'label'       => __('H5 font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //H6 size
    $wp_customize->add_setting(
        'h6_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '18',
        )       
    );
    $wp_customize->add_control( 'h6_size', array(
        'type'        => 'number',
        'priority'    => 22,
        'section'     => 'sydney_fonts',
        'label'       => __('H6 font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 60,
            'step'  => 1,
        ),
    ) );
    //Body
    $wp_customize->add_setting(
        'body_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '14',
        )       
    );
    $wp_customize->add_control( 'body_size', array(
        'type'        => 'number',
        'priority'    => 23,
        'section'     => 'sydney_fonts',
        'label'       => __('Body font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 24,
            'step'  => 1,
        ),
    ) );

    //___Colors___//
    $wp_customize->add_panel( 'sydney_colors_panel', array(
        'priority'       => 19,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Colors', 'sydney'),
    ) );
    $wp_customize->add_section(
        'colors_header',
        array(
            'title'         => __('Header', 'sydney'),
            'priority'      => 11,
            'panel'         => 'sydney_colors_panel',
        )
    );
    $wp_customize->add_section(
        'colors_sidebar',
        array(
            'title'         => __('Sidebar', 'sydney'),
            'priority'      => 12,
            'panel'         => 'sydney_colors_panel',
        )
    );
    $wp_customize->add_section(
        'colors_footer',
        array(
            'title'         => __('Footer', 'sydney'),
            'priority'      => 13,
            'panel'         => 'sydney_colors_panel',
        )
    );    
    $wp_customize->add_setting(
        'primary_color',
        array(
            'default'           => '#d65050',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            array(
                'label'         => __('Primary color', 'sydney'),
                'section'       => 'colors',
                'settings'      => 'primary_color',
                'priority'      => 11
            )
        )
    );
    //Menu bg
    $wp_customize->add_setting(
        'menu_bg_color',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_bg_color',
            array(
                'label' => __('Menu background', 'sydney'),
                'section' => 'colors_header',
                'priority' => 12
            )
        )
    );     
    //Site title
    $wp_customize->add_setting(
        'site_title_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_title_color',
            array(
                'label' => __('Site title', 'sydney'),
                'section' => 'colors_header',
                'settings' => 'site_title_color',
                'priority' => 13
            )
        )
    );
    //Site desc
    $wp_customize->add_setting(
        'site_desc_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'site_desc_color',
            array(
                'label' => __('Site description', 'sydney'),
                'section' => 'colors_header',
                'priority' => 14
            )
        )
    );
    //Top level menu items
    $wp_customize->add_setting(
        'top_items_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'top_items_color',
            array(
                'label' => __('Top level menu items', 'sydney'),
                'section' => 'colors_header',
                'priority' => 15
            )
        )
    );
    //Menu items hover
    $wp_customize->add_setting(
        'menu_items_hover',
        array(
            'default'           => '#d65050',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'menu_items_hover',
            array(
                'label' => __('Menu items hover', 'sydney'),
                'section' => 'colors_header',
                'priority' => 15
            )
        )
    );    
    //Sub menu items color
    $wp_customize->add_setting(
        'submenu_items_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'submenu_items_color',
            array(
                'label' => __('Sub-menu items', 'sydney'),
                'section' => 'colors_header',
                'priority' => 16
            )
        )
    );
    //Sub menu background
    $wp_customize->add_setting(
        'submenu_background',
        array(
            'default'           => '#1c1c1c',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'submenu_background',
            array(
                'label' => __('Sub-menu background', 'sydney'),
                'section' => 'colors_header',
                'priority' => 17
            )
        )
    );
    //Mobile menu
    $wp_customize->add_setting(
        'mobile_menu_color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'mobile_menu_color',
            array(
                'label' => __('Mobile menu button', 'sydney'),
                'section' => 'colors_header',
                'priority' => 17
            )
        )
    );     
    //Slider text
    $wp_customize->add_setting(
        'slider_text',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'slider_text',
            array(
                'label' => __('Header slider text', 'sydney'),
                'section' => 'colors_header',
                'priority' => 18
            )
        )
    );
    //Body
    $wp_customize->add_setting(
        'body_text_color',
        array(
	     'default'          =>  '#767676',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'body_text_color',
            array(
                'label' => __('Body text', 'sydney'),
                'section' => 'colors',
                'priority' => 19
            )
        )
    );    
    //Sidebar backgound
    $wp_customize->add_setting(
        'sidebar_background',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sidebar_background',
            array(
                'label' => __('Sidebar background', 'sydney'),
                'section' => 'colors_sidebar',
                'priority' => 20
            )
        )
    );
    //Sidebar color
    $wp_customize->add_setting(
        'sidebar_color',
        array(
            'default'           => '#767676',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'sidebar_color',
            array(
                'label' => __('Sidebar color', 'sydney'),
                'section' => 'colors_sidebar',
                'priority' => 21
            )
        )
    );
    //Footer widget area
    $wp_customize->add_setting(
        'footer_widgets_background',
        array(
            'default'           => '#252525',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_widgets_background',
            array(
                'label' => __('Footer widget area background', 'sydney'),
                'section' => 'colors_footer',
                'priority' => 22
            )
        )
    );
    //Footer widget color
    $wp_customize->add_setting(
        'footer_widgets_color',
        array(
            'default'           => '#767676',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_widgets_color',
            array(
                'label' => __('Footer widget area color', 'sydney'),
                'section' => 'colors_footer',
                'priority' => 23
            )
        )
    );
    //Footer background
    $wp_customize->add_setting(
        'footer_background',
        array(
            'default'           => '#1c1c1c',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_background',
            array(
                'label' => __('Footer background', 'sydney'),
                'section' => 'colors_footer',
                'priority' => 24
            )
        )
    );
    //Footer color
    $wp_customize->add_setting(
        'footer_color',
        array(
            'default'           => '#666666',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage'
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'footer_color',
            array(
                'label' => __('Footer color', 'sydney'),
                'section' => 'colors_footer',
                'priority' => 25
            )
        )
    );
    //Rows overlay
    $wp_customize->add_setting(
        'rows_overlay',
        array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'rows_overlay',
            array(
                'label'         => __('Rows overlay', 'sydney'),
                'section'       => 'colors',
                'description'   => __('[DEPRECATED] Please use the color option from Edit Row > Design > Overlay color', 'sydney'),
                'priority'      => 26
            )
        )
    );

    //___Pro options___//
    $wp_customize->add_panel( 'sydney_pro_panel', array(
        'priority'       => 20,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '',
        'title'          => __('Extra options', 'sydney'),
    ) );
    //___Footer___//
    $wp_customize->add_section(
        'sydney_footer_credits',
        array(
            'title'     => __('Footer credits', 'sydney'),
            'priority'  => 10,
            'panel'     => 'sydney_pro_panel',
        )
    );
    $wp_customize->add_setting(
        'footer_credits',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'footer_credits',
        array(
            'label' => __( 'Add your own credits for the footer [HTML allowed]', 'sydney' ),
            'section' => 'sydney_footer_credits',
            'type' => 'text',
            'priority' => 10
        )
    );
    //Italicize
    $wp_customize->add_setting(
        'footer_center',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'footer_center',
        array(
            'type'      => 'checkbox',
            'label'     => __('Center the footer credits?', 'sydney'),
            'section'   => 'sydney_footer_credits',
            'priority'  => 11,
        )
    );

    //___Front page section titles___//
    $wp_customize->add_section(
        'sydney_fp_titles',
        array(
            'title'     => __('Front page section titles', 'sydney'),
            'priority'  => 11,
            'panel'     => 'sydney_pro_panel',
        )
    );
    //Margin
    $wp_customize->add_setting(
        'section_title_margin',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '50',
        )       
    );
    $wp_customize->add_control( 'section_title_margin', array(
        'type'        => 'number',
        'priority'    => 10,
        'section'     => 'sydney_fp_titles',
        'label'       => __('Title bottom margin', 'sydney'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 150,
            'step'  => 5,
        ),
    ) );
    //Transform
    $wp_customize->add_setting(
        'section_title_transform',
        array(
            'default'           => 'uppercase',
            'sanitize_callback' => 'sydney_sanitize_transform',
        )
    );
    $wp_customize->add_control(
        'section_title_transform',
        array(
            'type'        => 'radio',
            'label'       => __('Title text transform', 'sydney'),
            'section'     => 'sydney_fp_titles',
            'priority'    => 11,
            'choices' => array(
                'uppercase'=> __('Uppercase', 'sydney'),
                'none'     => __('None', 'sydney'),
            ),
        )
    );
    //Italicize
    $wp_customize->add_setting(
        'section_title_italicize',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'section_title_italicize',
        array(
            'type'      => 'checkbox',
            'label'     => __('Italicize titles?', 'sydney'),
            'section'   => 'sydney_fp_titles',
            'priority'  => 12,
        )
    );    
    //Align
    $wp_customize->add_setting(
        'section_title_style',
        array(
            'default'           => 'default',
            'sanitize_callback' => 'sydney_sanitize_tstyle',
        )
    );
    $wp_customize->add_control(
        'section_title_style',
        array(
            'type'        => 'radio',
            'label'       => __('Title style', 'sydney'),
            'section'     => 'sydney_fp_titles',
            'priority'    => 13,
            'choices' => array(
                'default'    => __('Default', 'sydney'),
                'bordered'   => __('Bordered', 'sydney'),
                'solid'      => __('Solid', 'sydney'),
            ),
        )
    );         




    //___Single employees___//
    $wp_customize->add_section(
        'sydney_single_employees',
        array(
            'title'     => __('Single employees', 'sydney'),
            'priority'  => 12,
            'panel'     => 'sydney_pro_panel',
        )
    );
    //Full width singles
    $wp_customize->add_setting(
        'fullwidth_employee',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'fullwidth_employee',
        array(
            'type'      => 'checkbox',
            'label'     => __('Full width single employees?', 'sydney'),
            'section'   => 'sydney_single_employees',
            'priority'  => 10,
        )
    );
    //Emp images
    $wp_customize->add_setting(
        'employee_feat_image',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'employee_feat_image',
        array(
            'type' => 'checkbox',
            'label' => __('Check this box to hide featured images on single employees', 'sydney'),
            'section' => 'sydney_single_employees',
            'priority' => 11,
        )
    );
    //Employee single nav
    $wp_customize->add_setting(
        'employee_nav',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'employee_nav',
        array(
            'type' => 'checkbox',
            'label' => __('Check this box to hide the employee navigation', 'sydney'),
            'section' => 'sydney_single_employees',
            'priority' => 12,
        )
    );
    //___Single projects___//
    $wp_customize->add_section(
        'sydney_single_projects',
        array(
            'title'     => __('Single projects', 'sydney'),
            'priority'  => 13,
            'panel'     => 'sydney_pro_panel',
        )
    );
    //Full width singles
    $wp_customize->add_setting(
        'fullwidth_project',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'fullwidth_project',
        array(
            'type'      => 'checkbox',
            'label'     => __('Full width single projects?', 'sydney'),
            'section'   => 'sydney_single_projects',
            'priority'  => 10,
        )
    );
    //Project images
    $wp_customize->add_setting(
        'project_feat_image',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'project_feat_image',
        array(
            'type' => 'checkbox',
            'label' => __('Display the project featured image as header image?', 'sydney'),
            'section' => 'sydney_single_projects',
            'priority' => 11,
        )
    );
    //Project single nav
    $wp_customize->add_setting(
        'project_nav',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'project_nav',
        array(
            'type' => 'checkbox',
            'label' => __('Check this box to hide the projects navigation', 'sydney'),
            'section' => 'sydney_single_projects',
            'priority' => 12,
        )
    );




    //___Top contact info___//
    $wp_customize->add_section(
        'sydney_contact_info',
        array(
            'title'     => __('Header contact info', 'sydney'),
            'priority'  => 14,
            'panel'     => 'sydney_pro_panel',
        )
    );
    //Activate contact
    $wp_customize->add_setting(
        'toggle_contact',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'toggle_contact',
        array(
            'type' => 'checkbox',
            'label' => __('Activate the header contact info?', 'sydney'),
            'section' => 'sydney_contact_info',
            'priority' => 10,
        )
    );
    //Phone
    $wp_customize->add_setting(
        'contact_phone',
        array(
            'default' => '99.123.456',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'contact_phone',
        array(
            'label' => __( 'Phone number', 'sydney' ),
            'section' => 'sydney_contact_info',
            'type' => 'text',
            'priority' => 11
        )
    );   
    //Email
    $wp_customize->add_setting(
        'contact_email',
        array(
            'default' => 'office@site.com',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'contact_email',
        array(
            'label' => __( 'Email address', 'sydney' ),
            'section' => 'sydney_contact_info',
            'type' => 'text',
            'priority' => 12
        )
    );
    //Address
    $wp_customize->add_setting(
        'contact_address',
        array(
            'default' => '12 Street, New York City',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'contact_address',
        array(
            'label' => __( 'Address', 'sydney' ),
            'section' => 'sydney_contact_info',
            'type' => 'text',
            'priority' => 13
        )
    );
    //Contact center
    $wp_customize->add_setting(
        'contact_center',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'contact_center',
        array(
            'type' => 'checkbox',
            'label' => __('Center the contact info?', 'sydney'),
            'section' => 'sydney_contact_info',
            'priority' => 14,
        )
    );
    //Contact background
    $wp_customize->add_setting(
        'contact_background',
        array(
            'default'           => '#1c1c1c',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'contact_background',
            array(
                'label'         => __('Contact background', 'sydney'),
                'section'       => 'sydney_contact_info',
                'priority'      => 15
            )
        )
    );
    //Contact color
    $wp_customize->add_setting(
        'contact_color',
        array(
            'default'           => '#c5c5c5',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'contact_color',
            array(
                'label'         => __('Contact color', 'sydney'),
                'section'       => 'sydney_contact_info',
                'priority'      => 15
            )
        )
    );

    //___Buttons___//
    $wp_customize->add_section(
        'sydney_buttons',
        array(
            'title'     => __('Buttons', 'sydney'),
            'priority'  => 15,
            'panel'     => 'sydney_pro_panel',
            'description' => __('By default, buttons in Sydney are bordered or solid depending on where they are used. From below you can control them all at once.', 'sydney'),
        )
    );
    //Type
    $wp_customize->add_setting(
        'buttons_type',
        array(
            'default'           => 'default',
            'sanitize_callback' => 'sydney_sanitize_buttons',
        )
    );
    $wp_customize->add_control(
        'buttons_type',
        array(
            'type'        => 'radio',
            'label'       => __('Buttons style', 'sydney'),
            'section'     => 'sydney_buttons',
            'priority'    => 10,
            'choices' => array(
                'default'               => __('Default', 'sydney'),
                'bordered'              => __('Bordered', 'sydney'),
                'bordered-left-fill'    => __('Bordered - left fill hover', 'sydney'),
                'bordered-top-fill'     => __('Bordered - top fill hover', 'sydney'),
                'bordered-center-fill'  => __('Bordered - center fill hover', 'sydney'),
                'solid'                 => __('Solid', 'sydney'),
            ),
        )
    );
    //Padding
    $wp_customize->add_setting(
        'buttons_tb_padding',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '12',
        )       
    );
    $wp_customize->add_control( 'buttons_tb_padding', array(
        'type'        => 'number',
        'priority'    => 11,
        'section'     => 'sydney_buttons',
        'label'       => __('Top/bottom button padding', 'sydney'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 40,
            'step'  => 1,
        ),
    ) );
    $wp_customize->add_setting(
        'buttons_lr_padding',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '35',
        )       
    );
    $wp_customize->add_control( 'buttons_lr_padding', array(
        'type'        => 'number',
        'priority'    => 12,
        'section'     => 'sydney_buttons',
        'label'       => __('Left/right button padding', 'sydney'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 50,
            'step'  => 1,
        ),
    ) );
    //Font size
    $wp_customize->add_setting(
        'buttons_font_size',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '13',
        )       
    );
    $wp_customize->add_control( 'buttons_font_size', array(
        'type'        => 'number',
        'priority'    => 12,
        'section'     => 'sydney_buttons',
        'label'       => __('Button font size', 'sydney'),
        'input_attrs' => array(
            'min'   => 10,
            'max'   => 40,
            'step'  => 1,
        ),
    ) ); 
    //Border radius
    $wp_customize->add_setting(
        'buttons_radius',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '3',
        )       
    );
    $wp_customize->add_control( 'buttons_radius', array(
        'type'        => 'number',
        'priority'    => 13,
        'section'     => 'sydney_buttons',
        'label'       => __('Button border radius', 'sydney'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 50,
            'step'  => 1,
        ),
    ) );
    //___Below header widget area___//
    $wp_customize->add_section(
        'sydney_extra_widget_area',
        array(
            'title'     => __('Extra widget area', 'sydney'),
            'priority'  => 15,
            'panel'     => 'sydney_pro_panel',
            'description' => __('Here you can activate an extra widget area displayed below the header. After you activate it you can go to Appearance > Widgets to add widgets to it.', 'sydney'),
        )
    );    
    //Activate
    $wp_customize->add_setting(
        'activate_bh_widgets',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'activate_bh_widgets',
        array(
            'type'      => 'checkbox',
            'label'     => __('Activate the extra widget area?', 'sydney'),
            'section'   => 'sydney_extra_widget_area',
            'priority'  => 10,
        )
    );
    //Hide front page
    $wp_customize->add_setting(
        'hide_bh_widgets',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'hide_bh_widgets',
        array(
            'type'      => 'checkbox',
            'label'     => __('Hide this widget area on the front page?', 'sydney'),
            'section'   => 'sydney_extra_widget_area',
            'priority'  => 11,
        )
    );
    //Center
    $wp_customize->add_setting(
        'center_bh_widgets',
        array(
            'sanitize_callback' => 'sydney_sanitize_checkbox',
        )       
    );
    $wp_customize->add_control(
        'center_bh_widgets',
        array(
            'type'      => 'checkbox',
            'label'     => __('Center the content? [may or may not work, depending on the widgets]', 'sydney'),
            'section'   => 'sydney_extra_widget_area',
            'priority'  => 11,
        )
    );
    //Background color
    $wp_customize->add_setting(
        'bg_bh_widgets',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'bg_bh_widgets',
            array(
                'label'         => __('Background color', 'sydney'),
                'section'       => 'sydney_extra_widget_area',
                'priority'      => 12
            )
        )
    );
    //Color
    $wp_customize->add_setting(
        'color_bh_widgets',
        array(
            'default'           => '#767676',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'color_bh_widgets',
            array(
                'label'         => __('Color', 'sydney'),
                'section'       => 'sydney_extra_widget_area',
                'priority'      => 13
            )
        )
    );
    //Maps API key
    $wp_customize->add_section(
        'sydney_pro_maps',
        array(
            'title'     => __('Google Maps', 'sydney'),
            'priority'  => 20,
            'panel'     => 'sydney_pro_panel'
        )
    );
    $wp_customize->add_setting(
        'sydney_pro_maps_api',
        array(
            'default' => '',
            'sanitize_callback' => 'sydney_sanitize_text',
        )
    );
    $wp_customize->add_control(
        'sydney_pro_maps_api',
        array(
            'label' => __( 'Google Maps API key', 'sydney' ),
            'section' => 'sydney_pro_maps',
            'type' => 'text',
            'priority' => 10,
            'description' => __('You can obtain a free API key ', 'sydney') . '<a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">here</a>. You need to add your key in case you want to use the contact page template.'
        )
    );

}
add_action( 'customize_register', 'sydney_customize_register' );

/**
 * Sanitize
 */
//Header type
function sydney_sanitize_layout( $input ) {
    $valid = array(
        'crelly'    => __('Crelly Slider', 'sydney'),
        'slider'    => __('Full screen slider', 'sydney'),
        'image'     => __('Image', 'sydney'),
        'video'     => __('Video', 'sydney'),
        'core-video'=> __('Video', 'sydney'),
        'shortcode' => __('Shortcode', 'sydney'),        
        'nothing'   => __('No header (only menu)', 'sydney')
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Text
function sydney_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
//Background size
function sydney_sanitize_bg_size( $input ) {
    $valid = array(
        'cover'     => __('Cover', 'sydney'),
        'contain'   => __('Contain', 'sydney'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Footer widget areas
function sydney_sanitize_fw( $input ) {
    $valid = array(
        '1'     => __('One', 'sydney'),
        '2'     => __('Two', 'sydney'),
        '3'     => __('Three', 'sydney'),
        '4'     => __('Four', 'sydney')
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Sticky menu
function sydney_sanitize_sticky( $input ) {
    $valid = array(
        'sticky'     => __('Sticky', 'sydney'),
        'static'   => __('Static', 'sydney'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Blog Layout
function sydney_sanitize_blog( $input ) {
    $valid = array(
        'classic'    => __( 'Classic', 'sydney' ),
        'fullwidth'  => __( 'Full width (no sidebar)', 'sydney' ),
        'masonry-layout'    => __( 'Masonry (grid style)', 'sydney' )

    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Menu style
function sydney_sanitize_menu_style( $input ) {
    $valid = array(
        'inline'     => __('Inline', 'sydney'),
        'centered'   => __('Centered (menu and site logo)', 'sydney'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Titles transform
function sydney_sanitize_transform( $input ) {
    $valid = array(
        'uppercase'=> __('Uppercase', 'sydney'),
        'none'     => __('None', 'sydney'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Mobile slider
function sydney_sanitize_mslider( $input ) {
    $valid = array(
        'fullscreen'    => __('Full screen', 'sydney'),
        'responsive'    => __('Responsive', 'sydney'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Titles alignment
function sydney_sanitize_tstyle( $input ) {
    $valid = array(
        'default'    => __('Default', 'sydney'),
        'bordered'   => __('Bordered', 'sydney'),
        'solid'      => __('Solid', 'sydney'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Buttons
function sydney_sanitize_buttons( $input ) {
    $valid = array(
        'default'               => __('Default', 'sydney'),
        'bordered'              => __('Bordered', 'sydney'),
        'bordered-left-fill'    => __('Bordered - left fill hover', 'sydney'),
        'bordered-top-fill'     => __('Bordered - top fill hover', 'sydney'),
        'bordered-center-fill'  => __('Bordered - center fill hover', 'sydney'),
        'solid'                 => __('Solid', 'sydney'),
    );
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//Checkboxes
function sydney_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function sydney_customize_preview_js() {
	wp_enqueue_script( 'sydney_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'sydney_customize_preview_js' );
