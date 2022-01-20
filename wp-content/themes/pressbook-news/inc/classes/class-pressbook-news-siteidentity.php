<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Customizer site identity options service.
 *
 * @package PressBook_News
 */

/**
 * Site identity options service class.
 */
class PressBook_News_SiteIdentity implements PressBook\Serviceable {
	/**
	 * Register service features.
	 */
	public function register() {
		add_action( 'customize_register', array( $this, 'customize_register' ) );
		add_action( 'customize_preview_init', array( $this, 'customize_preview_scripts' ), 11 );

		add_filter( 'pressbook_default_logo_size', array( $this, 'get_logo_size_default' ) );
		add_filter( 'pressbook_default_site_title_size', array( $this, 'get_site_title_size_default' ) );
		add_filter( 'pressbook_default_tagline_size', array( $this, 'get_tagline_size_default' ) );
	}

	/**
	 * Modify site identity options for theme customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function customize_register( $wp_customize ) {
		$wp_customize->get_control( 'set_logo_size[sm]' )->description = esc_html_x( 'Default: Size 1', 'Default: Logo Size (Small-Screen Devices)', 'pressbook-news' );
		$wp_customize->get_control( 'set_logo_size[md]' )->description = esc_html_x( 'Default: Size 2', 'Default: Logo Size (Medium-Screen Devices)', 'pressbook-news' );
		$wp_customize->get_control( 'set_logo_size[lg]' )->description = esc_html_x( 'Default: Size 3', 'Default: Logo Size (Large-Screen Devices)', 'pressbook-news' );

		$wp_customize->get_control( 'set_site_title_size[sm]' )->description = esc_html_x( 'Default: Size 2', 'Default: Site Title Size (Small-Screen Devices)', 'pressbook-news' );
		$wp_customize->get_control( 'set_site_title_size[md]' )->description = esc_html_x( 'Default: Size 4', 'Default: Site Title Size (Medium-Screen Devices)', 'pressbook-news' );
		$wp_customize->get_control( 'set_site_title_size[lg]' )->description = esc_html_x( 'Default: Size 4', 'Default: Site Title Size (Large-Screen Devices)', 'pressbook-news' );

		$wp_customize->get_control( 'set_tagline_size[sm]' )->description = esc_html_x( 'Default: Size 2', 'Default: Tagline (Small-Screen Devices)', 'pressbook-news' );
		$wp_customize->get_control( 'set_tagline_size[md]' )->description = esc_html_x( 'Default: Size 3', 'Default: Tagline (Medium-Screen Devices)', 'pressbook-news' );
		$wp_customize->get_control( 'set_tagline_size[lg]' )->description = esc_html_x( 'Default: Size 3', 'Default: Tagline (Large-Screen Devices)', 'pressbook-news' );
	}

	/**
	 * Binds JS handlers to make theme customizer preview reload changes asynchronously.
	 */
	public function customize_preview_scripts() {
		wp_localize_script(
			'pressbook-customizer',
			'pressbook',
			array(
				'styles'    => PressBook_News_CSSRules::output_array(),
				'handle_id' => apply_filters( 'pressbook_news_inline_style_handle_id', 'pressbook-news-style-inline-css' ),
			)
		);
	}

	/**
	 * Get default setting: Logo Size.
	 *
	 * @return array
	 */
	public static function get_logo_size_default() {
		return array(
			'sm' => 1,
			'md' => 2,
			'lg' => 3,
		);
	}

	/**
	 * Get default setting: Size Title Size.
	 *
	 * @return array
	 */
	public static function get_site_title_size_default() {
		return array(
			'sm' => 2,
			'md' => 4,
			'lg' => 4,
		);
	}

	/**
	 * Get default setting: Tagline Size.
	 *
	 * @return array
	 */
	public static function get_tagline_size_default() {
		return array(
			'sm' => 2,
			'md' => 3,
			'lg' => 3,
		);
	}
}
