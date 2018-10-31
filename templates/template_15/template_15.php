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

<div class="bg-img1 size1 overlay1 p-b-35 p-l-15 p-r-15" style="background-image: url('images/bg01.jpg');">
    <div class="flex-col-c p-t-160 p-b-215 respon1">
        <div class="wrappic1">
            <a href="#">
                <img src="images/icons/logo.png" alt="IMG">
            </a>
        </div>

        <h3 class="l1-txt1 txt-center p-t-30 p-b-100">
            Coming Soon
        </h3>

        <div class="cd100"></div>

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