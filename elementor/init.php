<?php
 
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Plugin class.
 *
 * The main class that initiates and runs the addon.
 *
 * @since 1.0.1
 */
class NEZA_Elementor
{

	/**
	 * Instance
	 *
	 * @since 1.0.1
	 * @access private
	 * @static
	 * @var The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.1
	 * @access public
	 * @static
	 * @return \Ele_Genesis\Features An instance of the class.
	 */
	public static function instance()
	{

		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * Perform some compatibility checks to make sure basic requirements are meet.
	 * If all compatibility checks pass, initialize the functionality.
	 *
	 * @since 1.0.1
	 * @access public
	 */
	public function __construct()
	{
			// Register Widget
		add_action('elementor/widgets/register', [$this, 'register_widgets']);
		
	}

	
	/**
	 * Register Widgets
	 *
	 * Load widgets files and register new Elementor widgets.
	 *
	 * Fired by `elementor/widgets/register` action hook.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets($widgets_manager)
	{

		foreach (glob(NEZA_ELE_DIR . "/widgets/*.php") as $filename) {
			require_once $filename;
		}

	
		$widgets_manager->register(new NezaYouChannelGrid());

	}
}
NEZA_Elementor::instance();
