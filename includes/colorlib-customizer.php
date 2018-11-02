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
				'panel'    => 'colorlib_coming_soon_general_panel',
				'priority' => 5,
			)
		);

		/* Section - Coming Soon - Templates */
		$wp_customize->add_section( 'colorlib_coming_soon_section_templates', array(
				'title'    => esc_html__( 'Templates', 'colorlib-coming-soon' ),
				'panel'    => 'colorlib_coming_soon_general_panel',
				'priority' => 10,
				'type'     => 'outer'
			)
		);

		/* Section - Coming Soon - Site Logo */
		$wp_customize->add_section( 'colorlib_coming_soon_section_logo', array(
				'title'    => esc_html__( 'Site Logo', 'colorlib-coming-soon' ),
				'panel'    => 'colorlib_coming_soon_general_panel',
				'priority' => 20,
			)
		);

		/* Section - Coming Soon - Mailchimp */
		$wp_customize->add_section( 'colorlib_coming_soon_mailchimp_key', array(
				'title'    => esc_html__( 'MailChimp Form', 'colorlib-coming-soon' ),
				'panel'    => 'colorlib_coming_soon_general_panel',
				'priority' => 40,
			)
		);

		/* Section - Coming Soon - Social Links */
		$wp_customize->add_section( 'colorlib_coming_soon_section_social_settings', array(
				'title'    => esc_html__( 'Social Links', 'colorlib-coming-soon' ),
				'panel'    => 'colorlib_coming_soon_general_panel',
				'priority' => 50,
			)
		);

		/* Section - Coming Soon - Timer  */
		$wp_customize->add_section( 'colorlib_coming_soon_timer_settings', array(
				'title'    => esc_html__( 'Chose timer settings', 'colorlib-coming-soon' ),
				'panel'    => 'colorlib_coming_soon_general_panel',
				'priority' => 60,
			)
		);

		/* Section - Coming Soon - Custom CSS */
		$wp_customize->add_section( 'colorlib_coming_soon_custom_css_settings', array(
				'title'     => esc_html__( 'Add custom CSS', 'colorlib-coming-soon' ),
				'panel'     => 'colorlib_coming_soon_general_panel',
				'priority'  => 70,
				'code_type' => 'text/css',
			)
		);

	}

	public function colorlib_coming_soon_customizer( $wp_customize ) {

		require_once( CSMM_PATH . 'includes/colorlib-custom-controls.php' );

		/* Setting - Coming Soon - General */
		$wp_customize->add_setting( 'colorlib_coming_soon_preview', array(
			'default'           => '1',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( new Colorlib_CSMM_Control_Toggle ( $wp_customize, 'colorlib_coming_soon_preview', array(
				'label'       => esc_html__( 'Preview Coming Soon Page?', 'colorlib-coming-soon' ),
				'description' => esc_html__( 'Refresh this page page after saving in order to see the change.  This is used to preview your coming soon page in the theme customizer.', 'colorlib-coming-soon' ),
				'section'     => 'colorlib_coming_soon_section_general',
				'type'        => 'checkbox',
				'priority'    => 10,
			) )
		);


		/* Setting - Coming Soon - General */
		$wp_customize->add_setting( 'colorlib_coming_soon_page_custom_css', array(
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( new WP_Customize_Code_Editor_Control ( $wp_customize, 'colorlib_coming_soon_page_custom_css', array(
				'label'       => esc_html__( 'Custom CSS on Coming Soon Page', 'colorlib-coming-soon' ),
				'section'     => 'colorlib_coming_soon_custom_css_settings',
				'code_type'   => 'text/css',
				'priority'    => 20,
				'input_attrs' => array(
					'aria-describedby' => 'editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4',
				),
			) )
		);


		/* Setting - Coming Soon - Templates Selection */
		$wp_customize->add_setting( 'colorlib_coming_soon_template_selection', array(
			'default'           => 'template_01',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );

		$wp_customize->add_control( new Colorlib_Template_Selection( $wp_customize, 'colorlib_coming_soon_template_selection', array(
				'label'    => esc_html__( 'Select Template', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_templates',
				'priority' => 30,
				'choices'  => array(
					'template_01' => esc_html__( 'Template 1', 'colorlib-coming-soon' ),
					'template_02' => esc_html__( 'Template 2', 'colorlib-coming-soon' ),
					'template_03' => esc_html__( 'Template 3', 'colorlib-coming-soon' ),
					'template_04' => esc_html__( 'Template 4', 'colorlib-coming-soon' ),
					'template_05' => esc_html__( 'Template 5', 'colorlib-coming-soon' ),
					'template_06' => esc_html__( 'Template 6', 'colorlib-coming-soon' ),
					'template_07' => esc_html__( 'Template 7', 'colorlib-coming-soon' ),
					'template_08' => esc_html__( 'Template 8', 'colorlib-coming-soon' ),
					'template_09' => esc_html__( 'Template 9', 'colorlib-coming-soon' ),
					'template_10' => esc_html__( 'Template 10', 'colorlib-coming-soon' ),
					'template_11' => esc_html__( 'Template 11', 'colorlib-coming-soon' ),
					'template_12' => esc_html__( 'Template 12', 'colorlib-coming-soon' ),
					'template_13' => esc_html__( 'Template 13', 'colorlib-coming-soon' ),
					'template_14' => esc_html__( 'Template 14', 'colorlib-coming-soon' ),
					'template_15' => esc_html__( 'Template 15', 'colorlib-coming-soon' ),
				),
			)
		) );

		/*Settings - General - Timer*/
		$wp_customize->add_setting( 'colorlib_coming_soon_timer_option', array(
			'default'           => date( 'Y-m-d H:i:s', strtotime( '+1 month' ) ),
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );

		$wp_customize->add_control( new WP_Customize_Date_Time_Control( $wp_customize, 'colorlib_coming_soon_timer_option', array(
			'label'    => esc_html__( 'Time to opening', 'colorlib-coming-soon' ),
			'section'  => 'colorlib_coming_soon_timer_settings',
			'priority' => 10,
		) ) );


		/* Setting - General - Site Logo */
		$wp_customize->add_setting( 'colorlib_coming_soon_plugin_logo', array(
			'default'           => CSMM_URL . 'assets/images/logo.png',
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
		$wp_customize->add_setting( 'colorlib_coming_soon_page_heading', array(
			'default'           => 'Something <strong>really good</strong> is coming <strong>very soon</strong>',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( new Colorlib_Control_Text_Editor( $wp_customize, 'colorlib_coming_soon_page_heading', array(
				'label'    => esc_html__( 'Heading', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_page_settings',
				'type'     => 'epsilon-text-editor',
				'priority' => 20,
			) )
		);


		/* Setting - Coming Soon - Page Content */
		$wp_customize->add_setting( 'colorlib_coming_soon_page_content', array(
			'default'           => 'If you have something new you’re looking to launch, you’re going to want to start building a community of people interested in what you’re launching.',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( new Colorlib_Control_Text_Editor( $wp_customize, 'colorlib_coming_soon_page_content', array(
				'label'    => esc_html__( 'Main Content', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_page_settings',
				'type'     => 'epsilon-text-editor',
				'priority' => 30,
			) )
		);


		/* Setting - Coming Soon - Page Content */
		$wp_customize->add_setting( 'colorlib_coming_soon_page_footer', array(
			'default'           => 'And don\'t worry, we hate spam too! You can unsubscribe at any time.',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( new Colorlib_Control_Text_Editor( $wp_customize, 'colorlib_coming_soon_page_footer', array(
				'label'    => esc_html__( 'Footer Text', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_page_settings',
				'type'     => 'epsilon-text-editor',
				'priority' => 40,
			) )
		);


		/* Setting - Coming Soon - Page Content */
		$wp_customize->add_setting( 'colorlib_coming_soon_mailchimp_form', array(
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( new Colorlib_CSMM_Control_Toggle( $wp_customize, 'colorlib_coming_soon_mailchimp_form', array(
				'label'    => esc_html__( 'Disable MailChimp Form', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_mailchimp_key',
				'type'     => 'checkbox',
				'priority' => 10,
			) )
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
		$wp_customize->add_setting( 'colorlib_coming_soon_social_facebook', array(
			'default'           => 'https://www.facebook.com/',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_social_facebook', array(
				'label'    => esc_html__( 'Facebook', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_social_settings',
				'type'     => 'text',
				'priority' => 10,
			)
		);


		/* Setting - Coming Soon - Social Links */
		$wp_customize->add_setting( 'colorlib_coming_soon_social_twitter', array(
			'default'           => 'https://www.twitter.com/',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_social_twitter', array(
				'label'    => esc_html__( 'Twitter', 'colorlib-coming-soon' ),
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

		/* Setting - Coming Soon - Social Links */
		$wp_customize->add_setting( 'colorlib_coming_soon_social_youtube', array(
			'default'           => 'https://youtube.com/',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_social_youtube', array(
				'label'    => esc_html__( 'Youtube', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_social_settings',
				'type'     => 'text',
				'priority' => 40,
			)
		);

		/* Setting - Coming Soon - Social Links */
		$wp_customize->add_setting( 'colorlib_coming_soon_social_pinterest', array(
			'default'           => 'https://pinterest.com/',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_social_pinterest', array(
				'label'    => esc_html__( 'Pinterest', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_social_settings',
				'type'     => 'text',
				'priority' => 50,
			)
		);

		/* Setting - Coming Soon - Social Links */
		$wp_customize->add_setting( 'colorlib_coming_soon_social_instagram', array(
			'default'           => 'https://instagram.com/',
			'sanitize_callback' => 'colorlib_coming_soon_sanitize_text',
		) );
		$wp_customize->add_control( 'colorlib_coming_soon_social_instagram', array(
				'label'    => esc_html__( 'Instagram', 'colorlib-coming-soon' ),
				'section'  => 'colorlib_coming_soon_section_social_settings',
				'type'     => 'text',
				'priority' => 60,
			)
		);
	}
}

$cl = new Colorlib_CSMM();

function colorlib_coming_soon_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

