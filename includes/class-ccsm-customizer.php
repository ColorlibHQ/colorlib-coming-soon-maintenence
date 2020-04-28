<?php
/* Colorlib Coming Soon Customizer Options */


class CCSM_Customizer {

	public function __construct() {

		add_action( 'customize_register', array( $this, 'ccsm_customizer_controls' ) );
		add_action( 'customize_register', array( $this, 'ccsm_panels_initialize' ) );
		add_action( 'admin_menu', array( $this, 'ccsm_add_menu_item' ) );
		add_action( 'admin_init', array( $this, 'ccsm_redirect_customizer' ) );
	}

	public function ccsm_panels_initialize( $wp_customize ) {

		require_once( CCSM_PATH . 'includes/controls/class-ccsm-template-section.php' );

		$wp_customize->add_panel( 'colorlib_coming_soon_general_panel', array(
				'priority' => 1,
				'title'    => esc_html__( 'Colorlib Coming Soon Settings', 'colorlib-coming-soon-maintenance' ),
			)
		);


		/* Section - Coming Soon - Templates */
		$wp_customize->add_section( new CCSM_Templates_Section( $wp_customize, 'colorlib_coming_soon_section_templates', array(
			'title'    => esc_html__( 'Templates', 'colorlib-coming-soon-maintenance' ),
			'panel'    => 'colorlib_coming_soon_general_panel',
			'priority' => 5,
		) ) );

		/* Section - Coming Soon - General */
		$wp_customize->add_section( 'colorlib_coming_soon_section_general', array(
				'title'    => esc_html__( 'General', 'colorlib-coming-soon-maintenance' ),
				'panel'    => 'colorlib_coming_soon_general_panel',
				'priority' => 10,
			)
		);


		/* Section - Coming Soon - Subscribe Form */
		$wp_customize->add_section( 'colorlib_coming_soon_subscribe_form', array(
				'title'    => esc_html__( 'Subscribe Form', 'colorlib-coming-soon-maintenance' ),
				'panel'    => 'colorlib_coming_soon_general_panel',
				'priority' => 30,
			)
		);

		/* Section - Coming Soon - Social Links */
		$wp_customize->add_section( 'colorlib_coming_soon_section_social_settings', array(
				'title'           => esc_html__( 'Social Links', 'colorlib-coming-soon-maintenance' ),
				'panel'           => 'colorlib_coming_soon_general_panel',
				'priority'        => 35,
				'active_callback' => 'ccsm_template_has_social'
			)
		);


		/* Section - Coming Soon - Custom CSS */
		$wp_customize->add_section( 'colorlib_coming_soon_custom_css_settings', array(
				'title'     => esc_html__( 'Custom CSS', 'colorlib-coming-soon-maintenance' ),
				'panel'     => 'colorlib_coming_soon_general_panel',
				'priority'  => 40,
				'code_type' => 'text/css',
			)
		);

	}


	public function ccsm_customizer_controls( $wp_customize ) {

		require_once( CCSM_PATH . 'includes/controls/class-ccsm-control-text-editor.php' );
		require_once( CCSM_PATH . 'includes/controls/class-ccsm-control-toggle.php' );
		require_once( CCSM_PATH . 'includes/controls/class-ccsm-template-selection.php' );
		

		/* Setting - Coming Soon - Activation */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_activation]', array(
			'default'           => '1',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option',
		) );

		$wp_customize->add_control( new CCSM_Control_Toggle ( $wp_customize, 'ccsm_settings[colorlib_coming_soon_activation]', array(
				'label'       => esc_html__( 'Activate Colorlib Coming Soon Page?', 'colorlib-coming-soon-maintenance' ),
				'section'     => 'colorlib_coming_soon_section_general',
				'priority'    => 10,
			) )
		);


		/* Setting - Coming Soon - Timer Activation */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_timer_activation]', array(
			'default'           => '1',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option',
		) );

		$wp_customize->add_control( new CCSM_Control_Toggle ( $wp_customize, 'ccsm_settings[colorlib_coming_soon_timer_activation]', array(
				'label'           => esc_html__( 'Activate Timer Countdown?', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_section_general',
				'priority'        => 10,
				'active_callback' => 'ccsm_template_has_timer'
			) )
		);


		/* Setting - Coming Soon - Custom CSS */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_page_custom_css]', array(
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option'
		) );

		$wp_customize->add_control( new WP_Customize_Code_Editor_Control ( $wp_customize, 'ccsm_settings[colorlib_coming_soon_page_custom_css]', array(
				'label'       => esc_html__( 'Custom CSS on Coming Soon Page', 'colorlib-coming-soon-maintenance' ),
				'section'     => 'colorlib_coming_soon_custom_css_settings',
				'code_type'   => 'text/css',
				'priority'    => 20,
				'input_attrs' => array(
					'aria-describedby' => 'editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4',
				),
			) )
		);


		/* Setting - Coming Soon - Templates Selection */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_template_selection]', array(
			'default'           => 'template_01',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option'
		) );

		$wp_customize->add_control( new CCSM_Template_Selection( $wp_customize, 'ccsm_settings[colorlib_coming_soon_template_selection]', array(
				'label'    => esc_html__( 'Select Template', 'colorlib-coming-soon-maintenance' ),
				'section'  => 'colorlib_coming_soon_section_templates',
				'priority' => 30,
				'choices'  => array(
					'template_01' => esc_html__( 'Template 1', 'colorlib-coming-soon-maintenance' ),
					'template_02' => esc_html__( 'Template 2', 'colorlib-coming-soon-maintenance' ),
					'template_03' => esc_html__( 'Template 3', 'colorlib-coming-soon-maintenance' ),
					'template_04' => esc_html__( 'Template 4', 'colorlib-coming-soon-maintenance' ),
					'template_05' => esc_html__( 'Template 5', 'colorlib-coming-soon-maintenance' ),
					'template_06' => esc_html__( 'Template 6', 'colorlib-coming-soon-maintenance' ),
					'template_07' => esc_html__( 'Template 7', 'colorlib-coming-soon-maintenance' ),
					'template_08' => esc_html__( 'Template 8', 'colorlib-coming-soon-maintenance' ),
					'template_09' => esc_html__( 'Template 9', 'colorlib-coming-soon-maintenance' ),
					'template_10' => esc_html__( 'Template 10', 'colorlib-coming-soon-maintenance' ),
					'template_11' => esc_html__( 'Template 11', 'colorlib-coming-soon-maintenance' ),
					'template_12' => esc_html__( 'Template 12', 'colorlib-coming-soon-maintenance' ),
					'template_13' => esc_html__( 'Template 13', 'colorlib-coming-soon-maintenance' ),
					'template_14' => esc_html__( 'Template 14', 'colorlib-coming-soon-maintenance' ),
					'template_15' => esc_html__( 'Template 15', 'colorlib-coming-soon-maintenance' ),
				),
			)
		) );


		/*Settings - General - Timer*/
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_timer_option]', array(
			'default'           => date( 'Y-m-d H:i:s', strtotime( '+1 month' ) ),
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option'
		) );

		$wp_customize->add_control( new WP_Customize_Date_Time_Control( $wp_customize, 'ccsm_settings[colorlib_coming_soon_timer_option]', array(
            'label'              => esc_html__('Time to opening', 'colorlib-coming-soon-maintenance'),
            'section'            => 'colorlib_coming_soon_section_general',
            'priority'           => 10,
            'twelve_hour_format' => false,
            'active_callback'    => 'ccsm_template_has_timer',
		) ) );

		$wp_customize->selective_refresh->add_partial(
			'ccsm_settings[colorlib_coming_soon_timer_option]',
			array(
				'selector' => '.cd100',
			)
		);


		/* Setting - General - Site Logo */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_plugin_logo]', array(
			'default'           => CCSM_URL . 'assets/images/logo.jpg',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option'
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ccsm_settings[colorlib_coming_soon_plugin_logo]', array(
				'label'           => esc_html__( 'Logo Image', 'colorlib-coming-soon-maintenance' ),
				'description'     => esc_html__( 'Recommended size: 80px by 80px', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_section_general',
				'priority'        => 10,
				'active_callback' => 'ccsm_template_has_logo',
			) )
		);

		$wp_customize->selective_refresh->add_partial(
			'ccsm_settings[colorlib_coming_soon_plugin_logo]',
			array(
				'selector' => '.logo-link',
			)
		);

		/* Setting - General - Site Background Image */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_background_image]', array(
			'default'           => CCSM_URL . 'assets/images/logo.jpg',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option'
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ccsm_settings[colorlib_coming_soon_background_image]', array(
				'label'           => esc_html__( 'Background Image', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_section_general',
				'priority'        => 10,
				'active_callback' => 'ccsm_template_has_background_image',
			) )
		);

		/* Setting - General - Site Background Color */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_background_color]', array(
			'default'           => '',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option'
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ccsm_settings[colorlib_coming_soon_background_color]', array(
				'label'           => esc_html__( 'Background Color', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_section_general',
				'priority'        => 10,
				'active_callback' => 'ccsm_template_has_background_color',
			) )
		);

		/* Setting - General - Site Text Color */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_text_color]', array(
			'default'           => '',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ccsm_settings[colorlib_coming_soon_text_color]', array(
				'label'           => esc_html__( 'Text Color', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_section_general',
				'priority'        => 10,
				'active_callback' => 'ccsm_template_has_text_color'
			) )
		);

		/* Setting - Coming Soon - Page Heading */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_page_heading]', array(
			'default'           => 'Something <strong>really good</strong> is coming <strong>very soon</strong>',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'transport'         => 'postMessage',
			'type'              => 'option'
		) );

		$wp_customize->add_control( new CCSM_Control_Text_Editor( $wp_customize, 'ccsm_settings[colorlib_coming_soon_page_heading]', array(
				'label'    => esc_html__( 'Heading', 'colorlib-coming-soon-maintenance' ),
				'section'  => 'colorlib_coming_soon_section_general',
				'priority' => 20,
			) )
		);

		$wp_customize->selective_refresh->add_partial(
			'ccsm_settings[colorlib_coming_soon_page_heading]',
			array(
				'selector' => '#colorlib_coming_soon_page_heading',
			)
		);


		/* Setting - Coming Soon - Page Content */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_page_content]', array(
			'default'           => 'If you have something new you’re looking to launch, you’re going to want to start building a community of people interested in what you’re launching.',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'transport'         => 'postMessage',
			'type'              => 'option'
		) );

		$wp_customize->add_control( new CCSM_Control_Text_Editor( $wp_customize, 'ccsm_settings[colorlib_coming_soon_page_content]', array(
				'label'           => esc_html__( 'Main Content', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_section_general',
				'priority'        => 30,
				'active_callback' => 'ccsm_template_has_content',
			) )
		);

		/* Setting - Coming Soon - Google Analytics */

		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_google_analytics]', array(
				'sanitize_callback' => 'ccsm_sanitize_google_analytics',
				'type'              => 'option'
			) );

		$wp_customize->add_control( 'ccsm_settings[colorlib_coming_soon_google_analytics]', array(
			'label'           => esc_html__( 'Google Analytics', 'colorlib-coming-soon-maintenance' ),
			'section'         => 'colorlib_coming_soon_section_general',
			'priority'        => 30,
		) );
	

		$wp_customize->selective_refresh->add_partial(
			'ccsm_settings[colorlib_coming_soon_page_content]',
			array(
				'selector' => '#colorlib_coming_soon_page_content',
			)
		);


		/* Setting - Coming Soon - Page Footers */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_page_footer]', array(
			'default'           => 'And don\'t worry, we hate spam too! You can unsubscribe at any time.',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'transport'         => 'postMessage',
			'type'              => 'option'
		) );

		$wp_customize->add_control( new CCSM_Control_Text_Editor( $wp_customize, 'ccsm_settings[colorlib_coming_soon_page_footer]', array(
				'label'           => esc_html__( 'Footer Text', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_section_general',
				'priority'        => 40,
				'active_callback' => 'ccsm_template_has_footer',
			) )
		);

		$wp_customize->selective_refresh->add_partial(
			'ccsm_settings[colorlib_coming_soon_page_footer]',
			array(
				'selector' => '#colorlib_coming_soon_page_footer',
			)
		);


		/* Setting - Coming Soon - Subscribe Form Activation */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_subscribe]', array(
			'sanitize_callback' => 'ccsm_sanitize_text',
			'default'           => '',
			'type'              => 'option'
		) );

		$wp_customize->add_control( new CCSM_Control_Toggle( $wp_customize, 'ccsm_settings[colorlib_coming_soon_subscribe]', array(
				'label'           => esc_html__( 'Disable Subscribe Form', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_subscribe_form',
				'priority'        => 10,
				'active_callback' => 'ccsm_template_has_subscribe_form'
			) )
		);


		/* Setting - Coming Soon - Subscribe Form URL */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_subscribe_form_url]', array(
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option'
		) );

		$wp_customize->add_control( 'ccsm_settings[colorlib_coming_soon_subscribe_form_url]', array(
				'label'           => esc_html__( 'Subscribe Form Action URL', 'colorlib-coming-soon-maintenance' ),
				'description'     => __( 'You can get your form action URL by creating a sign-up form and copying the form action="" field.: <a href="https://mailchimp.com/help/add-a-signup-form-to-your-website/" target="_blank">https://mailchimp.com/help/add-a-signup-form-to-your-website/</a>', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_subscribe_form',
				'type'            => 'text',
				'priority'        => 10,
				'active_callback' => 'ccsm_template_has_subscribe_form'
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'ccsm_settings[colorlib_coming_soon_subscribe_form_url]',
			array(
				'selector' => 'form',
			)
		);

		/* Setting - Coming Soon - Subscribe Form Other */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_subscribe_form_other]', array(
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option'
		) );

		$wp_customize->add_control( 'ccsm_settings[colorlib_coming_soon_subscribe_form_other]', array(
				'label'           => esc_html__( 'Subscribe Form Action URL', 'colorlib-coming-soon-maintenance' ),
				'description'     => __( 'Sign Up Link', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_subscribe_form',
				'type'            => 'text',
				'priority'        => 20,
				'active_callback' => 'ccsm_template_has_subscribe_signup'
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'ccsm_settings[colorlib_coming_soon_subscribe_form_other]',
			array(
				'selector' => '.sign-up',
			)
		);


		/* Setting - Coming Soon - Social Links  Facebook*/
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_social_facebook]', array(
			'default'           => 'https://www.facebook.com/',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option'
		) );

		$wp_customize->add_control( 'ccsm_settings[colorlib_coming_soon_social_facebook]', array(
				'label'    => esc_html__( 'Facebook', 'colorlib-coming-soon-maintenance' ),
				'section'  => 'colorlib_coming_soon_section_social_settings',
				'type'     => 'text',
				'priority' => 10,
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'ccsm_settings[colorlib_coming_soon_social_facebook]',
			array(
				'selector' => '#colorlib_coming_soon_social_facebook',
			)
		);


		/* Setting - Coming Soon - Social Links Twitter*/
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_social_twitter]', array(
			'default'           => 'https://www.twitter.com/',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option'
		) );

		$wp_customize->add_control( 'ccsm_settings[colorlib_coming_soon_social_twitter]', array(
				'label'    => esc_html__( 'Twitter', 'colorlib-coming-soon-maintenance' ),
				'section'  => 'colorlib_coming_soon_section_social_settings',
				'type'     => 'text',
				'priority' => 20,
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'ccsm_settings[colorlib_coming_soon_social_twitter]',
			array(
				'selector' => '#colorlib_coming_soon_social_twitter',
			)
		);


		/* Setting - Coming Soon - Social Links Email*/
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_social_email]', array(
			'default'           => 'you@domain.com',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option'
		) );

		$wp_customize->add_control( 'ccsm_settings[colorlib_coming_soon_social_email]', array(
				'label'    => esc_html__( 'Email', 'colorlib-coming-soon-maintenance' ),
				'section'  => 'colorlib_coming_soon_section_social_settings',
				'type'     => 'text',
				'priority' => 30,
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'ccsm_settings[colorlib_coming_soon_social_email]',
			array(
				'selector' => '#colorlib_coming_soon_social_email',
			)
		);

		/* Setting - Coming Soon - Social Links Youtube*/
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_social_youtube]', array(
			'default'           => 'https://youtube.com/',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option'
		) );

		$wp_customize->add_control( 'ccsm_settings[colorlib_coming_soon_social_youtube]', array(
				'label'    => esc_html__( 'Youtube', 'colorlib-coming-soon-maintenance' ),
				'section'  => 'colorlib_coming_soon_section_social_settings',
				'type'     => 'text',
				'priority' => 40,
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'ccsm_settings[colorlib_coming_soon_social_youtube]',
			array(
				'selector' => '#colorlib_coming_soon_social_youtube',
			)
		);

		/* Setting - Coming Soon - Social Links Pinteres*/
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_social_pinterest]', array(
			'default'           => 'https://pinterest.com/',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option'
		) );

		$wp_customize->add_control( 'ccsm_settings[colorlib_coming_soon_social_pinterest]', array(
				'label'    => esc_html__( 'Pinterest', 'colorlib-coming-soon-maintenance' ),
				'section'  => 'colorlib_coming_soon_section_social_settings',
				'type'     => 'text',
				'priority' => 50,
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'ccsm_settings[colorlib_coming_soon_social_pinterest]',
			array(
				'selector' => '#colorlib_coming_soon_social_pinterest',
			)
		);

		/* Setting - Coming Soon - Social Links Instagram*/
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_social_instagram]', array(
			'default'           => 'https://instagram.com/',
			'sanitize_callback' => 'ccsm_sanitize_text',
			'type'              => 'option'
		) );

		$wp_customize->add_control( 'ccsm_settings[colorlib_coming_soon_social_instagram]', array(
				'label'    => esc_html__( 'Instagram', 'colorlib-coming-soon-maintenance' ),
				'section'  => 'colorlib_coming_soon_section_social_settings',
				'type'     => 'text',
				'priority' => 60,
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'ccsm_settings[colorlib_coming_soon_social_instagram]',
			array(
				'selector' => '#colorlib_coming_soon_social_instagram',
			)
		);

	}

	public function ccsm_add_menu_item() {
		$page = add_menu_page(
			esc_html__( 'Colorlib Coming Soon', 'colorlib-coming-soon-maintenance' ), esc_html__( 'Coming Soon', 'colorlib-coming-soon-maintenance' ), 'manage_options', 'ccsm_settings', array(
			$this,
			'settings_page',
		), 'dashicons-share-alt'
		);
	}

	/**
	 * Add settings link to plugin list table
	 *
	 * @param  array $links Existing links
	 *
	 * @return array        Modified links
	 */
	public function ccsm_add_settings_link( $links ) {
		$settings_link = '<a href="options-general.php?page=ccsm__settings">' . __( 'Settings', 'colorlib-coming-soon-maintenance' ) . '</a>';
		array_push( $links, $settings_link );

		return $links;
	}

	/**
	 * Hook to redirect the page for the Customizer.
	 *
	 * @access public
	 * @return void
	 */
	public function ccsm_redirect_customizer() {
		if ( ! empty( $_GET['page'] ) ) { // Input var okay.
			if ( 'ccsm_settings' === $_GET['page'] ) { // Input var okay.

				// Generate the redirect url.
				$url = add_query_arg(
					array(
						'autofocus[panel]' => 'colorlib_coming_soon_general_panel',
					),
					admin_url( 'customize.php' )
				);

				wp_safe_redirect( $url );
			}
		}
	}

}

$cl = new CCSM_Customizer();

function ccsm_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function ccsm_sanitize_google_analytics( $input ) {
	return $input;
}

