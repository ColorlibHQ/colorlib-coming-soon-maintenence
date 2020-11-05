<?php
$ccsm_options      = get_option( 'ccsm_settings' );
$counterActivation = $ccsm_options['colorlib_coming_soon_timer_activation'];
$template          = $ccsm_options['colorlib_coming_soon_template_selection'];
$counter           = $ccsm_options['colorlib_coming_soon_timer_option'];
$dates             = ccsm_counter_dates( $counter );
$bcg_url           = ($ccsm_options['colorlib_coming_soon_background_image']) ?  $ccsm_options['colorlib_coming_soon_background_image'] : '';
$logo_url          = ($ccsm_options['colorlib_coming_soon_plugin_logo']) ? $ccsm_options['colorlib_coming_soon_plugin_logo'] : false;

if ( is_ssl()  ) {

	if(!empty($bcg_url)){
		$bcg_url = str_replace( 'http://', 'https://', $ccsm_options['colorlib_coming_soon_background_image'] );
	}

	if ( $logo_url ) {
		$logo_url = str_replace( 'http://', 'https://', $logo_url );
	}
}

if ( ccsm_template_has_text_color() ) {
	?>
    <style>
        h1, h2, h3, p, span, li, a:not(.sign-up) {
            color: <?php echo esc_html($ccsm_options['colorlib_coming_soon_text_color']); ?> !important;
        }
    </style>
	<?php
}
?>
    <div class="simpleslide100"
         style="background-color:<?php echo $ccsm_options['colorlib_coming_soon_background_color']; ?>;">
        <div class="simpleslide100-item bg-img1"
             style="background-image: url('<?php echo esc_url($bcg_url); ?>');"></div>
    </div>

    <div class="flex-col-c-sb size1 overlay1 p-l-75 p-r-75 p-t-20 p-b-40 p-lr-15-sm">
        <div class="w-full flex-w flex-sb-m">
            <div class="wrappic1 m-r-30 m-t-10 m-b-10">
				<?php if ( $logo_url ) {
					?>
                    <a href="<?php echo site_url(); ?>" class="logo-link"><img
                                src="<?php echo esc_url( $logo_url ); ?>"
                                alt="<?php echo get_bloginfo(); ?>"></a>
					<?php
				}
				?>
            </div>
			<?php if ( $counterActivation == '1' ) { ?>
                <div class="flex-w cd100 p-t-15 p-b-15 p-r-36">
                    <div class="flex-w flex-b m-r-22 m-t-8 m-b-8">
                        <span class="l1-txt1 wsize1 days"><?php echo $dates['template']['days']; ?></span>
                        <span class="m1-txt1 p-b-2"><?php echo esc_html__( 'Days', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>

                    <div class="flex-w flex-b m-r-22 m-t-8 m-b-8">
                        <span class="l1-txt1 wsize1 hours"><?php echo $dates['template']['hours']; ?></span>
                        <span class="m1-txt1 p-b-2"><?php echo esc_html__( 'Hr', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>

                    <div class="flex-w flex-b m-r-22 m-t-8 m-b-8">
                        <span class="l1-txt1 wsize1 minutes"><?php echo $dates['template']['minutes']; ?></span>
                        <span class="m1-txt1 p-b-2"><?php echo esc_html__( 'Min', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>

                    <div class="flex-w flex-b m-r-22 m-t-8 m-b-8">
                        <span class="l1-txt1 wsize1 seconds"><?php echo $dates['template']['seconds']; ?></span>
                        <span class="m1-txt1 p-b-2"><?php echo esc_html__( 'Sec', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>
                </div>
			<?php } ?>
			<?php if ( isset( $ccsm_options['colorlib_coming_soon_subscribe_form_other'] ) && '' != $ccsm_options['colorlib_coming_soon_subscribe_form_other'] ) { ?>
                <div class="m-t-10 m-b-10">
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_subscribe_form_other'] ); ?>"
                       class="size2 s1-txt1 flex-c-m how-btn1 trans-04 sign-up">
						<?php echo esc_html__( 'Sign Up', 'colorlib-coming-soon-maintenance' ); ?>
                    </a>
                </div>
			<?php } ?>
        </div>

        <div class="flex-col-c-m p-l-15 p-r-15 p-t-80 p-b-90">
            <h3 class="l1-txt2 txt-center p-b-55 respon1">
				<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_heading'] ); ?>
            </h3>

            <div>
                <button class="how-btn-play1 flex-c-m">
                    <i class="zmdi zmdi-play"></i>
                </button>
            </div>
        </div>

        <div class="flex-sb-m flex-w w-full">
            <div class="flex-w flex-c-m m-t-10 m-b-10">
				<?php
				if ( $ccsm_options['colorlib_coming_soon_social_facebook'] ) {
					?>
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_facebook'] ); ?>"
                       id="colorlib_coming_soon_social_facebook"
                       class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-3 m-t-3">
                        <i class="fa fa-facebook"></i>
                    </a>
					<?php
				}
				if ( $ccsm_options['colorlib_coming_soon_social_twitter'] ) {
					?>
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_twitter'] ); ?>"
                       id="colorlib_coming_soon_social_twitter"
                       class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-3 m-t-3">
                        <i class="fa fa-twitter"></i>
                    </a>
					<?php
				}
				if ( $ccsm_options['colorlib_coming_soon_social_youtube'] ) {
					?>
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_youtube'] ); ?>"
                       id="colorlib_coming_soon_social_youtube"
                       class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-3 m-t-3">
                        <i class="fa fa-youtube-play"></i>
                    </a>
					<?php
				}
				if ( $ccsm_options['colorlib_coming_soon_social_email'] ) {
					?>
                    <a href="mailto:<?php echo esc_html( antispambot( $ccsm_options['colorlib_coming_soon_social_email'] ) ); ?>"
                       id="colorlib_coming_soon_social_email"
                       class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-3 m-t-3">
                        <i class="fa fa-envelope"></i>
                    </a>
					<?php
				}
				if ( $ccsm_options['colorlib_coming_soon_social_pinterest'] ) {
					?>
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_pinterest'] ); ?>"
                       id="colorlib_coming_soon_social_pinterest"
                       class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-3 m-t-3">
                        <i class="fa fa-pinterest"></i>
                    </a>
					<?php
				}
				if ( $ccsm_options['colorlib_coming_soon_social_instagram'] ) {
					?>
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_instagram'] ); ?>"
                       id="colorlib_coming_soon_social_instagram"
                       class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-3 m-t-3">
                        <i class="fa fa-instagram"></i>
                    </a>
					<?php
				}
				?>

            </div>
			<?php 
			    do_action('colorlib_coming_soon_before_forms'); 
 			    if ( $ccsm_options['colorlib_coming_soon_subscribe'] != '1' ) {  
			?>
                <form class="contact100-form validate-form m-t-10 m-b-10"
                      action="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_subscribe_form_url'] ); ?>" method="POST">
                    <div class="wrap-input100 validate-input m-lr-auto-lg"
                         data-validate="<?php echo esc_attr__( 'Email is required: ex@abc.xyz', 'colorlib-coming-soon-maintenance' ); ?>">
                        <input class="s2-txt1 placeholder0 input100 trans-04" type="text" name="EMAIL"
                               placeholder="<?php echo esc_attr__( 'Email Address', 'colorlib-coming-soon-maintenance' ); ?>">

                        <button class="flex-c-m ab-t-r size4 s1-txt1 hov1" name="subscribe">
                            <i class="zmdi zmdi-long-arrow-right fs-16 cl1 trans-04"></i>
                        </button>
                    </div>
                </form>
			<?php } ?>
        </div>
        <p style="color:#fff;" class="colorlib-copyright"><span><?php _e('Coming Soon Template designed by','colorlib-coming-soon-maintenance'); ?></span> <a
                    href="https://colorlib.com/" target="_blank">Colorlib</a></p>
    </div>

<?php
if ( is_customize_preview() ) {
	?>
    <div style="display:none !important;">
		<?php
		wp_footer();
		?>
    </div>
	<?php
}
?>
<?php if ( $counterActivation == '1' && $dates['script'] != false ) { ?>
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
<?php } ?>