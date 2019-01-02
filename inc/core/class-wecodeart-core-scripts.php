<?php namespace WeCodeArt\Core;
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit(); 
/**
 * WeCodeArt Framework.
 *
 * WARNING: This file is part of the core WeCodeArt Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package 	WeCodeArt Framework
 * @subpackage 	Front-End Scripts
 * @copyright   Copyright (c) 2018, WeCodeArt Framework
 * @since 		v1.9
 * @version		v3.5
 */ 

class Scripts {
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

	public function __construct() {
		// All starts here
		add_action( 'wp_enqueue_scripts', 	array( $this, 'front_scripts'  		) );
		add_action( 'wp_enqueue_scripts', 	array( $this, 'localize_js'	 		), 90 );
		add_action( 'wp_default_scripts', 	array( $this, 'jquery_to_footer'	) );
	}

	/**
	 * WeCodeArt JS Object
	 * @since	v3.2
	 * @version v3.5.0.2
	 */
	public function localize_js() {
		global $wp_scripts;

		$wecodeart = apply_filters( 'wecodeart/filter/scripts/localize_js', [
			'assetsEnqueue' 	=> wp_json_encode( $wp_scripts->queue ),
			'functionsQueue' 	=> [],
			'templateDirectory' => get_template_directory_uri()
		] );
		if( is_child_theme() ) $wecodeart['childDirectory'] = get_stylesheet_directory_uri();
		wp_localize_script( 'wecodeart-core', 'wecodeart', $wecodeart );
	}

	/**
	 * jQuery to Footer
	 * @since	v3.1.2
	 * @version v3.5
	 */
	public function jquery_to_footer( $wp_scripts ) {
		if ( ! is_admin() && apply_filters( 'wecodeart/filter/scripts/jquery-in-footer', false ) ) {
			$wp_scripts->add_data( 'jquery', 			'group', 1 );
			$wp_scripts->add_data( 'jquery-core', 		'group', 1 );
			$wp_scripts->add_data( 'jquery-migrate', 	'group', 1 );
		}
	}

	/**
	 * Enqueue Front-End Styles
	 * @since	v1.0
	 * @version v3.5
	 */
	public function front_scripts() {
		// Enqueue Styles
		wp_enqueue_style( 'wecodeart-core',	get_parent_theme_file_uri( '/assets/css/style.css' ), [], '3.5' );

		// Enqueue scripts
		wp_enqueue_script( 'wecodeart-core', 		get_parent_theme_file_uri( '/assets/js/bundle.js' ), 			array( 'jquery' ), '3.5', true );		
		wp_enqueue_script( 'wecodeart-foundation', 	get_parent_theme_file_uri( '/assets/js/foundation.min.js' ), 	array( 'jquery' ), '6.5.1', true );
		if ( 
			( is_page() && comments_open() && get_option( 'thread_comments' ) ) || 
			( is_single() && comments_open() && get_option( 'thread_comments' ) ) 
		) wp_enqueue_script( 'comment-reply' );
	}
}