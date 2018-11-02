<?php
if ( class_exists( 'WP_Customize_Control' ) ) {

	class Colorlib_Template_Selection extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'template_select_radio';

		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			?>
            <div class="colorlib_template_selection_radio">
                <div class="colorlib-templates-wrapper">
					<?php foreach ( $this->choices as $key => $value ) { ?>
                        <label class="colorlib-single-template-wrapper">
                            <img src="<?php echo CSMM_URL . 'templates/' . esc_attr( $key ) . '/' . esc_attr( $key ) . '.jpg' ?>">
                            <input class="colorlib-template-radio" type="radio"
                                   name="<?php echo esc_attr( $this->id ); ?>"
                                   value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
                        </label>
					<?php } ?>
                </div>
            </div>
			<?php
		}
	}

	if ( ! class_exists( 'Colorlib_Control_Text_Editor' ) ) {

		class Colorlib_Control_Text_Editor extends WP_Customize_Control {

			/**
			 * @since 1.0.0
			 * @var string
			 */
			public
				$type = 'epsilon-text-editor';

			/**
			 * Epsilon_Control_Text_Editor constructor.
			 *
			 * @param WP_Customize_Manager $manager
			 * @param string $id
			 * @param array $args
			 */
			public
			function __construct(
				WP_Customize_Manager $manager, $id, array $args = array()
			) {
				parent::__construct( $manager, $id, $args );
				$manager->register_control_type( 'Colorlib_Control_Text_Editor' );
			}

			/**
			 * @since 1.0.0
			 * @return array
			 */
			public
			function json() {
				$json          = parent::json();
				$json['id']    = $this->id;
				$json['link']  = $this->get_link();
				$json['value'] = $this->value();

				return $json;
			}

			/**
			 * @since 1.0.0
			 */
			public
			function enqueue() {

				if ( function_exists( 'wp_enqueue_editor' ) ) {
					wp_enqueue_editor();
				} else {
					if ( ! class_exists( '_WP_Editors', false ) ) {
						require( ABSPATH . WPINC . '/class-wp-editor.php' );
					}

					_WP_Editors::enqueue_scripts();
				}

			}

			/**
			 * @since 1.0.0
			 * Display the control's content
			 */
			public
			function content_template() {
				//@formatter:off ?>
                <label>
			<span class="customize-control-title">
				<# if( data.label ){ #>
					<span class="customize-control-title">{{{ data.label }}}</span>
				<# } #>

				<# if( data.description ){ #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
			</span>
                    <textarea id="{{{ data.id }}}-editor" class="widefat text wp-editor-area" {{{ data.link }}}>{{{ data.value }}}</textarea>
                </label>
				<?php //@formatter:on
			}

			/**
			 * Empty, as it should be
			 *
			 * @since 1.0.0
			 */
			public
			function render_content() {
			}
		}
	}

	class Colorlib_CSMM_Control_Toggle extends WP_Customize_Control {

		public $type = 'checkbox';

		public function render_content() {
			?>
            <div class="colorlib_csmm">
                <div class="checkbox_switch">
                    <div>
                        <input type="checkbox" class="onoffswitch-checkbox" name="<?php echo $this->id; ?>"
                               id="<?php echo $this->id; ?>" <?php echo ($this->value() == '1') ? 'checked="yes"' : ''; ?>/>
	                    <?php echo $this->label; ?>
                        <label for="<?php echo $this->id; ?>"
                               class="onoffswitch-label"></label>
                    </div>
                </div>
            </div>
			<?php
		}
	}
}
