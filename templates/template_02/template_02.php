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

style_enqueue( $styles );

$counter = get_option( 'colorlib_coming_soon_timer_option' );
$dates   = counter_dates( $counter );
?>
</head>
<body>
<!--  -->
<div class="simpleslide100">
    <div class="simpleslide100-item bg-img1"
         style="background-image: url('<?php echo CSMM_URL . 'templates/' . $template; ?>/images/bg01.jpg');"></div>
    <div class="simpleslide100-item bg-img1"
         style="background-image: url('<?php echo CSMM_URL . 'templates/' . $template; ?>/images/bg02.jpg');"></div>
    <div class="simpleslide100-item bg-img1"
         style="background-image: url(''<?php echo CSMM_URL . 'templates/' . $template; ?>/images/bg03.jpg');"></div>
</div>

<div class="size1 overlay1">
    <!--  -->
    <div class="size1 flex-col-c-m p-l-15 p-r-15 p-t-50 p-b-50">
        <h3 class="l1-txt1 txt-center p-b-25" id="colorlib_coming_soon_page_heading">
            <?php echo get_option('colorlib_coming_soon_page_heading'); ?>
        </h3>

        <p class="m2-txt1 txt-center p-b-48" id="colorlib_coming_soon_page_content">
            <?php echo get_option('colorlib_coming_soon_page_content'); ?>
        </p>

        <div class="flex-w flex-c-m cd100 p-b-33">
            <div class="flex-col-c-m size2 bor1 m-l-15 m-r-15 m-b-20">
                <span class="l2-txt1 p-b-9 days"><?php echo $dates['template']['days']; ?></span>
                <span class="s2-txt1"><?php _e( 'Days', 'colorlib-coming-soon' ); ?></span>
            </div>

            <div class="flex-col-c-m size2 bor1 m-l-15 m-r-15 m-b-20">
                <span class="l2-txt1 p-b-9 hours"><?php echo $dates['template']['hours']; ?></span>
                <span class="s2-txt1"><?php echo _e( 'Hours', 'colorlib-coming-soon' ); ?></span>
            </div>

            <div class="flex-col-c-m size2 bor1 m-l-15 m-r-15 m-b-20">
                <span class="l2-txt1 p-b-9 minutes"><?php echo $dates['template']['minutes']; ?></span>
                <span class="s2-txt1"><?php echo _e( 'Minutes', 'colorlib-coming-soon' ); ?></span>
            </div>

            <div class="flex-col-c-m size2 bor1 m-l-15 m-r-15 m-b-20">
                <span class="l2-txt1 p-b-9 seconds"><?php echo $dates['template']['seconds']; ?></span>
                <span class="s2-txt1"><?php echo _e( 'Seconds', 'colorlib-coming-soon' ); ?></span>
            </div>
        </div>

        <form class="w-full flex-w flex-c-m validate-form">

            <div class="wrap-input100 validate-input where1" data-validate="Valid email is required: ex@abc.xyz">
                <input class="input100 placeholder0 s2-txt2" type="text" name="email" placeholder="Enter Email Address">
                <span class="focus-input100"></span>
            </div>


            <button class="flex-c-m size3 s2-txt3 how-btn1 trans-04 where1">
				<?php _e( 'Subscribe', 'colorlib-coming-soon' ); ?>
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

script_enqueue( $scripts );

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
