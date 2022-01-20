<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Customizer carousel posts service.
 *
 * @package PressBook_News
 */

/**
 * Carousel posts service class.
 */
class PressBook_News_Carousel_Posts extends PressBook_News_Carousel {
	const CONTEXT = array( 'header', 'footer' );

	/**
	 * Allows to define customizer sections, settings, and controls.
	 */
	public function register() {
		add_action( 'customize_register', array( $this, 'customize_register' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_scripts' ) );
	}

	/**
	 * Add carousel options for theme customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function customize_register( $wp_customize ) {
		$this->pan_carousel( $wp_customize );

		if ( method_exists( $wp_customize, 'register_control_type' ) ) {
			$wp_customize->register_control_type( PressBook_News_Select_Multiple::class );
		}

		foreach ( static::CONTEXT as $context ) {
			$this->sec_carousel( $wp_customize, $context );

			$this->set_carousel_enable( $wp_customize, $context );

			$this->set_carousel_autoplay( $wp_customize, $context );

			$this->set_carousel_show( $wp_customize, $context );

			$this->set_carousel_source( $wp_customize, $context );
			$this->set_carousel_categories( $wp_customize, $context );
			$this->set_carousel_tags( $wp_customize, $context );
			$this->set_carousel_count( $wp_customize, $context );
			$this->set_carousel_order( $wp_customize, $context );
			$this->set_carousel_orderby( $wp_customize, $context );

			foreach ( static::PER_VIEW_SCREEN_SIZES as $screen_size ) {
				$this->set_carousel_perview( $wp_customize, $screen_size, $context );
			}
		}
	}

	/**
	 * Panel: Posts Carousel.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function pan_carousel( $wp_customize ) {
		$wp_customize->add_panel(
			'pan_carousel',
			array(
				'title'       => esc_html__( 'Posts Carousel', 'pressbook-news' ),
				'description' => esc_html__( 'You can customize the posts carousel options in here.', 'pressbook-news' ),
				'priority'    => 160,
			)
		);
	}

	/**
	 * Section: Posts Carousel.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $context Carousel context.
	 */
	public function sec_carousel( $wp_customize, $context = 'header' ) {
		$wp_customize->add_section(
			static::get_context_props()[ $context ]['sec']['id'],
			array(
				'panel'       => 'pan_carousel',
				'title'       => static::get_context_props()[ $context ]['sec']['title'],
				'description' => static::get_context_props()[ $context ]['sec']['desc'],
				'priority'    => static::get_context_props()[ $context ]['sec']['priority'],
			)
		);
	}

	/**
	 * Add setting: Enable Posts Carousel.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $context Carousel context.
	 */
	public function set_carousel_enable( $wp_customize, $context = 'header' ) {
		$set_key = ( $context . '_carousel_enable' );
		$set_id  = ( 'set_' . $set_key );

		$wp_customize->add_setting(
			$set_id,
			array(
				'default'           => static::get_carousel_enable( true, $context ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			$set_id,
			array(
				'section' => static::get_context_props()[ $context ]['sec']['id'],
				'type'    => 'checkbox',
				'label'   => static::get_context_props()[ $context ]['set']['carousel_enable']['label'],
			)
		);
	}

	/**
	 * Get setting: Enable Posts Carousel.
	 *
	 * @param bool   $get_default Get default.
	 * @param string $context Carousel context.
	 *
	 * @return string
	 */
	public static function get_carousel_enable( $get_default = false, $context = 'header' ) {
		$set_key = ( $context . '_carousel_enable' );
		$set_id  = ( 'set_' . $set_key );

		$default = apply_filters(
			( 'pressbook_default_' . $set_key ),
			static::get_context_props()[ $context ]['set']['carousel_enable']['default']
		);

		if ( $get_default ) {
			return $default;
		}

		return get_theme_mod( $set_id, $default );
	}

	/**
	 * Add setting: Autoplay Posts Carousel.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $context Carousel context.
	 */
	public function set_carousel_autoplay( $wp_customize, $context = 'header' ) {
		$set_key = ( $context . '_carousel_autoplay' );
		$set_id  = ( 'set_' . $set_key );

		$wp_customize->add_setting(
			$set_id,
			array(
				'default'           => static::get_carousel_autoplay( true, $context ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			$set_id,
			array(
				'section' => static::get_context_props()[ $context ]['sec']['id'],
				'type'    => 'checkbox',
				'label'   => static::get_context_props()[ $context ]['set']['carousel_autoplay']['label'],
			)
		);
	}

	/**
	 * Get setting: Autoplay Posts Carousel.
	 *
	 * @param bool   $get_default Get default.
	 * @param string $context Carousel context.
	 *
	 * @return string
	 */
	public static function get_carousel_autoplay( $get_default = false, $context = 'header' ) {
		$set_key = ( $context . '_carousel_autoplay' );
		$set_id  = ( 'set_' . $set_key );

		$default = apply_filters(
			( 'pressbook_default_' . $set_key ),
			static::get_context_props()[ $context ]['set']['carousel_autoplay']['default']
		);

		if ( $get_default ) {
			return $default;
		}

		return get_theme_mod( $set_id, $default );
	}

	/**
	 * Add setting: Carousel Posts Show.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $context Carousel context.
	 */
	public function set_carousel_show( $wp_customize, $context = 'header' ) {
		$set_key = ( $context . '_carousel_show' );
		$set_id  = ( 'set_' . $set_key );

		$set_in_front = ( $set_id . '[in_front]' );

		$wp_customize->add_setting(
			$set_in_front,
			array(
				'type'              => 'theme_mod',
				'default'           => static::get_carousel_show_default( 'in_front', $context ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			$set_in_front,
			array(
				'section' => static::get_context_props()[ $context ]['sec']['id'],
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Show in Front Page', 'pressbook-news' ),
			)
		);

		$set_in_blog = ( $set_id . '[in_blog]' );

		$wp_customize->add_setting(
			$set_in_blog,
			array(
				'type'              => 'theme_mod',
				'default'           => static::get_carousel_show_default( 'in_blog', $context ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			$set_in_blog,
			array(
				'section' => static::get_context_props()[ $context ]['sec']['id'],
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Show in Blog Page', 'pressbook-news' ),
			)
		);

		$set_in_archive = ( $set_id . '[in_archive]' );

		$wp_customize->add_setting(
			$set_in_archive,
			array(
				'type'              => 'theme_mod',
				'default'           => static::get_carousel_show_default( 'in_archive', $context ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			$set_in_archive,
			array(
				'section' => static::get_context_props()[ $context ]['sec']['id'],
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Show in Archive Pages', 'pressbook-news' ),
			)
		);

		$set_in_post = ( $set_id . '[in_post]' );

		$wp_customize->add_setting(
			$set_in_post,
			array(
				'type'              => 'theme_mod',
				'default'           => static::get_carousel_show_default( 'in_post', $context ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			$set_in_post,
			array(
				'section' => static::get_context_props()[ $context ]['sec']['id'],
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Show in Posts', 'pressbook-news' ),
			)
		);

		$set_in_page = ( $set_id . '[in_page]' );

		$wp_customize->add_setting(
			$set_in_page,
			array(
				'type'              => 'theme_mod',
				'default'           => static::get_carousel_show_default( 'in_page', $context ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_checkbox' ),
			)
		);

		$wp_customize->add_control(
			$set_in_page,
			array(
				'section' => static::get_context_props()[ $context ]['sec']['id'],
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Show in Pages', 'pressbook-news' ),
			)
		);
	}

	/**
	 * Get setting: Carousel Posts Show.
	 *
	 * @param string $context Carousel context.
	 * @return array
	 */
	public static function get_carousel_show( $context = 'header' ) {
		$set_key = ( $context . '_carousel_show' );
		$set_id  = ( 'set_' . $set_key );

		return wp_parse_args(
			get_theme_mod( $set_id, array() ),
			static::get_carousel_show_default( '', $context )
		);
	}

	/**
	 * Get default setting: Carousel Posts Show.
	 *
	 * @param string $key Setting key.
	 * @param string $context Carousel context.
	 *
	 * @return mixed|array
	 */
	public static function get_carousel_show_default( $key = '', $context = 'header' ) {
		$set_key = ( $context . '_carousel_show' );

		$default = apply_filters(
			( 'pressbook_default_' . $set_key ),
			static::get_context_props()[ $context ]['set']['carousel_show']['default']
		);

		if ( array_key_exists( $key, $default ) ) {
			return $default[ $key ];
		}

		return $default;
	}

	/**
	 * Add setting: Carousel Posts Source.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $context Carousel context.
	 */
	public function set_carousel_source( $wp_customize, $context = 'header' ) {
		$set_key = ( $context . '_carousel[source]' );
		$set_id  = ( 'set_' . $set_key );

		$wp_customize->add_setting(
			$set_id,
			array(
				'default'           => static::get_carousel_default( 'source', $context ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			$set_id,
			array(
				'section'     => static::get_context_props()[ $context ]['sec']['id'],
				'type'        => 'select',
				'choices'     => $this->source(),
				'label'       => static::get_context_props()[ $context ]['set']['carousel']['label']['source'],
				'description' => static::get_context_props()[ $context ]['set']['carousel']['desc']['source'],
			)
		);
	}

	/**
	 * Add setting: Carousel Posts Categories.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $context Carousel context.
	 */
	public function set_carousel_categories( $wp_customize, $context = 'header' ) {
		$set_key = ( $context . '_carousel[categories]' );
		$set_id  = ( 'set_' . $set_key );

		$wp_customize->add_setting(
			$set_id,
			array(
				'default'           => static::get_carousel_default( 'categories', $context ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook_News_Carousel::class, 'sanitize_array' ),
			)
		);

		$control_args = array(
			'section'     => static::get_context_props()[ $context ]['sec']['id'],
			'type'        => 'pressbook-select-multiple',
			'choices'     => $this->categories(),
			'label'       => static::get_context_props()[ $context ]['set']['carousel']['label']['categories'],
			'description' => static::get_context_props()[ $context ]['set']['carousel']['desc']['categories'],
			'settings'    => ( isset( $wp_customize->selective_refresh ) ) ? array( $set_id ) : $set_id,
		);

		if ( 'footer' === $context ) {
			$control_args['active_callback'] = function() {
				$carousel = static::get_carousel( 'footer' );
				if ( 'categories' === $carousel['source'] ) {
					return true;
				}

				return false;
			};
		} elseif ( 'header' === $context ) {
			$control_args['active_callback'] = function() {
				$carousel = static::get_carousel( 'header' );
				if ( 'categories' === $carousel['source'] ) {
					return true;
				}

				return false;
			};
		}

		$wp_customize->add_control(
			new PressBook_News_Select_Multiple(
				$wp_customize,
				$set_id,
				$control_args
			)
		);
	}

	/**
	 * Add setting: Carousel Posts Tags.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $context Carousel context.
	 */
	public function set_carousel_tags( $wp_customize, $context = 'header' ) {
		$set_key = ( $context . '_carousel[tags]' );
		$set_id  = ( 'set_' . $set_key );

		$wp_customize->add_setting(
			$set_id,
			array(
				'default'           => static::get_carousel_default( 'tags', $context ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook_News_Carousel::class, 'sanitize_array' ),
			)
		);

		$control_args = array(
			'section'     => static::get_context_props()[ $context ]['sec']['id'],
			'type'        => 'pressbook-select-multiple',
			'choices'     => $this->tags(),
			'label'       => static::get_context_props()[ $context ]['set']['carousel']['label']['tags'],
			'description' => static::get_context_props()[ $context ]['set']['carousel']['desc']['tags'],
			'settings'    => ( isset( $wp_customize->selective_refresh ) ) ? array( $set_id ) : $set_id,
		);

		if ( 'footer' === $context ) {
			$control_args['active_callback'] = function() {
				$carousel = static::get_carousel( 'footer' );
				if ( 'tags' === $carousel['source'] ) {
					return true;
				}

				return false;
			};
		} elseif ( 'header' === $context ) {
			$control_args['active_callback'] = function() {
				$carousel = static::get_carousel( 'header' );
				if ( 'tags' === $carousel['source'] ) {
					return true;
				}

				return false;
			};
		}

		$wp_customize->add_control(
			new PressBook_News_Select_Multiple(
				$wp_customize,
				$set_id,
				$control_args
			)
		);
	}

	/**
	 * Add setting: Carousel Posts Count.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $context Carousel context.
	 */
	public function set_carousel_count( $wp_customize, $context = 'header' ) {
		$set_key = ( $context . '_carousel[count]' );
		$set_id  = ( 'set_' . $set_key );

		$wp_customize->add_setting(
			$set_id,
			array(
				'default'           => static::get_carousel_default( 'count', $context ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			$set_id,
			array(
				'section'     => static::get_context_props()[ $context ]['sec']['id'],
				'type'        => 'select',
				'choices'     => $this->count(),
				'label'       => static::get_context_props()[ $context ]['set']['carousel']['label']['count'],
				'description' => static::get_context_props()[ $context ]['set']['carousel']['desc']['count'],
			)
		);
	}

	/**
	 * Add setting: Carousel Posts Order.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $context Carousel context.
	 */
	public function set_carousel_order( $wp_customize, $context = 'header' ) {
		$set_key = ( $context . '_carousel[order]' );
		$set_id  = ( 'set_' . $set_key );

		$wp_customize->add_setting(
			$set_id,
			array(
				'default'           => static::get_carousel_default( 'order', $context ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			$set_id,
			array(
				'section'     => static::get_context_props()[ $context ]['sec']['id'],
				'type'        => 'select',
				'choices'     => $this->order(),
				'label'       => static::get_context_props()[ $context ]['set']['carousel']['label']['order'],
				'description' => static::get_context_props()[ $context ]['set']['carousel']['desc']['order'],
			)
		);
	}

	/**
	 * Add setting: Carousel Posts Order By.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $context Carousel context.
	 */
	public function set_carousel_orderby( $wp_customize, $context = 'header' ) {
		$set_key = ( $context . '_carousel[orderby]' );
		$set_id  = ( 'set_' . $set_key );

		$wp_customize->add_setting(
			$set_id,
			array(
				'default'           => static::get_carousel_default( 'orderby', $context ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			$set_id,
			array(
				'section'     => static::get_context_props()[ $context ]['sec']['id'],
				'type'        => 'select',
				'choices'     => $this->orderby(),
				'label'       => static::get_context_props()[ $context ]['set']['carousel']['label']['orderby'],
				'description' => static::get_context_props()[ $context ]['set']['carousel']['desc']['orderby'],
			)
		);
	}

	/**
	 * Get setting: Posts Carousel.
	 *
	 * @param string $context Carousel context.
	 * @return array
	 */
	public static function get_carousel( $context = 'header' ) {
		$set_key = ( $context . '_carousel' );
		$set_id  = ( 'set_' . $set_key );

		return wp_parse_args(
			get_theme_mod( $set_id, array() ),
			static::get_carousel_default( '', $context )
		);
	}

	/**
	 * Get default setting: Posts Carousel.
	 *
	 * @param string $key Setting key.
	 * @param string $context Carousel context.
	 *
	 * @return mixed|array
	 */
	public static function get_carousel_default( $key = '', $context = 'header' ) {
		$set_key = ( $context . '_carousel' );

		$default = apply_filters(
			( 'pressbook_default_' . $set_key ),
			static::get_context_props()[ $context ]['set']['carousel']['default']
		);

		if ( array_key_exists( $key, $default ) ) {
			return $default[ $key ];
		}

		return $default;
	}

	/**
	 * Carousel Posts Per View.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @param string               $screen_size Screen size.
	 * @param string               $context Carousel context.
	 */
	public function set_carousel_perview( $wp_customize, $screen_size, $context = 'header' ) {
		$set_key = ( $context . '_carousel_perview[' . $screen_size . ']' );
		$set_id  = ( 'set_' . $set_key );

		$wp_customize->add_setting(
			$set_id,
			array(
				'default'           => static::get_carousel_perview_default( $screen_size, $context ),
				'transport'         => 'refresh',
				'sanitize_callback' => array( PressBook\Options\Sanitizer::class, 'sanitize_select' ),
			)
		);

		$wp_customize->add_control(
			$set_id,
			array(
				'section'     => static::get_context_props()[ $context ]['sec']['id'],
				'type'        => 'select',
				'choices'     => $this->per_view(),
				'label'       => static::get_context_props()[ $context ]['set']['carousel_perview']['label'][ $screen_size ],
				'description' => static::get_context_props()[ $context ]['set']['carousel_perview']['desc'][ $screen_size ],
			)
		);
	}

	/**
	 * Get setting: Carousel Posts Per View.
	 *
	 * @param string $context Carousel context.
	 * @return array
	 */
	public static function get_carousel_perview( $context = 'header' ) {
		$set_key = ( $context . '_carousel_perview' );
		$set_id  = ( 'set_' . $set_key );

		return wp_parse_args(
			get_theme_mod( $set_id, array() ),
			static::get_carousel_perview_default( '', $context )
		);
	}

	/**
	 * Get default setting: Carousel Posts Per View.
	 *
	 * @param string $key Setting key.
	 * @param string $context Carousel context.
	 *
	 * @return mixed|array
	 */
	public static function get_carousel_perview_default( $key = '', $context = 'header' ) {
		$set_key = ( $context . '_carousel_perview' );

		$default = apply_filters(
			( 'pressbook_default_' . $set_key ),
			static::get_context_props()[ $context ]['set']['carousel_perview']['default']
		);

		if ( array_key_exists( $key, $default ) ) {
			return $default[ $key ];
		}

		return $default;
	}

	/**
	 * Get posts carousel options and query.
	 *
	 * @param string $context Carousel context.
	 * @return array|bool
	 */
	public static function options( $context ) {
		if ( ! static::get_carousel_enable( false, $context ) ) {
			return false;
		}

		$carousel_show = static::get_carousel_show( $context );

		if ( empty( $carousel_show ) ) {
			return false;
		}

		if ( ( is_front_page() && ! $carousel_show['in_front'] ) ||
			( is_home() && ! $carousel_show['in_blog'] ) ||
			( is_archive() && ! $carousel_show['in_archive'] ) ||
			( is_404() ) ||
			( is_search() && ! $carousel_show['in_archive'] ) ||
			( is_single() && ! $carousel_show['in_post'] ) ||
			( ( ! is_front_page() && is_page() ) && ! $carousel_show['in_page'] ) ) {
			return false;
		}

		$carousel = static::get_carousel( $context );

		$query_args = array(
			'post_type'           => array( 'post' ),
			'post_status'         => 'publish',
			'posts_per_page'      => absint( $carousel['count'] ),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'order'               => strtoupper( $carousel['order'] ),
			'orderby'             => $carousel['orderby'],
		);

		if ( is_singular( 'post' ) ) {
			$query_args['post__not_in'] = array( get_the_ID() );
		}

		if ( 'categories' === $carousel['source'] ) {
			if ( is_array( $carousel['categories'] ) && ! empty( $carousel['categories'] ) ) {
				$query_args['category__in'] = $carousel['categories'];
			} else {
				return false;
			}
		} elseif ( 'tags' === $carousel['source'] ) {
			if ( is_array( $carousel['tags'] ) && ! empty( $carousel['tags'] ) ) {
				$query_args['tag__in'] = $carousel['tags'];
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
	 * Get posts carousel HTML.
	 *
	 * @param string $context Carousel context.
	 */
	public static function carousel_html( $context ) {
		$pressbook_carousel = static::options( $context );
		if ( ! $pressbook_carousel ) {
			return;
		}

		$pressbook_query = $pressbook_carousel['query'];
		if ( ! $pressbook_query->have_posts() ) {
			return;
		}
		?>
		<div class="u-wrapper <?php echo esc_attr( $context ); ?>-carousel-posts-wrap">
			<div class="glide carousel-posts <?php echo esc_attr( $context ); ?>-carousel-posts">
				<div class="glide__track" data-glide-el="track">
					<ul class="glide__slides">
					<?php
					while ( $pressbook_query->have_posts() ) {
						$pressbook_query->the_post();
						$pressbook_categories = get_the_category( get_the_ID() );
						?>
						<li class="<?php echo esc_attr( static::carousel_slide_class() ); ?>">
						<?php
						if ( has_post_thumbnail() ) {
							?>
							<div class="carousel-post-image-wrap">

								<a href="<?php the_permalink(); ?>" class="carousel-post-image-link">
									<?php
									the_post_thumbnail(
										'post-thumbnail',
										array( 'class' => 'carousel-post-image' )
									);
									?>
								</a>
							</div>
							<?php
						}
						?>
							<div class="carousel-post-title-wrap">
							<?php
							if ( '' !== get_the_title() ) {
								?>
								<a href="<?php the_permalink(); ?>" class="carousel-post-title-link"><?php the_title(); ?></a>
								<?php
							}
							if ( ! empty( $pressbook_categories ) ) {
								$pressbook_category = $pressbook_categories[0];
								?>
								<a class="carousel-post-taxonomy-link" href="<?php echo esc_url( get_category_link( $pressbook_category->term_id ) ); ?>"><?php echo esc_html( $pressbook_category->name ); ?></a>
								<?php
							} else {
								$pressbook_tags = get_the_tags( get_the_ID() );
								if ( ! empty( $pressbook_tags ) ) {
									$pressbook_tag = $pressbook_tags[0];
									?>
								<a class="carousel-post-taxonomy-link" href="<?php echo esc_url( get_tag_link( $pressbook_tag->term_id ) ); ?>"><?php echo esc_html( $pressbook_tag->name ); ?></a>
									<?php
								} elseif ( '' !== get_the_excerpt() ) {
									?>
								<p class="carousel-post-excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
									<?php
								}
							}
							?>
							</div>
						</li>
						<?php
					}

					wp_reset_postdata();
					?>
					</ul>
				</div>

				<div class="glide__arrows" data-glide-el="controls">
					<button class="glide__arrow glide__arrow--left" data-glide-dir="<">
						<span class="screen-reader-text"><?php echo esc_html( _x( 'prev', 'carousel previous', 'pressbook-news' ) ); ?></span>
						<?php PressBook\IconsHelper::the_theme_svg( 'chevron_down' ); ?>
					</button>
					<button class="glide__arrow glide__arrow--right" data-glide-dir=">">
						<span class="screen-reader-text"><?php echo esc_html( _x( 'next', 'carousel next', 'pressbook-news' ) ); ?></span>
						<?php PressBook\IconsHelper::the_theme_svg( 'chevron_down' ); ?>
					</button>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Post Categories.
	 *
	 * @return array
	 */
	public function categories() {
		$data       = array();
		$categories = get_categories(
			array(
				'orderby'    => 'count',
				'hide_empty' => false,
			)
		);

		foreach ( $categories as $category ) {
			$data[ $category->term_id ] = $category->name;
		}

		return $data;
	}

	/**
	 * Post Tags.
	 *
	 * @return array
	 */
	public function tags() {
		$data = array();
		$tags = get_tags(
			array(
				'orderby'    => 'count',
				'hide_empty' => false,
			)
		);

		foreach ( $tags as $tag ) {
			$data[ $tag->term_id ] = $tag->name;
		}

		return $data;
	}

	/**
	 * Contextual controls scripts.
	 */
	public function customize_controls_scripts() {
		wp_enqueue_script( 'pressbook-news-customizer-contextual', get_stylesheet_directory_uri() . '/assets/js/customizer-contextual.js', array( 'customize-controls' ), PRESSBOOK_NEWS_VERSION, true );
	}

	/**
	 * Get context properties.
	 *
	 * @return array
	 */
	public static function get_context_props() {
		return apply_filters(
			'pressbook_carousel_posts_properties',
			array(
				'header' => array(
					'sec' => array(
						'id'       => 'sec_header_carousel',
						'title'    => esc_html__( 'Header Posts Carousel', 'pressbook-news' ),
						'desc'     => esc_html__( 'You can customize the header posts carousel options in here.', 'pressbook-news' ),
						'priority' => 165,
					),
					'set' => array(
						'carousel_enable'   => array(
							'default' => true,
							'label'   => esc_html__( 'Enable Header Posts Carousel', 'pressbook-news' ),
						),
						'carousel_autoplay' => array(
							'default' => true,
							'label'   => esc_html__( 'Enable Autoplay', 'pressbook-news' ),
						),
						'carousel'          => array(
							'default' => array(
								'source'     => '',
								'categories' => array(),
								'tags'       => array(),
								'count'      => 8,
								'order'      => 'desc',
								'orderby'    => 'rand',
							),
							'label'   => array(
								'source'     => esc_html__( 'Header Carousel Posts Source', 'pressbook-news' ),
								'categories' => esc_html__( 'Categories', 'pressbook-news' ),
								'tags'       => esc_html__( 'Tags', 'pressbook-news' ),
								'count'      => esc_html__( 'Header Carousel Posts Count', 'pressbook-news' ),
								'order'      => esc_html__( 'Header Carousel Posts Order', 'pressbook-news' ),
								'orderby'    => esc_html__( 'Header Carousel Posts Order By', 'pressbook-news' ),
							),
							'desc'    => array(
								'source'     => esc_html__( 'Default: All Posts', 'pressbook-news' ),
								'categories' => esc_html__( 'Select the categories for the carousel posts in the header. You can select multiple categories by holding the CTRL key.', 'pressbook-news' ),
								'tags'       => esc_html__( 'Select the tags for the carousel posts in the header. You can select multiple tags by holding the CTRL key.', 'pressbook-news' ),
								'count'      => esc_html__( 'Set the number of related posts. Default: 8', 'pressbook-news' ),
								'order'      => esc_html__( 'Designates the ascending or descending order. Default: Latest First', 'pressbook-news' ),
								'orderby'    => esc_html__( 'Sort retrieved related posts by parameter. Default: Random Order', 'pressbook-news' ),
							),
						),
						'carousel_perview'  => array(
							'default' => array(
								'xlg' => 4,
								'lg'  => 3,
								'md'  => 2,
								'sm'  => 1,
								'xs'  => 1,
							),
							'label'   => array(
								'xlg' => esc_html__( 'Header Carousel Total Posts Per View (Extra Large Screen-Devices)', 'pressbook-news' ),
								'lg'  => esc_html__( 'Header Carousel Total Posts Per View (Large Screen-Devices)', 'pressbook-news' ),
								'md'  => esc_html__( 'Header Carousel Total Posts Per View (Medium Screen-Devices)', 'pressbook-news' ),
								'sm'  => esc_html__( 'Header Carousel Total Posts Per View (Small Screen-Devices)', 'pressbook-news' ),
								'xs'  => esc_html__( 'Header Carousel Total Posts Per View (Extra Small Screen-Devices)', 'pressbook-news' ),
							),
							'desc'    => array(
								'xlg' => esc_html__( 'Default: 4', 'pressbook-news' ),
								'lg'  => esc_html__( 'Default: 3', 'pressbook-news' ),
								'md'  => esc_html__( 'Default: 2', 'pressbook-news' ),
								'sm'  => esc_html__( 'Default: 1', 'pressbook-news' ),
								'xs'  => esc_html__( 'Default: 1', 'pressbook-news' ),
							),
						),
						'carousel_show'     => array(
							'default' => array(
								'in_front'   => true,
								'in_blog'    => true,
								'in_archive' => true,
								'in_post'    => true,
								'in_page'    => false,
							),
						),
					),
				),
				'footer' => array(
					'sec' => array(
						'id'       => 'sec_footer_carousel',
						'title'    => esc_html__( 'Footer Posts Carousel', 'pressbook-news' ),
						'desc'     => esc_html__( 'You can customize the footer posts carousel options in here.', 'pressbook-news' ),
						'priority' => 167,
					),
					'set' => array(
						'carousel_enable'   => array(
							'default' => true,
							'label'   => esc_html__( 'Enable Footer Posts Carousel', 'pressbook-news' ),
						),
						'carousel_autoplay' => array(
							'default' => true,
							'label'   => esc_html__( 'Enable Autoplay', 'pressbook-news' ),
						),
						'carousel'          => array(
							'default' => array(
								'source'     => '',
								'categories' => array(),
								'tags'       => array(),
								'count'      => 8,
								'order'      => 'desc',
								'orderby'    => 'rand',
							),
							'label'   => array(
								'source'     => esc_html__( 'Footer Carousel Posts Source', 'pressbook-news' ),
								'categories' => esc_html__( 'Categories', 'pressbook-news' ),
								'tags'       => esc_html__( 'Tags', 'pressbook-news' ),
								'count'      => esc_html__( 'Footer Carousel Posts Count', 'pressbook-news' ),
								'order'      => esc_html__( 'Footer Carousel Posts Order', 'pressbook-news' ),
								'orderby'    => esc_html__( 'Footer Carousel Posts Order By', 'pressbook-news' ),
							),
							'desc'    => array(
								'source'     => esc_html__( 'Default: All Posts', 'pressbook-news' ),
								'categories' => esc_html__( 'Select the categories for the carousel posts in the footer. You can select multiple categories by holding the CTRL key.', 'pressbook-news' ),
								'tags'       => esc_html__( 'Select the tags for the carousel posts in the footer. You can select multiple tags by holding the CTRL key.', 'pressbook-news' ),
								'count'      => esc_html__( 'Set the number of related posts. Default: 8', 'pressbook-news' ),
								'order'      => esc_html__( 'Designates the ascending or descending order. Default: Latest First', 'pressbook-news' ),
								'orderby'    => esc_html__( 'Sort retrieved related posts by parameter. Default: Random Order', 'pressbook-news' ),
							),
						),
						'carousel_perview'  => array(
							'default' => array(
								'xlg' => 4,
								'lg'  => 3,
								'md'  => 2,
								'sm'  => 1,
								'xs'  => 1,
							),
							'label'   => array(
								'xlg' => esc_html__( 'Footer Carousel Total Posts Per View (Extra Large Screen-Devices)', 'pressbook-news' ),
								'lg'  => esc_html__( 'Footer Carousel Total Posts Per View (Large Screen-Devices)', 'pressbook-news' ),
								'md'  => esc_html__( 'Footer Carousel Total Posts Per View (Medium Screen-Devices)', 'pressbook-news' ),
								'sm'  => esc_html__( 'Footer Carousel Total Posts Per View (Small Screen-Devices)', 'pressbook-news' ),
								'xs'  => esc_html__( 'Footer Carousel Total Posts Per View (Extra Small Screen-Devices)', 'pressbook-news' ),
							),
							'desc'    => array(
								'xlg' => esc_html__( 'Default: 4', 'pressbook-news' ),
								'lg'  => esc_html__( 'Default: 3', 'pressbook-news' ),
								'md'  => esc_html__( 'Default: 2', 'pressbook-news' ),
								'sm'  => esc_html__( 'Default: 1', 'pressbook-news' ),
								'xs'  => esc_html__( 'Default: 1', 'pressbook-news' ),
							),
						),
						'carousel_show'     => array(
							'default' => array(
								'in_front'   => true,
								'in_blog'    => true,
								'in_archive' => true,
								'in_post'    => true,
								'in_page'    => true,
							),
						),
					),
				),
			)
		);
	}
}
