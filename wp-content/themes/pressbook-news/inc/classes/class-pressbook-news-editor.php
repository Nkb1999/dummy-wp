<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Editor service.
 *
 * @package PressBook_News
 */

/**
 * Editor setup.
 */
class PressBook_News_Editor extends PressBook\Editor {
	/**
	 * Enqueue editor assets.
	 */
	public function enqueue_editor_assets() {
		$current_screen = get_current_screen();
		if ( $current_screen && in_array( $current_screen->id, array( 'widgets', 'nav-menus' ), true ) ) {
			return;
		}

		// Enqueue fonts.
		wp_enqueue_style( 'pressbook-news-editor-fonts', PressBook_News_Scripts::fonts_url(), array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

		// Add inline style for fonts in the block editor.
		$this->load_editor_fonts_css();

		// Enqueue the block editor stylesheet.
		wp_enqueue_style( 'pressbook-news-block-editor-style', get_theme_file_uri( 'assets/css/block-editor.css' ), array(), PRESSBOOK_NEWS_VERSION );

		// Add output of customizer settings as inline style.
		wp_add_inline_style( 'pressbook-news-block-editor-style', PressBook_News_CSSRules::output_editor() );
	}

	/**
	 * Add inline style for fonts in the block editor.
	 */
	public function load_editor_fonts_css() {
		$fonts_css = '';

		/* translators: If there are characters in your language that are not supported by IBM Plex Serif, translate this to 'off'. Do not translate into your own language. */
		$ibm_plex_serif = _x( 'on', 'IBM Plex Serif font (in the editor): on or off', 'pressbook-news' );
		if ( 'off' !== $ibm_plex_serif ) {
			$fonts_css .= ( '.block-editor-page .editor-styles-wrapper{font-family:\'IBM Plex Serif\', \'Georgia\', \'Times New Roman\', serif;}' );
		}

		/* translators: If there are characters in your language that are not supported by Lora, translate this to 'off'. Do not translate into your own language. */
		$lora = _x( 'on', 'Lora font (in the editor): on or off', 'pressbook-news' );
		if ( 'off' !== $lora ) {
			$fonts_css .= ( '.editor-styles-wrapper .editor-post-title__input,.editor-styles-wrapper .editor-post-title .editor-post-title__input,.editor-styles-wrapper h1,.editor-styles-wrapper h2,.editor-styles-wrapper h3,.editor-styles-wrapper h4,.editor-styles-wrapper h5,.editor-styles-wrapper h6{font-family:\'Lora\', \'Cambria\', sans-serif;}' );
		}

		if ( '' !== $fonts_css ) {
			wp_add_inline_style( 'pressbook-news-editor-fonts', $fonts_css );
		}
	}
}
