<?php
if ( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly.
/**
 * WeCodeArt Framework.
 *
 * WARNING: This file is part of the core WeCodeArt Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package 	WeCodeArt Framework
 * @subpackage  Header Bar Menu HTML
 * @since	 	v3.0.3
 * @version    	v3.6
 */
?>

<div id="bar-menu" class="header-bar__menu col-12 col-lg">
	<nav itemscope="" itemtype="http://schema.org/SiteNavigationElement">
	<?php 
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container' 	 => false, 
			'menu_class' 	 => 'menu nav justify-content-end', 
			'depth' 		 => 10, 
			'items_wrap'	 => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'walker' 		 => new WeCodeArt\Walkers\Menu 
		) );
	?>
	</nav>
</div>
<!-- /bar-menu -->