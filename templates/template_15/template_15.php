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
$ccsm_bcg_url           = ($ccsm_options['colorlib_coming_soon_background_image']) ?  $ccsm_options['colorlib_coming_soon_background_image'] : '';
$ccsm_logo_url          = ($ccsm_options['colorlib_coming_soon_plugin_logo']) ? $ccsm_options['colorlib_coming_soon_plugin_logo'] : false;
if ( is_ssl()  ) {

	if(!empty($ccsm_bcg_url)){
		$ccsm_bcg_url = str_replace( 'http://', 'https://', $ccsm_options['colorlib_coming_soon_background_image'] );
	}

	if ( $ccsm_logo_url ) {
		$ccsm_logo_url = str_replace( 'http://', 'https://', $ccsm_logo_url );
	}
}
?>
    <div class="simpleslide100">
        <div class="simpleslide100-item bg-img1"
             style="background-image: url('<?php echo esc_url($ccsm_bcg_url); ?>');"></div>
    </div>

    <div class="bg-img1 size1 overlay1 p-b-35 p-l-15 p-r-15"
         style="background-image: url('<?php echo esc_url($ccsm_bcg_url); ?>');">
        <div class="flex-col-c p-t-160 p-b-215 respon1">
            <div class="wrappic1">
				<?php if ( $ccsm_logo_url) {
					?>
                    <a href="<?php echo esc_url( site_url() ); ?>" class="logo-link"><img
                                src="<?php echo esc_url( $ccsm_logo_url ); ?>"
                                alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"></a>
					<?php
				}
				?>
            </div>

            <h1 class="l1-txt1 txt-center p-t-30 p-b-100" id="colorlib_coming_soon_page_heading">
				<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_heading'] ); ?>
            </h1>

			<?php if ( $ccsm_counter_activation == '1' ) { ?>
                <div class="cd100 ccsm-cd">
                    <div class="ccsm-cd-item">
                        <span class="ccsm-cd-num days"><?php echo esc_html( $ccsm_dates['template']['days'] ); ?></span>
                        <span class="ccsm-cd-label"><?php echo esc_html__( 'Days', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>
                    <div class="ccsm-cd-item">
                        <span class="ccsm-cd-num hours"><?php echo esc_html( $ccsm_dates['template']['hours'] ); ?></span>
                        <span class="ccsm-cd-label"><?php echo esc_html__( 'Hours', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>
                    <div class="ccsm-cd-item">
                        <span class="ccsm-cd-num minutes"><?php echo esc_html( $ccsm_dates['template']['minutes'] ); ?></span>
                        <span class="ccsm-cd-label"><?php echo esc_html__( 'Minutes', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>
                    <div class="ccsm-cd-item">
                        <span class="ccsm-cd-num seconds"><?php echo esc_html( $ccsm_dates['template']['seconds'] ); ?></span>
                        <span class="ccsm-cd-label"><?php echo esc_html__( 'Seconds', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>
                </div><?php } ?>

        </div>
        <div class="flex-w flex-c-m p-b-35">
			<?php
			if ( $ccsm_options['colorlib_coming_soon_social_facebook'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_facebook'] ); ?>"
                   id="colorlib_coming_soon_social_facebook"
                   class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-5">
                    <?php echo wp_kses( ccsm_icon('facebook'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}
			if ( $ccsm_options['colorlib_coming_soon_social_twitter'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_twitter'] ); ?>"
                   id="colorlib_coming_soon_social_twitter"
                   class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-5">
                    <?php echo wp_kses( ccsm_icon('twitter'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}
			if ( $ccsm_options['colorlib_coming_soon_social_youtube'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_youtube'] ); ?>"
                   id="colorlib_coming_soon_social_youtube"
                   class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-5">
                    <?php echo wp_kses( ccsm_icon('youtube-play'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}
			if ( $ccsm_options['colorlib_coming_soon_social_email'] ) {
				?>
                <a href="mailto:<?php echo esc_html( antispambot( $ccsm_options['colorlib_coming_soon_social_email'] ) ); ?>"
                   id="colorlib_coming_soon_social_email" class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-5">
                    <?php echo wp_kses( ccsm_icon('envelope'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}
			if ( $ccsm_options['colorlib_coming_soon_social_pinterest'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_pinterest'] ); ?>"
                   id="colorlib_coming_soon_social_pinterest"
                   class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-5">
                    <?php echo wp_kses( ccsm_icon('pinterest'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}
			if ( $ccsm_options['colorlib_coming_soon_social_instagram'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_instagram'] ); ?>"
                   id="colorlib_coming_soon_social_instagram"
                   class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-5">
                    <?php echo wp_kses( ccsm_icon('instagram'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}
			?>
        </div>
        <p style="color:#fff;" class="colorlib-copyright"><span><?php esc_html_e('Coming Soon Template designed by','colorlib-coming-soon-maintenance'); ?></span> <a href="https://colorlib.com/" target="_blank" rel="noopener noreferrer">Colorlib</a></p>
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