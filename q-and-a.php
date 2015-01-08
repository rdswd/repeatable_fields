<?php
/**
 * The plugin bootstrap file
 *
 * This file is responsible for starting the plugin using the main plugin
 * class file.
 *
 * @link              
 * @since             1.0.0
 * @package           RDS_Q_and_A
 *
 * @wordpress-plugin
 * Plugin Name:       RDS Questions and Answers
 * Plugin URI:        http://rdswebdesign.com
 * Description:       Provides a repeatable field on pages to facilitate a FAQ or Q and A
 * Version:           0.1.0
 * Author:            Ryan Santschi
 * Author URI:        http://rdswebdesign.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rds-q-and-a
 */
 
/**
 * If this file is called directly, abort.
 */
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * The class that represents the meta box that will dispaly the navigation tabs and each of the
 * fields for the meta box.
 */
require_once plugin_dir_path( __FILE__ ) . 'admin/class-q-and-a-meta-box.php';

/**
 * The core plugin class that is used to define the meta boxes, their tabs,
 * the views, and the partial content for each of the tabs.
 */
require_once plugin_dir_path( __FILE__ ) . 'admin/class-q-and-a.php';


/**
 * Begins execution of the plugin.
 *
 * Everything for this particular plugin will be done so from within the
 * q-and-a/admin subpackage. This means that there is no reason to setup
 * any hooks until we're in the context of the Q_and_A_Admin class.
 *
 * @since    0.1.0
 */
function run_q_and_a() {

    $q_and_a = new Q_and_A_Admin( 'q-and-a', '0.1.0' );
    $q_and_a->initialize_hooks();
	
}
run_q_and_a();