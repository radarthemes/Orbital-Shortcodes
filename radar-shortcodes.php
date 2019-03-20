<?php
/**
 * Radar Shortcodes
 *
 * @link              https://radarthemes.com
 * @since             1.0.0
 * @package           RTS
 *
 * @radar-shortcodes
 * Plugin Name:       Radar Shortcodes
 * Plugin URI:        https://radarthemes.com/wordpress-plugins/radar-shortcodes/
 * Description:       A lightweight shortcodes plugin for WordPress.
 * Version:           1.0.0
 * Author:            Radar Themes
 * Author URI:        https://radarthemes.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       radar-shortcodes
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 */
define( 'RADAR_SHORTCODES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-radar-shortcodes-activator.php
 */
function activate_plugin_name() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-radar-shortcodes-activator.php';
    RTS_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-radar-shortcodes-deactivator.php
 */
function deactivate_plugin_name() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-radar-shortcodes-deactivator.php';
    Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-radar-shortcodes.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_radar_shortcodes() {
    $plugin = new RTS_Shortcodes();
    $plugin->run();
}

run_radar_shortcodes();
