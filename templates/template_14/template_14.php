<?php
$ccsm_options = get_option( 'ccsm_settings' );
$styles       = array(
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

$template = $ccsm_options['colorlib_coming_soon_template_selection'];
$counter  = $ccsm_options['colorlib_coming_soon_timer_option']s;
$dates = counter_dates( $counter );
?>
</head>
<body>

<div class="simpleslide100">
    <div class="simpleslide100-item bg-img1"
         style="background-image: url('<?php echo CCSM_URL . 'templates/' . $template; ?>/images/bg01.jpg');"></div>
    <div class="simpleslide100-item bg-img1"
         style="background-image: url('<?php echo CCSM_URL . 'templates/' . $template; ?>/images/bg02.jpg');"></div>
    <div class="simpleslide100-item bg-img1"
         style="background-image: url('<?php echo CCSM_URL . 'templates/' . $template; ?>/images/bg03.jpg');"></div>
    <div class="simpleslide100-item bg-img1"
         style="background-image: url('<?php echo CCSM_URL . 'templates/' . $template; ?>/images/bg04.jpg');"></div>
</div>

<div class="flex-w flex-str size1 overlay1">
    <div class="flex-w flex-col-sb wsize1 bg0 p-l-70 p-t-37 p-b-52 p-r-50 respon1">
        <div class="wrappic1">
			<?php if ( $ccsm_options['colorlib_coming_soon_plugin_logo'] ) {
				?>
                <a href="#"><img src="<?php echo $ccsm_options['colorlib_coming_soon_plugin_logo']; ?>"
                                 alt="LOGO"></a>
				<?php
			}
			?>
        </div>

        <div class="w-full p-t-100 p-b-90 p-l-48 p-l-0-md">

            <h3 class="l1-txt1 p-b-34 respon3" id="colorlib_coming_soon_page_heading">
				<?php echo $ccsm_options['colorlib_coming_soon_page_heading']; ?>
            </h3>

            <p class="m2-txt1 p-b-46" id="colorlib_coming_soon_page_content">
				<?php echo $ccsm_options['colorlib_coming_soon_page_content']; ?>
            </p>

            <form class="contact100-form validate-form m-t-10 m-b-10">
                <div class="wrap-input100 validate-input m-lr-auto-lg" data-validate="Email is required: ex@abc.xyz">
                    <input class="s2-txt1 placeholder0 input100 trans-04" type="text" name="email"
                           placeholder="Email Address">

                    <button class="flex-c-m ab-t-r size2 hov1 respon5">
                        <i class="zmdi zmdi-long-arrow-right fs-30 cl1 trans-04"></i>
                    </button>

                    <div class="flex-c-m ab-t-l s2-txt1 size4 bor1 respon4">
                        <span><?php echo _e( 'Subcribe Now', 'colorlib-coming-soon' ); ?>:</span>
                    </div>
                </div>
            </form>

        </div>

        <div class="flex-w flex-m">
				<span class="m2-txt2 p-r-40">
					<?php echo _e( 'Follow us', 'colorlib-coming-soon' ); ?>
				</span>
			<?php
			if ( $ccsm_options['colorlib_coming_soon_social_facebook'] ) {
				?>
                <a href="<?php echo $ccsm_options['colorlib_coming_soon_social_facebook']; ?>"
                   id="colorlib_coming_soon_social_facebook"
                   class="size3 flex-c-m how-social trans-04 m-r-15 m-b-5 m-t-5">
                    <i class="fa fa-facebook"></i>
                </a>
				<?php
			}
			if ( $ccsm_options['colorlib_coming_soon_social_twitter'] ) {
				?>
                <a href="<?php echo $ccsm_options['colorlib_coming_soon_social_twitter']; ?>"
                   id="colorlib_coming_soon_social_twitter"
                   class="size3 flex-c-m how-social trans-04 m-r-15 m-b-5 m-t-5">
                    <i class="fa fa-twitter"></i>
                </a>
				<?php
			}
			if ( $ccsm_options['colorlib_coming_soon_social_youtube'] ) {
				?>
                <a href="<?php echo $ccsm_options['colorlib_coming_soon_social_youtube']; ?>"
                   id="colorlib_coming_soon_social_youtube"
                   class="size3 flex-c-m how-social trans-04 m-r-15 m-b-5 m-t-5">
                    <i class="fa fa-youtube-play"></i>
                </a>
				<?php
			}
			if ( $ccsm_options['colorlib_coming_soon_social_email'] ) {
				?>
                <a href="mailto:<?php echo $ccsm_options['colorlib_coming_soon_social_email']; ?>"
                   id="colorlib_coming_soon_social_email"
                   class="size3 flex-c-m how-social trans-04 m-r-15 m-b-5 m-t-5">
                    <i class="fa fa-envelope"></i>
                </a>
				<?php
			}
			if ( $ccsm_options['colorlib_coming_soon_social_pinterest'] ) {
				?>
                <a href="<?php echo $ccsm_options['colorlib_coming_soon_social_pinterest']; ?>"
                   id="colorlib_coming_soon_social_pinterest"
                   class="size3 flex-c-m how-social trans-04 m-r-15 m-b-5 m-t-5">
                    <i class="fa fa-pinterest"></i>
                </a>
				<?php
			}
			if ( $ccsm_options['colorlib_coming_soon_social_instagram'] ) {
				?>
                <a href="<?php echo $ccsm_options['colorlib_coming_soon_social_instagram']; ?>"
                   id="colorlib_coming_soon_social_instagram"
                   class="size3 flex-c-m how-social trans-04 m-r-15 m-b-5 m-t-5">
                    <i class="fa fa-instagram"></i>
                </a>
				<?php
			}
			?>


        </div>
    </div>


    <div class="wsize2 bg-img1 respon2"
         style="background-image: url('<?php echo CCSM_URL . 'templates/' . $template; ?>/images/bg01.jpg');">
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