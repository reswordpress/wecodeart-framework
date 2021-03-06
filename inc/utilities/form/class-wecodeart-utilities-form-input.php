<?php namespace WeCodeArt\Utilities\Form;
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit(); 
/**
 * WeCodeArt Framework
 *
 * WARNING: This file is part of the core WeCodeArt Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package 	WeCodeArt Framework 
 * @subpackage 	Utilities\Form\Inputs
 * @copyright   Copyright (c) 2019, WeCodeArt Framework
 * @since		v3.1.2
 * @version 	v3.6
 */
class Input {	
	/*
	 * Constructor 
	 */
	public function __construct( ) { }
	
	/**
	 * Render the HTML of the input
	 * @access 	public
	 * @param 	string 		$type		text/number/etc
	 * @param 	string 		$label		Label Text
	 * @param 	array 		$attrs		Input Attributes (id, name, value, etc)
	 * @return	function	input		Returns the HTML
	 */
	public static function render( $type = 'hidden', $label, $attrs = array(), $choices = array() ) {
		return self::input( $type, $label, $attrs, $choices );
	}
	
	/**
	 * Get the HTML of the input
	 * @access 	public
	 * @param 	string 		$type		text/number/etc
	 * @param 	array 		$args		$this->defaults/args
	 * @return	function	input		Renders the HTML
	 */
	public static function compile( $type = 'hidden', $label, $attrs = array(), $choices = array() ) {
		ob_start();
		self::input( $type, $label, $attrs, $choices );
		return ob_get_clean();
	}
	
	/**
	 * Create HTML Inputs
	 * @param  	array     	$array() 	Existing option array if exists (optional)
	 * @return 	array 		$array 		Array of options, all standard DOM input options
	 */
	protected static function input( $type, $label, $attrs, $choices ) {		
		// Will hold Input Attributes
		$attributes = array();
		
		// Create HTML for Input Attributes
		foreach( $attrs as $name => $val ) {
			$attributes[$name] = isset( $val ) ? sanitize_title_with_dashes( $name ) . '="' . esc_attr( $val ) . '"' : NULL;
		}
		
		// Switch our input type
		switch( $type ) {			
			/**
			 * Text/Number/Email/URL/Password/Range/Submit share same HTML
			 */
			case 'text' : case 'number' : case 'email' : case 'password' : case 'url' : case 'checkbox' : case 'range' : case 'submit' :   ?>
				<?php if ( isset( $label ) ) echo '<label>' . esc_html( $label ); ?>
					<input type="<?php echo esc_attr( $type ) ?>" <?php echo implode ( ' ', $attributes ); ?>/>
				<?php if ( isset( $label ) ) echo '</label>'; ?>
			<?php break; 
			
			/**
			 * Textarea
			 */
			case 'textarea' : ?>				
				<?php if ( isset( $label ) ) echo '<label>' . esc_html( $label ); ?>
					<textarea <?php echo implode ( ' ', $attributes ); ?>></textarea>
				<?php if ( isset( $label ) ) echo '</label>'; ?>
			<?php break;
			
			/**
			 * Radio Buttons
			 */
			case 'radio' : ?>
				<fieldset class="fieldset radio">
				<?php if ( isset( $label ) ) echo '<legend>' . esc_html( $label ) . '</legend>'; ?>
					<?php foreach ( (array) $choices as $value => $label ) { ?>
						<input 	
							type="radio" 
							name="<?php echo esc_attr( $attrs['name'] ) ?>" 
							value="<?php echo esc_attr( $value ); ?>" <?php if( isset( $attrs['value'] ) ) checked( $attrs['value'] , $value, true ); ?> 
							id="<?php echo esc_attr( $value ) ?>"/>
						<label for="<?php echo esc_attr( $value ) ?>"><?php echo esc_html( $label ) ?></label>
					<?php } // End Foreach ?>
				</fieldset> 
			<?php break;
			
			/**
			 * Select Input
			 */
			case 'select' : ?>
				<?php if ( isset( $label ) ) echo '<label>' . esc_html( $label ); ?>
				<select <?php unset( $attributes['placeholder'] ); echo implode ( ' ' , $attributes ); ?>>
					<?php if( isset( $attrs['placeholder'] ) ) { ?>
						<option value=''><?php echo esc_attr( $attrs['placeholder'] ); ?></option>
					<?php } // if isset = placeholder ?>
					<?php foreach( $choices as $value => $label ) { ?>
						<option value="<?php echo esc_attr( $value ); ?>" <?php if( isset( $attrs['value'] ) ) selected( $attrs['value'] , $value, true ); ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php } // End Foreach ?>
				</select>
				<?php if ( isset( $label ) ) echo '</label>'; ?>
			<?php break;

			/**
			 * Default/Other Value goes to hidden field
			 */
			default : ?>
				<input type="hidden" <?php echo implode ( ' ', $attributes ); ?>/>
			<?php
		}
	}
}