<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php bloginfo( 'name' );
		$site_description = get_bloginfo( 'description' ); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php

	$styles = array(
		array(
			'name'     => 'animate',
			'location' => 'css/vendor/animate/animate.css',
			'template' => 'global',
		),
		array(
			'name'     => 'bootstrap',
			'location' => 'css/vendor/bootstrap/css/bootstrap.min.css',
			'template' => 'global',
		),
		array(
			'name'     => 'font-awesome',
			'location' => 'fonts/font-awesome-4.7.0/css/font-awesome.min.css',
			'template' => 'global'
		),
		array(
			'name'     => 'select-2',
			'location' => 'css/vendor/select2/select2.min.css',
			'template' => 'global'
		),
	);

	colorlibStyleEnqueue( $styles );

	$counter = get_theme_mod( 'colorlib_coming_soon_timer_option' );
	$dates   = colorlibCounterDates( $counter );
	$template = get_theme_mod( 'colorlib_coming_soon_template_selection' );

	?>
    <link rel="icon" type="image/png"
          href="<?php echo CSMM_URL . 'templates/' . $template; ?>/images/icons/favicon.ico"/>
</head>

<body>
<?php
include( CSMM_PATH . 'templates/'.$template .'/' . $template . '.php' );
?>
</body>
</html>