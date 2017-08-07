<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Autoloader {

	private static $classes_map = [
		'Admin' => 'includes/admin.php',
		'Api' => 'includes/api.php',
		'Base_Control' => 'includes/controls/base.php',
		'Base_Data_Control' => 'includes/controls/base-data.php',
		'Base_UI_Control' => 'includes/controls/base-ui.php',
		'Beta_Testers' => 'includes/beta-testers.php',
		'Compatibility' => 'includes/compatibility.php',
		'Conditions' => 'includes/conditions.php',
		'Control_Base_Multiple' => 'includes/controls/base-multiple.php',
		'Control_Base_Units' => 'includes/controls/base-units.php',
		'Controls_Manager' => 'includes/managers/controls.php',
		'Controls_Stack' => 'includes/base/controls-stack.php',
		'CSS_File' => 'includes/css-file/css-file.php',
		'DB' => 'includes/db.php',
		'Debug\Debug' => 'includes/debug/debug.php',
		'Editor' => 'includes/editor.php',
		'Elements_Manager' => 'includes/managers/elements.php',
		'Embed' => 'includes/embed.php',
		'Fonts' => 'includes/fonts.php',
		'Frontend' => 'includes/frontend.php',
		'Global_CSS_File' => 'includes/css-file/global-css-file.php',
		'Group_Control_Background' => 'includes/controls/groups/background.php',
		'Group_Control_Base' => 'includes/controls/groups/base.php',
		'Group_Control_Border' => 'includes/controls/groups/border.php',
		'Group_Control_Box_Shadow' => 'includes/controls/groups/box-shadow.php',
		'Group_Control_Image_Size' => 'includes/controls/groups/image-size.php',
		'Group_Control_Interface' => 'includes/interfaces/group-control.php',
		'Group_Control_Text_Shadow' => 'includes/controls/groups/text-shadow.php',
		'Group_Control_Typography' => 'includes/controls/groups/typography.php',
		'Heartbeat' => 'includes/heartbeat.php',
		'Images_Manager' => 'includes/managers/image.php',
		'Maintenance' => 'includes/maintenance.php',
		'Maintenance_Mode' => 'includes/maintenance-mode.php',
		'Post_CSS_File' => 'includes/css-file/post-css-file.php',
		'Posts_CSS_Manager' => 'includes/managers/css-files.php',
		'Preview' => 'includes/preview.php',
		'Responsive' => 'includes/responsive.php',
		'Revisions_Manager' => 'includes/managers/revisions.php',
		'Rollback' => 'includes/rollback.php',
		'Scheme_Base' => 'includes/schemes/base.php',
		'Scheme_Color' => 'includes/schemes/color.php',
		'Scheme_Color_Picker' => 'includes/schemes/color-picker.php',
		'Scheme_Typography' => 'includes/schemes/typography.php',
		'Scheme_Interface' => 'includes/interfaces/scheme.php',
		'Schemes_Manager' => 'includes/managers/schemes.php',
		'Settings' => 'includes/settings/settings.php',
		'Settings_Controls' => 'includes/settings/controls.php',
		'Settings_Validations' => 'includes/settings/validations.php',
		'Settings_Page' => 'includes/settings/settings-page.php',
		'Shapes' => 'includes/shapes.php',
		'Skins_Manager' => 'includes/managers/skins.php',
		'Stylesheet' => 'includes/stylesheet.php',
		'System_Info\Main' => 'includes/settings/system-info/main.php',
		'TemplateLibrary\Classes\Import_Images' => 'includes/template-library/classes/class-import-images.php',
		'TemplateLibrary\Manager' => 'includes/template-library/manager.php',
		'TemplateLibrary\Source_Base' => 'includes/template-library/sources/base.php',
		'TemplateLibrary\Source_Local' => 'includes/template-library/sources/local.php',
		'TemplateLibrary\Source_Remote' => 'includes/template-library/sources/remote.php',
		'Tools' => 'includes/settings/tools.php',
		'Tracker' => 'includes/tracker.php',
		'Upgrades' => 'includes/upgrades.php',
		'User' => 'includes/user.php',
		'Utils' => 'includes/utils.php',
		'Widget_WordPress' => 'includes/widgets/wordpress.php',
		'Widgets_Manager' => 'includes/managers/widgets.php',
		'WordPress_Widgets_Manager' => 'includes/managers/wordpress-widgets.php',
	];

	private static $classes_aliases = [
		'Control_Base' => 'Base_Data_Control',
		'PageSettings\Manager' => 'Core\Settings\Page\Manager',
	];

	public static function run() {
		spl_autoload_register( [ __CLASS__, 'autoload' ] );
	}

	/**
	 * @return array
	 */
	public static function get_classes_aliases() {
		return self::$classes_aliases;
	}

	private static function load_class( $relative_class_name ) {
		if ( isset( self::$classes_map[ $relative_class_name ] ) ) {
			$filename = ELEMENTOR_PATH . '/' . self::$classes_map[ $relative_class_name ];
		} else {
			$filename = strtolower(
				preg_replace(
					[ '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$relative_class_name
				)
			);

			$filename = ELEMENTOR_PATH . $filename . '.php';
		}

		if ( is_readable( $filename ) ) {
			require $filename;
		}
	}

	private static function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ . '\\' ) ) {
			return;
		}

		$relative_class_name = preg_replace( '/^' . __NAMESPACE__ . '\\\/', '', $class );

		$has_class_alias = isset( self::$classes_aliases[ $relative_class_name ] );

		// Backward Compatibility: Save old class name for set an alias after the new class is loaded
		if ( $has_class_alias ) {
			$relative_class_name = self::$classes_aliases[ $relative_class_name ];
		}

		$final_class_name = __NAMESPACE__ . '\\' . $relative_class_name;

		if ( ! class_exists( $final_class_name ) ) {
			self::load_class( $relative_class_name );
		}

		if ( $has_class_alias ) {
			class_alias( $final_class_name, $class );
		}
	}
}
