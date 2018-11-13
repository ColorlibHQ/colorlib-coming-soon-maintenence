<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php bloginfo( 'name' );
		$site_description = get_bloginfo( 'description' ); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php
	$ccsm_options = get_option( 'ccsm_settings' );

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

        <?php }
		if($ccsm_options['colorlib_coming_soon_text_color']){
			?>
        p, h1, h2, h3, h4, span, li {
            color: <?php echo $ccsm_options['colorlib_coming_soon_text_color']; ?> !important;
        }

        <?php }
        echo $ccsm_options['colorlib_coming_soon_page_custom_css']; ?>
    </style>
</head>
<body>

<?php include( CCSM_PATH . 'templates/' . $template . '/' . $template . '.php' ); ?>

</body>
</html>