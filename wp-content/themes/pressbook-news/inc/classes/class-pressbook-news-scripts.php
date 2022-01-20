<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Scripts service.
 *
 * @package PressBook_News
 */

/**
 * Enqueue theme styles and scripts.
 */
class PressBook_News_Scripts extends PressBook\Scripts {
	/**
	 * Register service features.
	 */
	public function register() {
		parent::register();

		// Remove parent theme inline stlyes.
		add_action( 'wp_print_styles', array( $this, 'print_styles' ) );

		if ( is_admin() && isset( $GLOBALS['pagenow'] ) && in_array( $GLOBALS['pagenow'], array( 'widgets.php', 'nav-menus.php' ), true ) ) {
			add_action( 'wp_print_styles', array( $this, 'remove_dynamic_styles' ) );
		}
	}

	/**
	 * Enqueue styles and scripts.
	 */
	public function enqueue_scripts() {
		$pressbook_load_carousel = PressBook_News_Carousel::load_scripts();

		// Enqueue child theme fonts.
		wp_enqueue_style( 'pressbook-news-fonts', static::fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

		if ( $pressbook_load_carousel ) {
			// Glide assets.
			wp_enqueue_style( 'glide', get_stylesheet_directory_uri() . '/assets/glide/css/glide.core.min.css', array(), '3.4.1' );
			wp_enqueue_script( 'glide', get_stylesheet_directory_uri() . '/assets/glide/glide.min.js', array(), '3.4.1', true );
		}

		// Enqueue parent theme styles and scripts.
		parent::enqueue_scripts();

		// Dequeue parent theme fonts.
		wp_dequeue_style( 'pressbook-fonts' );

		// Enqueue child theme stylesheet.
		wp_enqueue_style( 'pressbook-news-style', get_stylesheet_directory_uri() . '/style.min.css', array(), PRESSBOOK_NEWS_VERSION );
		wp_style_add_data( 'pressbook-news-style', 'rtl', 'replace' );

		// Add output of customizer settings as inline style.
		wp_add_inline_style( 'pressbook-news-style', PressBook_News_CSSRules::output() );

		if ( $pressbook_load_carousel ) {
			// Carousel script.
			wp_enqueue_script( 'pressbook-news-script', get_stylesheet_directory_uri() . '/assets/js/script.min.js', array( 'glide' ), PRESSBOOK_NEWS_VERSION, true );

			wp_localize_script(
				'pressbook-news-script',
				'pressbookCarousel',
				array(
					'header'  => array(
						'autoplay' => PressBook_News_Carousel_Posts::get_carousel_autoplay( false, 'header' ),
						'perView'  => PressBook_News_Carousel_Posts::get_carousel_perview( 'header' ),
					),
					'footer'  => array(
						'autoplay' => PressBook_News_Carousel_Posts::get_carousel_autoplay( false, 'footer' ),
						'perView'  => PressBook_News_Carousel_Posts::get_carousel_perview( 'footer' ),
					),
					'related' => array(
						'autoplay' => PressBook_News_Related_Posts::get_carousel_autoplay(),
						'perView'  => PressBook_News_Related_Posts::get_carousel_perview(),
					),
				)
			);
		}
	}

	/**
	 * Add preconnect for Google fonts.
	 *
	 * @param array  $urls           URLs to print for resource hints.
	 * @param string $relation_type  The relation type the URLs are printed.
	 * @return array $urls           URLs to print for resource hints.
	 */
	public function resource_hints( $urls, $relation_type ) {
		if ( wp_style_is( 'pressbook-news-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
			$urls[] = array(
				'href' => 'https://fonts.gstatic.com',
				'crossorigin',
			);
		}

		return $urls;
	}

	/**
	 * Get fonts URL.
	 */
	public static function fonts_url() {
		$fonts_url = '';

		$font_families = array();

		$query_params = array();

		/* translators: If there are characters in your language that are not supported by IBM Plex Serif, translate this to 'off'. Do not translate into your own language. */
		$ibm_plex_serif = _x( 'on', 'IBM Plex Serif font: on or off', 'pressbook-news' );
		if ( 'off' !== $ibm_plex_serif ) {
			array_push( $font_families, 'IBM+Plex+Serif:ital,wght@0,400;0,600;1,400;1,600' );
		}

		/* translators: If there are characters in your language that are not supported by Lora, translate this to 'off'. Do not translate into your own language. */
		$lora = _x( 'on', 'Lora font: on or off', 'pressbook-news' );
		if ( 'off' !== $lora ) {
			array_push( $font_families, 'Lora:ital,wght@0,400;0,600;1,400;1,600' );
		}

		if ( count( $font_families ) > 0 ) {
			foreach ( $font_families as $font_family ) {
				array_push( $query_params, ( 'family=' . $font_family ) );
			}

			array_push( $query_params, 'display=swap' );

			$fonts_url = ( 'https://fonts.googleapis.com/css2?' . implode( '&#038;', $query_params ) );
		}

		$fonts_url = apply_filters( 'pressbook_news_fonts_url', $fonts_url );

		return esc_url_raw( $fonts_url );
	}

	/**
	 * Remove parent theme inline style.
	 */
	public function print_styles() {
		if ( wp_style_is( 'pressbook-style', 'enqueued' ) ) {
			wp_style_add_data( 'pressbook-style', 'after', '' );
		}
	}

	/**
	 * Remove theme inline style.
	 */
	public function remove_dynamic_styles() {
		if ( wp_style_is( 'pressbook-news-style', 'enqueued' ) ) {
			wp_style_add_data( 'pressbook-news-style', 'after', '' );
		}
	}
}
