<?php

$template = get_option( 'colorlib_coming_soon_template_selection' );
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

$counter = get_option( 'colorlib_coming_soon_timer_option' );
$dates   = colorlibCounterDates( $counter );
?>
</head>
<body>

<div class="bg-img1 overlay1 size1 flex-w flex-c-m p-t-55 p-b-55 p-l-15 p-r-15"
     style="background-image: url('<?php echo CSMM_URL . 'templates/' . $template; ?>/images/bg01.jpg');">
    <div class="wsize1">
        <p class="txt-center p-b-23">
            <i class="zmdi zmdi-card-giftcard cl0 fs-60"></i>
        </p>

        <h3 class="l1-txt1 txt-center p-b-22" id="colorlib_coming_soon_page_heading">
			<?php echo get_option( 'colorlib_coming_soon_page_heading' ); ?>
        </h3>

        <p class="txt-center m2-txt1 p-b-67">
			<?php echo get_option( 'colorlib_coming_soon_page_content' ); ?>
        </p>

        <div class="flex-w flex-sa-m cd100 bor1 p-t-42 p-b-22 p-l-50 p-r-50 respon1">
            <div class="flex-col-c-m wsize2 m-b-20">
                <span class="l1-txt2 p-b-4 days"><?php echo $dates['template']['days']; ?></span>
                <span class="m2-txt2"><?php echo _e( 'Days', 'colorlib-coming-soon' ); ?></span>
            </div>

            <span class="l1-txt2 p-b-22">:</span>

            <div class="flex-col-c-m wsize2 m-b-20">
                <span class="l1-txt2 p-b-4 hours"><?php echo $dates['template']['hours']; ?></span>
                <span class="m2-txt2"><?php echo _e( 'Hours', 'colorlib-coming-soon' ); ?></span>
            </div>

            <span class="l1-txt2 p-b-22 respon2">:</span>

            <div class="flex-col-c-m wsize2 m-b-20">
                <span class="l1-txt2 p-b-4 minutes"><?php echo $dates['template']['minutes']; ?></span>
                <span class="m2-txt2"><?php echo _e( 'Minutes', 'colorlib-coming-soon' ); ?></span>
            </div>

            <span class="l1-txt2 p-b-22">:</span>

            <div class="flex-col-c-m wsize2 m-b-20">
                <span class="l1-txt2 p-b-4 seconds"><?php echo $dates['template']['seconds']; ?></span>
                <span class="m2-txt2"><?php echo _e( 'Seconds', 'colorlib-coming-soon' ); ?></span>
            </div>
        </div>

        <form class="flex-w flex-c-m contact100-form validate-form p-t-70">
            <div class="wrap-input100 validate-input where1" data-validate="Email is required: ex@abc.xyz">
                <input class="s1-txt1 placeholder0 input100" type="text" name="email" placeholder="Email Address">
                <span class="focus-input100"></span>
            </div>

            <button class="flex-c-m s1-txt1 size2 how-btn trans-04 where1">
				<?php echo _e( 'Notify Me', 'colorlib-coming-soon' ); ?>
            </button>
        </form>
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
		'name'     => 'moment-timezone',
		'location' => 'js/vendor/countdowntime/moment-timezone.min.js',
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
        endtimeHours: <?php echo $dates['script']['hour']; ?>,
        endtimeMinutes: <?php echo $dates['script']['minute']; ?>,
        endtimeSeconds: <?php echo $dates['script']['second']; ?>,
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