<?php
/* Colorlib Coming Soon Customizer Options */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class CCSM_Customizer {

	public function __construct() {

		add_action( 'customize_register', array( $this, 'ccsm_customizer_controls' ) );
		add_action( 'customize_register', array( $this, 'ccsm_panels_initialize' ) );
		add_action( 'admin_menu', array( $this, 'ccsm_add_menu_item' ) );
		add_action( 'admin_init', array( $this, 'handle_tools_actions' ) );
	}

	/**
	 * Handle the export / import / regenerate actions posted from the settings page.
	 */
	public function handle_tools_actions() {
		if ( empty( $_POST['ccsm_action'] ) || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		check_admin_referer( 'ccsm_tools' );

		$action = sanitize_text_field( wp_unslash( $_POST['ccsm_action'] ) );
		$notice = '';

		if ( 'regenerate_token' === $action ) {
			$options = get_option( 'ccsm_settings' );
			if ( is_array( $options ) ) {
				$options['colorlib_coming_soon_bypass_token'] = wp_generate_password( 24, false );
				update_option( 'ccsm_settings', $options );
			}
			$notice = 'token';
		}

		if ( 'import' === $action && isset( $_POST['ccsm_import'] ) ) {
			$raw      = trim( wp_unslash( $_POST['ccsm_import'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput -- decoded and filtered below.
			$imported = json_decode( $raw, true );
			$notice   = 'import_failed';

			if ( is_array( $imported ) ) {
				// Only accept keys the plugin actually defines, and run each
				// through the same sanitizer the Customizer uses.
				$clean = array();
				foreach ( ccsm_defaults() as $key => $default ) {
					if ( array_key_exists( $key, $imported ) ) {
						$clean[ $key ] = ccsm_sanitize_setting( $key, $imported[ $key ] );
					}
				}

				if ( $clean ) {
					$existing = get_option( 'ccsm_settings' );
					update_option( 'ccsm_settings', array_merge( is_array( $existing ) ? $existing : array(), $clean ) );
					$notice = 'imported';
				}
			}
		}

		wp_safe_redirect( add_query_arg( 'ccsm_notice', $notice, admin_url( 'admin.php?page=ccsm_settings' ) ) );
		exit;
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
			'sanitize_callback' => 'ccsm_sanitize_checkbox',
			'type'              => 'option',
		) );

		$wp_customize->add_control( new CCSM_Control_Toggle ( $wp_customize, 'ccsm_settings[colorlib_coming_soon_activation]', array(
				'label'       => esc_html__( 'Activate Colorlib Coming Soon Page?', 'colorlib-coming-soon-maintenance' ),
				'section'     => 'colorlib_coming_soon_section_general',
				'priority'    => 10,
			) )
		);


		/* Setting - Coming Soon - Mode */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_mode]', array(
			'default'           => 'coming_soon',
			'sanitize_callback' => 'ccsm_sanitize_mode',
			'type'              => 'option',
		) );

		$wp_customize->add_control( 'ccsm_settings[colorlib_coming_soon_mode]', array(
				'label'       => esc_html__( 'Page Mode', 'colorlib-coming-soon-maintenance' ),
				'description' => esc_html__( 'Coming Soon answers with HTTP 200, so search engines may index the page. Maintenance answers with HTTP 503 and Retry-After, which tells search engines the downtime is temporary and keeps your existing rankings.', 'colorlib-coming-soon-maintenance' ),
				'section'     => 'colorlib_coming_soon_section_general',
				'type'        => 'radio',
				'priority'    => 11,
				'choices'     => array(
					'coming_soon' => esc_html__( 'Coming Soon (new site)', 'colorlib-coming-soon-maintenance' ),
					'maintenance' => esc_html__( 'Maintenance (existing site, temporary)', 'colorlib-coming-soon-maintenance' ),
				),
			)
		);


		/* Setting - Coming Soon - Discourage search engines */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_noindex]', array(
			'default'           => '',
			'sanitize_callback' => 'ccsm_sanitize_checkbox',
			'type'              => 'option',
		) );

		$wp_customize->add_control( new CCSM_Control_Toggle ( $wp_customize, 'ccsm_settings[colorlib_coming_soon_noindex]', array(
				'label'       => esc_html__( 'Discourage search engines from indexing this page?', 'colorlib-coming-soon-maintenance' ),
				'description' => esc_html__( 'Adds a noindex robots tag. Maintenance mode also blocks crawlers via robots.txt.', 'colorlib-coming-soon-maintenance' ),
				'section'     => 'colorlib_coming_soon_section_general',
				'priority'    => 12,
			) )
		);


		/* Setting - Coming Soon - Timer Activation */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_timer_activation]', array(
			'default'           => '1',
			'sanitize_callback' => 'ccsm_sanitize_checkbox',
			'type'              => 'option',
		) );

		$wp_customize->add_control( new CCSM_Control_Toggle ( $wp_customize, 'ccsm_settings[colorlib_coming_soon_timer_activation]', array(
				'label'           => esc_html__( 'Activate Timer Countdown?', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_section_general',
				'priority'        => 20,
				'active_callback' => 'ccsm_template_has_timer'
			) )
		);


		/* Setting - Coming Soon - Custom CSS */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_page_custom_css]', array(
			'sanitize_callback' => 'ccsm_sanitize_css',
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
			'sanitize_callback' => 'ccsm_sanitize_template',
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
			'default'           => gmdate( 'Y-m-d H:i:s', strtotime( '+1 month' ) ),
			'sanitize_callback' => 'ccsm_sanitize_datetime',
			'type'              => 'option'
		) );

		$wp_customize->add_control( new WP_Customize_Date_Time_Control( $wp_customize, 'ccsm_settings[colorlib_coming_soon_timer_option]', array(
            'label'              => esc_html__('Time to opening', 'colorlib-coming-soon-maintenance'),
            'section'            => 'colorlib_coming_soon_section_general',
            'priority'           => 21,
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
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'option',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ccsm_settings[colorlib_coming_soon_plugin_logo]', array(
				'label'           => esc_html__( 'Logo Image', 'colorlib-coming-soon-maintenance' ),
				'description'     => esc_html__( 'Recommended size: 80px by 80px', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_section_general',
				'priority'        => 40,
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
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'option',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ccsm_settings[colorlib_coming_soon_background_image]', array(
				'label'           => esc_html__( 'Background Image', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_section_general',
				'priority'        => 41,
				'active_callback' => 'ccsm_template_has_background_image',
			) )
		);

		/* Setting - General - Site Background Color */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_background_color]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
			'type'              => 'option',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ccsm_settings[colorlib_coming_soon_background_color]', array(
				'label'           => esc_html__( 'Background Color', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_section_general',
				'priority'        => 42,
				'active_callback' => 'ccsm_template_has_background_color',
			) )
		);

		/* Setting - General - Site Text Color */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_text_color]', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
			'type'              => 'option',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ccsm_settings[colorlib_coming_soon_text_color]', array(
				'label'           => esc_html__( 'Text Color', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_section_general',
				'priority'        => 43,
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
				'priority' => 30,
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
				'priority'        => 31,
				'active_callback' => 'ccsm_template_has_content',
			) )
		);

		/* Setting - Coming Soon - Google Analytics */

		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_google_analytics_id]', array(
				'sanitize_callback' => 'ccsm_sanitize_google_analytics',
				'type'              => 'option'
				
			) );

		$wp_customize->add_control( 'ccsm_settings[colorlib_coming_soon_google_analytics_id]', array(
			'label'           => esc_html__( 'Google Analytics tracking code ID', 'colorlib-coming-soon-maintenance' ),
			'section'         => 'colorlib_coming_soon_section_general',
			'priority'        => 60,
			'input_attrs' => array(
				'placeholder' => __( 'G-XXXXXXXXXX', 'colorlib-coming-soon-maintenance' ),
			)
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
				'priority'        => 32,
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
			'sanitize_callback' => 'ccsm_sanitize_checkbox',
			'default'           => '',
			'type'              => 'option'
		) );

		$wp_customize->add_control( new CCSM_Control_Toggle( $wp_customize, 'ccsm_settings[colorlib_coming_soon_subscribe]', array(
				'label'           => esc_html__( 'Hide the subscribe form', 'colorlib-coming-soon-maintenance' ),
				'description'     => esc_html__( 'Turn this on to remove the email sign-up form from the page.', 'colorlib-coming-soon-maintenance' ),
				'section'         => 'colorlib_coming_soon_subscribe_form',
				'priority'        => 10,
				'active_callback' => 'ccsm_template_has_subscribe_form'
			) )
		);


		/* Setting - Coming Soon - Subscribe Form URL */
		$wp_customize->add_setting( 'ccsm_settings[colorlib_coming_soon_subscribe_form_url]', array(
			'sanitize_callback' => 'esc_url_raw',
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
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'option'
		) );

		$wp_customize->add_control( 'ccsm_settings[colorlib_coming_soon_subscribe_form_other]', array(
				'label'           => esc_html__( 'Sign Up Button Link', 'colorlib-coming-soon-maintenance' ),
				'description'     => esc_html__( 'Where the Sign Up button sends visitors. Separate from the subscribe form above.', 'colorlib-coming-soon-maintenance' ),
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
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'option',
			'transport'         => 'postMessage',
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
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'option',
			'transport'         => 'postMessage',
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
			'sanitize_callback' => 'sanitize_email',
			'type'              => 'option',
			'transport'         => 'postMessage',
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
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'option',
			'transport'         => 'postMessage',
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
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'option',
			'transport'         => 'postMessage',
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
			'sanitize_callback' => 'esc_url_raw',
			'type'              => 'option',
			'transport'         => 'postMessage',
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
		add_menu_page(
			esc_html__( 'Colorlib Coming Soon', 'colorlib-coming-soon-maintenance' ), esc_html__( 'Coming Soon', 'colorlib-coming-soon-maintenance' ), 'manage_options', 'ccsm_settings', array(
			$this,
			'settings_page',
		), 'dashicons-share-alt'
		);
	}

	/**
	 * Render the settings page.
	 *
	 * This used to redirect straight to the Customizer from admin_init, which
	 * left nowhere to surface the preview link or the export tools - and on a
	 * block theme the Customizer has no menu entry of its own, so this page is
	 * the only signposted way in.
	 *
	 * @access public
	 * @return void
	 */
	public function settings_page() {
		$customizer = add_query_arg(
			array( 'autofocus[panel]' => 'colorlib_coming_soon_general_panel' ),
			admin_url( 'customize.php' )
		);

		$options = ccsm_get_options();
		$active  = '1' === $options['colorlib_coming_soon_activation'];
		$mode    = ccsm_get_mode();
		$notice  = isset( $_GET['ccsm_notice'] ) ? sanitize_text_field( wp_unslash( $_GET['ccsm_notice'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		$messages = array(
			'imported'      => array( 'success', __( 'Settings imported.', 'colorlib-coming-soon-maintenance' ) ),
			'import_failed' => array( 'error', __( 'Could not import those settings. Paste the exact JSON produced by Export.', 'colorlib-coming-soon-maintenance' ) ),
			'token'         => array( 'success', __( 'A new preview link was generated. The previous one no longer works.', 'colorlib-coming-soon-maintenance' ) ),
		);
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Coming Soon and Maintenance', 'colorlib-coming-soon-maintenance' ); ?></h1>

			<?php if ( isset( $messages[ $notice ] ) ) : ?>
				<div class="notice notice-<?php echo esc_attr( $messages[ $notice ][0] ); ?> is-dismissible">
					<p><?php echo esc_html( $messages[ $notice ][1] ); ?></p>
				</div>
			<?php endif; ?>

			<p>
				<?php if ( $active && 'maintenance' === $mode ) : ?>
					<strong><?php esc_html_e( 'Maintenance mode is on.', 'colorlib-coming-soon-maintenance' ); ?></strong>
					<?php esc_html_e( 'Visitors get the maintenance page with an HTTP 503 status.', 'colorlib-coming-soon-maintenance' ); ?>
				<?php elseif ( $active ) : ?>
					<strong><?php esc_html_e( 'Coming soon mode is on.', 'colorlib-coming-soon-maintenance' ); ?></strong>
					<?php esc_html_e( 'Visitors get the coming soon page.', 'colorlib-coming-soon-maintenance' ); ?>
				<?php else : ?>
					<strong><?php esc_html_e( 'The coming soon page is off.', 'colorlib-coming-soon-maintenance' ); ?></strong>
					<?php esc_html_e( 'Your site is visible to everyone.', 'colorlib-coming-soon-maintenance' ); ?>
				<?php endif; ?>
			</p>

			<p>
				<a class="button button-primary button-hero" href="<?php echo esc_url( $customizer ); ?>">
					<?php esc_html_e( 'Edit the page and settings', 'colorlib-coming-soon-maintenance' ); ?>
				</a>
			</p>

			<hr>

			<h2><?php esc_html_e( 'Share a preview with a client', 'colorlib-coming-soon-maintenance' ); ?></h2>
			<p class="description">
				<?php esc_html_e( 'Anyone who opens this link sees the real site for a week, without an account. Treat it as a password.', 'colorlib-coming-soon-maintenance' ); ?>
			</p>
			<p>
				<input type="text" class="large-text code" readonly
				       onfocus="this.select()"
				       value="<?php echo esc_url( ccsm_get_bypass_url() ); ?>">
			</p>
			<form method="post">
				<?php wp_nonce_field( 'ccsm_tools' ); ?>
				<input type="hidden" name="ccsm_action" value="regenerate_token">
				<?php submit_button( __( 'Generate a new link', 'colorlib-coming-soon-maintenance' ), 'secondary', 'submit', false ); ?>
			</form>

			<hr>

			<h2><?php esc_html_e( 'Export and import', 'colorlib-coming-soon-maintenance' ); ?></h2>
			<p class="description">
				<?php esc_html_e( 'Copy these settings to another site. The preview link is not included.', 'colorlib-coming-soon-maintenance' ); ?>
			</p>

			<h3><?php esc_html_e( 'Export', 'colorlib-coming-soon-maintenance' ); ?></h3>
			<textarea class="large-text code" rows="6" readonly onfocus="this.select()"><?php
				echo esc_textarea( $this->export_json() );
			?></textarea>

			<h3><?php esc_html_e( 'Import', 'colorlib-coming-soon-maintenance' ); ?></h3>
			<form method="post">
				<?php wp_nonce_field( 'ccsm_tools' ); ?>
				<input type="hidden" name="ccsm_action" value="import">
				<p>
					<label class="screen-reader-text" for="ccsm_import"><?php esc_html_e( 'Settings JSON', 'colorlib-coming-soon-maintenance' ); ?></label>
					<textarea class="large-text code" rows="6" name="ccsm_import" id="ccsm_import"
					          placeholder="<?php esc_attr_e( 'Paste exported settings here', 'colorlib-coming-soon-maintenance' ); ?>"></textarea>
				</p>
				<?php submit_button( __( 'Import settings', 'colorlib-coming-soon-maintenance' ), 'secondary', 'submit', false ); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * The current settings as portable JSON, minus anything site-specific.
	 *
	 * @return string
	 */
	private function export_json() {
		$options = get_option( 'ccsm_settings' );

		if ( ! is_array( $options ) ) {
			return '{}';
		}

		// The token is a credential and 'givemereview' is local review-notice state.
		unset( $options['colorlib_coming_soon_bypass_token'], $options['givemereview'] );

		return wp_json_encode( $options, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
	}


}

$cl = new CCSM_Customizer();

function ccsm_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Map a setting key to its sanitizer.
 *
 * Mirrors the sanitize_callback each setting is registered with, so imported
 * values go through exactly the same filtering as values saved in the
 * Customizer.
 *
 * @return array key => callable
 */
function ccsm_setting_sanitizers() {
	return array(
		'colorlib_coming_soon_activation'           => 'ccsm_sanitize_checkbox',
		'colorlib_coming_soon_timer_activation'     => 'ccsm_sanitize_checkbox',
		'colorlib_coming_soon_subscribe'            => 'ccsm_sanitize_checkbox',
		'colorlib_coming_soon_noindex'              => 'ccsm_sanitize_checkbox',
		'colorlib_coming_soon_mode'                 => 'ccsm_sanitize_mode',
		'colorlib_coming_soon_page_custom_css'      => 'ccsm_sanitize_css',
		'colorlib_coming_soon_template_selection'   => 'ccsm_sanitize_template',
		'colorlib_coming_soon_timer_option'         => 'ccsm_sanitize_datetime',
		'colorlib_coming_soon_google_analytics_id'  => 'ccsm_sanitize_google_analytics',
		'colorlib_coming_soon_plugin_logo'          => 'esc_url_raw',
		'colorlib_coming_soon_background_image'     => 'esc_url_raw',
		'colorlib_coming_soon_subscribe_form_url'   => 'esc_url_raw',
		'colorlib_coming_soon_subscribe_form_other' => 'esc_url_raw',
		'colorlib_coming_soon_social_facebook'      => 'esc_url_raw',
		'colorlib_coming_soon_social_twitter'       => 'esc_url_raw',
		'colorlib_coming_soon_social_youtube'       => 'esc_url_raw',
		'colorlib_coming_soon_social_pinterest'     => 'esc_url_raw',
		'colorlib_coming_soon_social_instagram'     => 'esc_url_raw',
		'colorlib_coming_soon_social_email'         => 'sanitize_email',
		'colorlib_coming_soon_background_color'     => 'sanitize_hex_color',
		'colorlib_coming_soon_text_color'           => 'sanitize_hex_color',
		'colorlib_coming_soon_page_heading'         => 'ccsm_sanitize_text',
		'colorlib_coming_soon_page_content'         => 'ccsm_sanitize_text',
		'colorlib_coming_soon_page_footer'          => 'ccsm_sanitize_text',
	);
}

/**
 * Sanitize one setting by key.
 *
 * @param string $key   Setting key.
 * @param mixed  $value Raw value.
 * @return mixed Sanitized value, or '' for a key with no sanitizer.
 */
function ccsm_sanitize_setting( $key, $value ) {
	$sanitizers = ccsm_setting_sanitizers();

	if ( ! isset( $sanitizers[ $key ] ) || ! is_scalar( $value ) ) {
		return '';
	}

	return call_user_func( $sanitizers[ $key ], $value );
}

/**
 * Sanitize a Google Analytics / Tag Manager measurement ID.
 *
 * Stores the raw ID rather than an escaped one: escaping belongs at output.
 *
 * @param string $input Raw value.
 * @return string Valid measurement ID, or '' .
 */
function ccsm_sanitize_google_analytics( $input ) {
	$input = trim( (string) $input );

	return preg_match( '/^(G|UA|GT|AW|DC)-[A-Z0-9\-]+$/i', $input ) ? $input : '';
}

/**
 * Sanitize the Custom CSS field.
 *
 * wp_kses_post() mangles valid CSS (it eats "&gt;" child selectors), so strip
 * tags instead — the value is only ever printed inside a <style> block.
 *
 * @param string $input Raw CSS.
 * @return string
 */
function ccsm_sanitize_css( $input ) {
	return wp_strip_all_tags( (string) $input );
}

/**
 * Sanitize the selected template against the shipped list.
 *
 * @param string $input Raw value.
 * @return string A known template slug.
 */
function ccsm_sanitize_template( $input ) {
	return in_array( $input, ccsm_allowed_templates(), true ) ? $input : 'template_01';
}

/**
 * Sanitize the countdown target datetime.
 *
 * @param string $input Raw value.
 * @return string A 'Y-m-d H:i:s' string.
 */
function ccsm_sanitize_datetime( $input ) {
	$date = DateTime::createFromFormat( 'Y-m-d H:i:s', (string) $input );

	if ( $date instanceof DateTime && $date->format( 'Y-m-d H:i:s' ) === $input ) {
		return $input;
	}

	return gmdate( 'Y-m-d H:i:s', strtotime( '+1 month' ) );
}

/**
 * Sanitize the page mode radio.
 *
 * @param string $input Raw value.
 * @return string 'coming_soon' or 'maintenance'.
 */
function ccsm_sanitize_mode( $input ) {
	return 'maintenance' === $input ? 'maintenance' : 'coming_soon';
}

/**
 * Sanitize a toggle control value.
 *
 * @param mixed $input Raw value.
 * @return string '1' when on, '' when off.
 */
function ccsm_sanitize_checkbox( $input ) {
	return ( '1' === $input || 1 === $input || true === $input ) ? '1' : '';
}

