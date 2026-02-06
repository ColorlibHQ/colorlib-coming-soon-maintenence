<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php bloginfo( 'name' );
		$site_description = get_bloginfo( 'description' ); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php
	$ccsm_options = get_option( 'ccsm_settings' );

	if ( ! is_array( $ccsm_options ) ) {
		return;
	}

    if ( isset( $ccsm_options['colorlib_coming_soon_google_analytics_id'] ) && '' !== $ccsm_options['colorlib_coming_soon_google_analytics_id'] ) {
     ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_html( str_replace(array('\'', '"'), '', $ccsm_options['colorlib_coming_soon_google_analytics_id']) ); ?>"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '<?php echo esc_html( str_replace(array('\'', '"'), '', $ccsm_options['colorlib_coming_soon_google_analytics_id']) ); ?>');
        </script>
     <?php
    }

	$template = isset( $ccsm_options['colorlib_coming_soon_template_selection'] ) ? $ccsm_options['colorlib_coming_soon_template_selection'] : 'template_01';

	// Validate template name to prevent path traversal
	$allowed_templates = array(
		'template_01', 'template_02', 'template_03', 'template_04', 'template_05',
		'template_06', 'template_07', 'template_08', 'template_09', 'template_10',
		'template_11', 'template_12', 'template_13', 'template_14', 'template_15',
	);
	if ( ! in_array( $template, $allowed_templates, true ) ) {
		$template = 'template_01';
	}

	$counterActivation = isset( $ccsm_options['colorlib_coming_soon_timer_activation'] ) ? $ccsm_options['colorlib_coming_soon_timer_activation'] : '1';
	do_action( 'ccsm_header', $template );

	?>
    <style>
        <?php if( $counterActivation !== '1' ) { ?>
        .cd100 {
            display: none !important;
        }

        <?php
        }

    if(ccsm_template_has_background_color()){
        ?>
        body {
            background-color: <?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_background_color'] ); ?> !important;
        }

        <?php
    }
	?>

        <?php echo wp_kses_post( isset( $ccsm_options['colorlib_coming_soon_page_custom_css'] ) ? $ccsm_options['colorlib_coming_soon_page_custom_css'] : '' ); ?>
        .colorlib-copyright {
            text-align: center;
            left: 0;
            right: 0;
            margin: 0 auto;
        }

        .colorlib-copyright span {
            opacity: 0.8;
        }

        .colorlib-copyright a {
            opacity: 1;
        }
    </style>
</head>
<body>

<?php include( CCSM_PATH . 'templates/' . $template . '/' . $template . '.php' ); ?>

</body>
</html>
