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

<div class="bg-img1 size1 overlay1 p-t-24" style="background-image: url('images/bg01.jpg');">
    <div class="flex-w flex-sb-m p-l-80 p-r-74 p-b-175 respon5">
        <div class="wrappic1 m-r-30 m-t-10 m-b-10">
            <a href="#"><img src="images/icons/logo.png" alt="LOGO"></a>
        </div>

        <div class="flex-w m-t-10 m-b-10">
            <a href="#" class="size3 flex-c-m how-social trans-04 m-r-6">
                <i class="fa fa-facebook"></i>
            </a>

            <a href="#" class="size3 flex-c-m how-social trans-04 m-r-6">
                <i class="fa fa-twitter"></i>
            </a>

            <a href="#" class="size3 flex-c-m how-social trans-04 m-r-6">
                <i class="fa fa-youtube-play"></i>
            </a>
        </div>
    </div>

    <div class="flex-w flex-sa p-r-200 respon1">
        <div class="p-t-34 p-b-60 respon3">
            <p class="l1-txt1 p-b-10 respon2">
                Our website is
            </p>

            <h3 class="l1-txt2 p-b-45 respon2 respon4">
                Coming Soon
            </h3>

            <div class="cd100"></div>

        </div>

        <div class="bg0 wsize1 bor1 p-l-45 p-r-45 p-t-50 p-b-18 p-lr-15-sm">
            <h3 class="l1-txt3 txt-center p-b-43">
                Newsletter
            </h3>

            <form class="w-full validate-form">

                <div class="wrap-input100 validate-input m-b-10" data-validate="Name is required">
                    <input class="input100 placeholder0 s1-txt1" type="text" name="name" placeholder="Name">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-20" data-validate="Valid email is required: ex@abc.xyz">
                    <input class="input100 placeholder0 s1-txt1" type="text" name="email" placeholder="Email">
                    <span class="focus-input100"></span>
                </div>

                <button class="flex-c-m size2 s1-txt2 how-btn1 trans-04">
                    Subscribe
                </button>
            </form>

            <p class="s1-txt3 txt-center p-l-15 p-r-15 p-t-25">
                And don’t worry, we hate spam too! You can unsubcribe at anytime.
            </p>
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