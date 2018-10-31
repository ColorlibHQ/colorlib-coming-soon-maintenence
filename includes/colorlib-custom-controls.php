<?php
if ( class_exists( 'WP_Customize_Control' ) ) {

	class Colorlib_Template_Selection extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'template_select_radio';

		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_style( 'colorlib-custom-controls-css', CSMM_URL . 'css/custom-controls.css', array(), '1.0', 'all' );
			wp_enqueue_editor();
		}

		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			?>
            <div class="colorlib_template_selection_radio">
				<?php if ( ! empty( $this->label ) ) { ?>
                    <span class="colorlib-customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if ( ! empty( $this->description ) ) { ?>
                    <span class="colorlib-customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>

                <div class="colorlib-templates-wrapper">
					<?php foreach ( $this->choices as $key => $value ) { ?>
                        <label class="colorlib-single-template-wrapper">
                            <img src="<?php echo CSMM_URL . 'templates/' . esc_attr( $key ) . '/' . esc_attr( $key ) . '.jpg' ?>">
                            <input type="radio" name="<?php echo esc_attr( $this->id ); ?>"
                                   value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
                            <span><?php echo esc_attr( $value ); ?></span>
                        </label>
					<?php } ?>
                </div>
            </div>
			<?php
		}
	}
}
