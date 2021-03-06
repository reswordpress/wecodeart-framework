<?php namespace WeCodeArt\Utilities;
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit();
/**
 * WeCodeArt Framework.
 *
 * WARNING: This file is part of the core WeCodeArt Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package 	WeCodeArt Framework
 * @subpackage  Helper Functions
 * @copyright   Copyright (c) 2019, WeCodeArt Framework
 * @since		v3.5
 * @version		v3.5
 */

class Helpers {
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
	 * Helper function to encode an array to an excaped json string
	 * Useful to use it for placing encoded object in html attrs
	 * @since	3.5
	 * @param 	array $json
	 * @return 	string 
	 */
	public static function toJSON( $json = array() ) {
		if( ! is_array( $json ) ) return null;
		$json = str_replace( '"', "'", json_encode( $json ) );
		return htmlspecialchars( $json, ENT_QUOTES, 'UTF-8' );
	}

	/**
	 * Detect active plugin by constant, class or function existence.
	 * @since 3.5
	 * @param 	array 	$plugins Array of array for constants, classes and / or functions to check for plugin existence.
	 * @return 	bool 	True if plugin exists or false if plugin constant, class or function not detected.
	 */
	public static function detectplugin( array $plugins ) {
		// Check for classes.
		if ( isset( $plugins['classes'] ) ) foreach ( $plugins['classes'] as $name ) if ( class_exists( $name ) ) return true;

		// Check for functions.
		if ( isset( $plugins['functions'] ) ) foreach ( $plugins['functions'] as $name ) if ( function_exists( $name ) ) return true;

		// Check for constants.
		if ( isset( $plugins['constants'] ) ) foreach ( $plugins['constants'] as $name ) if ( defined( $name ) ) return true;

		// No class, function or constant found to exist.
		return false;
	}
}