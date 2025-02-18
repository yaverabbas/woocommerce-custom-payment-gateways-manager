<?php
/**
 * Plugin Name: WooCommerce Custom Payment Gateways Manager
 * Plugin URI:  https://github.com/yaverabbas
 * Description: Manage custom manual payment gateways for WooCommerce. This plugin allows you to create multiple payment methods with detailed instructions, enable or disable each method, and have them appear on the WooCommerce checkout page for manual processing.
 * Version:     1.0.0
 * Author:      Yaver Abbas
 * Author URI:  https://www.linkedin.com/in/yawarak/
 * Text Domain: woo-custom-payment-gateways-manager
 * Domain Path: /languages
 *
 * @package WooCustomPaymentGatewaysManager
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin directory and URL constants.
define('WC_CUSTOM_PAYMENT_GATEWAYS_MANAGER_DIR', plugin_dir_path(__FILE__));
define('WC_CUSTOM_PAYMENT_GATEWAYS_MANAGER_URL', plugin_dir_url(__FILE__));

/**
 * Autoloader for plugin classes.
 */
spl_autoload_register(
    function (string $class): void {
        if (strpos($class, 'WooCustomPaymentGatewaysManager') !== false) {
            $classPath = str_replace('WooCustomPaymentGatewaysManager\\', '', $class);
            $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $classPath);
            $file      = WC_CUSTOM_PAYMENT_GATEWAYS_MANAGER_DIR . 'src' . DIRECTORY_SEPARATOR . $classPath . '.php';
            if (file_exists($file)) {
                require_once $file;
            }
        }
    }
);

/**
 * Initialize the plugin.
 */
function run_woo_custom_payment_gateways_manager(): void {
    $plugin = new WooCustomPaymentGatewaysManager\Plugin();
    $plugin->run();
}

run_woo_custom_payment_gateways_manager();
