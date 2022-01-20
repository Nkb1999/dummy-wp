<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Carousel base class.
 *
 * @package PressBook_News
 */

/**
 * Base class for carousel service classes.
 */
abstract class PressBook_News_Carousel extends PressBook\Options {
	const PER_VIEW_SCREEN_SIZES = array( 'xlg', 'lg', 'md', 'sm', 'xs' );

	/**
	 * Posts Source.
	 *
	 * @return array
	 */
	public function source() {
		return array(
			''           => esc_html__( 'All Posts', 'pressbook-news' ),
			'categories' => esc_html__( 'Posts from Selected Categories', 'pressbook-news' ),
			'tags'       => esc_html__( 'Posts from Selected Tags', 'pressbook-news' ),
		);
	}

	/**
	 * Posts Count.
	 *
	 * @return array
	 */
	public function count() {
		return array(
			'1'  => esc_html_x( '1', 'Carousel Posts Count', 'pressbook-news' ),
			'2'  => esc_html_x( '2', 'Carousel Posts Count', 'pressbook-news' ),
			'3'  => esc_html_x( '3', 'Carousel Posts Count', 'pressbook-news' ),
			'4'  => esc_html_x( '4', 'Carousel Posts Count', 'pressbook-news' ),
			'5'  => esc_html_x( '5', 'Carousel Posts Count', 'pressbook-news' ),
			'6'  => esc_html_x( '6', 'Carousel Posts Count', 'pressbook-news' ),
			'7'  => esc_html_x( '7', 'Carousel Posts Count', 'pressbook-news' ),
			'8'  => esc_html_x( '8', 'Carousel Posts Count', 'pressbook-news' ),
			'9'  => esc_html_x( '9', 'Carousel Posts Count', 'pressbook-news' ),
			'10' => esc_html_x( '10', 'Carousel Posts Count', 'pressbook-news' ),
			'11' => esc_html_x( '11', 'Carousel Posts Count', 'pressbook-news' ),
			'12' => esc_html_x( '12', 'Carousel Posts Count', 'pressbook-news' ),
			'13' => esc_html_x( '13', 'Carousel Posts Count', 'pressbook-news' ),
			'14' => esc_html_x( '14', 'Carousel Posts Count', 'pressbook-news' ),
			'15' => esc_html_x( '15', 'Carousel Posts Count', 'pressbook-news' ),
		);
	}

	/**
	 * Posts Order.
	 *
	 * @return array
	 */
	public function order() {
		return array(
			'desc' => esc_html__( 'Latest First', 'pressbook-news' ),
			'asc'  => esc_html__( 'Oldest First', 'pressbook-news' ),
		);
	}

	/**
	 * Posts Order By.
	 *
	 * @return array
	 */
	public function orderby() {
		return array(
			'rand'     => esc_html__( 'Random Order', 'pressbook-news' ),
			'date'     => esc_html__( 'Post Date', 'pressbook-news' ),
			'modified' => esc_html__( 'Last Modified Date', 'pressbook-news' ),
		);
	}

	/**
	 * Posts Per View.
	 *
	 * @return array
	 */
	public function per_view() {
		return array(
			'1' => esc_html_x( '1', 'Carousel Posts Per View', 'pressbook-news' ),
			'2' => esc_html_x( '2', 'Carousel Posts Per View', 'pressbook-news' ),
			'3' => esc_html_x( '3', 'Carousel Posts Per View', 'pressbook-news' ),
			'4' => esc_html_x( '4', 'Carousel Posts Per View', 'pressbook-news' ),
			'5' => esc_html_x( '5', 'Carousel Posts Per View', 'pressbook-news' ),
			'6' => esc_html_x( '6', 'Carousel Posts Per View', 'pressbook-news' ),
			'7' => esc_html_x( '7', 'Carousel Posts Per View', 'pressbook-news' ),
			'8' => esc_html_x( '8', 'Carousel Posts Per View', 'pressbook-news' ),
		);
	}

	/**
	 * Get carousel slide classs.
	 *
	 * @return string
	 */
	public static function carousel_slide_class() {
		$slide_class = 'glide__slide';
		if ( ! has_post_thumbnail() ) {
			$slide_class .= ' carousel-post-only-title';
		}

		return apply_filters( 'pressbook_carousel_slide_class', $slide_class );
	}

	/**
	 * Whether to load carousel styles and scripts.
	 *
	 * @return bool
	 */
	public static function load_scripts() {
		if ( PressBook_News_Carousel_Posts::get_carousel_enable( false, 'header' ) ||
			PressBook_News_Carousel_Posts::get_carousel_enable( false, 'footer' ) ) {
			return true;
		}

		if ( is_singular( 'post' ) && PressBook_News_Related_Posts::get_related_posts_enable() ) {
			return true;
		}

		return false;
	}

	/**
	 * Sanitize controls that returns array.
	 *
	 * @param mixed $input The input from the setting.
	 * @return array
	 */
	public static function sanitize_array( $input ) {
		$output = $input;

		if ( ! is_array( $input ) ) {
			$output = explode( ',', $input );
		}

		if ( ! empty( $output ) ) {
			return array_map( 'sanitize_text_field', $output );
		}

		return array();
	}
}
