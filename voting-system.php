<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/skshami
 * @since             1.0.0
 * @package           Voting_System
 *
 * @wordpress-plugin
 * Plugin Name:       Voting Sytem
 * Plugin URI:        https://github.com/skshami/voting-system
 * Description:       Allows users to vote only once from their IP address and device
 * Version:           1.0.0
 * Author:            Shamim Khan
 * Author URI:        https://github.com/skshami
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       voting-system
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'VOTING_SYSTEM_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-voting-system-activator.php
 */
function activate_voting_system() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-voting-system-activator.php';
	Voting_System_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-voting-system-deactivator.php
 */
function deactivate_voting_system() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-voting-system-deactivator.php';
	Voting_System_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_voting_system' );
register_deactivation_hook( __FILE__, 'deactivate_voting_system' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-voting-system.php';
require plugin_dir_path( __FILE__ ) . 'includes/user-voting.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_voting_system() {

	$plugin = new Voting_System();
	$plugin->run();

}
run_voting_system();
