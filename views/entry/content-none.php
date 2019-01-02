<?php if ( ! defined( 'ABSPATH' ) ) exit(); // Exit if accessed directly
/**
 * WeCodeArt Framework.
 *
 * WARNING: This file is part of the core WeCodeArt Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package 	WeCodeArt Framework
 * @subpackage 	No Posts Template
 * @since 		v3.0.4
 * @version		v3.5
 */
$message = apply_filters( 'wecodeart/filter/noposts-message', __( 'There are no posts matching your criteria.', 'wecodeart' ) );
?>
<p><?php echo $message; ?></p>