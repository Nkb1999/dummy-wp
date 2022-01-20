<?php
/**
 * Template part for displaying the top banner section.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PressBook
 */

$pressbook_top_banner = PressBook\Options\TopBanner::get_top_banner();

if ( '' === wp_get_attachment_image( $pressbook_top_banner['image'] ) ) {
	return;
}

$pressbook_top_banner_has_link = ( '' !== $pressbook_top_banner['link_url'] );
?>

<div class="<?php echo esc_attr( PressBook\Options\TopBanner::top_banner_class( $pressbook_top_banner ) ); ?>">
	<?php
	if ( $pressbook_top_banner_has_link ) {
		echo '<a class="top-banner-link"';
		if ( $pressbook_top_banner['link_new_tab'] ) {
			echo ' target="_blank"';
		}
		if ( '' !== $pressbook_top_banner['link_title'] ) {
			echo ( ' title="' . esc_attr( $pressbook_top_banner['link_title'] ) . '"' );
		}
		if ( '' !== $pressbook_top_banner['link_rel'] ) {
			echo ( ' rel="' . esc_attr( $pressbook_top_banner['link_rel'] ) . '"' );
		}

		echo ( ' href="' . esc_url( $pressbook_top_banner['link_url'] ) . '">' );
	}

	echo wp_get_attachment_image( $pressbook_top_banner['image'], 'full', false, array( 'class' => 'top-banner-image' ) );

	if ( $pressbook_top_banner_has_link ) {
		echo '</a>';
	}
	?>
</div><!-- .top-banner -->
