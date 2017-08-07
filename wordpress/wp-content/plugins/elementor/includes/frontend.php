<?php
namespace Elementor;

use Elementor\Core\Settings\Manager as SettingsManager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Frontend {

	const THE_CONTENT_FILTER_PRIORITY = 9;

	private $google_fonts = [];
	private $registered_fonts = [];
	private $google_early_access_fonts = [];

	private $_is_frontend_mode = false;
	private $_has_elementor_in_page = false;
	private $_is_excerpt = false;
	private $content_removed_filters = [];

	public function init() {
		if ( Plugin::$instance->editor->is_edit_mode() ) {
			return;
		}

		add_filter( 'body_class', [ $this, 'body_class' ] );

		if ( Plugin::$instance->preview->is_preview_mode() ) {
			return;
		}

		$this->_is_frontend_mode = true;
		$this->_has_elementor_in_page = Plugin::$instance->db->is_built_with_elementor( get_the_ID() );

		if ( $this->_has_elementor_in_page ) {
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		}

		add_action( 'wp_head', [ $this, 'print_google_fonts' ] );
		add_action( 'wp_footer', [ $this, 'wp_footer' ] );

		// Add Edit with the Elementor in Admin Bar
		add_action( 'admin_bar_menu', [ $this, 'add_menu_in_admin_bar' ], 200 );
	}

	protected function _print_elements( $elements_data ) {
		foreach ( $elements_data as $element_data ) {
			$element = Plugin::$instance->elements_manager->create_element_instance( $element_data );

			if ( ! $element ) {
				continue;
			}

			$element->print_element();
		}
	}

	public function body_class( $classes = [] ) {
		$classes[] = 'elementor-default';

		$id = get_the_ID();

		if ( is_singular() && Plugin::$instance->db->is_built_with_elementor( $id ) ) {
			$classes[] = 'elementor-page elementor-page-' . $id;
		}

		return $classes;
	}

	public function register_scripts() {
		do_action( 'elementor/frontend/before_register_scripts' );

		$suffix = Utils::is_script_debug() ? '' : '.min';

		wp_register_script(
			'elementor-waypoints',
			ELEMENTOR_ASSETS_URL . 'lib/waypoints/waypoints' . $suffix . '.js',
			[
				'jquery',
			],
			'4.0.2',
			true
		);

		wp_register_script(
			'imagesloaded',
			ELEMENTOR_ASSETS_URL . 'lib/imagesloaded/imagesloaded' . $suffix . '.js',
			[
				'jquery',
			],
			'4.1.0',
			true
		);

		wp_register_script(
			'jquery-numerator',
			ELEMENTOR_ASSETS_URL . 'lib/jquery-numerator/jquery-numerator' . $suffix . '.js',
			[
				'jquery',
			],
			'0.2.1',
			true
		);

		wp_register_script(
			'jquery-swiper',
			ELEMENTOR_ASSETS_URL . 'lib/swiper/swiper.jquery' . $suffix . '.js',
			[
				'jquery',
			],
			'3.4.2',
			true
		);

		wp_register_script(
			'jquery-slick',
			ELEMENTOR_ASSETS_URL . 'lib/slick/slick' . $suffix . '.js',
			[
				'jquery',
			],
			'1.6.0',
			true
		);

		wp_register_script(
			'elementor-dialog',
			ELEMENTOR_ASSETS_URL . 'lib/dialog/dialog' . $suffix . '.js',
			[
				'jquery-ui-position',
			],
			'3.2.3',
			true
		);

		wp_register_script(
			'elementor-frontend',
			ELEMENTOR_ASSETS_URL . 'js/frontend' . $suffix . '.js',
			[
				'elementor-dialog',
				'elementor-waypoints',

			],
			ELEMENTOR_VERSION,
			true
		);

		do_action( 'elementor/frontend/after_register_scripts' );
	}

	public function register_styles() {
		do_action( 'elementor/frontend/before_register_styles' );

		$suffix = Utils::is_script_debug() ? '' : '.min';

		$direction_suffix = is_rtl() ? '-rtl' : '';

		wp_register_style(
			'elementor-icons',
			ELEMENTOR_ASSETS_URL . 'lib/eicons/css/elementor-icons' . $suffix . '.css',
			[],
			ELEMENTOR_VERSION
		);

		wp_register_style(
			'font-awesome',
			ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/font-awesome' . $suffix . '.css',
			[],
			'4.7.0'
		);

		wp_register_style(
			'elementor-animations',
			ELEMENTOR_ASSETS_URL . 'css/animations.min.css',
			[],
			ELEMENTOR_VERSION
		);

		wp_register_style(
			'elementor-frontend',
			ELEMENTOR_ASSETS_URL . 'css/frontend' . $direction_suffix . $suffix . '.css',
			[],
			ELEMENTOR_VERSION
		);

		do_action( 'elementor/frontend/after_register_styles' );
	}

	public function enqueue_scripts() {
		Utils::do_action_deprecated( 'elementor/frontend/enqueue_scripts/before', [], '1.0.10', 'elementor/frontend/before_enqueue_scripts' );

		do_action( 'elementor/frontend/before_enqueue_scripts' );

		wp_enqueue_script( 'elementor-frontend' );

		$post = get_post();

		$elementor_frontend_config = [
			'isEditMode' => Plugin::$instance->preview->is_preview_mode(),
			'settings' => SettingsManager::get_settings_frontend_config(),
			'is_rtl' => is_rtl(),
			'post' => [
				'id' => $post->ID,
				'title' => $post->post_title,
				'excerpt' => $post->post_excerpt,
			],
			'urls' => [
				'assets' => ELEMENTOR_ASSETS_URL,
			],
		];

		if ( Plugin::$instance->preview->is_preview_mode() ) {
			$elements_manager = Plugin::$instance->elements_manager;

			$elements_frontend_keys = [
				'section' => $elements_manager->get_element_types( 'section' )->get_frontend_settings_keys(),
				'column' => $elements_manager->get_element_types( 'column' )->get_frontend_settings_keys(),
			];

			$elements_frontend_keys += Plugin::$instance->widgets_manager->get_widgets_frontend_settings_keys();

			$elementor_frontend_config['elements'] = [
				'data' => (object) [],
				'editSettings' => (object) [],
				'keys' => $elements_frontend_keys,
			];
		}

		wp_localize_script( 'elementor-frontend', 'elementorFrontendConfig', $elementor_frontend_config );

		do_action( 'elementor/frontend/after_enqueue_scripts' );
	}

	public function enqueue_styles() {
		do_action( 'elementor/frontend/before_enqueue_styles' );

		wp_enqueue_style( 'elementor-icons' );
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'elementor-animations' );
		wp_enqueue_style( 'elementor-frontend' );

		if ( ! Plugin::$instance->preview->is_preview_mode() ) {
			$this->parse_global_css_code();

			$css_file = new Post_CSS_File( get_the_ID() );
			$css_file->enqueue();
		}

		do_action( 'elementor/frontend/after_enqueue_styles' );
	}

	/**
	 * Handle style that do not printed in header
	 */
	public function wp_footer() {
		if ( ! $this->_has_elementor_in_page ) {
			return;
		}

		$this->enqueue_styles();
		$this->enqueue_scripts();

		$this->print_google_fonts();
	}

	public function print_google_fonts() {
		if ( ! apply_filters( 'elementor/frontend/print_google_fonts', true ) ) {
			return;
		}

		// Print used fonts
		if ( ! empty( $this->google_fonts ) ) {
			foreach ( $this->google_fonts as &$font ) {
				$font = str_replace( ' ', '+', $font ) . ':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';
			}

			$fonts_url = sprintf( 'https://fonts.googleapis.com/css?family=%s', implode( '|', $this->google_fonts ) );

			$subsets = [
				'ru_RU' => 'cyrillic',
				'bg_BG' => 'cyrillic',
				'he_IL' => 'hebrew',
				'el' => 'greek',
				'vi' => 'vietnamese',
				'uk' => 'cyrillic',
				'cs_CZ' => 'latin-ext',
				'ro_RO' => 'latin-ext',
				'pl_PL' => 'latin-ext',
			];
			$locale = get_locale();

			if ( isset( $subsets[ $locale ] ) ) {
				$fonts_url .= '&subset=' . $subsets[ $locale ];
			}

			echo '<link rel="stylesheet" type="text/css" href="' . $fonts_url . '">';
			$this->google_fonts = [];
		}

		if ( ! empty( $this->google_early_access_fonts ) ) {
			foreach ( $this->google_early_access_fonts as $current_font ) {
				printf( '<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/earlyaccess/%s.css">', strtolower( str_replace( ' ', '', $current_font ) ) );
			}
			$this->google_early_access_fonts = [];
		}
	}

	public function enqueue_font( $font ) {
		$font_type = Fonts::get_font_type( $font );
		$cache_id = $font_type . $font;

		if ( in_array( $cache_id, $this->registered_fonts ) ) {
			return;
		}

		switch ( $font_type ) {
			case Fonts::GOOGLE:
				if ( ! in_array( $font, $this->google_fonts ) ) {
					$this->google_fonts[] = $font;
				}
				break;

			case Fonts::EARLYACCESS:
				if ( ! in_array( $font, $this->google_early_access_fonts ) ) {
					$this->google_early_access_fonts[] = $font;
				}
				break;
		}

		$this->registered_fonts[] = $cache_id;
	}

	protected function parse_global_css_code() {
		$scheme_css_file = new Global_CSS_File();

		$scheme_css_file->enqueue();
	}

	public function apply_builder_in_content( $content ) {
		$this->restore_content_filters();

		if ( ! $this->_is_frontend_mode || $this->_is_excerpt ) {
			return $content;
		}

		// Remove the filter itself in order to allow other `the_content` in the elements
		remove_filter( 'the_content', [ $this, 'apply_builder_in_content' ], self::THE_CONTENT_FILTER_PRIORITY );

		$post_id = get_the_ID();
		$builder_content = $this->get_builder_content( $post_id );

		if ( ! empty( $builder_content ) ) {
			$content = $builder_content;
			$this->remove_content_filters();
		}

		// Add the filter again for other `the_content` calls
		add_filter( 'the_content', [ $this, 'apply_builder_in_content' ], self::THE_CONTENT_FILTER_PRIORITY );

		return $content;
	}

	public function get_builder_content( $post_id, $with_css = false ) {
		if ( post_password_required( $post_id ) ) {
			return '';
		}

		if ( ! Plugin::$instance->db->is_built_with_elementor( $post_id ) ) {
			return '';
		}

		$data = Plugin::$instance->db->get_plain_editor( $post_id );
		$data = apply_filters( 'elementor/frontend/builder_content_data', $data, $post_id );

		if ( empty( $data ) ) {
			return '';
		}

		if ( ! $this->_is_excerpt ) {
			$css_file = new Post_CSS_File( $post_id );
			$css_file->enqueue();
		}

		ob_start();

		// Handle JS and Customizer requests, with css inline.
		if ( is_customize_preview() || Utils::is_ajax() ) {
			$with_css = true;
		}

		if ( ! empty( $css_file ) && $with_css ) {
			echo '<style>' . $css_file->get_css() . '</style>';
		}

		?>
		<div class="elementor elementor-<?php echo $post_id; ?>">
			<div class="elementor-inner">
				<div class="elementor-section-wrap">
					<?php $this->_print_elements( $data ); ?>
				</div>
			</div>
		</div>
		<?php
		$content = apply_filters( 'elementor/frontend/the_content', ob_get_clean() );

		if ( ! empty( $content ) ) {
			$this->_has_elementor_in_page = true;
		}

		return $content;
	}

	public function add_menu_in_admin_bar( \WP_Admin_Bar $wp_admin_bar ) {
		$post_id = get_the_ID();

		$is_builder_mode = is_singular() && User::is_current_user_can_edit( $post_id ) && Plugin::$instance->db->is_built_with_elementor( $post_id );

		if ( ! $is_builder_mode ) {
			return;
		}

		$wp_admin_bar->add_node( [
			'id' => 'elementor_edit_page',
			'title' => __( 'Edit with Elementor', 'elementor' ),
			'href' => Utils::get_edit_link( $post_id ),
		] );
	}

	public function get_builder_content_for_display( $post_id ) {
		if ( ! get_post( $post_id ) ) {
			return '';
		}

		$editor = Plugin::$instance->editor;

		// Avoid recursion
		if ( get_the_ID() === (int) $post_id ) {
			$content = '';
			if ( $editor->is_edit_mode() ) {
				$content = '<div class="elementor-alert elementor-alert-danger">' . __( 'Invalid Data: The Template ID cannot be the same as the currently edited template. Please choose a different one.', 'elementor' ) . '</div>';
			}

			return $content;
		}

		// Set edit mode as false, so don't render settings and etc. use the $is_edit_mode to indicate if we need the css inline
		$is_edit_mode = $editor->is_edit_mode();
		$editor->set_edit_mode( false );

		// Change the global post to current library post, so widgets can use `get_the_ID` and other post data
		Plugin::$instance->db->switch_to_post( $post_id );

		$content = $this->get_builder_content( $post_id, $is_edit_mode );

		Plugin::$instance->db->restore_current_post();

		// Restore edit mode state
		Plugin::$instance->editor->set_edit_mode( $is_edit_mode );

		return $content;
	}

	public function start_excerpt_flag( $excerpt ) {
		$this->_is_excerpt = true;
		return $excerpt;
	}

	public function end_excerpt_flag( $excerpt ) {
		$this->_is_excerpt = false;
		return $excerpt;
	}

	/**
	 * Remove WordPress default filters that conflicted with Elementor
	 */
	public function remove_content_filters() {
		$filters = [
			'wpautop',
			'shortcode_unautop',
			'wptexturize',
		];

		foreach ( $filters as $filter ) {
			// Check if another plugin/theme do not already removed the filter.
			if ( has_filter( 'the_content', $filter ) ) {
				remove_filter( 'the_content', $filter );
				$this->content_removed_filters[] = $filter;
			}
		}
	}

	private function restore_content_filters() {
		foreach ( $this->content_removed_filters as $filter ) {
			add_filter( 'the_content', $filter );
		}
		$this->content_removed_filters = [];
	}

	public function __construct() {
		// We don't need this class in admin side, but in AJAX requests.
		if ( is_admin() && ! Utils::is_ajax() ) {
			return;
		}

		add_action( 'template_redirect', [ $this, 'init' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ], 5 );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ], 5 );
		add_filter( 'the_content', [ $this, 'apply_builder_in_content' ], self::THE_CONTENT_FILTER_PRIORITY );

		// Hack to avoid enqueue post css while it's a `the_excerpt` call.
		add_filter( 'get_the_excerpt', [ $this, 'start_excerpt_flag' ], 1 );
		add_filter( 'get_the_excerpt', [ $this, 'end_excerpt_flag' ], 20 );
	}
}
