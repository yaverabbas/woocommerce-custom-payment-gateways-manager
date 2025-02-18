<?php

declare(strict_types=1);

namespace WooCustomPaymentGatewaysManager\Admin;

if (!defined('ABSPATH')) {
    exit;
}

class PaymentGatewaysManager
{
    /**
     * Option key for storing custom payment gateways.
     *
     * @var string
     */
    private string $optionKey = 'wc_custom_payment_gateways';

    /**
     * Initialize admin hooks.
     *
     * @return void
     */
    public function init(): void
    {
        add_action('admin_menu', [$this, 'addAdminMenu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminAssets']);
        add_action('admin_post_save_custom_payment_gateways', [$this, 'saveCustomPaymentGateways']);
    }

    /**
     * Add the plugin menu page.
     *
     * @return void
     */
    public function addAdminMenu(): void
    {
        add_menu_page(
            __('Custom Payment Gateways', 'woo-custom-payment-gateways-manager'),
            __('Payment Gateways', 'woo-custom-payment-gateways-manager'),
            'manage_options',
            'wc-custom-payment-gateways',
            [$this, 'adminPageCallback'],
            'dashicons-money-alt'
        );
    }

    /**
     * Enqueue admin scripts and styles.
     *
     * @param string $hook
     *
     * @return void
     */
    public function enqueueAdminAssets(string $hook): void
    {
        if ($hook !== 'toplevel_page_wc-custom-payment-gateways') {
            return;
        }
        wp_enqueue_script(
            'wc-cpgm-admin-js',
            WC_CUSTOM_PAYMENT_GATEWAYS_MANAGER_URL . 'assets/js/admin.js',
            ['jquery'],
            '1.0.0',
            true
        );
        wp_enqueue_style(
            'wc-cpgm-admin-css',
            WC_CUSTOM_PAYMENT_GATEWAYS_MANAGER_URL . 'assets/css/admin.css',
            [],
            '1.0.0'
        );
    }

    /**
     * Render the admin page.
     *
     * @return void
     */
    public function adminPageCallback(): void
    {
        // Load saved gateways.
        $savedGateways = get_option($this->optionKey, []);
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('WooCommerce Custom Payment Gateways Manager', 'woo-custom-payment-gateways-manager'); ?></h1>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <?php wp_nonce_field('save_custom_payment_gateways', 'wc_cpgm_nonce'); ?>
                <input type="hidden" name="action" value="save_custom_payment_gateways">
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                    <tr>
                        <th><?php esc_html_e('Enable', 'woo-custom-payment-gateways-manager'); ?></th>
                        <th><?php esc_html_e('Payment Method Name', 'woo-custom-payment-gateways-manager'); ?></th>
                        <th><?php esc_html_e('Payment Method Details', 'woo-custom-payment-gateways-manager'); ?></th>
                        <th><?php esc_html_e('Add Row', 'woo-custom-payment-gateways-manager'); ?></th>
                    </tr>
                    </thead>
                    <tbody id="wc-cpgm-rows">
                    <?php
                    if (!empty($savedGateways) && is_array($savedGateways)) :
                        foreach ($savedGateways as $index => $gateway) :
                            ?>
                            <tr class="wc-cpgm-row">
                                <td>
                                    <input type="checkbox" name="gateways[<?php echo esc_attr($index); ?>][enabled]" value="yes" <?php checked($gateway['enabled'], 'yes'); ?>>
                                </td>
                                <td>
                                    <input type="text" name="gateways[<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($gateway['name']); ?>" required>
                                </td>
                                <td>
                                    <textarea name="gateways[<?php echo esc_attr($index); ?>][description]" rows="3" required><?php echo esc_textarea($gateway['description']); ?></textarea>
                                </td>
                                <td>
                                    <button type="button" class="button wc-cpgm-add-row">+</button>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                    else :
                        // Default empty row.
                        ?>
                        <tr class="wc-cpgm-row">
                            <td>
                                <input type="checkbox" name="gateways[0][enabled]" value="yes">
                            </td>
                            <td>
                                <input type="text" name="gateways[0][name]" value="" required>
                            </td>
                            <td>
                                <textarea name="gateways[0][description]" rows="3" required></textarea>
                            </td>
                            <td>
                                <button type="button" class="button wc-cpgm-add-row">+</button>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
                <?php submit_button(__('Save Payment Gateways', 'woo-custom-payment-gateways-manager')); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Save the custom payment gateways.
     *
     * @return void
     */
    public function saveCustomPaymentGateways(): void
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.', 'woo-custom-payment-gateways-manager'));
        }

        check_admin_referer('save_custom_payment_gateways', 'wc_cpgm_nonce');

        $gateways = isset($_POST['gateways']) ? (array) $_POST['gateways'] : [];
        $sanitizedGateways = [];

        foreach ($gateways as $gateway) {
            $sanitizedGateways[] = [
                'enabled'     => isset($gateway['enabled']) && $gateway['enabled'] === 'yes' ? 'yes' : 'no',
                'name'        => sanitize_text_field($gateway['name']),
                'description' => sanitize_textarea_field($gateway['description']),
            ];
        }

        update_option($this->optionKey, $sanitizedGateways);

        wp_redirect(admin_url('admin.php?page=wc-custom-payment-gateways&updated=true'));
        exit;
    }
}
