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
			'location' => 'vendor/animate/animate.css',
			'template' => 'template_01',
		),
		array(
			'name'     => 'main',
			'location' => 'css/main.css',
			'template' => 'template_01',
		),
		array(
			'name'     => 'bootstrap',
			'location' => 'vendor/bootstrap/css/bootstrap.min.css',
			'template' => 'template_01',
		),
		array(
			'name'     => 'font-awesome',
			'location' => 'fonts/font-awesome-4.7.0/css/font-awesome.min.css',
			'template' => 'template_01'
		),
		array(
			'name'     => 'select-2',
			'location' => 'vendor/select2/select2.min.css',
			'template' => 'template_01'
		),
		array(
			'name'     => 'util',
			'location' => 'css/util.css',
			'template' => 'template_01'
		)
	);

	colorlibStyleEnqueue( $styles );

	$counter = get_theme_mod( 'colorlib_coming_soon_timer_option' );
	$dates   = colorlibCounterDates( $counter );

	?>
    <link rel="icon" type="image/png"
          href="<?php echo CSMM_URL . 'templates/template_files/' . get_theme_mod( 'colorlib_coming_soon_template_selection' ); ?>/images/icons/favicon.ico"/>
	<?php wp_head(); ?>
</head>

<body>
<?php
$template = get_theme_mod( 'colorlib_coming_soon_template_selection' );
include( CSMM_PATH . 'templates/template_file/' . $template . '.php' );
?>
</body>
</html>