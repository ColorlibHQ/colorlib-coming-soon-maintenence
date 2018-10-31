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

<div class="bg-g1 size1 flex-w flex-col-c-sb p-l-15 p-r-15 p-b-30">
    <div class="flex-w flex-c cd100 wsize1 bor1">
        <div class="flex-col-c-m size2 bg0 bor2">
            <span class="l1-txt3 p-b-7 days">35</span>
            <span class="s1-txt1">Days</span>
        </div>

        <div class="flex-col-c-m size2 bg0 bor2">
            <span class="l1-txt3 p-b-7 hours">17</span>
            <span class="s1-txt1">Hours</span>
        </div>

        <div class="flex-col-c-m size2 bg0 bor2">
            <span class="l1-txt3 p-b-7 minutes">50</span>
            <span class="s1-txt1">Minutes</span>
        </div>

        <div class="flex-col-c-m size2 bg0">
            <span class="l1-txt3 p-b-7 seconds">39</span>
            <span class="s1-txt1">Seconds</span>
        </div>
    </div>


    <div class="flex-col-c w-full p-t-50 p-b-80">
        <h3 class="l1-txt1 txt-center p-b-10">
            Coming Soon
        </h3>

        <p class="txt-center l1-txt2 p-b-43 wsize2">
            Our website is under construction, follow us for update now!
        </p>

        <form class="flex-w flex-c-m w-full contact100-form validate-form">
            <div class="wrap-input100 validate-input where1" data-validate="Name is required">
                <input class="s1-txt3 placeholder0 input100" type="text" name="name" placeholder="Name">
            </div>

            <div class="wrap-input100 validate-input where1" data-validate="Email is required: ex@abc.xyz">
                <input class="s1-txt3 placeholder0 input100" type="text" name="email" placeholder="Email">
            </div>

            <button class="flex-c-m s1-txt4 size3 how-btn trans-04 where1">
                Get Updates
            </button>

        </form>
    </div>

    <span class="s1-txt2 txt-center">
			@ 2017 Coming Soon Template. Designed by Colorlib
		</span>

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