<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ccsm_options = ccsm_get_options();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <title><?php bloginfo( 'name' ); ?></title>
    <?php /* No maximum-scale: it blocks pinch zoom (WCAG 1.4.4). */ ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
	$ccsm_site_description = get_bloginfo( 'description', 'display' );
	if ( '' !== $ccsm_site_description ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $ccsm_site_description ) );
	}

	// The theme never loads here, so the Site Icon has to be printed by hand.
	if ( function_exists( 'wp_site_icon' ) && has_site_icon() ) {
		wp_site_icon();
	}

	if ( ! empty( $ccsm_options['colorlib_coming_soon_noindex'] ) || 'maintenance' === ccsm_get_mode() ) {
		echo '<meta name="robots" content="noindex, nofollow">' . "\n";
	}

    if ( isset( $ccsm_options['colorlib_coming_soon_google_analytics_id'] ) && '' !== $ccsm_options['colorlib_coming_soon_google_analytics_id'] ) {
     ?>
        <link rel="preconnect" href="https://www.googletagmanager.com">
		<?php
		// wp_print_script_tag() rather than a literal <script src>: it escapes
		// the attributes and keeps the tag out of the NonEnqueuedScript sniff.
		wp_print_script_tag(
			array(
				'src'   => 'https://www.googletagmanager.com/gtag/js?id=' . $ccsm_options['colorlib_coming_soon_google_analytics_id'],
				'async' => true,
			)
		);
		?>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', <?php echo wp_json_encode( $ccsm_options['colorlib_coming_soon_google_analytics_id'] ); ?>);
        </script>
     <?php
    }

	$ccsm_template = isset( $ccsm_options['colorlib_coming_soon_template_selection'] ) ? $ccsm_options['colorlib_coming_soon_template_selection'] : 'template_01';

	// Validate template name to prevent path traversal
	if ( ! in_array( $ccsm_template, ccsm_allowed_templates(), true ) ) {
		$ccsm_template = 'template_01';
	}

	$ccsm_counter_activation = $ccsm_options['colorlib_coming_soon_timer_activation'];
	do_action( 'ccsm_header', $ccsm_template );
	ccsm_preload_background( $ccsm_options );

	?>
    <style>
        <?php if( $ccsm_counter_activation !== '1' ) { ?>
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
            /* Templates that need a specific colour set one inline; the rest
               should follow the surrounding text rather than fall back to the
               browser's default link blue. Keep the underline: it is the only
               remaining affordance that this is a link. */
            color: inherit;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<main id="ccsm-main">
<?php
include CCSM_PATH . 'templates/' . $ccsm_template . '/' . $ccsm_template . '.php';
?>
</main>
<?php
do_action( 'ccsm_footer', $ccsm_template );
?>

</body>
</html>
