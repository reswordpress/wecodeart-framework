<?php namespace WeCodeArt\Core;
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit();
// Use
use WeCodeArt\Utilities\Markup as Markup;
use WeCodeArt\Customizer as Customizer;
/**
 * WeCodeArt Framework.
 *
 * WARNING: This file is part of the core WeCodeArt Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package 	WeCodeArt Framework
 * @subpackage 	Footer Class
 * @copyright   Copyright (c) 2018, WeCodeArt Framework
 * @since 		v3.5
 * @version		v3.5
 */

class Footer {
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
		add_action( 'wecodeart_footer_markup', 		[ $this, 'footer_markup' ] );
		add_action( 'wecodeart/hook/footer/bottom', [ $this, 'attribution_markup' ], 99 );
		add_action( 'widgets_init', 				[ $this, 'register_sidebars' ] );
	}
	
	/**
	 * Output FOOTER markup function
	 * @since 	1.0
	 * @version	3.5
	 * @return 	HTML 
	 */
	public function footer_markup() {
		$footer_attr = Markup::generate_attr( 'footer', [
			'id' 		=> 'footer', 
			'itemscope' => 'itemscope',
			'itemtype' 	=> 'http://schema.org/WPFooter'
		] ); // Attrs are escaped by the functiona above
		?>
		<footer <?php echo $footer_attr; ?>>
			<?php 
				do_action( 'wecodeart/hook/footer/top' );		// Hook Top
		
				Footer::render_widgets();	
		
				do_action( 'wecodeart/hook/footer/bottom' );	// Hook Bottom
			?>
		</footer>
		<!-- /footer.footer -->
		<?php
	}

	/**
	 * Footer Attribution
	 * @return 	HTML
	 */
	public function attribution_markup() {
		$copyright = get_theme_mod( 'footer-copyright-text' );
		?>
		<div class="footer__attribution attribution">
			<div class="grid-container fluid">
				<div class="grid-x grid-padding-x grid-padding-y">
					<div class="cell text-center">
						<span class="attribution__copyright"><?php echo esc_html( $copyright ); ?></span>
						<span class="attribution__credits">
							<?php
								printf( 
									esc_html__( 'Built on %1$s.', 'wecodeart' ), 
									'<a href="https://www.wecodeart.com/" target="_blank">WeCodeArt Framework</a>' 
								);
							?>
						</span>
					</div>
				</div>
			</div>
		</div>
		<!-- /attribution -->
		<?php
	}

	/**
	 * Footer Widgetized Area
	 * @return 	HTML 
	 */
	public static function footer_widgets_one() {
		get_template_part( 'views/footer/widgets', 'one' );
	}

	/**
	 * Footer Widgetized Area
	 * @return 	HTML 
	 */
	public static function footer_widgets_two() {
		get_template_part( 'views/footer/widgets', 'two' );
	}

	/**
	 * Footer Widgetized Area
	 * @return 	HTML 
	 */
	public static function footer_widgets_three() {
		get_template_part( 'views/footer/widgets', 'three' );
	}

	/**
	 * Footer Widgetized Area
	 * @return 	HTML 
	 */
	public static function footer_widgets_four() {
		get_template_part( 'views/footer/widgets', 'four' );
	}

	/**
	 * This function holds our footer widgets
	 * @since	v1.5
	 * @version v3.5
	 * @return 	array
	 */
	public static function footer_widgets() {
		$defaults = array();
		$defaults['footer-1'] = array(
			'label'    => __( 'Footer One', 'wecodeart' ),
			'callback' => [ __CLASS__, 'footer_widgets_one' ]
		);
		$defaults['footer-2'] = array(
			'label'    => __( 'Footer Two', 'wecodeart' ),
			'callback' => [ __CLASS__, 'footer_widgets_two' ]
		);
		$defaults['footer-3'] = array(
			'label'    => __( 'Footer Three', 'wecodeart' ),
			'callback' => [ __CLASS__, 'footer_widgets_three' ]
		);
		$defaults['footer-4'] = array(
			'label'    => __( 'Footer Four', 'wecodeart' ),
			'callback' => [ __CLASS__, 'footer_widgets_four' ]
		);
		
		// New Modules
		$widgets = apply_filters( 'wecodeart/filter/footer/widgets', $defaults );

		return $widgets;
	}

	/**
	 * Return the Footer final widgets HTML with modules selected by user
	 * @since	v3.5
	 * @version v3.5
 	 * @uses	WeCodeArt\Utilities\Layout::wrap()
	 * @return 	string HTML
	 */
	public static function render_widgets() {
		$wrappers = array(
			[
				'tag' => 'div',
				'attrs' => [
					'class' => 'footer__widgets'
				]
			],
			[
				'tag' => 'div',
				'attrs' => [
					'class' => get_theme_mod( 'footer-layout-container' )
				]
			],
			[
				'tag' => 'div',
				'attrs' => [
					'class' => 'grid-x grid-padding-x grid-padding-y'
				]
			]
		);

		Markup::wrap( 'footer-widgets-wrappers', $wrappers, [ __CLASS__, 'sort_widgets' ] ); 
	}

	/**
	 * Return the Inner final HTML with modules selected by user for each page.
	 * @since 	3.5
	 * @version	3.5
	 * @uses	WeCodeArt\Utilities\Layout::sortable()
	 * @return 	HTML
	 */
	public static function sort_widgets() {
		Markup::sortable( 
			self::footer_widgets(),
			get_theme_mod( 'footer-layout-modules' )
		);
	}

	/**
	 * Register Sidebars Based on Active Options
	 * @since	unknown
	 * @version	v3.5
	 * @return 	void
	 */
	public function register_sidebars() {
		// Get theme mod
		$options = get_theme_mod( 'footer-layout-modules', Customizer::get_defaults( 'footer-layout-modules' ) );

		// Get Default Footer Columns
		$columns = self::footer_widgets();
		$active = array();
		foreach( $options as $option ) if( array_key_exists( $option, $columns ) ) $active[] = $option;
		if( ! $active ) return;

		// Register Sidebar for each active footer columns
		foreach( $active as $sidebar ) {
			if( isset( $columns[$sidebar]['not_a_sidebar'] ) && $columns[$sidebar]['not_a_sidebar'] === true ) continue;
			register_sidebar(
				array(
					'name'          => $columns[$sidebar]['label'], // Translatable string defined in the function from the variable
					'id'            => $sidebar,
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				)
			);
		}
	}
}