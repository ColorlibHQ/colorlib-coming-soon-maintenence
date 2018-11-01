<?php
$template = get_theme_mod( 'colorlib_coming_soon_template_selection' );

$styles = array(

	array(
		'name'     => 'main',
		'location' => 'css/main.css',
		'template' => $template
	),
	array(
		'name'     => 'util',
		'location' => 'css/util.css',
		'template' => $template
	)
);

colorlibStyleEnqueue( $styles );

$counter = get_theme_mod( 'colorlib_coming_soon_timer_option' );
$dates   = colorlibCounterDates( $counter );
//wp_head();
?>
<div class="size1 bg0 where1-parent">
    <!-- Countdown -->
    <div class="flex-c-m bg-img1 size2 where1 overlay1 where2 respon2"
         style="background-image: url('<?php echo CSMM_URL . 'templates/' . $template; ?>/images/bg01.jpg');">
        <div class="wsize2 flex-w flex-c-m cd100 js-tilt">
            <div class="flex-col-c-m size6 bor2 m-l-10 m-r-10 m-t-15">
                <span class="l2-txt1 p-b-9 days"><?php echo $dates['template']['days']; ?></span>
                <span class="s2-txt4"><?php _e( 'Days', 'colorlib-coming-soon' ); ?></span>
            </div>

            <div class="flex-col-c-m size6 bor2 m-l-10 m-r-10 m-t-15">
                <span class="l2-txt1 p-b-9 hours"><?php echo $dates['template']['hours']; ?></span>
                <span class="s2-txt4"><?php _e( 'Hours', 'colorlib-coming-soon' ); ?></span>
            </div>

            <div class="flex-col-c-m size6 bor2 m-l-10 m-r-10 m-t-15">
                <span class="l2-txt1 p-b-9 minutes"><?php echo $dates['template']['minutes']; ?></span>
                <span class="s2-txt4"><?php _e( 'Minutes', 'colorlib-coming-soon' ); ?></span>
            </div>

            <div class="flex-col-c-m size6 bor2 m-l-10 m-r-10 m-t-15">
                <span class="l2-txt1 p-b-9 seconds"><?php echo $dates['template']['seconds']; ?></span>
                <span class="s2-txt4"><?php _e( 'Seconds', 'colorlib-coming-soon' ); ?></span>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="size3 flex-col-sb flex-w p-l-75 p-r-75 p-t-45 p-b-45 respon1">
        <div class="wrap-pic1">
            <img src="<?php echo get_theme_mod( 'colorlib_coming_soon_plugin_logo' ); ?>" alt="LOGO">
        </div>

        <div class="p-t-50 p-b-60">
            <p class="m1-txt1 p-b-36" id="colorlib_coming_soon_page_heading">
				<?php echo get_theme_mod( 'colorlib_coming_soon_page_heading' ); ?>
            </p>
            <form class="contact100-form validate-form">
                <div class="wrap-input100 m-b-10 validate-input" data-validate="Name is required">
                    <input class="s2-txt1 placeholder0 input100" type="text" name="name" placeholder="Your Name">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 m-b-20 validate-input" data-validate="Email is required: ex@abc.xyz">
                    <input class="s2-txt1 placeholder0 input100" type="text" name="email" placeholder="Email Address">
                    <span class="focus-input100"></span>
                </div>

                <div class="w-full">
                    <button class="flex-c-m s2-txt2 size4 bg1 bor1 hov1 trans-04">
                        <?php echo _e('Subscribe','colorlib-coming-soon'); ?>
                    </button>
                </div>
            </form>

            <p class="s2-txt3 p-t-18" id="colorlib_coming_soon_page_footer">
                <?php echo get_theme_mod('colorlib_coming_soon_page_footer'); ?>
            </p>
        </div>

        <div class="flex-w">
            <a href="#" class="flex-c-m size5 bg3 how1 trans-04 m-r-5">
                <i class="fa fa-facebook"></i>
            </a>

            <a href="#" class="flex-c-m size5 bg4 how1 trans-04 m-r-5">
                <i class="fa fa-twitter"></i>
            </a>

            <a href="#" class="flex-c-m size5 bg5 how1 trans-04 m-r-5">
                <i class="fa fa-youtube-play"></i>
            </a>
        </div>
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
		'template' => $template
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
