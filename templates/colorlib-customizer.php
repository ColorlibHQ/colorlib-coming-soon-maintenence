<?php
/* Colorlib Coming Soon Customizer Options */


class Colorlib_CSMM {

	public function __construct() {

		add_action( 'customize_register', array( $this, 'colorlib_coming_soon_customizer' ) );
		add_action( 'customize_register', array( $this, 'colorlib_comin_soon_panels' ) );

	}


	public function colorlib_comin_soon_panels( $wp_customize ) {

		$wp_customize->add_panel( 'colorlib_coming_soon_general_panel', array(
				'priority' => 1,
				'title'    => esc_html__( 'Colorlib Coming Soon Settings', 'colorlib-coming-soon' ),
			)
		);

		/* Section - Coming Soon - General */
		$wp_customize->add_section( 'colorlib_coming_soon_section_general', array(
				'title'    => esc_html__( 'General', 'colorlib-coming-soon' ),
				'panel'    => 'colorlib_coming_soon_general_panel', // Not typically needed.
				'priority' => 5,
			)
		);

		/* Section - Coming Soon - Background */
		$wp_customize->add_section( 'colorlib_coming_soon_section_templates', array(
				'title'    => esc_html__( 'Templates', 'colorlib-coming-soon' ),
				'panel'    => 'colorlib_coming_soon_general_panel', // Not typically needed.
				'priority' => 10,
			)
		);

		/* Section - Coming Soon - Site Logo */
		$wp_customize->add_section( 'colorlib_coming_soon_section_logo', array(
				'title'    => esc_html__( 'Site Logo', 'colorlib-coming-soon' ),
				'panel'    => 'colorlib_coming_soon_general_panel', // Not typically needed.
				'priority' => 20,
			)
		);

		/* Section - Coming Soon - Social Links */
		$wp_customize->add_section( 'colorlib_coming_soon_mailchimp_key', array(
				'title'    => esc_html__( 'MailChimp Form', 'colorlib-coming-soon' ),
				'panel'    => 'colorlib_coming_soon_general_panel', // Not typically needed.
				'priority' => 40,
			)
		);

		/* Section - Coming Soon - Social Links */
		$wp_customize->add_section( 'colorlib_coming_soon_section_social_settings', array(
				'title'    => esc_html__( 'Social Links', 'colorlib-coming-soon' ),
				'panel'    => 'colorlib_coming_soon_general_panel', // Not typically needed.
				'priority' => 50,
			)
		);

		/* Section - Coming Soon - Timer  */
		$wp_customize->add_section( 'colorlib_coming_soon_timer_settings', array(
				'title'    => esc_html__( 'Chose timer settings', 'colorlib-coming-soon' ),
				'panel'    => 'colorlib_coming_soon_general_panel', // Not typically needed.
				'priority' => 60,
			)
		);

		/* Section - Coming Soon - Social Links */
		$wp_customize->add_section( 'colorlib_coming_soon_custom_css_settings', array(
				'title'    => esc_html__( 'Add custom CSS', 'colorlib-coming-soon' ),
				'panel'    => 'colorlib_coming_soon_general_panel', // Not typically needed.
				'priority' => 70,
			)
		);

	}

	public function colorlib_coming_soon_customizer( $wp_customize ) {


		/* Setting - Coming Soon - General */
		$wp_customize->add_setting( 'colorlib_coming_soon_preview', array(
			'default'           => '1',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_preview', array(
				'label'       => esc_html__( 'Preview Coming Soon Page?', 'colorlib-coming-soon' ),
				'description' => esc_html__( 'Refresh this page page after saving in order to see the change.  This is used to preview your coming soon page in the theme customizer.', 'colorlib-coming-soon' ),
				'section'     => 'colorlib_coming_soon_section_general',
				'type'        => 'checkbox',
				'priority'    => 10,
			)
		);


		/* Setting - Coming Soon - General */
		$wp_customize->add_setting( 'colorlib_coming_soon_page_custom_css', array(
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_page_custom_css', array(
				'label'    => esc_html__( 'Custom CSS on Coming Soon Page', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_custom_css_settings',
				'type'     => 'textarea',
				'priority' => 20,
			)
		);


		/* Setting - Coming Soon - Templates Selection */
		$wp_customize->add_setting( 'colorlib_coming_soon_template_selection', array(
			'default'           => 'template_01',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );

		$wp_customize->add_control( 'colorlib_coming_soon_template_selection', array(
				'label'    => esc_html__( 'Select Template', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_templates',
				'type'     => 'select',
				'priority' => 30,
				'choices'  => array(
					'template_01' => esc_html__('Template 1','colorlib-coming-soon'),
					'template_02' => esc_html__('Template 2','colorlib-coming-soon'),
					'template_03' => esc_html__('Template 3','colorlib-coming-soon'),
					'template_04' => esc_html__('Template 4','colorlib-coming-soon'),
					'template_05' => esc_html__('Template 5','colorlib-coming-soon'),
					'template_06' => esc_html__('Template 6','colorlib-coming-soon'),
					'template_07' => esc_html__('Template 7','colorlib-coming-soon'),
					'template_08' => esc_html__('Template 8','colorlib-coming-soon'),
					'template_09' => esc_html__('Template 9','colorlib-coming-soon'),
					'template_10' => esc_html__('Template 10','colorlib-coming-soon'),
					'template_11' => esc_html__('Template 11','colorlib-coming-soon'),
					'template_12' => esc_html__('Template 12','colorlib-coming-soon'),
					'template_13' => esc_html__('Template 13','colorlib-coming-soon'),
					'template_14' => esc_html__('Template 14','colorlib-coming-soon'),
					'template_15' => esc_html__('Template 15','colorlib-coming-soon'),
					'template_16' => esc_html__('Template 16','colorlib-coming-soon'),
					'template_17' => esc_html__('Template 17','colorlib-coming-soon'),
					'template_18' => esc_html__('Template 18','colorlib-coming-soon'),
					'template_19' => esc_html__('Template 19','colorlib-coming-soon'),
					'template_20' => esc_html__('Template 20','colorlib-coming-soon'),
					'template_21' => esc_html__('Template 21','colorlib-coming-soon'),
					'template_22' => esc_html__('Template 22','colorlib-coming-soon'),
					'template_23' => esc_html__('Template 23','colorlib-coming-soon'),
				),
			)
		);

		/*Settings - General - Timer*/
		$wp_customize->add_setting( 'colorlib_coming_soon_timer_option', array(
			'default'           => date( 'Y-m-d', strtotime( '+1 month' ) ),
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );

		$wp_customize->add_control( 'colorlib_coming_soon_timer_option', array(
			'label'    => esc_html__( 'Time to opening', 'colorlib-coming-soon' ),
			'section'  => 'colorlib_coming_soon_timer_settings',
			'type'     => 'date',
			'priority' => 10,
		) );

		/* Setting - General - Background */
		$wp_customize->add_setting( 'colorlib_coming_soon_background_image', array(
			'default'           => plugin_dir_url( __FILE__ ) . '../assets/images/bg.jpg',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'colorlib_coming_soon_background_image', array(
				'label'    => esc_html__( 'Background Image', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_background',
				'priority' => 20,
			) )
		);

		/* Setting - Coming Soon - Background */
		$wp_customize->add_setting( 'colorlib_coming_soon_background_repeat', array(
			'default'           => 'no-repeat',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_background_repeat', array(
				'label'    => esc_html__( 'Background Repeat', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_background',
				'type'     => 'radio',
				'priority' => 30,
				'choices'  => array(
					'no-repeat'  => esc_html__( 'No repeat', 'colorlib-coming-soon' ),
					'repeat-all' => esc_html__( 'Tile', 'colorlib-coming-soon' ),
					'repeat-x'   => esc_html__( 'Tile Horizontally', 'colorlib-coming-soon' ),
					'repeat-y'   => esc_html__( 'Tile Vertically', 'colorlib-coming-soon' ),

				),

			)
		);

		/* Setting - Coming Soon - Background */
		$wp_customize->add_setting( 'colorlib_coming_soon_background_position', array(
			'default'           => 'center',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_background_position', array(
				'label'    => esc_html__( 'Background Position', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_background',
				'type'     => 'radio',
				'priority' => 40,
				'choices'  => array(
					'left'   => esc_html__( 'Left', 'colorlib-coming-soon' ),
					'center' => esc_html__( 'Center', 'colorlib-coming-soon' ),
					'right'  => esc_html__( 'Right', 'colorlib-coming-soon' ),

				),

			)
		);

		/* Setting - Coming Soon - Background */
		$wp_customize->add_setting( 'colorlib_coming_soon_background_cover', array(
			'default'           => 'cover',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_background_cover', array(
				'label'    => esc_html__( 'Background Cover', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_background',
				'type'     => 'radio',
				'priority' => 50,
				'choices'  => array(
					'cover' => esc_html__( 'Cover', 'colorlib-coming-soon' ),
					'auto'  => esc_html__( 'Auto', 'colorlib-coming-soon' ),

				),

			)
		);

		/* Setting - General - Site Logo */
		$wp_customize->add_setting( 'colorlib_coming_soon_plugin_logo', array(
			'default'           => plugin_dir_url( __FILE__ ) . '../assets/images/logo.png',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'colorlib_coming_soon_plugin_logo', array(
				'label'       => esc_html__( 'Logo Image', 'colorlib-coming-soon' ),
				'description' => esc_html__( 'Recommended size: 80px by 80px', 'colorlib-coming-soon' ),
				'section'     => 'colorlib_coming_soon_section_logo',
				'priority'    => 10,
			) )
		);


		/* Section - Coming Soon - Page Content */
		$wp_customize->add_section( 'colorlib_coming_soon_section_page_settings', array(
				'title'    => esc_html__( 'Page Content', 'colorlib-coming-soon' ),
				'panel'    => 'colorlib_coming_soon_general_panel', // Not typically needed.
				'priority' => 30,
			)
		);

		/* Setting - Coming Soon - Page Content */
		$wp_customize->add_setting( 'colorlib_coming_soon_percentage_completed', array(
			'default'           => '75',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_percentage_completed', array(
				'label'    => esc_html__( 'Percentage Completed', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_page_settings',
				'type'     => 'text',
				'priority' => 10,
			)
		);

		/* Setting - Coming Soon - Page Content */
		$wp_customize->add_setting( 'colorlib_coming_soon_page_heading', array(
			'default'           => '<h1>Something <strong>really good</strong> is coming <strong>very soon</strong>.</h1>',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_page_heading', array(
				'label'    => esc_html__( 'Heading', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_page_settings',
				'type'     => 'textarea',
				'priority' => 20,
			)
		);


		/* Setting - Coming Soon - Page Content */
		$wp_customize->add_setting( 'colorlib_coming_soon_page_content', array(
			'default'           => 'If you have something new you’re looking to launch, you’re going to want to start building a community of people interested in what you’re launching. The Launch template by is the best way to do just that.',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_page_content', array(
				'label'    => esc_html__( 'Main Content', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_page_settings',
				'type'     => 'textarea',
				'priority' => 30,
			)
		);


		/* Setting - Coming Soon - Page Content */
		$wp_customize->add_setting( 'colorlib_coming_soon_page_footer', array(
			'default'           => 'Designed by <a href="http://www.leeflets.com" rel="nofollow" target="_blank">Jason Schuller</a> & Developed by <a href="http://www.wpkube.com/" rel="nofollow" target="_blank">WP Kube</a>',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_page_footer', array(
				'label'    => esc_html__( 'Footer Text', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_page_settings',
				'type'     => 'textarea',
				'priority' => 40,
			)
		);


		/* Setting - Coming Soon - Page Content */
		$wp_customize->add_setting( 'colorlib_coming_soon_mailchimp_form', array(
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_mailchimp_form', array(
				'label'    => esc_html__( 'Disable MailChimp Form', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_mailchimp_key',
				'type'     => 'checkbox',
				'priority' => 10,
			)
		);


		/* Setting - Coming Soon - Page Content */
		$wp_customize->add_setting( 'colorlib_coming_soon_mailchimp_form_url', array(
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_mailchimp_form_url', array(
				'label'       => esc_html__( 'MailChimp Form Action URL', 'colorlib-coming-soon' ),
				'description' => __( 'You can get your form action URL by creating a sign-up form and copying the form action="" field.: <a href="http://kb.mailchimp.com/lists/signup-forms/add-a-signup-form-to-your-website" target="_blank">http://kb.mailchimp.com/lists/signup-forms/add-a-signup-form-to-your-website</a>', 'colorlib-coming-soon' ),
				'section'     => 'colorlib_coming_soon_mailchimp_key',
				'type'        => 'text',
				'priority'    => 10,
			)
		);


		/* Setting - Coming Soon - Social Links */
		$wp_customize->add_setting( 'colorlib_coming_soon_social_twitter', array(
			'default'           => 'https://www.twitter.com/circathemes',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_social_twitter', array(
				'label'    => esc_html__( 'Twitter', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_social_settings',
				'type'     => 'text',
				'priority' => 10,
			)
		);


		/* Setting - Coming Soon - Social Links */
		$wp_customize->add_setting( 'colorlib_coming_soon_social_facebook', array(
			'default'           => 'https://www.facebook.com/circathemes',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_social_facebook', array(
				'label'    => esc_html__( 'Facebook', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_social_settings',
				'type'     => 'text',
				'priority' => 20,
			)
		);


		/* Setting - Coming Soon - Social Links */
		$wp_customize->add_setting( 'colorlib_coming_soon_social_email', array(
			'default'           => 'you@domain.com',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_social_email', array(
				'label'    => esc_html__( 'Email', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_social_settings',
				'type'     => 'text',
				'priority' => 30,
			)
		);

	}
}

$cl = new Colorlib_CSMM();

function colorlib_coming_soon_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}
