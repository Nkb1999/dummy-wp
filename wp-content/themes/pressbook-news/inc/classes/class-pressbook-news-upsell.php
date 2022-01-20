<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Upsell customizer service.
 *
 * @package PressBook_News
 */

/**
 * Upsell service class.
 */
class PressBook_News_Upsell extends PressBook\Options {
	/**
	 * Add upsell in the theme customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function customize_register( $wp_customize ) {
		$this->upsell( $wp_customize );
	}

	/**
	 * Section: Upsell.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function upsell( $wp_customize ) {
		$wp_customize->add_control(
			new \PressBook_Upsell_Control(
				$wp_customize,
				'sec_header_carousel',
				array(
					'section'     => 'sec_header_carousel',
					'type'        => 'pressbook-addon',
					'label'       => esc_html__( 'Learn More', 'pressbook-news' ),
					'description' => esc_html__( 'Custom color options for carousel arrow buttons, custom slide text color, background color, and RGBA color options are available in our premium version.', 'pressbook-news' ),
					'url'         => ( esc_url( PressBook\Helpers::get_upsell_detail_url() ) ),
					'priority'    => 999,
					'settings'    => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname',
				)
			)
		);

		$wp_customize->add_control(
			new \PressBook_Upsell_Control(
				$wp_customize,
				'sec_footer_carousel',
				array(
					'section'     => 'sec_footer_carousel',
					'type'        => 'pressbook-addon',
					'label'       => esc_html__( 'Learn More', 'pressbook-news' ),
					'description' => esc_html__( 'Custom color options for carousel arrow buttons, custom slide text color, background color, and RGBA color options are available in our premium version.', 'pressbook-news' ),
					'url'         => ( esc_url( PressBook\Helpers::get_upsell_detail_url() ) ),
					'priority'    => 999,
					'settings'    => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname',
				)
			)
		);

		$wp_customize->add_control(
			new \PressBook_Upsell_Control(
				$wp_customize,
				'sec_related_posts',
				array(
					'section'     => 'sec_related_posts',
					'type'        => 'pressbook-addon',
					'label'       => esc_html__( 'Learn More', 'pressbook-news' ),
					'description' => esc_html__( 'Custom color options for carousel arrow buttons, custom slide text color, background color, and RGBA color options are available in our premium version.', 'pressbook-news' ),
					'url'         => ( esc_url( PressBook\Helpers::get_upsell_detail_url() ) ),
					'priority'    => 999,
					'settings'    => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname',
				)
			)
		);
	}
}
