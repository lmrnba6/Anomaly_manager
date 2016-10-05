<?php	

//Sécurité en cas d'accès direct
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    wp_vulnfinder
 * @subpackage wp_vulnfinder/includes
 */
class anomaly_manager_Activator {

	/**
	 * Contain everything needed to install the plugin
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	
	public function __construct() {

	}
	
	public static function activate() {
		self::activation_api();
		global $wpdb;
		
		$wpdb->query("DROP TABLE IF EXISTS Anomaly;");
		$wpdb->query("CREATE TABLE `Anomaly` (
  `id_anomaly` int(11) AUTO_INCREMENT PRIMARY KEY,
  `description_short` varchar(30)  NOT NULL,
  `description` varchar(255) NOT NULL,
  `version` varchar(50) NOT NULL,
  `status` varchar(255)  NOT NULL,
  `priority` int(11) NOT NULL,
  `comment` varchar(75)NOT NULL,
  `anomaly_name` varchar(125)NOT NULL
) ");
	}
	
	protected static function activation_api(){
		//Fin de la création des tables pour la BD
	}
}
