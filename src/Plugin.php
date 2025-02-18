<?php

declare(strict_types=1);

namespace WooCustomPaymentGatewaysManager;

if (!defined('ABSPATH')) {
    exit;
}

class Plugin
{
    /**
     * Plugin version.
     *
     * @var string
     */
    private string $version = '1.0.0';

    /**
     * Run the plugin.
     *
     * @return void
     */
    public function run(): void
    {
        $this->init_hooks();
    }

    /**
     * Initialize hooks.
     *
     * @return void
     */
    private function init_hooks(): void
    {
        // Load admin functionality if in admin area.
        if (is_admin()) {
            $admin = new Admin\PaymentGatewaysManager();
            $admin->init();
        }

        // Register custom payment gateways with WooCommerce.
        add_filter('woocommerce_payment_gateways', [$this, 'add_custom_payment_gateways']);
    }

    /**
     * Add custom payment gateways to WooCommerce.
     *
     * @param array $gateways
     *
     * @return array
     */
    public function add_custom_payment_gateways(array $gateways): array
    {
        $methods = get_option('wc_custom_payment_gateways', []);
        if (!empty($methods) && is_array($methods)) {
            foreach ($methods as $method) {
                if (isset($method['enabled']) && $method['enabled'] === 'yes') {
                    // Instantiate a new custom payment gateway with the saved method details.
                    $gateway   = new Frontend\CustomPaymentGateway($method);
                    $gateways[] = $gateway;
                }
            }
        }

        return $gateways;
    }
}
