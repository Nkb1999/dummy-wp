<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Customizer primary navbar options service.
 *
 * @package PressBook_News
 */

/**
 * Primary navbar options service class.
 */
class PressBook_News_PrimaryNavbar extends PressBook\Options {
	/**
	 * Add primary navbar options for theme customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function customize_register( $wp_customize ) {
		$this->set_primary_navbar_hover_bg_color( $wp_customize );
		$this->set_primary_navbar_hide_top_border( $wp_customize );

		$wp_customize->get_control( 'set_primary_navbar_search' )->priority = 11;
	}

	/**
	 * Add setting: Primary Navbar Hover Background Color.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_primary_navbar_hover_bg_color( $wp_customize ) {
		$wp_customize->add_setting(
			'set_styles[primary_navbar_hover_bg_color]',
			array(
				'default'           => PressBook_News_CSSRules::default_styles( 'primary_navbar_hover_bg_color' ),
				'transport'         => 'postMessage',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_alpha_color' ),
			)
		);

		$wp_customize->add_control(
			new PressBook\Options\AlphaColorControl(
				$wp_customize,
				'set_styles[primary_navbar_hover_bg_color]',
				array(
					'section'      => 'sec_primary_navbar',
					'label'        => esc_html__( 'Primary Navbar Hover Background Color', 'pressbook-news' ),
					'settings'     => 'set_styles[primary_navbar_hover_bg_color]',
					'palette'      => true,
					'show_opacity' => true,
				)
			)
		);
	}

	/**
	 * Add setting: Hide Top Border.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_primary_navbar_hide_top_border( $wp_customize ) {
		$wp_customize->add_setting(
			'set_primary_navbar_hide_top_border',
			array(
				'type'              => 'theme_mod',
				'default'           => self::get_primary_navbar_hide_top_border( true ),
				'transport'         => 'postMessage',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			'set_primary_navbar_hide_top_border',
			array(
				'section'     => 'sec_primary_navbar',
				'type'        => 'checkbox',
				'label'       => esc_html__( 'Hide Top Border', 'pressbook-news' ),
				'description' => esc_html__( 'Hide the top border of the menu item on hover or active state.', 'pressbook-news' ),
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'set_primary_navbar_hide_top_border',
			array(
				'selector'            => '.primary-navbar',
				'container_inclusive' => true,
				'render_callback'     => function() {
					get_template_part( 'template-parts/header/primary-navbar' );
				},
			)
		);
	}

	/**
	 * Get setting: Hide Top Border.
	 *
	 * @param bool $get_default Get default.
	 * @return bool
	 */
	public static function get_primary_navbar_hide_top_border( $get_default = false ) {
		$default = apply_filters( 'pressbook_default_primary_navbar_hide_top_border', false );
		if ( $get_default ) {
			return $default;
		}

		return get_theme_mod( 'set_primary_navbar_hide_top_border', $default );
	}

	/**
	 * Get primary navbar class.
	 *
	 * @return string
	 */
	public static function primary_navbar_class() {
		$primary_navbar_class = 'primary-navbar';

		if ( self::get_primary_navbar_hide_top_border() ) {
			$primary_navbar_class .= ' primary-navbar-no-border';
		}

		return apply_filters( 'pressbook_primary_navbar_class', $primary_navbar_class );
	}
}
