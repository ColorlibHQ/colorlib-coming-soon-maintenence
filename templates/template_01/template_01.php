<?php

$ccsm_options      = get_option( 'ccsm_settings' );
$counterActivation = $ccsm_options['colorlib_coming_soon_timer_activation'];
$template          = $ccsm_options['colorlib_coming_soon_template_selection'];
$counter           = $ccsm_options['colorlib_coming_soon_timer_option'];
$dates             = ccsm_counter_dates( $counter );
$bcg_url           = ($ccsm_options['colorlib_coming_soon_background_image']) ? $ccsm_options['colorlib_coming_soon_background_image'] : '';
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
        .cd100 span {
            color: <?php echo esc_html($ccsm_options['colorlib_coming_soon_text_color']); ?> !important;
        }
    </style>
	<?php
}
?>
<div class="size1 bg0 where1-parent">
    <div class="flex-c-m bg-img1 size2 where1 overlay1 where2 respon2 wrap-pic1"
         style="background-image: url('<?php echo esc_url($bcg_url); ?>')">
		<?php if ( $counterActivation == '1' ) { ?>
            <div class="wsize2 flex-w flex-c-m cd100 js-tilt">
                <div class="flex-col-c-m size6 bor2 m-l-10 m-r-10 m-t-15">
                    <span class="l2-txt1 p-b-9 days"><?php echo $dates['template']['days']; ?></span>
                    <span class="s2-txt4"><?php echo esc_html__( 'Days', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>

                <div class="flex-col-c-m size6 bor2 m-l-10 m-r-10 m-t-15">
                    <span class="l2-txt1 p-b-9 hours"><?php echo $dates['template']['hours']; ?></span>
                    <span class="s2-txt4"><?php echo esc_html__( 'Hours', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>

                <div class="flex-col-c-m size6 bor2 m-l-10 m-r-10 m-t-15">
                    <span class="l2-txt1 p-b-9 minutes"><?php echo $dates['template']['minutes']; ?></span>
                    <span class="s2-txt4"><?php echo esc_html__( 'Minutes', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>

                <div class="flex-col-c-m size6 bor2 m-l-10 m-r-10 m-t-15">
                    <span class="l2-txt1 p-b-9 seconds"><?php echo $dates['template']['seconds']; ?></span>
                    <span class="s2-txt4"><?php echo esc_html__( 'Seconds', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>
            </div>
		<?php } ?>
    </div>

    <div class="size3 flex-col-sb flex-w p-l-75 p-r-75 p-t-45 p-b-45 respon1">
        <div class="wrap-pic1">
			<?php if ( $logo_url ) {
				?>
                <a href="<?php echo site_url(); ?>" class="logo-link"><img
                            src="<?php echo esc_url( $logo_url ); ?>"
                            alt="<?php echo get_bloginfo(); ?>"></a>
				<?php
			}
			?>
        </div>

        <div class="p-t-50 p-b-60">
            <p class="m1-txt1 p-b-36" id="colorlib_coming_soon_page_heading">
				<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_heading'] ); ?>
            </p>
			<?php 
			    do_action('colorlib_coming_soon_before_forms'); 
 			    if ( $ccsm_options['colorlib_coming_soon_subscribe'] != '1' ) {  
			?>
                <form class="contact100-form validate-form"
                      action="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_subscribe_form_url'] ); ?>" method="POST">
                    <div class="wrap-input100 m-b-10 validate-input"
                         data-validate="<?php echo esc_attr__( 'Name is required', 'colorlib-coming-soon-maintenance' ); ?>">
                        <input class="s2-txt1 placeholder0 input100" type="text" name="FNAME"
                               placeholder="<?php echo esc_attr__( 'Your Name', 'colorlib-coming-soon-maintenance' ); ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 m-b-20 validate-input"
                         data-validate="<?php echo esc_attr__( 'Email is required: ex@abc.xyz', 'colorlib-coming-soon-maintenance' ); ?>">
                        <input class="s2-txt1 placeholder0 input100" type="text" name="EMAIL"
                               placeholder="<?php echo esc_attr__( 'Email Address', 'colorlib-coming-soon-maintenance' ); ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="w-full">
                        <button class="flex-c-m s2-txt2 size4 bg1 bor1 hov1 trans-04" name="subscribe">
							<?php echo esc_html__( 'Subscribe', 'colorlib-coming-soon-maintenance' ); ?>
                        </button>
                    </div>
                </form>

                <p class="s2-txt3 p-t-18" id="colorlib_coming_soon_page_footer">
					<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_footer'] ); ?>
                </p>
			<?php } ?>
        </div>

        <div class="flex-w">
			<?php
			if ( $ccsm_options['colorlib_coming_soon_social_facebook'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_facebook'] ); ?>"
                   id="colorlib_coming_soon_social_facebook" class="flex-c-m size5 bg3 how1 trans-04 m-r-5">
                    <i class="fa fa-facebook"></i>
                </a>
				<?php
			}
			?>
			<?php
			if ( $ccsm_options['colorlib_coming_soon_social_twitter'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_twitter'] ); ?>"
                   id="colorlib_coming_soon_social_twitter" class="flex-c-m size5 bg4 how1 trans-04 m-r-5">
                    <i class="fa fa-twitter"></i>
                </a>
				<?php
			}

			if ( $ccsm_options['colorlib_coming_soon_social_youtube'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_youtube'] ); ?>"
                   id="colorlib_coming_soon_social_youtube" class="flex-c-m size5 bg5 how1 trans-04 m-r-5">
                    <i class="fa fa-youtube-play"></i>
                </a>
				<?php
			}

			if ( $ccsm_options['colorlib_coming_soon_social_email'] ) {
				?>
                <a href="mailto:<?php echo esc_html( antispambot( $ccsm_options['colorlib_coming_soon_social_email'] ) ); ?>"
                   id="colorlib_coming_soon_social_email" class="flex-c-m size5 bg3 how1 trans-04 m-r-5">
                    <i class="fa fa-envelope"></i>
                </a>
				<?php
			}

			if ( $ccsm_options['colorlib_coming_soon_social_pinterest'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_pinterest'] ); ?>"
                   id="colorlib_coming_soon_social_pinterest" class="flex-c-m size5 bg3 how1 trans-04 m-r-5">
                    <i class="fa fa-pinterest"></i>
                </a>
				<?php
			}
			if ( $ccsm_options['colorlib_coming_soon_social_instagram'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_instagram'] ); ?>"
                   id="colorlib_coming_soon_social_instagram" class="flex-c-m size5 bg3 how1 trans-04 m-r-5">
                    <i class="fa fa-instagram"></i>
                </a>
				<?php
			}
			?>
        </div>
        <p class="colorlib-copyright"><span><?php _e('Coming Soon Template designed by','colorlib-coming-soon-maintenance'); ?></span> <a href="https://colorlib.com/" target="_blank">Colorlib</a>
        </p>
    </div>
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
<?php if ( $counterActivation == '1' && $dates['script'] != false ) {
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
<?php } ?>
<script>
    jQuery('.js-tilt').tilt({
        scale: 1.1
    })
</script>
