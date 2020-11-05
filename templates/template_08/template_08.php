<?php
$ccsm_options      = get_option( 'ccsm_settings' );
$counterActivation = $ccsm_options['colorlib_coming_soon_timer_activation'];
$template          = $ccsm_options['colorlib_coming_soon_template_selection'];
$counter           = $ccsm_options['colorlib_coming_soon_timer_option'];
$dates             = ccsm_counter_dates( $counter );
$bcg_url           = ($ccsm_options['colorlib_coming_soon_background_image']) ?  $ccsm_options['colorlib_coming_soon_background_image'] : '';

if ( is_ssl()  ) {

	if(!empty($bcg_url)){
		$bcg_url = str_replace( 'http://', 'https://', $ccsm_options['colorlib_coming_soon_background_image'] );
	}
}
?>
    <div class="bg-img1 overlay1 size1 flex-w flex-c-m p-t-55 p-b-55 p-l-15 p-r-15"
         style="background-image: url('<?php echo esc_url($bcg_url); ?>');">
        <div class="wsize1">
            <p class="txt-center p-b-23">
                <i class="zmdi zmdi-card-giftcard cl0 fs-60"></i>
            </p>

            <h3 class="l1-txt1 txt-center p-b-22" id="colorlib_coming_soon_page_heading">
				<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_heading'] ); ?>
            </h3>

            <p class="txt-center m2-txt1 p-b-67" id="colorlib_coming_soon_page_content">
				<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_content'] ); ?>
            </p>
			<?php if ( $counterActivation == '1' ) { ?>
                <div class="flex-w flex-sa-m cd100 bor1 p-t-42 p-b-22 p-l-50 p-r-50 respon1">
                    <div class="flex-col-c-m wsize2 m-b-20">
                        <span class="l1-txt2 p-b-4 days"><?php echo $dates['template']['days']; ?></span>
                        <span class="m2-txt2"><?php echo esc_html__( 'Days', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>

                    <span class="l1-txt2 p-b-22">:</span>

                    <div class="flex-col-c-m wsize2 m-b-20">
                        <span class="l1-txt2 p-b-4 hours"><?php echo $dates['template']['hours']; ?></span>
                        <span class="m2-txt2"><?php echo esc_html__( 'Hours', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>

                    <span class="l1-txt2 p-b-22 respon2">:</span>

                    <div class="flex-col-c-m wsize2 m-b-20">
                        <span class="l1-txt2 p-b-4 minutes"><?php echo $dates['template']['minutes']; ?></span>
                        <span class="m2-txt2"><?php echo esc_html__( 'Minutes', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>

                    <span class="l1-txt2 p-b-22">:</span>

                    <div class="flex-col-c-m wsize2 m-b-20">
                        <span class="l1-txt2 p-b-4 seconds"><?php echo $dates['template']['seconds']; ?></span>
                        <span class="m2-txt2"><?php echo esc_html__( 'Seconds', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>
                </div>
			<?php } ?>
			<?php 
			    do_action('colorlib_coming_soon_before_forms'); 
 			    if ( $ccsm_options['colorlib_coming_soon_subscribe'] != '1' ) {  
			?>
                <form class="flex-w flex-c-m contact100-form validate-form p-t-70"
                      action="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_subscribe_form_url'] ); ?>" method="POST">
                    <div class="wrap-input100 validate-input where1"
                         data-validate="<?php echo esc_attr__( 'Email is required: ex@abc.xyz', 'colorlib-coming-soon-maintenance' ); ?>">
                        <input class="s1-txt1 placeholder0 input100" type="text" name="EMAIL"
                               placeholder="<?php echo esc_attr__( 'Email Address', 'colorlib-coming-soon-maintenance' ); ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <button class="flex-c-m s1-txt1 size2 how-btn trans-04 where1" name="subscribe">
						<?php echo esc_html__( 'Notify Me', 'colorlib-coming-soon-maintenance' ); ?>
                    </button>
                </form>
			<?php } ?>
        </div>
        <p style="position:absolute;bottom:0;right:30px;color:#fff;" class="colorlib-copyright"><span><?php _e('Coming Soon Template designed by','colorlib-coming-soon-maintenance'); ?></span> <a href="https://colorlib.com/" target="_blank">Colorlib</a></p>
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