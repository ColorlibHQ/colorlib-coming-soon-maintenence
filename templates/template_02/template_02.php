<?php
$ccsm_options      = get_option( 'ccsm_settings' );
$counterActivation = $ccsm_options['colorlib_coming_soon_timer_activation'];
$template          = $ccsm_options['colorlib_coming_soon_template_selection'];
$counter           = $ccsm_options['colorlib_coming_soon_timer_option'];
$dates             = ccsm_counter_dates( $counter );
$bcg_url = ($ccsm_options['colorlib_coming_soon_background_image']) ?  $ccsm_options['colorlib_coming_soon_background_image'] : '';

if ( is_ssl()  ) {

	if ( !empty( $bcg_url ) ) {
		$bcg_url = str_replace( 'http://', 'https://', $ccsm_options['colorlib_coming_soon_background_image'] );
	}
}

if ( ccsm_template_has_text_color() ) {
	?>
    <style>
        h1,h2,h3,p,span,li {
            color: <?php echo esc_html($ccsm_options['colorlib_coming_soon_text_color']); ?> !important;
        }
    </style>
	<?php
}
?>
<div class="simpleslide100">
    <div class="simpleslide100-item bg-img1"
         style="background-image: url('<?php echo esc_url($bcg_url); ?>');background-color:<?php echo $ccsm_options['colorlib_coming_soon_background_color']; ?>;"></div>
</div>
<div class="size1 overlay1">
    <div class="size1 flex-col-c-m p-l-15 p-r-15 p-t-50 p-b-50">
        <h3 class="l1-txt1 txt-center p-b-25" id="colorlib_coming_soon_page_heading">
			<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_heading'] ); ?>
        </h3>

        <p class="m2-txt1 txt-center p-b-48" id="colorlib_coming_soon_page_content">
			<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_content'] ); ?>
        </p>
		<?php if ( $counterActivation == '1' ) { ?>
            <div class="flex-w flex-c-m cd100 p-b-33">
                <div class="flex-col-c-m size2 bor1 m-l-15 m-r-15 m-b-20">
                    <span class="l2-txt1 p-b-9 days"><?php echo $dates['template']['days']; ?></span>
                    <span class="s2-txt1"><?php echo esc_html__( 'Days', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>

                <div class="flex-col-c-m size2 bor1 m-l-15 m-r-15 m-b-20">
                    <span class="l2-txt1 p-b-9 hours"><?php echo $dates['template']['hours']; ?></span>
                    <span class="s2-txt1"><?php echo esc_html__( 'Hours', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>

                <div class="flex-col-c-m size2 bor1 m-l-15 m-r-15 m-b-20">
                    <span class="l2-txt1 p-b-9 minutes"><?php echo $dates['template']['minutes']; ?></span>
                    <span class="s2-txt1"><?php echo esc_html__( 'Minutes', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>

                <div class="flex-col-c-m size2 bor1 m-l-15 m-r-15 m-b-20">
                    <span class="l2-txt1 p-b-9 seconds"><?php echo $dates['template']['seconds']; ?></span>
                    <span class="s2-txt1"><?php echo esc_html__( 'Seconds', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>
            </div>
		<?php } ?>
		<?php 
		    do_action('colorlib_coming_soon_before_forms');
 		    if ( $ccsm_options['colorlib_coming_soon_subscribe'] != '1' ) {  
		?>
            <form class="w-full flex-w flex-c-m validate-form"
                  action="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_subscribe_form_url'] ); ?>" method="POST">

                <div class="wrap-input100 validate-input where1"
                     data-validate="<?php echo esc_attr__( 'Valid email is required: ex@abc.xyz', 'colorlib-coming-soon-maintenance' ); ?>">
                    <input class="input100 placeholder0 s2-txt2" type="text" name="EMAIL"
                           placeholder="<?php echo esc_attr__( 'Enter Email Address', 'colorlib-coming-soon-maintenance' ); ?>">
                    <span class="focus-input100"></span>
                </div>

                <button class="flex-c-m size3 s2-txt3 how-btn1 trans-04 where1" name="subscribe">
					<?php echo esc_html__( 'Subscribe', 'colorlib-coming-soon-maintenance' ); ?>
                </button>
            </form>
		<?php } ?>
        <p style="color:#fff;position:absolute;bottom:0;" class="colorlib-copyright"><span><?php _e('Coming Soon Template designed by','colorlib-coming-soon-maintenance'); ?></span>
            <a href="https://colorlib.com/" target="_blank" style="color:#fff">Colorlib</a></p>
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
