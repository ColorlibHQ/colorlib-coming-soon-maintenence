<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ccsm_options      = ccsm_get_options();
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
                <?php echo wp_kses( ccsm_icon('card-giftcard', 'cl0 fs-60'), ccsm_svg_allowed_html() ); ?>
            </p>

            <h1 class="l1-txt1 txt-center p-b-22" id="colorlib_coming_soon_page_heading">
				<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_heading'] ); ?>
            </h1>

            <p class="txt-center m2-txt1 p-b-67" id="colorlib_coming_soon_page_content">
				<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_content'] ); ?>
            </p>
			<?php if ( $counterActivation == '1' ) { ?>
                <div class="flex-w flex-sa-m cd100 bor1 p-t-42 p-b-22 p-l-50 p-r-50 respon1">
                    <div class="flex-col-c-m wsize2 m-b-20">
                        <span class="l1-txt2 p-b-4 days"><?php echo esc_html( $dates['template']['days'] ); ?></span>
                        <span class="m2-txt2"><?php echo esc_html__( 'Days', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>

                    <span class="l1-txt2 p-b-22">:</span>

                    <div class="flex-col-c-m wsize2 m-b-20">
                        <span class="l1-txt2 p-b-4 hours"><?php echo esc_html( $dates['template']['hours'] ); ?></span>
                        <span class="m2-txt2"><?php echo esc_html__( 'Hours', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>

                    <span class="l1-txt2 p-b-22 respon2">:</span>

                    <div class="flex-col-c-m wsize2 m-b-20">
                        <span class="l1-txt2 p-b-4 minutes"><?php echo esc_html( $dates['template']['minutes'] ); ?></span>
                        <span class="m2-txt2"><?php echo esc_html__( 'Minutes', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>

                    <span class="l1-txt2 p-b-22">:</span>

                    <div class="flex-col-c-m wsize2 m-b-20">
                        <span class="l1-txt2 p-b-4 seconds"><?php echo esc_html( $dates['template']['seconds'] ); ?></span>
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
                        <label class="ccsm-sr-only" for="ccsm-email-08"><?php echo esc_html__( 'Email Address', 'colorlib-coming-soon-maintenance' ); ?></label>
                        <input class="s1-txt1 placeholder0 input100" type="email" id="ccsm-email-08" name="EMAIL"
                               autocomplete="email"
                               placeholder="<?php echo esc_attr__( 'Email Address', 'colorlib-coming-soon-maintenance' ); ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <button class="flex-c-m s1-txt1 size2 how-btn trans-04 where1" name="subscribe">
						<?php echo esc_html__( 'Notify Me', 'colorlib-coming-soon-maintenance' ); ?>
                    </button>
                </form>
			<?php } ?>
        </div>
        <p style="position:absolute;bottom:0;right:30px;color:#fff;" class="colorlib-copyright"><span><?php esc_html_e('Coming Soon Template designed by','colorlib-coming-soon-maintenance'); ?></span> <a href="https://colorlib.com/" target="_blank" rel="noopener noreferrer">Colorlib</a></p>
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
        window.CCSM_COUNTDOWN = {
            year: <?php echo wp_json_encode( $dates['script']['year'] ); ?>,
            month: <?php echo wp_json_encode( $dates['script']['month'] ); ?>,
            day: <?php echo wp_json_encode( $dates['script']['day'] ); ?>,
            hour: <?php echo wp_json_encode( $dates['script']['hour'] ); ?>,
            minute: <?php echo wp_json_encode( $dates['script']['minute'] ); ?>,
            second: <?php echo wp_json_encode( $dates['script']['second'] ); ?>
        };
    </script>
<?php } ?>