<?php

/**

 * @wordpress_plugin
 * Plugin Name:       Anomaly_manager
 * Plugin URI:        http://igl711_a15_51_ja.espaceweb.usherbrooke.ca/
 * Description:       Anomaly manager
 * Version:           1.0.0
 * Author:            Anomaly_manager
 * Author URI:        http://igl711_a15_51_ja.espaceweb.usherbrooke.ca/
 * License:           GPL_2.0+
 * License URI:       http://www.gnu.org/licenses/gpl_2.0.txt
 * Text Domain:       Anomaly_manager
 * Domain Path:       /languages
 */

 define( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-vulnfinder-activator.php
 */
function activate_anomaly_manager() {
	require_once plugin_dir_path( __FILE__ ) . '/includes/class-anomaly-manager-activator.php';
	anomaly_manager_activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-vulnfinder-deactivator.php
 */
function deactivate_anomaly_manager() {
	require_once plugin_dir_path( __FILE__ ) . '/includes/class-anomaly-manager-deactivator.php';
	anomaly_manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_anomaly_manager' );
register_deactivation_hook( __FILE__, 'deactivate_anomaly_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin_specific hooks, and public_facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-anomaly-manager.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_anomaly_manager() {

	$plugin = new anomaly_manager();
	$plugin->run();

}
run_anomaly_manager();
