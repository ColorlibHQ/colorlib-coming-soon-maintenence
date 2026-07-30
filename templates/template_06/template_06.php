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
$logo_url          = ($ccsm_options['colorlib_coming_soon_plugin_logo']) ? $ccsm_options['colorlib_coming_soon_plugin_logo'] : false;

if ( is_ssl()  ) {

	if(!empty($bcg_url)){
		$bcg_url = str_replace( 'http://', 'https://', $ccsm_options['colorlib_coming_soon_background_image'] );
	}

	if ( $logo_url ) {
		$logo_url = str_replace( 'http://', 'https://', $logo_url );
	}
}
?>
    <div class="bg-img1 size1 overlay1 p-t-24"
         style="background-image: url('<?php echo esc_url($bcg_url); ?>');">
        <div class="flex-w flex-sb-m p-l-80 p-r-74 p-b-175 respon5">
            <div class="wrappic1 m-r-30 m-t-10 m-b-10">
				<?php if ( $logo_url ) {
					?>
                    <a href="<?php echo esc_url( site_url() ); ?>" class="logo-link"><img
                                src="<?php echo esc_url( $logo_url ); ?>"
                                alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"></a>
					<?php
				}
				?>
            </div>

            <div class="flex-w m-t-10 m-b-10">
				<?php
				if ( $ccsm_options['colorlib_coming_soon_social_facebook'] ) {
					?>
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_facebook'] ); ?>"
                       id="colorlib_coming_soon_social_facebook" class="size3 flex-c-m how-social trans-04 m-r-6">
                        <?php echo wp_kses( ccsm_icon('facebook'), ccsm_svg_allowed_html() ); ?>
                    </a>
					<?php
				}

				if ( $ccsm_options['colorlib_coming_soon_social_twitter'] ) {
					?>
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_twitter'] ); ?>"
                       id="colorlib_coming_soon_social_twitter" class="size3 flex-c-m how-social trans-04 m-r-6">
                        <?php echo wp_kses( ccsm_icon('twitter'), ccsm_svg_allowed_html() ); ?>
                    </a>
					<?php
				}

				if ( $ccsm_options['colorlib_coming_soon_social_youtube'] ) {
					?>
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_youtube'] ); ?>"
                       id="colorlib_coming_soon_social_youtube" class="size3 flex-c-m how-social trans-04 m-r-6">
                        <?php echo wp_kses( ccsm_icon('youtube-play'), ccsm_svg_allowed_html() ); ?>
                    </a>
					<?php
				}

				if ( $ccsm_options['colorlib_coming_soon_social_email'] ) {
					?>
                    <a href="mailto:<?php echo esc_html( antispambot( $ccsm_options['colorlib_coming_soon_social_email'] ) ); ?>"
                       id="colorlib_coming_soon_social_email" class="size3 flex-c-m how-social trans-04 m-r-6">
                        <?php echo wp_kses( ccsm_icon('envelope'), ccsm_svg_allowed_html() ); ?>
                    </a>
					<?php
				}

				if ( $ccsm_options['colorlib_coming_soon_social_pinterest'] ) {
					?>
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_pinterest'] ); ?>"
                       id="colorlib_coming_soon_social_pinterest" class="size3 flex-c-m how-social trans-04 m-r-6">
                        <?php echo wp_kses( ccsm_icon('pinterest'), ccsm_svg_allowed_html() ); ?>
                    </a>
					<?php
				}
				if ( $ccsm_options['colorlib_coming_soon_social_instagram'] ) {
					?>
                    <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_instagram'] ); ?>"
                       id="colorlib_coming_soon_social_instagram" class="size3 flex-c-m how-social trans-04 m-r-6">
                        <?php echo wp_kses( ccsm_icon('instagram'), ccsm_svg_allowed_html() ); ?>
                    </a>
					<?php
				}
				?>
            </div>
        </div>

        <div class="flex-w flex-sa p-r-200 respon1">
            <div class="p-t-34 p-b-60 respon3">
                <h1 class="l1-txt2 p-b-45 respon2 respon4" id="colorlib_coming_soon_page_heading">
					<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_heading'] ); ?>
                </h1>

                <p class="l1-txt1 p-b-10 respon2" id="colorlib_coming_soon_page_content">
					<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_content'] ); ?>
                </p>

				<?php if ( $counterActivation == '1' ) { ?>
                    <div class="cd100 ccsm-cd">
                        <div class="ccsm-cd-item">
                            <span class="ccsm-cd-num days"><?php echo esc_html( $dates['template']['days'] ); ?></span>
                            <span class="ccsm-cd-label"><?php echo esc_html__( 'Days', 'colorlib-coming-soon-maintenance' ); ?></span>
                        </div>
                        <div class="ccsm-cd-item">
                            <span class="ccsm-cd-num hours"><?php echo esc_html( $dates['template']['hours'] ); ?></span>
                            <span class="ccsm-cd-label"><?php echo esc_html__( 'Hours', 'colorlib-coming-soon-maintenance' ); ?></span>
                        </div>
                        <div class="ccsm-cd-item">
                            <span class="ccsm-cd-num minutes"><?php echo esc_html( $dates['template']['minutes'] ); ?></span>
                            <span class="ccsm-cd-label"><?php echo esc_html__( 'Minutes', 'colorlib-coming-soon-maintenance' ); ?></span>
                        </div>
                        <div class="ccsm-cd-item">
                            <span class="ccsm-cd-num seconds"><?php echo esc_html( $dates['template']['seconds'] ); ?></span>
                            <span class="ccsm-cd-label"><?php echo esc_html__( 'Seconds', 'colorlib-coming-soon-maintenance' ); ?></span>
                        </div>
                    </div> <?php } ?>

            </div>
			<?php 
			    do_action('colorlib_coming_soon_before_forms'); 
 			    if ( $ccsm_options['colorlib_coming_soon_subscribe'] != '1' ) {  
			?>
                <div class="bg0 wsize1 bor1 p-l-45 p-r-45 p-t-50 p-b-18 p-lr-15-sm">
                    <h3 class="l1-txt3 txt-center p-b-43">
						<?php echo esc_html__( 'Newsletter', 'colorlib-coming-soon-maintenance' ); ?>
                    </h3>

                    <form class="w-full validate-form"
                          action="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_subscribe_form_url'] ); ?>" method="POST">

                        <div class="wrap-input100 validate-input m-b-10"
                             data-validate="<?php echo esc_attr__( 'Name is required', 'colorlib-coming-soon-maintenance' ); ?>">
                            <label class="ccsm-sr-only" for="ccsm-name-06"><?php echo esc_html__( 'Name', 'colorlib-coming-soon-maintenance' ); ?></label>
                            <input class="input100 placeholder0 s1-txt1" type="text" id="ccsm-name-06" name="FNAME"
                                   autocomplete="given-name"
                                   placeholder="<?php echo esc_attr__( 'Name', 'colorlib-coming-soon-maintenance' ); ?>">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-20"
                             data-validate="<?php echo esc_attr__( 'Valid email is required: ex@abc.xyz', 'colorlib-coming-soon-maintenance' ); ?>">
                            <label class="ccsm-sr-only" for="ccsm-email-06"><?php echo esc_html__( 'Email', 'colorlib-coming-soon-maintenance' ); ?></label>
                            <input class="input100 placeholder0 s1-txt1" type="email" id="ccsm-email-06" name="EMAIL"
                                   autocomplete="email"
                                   placeholder="<?php echo esc_attr__( 'Email', 'colorlib-coming-soon-maintenance' ); ?>">
                            <span class="focus-input100"></span>
                        </div>

                        <button class="flex-c-m size2 s1-txt2 how-btn1 trans-04" name="subscribe">
							<?php echo esc_html__( 'Subscribe', 'colorlib-coming-soon-maintenance' ); ?>
                        </button>
                    </form>

                    <p class="s1-txt3 txt-center p-l-15 p-r-15 p-t-25" id="colorlib_coming_soon_page_footer">
						<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_footer'] ); ?>
                    </p>
                </div>
			<?php } ?>
            <p style="position:absolute;bottom:0;right:180px;" class="colorlib-copyright"><span><?php esc_html_e('Coming Soon Template designed by','colorlib-coming-soon-maintenance'); ?></span> <a href="https://colorlib.com/" target="_blank" rel="noopener noreferrer">Colorlib</a></p>
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