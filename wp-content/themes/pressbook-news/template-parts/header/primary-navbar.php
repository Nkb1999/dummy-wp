<?php
/**
 * Template part for displaying the primary navbar section.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PressBook_News
 */

if ( has_nav_menu( 'menu-1' ) ) {
	?>
	<div class="<?php echo esc_attr( PressBook_News_PrimaryNavbar::primary_navbar_class() ); ?>">
		<div class="u-wrapper primary-navbar-wrap">
			<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'pressbook-news' ); ?>">
				<button class="primary-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<?php
					PressBook\IconsHelper::the_theme_svg( 'menu' );
					PressBook\IconsHelper::the_theme_svg( 'close' );
					?>
				</button>
				<?php PressBook\Menu::primary_menu(); ?>
			</nav><!-- #site-navigation -->
		</div><!-- .primary-navbar-wrap -->
	</div><!-- .primary-navbar -->
	<?php
}
