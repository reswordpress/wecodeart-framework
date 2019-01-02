<?php namespace WeCodeArt\Customizer\Configs;
// No direct access, please.
if ( ! defined( 'ABSPATH' ) ) exit;
// Use
use WeCodeArt\Customizer\Config as Config;
use WeCodeArt\Customizer\Formatting as Formatting;

/**
 * WeCodeArt Framework.
 *
 * WARNING: This file is part of the core WeCodeArt Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package 	WeCodeArt Framework
 * @subpackage 	WP-Customizer Config
 * @since 		v3.5
 * @version		v3.5
 */

/**
 * Customizer Config Footer setup
 */
class Footer extends Config {
	/**
	 * Register Site Layout Customizer Configurations.
	 * @param 	Array                $configurations 
	 * @param 	WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
	 * @since 	3.5
	 * @return 	Array 
	 */
	public function register( $configurations, $wp_customize ) {
		// A handy class for formatting theme mods.
		$formatting = Formatting::get_instance();

		// Header Modules Choices
		$widgets = array();
		$modules = \WeCodeArt\Core\Footer::footer_widgets();
		foreach( $modules as $k => $v ) $widgets[$k] = $v['label']; 

		$_configs = array( 
			array(
				'name'			=> 'footer-layout-container',
				'type' 			=> 'control',
				'control'  		=> 'select',
				'section'		=> 'footer-layout',
				'title' 		=> __( 'Grid Type', 'wecodeart' ),
				'description' 	=> __( 'Choose the width of .grid-container class.', 'wecodeart' ),
				'choices'  		=> array(
					'grid-container' 		=> __( 'Grid', 'wecodeart' ),
					'grid-container fluid' 	=> __( 'Fluid Grid', 'wecodeart' ),
				), 
				'priority' 		=> 5, 
				'sanitize_callback'    => [ $formatting, 'sanitize_choices' ], 
				'transport' 		   => 'postMessage'
			),
			array(
				'name'			=> 'footer-layout-modules',
				'type'        	=> 'control',
				'control'  		=> 'wecodeart-sortable',
				'section'		=> 'footer-layout',
				'title'			=> __( 'Footer Columns', 'wecodeart' ),
				'description'	=> __( 'Enable and reorder Footer Columns.', 'wecodeart' ),
				'priority'   	=> 10, 
				'choices'		=> $widgets,
				'transport'		=> 'postMessage',
				'partial'		=> [
					'selector'        => '.footer__widgets',
					'render_callback' => [ 'WeCodeArt\Core\Footer', 'render_widgets' ],
					'container_inclusive' => true
				]
			),
			array(
				'name'			=> 'footer-copyright-text',
				'type'        	=> 'control',
				'control'  		=> 'textarea',
				'section'		=> 'footer-copyright',
				'title'			=> __( 'Footer Copyright Text', 'wecodeart' ),
				'description'	=> __( 'Enter your copyright text here. Appears in Footer attribution.', 'wecodeart' ),
				'priority'		=> 5,
				'sanitize_callback'	=> 'sanitize_text_field', 
				'transport'		=> 'postMessage',
				'partial'		=> [
					'selector'        => '.attribution__copyright',
					'render_callback' => [ 'WeCodeArt\Customizer\Partials', '_render_footer_copyright' ]
				]	
			)
		);

		return array_merge( $configurations, $_configs );
	}
}