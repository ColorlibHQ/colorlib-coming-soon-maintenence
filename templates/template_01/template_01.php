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
$ccsm_bcg_url           = ($ccsm_options['colorlib_coming_soon_background_image']) ? $ccsm_options['colorlib_coming_soon_background_image'] : '';
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
        .cd100 span {
            color: <?php echo esc_attr( ccsm_hex_color( $ccsm_options['colorlib_coming_soon_text_color'] ) ); ?> !important;
        }
    </style>
	<?php
}
?>
<div class="size1 bg0 where1-parent">
    <div class="flex-c-m bg-img1 size2 where1 overlay1 where2 respon2 wrap-pic1"
         style="background-image: url('<?php echo esc_url($ccsm_bcg_url); ?>')">
		<?php if ( $ccsm_counter_activation == '1' ) { ?>
            <div class="wsize2 flex-w flex-c-m cd100 js-tilt">
                <div class="flex-col-c-m size6 bor2 m-l-10 m-r-10 m-t-15">
                    <span class="l2-txt1 p-b-9 days"><?php echo esc_html( $ccsm_dates['template']['days'] ); ?></span>
                    <span class="s2-txt4"><?php echo esc_html__( 'Days', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>

                <div class="flex-col-c-m size6 bor2 m-l-10 m-r-10 m-t-15">
                    <span class="l2-txt1 p-b-9 hours"><?php echo esc_html( $ccsm_dates['template']['hours'] ); ?></span>
                    <span class="s2-txt4"><?php echo esc_html__( 'Hours', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>

                <div class="flex-col-c-m size6 bor2 m-l-10 m-r-10 m-t-15">
                    <span class="l2-txt1 p-b-9 minutes"><?php echo esc_html( $ccsm_dates['template']['minutes'] ); ?></span>
                    <span class="s2-txt4"><?php echo esc_html__( 'Minutes', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>

                <div class="flex-col-c-m size6 bor2 m-l-10 m-r-10 m-t-15">
                    <span class="l2-txt1 p-b-9 seconds"><?php echo esc_html( $ccsm_dates['template']['seconds'] ); ?></span>
                    <span class="s2-txt4"><?php echo esc_html__( 'Seconds', 'colorlib-coming-soon-maintenance' ); ?></span>
                </div>
            </div>
		<?php } ?>
    </div>

    <div class="size3 flex-col-sb flex-w p-l-75 p-r-75 p-t-45 p-b-45 respon1">
        <div class="wrap-pic1">
			<?php if ( $ccsm_logo_url ) {
				?>
                <a href="<?php echo esc_url( site_url() ); ?>" class="logo-link"><img
                            src="<?php echo esc_url( $ccsm_logo_url ); ?>"
                            alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"></a>
				<?php
			}
			?>
        </div>

        <div class="p-t-50 p-b-60">
            <h1 class="m1-txt1 p-b-36" id="colorlib_coming_soon_page_heading">
				<?php echo wp_kses_post( $ccsm_options['colorlib_coming_soon_page_heading'] ); ?>
            </h1>
			<?php 
			    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- public hook since 1.0; renaming would break sites that use it.
			    do_action('colorlib_coming_soon_before_forms'); 
 			    if ( $ccsm_options['colorlib_coming_soon_subscribe'] != '1' ) {  
			?>
                <form class="contact100-form validate-form" novalidate
                      action="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_subscribe_form_url'] ); ?>" method="POST">
                    <div class="wrap-input100 m-b-10 validate-input"
                         data-validate="<?php echo esc_attr__( 'Name is required', 'colorlib-coming-soon-maintenance' ); ?>">
                        <label class="ccsm-sr-only" for="ccsm-fname-01"><?php echo esc_html__( 'Your Name', 'colorlib-coming-soon-maintenance' ); ?></label>
                        <input class="s2-txt1 placeholder0 input100" type="text" name="FNAME" id="ccsm-fname-01"
                               autocomplete="given-name"
                               placeholder="<?php echo esc_attr__( 'Your Name', 'colorlib-coming-soon-maintenance' ); ?>">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 m-b-20 validate-input"
                         data-validate="<?php echo esc_attr__( 'Email is required: ex@abc.xyz', 'colorlib-coming-soon-maintenance' ); ?>">
                        <label class="ccsm-sr-only" for="ccsm-email-01"><?php echo esc_html__( 'Email Address', 'colorlib-coming-soon-maintenance' ); ?></label>
                        <input class="s2-txt1 placeholder0 input100" type="email" name="EMAIL" id="ccsm-email-01"
                               autocomplete="email"
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
                    <?php echo wp_kses( ccsm_icon('facebook'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}
			?>
			<?php
			if ( $ccsm_options['colorlib_coming_soon_social_twitter'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_twitter'] ); ?>"
                   id="colorlib_coming_soon_social_twitter" class="flex-c-m size5 bg4 how1 trans-04 m-r-5">
                    <?php echo wp_kses( ccsm_icon('twitter'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}

			if ( $ccsm_options['colorlib_coming_soon_social_youtube'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_youtube'] ); ?>"
                   id="colorlib_coming_soon_social_youtube" class="flex-c-m size5 bg5 how1 trans-04 m-r-5">
                    <?php echo wp_kses( ccsm_icon('youtube-play'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}

			if ( $ccsm_options['colorlib_coming_soon_social_email'] ) {
				?>
                <a href="mailto:<?php echo esc_html( antispambot( $ccsm_options['colorlib_coming_soon_social_email'] ) ); ?>"
                   id="colorlib_coming_soon_social_email" class="flex-c-m size5 bg3 how1 trans-04 m-r-5">
                    <?php echo wp_kses( ccsm_icon('envelope'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}

			if ( $ccsm_options['colorlib_coming_soon_social_pinterest'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_pinterest'] ); ?>"
                   id="colorlib_coming_soon_social_pinterest" class="flex-c-m size5 bg3 how1 trans-04 m-r-5">
                    <?php echo wp_kses( ccsm_icon('pinterest'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}
			if ( $ccsm_options['colorlib_coming_soon_social_instagram'] ) {
				?>
                <a href="<?php echo esc_url( $ccsm_options['colorlib_coming_soon_social_instagram'] ); ?>"
                   id="colorlib_coming_soon_social_instagram" class="flex-c-m size5 bg3 how1 trans-04 m-r-5">
                    <?php echo wp_kses( ccsm_icon('instagram'), ccsm_svg_allowed_html() ); ?>
                </a>
				<?php
			}
			?>
        </div>
        <p class="colorlib-copyright"><span><?php esc_html_e('Coming Soon Template designed by','colorlib-coming-soon-maintenance'); ?></span> <a href="https://colorlib.com/" target="_blank" rel="noopener noreferrer">Colorlib</a>
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
<?php if ( $ccsm_counter_activation == '1' && $ccsm_dates['script'] != false ) {
	?>
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
