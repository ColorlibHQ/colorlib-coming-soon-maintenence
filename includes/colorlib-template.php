<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php bloginfo( 'name' );
		$site_description = get_bloginfo( 'description' ); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php
	$ccsm_options = get_option( 'ccsm_settings' );
    if ( isset( $ccsm_options['colorlib_coming_soon_google_analytics'] ) ) {
        echo $ccsm_options['colorlib_coming_soon_google_analytics'];
    }

	if ( $ccsm_options['colorlib_coming_soon_template_selection'] ) {
		$template = $ccsm_options['colorlib_coming_soon_template_selection'];
	}

	$counterActivation = $ccsm_options['colorlib_coming_soon_timer_activation'];
	do_action( 'ccsm_header', $template );

	?>
    <style>
        <?php if( $counterActivation != '1' ) { ?>
        .cd100 {
            display: none !important;
        }

        <?php
        }

    if(ccsm_template_has_background_color()){
        ?>
        body {
            background-color: <?php echo $ccsm_options['colorlib_coming_soon_background_color']; ?> !important;
        }

        <?php
    }
	?>

        <?php  echo $ccsm_options['colorlib_coming_soon_page_custom_css']; ?>
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