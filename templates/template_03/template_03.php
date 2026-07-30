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
        h1,h2,h3,p,span,li {
            color: <?php echo esc_attr( ccsm_hex_color( $ccsm_options['colorlib_coming_soon_text_color'] ) ); ?> !important;
        }
    </style>
	<?php
}
?>
<div class="bg-img1 size1 flex-w flex-c-m p-t-55 p-b-55 p-l-15 p-r-15"
     style="background-image: url('<?php echo esc_url($ccsm_bcg_url); ?>');">
    <div class="wsize1 bor1 bg1 p-t-175 p-b-45 p-l-15 p-r-15 respon1">
        <div class="wrappic1">
			<?php if ( $ccsm_logo_url ) {
				?>
                <a href="<?php echo esc_url( site_url() ); ?>" class="logo-link"><img src="<?php echo esc_url($ccsm_logo_url); ?>"
                                 alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"></a>
				<?php
			}
			?>
        </div>

        <h1 class="txt-center m1-txt1 p-t-33 p-b-68" id="colorlib_coming_soon_page_heading">
			<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_heading'] ); ?>
        </h1>
		<?php if ( $ccsm_counter_activation == '1' ) { ?>
            <div class="wsize2 flex-w flex-c hsize1 cd100">
                <div class="flex-col-c-m size2 how-countdown">
                    <span class="l1-txt1 p-b-9 days"><?php echo esc_html( $ccsm_dates['template']['days'] ); ?></span>
                    <span class="s1-txt1"><?php echo esc_html__( 'Days', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>

                <div class="flex-col-c-m size2 how-countdown">
                    <span class="l1-txt1 p-b-9 hours"><?php echo esc_html( $ccsm_dates['template']['hours'] ); ?></span>
                    <span class="s1-txt1"><?php echo esc_html__( 'Hours', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>

                <div class="flex-col-c-m size2 how-countdown">
                    <span class="l1-txt1 p-b-9 minutes"><?php echo esc_html( $ccsm_dates['template']['minutes'] ); ?></span>
                    <span class="s1-txt1"><?php echo esc_html__( 'Minutes', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>

                <div class="flex-col-c-m size2 how-countdown">
                    <span class="l1-txt1 p-b-9 seconds"><?php echo esc_html( $ccsm_dates['template']['seconds'] ); ?></span>
                    <span class="s1-txt1"><?php echo esc_html__( 'Seconds', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>
            </div>
		<?php } ?>
		<?php
		    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- public hook since 1.0; renaming would break sites that use it.
		    do_action('colorlib_coming_soon_before_forms');
 		    if ( $ccsm_options['colorlib_coming_soon_subscribe'] != '1' ) {
		?>
            <form class="flex-w flex-c-m contact100-form validate-form p-t-55" action="<?php echo esc_url($ccsm_options['colorlib_coming_soon_subscribe_form_url']); ?>" method="POST">
                <div class="wrap-input100 validate-input where1" data-validate="<?php echo esc_attr__('Email is required: ex@abc.xyz','colorlib-coming-soon-maintenance'); ?>">
                    <label class="ccsm-sr-only" for="ccsm-email-03"><?php echo esc_html__('Your Email','colorlib-coming-soon-maintenance'); ?></label>
                    <input class="s1-txt2 placeholder0 input100" type="email" name="EMAIL" id="ccsm-email-03" autocomplete="email" placeholder="<?php echo esc_attr__('Your Email','colorlib-coming-soon-maintenance'); ?>">
                    <span class="focus-input100"></span>
                </div>


                <button class="flex-c-m s1-txt3 size3 how-btn trans-04 where1" name="subscribe">
					<?php echo esc_html__( 'Get Notified', 'colorlib-coming-soon-maintenance' ); ?>
                </button>

            </form>
			<?php } ?>

            <div class="flex-w justify-content-center p-2">
			<?php
			if ( $ccsm_options['colorlib_coming_soon_social_facebook'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_facebook'] ); ?>"
                   id="colorlib_coming_soon_social_facebook" class="flex-c-m size5 bg3 how1 trans-04 m-r-10">
                    <?php echo wp_kses( ccsm_icon('facebook', 'fs-25'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}
			?>
			<?php
			if ( $ccsm_options['colorlib_coming_soon_social_twitter'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_twitter'] ); ?>"
                   id="colorlib_coming_soon_social_twitter" class="flex-c-m size5 bg4 how1 trans-04 m-r-10">
                    <?php echo wp_kses( ccsm_icon('twitter', 'fs-25'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}

			if ( $ccsm_options['colorlib_coming_soon_social_youtube'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_youtube'] ); ?>"
                   id="colorlib_coming_soon_social_youtube" class="flex-c-m size5 bg5 how1 trans-04 m-r-10">
                    <?php echo wp_kses( ccsm_icon('youtube-play', 'fs-25'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}

			if ( $ccsm_options['colorlib_coming_soon_social_email'] ) {
				?>
                <a href="mailto:<?php echo esc_html( antispambot( $ccsm_options['colorlib_coming_soon_social_email'] ) ); ?>"
                   id="colorlib_coming_soon_social_email" class="flex-c-m size5 bg3 how1 trans-04 m-r-10">
                    <?php echo wp_kses( ccsm_icon('envelope', 'fs-25'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}

			if ( $ccsm_options['colorlib_coming_soon_social_pinterest'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_pinterest'] ); ?>"
                   id="colorlib_coming_soon_social_pinterest" class="flex-c-m size5 bg3 how1 trans-04 m-r-10">
                    <?php echo wp_kses( ccsm_icon('pinterest', 'fs-25'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}
			if ( $ccsm_options['colorlib_coming_soon_social_instagram'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_instagram'] ); ?>"
                   id="colorlib_coming_soon_social_instagram" class="flex-c-m size5 bg3 how1 trans-04 m-r-10">
                    <?php echo wp_kses( ccsm_icon('instagram', 'fs-25'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}
			?>
        </div>

            <p class="s1-txt4 txt-center p-t-10" id="colorlib_coming_soon_page_footer">
				<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_footer'] ); ?>
            </p>
        <p class="colorlib-copyright"><span><?php esc_html_e('Coming Soon Template designed by','colorlib-coming-soon-maintenance'); ?></span> <a href="https://colorlib.com/" target="_blank" rel="noopener noreferrer">Colorlib</a></p>
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