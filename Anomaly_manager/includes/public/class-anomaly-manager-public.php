<?php

/**
 * The public-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    anomaly_manager
 * @subpackage anomaly_manager/public
 */

/**
 * The public-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-specific stylesheet and JavaScript.
 *
 * @package    anomaly_manager
 * @subpackage anomaly_manager/public
 */
class anomaly_manager_public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( include __DIR__ . '/partials/css/anomaly_manager_public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( include __DIR__ . '/partials/js/anomaly_manager-public.js', array( 'jquery' ), $this->version, false );

	}
	
	public function anomaly_manager_page() {
		include __DIR__ . '/partials/anomaly_manager-public-display.php';
	}
	
}
