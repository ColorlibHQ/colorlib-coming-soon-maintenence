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

if ( ccsm_template_has_text_color() ) {
	?>
    <style>
        h1, h2, h3, p, span, li, a:not(.sign-up) {
            color: <?php echo esc_attr( ccsm_hex_color( $ccsm_options['colorlib_coming_soon_text_color'] ) ); ?> !important;
        }
    </style>
	<?php
}
?>
    <div class="simpleslide100"
         style="background-color:<?php echo esc_attr( ccsm_hex_color( $ccsm_options['colorlib_coming_soon_background_color'] ) ); ?>;">
        <div class="simpleslide100-item bg-img1"
             style="background-image: url('<?php echo esc_url($ccsm_bcg_url); ?>');"></div>
    </div>

    <div class="flex-col-c-sb size1 overlay1 p-l-75 p-r-75 p-t-20 p-b-40 p-lr-15-sm">
        <div class="w-full flex-w flex-sb-m">
            <div class="wrappic1 m-r-30 m-t-10 m-b-10">
				<?php if ( $ccsm_logo_url ) {
					?>
                    <a href="<?php echo esc_url( site_url() ); ?>" class="logo-link"><img
                                src="<?php echo esc_url( $ccsm_logo_url ); ?>"
                                alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"></a>
					<?php
				}
				?>
            </div>
			<?php if ( $ccsm_counter_activation == '1' ) { ?>
                <div class="flex-w cd100 p-t-15 p-b-15 p-r-36">
                    <div class="flex-w flex-b m-r-22 m-t-8 m-b-8">
                        <span class="l1-txt1 wsize1 days"><?php echo esc_html( $ccsm_dates['template']['days'] ); ?></span>
                        <span class="m1-txt1 p-b-2"><?php echo esc_html__( 'Days', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>

                    <div class="flex-w flex-b m-r-22 m-t-8 m-b-8">
                        <span class="l1-txt1 wsize1 hours"><?php echo esc_html( $ccsm_dates['template']['hours'] ); ?></span>
                        <span class="m1-txt1 p-b-2"><?php echo esc_html__( 'Hours', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>

                    <div class="flex-w flex-b m-r-22 m-t-8 m-b-8">
                        <span class="l1-txt1 wsize1 minutes"><?php echo esc_html( $ccsm_dates['template']['minutes'] ); ?></span>
                        <span class="m1-txt1 p-b-2"><?php echo esc_html__( 'Minutes', 'colorlib-coming-soon-maintenance' ); ?></span>
                    </div>

                    <div class="flex-w flex-b m-r-22 m-t-8 m-b-8">
                        <span class="l1-txt1 wsize1 seconds"><?php echo esc_html( $ccsm_dates['template']['seconds'] ); ?></span>
                        <span class="m1-txt1 p-b-2"><?php echo esc_html__( 'Seconds', 'colorlib-coming-soon-maintenance' ); ?></span>
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
            <h1 class="l1-txt2 txt-center p-b-55 respon1" id="colorlib_coming_soon_page_heading">
				<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_heading'] ); ?>
            </h1>

        </div>

        <div class="flex-sb-m flex-w w-full">
            <div class="flex-w flex-c-m m-t-10 m-b-10">
				<?php
				if ( $ccsm_options['colorlib_coming_soon_social_facebook'] ) {
					?>
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_facebook'] ); ?>"
                       id="colorlib_coming_soon_social_facebook"
                       class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-3 m-t-3">
                        <?php echo wp_kses( ccsm_icon('facebook'), ccsm_svg_allowed_html() ); ?>
                    </a>
					<?php
				}
				if ( $ccsm_options['colorlib_coming_soon_social_twitter'] ) {
					?>
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_twitter'] ); ?>"
                       id="colorlib_coming_soon_social_twitter"
                       class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-3 m-t-3">
                        <?php echo wp_kses( ccsm_icon('twitter'), ccsm_svg_allowed_html() ); ?>
                    </a>
					<?php
				}
				if ( $ccsm_options['colorlib_coming_soon_social_youtube'] ) {
					?>
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_youtube'] ); ?>"
                       id="colorlib_coming_soon_social_youtube"
                       class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-3 m-t-3">
                        <?php echo wp_kses( ccsm_icon('youtube-play'), ccsm_svg_allowed_html() ); ?>
                    </a>
					<?php
				}
				if ( $ccsm_options['colorlib_coming_soon_social_email'] ) {
					?>
                    <a href="mailto:<?php echo esc_html( antispambot( $ccsm_options['colorlib_coming_soon_social_email'] ) ); ?>"
                       id="colorlib_coming_soon_social_email"
                       class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-3 m-t-3">
                        <?php echo wp_kses( ccsm_icon('envelope'), ccsm_svg_allowed_html() ); ?>
                    </a>
					<?php
				}
				if ( $ccsm_options['colorlib_coming_soon_social_pinterest'] ) {
					?>
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_pinterest'] ); ?>"
                       id="colorlib_coming_soon_social_pinterest"
                       class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-3 m-t-3">
                        <?php echo wp_kses( ccsm_icon('pinterest'), ccsm_svg_allowed_html() ); ?>
                    </a>
					<?php
				}
				if ( $ccsm_options['colorlib_coming_soon_social_instagram'] ) {
					?>
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_instagram'] ); ?>"
                       id="colorlib_coming_soon_social_instagram"
                       class="size3 flex-c-m how-social trans-04 m-r-3 m-l-3 m-b-3 m-t-3">
                        <?php echo wp_kses( ccsm_icon('instagram'), ccsm_svg_allowed_html() ); ?>
                    </a>
					<?php
				}
				?>

            </div>
			<?php 
			    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- public hook since 1.0; renaming would break sites that use it.
			    do_action('colorlib_coming_soon_before_forms'); 
 			    if ( $ccsm_options['colorlib_coming_soon_subscribe'] != '1' ) {  
			?>
                <form class="contact100-form validate-form m-t-10 m-b-10"
                      action="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_subscribe_form_url'] ); ?>" method="POST">
                    <div class="wrap-input100 validate-input m-lr-auto-lg"
                         data-validate="<?php echo esc_attr__( 'Email is required: ex@abc.xyz', 'colorlib-coming-soon-maintenance' ); ?>">
                        <label class="ccsm-sr-only" for="ccsm-email-13"><?php echo esc_html__( 'Email Address', 'colorlib-coming-soon-maintenance' ); ?></label>
                        <input class="s2-txt1 placeholder0 input100 trans-04" type="email" id="ccsm-email-13" name="EMAIL" autocomplete="email"
                               placeholder="<?php echo esc_attr__( 'Email Address', 'colorlib-coming-soon-maintenance' ); ?>">

                        <button class="flex-c-m ab-t-r size4 s1-txt1 hov1" name="subscribe">
                            <?php echo wp_kses( ccsm_icon('long-arrow-right', 'fs-16 cl1 trans-04', esc_attr__( 'Subscribe', 'colorlib-coming-soon-maintenance' )), ccsm_svg_allowed_html() ); ?>
                        </button>
                    </div>
                </form>
			<?php } ?>
        </div>
        <p style="color:#fff;" class="colorlib-copyright"><span><?php esc_html_e('Coming Soon Template designed by','colorlib-coming-soon-maintenance'); ?></span> <a
                    href="https://colorlib.com/" target="_blank" rel="noopener noreferrer">Colorlib</a></p>
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