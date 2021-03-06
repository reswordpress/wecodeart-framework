<?php namespace WeCodeArt\Utilities\Markup;
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit();
// Use
use WeCodeArt\Utilities\Markup;
/**
 * WeCodeArt Framework.
 *
 * WARNING: This file is part of the core WeCodeArt Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package 	WeCodeArt Framework
 * @subpackage  SVG Markup Functions
 * @copyright   Copyright (c) 2019, WeCodeArt Framework
 * @since		v3.5
 * @version		v3.5.0.3
 */

class SVG {
	/**
	 * Instance
	 *
	 * @var $_instance
	 */
	private static $_instance = NULL;
	
	/**
	 * Initiator
	 *
	 * @since 	v3.3
	 * @return 	object
	 */
	public static function get_instance() {
		if( self::$_instance == NULL ) self::$_instance = new self;
		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Render an SVG Icon.
	 * @param	string	Icon Name
	 * @param 	array 	Args
	 * @param 	string	Fallback 
	 */
	public static function render( string $icon, $args = [], $fallback = '', $sprite = '' ) {
		echo self::compile( $icon, $args, $fallback, $sprite );
	}

	/**
	 * Compile an SVG Icon from sprite
	 * @param	string	Icon Name
	 * @param 	array 	Args
	 * @param 	string	Fallback 
	 */
	public static function compile( string $icon, $args = [], $fallback = '', $sprite = '' ) {
		// Make sure $args are an array.
		if ( empty( $icon ) ) return __( 'Please define an SVG icon filename!', 'wecodeart' );
		if ( empty( $sprite ) ) $sprite = get_template_directory_uri() . '/assets/images/sprite.svg';
		// Set defaults.
		$defaults = array(
			'title'    => '',
			'desc'     => '',
		);
	
		// Parse args.
		$args = wp_parse_args( $args, $defaults );
	
		// Generate Attrs
		$attrs = [
			'class' 		=> 'svg svg-' .  $icon . '',
			'aria-hidden' 	=> 'true',
			'role' 			=> 'img'
		];

		if( $args['title'] ) {
			unset( $attrs['aria-hidden'] );
			$unique_id = uniqid();
			$attrs['aria-labelledby'] = 'title-' . $unique_id . '';
			if ( $args['desc'] ) {
				$attrs['aria-labelledby'] = 'title-' . $unique_id . ' desc-' . $unique_id . '';
			}
		}

		$attributes = Markup::generate_attr( $icon, $attrs );

		// Begin SVG markup.
		$svg = '<svg ' . $attributes . '>';
		// Display the title.
		if ( $args['title'] ) {
			$svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';
			// Display the desc only if the title is already set.
			if ( $args['desc'] ) $svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
		}
		/**
		 * Display the icon.
		 * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
		 * See https://core.trac.wordpress.org/ticket/38387.
		 */
		$icon = $sprite . '#' . esc_html( $icon );
		$svg .= ' <use href="' . $icon . '" xlink:href="' . $icon . '"></use> ';
		// Add some markup to use as a fallback for browsers that do not support SVGs.
		if( $fallback ) $svg .= '<span class="svg-fallback icon-' . esc_attr( $fallback ) . '"></span>';
		$svg .= '</svg>';
	
		return $svg;
	}
}