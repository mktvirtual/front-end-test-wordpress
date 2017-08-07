<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * A Text Shadow set of controls
 *
 * @param array  $default    {
 *      @type integer $horizontal Default 0
 *      @type integer $vertical   Default 0
 *      @type integer $blur       Default 10
 *      @type string  $color      Shadow color, in rgb|rgba|hex format.
 * }
 *
 * @since 1.0.0
 */
class Control_Text_Shadow extends Control_Base_Multiple {

	public function get_type() {
		return 'text_shadow';
	}

	public function get_default_value() {
		return [
			'horizontal' => 0,
			'vertical' => 0,
			'blur' => 10,
			'color' => 'rgba(0,0,0,0.3)',
		];
	}

	public function get_sliders() {
		return [
			'blur' => [
				'label' => __( 'Blur', 'elementor' ),
				'min' => 0,
				'max' => 100,
			],
			'horizontal' => [
				'label' => __( 'Horizontal', 'elementor' ),
				'min' => -100,
				'max' => 100,
			],
			'vertical' => [
				'label' => __( 'Vertical', 'elementor' ),
				'min' => -100,
				'max' => 100,
			],
		];
	}

	public function content_template() {
		?>
		<#
		var defaultColorValue = '';

		if ( data.default.color ) {
			if ( '#' !== data.default.color.substring( 0, 1 ) ) {
				defaultColorValue = '#' + data.default.color;
			} else {
				defaultColorValue = data.default.color;
			}

			defaultColorValue = ' data-default-color=' + defaultColorValue; // Quotes added automatically.
		}
		#>
		<div class="elementor-control-field">
			<label class="elementor-control-title"><?php _e( 'Color', 'elementor' ); ?></label>
			<div class="elementor-control-input-wrapper">
				<input data-setting="color" class="elementor-shadow-color-picker" type="text" maxlength="7" placeholder="<?php esc_attr_e( 'Hex Value', 'elementor' ); ?>" data-alpha="true"{{{ defaultColorValue }}} />
			</div>
		</div>
		<?php
		foreach ( $this->get_sliders() as $slider_name => $slider ) :
			$control_uid = $this->get_control_uid( $slider_name );
			?>
			<div class="elementor-shadow-slider">
				<label for="<?php echo $control_uid; ?>" class="elementor-control-title"><?php echo $slider['label']; ?></label>
				<div class="elementor-control-input-wrapper">
					<div class="elementor-slider" data-input="<?php echo $slider_name; ?>"></div>
					<div class="elementor-slider-input">
						<input id="<?php echo $control_uid; ?>" type="number" min="<?php echo $slider['min']; ?>" max="<?php echo $slider['max']; ?>" data-setting="<?php echo $slider_name; ?>"/>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		<?php
	}
}
