<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ccsm_options      = ccsm_get_options();
$ccsm_counter_activation = $ccsm_options['colorlib_coming_soon_timer_activation'];
$ccsm_template          = $ccsm_options['colorlib_coming_soon_template_selection'];
$ccsm_counter           = $ccsm_options['colorlib_coming_soon_timer_option'];
$ccsm_dates             = ccsm_counter_dates( $ccsm_counter );

?>
    <div class="bg-g1 size1 flex-w flex-col-c-sb p-l-15 p-r-15 p-t-55 p-b-35 respon1">
        <span></span>
        <div class="flex-col-c p-t-50 p-b-50">
            <h1 class="l1-txt1 txt-center p-b-10" id="colorlib_coming_soon_page_heading">
				<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_heading'] ); ?>
            </h1>

            <p class="txt-center l1-txt2 p-b-60" id="colorlib_coming_soon_page_content">
				<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_content'] ); ?>
            </p>
			<?php if ( $ccsm_counter_activation == '1' ) { ?>
                <div class="flex-w flex-c cd100 p-b-82">
                    <div class="flex-col-c-m size2 how-countdown">
                        <span class="l1-txt3 p-b-9 days"><?php echo esc_html( $ccsm_dates['template']['days'] ); ?></span>
                        <span class="s1-txt1"><?php echo esc_html__( 'Days', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>

                    <div class="flex-col-c-m size2 how-countdown">
                        <span class="l1-txt3 p-b-9 hours"><?php echo esc_html( $ccsm_dates['template']['hours'] ); ?></span>
                        <span class="s1-txt1"><?php echo esc_html__( 'Hours', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>

                    <div class="flex-col-c-m size2 how-countdown">
                        <span class="l1-txt3 p-b-9 minutes"><?php echo esc_html( $ccsm_dates['template']['minutes'] ); ?></span>
                        <span class="s1-txt1"><?php echo esc_html__( 'Minutes', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>

                    <div class="flex-col-c-m size2 how-countdown">
                        <span class="l1-txt3 p-b-9 seconds"><?php echo esc_html( $ccsm_dates['template']['seconds'] ); ?></span>
                        <span class="s1-txt1"><?php echo esc_html__( 'Seconds', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>
                </div>
			<?php } ?>
			<?php 
			    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- public hook since 1.0; renaming would break sites that use it.
			    do_action('colorlib_coming_soon_before_forms'); 
 			    if ( $ccsm_options['colorlib_coming_soon_subscribe'] != '1' ) {  
			?>

                <button class="flex-c-m s1-txt2 size3 how-btn" data-ccsm-modal="subscribe">
					<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_footer'] ); ?>
                </button>

			<?php } ?>
        </div>

        <span class="s1-txt3 txt-center colorlib-copyright">
            <span><?php esc_html_e('Coming Soon Template designed by','colorlib-coming-soon-maintenance'); ?></span> <a href="https://colorlib.com/" target="_blank" rel="noopener noreferrer">Colorlib</a>
		</span>

    </div>
<?php 
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- public hook since 1.0; renaming would break sites that use it.
    do_action('colorlib_coming_soon_before_forms'); 
     if ( $ccsm_options['colorlib_coming_soon_subscribe'] != '1' ) {  
?>

    <div class="modal fade" id="subscribe" tabindex="-1" role="dialog" aria-labelledby="ccsm-modal-title-04" data-backdrop="true">
        <div class="modal-dialog" role="document">
            <div class="modal-subscribe where1-parent bg0 bor2 size4 p-t-54 p-b-100 p-l-15 p-r-15">
                <button class="btn-close-modal how-btn2 fs-26 where1 trans-04">
                    <?php echo wp_kses( ccsm_icon('close', '', esc_attr__( 'Close', 'colorlib-coming-soon-maintenance' )), ccsm_svg_allowed_html() ); ?>
                </button>

                <div class="wsize1 m-lr-auto">
                    <h3 class="m1-txt1 txt-center p-b-36" id="ccsm-modal-title-04">
                        <span class="bor1 p-b-6"><?php echo esc_html__( 'Subscribe', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </h3>

                    <p class="m1-txt2 txt-center p-b-40">
						<?php echo esc_html__( 'Follow us for update now!', 'colorlib-coming-soon-maintenance' ); ?>
                    </p>

                    <form class="contact100-form validate-form" novalidate
                          action="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_subscribe_form_url'] ); ?>" method="POST">
                        <div class="wrap-input100 m-b-10 validate-input"
                             data-validate="<?php echo esc_attr__( 'Name is required', 'colorlib-coming-soon-maintenance' ); ?>">
                            <label class="ccsm-sr-only" for="ccsm-fname-04"><?php echo esc_html__( 'Name', 'colorlib-coming-soon-maintenance' ); ?></label>
                            <input class="s1-txt4 placeholder0 input100" type="text" name="FNAME" id="ccsm-fname-04"
                                   autocomplete="given-name"
                                   placeholder="<?php echo esc_attr__( 'Name', 'colorlib-coming-soon-maintenance' ); ?>">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 m-b-20 validate-input"
                             data-validate="<?php echo esc_attr__( 'Email is required: ex@abc.xyz', 'colorlib-coming-soon-maintenance' ); ?>">
                            <label class="ccsm-sr-only" for="ccsm-email-04"><?php echo esc_html__( 'Email', 'colorlib-coming-soon-maintenance' ); ?></label>
                            <input class="s1-txt4 placeholder0 input100" type="email" name="EMAIL" id="ccsm-email-04"
                                   autocomplete="email"
                                   placeholder="<?php echo esc_attr__( 'Email', 'colorlib-coming-soon-maintenance' ); ?>">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="w-full">
                            <button class="flex-c-m s1-txt2 size5 how-btn1 trans-04" name="subscribe">
								<?php echo esc_html__( 'Get Updates', 'colorlib-coming-soon-maintenance' ); ?>
                            </button>
                        </div>
                    </form>

                    <p class="s1-txt5 txt-center wsize2 m-lr-auto p-t-20" id="colorlib_coming_soon_page_footer">
						<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_footer'] ); ?>
                    </p>
                </div>
            </div>

        </div>
    </div>

<?php } ?>
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
<?php if ( $ccsm_counter_activation == '1' && $ccsm_dates['script'] != false ) { ?>
    <script>
        window.CCSM_COUNTDOWN = {
            year: <?php echo wp_json_encode( $ccsm_dates['script']['year'] ); ?>,
            month: <?php echo wp_json_encode( $ccsm_dates['script']['month'] ); ?>,
            day: <?php echo wp_json_encode( $ccsm_dates['script']['day'] ); ?>,
            hour: <?php echo wp_json_encode( $ccsm_dates['script']['hour'] ); ?>,
            minute: <?php echo wp_json_encode( $ccsm_dates['script']['minute'] ); ?>,
            second: <?php echo wp_json_encode( $ccsm_dates['script']['second'] ); ?>
        };
    </script>
<?php } ?>