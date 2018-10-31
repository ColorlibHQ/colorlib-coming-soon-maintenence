<?php

$template = get_theme_mod( 'colorlib_coming_soon_template_selection' );
$styles   = array(
	array(
		'name'     => 'main',
		'location' => 'css/main.css',
		'template' => $template,
	),
	array(
		'name'     => 'util',
		'location' => 'css/util.css',
		'template' => $template,
	)
);

colorlibStyleEnqueue( $styles );

$counter = get_theme_mod( 'colorlib_coming_soon_timer_option' );
$dates   = colorlibCounterDates( $counter );
wp_head();
?>

<div class="simpleslide100">
	<div class="simpleslide100-item bg-img1" style="background-image: url('<?php echo CSMM_URL.'templates/'.$template; ?>/images/bg01.jpg');"></div>
	<div class="simpleslide100-item bg-img1" style="background-image: url('<?php echo CSMM_URL.'templates/'.$template; ?>/images/bg02.jpg');"></div>
	<div class="simpleslide100-item bg-img1" style="background-image: url('<?php echo CSMM_URL.'templates/'.$template; ?>/images/bg03.jpg');"></div>
	<div class="simpleslide100-item bg-img1" style="background-image: url('<?php echo CSMM_URL.'templates/'.$template; ?>/images/bg04.jpg');"></div>
</div>

<div class="flex-col-c-sb size1 overlay1">
	<!--  -->
	<div class="w-full flex-w flex-sb-m p-l-80 p-r-80 p-t-22 p-lr-15-sm">
		<div class="wrappic1 m-r-30 m-t-10 m-b-10">
			<a href="#"><img src="images/icons/logo.png" alt="LOGO"></a>
		</div>

		<div class="flex-w m-t-10 m-b-10">
			<a href="#" class="size2 m1-txt1 flex-c-m how-btn1 trans-04">
				Sign Up
			</a>
		</div>
	</div>

	<!--  -->
	<div class="flex-col-c-m p-l-15 p-r-15 p-t-50 p-b-120">
		<h3 class="l1-txt1 txt-center p-b-35 respon1">
			Coming Soon
		</h3>

		<div class="flex-w flex-c cd100 respon2">
			<div class="flex-col-c wsize1 m-b-30">
				<span class="l1-txt2 p-b-37 days"><?php echo $dates['template']['days']; ?></span>
				<span class="m1-txt2 p-r-20"><?php echo _e('Days','colorlib-coming-soon'); ?></span>
			</div>

			<span class="l1-txt2 p-t-15 dis-none-sm">:</span>

			<div class="flex-col-c wsize1 m-b-30">
				<span class="l1-txt2 p-b-37 hours"><?php echo $dates['template']['hours']; ?></span>
				<span class="m1-txt2 p-r-20"><?php echo _e('Hr','colorlib-coming-soon'); ?></span>
			</div>

			<span class="l1-txt2 p-t-15 dis-none-lg">:</span>

			<div class="flex-col-c wsize1 m-b-30">
				<span class="l1-txt2 p-b-37 minutes"><?php echo $dates['template']['minutes']; ?></span>
				<span class="m1-txt2 p-r-20"><?php echo _e('Min','colorlib-coming-soon'); ?></span>
			</div>

			<span class="l1-txt2 p-t-15 dis-none-sm">:</span>

			<div class="flex-col-c wsize1 m-b-30">
				<span class="l1-txt2 p-b-37 seconds"><?php echo $dates['template']['seconds']; ?></span>
				<span class="m1-txt2 p-r-20"><?php echo _e('Sec','colorlib-coming-soon'); ?></span>
			</div>
		</div>
	</div>

	<!--  -->
	<div class="flex-w flex-c-m p-b-35">
		<a href="#" class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-5">
			<i class="fa fa-facebook"></i>
		</a>

		<a href="#" class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-5">
			<i class="fa fa-twitter"></i>
		</a>

		<a href="#" class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-5">
			<i class="fa fa-youtube-play"></i>
		</a>
	</div>
</div>
<?php

$scripts = array(
	array(
		'name'     => 'popper',
		'location' => 'js/vendor/bootstrap/js/popper.js',
		'template' => 'global',
	),
	array(
		'name'     => 'bootstrap',
		'location' => 'js/vendor/bootstrap/js/bootstrap.min.js',
		'template' => 'global'
	),
	array(
		'name'     => 'popper',
		'location' => 'js/vendor/bootstrap/js/popper.js',
		'template' => 'global'
	),
	array(
		'name'     => 'select2',
		'location' => 'js/vendor/select2/select2.min.js',
		'template' => 'global'
	),
	array(
		'name'     => 'moment',
		'location' => 'js/vendor/countdowntime/moment.min.js',
		'template' => 'global'
	),
	array(
		'name'     => 'timezone',
		'location' => 'js/vendor/countdowntime/moment-timezone-with-data.min.js',
		'template' => 'global'
	),
	array(
		'name'     => 'coutdowntime',
		'location' => 'js/vendor/countdowntime/countdowntime.js',
		'template' => 'global'
	),
	array(
		'name'     => 'tilt',
		'location' => 'js/vendor/tilt/tilt.jquery.min.js',
		'template' => 'global'
	),
	array(
		'name'     => 'main',
		'location' => 'js/main.js',
		'template' => $template,
	),

);

colorlibScriptEnqueue( $scripts );

wp_footer();

?>

<script>
    jQuery('.cd100').countdown100({
        /*Set Endtime here*/
        /*Endtime must be > current time*/
        endtimeYear: <?php echo $dates['script']['year']; ?>,
        endtimeMonth: <?php echo $dates['script']['month']; ?>,
        endtimeDate: <?php echo $dates['script']['day']; ?>,
        endtimeHours: 23,
        endtimeMinutes: 0,
        endtimeSeconds: 0,
        timeZone: ""
        // ex:  timeZone: "America/New_York"
        //go to " http://momentjs.com/timezone/ " to get timezone
    });
</script>

<script>
    jQuery('.js-tilt').tilt({
        scale: 1.1
    })
</script>