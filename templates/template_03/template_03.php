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
//wp_head();
?>

<div class="bg-img1 size1 flex-w flex-c-m p-t-55 p-b-55 p-l-15 p-r-15"
     style="background-image: url('images/bg01.jpg');">
    <div class="wsize1 bor1 bg1 p-t-175 p-b-45 p-l-15 p-r-15 respon1">
        <div class="wrappic1">
            <img src="images/icons/logo.png" alt="LOGO">
        </div>

        <p class="txt-center m1-txt1 p-t-33 p-b-68" id="colorlib_coming_soon_page_content">
            <?php echo get-theme_mod('colorlib_coming_soon_page_heading'); ?>
        </p>

        <div class="wsize2 flex-w flex-c hsize1 cd100">
            <div class="flex-col-c-m size2 how-countdown">
                <span class="l1-txt1 p-b-9 days"><?php echo $dates['template']['days']; ?></span>
                <span class="s1-txt1"><?php echo _e( 'Days', 'colorlib-coming-soon' ); ?></span>
            </div>

            <div class="flex-col-c-m size2 how-countdown">
                <span class="l1-txt1 p-b-9 hours"><?php echo $dates['template']['hours']; ?></span>
                <span class="s1-txt1"><?php echo _e( 'Hours', 'colorlib-coming-soon' ); ?></span>
            </div>

            <div class="flex-col-c-m size2 how-countdown">
                <span class="l1-txt1 p-b-9 minutes"><?php echo $dates['template']['minutes']; ?></span>
                <span class="s1-txt1"><?php echo _e( 'Minutes', 'colorlib-coming-soon' ); ?></span>
            </div>

            <div class="flex-col-c-m size2 how-countdown">
                <span class="l1-txt1 p-b-9 seconds"><?php echo $dates['template']['seconds']; ?></span>
                <span class="s1-txt1"><?php echo _e( 'Seconds', 'colorlib-coming-soon' ); ?></span>
            </div>
        </div>

        <form class="flex-w flex-c-m contact100-form validate-form p-t-55">
            <div class="wrap-input100 validate-input where1" data-validate="Email is required: ex@abc.xyz">
                <input class="s1-txt2 placeholder0 input100" type="text" name="email" placeholder="Your Email">
                <span class="focus-input100"></span>
            </div>


            <button class="flex-c-m s1-txt3 size3 how-btn trans-04 where1">
				<?php echo _e( 'Get Notified', 'colorlib-coming-soon' ); ?>
            </button>

        </form>

        <p class="s1-txt4 txt-center p-t-10" id="colorlib_coming_soon_page_footer">
            <?php echo get_theme_mod('colorlib_coming_soon_page_footer'); ?>
        </p>

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
        endtimeYear: 0,
        endtimeMonth: 0,
        endtimeDate: 35,
        endtimeHours: 18,
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
