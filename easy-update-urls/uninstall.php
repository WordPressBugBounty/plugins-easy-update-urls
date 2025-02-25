<?php
/**
 * @author William Sergio Minossi
 * @copyright 2016 - 2024
 */
// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}


$plugin_name = 'bill-catch-errors.php'; // Name of the plugin file to be removed

// Retrieve all must-use plugins
$wp_mu_plugins = get_mu_plugins();

// MU-Plugins directory
$mu_plugins_dir = WPMU_PLUGIN_DIR;

if (isset($wp_mu_plugins[$plugin_name])) {
    // Get the plugin's destination path
    $destination = $mu_plugins_dir . '/' . $plugin_name;

    // Attempt to remove the plugin
    if (!unlink($destination)) {
        // Log the error if the file could not be deleted
        error_log("Error removing the plugin file from the MU-Plugins directory: $destination");
    } else {
        // Optionally, log success if the plugin is removed successfully
        // error_log("Successfully removed the plugin file: $destination");
    }
}
global $wpdb;
$table = $wpdb->prefix . 'bill_catch_some_bots';
$wpdb->query("DROP TABLE IF EXISTS $table");
?>
