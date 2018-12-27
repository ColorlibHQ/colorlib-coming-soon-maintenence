<?php
if ( class_exists( 'WP_Customize_Control' ) ) {
	if ( ! class_exists( 'CCSM_Template_Selection' ) ) {

		class CCSM_Template_Selection extends WP_Customize_Control {
			/**
			 * The type of control being rendered
			 */
			public $type = 'ccsm-templates';

			/**
			 * Render the control in the customizer
			 */
			public function render_content() {
				$ccsm_options = get_option( 'ccsm_settings' );
				$template     = $ccsm_options['colorlib_coming_soon_template_selection'];
				?>
                <div class="colorlib_template_selection_radio">
                    <div class="colorlib-templates-wrapper">
						<?php foreach ( $this->choices as $key => $value ) { ?>
							<?php
							if ( $key == $template ) {
								$active = 'active';
							} else {
								$active = '';
							}
							?>
                            <label class="colorlib-single-template-wrapper <?php echo $active; ?>">
                            	<input class="colorlib-template-radio" type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
                                <img src="<?php echo CCSM_URL . 'templates/' . esc_attr( $key ) . '/' . esc_attr( $key ) . '.jpg' ?>">
                            </label>
						<?php } ?>
                    </div>
                </div>
				<?php
			}
		}
	}
}