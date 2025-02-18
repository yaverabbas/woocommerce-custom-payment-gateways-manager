<?php

declare(strict_types=1);

namespace WooCustomPaymentGatewaysManager\Frontend;

if (!defined('ABSPATH')) {
    exit;
}

use WC_Payment_Gateway;

class CustomPaymentGateway extends WC_Payment_Gateway
{
    /**
     * Configuration for this payment method.
     *
     * @var array
     */
    protected array $methodConfig;

    /**
     * Constructor.
     *
     * @param array $methodConfig
     */
    public function __construct(array $methodConfig)
    {
        $this->methodConfig = $methodConfig;

        // Set a unique ID based on the method name.
        $this->id                = 'custom_' . sanitize_title($methodConfig['name']);
        $this->method_title      = $methodConfig['name'];
        $this->method_description = $methodConfig['description'] ?? '';
        $this->has_fields        = false;

        // Initialize gateway settings.
        $this->init_form_fields();
        $this->init_settings();

        // Allow title and description to be overridden via settings if needed.
        $this->title       = $this->get_option('title') ?: $this->method_title;
        $this->description = $this->get_option('description') ?: $this->method_description;

        add_action('woocommerce_receipt_' . $this->id, [$this, 'receiptPage']);
    }

    /**
     * Initialize form fields.
     *
     * @return void
     */
    public function init_form_fields(): void
    {
        // No additional fields required for this manual payment gateway.
        $this->form_fields = [];
    }

    /**
     * Process the payment.
     *
     * @param int $orderId
     *
     * @return array
     */
    public function process_payment($orderId): array
    {
        $order = wc_get_order($orderId);

        // Mark the order as on-hold with a note.
        $order->update_status(
            'on-hold',
            __('Awaiting manual payment – please contact the seller.', 'woo-custom-payment-gateways-manager')
        );

        // Reduce stock levels.
        wc_reduce_stock_levels($orderId);

        // Empty the cart.
        WC()->cart->empty_cart();

        return [
            'result'   => 'success',
            'redirect' => $this->get_return_url($order),
        ];
    }

    /**
     * Display the receipt page.
     *
     * @param int $orderId
     *
     * @return void
     */
    public function receiptPage($orderId): void
    {
        echo '<p>' . __('Thank you for your order. Please follow the instructions provided to complete your payment.', 'woo-custom-payment-gateways-manager') . '</p>';
    }
}
