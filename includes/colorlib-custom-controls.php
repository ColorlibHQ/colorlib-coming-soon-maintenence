<?php
if ( class_exists( 'WP_Customize_Control' ) ) {

	class Colorlib_Template_Selection_Radio extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'select';

		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			wp_enqueue_style( 'colorlib-custom-controls-css', CSMM_URL . 'css/custom-controls.css', array(), '1.0', 'all' );
		}


		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			/*$templates = array(
				'template_01' => 'Template 1',
				'template_02' => 'Template 2',
				'template_03' => 'Template 3',
				'template_04' => 'Template 4',
				'template_05' => 'Template 5',
				'template_06' => 'Template 6',
				'template_07' => 'Template 7',
				'template_08' => 'Template 8',
				'template_09' => 'Template 9',
				'template_10' => 'Template 10',
				'template_11' => 'Template 11',
				'template_12' => 'Template 12',
				'template_13' => 'Template 13',
				'template_14' => 'Template 14',
				'template_15' => 'Template 15',
			);*/
			?>
            <div class="colorlib_template_selection_radio">
				<?php if ( ! empty( $this->label ) ) { ?>
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if ( ! empty( $this->description ) ) { ?>
                    <span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>

                <div class="radio-buttons">
					<?php foreach ( $this->choices as $key => $value ) { ?>
                        <label class="radio-button-label">
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
