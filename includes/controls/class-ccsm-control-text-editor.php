<?php
if ( class_exists( 'WP_Customize_Control' ) ) {

	if ( ! class_exists( 'CCSM_Control_Text_Editor' ) ) {

		class CCSM_Control_Text_Editor extends WP_Customize_Control {

		    public $type = 'ccsm-editor';

			public
			function render_content() {
			    //replace '[' , ']' characters for wp_editor functionality to work correctly
				$id = str_replace( '[', '', $this->id );
				$id = str_replace( ']', '', $id );
				?>
                <label><span class="customize-control-title"><?php echo esc_html($this->label); ?></span></label>
                <span class="description customize-control-description"><?php echo wp_kses_post($this->description); ?></span>
                </span>
                <textarea id="<?php echo esc_attr($id); ?>"
                          class="widefat text wp-editor-area js-ccsm-editor" <?php echo $this->link(); ?><?php echo esc_textarea($this->value()); ?></textarea>
				<?php
			}
		}
	}
}