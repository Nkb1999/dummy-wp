<?php
/**
 * This is the child theme for PressBook theme.
 *
 * (See https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 *
 * @package PressBook_News
 */

defined( 'ABSPATH' ) || die();

define( 'PRESSBOOK_NEWS_VERSION', '1.0.9' );

/**
 * Load child theme text domain.
 */
function pressbook_news_setup() {
	load_child_theme_textdomain( 'pressbook-news', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'pressbook_news_setup', 11 );

/**
 * Load child theme services.
 *
 * @param  array $services Parent theme services.
 * @return array
 */
function pressbook_news_services( $services ) {
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-news-select-multiple.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-news-cssrules.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-news-scripts.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-news-editor.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-news-siteidentity.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-news-primarynavbar.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-news-carousel.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-news-carousel-posts.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-news-related-posts.php';
	require get_stylesheet_directory() . '/inc/classes/class-pressbook-news-upsell.php';

	foreach ( $services as $key => $service ) {
		if ( 'PressBook\Editor' === $service ) {
			$services[ $key ] = PressBook_News_Editor::class;
		} elseif ( 'PressBook\Scripts' === $service ) {
			$services[ $key ] = PressBook_News_Scripts::class;
		}
	}

	array_push( $services, PressBook_News_SiteIdentity::class );
	array_push( $services, PressBook_News_PrimaryNavbar::class );
	array_push( $services, PressBook_News_Carousel_Posts::class );
	array_push( $services, PressBook_News_Related_Posts::class );
	array_push( $services, PressBook_News_Upsell::class );

	return $services;
}
add_filter( 'pressbook_services', 'pressbook_news_services' );

/**
 * Add carousel posts section before the header ends.
 */
function pressbook_news_header_carousel_posts() {
	PressBook_News_Carousel_Posts::carousel_html( 'header' );
}
add_action( 'pressbook_before_header_end', 'pressbook_news_header_carousel_posts', 15 );

/**
 * Add carousel posts section after the footer starts.
 */
function pressbook_news_footer_carousel_posts() {
	PressBook_News_Carousel_Posts::carousel_html( 'footer' );
}
add_action( 'pressbook_after_footer_start', 'pressbook_news_footer_carousel_posts', 15 );

/**
 * Change default styles.
 *
 * @param  array $styles Default sttyles.
 * @return array
 */
function pressbook_news_default_styles( $styles ) {
	$styles['top_navbar_bg_color_1']         = '#537cff';
	$styles['top_navbar_bg_color_2']         = '#406dff';
	$styles['primary_navbar_bg_color']       = '#1c1c21';
	$styles['primary_navbar_hover_bg_color'] = '#ff4056';
	$styles['button_bg_color_1']             = '#406dff';
	$styles['button_bg_color_2']             = '#537cff';
	$styles['footer_bg_color']               = '#0e0e11';
	$styles['footer_credit_link_color']      = '#ff4056';

	return $styles;
}
add_filter( 'pressbook_default_styles', 'pressbook_news_default_styles' );

/**
 * Change welcome page title.
 *
 * @param  string $page_title Welcome page title.
 * @return string
 */
function pressbook_news_welcome_page_title( $page_title ) {
	return esc_html_x( 'PressBook News', 'page title', 'pressbook-news' );
}
add_filter( 'pressbook_welcome_page_title', 'pressbook_news_welcome_page_title' );

/**
 * Change welcome menu title.
 *
 * @param  string $menu_title Welcome menu title.
 * @return string
 */
function pressbook_news_welcome_menu_title( $menu_title ) {
	return esc_html_x( 'PressBook News', 'menu title', 'pressbook-news' );
}
add_filter( 'pressbook_welcome_menu_title', 'pressbook_news_welcome_menu_title' );

/**
 * Recommended plugins.
 */
require get_stylesheet_directory() . '/inc/recommended-plugins.php';
