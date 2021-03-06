<?php
    use WeCodeArt\Utilities\Markup;
    /**
     * WeCodeArt Framework.
     *
     * WARNING: This file is part of the core WeCodeArt Framework. DO NOT edit this file under any circumstances.
     * Please do all modifications in the form of a child theme.
     *
     * @package 	WeCodeArt Framework
     * @subpackage 	Header
     * @since 		v1.0
     * @version		v3.5
     */
?>	
<!DOCTYPE html>
<html class="no-js" <?php language_attributes( 'html' ); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php wp_head(); // WP Head ?>
    </head>	
    <body <?php echo Markup::generate_attr( 'body', [ 'class' => implode( ' ', get_body_class() ) ] ); ?>>
    <?php
        do_action( 'wecodeart/hook/header/before' 	);	// Hook Before Header
        do_action( 'wecodeart_header_markup' 		);	// WeCodeArt Header
        do_action( 'wecodeart/hook/header/after' 	);	// Hook After Header

        do_action( 'wecodeart/hook/inner/before' ); 	// Hook Inner Before
        echo '<div id="content" class="content">';
        do_action( 'wecodeart/hook/inner/top' );		// Hook Inner Top
    ?>
        