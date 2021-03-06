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
 * @subpackage 	WP-Customizer Partials
 * @copyright   Copyright (c) 2019, WeCodeArt Framework
 * @since 		v3.3
 * @version		v3.5
 */

/**
 * Customizer Partials initial setup
 */
class Partials {

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
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'register' ), 950 );
	}

	/**
	 * Add our Selective Refresh Partials.
	 * 
	 * @param  object $wp_customize An instance of the WP_Customize_Manager class.
	 */
	public function register( $wp_customize ) {
		// Override Defaults.
		$wp_customize->get_setting( 'blogname' 			)->transport	= 'postMessage';
		$wp_customize->get_setting( 'blogdescription' 	)->transport	= 'postMessage';
		$wp_customize->get_section( 'title_tagline' 	)->panel		= 'header';

		// Selective Refresh
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => array( $this, '_render_blogname' ),
		) );

		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => array( $this, '_render_blogdescription' ),
		) ); 
	}
		
	/**
	 * Render Partial Blog Name
	 */
	public static function _render_blogname() {
		return get_bloginfo( 'name', 'display' );
	}

	/**
	 * Render Partial Blog Description
	 */
	public static function _render_blogdescription() {
		return get_bloginfo( 'description', 'display' );
	}

	/**
	 * Render the Footer Copyright for the selective refresh partial.
	 */
	public static function _render_footer_copyright() {
		return wp_kses_post( get_theme_mod( 'footer-copyright-text' ) );
	}
}