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

	ccsm_style_enqueue( $styles );

	$ccsm_options = get_option( 'ccsm_settings' );

	if ( $ccsm_options['colorlib_coming_soon_template_selection'] ) {
		$template = $ccsm_options['colorlib_coming_soon_template_selection'];
	}


	?>
    <!--TODO think we should remove this or add option in the customizer-->
    <!--<link rel="icon" type="image/png"
          href="<?php /*echo CCSM_URL . 'templates/' . $template; */ ?>/images/icons/favicon.ico"/>-->

	<?php
	include( CCSM_PATH . 'templates/' . $template . '/' . $template . '.php' );
	?>

    </body>
</html>