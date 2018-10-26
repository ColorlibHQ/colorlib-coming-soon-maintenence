<?php
/* Colorlib Coming Soon Customizer Options */

 /* Theme Customizer Panel */
 function colorlib_coming_soon_customizer( $wp_customize ) {
 	$wp_customize->add_panel( 'colorlib_coming_soon_general_panel', array(
 		'priority'    => 1,
 		'title'       => esc_html__( 'Colorlib Coming Soon Settings', 'colorlib-coming-soon'),
 		 ) 
  	);
	
	
	
	
	/* Section - Coming Soon - General */
	$wp_customize->add_section( 'colorlib_coming_soon_section_general', array(
		'title'          => esc_html__( 'General', 'colorlib-coming-soon' ),
		'panel'          => 'colorlib_coming_soon_general_panel', // Not typically needed.
		'priority'       => 5,
		) 
	);
	
	
	/* Setting - Coming Soon - General */
	$wp_customize->add_setting( 'colorlib_coming_soon_preview' ,array(
		'default' => '1',
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( 'colorlib_coming_soon_preview', array(
		'label'          => esc_html__( 'Preview Coming Soon Page?', 'colorlib-coming-soon' ),
		'description'          => esc_html__( 'Refresh this page page after saving in order to see the change.  This is used to preview your coming soon page in the theme customizer.', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_section_general',
		'type' => 'checkbox',
		'priority'   => 10,
		)
	);
	
	
	/* Setting - Coming Soon - General */
	$wp_customize->add_setting( 'colorlib_coming_soon_page_custom_css' ,array(
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( 'colorlib_coming_soon_page_custom_css', array(
		'label'          => esc_html__( 'Custom CSS on Coming Soon Page', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_section_general',
		'type' => 'textarea',
		'priority'   => 20,
		)
	);
	
	
	

	
	/* Section - Coming Soon - Background */
	$wp_customize->add_section( 'colorlib_coming_soon_section_background', array(
		'title'          => esc_html__( 'Background', 'colorlib-coming-soon' ),
		'panel'          => 'colorlib_coming_soon_general_panel', // Not typically needed.
		'priority'       => 10,
		) 
	);
	
	/* Setting - Coming Soon - Background */
	$wp_customize->add_setting( 'colorlib_coming_soon_background_color', array(
		'default' => '#f5f5f5',
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'colorlib_coming_soon_background_color', array(
		'label'    => esc_html__( 'Background Color', 'colorlib-coming-soon' ),
		'section'  => 'colorlib_coming_soon_section_background',
		'priority'   => 10,
	) ) 
	);
	
	/* Setting - General - Background */
	$wp_customize->add_setting( 'colorlib_coming_soon_background_image' ,array(
		'default' => plugin_dir_url( __FILE__ ) .'../assets/images/bg.jpg',
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'colorlib_coming_soon_background_image', array(
		'label'    => esc_html__( 'Background Image', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_section_background',
		'priority'   => 20,
		))
	);
	
	/* Setting - Coming Soon - Background */
	$wp_customize->add_setting( 'colorlib_coming_soon_background_repeat' ,array(
		'default' =>  'no-repeat',
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( 'colorlib_coming_soon_background_repeat', array(
		'label'          => esc_html__( 'Background Repeat', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_section_background',
		'type' => 'radio',
		'priority'   => 30,
		'choices' => array(
	        'no-repeat' => esc_html__( 'No repeat', 'colorlib-coming-soon' ),
	        'repeat-all' => esc_html__( 'Tile', 'colorlib-coming-soon' ),
	        'repeat-x' => esc_html__( 'Tile Horizontally', 'colorlib-coming-soon' ),
	        'repeat-y' => esc_html__( 'Tile Vertically', 'colorlib-coming-soon' ),

		 ),
		 
		)
	);
	
	/* Setting - Coming Soon - Background */
	$wp_customize->add_setting( 'colorlib_coming_soon_background_position' ,array(
		'default' =>  'center',
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( 'colorlib_coming_soon_background_position', array(
		'label'          => esc_html__( 'Background Position', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_section_background',
		'type' => 'radio',
		'priority'   => 40,
		'choices' => array(
	        'left' => esc_html__( 'Left', 'colorlib-coming-soon' ),
	        'center' => esc_html__( 'Center', 'colorlib-coming-soon' ),
	        'right' => esc_html__( 'Right', 'colorlib-coming-soon' ),

		 ),
		 
		)
	);
	
	/* Setting - Coming Soon - Background */
	$wp_customize->add_setting( 'colorlib_coming_soon_background_cover' ,array(
		'default' =>  'cover',
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( 'colorlib_coming_soon_background_cover', array(
		'label'          => esc_html__( 'Background Cover', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_section_background',
		'type' => 'radio',
		'priority'   => 50,
		'choices' => array(
	        'cover' => esc_html__( 'Cover', 'colorlib-coming-soon' ),
	        'auto' => esc_html__( 'Auto', 'colorlib-coming-soon' ),

		 ),
		 
		)
	);
	

	
	
	
	
	
	
	
	
	
	
	
	/* Section - Coming Soon - Site Logo */
	$wp_customize->add_section( 'colorlib_coming_soon_section_logo', array(
		'title'          => esc_html__( 'Site Logo', 'colorlib-coming-soon' ),
		'panel'          => 'colorlib_coming_soon_general_panel', // Not typically needed.
		'priority'       => 20,
		) 
	);
	
	/* Setting - General - Site Logo */
	$wp_customize->add_setting( 'colorlib_coming_soon_plugin_logo' ,array(
		'default' => plugin_dir_url( __FILE__ ) .'../assets/images/logo.png',
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'colorlib_coming_soon_plugin_logo', array(
		'label'    => esc_html__( 'Logo Image', 'colorlib-coming-soon' ),
		'description'    => esc_html__( 'Recommended size: 80px by 80px', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_section_logo',
		'priority'   => 10,
		))
	);
	
	
	
	
	
	
	
	
	
	
	
	
	
	/* Section - Coming Soon - Page Content */
	$wp_customize->add_section( 'colorlib_coming_soon_section_page_settings', array(
		'title'          => esc_html__( 'Page Content', 'colorlib-coming-soon' ),
		'panel'          => 'colorlib_coming_soon_general_panel', // Not typically needed.
		'priority'       => 30,
		) 
	);
	
	/* Setting - Coming Soon - Page Content */
	$wp_customize->add_setting( 'colorlib_coming_soon_percentage_completed' ,array(
		'default' =>  '75',
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( 'colorlib_coming_soon_percentage_completed', array(
		'label'          => esc_html__( 'Percentage Completed', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_section_page_settings',
		'type' => 'text',
		'priority'   => 10,
		)
	);
	
	/* Setting - Coming Soon - Page Content */
	$wp_customize->add_setting( 'colorlib_coming_soon_page_heading' ,array(
		'default' =>  '<h1>Something <strong>really good</strong> is coming <strong>very soon</strong>.</h1>',
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( 'colorlib_coming_soon_page_heading', array(
		'label'          => esc_html__( 'Heading', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_section_page_settings',
		'type' => 'textarea',
		'priority'   => 20,
		)
	);
	
	
	/* Setting - Coming Soon - Page Content */
	$wp_customize->add_setting( 'colorlib_coming_soon_page_content' ,array(
		'default' =>  'If you have something new you’re looking to launch, you’re going to want to start building a community of people interested in what you’re launching. The Launch template by is the best way to do just that.',
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( 'colorlib_coming_soon_page_content', array(
		'label'          => esc_html__( 'Main Content', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_section_page_settings',
		'type' => 'textarea',
		'priority'   => 30,
		)
	);
	
	
	
	/* Setting - Coming Soon - Page Content */
	$wp_customize->add_setting( 'colorlib_coming_soon_page_footer' ,array(
		'default' =>  'Designed by <a href="http://www.leeflets.com" rel="nofollow" target="_blank">Jason Schuller</a> & Developed by <a href="http://www.wpkube.com/" rel="nofollow" target="_blank">WP Kube</a>',
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( 'colorlib_coming_soon_page_footer', array(
		'label'          => esc_html__( 'Footer Text', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_section_page_settings',
		'type' => 'textarea',
		'priority'   => 40,
		)
	);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/* Section - Coming Soon - Social Links */
	$wp_customize->add_section( 'colorlib_coming_soon_mailchimp_key', array(
		'title'          => esc_html__( 'MailChimp Form', 'colorlib-coming-soon' ),
		'panel'          => 'colorlib_coming_soon_general_panel', // Not typically needed.
		'priority'       => 40,
		) 
	);
	
	/* Setting - Coming Soon - Page Content */
	$wp_customize->add_setting( 'colorlib_coming_soon_mailchimp_form' ,array(
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( 'colorlib_coming_soon_mailchimp_form', array(
		'label'          => esc_html__( 'Disable MailChimp Form', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_mailchimp_key',
		'type' => 'checkbox',
		'priority'   => 10,
		)
	);
	
	
	/* Setting - Coming Soon - Page Content */
	$wp_customize->add_setting( 'colorlib_coming_soon_mailchimp_form_url' ,array(
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( 'colorlib_coming_soon_mailchimp_form_url', array(
		'label'          => esc_html__( 'MailChimp Form Action URL', 'colorlib-coming-soon' ),
		'description'	  => __( 'You can get your form action URL by creating a sign-up form and copying the form action="" field.: <a href="http://kb.mailchimp.com/lists/signup-forms/add-a-signup-form-to-your-website" target="_blank">http://kb.mailchimp.com/lists/signup-forms/add-a-signup-form-to-your-website</a>', 'colorlib-coming-soon'),
		'section' => 'colorlib_coming_soon_mailchimp_key',
		'type' => 'text',
		'priority'   => 10,
		)
	);
	
	
	/* Setting - Coming Soon - Page Content
	$wp_customize->add_setting( 'colorlib_coming_soon_embed_form' ,array(
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( 'colorlib_coming_soon_embed_form', array(
		'label'          => esc_html__( 'Optional Newsletter Embed Form', 'colorlib-coming-soon' ),
		'description'          => esc_html__( 'Add-in newsletter embed HTML into this box. This can be used for other third party newsletter forms like constant contact. ', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_mailchimp_key',
		'type' => 'textarea',
		'priority'   => 30,
		)
	);
	 */
	
	
	
	
	
	
	
	
	
	
	
	/* Section - Coming Soon - Social Links */
	$wp_customize->add_section( 'colorlib_coming_soon_section_social_settings', array(
		'title'          => esc_html__( 'Social Links', 'colorlib-coming-soon' ),
		'panel'          => 'colorlib_coming_soon_general_panel', // Not typically needed.
		'priority'       => 50,
		) 
	);
	
	/* Setting - Coming Soon - Social Links */
	$wp_customize->add_setting( 'colorlib_coming_soon_social_twitter' ,array(
		'default' =>  'https://www.twitter.com/circathemes',
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( 'colorlib_coming_soon_social_twitter', array(
		'label'          => esc_html__( 'Twitter', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_section_social_settings',
		'type' => 'text',
		'priority'   => 10,
		)
	);
	
	
	/* Setting - Coming Soon - Social Links */
	$wp_customize->add_setting( 'colorlib_coming_soon_social_facebook' ,array(
		'default' =>  'https://www.facebook.com/circathemes',
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( 'colorlib_coming_soon_social_facebook', array(
		'label'          => esc_html__( 'Facebook', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_section_social_settings',
		'type' => 'text',
		'priority'   => 20,
		)
	);
	
	
	/* Setting - Coming Soon - Social Links */
	$wp_customize->add_setting( 'colorlib_coming_soon_social_email' ,array(
		'default' =>  'you@domain.com',
		'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
	) );
	$wp_customize->add_control( 'colorlib_coming_soon_social_email', array(
		'label'          => esc_html__( 'Email', 'colorlib-coming-soon' ),
		'section' => 'colorlib_coming_soon_section_social_settings',
		'type' => 'text',
		'priority'   => 30,
		)
	);
	
	
	
	
	
	
	
 }
 
add_action( 'customize_register', 'colorlib_coming_soon_customizer' );

function colorlib_coming_soon_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
