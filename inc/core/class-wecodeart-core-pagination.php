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
 * @subpackage 	Pagination Class
 * @copyright   Copyright (c) 2019, WeCodeArt Framework
 * @since 		v3.5
 * @version		v3.6
 */

class Pagination {
	/**
	 * Instance
	 *
	 * @var $_instance
	 */
	private static $_instance = NULL;

	/**
	 * Initiator
	 *
	 * @since 	v3.5
	 * @return 	object
	 */
	public static function get_instance() {
		if( self::$_instance == NULL ) self::$_instance = new self;
		return self::$_instance;
	}

	/**
	 * Class Constructor.
	 */
	public function __construct() {
        add_action( 'wecodeart/hook/main/after',    [ $this, 'numeric_posts_nav' ], 10 );
        add_action( 'wecodeart_entry_footer',       [ $this, 'post_content_nav' ],  10 );
        add_action( 'wecodeart_entry_footer',       [ $this, 'prev_next_post_nav' ], 90 );
	}
	
	/**
	 * Display links to previous and next post, from a single post.
	 * @since	v1.0
	 * @version	v3.6
    * @return null Return early if not a post.
	 */
	public function prev_next_post_nav() {
        // Return only on Single Post
        if ( ! is_singular( 'post' ) ) return;	
        // Set the defaults
        $prev = '<span class="screen-reader-text">' . __( 'Previous Post', 'wecodeart' ) . '</span>';
        $next = '<span class="screen-reader-text">' . __( 'Next Post', 'wecodeart' ) . '</span>';
        $schema = '<span itemprop="name">%title</span>';
        // The HTML
        ?>
        <nav id="entry-prev-next" class="entry-prev-next"
            itemscope="" itemtype="http://schema.org/SiteNavigationElement">
            <h3 class="screen-reader-text"><?php _e( 'Post Navigation', 'wecodeart' ) ?></h3>
            <div class="row pt-3">
            <?php
                previous_post_link(
                    '<div class="col col-sm-12 col-md">' . $prev . '%link</div>', 
                    '&#x000AB; '. $schema 
                );
                next_post_link(
                    '<div class="col col-sm-12 col-md text-md-right">' . $next . '%link</div>',  
                    $schema .' &#x000BB;'
                );
            ?>
            </div>
        </nav>
    <?php
    }

	/**
     * Display links to previous and next post, from a single post.
     * @since	v1.0
     * @version v3.6
     * @return  string HTML
     */
    public function numeric_posts_nav() {
        $args = array( 
            'mixed' => 'array',
            'type' 	=> 'array',
        );
        
        $links = paginate_links( $args );
        
        if ( empty( $links ) || is_singular() ) return; 	
        
        ?>	
        <nav itemscope="" itemtype="http://schema.org/SiteNavigationElement">
            <ul class="pagination" role="navigation" aria-label="<?php esc_attr_e( 'Pagination', 'wecodeart' ); ?>">
                <?php foreach( $links as $key => $link ) { 
                        $class = [ 'page-item', 'pagination__item' ];
                        $class[] = ( strpos( $link, 'current' ) !== false ) ? 'pagination__item--current' : NULL;
                        $class[] = ( strpos( $link, 'current' ) !== false ) ? 'active' : NULL;
                    ?>
                    <li class="<?php echo esc_attr( trim( implode( ' ', $class ) ) ); ?> ">
                        <?php echo str_replace( 'page-numbers', 'page-link', $link ); ?>
                    </li> 				
                <?php } ?>
            </ul>
        </nav>
        <?php
    }

    /**
     * WP-Link Pages for paginated posts
     * @since	unknown
     * @version v3.6.0
     * @return 	null 	Return early if not a post.
     */
    public function post_content_nav() {
        // Return only on Single Post
        if ( ! is_singular( 'post' ) ) return;	
        
        $label = '<span class="entry-pages__title label">' . __( 'Pages:', 'wecodeart' ) . '</span>';
        wp_link_pages( array(
            'before'      => '<nav class="entry-pages pagination" itemscope="" itemtype="http://schema.org/SiteNavigationElement">' . $label,
            'after'       => '</nav>',
            'link_before' => '<span class="page-link">',
            'link_after'  => '</span>',
        ) );
    }
}