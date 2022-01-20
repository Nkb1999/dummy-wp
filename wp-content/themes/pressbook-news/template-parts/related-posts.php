<?php
/**
 * The template for displaying related posts carousel.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PressBook_News
 */

$pressbook_related_posts = PressBook_News_Related_Posts::options();
if ( ! $pressbook_related_posts ) {
	return;
}

$pressbook_query = $pressbook_related_posts['query'];
if ( ! $pressbook_query->have_posts() ) {
	return;
}
?>

<div class="pb-related-posts">
	<h2 class="pb-related-posts-title"><?php echo esc_html( $pressbook_related_posts['options']['title'] ); ?></h2>

	<div class="glide carousel-posts carousel-related-posts">
		<div class="glide__track" data-glide-el="track">
			<ul class="glide__slides">
			<?php
			while ( $pressbook_query->have_posts() ) {
				$pressbook_query->the_post();
				$pressbook_categories = get_the_category( get_the_ID() );
				?>
				<li class="<?php echo esc_attr( PressBook_News_Carousel::carousel_slide_class() ); ?>">
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
