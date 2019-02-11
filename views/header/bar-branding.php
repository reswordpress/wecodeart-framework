<?php if ( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly.
// Use
use WeCodeArt\Utilities\Markup\SVG;
/**
 * WeCodeArt Framework.
 *
 * WARNING: This file is part of the core WeCodeArt Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package 	WeCodeArt Framework
 * @subpackage  Header Branding HTML
 * @since	 	v3.0.5
 * @version    	v3.6
 */
?>
<div id="bar-branding" class="header-bar__branding col col-lg-auto">
	<div class="row no-gutters align-items-center">
		<div class="col">	
			<?php 
				if ( has_custom_logo() ) the_custom_logo();
				if ( is_front_page() ) : ?>	
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>		
				<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php 
				endif; 						
				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; ?></p>
			<?php 
				endif; 
			?>
		</div>
		<?php 
			$mod = get_theme_mod( 'header-bar-modules' );
			if ( in_array( 'search', $mod ) ) {
			// Display a search toggle on small devices ?>
				<div class="col-auto d-lg-none">
					<button class="btn btn-md" type="button" data-toggle="collapse" data-target=".header-bar__search" aria-expanded="false" aria-controls="bar-search">
						<span class="screen-reader-text"><?php _e( 'Search', 'wecodeart' ); ?></span>
						<?php SVG::render( 'icon--search' ); ?>
					</button>
				</div>
			<?php }
			if ( in_array( 'menu', $mod ) ) { 
			// Display a menu toggle on small devices ?>
				<div class="col-auto d-lg-none">
					<button class="btn btn-md" type="button" data-toggle="collapse" data-target=".header-bar__menu" aria-expanded="false" aria-controls="bar-menu">
						<span class="screen-reader-text"><?php _e( 'Primary Menu', 'wecodeart' ); ?></span>
						<?php SVG::render( 'icon--bars' ); ?>
					</button>
				</div>
			<?php }
		?>
	</div>
</div>
<!-- /bar-branding -->