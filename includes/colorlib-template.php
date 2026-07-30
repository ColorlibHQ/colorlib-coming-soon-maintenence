<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ccsm_options = ccsm_get_options();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php bloginfo( 'name' ); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php
	if ( ! empty( $ccsm_options['colorlib_coming_soon_noindex'] ) || 'maintenance' === ccsm_get_mode() ) {
		echo '<meta name="robots" content="noindex, nofollow">' . "\n";
	}

    if ( isset( $ccsm_options['colorlib_coming_soon_google_analytics_id'] ) && '' !== $ccsm_options['colorlib_coming_soon_google_analytics_id'] ) {
     ?>
        <link rel="preconnect" href="https://www.googletagmanager.com">
        <script async src="<?php echo esc_url( 'https://www.googletagmanager.com/gtag/js?id=' . $ccsm_options['colorlib_coming_soon_google_analytics_id'] ); ?>"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', <?php echo wp_json_encode( $ccsm_options['colorlib_coming_soon_google_analytics_id'] ); ?>);
        </script>
     <?php
    }

	$template = isset( $ccsm_options['colorlib_coming_soon_template_selection'] ) ? $ccsm_options['colorlib_coming_soon_template_selection'] : 'template_01';

	// Validate template name to prevent path traversal
	if ( ! in_array( $template, ccsm_allowed_templates(), true ) ) {
		$template = 'template_01';
	}

	$counterActivation = $ccsm_options['colorlib_coming_soon_timer_activation'];
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
            background-color: <?php echo esc_attr( sanitize_hex_color( $ccsm_options['colorlib_coming_soon_background_color'] ) ); ?> !important;
        }

        <?php
    }
	?>

        <?php echo wp_strip_all_tags( $ccsm_options['colorlib_coming_soon_page_custom_css'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- CSS context, tags stripped. ?>
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
