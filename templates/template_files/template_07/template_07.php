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

<div class="bg-img1 size1 overlay1" style="background-image: url('images/bg01.jpg');">
	<div class="size1 p-l-15 p-r-15 p-t-30 p-b-50">
		<div class="flex-w flex-sb-m p-l-75 p-r-60 p-b-165 respon1">
			<div class="wrappic1 m-r-30 m-t-10 m-b-10">
				<a href="#"><img src="images/icons/logo.png" alt="LOGO"></a>
			</div>

			<div class="flex-w m-t-10 m-b-10">
				<a href="#" class="size4 flex-c-m how-social trans-04 m-r-5 m-b-3 m-t-3">
					<i class="fa fa-facebook"></i>
				</a>

				<a href="#" class="size4 flex-c-m how-social trans-04 m-r-5 m-b-3 m-t-3">
					<i class="fa fa-twitter"></i>
				</a>

				<a href="#" class="size4 flex-c-m how-social trans-04 m-r-5 m-b-3 m-t-3">
					<i class="fa fa-youtube-play"></i>
				</a>
			</div>
		</div>

		<div class="wsize1 m-lr-auto">
			<p class="txt-center l1-txt1 p-b-60">
				Our website is <span class="l1-txt2">Coming Soon</span>, follow us for update now!
			</p>

			<form class="w-full flex-w flex-c-m validate-form">

				<div class="wrap-input100 validate-input m-b-20" data-validate = "Valid email is required: ex@abc.xyz">
					<input class="input100 placeholder0 m1-txt1" type="text" name="email" placeholder="Email Address">
					<span class="focus-input100"></span>
				</div>


				<button class="flex-c-m size3 m1-txt2 how-btn1 trans-04 m-b-20">
					Subscribe
				</button>
			</form>

			<p class="txt-center s1-txt1 p-t-5">
				And don’t worry, we hate spam too! You can unsubcribe at anytime.
			</p>
		</div>


		<div class="flex-w flex-c-m cd100 wsize1 m-lr-auto p-t-116">
			<div class="flex-col-c-m size2 bor1 m-l-10 m-r-10 m-b-15">
				<span class="l1-txt3 p-b-9 days">35</span>
				<span class="s1-txt2">Days</span>
			</div>

			<div class="flex-col-c-m size2 bor1 m-l-10 m-r-10 m-b-15">
				<span class="l1-txt3 p-b-9 hours">17</span>
				<span class="s1-txt2">Hours</span>
			</div>

			<div class="flex-col-c-m size2 bor1 m-l-10 m-r-10 m-b-15">
				<span class="l1-txt3 p-b-9 minutes">50</span>
				<span class="s1-txt2">Minutes</span>
			</div>

			<div class="flex-col-c-m size2 bor1 m-l-10 m-r-10 m-b-15">
				<span class="l1-txt3 p-b-9 seconds">39</span>
				<span class="s1-txt2">Seconds</span>
			</div>
		</div>
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