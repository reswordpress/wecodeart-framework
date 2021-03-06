<?php namespace WeCodeArt\Utilities;
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit(); 
/**
 * WeCodeArt Framework.
 *
 * WARNING: This file is part of the core WeCodeArt Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package 	WeCodeArt Framework.
 * @subpackage  Utilities\Schema
 * @copyright   Copyright (c) 2019, WeCodeArt Framework
 * @since		v3.1.2
 * @version		v3.2
 */

new Schema();
class Schema {
    private static $structured_data;
    /**
     * Setup class.
     *
     * @since 1.0
     */
    public function __construct() {
        add_action( 'wp_footer', array( $this, 'get_structured_data' ) );
    }

    /**
     * Sets `self::structured_data`.
     *
     * @param array $json
     */
    public static function set_structured_data( $json ) {
        if( ! is_array( $json ) ) return;
        self::$structured_data[] = $json;
    }

    /**
     * Outputs structured data.
     *
     * Hooked into `wp_footer` action hook.
     */
    public function get_structured_data() {
        if( ! self::$structured_data ) return;

        $structured_data['@context'] = 'http://schema.org/';

        if( count( self::$structured_data ) > 1 ) $structured_data['@graph'] = self::$structured_data;
        else $structured_data = $structured_data + self::$structured_data[0];

        printf( 
            '<script type="application/ld+json">%s</script><!-- /structured-data -->', 
            wp_json_encode( $this->sanitize_structured_data( $structured_data ) ) 
        );
    }

    /**
     * Sanitizes structured data.
     *
     * @param  array $data
     * @return array
     */
    public function sanitize_structured_data( $data ) {
        $sanitized = array();
        foreach ( $data as $key => $value ) {
            if( is_array( $value ) ) $sanitized_value = $this->sanitize_structured_data( $value );
            else $sanitized_value = sanitize_text_field( $value );
            $sanitized[ sanitize_text_field( $key ) ] = $sanitized_value;
        }
        return $sanitized;
    }
}