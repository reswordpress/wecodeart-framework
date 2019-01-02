<?php if ( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly
// Use
use WeCodeArt\Utilities\Markup\SVG;
/**
 * WeCodeArt Framework.
 *
 * WARNING: This file is part of the core WeCodeArt Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package 	WeCodeArt Framework
 * @subpackage 	Author Box HTML
 * @since 		v3.0.3
 * @version		v3.5
 */
	$author = array();
	$author['intro'] 	= is_author() ? __( 'All articles by', 'wecodeart' ) : __( 'About', 'wecodeart' );
	$author['name']		= get_the_author();
	$author['avatar']	= get_avatar( get_the_author_meta( 'email' ), apply_filters( 'wecodeart/filter/author_box/gravatar', 100 ), '', $author['name'] . "'s gravatar" );
	$author['desc'] 	= wpautop( get_the_author_meta( 'description' ) );
	$author['url']		= get_author_posts_url( get_the_author_meta( 'ID' ) );
	if ( is_singular() )
		$author['name']	= sprintf( '<a href="%s" rel="author">%s</a>', esc_url( $author['url'] ), esc_html( $author['name'] ) );
	// Retur early if no name or desc
	if ( 0 === mb_strlen( $author['name'] ) || 0 === mb_strlen( $author['desc'] ) ) return;

	$wrapper = [ get_theme_mod( 'content-general-layout', 'grid-container' ) ];
	$wrapper[] = ( ! is_author() ) ? 'full' : NULL;
?>
<div id="author-box" class="author-box">
	<div class="<?php echo esc_attr( trim( implode( ' ', $wrapper ) ) ); ?>">
		<div class="grid-x grid-padding-x">
			<div class="author-box__name cell small-12">
				<h3 class="author-box__headline">
					<?php SVG::render( 'icon--user' ); ?>	
					<span><?php echo implode( ' ', [ $author['intro'], $author['name'] ] ); ?></span>
				</h3>
			</div>
			<div class="author-box__gravatar cell small-12 medium-shrink text-center medium-text-left"><?php
				echo $author['avatar'];
			?></div>
			<div class="author-box__description cell auto">
				<?php echo wpautop( get_the_author_meta( 'description' ) ); ?>
				<a class="author-box__website button small hollow float-right"
					href="<?php echo esc_url( get_the_author_meta( 'url' ) ); ?>" target="_blank" rel="nofollow">
					<?php SVG::render( 'icon--globe' ); ?>
					<span><?php esc_html_e( 'Website', 'wecodeart' ); ?></span>
				</a>
			</div>
		</div>
	</div>
</div>
<!-- /author-box -->