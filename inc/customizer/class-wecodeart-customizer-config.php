<?php namespace WeCodeArt\Customizer;
// No direct access, please.
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * WeCodeArt Framework.
 *
 * WARNING: This file is part of the core WeCodeArt Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package 	WeCodeArt Framework
 * @subpackage 	WP-Customizer Config
 * @copyright   Copyright (c) 2019, WeCodeArt Framework
 * @since 		v3.5
 * @version		v3.6
 */

/**
 * Customizer Config initial setup
 */
abstract class Config {
	/**
	 * Instance
	 *
	 * @access 	private
	 * @var 	object
	 */
	private static $instance;

	/**
	 * Initiator
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) self::$instance = new self; 
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'wecodeart/filter/customizer/configurations', array( $this, 'register' ), 30, 2 );
	}

	/**
	 * Base Method for Registering Customizer Configurations.
	 * @param 	Array                $configurations 
	 * @param 	WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
	 * @since 	3.5
	 * @version 3.6 
	 */
	public abstract function register( array $configurations, $wp_customize );
}