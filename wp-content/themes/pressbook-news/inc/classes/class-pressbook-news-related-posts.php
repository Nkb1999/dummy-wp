<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Customizer related posts service.
 *
 * @package PressBook_News
 */

/**
 * Related posts carousel service class.
 */
class PressBook_News_Related_Posts extends PressBook_News_Carousel {
	/**
	 * Add related posts options for theme customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function customize_register( $wp_customize ) {
		$this->sec_related_posts( $wp_customize );

		$this->set_related_posts_enable( $wp_customize );

		$this->set_carousel_autoplay( $wp_customize );

		$this->set_related_posts_title( $wp_customize );
		$this->set_related_posts_source( $wp_customize );
		$this->set_related_posts_count( $wp_customize );
		$this->set_related_posts_order( $wp_customize );
		$this->set_related_posts_orderby( $wp_customize );

		foreach ( static::PER_VIEW_SCREEN_SIZES as $screen_size ) {
			$this->set_carousel_perview( $wp_customize, $screen_size );
		}
	}

	/**
	 * Section: Related Posts Carousel.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function sec_related_posts( $wp_customize ) {
		$wp_customize->add_section(
			'sec_related_posts',
			array(
				'panel'       => 'pan_carousel',
				'title'       => esc_html__( 'Related Posts Carousel', 'pressbook-news' ),
				'description' => esc_html__( 'You can customize the related posts carousel options in here.', 'pressbook-news' ),
				'priority'    => 169,
			)
		);
	}

	/**
	 * Add setting: Enable Related Posts Carousel.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_related_posts_enable( $wp_customize ) {
		$wp_customize->add_setting(
			'set_related_posts_enable',
			array(
				'default'           => static::get_related_posts_enable( true ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			'set_related_posts_enable',
			array(
				'section' => 'sec_related_posts',
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Enable Related Posts Carousel', 'pressbook-news' ),
			)
		);
	}

	/**
	 * Get setting: Enable Related Posts Carousel.
	 *
	 * @param bool $get_default Get default.
	 * @return string
	 */
	public static function get_related_posts_enable( $get_default = false ) {
		$default = apply_filters( 'pressbook_default_related_posts_enable', true );

		if ( $get_default ) {
			return $default;
		}

		return get_theme_mod( 'set_related_posts_enable', $default );
	}

	/**
	 * Add setting: Autoplay Related Posts Carousel.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_carousel_autoplay( $wp_customize ) {
		$wp_customize->add_setting(
			'set_related_posts_autoplay',
			array(
				'default'           => static::get_carousel_autoplay( true ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			'set_related_posts_autoplay',
			array(
				'section' => 'sec_related_posts',
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Enable Autoplay', 'pressbook-news' ),
			)
		);
	}

	/**
	 * Get setting: Autoplay Related Posts Carousel.
	 *
	 * @param bool $get_default Get default.
	 * @return string
	 */
	public static function get_carousel_autoplay( $get_default = false ) {
		$default = apply_filters( 'pressbook_default_related_posts_autoplay', true );

		if ( $get_default ) {
			return $default;
		}

		return get_theme_mod( 'set_related_posts_autoplay', $default );
	}

	/**
	 * Add setting: Related Posts Title.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_related_posts_title( $wp_customize ) {
		$wp_customize->add_setting(
			'set_related_posts[title]',
			array(
				'default'           => static::get_related_posts_default( 'title' ),
				'transport'         => 'refresh',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'set_related_posts[title]',
			array(
				'section'     => 'sec_related_posts',
				'type'        => 'text',
				'label'       => esc_html__( 'Related Posts Title', 'pressbook-news' ),
				'description' => esc_html__( 'You can change the heading of the related posts that is shown below the single post content.', 'pressbook-news' ),
			)
		);
	}

	/**
	 * Add setting: Related Posts Based On.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_related_posts_source( $wp_customize ) {
		$wp_customize->add_setting(
			'set_related_posts[source]',
			array(
				'default'           => static::get_related_posts_default( 'source' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			'set_related_posts[source]',
			array(
				'section'     => 'sec_related_posts',
				'type'        => 'select',
				'choices'     => array(
					'categories' => esc_html__( 'Categories', 'pressbook-news' ),
					'tags'       => esc_html__( 'Tags', 'pressbook-news' ),
				),
				'label'       => esc_html__( 'Related Posts Based On', 'pressbook-news' ),
				'description' => esc_html__( 'Select the source for related posts to display. Default: Categories', 'pressbook-news' ),
			)
		);
	}

	/**
	 * Add setting: Related Posts Count.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_related_posts_count( $wp_customize ) {
		$wp_customize->add_setting(
			'set_related_posts[count]',
			array(
				'default'           => static::get_related_posts_default( 'count' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			'set_related_posts[count]',
			array(
				'section'     => 'sec_related_posts',
				'type'        => 'select',
				'choices'     => $this->count(),
				'label'       => esc_html__( 'Related Posts Count', 'pressbook-news' ),
				'description' => esc_html__( 'Set the number of related posts. Default: 6', 'pressbook-news' ),
			)
		);
	}

	/**
	 * Add setting: Related Posts Order.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_related_posts_order( $wp_customize ) {
		$wp_customize->add_setting(
			'set_related_posts[order]',
			array(
				'default'           => static::get_related_posts_default( 'order' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			'set_related_posts[order]',
			array(
				'section'     => 'sec_related_posts',
				'type'        => 'select',
				'choices'     => $this->order(),
				'label'       => esc_html__( 'Related Posts Order', 'pressbook-news' ),
				'description' => esc_html__( 'Designates the ascending or descending order. Default: Latest First', 'pressbook-news' ),
			)
		);
	}

	/**
	 * Add setting: Related Posts Order By.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function set_related_posts_orderby( $wp_customize ) {
		$wp_customize->add_setting(
			'set_related_posts[orderby]',
			array(
				'default'           => static::get_related_posts_default( 'orderby' ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			'set_related_posts[orderby]',
			array(
				'section'     => 'sec_related_posts',
				'type'        => 'select',
				'choices'     => $this->orderby(),
				'label'       => esc_html__( 'Related Posts Order By', 'pressbook-news' ),
				'description' => esc_html__( 'Sort retrieved related posts by parameter. Default: Random Order', 'pressbook-news' ),
			)
		);
	}

	/**
	 * Get setting: Related Posts.
	 *
	 * @return array
	 */
	public static function get_related_posts() {
		return wp_parse_args(
			get_theme_mod( 'set_related_posts', array() ),
			static::get_related_posts_default()
		);
	}

	/**
	 * Get default setting: Related Posts.
	 *
	 * @param string $key Setting key.
	 * @return mixed|array
	 */
	public static function get_related_posts_default( $key = '' ) {
		$default = apply_filters(
			'pressbook_default_related_posts',
			array(
				'title'   => esc_html__( 'Related Posts', 'pressbook-news' ),
				'source'  => 'categories',
				'count'   => 6,
				'order'   => 'desc',
				'orderby' => 'rand',
			)
		);

		if ( array_key_exists( $key, $default ) ) {
			return $default[ $key ];
		}

		return $default;
	}

	/**
	 * Related Posts Per View.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $screen_size Screen size.
	 */
	public function set_carousel_perview( $wp_customize, $screen_size ) {
		$set_key = ( 'related_posts_carousel_perview[' . $screen_size . ']' );
		$set_id  = ( 'set_' . $set_key );

		$wp_customize->add_setting(
			$set_id,
			array(
				'default'           => static::get_carousel_perview_default( $screen_size ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			$set_id,
			array(
				'section'     => 'sec_related_posts',
				'type'        => 'select',
				'choices'     => $this->per_view(),
				'label'       => static::get_props()['set']['related_posts_carousel_perview']['label'][ $screen_size ],
				'description' => static::get_props()['set']['related_posts_carousel_perview']['desc'][ $screen_size ],
			)
		);
	}

	/**
	 * Get setting: Related Posts Per View.
	 *
	 * @return array
	 */
	public static function get_carousel_perview() {
		return wp_parse_args(
			get_theme_mod( 'set_related_posts_carousel_perview', array() ),
			static::get_carousel_perview_default()
		);
	}

	/**
	 * Get default setting: Related Posts Per View.
	 *
	 * @param string $key Setting key.
	 * @return mixed|array
	 */
	public static function get_carousel_perview_default( $key = '' ) {
		$default = apply_filters(
			'pressbook_default_related_posts_carousel_perview',
			static::get_props()['set']['related_posts_carousel_perview']['default']
		);

		if ( array_key_exists( $key, $default ) ) {
			return $default[ $key ];
		}

		return $default;
	}

	/**
	 * Get related posts options and query.
	 *
	 * @return array|bool
	 */
	public static function options() {
		if ( ! static::get_related_posts_enable() ) {
			return false;
		}

		$carousel = static::get_related_posts();

		$query_args = array(
			'post_type'           => array( 'post' ),
			'post_status'         => 'publish',
			'posts_per_page'      => absint( $carousel['count'] ),
			'post__not_in'        => array( get_the_ID() ),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'order'               => strtoupper( $carousel['order'] ),
			'orderby'             => $carousel['orderby'],
		);

		if ( 'tags' === $carousel['source'] ) {
			$tags_id = wp_get_post_tags( get_the_ID(), array( 'fields' => 'ids' ) );
			if ( ! is_wp_error( $tags_id ) && ! empty( $tags_id ) ) {
				$query_args['tag__in'] = $tags_id;
			} else {
				return false;
			}
		} else {
			$categories_id = wp_get_post_categories( get_the_ID(), array( 'fields' => 'ids' ) );
			if ( ! is_wp_error( $categories_id ) && ! empty( $categories_id ) ) {
				$query_args['category__in'] = $categories_id;
			} else {
				return false;
			}
		}

		return array(
			'options' => $carousel,
			'query'   => ( new \WP_Query( $query_args ) ),
		);
	}

	/**
	 * Get properties.
	 *
	 * @return array
	 */
	public static function get_props() {
		return apply_filters(
			'pressbook_related_posts_properties',
			array(
				'set' => array(
					'related_posts_carousel_perview' => array(
						'default' => array(
							'xlg' => 2,
							'lg'  => 2,
							'md'  => 1,
							'sm'  => 1,
							'xs'  => 1,
						),
						'label'   => array(
							'xlg' => esc_html__( 'Related Posts Per View Inside Carousel (Extra Large Screen-Devices)', 'pressbook-news' ),
							'lg'  => esc_html__( 'Related Posts Per View Inside Carousel (Large Screen-Devices)', 'pressbook-news' ),
							'md'  => esc_html__( 'Related Posts Per View Inside Carousel (Medium Screen-Devices)', 'pressbook-news' ),
							'sm'  => esc_html__( 'Related Posts Per View Inside Carousel (Small Screen-Devices)', 'pressbook-news' ),
							'xs'  => esc_html__( 'Related Posts Per View Inside Carousel (Extra Small Screen-Devices)', 'pressbook-news' ),
						),
						'desc'    => array(
							'xlg' => esc_html__( 'Default: 2', 'pressbook-news' ),
							'lg'  => esc_html__( 'Default: 2', 'pressbook-news' ),
							'md'  => esc_html__( 'Default: 1', 'pressbook-news' ),
							'sm'  => esc_html__( 'Default: 1', 'pressbook-news' ),
							'xs'  => esc_html__( 'Default: 1', 'pressbook-news' ),
						),
					),
				),
			)
		);
	}
}
