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
	<div class="simpleslide100-item bg-img1" style="background-image: url('images/bg01.jpg');"></div>
	<div class="simpleslide100-item bg-img1" style="background-image: url('images/bg02.jpg');"></div>
	<div class="simpleslide100-item bg-img1" style="background-image: url('images/bg03.jpg');"></div>
	<div class="simpleslide100-item bg-img1" style="background-image: url('images/bg04.jpg');"></div>
</div>

<div class="flex-col-c-sb size1 overlay1 p-l-75 p-r-75 p-t-20 p-b-40 p-lr-15-sm">
	<!--  -->
	<div class="w-full flex-w flex-sb-m">
		<div class="wrappic1 m-r-30 m-t-10 m-b-10">
			<a href="#"><img src="images/icons/logo.png" alt="LOGO"></a>
		</div>

		<div class="flex-w cd100 p-t-15 p-b-15 p-r-36">
			<div class="flex-w flex-b m-r-22 m-t-8 m-b-8">
				<span class="l1-txt1 wsize1 days">35</span>
				<span class="m1-txt1 p-b-2">Days</span>
			</div>

			<div class="flex-w flex-b m-r-22 m-t-8 m-b-8">
				<span class="l1-txt1 wsize1 hours">17</span>
				<span class="m1-txt1 p-b-2">Hr</span>
			</div>

			<div class="flex-w flex-b m-r-22 m-t-8 m-b-8">
				<span class="l1-txt1 wsize1 minutes">50</span>
				<span class="m1-txt1 p-b-2">Min</span>
			</div>

			<div class="flex-w flex-b m-r-22 m-t-8 m-b-8">
				<span class="l1-txt1 wsize1 seconds">39</span>
				<span class="m1-txt1 p-b-2">Sec</span>
			</div>
		</div>

		<div class="m-t-10 m-b-10">
			<a href="#" class="size2 s1-txt1 flex-c-m how-btn1 trans-04">
				Sign Up
			</a>
		</div>
	</div>

	<!--  -->
	<div class="flex-col-c-m p-l-15 p-r-15 p-t-80 p-b-90">
		<h3 class="l1-txt2 txt-center p-b-55 respon1">
			Coming Soon
		</h3>

		<div>
			<button class="how-btn-play1 flex-c-m">
				<i class="zmdi zmdi-play"></i>
			</button>
		</div>
	</div>

	<div class="flex-sb-m flex-w w-full">
		<!--  -->
		<div class="flex-w flex-c-m m-t-10 m-b-10">
			<a href="#" class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-3 m-t-3">
				<i class="fa fa-facebook"></i>
			</a>

			<a href="#" class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-3 m-t-3">
				<i class="fa fa-twitter"></i>
			</a>

			<a href="#" class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-3 m-t-3">
				<i class="fa fa-youtube-play"></i>
			</a>
		</div>

		<form class="contact100-form validate-form m-t-10 m-b-10">
			<div class="wrap-input100 validate-input m-lr-auto-lg" data-validate = "Email is required: ex@abc.xyz">
				<input class="s2-txt1 placeholder0 input100 trans-04" type="text" name="email" placeholder="Email Address">

				<button class="flex-c-m ab-t-r size4 s1-txt1 hov1">
					<i class="zmdi zmdi-long-arrow-right fs-16 cl1 trans-04"></i>
				</button>
			</div>
		</form>
	</div>
</div>
<?php

$scripts = array(
	array(
		'name'     => 'popper',
		'location' => 'vendor/bootstrap/js/popper.js',
		'template' => 'global',
	),
	array(
		'name'     => 'bootstrap',
		'location' => 'vendor/bootstrap/js/bootstrap.min.js',
		'template' => 'global'
	),
	array(
		'name'     => 'popper',
		'location' => 'vendor/bootstrap/js/popper.js',
		'template' => 'global'
	),
	array(
		'name'     => 'select2',
		'location' => 'vendor/select2/select2.min.js',
		'template' => 'global'
	),
	array(
		'name'     => 'moment',
		'location' => 'vendor/countdowntime/moment.min.js',
		'template' => 'global'
	),
	array(
		'name'     => 'timezone',
		'location' => 'vendor/countdowntime/moment-timezone-with-data.min.js',
		'template' => 'global'
	),
	array(
		'name'     => 'coutdowntime',
		'location' => 'vendor/countdowntime/countdowntime.js',
		'template' => 'global'
	),
	array(
		'name'     => 'tilt',
		'location' => 'vendor/tilt/tilt.jquery.min.js',
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