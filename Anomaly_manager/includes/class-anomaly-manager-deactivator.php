<?php

/**
 * Fired during plugin deactivation
 *
 * @since      1.0.0
 *
 * @package    wp_vulnfinder
 * @subpackage wp_vulnfinder/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    wp_vulnfinder
 * @subpackage wp_vulnfinder/includes
 */
class anomaly_manager_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;
		
		$wpdb->query("DROP TABLE IF EXISTS Anomaly;");
	}

}
